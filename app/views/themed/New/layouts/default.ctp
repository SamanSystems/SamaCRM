<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<?php
		echo $html->meta('icon')."\n".
		$html->charset()."\n".
		$html->css('style.css')."\n".
		$javascript->link(array('jquery','functions','pngfix'))."\n".
		$html->meta('keywords', 'Iran web hosting, هاست, وب هاستينگ, وب هاستینگ, ميزباني, دومين, دامنه, لينوکس, لینوکس, ويندوز, طراحی سایت, نرم افزار, وب رمز, ویندوز, ويندوز, سايت, میزبانی', array(), false).
		$html->meta('description', 'هاست میزبانی وب ثبت دامنه طراحی سایت وب هاستینگ ثبت دومین سرور اختصاصی' , array(), false).
		$scripts_for_layout;
?>
<title>Hpert.com <?php echo $title_for_layout; ?></title>

</head>
<body>

	<div id="header">
		<div class="logo"> </div>
		<div id="wrapper">
			<div class="contact">
				<a href="/pages/contact"> </a>
			</div>
			<?php echo $this->element('menu',array('cache' => '+2 days')); ?>
		</div>

	</div>
	
	<div id="wrapper" class="main">
		
		<div id="content">
				<?php
					$session->flash('auth');
					if ( $session->check('Message.flash') ) $session->flash();
					echo $content_for_layout; 
				?>
					<a href="" class="vps"></a>
					<a href="" class="reseller"></a>
					<a href="" class="domain"></a>
					<a href="" class="hosting"></a>
		</div>
		
		<div id="left">
			<?php
				echo $this->element('news-block',array('cache' => '+1 hour')).
					$this->element('user-block',array('user' => $user)).
					$this->element('merchants', array('cache' => '+1 month')).
					$this->element('topcustomers',array("cache" => "+1 day"));
			?>
		</div>
		
	</div>
	<div class="copyright">
		<div id="wrapper">
			تمامی حقوق اين وب سايت متعلق به <a href="http://samansystems.com/" targe="_blank">شرکت سيستم های يکپارچه سامان</a> می باشد.
		</div>
	</div>

</body>

</html>