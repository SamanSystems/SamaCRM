
<div class=content_title>
	<h2>مشتري ها</h2>
</div>

<div class=content_content >
 <?php echo $html->link('کاربران در انتظار تاييد',array('controller' => 'managers' , 'action' => 'users' , 'unconfirmed'),array('class' => 'button')).
	   $html->link('تمامي کاربران',array('controller' => 'managers' , 'action' => 'users' , 'all'),array('class' => 'button'));
	echo '<fieldset>
		<legend>جستجوی کاربران</legend>'.
		$form->input('user_search', array('id' => 'user_search', 'label' => 'نام مشتری'))
		.'</fieldset>';
       ?>
	<table class="listTable" border="0">
		<thead>
		<tr>
			<th>شماره مشتري</th>
			<th>نام مشتري</th>
			<th>نام شرکت</th>
			<th> نقش </th>
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
				switch ($row['User']['role']) {
					case -1:
					    echo '<span style= "color : red;"><b>تاييد نشده</b></span>';
					    break;
					case 0:
					    echo '<span style= "color : green;"><b>مشتري</b></span>';
					    break;
					case 1:
					    echo '<span style= "color:orange;"><b>اپراتور وبسايت</b></span>';
					    break;
					case 2:
					    echo '<span style= "color:orange;"><b>فروش و مالی</b></span>';
					    break;
					case 3:
					    echo '<span style= "color:orange;"><b>پشتيبانی</b></span>';
					    break;
					case 4:
					    echo '<span style= "color:orange;"><b>مديرکل</b></span>';
					    break;
				}					
				?>
			</td>
			<td><?php echo 
				$html->link($html->image('/img/icons/profile.png'), array('controller' => 'managers', 'action' => 'contact',$row['User']['id']),array('escape'=>false,'title' => 'مشخصات  مشتري')).
				$html->link($html->image('/img/icons/add.png'), array('controller' => 'managers', 'action' => 'add_order',$row['User']['id']),array('escape'=>false,'title' => 'افزودن سفارش')).
				$html->link($html->image('/img/icons/orders.png'), array('controller' => 'managers', 'action' => 'orders','user_orders',$row['User']['id']),array('escape'=>false,'title' => 'سفارشات')).
				$html->link($html->image('/img/icons/unconfirm.png'),array('controller' => 'managers', 'action' => 'user_delete',$row['User']['id']),array('escape'=>false,'title' => 'حذف کاربر'),'آیا مطمئنید می خواهید این کاربر را حذف کنید ؟');
				if($row['User']['role']=='-1')
				{
					echo $html->link($html->image('/img/icons/confirm.png'), array('controller' => 'managers', 'action' => 'user_confirm',$row['User']['id']),array('escape'=>false,'title' => 'تایید کابر'),'آیا مطمئنید می خواهید این کاربر را تایید کنید؟ (بعد از تایید پست الکترونیکی به کاربر فرستاده می شود)');
				}
				if($row['User']['role']=='0')
					echo $html->link($html->image('/img/icons/pay.png'), array('controller'=>'managers','action'=>'add_transaction',$row['User']['id']),array('escape'=>false,'title' => 'افزودن اعتبار'));
			?></td>
		</tr>
		<?php } ?>
		</tbody>
	</table>
<p align="left"><?php echo $html->link('افزودن کاربر جديد', array('controller'=>'managers','action'=>'register'),array('class'=>'button')); ?></p>

	<div class="paginate">
			<?php
				$paginator->options(array('url' => $this->passedArgs));
				echo $paginator->numbers(array('tag'=> 'span', 'separator' => '', 'first' => 'صفحه اول »', 'last' => '« صفحه آخر'));
			?>
	</div>
	<div class="clear"> </div>

</div>
