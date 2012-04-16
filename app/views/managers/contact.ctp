<div class="content_title">
	<h2>مشخصات مشتری</h2>
</div>
<div class="content_content">
	
	<fieldset>
	<?php 
		echo '<legend>مشخصات مشتری</legend><br />نام مشتری: '.$client['User']['name'].' - '
		.$html->link('ورود با اين شناسه کاربری' , array('controller'=>'managers','action'=>'loginas',$client['User']['id']))
		.'<br /><br />';
		if(!empty($client['User']['company']))
			echo 'نام شرکت: '.$client['User']['company'].'<br /><br />';
		if(!empty($client['User']['phonenum']))
			echo 'شماره تماس: '.$client['User']['phonenum'].'<br /><br />';
		if(!empty($client['User']['cellnum']))
			echo 'تلفن همراه: '.$client['User']['cellnum'].'<br /><br />';
		if(!empty($client['User']['address']))
			echo 'آدرس پستی: '.$client['User']['address'].'<br /><br />';
		if(!empty($client['User']['pbox']))
			echo 'کد پستی: '.$client['User']['pbox'].'<br /><br />';
		if($client['User']['referrer_id'] != 0)
			echo 'معرف: '.$html->link($referrer_client['User']['name'].' ('.$referrer_client['User']['company'].')', array('controller'=>'managers','action'=>'contact',$client['User']['referrer_id'])).'<br /><br />';

			echo 'تعداد کاربران معرفی شده: '.$referred_sum.' - '.$html->link('مشاهده' , array('controller'=>'managers','action'=>'referred_users',$client['User']['id'])).'<br /><br />';

		echo 'پست الکترونیک: '.$client['User']['email'].' - ';
		echo $html->link('افتتاح تيکت جديد برای کاربر',array('controller'=>'managers','action'=>'postticket',$client['User']['id']));
		echo '<br /><br />';
	?>
	</fieldset>
	<fieldset>
	<legend>عمليات</legend>
	<?php
		echo $html->link($html->image('/img/icons/edit.png'). ' ويرايش مشخصات', array('controller' => 'managers', 'action' => 'edit_user', $client['User']['id']),array('escape' => false, 'class' => 'button', 'title' => 'ویرایش مشخصات')).
			$html->link($html->image('/img/icons/add.png'). ' ثبت سفارش', array('controller' => 'managers', 'action' => 'add_order', $client['User']['id']), array('escape' => false, 'class' => 'button', 'title' => 'افزودن سفارش')).
			$html->link($html->image('/img/icons/pay.png'). ' ثبت تراکنش', array('controller' => 'managers', 'action' => 'add_transaction', $client['User']['id']), array('escape' => false, 'class' => 'button', 'title' => 'ثبت تراکنش')).
			$html->link($html->image('/img/icons/accounting.png'). ' گردش حساب', array('controller' => 'managers', 'action' => 'accounting', $client['User']['id']), array('escape' => false, 'class' => 'button', 'title' => 'گردش حساب')).
			$html->link($html->image('/img/icons/orders.png'). ' سفارشات', array('controller' => 'managers', 'action' => 'orders', 'user_orders', $client['User']['id']), array('escape' => false, 'class' => 'button', 'title' => 'سفارشات')).
			$html->link($html->image('/img/icons/unconfirm.png'). ' حذف کاربر', array('controller' => 'managers', 'action' => 'user_delete', $client['User']['id']), array( 'escape' => false, 'class' => 'button', 'title' => 'حذف کاربر'),'آیا مطمئنید می خواهید این کاربر را حذف کنید ؟');
		if($client['User']['role']=='-1')
		{
			echo $html->link($html->image('/img/icons/confirm.png'). ' تاييد کاربر', array('controller' => 'managers', 'action' => 'user_confirm', $client['User']['id']), array('escape' => false, 'class' => 'button', 'title' => 'تایید کابر'),'آیا مطمئنید می خواهید این کاربر را تایید کنید؟ (بعد از تایید پست الکترونیکی به کاربر فرستاده می شود)');
		}
	?>
	</fieldset>
	<fieldset>
	<legend> حذف تراکنش های کاربر</legend>
		<?php 
			echo $html->link('حذف تراکنش های مثبت و منفی کاربر',array('controller'=>'managers','action'=>'deletealltransaction',$client['User']['id']),array('escape'=>false,'title' => 'حذف کاربر'),'آيا نسبت به حذف تمامی تراکنش های مثبت و منفی اين کاربر اطمينان داريد؟');
		?>
		<br />
		برای حذف يک کاربر از سيستم ابتدا باید تمامی تراکنش های مالی کاربر حذف شود.
		<br />
		<b>مجموع تراکنش های تاييد شده تا اين لحظه: <?php echo $clienttrans; ?> تومان</b>
	</fieldset>
	<fieldset>
	<legend> آخرين تيکت های مربوط به اين کاربر (<?php echo $html->link('مشاهده ساير تيکت های '.$client['User']['name'], array('controller' => 'managers', 'action' => 'user_tickets', $client['User']['id'])); ?>)</legend>
