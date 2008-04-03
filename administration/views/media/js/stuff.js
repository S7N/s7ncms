$(function() {
	// show messages
	$('#error').fadeIn("slow");
	$('#message').fadeIn("slow");
	
	// zebra tables
	$("tr:nth-child(even)").addClass("even");
	
	// menu
	$('#navigation li:last').addClass('last');
	
	// tabs
    $("#tabs > ul").tabs();	
});