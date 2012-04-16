<?php
class SlideshowsController extends AppController
{

	function show()
	{
		return $this->Slideshow->find('all',array('conditions' => array('Slideshow.active'=> 1)));
	}

}
?>