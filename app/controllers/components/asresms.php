<?php
class AsresmsComponent extends Object 
{
	private $gateway_number;
	private $gateway_pass;
	
	function __construct(){
		$this->client = new SoapClient('http://www.novinpayamak.com/WebService/wsdl', array('encoding'=>'UTF-8'));
	}
	
	function SetVar($variable,$value){
		$this->{$variable} = $value;
	}
	
	function Send($data)
	{
		return $this->client->SendSMS(array('gateway_number' => $this->gateway_number, 'gateway_pass' => $this->gateway_pass), $data['cell'], urlencode($data['text']), $data['flash']);
	}
  
	function Check($data)
	{
		if($data['box'] == 'IN')
			return $sms_client->InboxCheck(array('gateway_number' => $this->gateway_number, 'gateway_pass' => $this->gateway_pass), 1, 30, 0);
		elseif($data['box'] == 'OUT')
			return $sms_client->OutboxCheck(array('gateway_number' => $this->gateway_number, 'gateway_pass' => $this->gateway_pass), 1, 30);
	}
	
	function GetInfo(){
		return $this->client->CreditCheck(array('gateway_number' => $this->gateway_number, 'gateway_pass' => $this->gateway_pass));
	}
}
?>