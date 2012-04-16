<?php
class Ticket extends AppModel
{
	var $name="Ticket";
	var $validate=array( 
							'title'=>array('notempty'=>
														array(
																'rule'=>'notEmpty',
																'message'=>'عنوان نبايد خالی باشد'
														),
										'6-character'=>
														array(
																'rule'=>array('minLength','6'),
																'message'=>'عنوان بايد بیشتر از 6 کاراکتر باشد'
														)
										  )
						);
	var $hasMany=array('Ticketreply' => array('conditions' => array('Ticketreply.note' => 0), 'order' => 'Ticketreply.date ASC'));
	var $belongsTo = array('User','Ticketdepartment', 'Flaguser' => array('className' => 'User', 'foreignKey' => 'flag_user_id'));
}
?>