<?php
/* Template name: Template - 2 */

get_header();

$page_id = get_the_ID();

$banner_as_pre_designed = get_field('banner_as_pre_designed', $page_id);
$banner_background = get_field('banner_background', $page_id);
$banner_back_img = get_field('banner_background_image', $page_id);
$banner_mobile_back_img = get_field('banner_mobile_background_image', $page_id);
$banner_back_color = get_field('banner_background_color', $page_id);
$bnrr_class = $bnrr_back = $bnrr_mobile_back = '';

if ($banner_as_pre_designed == true) {
	$pre_designed_banner_image_desktop = get_field('pre_designed_banner_image_desktop', $page_id);
	$pre_designed_banner_image_mobile = get_field('pre_designed_banner_image_mobile', $page_id);
	$bnrr_back = 'background: none';
	$bnrr_mobile_back = 'background: none';
	$bnrr_class = 'predesigned';
	$btn_class = get_field('banner_cta_position', $page_id);
}
else if ($banner_background == 'image') {
	$bnrr_back = 'background: url('.$banner_back_img.')';
	$bnrr_mobile_back = 'background: url('.$banner_mobile_back_img.')';
}
else if ($banner_background == 'color') {
	$bnrr_back = 'background: '.$banner_back_color;
}
?>
<link href="<?php echo get_theme_file_uri( '/assets/css/template2.css' ); ?>" rel="stylesheet">
<link href="<?php echo get_theme_file_uri( '/assets/css/template2-media.css' ); ?>" rel="stylesheet">

<header> 
	<div class="container">
		<a href="#" class="wow flash" style="visibility: visible; animation-name: flash"><img src="<?php the_field('header_logo', $page_id);?>" alt=""></a>
	</div>
</header>

<div class="main-banner wow fadeInUp is-desktop <?php echo $bnrr_class; ?>" style="visibility: visible; animation-name: fadeInUp; <?php echo $bnrr_back; ?>">
	<?php if ($banner_as_pre_designed) {
		echo '<img class="desk" src="'.$pre_designed_banner_image_desktop.'">';
		echo '<img class="mob" src="'.$pre_designed_banner_image_mobile.'">';
		echo '<div class="cart-btn discount-btn wow flash '.$btn_class.'">
			<a href="'.get_field('banner_cta_link', $page_id).'">'.get_field('banner_cta_text', $page_id).'</a>
		</div>';
	}
	else { ?>
		<div class="banner-left-img wow fadeInLeft" style="visibility: visible; animation-name: fadeInLeft" data-wow-delay="0.3s">
			<div class="top-line">
				<h3> <?php the_field('banner_top_tag_line', $page_id);?> </h3>
			</div>
			<div class="second-line">
				<h1> <span><?php the_field('banner_discount_text', $page_id);?> </span> <?php the_field('banner_discount_amount', $page_id);?></h1>
				<h2><?php the_field('banner_last_change_text', $page_id);?></h2>
			</div>
			<div class="third-line">
				<?php the_field('banner_bottom_tag_line', $page_id);?>
				<a href="<?php the_field('banner_cta_link', $page_id);?>"><?php the_field('banner_cta_text', $page_id);?></a>
			</div>
		</div>
		<div class="banner-right-img wow fadeInRight" style="visibility: visible; animation-name: fadeInRight" data-wow-delay="0.3s">
			<figure><img src="<?php the_field('banner_right_image', $page_id);?>" alt=""> </figure>
		</div>
	<?php } ?>
</div>

