			<div class="menu-box news">
					<h2>اخبار</h2>
					
					<ul class="list">
						<?php
						$news = $this->requestAction('/news/show');
							foreach ($news as $new) echo '<li>'.$html->link($new['News']['title'],array('controller' => 'news', 'action' => 'index','id' => $new['News']['id'])).'</li>';
						?>
					</ul>
					
			</div>