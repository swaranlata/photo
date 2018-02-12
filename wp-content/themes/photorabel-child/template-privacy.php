<?php
/* Template Name: Privacy Policy*/
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
            <div class="container">
                <h2><?php echo get_field('post_heading', $post->ID); ?></h2>
                <div class="max">
                  <?php echo $post->post_content; ?>
                </div>
                <?php echo get_field('content', $post->ID); ?>

            </div>
        </section>
    </div>
</main>
<?php get_footer(); ?>