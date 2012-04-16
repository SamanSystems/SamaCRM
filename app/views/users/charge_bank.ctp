<?php

echo '<div class="content_title">
		<h2>مشخصات حواله واريزی</h2>
	  </div>
		
		<div class="content_content">'
		.	$form->create('Transaction',array('url' => array('controller'=>'users', 'action' =>'charge','id'=>'bank'))).
			$form->inputs(array('fieldset'=>false,'payment','amount', 'reference_number','tdate' => array('type'=>'date','dateFormat' => 'DMY','minYear' => '1387', 'maxYear' => $jtime->pdate('Y',time()))),array('user_id','confirmed')).
			$form->end(__("Add transaction",true)).	
		'</div>';
?>