<?php

class ManagersController extends AppController
{
	//--- Variables
	
	//version 1.4.1
	var $uses = array('User', 'Order', 'Service', 'Product', 'Transaction', 'Payment', 'News', 'Page', 'Menu', 'Slideshow', 'Customer' , 'Setting' , 'Message' , 'Property' , 'Productproperty', 'Ticket', 'Ticketreply','Cardcharge', 'Api', 'Ticketdepartment', 'Newscategory', 'Bulk', 'Signature');
	var $components = array('Whois', 'Jtime', 'Email', 'Session', 'Asresms');
	var $helpers = array('Html', 'Form', 'Session', 'Javascript', 'Paginator', 'Xml', 'Qoute');
	var $paginate = array('limit' => 15);
	var $setting;
	
	function beforeFilter ()
	{
		
		$this->setting = $this->Setting->find();
		$this->setting = $this->setting['Setting'];																																																																																																								
	
	
		$this->setting['send_sms_admin'] = 0;
		
		$this->Auth->fields = array(
			'username' => 'email',
			'password' => 'password'
		);
		$this->set('users',$this->Auth->user());
		$this->Auth->loginRedirect = array('controller' => 'users', 'action' => 'home');
		$this->Auth->logoutRedirect =  array('controller' => 'users', 'action' => 'login');
		$this->Auth->autoRedirect = false;
		$this->Auth->allow('mailForPay', 'remote', 'admin_back', 'live_access','daily_accounting_report','remote');
		$this->Auth->loginError = "نام کاربری یا رمز عبور اشتباه است";
		$this->Auth->authError = "شما اجازه دسترسی به این بخش را ندارید";
		if(!($this->action == 'remote' || $this->action == 'mailForPay' || $this->action == 'admin_back' || $this->action == 'live_access' || $this->action == 'daily_accounting_report')){
			if($this->Auth->user('role') < 1 ) $this->redirect('/');
			$domains = $this->domain;
			$domains = $domain;
			
		}
		
		$this->layout = 'admin';
	}
	
	function beforeRender()
	{
		parent::beforeRender();
		$this->pageTitle = '- '. __('Management Panel',true);
	}
	
	function home()
	{
		
		$total_unconfirmed_total = $this->Transaction->find('first', array( 'conditions' => array('Transaction.confirmed' => 0),
												'fields' => array('COUNT(Transaction.id) as tot')
											 )
								);
		$total_unconfirmed_amount = $this->Transaction->find('first', array( 'conditions' => array('Transaction.confirmed' => 0),
												'fields' => array('SUM(Transaction.amount) as tot')
											 )
								);
		$total_order_confirmed = $this->Order->find('first', array( 'conditions' => array('Order.confirmed' => 1),
												'fields' => array('COUNT(Order.id) as tot')
											 )
								);
		$total_order_pre = $this->Order->find('first', array( 'conditions' => array('Order.confirmed' => 0),
												'fields' => array('COUNT(Order.id) as tot')
											 )
								);
		$total_order_expired = $this->Order->find('first', array( 'conditions' => array('Order.confirmed' => -1),
												'fields' => array('COUNT(Order.id) as tot')
											 )
								);
		$total_notchecked_cardcharge = $this->Cardcharge->find('first', array( 'conditions' => array('Cardcharge.user_id !=' => 0, 'Cardcharge.admin_check' => 0),
												'fields' => array('COUNT(Cardcharge.id) as tot')
											 )
								);
		$near_elapsed=$this->nearPay(7,0,true);
		$ticket_urgent=$this->Ticket->find('first', array('conditions' => array('Ticket.status' => array('0', '2')), 'fields' => array('COUNT(Ticket.id) as tot')));
		$tickets=$this->Ticket->find('first', array('conditions' => array('Ticket.status' => array('0', '2', '4', '3')), 'fields' => array('COUNT(Ticket.id) as tot')));
		$this->set('total', array('transaction_unconfirmed_total' => $total_unconfirmed_total[0]['tot'], 
				   'transaction_unconfirmed_amount' => $total_unconfirmed_amount[0]['tot'], 
				   'order_confirmed' => $total_order_confirmed[0]['tot'],
				   'order_pre' => $total_order_pre[0]['tot'],
				   'order_expired' => $total_order_expired[0]['tot'],
				   'near_elapsed' => $near_elapsed,
				   'tickets' => $tickets[0]['tot'] ,
				   'ticket_urgent' => $ticket_urgent[0]['tot'],
				   'notchecked_cardcharge' => $total_notchecked_cardcharge[0]['tot'],)
				);
		
		if(!empty($this->setting['gateway_number'])){
			$this->Asresms->SetVar('gateway_number', $this->setting['gateway_number']);
			$this->Asresms->SetVar('gateway_pass', $this->setting['gateway_pass']);
			$this->set('SMSCredit' , array('SMSCredit' => $this->Asresms->GetInfo()));
		}else{
			$this->set('SMSCredit' , array('SMSCredit' => 'تعریف نشده'));
		}
					
	}
	function last_update()
	{
		$this->layout = 'ajax';
		$total_unconfirmed_total = $this->Transaction->find('first', array( 'conditions' => array('Transaction.confirmed' => 0),'fields' => array('COUNT(Transaction.id) as tot')));
		$total_order_toconfirm = $this->Order->find('first', array('conditions' => array('Order.confirmed' => 1),'fields' => array('COUNT(Order.id) as tot')));
		$total_order_pre = $this->Order->find('first', array('conditions' => array('Order.confirmed' => 0),'fields' => array('COUNT(Order.id) as tot')));
		$ticket_urgent = $this->Ticket->find('first', array('conditions' => array('Ticket.status' => array('0', '2') ) ,'fields' => array('COUNT(Ticket.id) as tot')));
		$tickets = $this->Ticket->find('first', array('conditions' => array('Ticket.status' => array('0', '2', '4', '3') ) ,'fields' => array('COUNT(Ticket.id) as tot')));
	
		$this->set('total', array('unconfirmed' => $total_unconfirmed_total[0]['tot'], 
		   'order_toconfirm' => $total_order_toconfirm[0]['tot'], 
		   'order_pre' => $total_order_pre[0]['tot'],
		   'ticket_urgent' => $ticket_urgent[0]['tot'],
		   'tickets' => $tickets[0]['tot'])
			);
	}
	
	function users($operation = 'all')
	{
			if($operation == 'all')
				$this->set('client', $this->paginate('User'));
			elseif($operation == 'unconfirmed')
				$this->set('client', $this->paginate('User', array('User.role'=> '-1')));
	
	}
	
	function referred_users($id)
	{
		$this->set('referrer_client', $this->User->findById($id));
		$this->set('client', $this->paginate('User', array('User.referrer_id ' => $id)));
	}
	
	function user_search()
	{
		$this->layout = 'ajax';
		$this->set('clients', $this->User->find('all', array('conditions' => array('User.name LIKE'=>'%'.$_POST['query'].'%'))));
	}
	function tickets_search()
	{
		$this->layout = 'ajax';
		$this->set('tickets', $this->Ticket->find('all', array('conditions' => array('Ticket.title LIKE'=>'%'.$_POST['query'].'%'))));
	}
	
	function mailForPay($day)
	{
		$this->layout = 'ajax';
		$data=$this->nearPay($day,$day-1);

		$this->Order->unbindModel(
			array('belongsTo' => array('Product'))
		);
		
		$this->Order->updateAll(array('Order.confirmed' => -1),array('Order.next_pay <' => time(), 'Order.next_pay !=' => 1, 'Order.confirmed' => 2));
		foreach($data as $order)
		{
			$checkticket = $this->Ticket->find('first', array('conditions' => array('Ticket.user_id' => $order['Order']['user_id'], 'Ticket.title LIKE' => '%انقضای سفارش شماره '. $order['Order']['id'] .' (توجه کنيد)%')));
			if(empty($checkticket)){
				//open ticket
				$this->data['Ticket']['title'] = 'انقضای سفارش شماره '.$order['Order']['id'].' (توجه کنيد)';
				$this->data['Ticket']['content'] = 'با سلام
				به استحضار ميرساند تا انقضا سفارش شماره '.$order['Order']['id'].' مدت زمان '.$day.' روز باقی مانده است.
				چنانچه مايل به تمديد سفارش هستيد لطفا نسبت به پرداخت هزينه و تمديد سفارش اقدام کنيد.
				(اين تيکت به صورت خودکار توسط سيستم ثبت شد.)';
				$this->data['Ticket']['ticketdepartment_id'] = 0;
				$this->data['Ticket']['priority'] = 0;
				$this->data['Ticket']['user_unread'] = 1;
				$this->data['Ticket']['status'] = 6;
				$this->postticket($order['Order']['user_id'], 1);
				//$this->SendSMS();
			}
			else{
				$this->data['Ticketreply']['content'] = 'تا انقضا سفارش شماره '.$order['Order']['id'].' مدت زمان '.$day.' روز باقی مانده است.
				لطفا نسبت به تمديد سفارش اقدام کنيد.
				(اين پاسخ توسط سيستم و به صورت خودکار ثبت شد.)';
				$this->data['Ticketreply']['user_unread'] = 1;
				$this->data['Ticketreply']['status'] = 6;
				$this->postticketreply($checkticket['Ticket']['id'], 1);
				//$this->SendSMS();
			}
			
		}
		
		if($day == 1){
			$this->Order->deleteAll(array('Order.date <' => time()-345600,'Order.confirmed' => 0));
			$pre_orders = $this->Order->find( 'all' ,array('conditions'=>array('Order.confirmed' => 0,'Order.date >' => time()-86400) , 'recursive' => 2));
			foreach($pre_orders as $pre_order)
			{
				$checkticket = $this -> Ticket -> find( 'first', array('conditions' => array('Ticket.user_id' => $pre_order['Order']['user_id'],'Ticket.title LIKE' => '%سفارش شماره '.$pre_order['Order']['id'].' با موفقیت ثبت شد%')));
				if(empty($checkticket['Ticket']['id'])){
					//open ticket
					$this->data['Ticket']['title'] = 'سفارش شماره '.$pre_order['Order']['id'].' با موفقیت ثبت شد';
					$this->data['Ticket']['content'] = 'با سلام
					خواهشمند است نسبت به پرداخت اين سفارش اقدام فرمائيد. برای پرداخت سفارش، به بخش سفارشات من مراجعه کرده و روی کليد پرداخت سفارش کليک کنيد.
					بديهی است، سفارشات پرداخت نشده، ترتيب اثر داده نشده و در صورت عدم پرداخت، تا 4 روز پس از ثبت، از سيستم حذف خواهند شد.
					(اين تيکت به صورت خودکار توسط سيستم ثبت شد.)';
					$this->data['Ticket']['ticketdepartment_id'] = 0;
					$this->data['Ticket']['priority'] = 0;
					$this->data['Ticket']['user_unread'] = 1;
					$this->data['Ticket']['status'] = 6;
					$this->postticket($order['Order']['user_id'],1);
					//$this->SendSMS();
				} else {
					$this->data['Ticketreply']['content'] = 'با سلام
					خواهشمند است نسبت به پرداخت اين سفارش اقدام فرمائيد. برای پرداخت سفارش، به بخش سفارشات من مراجعه کرده و روی کليد پرداخت سفارش کليک کنيد.
					بديهی است، سفارشات پرداخت نشده، ترتيب اثر داده نشده و در صورت عدم پرداخت، تا 4 روز پس از ثبت، از سيستم حذف خواهند شد.
					(اين پاسخ توسط سيستم و به صورت خودکار ثبت شد.)';
					$this->data['Ticketreply']['user_unread'] = 1;
					$this->data['Ticketreply']['status'] = 6;
					$this->postticketreply($checkticket['Ticket']['id'],1);
					
					$this->data['Ticket']['title'] = 'سفارش شماره '.$pre_order['Order']['id'].' با موفقیت ثبت شد';
					//$this->SendSMS();
				}
			}
		}
		
	}
	
