<?php
class ZarinpalComponent extends Object 
{
	private $site;
	private $amount;
	private $user_id;
	private $pin = '';
	
	function ZarinpalComponent(){
		$this->client = new SoapClient('http://www.zarinpal.com/WebserviceGateway/wsdl', array('encoding' => 'UTF-8'));
		$this->callBackUrl = "/users/verify_online/Zarinpal";
		$this->site = "http://www.asrenet.com";
		$this->Onlinetransaction = ClassRegistry::init('Onlinetran');
	}
	
	function SetVar($variable,$value){
		$this->{$variable} = $value;
	}
	
	function Execute ($data)
	{
		$amount = intval($data['amount']);
		$this->callBackUrl = $this->site.$this->callBackUrl;
		$this->data['Onlinetran']['status'] = 0;
		$this->data['Onlinetran']['user_id'] = $data['user_id'];
		$this->data['Onlinetran']['amount'] = $amount;
		$this->Onlinetransaction->create();
		$this->Onlinetransaction->save($this->data);

		$res = $this->client->PaymentRequest($this->pin, $amount, $this->callBackUrl, urlencode('افزايش اعتبار کاربر: '.$data['user'].' تراکنش شماره: '.$this->Onlinetransaction->id) );
		
		$this->data['Onlinetran']['au'] = $res;
		$this->Onlinetransaction->save($this->data);
		
		if ( !empty($res) )
		 return array('address' => "https://www.zarinpal.com/users/pay_invoice/" .$res);
	}
  
	function Verify($data)
	{
		$transaction = $this->Onlinetransaction->find('first', array('conditions' => array('au' => $data['au'])));
		$res = $this->client->PaymentVerification($this->pin, $data['au'] , $transaction['Onlinetran']['amount']);

		if($res == 1)
		{
			if($transaction['Onlinetran']['status']==0){
				$this->Onlinetransaction->id = $transaction['Onlinetran']['id'];
				$this->data['Onlinetran']['status'] = 1;
				$this->Onlinetransaction->save($this->data);
				unset($this->data);
				$this->Transaction = ClassRegistry::init('Transaction');
				
				$this->Payment = ClassRegistry::init('Payment');
				$payment = $this->Payment->find('first',array('conditions' => array('Payment.merchant' => 'Zarinpal') ,'fields' => array('Payment.id')));
				
				$this->Transaction->create();
				$this->data['Transaction']['desc'] = 'شماره ارجاع: '.$data['au'];
				$this->data['Transaction']['date'] = time();
				$this->data['Transaction']['payment_id'] = $payment['Payment']['id'];
				$this->data['Transaction']['confirmed'] = 1;
				$this->data['Transaction']['amount'] = $transaction['Onlinetran']['amount'];
				$this->data['Transaction']['user_id'] = $transaction['Onlinetran']['user_id'];
				$this->Transaction->save($this->data);
				return $this->data;
			}
			
		}else{
			$this->data['Onlinetran']['status'] = -1;
			$this->Onlinetransaction->save($this->data);
			return false;
		}
		
		
		
	}
}
?>