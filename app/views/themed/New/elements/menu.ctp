<ul class="menu">
<?php
 $data = $this->requestAction('/menus/show');
 $i = 0 ;
 foreach ($data as $menu){
	
	echo '<li'. (($i==0)?' id="first"': '') .'><a href="'.$menu['Menu']['link'].'">'.$menu['Menu']['title'].'</a></li>';
	$i++;
 }

?>
</ul>