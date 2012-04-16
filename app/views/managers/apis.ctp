<div class="content_title">
	<h2>رابط API</h2>
</div>
<div class="content_content">
	<table border="0" class="listTable">
		<tr>
			<th>عنوان</th>
			<th>نام رابط</th>
			<th>انتخاب ها</th>
		</tr>
		<?php foreach ( $data as $row ) { ?>
		<tr>
			<td><?php echo $row['Api']['name']; ?></td>
			<td><?php echo $row['Api']['component_name']; ?></td>
			<td><?php echo $html->link($html->image('/img/icons/edit.png'), array('controller' => 'managers', 'action' => 'api_edit' ,$row['Api']['id']),array('escape'=>false,'title' => 'ویرایش'))
							.$html->link($html->image('/img/icons/unconfirm.png'), array('controller' => 'managers', 'action' => 'apis' ,$row['Api']['id']),array('escape'=>false,'title' => 'حذف'));
				?></td>
		</tr>
		<?php } ?>
	</table>
<p align="left"><?php echo $html->link('افزودن API', array('controller'=>'managers','action'=>'api_add'),array('class'=>'button')); ?></p>
</div>