<table class="listTable" border="0">
	
		<tr>
			<th>کاربر</th>
			<th>عنوان</th>
			<th>تاریخ ثبت</th>
			<th>آخرين تغيير</th>
			<th>اهميت</th>
			<th>وضعيت</th>
		</tr>
	
	<?php
		foreach ( $user_tickets as $user_ticket ) {
		if ($user_ticket['Ticket']['user_unread'] == 1)
			echo "<tr class='unread'>";
		else
			echo "<tr>";
	?>
			<td colspan = "2"><?php echo $html->link($user_ticket['Ticket']['title'], array('controller'=>'managers','action' => 'tickets',$user_ticket['Ticket']['id'])); ?></td>
			<?php
			$todaytime = $jtime->pdate("Y/n/j", time());
			if ($jtime->pdate("Y/n/j", $user_ticket['Ticket']['date']) == $todaytime)
				echo '<td>'. $jtime->pdate("h:i a", $user_ticket['Ticket']['date']).'</td>';
			else 
				echo '<td>'. $jtime->pdate("Y/n/j", $user_ticket['Ticket']['date']).'</td>';
			if ($jtime->pdate("Y/n/j", $user_ticket['Ticketreply'][count($user_ticket['Ticketreply'])-1]['date']) == $todaytime)
				echo '<td>'. $jtime->pdate("h:i a", $user_ticket['Ticketreply'][count($user_ticket['Ticketreply'])-1]['date']).'</td>';
			else
				echo '<td>'. $jtime->pdate("Y/n/j", $user_ticket['Ticketreply'][count($user_ticket['Ticketreply'])-1]['date']).'</td>';
			echo '<td>';
			switch ($user_ticket['Ticket']['priority']) {
				case 0:
				echo "<span class='blue'>عادی</span>";
				break;
				case 1:
				echo "<span class='orange'>مهم</span>";
				break;
				case 2:
				echo "<span class='red'>خيلی مهم</span>";
				break;
			}
			echo '</td><td>';
			switch ($user_ticket['Ticket']['status']) {
				case 0:
				echo "<span class='red'>باز شده</span>";
				break;
				case 1:
				echo "<span class='blue'>پاسخ داده شده</span>";
				break;
				case 2:
				echo "<span class='orange'>پاسخ مشتری</span>";
				break;
				case 3:
				echo "<span class='violet'>در انتظار</span>";
				break;
				case 4:
				echo "<span class='lavender'>در دست بررسی</span>";
				break;
				case 5:
				echo "<span class='green'>بسته شده</span>";
				break;
				case 6:
				echo "<span class='chromatic-green'>باز سيستمی</span>";
				break;
			}
			?>
			</td>
		</tr>
		<tr class='info'>
			<td>
				<?php if($user_ticket['Ticket']['user_id'] == -1) echo 'ميهمان'; else echo $link = $html->link($user_ticket['User']['name'], array('controller' => 'managers', 'action' => 'contact', $user_ticket['User']['id'])); ?>
			</td>
			<td colspan = "3">
			 دپارتمان: <b><?php if($user_ticket['Ticket']['ticketdepartment_id'] <> 0) echo $user_ticket['Ticketdepartment']['name']; else echo "بدون دپارتمان"; ?></b>
			</td>
			<td colspan = "2">
			<?php if($user_ticket['Ticket']['flag_user_id'] <> 0) echo 'ارجاع به: '.$user_ticket['Flaguser']['name']; ?></b>
			
			</td>
		</tr>
	<?php
		}
	?>
	</table>
	</fieldset>
	<fieldset>
	<legend> ارسال پست الکترونیک</legend>
		<?php 
			echo
				$form -> create('Contact',array('url' => array('controller' => 'managers' , 'action' => 'contact',$client['User']['id']))).
				$form -> input('subject',array('label'=>'موضوع')).
				$form -> input('post',array('label'=>'متن','id'=>'editor')).
				$form -> end('ارسال');
		?>
	</fieldset>
</div>