<div class="main-banner wow fadeInUp is-mobile <?php echo $bnrr_class; ?>" style="visibility: visible; animation-name: fadeInUp; <?php echo $bnrr_mobile_back; ?>">
	<?php if ($banner_as_pre_designed) {
		echo '<img class="desk" src="'.$pre_designed_banner_image_desktop.'">';
		echo '<img class="mob" src="'.$pre_designed_banner_image_mobile.'">';
		echo '<div class="cart-btn discount-btn wow flash '.$btn_class.'">
			<a href="'.get_field('banner_cta_link', $page_id).'">'.get_field('banner_cta_text', $page_id).'</a>
		</div>';
	}
	else { ?>
		<div class="banner-left-img wow fadeInLeft" style="visibility: visible; animation-name: fadeInLeft" data-wow-delay="0.3s">
			<div class="top-line">
				<h3> <?php the_field('banner_top_tag_line', $page_id);?> </h3>
			</div>
			<div class="second-line">
				<h1> <span><?php the_field('banner_discount_text', $page_id);?> </span> <?php the_field('banner_discount_amount', $page_id);?></h1>
				<h2><?php the_field('banner_last_change_text', $page_id);?></h2>
			</div>
			<div class="third-line">
				<?php the_field('banner_bottom_tag_line', $page_id);?>
				<a href="<?php the_field('banner_cta_link', $page_id);?>"><?php the_field('banner_cta_text', $page_id);?></a>
			</div>
		</div>
		<div class="banner-right-img wow fadeInRight" style="visibility: visible; animation-name: fadeInRight" data-wow-delay="0.3s">
			<figure><img src="<?php the_field('banner_right_image', $page_id);?>" alt=""> </figure>
		</div>
	<?php } ?>
</div>

<?php if ( have_rows('beginning_section_on_landing_page') ): ?>
   	<?php while( have_rows('beginning_section_on_landing_page') ): the_row(); ?>
   		<?php if( get_row_layout() == 'text_block' ){ ?>
			<div class="landing-about wow fadeInUp" style="<?php echo 'background:'.get_sub_field('background', $page_id); ?>">
				<div class="container">
					<?php the_sub_field('text_content');?>
				</div>
			</div>
	<?php } else if( get_row_layout() == 'cta_block' ){
			$is_icon = get_sub_field('is_icon');
			if($is_icon){
				$icon = '<i><img src="'.get_theme_file_uri('assets/images/template-2/cart-ic.svg').'" alt=""></i>';
			}
			?>
			<div class="bottom_section_cta" style="<?php echo 'background:'.get_sub_field('background', $page_id); ?>">
				<div class="cart-btn wow fadeInUp" style="visibility: visible; animation-name: fadeInUp" data-wow-delay="400ms">
					<a href="<?php the_sub_field('cta_link');?>"><?php echo $icon;?> <?php the_sub_field('cta_text');?></a>
				</div>
			</div>
		<?php } else if( get_row_layout() == 'image_block' ) { ?>
			<div class="img-box btm_sec wow fadeInUp" style="<?php echo 'background:'.get_sub_field('background', $page_id); ?>" data-wow-delay="100ms">
				<div class="container">
					<figure><img src="<?php the_sub_field('image');?>" alt=""></figure>
				</div>
			</div>
		<?php } else if( get_row_layout() == 'image_with_text_block' ){
			$text_style = get_sub_field( "text_style");
			if($text_style == 'text_left'){
				$style_cls = 'img-cont';
			}else if($text_style == 'text_right'){
				$style_cls = 'img-title';
			}else if($text_style == 'text_full'){
				$style_cls = 'img-desc';
			} ?>
			<div class="img-box btm_sec wow fadeInUp" style="<?php echo 'background:'.get_sub_field('background', $page_id); ?>" data-wow-delay="100ms">
				<div class="container">
					<div class="extra">
						<figure><img src="<?php the_sub_field('image');?>" alt=""></figure>
						<div class="<?php echo $style_cls?>">
							<?php the_sub_field('image_text');?>
						</div>
					</div>
				</div>
			</div>
		<?php } else if( get_row_layout() == 'video_block' ){?>
			<div class="iframe-cls btm_sec" style="<?php echo 'background:'.get_sub_field('background', $page_id); ?>">
				<div class="container">
					<video class="video" controls>
						<source src="<?php the_sub_field('video_url');?>" type="video/mp4" />
					</video>
				</div>
			</div>
		<?php } else if( get_row_layout() == 'rating_block' ){?>
			<section class="bottom_user_rat" style="<?php echo 'background:'.get_sub_field('background', $page_id); ?>">
				<div class="container">
				<h3><?php echo get_sub_field('section_title'); ?></h3>
			<?php if( have_rows('user_rating') ){
			while ( have_rows('user_rating') ) : the_row(); 
				$rating = get_sub_field('rating');?>
			<div class="client-review-box wow fadeInUp" style="visibility: visible; animation-name: fadeInUp" data-wow-delay="400ms">
				<div class="client-review-box-left">
					<figure><img src="<?php the_sub_field('image');?>" alt=""></figure>
					<div class="client-cont">
					<h4> <?php the_sub_field('name');?></h4>
					<p><?php the_sub_field('rating_date');?></p>
					<ul>
						<?php for ( $i = 0; $i < $rating; $i++ ) { ?>
							<li><a href="#"><i class="fa fa-star"></i></a></li>
						<?php }?>
					</ul>
					</div>
				</div>
				<div class="client-review-box-right">
					<p><?php the_sub_field('rating_content');?></p>
					<?php
					if (get_sub_field('is_rating_images')) {
						if( have_rows('rating_images') ){ ?>
						<ul>
							<?php while ( have_rows('rating_images') ) : the_row();?>
							<li><img src="<?php the_sub_field('rating_image');?>" alt=""> </li>
							<?php endwhile;?>
						</ul>
						<?php }
					} ?>
				</div>
			</div>
			<?php endwhile; } ?>
		</div>
		</section>

		<?php } else if( get_row_layout() == 'left_right_image_content' ){ ?>
			<section class="left_right_img_cont img_<?php echo get_sub_field('image_position', $page_id); ?>" style="<?php echo 'background:'.get_sub_field('background', $page_id); ?>">
				<div class="container">
					<div class="row align-items-<?php echo get_sub_field('vertically_content_alignment', $page_id); ?>">
						<div class="col-md-6">
							<figure>
								<img src="<?php echo get_sub_field('image'); ?>">
							</figure>
						</div>
						<div class="col-md-6">
							<div class="l_r_contnt">
								<?php echo get_sub_field('content'); ?>
							</div>
						</div>
					</div>
				</div>
			</section>
		<?php }
	endwhile;
