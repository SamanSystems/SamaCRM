<?php
class Service extends AppModel
{
	var $name = "Service";
	var $hasMany = array("Product","Property");
	var $belongsTo = array("Api");
	var $order = array('Service.name'=> 'ASC');
	var $validate=array(
			    'name'=>array(
					'empty'=>array(
						       'rule'=>'notEmpty'
							,'message'=>'نام سرویس نمی تواند خالی باشد'
							),
					'unique'=>array(
							'rule'=>'isUnique'
							,'message'=>'این نام سرویس وجود دارد.'
					)
				    ),
			    'monthly'=>array(
					'rule' => array('comparison', '>', -121),
					'message'=>'دوره پرداخت نمی تواند خالی باشد'
				)
			);
}
?>