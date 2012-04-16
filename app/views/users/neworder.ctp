<div class="content_title">
	<h2>ثبت سفارش جدید</h2>
</div>
<div class="content_content">
	<?php
	if(!empty($product['Service']['desc']))
		echo '<div class="warning-msg" id="flashMessage">'.nl2br($product['Service']['desc']).'</div>';

	if(!empty($orders_info)){
		echo $this->element('order-table', array('showprice' => false));
	}
	
	echo $form->create('Order', array('url' => array('controller'=>'users', 'action' =>'neworder', 'id' => $product['Product']['id'])));
		echo '<div class="input text"><label for="OrderService"><b>سرويس:  </b></label>'.$product['Service']['name'].
		'</div>
		<div class="input text"><label for="OrderProduct"><b>محصول:  </b></label>'.$product['Product']['name'].
		'</div>
		';
		
		if(count($monthlies)> 2){
			echo '<div class="input" id="price_label"></div>'
				.$form->input('monthly',array('label'=>'<b>دوره پرداخت:</b>'));
		}else{
			echo '<div class="input" id="price_label"><label for="PriceLabel"><b>قيمت:  </b></label>'. $price .' تومان</div>'
				.$form->input('monthly',array('label'=>'<b>دوره پرداخت:</b>','type' => 'hidden', 'value' => $month));
		}
		
			
	if($product['Service']['need_domain']){
		if($product['Product']['plan_name']{0} == '.') $ext = '<input type="text" id="OrderDomainExtension" disabled="disabled" value="'.$product['Product']['plan_name'].'" name="data[Order][domain_extension]">';
		echo $form->input('desc',array('id' => 'UserDomain', 'class' => 'input-eng', 'type' => 'text', 'label' => '<b>نام دامنه:</b>', 'between' => $ext));

	}
	
	foreach($extras as $extra => $val) echo $form->input('Order.'.$extra,array('class' => 'input-eng', 'value' => $val));
	
	echo '<br/>'.$form->input('public_note',array('type' => 'textarea','label'=>'<b>يادداشت عمومی:</b>')).'<br />';
	
	?>
	<br/>
	<b>گام بعدی:</b><br />
	<?php
		if(strlen($product['Service']['relative_services']) > 1)
			$states['continue'] = 'افزودن محصول جديد به سفارش';
		$states['finished'] = 'اتمام خريد و انتخاب نحوه پرداخت';
		echo $form->radio('state', $states, array('legend' => false, 'separator' => '<br />', 'label' => false))
			.'<br /><br />'
			.$form->hidden('product_id')
			.$form->end('ادامه خريد');
	?>
</div>