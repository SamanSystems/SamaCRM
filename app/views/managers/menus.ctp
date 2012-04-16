<div class="content_title">
	<h2>منوها</h2>
</div>
<div class="content_content">
	<table border="0" class="listTable">
		<tr>
			<th>نام</th>
			<th>آدرس</th>
			<th>انتخاب ها</th>
		</tr>
		<?php foreach ( $menus as $row ) { ?>
		<tr>
			<td><?php echo $row['Menu']['title']; ?></td>
			<td><?php echo $row['Menu']['link']; ?></td>
			<td><?php echo $html->link($html->image('/img/icons/unconfirm.png'), array('controller' => 'managers', 'action' => 'menus' ,$row['Menu']['id']),array('escape'=>false,'title' => 'حذف'))
						.$html->link($html->image('/img/icons/edit.png'), array('controller' => 'managers', 'action' => 'edit_menu' ,$row['Menu']['id']),array('escape'=>false,'title' => 'ویرایش')); ?></td>
		</tr>
		<?php } ?>
	</table>
	<p align="left"><?php echo $html->link('افزودن منو', array('controller'=>'managers','action'=>'add_menu'),array('class'=>'button')); ?></p>
</div>

