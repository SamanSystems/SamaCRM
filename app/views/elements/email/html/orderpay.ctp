<div style="direction: rtl; text-align: right; font: 12px Tahoma, Arial;">
با سلام<br>
 سفارش شما به شماره <?php echo $info[0]['Order']['id'];?>پرداخت شد
 مشخصات محصول پرداخت شده :
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
		<td>
			تاریخ پرداخت بعدی 
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
		<td>
			<?php echo $jtime->pdate("Y/n/j", $info[0]['Order']['next_pay']); ?>
		</td>
 </table></center>

اعتبار شما در حال حاضر  :
<?php echo $info[2];?>
</div>