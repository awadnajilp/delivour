<?php session_start(); if ( ! defined( 'ABSPATH' ) ) exit;
global $wp_session;


/**
 * Template Name: Restaurants
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
        
		<section id="main" class="fullwidth">

        <?php

        $city = isset($_POST['city']) ? $_POST['city']:'';
        $area = isset($_POST['customer_area']) ? $_POST['customer_area']:'';
        $_SESSION["city"] = $city;
        $_SESSION["area"] = $area;
        
        	if ( have_posts() ) { $count = 0;
        		while ( have_posts() ) { the_post(); $count++;
        ?>
                <article <?php post_class(); ?>>

                    <section class="entry">
 						<?php $js_title = ""; $js_title = get_the_title(); if ( !empty( $js_title ) ) { ?>
                		<header>
							<h1><?php the_title(); ?></h1>
                		</header>
						<?php } ?>
	                	
                        <?php 
                    
$attr = shortcode_atts( array(
            'per_page' => 10,
        ), $atts );

        $paged  = max( 1, get_query_var( 'paged' ) );
        $limit  = $attr['per_page'];
        $offset = ( $paged - 1 ) * $limit;

        $sellers = dokan_get_sellers( $limit, $offset );



        if ( $sellers['users'] ) {
            ?>
            <ul class="products">
                <?php
                foreach ($sellers['users'] as $seller) {
                    $store_info = dokan_get_store_info( $seller->ID );
                    $banner_id  = isset( $store_info['banner'] ) ? $store_info['banner'] : 0;
                    $store_name = isset( $store_info['store_name'] ) ? esc_html( $store_info['store_name'] ) : __( 'N/A', 'dokan' );
                    $store_url  = dokan_get_store_url( $seller->ID );
                    $delivery_area_array = array_values(explode(',', $store_info['delivery_area']));
                    if( $city == $store_info['restaurant_city'] ){ if(in_array($area,$delivery_area_array,true) ) {  ?>

                    <li class=" product-category product">
                     <h3><?php echo $store_name;  ?></h3>
                        <div class=" img-wrap">

                         <?php if ( $banner_id ) {
                                    $banner_url = wp_get_attachment_image_src( $banner_id, 'medium' );
                                    ?>
                                    <img src="<?php echo esc_url( $banner_url[0] ); ?>" alt="<?php echo esc_attr( $store_name ); ?>" height="180" width="280">
                                <?php } else { ?>
                                    <img  src="<?php echo dokan_get_no_seller_image(); ?>" alt="<?php _e( 'No Image', 'dokan' ); ?>" height="180" width="280">
                                <?php } ?>



                            <div class="shade-a"></div>
                            <div class="shade-b"></div>


                            
                        </div> <!-- .thumbnail -->
                        <div class="description">
                             <address>
                                    <?php if ( isset( $store_info['address'] )  ) {
                                        $address = esc_html( $store_info['address'] );
                                        echo nl2br( $address );
                                    } ?>

                                    <?php if ( isset( $store_info['phone'] ) && !empty( $store_info['phone'] ) ) { ?>
                                        <br>
                                        <abbr title="<?php _e( 'Phone', 'dokan' ); ?>"><?php _e( 'P:', 'dokan' ); ?></abbr> <?php echo esc_html( $store_info['phone'] ); ?>
                                    <?php } ?>

                                </address>
                        </div>
                        <a class=" readmore" href="<?php echo $store_url; ?>"><span class="view-more"> <span class="view-more"><?php   if( timeIsBetween($store_info['rest_opening_time'],$store_info['rest_closing_time']) ): echo 'View Menu'; else: echo 'Closed! Pre Order'; endif;?></span></a>
                    </li> <!-- .single-seller -->
                <?php } } } ?>

            </ul> <!-- .dokan-seller-wrap -->

                <?php
                $user_count = $sellers['count'];
                $num_of_pages = ceil( $user_count / $limit );

                if ( $num_of_pages > 1 ) {
                    echo '<div class="pagination-container clearfix">';
                    $page_links = paginate_links( array(
                        'current'   => $paged,
                        'total'     => $num_of_pages,
                        'base'      => str_replace( $post->ID, '%#%', esc_url( get_pagenum_link( $post->ID ) ) ),
                        'type'      => 'array',
                        'prev_text' => __( '&larr; Previous', 'dokan' ),
                        'next_text' => __( 'Next &rarr;', 'dokan' ),
                    ) );

                    if ( $page_links ) {
                        $pagination_links  = '<div class="pagination-wrap">';
                        $pagination_links .= '<ul class="pagination"><li>';
                        $pagination_links .= join( "</li>\n\t<li>", $page_links );
                        $pagination_links .= "</li>\n</ul>\n";
                        $pagination_links .= '</div>';

                        echo $pagination_links;
                    }

                    echo '</div>';
                }
                ?>

            <?php
        } else {
            ?>

            <p class="dokan-error"><?php _e( 'No seller found!', 'dokan' ); ?></p>

            <?php
        }
?>
	               	</section><!-- /.entry -->

                </article><!-- /.post -->

			<?php
					} // End WHILE Loop
				} else {
			?>
				<article <?php post_class(); ?>>
                	<p><?php _e( 'Sorry, no posts matched your criteria.', 'templatation' ); ?></p>
                </article><!-- /.post -->
            <?php } ?>

		</section><!-- /#main -->

		<?php woo_main_after(); ?>

    </div><!-- /#content -->

<?php get_footer(); ?>