	function nearPay($day, $until = -1, $count = false)
	{
		$find = 'all';
		if($until<0) $until = $day-1;
		if($count == true) $find = 'count'; 
		return $this->Order->find( $find ,array('conditions'=>array('Order.confirmed' => 2 , 'Order.next_pay <' => ($day*86400) + time() ,'Order.next_pay >' => (($until)*86400) + time() ) , 'recursive' => 2));
	}
	
	function order_confirm($id)
	{
		$order = $this->Order->findById($id);
		$product = $this->Product->findById($order[Order][product_id]);
		$costs = $this->costs($product['Product']['cost']);
		$user = $this->User->findById($order['Order']['user_id']);
		$this->set('client', $user);
		$this->set('id', $id);
		$ineditor = 'سفارش شما با فاکتور زير تاييد شد:
		<center><table border="1"><tr><td>نام سرویس</td><td>نام محصول</td><td>قيمت (تومان)</td><td>تاریخ سفارش</td><td>تاریخ پرداخت بعدی</td><td>توضيحات</td></tr><tr><td>'.$product[Service][name].'</td><td>'.$product[Product][name].'</td><td>'.($costs[$order[Order][monthly]]-$order[Order][discount]).'</td><td>'.$this->Jtime->pdate("Y/n/j", $order[Order][date]).'</td><td>'.$this->Jtime->pdate("Y/n/j", $order['Order']['next_pay']).'</td><td>'.$order[Order][desc].'</td></table></center>
		(اين پاسخ به صورت خودکار در سيستم ثبت شد.)';
		$this->set('ineditor', $ineditor);

			/**
			$this->set('info',$this->data);
			$this->set('setting',$this->setting);
			$this->Email->to = $user['User']['email'];
			$this->Email->from = $this -> setting['mail_title'].' <'.$this -> setting['noreply_mail_address'].'>';
			$this->Email->subject = 'سفارش شماره '.$order['Order']['id'].' مورد تایید قرار گرفت';
			$this->Email->template = 'orderconf';
			$this->Email->sendAs = 'html';
			$this->Email->send();
			**/
			
			$this->Order->id = $id;
			$data = $this->Order->read();
			$data['Order']['confirmed'] = 2;
			$this->Order->save($data);
			
			$checkticket = $this -> Ticket -> find('first', array('conditions' => array('Ticket.user_id' => $user['User']['id'], 'Ticket.title LIKE' => '%سفارش شماره '.$order['Order']['id'].' با موفقیت  ثبت شد%')));
			if(empty($checkticket['Ticket']['id'])){
				//open ticket
				$this->data['Ticket']['title'] = 'سفارش شماره '.$order['Order']['id'].' مورد تایید قرار گرفت';
				$this->data['Ticket']['content'] = $ineditor;
				$this->data['Ticket']['ticketdepartment_id'] = 0;
				$this->data['Ticket']['priority'] = 0;
				$this->data['Ticket']['status'] = 6;
				$this->postticket($user['User']['id'], 1);
				//$this->SendSMS();
				$this->Session->setFlash('سفارش شما مورد تاييد قرار گرفته شد و تيکت افتتاح شد. (<a href="/managers/tickets/'.$this->Ticket->id.'/">مشاهده تيکت</a>)', 'default', array('class' => 'success-msg'));
			} else {
				$this->data['Ticketreply']['content'] = 'سفارش شماره '.$order['Order']['id'].' مورد تایید قرار گرفت
				(اين پاسخ توسط سيستم و به صورت خودکار ثبت شد.)';
				$this->data['Ticketreply']['user_unread'] = 1;
				$this->data['Ticketreply']['status'] = 6;
				$this->postticketreply($checkticket['Ticket']['id'], 1);
				
				$this->data['Ticket']['title'] = 'سفارش شماره '.$order['Order']['id'].' مورد تایید قرار گرفت';
				//$this->SendSMS();
				
				$this->Session->setFlash('سفارش شما مورد تاييد قرار گرفت و پاسخ به تيکت ارسال شد. (<a href="/managers/tickets/'.$checkticket['Ticket']['id'].'/">مشاهده تيکت</a>)', 'default', array('class' => 'success-msg'));
			}
			
		$this->redirect(array('controller' => 'managers', 'action' => 'orders'));
	}
	
	function contact($id)
	{
			$user = $this->User->findById($id);
			$this->set('client', $user);
			$referrer_client=$this->User->findById($user['User']['referrer_id']);
			$user_tickets=$this->Ticket->find('all',array('conditions'=>array('Ticket.user_id'=>$id), 'limit'=>5, 'order' => array('Ticket.id DESC','Ticket.status ASC','Ticket.priority DESC')));
			$this->set('referrer_client',$referrer_client);
			$this->set('user_tickets',$user_tickets);
			$this->set('referred_sum',$this->User->find('count', array('conditions' =>array('User.referrer_id'=>$id))));
			$credit=$this->Transaction->find('first', array( 'conditions' => array('Transaction.user_id' =>  $id, 'Transaction.confirmed' => 1), 'fields' => array('SUM(Transaction.amount) as tot')));
			if (empty($credit[0]['tot']))
			$credit[0]['tot'] = 0;
			$this->set('clienttrans',$credit[0]['tot']);
			if(isset($this->data))
			{

				$this->set('info',$this->data);
				$this->Email->to = $user['User']['email'];
				$this->Email->from = $this -> setting['mail_title'].' <'.$this -> setting['noreply_mail_address'].'>';
				$this->Email->subject = $this->data['Contact']['subject'];
				$this->Email->template = 'contact';
				$this->Email->sendAs = 'html';
				$this->Email->send();
				
				$this->Session->setFlash('پست الکترونیکی فرستاده شد.', 'default', array('class' => 'success-msg'));
				$this->redirect(array('controller' => 'managers', 'action' => 'home'));	
			}
	}

	function orders ($operation = null,$id=null)
	{
                $this->paginate = array('limit' => 15, 'order' => 'Order.id DESC', 'recursive' => 2);
		if($operation == 'delete'){
				$this->Order->id = $id;	
				$order=$this->Order->read();			
				$this->Order->del();
				$this->Session->setFlash('سفارش مورد نظر حذف شد', 'default', array('class' => 'success-msg'));
				$this->redirect(array('controller' => 'managers', 'action' => 'orders'));
		}elseif($operation=='before')
		{
			$this->set('orders', $this->paginate('Order', array('Order.confirmed' => 0)));	
		}elseif($operation == 'unconfirmed')
		{
			$this->set('orders', $this->paginate('Order', array('Order.confirmed' => 1)));	
		}elseif($operation == 'confirmed')
		{
			$this->set('orders', $this->paginate('Order', array('Order.confirmed' => 2)));	
		}elseif($operation == 'expired')
		{
			$this->set('orders', $this->paginate('Order', array('Order.confirmed' => -1)));	
		}elseif($operation == 'user_orders')
		{
			$this->set('orders', $this->paginate('Order', array('Order.user_id' => $id)));
			$this->set('user_order' , '1');
		}elseif($operation == 'near_elapsed')
		{
			$this->set('orders',$this->nearPay(7,0,false));
		}else
		{
			$this->set('orders', $this->paginate('Order'));
		}
	}
	
	function add_order ($user_id,$product_id)
	{
		$this->set('id',$user_id);
		$product = $this->Product->findById($product_id);
		if ( isset($product_id) )
		{
			$product = $this->Product->findById($product_id);
			$this->set('product', $product);
			if(isset($this->data))
			{
				if($this->data['Order']['confirmed']!=0)
					$this->data['Order']['next_pay'] = $this->Jtime->pmktime(0,0,0,$this->data['Order']['next_pay']['month'],$this->data['Order']['next_pay']['day'],$this->data['Order']['next_pay']['year']);
				else
					$this->data['Order']['next_pay'] = 0;
				$this->data['Order']['product_id'] = $product_id;
				$this->data['Order']['user_id'] = $user_id;
				$this->data['Order']['date'] = $this->Jtime->pmktime(0, 0, 0, $this->data['Order']['date']['month'], $this->data['Order']['date']['day'], $this->data['Order']['date']['year']);
				if ( $this->Order->save($this->data) )
				{
					if($this->data['Order']['reduce'] == 1){
						$price = $this->costs($product['Product']['cost']);
						$trans['Transaction']['user_id'] = $user_id;
						$trans['Transaction']['order_id'] = $this->Order->id;
						$trans['Transaction']['payment_id'] = 0;
						$trans['Transaction']['amount'] = -($price[$this->data['Order']['monthly']]-$this->data['Order']['discount']);
						$trans['Transaction']['date'] = $this->data['Order']['date'];
						$trans['Transaction']['desc'] = 'پرداخت سفارش شماره '. $this->Order->id;
						$trans['Transaction']['confirmed'] = 1;
						$this->Transaction->save($trans);
					}
					
					$this->Session->setFlash('سفارش با موفقيت ثبت شد', 'default', array('class' => 'success-msg'));
					$this->redirect('/managers/orders/user_orders/'.$user_id.'/');
				}
				else
				{
					$this->Session->setFlash('مشکلی در ثبت سفارش وجود دارد.', 'default', array('class' => 'error-msg'));
				}
			}
		}else{
			
			if(isset($this->data))
			{
				$this->redirect('/managers/add_order/'.$user_id.'/'.$this->data['Service']['product_id']);
				
			} else {
				$this->set('services', $this->Service->find('all',array('order' => array('Service.name ASC'))));
				$this->set('products', $this->Product->find('all'));
			}
		}

	}
	
