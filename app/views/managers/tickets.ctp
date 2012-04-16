	<?php if(isset($tickets))
	  {
	?>
	<div class=content_title>
		<h2>تيکت ها</h2>
	</div>
	<div class="content_content">
	
	<?php
		echo '<fieldset>
			<legend>جستجوی تیکت</legend>'.
				$form->input('tickets_search', array('id' => 'tickets_search', 'label' => 'عنوان تیکت'))
			.'</fieldset><br />';
    ?>
	
	<?php
	echo $html->link('فوری',array('controller' => 'managers' , 'action' => 'tickets'),array('class' => 'button'))
	.$html->link('عملياتی',array('controller' => 'managers' , 'action' => 'tickets' , 'inwork'),array('class' => 'button'))
	.$html->link('ارجاع شده به من',array('controller' => 'managers' , 'action' => 'tickets', 'flaged-to-me'),array('class' => 'button'))
	.$html->link('باز',array('controller' => 'managers' , 'action' => 'tickets' , 'open'),array('class' => 'button'))
	.$html->link('پاسخ داده شده',array('controller' => 'managers' , 'action' => 'tickets', 'answered'),array('class' => 'button'))
	.$html->link('پاسخ مشتری',array('controller' => 'managers' , 'action' => 'tickets', 'customer-reply'),array('class' => 'button'))
	.$html->link('در انتظار',array('controller' => 'managers' , 'action' => 'tickets', 'on-hold'),array('class' => 'button'))
	.$html->link('بررسی',array('controller' => 'managers' , 'action' => 'tickets', 'in-progress'),array('class' => 'button'))
	.$html->link('بسته',array('controller' => 'managers' , 'action' => 'tickets', 'closed'),array('class' => 'button'))
	.$html->link('سيستمی',array('controller' => 'managers' , 'action' => 'tickets', 'system-open'),array('class' => 'button'))
	.$html->link('ساير',array('controller' => 'managers' , 'action' => 'tickets', 'all'),array('class' => 'button'))
	.'<br /> <br />';
	
		  $paginator->options(array('url' => $this->passedArgs));
		  
	?>

	<table class="listTable" border="0">
		<thead>
			<tr>
				<th><?php echo $paginator->sort('کاربر', 'User.name'); ?></th>
				<th>عنوان</th>
				<th><?php echo $paginator->sort('تاریخ ثبت', 'Ticket.date'); ?></th>
				<th>آخرين تغيير</th>
				<th>اهميت</th>
				<th>وضعيت</th>
			</tr>
		</thead>
		<tbody id="TicketsContainer">
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
	</tbody>
	</table>
	
	<div align="center" class="paginate">
	<?php
		echo $paginator->prev('«قبلي   ', null, null, array('class' => 'disabled')).
			$paginator->next(' بعدي »', null, null, array('class' => 'disabled'));
	?>
	</div>
	
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
		<th>کاربر</th>
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
		if($ticket['Ticketreply'][count($ticket['Ticketreply'])-1]['date'] < (time()-864000) & $ticket['Ticket']['status'] < 5)
		{
			$link = $html->link('بسته شده', array('controller' => 'managers', 'action' => 'closeticket', 'id' => $ticket['Ticket']['id']));
			echo'<tr><td colspan="6">از آخرين تعيير بيش از 10 روز گذشته است. تيکت را به وضعيت '.$link.' تغيير دهيد.</td></tr>';
		}
		elseif(count($ticket['Ticketreply']) == 1)
		{
			$link = $html->link('حذف کنيد', array('controller' => 'managers', 'action' => 'deleteticket', 'id' => $ticket['Ticket']['id']),array('escape'=>false,'title' => 'حذف تيکت'),'آيا نسبت به حذف تيکت اطمينان داريد؟');
			echo'<tr><td colspan="6">در صورتی که تيکت به اشتباه باز شده آن را '.$link.'.</td></tr>';
		}
			?>
		</td>
		</tr>
	</table>
	
	<?php if($ticket['Ticket']['user_id'] == -1) {
		echo "<br />
		<fieldset>
		<legend>مشخصات ميهمان</legend>
			<b>نام و نام خانوادگی :  </b>
			".$message['Message']['name']."<br />
			<b>شماره تماس :</b>
			".$message['Message']['phone']."<br />
			<b>پست الکترونیک :</b>
			".$message['Message']['email']."<br />
			<b>شماره تيکت :</b>
			".$message['Message']['ticket_id']."<br />
			<b>آی پی :</b>
			".$message['Message']['ip']."<br />
		</fieldset>
		<br />";
	}
		foreach ( $ticketreplies as $ticketreply ) {
			if($ticketreply['Ticketreply']['user_id'] == 0){
				$ticketreply['User']['name'] = 'کاربر خودکار';
				$ticketreply['User']['company'] = $setting['name'];
			}
			elseif($ticketreply['Ticketreply']['user_id'] == -1){
				$ticketreply['User']['name'] = $message['Message']['name'];
				$ticketreply['User']['company'] = 'ميهمان';
			}
			if($ticketreply['Ticketreply']['note'] == 0){
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
					. $qoute->blockqoute($ticketreply['Ticketreply']['content'], $ticketreply['Ticketreply']['user_id']) 
					.'<br />'.$AttachedFile.'</div>
					<div class="clear"></div>
					';
			}
			else{
				echo '<div class="ticket-reply note">
						<div class="header">
							<div class="info"> <b>يادداشت توسط :</b> '.$ticketreply['User']['name'].(!empty($ticketreply['User']['company'])?' ('.$ticketreply['User']['company'].') ': '').'</div>
							<div class="date"> <b>تاريخ :</b> '. $jtime->pdate("Y/n/j - h:i a", $ticketreply['Ticketreply']['date']) .'</div>
							<div class="clear"></div>
						</div>'
					. $qoute->blockqoute($ticketreply['Ticketreply']['content'], $ticketreply['Ticketreply']['user_id']) 
					.'<br /></div>
					<div class="clear"></div>
					';
			}
		}
	?>
		</div>
		<div class="content_title">
			<h2>ارسال پاسخ برای تيکت</h2>
		</div>
		<div class="content_content">
			<?php
			echo $form->create('Ticketreply', array('url' => array('controller' => 'managers' ,'action' => 'postticketreply', 'id' => $ticket['Ticket']['id']), 'type' => 'file'))
				.$form->input('content')
				.$form->input('file', array('label' => 'فایل' ,'type' => 'file'))
				.$form->input('ticketdepartment_id',array('selected' => $ticket['Ticket']['ticketdepartment_id'],'options' =>$departments, 'empty' => 'بدون دپارتمان'))
				.$form->input('priority',array('selected' => $ticket['Ticket']['priority']))
				.$form->input('status')
				.$form->input('flag_user_id', array('selected' => $ticket['Ticket']['flag_user_id'], 'options' => $flag_users, 'empty' => 'بدون ارجاع'))
				.$form->submit(__('Submit Note',true),array('div'=>false, 'name' => 'data[Ticketreply][submitnote]')).' '
				.$form->end(array(__('Submit', true),'div' => false)).' (در صورت ثبت يادداشت ارجاع به، وضعيت، اهميت و دپارتمان تغيير نميکند)';
			?>
		</div>
		<div class="content_title">
			<h2>آخرين تيکت های مربوط به اين کاربر</h2>
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
				<?php if($user_ticket['Ticket']['user_id'] == -1) echo 'ميهمان'; else echo $link = $html->link($user_ticket['User']['name'], array('controller' => 'managers', 'action' => 'contact', 'id' => $user_ticket['User']['id'])); ?>
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
		
		</div>
	<?php
	  }
	?>