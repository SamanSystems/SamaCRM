<div class="content_title">
	<h2>اخبار</h2>
</div>
<div class="content_content">
	<table border="0" class="listTable">
		<tr>
			<th>نام</th>
			<th>انتخاب ها</th>
		</tr>
		<?php foreach ( $news as $row ) { ?>
		<tr>
			<td><?php echo $row['News']['title']; ?></td>
			<td><?php echo $html->link($html->image('/img/icons/unconfirm.png'), array('controller' => 'managers', 'action' => 'news' ,$row['News']['id']),array('escape'=>false,'title' => 'حذف'))
						.$html->link($html->image('/img/icons/edit.png'), array('controller' => 'managers', 'action' => 'edit_news' ,$row['News']['id']),array('escape'=>false,'title' => 'ویرایش')); ?></td>
		</tr>
		<?php } ?>
	</table>
	<p align="left"><?php echo $html->link('افزودن خبر جديد', array('controller'=>'managers','action'=>'add_news'),array('class'=>'button')); ?></p>
</div>

