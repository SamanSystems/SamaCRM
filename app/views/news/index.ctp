<?php
if(isset($allnews)){
foreach ( $allnews as $news ) {
	echo '<div class="content_title">
			<h2>'.$html->link($news['News']['title'], array('controller'=>'news','action' => 'index',$news['News']['id'])).' <span class="date" style="font-size: 11px; font-weight: normal">('.$jtime->pdate("l j F Y", $news['News']['date']).')</span></h2>';
			if(!empty($news['News']['newscategory_id'])) echo' <span class="category" style="font-size: 11px; font-weight: normal">شاخه: '.$html->link($news['Newscategory']['name'], array('controller'=>'news','action' => 'category',$news['News']['newscategory_id'])).'</span>';
echo '		</div>';

	echo '<div class="content_content">'.
			$news['News']['content'].
		'</div>';

}
?>
		<div class="content_content">
		<div class="paginate">
					<ul>
						<?php								
							$paginator->options(array('url' => $this->passedArgs));
							echo $paginator->prev('«قبلي   ', null, null, array('class' => 'disabled')).
								$paginator->next(' بعدي »', null, null, array('class' => 'disabled'));
						?>
					</ul>
		</div>
		</div>
		<div class="clear"> </div>

<?php
}
else{
echo '<div class="content_title">
		<h2>'.$news['News']['title'].' <span class="date" style="font-size: 11px; font-weight: normal">('.$jtime->pdate("l j F Y", $news['News']['date']).')</span></h2>';
		if(!empty($news['News']['newscategory_id'])) echo' <span class="category" style="font-size: 11px; font-weight: normal">شاخه: '.$html->link($news['Newscategory']['name'], array('controller'=>'news','action' => 'category',$news['News']['newscategory_id'])).'</span>';
		echo'
	</div>';

echo '<div class="content_content">'.
		$news['News']['content'].
	'</div>';
}
?>