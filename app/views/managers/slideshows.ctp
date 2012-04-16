<div class="content_title">
	<h2>تصاوير کشويي</h2>
</div>
<div class="content_content">
	<table border="0" class="listTable">
		<tr>
			<th>عنوان</th>
			<th>انتخاب ها</th>
		</tr>
		<?php foreach ( $slideshows as $row ) { ?>
		<tr>
			<td><?php echo $row['Slideshow']['title']; ?></td>
			<td><?php echo $html->link($html->image('/img/icons/unconfirm.png'), array('controller' => 'managers', 'action' => 'slideshows' ,$row['Slideshow']['id']),array('escape'=>false,'title' => 'حذف'))
							.$html->link($html->image('/img/icons/edit.png'), array('controller' => 'managers', 'action' => 'edit_slideshow' ,$row['Slideshow']['id']),array('escape'=>false,'title' => 'ویرایش')); ?></td>
		</tr>
		<?php } ?>
	</table>
	<p align="left"><?php echo $html->link('افزودن تصوير کشويی', array('controller'=>'managers','action'=>'add_slideshow'),array('class'=>'button')); ?></p>
</div>