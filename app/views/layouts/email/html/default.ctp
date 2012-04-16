<?php
/**
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.view.templates.layouts.email.html
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
	<title><?php echo $title_for_layout;?></title>
</head>
<body marginheight="0" marginwidth="0">
<div align="center" style="background-color:#f2f2f2; font-family:Tahoma; font-size:11px; padding:15px 10px;">
	
    <div style="width:600px; border:1px solid #6f6f6f; background-color:#ffffff; border-radius:5px;">
    		
            <div style="height:31px; background-color:#9b9b9b; color:#FFF;">
				<?php echo $html->image($setting['website'] .'/img/mail/main_asrenet_logo.png', array('url' => $setting['website'], 'title' => $setting['name'], 'alt' => $setting['name'], 'align' => 'left')); ?>
            </div>
    	
        
        
        
        <div style="padding:8px; text-align:right;">

			<?php echo $content_for_layout;?>
	
		<div style="clear:both"></div>  
        </div>
        
        
        
        
        <div style="border-top:1px solid #6f6f6f; padding:8px; height: 45px;">
        
        <?php echo $html->image($setting['website'] .'/img/mail/main_facebook.png', array('url' => 'https://www.facebook.com/pages/asrenetcom/255626521130390', 'title' => 'Facebook', 'alt' => 'Facebook', 'align' => 'left')); ?>
        
        <div style="float:right; width:380px; text-align:right;">
        آدرس: <?php echo $setting['address']; ?><br>
        تلفن: <?php echo $setting['phonenum']; ?><br>
        سايت: <?php echo $html->link($setting['name'],$setting['website']); ?>
        </div>
        
        <br style="clear:both" />
        </div>
    </div>
    
</div>
</body>
</html>