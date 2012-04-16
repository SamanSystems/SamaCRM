<?php
App::import('Core', 'HttpSocket');
class DirectiapiComponent extends Object 
{
	private $user_id = '';
	private $username = '';
	private $pass = '';
	private $ns1 = '';
	private $ns2 = '';
	private $contact_id = 0;
	private $customer_id = 0;
	private $domain_ns1 = 'ns1.asrenet.com';
	private $domain_ns2 = 'ns2.asrenet.com';
	private $webservice_url = '';
	
	function SetVar ($variable,$value)
	{
		$this->{$variable} = $value;
	}
	
	function CheckDomain($domain){
	
		$HttpSocket = new HttpSocket();
		$results = $HttpSocket->post($this->webservice_url.'api/domains/available.json?auth-userid=343464&auth-password=pc1370021021&domain-name=vahiddavari&tlds=com');
		return $results;
	}
	
	function Create($domain){
		if(!empty($this->domain_ns1) && !empty($this->domain_ns2)){
			$this->ns1 = $this->domain_ns1;
			$this->ns2 = $this->domain_ns2;
		}
		$HttpSocket = new HttpSocket();
		//echo $HttpSocket->post('https://test.httpapi.com/api/contacts/add.json?auth-userid=343464&auth-password=pc1370021021&name=mostafa amiri&company=saman systems&email=info@samansystems.com&address-line-1=No. 61, 20th St., Yousefabad, Tehran&city=Tehran&country=IR&zipcode=14319&phone-cc=98&phone=2188012882&customer-id=7192578&type=Contact');
		$results = $HttpSocket->post($this->webservice_url.'api/domains/register.json?auth-userid='. $this->user_id .'&auth-password='. $this->pass .'&domain-name='. $domain['domain'] .'&years='. $domain['duration']/12 .'&ns='. $this->ns1 .'&ns='. $this->ns2 .'&customer-id='. $this->customer_id .'&reg-contact-id='. $this->contact_id .'&admin-contact-id='. $this->contact_id .'&tech-contact-id='. $this->contact_id .'&billing-contact-id='. $this->contact_id .'&invoice-option=NoInvoice&protect-privacy=true');
		$results = json_decode($results, true);
		$status = strtolower($results['status']);
		
		if($status != 'success'){
			$this->Message = $results['error'];
		}
		
		return $status;
	}
	
	function Renew($domain){
		if(!empty($this->domain_ns1) && !empty($this->domain_ns2)){
			$this->ns1 = $this->domain_ns1;
			$this->ns2 = $this->domain_ns2;
		}
		
		$HttpSocket = new HttpSocket();
		$OrderId = $HttpSocket->get($this->webservice_url.'api/api/domains/search.json?auth-userid='. $this->user_id .'&auth-password='. $this->pass .'&no-of-records=10&page-no=1&domain-name='. $domain['domain'] .'&status=Active');
		$OrderId  = json_decode($OrderId, true);
		$results = $HttpSocket->post($this->webservice_url.'api/api/domains/renew.json?auth-userid='. $this->user_id .'&auth-password='. $this->pass .'&order-id='.$OrderId[1]['orders.orderid'].'&years='. $domain['duration']/12 .'&exp-date='.$OrderId[1]['orders.endtime'].'&invoice-option=NoInvoice');
		$results = json_decode($results, true);
		$status = strtolower($results['status']);
		
		if($status != 'success'){
			$this->Message = $results['error'];
		}
		
		return $status;
	}
	
	function ExtraFields(){
		$fields = array('Api.domain_ns1' => $this->domain_ns1, 'Api.domain_ns2' => $this->domain_ns2);
		return $fields;
	}
	
	function GetInfo(){
		return '{کد}DNS1: '.$this->ns1. '<br />'. 'DNS2: '.$this->ns2. '<br />{/کد}' ;
	}
}
?>