	function edit_order ($id = null)
	{
		if ( $id )
		{
			$this->Order->id = $id;

			if ( $this->data )
			{
				if(isset($this->data['Order']['next_pay']))
					$this->data['Order']['next_pay'] = $this->Jtime->pmktime(0,0,0,$this->data['Order']['next_pay']['month'],$this->data['Order']['next_pay']['day'],$this->data['Order']['next_pay']['year']);
				
				if(isset($this->data['Order']['date']))
					$this->data['Order']['date'] = $this->Jtime->pmktime(0,0,0,$this->data['Order']['date']['month'],$this->data['Order']['date']['day'],$this->data['Order']['date']['year']);
				
				$api_data = '';
				if(!empty($this->data['Order']['Api']))
						foreach($this->data['Order']['Api'] as $key => $data) $api_data .= '$api_data[\''. $key .'\'] ="'. $data .'";';
				
				$this->data['Order']['api_data'] = $api_data;
				
				if ( $this->Order->save($this->data) )
				{	
					$this->Session->setFlash('اطلاعات با موفقیت ثبت شد', 'default', array('class' => 'success-msg'));
					$this->redirect('/managers/orders/');
				}
				else
				{
					$this->Session->setFlash('مشکلی در ثبت اطلاعات وجود دارد', 'default', array('class' => 'error-msg'));
				}
			}
			$this->data = $this->Order->read();
			
			$monthles[1]=' ماهیانه';
			$monthles[3]='3 ماهه';
			$monthles[6]='6 ماهه';
			$monthles[12]='سالیانه';
			$monthles[24]='دو ساله';
			$monthles[60]='پنج ساله';
			
			$product = $this->Product->find('first',array('fields' => array('Product.cost'),'conditions' => array('Product.id' => $this->data['Order']['product_id']), 'recursive'=> -1));
			$costs = $this->costs($product['Product']['cost']);
			$this->set('cost',$costs[$this->data['Order']['monthly']]);
			
			if(!empty($this->data['Order']['api_data'])){
				eval($this->data['Order']['api_data']);
				$this->set('extras', $api_data);
			}	
					
			$this->set('monthles',$monthles);
			$this->set('services', $this->Service->find('all'));
			$this->set('products', $this->Product->find('list',array('fields' => array('Product.id','Product.name'),'conditions' => array('Product.service_id' => $this->data['Product']['service_id']))));
		}
	}
	function slideshows ($delid = null)
	{
		if($delid)
		{
			$this->Slideshow->id=$delid;
			$this->Slideshow->del();
		}
		$this -> set( 'slideshows' , $this->Slideshow->find('all',array('order'=>'Slideshow.id DESC')));
	}
	function add_slideshow()
	{
		if ( $this->data )
		{
			if ( $this->Slideshow->save($this->data) )
			{
				$this->Session->setFlash('اطلاعات با موفقیت ثبت شد', 'default', array('class' => 'success-msg'));
			}
			else
			{
				$this->Session->setFlash('مشکلی در ثبت اطلاعات وجود دارد', 'default', array('class' => 'error-msg'));
			}
		} 
	}
	function edit_slideshow ($id = null)
	{
		if ( $id )
		{
			$this->Slideshow->id = $id;
			if ( $this->data )
			{
				if ( $this->Slideshow->save($this->data) )
				{
					$this->Session->setFlash('اطلاعات با موفقیت ثبت شد', 'default', array('class' => 'success-msg'));
				}
				else
				{
					$this->Session->setFlash('مشکلی در ثبت اطلاعات وجود دارد', 'default', array('class' => 'error-msg'));
				}
			}
			$this->data = $this->Slideshow->read();
		}
	}

	function products ($delid = null)
	{
		if ( $delid )
		{
			$this->Product->delete($delid,false);

			$productproperty=$this->Productproperty->find('all',array('conditions'=>array('Productproperty.product_id'=>$delid)));
			foreach ($productproperty as $row)
			{
				$this->Productproperty->delete($row['Productproperty']['id'],false);
			}
			$orders=$this->Order->find('all',array('conditions'=>array('Order.product_id'=>$delid)));
			foreach ($orders as $row1)
			{
				$this->Order->delete($row1['Order']['id'],false);
			}					
			$this->Session->setFlash('محصول با موفقیت حذف شد', 'default', array('class' => 'success-msg'));
		}
		$this->paginate['order'] = array('Product.id' => 'DESC');
		$this->set('products',$this->paginate('Product'));
		//$this->set('products', $this->Product->find('all', array('order' => 'Product.id DESC')));
	}
	
	function add_product ()
	{
		if ( $this->data )
		{
				foreach($this->data['Product']['costs'] as $month => $cost)
				{
					$this->data['Product']['cost'] .= $month.','.$cost.':';
				}
			if ( $this->Product->save($this->data) )
			{
				foreach($this->data['Product']['property'] as $key=>$value)
				{
					$this->Productproperty->create();
					$temp['Productproperty']['property_id']=$key;
					$temp['Productproperty']['value']=$value;
					$temp['Productproperty']['product_id']=$this->Product->id;
					$this->Productproperty->save($temp);
				}

				$this->Session->setFlash('اطلاعات با موفقیت ثبت شد', 'default', array('class' => 'success-msg'));
				$this->redirect('/managers/home');
			}
			else
			{
				$this->Session->setFlash('مشکلی در ثبت اطلاعات وجود دارد', 'default', array('class' => 'error-msg'));
			}
		}
		$temp=$this->Service->find('all');
		$option[-1]='انتخاب کنید';
		foreach($temp as $row)
		{
			$option[$row['Service']['id']]=$row['Service']['name'];
		}
		$this->set('options',$option);
	}
	
	function edit_product ($id = null)
	{
		if ( $id )
		{

			
			$this->Product->id = $id;
			
			if ( $this->data )
			{
				
				//$product=$this->Product->read();
				//$price=$this->costs($product['Product']['cost']);
/*
				if(!empty($price))
				{
					$this->data['Product']['cost']='';
					foreach($price as $month => $cost)
					{
						$flag=false;
						foreach($this->data['Product']['costs'] as $month2 => $cost2)
						{
							if($month==$month2)
							{
								$this->data['Product']['cost'] .=$month2.','.$cost2.':';
								$flag=true;
							}
						}
						if(!$flag)
						{
							$this->data['Product']['cost'] .=$month.','.$cost.':';
						}
					}
				}else
				{
*/
					$this->data['Product']['cost']='';
					foreach($this->data['Product']['costs'] as $month => $cost)
					{
						$this->data['Product']['cost'] .= $month.','.$cost.':';
					}
				//}
				if ( $this->Product->save($this->data) )
				{
					foreach($this->data['Product']['oldproperty'] as $key=>$value)
					{
						$this->Productproperty->id=$key;
						$temp['Productproperty']['value']=$value;
						$this->Productproperty->save($temp);
					}
					foreach($this->data['Product']['newproperty'] as $key=>$value)
					{
						$this->Productproperty->create();
						$temp2['Productproperty']['product_id']=$this->Product->id;
						$temp2['Productproperty']['property_id']=$key;
						$temp2['Productproperty']['value']=$value;
						$this->Productproperty->save($temp2);
					}
					$this->Session->setFlash('اطلاعات با موفقیت ثبت شد', 'default', array('class' => 'success-msg'));
					$this->redirect('/managers/products');
				}
				else
				{
					$this->Session->setFlash('مشکلی در ثبت اطلاعات وجود دارد', 'default', array('class' => 'error-msg'));
				}
			}else
			{
				$product=$this->Product->find('first',array('conditions'=>array('Product.id'=>$id),'recursive'=>3));
				$inputs='<div id="productproperty">';
			
				foreach($product['Service']['Property'] as $property)
				{
					$productproperty=$this->Productproperty->find('first',array('conditions'=>array('Productproperty.property_id'=>$property['id'],'Productproperty.product_id'=>$id)));
					if(isset($productproperty['Productproperty']['id']))
						$inputs .='<label>'.$property['name'] .' :</label><input name="data[Product][oldproperty]['.$productproperty['Productproperty']['id'].']" type="text" value="'.$productproperty['Productproperty']['value'].'"  /><br /><br />';
					else
						$inputs .='<label>'.$property['name'] .' :</label><input name="data[Product][newproperty]['.$property['id'].']" type="text" value=""  /><br /><br />';
				}
				$costs=$this->costs($product['Product']['cost']);
	
				$monthly = $product['Service']['monthly'];
				if($monthly < 0)
				{
					$period[]='-120';
					$monthly=$monthly+120;
				}
				if($monthly-60 >= 0)
				{
					$period[]='60';
					$monthly=$monthly-60;
				}
				if($monthly-24 >= 0)
				{
					$period[]='24';
					$monthly=$monthly-24;
				}		
				if($monthly-12 >= 0)
				{
					$period[]='12';
					$monthly=$monthly-12;
				}
				if(($monthly-6) >= 0)
				{
					$period[]='6';
					$monthly=$monthly-6;
				}
				if(($monthly-3) >= 0)
				{
					$period[]='3';
					$monthly=$monthly-3;
				}
				if(($monthly-1) >= 0)
				{
					$period[]='1';
					$monthly=$monthly-1;
				}
				foreach($period  as $row)
				{
					if($row>0) $month = $row .' ماهه';
					 else $month = 'مادام العمر';
					$inputs .='<label> قیمت  '.$month.' :</label><input name="data[Product][costs]['.$row.']" type="text" value="'.$costs[$row].'"  /><br /><br />';
				}
				$inputs.='</div>';
				$this->set('inputs',$inputs);
				$this->data = $this->Product->read();
			}
		}
		
	}
	
	function transactions ($operation = null, $id = null)
	{
		$this->paginate=array('limit' => 15, 'order' => 'Transaction.id DESC');
		
		if ( $operation == 'confirm' )
		{
			$this->Transaction->id = $id;
			$this->data['Transaction']['confirmed'] = 1;
			$this->Transaction->save($this->data);
			$trans=$this->Transaction->findById($id);
			$credit=$this->Transaction->find('first', array( 'conditions' => array('Transaction.user_id' =>  $trans['User']['id'], 'Transaction.confirmed' => 1), 'fields' => array('SUM(Transaction.amount) as tot')));
			
			if($trans['Transaction']['payment_id'] !=0)
			{
				$checkticket = $this -> Ticket -> find( 'first', array('conditions' => array('Ticket.user_id' => $trans['User']['id'],'Ticket.title LIKE' => '%تراکنش شماره '.$id.' ثبت شد%')));
				if(!empty($checkticket['Ticket']['id'])){
					$this->data['Ticketreply']['content'] = 'اين تراکنش به ارزش '.$trans['Transaction']['amount'].' تومان مورد تاييد قرار گرفت.
					اعتبار شما در حال حاضر : '.$credit[0]['tot'].' تومان
					(اين پاسخ توسط سيستم و به صورت خودکار ثبت شد.)';
					$this->data['Ticketreply']['user_unread'] = 1;
					$this->data['Ticketreply']['status'] = 6;
					$this->postticketreply($checkticket['Ticket']['id'],1);
					
					$this->data['Ticket']['title'] = 'اين تراکنش به ارزش '.$trans['Transaction']['amount'].' تومان مورد تاييد قرار گرفت.';
					//$this->SendSMS();
					
				}
			}
		
			if($this -> setting['send_email']==1)
			{
				$this->set('trans',$trans);
				$this->set('setting',$this->setting);
				$this->Email->to = $this -> setting['billing_mail_address'];
				$this->Email->from = $this -> setting['mail_title'].' <'.$this -> setting['noreply_mail_address'].'>';
				$this->Email->subject = 'تراکنش به ارزش '.$trans['Transaction']['amount']. ' در سايت '.$this -> setting['name'];
				$this->Email->template = 'transconf';
				$this->Email->sendAs = 'html';
				$this->Email->send();
			}

			$this->Session->setFlash('تراکنش با موفقیت تایید شد.', 'default', array('class' => 'success-msg'));
			$this->redirect('/managers/transactions');

		}
		elseif ( $operation == 'unconfirmed' )
		{
			$this->set('transactions', $this->paginate('Transaction',array('Transaction.amount >' => '0', 'Transaction.confirmed' => '0')));
		}
		elseif ( $operation == 'confirmed' )
		{
			$this->set('transactions', $this->paginate('Transaction',array('Transaction.amount >' => '0', 'Transaction.confirmed' => '1')));
		}
		elseif ( $operation == 'delete' )
		{
			$this->Transaction->id = $id;
			$data=$this->Transaction->read();
			if($data['Transaction']['confirmed']==0){
				$this->Transaction->del();
				$this->data['Ticketreply']['content'] = 'اين تراکنش به ارزش '.$data['Transaction']['amount'].' از سيستم حذف شد.
				(اين پاسخ توسط سيستم و به صورت خودکار ثبت شد.)';
				$this->Session->setFlash('تراکنش مورد نظر حذف گرديد.', 'default', array('class' => 'success-msg'));
			}
			else
			{
				$data['Transaction']['confirmed']=0;
				$this->Transaction->id = $id;
				$this->Transaction->save($data);
				$this->data['Ticketreply']['content'] = 'اين تراکنش به ارزش '.$data['Transaction']['amount'].' در سيستم رد شد.
				(اين پاسخ توسط سيستم و به صورت خودکار ثبت شد.)';
				$this->Session->setFlash('تراکنش مورد نظر تاييد نشده گرديد.', 'default', array('class' => 'success-msg'));
			}
			
			$checkticket = $this -> Ticket -> find( 'first', array('conditions' => array('Ticket.user_id' => $data['Transaction']['user_id'],'Ticket.title LIKE' => '%تراکنش شماره '.$data['Transaction']['id'].' ثبت شد%')));
			if(!empty($checkticket['Ticket']['id'])){
				$this->data['Ticketreply']['user_unread'] = 1;
				$this->data['Ticketreply']['status'] = 6;
				$this->postticketreply($checkticket['Ticket']['id'],1);
				
				$this->data['Ticket']['title'] = 'اين تراکنش به ارزش '.$data['Transaction']['amount'].' در سيستم رد شد.';
				//$this->SendSMS();
				
			}
			
			$this->redirect('/managers/transactions');
			
		}
		else
		{
			$this->set('transactions', $this->paginate('Transaction',array('Transaction.amount >' => '0')));
		}
	}

