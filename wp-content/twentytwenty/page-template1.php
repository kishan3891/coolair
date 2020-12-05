<?php
/* Template name: Template - 1 */

get_header();

$page_id = get_the_ID();

$banner_as_pre_designed = get_field('banner_as_pre_designed', $page_id);
$banner_background = get_field('banner_background', $page_id);
$banner_back_img = get_field('banner_background_image', $page_id);
$banner_mobile_back_img = get_field('banner_mobile_background_image', $page_id);
$banner_back_color = get_field('banner_background_color', $page_id);
$bnrr_class = $bnrr_back = $bnrr_mobile_back = '' ;

if ($banner_as_pre_designed == true) {
	$pre_designed_banner_image_desktop = get_field('pre_designed_banner_image_desktop', $page_id);
	$pre_designed_banner_image_mobile = get_field('pre_designed_banner_image_mobile', $page_id);
	$bnrr_back = 'background: none';
	$bnrr_mobile_back = 'background: none';
	$bnrr_class = 'predesigned';
	$btn_class = get_field('banner_cta_position', $page_id);
}
?>
<link href="<?php echo get_theme_file_uri( '/assets/css/template.css' ); ?>" rel="stylesheet">
<link href="<?php echo get_theme_file_uri( '/assets/css/template-media.css' ); ?>" rel="stylesheet">

<?php 
$is_top_line_1 = get_field('is_top_line_1', $page_id);
if($is_top_line_1){ ?>
<div class="top-line" style="<?php echo (get_field('top_line_1_background', $page_id)) ? 'background:'.get_field('top_line_1_background', $page_id) : ''; ?>">
	<div class="container">
		<span class="wow flash" style="visibility: visible; animation-name: flash"><?php the_field('top_line_1', $page_id);?></span>
	</div>
</div>
<?php } ?>

<?php 
$is_top_line_2 = get_field('is_top_line_2', $page_id);
if($is_top_line_2){?>
<section class="top-secondline wow fadeInUp" style="<?php echo (get_field('top_line_2_background', $page_id)) ? 'background:'.get_field('top_line_2_background', $page_id) : ''; ?>">
	<div class="container">
		<h2><?php the_field('top_line_2', $page_id);?></h2>
	</div>
</section>
<?php }?>

<section class="main-banner wow fadeInUp <?php echo $bnrr_class; ?>" style="visibility: visible; animation-name: fadeInUp;">
	<?php if ($banner_as_pre_designed) {
		echo '<img class="desk" src="'.$pre_designed_banner_image_desktop.'">';
		echo '<img class="mob" src="'.$pre_designed_banner_image_mobile.'">';
		echo '<div class="discount-btn wow flash '.$btn_class.'">
			<a href="'.get_field('banner_cta_link', $page_id).'">'.get_field('banner_cta_text', $page_id).'</a>
		</div>';
	}
	else { ?>
		<img src="<?php echo $banner_back_img; ?>" class="desk_img" >
		<img src="<?php echo $banner_mobile_back_img; ?>" class="mob_img" >
		<div class="container main_cont">
			<div class="row align-items-bottom">
				<div class="banner-left">
					<figure><img src="<?php the_field('banner_image', $page_id);?>" alt=""> </figure>
				</div>
				<div class="banner-right">
					<?php the_field('banner_content', $page_id);?>
					<div class="discount-btn wow flash" style="visibility: visible; animation-name: flash">
						<a href="<?php the_field('banner_cta_link', $page_id);?>"><?php the_field('banner_cta_text', $page_id);?> </a>
					</div>
					<p> <?php the_field('banner_cta_tag_line', $page_id);?> </p>
				</div>
			</div>
		</div>
	<?php } ?>
</section>

<div class="landing-about wow fadeInUp" style="<?php echo 'background:'.get_field('about_background', $page_id); ?>">
	<div class="container">
		<?php the_field('about_content', $page_id);?>
		<figure>
			<?php
			$is_youtube_video = get_field('is_youtube_video', $page_id);
			if($is_youtube_video){?>
				<iframe id="youtubeVideo" width="560" height="315" src="<?php the_field('youtube_video_url', $page_id);?>" frameborder="0" allowfullscreen></iframe>
			<?php }?>

			<?php
			$is_about_image = get_field('is_about_image', $page_id);
			if($is_about_image){?>
				<img src="<?php the_field('about_image', $page_id);?>" alt="">
			<?php }?>			
		</figure>			
	</div>
</div>

