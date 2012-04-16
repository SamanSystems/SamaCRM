
<div class=content_title>
	<h2>سفارشات</h2>
</div>
<div class=content_content>
	<?php
		echo 
			 $html->link('تایید شده',array('controller' => 'managers' , 'action' => 'orders' , 'confirmed'),array('class' => 'button'))
			.$html->link('تایید نشده',array('controller' => 'managers' , 'action' => 'orders', 'unconfirmed'),array('class' => 'button'))
			.$html->link('پیش سفارش', array('controller' => 'managers' , 'action' => 'orders', 'before'),array('class' => 'button'))
			.$html->link('منقضی',array('controller' => 'managers' , 'action'=>'orders', 'expired'),array('class' => 'button'))
			.$html->link('در حال انقضا',array('controller' => 'managers' , 'action'=>'orders', 'near_elapsed'),array('class' => 'button'))
			.$html->link('همه',array('controller' => 'managers' , 'action'=>'orders'),array('class' => 'button'))
			.'<br /> <br />';
			
		$paginator->options(array('url' => $this->passedArgs));

	if(isset($user_order))
	{
		echo '<form id="invoiceAddForm" action="/managers/invoice" method="post">';
	}?>
	<table class="listTable" border="0">
		<tr>
			<?php if(isset($user_order))
				echo '<th></th>';
			?>
			<th><?php echo $paginator->sort('شماره سفارش', 'Order.id'); ?></th>
			<th><?php echo $paginator->sort('سرویس', 'Product.name'); ?></th>
			<th><?php echo $paginator->sort('تاریخ ثبت', 'Order.date'); ?></th>
			<th><?php echo $paginator->sort('پرداخت بعدی', 'Order.next_pay'); ?></th>
			<th>توضیحات</th>
			<th>انتخاب ها</th>
		</tr>
	<?php
		foreach ( $orders as $order ) {

	
	?>
		<tr>
			<?php if(isset($user_order))
				echo '<td><input name="data[invoice][order_id][]" type="checkbox"  value="'. $order['Order']['id'].'" /></td>';
			?>
			<td><?php echo $order['Order']['id']; ?></td>
			<td><?php echo $order['Product']['Service']['name'].'  <b /><b>'.$order['Product']['name'].'</b>'; ?></td>
			<td><?php echo $jtime->pdate("Y/n/j", $order['Order']['date']); ?></td>
			<td><?php
					if($order['Order']['next_pay']!=0)
					{
						echo $jtime->pdate("Y/n/j", $order['Order']['next_pay']); 
					}else
					{
						echo ' ';
					}
					?></td>
			<td><?php
						
						if($order['Order']['confirmed']==-1)
						{
							echo $html->image('/img/icons/expired.png',array('title'=>' وضعیت : منقضی ', 'alt' =>' وضعیت : منقضی ')).'<br />';
						}else if($order['Order']['confirmed']==0)
						{
							echo $html->image('/img/icons/preorder.png',array('title'=>' وضعیت : پیش سفارش ', 'alt' =>'وضعیت : پیش سفارش')).'<br />';
						}else if($order['Order']['confirmed']==1)
						{
							echo $html->image('/img/icons/verify.png',array('title'=>'وضعیت : تایید نشده ' , 'alt' =>'وضعیت : تایید نشده')).'<br />';
						}else if($order['Order']['confirmed']==2)
						{		
							echo $html->image('/img/icons/confirmed.png',array('title'=>' وضعیت : تایید شده' , 'alt' => 'وضعیت : تایید شده')).'<br />';
		
						}
						 echo $order['Order']['desc']; 
						?></td>
			<td>
				<?php 
						echo $html->link($html->image('/img/icons/profile.png'), array('controller' => 'managers', 'action' => 'contact', $order['Order']['user_id']),array('escape'=>false,'title' => 'مشخصات  مشتری'))
							.$html->link($html->image('/img/icons/edit.png'), array('controller' => 'managers', 'action' => 'edit_order', $order['Order']['id']),array('title'=>'ویرایش سفارش','escape'=>false));
						if($order['Order']['confirmed']== 0)
							echo 
								$html->link($html->image('/img/icons/unconfirm.png'), array('controller' => 'managers', 'action' => 'orders/delete', 'id' => $order['Order']['id']),array('title'=>'رد','escape'=>false));
						elseif($order['Order']['confirmed']==1)
							echo 
								$html->link($html->image('/img/icons/confirm.png'), array('controller' => 'managers' ,'action'=> 'order_confirm',$order['Order']['id']),array('title'=>'تایید','escape'=>false));
						elseif($order['Order']['confirmed']==2)	
							echo 
								$html->link($html->image('/img/icons/unconfirm.png'), array('controller' => 'managers', 'action' => 'orders/delete', 'id' => $order['Order']['id']),array('title'=>'حذف','escape'=>false)).
									 $html->link($html->image('/img/icons/invoice.png'), array('controller' => 'managers', 'action' => 'invoice', 'id'=>$order['Order']['id']),array('title'=>'فاکتور','escape'=>false,'class'=>'newPage'));
						
				?>
			</td>
		</tr>
	<?php } ?>
	</table>
	<?php
		if(isset($user_order))
			echo '<br/><br/>'.$form->end('گرفتن فاکتور');
	?>
	
	<div align="center" class="paginate">
	<?php
		echo $paginator->prev('«قبلي   ', null, null, array('class' => 'disabled')).
			$paginator->next(' بعدي »', null, null, array('class' => 'disabled'));
	?>
	</div>
</div>