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
global $wpdb;

$store_user = get_userdata( get_query_var( 'author' ) );
$store_info = dokan_get_store_info( $store_user->ID );
$seller_id = $store_user->ID;
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
    
<?php

 $sql = "SELECT t.term_id,t.slug,t.name, tt.parent FROM $wpdb->terms as t
                        LEFT JOIN $wpdb->term_taxonomy as tt on t.term_id = tt.term_id
                        LEFT JOIN $wpdb->term_relationships AS tr on tt.term_taxonomy_id = tr.term_taxonomy_id
                        LEFT JOIN $wpdb->posts AS p on tr.object_id = p.ID
                        WHERE tt.taxonomy = 'product_cat'
                        AND p.post_type = 'product'
                        AND p.post_status = 'publish'
                        AND p.post_author = $seller_id GROUP BY t.term_id";

                $product_categories = $wpdb->get_results( $sql );




 $args = array(
    'number'     => $number,
    'orderby'    => 'title',
    'order'      => 'ASC',
    'hide_empty' => $hide_empty,
    'include'    => $ids
);
//$product_categories = get_terms( 'product_cat', $args );
$count = count($product_categories);
if ( $count > 0 ){
    foreach ( $product_categories as $product_category ) {
        echo '<h4><a href="' . get_term_link( $product_category ) . '">' . $product_category->name . '</a></h4>';
        $args = array(
            'posts_per_page' => -1,
            'tax_query' => array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    // 'terms' => 'white-wines'
                    'terms' => $product_category->slug
                )
            ),
            'post_type' => 'product',
            'orderby' => 'title,'
        );
        $products = new WP_Query( $args );
        echo "<ul>";
        while ( $products->have_posts() ) {
            $products->the_post();
            ?>
               <li <?php post_class( $classes ); ?>>

    <?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
                  <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <?php templatation_product_rating_overview(); ?>

        <?php
            /**
             * woocommerce_after_shop_loop_item_title hook
             *
             * @hooked woocommerce_template_loop_rating - 5
             * @hooked woocommerce_template_loop_price - 10 - @TT - removed, moved to below _item hook instead.
             */
            do_action( 'woocommerce_after_shop_loop_item_title' );
        ?>
            <?php $tt_short_desc = strip_shortcodes( $product->post->post_excerpt ); $tt_short_desc = strip_tags( $tt_short_desc );
            echo '<div class=prod-excerpt style="min-height:20px">'. substr($tt_short_desc, 0, 100); ?>
 
    <!--</a>-->
    <?php do_action( 'woocommerce_after_shop_loop_item' ); //@hooked woocommerce_template_loop_add_to_cart - 10 @hooked woocommerce_template_loop_price - 10 ?> 

                </li>
            <?php
        }
        echo "</ul>";
    }
}?>

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