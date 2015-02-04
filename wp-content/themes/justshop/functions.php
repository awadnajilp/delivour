<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/*-----------------------------------------------------------------------------------*/
/* Start templatation Functions - Please refrain from editing this section */
/*-----------------------------------------------------------------------------------*/

// WooFramework init
require_once ( get_template_directory() . '/functions/admin-init.php' );

/*-----------------------------------------------------------------------------------*/
/* Load the theme-specific files, with support for overriding via a child theme.
/*-----------------------------------------------------------------------------------*/

$includes = array(
				'includes/theme-options.php', 			// Options panel settings and custom settings
				'includes/theme-functions.php', 		// Custom theme functions
				'includes/theme-actions.php', 			// Theme actions & user defined hooks
				'includes/theme-comments.php', 			// Custom comments/pingback loop
				'includes/theme-js.php', 				// Load JavaScript via wp_enqueue_script
				'includes/sidebar-init.php', 			// Initialize widgetized areas
				'includes/theme-widgets.php'			// Theme widgets
				);

// Allow child themes/plugins to add widgets to be loaded.
$includes = apply_filters( 'woo_includes', $includes );

foreach ( $includes as $i ) {
	locate_template( $i, true );
}

require_once( 'includes/testimonials/templatation-testimonials.php' );
require_once( 'includes/retail-menu-cards/retail-menu-cards.php' );
require_once( 'includes/tt-plugins/tt-plugins.php' );

if ( is_woocommerce_activated() ) {
	if ( !defined('YITH_WCMG') ) { require_once( 'includes/wc-zm/init.php' ); }
	if ( !defined('YITH_WCAN') ) { require_once( 'includes/wc-ajax-nav/init.php' ); }
	locate_template( 'includes/theme-woocommerce.php', true );
}

/*-----------------------------------------------------------------------------------*/
/* Visual Composer Stuff */
/*-----------------------------------------------------------------------------------*/
define('ULTIMATE_USE_BUILTIN', 'true');
add_action( 'init', 'tt_vcSetAsTheme' );
function tt_vcSetAsTheme() {
	if (function_exists('vc_set_as_theme')) vc_set_as_theme(true);
}
function templatation_vc_row_and_vc_column($class_string, $tag) { return $class_string; }

// Filter to Replace default css class for vc_row shortcode and vc_column
add_filter('vc_shortcodes_css_class', 'templatation_vc_row_and_vc_column', 10, 2);

// Ext VC
if (class_exists('WPBakeryVisualComposerAbstract')) {
	require_once locate_template('/includes/tt-vc-extend/tt-vc-extend.php');
}


/*-----------------------------------------------------------------------------------*/
/* You can add custom functions below. */
/*-----------------------------------------------------------------------------------*/
// Restaurant Cuisine Field in Restaurant Settings page

function my_script_enqueuer() {
	wp_register_script( "get_city_area_script", get_template_directory_uri().'/includes/js/get-city-area.js', array('jquery') );
	wp_localize_script( 'get_city_area_script', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));  
	wp_register_style('chosen_style',get_template_directory_uri().'/awad/chosen.min.css');
	wp_register_script("chosen_script",get_template_directory_uri().'/awad/chosen.jquery.min.js',array('jquery'));
	wp_register_script("awd_script",get_template_directory_uri().'/awad/custom.awd.js',array('jquery'));
	wp_register_style("select2_style",'//cdn.jsdelivr.net/select2/3.5.2/select2.css');
	wp_register_style("select2_flatstyle",get_template_directory_uri().'/awad/select2.flat.css');
	wp_register_script("select2_script",'http://cdn.jsdelivr.net/select2/3.5.2/select2.js',array('jquery'));
	wp_register_script("timepicker_script",get_template_directory_uri().'/awad/jquery.ui.timepicker.js',array('jquery'));




	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'get_city_area_script' );
	wp_enqueue_style('chosen_style');
	wp_enqueue_script('chosen_script');
	wp_enqueue_style('select2_style');
	wp_enqueue_style('select2_flatstyle');
	wp_enqueue_script('select2_script');
	wp_enqueue_script('timepicker_script');
	wp_enqueue_script('awd_script');
}

