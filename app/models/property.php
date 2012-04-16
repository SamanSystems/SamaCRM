<?php
class Property extends AppModel
{
	var $name="Property";
	var $hasMany=array("Productproperty" => array('order' => 'Productproperty.product_id'));
	var $order= "Property.id ASC";
}
?>