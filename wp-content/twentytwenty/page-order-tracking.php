<?php
/* Template Name: Order Tracking */

get_header();
?>

<section class="order_tracking">
	<div class="container">
		<form name="track_order" id="track_order" class="track_order" method="post">
			<label for="order_number">Order Number#</label>
			<input type="text" name="order_number" id="order_number" required="true">
			<label for="order_email">Order Email Address</label>
			<input type="email" name="order_email" id="order_email" required="true">
			<div class="submit_area">
				<input type="submit" name="submit" value="Track Order">
				<img src="<?php echo get_template_directory_uri(); ?>/assets/images/loader.gif" class="ajax_loader">
			</div>
		</form>
		<div class="track_detail"></div>
	</div>
</section>

<script type="text/javascript">
	jQuery( "#track_order" ).submit(function( event ) {
		event.preventDefault();
		var orderID = jQuery('#order_number').val();
		var order_email = jQuery('#order_email').val();

		jQuery.ajax({
			type: 'POST',
			url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
			data: {action: 'track_cutomer_order', orderID: orderID, order_email: order_email},
			beforeSend: function(){
				jQuery('.ajax_loader').css('display', 'inline-block');
				jQuery( '.submit_area input' ).prop( "disabled", true );
			},
			success: function(data) {
				jQuery('.track_detail').html(data.message);
				jQuery('#track_order')[0].reset();
			},
			error: function(errorThrown){
				jQuery('.track_detail').html('<p class="error">Something went wrong please try again!.</p>');
			},
			complete: function(){
				jQuery('.ajax_loader').hide();
				jQuery( '.submit_area input' ).prop( "disabled", false );
			}
		})
	});
</script>

<?php get_footer();