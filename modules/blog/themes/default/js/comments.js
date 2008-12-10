$(function() {
	$('#commentform #content').focus(function(e) {
		$('#commentform #content').after('<input type="hidden" name="location" value="none" />');
		$('#commentform #content').unbind('focus');
	});	
});