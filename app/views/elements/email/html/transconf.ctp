<div style="direction: rtl; text-align: right; font: 12px Tahoma, Arial;">
با سلام<br>
فيش پرداختی به ارزش <?php echo $trans['Transaction']['amount'];?> تومان، پرداخت شده از طريق <?php echo $trans['Payment']['name'] ;?> با توضيحات <?php echo $trans['Transaction']['desc'];?> ثبت شده در تاريخ <?php echo $jtime->pdate("Y/n/j", $trans['Transaction']['date']); ?> مورد تاييد قرار گرفت.<br />
<br>
تاييد شده توسط: <?php echo $users['User']['name'];?>
<br>
لطفا در حسابداری اعمال نمائيد.
</div>