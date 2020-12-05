<?php
/**
 * OPC review order form template with Remove/Quantity columns
 *
 * @version 2.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div class="middle-right-cont">
<?php if ( ! is_ajax() ) : ?>
<div class="opc_order_review">
	<input type="hidden" name="is_opc" value="1" />
<?php endif; ?>

			<?php
				do_action( 'woocommerce_review_order_before_cart_contents' );

				foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
					$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

					$pID = $cart_item['product_id'];

					if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
						$template = get_checkout_template($_COOKIE['affiliate_for_woocommerce'], $cart_item['product_id']);
						if ($template == 1) {
						?>
							<div class="row">
								<div class="col-lg-8 col-md-12 col-sm-8">
									<div class="middle-right-left">
										<h3><?php echo get_the_title($cart_item['product_id']); ?></h3>
										<span>FREE DELIVERY Today!</span>
									</div>
								</div>
								<div class="col-lg-4 col-md-12 col-sm-4">
									<div class="middle-right-img">
										<figure><img src="<?php echo wp_get_attachment_url( $_product->get_image_id() ); ?>"></figure>
									</div>
								</div>
							</div>

							<div class="step-sec">
								<div class="step-sec3">
									<h4>Step 3: Delivery Address</h4>
									<?php do_action( 'woocommerce_before_checkout_billing_form', $checkout ); ?>
									<div class="woocommerce-billing-fields__field-wrapper sddfsfsd">
										<?php
										$fields = $checkout->get_checkout_fields( 'billing' );
										foreach ( $fields as $key => $field ) {
											if ( $key == 'billing_country' || $key == 'billing_state' || $key == 'billing_city' || $key == 'billing_address_1' || $key == 'billing_postcode' ) {
												woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
											}
										}
										?>
									</div>
									<?php do_action( 'woocommerce_after_checkout_billing_form', $checkout ); ?>
								</div>

								<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
									<tr class="cart-discount coupon-<?php echo esc_attr( $code ); ?>">
										<th><?php wc_cart_totals_coupon_label( $coupon ); ?></th>
										<td><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
									</tr>
								<?php endforeach; ?>

								<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

									<?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

									<?php wc_cart_totals_shipping_html(); ?>

									<?php do_action( 'woocommerce_review_order_after_shipping' ); ?>

								<?php endif; ?>

								<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
									<tr class="fee">
										<th><?php echo esc_html( $fee->name ); ?></th>
										<td><?php wc_cart_totals_fee_html( $fee ); ?></td>
									</tr>
								<?php endforeach; ?>

								<?php if ( WC()->cart->get_tax_price_display_mode() === 'excl' ) : ?>
									<?php if ( get_option( 'woocommerce_tax_total_display' ) === 'itemized' ) : ?>
										<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
											<tr class="tax-rate tax-rate-<?php echo sanitize_title( $code ); ?>">
												<th><?php echo esc_html( $tax->label ); ?></th>
												<td><?php echo wp_kses_post( $tax->formatted_amount ); ?></td>
											</tr>
										<?php endforeach; ?>
									<?php else : ?>
										<tr class="tax-total">
											<th><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></th>
											<td><?php echo wc_price( WC()->cart->get_taxes_total() ); ?></td>
										</tr>
									<?php endif; ?>
								<?php endif; ?>

								<?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

								<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>
							</div>
						<?php }
						else {
							
							echo '<div class="disc_block">
										'.get_the_excerpt($pID).'
								</div>';
							?>

							<div class="woocommerce-billing-fields step-sec">
								<div class="step-sec2">
									<?php if ($template != 2) { ?>
										<h4>Step 2: Contact Information</h4>
										<?php do_action( 'woocommerce_before_checkout_billing_form', $checkout ); ?>
										<div class="woocommerce-billing-fields__field-wrapper">
											<?php
											$fields = $checkout->get_checkout_fields( 'billing' );
											foreach ( $fields as $key => $field ) {
												if ($key == 'billing_first_name' || $key == 'billing_last_name' || $key == 'billing_phone' || $key == 'billing_email') {
													woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
												}
											}
											?>
										</div>
									<?php } ?>
									<div class="woocommerce-billing-fields__field-wrapper">
										<h4>Step 3: Delivery Address</h4>
										<?php
										$fields = $checkout->get_checkout_fields( 'billing' );
										foreach ( $fields as $key => $field ) {
											if ( $key == 'billing_country' || $key == 'billing_state' || $key == 'billing_city' || $key == 'billing_address_1' || $key == 'billing_postcode' ) {
												woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
											}
										}
										?>
									</div>
									<?php do_action( 'woocommerce_after_checkout_billing_form', $checkout ); ?>
								</div>

								<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
									<tr class="cart-discount coupon-<?php echo esc_attr( $code ); ?>">
										<th><?php wc_cart_totals_coupon_label( $coupon ); ?></th>
										<td><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
									</tr>
								<?php endforeach; ?>

								<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

									<?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

									<?php wc_cart_totals_shipping_html(); ?>

									<?php do_action( 'woocommerce_review_order_after_shipping' ); ?>

								<?php endif; ?>

								<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
									<tr class="fee">
										<th><?php echo esc_html( $fee->name ); ?></th>
										<td><?php wc_cart_totals_fee_html( $fee ); ?></td>
									</tr>
								<?php endforeach; ?>

								<?php if ( WC()->cart->get_tax_price_display_mode() === 'excl' ) : ?>
									<?php if ( get_option( 'woocommerce_tax_total_display' ) === 'itemized' ) : ?>
										<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
											<tr class="tax-rate tax-rate-<?php echo sanitize_title( $code ); ?>">
												<th><?php echo esc_html( $tax->label ); ?></th>
												<td><?php echo wp_kses_post( $tax->formatted_amount ); ?></td>
											</tr>
										<?php endforeach; ?>
									<?php else : ?>
										<tr class="tax-total">
											<th><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></th>
											<td><?php echo wc_price( WC()->cart->get_taxes_total() ); ?></td>
										</tr>
									<?php endif; ?>
								<?php endif; ?>

								<?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

								<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>
								<?php echo show_product_warranty(); ?>
							</div>
						<?php }
					}
				}

				do_action( 'woocommerce_review_order_after_cart_contents' );
			?>
<?php if ( ! is_ajax() ) : ?></div><?php endif; ?>
		
			

