<?php
/**
 * Twenty Twenty functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

/**
 * Table of Contents:
 * Theme Support
 * Required Files
 * Register Styles
 * Register Scripts
 * Register Menus
 * Custom Logo
 * WP Body Open
 * Register Sidebars
 * Enqueue Block Editor Assets
 * Enqueue Classic Editor Styles
 * Block Editor Settings
 */

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function twentytwenty_theme_support() {

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Custom background color.
	add_theme_support(
		'custom-background',
		array(
			'default-color' => 'f5efe0',
		)
	);

	// Set content-width.
	global $content_width;
	if ( ! isset( $content_width ) ) {
		$content_width = 580;
	}

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// Set post thumbnail size.
	set_post_thumbnail_size( 1200, 9999 );

	// Add custom image size used in Cover Template.
	add_image_size( 'twentytwenty-fullscreen', 1980, 9999 );

	// Custom logo.
	$logo_width  = 120;
	$logo_height = 90;

	// If the retina setting is active, double the recommended width and height.
	if ( get_theme_mod( 'retina_logo', false ) ) {
		$logo_width  = floor( $logo_width * 2 );
		$logo_height = floor( $logo_height * 2 );
	}

	add_theme_support(
		'custom-logo',
		array(
			'height'      => $logo_height,
			'width'       => $logo_width,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'script',
			'style',
		)
	);

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Twenty Twenty, use a find and replace
	 * to change 'twentytwenty' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'twentytwenty' );

	// Add support for full and wide align images.
	add_theme_support( 'align-wide' );

	// Add support for responsive embeds.
	add_theme_support( 'responsive-embeds' );

	/*
	 * Adds starter content to highlight the theme on fresh sites.
	 * This is done conditionally to avoid loading the starter content on every
	 * page load, as it is a one-off operation only needed once in the customizer.
	 */
	if ( is_customize_preview() ) {
		require get_template_directory() . '/inc/starter-content.php';
		add_theme_support( 'starter-content', twentytwenty_get_starter_content() );
	}

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	add_theme_support( 'woocommerce' );

	/*
	 * Adds `async` and `defer` support for scripts registered or enqueued
	 * by the theme.
	 */
	$loader = new TwentyTwenty_Script_Loader();
	add_filter( 'script_loader_tag', array( $loader, 'filter_script_loader_tag' ), 10, 2 );

}

add_action( 'after_setup_theme', 'twentytwenty_theme_support' );

/**
 * REQUIRED FILES
 * Include required files.
 */
require get_template_directory() . '/inc/template-tags.php';

// Handle SVG icons.
require get_template_directory() . '/classes/class-twentytwenty-svg-icons.php';
require get_template_directory() . '/inc/svg-icons.php';

// Require Separator Control class.
require get_template_directory() . '/classes/class-twentytwenty-separator-control.php';

// Custom comment walker.
require get_template_directory() . '/classes/class-twentytwenty-walker-comment.php';

// Custom page walker.
require get_template_directory() . '/classes/class-twentytwenty-walker-page.php';

// Custom script loader class.
require get_template_directory() . '/classes/class-twentytwenty-script-loader.php';

// Non-latin language handling.
require get_template_directory() . '/classes/class-twentytwenty-non-latin-languages.php';

// Custom CSS.
require get_template_directory() . '/inc/custom-css.php';

/**
 * Register and Enqueue Styles.
 */
function twentytwenty_register_styles() {

	$theme_version = wp_get_theme()->get( 'Version' );
	wp_enqueue_style( 'twentytwenty-bootstrap-min-css', get_theme_file_uri( '/assets/css/bootstrap.min.css' ), array(), wp_get_theme()->get( 'Version' ), 'all' );
	wp_enqueue_style( 'font-awesome-min-css', 'https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', array(), wp_get_theme()->get( 'Version' ), 'all' );
	wp_enqueue_style( 'twentytwenty-style', get_stylesheet_uri(), array(), $theme_version );
	wp_style_add_data( 'twentytwenty-style', 'rtl', 'replace' );
	wp_enqueue_style( 'twentytwenty-media-css', get_theme_file_uri( '/assets/css/media.css' ), array(), wp_get_theme()->get( 'Version' ), 'all' );
	wp_enqueue_style( 'twentytwenty-menu-css', get_theme_file_uri( '/assets/css/menu.css' ), array(), wp_get_theme()->get( 'Version' ), 'all' );
}

add_action( 'wp_enqueue_scripts', 'twentytwenty_register_styles' );

/**
 * Register and Enqueue Scripts.
 */
