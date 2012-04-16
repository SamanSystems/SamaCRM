	<div class="content_title">
		<h2>آدرس رجوع کاربر</h2>
	  </div>
		
		<div class="content_content">
		میتوانید از طریق آدرس زير کاربران را به سایت هدایت کرده و در ازای شارژ مالی کاربران درصد خود را به عنوان پورسانت دريافت کنيد:
		<br />
		<div dir="ltr">
		<?php echo $website.'/users/register/'.$base64mail; ?>
		</div>
		</div>
	  <div class="content_title">
		<h2>کاربران زیر مجموعه شما</h2>
	  </div>
		
		<div class="content_content">
<table class="listTable"  border="0">
		<thead>
		<tr>
			<th>شماره مشتري</th>
			<th>نام مشتري</th>
			<th>نام شرکت</th>
			<th>وضعيت</th>
		</tr>
		</thead>
		<tbody id="usersContainer">
		<?php foreach($referred_users as $row){?>
		
		<tr>
			<td><?php echo $row['User']['id'];?></td>
			<td><?php echo $row['User']['name'];?></td>
			<td><?php echo $row['User']['company'];?></td>
			<td>
				<?php										
				if($row['User']['role']=='-1')
					echo '<span style= "color:orange;"><b>تاييد نشده</b></span>';
				else
					echo '<span style= "color : green;"><b>تاييد شده</b></span>';
				?>
			</td>
		</tr>
		<?php } ?>
		</tbody>
	</table>
		</div>