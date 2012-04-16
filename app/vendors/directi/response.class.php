<?php
include("error.class.php");
/**
* This class is basically used to get formatted o/p.
*/

class Response
{
	/**
	* Holds an Error code.
	*
	* @access public
	* @var string
	*/
	var $errorCode;
	
	/**
	* Holds an Class which throws Error.
	*
	* @access public
	* @var string
	*/
	var $errorClass;
	
	/**
	* Holds an Error Description.
	*
	* @access public
	* @var string
	*/
	var $errorMsg;
	
	/**
	* Holds an Error Level.
	*
	* @access public
	* @var string
	*/
	var $errorLevel;
	
	/**
	* @access private
	*/
	var $seperator = "#~#";    // seperator used in Error string.

	/**
	* @access private
	*/
	var $data;	// Holds data.

	/**
	* @access private
	*/
	var $error = false;	//Holds error string.

	var $errorObj;

	/**
	* The constructor which takes data to be analysed as a parameter.
	*
	* @param string data to be analysed
	*
	*/
/*        function Response($value,$extra)
        {
          $this->data = $value;
        }   
*/	
	function Response($value)
	{
		$this->data = $value;
		if(is_array($this->data))
		{                        
			$this->errorAnalyse();
		}
	}

	/**
	* @access private
	*
	*/
	// This function analyse the data for error. 
	// If data consists of Error string it fills the variables $errorCode,$errorClass,$errorMsg $errorLevel and $error.

	function errorAnalyse()
	{
		foreach($this->data as $key => $value)
		{
			if (is_string($key) and $key == "faultstring")
			{
				$error = array();
				$counter = 1;
				$start = 0;
				
				while($pos = strpos($value,$this->seperator,$start))
				{
					$error[$counter] = substr($value,$start,$pos-$start);
					$start = $pos+strlen($this->seperator);
					$counter = $counter+1;
				}
				$this->errorCode = $error[1];
				$this->errorClass = $error[2];
				$this->errorMsg = $error[3];
				$this->errorLevel = $error[4];
				$this->error = true;
				$this->errorObj = new Error($this->errorCode, $this->errorClass, $this->errorMsg, 		$this->errorLevel);
			}
		}
	}

	function getErrorObj()
	{
		return $this->errorObj;
	}
	/**
	* This function returns true/false depending upon whether data is an error string or not.
	*
	* @return boolean
	*
	*/
	function isError()
	{
		return $this->error;
	}

	/**
	* This function returns the data if no error occured . 
	*
	* @return Any
	*
	*/
	function getResult()
	{
		if(!$this->error)
		{
			return $this->data;
		}
		else
		{
			return "<b>Error Occured</b>.<br><br> Access Member Variables of the Response class for Error Description<br>";
		}
	}

	/**
	* This fuction print the Error in proper format.
	*
	* @return void
	*
	*/
	function printError()
	{
		if($this->error)
		{
                 print" <TABLE id=\"tblParams\" style=\"FONT-SIZE: 11px; FONT-FAMILY: Verdana\" cellSpacing=\"1\" cellPadding=\"1\" width=\"100%\" border=\"1\">";
			print "<tr><td><b>Error Code:</b></td><td><br>" . $this->errorCode . "<br></td></tr>";
			print "<tr><td><b>Error Class:</b></td><td><br>" . $this->errorClass. "<br></td></tr>";
			print "<tr><td><b>Error Description:</b></td><td><br>" . $this->errorMsg . "<br></td></tr>";
			print "<tr><td><b>Error Level:</b><br></td><td>" . $this->errorLevel . "<br></td></tr>";
                 print"</TABLE>";
		}
		else
		{
			print "<b>No Error:</b> Call printData(\$dataToPrint) to print Result<br><br>";
		}
	}
	
	/**
	* This fuction print the passed data in proper format.
	*
	* @return void
	* @param string Data to print.
	*
	*/

