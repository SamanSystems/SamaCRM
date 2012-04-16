<?php
class Cardcharge extends AppModel
{
	var $name="Cardcharge";
	var $validate=array( 
							'id'=>array('notempty'=>
														array(
																'rule'=>'notEmpty',
																'message'=>'شماره کارت نبايد خالی باشد'
														),
										'5-character'=>
														array(
																'rule'=>array('minLength','5'),
																'message'=>'شماره کارت بايد حداقل 5 عدد باشد'
														),
										),
							'security_code '=>array('notempty'=>
														array(
																'rule'=>'notEmpty',
																'message'=>'کد امنيتی نبايد خالی باشد'
														),
										'5-character'=>
														array(
																'rule'=>array('minLength','5'),
																'message'=>'کد امنيتی بايد حداقل 5 کاراکتر باشد'
														),
										)
						);
	var $belongsTo = array('User');
}
?>