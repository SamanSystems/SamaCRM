<?php

echo '<div class="content_title">
		<h2>مديريت سيستم</h2>
</div>';

echo '
<div class="content_content">
	<center>
	<table border="0" width="99%" cellpadding="5" style="border: 1px solid #dfdfdf" cellspacing="0">
		<tr>
			<td bgcolor="#e0e0e0" style="border-bottom: 1px solid #dfdfdf; width: 50%;">کل مبلغ تراکنش های در انتظار تاييد</td>
			<td style="border-bottom: 1px solid #dfdfdf"><b>';
			if(empty($total['transaction_unconfirmed_amount']))
				$total['transaction_unconfirmed_amount']=0;
			echo $total['transaction_unconfirmed_amount'].
		' تومان</b></td>
		</tr>
		<tr>
			<td bgcolor="#e0e0e0" style="border-bottom: 1px solid #dfdfdf">تراکنش های در انتظار تاييد</td>
			<td style="border-bottom: 1px solid #dfdfdf"><b>'.$total['transaction_unconfirmed_total'].'</b></td>
		</tr>
		<tr>
			<td bgcolor="#e0e0e0" style="border-bottom: 1px solid #dfdfdf">کوپن شارژ های ثبت شده و چک نشده</td>
			<td style="border-bottom: 1px solid #dfdfdf"><b>'.$total['notchecked_cardcharge'].'</b></td>
		</tr>
		<tr>
			<td bgcolor="#e0e0e0" style="border-bottom: 1px solid #dfdfdf">پيش سفارشات</td>
			<td style="border-bottom: 1px solid #dfdfdf"><b>'.$total['order_pre'].'</b></td>
		</tr>
		<tr>
			<td bgcolor="#e0e0e0" style="border-bottom: 1px solid #dfdfdf">سفارشات در انتظار تاييد</td>
			<td style="border-bottom: 1px solid #dfdfdf"><b>'.$total['order_confirmed'].'</b></td>
		</tr>
		<tr>
			<td bgcolor="#e0e0e0" style="border-bottom: 1px solid #dfdfdf">سفارشات در حال انقضا</td>
			<td style="border-bottom: 1px solid #dfdfdf"><b>'.$total['near_elapsed'].'</b></td>
		</tr>
		<tr>
			<td bgcolor="#e0e0e0" style="border-bottom: 1px solid #dfdfdf">سفارشات منقضی شده</td>
			<td style="border-bottom: 1px solid #dfdfdf"><b>'.$total['order_expired'].'</b></td>
		</tr>
		<tr>
			<td bgcolor="#e0e0e0" style="border-bottom: 1px solid #dfdfdf">تيکت های فوری (<span class="red">+</span><span class="orange">+</span>)</td>
			<td style="border-bottom: 1px solid #dfdfdf"><b>'.$total['ticket_urgent'].'</b></td>
		</tr>
		<tr>
			<td bgcolor="#e0e0e0" style="border-bottom: 1px solid #dfdfdf">تيکت های عملياتی (<span class="red">+</span><span class="orange">+</span><span class="violet">+</span><span class="lavender">+</span>)</td>
			<td style="border-bottom: 1px solid #dfdfdf"><b>'.$total['tickets'].'</b></td>
		</tr>
		<tr>
			<td bgcolor="#e0e0e0" style="border-bottom: 1px solid #dfdfdf">اعتبار درگاه اس ام اس</td>
			<td style="border-bottom: 1px solid #dfdfdf"><b>'.$SMSCredit['SMSCredit'].' تومان</b></td>
		</tr>
		
	</table>

	
	</center>
	<br /><br />
	<ul class="admin-lists">';

		if($users['User']['role']== 4)
		{
			echo '<li>'
				.$html->link('سرویسها', array('controller' => 'managers', 'action' => 'services')).'<br />'
				.$html->link('محصولات', array('controller' => 'managers', 'action' => 'products')).'<br />'
				.$html->link('روش های پرداخت', array('controller' => 'managers', 'action' => 'payments')).'<br />'
				.$html->link('دپارتمان تيکت ها', array('controller' => 'managers', 'action' => 'departments')).'<br />'
				.$html->link('شاخه های اخبار', array('controller' => 'managers', 'action' => 'newscategories')).'<br />'
				.$html->link('رابط های API', array('controller' => 'managers', 'action' => 'apis')).'<br />'
				.$html->link('تنظیمات',array('controller'=>'managers' ,'action'=>'edit_setting')).'<br />'
			.'</li>';
		}
		if($users['User']['role']== 2 || $users['User']['role']== 4)
		{
			echo '<li>'
				.$html->link('کاربران',array('controller' => 'managers', 'action' => 'users')).'<br />';
				if($users['User']['role']== 4)
				{
					echo $html->link('پیامها' , array('controller' => 'managers' , 'action' => 'messages')).'<br />';
				}
				echo 
				$html->link('تراکنش ها', array('controller' => 'managers', 'action' => 'transactions')).'<br />'
				.$html->link('سفارشات', array('controller' => 'managers', 'action' => 'orders')).'<br />'
				.$html->link('تيکت ها', array('controller' => 'managers', 'action' => 'tickets')).'<br />'
				.$html->link('مشاهده کوپن شارژ ها', array('controller' => 'managers', 'action' => 'checkcardcharges')).'<br />'
				.'</li>';
		}
		if($users['User']['role']==1 || $users['User']['role']== 4 )
		{
			echo '<li>' 
				.$html->link('صفحات', array('controller' => 'managers', 'action' => 'pages')).'<br />'
				.$html->link('اخبار', array('controller' => 'managers', 'action' => 'news')).'<br />'
				.$html->link('منو', array('controller' => 'managers', 'action' => 'menus')).'<br />'
				.$html->link('تصاویر کشویی', array( 'controller'=>'managers' , 'action'=>'slideshows')).'<br />'
				.$html->link('مشتری های برتر', array('controller'=>'managers' , 'action' => 'customers')).'<br />'
				.$html->link('ارسال انبوه ایمیل',array('controller'=>'managers' ,'action'=>'bulk_email')).'<br />'
				.$html->link('ارسال انبوه اس ام اس',array('controller'=>'managers' ,'action'=>'bulk_sms')).'<br />'
				.$html->link('امضاها',array('controller'=>'managers' ,'action'=>'Signatures'))
			.'</li>';
		}
		if($users['User']['role']== 3)
		{
			echo '<li>'
				.$html->link('کاربران',array('controller' => 'managers', 'action' => 'users')).'<br />'
				.$html->link('تيکت ها', array('controller' => 'managers', 'action' => 'tickets')).'<br />'
				.$html->link('پیامها' , array('controller' => 'managers' , 'action' => 'messages')).'<br />
				</li>';
		}
echo	'</ul>
</div>';
?>