endif; ?>

<section class="middle-content wow fadeInUp" style="visibility: visible; animation-name: fadeInUp">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-md-6">
				<div class="main-left-cont">
					<!-- <h3>What Others are Saying...</h3> -->
					<?php if ( have_rows('left_section_of_landing_page') ): ?>
   						<?php while( have_rows('left_section_of_landing_page') ): the_row(); ?>

   							<?php if( get_row_layout() == 'image_block' ) { ?>
   								<div class="img-box wow fadeInUp" style="visibility: visible; animation-name: fadeInUp" data-wow-delay="100ms">
									<figure><img src="<?php the_sub_field('image');?>" alt=""></figure>
								</div>
   							<?php } else if( get_row_layout() == 'image_with_text_block' ){
   									$text_style = get_sub_field( "text_style");
   									if($text_style == 'text_left'){
   										$style_cls = 'img-cont';
   									}else if($text_style == 'text_right'){
   										$style_cls = 'img-title';
   									}else if($text_style == 'text_full'){
   										$style_cls = 'img-desc';
   									}
   								?>
   								<div class="img-box wow fadeInUp" style="visibility: visible; animation-name: fadeInUp" data-wow-delay="100ms">
									<figure><img src="<?php the_sub_field('image');?>" alt=""></figure>
									 <div class="<?php echo $style_cls?>">
										<?php the_sub_field('image_text');?>
									 </div>
								</div>

   							<?php } else if( get_row_layout() == 'rating_block' ){?>
   								<h3><?php echo get_sub_field('section_title'); ?></h3>
   								<div class="client-review-outer">
									<?php if( have_rows('user_rating') ){
									while ( have_rows('user_rating') ) : the_row(); 
										$rating = get_sub_field('rating');?>
									<div class="client-review-box wow fadeInUp" style="visibility: visible; animation-name: fadeInUp" data-wow-delay="400ms">
										<div class="client-review-box-left">
											<figure><img src="<?php the_sub_field('image');?>" alt=""></figure>
											<div class="client-cont">
											<h4> <?php the_sub_field('name');?></h4>
											<p><?php the_sub_field('rating_date');?></p>
											<ul>
												<?php for ( $i = 0; $i < $rating; $i++ ) { ?>
													<li><a href="#"><i class="fa fa-star"></i></a></li>
												<?php }?>
											</ul>
											</div>
										</div>
										<div class="client-review-box-right">
											<p><?php the_sub_field('rating_content');?></p>
											<?php
											if (get_sub_field('is_rating_images')) {
												if( have_rows('rating_images') ){ ?>
												<ul>
													<?php while ( have_rows('rating_images') ) : the_row();?>
													<li><img src="<?php the_sub_field('rating_image');?>" alt=""> </li>
													<?php endwhile;?>
												</ul>
												<?php }
											} ?>
										</div>
									</div>
									<?php endwhile; } ?>
								</div>

   							<?php } else if( get_row_layout() == 'cta_button' ){
   								$is_icon = get_sub_field('is_icon');
   								if($is_icon){
   									$icon = '<i><img src="'.get_theme_file_uri('assets/images/template-2/cart-ic.svg').'" alt=""></i>';
   								}
   								?>
   								<div class="cart-btn wow fadeInUp" style="visibility: visible; animation-name: fadeInUp" data-wow-delay="400ms">
									<a href="<?php the_sub_field('cta_link');?>"><?php echo $icon;?> <?php the_sub_field('cta_text');?></a>
								</div>
   							<?php } else if( get_row_layout() == 'video_block' ){?>
   								<div class="iframe-cls">
   									<video class="video" controls>
										<source src="<?php the_sub_field('video_url');?>" type="video/mp4" />
									</video>
   								</div>
   							<?php } else if( get_row_layout() == 'text_block' ){?>
   								<div class="text-content">
   									<?php the_sub_field('text_editor_block');?>
   								</div>
   							<?php } ?>

   						<?php endwhile; ?>
   					<?php endif; ?>
					
				</div>
			 </div>
				
			<div class="col-sm-12 col-md-6">
				<div class="main-right-cont">

					<?php if ( have_rows('right_section_of_landing_page') ): ?>
   						<?php while( have_rows('right_section_of_landing_page') ): the_row(); ?>

   							<?php if( get_row_layout() == 'image_block' ) { ?>
   								<div class="img-box wow fadeInUp" style="visibility: visible; animation-name: fadeInUp" data-wow-delay="100ms">
									<figure><img src="<?php the_sub_field('image');?>" alt=""></figure>
								</div>
   							<?php } else if( get_row_layout() == 'image_with_text_block' ){
   									$text_style = get_sub_field( "text_style");
   									if($text_style == 'text_left'){
   										$style_cls = 'img-cont';
   									}else if($text_style == 'text_right'){
   										$style_cls = 'img-title';
   									}else if($text_style == 'text_full'){
   										$style_cls = 'img-desc';
   									}
   									$img = get_sub_field('image');
   								?>
   								<div class="img-box wow fadeInUp" style="visibility: visible; animation-name: fadeInUp" data-wow-delay="100ms">
									<figure><img src="<?php echo $img;?>" alt=""></figure>
									 <div class="<?php echo $style_cls?>">
										<?php the_sub_field('image_text');?>
									 </div>
								</div>
   							<?php }else if( get_row_layout() == 'rating_block' ){?>
   								<h3><?php echo get_sub_field('section_title'); ?></h3>
   								<div class="client-review-outer">
									<?php if( have_rows('user_rating') ){
									while ( have_rows('user_rating') ) : the_row();
										$rating = get_sub_field('rating');?>
									<div class="client-review-box wow fadeInUp" style="visibility: visible; animation-name: fadeInUp" data-wow-delay="400ms">
										<div class="client-review-box-left">
											<figure><img src="<?php the_sub_field('image');?>" alt=""></figure>
											<div class="client-cont">
											<h4> <?php the_sub_field('user_name');?></h4>
											<p><?php the_sub_field('rating_date');?></p>
											<ul>
												<?php for ($i=0; $i < $rating; $i++) { ?>
													<li><a href="#"><i class="fa fa-star"></i></a></li>
												<?php }?>
											</ul>
											</div>
										</div>
										<div class="client-review-box-right">
											<p><?php the_sub_field('rating_content');?></p>
											<?php
											if (get_sub_field('is_rating_images')) {
												if( have_rows('rating_images') ){ ?>
												<ul>
													<?php while ( have_rows('rating_images') ) : the_row();?>
													<li><img src="<?php the_sub_field('rating_image');?>" alt=""> </li>
													<?php endwhile;?>
												</ul>
												<?php }
											} ?>
										</div>
									</div>
									<?php endwhile; } ?>
								</div>

   							<?php } else if( get_row_layout() == 'cta_button' ){
   								$is_icon = get_sub_field('is_icon');
   								if($is_icon){
   									$icon = '<i><img src="'.get_theme_file_uri('assets/images/template-2/cart-ic.svg').'" alt=""></i>';
   								}
   								?>
   								<div class="cart-btn wow fadeInUp" style="visibility: visible; animation-name: fadeInUp" data-wow-delay="400ms">
									<a href="<?php the_sub_field('cta_link');?>"><?php echo $icon;?> <?php the_sub_field('cta_text');?></a>
								</div>
   							<?php } else if( get_row_layout() == 'video_block' ){?>
   								<div class="iframe-cls">
   									<video class="video" controls>
										<source src="<?php the_sub_field('video_url');?>" type="video/mp4" />
									</video>
   								</div>
   							<?php } else if( get_row_layout() == 'text_block' ){?>
   								<div class="text-content">
   									<?php the_sub_field('text_editor_block');?>
   								</div>
   							<?php } ?>

   						<?php endwhile; ?>
   					<?php endif; ?>
					

				</div>
			</div>
		</div>
	</div>
