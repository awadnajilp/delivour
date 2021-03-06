<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Template Name: Contact Form
 *
 * The contact form page template displays the a
 * simple contact form in your website's content area.
 *
 * @package WooFramework
 * @subpackage Template
 */
 
global $woo_options;
get_header();
 
$nameError = '';
$emailError = '';
$commentError = '';

//If the form is submitted
if( isset( $_POST['submitted'] ) ) {

	//Check to see if the honeypot captcha field was filled in
	if( trim( $_POST['checking'] ) !== '' ) {
		$captchaError = true;
	} else {

		//Check to make sure that the name field is not empty
		if( trim( $_POST['contactName'] ) === '' ) {
			$nameError =  __( 'You forgot to enter your name.', 'templatation' );
			$hasError = true;
		} else {
			$name = trim( $_POST['contactName'] );
		}

		//Check to make sure sure that a valid email address is submitted
		if( trim( $_POST['email'] ) === '' )  {
			$emailError = __( 'You forgot to enter your email address.', 'templatation' );
			$hasError = true;
		} else if ( ! eregi( "^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}$", trim($_POST['email'] ) ) ) {
			$emailError = __( 'You entered an invalid email address.', 'templatation' );
			$hasError = true;
		} else {
			$email = trim( $_POST['email'] );
		}

		//Check to make sure comments were entered
		if( trim( $_POST['comments'] ) === '' ) {
			$commentError = __( 'You forgot to enter your comments.', 'templatation' );
			$hasError = true;
		} else {
			$comments = stripslashes( trim( $_POST['comments'] ) );
		}

		//If there is no error, send the email
		if( ! isset( $hasError ) ) {

			$emailTo = get_option( 'woo_contactform_email' );
			$subject = __( 'Contact Form Submission from ', 'templatation' ).$name;
			$sendCopy = trim( $_POST['sendCopy'] );
			$body = sprintf( __( "Name: %s \n\nEmail: %s \n\nComments: %s", 'templatation' ), $name, $email, $comments );
			$headers = __( 'From: ', 'templatation') . "$name <$email>" . "\r\n" . __( 'Reply-To: ', 'templatation' ) . $email;

			wp_mail( $emailTo, $subject, $body, $headers );

			if( $sendCopy == true ) {
				$subject = __( 'You emailed ', 'templatation' ) . get_bloginfo( 'title' );
				$headers = __( 'From: ', 'templatation' ) . "$name <$emailTo>";
				wp_mail( $email, $subject, $body, $headers );
			}

			$emailSent = true;

		}
	}
}
?>
<script type="text/javascript">
<!--//--><![CDATA[//><!--
jQuery(document).ready(function() {
	jQuery( 'form#contactForm').submit(function() {
		jQuery( 'form#contactForm .error').remove();
		var hasError = false;
		jQuery( '.requiredField').each(function() {
			if(jQuery.trim(jQuery(this).val()) == '') {
				var labelText = jQuery(this).prev( 'label').text();
				jQuery(this).parent().append( '<span class="error"><?php _e( 'You forgot to enter your', 'templatation' ); ?> '+labelText+'.</span>' );
				jQuery(this).addClass( 'inputError' );
				hasError = true;
			} else if(jQuery(this).hasClass( 'email')) {
				var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
				if(!emailReg.test(jQuery.trim(jQuery(this).val()))) {
					var labelText = jQuery(this).prev( 'label').text();
					jQuery(this).parent().append( '<span class="error"><?php _e( 'You entered an invalid', 'templatation' ); ?> '+labelText+'.</span>' );
					jQuery(this).addClass( 'inputError' );
					hasError = true;
				}
			}
		});
		if(!hasError) {
			var formInput = jQuery(this).serialize();
			jQuery.post(jQuery(this).attr( 'action'),formInput, function(data){
				jQuery( 'form#contactForm').slideUp( "fast", function() {
					jQuery(this).before( '<p class="tick"><?php _e( '<strong>Thanks!</strong> Your email was successfully sent.', 'templatation' ); ?></p>' );
				});
			});
		}

		return false;

	});
});
//-->!]]>
</script>

    <div id="content" class="col-full">
    	
    	<?php woo_main_before(); ?>
    
		<section id="main" class="col-left">

            <article id="contact-page" class="type-page">

            <?php if( isset( $emailSent ) && $emailSent == true ) { ?>

                <p class="info"><?php _e( 'Your email was successfully sent.', 'templatation' ); ?></p>

            <?php } else { ?>

                <?php if ( have_posts() ) { ?>

                <?php while ( have_posts() ) { the_post(); ?>
                
                		<header>
                			<h1><?php the_title(); ?></h1>
                		</header>

                        <section class="entry">
	                        <?php the_content(); ?>
                			
                			<div class="location-twitter fix">
    							<?php if ( isset( $woo_options['woo_contact_panel'] ) && $woo_options['woo_contact_panel'] == 'true' ) { ?>
						    	<section id="office-location"<?php if ( ( isset( $woo_options['woo_contact_twitter'] ) && $woo_options['woo_contact_twitter'] != '' ) || ( isset($woo_options['woo_contact_subscribe_and_connect']) && $woo_options['woo_contact_subscribe_and_connect'] == 'true' ) ) { ?> class="col-left"<?php } ?>>
									<?php if (isset($woo_options['woo_contact_title'])) { ?><h3><?php echo esc_html( $woo_options['woo_contact_title'] ); ?></h3><?php } ?>
									<ul>
										<?php if (isset($woo_options['woo_contact_title']) && $woo_options['woo_contact_title'] != '' ) { ?><li><?php echo nl2br( esc_html( $woo_options['woo_contact_address'] ) ); ?></li><?php } ?>
										<?php if (isset($woo_options['woo_contact_number']) && $woo_options['woo_contact_number'] != '' ) { ?><li><?php _e('Tel:','templatation'); ?> <?php echo esc_html( $woo_options['woo_contact_number'] ); ?></li><?php } ?>
										<?php if (isset($woo_options['woo_contact_fax']) && $woo_options['woo_contact_fax'] != '' ) { ?><li><?php _e('Fax:','templatation'); ?> <?php echo esc_html( $woo_options['woo_contact_fax'] ); ?></li><?php } ?>
										<?php if (isset($woo_options['woo_contactform_email']) && $woo_options['woo_contactform_email'] != '' ) { ?><li><?php _e('Email:','templatation'); ?> <a href="mailto:<?php echo esc_attr( $woo_options['woo_contactform_email'] ); ?>"><?php echo esc_html( $woo_options['woo_contactform_email'] ); ?></a></li><?php } ?>
									</ul>
						    	</section>
						    	<?php } ?>
						    	<div class="contact-social<?php if ( ( isset( $woo_options['woo_contact_panel'] ) && $woo_options['woo_contact_panel'] == 'true' ) && ( ( isset( $woo_options['woo_contact_twitter'] ) && $woo_options['woo_contact_twitter'] != '' ) || ( isset($woo_options['woo_contact_subscribe_and_connect']) && $woo_options['woo_contact_subscribe_and_connect'] == 'true' ) ) ) { ?> col-right<?php } ?>">
						    	
						    		<?php if ( isset( $woo_options['woo_contact_twitter'] ) && $woo_options['woo_contact_twitter'] != '' ) { ?>
						    		<section id="twitter">
										<?php echo do_shortcode( '[twitter-widget items="1" showretweets="false" username="'.$woo_options["woo_contact_twitter"].'"]' ); ?>
						    		</section>
						    		<?php } ?>
						    		<?php if ( isset($woo_options['woo_contact_subscribe_and_connect']) && $woo_options['woo_contact_subscribe_and_connect'] == 'true' ) { woo_subscribe_connect(); } ?>
						    	
						    	</div>
						    	
						    	</div><!-- /.location-twitter -->
	                        
                        </section>
                        <div class="woo-sc-hr"></div>
                    <?php templatation_gmap(); ?>

                    <?php if( isset( $hasError ) || isset( $captchaError ) ) { ?>
                        <p class="alert"><?php _e( 'There was an error submitting the form.', 'templatation' ); ?></p>
                    <?php } ?>

                    <?php if ( get_option( 'woo_contactform_email' ) == '' ) { ?>
                        <?php echo do_shortcode( '[box type="alert"]' . __( 'E-mail has not been setup properly. Please add your contact e-mail!', 'templatation' ) . '[/box]' );  ?>
                    <?php } ?>
					

                    <form action="<?php the_permalink(); ?>" id="contactForm" method="post">

                        <ol class="forms">
                            <li><label for="contactName"><?php _e( 'Name', 'templatation' ); ?></label>
                                <input type="text" name="contactName" id="contactName" value="<?php if( isset( $_POST['contactName'] ) ) { echo esc_attr( $_POST['contactName'] ); } ?>" class="txt requiredField" />
                                <?php if($nameError != '') { ?>
                                    <span class="error"><?php echo $nameError;?></span>
                                <?php } ?>
                            </li>

                            <li><label for="email"><?php _e( 'Email', 'templatation' ); ?></label>
                                <input type="text" name="email" id="email" value="<?php if( isset( $_POST['email'] ) ) { echo esc_attr( $_POST['email'] ); } ?>" class="txt requiredField email" />
                                <?php if($emailError != '') { ?>
                                    <span class="error"><?php echo $emailError;?></span>
                                <?php } ?>
                            </li>

                            <li class="textarea"><label for="commentsText"><?php _e( 'Message', 'templatation' ); ?></label>
                                <textarea name="comments" id="commentsText" rows="20" cols="30" class="requiredField"><?php if( isset( $_POST['comments'] ) ) { echo esc_textarea( $_POST['comments'] ); } ?></textarea>
                                <?php if( $commentError != '' ) { ?>
                                    <span class="error"><?php echo $commentError; ?></span>
                                <?php } ?>
                            </li>
                            <li class="inline"><input type="checkbox" name="sendCopy" id="sendCopy" value="true"<?php if( isset( $_POST['sendCopy'] ) && $_POST['sendCopy'] == true ) { echo ' checked="checked"'; } ?> /><label for="sendCopy"><?php _e( 'Send a copy of this email to yourself', 'templatation' ); ?></label></li>
                            <li class="screenReader"><label for="checking" class="screenReader"><?php _e( 'If you want to submit this form, do not enter anything in this field', 'templatation' ); ?></label><input type="text" name="checking" id="checking" class="screenReader" value="<?php if( isset( $_POST['checking'] ) ) { echo esc_attr( $_POST['checking'] ); } ?>" /></li>
                            <li class="buttons"><input type="hidden" name="submitted" id="submitted" value="true" /><input class="submit button" type="submit" value="<?php esc_attr_e( 'Submit', 'templatation' ); ?>" /></li>
                        </ol>
                    </form>

                    <?php
                    		} // End WHILE Loop
                    	}
                    }
                    ?>

            </article><!-- /#contact-page -->
		</section><!-- /#main -->
		
		<?php woo_main_after(); ?>

        <?php get_sidebar(); ?>

    </div><!-- /#content -->

<?php get_footer(); ?>