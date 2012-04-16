<div class="content_title">
	<h2>دپارتمان ها</h2>
</div>
<div class="content_content">
	<table border="0" class="listTable">
		<tr>
			<th>نام</th>
			<th>انتخاب ها</th>
		</tr>
		<?php foreach ( $departments as $row ) { ?>
		<tr>
			<td><?php echo $row['Ticketdepartment']['name']; ?></td>
			<td><?php echo $html->link($html->image('/img/icons/unconfirm.png'), array('controller' => 'managers', 'action' => 'departments' ,$row['Ticketdepartment']['id']),array('escape'=>false,'title' => 'حذف'))
						.$html->link($html->image('/img/icons/edit.png'), array('controller' => 'managers', 'action' => 'edit_department' ,$row['Ticketdepartment']['id']),array('escape'=>false,'title' => 'ویرایش')); ?></td>
		</tr>
		<?php } ?>
	</table>
	<p align="left"><?php echo $html->link('افزودن دپارتمان', array('controller'=>'managers','action'=>'add_department'),array('class'=>'button')); ?></p>
</div>

