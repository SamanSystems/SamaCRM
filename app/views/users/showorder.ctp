<div class=content_title>
	<h2>سفارشات مرتبط با سفارش <?php echo $top_order['Order']['id']; ?></h2>
</div>
<div class="content_content">
	<table class="listTable" border="0">
	
		<tr>
			<th>شماره سفارش</th>
			<th>محصول</th>
			<th>تاریخ ثبت</th>
			<th>پرداخت بعدی</th>
			<th>قیمت</th>
			<th>توضیحات</th>
			<th>انتخاب</th>
		</tr>		<tr>			<td><?php echo $top_order['Order']['id']; ?> </td>			<td><?php echo $top_order['Product']['Service']['name'].'<br /><b>'.$top_order['Product']['name'].'</b>'; ?></td>			<td><?php echo $jtime->pdate("Y/n/j", $top_order['Order']['date']); ?></td>			<td><?php if($top_order['Order']['confirmed']!=0)						echo $jtime->pdate("Y/n/j", $top_order['Order']['next_pay']);?></td>			<td><?php echo $top_order['Product']['cost']-$top_order['Order']['discount']; ?></td>			<td><?php							if($top_order['Order']['confirmed']==-1)						{							echo $html->image('/img/icons/expired.png',array('title'=>' وضعیت : منقضی ', 'alt' =>' وضعیت : منقضی ')).'<br />';						}else if($top_order['Order']['confirmed']==0)						{							echo $html->image('/img/icons/preorder.png',array('title'=>'وضعیت : پیش سفارش', 'alt' => ' پیش سفارش')).'<br />';						}else if($top_order['Order']['confirmed']==1)						{							echo $html->image('/img/icons/verify.png',array('title'=>'وضعیت : در انتظار تاييد' , 'alt' => 'تایید نشده')).'<br />';						}else if($top_order['Order']['confirmed']==2)						{							echo $html->image('/img/icons/confirmed.png',array('title'=>'وضعیت : تایید شده' , 'alt' => 'تایید شده ')).'<br />';						}						echo $top_order['Order']['desc'];						?></td>			<td><?php 										if($top_order['Order']['confirmed'] <= 0 )						echo $html->link($html->image('/img/icons/pay.png'),array('controller'=>'users' , 'action' => 'reneworder',$top_order['Order']['id']),array('escape'=>false , 'title' => ' پرداخت'),'آیا نسبت به پرداخت سفارش مطمئن هستید ؟');					elseif($top_order['Order']['confirmed']==2)					{						echo $html->link($html->image('/img/icons/pay.png'),array('controller'=>'users' , 'action' => 'reneworder',$top_order['Order']['id']),array('escape'=>false , 'title' =>'تمدید سرویس'),'آیا نسبت به تمدید سفارش مطمئن هستید ؟');						echo $html->link($html->image('/img/icons/invoice.png'),array('controller' => 'users' , 'action' => 'invoice',$top_order['Order']['id']), array( 'class'=>'newPage','escape' => false ,'title'=>'فاکتور'));					}				?>			</td>							</tr>
	
	<?php

		foreach ( $in_order as $order ) {
	?>
	
		<tr>
			<td><?php echo $order['Order']['id']; ?> </td>
			<td><?php echo $order['Product']['Service']['name'].'<br /><b>'.$order['Product']['name'].'</b>'; ?></td>
			<td><?php echo $jtime->pdate("Y/n/j", $order['Order']['date']); ?></td>
			<td><?php if($order['Order']['confirmed']!=0)
						echo $jtime->pdate("Y/n/j", $order['Order']['next_pay']);?></td>
			<td><?php echo $order['Product']['cost']-$order['Order']['discount']; ?></td>
			<td><?php	
						if($order['Order']['confirmed']==-1)
						{
							echo $html->image('/img/icons/expired.png',array('title'=>' وضعیت : منقضی ', 'alt' =>' وضعیت : منقضی ')).'<br />';
						}else if($order['Order']['confirmed']==0)
						{
							echo $html->image('/img/icons/preorder.png',array('title'=>'وضعیت : پیش سفارش', 'alt' => ' پیش سفارش')).'<br />';
						}else if($order['Order']['confirmed']==1)
						{
							echo $html->image('/img/icons/verify.png',array('title'=>'وضعیت : در انتظار تاييد' , 'alt' => 'تایید نشده')).'<br />';
						}else if($order['Order']['confirmed']==2)
						{
							echo $html->image('/img/icons/confirmed.png',array('title'=>'وضعیت : تایید شده' , 'alt' => 'تایید شده ')).'<br />';
						}
						echo $order['Order']['desc'];
						?></td>
			<td><?php 
					
					if($order['Order']['confirmed'] <= 0 )
						echo $html->link($html->image('/img/icons/pay.png'),array('controller'=>'users' , 'action' => 'reneworder',$order['Order']['id']),array('escape'=>false , 'title' => ' پرداخت'),'آیا نسبت به پرداخت سفارش مطمئن هستید ؟');
					elseif($order['Order']['confirmed']==2)
						echo $html->link($html->image('/img/icons/pay.png'),array('controller'=>'users' , 'action' => 'reneworder',$order['Order']['id']),array('escape'=>false , 'title' =>'تمدید سرویس'),'آیا نسبت به تمدید سفارش مطمئن هستید ؟');
				?>
			</td>
					
		</tr>
	<?php } ?>
	
	</table>
</div>