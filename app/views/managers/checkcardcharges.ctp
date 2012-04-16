	<div class=content_title>
		<h2>کوپن شارژ ها</h2>
	</div>
	<div class="content_content">
	
	<?php
	echo $html->link('ثبت نشده ها',array('controller' => 'managers' , 'action' => 'checkcardcharges' , 'notsubmited'),array('class' => 'button'))
	.$html->link('ثبت شده های چک نشده',array('controller' => 'managers' , 'action' => 'checkcardcharges', 'notchecked'),array('class' => 'button'))
	.$html->link('چک شده ها',array('controller' => 'managers' , 'action' => 'checkcardcharges', 'verified'),array('class' => 'button'))
	.$html->link('باطل شده ها',array('controller' => 'managers' , 'action' => 'checkcardcharges', 'faild'),array('class' => 'button'))
	.$html->link('همه',array('controller' => 'managers' , 'action' => 'checkcardcharges'),array('class' => 'button'))
	.'<br /> <br />';
	?>

	<table class="listTable" border="0">
		<tr>
			<th>شناسه</th>
			<th>تاريخ ايجاد</th>
			<th>اعتبار</th>
			<th>کاربر ثبت کننده</th>
			<th>تاریخ ثبت</th>
			<th>وضعيت</th>
			<th>تا</th>
			<th>رد</th>
		</tr>
	<?php
		echo $form->create('Ticket', array('url' => array('controller' => 'managers' ,'action' => 'checkcardcharges')));
		foreach ( $listcards as $listcard ) {
		echo "<tr>";
	?>
			<td><?php echo $listcard['Cardcharge']['id']; ?> </td>
			<td><?php echo $jtime->pdate("Y/n/j", $listcard['Cardcharge']['start_date']); ?> </td>
			<td><?php echo $listcard['Cardcharge']['credit']; ?> تومان</td>
			<td>
			<?php
			if (!empty($listcard['Cardcharge']['user_id']))
				echo $html->link($listcard['User']['name'], array('controller' => 'managers', 'action' => 'contact',$listcard['User']['id']));
			else
				echo "ثبت نشده";
			?>
			</td>
			<td>
			<?php
			if (!empty($listcard['Cardcharge']['user_id']))
				echo $jtime->pdate("Y/n/j", $listcard['Cardcharge']['submit_date']);
			else
				echo "ثبت نشده";
			?>
			</td>
			<td>
			<?php
			switch($listcard['Cardcharge']['admin_check']){
				case 0:
					echo "بدون عمليات";
				break;
				case 1:
					echo "<span class='green'>تاييد شده</span>";
				break;
				case 2:
					echo "<span class='red'>باطل شده</span>";
				break;
			}
			?>
			</td>
			<?php 
			if ($listcard['Cardcharge']['admin_check'] > 0){
				echo "<td class='tdgreen'>
				<input type='checkbox' name='data[accept][".$listcard[Cardcharge][id]."]' value='".$listcard[Cardcharge][id]."' disabled>
				</td>
				<td class='tdred'>
				<input type='checkbox' name='data[failed][".$listcard[Cardcharge][id]."]' value='".$listcard[Cardcharge][id]."' disabled>
				</td>";
			}
			else{
				echo "<td class='tdgreen'>
				<input type='checkbox' name='data[accept][".$listcard[Cardcharge][id]."]' value='".$listcard[Cardcharge][id]."'>
				</td>
				<td class='tdred'>
				<input type='checkbox' name='data[failed][".$listcard[Cardcharge][id]."]' value='".$listcard[Cardcharge][id]."'>
				</td>";
			}
			?>
		</tr>
	<?php
		}
	?>
	</table>
	<p>
	<?php echo $form->end(__('Submit', true)); ?>
	</p>
	<p>
	<span class='red'>ابطال</span> بر <span class='green'>تاييد</span> اولويت دارد.
	</p>
	<p align="left"><?php echo $html->link('ايجاد کوپن شارژ', array('controller'=>'managers','action'=>'makecardcharge'),array('class'=>'button')); ?></p>
	<div align="center" class="paginate">
	<?php
		echo $paginator->prev('«قبلي   ', null, null, array('class' => 'disabled')).
			$paginator->next(' بعدي »', null, null, array('class' => 'disabled'));
	?>
	</div>
	</div>