<div class=content_title>
	<h2>افزودن تراکنش</h2>
</div>
<div class=content_content>
<?php
   echo $form->create('Transaction',array('url'=>array('controller'=>'managers', 'action'=>'add_transaction',$id))).
        $form->input('payment_id',array('label'=>'روش پرداخت:','options'=>$payment)).
        $form->input('amount',array('label'=>'مقدار :')).
        $form->input('desc' ,array('label'=>'توضیحات :')).
        $form->end(__('ثبت',true));
    
?>
</div>