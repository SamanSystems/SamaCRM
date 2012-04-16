<div class="content_title">
	<h2>ویرایش سفارش</h2>
</div>
<div class="content_content">
	
	<?php	
	if($this->data['Order']['confirmed'] == 0)
		echo '<div class="warning-msg" id="flashMessage">جهت تغيير وضعيت به در انتظار تاييد لطفا '. $html->link('کليک کنيد', array('controller' => 'managers', 'action' => 'loginas', 'id' => $this->data['Order']['user_id'])).' تا با حساب کاربری مشتری وارد شويد.</div>';
	echo $form->create('Order', array('url' => array('controller'=>'managers', 'action' =>'edit_order',$this->data['Order']['id'])));
	if ( isset($services) )
	{
		echo '<div class="input select"><label for="OrderConfirmed"><b>سرویسها:</b></label> <select name="data[Order][service]" size="1" id="services_list" disabled>';
		foreach ( $services as $service )
		{
			echo '<option value="'.$service['Service']['id'].'" monthly="'.$service['Service']['monthly'].'" '.( ($service['Service']['id'] == $this->data['Product']['service_id']) ? 'selected' : '' ).'>'.$service['Service']['name'].'</option>';
		}
		echo '</select></div>'
		.$form->input('product_id',array('options'=> $products,'selected' =>$this->data['Product']['id'],'label'=>'<b>محصولات:</b>','disabled'=>'disabled'));
	}

			echo $form->input('next_pay', array('type'=>'date','label'=>'<b>تاریخ پرداخت بعدی:</b>')).
				$form->input('date', array('type'=>'date','label'=>'<b>تاریخ ثبت:</b>'));


	echo $form->input('monthly',array('options'=> $monthles,'selected' =>$this->data['Order']['monthly'],'label'=>'<b>دوره پرداخت:</b>','disabled'=>'disabled'));
	?>

	<div class="input text"><label for="OrderPrice"><b>قيمت:</b></label>
	<?php echo $cost; ?> تومان</div>
	<?php echo $form->input('desc',array('type' => 'text','id' => 'UserDomain','label'=>'<b>نام دامنه:</b>')).
			$form->input('discount',array('label'=>'<b>تخفیف (تومان) :</b>')).						$form->input('privet_note',array('type' => 'textarea','label'=>'<b>يادداشت عمومی:</b>')).						$form->input('public_note',array('type' => 'textarea','label'=>'<b>يادداشت خصوصی:</b>')); 
			
	echo $form->input('confirmed',array('label'=>'<b>وضعيت:</b>', 'options'=> array('-2' => 'اشکال سيستمی','-1' => 'منقضی شده','0' => 'پيش سفارش','1' => 'در انتظار تاييد','2' => 'تاييد شده')));
	
	foreach($extras as $extra => $val) echo $form->input('Order.Api.'.$extra,array('class' => 'input-eng', 'value' => $val));
	?>
	<button type="submit">ادامه &raquo;</button>
	</form>
</div>

