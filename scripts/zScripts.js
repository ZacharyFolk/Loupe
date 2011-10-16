(function() {
var $ = jQuery;
var imgCtrl = $('#controls');
var panel = $('.thumbBox');
var button = $('.all');
var initialState = "collapsed";
var activeClass = "active";
var visibleText = "hide recent posts";
var hiddenText = "show recent posts";
var triangle = $('.tagLink span');
var infoTri = $('#infoLink span');
var closed = "close";
var opened = "open";	
var tags = $('#tagList');	
var tagPanelState = $.cookie("tagPanel");
var tagButton = $('.tagLink');
var tagThumbs = $('.tagTable');
var tagImage = $('.tagImgBox a');
var tagThumbState = $.cookie("tagThumbPanel");
var info = $('#infoPanel');	
var infoPanelState = $.cookie("infoPanel");
var infoButton = $('#infoLink');
var main = $('#ajaxTable');
var tagBump = ("tagged");
var tagTeamBump = ("tagTeam");
var activeTags = "activeTagClass";

//	$('#coda-slider-1').codaSlider();
	if($.cookie("panelState") == undefined) {
		$.cookie("panelState", initialState);
		}
	var state = $.cookie("panelState");
		if(state == "collapsed") {
			panel.hide();
			button.text(hiddenText);
			button.addClass(activeClass);
		}
		button.click(function(){
			if($.cookie("panelState") == "expanded") {
				$.cookie("panelState", "collapsed");
				button.text(hiddenText);
				button.addClass(activeClass);
			} else {
				$.cookie("panelState", "expanded");
				button.text(visibleText);
				button.removeClass(activeClass);
			}
			panel.slideToggle("slow");
			return false;
		});		
	
	// tags 
	
		if($.cookie("tagPanel") == undefined){
			$.cookie("tagPanel", initialState);
			triangle.addClass(closed);
			triangle.removeClass(opened);
			}
			
		if(tagPanelState == "collapsed"){
			tags.hide();
			info.removeClass(tagBump);
			triangle.removeClass(opened);
			triangle.addClass(closed);
			}
		
		if(tagPanelState == "expanded"){
			tags.show();
			info.addClass(tagBump);
			triangle.removeClass(closed);
			triangle.addClass(opened);
			main.addClass(tagBump);
			function reLoadOpenTags(){
		            //$('.lightTable').remove();
					$('.tagTable').detach();
					reloadThemOpenTags();
				}
				
			function reloadThemOpenTags(){	
					//rehideLoader();
					//$('.loader').fadeIn('fast');			
					$('#tagThumbs').load(reLoadTagURL,rehideTagLoader);
				    $('.tagTable').appendTo($('#ajaxTable'));		
				};
				
			function rehideTagLoader(){
					//$('.loader').fadeOut('fast');		
				};
				
			reLoadOpenTags ();
				}
	
		tagButton.click(function(){		
				if($.cookie("tagPanel") == "expanded") {
					$.cookie("tagPanel", "collapsed");			
					triangle.removeClass(opened);
					triangle.addClass(closed);
						$('.tagTable').remove();			
				} else {
					$.cookie("tagPanel", "expanded");				
					triangle.addClass(opened);
					triangle.removeClass(closed);
				}			
					tagButton.toggleClass(activeTags);
					tags.slideToggle("fast");	
					info.toggleClass(tagBump);
					tagThumbs.slideToggle("fast");	
					return false;
				});
	
	// info
	
		if($.cookie("infoPanel") == undefined){
			$.cookie("infoPanel", initialState);
			infoTri.addClass(closed);
			infoTri.removeClass(opened);
		}
		if(infoPanelState == "collapsed"){
			info.hide();
			infoTri.removeClass(opened);
			infoTri.addClass(closed);
		}
		
		if(infoPanelState == "expanded"){
			info.show();
			infoTri.removeClass(closed);
			infoTri.addClass(opened);
		}
	
		infoButton.click(function(){
				if($.cookie("infoPanel") == "expanded") {
					$.cookie("infoPanel", "collapsed");
					infoButton.removeClass(activeTags);
					infoTri.removeClass(opened);
					infoTri.addClass(closed);
				} else {
					$.cookie("infoPanel", "expanded");
					infoButton.addClass(activeTags);
					infoTri.addClass(opened);
					infoTri.removeClass(closed);
				}
					info.slideToggle("fast");
					return false;
			});		
});	
					
	/*	var recPanel = $('ul#recentPosts');
		var tagPanel = $('ul#recentTags');
		var postButton = $('h2.postTrigger');
		var tagButton = $('h2.tagTrigger');
		var initialState = "collapsed";
		var activeClass = "active";
		var visibleText = "HIDE RECENT POSTS";
		var hiddenText = "VIEW RECENT POSTS";
		var visibleTagText = "HIDE TOP TEN TAGS";
		var hiddenTagText = "SHOW TOP TEN TAGS";
	
		if($.cookie("postPanelState") == undefined) {
			$.cookie("postPanelState", initialState);
			}
		var state = $.cookie("postPanelState");
			/* if(state == "collapsed") {
				recPanel.hide('fast'); 
				postButton.text(hiddenText);
				postButton.removeClass(activeClass);
			}
			postButton.click(function(){
				if($.cookie("postPanelState") == "expanded") {
					$.cookie("postPanelState", "collapsed");
					postButton.text(hiddenText);
					postButton.removeClass(activeClass);
				} else {
					$.cookie("postPanelState", "expanded");
					postButton.text(visibleText);
					postButton.addClass(activeClass);
				}
			/*	recPanel.slideToggle("fast");
				return false;
			});
				 */
		/*	var state = $.cookie("tagPanelState");
			if(state == "collapsed") {
				tagPanel.hide('fast');
				tagButton.text(hiddenTagText);
				tagButton.removeClass(activeClass);
			}
			tagButton.click(function(){
				if($.cookie("tagPanelState") == "expanded") {
					$.cookie("tagPanelState", "collapsed");
					tagButton.text(hiddenTagText);
					tagButton.removeClass(activeClass);
				} else {
					$.cookie("tagPanelState", "expanded");
					tagButton.text(visibleTagText);
					tagButton.addClass(activeClass);
				}
				tagPanel.slideToggle("fast");
				return false;
			});
			*/		

	
	
