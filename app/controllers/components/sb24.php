<?php
class Sb24Component extends Object 
{
	var $site = '';
	var $amount;
	private $merchant_code = '';
	private $payment_id = '';
	private $percent = 0;
	private $callBackUrl = '/users/verify_online/Sb24';
	
	function Sb24Component(){
        $this->Onlinetransaction = ClassRegistry::init('Onlinetran');
	}
	
	function SetVar($variable,$value){
		$this->{$variable} = $value;
	}
	
	function Execute ($data)
	{
		$this->callBackUrl = $this->site . $this->callBackUrl;
		
		$this->amount = $data['amount'];
		$this->data['Onlinetran']['amount'] = $this->amount;
		$this->data['Onlinetran']['status'] = 0;
		$this->data['Onlinetran']['user_id'] = $data['user_id'];
		$this->Onlinetransaction->create();
		$this->Onlinetransaction->save($this->data);
		$this->amount = $this->amount*10;
			
			if(!empty($this->percent)){
				$this->amount *= ($this->percent+100)/100;
			}

		$return['address'] = 'https://acquirer.sb24.com/CardServices/controller';
		$return['params']['MID'] = $this->merchant_code;
		$return['params']['TableBorderColor'] = '488DCC';
		$return['params']['TableBGColor'] = '488DCC';
		$return['params']['PageBGColor'] = 'B6CBEA';
		$return['params']['PageBorderColor'] = '6C788B';
		$return['params']['TitleFont'] = 'Tahoma';
		$return['params']['TitleColor'] = '000000';
		$return['params']['TitleSize'] = '5';
		$return['params']['TextFont'] = 'Tahoma';
		$return['params']['TextColor'] = '000000';
		$return['params']['TextSize'] = '2';
		$return['params']['TypeTextFont'] = 'Tahoma';
		$return['params']['TypeTextColor'] = '000000';
		$return['params']['TypeTextSize'] = '2';
		$return['params']['LogoURL'] = $this->site.'/img/logo.gif';
		$return['params']['Amount'] = $this->amount;
		$return['params']['RedirectURL'] = $this->callBackUrl;
		$return['params']['ResNum'] = $this->Onlinetransaction->id;	
		
		return $return;
	}
  
	function Verify($data)
	{
		if(!empty($_POST['RefNum'])){
			$verifier = new SoapClient('https://Acquirer.sb24.com/ref-payment/ws/ReferencePayment?WSDL', array('encoding' => 'UTF-8'));
			$transaction = $this->Onlinetransaction->find('first', array('conditions' => array('Onlinetran.id' => $_POST['ResNum'])));
			$res = $verifier->VerifyTransaction($_POST['RefNum'], $this->merchant_code);
			$amount = $transaction['Onlinetran']['amount'] * 10;
			
			if(!empty($this->percent)){
				$amount *= ($this->percent+100)/100;
			}
			
			if($transaction['Onlinetran']['status'] == 0 && $res == $amount){
				$this->data['Onlinetran']['status'] = 1;
				$this->data['Onlinetran']['au'] = $_POST['RefNum'];
				$this->Onlinetransaction->save($this->data);
				unset($this->data);
				$this->Transaction = ClassRegistry::init('Transaction');
				$this->Transaction->create();
				$this->data['Transaction']['desc'] = 'شماره ارجاع: '. $_POST['RefNum'];
				$this->data['Transaction']['date'] = time();
				$this->data['Transaction']['payment_id'] = $this->payment_id;
				$this->data['Transaction']['confirmed'] = 1;
				$this->data['Transaction']['amount'] = $transaction['Onlinetran']['amount'];
				$this->data['Transaction']['user_id'] = $transaction['Onlinetran']['user_id'];
				$this->Transaction->save($this->data);
				return $this->data;
			} else {
				$this->data['Onlinetran']['status'] = -1;
				$this->Onlinetransaction->save($this->data);
				return false;
			}
		}
	}
}
?>