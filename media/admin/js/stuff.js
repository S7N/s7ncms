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
});