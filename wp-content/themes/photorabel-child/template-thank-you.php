<?php
/*Template Name: Thank You */
get_header();
$post=get_post();
$src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'full');
$bgImage='';
if(isset($src[0])){
   $bgImage =$src[0];
}
?>
<main class="main">
    <div class="privacy">
        <section class="banner" style="background-image: url('<?php echo $bgImage; ?>');">
            <h1><?php echo $post->post_title; ?></h1>
        </section>

        <section class="privacy-policy">
        	<div class="thankyou-cover contact-page text-center">
				<div class="container-fluid">
					<div class="tick"><i class="fa fa-check" aria-hidden="true"></i></div>
					<div class="thnkyou-message"><p>Thank you for getting in touch. We will get back to you shortly.</p></div>
				</div>
			</div>
        </section>
    </div>
</main>
<?php
get_footer();
?>