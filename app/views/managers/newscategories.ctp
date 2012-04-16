<div class="content_title">
	<h2>شاخه های خبری</h2>
</div>
<div class="content_content">
	<table border="0" class="listTable">
		<tr>
			<th>نام</th>
			<th>انتخاب ها</th>
		</tr>
		<?php foreach ( $newscategories as $row ) { ?>
		<tr>
			<td><?php echo $row['Newscategory']['name']; ?></td>
			<td><?php echo $html->link($html->image('/img/icons/unconfirm.png'), array('controller' => 'managers', 'action' => 'newscategories' ,$row['Newscategory']['id']),array('escape'=>false,'title' => 'حذف'))
						.$html->link($html->image('/img/icons/edit.png'), array('controller' => 'managers', 'action' => 'edit_newscategory' ,$row['Newscategory']['id']),array('escape'=>false,'title' => 'ویرایش')); ?></td>
		</tr>
		<?php } ?>
	</table>
	<p align="left"><?php echo $html->link('افزودن شاخه جديد', array('controller'=>'managers','action'=>'add_newscategory'),array('class'=>'button')); ?></p>
</div>

