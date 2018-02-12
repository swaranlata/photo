<?php
/*Template Name:About Us*/
get_header();
$post=get_post();
$src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'full');
$bgImage='';
if(isset($src[0])){
   $bgImage =$src[0];
}
?>
	<main class="main">
		<div class="about">
			<section class="banner" style="background-image: url(<?php echo $bgImage;?>);">
				<h1><?php  echo $post->post_title;?></h1>
			</section>
			<section>
				<div class="container">
					<div class="max">
						<p>
							<?php  echo $post->post_content;?>
						</p>
					</div>
					<div class="row">
						<div class="col-xs-12 col-sm-6">
							<div class="img-half" style="background-image: url('<?php  echo get_field('image_1',$post->ID); ?>');">
								<h3 class="hide"></h3></div>
						</div>
						<div class="col-xs-12 col-sm-6">
							<div class="img-half" style="background-image: url('<?php  echo get_field('image_2',$post->ID); ?>');">
								<h3 class="hide"></h3></div>
						</div>
					</div>
				</div>
			</section>
			<section class="work-section">
				<div class="container">
					<?php dynamic_sidebar('how-it-works'); ?>
				</div>
			</section>
			<section class="story">
				<div class="container">
					<h2><?php  echo get_field('our_story_title',$post->ID); ?></h2>
					<div class="max">
						<p>
							<?php  echo get_field('decsription',$post->ID); ?>
						</p>
					</div>
					<div class="single-img" style="background-image: url('<?php  echo get_field('content_image',$post->ID); ?>');"></div>
				</div>
			</section>
		</div>
	</main>
	<?php get_footer(); ?>