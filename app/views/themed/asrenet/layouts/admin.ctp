<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
		echo $html->meta('icon')."\n".
		$html->charset()."\n".
		$html->css('style.css')."\n".
		$javascript->link(array('jquery','functions','pngfix','live','tiny_mce/tiny_mce'))."\n".
		$html->meta('keywords', 'Iran web hosting, هاست, وب هاستينگ, وب هاستینگ, ميزباني, دومين, دامنه, لينوکس, لینوکس, ويندوز, طراحی سایت, نرم افزار, وب رمز, ویندوز, ويندوز, سايت, میزبانی', array(), false).
		$html->meta('description', 'هاست میزبانی وب ثبت دامنه طراحی سایت وب هاستینگ ثبت دومین سرور اختصاصی' , array(), false).
		$scripts_for_layout;
?>
<script type="text/javascript">
	tinyMCE.init({
		mode : "exact",
		elements : "editor",
		theme : "advanced",
		skin : "o2k7",
		plugins : "safari,table,advimage,advlink,emotions,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,inlinepopups,falang",
		theme_advanced_buttons1 : "faen,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect,code",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,media,|,ltr,rtl,|,fullscreen",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "center",
		directionality : "rtl",
		theme_advanced_statusbar_location : "bottom",
		force_br_newlines: true,
		forced_root_block: "",
		convert_urls : false,
		verify_html : false
	});
</script>
<title>عصرنت | هاست | هاستینگ | میزبانی وب | ثبت دامنه | دومین | سروراختصاصی | سرور مجازی <?php echo $title_for_layout; ?></title>
</head>
<body>

<div class="wrapper">
	
	<div class="top_corners"></div>
	
	<div class="header">
		<div class="navigation">
			<?php echo $this->element('menu',array('cache' => '+2 days')); ?>
		</div>
		<div class="clear"></div>
		<div class="banner"></div>
	</div>
	
	<div class="main">
		
		<div class="right">
			<?php
			 echo $this->element('news-block',array('cache' => '+1 hour')).
			  $this->element('user-block',array('user' => $user));
			?>
		</div>
		
		<div class="left">
			<div class="content">
				<?php echo $this->element('live-status',array('cache' => '+10 days')); ?>
				
				<?php if ( $session->check('Message.flash') ) $session->flash();
				echo $content_for_layout; ?>
			</div>
		</div>
		
		<div class="clear"></div>
		
	</div>
	
	<div class="footer">
		<p>کلیه حقوق این وبسایت متعلق به <a href="http://www.asrenet.com/">عصرنت</a> می باشد.<br />
			طراحی و پياده سازی: <a href="http://www.samansystems.com/">شرکت سیستم های یکپارچه سامان</a></p>
	</div>
	
	<div class="bottom_corners"></div>
	
</div>

</body>
</html>