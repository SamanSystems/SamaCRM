<?php 
echo '<div class="content_title">
		<h2>Orders</h2>
		</div>';

echo '<div class="content_content">';
		foreach($orders as $order)
		{
			echo $order['Order']['product_id'];
		}
echo  '</div>';
?>