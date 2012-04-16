<?php
$slideshows = $this->requestAction('/slideshows/show');
echo  $javascript->link('slideshow.js')
	.'<div class="slideshow" id="slideshow">
	<ul>';
	foreach($slideshows as $slideshow)
	{
			echo
					'<li class="active">
						<a href="'.$slideshow['Slideshow']['link_address'].'">
							<img src="'.$slideshow['Slideshow']['pic_address'].'" />
						</a>
					</li>';
	}	
	
echo '</ul></div>';

?>