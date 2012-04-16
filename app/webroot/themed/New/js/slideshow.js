function Slider()
{
	var $active = ( $('#slideshow ul li.active').length == 0 ) ? $active = $('#slideshow ul li:first') : $('#slideshow ul li.active');
	var $next = ( $active.next().length == 0 ) ? $('#slideshow ul li:first') : $active.next();

	//$active.children('span').animate({bottom: -28}, 1000, function () {
	$active.fadeOut('slow', function() {
		$active.removeClass('active');
		$next.fadeIn('slow');
		$next.addClass('active');
	})
	
}

$(function () {
	var playSlide = setInterval('Slider()', 6000);
});
