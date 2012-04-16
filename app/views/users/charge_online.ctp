<?php

echo '<div class="content_title">
		<h2>افزايش اعتبار آنلاين</h2>
	  </div>
		
		<div class="content_content">'.
			$form->create('Transaction',array('url' => array('controller'=>'users', 'action' =>'charge','online'))).
			$form->input('amount').
			$form->input('merchent').
			$form->end(__("Add Fund",true)).	
		'</div>';
?>