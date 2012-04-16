<?php
require_once("rsa.class.php");
class RSAProcessor
{
 private $public_key = null;
 private $private_key = null;
 private $modulus = null;
 private $key_length = "1024";
 public function __construct($xmlRsakey=null,$type=null)
 {
         $xmlObj = null;
   if($xmlRsakey==null)          {
           $xmlObj = simplexml_load_file("xmlfile/RSAKey.xml");
          }
          elseif($type==RSAKeyType::XMLFile)          {
           $xmlObj = simplexml_load_file($xmlRsakey);
          }
          else          {
           $xmlObj = simplexml_load_string($xmlRsakey);
          }
        $this->modulus = RSA::binary_to_number(base64_decode($xmlObj->Modulus));
		$this->public_key = RSA::binary_to_number(base64_decode($xmlObj->Exponent));
		$this->private_key = RSA::binary_to_number(base64_decode($xmlObj->D));
		$this->key_length = strlen(base64_decode($xmlObj->Modulus))*8;
 }
 public function getPublicKey() {
  return $this->public_key;
 }
 public function getPrivateKey() {
  return $this->private_key;
 }
 public function getKeyLength() {
  return $this->key_length;
 }
 public function getModulus() {
  return $this->modulus;
 }
 public function encrypt($data) {
  return base64_encode(RSA::rsa_encrypt($data,$this->public_key,$this->modulus,$this->key_length));
 }
  public function dencrypt($data) {
  return RSA::rsa_decrypt($data,$this->private_key,$this->modulus,$this->key_length);
 }
  public function sign($data) {
  return RSA::rsa_sign($data,$this->private_key,$this->modulus,$this->key_length);
 }
  public function verify($data) {
  return RSA::rsa_verify($data,$this->public_key,$this->modulus,$this->key_length);
 }
}
class RSAKeyType{
 const XMLFile = 0;
 const XMLString = 1;
}

class Verifier
{
 
/* ------------------------------------- XML PARSE ------------------------------------- */
public function makeXMLTree($data)
{
    $ret = array();
    $parser = xml_parser_create();
    xml_parser_set_option($parser,XML_OPTION_CASE_FOLDING,0);
    xml_parser_set_option($parser,XML_OPTION_SKIP_WHITE,1);
    xml_parse_into_struct($parser,$data,$values,$tags);
    xml_parser_free($parser);
    $hash_stack = array();
    foreach ($values as $key => $val)
    {
        switch ($val['type'])
        {
            case 'open':
                array_push($hash_stack, $val['tag']);
                break;
            case 'close':
                array_pop($hash_stack);
                break;
            case 'complete':
                array_push($hash_stack, $val['tag']);
                eval("\$ret[" . implode($hash_stack, "][") . "] = '{$val[value]}';");
                array_pop($hash_stack);
                break;
        }
    }
    return $ret;
}

/* ------------------------------------- CURL POST TO HTTPS --------------------------------- */
public function post2https($invoiceUID,$url)
{
    //set POST variables
    $fields = array (
    'invoiceUID'=>urlencode($invoiceUID),
    );
    //url-ify the data for the POST
    foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
    rtrim($fields_string,'&');
    //open connection
    $ch = curl_init();
    //set the url, number of POST vars, POST data
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_POST,count($fields));
    curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    //execute post
    $res = curl_exec($ch);
    //close connection
    curl_close($ch);
    return $res;
}

}