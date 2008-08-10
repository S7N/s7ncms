$(function() {
	$('form #content').focus(function(e) {
		$('form #content').after('<input type="hidden" name="location" value="none" />');
		$('form #content').unbind('focus');
	});	
});