	function add_transaction($user_id=null)
	{
		if($this->data)
		{
			$this->data['Transaction']['user_id']=$user_id;
			$this->data['Transaction']['date']=time();
			$this->data['Transaction']['confirmed']=1;
			if($this->Transaction->save($this->data))
			{
				$this->Session->setFlash('اطلاعات با موفقیت ثبت شد', 'default', array('class' => 'success-msg'));
				$this->redirect('/managers/accounting/'.$user_id.'/');
			} else {
				$this->Session->setFlash('مشکلی در ثبت اطلاعات وجود دارد', 'default', array('class' => 'error-msg'));
			}
		}
		$this->set('id',$user_id);
		$this->set('payment',$this->Payment->find('list',array('fileds'=>array('Payment.name'))));
		$this->set('this_user',$this->User->find('first',array('conditions'=>array('User.id'=>$user_id),'fileds'=>array('User.name'))));
	}
	
	function edit_transaction ($id = null)
	{
		if ( $id )
		{
			$this->Transaction->id = $id;
			if ( $this->data )
			{
				if ( $this->Transaction->save($this->data) )
				{
					$this->Session->setFlash('اطلاعات با موفقیت ثبت شد', 'default', array('class' => 'success-msg'));
				}
				else
				{
					$this->Session->setFlash('مشکلی در ثبت اطلاعات وجود دارد', 'default', array('class' => 'error-msg'));
				}
			}
			$this->data = $this->Transaction->read();
		}
	}
	
	function services ($delid = null)
	{
		if ( $delid )
		{
			$service=$this->Service->find('first',array('conditions'=>array('Service.id'=>$delid),'recursive'=>2));
			
			foreach($service['Property'] as $property)
			{
				foreach($property['Productproperty'] as $productproperty)
					$this->Productproperty->delete($productproperty['id'],false);
					
				$this->Property->delete($property['id'],false);
			}	
				
			foreach($service['Product'] as $product)
			{
				foreach($product['Order'] as $order)
					$this->Order->delete($order['id'],false);
				$this->Product->delete($product['id'],false);
			}
			$this->Service->delete($delid,false);
			
			$this->Session->setFlash('سرویس با موفقیت حذف شد', 'default', array('class' => 'success-msg'));
		}
		$this->set('services', $this->Service->find('all', array('order' => 'Service.id DESC')));
	}
	
	function add_service ()
	{
		if ( $this->data )
		{
			$this->data['Service']['relative_services'] = implode(',',$this->data['Service']['relative_services']);
			if(empty($this->data['Service']['relative_services'])) $this->data['Service']['relative_services'] = ',';
			$monthly = 0;
			foreach($this->data['Service']['period'] as $row)
			{
				
				$monthly += $row;
			}
			$this->data['Service']['monthly'] = $monthly;

			$this->Service->create();
			if ( $this->Service->save($this->data) )
			{
				foreach($this->data['Service']['property'] as $property)
				{
					if(!empty($property)){
						$temp['Property']['name']=$property;
						$temp['Property']['service_id']= $this-> Service->id;
						$this->Property->create();
						$this->Property->save($temp);
					}
				}
				$this->Session->setFlash('اطلاعات با موفقیت ثبت شد', 'default', array('class' => 'success-msg'));
			}
			else
			{
				$this->Session->setFlash('مشکلی در ثبت اطلاعات وجود دارد', 'default', array('class' => 'error-msg'));
			}
			

		}
		$services = $this->Service->find('list',array('fields' => array('Service.id','Service.name')));
		$this->set('services', $services);
	}
	
	function edit_service ($id = null)
	{
		if ( $id )
		{
			$this->Service->id = $id;
			if ( $this->data )
			{
				$this->data['Service']['relative_services'] = implode(',',$this->data['Service']['relative_services']);
				if(empty($this->data['Service']['relative_services'])) $this->data['Service']['relative_services'] = ',';
				foreach($this->data['Service']['period'] as $row)
				{
					
					$this->data['Service']['monthly'] +=$row;
				}
				
				if ( $this->Service->save($this->data) )
				{
					foreach($this->data['Service']['oldproperty'] as $id => $oldProperty)
					{
						$this->Property->id=$id;
						if($oldProperty=='')
							$this->Property->del($id,true);
						else
						{
							$temp['Product']['name']=$oldProperty;
							$this->Property->save($temp);
						}
						
					}
					foreach($this->data['Service']['property'] as $property )
					{
						$temp['Property']['name']=$property;
						$temp['Property']['service_id']= $this-> Service->id;
						$this->Property->create();
						$this->Property->save($temp);
					}
					$this->Session->setFlash('اطلاعات با موفقیت ثبت شد', 'default', array('class' => 'success-msg'));
					$this->redirect('/managers/services');
				}
				else
				{
					$this->Session->setFlash('مشکلی در ثبت اطلاعات وجود دارد', 'default', array('class' => 'error-msg'));
				}
			}
			$this->data = $this->Service->read();
			$this->data['Service']['relative_services'] = explode(',',$this->data['Service']['relative_services']);
			$monthly = $this->Service->find('first',array('conditions'=>array('Service.id'=>$id),'fields'=>array('Service.monthly')));
			$monthly = $monthly['Service']['monthly'];
			if($monthly < 0)
			{
				$period[]='-120';
				$monthly=$monthly+120;
			}
			if($monthly-60 >= 0)
			{
				$period[]='60';
				$monthly=$monthly-60;
			}
			if($monthly-24 >= 0)
			{
				$period[]='24';
				$monthly=$monthly-24;
			}		
			if($monthly-12 >= 0)
			{
				$period[]='12';
				$monthly=$monthly-12;
			}
			if(($monthly-6) >= 0)
			{
				$period[]='6';
				$monthly=$monthly-6;
			}
			if(($monthly-3) >= 0)
			{
				$period[]='3';
				$monthly=$monthly-3;
			}
			if(($monthly-1) >= 0)
			{
				$period[]='1';
				$monthly=$monthly-1;
			}
			$apis = $this->Api->find('list',array('fields' => array('Api.id','Api.name')));
			$apis[0] = 'هيچ يک';
		
			$services = $this->Service->find('list',array('fields' => array('Service.id','Service.name')));
			$this->set('services', $services);
			$this->set('period',$period);
			$this->set('properties',$this->Property->find('all',array('conditions' => array('Property.service_id' => $id))));
			$this->set('apis',$apis );
		}
	}
	
	function pages ($delid = null)
	{
		if ( $delid )
		{
			$this->Page->id = $delid;
			$this->Page->del();
		}
		$this->set('pages', $this->Page->find('all', array('order' => 'Page.id DESC')));
	}
	
	function news ($delid = null)
	{
		if ( $delid )
		{
			$this->News->id = $delid;
			$this->News->del();
		}
		$this->set('news', $this->News->find('all', array('order' => 'News.id DESC')));
	}
	
	function add_news ()
	{
		$this->set('categories', $this->Newscategory->find('list'));
	
		if ( $this->data )
		{
			$this->data['News']['date'] = $this->Jtime->pmktime(0,0,0,$this->data['News']['date']['month'],$this->data['News']['date']['day'],$this->data['News']['date']['year']);
	
			if ( $this->News->save($this->data) )
			{
				$this->Session->setFlash('اطلاعات با موفقیت ثبت شد', 'default', array('class' => 'success-msg'));
				$this->redirect('/managers/news');
			}
			else
			{
				$this->Session->setFlash('مشکلی در ثبت اطلاعات وجود دارد', 'default', array('class' => 'error-msg'));
			}
		}
	}
	
	function edit_news ($id = null)
	{
		$this->set('categories', $this->Newscategory->find('list'));
		if ( $id )
		{
			$this->News->id = $id;
			if ( $this->data )
			{
				$this->data['News']['date'] = $this->Jtime->pmktime(0,0,0,$this->data['News']['date']['month'],$this->data['News']['date']['day'],$this->data['News']['date']['year']);
				if ( $this->News->save($this->data) )
				{
					$this->Session->setFlash(' خبر مورد نظر با موفقیت ویرایش شد', 'default', array('class' => 'success-msg'));
					$this->redirect('/managers/news');
				}
				else
				{
					$this->Session->setFlash('مشکلی در ثبت اطلاعات وجود دارد', 'default', array('class' => 'error-msg'));
				}
			}
			$this->data = $this->News->read();
		}
	}
	
	function newscategories ($delid = null)
	{
		if ( $delid )
		{
			$this->Newscategory->id = $delid;
			$this->Newscategory->del();
		}
		$this->set('newscategories', $this->Newscategory->find('all'));
	}
	
	function add_newscategory ()
	{
		if ( $this->data )
		{
			if(!empty($this->data['Newscategory']['guest_read']))
				$this->data['Newscategory']['guest_read'] == 1;
			else
				$this->data['Newscategory']['guest_read'] == 0;
	
			if ( $this->Newscategory->save($this->data) )
			{
				$this->Session->setFlash('اطلاعات با موفقیت ثبت شد', 'default', array('class' => 'success-msg'));
				$this->redirect('/managers/newscategories');
			}
			else
			{
				$this->Session->setFlash('مشکلی در ثبت اطلاعات وجود دارد', 'default', array('class' => 'error-msg'));
			}
		}
	}
	
	function edit_newscategory ($id = null)
	{
		if ( $id )
		{
			$this->Newscategory->id = $id;
			if ( $this->data )
			{
				if(!empty($this->data['Newscategory']['guest_read']))
					$this->data['Newscategory']['guest_read'] == 1;
				else
					$this->data['Newscategory']['guest_read'] == 0;
				
				if ( $this->Newscategory->save($this->data) )
				{
					$this->Session->setFlash('شاخه با موفقيت ويرايش يافت.', 'default', array('class' => 'success-msg'));
					$this->redirect('/managers/newscategories');
				}
				else
				{
					$this->Session->setFlash('مشکلی در ثبت اطلاعات وجود دارد', 'default', array('class' => 'error-msg'));
				}
			}
			$this->data = $this->Newscategory->read();
		}
	}
	
	function add_page ()
	{
		if ( $this->data )
		{
			if ( $this->Page->save($this->data) )
			{
				$this->Session->setFlash('اطلاعات با موفقیت ثبت شد', 'default', array('class' => 'success-msg'));
				$this->redirect('/managers/pages');
			}
			else
			{
				$this->Session->setFlash('مشکلی در ثبت اطلاعات وجود دارد', 'default', array('class' => 'error-msg'));
			}
		}
	}
	
