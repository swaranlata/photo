<?php
/* Template Name: Contact*/
get_header();
$post=get_post();
$src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'full');
$bgImage='';
if(isset($src[0])){
   $bgImage =$src[0];
}
?>
<main class="main">
    <div class="contactus-template">
        <section class="banner" style="background-image: url('<?php echo $bgImage;?>');">
            <h1><?php echo $post->post_title; ?></h1>
        </section>
        <section id="contact" class="text-center">
            <div class="container">
                <h2><?php echo get_field('post_heading',$post->ID); ?></h2>
                <div class="max">
                    <p><?php  echo $post->post_content?></p>
                </div>
                <div class="contact-us">
                    <?php echo do_shortcode('[contact-form-7 id="919" title="Contact Us Form" html_class="form-inline"]'); ?></div>
                <div class="single-img"  style="background-image: url('<?php echo get_field('image',$post->ID); ?>');"></div>
            </div>
        </section>
    </div>
</main>
<?php get_footer(); ?>