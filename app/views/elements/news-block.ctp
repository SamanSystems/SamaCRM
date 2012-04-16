			<div class="block">
				<div class="block_title">
					<h2>اخبار</h2>
				</div>
				<div class="block_content">
					<ul class="list">
<?php
$news = $this->requestAction('/news/show');
	foreach ($news as $new) echo '<li>'.$html->link($new['News']['title'],array('controller' => 'news', 'action' => 'index','id' => $new['News']['id'])).'</li>';
?>
					</ul>
				</div>
			</div>