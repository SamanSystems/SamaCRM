<?php
App::Import('Vendor','nusoap/directi');
class DirectiapiComponent extends Object 
{
	private $username = '';
	private $pass = '';
	private $role     = "reseller";
	private $lang = 'en';
	private $parentid = "0";
	private $customerid = "0";
	private $ns1 = '';
	private $ns2 = '';
	private $domain_ns1 = '';
	private $domain_ns2 = '';
	
	function DirectiapiComponent ()
	{
		$this->client = new soapclient_nusoap("../controllers/components/wsdl/DomContact.wsdl","wsdl");
	}
	
	function SetVar ($variable,$value)
	{
		$this->{$variable} = $value;
	}
	
	function Create ($domain)
	{

		$contact = $this->client->call("addDefaultContact",array($this->username, $this->pass, $this->role, $this->lang, $this->parentid, $this->customerid));

		$domainhash = array($domain['domain'] => $domain['duration']/12);
		$contacthash=array('registrantcontactid'=>$contact,'admincontactid'=>$contact,'technicalcontactid'=>$contact,'billingcontactid'=>$contact);
		if(!empty($this->domain_ns1) && !empty($this->domain_ns2)){
			$this->ns1 = $this->domain_ns1;
			$this->ns2 = $this->domain_ns2;
		}

			$temp['domainhash']=$domainhash;
			$temp['contacthash']=$contacthash;
			$addParamList[] = $temp;
			$nameServersList = array($this->ns1,$this->ns2);
			$invoiceOption = 'PayInvoice'; //or it can be PayInvoice, KeepInvoice, OnlyAdd
			$enablePrivacyProtection = true; // or true
			$validate = false; // or false;
			$extraInfo = array(); //send extra info if required
			
			$this->domain = new soapclient_nusoap("../controllers/components/wsdl/DomOrder.wsdl","wsdl");
			
			$returnValue = $this->domain->call("registerDomain",array($this->username, $this->pass, $this->role, $this->lang, $this->parentid, $addParamList, $nameServersList, $this->customerid, $invoiceOption, $enablePrivacyProtection, $validate, $extraInfo));
			foreach ($returnValue as $ret) return strtolower($ret['status']);
	}
	
	function ExtraFields(){
		$fields = array('Api.domain_ns1' => $this->domain_ns1 , 'Api.domain_ns2' => $this->domain_ns2);
		return $fields;
	}
	
	function Renew($domain){
		$contact = $this->client->call("addDefaultContact",array($this->username, $this->pass, $this->role, $this->lang, $this->parentid, $this->customerid));

		$domainhash = array($domain['domain'] => $domain['duration']/12);
		$contacthash=array('registrantcontactid'=>$contact,'admincontactid'=>$contact,'technicalcontactid'=>$contact,'billingcontactid'=>$contact);

		$invoiceOption = 'PayInvoice'; //or it can be PayInvoice, KeepInvoice, OnlyAdd

		$validate = false; // or false;
			
		$this->domain = new soapclient_nusoap("../controllers/components/wsdl/DomOrder.wsdl","wsdl");
			
		$returnValue = $this->domain->call("renewDomain",array($this->username, $this->pass, $this->role, $this->lang, $this->parentid, $domainhash, $invoiceOption));
		foreach ($returnValue as $ret) return strtolower($ret['status']);
	}
	
	function GetInfo(){
		return '{کد}DNS1: '.$this->ns1. '<br />'. 'DNS2: '.$this->ns2. '<br />{/کد}' ;
	}
  
}
?>