	function edit_page ($id = null)
	{
		if ( $id )
		{
			$this->Page->id = $id;
			if ( $this->data )
			{
				if ( $this->Page->save($this->data) )
				{
					$this->Session->setFlash('صفحه با موفقیت ویرایش شد', 'default', array('class' => 'success-msg'));
					$this->redirect('/managers/pages');
				}
				else
				{
					$this->Session->setFlash('مشکلی در ثبت اطلاعات وجود دارد', 'default', array('class' => 'error-msg'));
				}
			}
			$this->data = $this->Page->read();
		}
	}
	
	function menus ($delid = null)
	{
		if ( $delid )
		{
			$this->Menu->id = $delid;
			$this->Menu->del();
		}
		$this->set('menus', $this->Menu->find('all', array('order' => 'Menu.id DESC')));
	}
	
	function add_menu ()
	{
		if ( $this->data )
		{
			if ( $this->Menu->save($this->data) )
			{
				$this->Session->setFlash('اطلاعات با موفقیت ثبت شد', 'default', array('class' => 'success-msg'));
				$this->redirect('/managers/menus');
			}
			else
			{
				$this->Session->setFlash('مشکلی در ثبت اطلاعات وجود دارد', 'default', array('class' => 'error-msg'));
			}
		}
	}
	
	function edit_menu ($id = null)
	{
		if ( $id )
		{
			$this->Menu->id = $id;
			if ( $this->data )
			{
				if ( $this->Menu->save($this->data) )
				{
					$this->Session->setFlash('اطلاعات با موفقیت ثبت شد', 'default', array('class' => 'success-msg'));
					$this->redirect('/managers/menus');
				}
				else
				{
					$this->Session->setFlash('مشکلی در ثبت اطلاعات وجود دارد', 'default', array('class' => 'error-msg'));
				}
			}
			$this->data = $this->Menu->read();
		}
	}	
	
	function departments ($delid = null)
	{
		if ( $delid )
		{
			$this->Ticketdepartment->id = $delid;
			$this->Ticketdepartment->del();
		}
		$this->set('departments', $this->Ticketdepartment->find('all'));
	}
	
	function add_department ()
	{
		if ( $this->data )
		{
			if ( $this->Ticketdepartment->save($this->data) )
			{
				$this->Session->setFlash('اطلاعات با موفقیت ثبت شد', 'default', array('class' => 'success-msg'));
				$this->redirect('/managers/departments');
			}
			else
			{
				$this->Session->setFlash('مشکلی در ثبت اطلاعات وجود دارد', 'default', array('class' => 'error-msg'));
			}
		}
	}
	
	function edit_department ($id = null)
	{
		if ( $id )
		{
			$this->Ticketdepartment->id = $id;
			if ( $this->data )
			{
				if ( $this->Ticketdepartment->save($this->data) )
				{
					$this->Session->setFlash('اطلاعات با موفقیت ثبت شد', 'default', array('class' => 'success-msg'));
					$this->redirect('/managers/departments');
				}
				else
				{
					$this->Session->setFlash('مشکلی در ثبت اطلاعات وجود دارد', 'default', array('class' => 'error-msg'));
				}
			}
			$this->data = $this->Ticketdepartment->read();
		}
	}

	function payments ($delid = null)
	{
		if ( $delid )
		{
			$this->Payment->id = $delid;
			$this->Payment->del();
		}
		$this->set('payments', $this->Payment->find('all', array('order' => 'Payment.id DESC')));
	}
	
	function add_payment ()
	{
		if ( $this->data )
		{
			if ( $this->Payment->save($this->data) )
			{
				$this->Session->setFlash('اطلاعات با موفقیت ثبت شد', 'default', array('class' => 'success-msg'));
				$this->redirect('/managers/payments');
			}
			else
			{
				$this->Session->setFlash('مشکلی در ثبت اطلاعات وجود دارد', 'default', array('class' => 'error-msg'));
			}
		}
	}
	
	function edit_payment ($id = null)
	{
		if ( $id )
		{
			$this->Payment->id = $id;
			if ( $this->data )
			{
				if ( $this->Payment->save($this->data) )
				{
					$this->Session->setFlash('اطلاعات با موفقیت ثبت شد', 'default', array('class' => 'success-msg'));
					$this->redirect('/managers/payments');
				}
				else
				{
					$this->Session->setFlash('مشکلی در ثبت اطلاعات وجود دارد', 'default', array('class' => 'error-msg'));
				}
			}
			$this->data = $this->Payment->read();
		}
	}
	function add_customer ()
	{
		if ( $this->data )
		{
			if ( $this->Customer->save($this->data) )
			{
				$this->Session->setFlash('اطلاعات با موفقیت ثبت شد', 'default', array('class' => 'success-msg'));
				$this->redirect('/managers/customers');
			}
			else
			{
				$this->Session->setFlash('مشکلی در ثبت اطلاعات وجود دارد', 'default', array('class' => 'error-msg'));
			}
		}
	}
	
	function edit_customer ($id = null)
	{
		if ( $id )
		{
			$this->Customer->id = $id;
			if ( $this->data )
			{
				if ( $this->Customer->save($this->data) )
				{
					$this->Session->setFlash('اطلاعات با موفقیت ثبت شد', 'default', array('class' => 'success-msg'));
					$this->redirect('/managers/customers');
				}
				else
				{
					$this->Session->setFlash('مشکلی در ثبت اطلاعات وجود دارد', 'default', array('class' => 'error-msg'));
				}
			}
			$this->data = $this->Customer->read();
		}
	}
	
	function customers ($delid = null)
	{
		if ( $delid )
		{
			$this->Customer->id = $delid;
			$this->Customer->del();
		}
		$this->set('customers', $this->Customer->find('all', array('order' => 'Customer.id DESC')));
	}
	
	function edit_setting()
	{
		if($this->data)
		{
			$this->Setting->id=$this->Setting->find('id');
			$this->Setting->save($this->data);
			$this->Session->setFlash('تنظیمات با موفقیت ذخیره شد', 'default', array('class' => 'success-msg'));
			$this->redirect('/managers/home') ;
		}else
		{
			$this->data=$this->Setting->find();
		}
	}
	
	function invoice($id)
	{
		
		
		if(isset($this->data['invoice']['order_id']))
		{
			$count=0;
			foreach($this->data['invoice']['order_id'] as $id)
			{
				$order[$count] = $this->Order->find('first',array('conditions'=>array('Order.id'=>$id),'recursive' =>2));
				$price=$this->costs($order[$count]['Product']['cost']);
				$order[$count]['Product']['cost']=$price[$order[$count]['Order']['monthly']]-$order[$count]['Order']['discount'];
				$count++;
			}
			
			
		}else
		{
			$order[0] = $this->Order->find('first',array('conditions'=>array('Order.id'=>$id),'recursive' =>2));
			$price=$this->costs($order[0]['Product']['cost']);
			$order[0]['Product']['cost']=$price[$order[0]['Order']['monthly']]-$order[0]['Order']['discount'];
		}
		$this->set('settings',$this->Setting->find());
		//print_r($order);
		$this->set('info',$order);
		$this->set('client',$this->User->findById($order[0]['Order']['user_id']));
		$this->render('/users/invoice' ,'invoice');
	}
	function edit_user($id=null)
	{
		if($id)
		{
			$this->set('id',$id);
			$this->User->id=$id;
			if($this->data)
			{
				if(!empty($this->data['User']['password'])){
					if($this->data['User']['password'] == $this->Auth->password($this->data['User']['password_confirm'])){
					
						if($this->User->save($this->data, array('validate' => false))){
						$this->Session->setFlash('مشخصات و کلمه عبور مشتری ویرایش شد .', 'default', array('class' => 'success-msg'));
						$this->redirect('/managers/users');
						}else{
						$this->Session->setFlash('مشکلی در ثبت اطلاعات به وجود آمده است', 'default', array('class' => 'error-msg'));
						}
						
					}else{
						$this->Session->setFlash('کلمه عبور وارد شده با تکرار آن همخوانی ندارد .', 'default', array('class' => 'error-msg'));
						$this->data['User']['password'] = '';
						$this->data['User']['password_confirm'] = '';
					}
				
				}else{
					if($this->User->save($this->data, array('validate' => false))){
						$this->Session->setFlash('مشخصات مشتری با موفقیت ویرایش شد', 'default', array('class' => 'success-msg'));
						$this->redirect('/managers/users');
					}else{
						$this->Session->setFlash('مشکلی در ثبت اطلاعات به وجود آمده است', 'default', array('class' => 'error-msg'));
					}
				}
			}else
			{
				$this->data=$this->User->read();
				$this->data['User']['password'] = '';
			}
		}	
	}
	function messages($id=null,$operation=null)
	{
		if(empty($id))
			$this->set('messages',$this->paginate('Message'));
		else
		{
			if($operation == "delete")
			{
				$this->Message->id=$id;
				$this->Message->del();
				$this->Session->setFlash('پیام با موفقیت حذف شد', 'default', array('class' => 'success-msg'));
				$this->redirect('/managers/messages');
			}else
				$this->set('message',$this->Message->findById($id));
		}
	}		
	function user_confirm($id)	
	{
			$this->User->id=$id;
			$temp['User']['role']='0';		
			$this->User->save($temp);	
			$user=$this->User->read();
			$this->set('client',$user);		
			$this->set('setting',$this->setting);
			$this->Email->to = $user['User']['email'];	
			$this->Email->from = $this -> setting['mail_title'].' <'.$this -> setting['noreply_mail_address'].'>';	
			$this->Email->subject = 'شناسه کاربری شما فعال شد';	
			$this->Email->template = 'userconfirm';	
			$this->Email->sendAs = 'html';	
			$this->Email->send();	
			$this->redirect('/managers/users');
	}
	
	 function register() {
		 if ($this->data) {
			 if ($this->data['User']['password'] == $this->Auth->password($this->data['User']['password_confirm'])) {
		
				$this->User->create();
				if($this->data['User']['send_mail']==1)
					$this->data['User']['role']=0;
				elseif($this->data['User']['send_mail']==0)
					$this->data['User']['role']=-1;

				if($this->User->save($this->data)) 
				{
					$message='شناسه کاربری با موفقیت ساخته شده است';
					if($this->data['User']['send_mail']==0)
					{
						$message .=' و پست الکترونیکی فرستاده شد';
						$key=$this->data['User']['password'].'samansystems';
						$key=md5($key);
						$key=substr($key,2,12);
						$this->set('user',$this->data);
						$this->set('key',$key);
						$this->set('setting',$this->setting);					
						$this->Email->to = $this->data['User']['email'] ;
						$this->Email->from = $this -> setting['mail_title'].' <'.$this -> setting['noreply_mail_address'].'>';
						$this->Email->subject = 'شناسه کاربری در '.$this->setting['name'].' برای شما ساخته شده است';
						$this->Email->template = 'userconfirm';
						$this->Email->sendAs = 'html';
						$this->Email->send();
					}
					$this->Session->setFlash($message, 'default', array('class' => 'success-msg'));							
					$this->redirect('/managers/home');
					
				}else
				{
					$this->data['User']['password'] = $this->data['User']['password_confirm'] ='';
					$this->Session->setFlash('‍‍مشکلی در ثبت پیش آمده است ', 'default', array('class' => 'error-msg'));							
				}
			 }
		 }
	 }
	 function user_delete($user_id=0)
	 {
		$this->layout='ajax';
		$transaction=$this->Transaction->find('count',array('conditions'=>array(
									  'Transaction.user_id'=>$user_id
									  )
						       )
					 );
		if($transaction > 0)
		{
			$this -> Session->setFlash('کاربر مورد نظر دارای تراکنش فعال است این کاربر نمی تواند حذف بشود', 'default', array('class' => 'error-msg'));
		}else{
			$this->User->id =$user_id;
			if($this->User->del())
				$this->Session->setFlash('کاربر مورد نظر با موفقیت حذف شد', 'default', array('class' => 'success-msg'));
			else
				$this->Session->setFlash('مشکلی در حذف کاربر رخ داده است ', 'default', array('class' => 'error-msg'));
			
		}
		$this -> redirect('/managers/users');
		
		
	 }
	 function productproperty()
	 {
		$this->layout='ajax';
		$service=$this->Service->findById($_POST['service_id']);
		$monthly = $service['Service']['monthly'];
		if($monthly < 0)
		{
			$period[]='-120';
			$monthly=$monthly+120;
		}
		if($monthly-60 >= 0)
		{
			$period[]='60';
			$monthly=$monthly-60;
		}
		if($monthly-24 >= 0)
		{
			$period[]='24';
			$monthly=$monthly-24;
		}		
		if($monthly-12 >= 0)
		{
			$period[]='12';
			$monthly=$monthly-12;
		}
		if(($monthly-6) >= 0)
		{
			$period[]='6';
			$monthly=$monthly-6;
		}
		if(($monthly-3) >= 0)
		{
			$period[]='3';
			$monthly=$monthly-3;
		}
		if(($monthly-1) >= 0)
		{
			$period[]='1';
			$monthly=$monthly-1;
		}
		foreach($service['Property'] as $row)
		{
			$return .='<label>'.$row['name'] .' :</label><input name="data[Product][property]['.$row['id'].']" type="text" value=""   /><br /><br />';
		}
		foreach($period as $month)
		{
			$return .='<label>قیمت  '.$month.' ماهه'.'</label><input name="data[Product][costs]['.$month.'] type="text" value="" /><br /><br />';
		}
		echo  $return;
	 }
        
