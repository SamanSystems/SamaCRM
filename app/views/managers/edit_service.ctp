<div class="content_title">
	<h2>ویرایش سرویس</h2>
</div>
<div class="content_content">
	<?php
	
	echo $form->create('Service', array('url' => array('controller' => 'managers' ,'action' => 'edit_service')))
		.$form->input('name',array('label' => __('Service Name',true)))
		.$form->input('desc',array('label'=>'توضیحات')).
		'<br /> <i> برای پاک کردن مشخصات قبلی  مقدار آن را پاک کنید</i><br /><b> مشخصات قبلی :</b><br /><br />';
		$count=0;
		foreach($properties as $property )
		{
			$count++;
			echo '<label>مورد '.$count.' :</label><input name="data[Service][oldproperty]['.$property['Property']['id'].']" type="text" value="'.$property['Property']['name'].'" count="'.$count.'" /><br/><br/>';
			
		}
		echo '<b>مشخصات  :</b><br /><br /><div id="property"></div>'.$html->image('icons/add.png', array('id' => 'add_property')).
		$html->image('icons/unconfirm.png', array('id' => 'delete_property')).'<br /><br />'
		.$form->input('period', array('type' => 'select', 'multiple' => 'checkbox',
					      'options'=>array('1' => 'ماهيانه',
						'3'=>'سه ماهه',
						'6' => 'شش ماهه',	
						'12'=>'سالیانه',
						'24'=>'دو ساله',
						'60'=>'پنج ساله',
						'-120'=>'مادام العمر'
						),
					      'selected'=>$period
				)
		)
		.$form->input('need_domain',array('label'=>'نیاز به وارد کردن نام دامنه دارد'))
		.$form->input('relative_services',array('label'=>'سرويس های مرتبط', 'type' => 'select', 'multiple' => 'checkbox' ,'options'=> $services))
		.$form->input('api_id',array('options' => $apis))
		.$form->end(__('Submit', true));
	?>
</div>

