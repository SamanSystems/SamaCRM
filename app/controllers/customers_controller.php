<?php
class CustomersController extends AppController{
	function show()
	{
		return $this->Customer->find('all');
	}
}


?>