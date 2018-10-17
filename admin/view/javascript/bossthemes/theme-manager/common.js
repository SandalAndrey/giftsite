$(function () {
	// Switch
	$('input[type="checkbox"], input[type="radio"]').each(function(index, element) {
        $(this).addClass('switch-input').wrap('<label class="switch switch-default switch-pill switch-primary"></label>').after('<span class="switch-label"></span><span class="switch-handle"></span>');
    });
});
