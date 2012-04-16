<?php
class News extends AppModel
{
	var $name="News";
	var $belongsTo = array("Newscategory");

}
?>