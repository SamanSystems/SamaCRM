<?php
	include_once("nusoap.php");
	include_once("apiutil.php");

	class DomOrder
	{
		var $serviceObj;
		var $wsdlFileName;
		function DomOrder($wsdlFileName="wsdl/DomOrder.wsdl")
		{
			$this->wsdlFileName = $wsdlFileName;
			$this->serviceObj = new soapclient_nusoap($this->wsdlFileName,"wsdl");
		}
		function getDetails(
			$SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $orderId, $option)
		{
			$return = $this->serviceObj->call("getDetails",array($SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $orderId, $option));
			debugfunction($this->serviceObj);
			return $return;
		}
		function checkAvailabilityMultiple(
			$SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $domainNames, $tlds, $suggestAlternative)
		{
			$return = $this->serviceObj->call("checkAvailabilityMultiple",array($SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $domainNames, $tlds, $suggestAlternative));
			debugfunction($this->serviceObj);
			return $return;
		}
		function transferDomain(
			$SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $domainHash, $registrantContactId, $adminContactId, $techContactId, $billingContactId, $customerId, $invoiceOption)
		{
			$return = $this->serviceObj->call("transferDomain",array($SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $domainHash, $registrantContactId, $adminContactId, $techContactId, $billingContactId, $customerId, $invoiceOption));
			debugfunction($this->serviceObj);
			return $return;
		}
		function addTransferDomain(
			$SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $addParamList, $nameServersList, $customerId, $invoiceOption, $enablePrivacyProtection, $validate, $extraInfo)
		{
			$return = $this->serviceObj->call("addTransferDomain",array($SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $addParamList, $nameServersList, $customerId, $invoiceOption, $enablePrivacyProtection, $validate, $extraInfo));
			debugfunction($this->serviceObj);
			return $return;
		}
		function registerDomain(
			$SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $addParamList, $nameServersList, $customerId, $invoiceOption, $enablePrivacyProtection, $validate, $extraInfo)
		{
			$return = $this->serviceObj->call("registerDomain",array($SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $addParamList, $nameServersList, $customerId, $invoiceOption, $enablePrivacyProtection, $validate, $extraInfo));
			debugfunction($this->serviceObj);
			return $return;
		}
		function renewDomain(
			$SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $domainHash, $invoiceOption)
		{
			$return = $this->serviceObj->call("renewDomain",array($SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $domainHash, $invoiceOption));
			debugfunction($this->serviceObj);
			return $return;
		}
		function bulkAdd(
			$SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $domains, $noOfYears, $ns, $registrantContactId, $adminContactId, $techContactId, $billingContactId, $customerId, $invoiceOption)
		{
			$return = $this->serviceObj->call("bulkAdd",array($SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $domains, $noOfYears, $ns, $registrantContactId, $adminContactId, $techContactId, $billingContactId, $customerId, $invoiceOption));
			debugfunction($this->serviceObj);
			return $return;
		}
		function bulkAddTransferDomain(
			$SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $domainHash, $registrantContactId, $adminContactId, $techContactId, $billingContactId, $customerId, $invoiceOption)
		{
			$return = $this->serviceObj->call("bulkAddTransferDomain",array($SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $domainHash, $registrantContactId, $adminContactId, $techContactId, $billingContactId, $customerId, $invoiceOption));
			debugfunction($this->serviceObj);
			return $return;
		}
		function bulkModifyByDomainName(
			$SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $domainNames, $ns, $registrantContactId, $adminContactId, $techContactId, $billingContactId)
		{
			$return = $this->serviceObj->call("bulkModifyByDomainName",array($SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $domainNames, $ns, $registrantContactId, $adminContactId, $techContactId, $billingContactId));
			debugfunction($this->serviceObj);
			return $return;
		}
		function bulkModifyByCustomerId(
			$SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $customerID, $resellerId, $domainNames, $ns, $registrantContactId, $adminContactId, $techContactId, $billingContactId)
		{
			$return = $this->serviceObj->call("bulkModifyByCustomerId",array($SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $customerID, $resellerId, $domainNames, $ns, $registrantContactId, $adminContactId, $techContactId, $billingContactId));
			debugfunction($this->serviceObj);
			return $return;
		}
		function addChildNameServer(
			$SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $orderId, $cns, $ipAddress)
		{
			$return = $this->serviceObj->call("addChildNameServer",array($SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $orderId, $cns, $ipAddress));
			debugfunction($this->serviceObj);
			return $return;
		}
		function deleteChildNameServerIp(
			$SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $orderId, $cns, $ipAddress)
		{
			$return = $this->serviceObj->call("deleteChildNameServerIp",array($SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $orderId, $cns, $ipAddress));
			debugfunction($this->serviceObj);
			return $return;
		}
		function del(
			$SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $orderId)
		{
			$return = $this->serviceObj->call("del",array($SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $orderId));
			debugfunction($this->serviceObj);
			return $return;
		}
		function modifyChildNameServerIp(
			$SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $orderId, $cns, $oldIp, $newIp)
		{
			$return = $this->serviceObj->call("modifyChildNameServerIp",array($SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $orderId, $cns, $oldIp, $newIp));
			debugfunction($this->serviceObj);
			return $return;
		}
		function modifyChildNameServerName(
			$SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $orderId, $oldCns, $newCns)
		{
			$return = $this->serviceObj->call("modifyChildNameServerName",array($SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $orderId, $oldCns, $newCns));
			debugfunction($this->serviceObj);
			return $return;
		}
		function modifyContact(
			$SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $orderId, $registrantContactId, $adminContactId, $techContactId, $billingContactId)
		{
			$return = $this->serviceObj->call("modifyContact",array($SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $orderId, $registrantContactId, $adminContactId, $techContactId, $billingContactId));
			debugfunction($this->serviceObj);
			return $return;
		}
		function modifyDomainSecret(
			$SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $orderId, $newSecret)
		{
			$return = $this->serviceObj->call("modifyDomainSecret",array($SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $orderId, $newSecret));
			debugfunction($this->serviceObj);
			return $return;
		}
		function modifyNameServer(
			$SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $orderId, $nsHash)
		{
			$return = $this->serviceObj->call("modifyNameServer",array($SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $orderId, $nsHash));
			debugfunction($this->serviceObj);
			return $return;
		}
		function namesuggestion(
			$SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $domainname, $hyphenAllowed, $numberAllowed, $domainNameLen, $noofResults, $arrTlds)
		{
			$return = $this->serviceObj->call("namesuggestion",array($SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $domainname, $hyphenAllowed, $numberAllowed, $domainNameLen, $noofResults, $arrTlds));
			debugfunction($this->serviceObj);
			return $return;
		}
		function isTransferRequestValid(
			$SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $domainName)
		{
			$return = $this->serviceObj->call("isTransferRequestValid",array($SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $domainName));
			debugfunction($this->serviceObj);
			return $return;
		}
		function checkNameServer(
			$SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $nameServer, $productKeys)
		{
			$return = $this->serviceObj->call("checkNameServer",array($SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $nameServer, $productKeys));
			debugfunction($this->serviceObj);
			return $return;
		}
		function validateDomainRegistrationParams(
			$SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $domainHash, $ns, $registrantContactId, $adminContactId, $techContactId, $billingContactId, $customerId, $invoiceOption)
		{
			$return = $this->serviceObj->call("validateDomainRegistrationParams",array($SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $domainHash, $ns, $registrantContactId, $adminContactId, $techContactId, $billingContactId, $customerId, $invoiceOption));
			debugfunction($this->serviceObj);
			return $return;
		}
		function validateDomainTransferParams(
			$SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $domainHash, $registrantContactId, $adminContactId, $techContactId, $billingContactId, $customerId, $invoiceOption)
		{
			$return = $this->serviceObj->call("validateDomainTransferParams",array($SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $domainHash, $registrantContactId, $adminContactId, $techContactId, $billingContactId, $customerId, $invoiceOption));
			debugfunction($this->serviceObj);
			return $return;
		}
		function addTransferDomainWithoutvalidation(
			$SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $domainHash, $registrantContactId, $adminContactId, $techContactId, $billingContactId, $customerId)
		{
			$return = $this->serviceObj->call("addTransferDomainWithoutvalidation",array($SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $domainHash, $registrantContactId, $adminContactId, $techContactId, $billingContactId, $customerId));
			debugfunction($this->serviceObj);
			return $return;
		}
		function addWithoutValidation(
			$SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $domainHash, $ns, $registrantContactId, $adminContactId, $techContactId, $billingContactId, $customerId, $invoiceOption)
		{
			$return = $this->serviceObj->call("addWithoutValidation",array($SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $domainHash, $ns, $registrantContactId, $adminContactId, $techContactId, $billingContactId, $customerId, $invoiceOption));
			debugfunction($this->serviceObj);
			return $return;
		}
		function getDetailsByDomain(
			$SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $domainName, $option)
		{
			$return = $this->serviceObj->call("getDetailsByDomain",array($SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $domainName, $option));
			debugfunction($this->serviceObj);
			return $return;
		}
		function getOrderIdByDomain(
			$SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $domainName, $productkey)
		{
			$return = $this->serviceObj->call("getOrderIdByDomain",array($SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $domainName, $productkey));
			debugfunction($this->serviceObj);
			return $return;
		}
		function changePrivacyProtectionStatus(
			$SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $lockerId, $orderID, $newIsPrivacyProtected, $reason)
		{
			$return = $this->serviceObj->call("changePrivacyProtectionStatus",array($SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $lockerId, $orderID, $newIsPrivacyProtected, $reason));
			debugfunction($this->serviceObj);
			return $return;
		}
		function resendTransferAuthorizationMail(
			$SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $orderId)
		{
			$return = $this->serviceObj->call("resendTransferAuthorizationMail",array($SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $orderId));
			debugfunction($this->serviceObj);
			return $return;
		}
		function cancelTransfer(
			$SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $orderId)
		{
			$return = $this->serviceObj->call("cancelTransfer",array($SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $orderId));
			debugfunction($this->serviceObj);
			return $return;
		}
		function add(
			$SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $domainHash, $ns, $registrantContactId, $adminContactId, $techContactId, $billingContactId, $customerId, $invoiceOption)
		{
			$return = $this->serviceObj->call("add",array($SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $domainHash, $ns, $registrantContactId, $adminContactId, $techContactId, $billingContactId, $customerId, $invoiceOption));
			debugfunction($this->serviceObj);
			return $return;
		}
		function listOrder(
			$SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $orderId, $resellerId, $customerId, $showChildOrders, $classKey, $currentStatus, $description, $ns, $contactName, $contactCompanyName, $creationDTRangStart, $creationDTRangEnd, $endTimeRangStart, $endTimeRangEnd, $numOfRecordPerPage, $pageNum, $orderBy)
		{
			$return = $this->serviceObj->call("list",array($SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $orderId, $resellerId, $customerId, $showChildOrders, $classKey, $currentStatus, $description, $ns, $contactName, $contactCompanyName, $creationDTRangStart, $creationDTRangEnd, $endTimeRangStart, $endTimeRangEnd, $numOfRecordPerPage, $pageNum, $orderBy));
			debugfunction($this->serviceObj);
			return $return;
		}
		function restore(
			$SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $orderId, $invoiceOption)
		{
			$return = $this->serviceObj->call("restore",array($SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $orderId, $invoiceOption));
			debugfunction($this->serviceObj);
			return $return;
		}
	}
?>