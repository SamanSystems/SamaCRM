<?php
class Ticketreply extends AppModel
{
	var $name="Ticketreply";	var $belongsTo = array('User');
	var $validate=array( 
						'content'=>array('notempty'=>
														array(
																'rule'=>'notEmpty',
																'message'=>'متن نباید خالی باشد'
														)
										)
						);
}
?>