</section>

<?php if ( have_rows('bottom_section_on_landing_page') ): ?>
   	<?php while( have_rows('bottom_section_on_landing_page') ): the_row(); ?>
   		<?php if( get_row_layout() == 'text_block' ){ ?>
			<div class="landing-about wow fadeInUp" style="<?php echo 'background:'.get_sub_field('background', $page_id); ?>">
				<div class="container">
					<?php the_sub_field('text_content');?>
				</div>
			</div>
		<?php } else if( get_row_layout() == 'cta_block' ){
			$is_icon = get_sub_field('is_icon');
			if($is_icon){
				$icon = '<i><img src="'.get_theme_file_uri('assets/images/template-2/cart-ic.svg').'" alt=""></i>';
			}
			?>
			<div class="bottom_section_cta" style="<?php echo 'background:'.get_sub_field('background', $page_id); ?>">
				<div class="cart-btn wow fadeInUp" style="visibility: visible; animation-name: fadeInUp" data-wow-delay="400ms">
					<a href="<?php the_sub_field('cta_link');?>"><?php echo $icon;?> <?php the_sub_field('cta_text');?></a>
				</div>
			</div>
		<?php } else if( get_row_layout() == 'image_block' ) { ?>
			<div class="img-box btm_sec wow fadeInUp" style="<?php echo 'background:'.get_sub_field('background', $page_id); ?>" data-wow-delay="100ms">
				<div class="container">
					<figure><img src="<?php the_sub_field('image');?>" alt=""></figure>
				</div>
			</div>
		<?php } else if( get_row_layout() == 'image_with_text_block' ){
			$text_style = get_sub_field( "text_style");
			if($text_style == 'text_left'){
				$style_cls = 'img-cont';
			}else if($text_style == 'text_right'){
				$style_cls = 'img-title';
			}else if($text_style == 'text_full'){
				$style_cls = 'img-desc';
			} ?>
			<div class="img-box btm_sec wow fadeInUp" style="<?php echo 'background:'.get_sub_field('background', $page_id); ?>" data-wow-delay="100ms">
				<div class="container">
					<div class="extra">
						<figure><img src="<?php the_sub_field('image');?>" alt=""></figure>
						<div class="<?php echo $style_cls?>">
							<?php the_sub_field('image_text');?>
						</div>
					</div>
				</div>
			</div>
		<?php } else if( get_row_layout() == 'video_block' ){?>
			<div class="iframe-cls btm_sec" style="<?php echo 'background:'.get_sub_field('background', $page_id); ?>">
				<div class="container">
					<video class="video" controls>
						<source src="<?php the_sub_field('video_url');?>" type="video/mp4" />
					</video>
				</div>
			</div>
		<?php } else if( get_row_layout() == 'rating_block' ){?>
			<section class="bottom_user_rat" style="<?php echo 'background:'.get_sub_field('background', $page_id); ?>">
				<div class="container">
				<h3><?php echo get_sub_field('section_title'); ?></h3>
			<?php if( have_rows('user_rating') ){
			while ( have_rows('user_rating') ) : the_row(); 
				$rating = get_sub_field('rating');?>
			<div class="client-review-box wow fadeInUp" style="visibility: visible; animation-name: fadeInUp" data-wow-delay="400ms">
				<div class="client-review-box-left">
					<figure><img src="<?php the_sub_field('image');?>" alt=""></figure>
					<div class="client-cont">
					<h4> <?php the_sub_field('name');?></h4>
					<p><?php the_sub_field('rating_date');?></p>
					<ul>
						<?php for ( $i = 0; $i < $rating; $i++ ) { ?>
							<li><a href="#"><i class="fa fa-star"></i></a></li>
						<?php }?>
					</ul>
					</div>
				</div>
				<div class="client-review-box-right">
					<p><?php the_sub_field('rating_content');?></p>
					<?php
					if (get_sub_field('is_rating_images')) {
						if( have_rows('rating_images') ){ ?>
						<ul>
							<?php while ( have_rows('rating_images') ) : the_row();?>
							<li><img src="<?php the_sub_field('rating_image');?>" alt=""> </li>
							<?php endwhile;?>
						</ul>
						<?php }
					} ?>
				</div>
			</div>
			<?php endwhile; } ?>
		</div>
		</section>

		<?php } else if( get_row_layout() == 'left_right_image_content' ){ ?>
			<section class="left_right_img_cont img_<?php echo get_sub_field('image_position', $page_id); ?>" style="<?php echo 'background:'.get_sub_field('background', $page_id); ?>">
				<div class="container">
					<div class="row align-items-<?php echo get_sub_field('vertically_content_alignment', $page_id); ?>">
						<div class="col-md-6">
							<figure>
								<img src="<?php echo get_sub_field('image'); ?>">
							</figure>
						</div>
						<div class="col-md-6">
							<div class="l_r_contnt">
								<?php echo get_sub_field('content'); ?>
							</div>
						</div>
					</div>
				</div>
			</section>
		<?php }
	endwhile;
endif; ?>

<!-- <script src="<?php echo get_template_directory_uri(); ?>/assets/js/wow.js"></script>
<script>
	jQuery(document).ready(function(){ 
	 wow = new WOW(
	  {
		animateClass: 'animated',
		offset:       0,
		callback:     function(box) {
		  console.log("WOW: animating <" + box.tagName.toLowerCase() + ">")
		}
	  }
	);
	wow.init();  
	}); 
</script> -->
<?php get_footer(); ?>