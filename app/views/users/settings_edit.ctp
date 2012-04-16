              <div class="content-header">
                  <div class="content-header-right">
	                <?php echo $html->image('icons/48/settings.png'); ?>
                      <h2>ويرايش تنظيمات سايت</h2>
                  </div>
              </div>
              <div class="content-in" id="tab">
				<?php
				echo $form->create('Setting', array('url' => array('controller' => 'managers' ,'action' => 'settings_edit')))
					.$form->input('name',array('label'=>'نام فروشگاه:'))
					.$form->input('phonenum',array('label'=>'تلفن تماس:'))
					.$form->input('address',array('label'=>'آدرس فروشگاه:'))
					.$form->input('website',array('آدرس سایت : '))
					.$form->input('desc',array('label'=>'توضیحات:'))
					.$form->input('mail_address',array('label'=>'آدرس پست الکترونیک:','class'=>'input-eng'))
					.$form->input('mail_title',array('label'=>'عنوان پست‌های الکترونیک:'))
					.$form->input('send_email',array('label'=>'پست الکترونیک فرستاده شود'))
					.$form->end(__('Submit', true));
				?>
              </div>