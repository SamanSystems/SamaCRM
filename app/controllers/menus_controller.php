<?php

class MenusController extends AppController
{
    var $name = 'Menus';
	var $uses = array('Menu');
	
	function show ()
	{
        $data = $this->Menu->find('all',array('order'=> array('Menu.sort ASC')));
		return $data;
    }

}

?>