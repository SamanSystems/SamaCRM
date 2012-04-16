<?php
	include_once("nusoap.php");
	include_once("apiutil.php");

	class DomFwdOrder
	{
		var $serviceObj;
		var $wsdlFileName;
		function DomFwdOrder($wsdlFileName="wsdl/DomFwdOrder.wsdl")
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
		function getDetailsByDomain(
			$SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $domainName, $option, $productkey)
		{
			$return = $this->serviceObj->call("getDetailsByDomain",array($SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $domainName, $option, $productkey));
			debugfunction($this->serviceObj);
			return $return;
		}
		function renew(
			$SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $domainHash, $invoiceOption)
		{
			$return = $this->serviceObj->call("renew",array($SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $domainHash, $invoiceOption));
			debugfunction($this->serviceObj);
			return $return;
		}
		function manage(
			$SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $entityId, $forward, $urlMasking, $subdomainForwarding, $noframes, $headerTags)
		{
			$return = $this->serviceObj->call("manage",array($SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $entityId, $forward, $urlMasking, $subdomainForwarding, $noframes, $headerTags));
			debugfunction($this->serviceObj);
			return $return;
		}
		function deleteService(
			$SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $entityId)
		{
			$return = $this->serviceObj->call("deleteService",array($SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $entityId));
			debugfunction($this->serviceObj);
			return $return;
		}
		function setupDomainFwdService(
			$SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $orderId)
		{
			$return = $this->serviceObj->call("setupDomainFwdService",array($SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $orderId));
			debugfunction($this->serviceObj);
			return $return;
		}
		function manageDomainForwardService(
			$SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $domainName, $urlMasking, $subdomainForwarding, $forward, $noframes, $headerTags)
		{
			$return = $this->serviceObj->call("manageDomainForwardService",array($SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $domainName, $urlMasking, $subdomainForwarding, $forward, $noframes, $headerTags));
			debugfunction($this->serviceObj);
			return $return;
		}
		function add(
			$SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $domainHash, $customerId, $invoiceOption)
		{
			$return = $this->serviceObj->call("add",array($SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $domainHash, $customerId, $invoiceOption));
			debugfunction($this->serviceObj);
			return $return;
		}
		function listOrder(
			$SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $orderId, $resellerId, $customerId, $showChildOrders, $currentStatus, $domainname, $forward, $checkUrlMasking, $checkPathForwarding, $checkSubDomainForwarding, $creationDTRangStart, $creationDTRangEnd, $endTimeRangStart, $endTimeRangEnd, $numOfRecordPerPage, $pageNum, $orderBy)
		{
			$return = $this->serviceObj->call("list",array($SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $orderId, $resellerId, $customerId, $showChildOrders, $currentStatus, $domainname, $forward, $checkUrlMasking, $checkPathForwarding, $checkSubDomainForwarding, $creationDTRangStart, $creationDTRangEnd, $endTimeRangStart, $endTimeRangEnd, $numOfRecordPerPage, $pageNum, $orderBy));
			debugfunction($this->serviceObj);
			return $return;
		}
		function mod(
			$SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $entityId, $forward, $urlMasking, $subdomainForwarding, $noframes, $headerTags)
		{
			$return = $this->serviceObj->call("mod",array($SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $entityId, $forward, $urlMasking, $subdomainForwarding, $noframes, $headerTags));
			debugfunction($this->serviceObj);
			return $return;
		}
	}
?>