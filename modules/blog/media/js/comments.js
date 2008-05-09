$(function() {
	$('#form_comment').focus(function(e) {
		$('#form_comment').after('<input type="hidden" name="location" value="none" />');
		$('#form_comment').unbind('focus');
	});	
});