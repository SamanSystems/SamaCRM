<div class="content_title">
	<h2>روش های پرداخت</h2>
</div>
<div class="content_content">
	<table border="0" class="listTable">
		<tr>
			<th>نام</th>
			<th>توضيحات</th>
			<th>انتخاب ها</th>
		</tr>
		<?php foreach ( $payments as $row ) { ?>
		<tr>
			<td><?php echo $row['Payment']['name']; ?></td>
			<td><?php echo $row['Payment']['desc']; ?></td>
			<td><?php echo $html->link($html->image('/img/icons/unconfirm.png'), array('controller' => 'managers', 'action' => 'payments' ,$row['Payment']['id']),array('escape'=>false,'title' => 'حذف'))
						.$html->link($html->image('/img/icons/edit.png'), array('controller' => 'managers', 'action' => 'edit_payment' ,$row['Payment']['id']),array('escape'=>false,'title' => 'ویرایش')); 
				?></td>
		</tr>
		<?php } ?>
	</table>
	<p align="left"><?php echo $html->link('افزودن روش پرداخت', array('controller'=>'managers','action'=>'add_payment'),array('class'=>'button')); ?></p>
</div>