<?php if ( have_rows('beginning_section_on_landing_page_1') ): ?>
   	<?php while( have_rows('beginning_section_on_landing_page_1') ): the_row(); ?>
   		<?php if( get_row_layout() == 'text_block' ){ ?>
			<div class="landing-about wow fadeInUp" style="<?php echo 'background:'.get_sub_field('background', $page_id); ?>">
				<div class="container">
					<?php the_sub_field('text_content');?>
				</div>
			</div>
		<?php } else if( get_row_layout() == 'cta_block' ){?>
				<div class="bottom_section_cta" style="visibility: visible; animation-name: fadeInUp; <?php echo 'background:'.get_sub_field('background', $page_id); ?>">
					<div class="discount-btn">
						<a href="<?php the_sub_field('cta_link');?>"><?php the_sub_field('cta_text');?></a>
					</div>
				</div>
		<?php } else if( get_row_layout() == 'video_block' ){?>
			<div class="iframe-cls btm_sec" style="visibility: visible; animation-name: fadeInUp; <?php echo 'background:'.get_sub_field('background', $page_id); ?>">
				<div class="container">
					<video class="video" controls>
						<source src="<?php the_sub_field('video_url');?>" type="video/mp4" />
					</video>
				</div>
			</div>
		<?php } else if( get_row_layout() == 'image_block' ) { ?>
			<div class="single-img wow fadeInUp btm_sec" data-wow-delay="100ms" style="<?php echo 'background:'.get_sub_field('background', $page_id); ?>">
				<div class="container">
					<figure><img src="<?php the_sub_field('image');?>" alt=""></figure>
				</div>
			</div>
		<?php } else if( get_row_layout() == 'image_with_text_block' ){?>
			<div class="single-img-box btm_sec wow fadeInUp" data-wow-delay="100ms" style="<?php echo 'background:'.get_sub_field('background', $page_id); ?>">
				<div class="container">
					<figure><img src="<?php the_sub_field('image');?>" alt=""></figure>
					<?php the_sub_field('image_text');?>
				</div>
			</div>
		<?php } else if( get_row_layout() == 'rating_block' ){ ?>
			<section class="bottom_user_rat" style="<?php echo 'background:'.get_sub_field('background', $page_id); ?>">
				<div class="container">
				<h5><?php echo get_sub_field('section_title'); ?></h5>
			<?php if( have_rows('user_rating') ){ ?>
				<?php while ( have_rows('user_rating') ) : the_row(); ?>
					<div class="client-review-box">
						<figure><img src="<?php the_sub_field('image');?>" alt=""></figure>
						<div class="review-cont">
							<div class="name-list">
								<li><h4><?php the_sub_field('name');?></h4></li>
								<li><span><?php the_sub_field('rating_date');?></span></li>
								<li>
									<ul class="star">
										<?php $rating = get_sub_field('rating');
										for ($i = 0; $i < $rating; $i++) {
										    print "<li><a href='#'><i class='fa fa-star'></i></a></li>";
										}
										?>
									</ul>
								</li>
							</div>
							<p><?php the_sub_field('rating_content');?></p>
							<?php if (get_sub_field('is_rating_images')) { ?>
								<ul class="img-list">
									<?php
										if( have_rows('rating_images') ){
										while ( have_rows('rating_images') ) : the_row();?>
										<li><img src="<?php the_sub_field('rating_image');?>" alt=""> </li>
									<?php endwhile; } ?>
								</ul>
							<?php } ?>
						</div>
					</div>
				<?php endwhile; ?>
			<?php } ?>
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
		<?php } ?>
	<?php endwhile; ?>
<?php endif; ?>

