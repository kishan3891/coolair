<?php

/* Template Name: Test Functionality */
test_func();

function test_func() {
	$suppliers = get_terms('dropship_supplier');
	foreach($suppliers as $supplier) {
		$suppMeta = get_term_meta($supplier->term_id, 'meta', true);
		$user_spp = get_user_by( 'email', $suppMeta['order_email_addresses'] );
		echo 'User is ' . $user_spp->id . ' ' . $user_spp->last_name;
		// print_r($suppMeta);
		// exit();
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
			$order  = wc_get_order($orderID);
			$status = $order->get_status();

			echo $orderID;
			echo $status;
			echo '<br>';
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
		//echo $filepath;
		$headers = array('Content-Type: text/html; charset=UTF-8');
		$headers[] = 'Cc: techtic.adnan@gmail.com';
		// wp_mail( $suppMeta['order_email_addresses'], 'cron test', 'cron test', '', $filepath);
		wp_mail( 'techtic.adnan1@gmail.com', 'cron test', 'cron test',$headers, $filepath);
	}
}


// wp_schedule_single_event(time() + 600, 'order_csv_email');
// add_action('order_csv_email', 'do_this_once_daily', 10, 1);
// function do_this_once_daily() {
// 	$order_args = array(
// 		'posts_per_page' => -1,
// 		'post_status'    => 'publish',
// 		'post_type'      => 'shop_order',
// 		'orderby'        => 'date',
// 		'order'          => 'ASC'
// 	);
// 	$orderQuery = new WP_Query( $order_args );

// 	wp_mail( 'techtic.irfan@gmail.com', 'cron test', 'cron test');
// }
	// update_field('tracking_website', 'test.com', 922);
	// update_field('tracking_number', '1234567890', 922);

?>