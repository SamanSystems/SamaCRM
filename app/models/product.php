<?php
class Product extends AppModel
{
	var $name = "Product";
	var $belongsTo = array('Service');
	var $hasMany=array('Productproperty' , 'Order');
	var $validate=array('name'=>array('rule'=>'notEmpty',
					  'message'=>'نام محصول نمی تواند خالی باشد'
					  )
			    );
}
?>