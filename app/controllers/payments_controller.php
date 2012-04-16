<?php
class PaymentsController extends AppController
{
	var $name='Payments';
	
	function show()
	{
		return $this->Payment->find('all',array('conditions' => array('Payment.list' => '1')));
	}
}

?>