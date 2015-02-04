<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Page Template
 *
 * This template is the default page template. It is used to display content when someone is viewing a
 * singular view of a page ('page' post_type) unless another page template overrules this one.
 * @link http://codex.wordpress.org/Pages
 *
 * @package WooFramework
 * @subpackage Template
 */
get_header();

global $woo_options;

$store_user = get_userdata( get_query_var( 'author' ) );
$store_info = dokan_get_store_info( $store_user->ID );

$scheme = is_ssl() ? 'https' : 'http';

wp_enqueue_script( 'google-maps', $scheme . '://maps.google.com/maps/api/js?sensor=true' );
?>
       
    <div id="content" class="page col-full">
    
    	<?php woo_main_before(); ?>
    	
		<section id="main" class="col-left"> 			

        <div id="primary" class="content-area dokan-single-store">
    <div id="content" class="site-content store-page-wrap woocommerce" role="main">

        <?php dokan_get_template_part( 'store-header' ); ?>

        <?php do_action( 'dokan_store_profile_frame_after', $store_user, $store_info ); ?>

        <?php if ( have_posts() ) { ?>

            <div class="seller-items">
    

                <?php woocommerce_product_loop_start(); ?>

                    <?php while ( have_posts() ) : the_post(); ?>

                        <?php wc_get_template_part( 'content', 'product' ); ?>

                    <?php endwhile; // end of the loop. ?>

                <?php woocommerce_product_loop_end(); ?>

            </div>

            <?php dokan_content_nav( 'nav-below' ); ?>

        <?php } else { ?>

            <p class="dokan-info"><?php _e( 'No products were found of this seller!', 'dokan' ); ?></p>

        <?php } ?>
    </div>

    </div><!-- #content .site-content -->
        
		</section><!-- /#main -->

        <?php woo_main_after(); ?>

        <?php  //get_sidebar('store'); ?>

    </div><!-- /#content -->
		
<?php get_footer(); ?>