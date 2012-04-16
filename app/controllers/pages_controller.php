<?php
class PagesController extends AppController
{
	var $name = 'Pages';
	var $uses = array('Page','User','Message','Property','Product','Ticket','Ticketreply','Ticketdepartment');
	var $helpers = array('Javascript','Form');
	var $components = array('Security', 'Whois', 'Recaptcha.Recaptcha', 'Asresms');
	
	function display($slug, $cat='pages')
	{
		$guest_department = $this->Ticketdepartment->find('list',array('conditions'=>array('Ticketdepartment.guest_access'=>1), 'fields' => array('Ticketdepartment.id','Ticketdepartment.name'),'order'=> 'Ticketdepartment.department_order'));
		$this->set('guest_department',$guest_department);
		$result=$this->Page->find('first',array('conditions' => array('Page.slug' =>$slug, 'Page.cat' =>$cat)));
		$this->set('result',$result);
		$keys = array_keys($this->Whois->whois_servers);
		foreach($keys as $key) $exts[$key] = $key;
		$this->set('exts', $exts);
		if(preg_match('/%servicetable=(.*)%/si',$result['Page']['content'] ,$matches))
		{
				$this->set('properties',$this->Property->find('all',array('conditions'=>array('Property.service_id'=> $matches[1]))));
				$products=$this->Product->find('all',array('conditions'=>array('Product.service_id'=> $matches[1]),'recursive' => -1, 'order' => array('Product.id')));
				foreach($products as $key=>$product)
				{
					$costs=explode(':',$product['Product']['cost']);
					foreach($costs as $row)
					{
						$temp=explode(',',$row);
						$products[$key]['Product']['costs'][$temp[0]]=$temp[1];
					}
						array_pop($products[$key]['Product']['costs']);
				}
				$this->set('products',$products);
		}

		$this->set('address',array('cat' => $cat,'slug' => $slug));
	}
	
	function contact()
	{
		
		if($this->data)
		{
			if ($this->Recaptcha->verify()) {
				$this->data['Ticket']['user_id'] = -1;
				$this->data['Ticket']['title'] = $this->data['Message']['title'];
				$this->data['Ticket']['date'] = time();
				$this->data['Ticket']['priority'] = 0;
				$this->data['Ticket']['status'] = 0;
				$this->data['Ticket']['ticketdepartment_id'] = $this->data['Message']['ticketdepartment_id'];
				
				if($this->Ticket->save($this->data))
				{
					$this->data['Ticketreply']['ticket_id'] = $this->Ticket->id;
					$this->data['Ticketreply']['user_id'] = -1;
					$this->data['Ticketreply']['content'] = $this->data['Message']['content'];
					$this->data['Ticketreply']['date'] = time();
					if($this->Ticketreply->save($this->data)){
						$this->data['Message']['ip'] = $_SERVER['REMOTE_ADDR'];
						$this->data['Message']['ticket_id'] = $this->data['Ticketreply']['ticket_id'];
						if($this->Message->save($this->data)){
							if($this->SavedSetting['send_sms_option'] == 1)
							{
								$Admin_Cell = $this->SavedSetting['admin_cellnum'];
								$this->Asresms->SetVar('gateway_number', $this->SavedSetting['gateway_number']);
								$this->Asresms->SetVar('gateway_pass', $this->SavedSetting['gateway_pass']);
						
								if(!empty($Admin_Cell) && strlen($Admin_Cell) == 11 && substr($Admin_Cell, 0, 2) == '09'){
									$this->Asresms->Send(array('cell' => $Admin_Cell, 'text' => " مدیر محترم تیکت جدیدی با عنوان ". $this->data['Ticket']['title'] . " از قسمت ارتباط با ما افتتاح شده است . \n\n".$this->setting['name'], 'flash' => 0));
								}
							}
						
							$this->Session->setFlash('پیام شما با موفقیت فرستاده شد.', 'default', array('class' => 'success-msg'));
							$this->redirect(array('controller' => 'users', 'action' => 'guest_ticket', $this->data['Message']['email'], $this->Ticket->id));
						}
						else{
							$this->Session->setFlash('در فرستادن پیام شما مشکلی پیش آمده است', 'default', array('class' => 'error-msg'));
							$this->redirect($_SERVER['HTTP_REFERER']);
						}
					}
					else{
						$this->Session->setFlash('در فرستادن پیام شما مشکلی پیش آمده است', 'default', array('class' => 'error-msg'));
						$this->redirect($_SERVER['HTTP_REFERER']);
					}
				}
				else{
					$this->Session->setFlash('در فرستادن پیام شما مشکلی پیش آمده است', 'default', array('class' => 'error-msg'));
					$this->redirect($_SERVER['HTTP_REFERER']);
				}
			}else{
				$this->Session->setFlash('کد امنيتی وارد شده نامعتبر می باشد.', 'default', array('class' => 'error-msg'));
				$this->redirect($_SERVER['HTTP_REFERER']);
			}
		}
	}

}
?>