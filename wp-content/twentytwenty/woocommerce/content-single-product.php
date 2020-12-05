<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
$template = get_checkout_template($_COOKIE['affiliate_for_woocommerce'], $product->get_id());
?>
<section id="product-<?php the_ID(); ?>" <?php wc_product_class( 'banner template_'.$template.'', $product ); ?>>
	<div class="container">
		<?php
		if ($template == 1) { ?>
			<div class="bnr-cont">
				<div class="bnr-cont-inner">
					<div class="row align-items-center">
						<div class="col-lg-7 col-md-5">
							<?php
							/**
							 * Hook: woocommerce_before_single_product_summary.
							 *
							 * @hooked woocommerce_show_product_sale_flash - 10
							 * @hooked woocommerce_show_product_images - 20
							 */
							do_action( 'woocommerce_before_single_product_summary' );
							?>
						</div>
						<div class="col-lg-5 col-md-7">
							<div class="summary entry-summary">
								<?php
								/**
								 * Hook: woocommerce_single_product_summary.
								 *
								 * @hooked woocommerce_template_single_title - 5
								 * @hooked woocommerce_template_single_rating - 10
								 * @hooked woocommerce_template_single_price - 10
								 * @hooked woocommerce_template_single_excerpt - 20
								 * @hooked woocommerce_template_single_add_to_cart - 30
								 * @hooked woocommerce_template_single_meta - 40
								 * @hooked woocommerce_template_single_sharing - 50
								 * @hooked WC_Structured_Data::generate_product_data() - 60
								 */
								do_action( 'woocommerce_single_product_summary' );
								?>
							</div>
						</div>
					</div>
				</div>
				<div class="bnr-special-offer">
					<?php the_content(); ?>
				</div>
			</div>
		<?php }
		elseif ($template == 3) {
			echo '<div class="temaplate_3_p_banner row">';
			echo '<div class="col-md-6"><h1>'.get_the_title().'</h1></div>';
			echo '<div class="col-md-6 img"><img src="'.get_the_post_thumbnail_url($product->get_id(), 'full').'"></div>';
			echo '</div>';
		}
		else { ?>
			<div class="bnr-special-offer"><?php the_content(); ?></div>
		<?php } ?>
	</div>
</section>

<section class="middle-content">
	<div class="container">
		<?php
		/**
		 * Hook: woocommerce_after_single_product_summary.
		 *
		 * @hooked woocommerce_output_product_data_tabs - 10
		 * @hooked woocommerce_upsell_display - 15
		 * @hooked woocommerce_output_related_products - 20
		 */
		do_action( 'woocommerce_after_single_product_summary' );
		?>
	</div>
</section>

<?php do_action( 'woocommerce_after_single_product' ); ?>