	function costs($string)
	 {
            $costs=explode(':',$string);
            foreach($costs  as $row)
            {
                $temp=explode(',',$row);
                $price[$temp[0]]=$temp[1];
            }
	    array_pop($price);
            return $price;
	 }
	 
	function user_tickets($user_id=null) 
	{
		$user=$this->User->findById($user_id);
		$this->set('client',$user);
		$tickets=$this->Ticket->find('all',array('conditions'=>array('Ticket.user_id' => $user_id), 'order' => array('Ticket.id DESC','Ticket.status ASC','Ticket.priority DESC')));
		$this->set('tickets',$tickets);
	}
	 
	function tickets($ticket_id=null) 
	{
		if(!isset($ticket_id)){
            $this->paginate = array('limit' => 15, 'order' => array('Ticket.status ASC','Ticket.priority DESC'));
			$this->set('tickets', $this->paginate('Ticket',array('Ticket.status' => array('0','2'))));
			$this->Ticket->updateAll(array('Ticket.status' => 5),array('Ticket.status' => array(1,6), 'Ticket.date <' => time()-432000));
		}
		else 
		{
                        $this->paginate = array('limit' => 15, 'order' => array('Ticket.id DESC','Ticket.status ASC','Ticket.priority DESC'));
                        
			switch ($ticket_id) {
				case 'all':
					$tickets = $this->paginate('Ticket');
					$this->set('tickets',$tickets);
					break;
				case 'inwork':
					$tickets = $this->paginate('Ticket', array('Ticket.status' => array('0', '2', '3', '4')));
					$this->set('tickets',$tickets);
					break;
				case 'open':
                                        $tickets = $this->paginate('Ticket', array('Ticket.status' => '0'));
					$this->set('tickets',$tickets);
					break;
				case 'answered':
                                        $tickets = $this->paginate('Ticket', array('Ticket.status' => '1'));
					$this->set('tickets',$tickets);
					break;
				case 'customer-reply':
                                        $tickets = $this->paginate('Ticket', array('Ticket.status' => '2'));
					$this->set('tickets',$tickets);
					break;
				case 'on-hold':
                                        $tickets = $this->paginate('Ticket', array('Ticket.status' => '3'));
					$this->set('tickets',$tickets);
					break;
				case 'in-progress':
                                        $tickets = $this->paginate('Ticket', array('Ticket.status' => '4'));
					$this->set('tickets',$tickets);
					break;
				case 'closed':
                                        $tickets = $this->paginate('Ticket', array('Ticket.status' => '5'));
					$this->set('tickets',$tickets);
					break;
				case 'system-open':
                                        $tickets = $this->paginate('Ticket', array('Ticket.status' => '6'));
					$this->set('tickets',$tickets);
					break;
				case 'flaged-to-me':
					$tickets = $this->paginate('Ticket', array('Ticket.status' => array('0', '2', '3', '4'),'Ticket.flag_user_id' => $this->Auth->user('id')));
					$this->set('tickets',$tickets);
					break;
				default:
					$tickets=$this->Ticket->find('first',array('conditions'=>array('Ticket.id'=>$ticket_id),'recursive' => 1));
					$ticketreplies=$this->Ticketreply->find('all',array('conditions'=>array('Ticketreply.ticket_id'=>$ticket_id),'order' => array('Ticketreply.date ASC')));
					$user_tickets=$this->Ticket->find('all',array('conditions'=>array('Ticket.user_id'=>$tickets[Ticket][user_id]), 'limit'=>5, 'order' => array('Ticket.status ASC','Ticket.priority DESC')));
					if($tickets['Ticket']['user_id'] == -1){
						$message=$this->Message->find('first',array('conditions'=>array('Message.ticket_id' => $ticket_id)));
						$this->set('message',$message);
					}
					$this->set('setting',$this -> setting);
					$this->set('ticketreplies',$ticketreplies);
					$this->set('departments',$this->Ticketdepartment->find('list',array('fields'=> array('Ticketdepartment.id','Ticketdepartment.name'),'order'=> 'Ticketdepartment.department_order')));
					$this->set('statuses',array('1'=>'پاسخ داده شده','3'=>'در انتظار','4'=>'در دست برسی','5'=>'بسته شده'));
					$this->set('priorities',array('0'=>'عادی','1'=>'مهم','2'=>'خيلی مهم'));
					$this->set('flag_users',$this->User->find('list',array('conditions'=>array('User.role >'=>1), 'fields'=> array('User.id','User.name'),'order'=> 'User.role')));
					$this->set('ticket',$tickets);
					$this->set('user_tickets',$user_tickets);
					$Signature = $this->Signature->find('first', array('conditions' => array('Signature.user_id' => $this->Auth->user('id'))));
					$this->data['Ticketreply']['content'] = $Signature['Signature']['text'];
			}
		}
		
	}
	function postticket($user_id,$remote = 0)
	{
		if (!empty($this->data)) {
		
			if(!empty($this->data['Ticket']['file']['name'])){
				$FileType = explode(".", $this->data['Ticket']['file']['name']);
				
				switch($this->data['Ticket']['file']['type'])
				{
					case 'application/zip':
						$FileTypeValid = true;
						break;
					case 'application/x-zip':
						$FileTypeValid = true;
						break;
					case 'application/x-zip-compressed': 
						$FileTypeValid = true;
						break;
					case 'multipart/x-zip': 
						$FileTypeValid = true;
						break;
					case 'application/s-compressed': 
						$FileTypeValid = true;
						break;
					default :
						$FileTypeValid = false;
						break;
				}
				
				if(strtolower($FileType[1]) == "zip" && $FileTypeValid == true){
					$NewFileName = String::uuid().".zip";
					$temp['Ticketreply']['attached_file'] = $NewFileName;
					move_uploaded_file($this->data['Ticket']['file']['tmp_name'], "../uploads/".$NewFileName);
				}else{
					$this->Session->setFlash('فایل ارسالی مجاز نمی باشد .','default', array('class' => 'error-msg'));
					$this->redirect(array('controller' => 'managers','action' => 'postticket',$ticket_id));
				}
			}
		
			$this->data['Ticket']['user_id'] = $user_id;
			$this->data['Ticket']['date'] = time();
			$this->data['Ticket']['user_unread'] = 1;
			if ($this->Ticket->save($this->data)) {
			
				$user_id = $this->Auth->user('id');
				if(empty($user_id)) $user_id = 0;
				
				$temp['Ticketreply']['user_id'] = $user_id;
				$temp['Ticketreply']['content'] = $this->data['Ticket']['content'];
				$temp['Ticketreply']['date'] = time();
				$temp['Ticketreply']['ticket_id'] = $this->Ticket->id;
			
				if($this->Ticketreply->save($temp))
				{
						if($this -> setting['send_email']==1)
						{
							$this->set('ticket_title',$this->data['Ticket']['title']);
							$this->set('ticket_content', $this->blockqoute($temp['Ticketreply']['content']));
							$this->set('ticket_id',$this->Ticket->id);
							$this->set('opendate',$this->data['Ticket']['date']);
							$this->set('setting',$this->setting);
							$to_user=$this->User->find('first' , array('conditions'=>array('User.id'=>$this->data['Ticket']['user_id'])));
							$this->Email->to = $to_user['User']['email'];
							$this->Email->from = $this -> setting['mail_title'].' <'.$this -> setting['noreply_mail_address'].'>';
							$this->Email->subject = 'تيکت جديد: #'.$this->Ticket->id.' - '.$this->data['Ticket']['title'];
							$this->Email->template = 'ticketopen';
							$this->Email->sendAs = 'html';
							$this->Email->send();
						}
						if($this->setting['send_sms']==1)
						{
							$this->Asresms->SetVar('gateway_number', $this->setting['gateway_number']);
							$this->Asresms->SetVar('gateway_pass', $this->setting['gateway_pass']);
							if(!empty($user['User']['cellnum']) && strlen($user['User']['cellnum']) == 11 && substr($user['User']['cellnum'], 0, 2) == '09'){
								$this->Asresms->Send(array('cell' => $user['User']['cellnum'], 'text' => " تيکت جديدی با عنوان ". $this->data['Ticket']['title'] ." افتتاح گرديده است. \n\n".$this->setting['name'], 'flash' => 0));
							}
						}
						
					if(!$remote){
						$this->Session->setFlash('تيکت شما با موفقيت ثبت شد.','default', array('class' => 'success-msg'));
						$this->redirect(array('controller' => 'managers','action' => 'tickets',$this->Ticket->id));
					}
				}
			}
		}
		$this->set('priorities',array('0'=>'عادی','1'=>'مهم','2'=>'خيلی مهم'));
		$this->set('statuses',array('1'=>'پاسخ داده شده','3'=>'در انتظار','4'=>'در دست برسی','5'=>'بسته شده'));
		$this->set('departments',$this->Ticketdepartment->find('list',array('fields'=> array('Ticketdepartment.id','Ticketdepartment.name'),'order'=> 'Ticketdepartment.department_order')));
		$to_user=$this->User->find('first',array('conditions'=>array('User.id' =>$user_id)));
		$this->set('to_user',$to_user);
	}
	function postticketreply($ticket_id,$remote = 0)
	{
		$ticket = $this->Ticket->find('first', array('conditions' => array('Ticket.id' => $ticket_id)));
		if(!empty($ticket)){
			if(!empty($this->data['Ticketreply']['file']['name'])){
				$FileType = explode(".", $this->data['Ticketreply']['file']['name']);
				switch($this->data['Ticketreply']['file']['type'])
				{
					case 'application/zip':
						$FileTypeValid = true;
						break;
					case 'application/x-zip':
						$FileTypeValid = true;
						break;
					case 'application/x-zip-compressed': 
						$FileTypeValid = true;
						break;
					case 'multipart/x-zip': 
						$FileTypeValid = true;
						break;
					case 'application/s-compressed': 
						$FileTypeValid = true;
						break;
					default :
						$FileTypeValid = false;
						break;
				}
				
				if(strtolower($FileType[1]) == "zip" && $FileTypeValid == true){
					$NewFileName = String::uuid().".zip";
					$this->data['Ticketreply']['attached_file'] = $NewFileName;
					move_uploaded_file($this->data['Ticketreply']['file']['tmp_name'], "../uploads/".$NewFileName);
				}else{
					$this->Session->setFlash('فایل ارسالی مجاز نمی باشد .','default', array('class' => 'error-msg'));
					$this->redirect(array('controller' => 'managers','action' => 'tickets',$ticket_id));
				}
			}
		
			if (!empty($this->data)){
				if(empty($this->data['Ticketreply']['submitnote'])){
					$this->data['Ticketreply']['ticket_id'] = $ticket_id;
					
					$user_id = $this->Auth->user('id');
					if(empty($user_id)) $user_id = 0;
					
					$this->data['Ticketreply']['user_id'] = $user_id;
					$this->data['Ticketreply']['date'] = time();

					$this->Ticketreply->create();
						if($this->Ticketreply->save($this->data))
						{
							$temp = array('status' => $this->data['Ticketreply']['status'], 'priority' => $this->data['Ticketreply']['priority'], 'flag_user_id' => $this->data['Ticketreply']['flag_user_id']) ;
						
							$this->Ticket->id = $ticket_id;
							$this->data['Ticket']['ticketdepartment_id'] = $this->data['Ticketreply']['ticketdepartment_id'];
							$this->data['Ticket']['user_unread'] = 1;
							$this->data['Ticket']['status'] = $temp['status'];
							$this->data['Ticket']['priority'] = $temp['priority'];
							$this->data['Ticket']['flag_user_id'] = $temp['flag_user_id'];
							if($this->Ticket->save($this->data))
							{
								$ticket=$this->Ticket->find('first' , array('conditions'=>array('Ticket.id'=>$ticket_id)));
								
								if($ticket['Ticket']['user_id'] == -1){
									$message=$this->Message->find('first',array('conditions'=>array('Message.ticket_id' => $ticket_id)));
									$this->Email->to = $message['Message']['email'];
									$this->set('message',$message);
									$mobile = $message['Message']['phone'];
								}
								else{
									$user=$this->User->find('first' , array('conditions'=>array('User.id'=>$ticket['Ticket']['user_id'])));
									$this->Email->to = $user['User']['email'];
									$mobile = $user['User']['cellnum'];
								}
								
								if($this -> setting['send_email']==1)
								{
									$this->set('reply_content',$this->blockqoute($this->data['Ticketreply']['content']));
									$this->set('ticket_id',$ticket_id);
									$this->set('replydate',$this->data['Ticketreply']['date']);
									$this->set('setting',$this->setting);
									$this->Email->from = $this -> setting['mail_title'].' <'.$this -> setting['noreply_mail_address'].'>';
									$this->Email->subject = 'پاسخ جديد در تيکت: #'.$this->Ticket->id.' - '.$ticket['Ticket']['title'];
									$this->Email->template = 'ticketreply';
									$this->Email->sendAs = 'html';
									$this->Email->send();
								}
								
								if($this->setting['send_sms']==1)
								{
									$this->Asresms->SetVar('gateway_number', $this->setting['gateway_number']);
									$this->Asresms->SetVar('gateway_pass', $this->setting['gateway_pass']);
									
									if(strlen($mobile) == 11 && substr($mobile, 0, 2) == '09')
										$this->Asresms->Send(array('cell' => $mobile, 'text' => "پاسخی در تيکت  با عنوان ". $ticket['Ticket']['title'] ." ارسال شد.\n\n".$this->setting['name'], 'flash' => 0));
								}
								
							}
								if(!$remote){
									$this->Session->setFlash('پاسخ به تيکت مورد نظر با موفقيت ارسال شد.','default', array('class' => 'success-msg'));
								}
						}else
							$this->Session->setFlash('پاسخ ارسالی بايد حاوی نوشته باشد.','default', array('class' => 'error-msg'));
						
				}
				elseif(!empty($this->data['Ticketreply']['submitnote'])){
					$this->data['Ticketreply']['ticket_id'] = $ticket_id;
					$this->data['Ticketreply']['user_id'] = $this->Auth->user('id');
					$this->data['Ticketreply']['date'] = time();
					$this->data['Ticketreply']['note'] = 1;
					$this->Ticketreply->create();
					if($this->Ticketreply->save($this->data))
					{							
						$this->Session->setFlash('يادداشت با موفقيت ثبت شد.','default', array('class' => 'success-msg'));
					}else
						$this->Session->setFlash('يادداشت بايد حاوی نوشته باشد.','default', array('class' => 'error-msg'));
				}
			}
			if(!$remote){
				$this->redirect(array('controller' => 'managers','action' => 'tickets',$ticket_id));
			}
		}
		else
		{
			$this->Session->setFlash('تيکتي با اين مشخصات وجود ندارد.','default', array('class' => 'error-msg'));
			$this->redirect(array('controller' => 'managers','action' => 'tickets'));
		}
	}
	function deleteticket($ticket_id)
	{
		$ticketreplycount = $this->Ticketreply->find('count',array('conditions'=>array(
							  'Ticketreply.ticket_id'=>$ticket_id
							  )
				       )
			 );
		if ($ticketreplycount < 2){
			//delete ticket
			$this->Ticket->id = $ticket_id;	
			$this->Ticket->del();
			//delete reply
			$this->Ticketreply->deleteAll(array('Ticketreply.ticket_id' => $ticket_id));
			
			$this->Session->setFlash('تيکت حذف شد.','default', array('class' => 'success-msg'));			
			$this->redirect(array('controller' => 'managers','action' => 'tickets'));
		}
		else{
			$this->Session->setFlash('تيکت دارای پاسخ ميباشد و بنابراين امکان حذف وجود ندارد.','default', array('class' => 'error-msg'));			
			$this->redirect(array('controller' => 'managers','action' => 'tickets',$ticket_id));
		}
	}
	function checkcardcharges($status){
		if(!empty($this->data)){
			foreach($this->data['accept'] as $arow)
			{
				if(!empty($arow)){
					$this->Cardcharge->id = $arow;
					$temp['Cardcharge']['admin_check'] = 1;
					$this->Cardcharge->save($temp);
					unset($temp);
					$a++;
				}
			}
			foreach($this->data['failed'] as $frow)
			{
				if(!empty($frow)){
					$this->Cardcharge->id = $frow;
					$temp['Cardcharge']['admin_check'] = 2;
					$this->Cardcharge->save($temp);
					$payment=$this->Payment->find('first' , array('filds'=>array('id'),'conditions'=>array('Payment.pin'=>'cardcharge')));
					$cardinfo = $this->Cardcharge->find('first' , array('conditions'=>array('Cardcharge.id'=>$frow,'Cardcharge.user_id !='=>0)));
					if(!empty($cardinfo['Cardcharge']['user_id'])){
						$this->data['Transaction']['user_id'] = $cardinfo['Cardcharge']['user_id'];
						$this->data['Transaction']['amount'] = -($cardinfo['Cardcharge']['credit']);
						$this->data['Transaction']['date'] = time();
						$this->data['Transaction']['confirmed'] = 1;
						$this->data['Transaction']['payment_id'] = $payment['Payment']['id'];
						$this->data['Transaction']['desc'] = ' رد کارت به شماره '.$cardinfo['Cardcharge']['id'];
						$this->Transaction->save($this->data);
					}
					unset($temp);
					$f++;
				}
			}
			if(($a > 0) & ($f > 0))
			$this->Session->setFlash('تعداد '.$a.' کارت شارژ تاييد و '.$f.' کارت شارژ رد شد.','default', array('class' => 'success-msg'));
			elseif($a > 0)
			$this->Session->setFlash('تعداد '.$a.' کارت شارژ با موفقيت تاييد شد.','default', array('class' => 'success-msg'));
			elseif($f > 0)
			$this->Session->setFlash('تعداد '.$f.' کارت شارژ با موفقيت رد شد.','default', array('class' => 'success-msg'));
			else
			$this->Session->setFlash('هيچ عملياتی روی کارت شارژ ها انجام نشد.','default', array('class' => 'error-msg'));
			$this->redirect(array('controller' => 'managers','action' => 'checkcardcharges'));
		}
		else{
			switch ($status){
				case 'notsubmited':
					$this->paginate=array('limit'=>15,'order'=>'Cardcharge.start_date DESC');
					$this->set('listcards',$this->paginate('Cardcharge',array('Cardcharge.user_id'=> 0)));
				break;
				case 'notchecked':
					$this->paginate=array('limit'=>15,'order' => 'Cardcharge.submit_date DESC');
					$this->set('listcards',$this->paginate('Cardcharge',array('Cardcharge.user_id !='=> 0,'Cardcharge.admin_check'=>0)));
				break;
				case 'verified':
					$this->paginate=array('limit'=>15,'order' => 'Cardcharge.submit_date DESC');
					$this->set('listcards',$this->paginate('Cardcharge',array('Cardcharge.admin_check'=> 1)));
				break;
				case 'faild':
					$this->paginate=array('limit'=>15,'order'=>'Cardcharge.start_date DESC');
					$this->set('listcards',$this->paginate('Cardcharge',array('Cardcharge.admin_check'=> 2)));
				break;
				default:
					$this->paginate=array('limit'=>15,'order'=>'Cardcharge.start_date DESC');
					$this->set('listcards',$this->paginate('Cardcharge'));
			}
		}
	}
	function makecardcharge($make){
		if($make == 'make' && !empty($this->data['Cardcharge']['credit'])){
			$f1 = rand(10, 9999999999);
			$f2 = md5($f1);
			$p1 = rand(-5, -32);
			$this->data['Cardcharge']['security_code'] = substr($f2, $p1, 5);
			$this->data['Cardcharge']['start_date'] = time();
			if($this->Cardcharge->save($this->data)){
				$this->set('cardbarcode',$this->data['Cardcharge']['start_date'].$this->Cardcharge->id);
				$this->set('cardid',$this->Cardcharge->id);
				$this->set('cardpassword',$this->data['Cardcharge']['security_code']);
				$this->set('cardcredit',$this->data['Cardcharge']['credit']);
			}
		}
	}
	function printcardcharge($cardid){
		$this->layout = 'printcardcharge';
		$cardinfo = $this->Cardcharge->find('first' , array('conditions'=>array('Cardcharge.id'=>$cardid)));
		$this->set('cardinfo',$cardinfo);
	}
	function closeticket($ticket_id)
	{
		$ticket=$this->Ticket->find('first',array('conditions'=>array('Ticket.id'=>$ticket_id)));
		if(!empty($ticket))
		{
			$this->Ticket->id = $ticket_id;
			$this->data['Ticket']['status'] = 5;
			if($this->Ticket->save($this->data)){
				$this->Session->setFlash('وضعيت تيکت به بسته شده تغيير يافت.','default', array('class' => 'success-msg'));
				$this->redirect(array('controller' => 'managers','action' => 'tickets',$ticket_id));
			}
		}
		else
		{
			$this->Session->setFlash('تيکتی با اين مشخصات پيدا نشد.','default', array('class' => 'error-msg'));
			$this->redirect(array('controller' => 'managers','action' => 'tickets'));
		}
	}
	function deletealltransaction($user_id)
	{			
		$this->Transaction->deleteAll(array('Transaction.user_id' => $user_id));
		$this->Session->setFlash('تراکنش های مورد نظر با موفقيت حذف شدند.', 'default', array('class' => 'success-msg'));
		$this->redirect(array('controller' => 'managers', 'action' => 'contact',$user_id));
	}
	function loginas($userid)
	{
		$this->layout = 'ajax';
		if(is_numeric($userid)){
			$this->Session->write('Admin.userid', $this->Auth->user('id'));
			$user = $this->User->findById($userid);
			$data['User']['email'] = $user['User']['email'];
			$data['User']['password'] = $user['User']['password'];
			$this->Auth->login($data);
			$this->Session->setFlash('ورود با حساب کاربری '. $user['User']['name'] .' صورت پذيرفت.','default', array('class' => 'success-msg'));
			$this->redirect(array('controller' => 'users','action' => 'home'));
		}
	}
	
