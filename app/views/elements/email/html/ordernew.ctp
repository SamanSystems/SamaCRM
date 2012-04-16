<div style="direction: rtl; text-align: right; font: 12px Tahoma, Arial;">
با سلام<br>
 سفارش شما به شماره <?php echo $info[0]['Order']['id'];?> ثبت گردید
 مشخصات محصول سفارش داده شده :
 <center><table border="1" >
	<tr>
		<td>
			نام سرویس
		</td>
		<td>
			نام محصول
		</td>
		<td>
			قیمت
		</td>
		<td>
			تاریخ سفارش 
		</td>
	</tr>
	<tr>
		<td>
			<?php echo $info[1]['Service']['name'];?>
		</td>
		<td>
			<?php echo $info[1]['Product']['name'];?>
		</td>
		<td>
			<?php echo $info[1]['Product']['cost'];?>
		</td>
		<td>
			<?php echo $jtime->pdate("Y/n/j", $info[0]['Order']['date']); ?>
		</td>
 </table></center>
<?php if(!isset($info[2])) {?>
برای نحوه پرداخت این سفارش با شما تماس  گرفته خواهد شد.
<?php } else{?>
اعتبار شما در حال حاضر  :
<?php echo $info[2]; }?>
</div>