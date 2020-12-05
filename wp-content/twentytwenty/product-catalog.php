<?php
/* Template name: Product Catalog */
get_header();
?>

<link href="<?php echo get_theme_file_uri( '/assets/css/product_catalog_style.css' ); ?>" rel="stylesheet">
<link href="<?php echo get_theme_file_uri( '/assets/css/product_catalog_media.css' ); ?>" rel="stylesheet">
<?php
function tabProductHtml() {
	$tabProductData = wc_get_product(get_the_ID());
	?>
	<div class="prod-main">
		<figure class="prod-img">
			<a href="<?php echo get_the_permalink(); ?>" target="_blank">
				<img src="<?php echo get_the_post_thumbnail_url( get_the_ID(), 'post-thumbnail' ); ?>" alt="<?php echo get_the_title(); ?>">
			</a>
		</figure>
		<div class="prod-cont">
			<div class="prod-title"><?php echo get_the_title(); ?></div>
			<?php if($tabProductData->is_type( 'variable' )){?>
				<div class="prod-price">
					<span>from</span>
					<span class="price-in">
						<strong><?php echo get_woocommerce_currency_symbol().$tabProductData->get_variation_price('min', true);?></strong>
					</span>
				</div>
			<?php }else { ?>
				<div class="prod-price">
					<div class="price-in">
						<strong><?php echo get_woocommerce_currency_symbol().$tabProductData->get_price();?></strong>
					</div>
				</div>
			<?php } ?>
		</div>
		<a href="<?php echo get_the_permalink(); ?>" class="button btn-yellow" target="_blank">Add to cart</a>
	</div>
<?php } 

$tax_query[] = array(
	'taxonomy' => 'product_visibility',
	'field'    => 'name',
	'terms'    => 'featured',
	'operator' => 'IN',
);

$featuredQuery = new WP_Query( array(
	'post_type'		 => 'product',
	'post_status'	 => 'publish',
	'posts_per_page' => 4,
	'orderby'		 => 'date',
	'order'			 => 'desc',
	'tax_query'		 => $tax_query
) );

?>

