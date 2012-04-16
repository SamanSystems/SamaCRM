<div class=content_title>
		<h2>گردش حساب من</h2>
		</div>
		<div class=content_content>
			<table class="listTable" border="0">
				<tr>
					<th>رديف</th>
					<th>تاريخ</th>
					<th>بدهکار</th>
					<th>بستانکار</th>
					<th>شرح</th>

				</tr>
		<?php
			$i = ( ($page-1)*15 < 0 ) ? 1 : ($page-1)*15+1;
			foreach ( $transactions as $transaction ) {
		?>
				<tr>
					<td><?php echo $i;?></td>
					<td><?php echo $jtime->pdate('Y/m/d',$transaction['Transaction']['date']); ?></td>
					<td>
						<?php 
							if ($transaction['Transaction']['amount']>0) {
								if($transaction['Transaction']['confirmed']== 1) $status = $html->image('/img/icons/confirmed.png',array('title'=>'وضعیت :  تایید شده ' , 'alt' => 'وضعیت : تایید شده '));
								 else $status = $html->image('/img/icons/verify.png',array('title'=>'وضعیت : در انتظار تاييد' , 'alt' => 'وضعيت: در انتظار تاييد'));
								echo '</td><td>'.$transaction['Transaction']['amount'].'</td>'.
									 '<td> روش پرداخت : '.$transaction['Payment']['name'].'<br />'.$status;
							} else {
								echo -($transaction['Transaction']['amount']).'</td><td></td><td>';
								if($transaction['Transaction']['order_id'] != 0)
									echo $html->link('شماره سفارش  :'.$transaction['Transaction']['order_id'],array('controller'=>'users' , 'action'=>'orders', $transaction['Transaction']['order_id']));
								echo '<br />'.$transaction['Transaction']['desc'];
							}
						?>
					</td>
					</td>
				</tr>
		<?php
			$i++;
			}
		?>
			</table>
			<div class="paginate">
<?php
	echo $paginator->next('« صفحه بعد ', null, null, array('class' => 'disabled')).
	'&nbsp;&nbsp;'.
	$paginator->prev(' صفحه قبل »', null, null, array('class' => 'disabled'));
?>
</div>
</div>