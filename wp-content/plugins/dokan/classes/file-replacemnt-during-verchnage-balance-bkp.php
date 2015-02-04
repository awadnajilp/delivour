 /**
     * Displays the store lists
     *
     * @param  array $atts
     * @return string
     */
    function store_listing( $atts ) {
        global $post;

        $attr = shortcode_atts( array(
            'per_page' => 10,
        ), $atts );

        $paged  = max( 1, get_query_var( 'paged' ) );
        $limit  = $attr['per_page'];
        $offset = ( $paged - 1 ) * $limit;

        $sellers = dokan_get_sellers( $limit, $offset );

        ob_start();

        if ( $sellers['users'] ) {
            ?>
            <ul class="dokan-seller-wrap">
                <?php
                foreach ( $sellers['users'] as $seller ) {
                    $store_info = dokan_get_store_info( $seller->ID );
                    $banner_id  = isset( $store_info['banner'] ) ? $store_info['banner'] : 0;
                    $store_name = isset( $store_info['store_name'] ) ? esc_html( $store_info['store_name'] ) : __( 'N/A', 'dokan' );
                    $store_url  = dokan_get_store_url( $seller->ID );
                    ?>

                    <li class="dokan-single-seller">
                        <div class="dokan-store-thumbnail">

                            <a href="<?php echo $store_url; ?>">
                                <?php if ( $banner_id ) {
                                    $banner_url = wp_get_attachment_image_src( $banner_id, 'medium' );
                                    ?>
                                    <img class="dokan-store-img" src="<?php echo esc_url( $banner_url[0] ); ?>" alt="<?php echo esc_attr( $store_name ); ?>">
                                <?php } else { ?>
                                    <img class="dokan-store-img" src="<?php echo dokan_get_no_seller_image(); ?>" alt="<?php _e( 'No Image', 'dokan' ); ?>">
                                <?php } ?>
                            </a>

                            <div class="dokan-store-caption">
                                <h3><a href="<?php echo $store_url; ?>"><?php echo $store_name; ?></a></h3>

                                <address>
                                    <?php if ( isset( $store_info['address'] ) ) {
                                        $address = esc_html( $store_info['address'] );
                                        echo nl2br( $address );
                                    } ?>

                                    <?php if ( isset( $store_info['phone'] ) && !empty( $store_info['phone'] ) ) { ?>
                                        <br>
                                        <abbr title="<?php _e( 'Phone', 'dokan' ); ?>"><?php _e( 'P:', 'dokan' ); ?></abbr> <?php echo esc_html( $store_info['phone'] ); ?>
                                    <?php } ?>

                                </address>

                                <p><a class="dokan-btn dokan-btn-theme" href="<?php echo $store_url; ?>"><?php _e( 'Visit Store', 'dokan' ); ?></a></p>

                            </div> <!-- .caption -->
                        </div> <!-- .thumbnail -->
                    </li> <!-- .single-seller -->
                <?php } ?>

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

        $content = ob_get_clean();

        return apply_filters( 'dokan_seller_listing', $content, $attr );
    }

    function my_orders_page() {
        return dokan_get_template_part( 'my-orders' );
    }

}
