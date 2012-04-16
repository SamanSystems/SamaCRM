<?php

class UsersController extends AppController
{
	//--- Variables
	var $uses = array('User', 'Order', 'Service', 'Product', 'Transaction', 'Payment', 'Setting', 'Ticket', 'Ticketreply', 'Cardcharge', 'Ticketdepartment', 'Api', 'Message');
	var $components = array('Security', 'Whois', 'Jtime', 'Email', 'Cookie', 'Directiapi', 'Pasargad', 'Cpanelapi', 'Nicchargeapi', 'Redresellerapi', 'Zarinpal', 'Asresms', 'RequestHandler');
	var $helpers = array('Html', 'Form', 'Session', 'Javascript', 'Paginator', 'Qoute');
	var $paginate = array('limit' => 15);
	var $setting;
	function beforeFilter()
	{
		//$this->load_license();
		$this->setting = $this->Setting->find();
		$this->setting = $this->setting['Setting'];
		$this->set('setting', $this->setting);
		
		if($this->action == 'login')
			$this->Security->enabled = false; 
		
		$this->Auth->fields = array(
			'username' => 'email',
			'password' => 'password'
		);
		$this->set('users',$this->Auth->user());
		$this->Auth->loginRedirect = array('controller' => 'users', 'action' => 'home');
		$this->Auth->logoutRedirect =  '/';
		$this->Auth->autoRedirect = false;
		$this->Auth->loginError="نام کاربری یا رمز عبور اشتباه است";
		$this->Auth->authError="دسترسی غيرمجاز! لطفا جهت ثبت سفارش ابتدا در سيستم وارد شده و يا ثبت نام نماييد.";
		$this->Auth->allow('login', 'logout', 'register', 'confirmation', 'forget_password', 'verify_online', 'guest_ticket', 'guest_postticketreply');
		
		
		$domains = $this->domain;
		$domains = $domain;
		
		
		if($this->Auth->user('role')==-1 & ( $this->action != 'home' && $this->action !='logout' && $this->action !='confirmation' && $this->action !='sendconfirmatinemail' ) ){
			$this->Session->setFlash('آدرس پست الکترونيکی شما مورد تاييد قرار نگرفته است لطفا پست الکترونيکی خود را چک کنيد و مراحل ثبت نام را تکميل نماييد.<br />در صورت عدم دريافت ايميل و نياز به ارسال مجدد اينجا <a href="/users/sendconfirmatinemail/">کليک کنيد</a>.', 'default', array('class' => 'error-msg'));
			$this->redirect(array('action'=>'home'));
		}
		
		
	}

	function home()
	{
		$total_unconfirmed = $this->Transaction->find('first', array( 'conditions' => array('Transaction.user_id' => $this->Auth->user('id'), 'Transaction.confirmed' => 0),
												'fields' => array('SUM(Transaction.amount) as tot')
											 )
								);
		$total_confirmed = $this->Transaction->find('first', array( 'conditions' => array('Transaction.user_id' => $this->Auth->user('id'), 'Transaction.confirmed' => 1, 'Transaction.amount >' =>'0'),
												'fields' => array('SUM(Transaction.amount) as tot')
											 )
								);
		$total_credit = $this->Transaction->find('first', array( 'conditions' => array('Transaction.user_id' => $this->Auth->user('id'), 'Transaction.confirmed' => 1),
																		'fields' => array('SUM(Transaction.amount) as tot')
											 )
								);
		$referred_users = $this->User->find('count', array('conditions' =>array('User.referrer_id'=>$this->Auth->user('id'))));
		$top_user=$this->User->findById($this->Auth->user('referrer_id'));
		$this ->set('top_user', $top_user);
		$this->set('total', array('credit' => $total_credit[0]['tot'],'confirmed' => $total_confirmed[0]['tot'],'unconfirmed' => $total_unconfirmed[0]['tot'], 'referred_users' => $referred_users));
		
		$ticket_unread=$this->Ticket->find('first',array('conditions'=>array('Ticket.user_id' => $this->Auth->user('id'),'Ticket.user_unread' => '1' ) ,'fields'=>array( 'COUNT(Ticket.id) as tot')));
		$ticket_open=$this->Ticket->find('first',array('conditions'=>array('Ticket.user_id' => $this->Auth->user('id'),'Ticket.status' => '0' ) ,'fields'=>array( 'COUNT(Ticket.id) as tot')));
		$ticket_areply=$this->Ticket->find('first',array('conditions'=>array('Ticket.user_id' => $this->Auth->user('id'),'Ticket.status' => '1' ) ,'fields'=>array( 'COUNT(Ticket.id) as tot')));
		$ticket_inporonh=$this->Ticket->find('first',array('conditions'=>array('Ticket.user_id' => $this->Auth->user('id'),'Ticket.status' => array('3','4') ) ,'fields'=>array( 'COUNT(Ticket.id) as tot')));
		
		$order_confirmed =$this->Order->find('count',array('conditions'=>array('Order.user_id'=>$this->Auth->User('id') , 'Order.confirmed' => 2)));
		$order_unconfirmed =$this->Order->find('count',array('conditions'=>array('Order.user_id'=>$this->Auth->User('id') , 'Order.confirmed' => 1)));
		$order_before =$this->Order->find('count',array('conditions'=>array('Order.user_id'=>$this->Auth->User('id') , 'Order.confirmed' => 0)));
		$this->set('orders',array('confirmed'=>$order_confirmed , 'unconfirmed'=>$order_unconfirmed , 'before'=>$order_before));
		$this ->set('tickets', array('unread'=>$ticket_unread[0]['tot'] ,'open'=>$ticket_open[0]['tot'] , 'areply'=> $ticket_areply[0]['tot'], 'inporonh'=> $ticket_inporonh[0]['tot']));
	}
	
	function login()
	{
		$this->layout = 'ajax';
		if(!empty($this->data)){
			if ($this->Auth->user()) {
				
				$order_id = $this->Cookie->read('Order.id');
					
				if(!empty($order_id)){
					$this->Order->id = $order_id;
					$this->Order->saveField('user_id', $this->Auth->user('id'));
					$this->Cookie->del('Order.id');
				}
				
				echo 'success#';
				$this->render('/elements/login-block');
			}else{
				echo 'error#';
			}
		}else {
			$this->redirect(array('controller'=> 'users', 'action' => 'register'));
		}
	}
	
