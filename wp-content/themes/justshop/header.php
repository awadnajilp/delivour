<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Header Template
 *
 * Here we setup all logic and XHTML that is required for the header section of all screens.
 *
 * @package WooFramework
 * @subpackage Template
 */

 global $woo_options, $woocommerce;

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php woo_title( '' ); ?></title>
<?php woo_meta(); ?>
<link rel="pingback" href="<?php echo esc_url( get_bloginfo( 'pingback_url' ) ); ?>" />
<script type="text/javascript">
var templateUrl = '<?= get_bloginfo("template_url"); ?>';
</script>
<?php
wp_head();
woo_head();
?>
</head>
<body <?php body_class(); ?>>

<?php woo_top(); ?>
<div id="wrapper">

    <?php woo_header_before(); ?>

	<header id="header" class="TThdr <?php jc_hdr_class() ?>"> <!-- making class "b" for layout 2, class "c" for layout 3, class "d" for layout 4, class "e" for layout 5, class "f" for layout 6. -->

<div class="cboxOverlay" style="position:fixed; width:100%; height:100%;background:#000;
	top:0;
	left:0;
	z-index:9999;
	overflow:hidden;opacity:0.8;"><div style="position:relative;margin: 0 auto;text-align:center;top:320px"><img  src="<?= get_bloginfo("template_url"); ?>/images/spinner.gif" style="width:30px;height:30px;" title="img/ajax-loaders/ajax-loader-2.gif" ></div>
			
			</div>
			<?php woo_header_inside(); // Top nav bar hooked here, logo hooked here ?>

			<div class="row">

			    <hgroup>
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
					<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
					<span class="nav-toggle"><a href="#navigation"><span><?php _e( 'Navigation', 'templatation' ); ?></span></a></span>
				</hgroup>

				<?php woo_nav_before(); ?>

	    	</div><!--/.row-->

		<nav id="navigation" class="col-full" role="navigation">

			<?php
			if ( function_exists( 'has_nav_menu' ) && has_nav_menu( 'primary-menu' ) ) {
				wp_nav_menu( array( 'depth' => 6, 'sort_column' => 'menu_order', 'container' => 'ul', 'menu_id' => 'main-nav', 'menu_class' => 'nav', 'theme_location' => 'primary-menu' ) );
			} else {
	        echo "Please assign primary menu in wp-admin->Appearance->Menus";
			} ?>

		</nav><!-- /#navigation -->

		<?php woo_nav_after();  ?>
			
	</header><!-- /#header -->

	<?php woo_content_before(); // @hooked  Sticky Tagline area?>