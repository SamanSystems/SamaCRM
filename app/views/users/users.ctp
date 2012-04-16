
	<div class=content_title>
		<h2>مشتری ها<h2>
	</div>

	<div class=content_content>
		<table class="listTable" border="0">
			<tr>
				<th>شماره مشتری</th>
				<th>نام مشتری</th>
				<th>نام شرکت</th>
				<th>انتخاب ها</th>
			</tr>
			<?php foreach($client as $row){?>
			
			<tr>
				<td><?php echo $row['User']['id'];?></td>
				<td><?php echo $row['User']['name'];?></td>
				<td><?php echo $row['User']['company'];?></td>
				<td><?php 
						
							echo 
								$html->link($html->image('/img/icons/profile.png'), array('controller' => 'managers', 'action' => 'contact',$row['User']['id']),array('escape'=>false,'title' => 'مشخصات  مشتری')).
						if($row['User']['role']!='-1')
						{
							echo	
								$html->link($html->image('/img/icons/add.png'), array('controller' => 'managers', 'action' => 'add_order',$row['User']['id']),array('escape'=>false,'title' => 'افزودن سفارش')).
								$html->link($html->image('/img/icons/orders.png'), array('controller' => 'managers', 'action' => 'orders','user_orders',$row['User']['id']),array('escape'=>false,'title' => 'سفارشات'));
						}else
						{
								echo	
								$html->link($html->image('/img/icons/check.png'), array('controller' => 'managers', 'action' => 'user_confirm',$row['User']['id']),array('escape'=>false,'title' => 'تایید مشتری'));
						}
						
		
						?></td>
			</tr>
			<?php } ?>
		</table>
	<div align="center" class="paginate">
	<?php
		echo $paginator->prev('«قبلی   ', null, null, array('class' => 'disabled')).
			$paginator->next(' بعدی »', null, null, array('class' => 'disabled'));
	?>
	</div>
	</div>