	function register($referrer=0) {
		 if ($this->data) {
			 if ($this->data['User']['password'] == $this->Auth->password($this->data['User']['password_confirm'])) {

				$this->User->create();
				$this->data['User']['role']=-1;
				$ureferrer = $this->Cookie->read('referrer');

				if(!empty($ureferrer)){
					$referrer_user = $this->User->find('first',array('conditions'=>array('User.email'=>base64_decode($ureferrer))));
					$this->data['User']['referrer_id'] = $referrer_user['User']['id'];
				}

				if($this->User->save($this->data)) 
				{
					$order_id = $this->Cookie->read('Order.id');
					
					if(!empty($order_id)){
						$this->Order->id = $order_id;
						$this->Order->saveField('user_id', $this->User->id);
						$this->Cookie->del('Order.id');
					}
					
					$key=$this->data['User']['password'].'samansystems';
					$key=md5($key);
					$key=substr($key,2,12);
					$this->set('info',$this->data);
					$this->set('key',$key);
					$this->set('setting',$this->setting);					
				 	$this->Email->to = $this->data['User']['email'] ;
					$this->Email->from = $this -> setting['mail_title'].' <'.$this -> setting['noreply_mail_address'].'>';
					$this->Email->subject = ' تایید عضویت در'.$this->setting['name'];
				 	$this->Email->template = 'userconfirm';
					$this->Email->sendAs = 'html';
					$this->Email->send();
					$this->Session->setFlash('لطفا ايميل خود را چک کنيد و مراحل ثبت نام را تکميل کنيد. ممکن است ايميل در شاخه اسپم یا بالک قرار گيرد.', 'default', array('class' => 'success-msg'));
					$this->redirect('/');
					
				}else
				{
					$this->data['User']['password'] = $this->data['User']['password_confirm'] ='';
					$this->Session->setFlash('‍‍مشکلی در ثبت پیش آمده است ', 'default', array('class' => 'error-msg'));							
				}
			 }
		 }
		 elseif(!empty($referrer)){
			$referrer_email = base64_decode($referrer);
			$referrer_user = $this->User->find('first',array('conditions'=>array('User.email'=>$referrer_email)));
			if (!empty($referrer_user['User']['id'])){
				$this->Cookie->write('referrer',$referrer,false, 5184000);
			}
			else{
				$this->Session->setFlash('اطلاعات معرف وارد شده صحيح نمی باشد.', 'default', array('class' => 'error-msg'));	
			}
		 }
		 $ureferrer = $this->Cookie->read('referrer');
		 if(!empty($ureferrer)){
			$referrer_user = $this->User->find('first',array('conditions'=>array('User.email'=>base64_decode($ureferrer))));
			$referrer_name = $referrer_user['User']['name'];
			if(!empty($referrer_user['User']['company']))
			$referrer_name .= " (".$referrer_user['User']['company'].")";
			$this->set('referrer_name',$referrer_name);
		 }
	}
	
	function logout()
	{
		$this->redirect($this->Auth->logout());
	}
	function update()
	{
		$this->User->id=$this->Auth->user('id');
		if(empty($this->data)){
			$this->data=$this->User->read();
		}else {
		if($this->User->save($this->data))
			{			
				$this->Session->setFlash(__('Your information has been updated',true), 'default', array('class' => 'success-msg'));
				$this->redirect(array('action'=>'home'));
			}	
		}
	}
	
	function change_password()
	{
		if ( $this->data )
		{
			$user_password = $this->User->find('count',array('conditions'=>array('User.id'=>$this->Auth->user('id'),'User.password'=> $this->Auth->password($this->data['User']['old_password']))));
			if($user_password){
				$this->User->id = $this->Auth->user('id');
				if ( $this->data['User']['password'] == $this->data['User']['password_confirm'] )
				{
					$this->data['User']['password'] = $this->Auth->password($this->data['User']['password']);
					if($this->User->save($this->data)){
						$this->Session->setFlash('رمز عبور با موفقیت تغییر یافت', 'default', array('class' => 'success-msg'));
						$this->redirect(array('controller' => 'users', 'action' => 'home'));
					}
					unset($this->data['User']);
				}
				else
				{
					$this->Session->setFlash('رمز عبور شما با تکرار آن مطابقت ندارد', 'default', array('class' => 'error-msg'));
				}
			}
			else{
				$this->Session->setFlash('رمز عبور فعلی اشتباه است', 'default', array('class' => 'error-msg'));
			}
		}
	}
	function orders($order_id)
	{
		//$this->paginate = array ('limit' => 25, 'order' => array('Order.id' => 'desc'));
		if(!isset($order_id))
			$orders=$this->Order->find('all',array('conditions'=>array('Order.user_id' =>$this->Auth->user('id')),'recursive' => 2));
		else
			$orders=$this->Order->find('all',array('conditions'=>array('Order.id' =>$order_id , 'Order.user_id' =>$this->Auth->user('id')),'recursive' => 2));
		foreach($orders as $key=>$row)
		{
			$costs=$this->costs($row['Product']['cost']);
			$orders[$key]['Product']['cost']=$costs[$row['Order']['monthly']];
		}
		$this->set('orders',$orders);
	}

	
	function invoice($id)
	{
		$this->layout='invoice';
		$order[0]=$this->Order->find('first',array('conditions'=>array('Order.id'=>$id,'Order.user_id'=>$this->Auth->User('id')),'recursive' =>2));
		$price=$this->costs($order[0]['Product']['cost']);
		$order[0]['Product']['cost']=$price[$order[0]['Order']['monthly']]-$order[0]['Order']['discount'];
		$this->set('settings',$this->Setting->find());
		$this->set('info',$order);
		$this->set('client',$this->User->findById($this->Auth->User('id')));
	}
	