	function printData($dataToPrint)
	{
		if(!$this->error)
		{
		 print" <TABLE id=\"tblParams\" style=\"FONT-SIZE: 11px; FONT-FAMILY: Verdana\" cellSpacing=\"1\" cellPadding=\"1\" width=\"100%\" border=\"1\">";
            if(is_array($dataToPrint))
			{
				foreach($dataToPrint as $key => $value)
				{									
					if(is_array($value))
					{                                       
						print "<tr><td>$key </td><td>";
	                    $this->printData($value);
	                    print"</td></tr>"; 
					}
					else
					{
                        if(is_string($key))
                           {
                             if(empty($value))
                               {
                                $value="&nbsp;";
                               } 
     						  print "<tr><td>$key</td><td>$value</td></tr>";
                           }
                         else
                           {
                             print "<tr><td>$key</td><td>$value</td></tr>";
                           }
					}
				}                          
			}
			else
			{
                               
				print "<tr><td>$dataToPrint</td><td></td></tr>";  
			}
                      print"</TABLE>";

		}
		else
		{
			print "<b>Error Occured:</b> Call printError() to print Error<br><br>";
		}
	}


    function PrintCustomerData($dataToPrint)
	{
		?>
		<form name="Form1" method="post" action="../examples/CustomerClient.php" id="Form1">
			<TABLE id="tblParams" style="FONT-SIZE: 11px; FONT-FAMILY: Verdana" cellSpacing="1" cellPadding="1"
				width="100%" border="1">
				<TR>
					<TD colSpan="2">Customer Details</TD>
				</TR>
				<TR>
					<TD style="WIDTH: 197px; HEIGHT: 26px">Customer ID</TD>
					<TD><?php echo $dataToPrint['customerid']?></TD>
					<input name="txtCustomerID" value="<?php echo $dataToPrint['customerid']?>"type="hidden"/>
				</TR>
				<TR>
					<TD style="WIDTH: 197px; HEIGHT: 26px">User Name</TD>
					<TD><input name="txtUsername" value="<?php echo $dataToPrint['username']?>"type="text" id="txtUsername" /></TD>
				</TR>
				<TR>
					<TD style="WIDTH: 197px">Name</TD>
					<TD>
						<P><input name="txtName" value="<?php echo $dataToPrint['name']?>" type="text" id="txtName" /></P>
					</TD>
				</TR>
				<TR>
					<TD style="WIDTH: 197px; HEIGHT: 28px">Company</TD>
					<TD style="HEIGHT: 28px">
						<P><input name="txtCompany" value="<?php echo $dataToPrint['company']?>" type="text" id="txtCompany" /></P>
					</TD>
				</TR>
				<TR>
					<TD style="WIDTH: 197px">Language Preference</TD>
					<TD>
						<P><input name="txtLangPref" value="<?php echo $dataToPrint['langpref']?>" type="text" id="txtLangPref" /></P>
					</TD>
				</TR>
				<TR>
					<TD style="WIDTH: 197px; HEIGHT: 29px">Adderss1</TD>
					<TD style="HEIGHT: 29px">
						<P><input name="txtAddress1" value="<?php echo $dataToPrint['address1']?>" type="text" id="txtAddress1" /></P>
					</TD>
				</TR>
				<TR>
					<TD style="WIDTH: 197px; HEIGHT: 28px">Address2</TD>
					<TD style="HEIGHT: 28px">
						<P><input name="txtAddress2" value="<?php echo $dataToPrint['address2']?>" type="text" id="txtAddress2" /></P>
					</TD>
				</TR>
				<TR>
					<TD style="WIDTH: 197px">Address3</TD>
					<TD><input name="txtAddress3" value="<?php echo $dataToPrint['address3']?>" type="text" id="txtAddress3" /></TD>
				</TR>
				<TR>
					<TD style="WIDTH: 197px">City</TD>
					<TD><input name="txtCity" value="<?php echo $dataToPrint['city']?>" type="text" id="txtCity" /></TD>
				</TR>
				<TR>
					<TD style="WIDTH: 197px; HEIGHT: 28px">State</TD>
					<TD><input name="txtState" value="<?php echo $dataToPrint['state']?>" type="text" id="txtState" /></TD>
				</TR>
				<TR>
					<TD style="WIDTH: 197px">Country</TD>
					<TD><input name="txtCountry" value="<?php echo $dataToPrint['country']?>" type="text" id="txtCountry" /></TD>
				</TR>
				<TR>
					<TD style="WIDTH: 197px">Zip</TD>
					<TD><input name="txtZip" value="<?php echo $dataToPrint['zip']?>" type="text" id="txtZip" /></TD>
				</TR>
				<TR>
					<TD style="WIDTH: 197px">TelNo. Country code.</TD>
					<TD><input name="txtTelCc" value="<?php echo $dataToPrint['telnocc']?>" type="text" id="txtTelCc" /></TD>
				</TR>
				<TR>
					<TD style="WIDTH: 197px">TelNo.</TD>
					<TD><input name="txtTelNo" value="<?php echo $dataToPrint['telno']?>" type="text" id="txtTelNo" /></TD>
				</TR>
				<TR>
					<TD style="WIDTH: 197px">Alternate TelNo.Country code</TD>
					<TD><input name="txtAltTelCc" value="<?php echo $dataToPrint['alttelnocc']?>" type="text" id="txtAltTelCc" /></TD>
				</TR>
				<TR>
					<TD style="WIDTH: 197px">Alternate &nbsp;TelNo.</TD>
					<TD><input name="txtAltTelNo" value="<?php echo $dataToPrint['alttelno']?>" type="text" id="txtAltTelNo" /></TD>
				</TR>
				<TR>
					<TD style="WIDTH: 197px">FaxNo. Country code</TD>
					<TD><input name="txtFaxCc" value="<?php echo $dataToPrint['faxnocc']?>" type="text" id="txtFaxCc" /></TD>
				</TR>
				<TR>
					<TD style="WIDTH: 197px">FaxNo.</TD>
					<TD><input name="txtFaxNo" value="<?php echo $dataToPrint['faxno']?>" type="text" id="txtFaxNo" /></TD>
				</TR>
				<TR>
					<TD align="center" colSpan="2"><input type="submit" name="btnModDetails" value="ModDetails" id="btnModDetails" /></TD>
							<input type="hidden" name="submitbtn" value="ModDetails2">
				</TR>
			</TABLE>
		</form>
		<?
	}

