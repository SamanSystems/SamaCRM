<?php
class Error
{
	var $errorCode;
	var $errorClass;
	var $errorMsg;
	var $errorLevel;
	var $error;
	
	function Error($errorCode, $errorClass, $errorMsg, $errorLevel)
	{
		$this->errorCode = $errorCode;
		$this->errorClass = $errorClass;

		if(isset($errorMsg))
		{
			$dataArr = array();
			$errorArr = array();
			$this->errorMsg = $errorMsg;
//			print "The Error Msg is ".$errorMsg."<br />";
//			$errorMsg = substr($errorMsg,1,strlen($errorMsg)-2);
//			print "Now The Error Msg is ".$errorMsg."\n";

//			$errorArr = split(",",$errorMsg);
			//while($pos = strpos($errorMsg,",",$start))
//			foreach($errorArr as $keyValue)
//			{
				//$keyvalue = substr($errorMsg,$start,$pos-$start);
//				print "The KeyValue is ".$keyValue."\n";

//				$dataArr = split("=",$keyValue);
//				print "The DataArr is ";print_r($dataArr);print "\n";
//				if(isset($dataArr[1])) 
//					$this->errorMsg[$dataArr[0]] = $dataArr[1];
//			}

		}
		else
		{
			print "Setting Nothing to ErroMsg";
		}
		
		$this->errorLevel = $errorLevel;
		$this->error = true;
	}


	function getErrorValue($key)
	{
		return $this->$errorMsg[$key];
	}

	function printErrorValues()
	{
//		print "<table border=4>";
		print "<tr><td><b>Error Description:</b></td><td><br>" . $this->errorMsg . "<br></td></tr>";
/*
		foreach($this->errorMsg as $key=>$value) 
	    {
			print "<tr><td>".$key."</td>"; 
			print "<td>".$value."</td></tr>"; 
		}
*/
//		print "</table>";
	}

	function printError()
	{
		if($this->error)
		{
                 print" <TABLE id=\"tblParams\" style=\"FONT-SIZE: 11px; FONT-FAMILY: Verdana\" cellSpacing=\"1\" cellPadding=\"1\" width=\"100%\" border=\"1\">";
			print "<tr><td><b>Error Code:</b></td><td><br>" . $this->errorCode . "<br></td></tr>";
			print "<tr><td><b>Error Class:</b></td><td><br>" . $this->errorClass. "<br></td></tr>";
		/*	
			print "<tr><td><b>Error Description:</b></td><td><br>" . $this->errorMsg . "<br></td></tr>";
		*/
			print "<tr><td>";
			$this->printErrorValues();
			print "</td></tr>";
			print "<tr><td><b>Error Level:</b><br></td><td>" . $this->errorLevel . "<br></td></tr>";
                 print"</TABLE>";
		}
		else
		{
			print "<b>No Error:</b> Call printData(\$dataToPrint) to print Result<br><br>";
		}
	}
}
?>

