	<?php if(isset($cardid))
	  {
	?>
	<div class="content_title">
		<h2>کوپن شارژ ايجاد شده</h2>
	</div>
	<div class="content_content">
		<table>
		<tr><td>بارکد کارت: </td><td><b><?php echo $cardbarcode; ?></b></td></tr>
		<tr><td>شماره کارت: </td><td><b><?php echo $cardid; ?></b></td></tr>
		<tr><td>رمز کارت: </td><td><b><?php echo $cardpassword; ?></b></td></tr>
		<tr><td>اعتبار کارت: </td><td><b><?php echo $cardcredit; ?> تومان</b></td></tr>
		</table>
		<p align='left'><?php
		echo $html->link('مشاهده نسخه چاپی', array('controller' => 'managers', 'action' => 'printcardcharge', 'id'=>$cardid),array('title'=>'مشاهده نسخه چاپی','escape'=>false,'class'=>'newPage'));
		?></p>
	</div>
	<?php
	  }
	?>
	<div class="content_title">
		<h2>ايجاد کوپن شارژ</h2>
	</div>
	<div class="content_content">
		<?php
		echo 
			$form->create('Cardcharge', array('url' => array('controller' => 'managers' ,'action' => 'makecardcharge','make')))
			.$form->input('credit')
			.$form->end(__('Submit', true));
		?>
	</div>