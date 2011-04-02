<?php
get_header(); ?>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
      <div id="viewer" class="viewer"></div>
<?php endwhile; // end of the loop. ?>

     <script type="text/javascript" src="<?php bloginfo('template_url');?>/scripts/jquery.mousewheel.min.js" ></script>
     <script type="text/javascript" src="<?php bloginfo('template_url');?>/scripts/iViewer.js" ></script>
        <script type="text/javascript">
            var $ = jQuery;
            $(document).ready(function(){
                  $("#viewer").iviewer(
                       {
                       src: "<?php echo catch_that_image() ?>", 
                   
                       zoom: 100,
                       initCallback: function ()
                       {
                           var object = this;
                           $("#in").click(function(){ object.zoom_by(1);}); 
                           $("#out").click(function(){ object.zoom_by(-1);}); 
                           $("#fit").click(function(){ object.fit();}); 
                           //$("#orig").click(function(){  object.set_zoom(100); }); 
                      
						        // console.log(this.img_object.display_width); //works*
									// console.log(object.img_object.display_width); //getting undefined.*

                       },
                  //      onFinishLoad: function()
                  //      {
			//	$("#viewer").data('viewer').setCoords(-500,-500);
                  //        this.setCoords(-0, -500);
                  //      }

//                       onMouseMove: function(object, coords) { },
//                       onStartDrag: function(object, coords) { return false; }, //this image will not be dragged
//                       onDrag: function(object, coords) { }
                  });


            

              
            });
        </script>

<script>
   Galleria.loadTheme('wp-content/themes/theLoupe/scripts/themes/classic/galleria.classic.js');
   jQuery('#gallery-1').galleria({
   debug: true
    });
</script>

</div><!-- #content -->
</div><!-- #container -->
	</div><!-- /lightTable -->
</div><!-- #container -->
</div><!--- /main -->
</div><!-- /wrap -->
<?php get_footer(); ?>
