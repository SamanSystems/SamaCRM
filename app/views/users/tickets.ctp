	<?php if(isset($tickets))
	  {
	?>
	<div class=content_title>
		<h2>تيکت های من</h2>
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
		foreach ( $tickets as $ticket ) {
		if ($ticket['Ticket']['user_unread'] == 1)
			echo "<tr class='unread'>";
		else
			echo "<tr>";
	?>
			<td><?php echo $ticket['Ticket']['id']; ?> </td>
			<td><?php echo $html->link($ticket['Ticket']['title'], array('controller'=>'users','action' => 'tickets',$ticket['Ticket']['id'])); ?></td>
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
			?>
			</td>
		</tr>
	<?php
		}
	?>
	
	</table>
	<p align='left'><a href='/users/postticket' class='button'>افتتاح تيکت جديد</a></p>
	</div>
	<?php
	  }
	  else
	  {
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

	<?php
		foreach ( $ticketreplies as $ticketreply ) {
			if(!$ticketreply['User']['name']){
				$ticketreply['User']['name'] = 'کاربر خودکار';
				$ticketreply['User']['company'] = $setting['name'];
			}
				$AttachedFile = '';
				if(!empty($ticketreply['Ticketreply']['attached_file'])){
					$AttachedFile = '<br /><a href="/users/get_attachment/'.$ticketreply['Ticketreply']['attached_file'].'" class="attachment">مشاهده فايل ضميمه</a>';
				}
			echo '<div class="ticket-reply">
					<div class="header">
						<div class="info"> <b>توسط :</b> '.$ticketreply['User']['name'].(!empty($ticketreply['User']['company'])?' ('.$ticketreply['User']['company'].') ': '').'</div>
						<div class="date"> <b>تاريخ :</b> '. $jtime->pdate("Y/n/j - h:i a", $ticketreply['Ticketreply']['date']) .'</div>
						<div class="clear"></div>
					</div>'
				.$qoute->blockqoute($ticketreply['Ticketreply']['content'], $ticketreply['Ticketreply']['user_id']) 
				.'<br />'.$AttachedFile.'</div>
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
			echo $form->create('Ticketreply', array('url' => array('controller' => 'users' ,'action' => 'postticketreply', 'id' => $ticket['Ticket']['id']), 'type' => 'file'))
				.$form->input('content')
				.$form->input('file', array('label' => 'فایل' ,'type' => 'file'))
				.$form->end(__('Submit', true));
			?>
		</div>
	<?php
	  }
	?>