<?php if ( have_rows('product_catalog_flexible_content') ): ?>
   	<?php while( have_rows('product_catalog_flexible_content') ): the_row(); ?>

   		<?php if( get_row_layout() == 'product_tab_section' ){
   			$product_tab = get_sub_field('product_tab');
   			if($product_tab){
			$argsRecent = array(
				'posts_per_page' => 8,
				'post_status'    => 'publish',
				'post_type'      => 'product',
				'orderby'        => 'date',
				'order'          => 'desc',
			);
			$recentQuery = new WP_Query( $argsRecent );

			$argsMore = array(
				'posts_per_page' => 8,
				'post_status'    => 'publish',
				'post_type'      => 'product',
				'orderby'        => 'date',
				'order'          => 'ASC'
			);
			$moreQuery = new WP_Query( $argsMore );

   			?>
   			<div class="middle-content">
				<div class="container">
		   			<div class="products-tab">
						<div id="tabs" class="prod-tab">
							<nav>
								<div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
									<a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true"><?php echo get_sub_field('tab_1_title'); ?></a>
									<a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false"><?php echo get_sub_field('tab_2_title'); ?></a>
									<a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false"><?php echo get_sub_field('tab_3_title'); ?></a>
								</div>
							</nav>
							<div class="tab-content" id="nav-tabContent">
								<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
									<div class="prod-outer">
										<?php if ( $featuredQuery->have_posts() ) {
											while ( $featuredQuery->have_posts() ) : $featuredQuery->the_post();
												echo tabProductHtml();
											endwhile;
											wp_reset_query();
										}
										else {
											echo __( 'No products found' );
										} ?>
									</div>
								</div>
								<div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
									<div class="prod-outer">
										<?php if ( $recentQuery->have_posts() ) {
											while ( $recentQuery->have_posts() ) : $recentQuery->the_post();
												echo tabProductHtml();
											endwhile;
											wp_reset_query();
										}
										else {
											echo __( 'No products found' );
										} ?>
									</div>
								</div>
								<div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
									<div class="prod-outer">
										<?php if ( $moreQuery->have_posts() ) {
											while ( $moreQuery->have_posts() ) : $moreQuery->the_post();
												echo tabProductHtml();
											endwhile;
											wp_reset_query();
										}
										else {
											echo __( 'No products found' );
										} ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>


   		<?php } else if( get_row_layout() == 'hero_product_section' ){
			$hero_background_color = get_sub_field('hero_background_color');
			$hero_text_position = get_sub_field('hero_text_position');
			if($hero_text_position == 'text_left'){
			?>
   			<section class="blue-box-sec">
				<div class="container">
					<div class="blue-box blue-block-2" style="background-color: <?php echo $hero_background_color;?>">
						<div class="row align-items-center">
							<div class="col-md-8 col-sm-6">
								<div class="inner-blue-box">
									<div class="title-big"><?php the_sub_field('hero_tag_line');?></div>
									<div class="subtitle"><?php the_sub_field('hero_sub_tag_line');?></div>
									<a href="<?php echo get_permalink(get_sub_field('select_product')) ?>" target="_blank" class="button btn-yellow">shop now</a>
								</div>
							</div>
							<div class="col-md-4 col-sm-6">
								<div class="wrapper-banner">
									<img src="<?php the_sub_field('hero_image');?>">
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>

		<?php } else{ ?>

			<section class="blue-box-sec">
				<div class="container">
					<div class="blue-box blue-block-2" style="background-color: <?php echo $hero_background_color;?>">
						<div class="row align-items-center">
							<div class="col-md-6 col-sm-6">
								<div class="wrapper-banner">
									<img src="<?php the_sub_field('hero_image');?>">
								</div>
							</div>
							
							<div class="col-md-6 col-sm-6">
								<div class="wrapper-left-block">
									<div class="left-block">
										<div class="title-big"><?php the_sub_field('hero_tag_line');?></div>
										<div class="subtitle"><?php the_sub_field('hero_sub_tag_line');?></div>
										<a href="<?php echo get_permalink(get_sub_field('select_product')) ?>" target="_blank" class="button btn-yellow">shop now</a>
									</div>
									<div class="white-block white-block-blue"><div class="top-text">50
									<span class="top-text-min">%</span></div> <div class="bottom-text">off</div></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>

		<?php } ?>


   		<?php } else if( get_row_layout() == 'two_product_section' ){ 
   			$product_left = get_sub_field('product_left');
   			$product_left_title_color = get_sub_field('product_left_title_color');
   			$product_left_background_image = get_sub_field('product_left_background_image');
   			$product_right = get_sub_field('product_right');
   			$product_right_title_color = get_sub_field('product_right_title_color');
   			$product_right_background_image = get_sub_field('product_right_background_image');

   			?>
   			<section class="deal-sec">
				<div class="container">
					<div class="row deal-line">
						<div class="col-lg-4 col-sm-4 deals-col order-last">
							<div class="deals-big-block">
								<a href="<?php echo get_permalink($product_right->ID);?>" target="_blank"><img src="<?php echo $product_right_background_image;?>"></a>
								<div class="deals-left">
									<div class="deals-title" style="<?php echo ($product_right_title_color) ? 'color: '.$product_right_title_color : ''; ?>"><?php echo $product_right->post_title; ?></div>
									<a href="<?php echo get_permalink($product_right->ID);?>" target="_blank" class="button btn-yellow">shop now</a>
								</div>
							</div>
						</div>
						
						<div class="col-lg-8 col-sm-8 deals-col order-fst">
							<div class="deals-big-block">
								<a href="<?php echo get_permalink($product_left->ID);?>" target="_blank"><img src="<?php echo $product_left_background_image;?>"></a>
								<div class="deals-left">
									<div class="deals-title" style="<?php echo ($product_left_title_color) ? 'color: '.$product_left_title_color : ''; ?>"><?php echo $product_left->post_title; ?></div>
									<a href="<?php echo get_permalink($product_left->ID);?>" target="_blank" class="button btn-yellow">shop now</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>

   		<?php } else if( get_row_layout() == 'is_product_list' ){ ?>

			<?php 
			$display_product_list = get_sub_field('display_product_list');
			if($display_product_list){ ?>

				<section class="mn-product-sec">
					<div class="container">
						<h3><?php echo get_sub_field('section_title'); ?></h3>
						<div class="main-prod-wrapper">
							<?php  
						    $args = array(
						        'post_type'      => 'product',
						        'posts_per_page' => -1
						    );

						    $loop = new WP_Query( $args );
						    while ( $loop->have_posts() ) : $loop->the_post();
						    	$featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'full');
						    	$product = wc_get_product( get_the_ID() );
						    ?>
							<div class="prod-main">
								<a href="<?php echo get_permalink(get_the_ID())?>" class="prod-img" target="_blank" >
									<img src="<?php echo $featured_img_url;?>" alt="">
								</a>
								<div class="prod-cont">
									<div class="prod-title"><?php echo get_the_title();?></div>
									<?php if($product->is_type( 'variable' )){?>
										<div class="prod-price">
											<span>from</span>
											<span class="price-in">
												<strong><?php echo get_woocommerce_currency_symbol().$product->get_variation_price('min', true);?></strong>
											</span>
										</div>
									<?php }else { ?>
										<div class="prod-price">
											<div class="price-in">
												<strong><?php echo get_woocommerce_currency_symbol().$product->get_price();?></strong>
											</div>
										</div>
									<?php } ?>
								</div>
								<a href="<?php echo get_permalink(get_the_ID())?>" class="button btn-yellow" target="_blank">Add to cart</a>
							</div>
							<?php endwhile; wp_reset_query();?>
						</div>
						
					</div>
				</section>

			<?php } ?>

   		<?php }
		else if( get_row_layout() == 'featured_products' ){
			$display_featured_products = get_sub_field('display_featured_products');
			if($display_featured_products){ ?>
				<section class="mn-product-sec">
					<div class="container">
						<h3><?php echo get_sub_field('section_title'); ?></h3>
						<div class="main-prod-wrapper">
							<?php
						    while ( $featuredQuery->have_posts() ) : $featuredQuery->the_post();
						    	$featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'full');
						    	$product = wc_get_product( get_the_ID() );
						    ?>
							<div class="prod-main">
								<a href="<?php echo get_permalink(get_the_ID())?>" class="prod-img" target="_blank">
									<img src="<?php echo $featured_img_url;?>" alt="">
								</a>
								<div class="prod-cont">
									<div class="prod-title"><?php echo get_the_title();?></div>
									<?php if($product->is_type( 'variable' )){?>
										<div class="prod-price">
											<span>from</span>
											<span class="price-in">
												<strong><?php echo get_woocommerce_currency_symbol().$product->get_variation_price('min', true);?></strong>
											</span>
										</div>
									<?php }else { ?>
										<div class="prod-price">
											<div class="price-in">
												<strong><?php echo get_woocommerce_currency_symbol().$product->get_price();?></strong>
											</div>
										</div>
									<?php } ?>
								</div>
								<a href="<?php echo get_permalink(get_the_ID())?>" class="button btn-yellow" target="_blank">Add to cart</a>
							</div>
							<?php endwhile; wp_reset_query();?>
						</div>
					</div>
				</section>
			<?php }
		} else if( get_row_layout() == 'features_section' ) {
			if( have_rows('features') ): ?>
			<section class="features_section">
				<div class="container">
					<div class="main_fe">
						<div class="row">
							<?php while( have_rows('features') ) : the_row(); ?>
								<div class="col-md-3">
									<img src="<?php echo get_sub_field('image_icon'); ?>">
									<p><?php echo get_sub_field('title'); ?></p>
								</div>
							<?php endwhile; ?>
						</div>
					</div>
				</div>
			</section>
			<?php endif;
		} 
   	endwhile; ?>
<?php endif; ?>

<script src="<?php echo get_theme_file_uri( '/assets/js/bootstrap.min.js' ); ?>"> </script>
<script>
jQuery(document).ready(function() {
	jQuery(".search-input").on("keyup", function() {
		var value = this.value.toLowerCase().trim();
		jQuery(".prod-main").show().filter(function() {
			return jQuery(this).text().toLowerCase().trim().indexOf(value) == -1;
		}).hide();
	});
});	
</script>

<?php get_footer(); ?>