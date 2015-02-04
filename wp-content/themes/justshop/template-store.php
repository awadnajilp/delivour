<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Template Name: Store List
 *
 * This template is a full-width version of the page.php template file. It removes the sidebar area.
 *
 * @package WooFramework
 * @subpackage Template
 */
	get_header();
	global $woo_options;
?>

    <div id="content" class="page col-full">

    	<?php woo_main_before(); ?>



        <?php
        	if ( have_posts() ) { $count = 0;
        		while ( have_posts() ) { the_post(); $count++;
        ?>
               
 						<?php $js_title = ""; $js_title = get_the_title(); if ( !empty( $js_title ) ) { ?>
                		
						<?php } ?>
	                	<?php the_content(); ?>
	               

			<?php
					} // End WHILE Loop
				} else {
			?>
			
            <?php } ?>


		<?php woo_main_after(); ?>

    </div><!-- /#content -->

<?php get_footer(); ?>