	<div class=content_title>
		<h2>مشاهده تيکت های <?php echo $client['User']['name']; ?></h2>
	</div>
	<div class="content_content">

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
		foreach ( $tickets as $ticket ) {
		if ($ticket['Ticket']['user_unread'] == 1)
			echo "<tr class='unread'>";
		else
			echo "<tr>";
	?>
			<td colspan = "2"><?php echo $html->link($ticket['Ticket']['title'], array('controller'=>'managers','action' => 'tickets',$ticket['Ticket']['id'])); ?></td>
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
		<tr class='info'>
			<td>
				<?php if($ticket['Ticket']['user_id'] == -1) echo 'ميهمان'; else echo $link = $html->link($ticket['User']['name'], array('controller' => 'managers', 'action' => 'contact', 'id' => $ticket['User']['id'])); ?>
			</td>
			<td colspan = "3">
			 دپارتمان: <b><?php if($ticket['Ticket']['ticketdepartment_id'] <> 0) echo $ticket['Ticketdepartment']['name']; else echo "بدون دپارتمان"; ?></b>
			</td>
			<td colspan = "2">
			<?php if($ticket['Ticket']['flag_user_id'] <> 0) echo 'ارجاع به: '.$ticket['Flaguser']['name']; ?></b>
			
			</td>
		</tr>
	<?php
		}
	?>
	
	</table>
	</div>