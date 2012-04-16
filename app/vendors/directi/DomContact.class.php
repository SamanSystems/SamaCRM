<?php
	include_once("nusoap.php");
	include_once("apiutil.php");

	class DomContact
	{
		var $serviceObj;
		var $wsdlFileName;
		function DomContact($wsdlFileName="/home/asrenet/public_html/app/vendors/directi/wsdl/DomContact.wsdl")
		{
			$this->wsdlFileName = $wsdlFileName;
			//echo file_get_contents("/home/asrenet/public_html/app/vendors/directi/wsdl/DomContact.wsdl");
			$this->serviceObj = new soapclient_nusoap($this->wsdlFileName,"wsdl");
		}
		function listByType(
			$SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $customerId, $contactId, $currentStatus, $creationDTRangStart, $creationDTRangEnd, $contactName, $companyName, $emailAddr, $numOfRecordPerPage, $pageNum, $orderBy, $type, $requirements)
		{
			$return = $this->serviceObj->call("listByType",array($SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $customerId, $contactId, $currentStatus, $creationDTRangStart, $creationDTRangEnd, $contactName, $companyName, $emailAddr, $numOfRecordPerPage, $pageNum, $orderBy, $type, $requirements));
			debugfunction($this->serviceObj);
			return $return;
		}
		function listNames(
			$SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $customerId)
		{
			$return = $this->serviceObj->call("listNames",array($SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $customerId));
			debugfunction($this->serviceObj);
			return $return;
		}
		function listNamesByContactTypes(
			$SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $customerId, $type)
		{
			$return = $this->serviceObj->call("listNamesByContactTypes",array($SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $customerId, $type));
			debugfunction($this->serviceObj);
			return $return;
		}
		function getDetails(
			$SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $contactId, $option)
		{
			$return = $this->serviceObj->call("getDetails",array($SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $contactId, $option));
			debugfunction($this->serviceObj);
			return $return;
		}
		function addDefaultContact(
			$SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $customerId)
		{
			$return = $this->serviceObj->call("addDefaultContact",array($SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $customerId));
			debugfunction($this->serviceObj);
			return $return;
		}
		function addDefaultContacts(
			$SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $customerId, $types)
		{
			$return = $this->serviceObj->call("addDefaultContacts",array($SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $customerId, $types));
			debugfunction($this->serviceObj);
			return $return;
		}
		function addContact(
			$SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $name, $company, $emailAddr, $address1, $address2, $address3, $city, $state, $country, $zip, $telNoCc, $telNo, $faxNoCc, $faxNo, $customerId, $type, $extraInfo)
		{
			$return = $this->serviceObj->call("addContact",array($SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $name, $company, $emailAddr, $address1, $address2, $address3, $city, $state, $country, $zip, $telNoCc, $telNo, $faxNoCc, $faxNo, $customerId, $type, $extraInfo));
			debugfunction($this->serviceObj);
			return $return;
		}
		function getDefaultContacts(
			$SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $customerId, $types)
		{
			$return = $this->serviceObj->call("getDefaultContacts",array($SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $customerId, $types));
			debugfunction($this->serviceObj);
			return $return;
		}
		function add(
			$SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $name, $company, $emailAddr, $address1, $address2, $address3, $city, $state, $country, $zip, $telNoCc, $telNo, $faxNoCc, $faxNo, $customerId)
		{
			$return = $this->serviceObj->call("add",array($SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $name, $company, $emailAddr, $address1, $address2, $address3, $city, $state, $country, $zip, $telNoCc, $telNo, $faxNoCc, $faxNo, $customerId));
			debugfunction($this->serviceObj);
			return $return;
		}
		function listOrder(
			$SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $customerId, $contactId, $currentStatus, $creationDTRangStart, $creationDTRangEnd, $contactName, $companyName, $emailAddr, $numOfRecordPerPage, $pageNum, $orderBy)
		{
			$return = $this->serviceObj->call("list",array($SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $customerId, $contactId, $currentStatus, $creationDTRangStart, $creationDTRangEnd, $contactName, $companyName, $emailAddr, $numOfRecordPerPage, $pageNum, $orderBy));
			debugfunction($this->serviceObj);
			return $return;
		}
		function delete(
			$SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $contactId)
		{
			$return = $this->serviceObj->call("delete",array($SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $contactId));
			debugfunction($this->serviceObj);
			return $return;
		}
		function mod(
			$SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $contactId, $name, $company, $emailAddr, $address1, $address2, $address3, $city, $state, $country, $zip, $telNoCc, $telNo, $faxNoCc, $faxNo)
		{
			$return = $this->serviceObj->call("mod",array($SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $contactId, $name, $company, $emailAddr, $address1, $address2, $address3, $city, $state, $country, $zip, $telNoCc, $telNo, $faxNoCc, $faxNo));
			debugfunction($this->serviceObj);
			return $return;
		}
	}
?>