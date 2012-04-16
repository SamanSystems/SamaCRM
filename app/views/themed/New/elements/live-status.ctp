				<div id="flashMessage" class="dialog-msg LiveStatus">
						<label><?php echo $html->link('تراکنش های در انتظار تاييد',array('controller'=>'managers','action'=>'transactions','unconfirmed')); ?></label><span></span>
						<label><?php echo $html->link('تيکت های فوری',array('controller'=>'managers','action'=>'tickets')); ?></label><span></span>
						<label><?php echo $html->link('تيکت های عملياتی',array('controller'=>'managers','action'=>'tickets','inwork')); ?></label><span></span>						
				</div>