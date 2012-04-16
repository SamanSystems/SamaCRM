<?php

class NewsController extends AppController {
	var $name = 'News';
	//var $uses = array('News','Newscategory');
	var $components = array('Security');
	
	function index($id = 0)
	{
		if(!empty($id))
			$this->set('news',$this->News->findById($id));
		else{
			$this->paginate = array ('limit' => 10, 'order' => array('News.date' => 'desc'));
			$allnews = $this->Paginate('News');
			$this->set('allnews',$allnews);
		}
	}
	
	function category($id = 0)
	{
		if(empty($id))
			$this->redirect(array('controller' => 'news','action' => 'index'));
		else{
			$this->paginate = array ('limit' => 10, 'conditions'=>array('News.newscategory_id' =>$id),'order' => array('News.date' => 'desc'));
			$allnews = $this->Paginate('News');
			$this->set('allnews',$allnews);
		}
	}
	
	function show($limit=5)
	{
		return $this->News->find('all',array('limit' => $limit, 'order' => 'News.id DESC'));
	}
	
}
?>
