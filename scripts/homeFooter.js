jQuery(document).ready(function($){
$('#featured').cycle(
{fx: 'fade', speed: 300, timeout: 3000,
allowPagerClickBubble: true, 
pagerEvent: 'mouseover',
pauseOnPagerHover:true,
pagerAnchorBuilder: function(idx,slide){
return '#thumbNav li:eq(' + idx + ') a';
}
});
});