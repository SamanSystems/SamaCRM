function Slider()
{
	var $active = ( $('#slideshow ul li.active').length == 0 ) ? $active = $('#slideshow ul li:first') : $('#slideshow ul li.active');
	var $next = ( $active.next().length == 0 ) ? $('#slideshow ul li:first') : $active.next();
	$active.addClass('last-active');
	//$active.children('span').animate({bottom: -28}, 1000, function () {
	$next.hover(function () {
		$(this).children('span').animate({bottom: 0}, 1000);
	},
	function () {
		$(this).children('span').animate({bottom: -28}, 1000);
	});
	$next.css({opacity: 0.0})
		.addClass('active')
		.animate({opacity: 1.0}, 1000, function () {
				$active.removeClass('active last-active');
			});
}

$(function () {
	$('ul.latests').mySpy();
	var playSlide = setInterval('Slider()', 6000);
	$('.more').click(function () {
		var $more = $(this).parent().find('li[class=active]');
		var $next = ( $more.next().length == 0 ) ? $(this).parent().find('li:first') : $more.next();
		
		$more.removeClass('active');
		$more.fadeOut('normal', function() {
			$next.addClass('active').fadeIn('normal');
		});
	});
});

(function ($)
{
	$.fn.mySpy = function (interval)
	{
		var interval = interval || 4000;
		
		return this.each(function ()
		{
			var $list = $(this),
			currentItem = 1;
			items = [],
			total = $list.find('> li').size();
			
			$list.find('> li').each(function () {
				items.push('<li>' + $(this).html() + '</li>');
			});
			
			$list.find('> li:gt(0)').remove();
			
			function spy() {
				var $insert = $(items[currentItem]).prependTo($list).hide();
				var $remove = $list.find('> li:last');
				$remove.fadeOut(1000, function () {
					$(this).remove();
					$insert.fadeIn(1000);
				});
				
				currentItem++;
				if ( currentItem >= total ) currentItem = 0;
				setTimeout(spy, interval);
			}
			spy();
		});
	}
})(jQuery);