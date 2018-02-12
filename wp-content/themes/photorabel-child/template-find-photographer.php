<?php
/* Template Name: Find Photographer Template */
get_header();
$post = get_post();
$src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'full');
$bgImage = '';
if(isset($src[0])) {
	$bgImage  = $src[0];
}
$data['offset'] = 0;
$data['country'] = '';
$data['city'] = '';
$data['date'] = '';
$data['time'] = '';
$ip = $_SERVER['REMOTE_ADDR'];
$useragent=$_SERVER['HTTP_USER_AGENT'];
if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){
    if(isset($_SESSION['lat']) and !empty($_SESSION['lat']) and isset($_SESSION['long']) and !empty($_SESSION['long'])){
        $data['currentLat']=@$_SESSION['lat'];
        $data['currentLong']=@$_SESSION['long']; 
    }else{
        $latLong=getLatLongByIp($ip);
        $data['currentLat']=$latLong['lat'];
        $data['currentLong']=$latLong['long'];   
    }
}else{
    $latLong=getLatLongByIp($ip);
    $data['currentLat']=$latLong['lat'];
    $data['currentLong']=$latLong['long'];     
} 
$data['userId'] = '';
if(!empty($_POST['submit'])) {
	if(!empty($_POST['address'])) {
		$data['country'] = $_POST['address'];
		$data['city'] = $_POST['address'];
		$data['currentLat'] = '';
		$data['currentLong'] = '';
	}
	if(!empty($_POST['date'])){
		$data['date'] = $_POST['date'];
		$_SESSION['date'] = $_POST['date'];
	}
	if(!empty($_POST['startTime']) and !empty($_POST['endTime'])){
		$data['time'] = $_POST['startTime'].'-'.$_POST['endTime'];
        $_SESSION['startTime']=$_POST['startTime'];
        $_SESSION['endTime']=$_POST['endTime'];
	}
	if(get_current_user_id()){
		$data['userId'] = get_current_user_id();
	}
	if(isset($_POST['page'])){
		$data['offset'] = $_POST['page']-1; 
	}
    ?>
<script>
    $(document).ready(function(){
        $('#autocompletelocation').val('<?php echo @$_POST['address']; ?>');
        $('#searchDate').val('<?php echo @$_POST['date']; ?>');
        $('input[name="startTime"]').val('<?php echo @$_POST['startTime']; ?>');
        $('input[name="endTime"]').val('<?php echo @$_POST['endTime']; ?>');
    });
</script>
<?php    
}
$allPhotographer=getAllPhotographerList($data,'web');
$allPhotographerCount=getAllPhotographerListCount($data,'web');
?>
	<main class="main">
		<div class="about">
			<section class="banner" style="background-image: url('<?php echo $bgImage; ?>');">
				<h1><?php echo $post->post_title;?></h1>
			</section>
			<section id="search-box">
				<div class="container">
					<div class="row">
						<div class="search-form">
							<?php  dynamic_sidebar('search-form');?>
						</div>
					</div>
				</div>
			</section>
			<form style="display:none;" id="pageForm" action="javascript:void(0);">
				<input type="hidden" name="page" value="1" />
				<input type="hidden" name="action" value="pagination" />
				<?php if(!empty($data)) {
				foreach($data as $k=>$v) {
					?>
				<input type="hidden" name="<?php  echo $k; ?>" value="<?php echo $v; ?>" />
				<?php 
				}
			} ?>
			</form>
			<section class="photographers">
				<div class="container">
					<h2>List Of Photographers</h2>
					<!--<div class="row" >-->
					<!--<div class="offset-md-1 col-md-10" >-->
					<div class="row" id="results">
						<?php 
							if(!empty($allPhotographer)) {
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
								<p>
									<?php echo $v['bio'];?>
								</p>
								<div class="grapher-footer">
									<div class="grapher-price">$
										<?php
													$hours=0;
													if(!empty($v['hourlyRate'])) {
														$hours=$v['hourlyRate'];
													}
													echo $hours;
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
												} ?>
										<div style="background-image: url('<?php echo $profileImage; ?>');"></div>
										<!-- <img src="<?php //echo $profileImage; ?>" alt="..."> -->
										<a href="<?php echo get_site_url().'/photographer-profile/'.$v['userId'];?>">View Profile</a>
								</div>
							</div>
						</div>
						<?php
								}
							} else {
								?>
							<p class="w100p text-center">No Photographer found according to your search.</p>
							<?php
							}
							?>
					</div>
					<?php
						$total_pages = ceil($allPhotographerCount/8);
						echo paginate_function(8,1,$allPhotographerCount,$total_pages);
						?>
						<!--</div>-->
						<!--</div>-->
				</div>
			</section>
		</div>
	</main>
	<script src="<?php echo get_stylesheet_directory_uri().'/js/jquery.timepicker.min.js'; ?>"></script>
	<script>
	$(document).ready(function() {
		$('.timepickerclass').timepicker();
	});
	</script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCS_kV32SWfFmAPm2HIId6zzg73iE_g39k&libraries=places&callback=initAutocomplete" async defer></script>
	<script src="<?php echo get_stylesheet_directory_uri().'/js/jquery.geocomplete.js'?>"></script>
	<script>
	var placeSearch, autocomplete;
	var componentForm = {
		// street_number: 'short_name',
		// route: 'long_name',
		locality: 'long_name',
		administrative_area_level_1: 'short_name',
		country: 'long_name',
		// postal_code: 'short_name',
	};

	function initAutocomplete() {
		// location types.
		autocomplete = new google.maps.places.Autocomplete(
			/** @type {!HTMLInputElement} */
			(document.getElementById('autocompletelocation')), { types: ['geocode'] }
		);

		// When the user selects an address from the dropdown, populate the address
		// fields in the form.
		autocomplete.addListener('place_changed', fillInAddress);
	}

	function fillInAddress() {
		// Get the place details from the autocomplete object.
		var place = autocomplete.getPlace();

		for (var component in componentForm) {
			// document.getElementById(component).value = '';
			// document.getElementById(component).disabled = false;
		}

		// Get each component of the address from the place details
		// and fill the corresponding field on the form.
		/*if (place != undefined) {
			for (var i = 0; i < place.address_components.length; i++) {
				var addressType = place.address_components[i].types[0];
				if (componentForm[addressType]) {
					var val = place.address_components[i][componentForm[addressType]];
					if (val != '' || val == undefined) {
						document.getElementById(addressType).value = val;
					}
				}
			}
		}*/
	}
	// Bias the autocomplete object to the user's geographical location,
	// as supplied by the browser's 'navigator.geolocation' object.
	function geolocate() {
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(function(position) {
				var geolocation = {
					lat: position.coords.latitude,
					lng: position.coords.longitude
				};
				var circle = new google.maps.Circle({
					center: geolocation,
					radius: position.coords.accuracy
				});
				autocomplete.setBounds(circle.getBounds());
			});
		}
	}
	</script>
	<?php get_footer(); ?>