function dateIsBetween($from, $to, $date = 'now') {
    $date = is_int($date) ? $date : strtotime($date); // convert non timestamps
    $from = is_int($from) ? $from : strtotime($from); // ..
    $to = is_int($to) ? $to : strtotime($to);         // ..
    return ($date > $from) && ($date < $to); // extra parens for clarity
}

function restaurant_cuisin_type_field($current_user,$profile_info){
	global $wpdb;
	$rest_cuisines_selected = isset($profile_info['rest_cuisines']) ? $profile_info['rest_cuisines'] : '';?>
	<h3>Restaurant Info</h3>
	<div class="gregcustom dokan-form-group">
	<label class="dokan-w3 dokan-control-label " for="delivery_area"><?php _e( 'Restaurant Cuisines ', 'dokan' ); ?></label>
	<div class="dokan-w5">
		<select class="awd-chosen-select extra-field"  name="rest_cuisines[]" id="rest_cuisines"  style="width:300px"  multiple="multiple">
			<?php 	
  			#fethcing city areas from table based on city
			$rest_cuisines_array = array_values(explode(',', $rest_cuisines_selected));
			$query_cuisines = "SELECT cuisine FROM wp_restaurant_cuisines ORDER BY id ASC  ";
			$rest_cuisines = $wpdb->get_results($query_cuisines);
			foreach ($rest_cuisines as $cuisine) {
				if(in_array($cuisine->cuisine,$rest_cuisines_array,true) ) {
					echo '<option value="'.$cuisine->cuisine.'" selected="selected">'.$cuisine->cuisine.'</option>tre';
				}else{
					echo '<option value="'.$cuisine->cuisine.'">'.$cuisine->cuisine.'</option>';
				}

			}?>
		</select>
		
	</div>
	</div><?php
	$rest_min_order = isset($profile_info['rest_min_order']) ? $profile_info['rest_min_order'] : '';?>
	<div class="gregcustom dokan-form-group">
	<label class="dokan-w3 dokan-control-label " for="delivery_area"><?php _e( 'Minimum Order Amount ', 'dokan' ); ?></label>
	<div class="dokan-w5">
		<input type="text" name="rest_min_order" class="dokan-form-control valid" placeholder="min order amount" value="<?php echo $rest_min_order;?>"></input>
	</div>
	</div><?php
	$rest_opening_time = isset($profile_info['rest_opening_time']) ? $profile_info['rest_opening_time'] : '';?>
	<div class="gregcustom dokan-form-group">
	<label class="dokan-w3 dokan-control-label " for="delivery_area"><?php _e( 'Delivery opening time ', 'dokan' ); ?></label>
	<div class="dokan-w5">
		<input type="text" name="rest_opening_time" class="dokan-form-control valid awd-time" placeholder="min order amount" value="<?php echo $rest_opening_time;?>"></input>
	</div>
	</div><?php
	$rest_closing_time = isset($profile_info['rest_closing_time']) ? $profile_info['rest_closing_time'] : '';?>
	<div class="gregcustom dokan-form-group">
	<label class="dokan-w3 dokan-control-label " for="delivery_area"><?php _e( 'Delivery closing time', 'dokan' ); ?></label>
	<div class="dokan-w5">
		<input type="text" name="rest_closing_time" class="dokan-form-control valid awd-time" placeholder="min order amount" value="<?php echo $rest_closing_time;?>"></input>
	</div>
	</div><?php
	
}


 add_filter( 'dokan_settings_after_banner', 'restaurant_cuisin_type_field', 10, 2);