	function accounting()
	{
		$this->paginate = array ('limit' => 15, 'order' => array('Transaction.id' => 'desc'));
		$this->set('transactions',$this->Paginate('Transaction',array('Transaction.user_id =' => $this->Auth->user('id'))));
		$this->set('page', $this->params['named']['page']);
	}
	function charge($method='')
	{
		
		if(!empty($method)){
			if($method=='bank'){
				if( $this->data ){
					$this->Transaction->create();
					$this->data['Transaction']['date'] = $this->Jtime->pmktime(0,0,0,$this->data['Transaction']['tdate']['month'],$this->data['Transaction']['tdate']['day'],$this->data['Transaction']['tdate']['year']);
					$this->data['Transaction']['payment_id'] = $this->data['Transaction']['payment'];
					$this->data['Transaction']['user_id'] = $this->Auth->user('id');
					$this->data['Transaction']['desc'] = __('Reference Number',true). ': '. $this->data['Transaction']['reference_number'];
					$payment_info = $this->Payment->findById($this->data['Transaction']['payment']);
					if ( $this->Transaction->save($this->data) ) {
						$temp1['Transaction']['id'] = $this->Transaction->id;
						
						//open ticket
						$this->data['Ticket']['title'] = 'تراکنش شماره '.$temp1['Transaction']['id'].' ثبت شد';
						$this->data['Ticket']['content'] = "با سلام
						فیش پرداختی شما به مبلغ ".$this->data['Transaction']['amount']." تومان که به حساب ".$payment_info['Payment']['name']." پرداخت کرديد در سيستم ثبت شد.
						تا ساعات آينده نتيجه تاييد فيش اعلام خواهد شد.
						(اين تيکت به صورت خودکار توسط سيستم ثبت شد.)";
						$this->data['Ticket']['ticketdepartment_id'] = 0;
						$this->data['Ticket']['priority'] = 0;
						$this->data['Ticket']['user_unread'] = 1;
						$this->data['Ticket']['status'] = 6;
						$this->postticket(1);
						//$this->SendSMS();
							
						if($this->Auth->user('referrer_id') != 0){
							$this->Transaction->create();
							$temp['Transaction']['date'] = time();
							$temp['Transaction']['amount'] = ($this->setting['top_user_percent']/100)*$this->data['Transaction']['amount'];
							$temp['Transaction']['user_id'] = $this->Auth->user('referrer_id');
							$temp['Transaction']['payment_id'] = 0;
							$temp['Transaction']['confirmed'] = 0;
							$temp['Transaction']['desc'] = 'پورسانت حاصل از تراکنش '.$temp1['Transaction']['id'];
							$this->Transaction->save($temp);
						}
						$this->Session->setFlash(__('Transaction saved successfully!',true), 'default', array('class' => 'success-msg'));
						$this->redirect(array('controller' => 'users', 'action' => 'accounting'));
					} else {
						$this->Session->setFlash(__('There\'s an error on saving transaction',true), 'default', array('class' => 'error-msg'));
					}
				}

				$this->set('payments', $this->Payment->find('list',array('conditions' => array('Payment.list' => '1') ,'fields' => array('Payment.id', 'Payment.name'))));
			}elseif($method=='online'){
				$this->set('merchents', $this->Payment->find('list',array('conditions' => array('Payment.list' => '2') ,'fields' => array('Payment.merchant', 'Payment.name'))));
				if($this->data){
					$data['amount'] = $this->data['Transaction']['amount'];
					$data['user_id'] = $this->Auth->user('id');
					$data['user'] = $this->Auth->user('email');
					
					$merchent_data = $this->Payment->find('first', array('conditions' => array('Payment.merchant' => $this->data['Transaction']['merchent']), 'fields' => array('Payment.settings')));
					eval($merchent_data['Payment']['settings']);
					$settings['site'] = $this->setting['website'];
					$settings['payment_id'] = $merchent_data['Payment']['id'];
					
					foreach($settings as $key => $setting) $this->{$this->data['Transaction']['merchent']}->SetVar($key, $setting);
					
					$this->set('params', $this->{$this->data['Transaction']['merchent']}->Execute($data));
					$this->render('/users/redirectmerchant');
					unset($method);
				}
			}
			elseif($method=='cardcharge'){
				if( $this->data ){			
					$card=$this->Cardcharge->find('first' , array('conditions'=>array('Cardcharge.id'=>$this->data['Cardcharge']['cardid'],'Cardcharge.security_code'=>$this->data['Cardcharge']['cardpassword'])));
					if(!empty($card[Cardcharge][user_id])){
						$this->Session->setFlash('اين کارت قبلا توسط شخص ديگری ثبت شده است.','default', array('class' => 'error-msg'));
					}
					elseif(!empty($card[Cardcharge][id])){
						$this->Transaction->create();
						$payment=$this->Payment->find('first' , array('filds'=>array('id'),'conditions'=>array('Payment.pin'=>'cardcharge')));
						$this->data['Transaction']['user_id'] = $this->Auth->user('id');
						$this->data['Transaction']['amount'] = $card[Cardcharge][credit];
						$this->data['Transaction']['date'] = time();
						$this->data['Transaction']['confirmed'] = 1;
						$this->data['Transaction']['payment_id'] = $payment['Payment']['id'];
						$this->data['Transaction']['desc'] = ' ثبت کارت به شماره '.$card[Cardcharge][id];
						if($this->Transaction->save($this->data)){
							$temp1['Transaction']['id'] = $this->Transaction->id;
							$this->Cardcharge->id = $this->data['Cardcharge']['cardid'];
							$this->Cardcharge->security_code = $this->data['Cardcharge']['cardpassword'];
							$this->data['Cardcharge']['submit_date'] = time();
							$this->data['Cardcharge']['user_id'] = $this->Auth->user('id');
							$this->data['Cardcharge']['transaction_id'] = $this->Transaction->id;
							if ( $this->Cardcharge->save($this->data) ) {
								if($this->Auth->user('referrer_id') != 0){
									$this->Transaction->create();
									$temp['Transaction']['date'] = time();
									$temp['Transaction']['amount'] = ($this->setting['top_user_percent']/100)*$card[Cardcharge][credit];
									$temp['Transaction']['user_id'] = $this->Auth->user('referrer_id');
									$temp['Transaction']['payment_id'] = $this->Transaction->id;
									$temp['Transaction']['confirmed'] = 0;
									$temp['Transaction']['desc'] = 'پورسانت حاصل از تراکنش '.$temp1['Transaction']['id'];
									$this->Transaction->save($temp);
								}
								$this->Session->setFlash('کارت به ارزش '.$card[Cardcharge][credit].' تومان برای شما ثبت شد.', 'default', array('class' => 'success-msg'));
								
								$order_info = $this->Session->read('order_info');
			
								if(!empty($order_info)){
									$this->Session->setFlash('کارت به ارزش '.$card['Cardcharge']['credit'].' تومان برای شما ثبت شد. لطفا سفارش زير را پرداخت نماييد.', 'default', array('class' => 'success-msg'));
									$this->redirect(array('controller'=>'users', 'action' => 'reneworder', 'id' => $order_info['id']));
								}else{
									$this->Session->setFlash('کارت به ارزش '.$card['Cardcharge']['credit'].' تومان برای شما ثبت شد.', 'default', array('class' => 'success-msg'));
									$this->redirect(array('controller' => 'users', 'action' => 'accounting'));
								}
								
							}
						} else {
							$this->Session->setFlash(__('There\'s an error on saving transaction',true), 'default', array('class' => 'error-msg'));
						}
					}
					else{
						$this->Session->setFlash('شماره کارت و رمز کارت با هم مطابقت ندارند.','default', array('class' => 'error-msg'));
					}
				}
			}
			
			$order_info = $this->Session->read('order_info');
			if(!empty($order_info)) $this->data['Transaction']['amount'] = $order_info['amount'];
			
			if(!empty($method)) $this->render('/users/charge_'.$method);
		}
		else $this->render();
	}
	
