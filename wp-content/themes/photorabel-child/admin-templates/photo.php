<?php 
$allPhotographerCount=getAllPhotographerListCount($_POST,'web');
$total_pages = ceil($allPhotographerCount/8);
    if(!empty($allPhotographer)) {
        ?>
<!--<div class="row">-->
<?php
        foreach($allPhotographer as $k=>$v) {
        ?>
          <div class="col-xs-12 col-md-6 col-lg-3">
                <div class="photo-ghrapher">
                    <figure>
												<?php if(!empty($v['bannerImage'])) {
													?>
													<span style="background-image: url('<?php echo $v['bannerImage'] ?>');"></span>
													<?php
												} else {
													if(!empty($v['profileImage'])) {
														?>
														<span style="background-image: url('<?php echo $v['profileImage'] ?>');filter: blur(15px);"></span>
														<?php
													} else {
														?>
														<span style="background-image: url('<?php echo get_site_url().'/wp-content/uploads/2017/10/banner.png'; ?>');"></span>
														<?php
													}
												} ?>
											</figure>
                    <a href="<?php echo get_site_url().'/photographer-profile/'.$v['userId'];?>"><h4><?php echo $v['name'];?></h4></a>
                    <p><?php echo $v['bio'];?></p>
                    <div class="grapher-footer">
                        <div class="grapher-price">$
                            <?php
                                $hours=0;
                                if(!empty($v['hourlyRate'])) {
                                    $hours=$v['hourlyRate'];
                                } echo str_replace('$','',$hours);
                            ?>
                        </div>
                        <div class="grapher-rating">
                            <?php 
                                $rating=$v['rating'];
                            ?>
                             <div class="ratebox" data-id="1" data-rating="<?php echo $rating; ?>"></div>
                        </div>
                    </div>
                    <div class="grapher-avatar">
                        <?php
                            $profileImage=get_site_url()."/wp-content/uploads/2017/08/avatar.jpg";
                            if(!empty($v['profileImage'])) {
                                $profileImage=$v['profileImage'];
                            }
                        ?>
                        <div style="background-image: url('<?php echo $profileImage; ?>');"></div>
                        <a href="<?php echo get_site_url().'/photographer-profile/'.$v['userId'];?>">View Profile</a>
                    </div>
                </div>
            </div>
        <?php }
    
    ?>
<!--</div>-->
    <?php
    
    ?>
 <?php  
                    $test=paginate_function(8,$_POST['offset'],$allPhotographerCount,$total_pages); 
                    if(!empty($test)){
                     $test;
                    }
                ?>
<?php
    } else {
        ?>
            <p>No Photographer found according to your search.</p>
        <?php
    }
?>

                
<script src="<?php echo get_stylesheet_directory_uri();?>/js/raterater.jquery.js"></script>
<script>
$(function() {
    $( '.ratebox' ).raterater( { 
        submitFunction: 'rateAlert', 
        allowChange: true,
        starWidth: 20,
        spaceWidth: 5,
        numStars: 5
    } );
});

</script>

