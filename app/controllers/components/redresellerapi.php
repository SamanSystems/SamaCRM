<?php
class RedresellerapiComponent extends Object 
{
	private $user_id = '';
	private $username = '';
	private $pass = '';
	private $ns1 = '';
	private $ns2 = '';
	private $domain_ns1 = '';
	private $domain_ns2 = '';
	
	function SetVar ($variable,$value)
	{
		$this->{$variable} = $value;
	}
	
	function Create ($domain)
	{
		//ini_set("soap.wsdl_cache_enabled", "0");, 'trace' => 1
		$this->client = new SoapClient('http://www.redreseller.com/WebService/wsdl', array('encoding'=>'UTF-8'));
		
		if(!empty($this->domain_ns1) && !empty($this->domain_ns2)){
			$this->ns1 = $this->domain_ns1;
			$this->ns2 = $this->domain_ns2;
		}
		
		$res = $this->client->PayDomain(array('webservice_id' => $this->username, 'webservice_pass' => $this->pass ), $domain['domain'], $this->nic_handle, $domain['duration'], array('ns1' => $this->ns1, 'ns2' => $this->ns2));
		
		if($res==1000)
			return 'success';
		else{
			$this->Message = 'کد خطا: '. $res;
			return 'failed';
		}
	}
	
	function ExtraFields(){
		$fields = array('Api.nic_handle' => $this->nic_handle, 'Api.domain_ns1' => $this->domain_ns1, 'Api.domain_ns2' => $this->domain_ns2);
		return $fields;
	}
	
	function Renew($domain){
		return 'renew';
	}
	
	function GetInfo(){
		return '{کد}DNS1: '.$this->ns1. '<br />'. 'DNS2: '.$this->ns2. '<br />{/کد}' ;
	}
  
}
?>