<div class="content_title">
	<h2>مشتری ها</h2>
</div>
<div class="content_content">
	<table border="0" class="listTable">
		<tr>
			<th>نام</th>
			<th>آدرس</th>
			<th>انتخاب ها</th>
		</tr>
		<?php foreach ( $customers as $row ) { ?>
		<tr>
			<td><?php echo $row['Customer']['title']; ?></td>
			<td><?php echo $row['Customer']['link']; ?></td>
			<td><?php echo $html->link($html->image('/img/icons/unconfirm.png'), array('controller' => 'managers', 'action' => 'customers' ,$row['Customer']['id']),array('escape'=>false,'title' => 'حذف'))
						.$html->link($html->image('/img/icons/edit.png'), array('controller' => 'managers', 'action' => 'edit_customer' ,$row['Customer']['id']),array('escape'=>false,'title' => 'ویرایش')); ?></td>
		</tr>
		<?php } ?>
	</table>
	<p align="left"><?php echo $html->link('افزودن مشتری برتر', array('controller'=>'managers','action'=>'add_customer'),array('class'=>'button')); ?></p>
</div>

