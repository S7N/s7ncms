$(function(){
	// show messages
	$('#error_message').fadeIn("slow");
	$('#info_message').fadeIn("slow");

	// zebra tables
	$("tr:nth-child(even)").addClass("even");

	// menu
	$('#navigation li:last').addClass('last');

	// tabs
    $("#contentmenu").tabs();
    
    $("#dialog").dialog({
		autoOpen: false,
		resizable: false,
		modal: true,
		buttons: {
			'Cancel': function() {
				$(this).dialog('close');
			},
			'Delete': function() {
				window.location = $("#dialog").dialog('option', 'href');
				$(this).dialog('close');
			}
		}
	});
    
    // confirm before delete
	$('a.confirm').click(function(){
		$("#dialog").dialog('option', 'href', this.href);
		$("#dialog").dialog('open');
		
		return false;
	});
});