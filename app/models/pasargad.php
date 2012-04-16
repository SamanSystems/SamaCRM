<?php
App::Import('Vendor','pep/processor');
class PasargadComponent extends Object 
{
	var $site;
	var $amount;
	var $user_id;
	private $merchantCode = 211996;
        private $terminalCode = 212261;
	
	function PasargadComponent(){
		$this->site = 'http://www.asrenet.com';
		$this->callBackUrl = $this->site."/users/verify_online/pasargad";
                $this->Onlinetransaction = ClassRegistry::init('Onlinetran');
                $this->processor = new RSAProcessor("../controllers/components/wsdl/certificate.xml",RSAKeyType::XMLFile);
	}
	
	function SetVar($variable,$value){
		$this->{$variable} = $value;
	}
	
	function Execute ($data)
	{
		$this->amount = $data['amount'];
                $this->data['Onlinetran']['amount'] = $this->amount;
                $this->data['Onlinetran']['status'] = 0;
                $this->Onlinetransaction->create();
                $this->Onlinetransaction->save($this->data);
                echo $this->Onlinetransaction->id;
		$invoiceNumber = $this->Onlinetransaction->id; 
		$timeStamp = date("Y/m/d H:i:s");
		$invoiceDate = date("Y/m/d H:i:s",time()-2);
		$action = "1003";
		$data = "#". $this->merchantCode ."#". $this->terminalCode ."#". $invoiceNumber ."#". $invoiceDate ."#". $this->amount ."#". $this->callBackUrl ."#". $action ."#". $timeStamp ."#";
		$data = sha1($data,true);
		$data = $this->processor->sign($data);
		$result = base64_encode($data); // base64_encode
		$return['address'] = 'https://epayment.bankpasargad.com/gateway.aspx';
		$return['params']['invoiceNumber'] = $invoiceNumber;
		$return['params']['invoiceDate'] = $invoiceDate;
		$return['params']['amount'] = $this->amount;
		$return['params']['terminalCode'] = $this->terminalCode;
		$return['params']['merchantCode'] = $this->merchantCode;
		$return['params']['redirectAddress'] = $this->callBackUrl;
		$return['params']['timeStamp'] = $timeStamp;
		$return['params']['action'] = $action;
		$return['params']['sign'] = $result;
		return $return;
	}
  
	function Verify()
	{
		$params = array(
					'pin' =>$this->pin,  
					'authority' => $this->authority,
					'status' => 1 ) ; 
		$sendParams = array($params) ;
		$res = $this->client->call('PinPaymentEnquiry', $sendParams);
		$status = $res['status'];
		if($status == 0)
		{
			return true;
		}else{
			return false;
		}
		
		
		
	}
}
?>