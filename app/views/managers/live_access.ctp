<?php    if(empty($total['customer_reply'])) $total['customer_reply'] = 0;    if(empty($total['customer_operating'])) $total['customer_operating'] = 0;	if(empty($total['transaction'])) $total['transaction'] = 0;    $total['nowh'] = $jtime->pdate("H", time());	$total['nowm'] = $jtime->pdate("i", time());	    $rs = explode('?', $_GET['callback']);       echo $rs[0] . '('.json_encode($total).')';?>