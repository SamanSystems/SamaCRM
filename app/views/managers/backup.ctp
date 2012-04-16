<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
		echo $html->meta('icon')."\n".
		$html->charset()."\n".
		$html->css(array('style.css', 'jqueryui/jquery-ui.css'))."\n".
		$javascript->link(array('jquery', 'jquery-ui', 'jquery-smscounter', 'functions', 'pngfix', 'jquery.tipTip'))."\n".
		$html->meta('keywords', 'سامانه ارسال پيامک کوتاه فارسی انگليسی', array(), false).
		$html->meta('description', 'سامانه ارسال پيامک کوتاه' , array(), false).
		$scripts_for_layout;
?>
	<title>.: AsreSMS - عصر اس ام اس :. درگاه ارسال پيامک انبوه <?php echo $title_for_layout; ?></title>
</head>

	<body>
		
	<div class="page">
		
		<div class="livesupport">
			<!-- LiveSupport Chat Button Link Code --><a href="javascript:void(window.open('http://support.samanfamily.com/chat.php?intgroup=QXNyZVNNUw==&amp;hg=Pw__&amp;reset=true','','width=590,height=580,left=0,top=0,resizable=yes,menubar=no,location=no,status=yes,scrollbars=yes'))"><img src="http://support.samanfamily.com/image.php?id=03&amp;hg=Pw__&amp;intgroup=QXNyZVNNUw==" width="30" height="150" border="0" alt="LiveZilla Live Help"></a><noscript><div><a href="http://support.samanfamily.com/chat.php?intgroup=QXNyZVNNUw==&amp;hg=Pw__&amp;reset=true" target="_blank">Start Live Help Chat</a></div></noscript><!-- LiveSupport Chat Button Link Code --><!-- LiveSupport Tracking Code --><div id="livezilla_tracking" style="display:none"></div><script type="text/javascript">var script = document.createElement("script");script.type="text/javascript";var src = "http://support.samanfamily.com/server.php?request=track&output=jcrpt&reset=true&nse="+Math.random();setTimeout("script.src=src;document.getElementById('livezilla_tracking').appendChild(script)",1);</script><!-- LiveSupport Tracking Code -->		</div>
		<div id="info">
			<div class="TEXT">
				<div class="call">Tel: +98 21 8801 2882</div>
			</div>
		</div>
			
			<div id="header">
				<div class="Navigation">
					<?php echo $this->element('menu',array('cache' => '+2 days')); ?>
				<div class="clear"></div>
				</div>
			</div>
			
			<div class="customers">
				<div class="TEXT2">
					<?php echo $this->element('topcustomers',array("cache" => "+1 day")); ?>
				</div>
			</div>
		
		<div class="content">
			
			<div class="RightSide">
				<?php
					echo $this->element('user-block',array('user' => $user)).
						 $this->element('news-block',array('cache' => '+1 hour'));
				?>
			</div>
			<div class="Post">
				<?php
					if($address['cat'] == 'home' && $address['cat'] == 'home'){
						echo '<center>'. $this->Html->link($this->Html->image('/img/demo-panel.jpg'), array('controller' => 'users', 'action' => 'LoginAsDemo'), array('escape' => false, 'title' => 'دمو سامانه ارسال پيامک عصر اس ام اس')) .'</center><br />';
					}
				
					echo $session->flash('auth');
					if ( $session->check('Message.flash') ) echo $session->flash();
					echo $content_for_layout; 
				?>
				<div class="Postdesc"></div>
			</div>		
			
		<div class="clear"></div>	
		
		</div>
		
	</div>
		
		<div class="clear"></div>
			
			<div class="bottom">
			<br />
				کلیه حقوق این وبسایت متعلق به سايت AsreSMS می‌باشد.<br />
				طراحی و پياده سازی: <a href="http://www.samansystems.com/">شرکت سامان سيستم پرداز کيش</a>
				<?php echo $this->element('sql_dump'); ?>
			</div>

	</body>
	
</html>	