<div style="direction: rtl; text-align: right; font: 12px Tahoma, Arial;">
با سلام<br />
تيکت جديدی برای شما افتتاح شده است.
<br /><br />
 <center><table class="ticketTable" style="border: 1px solid #CCCCCC; width: 95%; font: 12px Tahoma, Arial;">
	<tr>
		<td style="text-align: center; width: 20%; background: #ccc; padding: 5px;">
			شماره تيکت:
		</td>
		<td style="padding: 5px; text-align: right;">
			#<?php echo $ticket_id;?>
		</td>
	</tr>
	<tr>
		<td style="text-align: center; padding: 5px; background: #ccc;">
			تاريخ افتتاح:
		</td>
		<td style="padding: 5px; text-align: right;">
			<?php echo $jtime->pdate("Y/n/j", $opendate); ?>
		</td>
	</tr>
	<tr>
		<td style="text-align: center; padding: 5px; background: #ccc;">
			عنوان تيکت:
		</td>
		<td style="padding: 5px; text-align: right;">
			<b><?php echo $ticket_title;?></b>
		</td>
	</tr>
	<tr>
		<td valign="top" style="text-align: center; padding: 5px; background: #ccc;">
			متن تيکت:
		</td>
		<td style="padding: 5px; text-align: right;">
			<?php echo $ticket_content;?>
		</td>
	</tr>
		</tr></table></center>
</div>