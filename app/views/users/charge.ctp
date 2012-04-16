<?php

echo '<div class="content_title">
		<h2>افزايش اعتبار</h2>
	  </div>
		
		<div class="content_content">'
		.$html->link ($html->image('/img/icons/pay.png').'شارژ نقدی (فیش ها)',array('controller' => 'users', 'action'=>'charge', 'bank'),array('class'=>'button' , 'title'=>'شارژ نقدی (فیش ها)' , 'escape'=>false ,'style'=>'width:175px;' )).'<br /><br />'
		.$html->link ($html->image('/img/icons/cardcharge.png').'شارژ اعتباری (کوپن شارژ)',array('controller' => 'users', 'action'=>'charge', 'cardcharge'),array('class'=>'button' , 'title'=>'شارژ کارتی (کارت شارژ)' , 'escape'=>false ,'style'=>'width:175px;' )).'<br /><br />'
		.$html->link ($html->image('/img/icons/credit.png').'شارژ آنلاین (کارتهای عضو شتاب)',array('controller' => 'users', 'action'=>'charge', 'online'),array('class'=>'button' , 'title'=>'شارژ آنلاین (کارتهای عضو شتاب)' , 'escape'=>false ,'style'=>'width:175px;' ));
		
$banks = $this->requestAction('/payments/show');
echo '<br /><br /><table width="99%" class="listTable">
	<tr>
		<th width="100">نام بانک</th>
		<th>توضیحات</th>
	</tr>
';
	foreach ($banks as $bank)
	{
		echo '<tr><td>'.$bank['Payment']['name'].'</td><td>'. $bank['Payment']['desc'].'</td></tr>';
	}
echo '</table>
</div>';

?>