<?php
class WhoisComponent extends Object {
	var $whois_servers = array(
		".com" => array("whois.crsnic.net" ,"No match for"),
		".net" => array("whois.crsnic.net" ,"No match for"),
		".org" => array("whois.publicinterestregistry.net" ,"NOT FOUND"),
		".info" => array("whois.afilias.net" ,"NOT FOUND"),
		".biz" => array("whois.nic.biz" ,"Not found"),
		".us" => array("whois.nic.us" ,"Not found"),
		".de" => array("whois.nic.de" ,"free"),
		".eu" => array("whois.eu" ,"FREE"),
		".name" => array("whois.nic.name" ,"No match"),
		".asia" => array("whois.nic.asia" ,"NOT FOUND"),
		".bz" => array("whois.resellerclub.com" ,"Not found"),
		".cc" => array("whois.nic.cc" ,"No match"),
		".tel" => array("whois.nic.tel" ,"Not found"),
		".tv" => array("tvwhois.verisign-grs.com" ,"No match"),
		".mobi" => array("whois.dotmobiregistry.net" ,"NOT FOUND"),
		".ws" => array("whois.nic.ws" ,"No match for"),
		".me" => array("whois.nic.me" ,"No match for"),
		".in" => array("whois.inregistry.net" ,"NOT FOUND"),
		".co" => array("whois.nic.co", "Not found"),
		".ir" => array("whois.nic.ir" ,"no entries found"),
		".co.ir" => array("whois.nic.ir" ,"no entries found"),
		".id.ir" => array("whois.nic.ir" ,"no entries found"),
		".sch.ir" => array("whois.nic.ir" ,"no entries found"),
		".gov.ir" => array("whois.nic.ir" ,"no entries found"),
		".ac.ir" => array("whois.nic.ir" ,"no entries found"),
		".org.ir" => array("whois.nic.ir" ,"no entries found"),
		".net.ir" => array("whois.nic.ir", "no entries found")

	);

  function lookupdomain ($sld, $ext)
  {
	$server = $this -> whois_servers[$ext];
    if (!isset($server))
    {
      $result['result'] = 'error';
    }
    else
    {
      $domain = $sld . $ext;
      if (substr ($server[1], 0, 12) == 'HTTPREQUEST-')
      {
        $ch = curl_init ();
        $url = $server[0] . $domain;
        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 0);
        curl_setopt ($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec ($ch);
        curl_close ($ch);
        $data2 = ' ---' . $data;
        if (strpos ($data2, substr ($server[1], 12)) == true)
        {
          $result['result'] = 'available';
        }
        else
        {
          $result['result'] = 'unavailable';
	  if(strpos($ext,'ir')){
		$start = strpos($data, '<pre>');
		$end = strpos($data, '</pre>');
		$result['whois'] = substr($data, $start+5, $end-$start-6);
	  }else $result['whois'] = nl2br (strip_tags ($data));

        }
      }
      else
      {
        $fp = @fsockopen ($server[0], 43, $errno, $errstr, 10);
        if ($fp)
        {
          @fputs ($fp, $domain . '
');
          @socket_set_timeout ($fp, 10);
		  $data ='';
          while (!@feof ($fp))
          {
			$data .= @fread ($fp, 4096);
          }

		  @fclose ($fp);
		  $data2 = ' ---' . $data;
          if (strpos ($data2, $server[1]) == true)
          {
			$result['result'] = 'available';
          }
          else
          {
			$result['result'] = 'unavailable';
			$result['whois'] = nl2br ($data);
          }
        }
        else
        {
		  $result['result'] = 'error';
        }
      }

    }

    return $result;
  }

  function getwhoisservers ()
  {
    $whoisservers = file_get_contents('whoisservers.php');
    $whoisservers = explode ("\n", $whoisservers);
    foreach ($whoisservers as $value)
    {
      $value = explode ('|', $value);
      $whoisserver[trim (strip_tags ($value[0]))] = trim (strip_tags ($value[1]));
    }

    return $whoisserver;
  }

  function getwhoisservervars ()
  {
    $whoisservers = file_get_contents('whoisservers.php');
    $whoisservers = explode ("\n", $whoisservers);
    foreach ($whoisservers as $value)
    {
      $value = explode ('|', $value);
      $whoisvalue[trim (strip_tags ($value[0]))] = trim (strip_tags ($value[2]));
    }

    return $whoisvalue;
  }
}
?>