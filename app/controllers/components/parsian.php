<?php

class ParsianComponent extends Object 
{
	private $site;
	private $amount;
	private $user_id;
	private $pin;
	private $callBackUrl = '/users/verify_online/Parsian';
	
	function ParsianComponent(){
		$this->client = new SoapClient('https://www.pec24.com/pecpaymentgateway/eshopservice.asmx?wsdl', array('encoding' => 'UTF-8'));
	}
	
	function SetVar($variable,$value){
		$this->{$variable} = $value;
	}
	
	function Execute ($data)
	{
	    $this->amount = intval($data['amount']);
		$this->callBackUrl = $this->site . $this->callBackUrl;
		
		$this->Onlinetransaction = ClassRegistry::init('Onlinetran');
		
		$this->data['Onlinetran']['amount'] = $this->amount;
		$this->amount = $this->amount*10;
		$this->data['Onlinetran']['status'] = 0;
		$this->data['Onlinetran']['user_id'] = $data['user_id'];
		
		$this->Onlinetransaction->create();
		$this->Onlinetransaction->save($this->data);
		unset($this->data);
		
		$params = array(
					'pin' => $this->pin,
					'amount' => $this->amount,
					'orderId' => $this->Onlinetransaction->id,
					'callbackUrl' => $this->callBackUrl,
					'authority' => 0,
					'status' => 1
				  );
		$res = $this->client->PinPaymentRequest($params);
		
		
		$this->data['Onlinetran']['au'] = $res->authority;
		$this->Onlinetransaction->save($this->data);
		
		if ( !empty($res->authority) && $res->status == 0 )
		 return array('address' => 'https://www.pec24.com/pecpaymentgateway/?au=' .$res->authority);
	}
  
	function Verify($data)
	{
		$this->Onlinetransaction = ClassRegistry::init('Onlinetran');
		$transaction = $this->Onlinetransaction->find('first', array('conditions' => array('au' => $data['au'])));
		$params = array(
						'pin' => $this->pin,  
						'authority' => $data['au'],
						'status' => 1
						); 
		
		$res = $this->client->PinPaymentEnquiry($params);

		if($res->status == 0 && $transaction['Onlinetran']['status_id'] == 0)
		{
			$this->Onlinetransaction->id = $transaction['Onlinetran']['id'];
			$this->data['Onlinetran']['status'] = 1;
			$this->Onlinetransaction->save($this->data);
			unset($this->data);
			$this->Transaction = ClassRegistry::init('Transaction');
			
			$this->Transaction->create();
			
			$this->data['Transaction']['desc'] = 'شماره ارجاع: '. $data['au'];
			$this->data['Transaction']['date'] = time();
			$this->data['Transaction']['payment_id'] = $this->payment_id;
			$this->data['Transaction']['confirmed'] = 1;
			$this->data['Transaction']['amount'] = $transaction['Onlinetran']['amount'];
			$this->data['Transaction']['user_id'] = $transaction['Onlinetran']['user_id'];
			$this->Transaction->save($this->data);
			return $this->data;
		} else {
			if(!empty($transaction)){
				$this->Onlinetransaction->id = $transaction['Onlinetran']['id'];
				$this->data['Onlinetran']['status_id'] = -1;
				$this->Onlinetransaction->save($this->data);
			}
		    return false;
		}
	}
}
?>