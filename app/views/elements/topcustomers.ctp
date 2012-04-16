<?php
	$customers=$this->requestAction('/customers/show');
?>
<div id="customers-cont">
<ul id="customers">
<?php
foreach($customers as $customer)
{
	echo '<li><a href="'.$customer['Customer']['link'].'" target="_blank">'.$customer['Customer']['title'].'</a></li>';
}
?>
</ul>
</div>