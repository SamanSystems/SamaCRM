		<h1> بسمه تعالی </h1>
		<br />
<table class="invoice" border="1" dir="rtl" cellspacing="0">
	<tr>
		<td colspan="6" style="text-align:right"><?php
														
									echo '<b>فاکتور آقای/خانم :</b>'.$client['User']['name'];
									if(!empty($client['User']['company']))
									{
										echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>نماینده شرکت :</b>'.$client['User']['company'];
									}
									if(!empty($client['User']['address']))
									{
										echo '<br /> <b>آدرس</b> :'.$client['User']['address'];
									}
									if(!empty($client['User']['phonenum']))
									{
										echo '<br /><b> تلفن :</b>'.$client['User']['phonenum'];
									}
									
							?></td>
	</tr>
	<tr style="background-color: gray; color: white">
		<td width="1%">شماره سفارش</td>
		<td>تاریخ سفارش</td>
		<td>شرح</td>
		<td>توضیحات</td>
		<td>قیمت (تومان)</td>
	</tr>
	
	<?php
	
	foreach($info as $row){ ?>
	<tr>
		<td><?php echo $row['Order']['id']; ?></td>
		<td><?php echo $jtime->pdate('d M Y',$row['Order']['date']); ?></td>
		<td><?php echo $row['Product']['Service']['name'].'<br /><b>'.$row['Product']['name'].'</b>'; ?></td>
		<td><?php echo $row['Order']['desc']; ?></td>
		<td><?php echo $row['Product']['cost'];?></td>
	</tr>
	<?php } ?>
	<tr>
		<td colspan="4" style="border-right: 0px; border-bottom: 0px;"> </td>
		<td>مبلغ کل (تومان) :</td>
		<td><?php
			foreach ($info as $row)
			{
				$temp +=$row['Product']['cost']-$row['Order']['discount']; 
			}
			echo $temp;
			?></td>
	</tr>
	<tr>
		<td colspan="6"><b>تاريخ پرداخت بعدی:</b> <?php echo $jtime->pdate('d M Y',$info['Order']['next_pay']); ?></td>
	</tr>
</table>


		<?php echo '<div class="company">مديريت فروش شرکت '.$settings['Setting']['name'].'</div>';?>