<div class=content_title>
	<h2>سفارش سرويس های مرتبط</h2>
</div>
<div class="content_content">
<?php
	foreach($relative_services as $keys => $service)
	{
		$productstable .='<table border="0" class="listTable">
		<tbody>
		<tr>
		<th>'. $service['Service']['name'] .'</th>';
		
		$order_links = '';
		unset($costs);
		
			foreach($service['Product'] as $keyp => $product)
			{
				$productstable .= '<th>'.$product['name'].'</th>';

				$order_links.= '<td>'.$html->link($html->image("icons/cart.png", array("alt" => "خريد")),array('controller' => 'users', 'action' => 'neworder', 'id' =>$product['id']), array('escape'=>false)).'</td>';
				
				$productstable_tr .= 
				$cost=explode(':',$product['cost']);
				foreach($cost as $row)
				{
					$temp=explode(',',$row);
					$costs[$temp[0]].='<td>'.$temp[1].'</td>';
				}
					array_pop($products[$key]['Product']['costs']);
			}
			
			foreach($costs as $key=>$price)
			{
				switch($key)
				{
					case 1:
						$productstable .='<tr> <td>قیمت ماهانه </td>'.$costs[1].'</tr>';
						break;
					case 3:
						$productstable .='<tr> <td> قیمت سه ماهه </td>'.$costs[3].'</tr>';
						break;
					case 6:
						$productstable .='<tr> <td> قیمت شش ماهه </td>'.$costs[6].'</tr>';
						break;
					case 12:
						$productstable .='<tr><td> قیمت سالانه </td>'.$costs[12].'</tr>';
						 break;
					case 24:
						$productstable .='<tr><td> قیمت دوساله </td>'.$costs[24].'</tr>';
						break;
					case 60:
						$productstable .='<tr><td> قیمت پنج ساله </td>'.$costs[60].'</tr>';
						break;
				}
			}
		$productstable.='
			<tr>
			<td><b>خريد</b></td>'.$order_links.'</tr>
		</tbody>
		</table><br />';
	}
	
	echo $productstable;
?>
</div>