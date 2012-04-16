<?php
	include_once("nusoap.php");
	include_once("config.php");
		
	$debug = true;
	function debugfunction($serviceObj)
	{
		global $debug;
		echo 'here';
		if($debug)
		{
			print "<b>Debug Mode is True:</b></br></br>";
			print "<b>XML Sent:</b><br><br>";
			print "<xmp>" . $serviceObj->request . "</xmp>";
			print "<br><b>XML Received:</b><br><br>";
			print "<xmp>" . $serviceObj->response . "</xmp>";
			print "<br>";
		}
		else
		{
			print "<b>Debug Mode is False:</b></br></br>";
		}

	}
	function getArrayFromString($strValue)
	{
		$tok = strtok($strValue, ",");
		$arrValue= array();
		while ($tok)
		{
			$arrValue[]=$tok;
			$tok = strtok(",");
		}
		return $arrValue;
	}
	function getVectorFromStringOld($strValue)
	{
		$tok = strtok($strValue, "#");
		$arrValue= array();
		while ($tok)
		{
			$arrValue[]=$tok;
			$tok = strtok("#");
		}
		return $arrValue;
	}

	function getVectorFromString($strValue)
	{
		return $strValue;
	}

	function getHashFromStringOld($strValue)
	{
		$tok = strtok($strValue, "#");
		while ($tok)
		{
			$p=strrpos($tok,"->");
			$hashValue[substr($tok,0,$p)]=substr($tok,$p+2); ;
			$tok = strtok("#");
		}
		return $hashValue;
	}

	function getHashFromStringDelimiter($strValue,$delimiter)
	{
		foreach($strValue as $key=>$value)
        {
			$p=strrpos($value,$delimiter);
			$valueDetails = substr($value,$p+2);
            $hashValue[substr($value,0,$p)]=$valueDetails;
        }
		return $hashValue;
	}

	function getHashFromString($strValue)
	{
		foreach($strValue as $key=>$value)
        {
			$p=strpos($value,"->");
			$valueDetails = substr($value,$p+2);
			if(count(split(',',$valueDetails)) > 1)
			{
//				print "Got More Values<BR>";
				$tok=strtok($valueDetails, ",");
				$innerarry=array() ;
				while ($tok)
				{
//					print "Got Inner Values ".$tok."<BR>";
					$innerp=strpos($tok,"=");
					$innerarrykey=trim(substr($tok,0,$innerp));
					$innerarrvalue=trim(substr($tok,$innerp+1));
					$innerarray[$innerarrykey]=trim($innerarrvalue);
					$tok = strtok(",");
				}
				$valueDetails = $innerarray;
//				print "<BR>Check the Ultimate Array<BR>";
//				print_r ($innerarray);
			}
			else
			{
				$valueDetails = substr($value,$p+2);
			}
            $hashValue[substr($value,0,$p)]=$valueDetails;
        }
//		print "<BR>Check the Ultimate Hash<BR>";
//		print_r ($innerHash);
		return $hashValue;
	}

	function processResponse($returnValue)
	{
		$response = new Response($returnValue);
		print "<b>Output:</b><br><br>";
		if($response->isError())
		{
			$errorObj = $response->getErrorObj();
			$errorObj->printError();
		}
		else
		{
			$result = $response->getResult();
			$response->printData($result);
		}
	}
?>