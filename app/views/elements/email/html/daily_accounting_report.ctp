<?php
foreach($total as $key => $tot){
		if(empty($tot)) $total[$key] = 0;
}
?>
<div style="direction: rtl; text-align: right; font: 12px Tahoma, Arial;">
با سلام<br />
گزارش تراکنش های روز <?php echo $jtime->pdate("Y/n/j", $date); ?> ارسال شد.
<br /><br />
 <center><table class="ticketTable" style="border: 1px solid #CCCCCC; width: 95%; font: 12px Tahoma, Arial;">
	<tr>
		<td style="text-align: center; width: 20%; background: #ccc; padding: 5px;">
			مجموع تراکنش های ورودی پاسارگاد
		</td>
		<td style="padding: 5px; text-align: right;">
			<?php echo $total['yesterday_insystem_pasargad'];?> تومان
		</td>
	</tr>
	<tr>
		<td style="text-align: center; padding: 5px; background: #ccc;">
			مجموع تراکنش های ورودی زرين پال
		</td>
		<td style="padding: 5px; text-align: right;">
			<?php echo $total['yesterday_insystem_zarinpal'];?> تومان
		</td>
	</tr>
		</table></center>
</div>