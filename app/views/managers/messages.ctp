
<div class=content_title>
	<h2>پیام های  کاربران<h2>
</div>
<div class=content_content>
<?php 
	if(isset($messages))
	{?>
	<table class="listTable" border="0">
		<tr>
			<th>شماره پیام</th>
			<th>نام کاربر</th>
			<th>خلاصه پیام</th>
			<th>انتخاب ها</th>
		</tr>
	<?php foreach($messages as $row){?>	
		<tr>
			<td><?php echo $row['Message']['id']; ?> </td>
			<td><?php echo $row['Message']['name']; ?> </td>
			<td><?php echo substr($row['Message']['content'] , 0,30);?></td>
			<td><?php echo 
							$html->link('[ادامه]',array('controller' => 'managers' , 'action' => 'messages' , $row['Message']['id'])).
							$html->link($html->image('/img/icons/unconfirm.png'), array('controller' => 'managers', 'action' => 'messages' ,$row['Message']['id'],'delete'),array('escape'=>false,'title' => 'حذف'));?></td>
		</tr>
	<?php }?>
	</table>
		<div align="center" class="paginate">
		<?php
			echo $paginator->prev('«قبلی   ', null, null, array('class' => 'disabled')).
				$paginator->next(' بعدی »', null, null, array('class' => 'disabled'));
		?>
		</div>
<?php	
	}else
	{
	?>
		<fieldset>
		<legend>مشخصات  کاربر</legend>
			<b>نام و نام خانوادگی :  </b>
			<?php
				echo $message['Message']['name'].'<br />';
			?>
			<b>شماره تماس :</b>
			<?php
				echo $message['Message']['phone'].'<br />';
			?>
			<b>پست الکترونیک :</b>
			<?php
				echo $message['Message']['email'].'<br />';
			?>
			
		</fieldset>
		<br />
		<br />
		<fieldset>
		<legend>متن پیام</legend>
			<?php 
				echo $message['Message']['content'];
			?>
		</fieldset>
	
<?php
}

?>	

</div>