	function neworder($product_id = 0, $domain = '')
	{
		//user's credit
		$credit = $this->Transaction->find( 'first', array(
									'conditions' => array(
											      'Transaction.user_id' => $this->Auth->user('id'),
											      'Transaction.confirmed' => 1
											      ),
									'fields' => array('SUM(Transaction.amount) as tot')
									)
						       );
		
		$this->set('credit', $credit[0]['tot']);
		
		//product properties
		$product = $this->Product->findById($product_id);
		if($product['Service']['api_id']){
			$api_info = $this->Api->findById($product['Service']['api_id']);

			eval($api_info['Api']['settings']);
			foreach($settings as $key => $setting) $this->{$api_info['Api']['component_name']}->SetVar($key, $setting);
			$this->set('extras', $this->{$api_info['Api']['component_name']}->ExtraFields());
		}
		
		$top_order_id = 0;
		
		if($this->Session->check('Order.top_order_id')){
			$top_order_id = $this->Session->read('Order.top_order_id');
			$orders_info[-1] = $this->Order->find('first', array('conditions' => array('Order.id' => $top_order_id, 'Order.user_id' => $this->Auth->user('id')), 'recursive' => 1));
			$orders_info = array_merge($orders_info, $this->Order->find('all', array('conditions' => array('Order.top_order_id' => $top_order_id, 'Order.user_id' => $this->Auth->user('id')), 'recursive' => 1)));
			$this->set('orders_info', $orders_info);
		}
		
		if(!empty($product))
		{
			$this->set('product', $product);
			$monthly=$product['Service']['monthly'];
			
			$price=$this->costs($product['Product']['cost']);
			$monthles[0] = 'انتخاب کنید';
			foreach($price as $month => $cost)
			{
				if($month==1)
					$monthles[1] ='ماهیانه';
				elseif($month==3)
					$monthles[3] ='3 ماهه';
				elseif($month==6)
					$monthles[6] ='6 ماهه';
				elseif($month==12)
					$monthles[12] ='سالیانه';
				elseif($month==24)
					$monthles[24] ='دو ساله';
				elseif($month==60)
					$monthles[60] ='پنج ساله';
				elseif($month==-120)
					$monthles[-120] ='مادام العمر';
			}
			
			if(count($monthles)== 2){
				$this->set('price', $cost);
				$this->set('month', $month);
			}
			$this->set('monthlies',$monthles);
			//if data fill in view
			if(!empty($this->data)){
				if ( $this->data['Order']['monthly'] != 0 )
				{
					
					//some of order's properties
					$this->data['Order']['product_id'] = $product_id;
					$this->data['Order']['user_id'] = $this->Auth->user('id');
					
					if(empty($this->data['Order']['user_id']))
						$this->data['Order']['user_id'] = -1;
						
					$this->data['Order']['date'] = time();
			
					//if user want to pay
						$product['Product']['cost'] = $price[$this->data['Order']['monthly']];
						$this->data['Order']['confirmed'] = 0;
						
						if($product['Product']['plan_name']{0} == '.') 
							$this->data['Order']['desc'] .= $product['Product']['plan_name'];
						
						$api_data = '';
						foreach($this->data['Order']['Api'] as $key => $data) $api_data .= '$api_data[\''. $key .'\'] ="'. $data .'";';
						
						$this->data['Order']['api_data'] = $api_data;
						$this->data['Order']['next_pay'] = 0;
						$this->data['Order']['top_order_id'] = $top_order_id;
						$this->data['Order']['privet_note'] = '';

						if($this->Order->save($this->data)){
							
							if($this->data['Order']['user_id']>0){
								if(empty($top_order_id)){
									$top_order_id = $this->Order->id;
									$this->Session->write('Order.top_order_id', $top_order_id);
								}

								if($this->data['Order']['state'] == 'continue'){
									$this->Session->setFlash('سفارش شما با موفقیت ثبت شد', 'default', array('class' => 'success-msg'));
									$this->redirect(array('controller' => 'users', 'action' => 'RelativeServices', $product['Product']['service_id']));
								} elseif($this->data['Order']['state'] == 'finished') {
									$this->Session->setFlash('سفارش شما با موفقیت ثبت شد', 'default', array('class' => 'success-msg'));
									$this->redirect(array('controller' => 'users', 'action' => 'PayOrder', $top_order_id));
								}
							} else {
								$this->Cookie->write('Order.id', $this->Order->id, false, 7200);
								$this->Session->setFlash('سفارش شما به صورت معلق ثبت گرديد. لطفا جهت تکميل سفارش در سيستم وارد شده و يا عضو شويد', 'default', array('class' => 'warning-msg'));
								$this->redirect(array('controller' => 'users', 'action' => 'register'));
							}
						} else {
							$this->Session->setFlash('سفارش شما ثبت نشد لطفا همه موارد را پر کنید.', 'default', array('class' => 'error-msg'));
						}
					
				} else {
					$this->Session->setFlash('لطفا دوره پرداخت مورد نظر خود را انتخاب نماييد', 'default', array('class' => 'error-msg'));
				}
			}else{
				$user = $this->Auth->user('id');
				if(empty($user)){
					$this->Session->setFlash('توصيه مي شود پيش از ثبت سفارش اقدام به <a href="/users/register">عضويت در سیستم</a> و يا ورود با نام کاربری خود نماييد.', 'default', array('class' => 'dialog-msg'));
				}
			}
		}else
		{
			$this->Session->setFlash('محصول مورد نظر پیدا نشد', 'default', array('class' => 'error-msg'));
			$this->redirect('/users/home');
		}
		if(!empty($domain)) $this->data['Order']['desc'] = $domain;
		$this->data['Order']['product_id'] = $product_id;
	}
	
	function RelativeServices ( $service_id )
	{
		$service = $this->Service->find('first',array('conditions'=>array('Service.id' =>$service_id), 'fields' => array('Service.relative_services'),'recursive' => -1));
		$service['Service']['relative_services'] = explode(',', $service['Service']['relative_services']);
		array_pop($service['Service']['relative_services']);

		$this->set('relative_services', $this->Service->find('all', array('conditions' => array('Service.id' => $service['Service']['relative_services']), 'recursive' => 1)));
	}
	
