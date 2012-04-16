
<div class=content_title>
	<h2>مشتری های معرفی شده توسط <?php echo $referrer_client['User']['name']; if(!empty($referrer_client['User']['company'])) echo ' ('.$referrer_client['User']['company'].')';?><h2>
</div>

<div class=content_content >
	<table class="listTable"  border="0">
		<thead>
		<tr>
			<th>شماره مشتري</th>
			<th>نام مشتري</th>
			<th>نام شرکت</th>
			<th> وضعيت </th>
			<th>انتخاب ها</th>
		</tr>
		</thead>
		<tbody id="usersContainer">
		<?php foreach($client as $row){?>
		
		<tr>
			<td><?php echo $row['User']['id'];?></td>
			<td><?php echo $row['User']['name'];?></td>
			<td><?php echo $row['User']['company'];?></td>
			<td>
				<?php										
				if($row['User']['role']=='-1') 
					echo '<span style= "color : red;"><b>تاييد نشده</b></span>';
				else
					echo '<span style= "color : green;"><b>تاييد شده</b></span>';
				?>
			</td>
			<td><?php echo 
				$html->link($html->image('/img/icons/profile.png'), array('controller' => 'managers', 'action' => 'contact',$row['User']['id']),array('escape'=>false,'title' => 'مشخصات  مشتري')).
				$html->link($html->image('/img/icons/add.png'), array('controller' => 'managers', 'action' => 'add_order',$row['User']['id']),array('escape'=>false,'title' => 'افزودن سفارش')).
				$html->link($html->image('/img/icons/orders.png'), array('controller' => 'managers', 'action' => 'orders','user_orders',$row['User']['id']),array('escape'=>false,'title' => 'سفارشات')).
				$html->link($html->image('/img/icons/unconfirm.png'),array('controller' => 'managers', 'action' => 'user_delete',$row['User']['id']),array('escape'=>false,'title' => 'حذف کاربر'),'آیا مطمئنید می خواهید این کاربر را حذف کنید ؟');
				if($row['User']['role']=='-1')
				{
					echo	$html->link($html->image('/img/icons/confirm.png'), array('controller' => 'managers', 'action' => 'user_confirm',$row['User']['id']),array('escape'=>false,'title' => 'تایید کابر'),'آیا مطمئنید می خواهید این کاربر را تایید کنید؟ (بعد از تایید پست الکترونیکی به کاربر فرستاده می شود)');
				}
				if($row['User']['role']=='0')
					echo $html->link($html->image('/img/icons/pay.png'), array('controller'=>'managers','action'=>'add_transaction',$row['User']['id']),array('escape'=>false,'title' => 'افزودن اعتبار'));
			?></td>
		</tr>
		<?php } ?>
		</tbody>
	</table>
<div align="center" class="paginate">
<?php
	echo $paginator->prev('«قبلي   ', null, null, array('class' => 'disabled')).
		$paginator->next(' بعدي »', null, null, array('class' => 'disabled'));
?>
</div>
</div>