// City & Area Cutsom fields in Restaurant Setting page
function city_area_fields( $current_user, $profile_info ) {
	global $wpdb;
	#Fetching all cities from custom table
	$restaurant_city = isset( $profile_info['restaurant_city'] ) ? $profile_info['restaurant_city'] : ''; // if city is choosed previuosly set it or set null
	$delivery_area = isset( $profile_info['delivery_area'] ) ? $profile_info['delivery_area'] : '';	
	$sql1 = "SELECT DISTINCT(city) FROM wp_restaurant_locations ORDER BY id ASC  ";
	$cities = $wpdb->get_results($sql1);
	if($cities):  $nonce = wp_create_nonce("get_city_area");?>
	<div class="gregcustom dokan-form-group">
		<label class="dokan-w3 dokan-control-label" for="setting_address"><?php _e( 'City', 'dokan' ); ?></label>
		<div class="dokan-w5">
			<select class="dokan-form-control input-md valid delivery_area" data-nonce="<?php echo $nonce ?>" name="restaurant_city" id="restaurant_city" >
				<?php foreach ($cities as $city) {
					if($city->city == $restaurant_city){ ?>
					<option value="<?php echo $city->city;?>" selected="selected"><?php echo $city->city;?></option>
					<?php }else{ ?>
					<option value="<?php echo $city->city;?>"><?php echo $city->city;?></option>
					<?php	  }
				}?>
			</select>
		</div>
	</div>   
<?php endif;?>

<div class="gregcustom dokan-form-group">
	<label class="dokan-w3 dokan-control-label " for="delivery_area"><?php _e( 'Delivery Area\'s<br>(<small>To select multiple locations,press & hold CTRL and select</small>)', 'dokan' ); ?></label>
	<div class="dokan-w5">
		<select class="chosen-select"  name="delivery_area[]" id="delivery_area"  style="width:300px" value="<?php echo $delivery_area; ?>" multiple="multiple" onchange="get_city_area();">
			<?php 	
  			#fethcing city areas from table based on city
			$delivery_area_array = array_values(explode(',', $delivery_area));
			$query = "SELECT area FROM wp_restaurant_locations WHERE city='$restaurant_city' ORDER BY id ASC  ";
			$areas = $wpdb->get_results($query);
			foreach ($areas as $area) {
				if(in_array($area->area,$delivery_area_array,true) ) {
					echo '<option value="'.$area->area.'" selected="selected">'.$area->area.'</option>tre';
				}else{
					echo '<option value="'.$area->area.'">'.$area->area.'</option>';
				}

			}?>
		</select><br>
		<input type="checkbox" id="select-all-area"> Select All
	</div>
</div>  
<?php } ?>
<?php add_filter( 'dokan_settings_after_banner', 'city_area_fields', 10, 2);





add_action( 'init', 'my_script_enqueuer' );

// requests using default  wp_ajax

add_action('wp_ajax_set_session_location', 'set_session_location_ajx_handler' );
add_action('wp_ajax_nopriv_set_session_location', 'set_session_location_ajx_handler' );

function set_session_location_ajx_handler(){
	//global $wp_session;
	/*if ( !wp_verify_nonce( $_REQUEST['nonce'], "get_city_area_front")) {
		exit("No naughty business please");
	}*/
	$_SESSION['city'] = $_REQUEST['city'];
	$_SESSION['area'] = $_REQUEST['area'];
	die();
}

//request using custom ajax handler
//For logged in users
add_action('MY_AJAX_HANDLER_set_session_location','set_session_location_ajx_handler');
//For logged out users
add_action('MY_AJAX_HANDLER_nopriv_set_session_location','set_session_location_ajx_handler');



add_action( 'wp_ajax_get_city_area', 'get_city_area' ); // WP Ajax Hooks to load areas based on choosed city
add_action( 'wp_ajax_nopriv_get_city_area', 'get_city_area' ); // WP ajax for non logged in users