 function printData2($dataToPrint)
        {
                if(!$this->error)
                {
                 print"<form name=\"Form1\" method=\"post\" action=\"../examples/CustomerClient.php\" id=\"Form1\">"; 

                 print" <TABLE id=\"tblParams\" style=\"FONT-SIZE: 11px; FONT-FAMILY: Verdana\" cellSpacing=\"1\" cellPadding=\"1\" width=\"100%\" border=\"1\">";
                if(is_array($dataToPrint))
                        {
                         foreach($dataToPrint as $key => $value)
                                {
                                  if($key=="customerid")
                                     {
                                        print"<TR><TD><input type=\"hidden\" name=\"txtCustomerID\" value =\"$value\"></TD></TR>";
                                        print "<TR><TD style=\"WIDTH: 197px; HEIGHT: 29px\">$key</TD><TD style=\"HEIGHT: 29px\"><P>$value</P></TD></TR>";
                                     } 
                                }
                                foreach($dataToPrint as $key => $value)
                                {
                                        if(is_array($value))
                                        {
                                       /*    print" <TABLE id=\"tblParams\" style=\"FONT-SIZE: 11px; FONT-FAMILY: Verdana\" cellSpacing=\"1\" cellPadding=\"1\"
                                        width=\"100%\" border=\"1\">";*/
                                        print "<tr><td>$key </td><td>";
                                        $this->printData2($value);
                                        print"</td></tr>";
                                        }
           
                                        else
                                        {
                                                if(is_string($key))
                                                   {
                                                     if(empty($value))
                                                       {
                                                        $value="&nbsp;";
                                                       }
                                         //            print "<tr><td>$key</td><td>$value</td></tr>";
                                        if($key=="password"||$key=="totalreceipts"||$key=="creationdt"||$key=="customerstatus"||$key=="resellerid"||$key=="customerid")
                                           {
                                             continue;
                                           }
                                        print "<TR><TD style=\"WIDTH: 197px; HEIGHT: 29px\">$key</TD><TD style=\"HEIGHT: 29px\"><P><input name=\"txt$key\" type=\"text\" id=\"txt$key\" value=\"$value\"/></P></TD></TR>";

                                                   }
                                                 else
                                                   {
                                                     print "<tr><td>$value</td></tr>";
                                                   }
                                        }
                                }
                      /*     print"</TABLE>";  */

                        }
                        else
                        {
                                print "<tr><td>$dataToPrint</td><td></td></tr>";
                        }
                      print"<TR><TD align=\"center\" colSpan=\"2\"><input type=\"submit\" name=\"submit\" value=\"ModDetails2\" id=\"btnModDetails2\" /></TD><input type=\"hidden\" name=\"submitbtn\" value=\"ModDetails2\" /></TR>";

					  
              print"</TABLE></form>";

                }
                else
                {
                        print "<b>Error Occured:</b> Call printError() to print Error<br><br>";
                }
        }

function printData3($dataToPrint)
        {
                if(!$this->error)
                {
                 print"<form name=\"Form1\" method=\"post\" action=\"http://image.local.webhosting.info/api/examples/domcontactclient.php\" id=\"Form1\">";
                 print" <TABLE id=\"tblParams\" style=\"FONT-SIZE: 11px; FONT-FAMILY: Verdana\" cellSpacing=\"1\" cellPadding=\"1\" width=\"100%\" border=\"1\">";
                if(is_array($dataToPrint))
                        {
                                foreach($dataToPrint as $key => $value)
                                {
                                  if($key=="contactid")
                                     {
                                        print"<TR><TD><input type=\"hidden\" name=\"txtContactID\" value =\"$value\"></TD></TR>";

                                        print "<TR><TD style=\"WIDTH: 197px; HEIGHT: 29px\">$key</TD><TD style=\"HEIGHT: 29px\"><P>$value</P></TD></TR>";
                                     }
                                }
                                foreach($dataToPrint as $key => $value)
                                {
                                        if(is_array($value))
                                        {
                                       /*    print" <TABLE id=\"tblParams\" style=\"FONT-SIZE: 11px; FONT-FAMILY: Verdana\" cellSpacing=\"1\" cellPadding=\"1\"
                                        width=\"100%\" border=\"1\">";*/
                                        if($key=="contacttype")
                                          continue;
                                        print "<tr><td>$key </td><td>";
                                        $this->printData3($value);
                                        print"</td></tr>";
                                        }

                                 else
                                        {
                                                if(is_string($key))
                                                   {
                                                     if(empty($value))
                                                       {
                                                        $value="&nbsp;";
                                                       }
                                         //            print "<tr><td>$key</td><td>$value</td></tr>";
                                        if($key=="password"||$key=="totalreceipts"||$key=="creationdt"||$key=="customerstatus"||$key=="resellerid"||$key=="contactid"||$key=="eaqid"||$key=="classname"||$key=="parentkey"||$key=="actioncompleted"||$key=="customerid"||$key=="classkey"||$key=="entitytypeid"||$key=="currentstatus"||$key=="contacttype"||$key=="description"||$key=="entityid")
                                           {
                                             continue;
                                           }
                                        print "<TR><TD style=\"WIDTH: 197px; HEIGHT: 29px\">$key</TD><TD style=\"HEIGHT: 29px\"><P><input name=\"txt$key\" type=\"text\" id=\"txt$key\" value=\"$value\"/></P></TD></TR>";

                                                   }
                                                 else
                                                   {
                                                     print "<tr><td>$value</td></tr>";
                                                   }
                                        }
                                }
                      /*     print"</TABLE>";  */

                        }
                        else
                        {

                                print "<tr><td>$dataToPrint</td><td></td></tr>";
                        }
                      print"<TR><TD align=\"center\" colSpan=\"2\"><input type=\"submit\" name=\"submitbtn\" value=\"ModDetails2\" id=\"btnModDetails\" /></TD></TR>";
              print"</TABLE>";

                }
                else
                {
                        print "<b>Error Occured:</b> Call printError() to print Error<br><br>";
                }
        }
}
?>
