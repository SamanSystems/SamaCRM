<div class="content_title">
	<h2>تراکنش ها</h2>
</div>
<div class="content_content">
	<?php 
		echo $html->link('تراکنش های تایید نشده', array('controller' => 'managers', 'action' => 'transactions', 'unconfirmed'),array('class' => 'button'))
			.$html->link('تراکنش های تایید شده', array('controller' => 'managers', 'action' => 'transactions', 'confirmed'),array('class' => 'button'))
			.$html->link('همه تراکنش ها', array('controller' => 'managers', 'action' => 'transactions'),array('class' => 'button'));
			
		$paginator->options(array('url' => $this->passedArgs));	
	?>
	<br /><br />
	<table border="0" class="listTable">
		<tr>
			<th><?php echo $paginator->sort('کاربر', 'User.name'); ?></th>
			<th><?php echo $paginator->sort('مبلغ', 'Transaction.amount'); ?></th>
			<th><?php echo $paginator->sort('تاریخ', 'Transaction.date'); ?></th>
			<th><?php echo $paginator->sort('توضيحات', 'Transaction.desc'); ?></th>
			<th><?php echo $paginator->sort('وضعیت', 'Transaction.confirmed'); ?></th>
			<th>انتخاب ها</th>
		</tr>
		<?php foreach ( $transactions as $row ) { ?>
		<tr>
			<td><?php echo $html->link($row['User']['name'], array('controller' => 'managers', 'action' => 'contact',$row['User']['id'])); ?></td>
			<td><?php echo $row['Transaction']['amount']; ?></td>
			<td><?php echo $jtime->pdate("Y/n/j", $row['Transaction']['date']); ?></td>
			<td><?php echo $row['Transaction']['desc']; ?><br /> <b>روش پرداخت:</b> <?php echo $row['Payment']['name']; ?></td>
			<td><?php if( $row['Transaction']['confirmed']==0)
						echo $html->image('/img/icons/verify.png',array( 'alt' => 'در انتظار تاييد' , 'title' =>'در انتظار تاييد' )).'<br />';
					else
						echo $html->image('/img/icons/confirmed.png',array( 'alt' => 'تایید شده ' , 'title'=>'تایید شده ')).'<br />';
					?></td>
			<td><?php
				echo $html->link($html->image('/img/icons/unconfirm.png'), array('controller' => 'managers', 'action' => 'transactions','delete' ,$row['Transaction']['id']),array('escape'=>false,'title' => 'رد'));
				echo ( $row['Transaction']['confirmed'] == 0 ) ? $html->link($html->image('/img/icons/confirm.png'), array('controller' => 'managers', 'action' => 'transactions','confirm',$row['Transaction']['id']),array('escape'=>false,'title' => 'تایید')) : ''; ?>
			</td>
		</tr>
		<?php } ?>
	</table>
	<div align="center" class="paginate">
	<?php

		echo $paginator->prev('«قبلي   ', null, null, array('class' => 'disabled')).
			$paginator->next(' بعدي »', null, null, array('class' => 'disabled'));
	?>
	</div>
</div>

