<div class="content_title">
		<h2>جستجوی دامنه</h2>
	  </div>
	  <div class="content_content">
<?php
echo $form->create ('User',array('url' => array('controller'=>'users', 'action' =>'whois'))).
$form->input('domain', array('class' => 'input-eng')). $form->input('ext').
$form->end(__('Whois',true));
	if(!empty($domain)){
		if($domain['whois']['result'] == 'available' ) { 
			$message = 'دامنه '. $domain['domain'] .' برای ثبت <span> آزاد  مي باشد</span>'.'برای ثبت اینجا '.$html->link('کلیک کنید',array('controller'=>'users' , 'action'=>'neworder','id' => $domain['product_id'], $this->data['User']['domain'] ));
			$status='success';
		} else {
			$message = 'دامنه '. $domain['domain'] .' برای ثبت <span> آزاد  نمي باشد</span>';
			$status='error';
		}
	  echo '<br /><div class="'.$status.'-msg" id="flashMessage">'. $message .'</div>';
	}
?>
	 </div>
<?php
if(!empty($domain['whois']['whois'])){

	  echo '<div class="content_title">
		<h2>اطلاعات ثبت کننده</h2>
	  </div>
	  <div class="content_content input-eng">'.$domain['whois']['whois'].'</div>';

}
?>