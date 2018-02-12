<?php
/* Template Name: Signup */
get_header();
$signUpPage=get_post();
if(!empty($signUpPage)){
  $signUpPage=convert_array($signUpPage);  
}
$src = wp_get_attachment_image_src(get_post_thumbnail_id($signUpPage['ID']),'full');

?>
	<main class="main">
			<div class="photographer">
				<section class="banner" style="background-image: url('<?php echo get_field('banner_image',$signUpPage['ID']); ?>');">
					<h1>photographer</h1>
				</section>
				<section id="signup">
					<div class="container">
						<h2 class="postTitle"><?php echo $signUpPage['post_title'];?></h2>
						<div class="max">
                            <input type="hidden" id="userDefaultImage" value="<?php echo get_site_url()."/wp-content/uploads/2017/08/avatar.png";?>"/>
							<?php echo $signUpPage['post_content'];?>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<ul class="tabs">
									<li class="active"><a href="javascript:void(0)"  class="changeTab" data-attr="P"  data-target="photo-signup">Photographer</a></li>
									<li><a href="javascript:void(0)" class="changeTab" data-attr="T" data-target="user-signup">Traveler</a></li>
								</ul>
								<div class="form-wrapper">
                                    <div id="response">
                                        </div>
									<form enctype="multipart/form-data" id="photo-signup" method="post" action="">
                                        <input type="hidden" name="action" value="signup"/>
                                        <input type="hidden" name="userType" value="0"/>
                                        <div class="signup-imgs updateIcon">
											<div class="img-wrapper"  id="profile-img-tag-photo" style="background-image: url('<?php echo get_site_url()."/wp-content/uploads/2017/08/avatar.png";?>');"></div>
										</div>
										<div class="form-group">
											<div class="row">
												<div class="col-sm-6">
													<input type="text" class="form-control character" placeholder="First Name" name="firstName" value="">
												</div>
												<div class="col-sm-6">
													<input type="text" name="lastName" class="form-control character" placeholder="Last Name" value="">
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="row">
												<div class="col-sm-12">
                                                    <textarea placeholder="Bio"  name="bio" class="form-control" ></textarea>													
												</div>
												
											</div>
										</div>
                                        <div class="form-group">
											<div class="row">
                                                 <div class="col-sm-6">
													<input name="dob" id="birthdayP" type="text" class="form-control" placeholder="Birthday" value="" onfocus="blur();">
												</div>
                                                 <div class="col-sm-6">
													<input maxLength="2" name="minHours" type="text" class="form-control price_error" placeholder="Min Number of hours" value="">
												</div>                                           
                                             </div>
										</div>
                                        
                                        <div class="form-group">
											<div class="row">
                                                 <div class="col-sm-6">
													<input type="text" maxLength="15" name="contactNo" class="form-control price_error" placeholder="Phone Number">
												</div>
                                                 <div class="col-sm-6">
													<input maxLength="2" type="text" name="experience" class="form-control price_error" placeholder="Experience in years">
												</div>                                                                
                                            </div>
										</div>
                                     	<div class="form-group">
											<div class="row" id="result">
												
											</div>
										</div>
										<div class="form-group">
											<div class="row">
												<div class="col-sm-12 setPort">
													<span>Select Portfolio</span>
													<div class="input-group">
														<input type="text" class="form-control pim" readonly placeholder="No file choosen">
														<label class="input-group-btn">Choose File <input accept="image/*" id="files" type="file" style="display: none;" multiple></label>
													</div>
                                                    <div style="display:none;color:red;" class="validationMsg">You can only select 6 portfolio images.</div>
												</div>
											</div>
										</div>
                                        
										<div class="form-group">
											<div class="row">
												<div class="col-sm-6">
													<input maxLength="6" type="text"  name="hourlyRate" class="form-control price_error" placeholder="Hourly Charge">
												</div>
                                                <div class="col-sm-6">
													<select class="form-control" name="gender">
														<option value="male">Male</option>
														<option value="female">Female</option>
													</select>
												</div> 
												
											</div>
										</div>
                                        <input type="hidden" name="profileImage" id="imageDataPhoto" class="form-control" placeholder="No file choosen">
										<input name="image"  id="profile-img-photo" type="file" style="display: none;">
                                        
                                        <div class="form-group">
											<div class="row">
                                                <div class="col-sm-6">
													<input type="text" id="autocomplete" onFocus="geolocate()" name="address" class="form-control autocompleteP" placeholder="Current Location">
												</div>
                                                 <div class="col-sm-6">
													<input type="text"  name="email" class="form-control" placeholder="Email">
												</div>
											 </div>
										</div>
                                        <!--<div class="form-group">
											<div class="row">
												<div class="col-sm-6">
													<input type="text" id="locality" name="city" class="form-control localityP" placeholder="City">
												</div>
												<div class="col-sm-6">
													<input type="text" id="administrative_area_level_1" name="state" class="form-control administrative_area_level_1P" placeholder="State">
												</div>
											</div>
										</div>-->
                                       <!-- <div class="form-group">
											<div class="row">
												<div class="col-sm-6">
													<input type="text" id="country"  name="country" class="form-control countryP" placeholder="Country">
												</div>
                                                <div class="col-sm-6">
													<input type="text"  name="email" class="form-control" placeholder="Email">
												</div>
											</div>
										</div>-->
										<div class="form-group">
											<div class="row">
												<div class="col-sm-6">
													<input type="password" id="passwordPhoto" name="password" class="form-control" placeholder="Password">
												</div>
												<div class="col-sm-6">
													<input type="password" name="confirmPassword" class="form-control" placeholder="Confirm Password">
                                                   </div>
											</div>
										</div>
										<input type="submit" value="Submit" class="blue-btn">
									</form>
									<form  enctype="multipart/form-data" id="user-signup" method="post" action="">               <input type="hidden" name="action" value="signup"/>
                                        <input type="hidden" name="userType" value="1"/>
										<div class="signup-img updateIcon">
											<div class="img-wrapper"  id="profile-img-tag" style="background-image: url('<?php echo get_site_url()."/wp-content/uploads/2017/08/avatar.png";?>');"></div>
										</div>
										<div class="form-group">
											<div class="row">
												<div class="col-sm-6">
													<input type="text" class="form-control character" name="firstName" placeholder="First Name">
												</div>
												<div class="col-sm-6">
													<input type="text" class="form-control character"  name="lastName"  placeholder="Last Name">
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="row">
												<div class="col-sm-6">
													<input type="email" class="form-control" name="email" placeholder="Email" value="">
												</div>
												<div class="col-sm-6">
													<!-- <input type="text" class="form-control" placeholder="Phone Number"> -->
													<select class="form-control" name="gender">
														<option value="male">Male</option>
														<option value="female">Female</option>
													</select>
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="row">
												<div class="col-sm-6">
													<input name="dob" id="birthday" type="text" class="form-control" placeholder="Birthday" value="" onfocus="blur();">
												</div>
												<div class="col-sm-6">
													<input type="text" maxLength="15" name="contactNo" class="form-control price_error" placeholder="Phone Number">
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="row">
												<div class="col-sm-6">
													<input type="password" name="password" id="password"  class="form-control" placeholder="Password">
												</div>
												<div class="col-sm-6">
													<input type="password" name="confirmPassword" class="form-control" placeholder="Confirm Password">
												</div>
											</div>
										</div>
                                        <div class="form-group">
											<div class="row">
                                                 <div class="col-sm-12">
													<input type="text" id="autocompleteT" onFocus="geolocatetest()" name="address" class="form-control autocompleteT" placeholder="Current Location">
												</div> 
												<!--<div class="col-sm-6">
													<input type="text" id="locality" name="city" class="form-control localityT" placeholder="City">
												</div>-->
												
											</div>
										</div>
                                        <!--<div class="form-group">
											<div class="row">
                                                  <div class="col-sm-6">
													<input type="text" id="administrative_area_level_1" name="state" class="form-control administrative_area_level_1T" placeholder="State">
												</div>                                           
                                                
												<div class="col-sm-6">
												    <input type="text" id="country"  name="country" class="form-control countryT" placeholder="Country">
                                                </div>
												
											</div>
										</div>-->
										<div style="display:none;" class="form-group">
											<div class="row">
												<div class="col-sm-3">
													<span>Select Image</span>
												</div>
												<div class="col-sm-9">
													<div class="input-group">
														<input type="text" class="form-control" readonly placeholder="No file choosen">
														<input type="hidden" name="profileImage" id="imageData" class="form-control" placeholder="No file choosen">
														<label class="input-group-btn">Choose File <input name="image"  id="profile-img" type="file" style="display: none;"></label>
													</div>
												</div>
											</div>
										</div>
                                        <input type="submit" value="Submit" class="blue-btn">
									</form>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="sideimg" style="background-image: url('<?php echo @$src[0]; ?>');"></div>
							</div>
						</div>
					</div>
				</section>
			</div>
		</main>

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
        initAutocompletetest();
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
            {types: ['geocode']});         

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
          if(place!=undefined){
              for (var i = 0; i < place.address_components.length; i++) {
              var addressType = place.address_components[i].types[0];
              if (componentForm[addressType]) {
                var val = place.address_components[i][componentForm[addressType]];
                  if(val!=''){
                      document.getElementById(addressType).value = val;
                  }

              }
        }
              
          }
       
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
     function geolocatetest() {
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
     var placeSearch, autocomplete;
      var componentForm = {
        //street_number: 'short_name',
       // route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
       // postal_code: 'short_name'
      };
    
    
      function initAutocompletetest() {         
        // location types.
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('autocompleteT')),
            {types: ['geocode']});         

        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        autocomplete.addListener('place_changed', fillInAddresstest);
      }

      function fillInAddresstest() {
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();

        for (var component in componentForm) {
         // document.getElementById(component).value = '';
         // document.getElementById(component).disabled = false;
        }
          //console.log(place);
        // Get each component of the address from the place details
        // and fill the corresponding field on the form.
         /* if(place!=undefined){
              for (var i = 0; i < place.address_components.length; i++) {
              var addressType = place.address_components[i].types[0];
              if (componentForm[addressType]) {
                var val = place.address_components[i][componentForm[addressType]];
                  if(val!=''){
                      document.getElementById(addressType).value = val;
                  }

              }
        }
              
          }*/
       
      }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCS_kV32SWfFmAPm2HIId6zzg73iE_g39k&libraries=places&callback=initAutocomplete"
        async defer></script>
<script src="<?php echo get_stylesheet_directory_uri().'/js/jquery.geocomplete.js'?>"></script>



<?php get_footer(); ?>

