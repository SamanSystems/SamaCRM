<div class="content_title">
	<h2>تاييد سفارش</h2>
</div>
<div class="content_content">
<?php	
	echo
		'برای ادامه کار باید پست الکترونیکی به  آقا/خانم '.$client['User']['name'].'&nbsp;&nbsp;به آدرس '.$client['User']['email'].' فرستاده شود.<br /> 
		متن نامه  را می توانید در زیر پر کنید: '.'<br />'.
		$form->create('Order',array('url' => array('controller' => 'managers' , 'action' => 'order_confirm', $id ))).
		$form->input('mail',array('id'=>'editor','value'=>$ineditor)).
		$form->end(__('Send',true)).'<br />'.
		$html->link('برگشت به سفارشات',array('controller' => 'managers' , 'action'=>'orders' ));
?>
</div>