	function admin_back(){
		
		$this->layout = 'ajax';
		$userid = $this->Session->read('Admin.userid');
		if(!empty($userid)){
			$this->Session->destroy();
			$user = $this->User->findById($userid);
			$data['User']['email'] = $user['User']['email'];
			$data['User']['password'] = $user['User']['password'];
			$this->Auth->login($data);
			$this->Session->setFlash('ورود با حساب کاربری '. $user['User']['name'] .' صورت پذيرفت.','default', array('class' => 'success-msg'));
			$this->redirect(array('controller' => 'managers','action' => 'home'));
		}
		
	}
	
	function remote($username,$password)
	{
		$this->layout = 'ajax';
		$username = base64_decode($username);	
		$password = $this->Auth->password(base64_decode($password));
		
		$data['User']['email'] = $username;
		$data['User']['password'] = $password;
		if($this->Auth->login($data))
		{
			$temp = $this->Transaction->find('first', array( 'conditions' => array('Transaction.confirmed' => 0),
												'fields' => array('SUM(Transaction.amount) as tot')
											 ));
			if(empty($temp[0]['tot'])) $temp[0]['tot'] = 0;
			
			$state = array(
				'state' => array(
					"0" => array(
							'untransactions' =>
											array(
												'count'  => $this->Transaction->find('count', array( 'conditions' => array('Transaction.confirmed' => 0))),
												'amount' => $temp[0]['tot']
											)
					),
					"1" => array(
							'untickets' => 
											array(
												'urgent' => $this->Ticket->find('count',array('conditions'=>array('Ticket.status' => array('0','2') ))),
												'working' => $this->Ticket->find('count',array('conditions'=>array('Ticket.status' => array('0','2' , '4' ,'3') )))
											)
					),
					"2" => array(
							'unorders' => 
											array(
												'unconfirmed' => $this->Order->find('count',array('conditions'=>array('Order.confirmed' => 0))),
												'near_elapsed' => $this->nearPay(7,0,true)
											)
					),
					"3" => array(
							'cardcharge' => 
											array(
												'c_count' => $this->Cardcharge->find('count',array('conditions'=>array('Cardcharge.user_id !=' => 0, 'Cardcharge.admin_check' => 0)))
											)
					)
				)
			);
			$this->set('state',$state);
		}	
	}
        