	function PayOrder($top_order_id = 0){

		$orders_info[-1] = $this->Order->find('first', array('conditions' => array('Order.id' => $top_order_id, 'Order.user_id' => $this->Auth->user('id')), 'recursive' => 1));
		
		$credit = $this->Transaction->find('first', array(
														'conditions' => array(
																	'Transaction.user_id' => $this->Auth->user('id'),
																	'Transaction.confirmed' => 1
																 ),
														'fields' => array(
																	'SUM(Transaction.amount) as tot'
																  )
													)
											   );
	
		if(!empty($orders_info)){
			$orders_info = array_merge($orders_info, $this->Order->find('all', array('conditions' => array('Order.top_order_id' => $top_order_id, 'Order.user_id' => $this->Auth->user('id')), 'recursive' => 1)));
			
			foreach($orders_info as $key => $relative_order){
				$prices = $this->costs($relative_order['Product']['cost']);
				$orders_info[$key]['Product']['cost'] = $prices[$relative_order['Order']['monthly']]-$relative_order['Order']['discount'];
				$total += $orders_info[$key]['Product']['cost'];
			}

			if(!empty($this->data)){
				if ( $this->data['Order']['payment_method'] == 'credit' )
				{

					if ($credit[0]['tot'] < $total)
					{
						$this->Session->setFlash('متاسفانه اعتبار شما برای این سفارش کافی نمی باشد', 'default', array('class' => 'error-msg'));
					}
					else
					{
						//make Order confirmed option to one that indicate this order is payedup
						foreach($orders_info as $order){
							$this->Transaction->create();
							$trans['Transaction']['user_id'] = $this->Auth->User('id');
							$trans['Transaction']['order_id'] = $order['Order']['id'];
							$trans['Transaction']['amount'] = -($order['Product']['cost']);
							$trans['Transaction']['date'] = time();
							$trans['Transaction']['confirmed'] = 1;
							$this->Transaction->save($trans);
							
							$this->Order->id = $order['Order']['id'];
							$this->data['Order']['confirmed'] = 1;
							
							$order_date = time();
							$action = 'Create';
							if($order['Order']['next_pay']>1){ 
								$order_date = $order['Order']['next_pay'];
								$action = 'Renew';
							}
	
							list($year, $month, $day) = explode('/',$this->Jtime->pdate("Y/n/j", $order_date));
							$next_pay = $this->Jtime->pmktime(0, 0, 0, $month+$order['Order']['monthly'], $day, $year);
							
							$this->data['Order']['next_pay'] = $next_pay;
							if($order['Order']['monthly']<0) $this->data['Order']['next_pay'] = 1;
							
							$product = $this->Product->findById($order['Product']['id']);

							if($product['Service']['api_id']) {
								$api_info = $this->Api->findById($product['Service']['api_id']);
								unset($setting);
								eval($api_info['Api']['settings']);
								foreach($settings as $key => $setting) $this->{$api_info['Api']['component_name']}->SetVar($key, $setting);
							}
							
							if($api_info){
								if(!empty($order['Product']['plan_name'])){
									$this->{$api_info['Api']['component_name']}->SetVar('plan_name', $product['Product']['plan_name']);
								}
									
									eval($order['Order']['api_data']);
									
									foreach($api_data as $key => $data) $this->{$api_info['Api']['component_name']}->SetVar($key, $data);
									
									$parameters['domain'] = $order['Order']['desc'];
									$parameters['duration'] = $order['Order']['monthly'];
									$parameters['email'] = $this->Auth->User('email');
									
									$status = $this->{$api_info['Api']['component_name']}->{$action}($parameters);
									
									if($status == 'success'){
										$this->data['Order']['confirmed'] = 2;
										$success = true;
										$answer_info = $this->{$api_info['Api']['component_name']}->GetInfo();
										$this->Session->setFlash('صورت حساب با موفقيت پرداخت گرديد', 'default', array('class' => 'success-msg'));
									} elseif($status=='failed') {
										$this->Transaction->del();
										
										if(!empty($this->{$api_info['Api']['component_name']}->Message) ) $message = 'مشکلی در ثبت سفارش رخ داده است. '.$this->{$api_info['Api']['component_name']}->Message;
										 else $message = 'اطلاعات وارد شده و مدت زمان ثبت با يکديگر تطابق ندارند';
										 
										$this->Session->setFlash($message, 'default', array('class' => 'error-msg'));
									} else {
										$this->data['Order']['confirmed'] = -2;
										
										if(!empty($this->{$api_info['Api']['component_name']}->Message) ) $message = 'مشکلی در ثبت سفارش رخ داده است. '.$this->{$api_info['Api']['component_name']}->Message;
										 else $message = 'مشکلی در ثبت سفارش به وجود آمده است. لطفا با بخش پشتيبانی تماس حاصل فرماييد.';
										 
										$this->Session->setFlash($message, 'default', array('class' => 'error-msg'));
									}
							}else{
								$this->Session->setFlash('سفارش شما با موفقیت ثبت شد', 'default', array('class' => 'success-msg'));
							}
							
							if($status!='failed') {
								$this->Cookie->del('Order.id');
								$this->Order->save($this->data);
									
								//open ticket
								$this->data['Ticket']['title'] = 'سفارش شماره '. $order['Order']['id'] .' با موفقیت  ثبت شد';
								$this->data['Ticket']['content'] = "با سلام
								سفارش شما به شماره ".$order['Order']['id']."ثبت گردید
								مشخصات محصول سفارش داده شده :
								<center><table style='width: 96%; border: 1px solid #ccc;'><tr><th style='text-align: center; padding: 5px; background: #ccc;'>نام سرویس</th><th style='text-align: center; padding: 5px; background: #ccc;'>نام محصول</th><th style='text-align: center; padding: 5px; background: #ccc;'>قیمت</th><th style='text-align: center; padding: 5px; background: #ccc;'>تاریخ سفارش</th><th style='text-align: center; padding: 5px; background: #ccc;'>توضيحات</th></tr><tr><td>".$product['Service']['name']."</td><td>".$product['Product']['name']."</td><td>".$order['Product']['cost']."</td><td>".$this->Jtime->pdate("Y/n/j", $order['Order']['date'])."</td><td>".$order['Order']['desc']."</td></table></center><br />".
								$answer_info;
								
								$this->data['Ticket']['content'] .="اعتبار شما در حال حاضر  :".($credit[0]['tot']-$total);
								$this->data['Ticket']['ticketdepartment_id'] = 0;
								$this->data['Ticket']['priority'] = 0;
								$this->data['Ticket']['user_unread'] = 1;
								$this->data['Ticket']['status'] = 6;
								$this->postticket(1);
								//$this->SendSMS();
							}
							
						}
	
						$this->redirect('/users/orders');							
					}
				} elseif($this->data['Order']['payment_method'] == 'recharge') {
					$this->Session->setFlash('سفارش شما با موفقیت ثبت شد. لطفا نسبت به افزايش اعتبار خود اقدام نماييد.', 'default', array('class' => 'success-msg'));
					$this->redirect(array('controller' => 'users', 'action' => 'charge'));
				} else if($this->data['Order']['payment_method'] == 'skip'){
					$this->Session->delete('Order.top_order_id');
					$this->Session->setFlash('سفارش شما با موفقیت ثبت شد. جهت دريافت سرويس با يکی از روش های موجود در سايت اقدام به پرداخت سفارش خود نماييد.', 'default', array('class' => 'warning-msg'));
					$this->redirect(array('controller' => 'users', 'action' => 'home'));
				} else{
					$this->Session->setFlash('لطفا روش پرداختی را انتخاب نماييد', 'default', array('class' => 'error-msg'));
				}
			}else{
			
			
			}
			
			$this->set('credit', $credit[0]['tot']);
			$this->set('total', $total);
			$this->set('orders_info', $orders_info);
			$this->data['Order']['id'] = $top_order_id;
		}
	}
	
	function serviceproducts ()
	{
		$this->layout = 'ajax';
		$data = $this->Product->find('all',array('conditions' => array('Service.id' => $_POST['service_id'])));
		$return='<option cost="0">انتخاب کنید</option>';
		foreach ( $data as $row )
			$return .= '<option value="'.$row['Product']['id'].'" cost="'.$row['Product']['cost'].'">'.$row['Product']['name'].'</option>';
		
		echo $return;
	}
	
	function showByServiceId($service_id)
	{
		$this->set('products', $this->Product->findAllByServiceId($service_id));
		$this->set('service', $this->Service->findById($service_id));
	}
	
	function showById($product_id)
	{
		$this->set('product',$this->Product->findById($product_id));
		$this->set('product_id',$product_id);
	}
	
	function whois()
	{
		$keys = array_keys($this->Whois->whois_servers);
		foreach($keys as $key) $exts[$key] = $key;
		$this->set('exts', $exts);
		if($this->data){
			$result = $this->Whois->lookupdomain($this->data['User']['domain'],$this->data['User']['ext']);
			$product = $this->Product->find('first',array('conditions'=> array("Product.plan_name" => $this->data['User']['ext'])));
			$domain = array ( 'whois' => $result, 'domain' => $this->data['User']['domain'].$this->data['User']['ext'], 'product_id' => $product['Product']['id']);
			$this->set('domain', $domain );
		}
	}
	
	function confirmation($email , $hash)
	{
		$user=$this->User->find('first',array('conditions'=>array('User.email' =>base64_decode($email))));
		$temp=substr(md5($user['User']['password'].'samansystems'),2,12);
		if($temp == $hash)
		{
			$this->User->id=$user['User']['id'];
			$user['User']['role']=0;
			$this->User->save($user);
			$this->Session->setFlash('شناسه کاربری شما با مو فقیت فعال شد', 'default', array('class' => 'success-msg'));
			$this->redirect('/');			
		}else
		{
			$this->Session->setFlash('لینک وارد شده اشتباه است', 'default', array('class' => 'error-msg'));
			$this->redirect('/');
		}
		
	}
	
