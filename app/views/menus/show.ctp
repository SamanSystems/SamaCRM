<div class="content_title">
	<h2>منو</h2>
</div>
<div class="content_content">
	<table border="0" class="listTable">
		<tr>
			<th>نام</th>
			<th>انتخاب ها</th>
		</tr>
		<?php foreach ( $menus as $row ) { ?>
		<tr>
			<td><?php echo $row['Menu']['title']; ?></td>
			<td><?php echo $html->link('[حذف]', array('controller' => 'menus', 'action' => 'admin_index/'.$row['Menu']['id']))
						.$html->link('[ویرایش]', array('controller' => 'menus', 'action' => 'admin_edit/'.$row['Menu']['id'])); ?></td>
		</tr>
		<?php } ?>
	</table>
</div>

