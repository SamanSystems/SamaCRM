<?php
	$customers=$this->requestAction('/customers/show');
?>

<div class="menu-box normal">
	<h2>مشتريان ما</h2>
		<ul class="list">
			<?php
			foreach($customers as $customer)
			{
				echo '<li><a href="'.$customer['Customer']['link'].'" target="_blank">'.$customer['Customer']['title'].'</a></li>';
			}
			?>
		</ul>
</div>