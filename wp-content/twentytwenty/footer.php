<?php
/**
 * The template for displaying the footer
 *
 * Contains the opening of the #site-footer div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

?>
<footer>
		<div class="container">
			<?php

			if( have_rows('social_media_links', 'option') ):
				echo '<ul class="foot-social">';
					while( have_rows('social_media_links', 'option') ) : the_row();
						if (get_sub_field('platform') == 'envelope') {
							echo '<li><a href="mailto:'.get_sub_field('email_address').'" class="social_icon '.get_sub_field('platform').'"><i class="fa fa-'.get_sub_field('platform').'" aria-hidden="true"></i></a></li>';
						}
						else {
							echo '<li><a href="'.get_sub_field('link').'" target="_blank" class="social_icon '.get_sub_field('platform').'"><i class="fa fa-'.get_sub_field('platform').'" aria-hidden="true"></i></a></li>';
						}
					endwhile;
				echo '</ul>';
			endif;
			?>

			<ul class="foot-link">
				<?php
				if ( has_nav_menu( 'footer' ) ) {

					wp_nav_menu(
						array(
							'container'  => '',
							'items_wrap' => '%3$s',
							'theme_location' => 'footer',
						)
					);

				}
				?>
			</ul>
			<?php echo get_field('copyright_text', 'option') ?>
		</div>
	</footer>

		<?php wp_footer(); ?>

	</body>
</html>


<?php if (is_product()) { ?>
	<script type="text/javascript">

		jQuery('.entry-summary form.variations_form').remove();

		jQuery('#customer_details input[name=radio-group]').on('change', function() {

			var variationID = jQuery(this).val();
			var productID = jQuery('#customer_details input[name=radio-group]:checked').data('productid');
			var productQty = jQuery('#customer_details input[name=radio-group]:checked').data('qty');

			var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
			jQuery.ajax({
				data: {action: 'variation_add_to_cart_func', variationID: variationID, productID: productID, productQty: productQty},
				type: 'POST',
				url: ajaxurl,
				success: function(data) {
					jQuery( 'body' ).trigger( 'update_checkout' );
					jQuery( 'body' ).trigger( 'wc_update_cart' );
				}
			});
		})

		jQuery('#warranty_option').on('change', function() {
			var isWarranty = 0;
			if(jQuery(this).prop('checked')) {
				isWarranty = 1;
			}
			var variationID = jQuery('#customer_details input[name=radio-group]:checked').val();
			var productID = jQuery('#customer_details input[name=radio-group]:checked').data('productid');
			var productQty = jQuery('#customer_details input[name=radio-group]:checked').data('qty');
			var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
			jQuery.ajax({
				data: {action: 'variation_add_to_cart_func', isWarranty: isWarranty, productID: productID,variationID: variationID, productID: productID, productQty: productQty},
				type: 'POST',
				url: ajaxurl,
				success: function(data) {
					jQuery( 'body' ).trigger( 'update_checkout' );
					jQuery( 'body' ).trigger( 'wc_update_cart' );
				}
			});
		});

		//Remove State field on checkout page
		jQuery('#billing_country').on("select2:select", function(e) {
			var country = jQuery('#billing_state').is("input");
			if(country){
				jQuery('#billing_state_field').hide();
			}else{
				jQuery('#billing_state_field').show();
			}
		});

	</script>
<?php } ?>

<!--Start Chat Script-->
<!-- <script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
	var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
	s1.async=true;
	s1.src='https://embed.tawk.to/5fb7cf13920fc91564c8fae8/default';
	s1.charset='UTF-8';
	s1.setAttribute('crossorigin','*');
	s0.parentNode.insertBefore(s1,s0);
})();
</script> -->
<!--End Chat Script-->
<script type="text/javascript">
	jQuery(document).ready(function(){
	/*wow = new WOW(
	  {
		animateClass: 'animated',
		offset:       0,
		callback:     function(box) {
		  console.log("WOW: animating <" + box.tagName.toLowerCase() + ">")
		}
	  }
	);
	wow.init();*/

	// Set footer at bottom position
	var HFHeight = (jQuery('#site-header').height() + jQuery('footer').height() + 50)
	jQuery('#site-content').css('min-height', 'calc(100vh - '+HFHeight+'px)')

	});

</script>