<?php
	include_once("nusoap.php");
	include_once("apiutil.php");

	class DotCoopContact
	{
		var $serviceObj;
		var $wsdlFileName;
		function DotCoopContact($wsdlFileName="wsdl/DotCoopContact.wsdl")
		{
			$this->wsdlFileName = $wsdlFileName;
			$this->serviceObj = new soapclient_nusoap($this->wsdlFileName,"wsdl");
		}
		function addSponsor(
			$SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $name, $company, $emailAddr, $address1, $address2, $address3, $city, $state, $country, $zip, $telNoCc, $telNo, $faxNoCc, $faxNo, $customerId)
		{
			$return = $this->serviceObj->call("addSponsor",array($SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $name, $company, $emailAddr, $address1, $address2, $address3, $city, $state, $country, $zip, $telNoCc, $telNo, $faxNoCc, $faxNo, $customerId));
			debugfunction($this->serviceObj);
			return $return;
		}
		function getSponsorsList(
			$SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $customerId, $registrantContactId)
		{
			$return = $this->serviceObj->call("getSponsorsList",array($SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $customerId, $registrantContactId));
			debugfunction($this->serviceObj);
			return $return;
		}
		function addCoopContact(
			$SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $name, $company, $emailAddr, $address1, $address2, $address3, $city, $state, $country, $zip, $telNoCc, $telNo, $faxNoCc, $faxNo, $customerId)
		{
			$return = $this->serviceObj->call("addCoopContact",array($SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $name, $company, $emailAddr, $address1, $address2, $address3, $city, $state, $country, $zip, $telNoCc, $telNo, $faxNoCc, $faxNo, $customerId));
			debugfunction($this->serviceObj);
			return $return;
		}
	}
?>