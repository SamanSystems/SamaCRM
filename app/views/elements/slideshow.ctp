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
							<img alt="عصرنت | هاست | هاستینگ | میزبانی وب | ثبت دامنه | دومین | سروراختصاصی | سرور مجازی" src="'.$slideshow['Slideshow']['pic_address'].'" />
						</a>
					</li>';
	}	
	
echo '</ul></div>';

?>