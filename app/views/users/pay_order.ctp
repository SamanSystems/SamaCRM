<div class="content_title">
	<h2>پرداخت صورت حساب</h2>
</div>
<div class="content_content">
	<?php

	if(!empty($orders_info)){
		echo $this->element('order-table');
	}
		
		if(!empty($credit)) $payment_method['credit'] = ' پرداخت با اعتبار حساب کاربری<br /><b style= margin-right:20px>  اعتبار شما در حال حاضر:</b> <span class="credit">'.$credit.'</span>   تومان<br />';
		if(!empty($user)) $payment_method['recharge'] = 'هم اکنون افزايش اعتبار می کنم';
		
		$payment_method['skip'] = 'پرداخت بعدا صورت می گیرد';
		
		echo '<b>روش پرداخت:</b><br />'
			.$form->create('Order', array('url' => array('controller'=>'users', 'action' =>'PayOrder')))
			.$form->radio('payment_method', $payment_method, array('legend' => false, 'separator' => '<br />', 'label' => false))
			.'<br /><br />'
			.$form->end('ادامه خريد');
	?>
</div>