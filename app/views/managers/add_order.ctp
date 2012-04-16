<div class="content_title">
	<h2>ثبت سفارش جدید</h2>
</div>
<div class="content_content">
	
	<?php	
	
	if ( isset($services) )
	{
		echo $form->create('Service', array('url' => array('controller'=>'managers', 'action' =>'add_order',$id))).
		'<b>سرویسها:</b> <select name="data[Service][service]" size="1" id="services_list">'
		.'<option selected>انتخاب کنید</option>';
		foreach ( $services as $service )
		{
			echo '<option value="'.$service['Service']['id'].'" monthly="'.$service['Service']['monthly'].'">'.$service['Service']['name'].'</option>';
		}
		echo '</select><br /><br /><b>محصولات:</b> <select name="data[Service][product_id]" size="1" id="service_products"></select>'.
		$form->end('ادامه >>');
	}
	else
	{
		
        $monthly=$product['Service']['monthly'];
		if($monthly < 0)
		{
			$period[-120]='مادام العمر';
			$monthly=$monthly+120;
		}
		if($monthly-60 >= 0)
		{
			$period[60]='پنج ساله';
			$monthly=$monthly-60;
		}
		if($monthly-24 >= 0)
		{
			$period[24]='دو ساله';
			$monthly=$monthly-24;
		}
		if($monthly-12 >= 0)
		{
			$period[12]='ساليانه';
			$monthly=$monthly-12;
		}
		if(($monthly-6) >= 0)
		{
			$period[6]='شش ماهه';
			$monthly=$monthly-6;
		}
		if(($monthly-3) >= 0)
		{
			$period[3]='سه ماهه';
			$monthly=$monthly-3;
		}
		if(($monthly-1) >= 0)
		{
			$period[1]='ماهیانه';
			$monthly=$monthly-1;
		}
		ksort($period);
	

		echo
		$form->create('Order', array('url' => array('controller'=>'managers', 'action' =>'add_order',$id,$product['Product']['id']))).
		'<br /><br />
		<span id="period">
		<label>دوره پرداخت:</label>'.
		$form->input('monthly',array('options'=>$period , 'div'=>false,'label'=>false)).
		'</span><br /><br />'
			.$form->input('date', array('type'=>'date','label'=>'تاريخ سفارش'))
			.$form->input('next_pay', array('type'=>'date','label'=>'تاریخ  پرداخت بعدی:'));
                if($product['Service']['need_domain']==1)
                {
                    echo $form->input('desc',array('label'=>'نام دامنه :' , 'type'=>'text'));
                }
        echo $form->input('confirmed',array('label'=>'وضعیت :' , 'options'=>array('0'=>'پیش سفارش' , '1' => 'تایید نشده' , '2' => 'تایید شده')))
			.$form->input('reduce',array('label'=>'کسر از حساب:', 'type' => 'checkbox'))
		.$form->input('discount',array('label'=>'تخفیف (تومان) :'))
		.$form->input('privet_note',array('type' => 'textarea','label'=>'<b>يادداشت عمومی:</b>'))
		.$form->input('public_note',array('type' => 'textarea','label'=>'<b>يادداشت خصوصی:</b>'))
		.$form->end('ثبت سفارش');

	}
	?>
</div>