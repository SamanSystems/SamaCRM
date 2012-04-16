<?php
class Transaction extends AppModel
{
	var $name = "Transaction";
	var $belongsTo = array(
							'User',
							'Payment' => array(
								'fields' => 'Payment.name'
							),
							
							'Order' => array(
								'fields' => 'Order.desc'
							)
						  );
}
?>