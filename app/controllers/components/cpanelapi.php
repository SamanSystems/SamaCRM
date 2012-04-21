<?php
App::Import('Vendor','cpanel/xmlapi');


class CpanelapiComponent extends Object 
{
	private $username = '';
	private $password = '';
	private $ip = '';
	private $host_user = '';
	private $host_pass = '';
	private $plan_name = '';
	
	function CpanelapiComponent ()
	{
		$this->xmlapi = new xmlapi($this->ip);
	}
	
	function SetVar ($variable,$value)
	{
		$this->{$variable} = $value;
	}
	
	function Create ($domain)
	{
		$this->xmlapi->password_auth($this->username,$this->password);
		
		$username = str_replace(array('.', '-'), '', $domain['domain']);
		$this->host_user = substr($username, 0, 8);

		$this->xmlapi->set_debug(1);
		if(empty($this->host_pass)) 
			$this->host_pass = substr(md5(rand(1001,9999).time()), 0, 8);
		
		$acct = array('username' => $this->host_user, 'password' => $this->host_pass, 'domain' => $domain['domain'], 'contactemail' => $domain['email'], 'plan' => $this->plan_name);
		$result = $this->xmlapi->createacct($acct);
		if($result['result']['status']==1) return 'success';
		else return 'error';
	}
	
	function ExtraFields(){
		return array('Api.host_pass' => '');
	}
	
	function Renew($domain){
		return 'success';
	}
	
	function GetInfo(){
		return '{کد}Username: '.$this->host_user. '<br />'. 'Password: '.$this->host_pass. '<br />{/کد}' ;
	}
	
  
}

?>