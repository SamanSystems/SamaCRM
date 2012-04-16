<?php

	if($address['cat']=='home' & $address['slug']=='home')
		echo $this->element('slideshow' , array("cache" => "+1 hour"));
	

	$WhoisForm = $form->create ('User',array('url' => array('controller'=>'users', 'action' =>'whois'),'class' => 'whois'))
				.$form->input('domain', array('class' => 'input-eng'))
				.$form->input('ext')
				.$form->end(__('Whois',true));
	
	$result['Page']['content'] = preg_replace('/%whois%/i',$WhoisForm,$result['Page']['content']);
	
	if(strpos($result['Page']['content'], '%contact%') !== false){
		$ContactForm = $form->create('Message',array('url' => array('controller'=>'pages', 'action'=>'contact')))
				.$form->input('name')
				.$form->input('phone')
				.$form->input('email',array('class' => 'input-eng'))
				.$form->input('ticketdepartment_id',array('options' => $guest_department))
				.$form->input('title',array('label'=>'عنوان پيام'))
				.$form->input('content',array('type' => 'textarea','label'=>'متن پیام'))
				.$form->label('captcha').$recaptcha->display()
				.$form->end('  ثــــــبــت  ');
		$result['Page']['content'] = preg_replace('/%contact%/i',$ContactForm,$result['Page']['content']);
	}
	

	
	$property_table='<table border="0" class="listTable">
	<tbody>
	<tr>
	<th>مشخصات سرويس</th>';


	foreach($products as $product) {
		$property_table.= '<th>'.$product['Product']['name'].'</th>';
		$order_links.= '<td>'.$html->link($html->image("icons/cart.png", array("alt" => "خريد")),array('controller' => 'users', 'action' => 'neworder', 'id' =>$product['Product']['id']), array('escape'=>false)).'</td>';
		foreach($product['Product']['costs'] as $month => $cost)
		{
			switch($month)
			{
				case 1:
					$costs[1].='<td>'.$cost.'</td>';
					break;
				case 6:
					$costs[6].='<td>'.$cost.'</td>';
					break;
				case 3:
					$costs[3].='<td>'.$cost.'</td>';
					break;
				case 12:	
					$costs[12].='<td>'.$cost.'</td>';
					break;
				case 24:
					$costs[24].='<td>'.$cost.'</td>';
					break;
				case 60:
					$costs[60].='<td>'.$cost.'</td>';
					break;
				case -120:
					$costs[-120].='<td>'.$cost.'</td>';
					break;
			}
			
		}
	}
	

	$property_table.='</tr>';
	

	foreach($properties as $property){
	$property_table.= '
	<tr>
		<td>'.$property['Property']['name'].'</td>';
		foreach ($property['Productproperty'] as $product_property)
			$property_table.= '<td>'.$product_property['value'].'</td>';
	$property_table.= '	</tr>';
	}
	foreach($costs as $key=>$price)
	{
		switch($key)
		{
			case 1:
				$property_table.='<tr> <td>قیمت ماهانه </td>'.$costs[1].'</tr>';
				break;
			case 3:
				$property_table.='<tr> <td> قیمت سه ماهه </td>'.$costs[3].'</tr>';
				break;
			case 6:
				$property_table.='<tr> <td> قیمت شش ماهه </td>'.$costs[6].'</tr>';
				break;
			case 12:
				$property_table .='<tr><td> قیمت سالانه </td>'.$costs[12].'</tr>';
				 break;
			case 24:
				$property_table .='<tr><td> قیمت دوساله </td>'.$costs[24].'</tr>';
				break;
			case 60:
				$property_table .='<tr><td> قیمت پنج ساله </td>'.$costs[60].'</tr>';
				break;
			case -120:
				$property_table .='<tr><td> قیمت پرداخت يک باره</td>'.$costs[-120].'</tr>';
				break;
		}
	}
	if(isset($user))
	{
		$property_table.='
		<tr>
		<td><b>خريد</b></td>'.$order_links;
		
		$property_table.='
		</tr>';
	}
	$property_table.='
	</tbody>
	</table>
	';	
	
	$result['Page']['content'] = preg_replace('/%servicetable=(.*)%/si', $property_table, $result['Page']['content']);
	
	if(isset($user))
	{
		$find = array('/<!--IfIsNotLogin-->(.*)<!--\/IfIsNotLogin-->/si','/<!--\/IfIsLogin-->/i','/<!--IfIsLogin-->/i');
		$result['Page']['content']=preg_replace($find, ' ', $result['Page']['content']);
		$result['Page']['content'] = preg_replace('/%orderlink=(.*)%/si', '/users/neworder/$1', $result['Page']['content']);
	}else
	{
		$find = array('/<!--IfIsLogin-->(.*)<!--\/IfIsLogin-->/si','/<!--\/IfIsNotLogin-->/i','/<!--IfIsNotLogin-->/i');
		$result['Page']['content']=preg_replace($find, ' ', $result['Page']['content']);
	}
echo '<div class="content_title">
		<h2>'.$result['Page']['title'].'</h2>
		</div>
		
	  <div class="content_content">'
		.$result['Page']['content'].	
	  '</div>';

?>