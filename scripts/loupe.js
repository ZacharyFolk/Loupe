var $ = jQuery;
$(document).ready(function(){
var colors = $.cookie('colors');

	$(".box_2f2").click(function(){
		$('body').removeClass('c000 cfff c2f2');
		$('body').addClass('c2f2');
		$.cookie('colors','middleGrey');
		return false;
		});
	$(".box_fff").click(function(){
		$('body').removeClass('c000 cfff c2f2');
		$('body').addClass('cfff');
		$.cookie('colors','white');
		return false;
		});
	$(".box_000").click(function(){
		$('body').removeClass('c000 cfff c2f2');
		$('body').addClass('c000');
		$.cookie('colors','black');
		return false;
		});
/*	if(colors == 'middleGrey')
	{
	$('body').addClass('c2f2');
	}
	if (colors == 'white')
	{
	$('body').addClass('cfff');
	}
	if(colors == 'black')
	{
	$('body').addClass('c000');
	}
	*/
	});