	function forget_password($step = NULL,$email = NULL, $key = NULL)
	{
		if($step == 'step2'){
			$email_decode = base64_decode($email);
			$user = $this->User->findByEmail($email_decode);
			$org_key=$user['User']['password'].'samansystems';
			$org_key=md5($org_key);
			$org_key=substr($org_key,2,12);
			
			if($org_key == $key){
				if ( $this->data )
				{
					if ( $this->data['User']['password'] == $this->data['User']['password_confirm'] )
					{
						$this->User->id = $user['User']['id'];
						$data['User']['password'] = $this->Auth->password($this->data['User']['password']);
						if($this->User->save($data)){
							$this->Session->setFlash('رمز عبور با موفقیت تغییر یافت', 'default', array('class' => 'success-msg'));
							
							$this->set('setting',$this->setting);
							$this->set('user',$user);
							$this->set('password',$this->data['User']['password']);
							$this->Email->to = $user['User']['email'];
							$this->Email->from = $this -> setting['mail_title'].' <'.$this -> setting['noreply_mail_address'].'>'  ;
							$this->Email->subject = 'بازیابی رمز عبور';
							$this->Email->template = 'forget_password_2';
							$this->Email->sendAs = 'html';
							$this->Email->send();
							unset($this->data);
							$this->redirect('/');
						}
					}
					else
					{
						$this->Session->setFlash('رمز عبور شما با تکرار آن مطابقت ندارد', 'default', array('class' => 'error-msg'));
						$this->redirect('/users/forget_password/step2/'.$email.'/'.$key.'/');
					}
				}
				else{
					$this->set('key',$key);
					$this->set('email', $email);
					$this->set('step', $step);
				}
			}
			else{
				$this->Session->setFlash('لينک وارد شده صحيح نيست.', 'default', array('class' => 'error-msg'));
				$this->redirect('/');
			}
		}
		elseif ( $this->data )
		{
			if ( $user = $this->User->findByEmail($this->data['User']['email']) )
			{
				$key=$user['User']['password'].'samansystems';
				$key=md5($key);
				$key=substr($key,2,12);
				$this->set('user',$user);
				$this->set('key',$key);
				$this->set('setting',$this->setting);					
				$this->Email->to = $user['User']['email'] ;
				$this->Email->from = $this -> setting['mail_title'].' <'.$this -> setting['noreply_mail_address'].'>';
				$this->Email->subject = ' درخواست تغيير رمز در'.$this->setting['name'];
				$this->Email->template = 'forget_password';
				$this->Email->sendAs = 'html';
				$this->Email->send();
				$this->Session->setFlash('به منظور تکميل عمليات ايميلی برای شما ارسال شد.', 'default', array('class' => 'success-msg'));
				$this->redirect('/');
			}
			else
			{
				$this->Session->setFlash('کاربری با این مشخصات یافت نشد', 'default', array('class' => 'error-msg'));
			}
		}
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
	
	function tickets($ticket_id=null) 
	{
		if(!isset($ticket_id)){
			$tickets=$this->Ticket->find('all',array('conditions'=>array('Ticket.user_id' =>$this->Auth->user('id')),'order' => array('Ticket.user_unread DESC','Ticket.status ASC','Ticket.priority DESC')));
			$this->set('tickets',$tickets);
		}
		else 
		{
			$tickets=$this->Ticket->find('first',array('conditions'=>array('Ticket.user_id' =>$this->Auth->user('id') , 'Ticket.id'=>$ticket_id),'recursive' => 1));
			$ticketreplies=$this->Ticketreply->find('all',array('conditions'=>array('Ticketreply.ticket_id'=>$ticket_id, 'Ticketreply.note'=>0),'order' => array('Ticketreply.date ASC'),'recursive' => 1));
			
			if ($tickets['Ticket']['user_id'] != $this->Auth->user('id'))
			{
				$this->Session->setFlash('تيکت مربوط به شما نمي باشد.','default', array('class' => 'error-msg'));
				$this->redirect(array('controller' => 'users','action' => 'tickets'));
			}
			elseif ($tickets['Ticket']['user_unread'] == 1)
			{
				$temp['Ticket']['user_unread'] = 0;
				$this->Ticket->id = $tickets['Ticket']['id'];
				$this->Ticket->save($temp);
			}
			$this->set('setting',$this -> setting);
			$this->set('ticketreplies',$ticketreplies);
			$this->set('ticket',$tickets);
		}
	}
	
	function postticket($remote = 0)
	{
		if (!empty($this->data)) {
			$this->data['Ticket']['user_id'] = $this->Auth->user('id');
			$this->data['Ticket']['date'] = time();
			
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
					$this->redirect(array('controller' => 'users','action' => 'postticket',$ticket_id));
				}
			}
		
			
			$this->Ticket->create();
			
			if ($this->Ticket->save($this->data)) {
			
				$temp['Ticketreply']['content']=$this->data['Ticket']['content'];
				if(!$remote){
					$temp['Ticketreply']['user_id'] = $this->Auth->user('id');
					$user['User']['name'] = $this->Auth->user('name');
				} else {
					$temp['Ticketreply']['user_id'] = 0;
					$user['User']['name'] = 'مهمان';
				}
				
				$temp['Ticketreply']['date'] = time();
				$temp['Ticketreply']['ticket_id'] = $this->Ticket->id;
				
				$this->Ticketreply->create();
				
				if($this->Ticketreply->save($temp))
				{
					
					//print_r($this->params);
					//$this->params['pass'][0]
					//$this->params['controller']
					//$this->params['action']
					
					if($this->setting['send_email']==1)
					{
						$this->set('ticket_title',$this->data['Ticket']['title']);
						$this->set('ticket_content',$this->blockqoute($this->data['Ticket']['content']));
						$this->set('ticket_id',$this->Ticket->id);
						$this->set('opendate',$this->data['Ticket']['date']);
						$this->set('setting',$this->setting);
						$this->Email->to = $this -> setting['mail_address'];
						$this->Email->from = $this->Auth->user('name').' <'.$this->Auth->user('email').'>';
						$this->Email->subject = 'تيکت جديد: #'.$this->Ticket->id.' - '.$this->data['Ticket']['title'];
						$this->Email->template = 'ticketopen';
						$this->Email->sendAs = 'html';
						$this->Email->send();
						if($remote){
							$this->Email->reset();
							$this->Email->to = $this->Auth->user('email');
							$this->Email->from = $this -> setting['mail_title'].' <'.$this -> setting['noreply_mail_address'].'>';
							$this->Email->subject = 'تيکت جديد: #'.$this->Ticket->id.' - '.$this->data['Ticket']['title'];
							$this->Email->template = 'ticketopen';
							$this->Email->sendAs = 'html';
							$this->Email->send();
						}
					}
					
					if($this->setting['send_sms_option']==1)
					{
						$Admin_Cell = $this->setting['admin_cellnum'];
						$this->Asresms->SetVar('gateway_number', $this->setting['gateway_number']);
						$this->Asresms->SetVar('gateway_pass', $this->setting['gateway_pass']);
						
						if(strlen($Admin_Cell) == 11 && substr($Admin_Cell, 0, 2) == '09'){
								$this->Asresms->Send(array('cell' => $Admin_Cell, 'text' => " مدیر محترم تیکت جدیدی با عنوان ". $this->data['Ticket']['title'] . " توسط : " . $user['User']['name'] . " افتتاح گردیده است . \n\n".$this->setting['name'], 'flash' => 0));
						}
						
						if($remote){
							$mobile = $this->Auth->user('cellnum');
							if(strlen($mobile) == 11 && substr($mobile, 0, 2) == '09')
								$this->Asresms->Send(array('cell' => $mobile, 'text' => $this->data['Ticket']['title'], 'flash' => 0));
						}
					}
					
					if(!$remote){
						$this->Session->setFlash('تيکت شما با موفقيت ثبت شد.','default', array('class' => 'success-msg'));
						$this->redirect(array('controller' => 'users','action' => 'tickets',$this->Ticket->id));
					}
				}
			} else {
				if(!$remote){
					$this->Session->setFlash('مشکلی در ثبت تيکت رخ داده است.','default', array('class' => 'error-msg'));
				}
			}
		}
		$this->set('priorities', array('0' => 'عادی', '1' => 'مهم', '2' => 'خيلی مهم'));
		$this->set('departments', $this->Ticketdepartment->find('list',array('fields'=> array('Ticketdepartment.id','Ticketdepartment.name'),'order'=> 'Ticketdepartment.department_order')));
	}
	
	function postticketreply($ticket_id,$remote = 0)
	{
		$ticket=$this->Ticket->find('first',array('conditions'=>array('Ticket.user_id' =>$this->Auth->user('id') , 'Ticket.id'=>$ticket_id)));
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
					$this->redirect(array('controller' => 'users','action' => 'postticket',$ticket_id));
				}
			}
		
			if (!empty($this->data)) {
				$this->data['Ticketreply']['ticket_id'] = $ticket_id;
				if(!$remote)
					$this->data['Ticketreply']['user_id'] = $this->Auth->user('id');
				else
					$this->data['Ticketreply']['user_id'] = 0;
				$this->data['Ticketreply']['date'] = time();
				$this->Ticketreply->create();
				//$this->Ticketreply->save($this->data);
				
				if($this->Ticketreply->save($this->data))
				{
					
					if($this -> setting['send_email']==1)
					{
						$this->set('reply_content',$this->blockqoute($this->data['Ticketreply']['content']));
						$this->set('ticket_id',$ticket_id);
						$this->set('replydate',$this->data['Ticketreply']['date']);
						$this->set('setting',$this->setting);
						$ticket=$this->Ticket->find('first' , array('conditions'=>array('Ticket.id'=>$ticket_id)));
						$user=$this->User->find('first' , array('conditions'=>array('User.id'=>$ticket['Ticket']['user_id'])));
						$this->Email->to = $this -> setting['mail_address'];
						$this->Email->from = $user['User']['name'].' <'.$user['User']['email'].'>';
						$this->Email->subject = 'پاسخ جديد در تيکت: #'.$ticket_id.' - '.$ticket['Ticket']['title'];
						$this->Email->template = 'ticketreply';
						$this->Email->sendAs = 'html';
						$this->Email->send();
					}
					
					if($this->setting['send_sms_option']==1)
					{
						$Admin_Cell = $this->setting['admin_cellnum'];
						$this->Asresms->SetVar('gateway_number', $this->setting['gateway_number']);
						$this->Asresms->SetVar('gateway_pass', $this->setting['gateway_pass']);
						
						if(strlen($Admin_Cell) == 11 && substr($Admin_Cell, 0, 2) == '09'){
								$this->Asresms->Send(array('cell' => $Admin_Cell, 'text' => " مدیر محترم پاسخ جدیدی در تیکت با عنوان ". $ticket['Ticket']['title'] . " توسط : " . $user['User']['name'] . " ارسال گردیده است . \n\n".$this->setting['name'], 'flash' => 0));
						}
						
						if($remote){
							$mobile = $this->Auth->user('cellnum');
							if(strlen($mobile) == 11 && substr($mobile, 0, 2) == '09')
								$this->Asresms->Send(array('cell' => $mobile, 'text' => $this->data['Ticket']['title'], 'flash' => 0));
						}
					}
					
					$temp['Ticketreply']['user_unread'] = $this->data['Ticketreply']['user_unread'];
					$temp['Ticketreply']['status'] = $this->data['Ticketreply']['status'];
					unset($this->data);
					$this->Ticket->id = $ticket_id;
					if(!$remote){
						$this->data['Ticket']['status'] = 2;
					}
					else{
						$this->data['Ticket']['status'] = $temp['Ticketreply']['user_unread'];
						$this->data['Ticket']['status'] = $temp['Ticketreply']['status'];
					}
					$this->Ticket->save($this->data);
					if(!$remote){
						$this->Session->setFlash('پاسخ به تيکت مورد نظر با موفقيت ارسال شد.','default', array('class' => 'success-msg'));
					}
				}else
					$this->Session->setFlash('پاسخ ارسالی بايد حاوی نوشته باشد.','default', array('class' => 'error-msg'));
				if(!$remote){
					$this->redirect(array('controller' => 'users','action' => 'tickets',$ticket_id));
				}
			}
		}
		else
		{
			$this->Session->setFlash('تيکت مربوط به شما نمي باشد.','default', array('class' => 'error-msg'));
			$this->redirect(array('controller' => 'users','action' => 'tickets'));
		}
	}
	
	function closeticket($ticket_id)
	{
		$ticket=$this->Ticket->find('first',array('conditions'=>array('Ticket.user_id' =>$this->Auth->user('id') , 'Ticket.id'=>$ticket_id)));
		if(!empty($ticket))
		{
			$this->Ticket->id = $ticket_id;
			$this->data['Ticket']['status'] = 5;
			if($this->Ticket->save($this->data)){
				$this->Session->setFlash('وضعيت تيکت به بسته شده تغيير يافت.','default', array('class' => 'success-msg'));
				$this->redirect(array('controller' => 'users','action' => 'tickets',$ticket_id));
			}
		}
		else
		{
			$this->Session->setFlash('تيکت مربوط به شما نمي باشد.','default', array('class' => 'error-msg'));
			$this->redirect(array('controller' => 'users','action' => 'tickets'));
		}
	}
	
	function refer_user()
	{
		$this->set('website',$this->setting['website']);
		$this->set('base64mail',base64_encode ($this->Auth->user('email')));
		$referred_users=$this->User->find('all',array('conditions'=>array('User.referrer_id' => $this->Auth->user('id')) ,'fields'=>array('id','name','company','role')));
		$this->set('referred_users',$referred_users);
	}
	
	function sendconfirmatinemail()
	{
		$user = $this->User->findById($this->Auth->user('id'));
		$key=md5($user['User']['password'].'samansystems');
		$key=substr($key,2,12);
		$this->set('info',$this->Auth->user());
		$this->set('setting',$this->setting);	
		$this->set('key',$key);
		$this->Email->to = $this->Auth->user('email');
		$this->Email->from = $this -> setting['mail_title'].' <'.$this -> setting['noreply_mail_address'].'>';
		$this->Email->subject = ' تایید عضویت در'.$this->setting['name'];
		$this->Email->template = 'userconfirm';
		$this->Email->sendAs = 'html';
		$this->Email->send();
		$this->Session->setFlash('لطفا ايميل خود را چک کنيد و مراحل ثبت نام را تکميل کنيد. ممکن است ايميل در شاخه اسپم یا بالک قرار گيرد.', 'default', array('class' => 'success-msg'));
		$this->redirect('/users/home');
	}
	
	
	function getprice($product_id,$duration){
		$this->layout = 'ajax';
		$product=$this->Product->find('first',array('conditions'=>array('Product.id'=>$product_id), 'fields' => array('Product.cost'),'recursive' =>-1));
		$price=$this->costs($product['Product']['cost']);
		echo $price[$duration];
	}
	
	function verify_online($merchent){
		$url = $this->params['url'];
		
		$merchent_data = $this->Payment->find('first', array('conditions' => array('Payment.merchant' => $merchent), 'fields' => array('Payment.settings', 'Payment.id')));
		eval($merchent_data['Payment']['settings']);
		$settings['site'] = $this->setting['website'];
		$settings['payment_id'] = $merchent_data['Payment']['id'];

		foreach($settings as $key => $setting) $this->{$merchent}->SetVar($key, $setting);
		
		$res = $this->{$merchent}->Verify($url);
		if($res){
			$user = $this->User->findById($res['Transaction']['user_id']);
			if($user['User']['referrer_id'] != 0){
				$this->Transaction->create();
				$temp['Transaction']['date'] = time();
				$temp['Transaction']['amount'] = ($this->setting['top_user_percent']/100)*$res['Transaction']['amount'];
				$temp['Transaction']['user_id'] = $user['User']['referrer_id'];
				$temp['Transaction']['payment_id'] = 0;
				$temp['Transaction']['confirmed'] = 1;
				$temp['Transaction']['desc'] = 'پورسانت حاصل از تراکنش آنلاين کاربر '.$res['Transaction']['user_id'];
				$this->Transaction->save($temp);
			}
			
			$order_info = $this->Session->read('order_info');
			
			if(!empty($order_info)){
				$this->Session->setFlash('تراکنش شما با موفقيت ثبت گرديد. لطفا سفارش زير را پرداخت نماييد.', 'default', array('class' => 'success-msg'));
				$this->redirect(array('controller'=>'users', 'action' => 'PayOrder', 'id' => $order_info['id']));
			}else{
				$this->Session->setFlash('تراکنش شما با موفقيت ثبت گرديد', 'default', array('class' => 'success-msg'));
				$this->redirect(array('controller'=>'users', 'action' => 'home'));
			}
			
		}else{
			$this->Session->setFlash('مشکلی در ثبت تراکنش به وجود آمده است', 'default', array('class' => 'error-msg'));
			$this->redirect(array('controller'=>'users', 'action' => 'home'));
		}
	}
	
	function guest_ticket($email,$ticket_id)
	{
		if($this->data){
			$this->redirect(array('controller'=>'users', 'action' => 'guest_ticket', $this->data['Ticket']['email'], $this->data['Ticket']['ticket_id']));
		}
		else{
			$message=$this->Message->find('first',array('conditions'=>array('Message.ticket_id' => $ticket_id , 'Message.email'=> $email)));
			if(!empty($email) && !empty($ticket_id) && $message['Message']['id']){
				$tickets=$this->Ticket->find('first',array('conditions'=>array('Ticket.user_id' => '-1', 'Ticket.id'=>$ticket_id),'recursive' => 1));
				$ticketreplies=$this->Ticketreply->find('all',array('conditions'=>array('Ticketreply.ticket_id'=>$ticket_id, 'Ticketreply.note'=>0),'order' => array('Ticketreply.date ASC'),'recursive' => 1));
				if ($tickets['Ticket']['user_unread'] == 1)
				{
					$temp['Ticket']['user_unread'] = 0;
					$this->Ticket->id = $tickets['Ticket']['id'];
					$this->Ticket->save($temp);
				}
				$this->set('setting',$this -> setting);
				$this->set('ticketreplies',$ticketreplies);
				$this->set('ticket',$tickets);
				$this->set('message',$message);
			}
			elseif(!empty($email) && !empty($ticket_id)){
				$this->Session->setFlash('شماره تيکت با ايميل مطابقت ندارد.', 'default', array('class' => 'error-msg'));
				$this->redirect(array('controller'=>'users', 'action' => 'guest_ticket'));
			}
		}
	}
	
	function guest_postticketreply($email,$ticket_id)
	{
		
		$message=$this->Message->find('first',array('conditions'=>array('Message.ticket_id' => $ticket_id , 'Message.email'=> $email)));
		if(!empty($message)){
			$ticket=$this->Ticket->find('first',array('conditions'=>array('Ticket.id'=>$ticket_id)));

				if (!empty($this->data)) {
					$this->data['Ticketreply']['ticket_id'] = $ticket_id;
					if($this->Auth->user('id'))
						$this->data['Ticketreply']['user_id'] = $this->Auth->user('id');
					else
						$this->data['Ticketreply']['user_id'] = -1;
					$this->data['Ticketreply']['date'] = time();
					$this->Ticketreply->create();
					//$this->Ticketreply->save($this->data);
					
					if($this -> setting['send_email']==1)
					{
						$this->set('reply_content',$this->blockqoute($this->data['Ticketreply']['content']));
						$this->set('ticket_id',$ticket_id);
						$this->set('replydate',$this->data['Ticketreply']['date']);
						$this->set('setting',$this->setting);
						$ticket=$this->Ticket->find('first' , array('conditions'=>array('Ticket.id'=>$ticket_id)));
						$user=$this->User->find('first' , array('conditions'=>array('User.id'=>$ticket['Ticket']['user_id'])));
						$this->Email->to = $this -> setting['mail_address'];
						if($this->Auth->user('id'))
							$this->Email->from = $user['User']['name'].' <'.$user['User']['email'].'>';
						else
							$this->Email->from = $message['Message']['name'].' <'.$message['Message']['email'].'>';
							
						$this->Email->subject = 'پاسخ جديد در تيکت: #'.$ticket_id.' - '.$ticket['Ticket']['title'];
						$this->Email->template = 'ticketreply';
						$this->Email->sendAs = 'html';
						$this->Email->send();
					}
					
					if($this->Ticketreply->save($this->data))
					{
						$temp['Ticketreply']['user_unread'] = $this->data['Ticketreply']['user_unread'];
						$temp['Ticketreply']['status'] = $this->data['Ticketreply']['status'];
						unset($this->data);
						$this->Ticket->id = $ticket_id;
						
						$this->data['Ticket']['status'] = 2;
						
						$this->Ticket->save($this->data);

						$this->Session->setFlash('پاسخ به تيکت مورد نظر با موفقيت ارسال شد.','default', array('class' => 'success-msg'));

					}else
						$this->Session->setFlash('پاسخ ارسالی بايد حاوی نوشته باشد.','default', array('class' => 'error-msg'));
						
						$this->redirect(array('controller' => 'users','action' => 'guest_ticket',$email,$ticket_id));
				}
		}
		else
		{
			$this->Session->setFlash('تيکت مربوط به شما نمي باشد.','default', array('class' => 'error-msg'));
			$this->redirect(array('controller' => 'users','action' => 'guest_ticket'));
		}
	}
	
	function get_attachment($fileName){
        $this->layout = 'ajax';
       
        $reply_info = $this->Ticketreply->find('first', array('conditions' => array('Ticketreply.attached_file' => $fileName)));
        if($reply_info){
            $ticket_info = $this->Ticket->find('first', array('conditions' => array('Ticket.id' => $reply_info['Ticketreply']['ticket_id']), 'recursive' => -1));
           
            if($this->Auth->user('id') == $ticket_info['Ticket']['user_id'] || $this->Auth->user('role') == 4 ){
                $this->RequestHandler->setContent('zip','application/x-zip');
                $this->RequestHandler->respondAs('zip',array('application/x-zip'));
                header('Content-Length: '.filesize('../uploads/'.$fileName) );
                echo file_get_contents('../uploads/'.$fileName);
                ob_end_flush();
            }else{
                $this->Session->setFlash('شما اجازه دسترسی به اين فايل را نداريد.', 'default', array('class' => 'error-msg'));
                $this->redirect(array('controller' => 'users', 'action' => 'tickets', $reply_info['Ticketreply']['ticket_id']));
            }
        }else{
            $this->Session->setFlash('فايل مورد نظر موجود نمي باشد.', 'default', array('class' => 'error-msg'));
            $this->redirect(array('controller' => 'users', 'action' => 'tickets', $reply_info['Ticketreply']['ticket_id']));
        }
    }
	
}

?>