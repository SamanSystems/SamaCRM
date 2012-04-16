<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
		echo $html->meta('icon')."\n".
		$html->charset()."\n".
		$scripts_for_layout;
?>
<style>
.printcardcharge {
	border-left-style: solid;
	border-left-width: 1px;
	border-right: 1px solid #C0C0C0;
	border-top-style: solid;
	border-top-width: 1px;
	border-bottom: 1px solid #C0C0C0;
	width: 740px;
	border-collapse: collapse;
	border-color: black;
	margin: 70px auto;
}
.printcardcharge td {
	text-align: center;
	font: 11px Tahoma;
	padding: 3px;
}
#printcardcharge{
	width: 729px;
	margin: 0 auto;
	font-family: Tahoma, Arial;
	position: relative;
}
#printcardcharge h1{
	font-family: "B Titr", Arial;
	font-size: 14pt;
	text-align: center;
	padding: 45px 0 0 0;
	margin: 0;
}
#printcardcharge .address{
	font-size: 11px;
	text-align: center;
}
#printcardcharge .company{
	padding-left: 30px;
	text-align: left;
	font-family: B Titr, Arial;
	font-size: 16px;
}
#order_number {
	position: absolute;
	left: 10px;
	top: -15px;
	font: 16px "B Zar", Arial;
}
#date {
	position: absolute;
	left: 10px;
	top: -25px;
	font: 16px "B Zar", Arial;
}
@page { size 15cm 21cm }
</style>
<title>کارت شارژ <?php echo $title_for_layout; ?></title>
</head>
<body>
<div id="printcardcharge" align="center">
<?php echo $content_for_layout; ?>
</div>
</body>
</html>