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
          <?php   if( !timeIsBetween($store_info['rest_opening_time'],$store_info['rest_closing_time']) ): ?> 
        <div class="wpb_alert wpb_content_element wpb_alert-error">
            <div class="messagebox_text"><p><strong>Restaurant currently closed!</strong> You can still make Pre - Order.Your order will be processed immedietly once restaurant is opened. Opening time :<strong><?php echo $store_info['rest_closing_time']; ?></strong> </p>
        </div>
        </div> 
        <?php endif;?>
            <?php woo_main_before(); ?>
            
            <section id="main" class="col-left">            

            <div id="primary" class="content-area dokan-single-store">
        <div  class="site-content store-page-wrap woocommerce" role="main">
      
            <?php dokan_get_template_part( 'store-header' ); ?>

            <?php do_action( 'dokan_store_profile_frame_after', $store_user, $store_info ); ?>

            <?php if ( have_posts() ) { ?>

                <div class="seller-items">
    <?php
    $product_categories = awdProductCategories($seller_id); 
    echo '<div id="m-product-cat-container">';
    echo '<select id="m-product-cat" class="select2" style="margin-top:60px;padding:0px">';
    foreach ($product_categories as $key => $value) {
            echo '<option value="'.$value->term_id.'">'.$value->name."</option>";
    }
    echo '<select></div>';
     /*$product_categories = get_transient( 'dokan-store-category-'.$seller_id );

                if ( $product_categories === false ) {
                    
                    
                    //set_transient( 'dokan-store-category-'.$seller_id , $product_categories );
                }

    
    //$product_categories = get_terms( 'product_cat', $args );*/
    $args = array(
        'number'     => $number,
        'orderby'    => 'title',
        'order'      => 'ASC',
        'hide_empty' => $hide_empty,
        'include'    => $ids
    );
    //Changing product categories by parent
    $count = count($product_categories);
    $getTerms = $product_categories;
    $terms = array();              
    foreach($getTerms as $key => $term){
      $terms[$term->parent][$term->term_id] = $term;
    } 


    awdRestauratMenu($terms,0,0,$seller_id); ?>


                </div>

                <?php //dokan_content_nav( 'nav-below' ); ?>

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