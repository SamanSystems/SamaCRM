<div class="content_title">
	<h2>افزودن سرویس</h2>
</div>
<div class="content_content">
	<?php
	echo $form->create('Service', array('url' => array('controller' => 'managers' ,'action' => 'add_service')))
		.$form->input('name' ,  array('label' => __('Service Name',true)))
		.$form->input('desc',array('label'=>'توضیحات')).
		'<div id="property">
	
			<b>مشخصات این سرویس :</b><br />
			<br /><span><label>مورد 1:</label><input name="data[Service][property][1]" type="text" value="" count="1" /><br/><br/></span>
			<span><label>مورد 2:</label><input name="data[Service][property][2]" type="text" value="" count="2"   /><br /><br/></span>
			<span><label>مورد 3:</label><input name="data[Service][property][3]" type="text" value="" count="3" /><br /><br/></span>
			<span><label>مورد 4:</label><input name="data[Service][property][4]" type="text" value="" count="4"  /><br /><br/></span>
			<span><label>مورد 5:</label><input name="data[Service][property][5]" type="text" value="" count="5"  /><br/><br/></span>
		</div>'.
		$html->image('/img/icons/add.png', array('id' => 'add_property')). ' ' .
		$html->image('/img/icons/unconfirm.png', array('id' => 'delete_property')). '<br /><br />'
		.$form->input('period',array('type' => 'select', 'multiple' => 'checkbox' ,'options'=>array(
														'1' => 'ماهيانه',
														'3'=>'سه ماهه',
														'6' => 'شش ماهه',
														'12'=>'سالیانه',
														'24'=>'دو ساله',
														'60'=>'پنج ساله',
														'-120'=>'مادام العمر'
														)
						)
				)
		.$form->input('need_domain',array('label'=>'نیاز به وارد کردن نام دامنه دارد'))
		.$form->input('relative_services',array('label'=>'سرويس های مرتبط', 'type' => 'select', 'multiple' => 'checkbox' ,'options'=> $services))
		.$form->end(__('Submit', true));
	?>
</div>