        function apis ($delid = null)
	{
		if ( $delid )
		{
			$this->Api->id = $delid;
			$this->Api->del();
		}
		$this->set('data', $this->Api->find('all', array('order' => 'Api.id DESC')));
	}
        
        function api_edit($id=null)
	{
		if($id)
		{
			$this->set('id',$id);
			$this->Api->id=$id;
			if($this->data)
			{
				if($this->Api->save($this->data)){
					$this->Session->setFlash('اطلاعات با موفقیت ویرایش شد', 'default', array('class' => 'success-msg'));
					$this->redirect('/managers/apis');
				}
				else
					$this->Session->setFlash('مشکلی در ثبت اطلاعات به وجود آمده است', 'default', array('class' => 'error-msg'));
                        }
		    
                    $this->data=$this->Api->read();
		}	
	}
        
	function api_add($id=null)
	{
		if($this->data)
		{
		if($this->Api->save($this->data)){
			$this->Session->setFlash('اطلاعات با موفقیت ویرایش شد', 'default', array('class' => 'success-msg'));
			$this->redirect('/managers/apis');
		}
		else
			$this->Session->setFlash('مشکلی در ثبت اطلاعات به وجود آمده است', 'default', array('class' => 'error-msg'));
		}
	}
	
	function accounting($user_id)
	{
		$this->paginate = array ('limit' => 15, 'order' => array('Transaction.id' => 'desc'));
		$this->set('transactions',$this->Paginate('Transaction',array('Transaction.user_id =' => $user_id)));
	}
	
	
	
	function bulk_email(){
	
		if($this->data){
			if(!empty($this->data['Bulk']['content'])){
				$UserEmail = $this->User->find('list',array('fields' => array('User.email')));
				$this->set('setting',$this->setting);
				$this->Email->to = $this -> setting['mail_address'];
				$this->Email->bcc = $UserEmail;
				$this->Email->from = $this -> setting['mail_title'].' <'.$this -> setting['noreply_mail_address'].'>';
				$this->Email->subject = $this->data['Bulk']['subject'];
				$this->Email->template = 'bilk_email_temp';
				$this->Email->sendAs = 'html';
				$this->Email->send();
			
				$this->data['Bulk']['mod'] = 'Email';
				$this->data['Bulk']['date'] = time();
				$this->data['Bulk']['count'] = count($UserEmail, COUNT_RECURSIVE);
				$this->data['Bulk']['user_id'] = $this->Auth->user('id');
			
				if($this->Bulk->save($this->data)){
					$this->Session->setFlash('پست الکترونیکی ارسال و ذخیره شد.', 'default', array('class' => 'success-msg'));
					$this->redirect('/managers/bulk_email');
				}
		
			}else{
					$this->Session->setFlash('هیچ متنی برای ارسال وجود ندارد .', 'default', array('class' => 'error-msg'));
					$this->redirect('/managers/bulk_email');
			}
		}
		
			
	}
	
	
	function bulk_sms(){
		
		if($this->data){
			
			if(!empty($this->data['Bulk']['content'])){
			$UserCellnumber = $this->User->find('list',array('fields' => array('User.cellnum')));
				$i = 0;
				foreach($UserCellnumber as $Key){
					if(!empty($Key) && strlen($Key) == 11 && substr($Key, 0, 2) == '09'){
					$CellNumbers[] .= $Key;
					$i++;
					}
				}
				$CellNumbers = implode(";", $CellNumbers);
				
				$this->Asresms->SetVar('gateway_number', $this->setting['gateway_number']);
				$this->Asresms->SetVar('gateway_pass', $this->setting['gateway_pass']);
				$this->Asresms->Send(array('cell' => $CellNumbers, 'text' => $this->data['Bulk']['content'], 'flash' => 0));
				
				$this->data['Bulk']['mod'] = 'SMS';
				$this->data['Bulk']['date'] = time();
				$this->data['Bulk']['count'] = $i;
				$this->data['Bulk']['user_id'] = $this->Auth->user('id');
				
				if($this->Bulk->save($this->data)){
					$this->Session->setFlash('اس ام اس ارسال و ذخیره شد.', 'default', array('class' => 'success-msg'));
					$this->redirect('/managers/bulk_sms');
				}
			}else{
				$this->Session->setFlash('هیچ متنی برای ارسال وجود ندارد .', 'default', array('class' => 'error-msg'));
				$this->redirect('/managers/bulk_sms');
			}
			
		}
		
	}
	
	
	function live_access($security_key)
	{
	$this->layout = 'ajax';
		if($this->setting['security_key'] == $security_key){
			$customer_reply = $this->Ticket->find('first', array('conditions' => array('Ticket.status' => array('0','2') ), 'fields' => array('COUNT(Ticket.id) as tot')));
			$customer_operating = $this->Ticket->find('first', array('conditions' => array('Ticket.status' => array('0','2','3','4') ), 'fields' => array('COUNT(Ticket.id) as tot')));
			$transaction = $this->Transaction->find('first', array('conditions' => array('Transaction.confirmed' => 0 ) ,'fields'=>array( 'COUNT(Transaction.id) as tot')));
			$this->set('total', array('customer_reply' => $customer_reply[0]['tot'], 'customer_operating' => $customer_operating[0]['tot'], 'transaction' => $transaction[0]['tot']));
		}
	}
	
	function daily_accounting_report($security_key ){
		$this->layout = 'ajax';
		if($this -> setting['security_key'] == $security_key){
			$today = $this->Jtime->pmktime(0,0,0,$this->Jtime->pdate('m'),$this->Jtime->pdate('j'),$this->Jtime->pdate('Y'));
			
			$total_yesterday_insystem_pasargad = $this->Transaction->find('first', array( 'conditions' => array('Transaction.payment_id' => 6, 'Transaction.confirmed' => 1, 'Transaction.date between ? AND ?' => array($today-86400,$today)),
													'fields' => array('SUM(Transaction.amount) as tot', 'COUNT(*) as count_tot')
												 )
									);
			$total_yesterday_insystem_zarinpal = $this->Transaction->find('first', array( 'conditions' => array('Transaction.payment_id' => 5, 'Transaction.confirmed' => 1, 'Transaction.date between ? AND ?' => array($today-86400,$today)),
													'fields' => array('SUM(Transaction.amount) as tot', 'COUNT(*) as count_tot')
												 )
									);
			
			$this->set('setting',$this->setting);
			$this->set('date',$today-86400);
			$this->set('total', array(
									   'yesterday_insystem_pasargad'=> $total_yesterday_insystem_pasargad[0]['tot'],
									   'yesterday_insystem_zarinpal'=> $total_yesterday_insystem_zarinpal[0]['tot']
									)
					);
			
			$this->Email->reset();
			$this->Email->to = $this -> setting['billing_mail_address'];
			$this->Email->from = $this -> setting['mail_title'].' <'.$this -> setting['noreply_mail_address'].'>';
			$this->Email->subject = " مجموع تراکنش های روز گذشته عصرنت ".($this->Jtime->pdate('j')-1)."/".$this->Jtime->pdate('m')."/".$this->Jtime->pdate('Y');
			$this->Email->template = 'daily_accounting_report';
			$this->Email->sendAs = 'html';
			$this->Email->send();
		}
		else{
			echo "Invalid Aceess Key";
			exit();
		}
	}
	
	function Signatures()
	{
		$Signature = $this->Signature->find('first', array('conditions' => array('Signature.user_id' => $this->Auth->user('id'))));
		if($this->data){
			if(empty($Signature)){
				$this->Signature->create();
				$this->data['Signature']['user_id'] = $this->Auth->user('id');
				if($this->Signature->save($this->data)){
					$this->Session->setFlash('امضاء با موفقیت ایجاد شد .', 'default', array('class' => 'success-msg'));
					$this->redirect(array('controller'=>'managers', 'action' => 'home'));
				}else{
					$this->Session->setFlash('مشکلی در ثبت امضاء وجود دارد .', 'default', array('class' => 'error-msg'));
				}
			}else{
				$this->Signature->id = $this->Auth->user('id');
				if($this->Signature->save($this->data)){
					$this->Session->setFlash('امضاء با موفقیت ویرایش شد .', 'default', array('class' => 'success-msg'));
					$this->redirect(array('controller'=>'managers', 'action' => 'home'));
				}else{
					$this->Session->setFlash('مشکلی در ثبت امضاء وجود دارد .', 'default', array('class' => 'error-msg'));
				}
			}
		}
		$this->data = $Signature;
	}
	
	function Backup(){
	echo 'here';
		$models = App::objects('model');
		print_r($models);
	}
}
?>