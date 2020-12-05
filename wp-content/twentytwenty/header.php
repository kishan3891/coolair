<?php
/**
 * Header file for the Twenty Twenty WordPress default theme.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

?><!DOCTYPE html>

<html class="no-js" <?php language_attributes(); ?>>

	<head>

		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1.0" >

		<link rel="profile" href="https://gmpg.org/xfn/11">

		<?php wp_head(); ?>

	</head>
	<?php $template = get_checkout_template($_COOKIE['affiliate_for_woocommerce'], get_the_ID()); ?>
	<body <?php body_class('chk_template_'.$template); ?>>

		<?php
		wp_body_open();
		?>
		<?php if (is_product()) {
			echo '<link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;700&display=swap" rel="stylesheet">';
			global $woocommerce;
			$product_id = get_the_ID();
			$product = wc_get_product( $product_id );

			//Get Product Logo
			$product_log = get_field( 'product_logo', $product_id, true );
			$product_bnr_back_desk = get_field( 'product_banner_image_desktop', $product_id, true );
			$product_bnr_back_mob = get_field( 'product_banner_image_mobile', $product_id, true );

			$children = $product->get_children();
			$i = 1;
			foreach($children as $child) {
				$is_bestSeller = get_post_meta( $child, 'bestSeller_checkbox', true );
				if ($is_bestSeller == 'yes' || $i == 1) {
					$variation_id = $child;
					$var_qty = intval(get_post_meta( $child, 'qty_number_field', true ));
					if ($var_qty == null) {
						$var_qty = 1;
					}
					$custom_price = get_post_meta($child, '_price', true);
					$custom_price = $custom_price / $var_qty;
				}
				$i++;
			}

			$woocommerce->cart->empty_cart();
			$cart_item_data = array('custom_price' => $custom_price);
			$woocommerce->cart->add_to_cart($product_id, $var_qty, $variation_id, null, $cart_item_data);
			$woocommerce->cart->calculate_totals();
			$woocommerce->cart->set_session();
			$woocommerce->cart->maybe_set_cart_cookies();

			$template = get_checkout_template($_COOKIE['affiliate_for_woocommerce'], $product_id);

			if ($template == 2) { ?>
				<header class="temp_head_2">
					<figure>
						<img class="desktop" src="<?php echo $product_bnr_back_desk; ?>">
						<img class="mobile" src="<?php echo $product_bnr_back_mob; ?>">
					</figure>
				</header>
			<?php }
			else { ?>
				<header>
					<div class="logo">
						<?php 
						if($product_log){?>
							<div class="site-logo faux-heading">
								<img src="<?php echo $product_log;?>" class="custom-logo">
							</div>
						<?php }else{

							twentytwenty_site_logo();
						}?>
					</div>
				</header>
			<?php }
		}
		else {
		?>
			
			<header id="site-header" class="header-footer-group" role="banner">

				<div class="header-inner section-inner">

					<div class="header-titles-wrapper">

						<div class="header-titles">

							<?php
								twentytwenty_site_logo();
								twentytwenty_site_description();
							?>

						</div><!-- .header-titles -->

					</div><!-- .header-titles-wrapper -->

					<div class="header-navigation-wrapper">

						<?php
						if ( has_nav_menu( 'primary' ) || ! has_nav_menu( 'expanded' ) ) {
							?>

								<nav class="primary-menu-wrapper" aria-label="<?php esc_attr_e( 'Horizontal', 'twentytwenty' ); ?>" role="navigation">

									<ul class="primary-menu reset-list-style">

									<?php
									if ( has_nav_menu( 'primary' ) ) {

										wp_nav_menu(
											array(
												'container'  => '',
												'items_wrap' => '%3$s',
												'theme_location' => 'primary',
											)
										);

									}
									?>

									</ul>

								</nav><!-- .primary-menu-wrapper -->

							<?php
						}

						?>

					</div><!-- .header-navigation-wrapper -->

					<div class="cd-dropdown-wrapper">
					<a class="cd-dropdown-trigger meanmenu-reveal" href="#"><span></span><span></span><span></span></a>
					<nav class="cd-dropdown">
					<h2>Menu</h2>
					<a href="#0" class="cd-close">Close</a>
					<ul class="cd-dropdown-content">
						<?php
						if ( has_nav_menu( 'primary' ) ) {

							wp_nav_menu(
								array(
									'container'  => '',
									'items_wrap' => '%3$s',
									'theme_location' => 'primary',
								)
							);

						}
						?>
					</ul>
					</nav> 
					</div>

				</div><!-- .header-inner -->

			</header><!-- #site-header -->

			<?php
		}
