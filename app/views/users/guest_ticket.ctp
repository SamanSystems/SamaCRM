<?php
if(empty($message)){
?>
	<div class=content_title>
		<h2>پيگيری تيکت های باز شده قبلی</h2>
	</div>
	<div class="content_content">
		<?php
		echo $form->create('Ticket', array('url' => array('controller' => 'users' ,'action' => 'guest_ticket')))
			.$form->input('email')
			.$form->input('ticket_id',array('label' => 'شماره تيکت'))
			.$form->end(__('Submit', true));
		?>
	</div>
<?php
}
else{
?>
	<div class=content_title>
		<h2>عنوان تيکت: <?php echo $ticket['Ticket']['title']; ?> - <span dir='ltr'>#<?php echo $ticket['Ticket']['id']; ?></span></h2>
	</div>
	<div class="content_content">

	<table class="listTable" border="0">
		<tr>
		<th>شماره</th>
		<th>عنوان</th>
		<th>تاریخ ثبت</th>
		<th>آخرين تغيير</th>
		<th>اهميت</th>
		<th>وضعيت</th>
		</tr>
		<?php
		if ($ticket['Ticket']['user_unread'] == 1)
			echo "<tr class='unread'>";
		else
			echo "<tr>";
		?>
		<td><?php echo $ticket['Ticket']['id']; ?></td>
		<td><?php echo $ticket['Ticket']['title']; ?></td>
		<?php 
		$todaytime = $jtime->pdate("Y/n/j", time());
		if ($jtime->pdate("Y/n/j", $ticket['Ticket']['date']) == $todaytime)
			echo '<td>'. $jtime->pdate("h:i a", $ticket['Ticket']['date']).'</td>';
		else 
			echo '<td>'. $jtime->pdate("Y/n/j", $ticket['Ticket']['date']).'</td>';
		if ($jtime->pdate("Y/n/j", $ticket['Ticketreply'][count($ticket['Ticketreply'])-1]['date']) == $todaytime)
			echo '<td>'. $jtime->pdate("h:i a", $ticket['Ticketreply'][count($ticket['Ticketreply'])-1]['date']).'</td>';
		else
			echo '<td>'. $jtime->pdate("Y/n/j", $ticket['Ticketreply'][count($ticket['Ticketreply'])-1]['date']).'</td>';
		echo '<td>';
		switch ($ticket['Ticket']['priority']) {
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
		switch ($ticket['Ticket']['status']) {
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
		echo'</td>
		</tr>';
		if($ticket['Ticket']['status'] == 1)
		{
			$link = $html->link('بسته شده', array('controller' => 'users', 'action' => 'closeticket', 'id' => $ticket['Ticket']['id']));
			echo'<tr><td colspan="6">در صورتی که مشکل شما حل شده است تيکت را به وضعيت '.$link.' تغيير دهيد.</td></tr>';
		}
			?>
	</table>
	<br />
	<fieldset>
		<legend>مشخصات ميهمان</legend>
			<b>نام و نام خانوادگی :  </b>
			<?php
				echo $message['Message']['name'].'<br />';
			?>
			<b>شماره تماس :</b>
			<?php
				echo $message['Message']['phone'].'<br />';
			?>
			<b>پست الکترونیک :</b>
			<?php
				echo $message['Message']['email'].'<br />';
			?>
			<b>شماره تيکت :</b>
			<?php
				echo $message['Message']['ticket_id'].' (برای پيگيری، اين شماره را به خاطر داشته باشيد.)<br />';
			?>
			
		</fieldset>
	<br />
	<?php
		foreach ( $ticketreplies as $ticketreply ) {
			if($ticketreply['Ticketreply']['user_id'] == 0){
				$ticketreply['User']['name'] = 'کاربر خودکار';
				$ticketreply['User']['company'] = $setting['name'];
			}
			elseif($ticketreply['Ticketreply']['user_id'] == -1){
				$ticketreply['User']['name'] = $message['Message']['name'];
				$ticketreply['User']['company'] = 'ميهمان';
			}
			echo '<div class="ticket-reply">
					<div class="header">
						<div class="info"> <b>توسط :</b> '.$ticketreply['User']['name'].(!empty($ticketreply['User']['company'])?' ('.$ticketreply['User']['company'].') ': '').'</div>
						<div class="date"> <b>تاريخ :</b> '. $jtime->pdate("Y/n/j - h:i a", $ticketreply['Ticketreply']['date']) .'</div>
						<div class="clear"></div>
					</div>'
				.nl2br($ticketreply['Ticketreply']['content']) 
				.'<br /></div>
				<div class="clear"></div>
				';
		}
	?>
		</div>
		<div class="content_title">
			<h2>ارسال پاسخ برای تيکت</h2>
		</div>
		<div class="content_content">
			<?php
			echo $form->create('Ticketreply', array('url' => array('controller' => 'users' ,'action' => 'guest_postticketreply', $message['Message']['email'] , $ticket['Ticket']['id'])))
				.$form->input('content')
				.$form->end(__('Submit', true));
			?>
		</div>
<?php
}
?>