<div class="content_title">
	<h2>محصولات</h2>
</div>
<div class="content_content">
	<table border="0" class="listTable">
		<tr>
			<th>نام</th>
			<th>سرویس</th>
			<th>انتخاب ها</th>
		</tr>
		<?php foreach ( $products as $row ) { ?>
		<tr>
			<td><?php echo $row['Product']['name']; ?></td>
			<td><?php echo $row['Service']['name']; ?></td>
			<td><?php echo 
						$html->link($html->image('/img/icons/unconfirm.png'), array('controller' => 'managers', 'action' => 'products' ,$row['Product']['id']),array('escape'=>false,'title' => 'حذف')).
						$html->link($html->image('/img/icons/edit.png'), array('controller' => 'managers', 'action' => 'edit_product' ,$row['Product']['id']),array('escape'=>false,'title' => 'ویرایش')); ?></td>
		</tr>
		<?php } ?>
	</table>
<p align="left"><?php echo $html->link('افزودن محصول', array('controller'=>'managers','action'=>'add_product'),array('class'=>'button')); ?></p>
<div align="center" class="paginate">
<?php
	echo $paginator->prev('«قبلي   ', null, null, array('class' => 'disabled')).
		$paginator->next(' بعدي »', null, null, array('class' => 'disabled'));
?>
</div>
</div>

