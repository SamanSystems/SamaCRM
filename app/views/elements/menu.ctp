<ul>
<?php
	$data = $this->requestAction('/menus/show');
	
	foreach ($data as $menu)
		echo '<li><a href="'.$menu['Menu']['link'].'">'.$menu['Menu']['title'].'</a></li>';

?>
</ul>