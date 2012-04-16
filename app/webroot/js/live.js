(function ($)
{
	$.fn.LiveStatus = function (interval)
	{
		var interval = interval || 120000;
		
		return this.each(function ()
		{
			var $state = $(this);
			
			function render ()
			{
				$.ajax({
					url: '/managers/last_update',
					type: 'GET',
					
					success: function (result) {
						$state.fadeIn();
						result = result.split('|');
						$state.find('span:eq(0)').text(result[0]);
						$state.find('span:eq(1)').text(result[3]);
						$state.find('span:eq(2)').text(result[4]);
					}
				});
				setTimeout(render, interval);
			}
			render();
		});
	}
})(jQuery);

$(function () {
	$('.LiveStatus').each(function () {
		$(this).LiveStatus();
	});
});