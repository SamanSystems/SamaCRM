<div class="content_title">
	<h2>تمديد / پرداخت سرويس</h2>
</div>
<div class="content_content">
	<?php	

	echo $form->create('Order', array('url' => array('controller'=>'users', 'action' =>'reneworder', $order_id)));
		
		echo '<div class="input text"><label for="OrderService"><b>سرویسها:  </b></label>'.$product['Service']['name'].
		'</div><br />
		<div class="input text"><label for="OrderProduct"><b>محصولات:  </b></label>'.$product['Product']['name'].
		'</div>
		<div class="input" id="price_label"></div>';

	?>
	<br />
	<?php
		$disabled = Array();
		if($order['Order']['discount']>0) $disabled['readonly'] = true;
		echo $form->input('monthly',array_merge(array('label'=>'<b>دوره پرداخت:</b>'),$disabled));
	?>
	<br />
	<?php
	if($product['Service']['need_domain']){
		echo $form->input('desc',array('id' => 'UserDomain','type' => 'text','label'=>'<b>نام دامنه:</b>','readonly' => 'true')).'<br />';
	}
	?>
	<?php
		foreach($extras as $extra => $val) echo $form->input('Order.'.$extra,array('class' => 'input-eng', 'value' => $val));
		echo '<br/>'.$form->input('public_note',array('type' => 'textarea','label'=>'<b>يادداشت عمومی:</b>')).'<br />';
	?>
	<br/>
	<b>نحوه پرداخت:</b><br />
	<?php
		echo $form->radio('payment_method', array('credit' => ' پرداخت با اعتبار حساب کاربری<br /><b style= margin-right:20px>  اعتبار شما در حال حاضر:</b> <span class="credit">'.$credit.'</span>   تومان<br />'), array('legend' => false, 'separator' => '<br />', 'label' => false))
			.$form->hidden('product_id')
			.$form->end('پرداخت سرويس');
	?>
</div>