function get_city_area() {  // Ajax handler Function for areas loading 
	if ( !wp_verify_nonce( $_REQUEST['nonce'], "get_city_area")) {
		exit("No naughty business please");
	} 
	global $wpdb;
	
	$city = $_REQUEST['city'];
	$user_id = get_current_user_id();
	$profile_info =  dokan_get_store_info( $user_id );
	$delivery_area = $profile_info['delivery_area'];
	$delivery_area_array = array();
	$areas =array();
	$delivery_area_array = array_values(explode(',', $delivery_area));


	$query = "SELECT area FROM wp_restaurant_locations WHERE city='$city' ORDER BY id ASC  ";
	$areas = $wpdb->get_results($query);
	foreach ($areas as $area) {
		if(in_array($area->area,$delivery_area_array,true) ) {
			echo '<option value="'.$area->area.'" selected="selected">'.$area->area.'</option>tre';
		}
		else{
			echo '<option value="'.$area->area.'">'.$area->area.'</option>';
		} 



	}

	die();
}


/**
 * Save the extra fields.
 *
 * @param  int  $customer_id Current customer ID.
 *
 * @return void
 */
function save_extra_city_area_fields( $store_id, $dokan_settings ) {

	if (isset($_POST['restaurant_city'])) {
		$dokan_settings['restaurant_city'] = $_POST['restaurant_city'];
	}

	if (isset($_POST['delivery_area'])) {
		
        $dokan_settings['delivery_area'] =  implode(',', $_POST['delivery_area']); //'mavoor,areacode road,nadakkav';//serialize($_POST['delivery_area']);
    }
    // Restaurant Cuisines save 
    if (isset($_POST['rest_cuisines'])) {
		
		$dokan_settings['rest_cuisines'] = implode(',', $_POST['rest_cuisines']);  
		
	}
	if (isset($_POST['rest_min_order'])) {
		$dokan_settings['rest_min_order'] = $_POST['rest_min_order'];
	}
	if (isset($_POST['rest_opening_time'])) {
		$dokan_settings['rest_opening_time'] = $_POST['rest_opening_time'];
	}
	if (isset($_POST['rest_closing_time'])) {
		$dokan_settings['rest_closing_time'] = $_POST['rest_closing_time'];
	}

    update_user_meta( $store_id, 'dokan_profile_settings', $dokan_settings );
}

add_action( 'dokan_store_profile_saved', 'save_extra_city_area_fields', 10, 2 );

function save_rest_cuisine_field($store_id,$dokan_settings){
	if (isset($_POST['rest_cuisines'])) {
		$rest_cuisines = '';
		foreach ($_POST['rest_cuisines'] as $key => $value) {
			$rest_cuisines = $rest_cuisines.','.$value;
		}
		$doken_settings['rest_cuisines'] = implode(',', $_POST['rest_cuisines']);  
		update_user_meta($store_id,'dokan_profile_settings',$dokan_settings);
	}
}

//add_action('dokan_store_profile_saved','save_rest_cuisine_field',10,2);


add_action('save_post', 'assign_parent_terms'); // Hook to assign parent categories when a child category selected for a product

function assign_parent_terms($post_id){
	global $post;

	if(isset($post) && $post->post_type != 'product')
		return $post_id;

// get all assigned terms   
	$terms = wp_get_post_terms($post_id, 'product_cat' );
	foreach($terms as $term){
		while($term->parent != 0 && !has_term( $term->parent, 'product_cat', $post )){
    // move upward until we get to 0 level terms
			wp_set_object_terms($post_id, array($term->parent), 'product_cat', true);
			$term = get_term($term->parent, 'product_cat');
		}
	}
}

