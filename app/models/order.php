<?php
class Order extends AppModel
{
	var $name="Order";
	var $belongsTo = array('Product');
	var $validate=array( 
							'service'=>array(
												'rule'=> array('comparison', '>=', 1),
												'message'=>'شما باید حتما یک سرویس انتخاب کنید'
											),
							'product_id'=>array(
												'rule'=> array('comparison', '>=', 1),
												'message'=>'شما باید حتما یک محصول انتخاب کنید'
											)
						);
	var $order = array('Order.id'=> 'DESC');
							
}
?>