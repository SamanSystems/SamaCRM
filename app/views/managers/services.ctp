<div class="content_title">
	<h2>سرویس ها</h2>
</div>
<div class="content_content">
	<table border="0" class="listTable">
		<tr>
			<th>نام</th>
			<th>انتخاب ها</th>
		</tr>
		<?php foreach ( $services as $row ) { ?>
		<tr>
			<td><?php echo $row['Service']['name']; ?></td>
			<td><?php echo $html->link($html->image('/img/icons/unconfirm.png'), array('controller' => 'managers', 'action' => 'services' ,$row['Service']['id']),array('escape'=>false,'title' => 'حذف'))
							.$html->link($html->image('/img/icons/edit.png'), array('controller' => 'managers', 'action' => 'edit_service' ,$row['Service']['id']),array('escape'=>false,'title' => 'ویرایش'));
				?></td>
		</tr>
		<?php } ?>
	</table>
<p align="left"><?php echo $html->link('افزودن سرویس', array('controller'=>'managers','action'=>'add_service'),array('class'=>'button')); ?></p>
</div>

