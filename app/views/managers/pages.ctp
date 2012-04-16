<div class="content_title">
	<h2>صفحات</h2>
</div>
<div class="content_content">
	<table border="0" class="listTable">
		<tr>
			<th>نام</th>
			<th>انتخاب ها</th>
		</tr>
		<?php foreach ( $pages as $row ) { ?>
		<tr>
			<td><?php echo $row['Page']['title']; ?></td>
			<td><?php echo $html->link($html->image('/img/icons/unconfirm.png'), array('controller' => 'managers', 'action' => 'pages' ,$row['Page']['id']),array('escape'=>false,'title' => 'حذف'))
						.$html->link($html->image('/img/icons/edit.png'), array('controller' => 'managers', 'action' => 'edit_page' ,$row['Page']['id']),array('escape'=>false,'title' => 'ویرایش')); ?></td>
		</tr>
		<?php } ?>
	</table>
	<p align="left"><?php echo $html->link('افزودن صفحه جديد', array('controller'=>'managers','action'=>'add_page'),array('class'=>'button')); ?></p>
</div>