// City and Location chooser Form - Function only
function city_choose_form($atts){
	
	global $wpdb,$wp_session;
	#Fetching all cities from custom table
	if (!isset($_SESSION["city"]) || empty($_SESSION["city"]) ) {
		$_SESSION["city"] = 'Kozhikode';
	}

	if (!isset($_SESSION["area"])  || empty($_SESSION["area"])) {
		$_SESSION["area"] = 'Mavoor road';
	}

	$sql1 = "SELECT DISTINCT(city) FROM wp_restaurant_locations ORDER BY id ASC ";
	$cities = $wpdb->get_results($sql1);
	
	if($cities):  $nonce = wp_create_nonce("get_city_area_front");
	$form = '<div class="city_choose_form_container">
	<form class="city_choose_form" id="city_choose_form_home" action="'.get_permalink( 2846 ).'" method="post">
		<div class="city_choose_input">	    			    		
			<select class="select2 customer_city_home" data-nonce="'.$nonce.'" name="city" id="customer_city_home" >';
				foreach ($cities as $city) {
					if($city->city == $_SESSION["city"]){ 
						$form = $form.'<option value="'.$city->city.'" selected="selected">'.$city->city.'</option>';
					}else{ 
						$form = $form.'<option value="'.$city->city.'">'.$city->city.'</option>';
					}
				}
				$form = $form.'</select></div>		
				<div class="city_choose_input">
					<select class="select2 customer_area_home" name="customer_area" id="customer_area_home" onchange="set_session_location_home(this.value);" >';

  				#fethcing city areas from table based on city
						$query = "SELECT area FROM wp_restaurant_locations WHERE city='".$_SESSION["city"]."' ORDER BY id ASC  ";
						$areas = $wpdb->get_results($query);
						foreach ($areas as $area) {
							if($area->area == $_SESSION["area"]){ 
								$form = $form.'<option value="'.$area->area.'" selected="selected">'.$area->area.'</option>';
							}else{ 
								$form = $form.'<option value="'.$area->area.'">'.$area->area.'</option>';
							}
						}
						$form = $form.'</select>
					</div>	 		  
					<input type="hidden" name="action" value="find_restaurants">
					<input type="submit" class="find_restaurants_btn" value="Find Restaurants">
				</form>
			</div>';
			endif;

return $form;//ob_get_contents();
}

add_action('init', 'myStartSession', 1);
function myStartSession() {
    if(!session_id()) {
        session_start();
    }
}
function city_choose_form_headline($area){
	
	global $wpdb,$wp_session;
	#Fetching all cities from custom table
	if (!isset($_SESSION["city"])  || empty($_SESSION["city"]) ) {
		$_SESSION["city"] = 'Kozhikode';
		
	}

	if (!isset($_SESSION["area"])  || empty($_SESSION["area"]) ) {
		$_SESSION["area"] = 'Mavoor road';
		
	}
	

	$sql1 = "SELECT DISTINCT(city) FROM wp_restaurant_locations ORDER BY id ASC ";
	$cities = $wpdb->get_results($sql1);
	
	if($cities):  $nonce = wp_create_nonce("get_city_area_front");
	$form = '<div class="city_choose_form_container_hl">
	<form class="city_choose_form" id="city_choose_form_hl" action="'.get_permalink( 2846 ).'" method="post">
		<div class="city_choose_input">	    			    		
			<select class="select2" data-nonce="'.$nonce.'" name="city" id="customer_city" style="width:250px">';
				foreach ($cities as $city) {
					if($city->city == $_SESSION["city"]){ 
						$form = $form.'<option value="'.$city->city.'" selected="selected">'.$city->city.'</option>';
					}else{ 
						$form = $form.'<option value="'.$city->city.'">'.$city->city.'</option>';
					}
				}
				$form = $form.'</select></div>		
				<div class="city_choose_input">
					<select class="select2" name="customer_area" id="customer_area" onchange="set_session_location(this.value);" style="width:250px">';

  				#fethcing city areas from table based on city
						$query = "SELECT area FROM wp_restaurant_locations WHERE city='".$_SESSION["city"]."' ORDER BY id ASC  ";
						$areas = $wpdb->get_results($query);
						foreach ($areas as $area) {
							if($area->area == $_SESSION["area"]){ 
								$form = $form.'<option value="'.$area->area.'" selected="selected">'.$area->area.'</option>';
							}else{ 
								$form = $form.'<option value="'.$area->area.'">'.$area->area.'</option>';
							}
						}
						$form = $form.'</select>
					</div>	 		  
					<input type="hidden" name="action" value="find_restaurants">
					<input type="submit" class="find_restaurants_hl" value="Find Restaurants">
				</form>
			</div>';
			endif;

return $form;//ob_get_contents();
}

