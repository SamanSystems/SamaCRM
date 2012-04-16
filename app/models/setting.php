<?php
class Setting extends AppModel
{
	var $name = "Setting";
	var $validate=array(
						 'discount'=>array(
											'rule'=>array('rule' => 'numeric',
															'message'=>'تحفیف سالانه باید عدد باشد'
															)
										)
						);
}
?>