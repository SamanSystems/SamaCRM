<div style="direction: rtl; text-align: right; font: 12px Tahoma, Arial;">
با سلام<br />
پاسخی برای تيکت مرتبط با شما ارسال گرديده است.
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
			تاريخ پاسخ:
		</td>
		<td style="padding: 5px; text-align: right;">
			<?php echo $jtime->pdate("Y/n/j", $replydate); ?>
		</td>
	</tr>
	<tr>
		<td valign="top" style="text-align: center; padding: 5px; background: #ccc;">
			متن پاسخ:
		</td>
		<td style="padding: 5px; text-align: right;">
			<?php echo $reply_content;?>
		</td>
	</tr>
		</tr></table></center>
<br />
	<?php if($message){
		echo "برای پاسخ دادن به تيکت ".$html->link('اينجا کليک کنيد',$setting['website']."/users/guest_ticket/".$message['Message']['email']."/".$message['Message']['ticket_id']).".";
	}
	else{
		echo "برای پاسخ دادن به تيکت، ابتدا به وبسايت مراجعه کرده، وارد پنل کاربری خود شده و به بخش تيکت ها مراجعه کنيد.";
	}
	?>
</div>