add_shortcode( 'location_choose', 'city_choose_form' );

add_action('admin_post_find_restaurants','handler_find_restaurants');
add_action('admin_post_nopriv_find_restaurants','handler_find_restaurants');

function handler_find_restaurants(){
	 //Redirect to a page template or file with POST data  using wp_redirect()?

	die();
}

// Ajax Hook and Handler for Front end City and location choosing
add_action( 'wp_ajax_get_city_area_front', 'get_city_area_front' ); // WP Ajax Hooks to load areas based on choosed city
add_action( 'wp_ajax_nopriv_get_city_area_front', 'get_city_area_front' ); // WP ajax for non logged in users

function get_city_area_front() {  // Ajax handler Function for areas loading 
	if ( !wp_verify_nonce( $_REQUEST['nonce'], "get_city_area_front")) {
		exit("No naughty business please");
	} 
	global $wpdb;
	//$restaurant_city = isset( $profile_info['restaurant_city'] ) ? $profile_info['restaurant_city'] : '';
	//$delivery_area = isset( $profile_info['delivery_area'] ) ? $profile_info['delivery_area'] : '';
	
	$city = $_REQUEST['city'];

	$query = "SELECT area FROM wp_restaurant_locations WHERE city='$city' ORDER BY id ASC  ";
	$areas = $wpdb->get_results($query);
	foreach ($areas as $area) {
		echo '<option value="'.$area->area.'">'.$area->area.'</option>';
	}

	die();
}


function awdProductCategories($seller_id){
	global $wpdb;
	$sql = "SELECT t.term_id,t.slug,t.name, tt.parent FROM $wpdb->terms as t
                            LEFT JOIN $wpdb->term_taxonomy as tt on t.term_id = tt.term_id
                            LEFT JOIN $wpdb->term_relationships AS tr on tt.term_taxonomy_id = tr.term_taxonomy_id
                            LEFT JOIN $wpdb->posts AS p on tr.object_id = p.ID
                            WHERE tt.taxonomy = 'product_cat'
                            AND p.post_type = 'product'
                            AND p.post_status = 'publish'
                            AND p.post_author = $seller_id GROUP BY t.term_id";

                    return $product_categories = $wpdb->get_results( $sql );
}



