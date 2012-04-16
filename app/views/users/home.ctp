<?php

echo '<div class="content_title">
		<h2>محيط کاربري</h2>
</div>';

if(empty($total['confirmed'])) $total['confirmed'] = 0;
if(empty($total['unconfirmed'])) $total['unconfirmed'] = 0;
if(empty($total['credit'])) $total['credit'] = 0;

$total['total']=$total['unconfirmed']+$total['confirmed'];

echo '
<div class="content_content">
	<center>
	<table border="0" width="99%" cellpadding="5" style="border: 1px solid #dfdfdf" cellspacing="0">
		<tr>
			<td bgcolor="#e0e0e0" width="50%" style="border-bottom: 1px solid #dfdfdf">کل مبلغ تراکنشهای تایید شده:</td>
			<td style="border-bottom: 1px solid #dfdfdf"><b>'. $total['confirmed'] .' تومان</b></td>
		</tr>
		<tr>
			<td bgcolor="#e0e0e0" style="border-bottom: 1px solid #dfdfdf">کل مبلغ تراکنش های تایید نشده:</td>
			<td style="border-bottom: 1px solid #dfdfdf"><b>'.$total['unconfirmed'].' تومان</b></td>
		</tr>
		<tr>
			<td bgcolor="#e0e0e0">اعتبار حساب شما:</td>
			<td style="border-bottom: 1px solid #dfdfdf"><b>'. $total['credit'] .' تومان</b></td>	
		</tr>
		<tr>
			<td bgcolor="#e0e0e0">گردش کلی حساب شما:</td>
			<td style="border-bottom: 1px solid #dfdfdf"><b>'. $total['total'] .' تومان</b></td>	
		</tr>';
		if(!empty($top_user['User']['name'])){
			echo'<tr>
			<td bgcolor="#e0e0e0">کاربر معرفی کننده شما:</td>
			<td style="border-bottom: 1px solid #dfdfdf"><b>'. $top_user['User']['name'];
			if(!empty($top_user['User']['company']))
				echo ' ('.$top_user['User']['company'].')';
			echo '</b></td>	
		</tr>';
		}
		echo '<tr>
			<td bgcolor="#e0e0e0">تعداد کاربران معرفی شده توسط شما:</td>
			<td><b>'. $total['referred_users'] .'</b></td>	
		</tr>
	</table>
	<br/>
	<br/>
	
	<table border="0" width="99%" cellpadding="5" style="border: 1px solid #dfdfdf" cellspacing="0">
		<tr>
			<td bgcolor="#e0e0e0" width="50%" style="border-bottom: 1px solid #dfdfdf">سفارشات تایید شده :</td>
			<td style="border-bottom: 1px solid #dfdfdf"><b>'.$orders['confirmed'].'</b></td></tr>
			<tr>
			<td bgcolor="#e0e0e0">سفارشات تایید نشده:</td>
			<td style="border-bottom: 1px solid #dfdfdf"><b>'.$orders['unconfirmed'].'</b></td></tr>
			<tr>
			<td bgcolor="#e0e0e0">پیش سفارش:</td>
			<td><b>'.$orders['before'].'</b></td></tr>
	</table>
	<br/>
	<br/>

	<table border="0" width="99%" cellpadding="5" style="border: 1px solid #dfdfdf" cellspacing="0">
		<tr>
			<td bgcolor="#e0e0e0" width="50%" style="border-bottom: 1px solid #dfdfdf">تيکت های خوانده نشده:</td>
			<td style="border-bottom: 1px solid #dfdfdf"><b>'.$tickets['unread'].'</b></td></tr>
			<tr>
			<td bgcolor="#e0e0e0" width="50%" style="border-bottom: 1px solid #dfdfdf">تيکت های باز:</td>
			<td style="border-bottom: 1px solid #dfdfdf"><b>'.$tickets['open'].'</b></td></tr>
			<tr>
			<td bgcolor="#e0e0e0">تيکت های پاسخ داده شده:</td>
			<td style="border-bottom: 1px solid #dfdfdf"><b>'.$tickets['areply'].'</b></td></tr>
			<tr>
			<td bgcolor="#e0e0e0">تيکت های در انتظار و در دست برسی:</td>
			<td><b>'.$tickets['inporonh'].'</b></td></tr>
	</table>
	</center>
</div>';
?>