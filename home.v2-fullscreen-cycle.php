<?php
get_header(); ?>



<script type="text/javascript">
jQuery(document).ready(function($){
$('#feat').cycle({fx: 'scrollLeft', delay: -2000, timeout: 6000});
$('#feat img').click(function(){
	document.location.href=$(this).attr('rel');
}).css('cursor','pointer');
});
</script>

<?php get_footer(); ?>