function awdRestauratMenu($terms, $parent = 0, $deep = 0,$seller_id){
	if(count($terms[$parent]) > 0){

		$indent = "";
		for($i = 0; $i < $deep; $i++){
			$indent .= "&nbsp;&nbsp;&nbsp;";
		}

		foreach($terms[$parent] as $key => $term){
			//$products = get_transient('dokan_store_categorized_product_'.$seller_id);
			
				$args = array(
					'posts_per_page' => -1,
					'tax_query' => array(
						'relation' => 'AND',
						array(
							'taxonomy' => 'product_cat',
							'field' => 'slug',
                    // 'terms' => 'white-wines'
							'terms' => $term->slug
							)
						),
					'post_type' => 'product',
					'orderby' => 'title,'
					);
				$products = new WP_Query( $args );
			
			if(count($terms[$term->term_id]) > 0){
				if($deep == 0){
					echo "<div class='awd-single-product' id='div-".$term->term_id."' >".'<h4 class="rest-menu-category"><span id="'.$term->term_id.'">&nbsp;</span><a href="#' . $term->term_id. '">' . $term->name . '</a></h4>';
					echo "<ul class='products' >";
					while ( $products->have_posts() ) {
						$products->the_post();
						?>
						<li <?php post_class( $classes ); ?>>

							<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
							<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<?php templatation_product_rating_overview(); 
            /**
             * woocommerce_after_shop_loop_item_title hook
             *
             * @hooked woocommerce_template_loop_rating - 5
             * @hooked woocommerce_template_loop_price - 10 - @TT - removed, moved to below _item hook instead.
             */
            do_action( 'woocommerce_after_shop_loop_item_title' );
            $tt_short_desc = strip_shortcodes( $product->post->post_excerpt ); $tt_short_desc = strip_tags( $tt_short_desc );
            echo '<div class=prod-excerpt >'. substr($tt_short_desc, 0, 100).'</div>';  ?>

            <!--</a>-->
            <?php do_action( 'woocommerce_after_shop_loop_item' ); //@hooked woocommerce_template_loop_add_to_cart - 10 @hooked woocommerce_template_loop_price - 10 ?> 

        </li>
        <?php
    }
    echo "</ul></div>";
} else {
	echo "<div class='awd-single-product' id='div-".$term->term_id."' >".'<h4 class="rest-menu-category"><span id="'.$term->term_id.'">&nbsp;</span><a href="#' . $term->term_id. '">'.$term->name . 'ss</a></h4>';
        //echo "<option value='".$term->name."'>".$indent.$term->name."</option>";

	echo "<ul class='products' >";
	while ( $products->have_posts() ) {
		$products->the_post();
		?>
		<li <?php post_class( $classes ); ?>>

			<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
			<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
			<?php templatation_product_rating_overview(); 
            /**
             * woocommerce_after_shop_loop_item_title hook
             *
             * @hooked woocommerce_template_loop_rating - 5
             * @hooked woocommerce_template_loop_price - 10 - @TT - removed, moved to below _item hook instead.
             */
            do_action( 'woocommerce_after_shop_loop_item_title' );
            $tt_short_desc = strip_shortcodes( $product->post->post_excerpt ); $tt_short_desc = strip_tags( $tt_short_desc );
            echo '<div class=prod-excerpt >'. substr($tt_short_desc, 0, 100).'</div>'; ?>

            <!--</a>-->
            <?php do_action( 'woocommerce_after_shop_loop_item' ); //@hooked woocommerce_template_loop_add_to_cart - 10 @hooked woocommerce_template_loop_price - 10 ?> 

        </li>
        <?php
    }
    echo "</ul></div>";
}
for ($i=0; $i <= $deep; $i++) { 
	echo " -";
}

awdRestauratMenu($terms, $term->term_id, ($deep+1));

} else {
	echo "<div class='awd-single-product' id='div-".$term->term_id."' >".'<h4 class="rest-menu-category"><span id='.$term->term_id.' >&nbsp;</span><a href="#' . $term->term_id. '">' . $term->name . '</a></h4>';
        //echo "<option value='".$term->name."'>".$indent.$term->name."</option>";

	echo "<ul class='products' >";
	while ( $products->have_posts() ) {
		$products->the_post();
		?>
		<li <?php post_class( $classes ); ?>>

			<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
			<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
			<?php templatation_product_rating_overview(); 
            /**
             * woocommerce_after_shop_loop_item_title hook
             *
             * @hooked woocommerce_template_loop_rating - 5
             * @hooked woocommerce_template_loop_price - 10 - @TT - removed, moved to below _item hook instead.
             */
            do_action( 'woocommerce_after_shop_loop_item_title' );
            $tt_short_desc = strip_shortcodes( $product->post->post_excerpt ); $tt_short_desc = strip_tags( $tt_short_desc );
            echo '<div class=prod-excerpt >Silver beet shallot wakame tomatillo salsify mung bean beetroot'. substr($tt_short_desc, 0, 100).'</div>'; ?>

            <!--</a>-->
            <?php do_action( 'woocommerce_after_shop_loop_item' ); //@hooked woocommerce_template_loop_add_to_cart - 10 @hooked woocommerce_template_loop_price - 10 ?> 

        </li>
        <?php
    }
    echo "</ul></div>";



}

}
}
}



