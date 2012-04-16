<?php
echo '<div class="content_title">
		<h2> سرویس های ارائه شده'. $service['Service']['name'].':</h2>
     </div>';
	echo'<div class="content_content">';
		foreach($products as $product)
		{
			echo	$html->link($product['Product']['name'],array('controller'=>'User' , 'action'=>'showById', $product['Product']['id']));
			echo '<br>'.
			$product['Product']['description'].'<br>';
		}
	echo	 '</div>';
 ?>
