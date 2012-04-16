<?php
	include_once("nusoap.php");
	include_once("apiutil.php");

	class ZoneOrder
	{
		var $serviceObj;
		var $wsdlFileName;
		function ZoneOrder($wsdlFileName="wsdl/ZoneOrder.wsdl")
		{
			$this->wsdlFileName = $wsdlFileName;
			$this->serviceObj = new soapclient_nusoap($this->wsdlFileName,"wsdl");
		}
		function getDetails(
			$SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $zoneid, $options)
		{
			$return = $this->serviceObj->call("getDetails",array($SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $zoneid, $options));
			debugfunction($this->serviceObj);
			return $return;
		}
		function del(
			$SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $entityId)
		{
			$return = $this->serviceObj->call("del",array($SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $entityId));
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
		function getOrderIdByDomain(
			$SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $domainName, $productkey)
		{
			$return = $this->serviceObj->call("getOrderIdByDomain",array($SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $domainName, $productkey));
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
		function setupDNSService(
			$SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $orderID)
		{
			$return = $this->serviceObj->call("setupDNSService",array($SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $orderID));
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
			$SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $orderId, $resellerId, $customerId, $showChildOrders, $currentStatus, $description, $recordtype, $source, $destination, $creationDTRangStart, $creationDTRangEnd, $endTimeRangStart, $endTimeRangEnd, $numOfRecordPerPage, $pageNum, $orderBy)
		{
			$return = $this->serviceObj->call("list",array($SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $orderId, $resellerId, $customerId, $showChildOrders, $currentStatus, $description, $recordtype, $source, $destination, $creationDTRangStart, $creationDTRangEnd, $endTimeRangStart, $endTimeRangEnd, $numOfRecordPerPage, $pageNum, $orderBy));
			debugfunction($this->serviceObj);
			return $return;
		}
		function mod(
			$SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $zoneid, $modnoofrecords, $modnoofyears)
		{
			$return = $this->serviceObj->call("mod",array($SERVICE_USERNAME, $SERVICE_PASSWORD, $SERVICE_ROLE, $SERVICE_LANGPREF, $SERVICE_PARENTID, $zoneid, $modnoofrecords, $modnoofyears));
			debugfunction($this->serviceObj);
			return $return;
		}
	}
?>