add_filter('woocommerce_checkout_fields','custom_overide_checkout_fields');

function custom_overide_checkout_fields($fields){
	global $wp_session;
		unset($fields['billing']['billing_company']);
		unset($fields['shipping']['shipping_company']);
		unset($fields['billing']['billing_last_name']);
		unset($fields['shipping']['shipping_last_name']);
		unset($fields['billing']['billing_postcode']);	
		unset($fields['shipping']['shipping_postcode']);
		unset($fields['billing']['billing_country']);
		unset($fields['shipping']['shipping_country']);
		unset($fields['billing']['billing_state']);
		unset($fields['shipping']['shipping_state']);
	


		// Billing
		$fields['billing']['billing_first_name']['label'] = 'Full Name';
		$fields['billing']['billing_city']['default'] = $_SESSION['city'];

		$fields2['billing']['billing_first_name'] = $fields['billing']['billing_first_name'];
        $fields2['billing']['billing_phone'] = $fields['billing']['billing_phone'];
        $fields2['billing']['billing_address_1'] = $fields['billing']['billing_address_1'];
        $fields2['billing']['billing_address_2'] = $fields['billing']['billing_address_2'];
        $fields2['billing']['billing_city'] = $fields['billing']['billing_city'];
       

         // Shipping

		$fields['shipping']['shipping_first_name']['label'] = 'Full Name';
		$fields['shipping']['shipping_city']['default'] = $_SESSION['city'];

		$fields2['shipping']['shipping_first_name'] = $fields['shipping']['shipping_first_name'];
        $fields2['shipping']['shipping_phone'] = $fields['shipping']['shipping_phone'];
        $fields2['shipping']['shipping_address_1'] = $fields['shipping']['shipping_address_1'];
        $fields2['shipping']['shipping_address_2'] = $fields['shipping']['shipping_address_2'];
        $fields2['shipping']['shipping_city'] = $fields['shipping']['shipping_city'];

        
      
       
        $fields2['account'] = $fields['account'];
        $fields2['order'] = $fields['order'];
        return $fields2;

}

add_filter('woocommerce_checkout_fields','custom_overide_state');
function custom_overide_state($fields){
	 //$fields['billing']['billing_state']['default'] = 'KL';
	 //$fields['shipping']['shipping_state']['default'] = 'KL';
	 $fields['shipping']['shipping_phone']['label'] = 'phone';
	 return $fields;
}

//add_filter( 'woocommerce_product_single_add_to_cart_text', 'woo_custom_cart_button_text' ); // 2.1 +
//add_filter( 'woocommerce_product_add_to_cart_text', 'woo_custom_cart_button_text' ); // 2.1 +

function woo_custom_cart_button_text() {
return __( 'Add to cartss', 'woocommerce' );
}


// Custom Cart Message
add_filter( 'woocommerce_add_to_cart_message', 'custom_add_to_cart_message' );
function custom_add_to_cart_message ($message) {
    global $woocommerce;
    // Output success messages
        $custom_message    = sprintf('%s %s', __('Product successfully added to your ', 'woocommerce'), get_permalink(woocommerce_get_page_id('cart')), __('Briefcase', 'woocommerce'));
    global $is_cart_added;
    $is_cart_added = 1;
    return $custom_message;
}
/*-----------------------------------------------------------------------------------*/
/* Don't add any code below here. */
/*-----------------------------------------------------------------------------------*/
?>