function twentytwenty_register_scripts() {

	$theme_version = wp_get_theme()->get( 'Version' );

	if ( ( ! is_admin() ) && is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_script( 'twentytwenty-js', get_template_directory_uri() . '/assets/js/index.js', array(), $theme_version, false );
	wp_enqueue_script( 'twentytwenty-modernizr-js', get_template_directory_uri() . '/assets/js/modernizr.min.js', array(), $theme_version, false );
	wp_enqueue_script( 'twentytwenty-main-js', get_template_directory_uri() . '/assets/js/main.js', array(), $theme_version, false );
	wp_enqueue_script( 'twentytwenty-menu-js', get_template_directory_uri() . '/assets/js/jquery.menu-aim.js', array(), $theme_version, false );
	wp_script_add_data( 'twentytwenty-js', 'async', true );

	/*wp_enqueue_script( 'wow-js', get_template_directory_uri() . '/assets/js/wow.js', array(), $theme_version, false );
	wp_script_add_data( 'wow-js', 'async', true );*/

}

add_action( 'wp_enqueue_scripts', 'twentytwenty_register_scripts' );

/**
 * Fix skip link focus in IE11.
 *
 * This does not enqueue the script because it is tiny and because it is only for IE11,
 * thus it does not warrant having an entire dedicated blocking script being loaded.
 *
 * @link https://git.io/vWdr2
 */
function twentytwenty_skip_link_focus_fix() {
	// The following is minified via `terser --compress --mangle -- assets/js/skip-link-focus-fix.js`.
	?>
	<script>
	/(trident|msie)/i.test(navigator.userAgent)&&document.getElementById&&window.addEventListener&&window.addEventListener("hashchange",function(){var t,e=location.hash.substring(1);/^[A-z0-9_-]+$/.test(e)&&(t=document.getElementById(e))&&(/^(?:a|select|input|button|textarea)$/i.test(t.tagName)||(t.tabIndex=-1),t.focus())},!1);
	</script>
	<?php
}
add_action( 'wp_print_footer_scripts', 'twentytwenty_skip_link_focus_fix' );


// add_action( 'wp_enqueue_scripts', 'twentytwenty_non_latin_languages' );

/**
 * Register navigation menus uses wp_nav_menu in five places.
 */
function twentytwenty_menus() {

	$locations = array(
		'primary'  => __( 'Desktop Horizontal Menu', 'twentytwenty' ),
		'mobile'   => __( 'Mobile Menu', 'twentytwenty' ),
		'footer'   => __( 'Footer Menu', 'twentytwenty' ),
	);

	register_nav_menus( $locations );
}

add_action( 'init', 'twentytwenty_menus' );

/**
 * Get the information about the logo.
 *
 * @param string $html The HTML output from get_custom_logo (core function).
 * @return string
 */
function twentytwenty_get_custom_logo( $html ) {

	$logo_id = get_theme_mod( 'custom_logo' );

	if ( ! $logo_id ) {
		return $html;
	}

	$logo = wp_get_attachment_image_src( $logo_id, 'full' );

	if ( $logo ) {
		// For clarity.
		$logo_width  = esc_attr( $logo[1] );
		$logo_height = esc_attr( $logo[2] );

		// If the retina logo setting is active, reduce the width/height by half.
		if ( get_theme_mod( 'retina_logo', false ) ) {
			$logo_width  = floor( $logo_width / 2 );
			$logo_height = floor( $logo_height / 2 );

			$search = array(
				'/width=\"\d+\"/iU',
				'/height=\"\d+\"/iU',
			);

			$replace = array(
				"width=\"{$logo_width}\"",
				"height=\"{$logo_height}\"",
			);

			// Add a style attribute with the height, or append the height to the style attribute if the style attribute already exists.
			if ( strpos( $html, ' style=' ) === false ) {
				$search[]  = '/(src=)/';
				$replace[] = "style=\"height: {$logo_height}px;\" src=";
			} else {
				$search[]  = '/(style="[^"]*)/';
				$replace[] = "$1 height: {$logo_height}px;";
			}

			$html = preg_replace( $search, $replace, $html );

		}
	}

	return $html;

}

add_filter( 'get_custom_logo', 'twentytwenty_get_custom_logo' );

if ( ! function_exists( 'wp_body_open' ) ) {

	/**
	 * Shim for wp_body_open, ensuring backward compatibility with versions of WordPress older than 5.2.
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
}


/**
 * Overwrite default more tag with styling and screen reader markup.
 *
 * @param string $html The default output HTML for the more tag.
 * @return string
 */
function twentytwenty_read_more_tag( $html ) {
	return preg_replace( '/<a(.*)>(.*)<\/a>/iU', sprintf( '<div class="read-more-button-wrap"><a$1><span class="faux-button">$2</span> <span class="screen-reader-text">"%1$s"</span></a></div>', get_the_title( get_the_ID() ) ), $html );
}

add_filter( 'the_content_more_link', 'twentytwenty_read_more_tag' );


add_filter( 'woocommerce_product_tabs', 'misha_remove_description_tab', 11 );

function misha_remove_description_tab( $tabs ) {
	unset( $tabs['description'] );
	unset( $tabs['reviews'] );
	unset( $tabs['additional_information'] );
	return $tabs;
}

// add_filter( 'woocommerce_form_field', 'my_woocommerce_form_field' );
// function my_woocommerce_form_field( $field ) {
// 	echo $field;
// 	return preg_replace(
// 		'#<p class="form-row (.*?)"(.*?)>(.*?)</p>#',
// 		'<div class="col-md-6 col-sm-12 $1"$2>$3</div>',
// 		$field
// 	);
// }

add_filter( 'woocommerce_checkout_fields' , 'wa_override_checkout_fields' );
function wa_override_checkout_fields( $fields ) {
	unset($fields['billing']['billing_address_2']);
	unset($fields['order']['order_comments']);
	unset($fields['billing']['billing_company']);

	$fields['billing']['billing_phone']['priority'] = 21;
	$fields['billing']['billing_email']['priority'] = 22;
	// $fields['billing']['billing_state']['priority'] = 41;
	// $fields['billing']['billing_city']['priority'] = 42;
	// $fields['billing']['billing_address_1']['priority'] = 43;

	$fields['billing']['billing_phone']['placeholder'] = 'Phone';
	$fields['billing']['billing_first_name']['placeholder'] = 'First name';
	$fields['billing']['billing_last_name']['placeholder'] = 'Last name';
	$fields['billing']['billing_email']['placeholder'] = 'Email address';
	$fields['billing']['billing_city']['placeholder'] = 'Town/City';
	$fields['billing']['billing_postcode']['placeholder'] = 'Postal Code';

	return $fields;
}

// add_action( 'woocommerce_form_field_email','reigel_custom_heading', 10, 4 );
// function reigel_custom_heading( $field, $key, $args, $value ){
// 	if ( is_checkout() ) {
// 		$field .= '<div class="step-sec3"><h4>' . __('Step 3: Delivery Address') . '</h4></div>';
// 	}
// 	return $field;
// }

add_action( 'woocommerce_before_checkout_billing_form', 'display_extra_fields_after_billing_address' , 10, 1 );
function display_extra_fields_after_billing_address () {
	?>
	<div class="contact-info-col">
		<input type="radio" id="male" name="billing_gender" checked="">
		<label for="male">Mr.</label>
	</div>
	<div class="contact-info-col">
		<input type="radio" id="female" name="billing_gender">
		<label for="female">Mrs.</label>
	</div>
  <?php
}

// add_action( 'woocommerce_checkout_update_order_meta', 'add_order_delivery_date_to_order' , 10, 1);

// function add_order_delivery_date_to_order ( $order_id ) {

// 	if ( isset( $_POST ['add_delivery_date'] ) &&  '' != $_POST ['add_delivery_date'] ) {
// 		add_post_meta( $order_id, '_delivery_date',  sanitize_text_field( $_POST ['add_delivery_date'] ) );
// 	}
// }


function variation_radio_buttons() {

	$product = wc_get_product( get_the_ID() );
	$product_title = get_the_title().' - ';

	$children = $product->get_children();
	$is_discount = get_field( 'discount', get_the_ID(), true );

	$warranty = get_post_meta( $product, '_warranty_duration', true );

	echo $warranty;

	foreach ($children as $value) {
		if (get_post_meta( $value, 'qty_number_field', true ) == 1) {
			$one_qty_product = wc_get_product( $value );
			$one_qty_p_price = get_post_meta( $value, '_price', true );
		}
	}

	$i = 1;
	$radios = '<ul>';
	foreach($children as $child) {
		$child_product = wc_get_product( $child );
		$var_title = str_replace( $product_title, '', $child_product->get_name() );
		$is_bestSeller = get_post_meta( $child, 'bestSeller_checkbox', true );
		$var_qty = get_post_meta( $child, 'qty_number_field', true );
		$p_price = $child_product->get_price();
		if ($var_qty == null) {
			$var_qty = 1;
		}
		$each_price = wc_format_decimal($p_price/$var_qty, 2);
		$discount = wc_format_decimal(100 - ($each_price * 100 / $one_qty_p_price), 0);

		$class = $checked = $text = '';
		if ($is_bestSeller == 'yes') {
			$class = "yellow-bg";
			$checked = 'checked="checked"';
			$text = '<em class="best-seller">Best Seller</em>';
		}
		elseif ($i == 1) {
			$checked = 'checked="checked"';
		}
		if($is_discount){
			if ($discount > 0) {
				$discount_text = $discount.'% DISCOUNT ';
			}
			else {
				$discount_text = '';
			}
		}

		$radios .= '<li class="'.$class.'">'.$text.'
			<span class="title">
				<input type="radio" id="variation-'.esc_attr($child).'" data-qty="'.$var_qty.'" data-productid="'.get_the_ID().'" name="radio-group" value="'.$child.'" '.$checked.'>
				<label for="variation-'.esc_attr($child).'">
					<span class="var_title">'.$var_title.'</span>
					<span class="each_price">'.$discount_text.'('.$each_price.get_woocommerce_currency_symbol().' / each)</span>
				</label>
			</span>
			<span class="total-price">
				'.$child_product->get_price_html().'
			</span>
		</li>';

		$i++;
	}

	$radios .= '</ul>';

	return $radios;

}

add_action('wp_ajax_variation_add_to_cart_func', 'variation_add_to_cart_func');
add_action('wp_ajax_nopriv_variation_add_to_cart_func', 'variation_add_to_cart_func');
function variation_add_to_cart_func() {

	global $woocommerce;
	$woocommerce->cart->empty_cart();
	if ($_POST['productQty']) {
		$qty = intval($_POST['productQty']);
	}
	else {
		$qty = 1;
	}

	WCCT_Core::register( 'appearance', 'WCCT_Appearance' );
	$single_data = WCCT_Core()->public->get_single_campaign_pro_data( $_POST['productID'] );

	$custom_price = get_post_meta($_POST['variationID'], '_price', true);

    if($_POST['isWarranty']){
		$product_id = $_POST['productID'];
		$warranty_index = false;
		$warranty   = warranty_get_product_warranty( $product_id );
		if ( $warranty ) {
			$warranty_index    = 0;
			if ( $warranty['type'] == 'addon_warranty') {
            	$addons 	= $warranty['addons'];
                $add_cost	= 0;
                if ( isset($addons[$warranty_index]) && !empty($addons[$warranty_index]) ) {
                	$addon = $addons[$warranty_index];
                    if ( $addon['amount'] > 0 ) {
                        $add_cost += $addon['amount'];
                        if (!empty($single_data)) {
							if (!empty($single_data['deals'])) {
                        		$add_cost = ($add_cost * 2);
							}
						}
                    }
                }
            }
        }
        $final_price = ($custom_price / $qty) + $add_cost;
	}
	else {
		$final_price = $custom_price / $qty;
	}

	$cart_item_data = array(
		'warranty_index' => $warranty_index,
		'custom_price' => $final_price
	);
	$woocommerce->cart->add_to_cart($_POST['productID'], $qty, $_POST['variationID'], null, $cart_item_data);
	$woocommerce->cart->calculate_totals();
	$woocommerce->cart->set_session();
	$woocommerce->cart->maybe_set_cart_cookies();
	wp_die();

}


add_action( 'woocommerce_product_after_variable_attributes', 'variation_settings_fields', 10, 3 );
add_action( 'woocommerce_save_product_variation', 'save_variation_settings_fields', 10, 2 );
function variation_settings_fields( $loop, $variation_data, $variation ) {
	woocommerce_wp_checkbox(
		array(
			'id'	=> 'bestSeller_checkbox[' . $variation->ID . ']',
			'label'	=> __('Best Seller', 'woocommerce' ),
			'value'	=> get_post_meta( $variation->ID, 'bestSeller_checkbox', true ),
		)
	);
	woocommerce_wp_text_input(
		array(
			'id'				=> 'qty_number_field['.$variation->ID.']',
			'label'				=> __( 'Product Quantity', 'woocommerce' ),
			'type'				=> 'number',
			'desc_tip'			=> 'true',
			'description'		=> __( 'Enter the quantity of product will include.', 'woocommerce' ),
			'value'				=> get_post_meta( $variation->ID, 'qty_number_field', true ),
			'custom_attributes'	=> array(
				'step'		=> 'any',
				'min'		=> '1'
			)
		)
	);
}
function save_variation_settings_fields( $post_id ) {
	$checkbox = isset( $_POST['bestSeller_checkbox'][ $post_id ] ) ? 'yes' : 'no';
	$qty_number_field = $_POST['qty_number_field'][ $post_id ];
	update_post_meta( $post_id, 'bestSeller_checkbox', $checkbox );
	update_post_meta( $post_id, 'qty_number_field', $qty_number_field );
}

add_filter( 'woocommerce_order_button_text', 'misha_custom_button_text' );
function misha_custom_button_text( $button_text ) {
	return 'Yes! Send my product';
}

// remove_theme_support( 'wc-product-gallery-lightbox' );
remove_theme_support( 'wc-product-gallery-zoom' );
add_filter( 'woocommerce_sale_flash', '__return_null' );


add_filter( 'default_checkout_billing_country', 'change_default_checkout_country' );
function change_default_checkout_country() {

	/* $geo_instance  = new WC_Geolocation();
	// Get geolocated user geo data.
	$user_geodata = $geo_instance->geolocate_ip();
	// Get current user GeoIP Country
	$country = $user_geodata['country']; */

	$client_ip = explode(", ", get_client_ip());
	$details = json_decode(file_get_contents("http://ipinfo.io/{$client_ip[0]}"));

	return $details->country;
}

function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

function get_checkout_template($affiliateID = null, $productID) {
	$template = 1;
	if($affiliateID) {
		if( have_rows('assign_affiliate_user', $productID) ):
			while( have_rows('assign_affiliate_user', $productID) ) : the_row();
				if ( get_sub_field('affiliate_user') == $affiliateID ) {
					$template = get_sub_field('checkout_template');
				}
			endwhile;
		endif;
	}
	return $template;
}

function woocommerce_custom_price_to_cart_item( $cart_object ) {
	if( !WC()->session->__isset( "reload_checkout" )) {
		foreach ( $cart_object->cart_contents as $key => $value ) {
			if( isset( $value["custom_price"] ) ) {
				$value['data']->set_price($value["custom_price"]);
			}
		}
	}
}
add_action( 'woocommerce_before_calculate_totals', 'woocommerce_custom_price_to_cart_item', 99 );

add_filter( 'woocommerce_checkout_get_value' , 'clear_checkout_fields' , 10, 2 );
function clear_checkout_fields( $value, $input ){
    if( $input != 'billing_country' )
        $value = '';

    return $value;
}


/**
Add Inline Field Error Notifications @ WooCommerce Checkout
**/

add_filter( 'woocommerce_form_field', 'bbloomer_checkout_fields_in_label_error', 10, 4 );

function bbloomer_checkout_fields_in_label_error( $field, $key, $args, $value ) {
   if ( strpos( $field, '</span>' ) !== false && $args['required'] ) {
      $error = '<span class="error" style="display:none">';
      $error .= sprintf( __( '%s is required field.', 'woocommerce' ), $args['label'] );
      $error .= '</span>';
      $field = substr_replace( $field, $error, strpos( $field, '</span>' ), 0);
   }
   return $field;
}


/**
 * Show a product's warranty information
 */
function show_product_warranty() {
    global $post, $product, $woocommerce;

    /*if ( $product->is_type( 'external' ) ) {
        return;
    }*/

    $product_id     = get_the_ID();
	// $product_id     = $product->get_id();
    $warranty       = warranty_get_product_warranty( $product_id );
    $warranty_label = $warranty['label'];

    if ( $warranty['type'] == 'included_warranty' ) {
        if ( $warranty['length'] == 'limited' ) {
            $value      = $warranty['value'];
            $duration   = warranty_duration_i18n( $warranty['duration'], $value );

            echo '<p class="warranty_info"><b>'. $warranty_label .':</b> '. $value .' '. $duration .'</p>';
        } else {
            echo '<p class="warranty_info"><b>'. $warranty_label .':</b> '. __('Lifetime', 'wc_warranty') .'</p>';
        }
    } elseif ( $warranty['type'] == 'addon_warranty' ) {
        $addons = $warranty['addons'];

        if ( is_array($addons) && !empty($addons) ) {
            echo '<div class="warranty_info"><b>'. $warranty_label .'</b> <p name="warranty">';

            if ( isset($warranty['no_warranty_option']) && $warranty['no_warranty_option'] == 'yes' ) {
                echo '<option value="-1">'. __('No warranty', 'wc_warranty') .'</option>';
            }

            foreach ( $addons as $x => $addon ) {
                $amount     = wmc_get_price($addon['amount']);
                $value      = $addon['value'];
                $duration   = warranty_duration_i18n( $addon['duration'], $value );

                if ( $value == 0 && $amount == 0 ) {
                    // no warranty option
                    echo '<option value="-1">'. __('No warranty', 'wc_warranty') .'</option>';
                } else {
                    if ( $amount == 0 ) {
                        $amount = __('Free', 'wc_warranty');
                    } else {
                        $amount = wc_price( $amount );
                    }
                   // echo '<option value="'. $x .'">'. $value .' '. $duration . ' &mdash; '. $amount .'</option>';
                    echo '<input type="checkbox" id="warranty_option" name="'. $x .'" value="'. $x .'"><label for="warranty_option">' .get_the_title().' '. $value .' '. $duration . ' Warranty :'. $amount.'<span class="great-deal">Great Deal</span></label>';
                }
            }

            echo '</p></div>';
        }
    }

}

if( function_exists('acf_add_options_page') ) {
	acf_add_options_page(array(
		'page_title' 	=> 'General Settings',
		'menu_title'	=> 'General Settings',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'manage_options',
		'redirect'		=> false
	));
}

function custom_price_converter_func( $atts ) {
    $price = get_woocommerce_currency_symbol(). number_format( wmc_get_price( $atts['price'] ));
    return $price;
}
add_shortcode( 'price-converter', 'custom_price_converter_func' );

/* ============= Dropshipping tracking module start ============= */

// wp_schedule_single_event('order_csv_email');

add_action('order_csv_email', 'do_this_once_daily', 10, 1);
function do_this_once_daily() {
	$suppliers = get_terms('dropship_supplier');
	foreach($suppliers as $supplier) {
		$suppMeta = get_term_meta($supplier->term_id, 'meta', true);
		$customer_orders = get_posts( array(
			'numberposts' => -1,
			'meta_key'    => '_customer_user',
			'post_type'   => wc_get_order_types(),
			'post_status' => array_keys( wa_get_order_statuses() ),
			'fields' => 'ids',
			'meta_query' => array(
				'relation' => 'AND',
				array(
					'relation' => 'OR',
					array(
						'key'   => 'tracking_website',
						'compare' => 'NOT EXISTS',
					),
					array(
						'key'   => 'tracking_number',
						'compare' => 'NOT EXISTS',
					)
				),
				array(
					'key'   => 'supplier_'.$supplier->term_id,
					'value' => $supplier->name,
					'compare' => '=',
				)
			)
		) );

		$classOjb = new WC_Dropshipping_Orders();
		$csv_path = $classOjb->make_directory('supplier_'.$supplier->term_id);
		$filepath = $csv_path.'/supplier_'.$supplier->term_id.'.csv';
		$file = fopen($filepath, 'w+');

		$headers = array(
			'Order ID',
			'ASIN Number',
			'SKU Name',
			'QTY',
			'Country',
			'State/Provine',
			'City',
			'Shippig Address',
			'POSTCODE',
			'Recevier Name',
			'Phone Number',
			'Tracking number',
			'Tracking Web'
		);

		fputcsv( $file, $headers );

		foreach ($customer_orders as $orderID) {
			$order = wc_get_order($orderID);
			foreach ( $order->get_items() as $item_id => $item ) {
				$product_id = $item->get_product_id();
				$productName = $item->get_name();
				$product_sku = get_post_meta( $product_id, '_sku', true );
			}
			$country = WC()->countries->countries[ $order->get_billing_country() ];
			$states = WC()->countries->get_states( $order->get_billing_country() );
			$state = ! empty( $states[ $order->get_billing_state() ] ) ? $states[ $order->get_billing_state() ] : '';

			fputcsv($file, array(
				$orderID,
				$product_sku,
				$productName,
				$order->get_item_count(),
				$country,
				$state,
				$order->get_billing_city(),
				$order->get_billing_address_1(),
				$order->get_billing_postcode(),
				$order->get_formatted_billing_full_name(),
				$order->get_billing_phone(),
				'',
				''
			));
		}
		fclose($file);
		$headers = array('Content-Type: text/html; charset=UTF-8');
		$headers[] = 'Cc: patrick.kalns@mcaffic.com';
		wp_mail( $suppMeta['order_email_addresses'], 'Your Order List', 'Please check your order list attached.',$headers, $filepath);
		//wp_mail( 'kishan@techtic.com', 'Daily email once testing', 'Daily email once testing', '', $filepath);
	}
}

function register_import_order_csv_menu_page(){
	add_menu_page(
		__( 'Custom Menu Title', 'textdomain' ),
		'Import Order Csv',
		'dropshipper',
		'custompage',
		'import_order_csv_menu_page',
		'dashicons-database-import',
		6
	);
}
add_action( 'admin_menu', 'register_import_order_csv_menu_page' );

function import_order_csv_menu_page(){
	echo '<div class="wrap">
			<h1>Import Order CSV</h1>
			<div class="message"></div>
			<div id="dashboard-widgets" class="metabox-holder">
			<div id="dashboard_quick_press" class="postbox">
				<div class="postbox-header">
					<h2 class="hndle ui-sortable-handle">
						<span class="hide-if-no-js">Upload CSV File</span>
					</h2>
				</div>
				<div class="inside">
				<form name="update_csv_data" id="update_csv_data" class="update_csv_data" action="" method="post" enctype="multipart/form-data">
					<div class="input-text-wrap">
						<input type="file" name="order_csv" id="order_csv" required>
					</div>
					<p class="submit" style="margin-top: 12px; display: inline-block;">
						<span class="spinner" style="display: inline-block;"></span>
						<input type="submit" value="submit" class="button button-primary" name="Submit">
					</p>
				</form>
				</div>
			</div>
			</div>
		</div>';
	?>
	<script type="text/javascript">
		jQuery( "#update_csv_data" ).submit(function( event ) {
			event.preventDefault();
			var file_data = jQuery('#order_csv').prop('files')[0];
			form_data = new FormData();
			form_data.append('file', file_data);
			form_data.append('action', 'update_csv_data');

			jQuery.ajax({
				type: 'POST',
				url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
				data: form_data,
				processData: false,
				contentType: false,
				beforeSend: function(){
					jQuery('.spinner').addClass('is-active');
					jQuery('.submit input').addClass('disabled');
				},
				success: function(data) {
					jQuery('.message').html('<div id="message" class="updated notice notice-success is-dismissible"><p>'+data.message+'</p></div>');
					jQuery('#update_csv_data')[0].reset();
				},
				error: function(errorThrown){
					jQuery('.message').html('<div id="message" class="updated notice notice-error is-dismissible"><p>'+data.message+'</p></div>');
				},
				complete: function(){
					jQuery('.spinner').removeClass('is-active');
					jQuery('.submit input').removeClass('disabled');
				}
			})
		});
	</script>

	<?php
}

function wpse28782_remove_menu_items() {
    if( !current_user_can( 'administrator' ) ):
        remove_menu_page( 'wpcf7' );
    endif;
}
add_action( 'admin_menu', 'wpse28782_remove_menu_items' );

add_action('wp_ajax_update_csv_data', 'update_csv_data');
add_action('wp_ajax_nopriv_update_csv_data', 'update_csv_data');
function update_csv_data() {
	$file = $_FILES['file'];
	$uploaded_file = wp_handle_upload($file, array('test_form' => false));

	if ( $uploaded_file && !isset( $uploaded_file['error'] ) ) {
		$row = 1;
		if (($handle = fopen($uploaded_file['file'], "r")) !== FALSE) {
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
				$num = count($data);
				$row++;
				$trackingInfo = array('date' => '',
					'tracking_number' => $data[11],
					'shipping_company' => $data[12],
					'notes' => ''
				);
				update_post_meta($data[0], 'dropshipper_shipping_info_' . get_current_user_id(), $trackingInfo);
				update_field('tracking_number', $data[11], $data[0]);
				update_field('tracking_website', $data[12], $data[0]);

				//Update order status code added 4.12.2020
				if(!empty($data[11]) && !empty($data[12])){
					$order_id = $data[0];
					$order = new WC_Order($order_id);
					$order->update_status('completed', 'order_note');
				}
			}
			fclose($handle);
		}
		wp_send_json(['status' => 200, 'message' => 'Tracking detail updated successfully.']);
	} else {
		wp_send_json(['status' => 400, 'message' => 'Something went wrong please try again.']);
	}
	wp_delete_file( $uploaded_file['file'] );
	wp_die();
}

add_action('wp_ajax_track_cutomer_order', 'track_cutomer_order');
add_action('wp_ajax_nopriv_track_cutomer_order', 'track_cutomer_order');
function track_cutomer_order() {
	if ( $order = wc_get_order($_POST['orderID']) ) {
		if ($order->get_billing_email() == $_POST['order_email']) {
			$trackNumbr = get_field('tracking_number', $_POST['orderID']);
			$trackWeb = get_field('tracking_website', $_POST['orderID']);
			$msg = '<div class="alert alert-success" role="alert">Track your order here: <a target="_blank" href="'.$trackWeb.'"><strong>'.$trackWeb.'</strong></a></br></br>Tracking number: <strong>'.$trackNumbr.'</strong></div>';
		}
		else {
			$msg = '<div class="alert alert-warning" role="alert"><strong>'.$_POST['order_email'].' </strong>Email address does not exist.</div>';
		}
	}
	else {
		$msg = '<div class="alert alert-warning" role="alert"><strong>#'.$_POST['orderID'].'</strong> Order number does not exist.</div>';
	}
	wp_send_json(['message' => $msg]);

	wp_die();
}

/* ============= Dropshipping tracking module end ============= */

// Remove fields from Admin profile page
if ( ! function_exists( 'cor_remove_personal_options' ) ) {
    function cor_remove_personal_options( $subject ) {
        $subject = preg_replace('#<table class="form-table" id="afwc">(.*?)</table>#s', '', $subject, 1);
        $subject = preg_replace('#<h2 id="afwc-settings">(.*?)</h2>#s', '', $subject, 1);
        return $subject;
    }

    function cor_profile_subject_start() {
        if ( ! current_user_can('manage_options') ) {
            ob_start( 'cor_remove_personal_options' );
        }
    }

    function cor_profile_subject_end() {
        if ( ! current_user_can('manage_options') ) {
            ob_end_flush();
        }
    }
}
add_action( 'admin_head', 'cor_profile_subject_start' );
add_action( 'admin_footer', 'cor_profile_subject_end' );

add_action( 'wp_before_admin_bar_render', function() {
    global $wp_admin_bar;
	if ( ! current_user_can('manage_options') ) {
    	$wp_admin_bar->remove_node( 'new-content' );
    	$wp_admin_bar->remove_menu('comments');
	}
},999);

add_action( 'woocommerce_thankyou', 'conversion_tracking_thank_you_page' );
function conversion_tracking_thank_you_page($order_id) {
	$order = wc_get_order( $order_id );
	$items = $order->get_items();
	foreach ( $items as $item ) {
		$product_id = $item->get_product_id();
		echo get_field( 'iframe_pixel', $product_id );
	}
}

// Add a new interval of 180 seconds
// See http://codex.wordpress.org/Plugin_API/Filter_Reference/cron_schedules
/* add_filter( 'cron_schedules', 'isa_add_every_three_minutes' );
function isa_add_every_three_minutes( $schedules ) {
    $schedules['every_three_minutes'] = array(
            'interval'  => 180,
            'display'   => __( 'Every 3 Minutes', 'textdomain' )
    );
    return $schedules;
}

// Schedule an action if it's not already scheduled
if ( ! wp_next_scheduled( 'isa_add_every_three_minutes' ) ) {
    wp_schedule_event( time(), 'every_three_minutes', 'isa_add_every_three_minutes' );
}

// Hook into that action that'll fire every three minutes
add_action( 'isa_add_every_three_minutes', 'every_three_minutes_event_func' );
function every_three_minutes_event_func() {
    wp_mail( 'kishan@techtic.com', 'Automatic email', 'Automatic scheduled email from WordPress.');
} */

add_shortcode( 'rand', 'countdown_rand_func' );
function countdown_rand_func( $atts ) {
    return rand(49,99);
}

// Added Warranty to confirmations email.
add_action( 'woocommerce_order_item_meta_end', 'waf_order_item_meta_end', 10, 4 );
function waf_order_item_meta_end( $item_id, $item, $order, $plain_text ){
	$status = $order->status; 
	if($status == 'processing'){
	$name = $value = $expiry = false;
	$order_id  = $order->get_id(); 
	$order      = wc_get_order( $order_id );
	$product_warranty = warranty_get_product_warranty( $item['product_id'] );
    $warranty['label'] = $product_warranty['label'];
   //code added
	if ( empty( $warranty['label'] ) ) {
		$product_warranty = warranty_get_product_warranty( $item['product_id'] );
		$warranty['label'] = $product_warranty['label'];
	}
	if ( $product_warranty['type'] == 'addon_warranty' ) {
	$addons = $product_warranty['addons'];
	$warranty_index = wc_get_order_item_meta( $item_id, '_item_warranty_selected', true );
	if ( $warranty_index !== false && isset($addons[$warranty_index]) && !empty($addons[$warranty_index]) ) {
	    $addon  = $addons[$warranty_index];
	    $name   = $warranty['label'];
	    $value  = $GLOBALS['wc_warranty']->get_warranty_string( $addon['value'], $addon['duration'] );
	}
	} elseif ( $product_warranty['type'] == 'included_warranty' ) {
		if ( $warranty['length'] == 'limited' ) {
		    $name   = $warranty['label'];
		    $value  = $GLOBALS['wc_warranty']->get_warranty_string( $product_warranty['value'], $product_warranty['duration'] );
		}
	}
	if ( !$name || ! $value ) {
    return;
	}
	?>

	<table cellspacing="0" class="display_meta">
	    <tr>
	        <th><?php echo wp_kses_post( $name ); ?>:</th>
	        <td><?php
	            echo wp_kses_post( $value );
	        ?></td>
	    </tr>
	</table>
	<?php
  }
}


//Code added for status filter
function wa_get_order_statuses() {
  $order_statuses = array(
    'wc-pending'    => _x( 'Pending payment', 'Order status', 'woocommerce' ),
    'wc-processing' => _x( 'Processing', 'Order status', 'woocommerce' ),
    'wc-completed'  => _x( 'Completed', 'Order status', 'woocommerce' ),
  );
  return apply_filters( 'wa_order_statuses', $order_statuses );
}