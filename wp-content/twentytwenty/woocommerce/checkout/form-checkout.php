<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
	return;
}

global $product;

$template = get_checkout_template($_COOKIE['affiliate_for_woocommerce'], $product->get_id());

?>

<form name="checkout" method="post" class="row checkout woocommerce-checkout template_<?php echo $template; ?>" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

	<?php if ( $checkout->get_checkout_fields() ) : ?>

		<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

		<div class="col-md-6" id="customer_details">
			<div class="middle-left-cont">
				<div class="discount-sec">
					<figure>
						
						<?php if ($template == 2) {
							echo '<img src="'.get_template_directory_uri().'/assets/images/discount-image-2.png">';
						}
						else {
							echo '<img src="'.get_template_directory_uri().'/assets/images/discount-image-1.png">';
						}?>

					</figure>
					<div class="discount-inner-cont">
						<?php echo do_shortcode("[finale_countdown_timer]"); ?>
					</div>
				</div>

				<?php do_action( 'woocommerce_checkout_billing' ); ?>
				
			</div>
		</div>

		<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

	<?php endif; ?>
	
	<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>
	
	<!-- <h3 id="order_review_heading"><?php //esc_html_e( 'Your order', 'woocommerce' ); ?></h3> -->
	
	<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

	<div id="order_review" class="col-md-6 woocommerce-checkout-review-order">
		<?php do_action( 'woocommerce_checkout_order_review' ); ?>
	</div>

	<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