<section class="landing-main-cont wow fadeInUp" style="visibility: visible; animation-name: fadeInUp">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-md-6"> 
				<div class="main-left-side wow fadeInUp" style="visibility: visible; animation-name: fadeInUp">
					<!-- <h5>What Others are Saying...</h5> -->

					<?php if ( have_rows('left_section_of_landing_page1') ): ?>
   						<?php while( have_rows('left_section_of_landing_page1') ): the_row(); ?>

   							<?php if( get_row_layout() == 'image_block' ) { ?>
   								<div class="single-img wow fadeInUp" style="visibility: visible; animation-name: fadeInUp" data-wow-delay="100ms">
									<figure><img src="<?php the_sub_field('image');?>" alt=""></figure>
								</div>
   							<?php } else if( get_row_layout() == 'image_with_text_block' ){?>
   								<div class="single-img-box wow fadeInUp" style="visibility: visible; animation-name: fadeInUp" data-wow-delay="100ms">
									<figure><img src="<?php the_sub_field('image');?>" alt=""></figure>
									<?php the_sub_field('image_text');?>
								</div>

   							<?php } else if( get_row_layout() == 'rating_block' ){ ?>

   								<h5><?php echo get_sub_field('section_title'); ?></h5>
   								<?php if( have_rows('user_rating') ){
									while ( have_rows('user_rating') ) : the_row(); ?>
								<div class="client-review-box">
									<figure><img src="<?php the_sub_field('image');?>" alt=""></figure>
									<div class="review-cont">
										<div class="name-list">
											<li><h4><?php the_sub_field('name');?></h4></li>
											<li><span><?php the_sub_field('rating_date');?></span></li>
											<li>
												<ul class="star">
													<?php $rating = get_sub_field('rating');
													for ($i = 0; $i < $rating; $i++) {
													    print "<li><a href='#'><i class='fa fa-star'></i></a></li>";
													}
													?>
												</ul>
											</li>
										</div>
										<p><?php the_sub_field('rating_content');?></p>
										<?php if (get_sub_field('is_rating_images')) { ?>
											<ul class="img-list">
												<?php
													if( have_rows('rating_images') ){
													while ( have_rows('rating_images') ) : the_row();?>
													<li><img src="<?php the_sub_field('rating_image');?>" alt=""> </li>
												<?php endwhile; } ?>
											</ul>
										<?php } ?>
									</div>
								</div>
								<?php endwhile; } ?>

   							<?php } else if( get_row_layout() == 'cta_button' ){?>
   								<div class="discount-btn">
									<a href="<?php the_sub_field('cta_link');?>"><?php the_sub_field('cta_text');?></a>
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
			
			<div class="col-smn-12 col-md-6">
				<div class="main-right-side wow fadeInUp" style="visibility: visible; animation-name: fadeInUp">

					<?php if ( have_rows('right_section_of_landing_page1') ): ?>
   						<?php while( have_rows('right_section_of_landing_page1') ): the_row(); ?>

   							<?php if( get_row_layout() == 'image_block' ) { ?>
   								<div class="single-img wow fadeInUp" style="visibility: visible; animation-name: fadeInUp" data-wow-delay="100ms">
									<figure><img src="<?php the_sub_field('image');?>" alt=""></figure>
								</div>
   							<?php } else if( get_row_layout() == 'image_with_text_block' ){?>
   								<div class="single-img-box wow fadeInUp" style="visibility: visible; animation-name: fadeInUp" data-wow-delay="100ms">
									<figure><img src="<?php the_sub_field('image');?>" alt=""></figure>
									<h5><?php the_sub_field('image_text');?></h5>
								</div>

   							<?php } else if( get_row_layout() == 'rating_block' ){ ?>
   								<h5><?php echo get_sub_field('section_title'); ?></h5>
   								<?php if( have_rows('user_rating') ){
									while ( have_rows('user_rating') ) : the_row(); ?>
								<div class="client-review-box">
									<figure><img src="<?php the_sub_field('image');?>" alt=""></figure>
									<div class="review-cont">
										<div class="name-list">
											<li><h4><?php the_sub_field('name');?></h4></li>
											<li><span><?php the_sub_field('rating_date');?></span></li>
											<li>
												<ul class="star">
													<?php $rating = get_sub_field('rating');
													for ($i = 0; $i < $rating; $i++) {
													    print "<li><a href='#'><i class='fa fa-star'></i></a></li>";
													}
													?>
												</ul>
											</li>
										</div>
										<p><?php the_sub_field('rating_content');?></p>
										<?php if (get_sub_field('is_rating_images')) { ?>
											<ul class="img-list">
												<?php
													if( have_rows('rating_images') ){
													while ( have_rows('rating_images') ) : the_row();?>
													<li><img src="<?php the_sub_field('rating_image');?>" alt=""> </li>
												<?php endwhile; } ?>
											</ul>
										<?php } ?>
									</div>
								</div>
								<?php endwhile; } ?>

   							<?php } else if( get_row_layout() == 'cta_button' ){?>
   								<div class="discount-btn">
									<a href="<?php the_sub_field('cta_link');?>"><?php the_sub_field('cta_text');?></a>
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

<?php if ( have_rows('bottom_section_on_landing_page_1') ): ?>
   	<?php while( have_rows('bottom_section_on_landing_page_1') ): the_row(); ?>
   		
   		<?php if( get_row_layout() == 'text_block' ){ ?>
			<div class="landing-about wow fadeInUp" style="<?php echo 'background:'.get_sub_field('background', $page_id); ?>">
				<div class="container">
					<?php the_sub_field('text_content');?>
				</div>
			</div>
		<?php } else if( get_row_layout() == 'cta_block' ){?>
				<div class="bottom_section_cta" style="visibility: visible; animation-name: fadeInUp; <?php echo 'background:'.get_sub_field('background', $page_id); ?>">
					<div class="discount-btn">
						<a href="<?php the_sub_field('cta_link');?>"><?php the_sub_field('cta_text');?></a>
					</div>
				</div>
		<?php } else if( get_row_layout() == 'video_block' ){?>
			<div class="iframe-cls btm_sec" style="visibility: visible; animation-name: fadeInUp; <?php echo 'background:'.get_sub_field('background', $page_id); ?>">
				<div class="container">
					<video class="video" controls>
						<source src="<?php the_sub_field('video_url');?>" type="video/mp4" />
					</video>
				</div>
			</div>
		<?php } else if( get_row_layout() == 'image_block' ) { ?>
			<div class="single-img wow fadeInUp btm_sec" data-wow-delay="100ms" style="<?php echo 'background:'.get_sub_field('background', $page_id); ?>">
				<div class="container">
					<figure><img src="<?php the_sub_field('image');?>" alt=""></figure>
				</div>
			</div>
		<?php } else if( get_row_layout() == 'image_with_text_block' ){?>
			<div class="single-img-box btm_sec wow fadeInUp" data-wow-delay="100ms" style="<?php echo 'background:'.get_sub_field('background', $page_id); ?>">
				<div class="container">
					<figure><img src="<?php the_sub_field('image');?>" alt=""></figure>
					<?php the_sub_field('image_text');?>
				</div>
			</div>
		<?php } else if( get_row_layout() == 'rating_block' ){ ?>
			<section class="bottom_user_rat" style="<?php echo 'background:'.get_sub_field('background', $page_id); ?>">
				<div class="container">
				<h5><?php echo get_sub_field('section_title'); ?></h5>
			<?php if( have_rows('user_rating') ){ ?>
				<?php while ( have_rows('user_rating') ) : the_row(); ?>
					<div class="client-review-box">
						<figure><img src="<?php the_sub_field('image');?>" alt=""></figure>
						<div class="review-cont">
							<div class="name-list">
								<li><h4><?php the_sub_field('name');?></h4></li>
								<li><span><?php the_sub_field('rating_date');?></span></li>
								<li>
									<ul class="star">
										<?php $rating = get_sub_field('rating');
										for ($i = 0; $i < $rating; $i++) {
										    print "<li><a href='#'><i class='fa fa-star'></i></a></li>";
										}
										?>
									</ul>
								</li>
							</div>
							<p><?php the_sub_field('rating_content');?></p>
							<?php if (get_sub_field('is_rating_images')) { ?>
								<ul class="img-list">
									<?php
										if( have_rows('rating_images') ){
										while ( have_rows('rating_images') ) : the_row();?>
										<li><img src="<?php the_sub_field('rating_image');?>" alt=""> </li>
									<?php endwhile; } ?>
								</ul>
							<?php } ?>
						</div>
					</div>
				<?php endwhile; ?>
			<?php } ?>
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

<?php
$limited_offer_background = get_field('limited_offer_background', $page_id);
if ($limited_offer_background == 'image') {
	$lmtd_offr_back = 'background: url('.get_field('limited_offer_background_img', $page_id).')';
}
else {
	$lmtd_offr_back = 'background: '.get_field('limited_offer_background_color', $page_id);
}
?>

<section class="limitd-main-outer wow fadeInUp" style="<?php echo $lmtd_offr_back; ?>">
	<div class="limited-cont">
		<div class="container">
			<h3><?php the_field('limited_offer', $page_id);?></h3>
		</div>
	</div>
	<div class="claim-discount wow flash" <?php echo (get_field('claim_discount_background', $page_id)) ? 'style="background: '.get_field('claim_discount_background', $page_id).'"' : ''; ?>>
			<a href="#"><?php the_field('claim_discount_offer', $page_id);?></a>
	</div>
</section>

<script src="<?php echo get_template_directory_uri(); ?>/assets/js/wow.js"></script>
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
</script>

<?php get_footer(); ?>