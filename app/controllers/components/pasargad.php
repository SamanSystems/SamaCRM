<?php
App::Import('Vendor','pep/processor');
class PasargadComponent extends Object 
{
	var $site;
	var $amount;
	var $user_id;
	private $merchantCode = '';
	private $terminalCode = '';
	
	function PasargadComponent(){
		$this->site = 'http://www.asrenet.com';
		$this->callBackUrl = $this->site."/users/verify_online/Pasargad";
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
			$this->amount = $this->amount*10;
			$this->data['Onlinetran']['status'] = 0;
			$this->data['Onlinetran']['user_id'] = $data['user_id'];
			$this->Onlinetransaction->create();
			$this->Onlinetransaction->save($this->data);
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
  
	function Verify($data)
	{
            $this->verifier = new Verifier();
            $result = $this->verifier->post2https($data['tref'],'https://epayment.bankpasargad.com/CheckTransactionResult.aspx');
            $res = $this->verifier->makeXMLTree($result);
            $this->Onlinetransaction->id = $res['resultObj']['invoiceNumber'];
            $transaction = $this->Onlinetransaction->read();
            if($res['resultObj']['result']=='True'){
                if($transaction['Onlinetran']['status']==0){
                    $this->data['Onlinetran']['status'] = 1;
                    $this->Onlinetransaction->save($this->data);
                    unset($this->data);
                    $this->Transaction = ClassRegistry::init('Transaction');
		    
		    $this->Payment = ClassRegistry::init('Payment');
		    $payment = $this->Payment->find('first',array('conditions' => array('Payment.merchant' => 'Pasargad') ,'fields' => array('Payment.id')));
		    
                    $this->Transaction->create();
                    $this->data['Transaction']['desc'] = 'شماره ارجاع: '.$res['resultObj']['referenceNumber'];
                    $this->data['Transaction']['date'] = time();
                    $this->data['Transaction']['payment_id'] = $payment['Payment']['id'];
                    $this->data['Transaction']['confirmed'] = 1;
                    $this->data['Transaction']['amount'] = $transaction['Onlinetran']['amount'];
                    $this->data['Transaction']['user_id'] = $transaction['Onlinetran']['user_id'];
                    $this->Transaction->save($this->data);
                    return $this->data;
                }
            } else{
                $this->data['Onlinetran']['status'] = -1;
                $this->Onlinetransaction->save($this->data);
                return false;
            }
	}
}
?>