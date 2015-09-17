$(document).ready(function(){
var hash = window.location.hash;
	$('#title').slideDown('slow');
	$('#content').fadeIn('slow');
});
$('#newhelplink').click(function(){
	$('#newhelp').toggle('fast');
});
$('#whatpic_click').click(function(){
	$('#whatpic').toggle();
});
