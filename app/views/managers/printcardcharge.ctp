		<h1> بسمه تعالی </h1>
		<br />
<table class="printcardcharge" border="1" dir="rtl" cellspacing="0">
	<tr>
		<td>بارکد کارت: </td>
		<td><?php echo $cardinfo[Cardcharge][start_date].$cardinfo[Cardcharge][id]; ?></td>
	</tr>
	<tr>
		<td>شماره کارت: </td>
		<td><?php echo $cardinfo[Cardcharge][id]; ?></td>
	</tr>
	<tr>
		<td>رمز کارت: </td>
		<td><?php echo $cardinfo[Cardcharge][security_code]; ?></td>
	</tr>
	<tr>
		<td>اعتبار کارت: </td>
		<td><?php echo $cardinfo[Cardcharge][credit]; ?></td>
	</tr>
</table>


		<?php echo '<div class="company">مديريت فروش شرکت '.$settings['Setting']['name'].'</div>';?>