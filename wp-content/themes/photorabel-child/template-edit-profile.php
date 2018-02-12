<?php
/* Template Name: Edit Profile Template */
get_header('custom');
$userId=get_custom_user_id();
$getUserType=get_user_meta($userId,'userType',true);
$profileImage=getUserProfile($userId);
if(empty($profileImage)){
	$profileImage=get_site_url().'/wp-content/uploads/2017/08/avatar.png';
}
?>
<section class="photo-profile edit-profile">
	<div class="container-fluid">
		<div class="customHead">
			<div class="customBox">
				<h1>Update Profile</h1>
			</div>
			<!--<div class="customBox">
				<a href="#" class="custom-btn btn-blue">Edit</a>
			</div>-->
		</div>
		<div class="row">
			<div class="col-md-3">
				<div class="avatar-section updateIcon">
					<span class="profile-img-update profile-img updateProfileImage" style="background-image: url('<?php echo $profileImage; ?>');"></span>
				</div>
			</div>
			<div class="col-md-9">
				<form name="updateProfile" action="" class="hasInputIcon" id="updateProfileForm">
					<input type="file" id="selectImage" class="hidden" />
					<input type="hidden" name="profileImage" id="selectedimage" />
					<input type="hidden" name="optype" value="web" />
					<div class="responses"></div>
					<table>
						<caption>Update Personal Information</caption>
						<tr>
							<th>First Name:</th>
							<td>
								<div class="form-group">
									<input type="text" class="form-control character" name="firstName" value="<?php echo get_user_meta($userId,'firstName',true);?>">
									<svg class="user" width="15px" height="15px" viewBox="5.508 3.1 19.984 18.6">
										<circle cx="15.5" cy="8.267" r="5.167"></circle>
										<path d="M25.492,21.7c-1.146-3.565-5.166-6.2-9.992-6.2c-4.826,0-8.845,2.635-9.992,6.2H25.492z"></path>
									</svg>
								</div>
							</td>
						</tr>
						<tr>
							<th>Last Name:</th>
							<td>
								<div class="form-group">
									<input type="text" class="form-control character" name="lastName" value="<?php echo get_user_meta($userId,'lastName',true);?>">
									<svg class="user" width="15px" height="15px" viewBox="5.508 3.1 19.984 18.6">
										<circle cx="15.5" cy="8.267" r="5.167"></circle>
										<path d="M25.492,21.7c-1.146-3.565-5.166-6.2-9.992-6.2c-4.826,0-8.845,2.635-9.992,6.2H25.492z"></path>
									</svg>
								</div>
							</td>
						</tr>
						<tr>
							<th>Email:</th>
							<td>
								<div class="form-group">
									<input type="readonly" disabled class="form-control" name="email" value="<?php echo getUserEmail($userId); ?>">
									<svg class="email" width="15px" height="15px" viewBox="5.332 6.2 20.336 12.399" >
										<g transform="translate(0,-952.36218)">
											<path d="M5.58,958.562c-0.138,0-0.248,0.11-0.248,0.248v0.248l10.168,7.805l10.168-7.805v-0.248c0-0.138-0.11-0.248-0.248-0.248 H5.58z M5.332,960.306v10.408c0,0.138,0.11,0.248,0.248,0.248h19.84c0.138,0,0.248-0.11,0.248-0.248v-10.408l-9.866,7.572 c-0.178,0.137-0.426,0.137-0.604,0L5.332,960.306z"></path>
										</g>
									</svg>
								</div>
							</td>
						</tr>
						<tr>
							<th>Contact Number:</th>
							<td>
								<div class="form-group">
									<input type="text"  maxlength="15"  class="form-control price_error" name="contactNo" value="<?php echo get_user_meta($userId,'contactNo',true);?>">
									<svg class="phone" width="15px" height="15px" viewBox="9.176 0.744 12.648 23.313">
										<path d="M20.212,0.744h-9.424c-0.893,0-1.612,0.719-1.612,1.612v20.087c0,0.894,0.719,1.613,1.612,1.613h9.424 c0.894,0,1.612-0.72,1.612-1.613V2.356C21.824,1.463,21.105,0.744,20.212,0.744z M15.004,2.728h0.992c0.348,0,0.62,0.273,0.62,0.62 s-0.272,0.62-0.62,0.62h-0.992c-0.347,0-0.62-0.272-0.62-0.62S14.657,2.728,15.004,2.728z M16.492,21.824h-1.984 c-0.347,0-0.62-0.273-0.62-0.62s0.272-0.62,0.62-0.62h1.984c0.348,0,0.619,0.273,0.619,0.62S16.84,21.824,16.492,21.824z M20.584,19.096H10.416V5.208h10.168V19.096z"></path>
									</svg>
								</div>
							</td>
						</tr>
						<tr>
							<th>Gender:</th>
							<td>
								<?php $array=array(''=>'Select','male'=>'Male','female'=>'Female'); ?>
								<div class="form-group gender">
									<select name="gender" class="form-control">
										<?php
										$gender=get_user_meta($userId,'gender',true);
										if(!empty($array)) {
											foreach($array as $k=>$v) {
												$selected="";
												if($gender==$k) {
													$selected="selected";
												}
												?>
												<option <?php echo $selected; ?> value="<?php echo $k; ?>"><?php echo $v; ?></option>
												<?php
											}
										}
										?>
									</select>
									<svg class="gender" width="15px" height="15px" viewBox="7.563 4.464 15.873 15.872">
										<path d="M21.948,6.448c0,1.096-0.889,1.984-1.984,1.984S17.98,7.544,17.98,6.448c0-1.096,0.888-1.984,1.983-1.984 S21.948,5.352,21.948,6.448z M21.948,9.424H17.98c-0.822,0-1.488,0.667-1.488,1.488v2.976c0,0.822,0.666,1.488,1.488,1.488v3.968 c0,0.549,0.443,0.992,0.992,0.992h1.983c0.548,0,0.992-0.443,0.992-0.992v-3.968c0.821,0,1.487-0.666,1.487-1.488v-2.976 C23.436,10.09,22.77,9.424,21.948,9.424z M9.548,6.448c0,1.096,0.889,1.984,1.984,1.984s1.984-0.888,1.984-1.984 c0-1.096-0.888-1.984-1.984-1.984S9.548,5.352,9.548,6.448z M8.601,16.864h1.443v2.479c0,0.549,0.444,0.992,0.992,0.992h0.992 c0.548,0,0.992-0.443,0.992-0.992v-2.479h1.443c0.573,0,1.037-0.464,1.037-1.037c0-0.132-0.025-0.264-0.075-0.387l-2.029-5.079 c-0.226-0.566-0.774-0.938-1.384-0.938h-0.96c-0.61,0-1.158,0.371-1.384,0.938L7.638,15.44c-0.213,0.531,0.044,1.135,0.575,1.349 C8.336,16.839,8.468,16.864,8.601,16.864z">
                                        </path>
									</svg>
								</div>
							</td>
						</tr>
						<tr>
							<th>Date Of Birth:</th>
							<td>
								<div class="form-group bdate">
									<input type="text" class="form-control" name="dob" id="birthday" value="<?php echo get_user_meta($userId,'dob',true); ?>" readonly>
									<svg class="calendar" width="15px" height="15px" viewBox="-945.007 951.62 22.965 23.56">
										<g>
											<path d="M-925.465,953.679v2.951h-3.422v-2.951h-9.25v2.951h-3.422v-2.951h-3.447v21.501h22.965v-21.501H-925.465z M-923.183,961.268v3.472h-6.076v-3.472H-923.183z M-936.55,969.377v-3.447h6.125v3.447H-936.55z M-930.45,970.542v3.473h-6.125 v-3.473H-930.45z M-937.741,969.377h-6.076v-3.447h6.076V969.377z M-936.55,964.739v-3.472h6.125v3.472H-936.55z M-929.259,965.904 h6.076v3.447h-6.076V965.904z M-937.741,961.268v3.472h-6.076v-3.472H-937.741z M-943.817,970.542h6.076v3.473h-6.076V970.542z M-929.259,974.015v-3.473h6.076v3.473H-929.259z"></path>
											<rect x="-940.667" y="951.62" width="1.661" height="4.142"></rect>
											<rect x="-927.994" y="951.62" width="1.661" height="4.142"></rect>
										</g>
									</svg>
								</div>
							</td>
						</tr>
						<tr>
							<th>Location:</th>
							<td>
								<div class="form-group">
									<input type="text" class="form-control" id="autocomplete" name="address" value="<?php echo get_user_meta($userId,'address',true); ?>">
									<svg class="pin" width="15px" height="15px" viewBox="9.26 3.939 12.48 16.921" enable-background="new 9.26 3.939 12.48 16.921" xml:space="preserve">
										<path d="M15.5,3.939c-3.446,0-6.24,2.794-6.24,6.24S15.5,20.86,15.5,20.86s6.24-7.235,6.24-10.682 C21.74,6.733,18.946,3.939,15.5,3.939z M15.5,13.392c-1.872,0-3.39-1.518-3.39-3.39c0-1.872,1.518-3.389,3.39-3.389 s3.39,1.518,3.39,3.389C18.89,11.875,17.372,13.392,15.5,13.392z"></path>
									</svg>
								</div>
							</td>
						</tr>
						<?php if(empty($getUserType)) {
							?>
							<tr>
								<th>Hourly Rate:</th>
								<td>
									<div class="form-group">
										<input type="text"  maxlength="6"  class="form-control price_error" name="hourlyRate" value="<?php echo get_user_meta($userId,'hourlyRate',true); ?>">

										<svg class="calendar" width="15px" height="15px" viewBox="-945.007 951.62 22.965 23.56">
											<g>
												<path d="M-925.465,953.679v2.951h-3.422v-2.951h-9.25v2.951h-3.422v-2.951h-3.447v21.501h22.965v-21.501H-925.465z M-923.183,961.268v3.472h-6.076v-3.472H-923.183z M-936.55,969.377v-3.447h6.125v3.447H-936.55z M-930.45,970.542v3.473h-6.125 v-3.473H-930.45z M-937.741,969.377h-6.076v-3.447h6.076V969.377z M-936.55,964.739v-3.472h6.125v3.472H-936.55z M-929.259,965.904 h6.076v3.447h-6.076V965.904z M-937.741,961.268v3.472h-6.076v-3.472H-937.741z M-943.817,970.542h6.076v3.473h-6.076V970.542z M-929.259,974.015v-3.473h6.076v3.473H-929.259z"></path>
												<rect x="-940.667" y="951.62" width="1.661" height="4.142"></rect>
												<rect x="-927.994" y="951.62" width="1.661" height="4.142"></rect>
											</g>
										</svg>
									</div>
								</td>
							</tr>
                            <tr>
                                    <th>Experience:</th>
                                    <td>
                                        <div class="form-group">
                                            <input type="text"  maxlength="2"  class="form-control price_error" name="experience" value="<?php echo get_user_meta($userId,'experience',true); ?>">
                                            
                                            <svg class="calendar" width="15px" height="15px" viewBox="-945.007 951.62 22.965 23.56">
											<g>
												<path d="M-925.465,953.679v2.951h-3.422v-2.951h-9.25v2.951h-3.422v-2.951h-3.447v21.501h22.965v-21.501H-925.465z M-923.183,961.268v3.472h-6.076v-3.472H-923.183z M-936.55,969.377v-3.447h6.125v3.447H-936.55z M-930.45,970.542v3.473h-6.125 v-3.473H-930.45z M-937.741,969.377h-6.076v-3.447h6.076V969.377z M-936.55,964.739v-3.472h6.125v3.472H-936.55z M-929.259,965.904 h6.076v3.447h-6.076V965.904z M-937.741,961.268v3.472h-6.076v-3.472H-937.741z M-943.817,970.542h6.076v3.473h-6.076V970.542z M-929.259,974.015v-3.473h6.076v3.473H-929.259z"></path>
												<rect x="-940.667" y="951.62" width="1.661" height="4.142"></rect>
												<rect x="-927.994" y="951.62" width="1.661" height="4.142"></rect>
											</g>
										</svg>
                                        </div>
                                </td>
                            </tr>
							<tr>
								<th>Minimum No. Of Hours:</th>
								<td>
									<div class="form-group">
										<input  maxlength="2"  type="text" class="form-control price_error" name="minHours" value="<?php echo get_user_meta($userId,'minHours',true); ?>">

										<svg class="calendar" width="15px" height="15px" viewBox="-945.007 951.62 22.965 23.56">
											<g>
												<path d="M-925.465,953.679v2.951h-3.422v-2.951h-9.25v2.951h-3.422v-2.951h-3.447v21.501h22.965v-21.501H-925.465z M-923.183,961.268v3.472h-6.076v-3.472H-923.183z M-936.55,969.377v-3.447h6.125v3.447H-936.55z M-930.45,970.542v3.473h-6.125 v-3.473H-930.45z M-937.741,969.377h-6.076v-3.447h6.076V969.377z M-936.55,964.739v-3.472h6.125v3.472H-936.55z M-929.259,965.904 h6.076v3.447h-6.076V965.904z M-937.741,961.268v3.472h-6.076v-3.472H-937.741z M-943.817,970.542h6.076v3.473h-6.076V970.542z M-929.259,974.015v-3.473h6.076v3.473H-929.259z"></path>
												<rect x="-940.667" y="951.62" width="1.661" height="4.142"></rect>
												<rect x="-927.994" y="951.62" width="1.661" height="4.142"></rect>
											</g>
										</svg>
									</div>
								</td>
							</tr>
							<tr>
								<th>Bio:</th>
								<td>
									<div class="form-group">
										<textarea name="bio" class="form-control"><?php echo trim(get_user_meta($userId,'bio',true)); ?>
										</textarea>
										<svg class="cv" width="15px" height="15px" viewBox="5.58 0 19.84 24.8">
											<g>
												<polygon points="20.46,0 20.46,4.96 25.42,4.96 	"></polygon>
												<path d="M17.98,0H6.82C6.076,0,5.58,0.496,5.58,1.24v22.32c0,0.744,0.496,1.239,1.24,1.239h17.36c0.744,0,1.24-0.495,1.24-1.239 V7.44H17.98V0z M11.78,2.48c1.364,0,2.48,1.116,2.48,2.48c0,1.364-1.116,2.48-2.48,2.48c-1.364,0-2.48-1.116-2.48-2.48 C9.3,3.596,10.416,2.48,11.78,2.48z M11.78,8.68c2.108,0,3.72,1.612,3.72,3.72H8.06C8.06,10.292,9.672,8.68,11.78,8.68z M17.98,22.32H9.3c-0.744,0-1.24-0.496-1.24-1.24s0.496-1.24,1.24-1.24h8.681c0.744,0,1.24,0.496,1.24,1.24 S18.725,22.32,17.98,22.32z M21.7,14.88c0.743,0,1.239,0.496,1.239,1.24s-0.496,1.239-1.239,1.239H9.3 c-0.744,0-1.24-0.495-1.24-1.239s0.496-1.24,1.24-1.24H21.7z"></path>
											</g>
										</svg>
									</div>
								</td>
							</tr>
							<tr>
								<th>Banner Image:</th>
								<td>
									<div class="form-group">
										<!-- <input type='file' id="fileUploader" />
										<input type="hidden" name="bannerImage" id="bner" /> -->
										<div class="input-group upImage">
											<input type="text" class="form-control" readonly="" placeholder="No file choosen">
											<label class="input-group-btn">
												Choose File
												<input type='file' id="fileUploader" style="display: none;" multiple="">
												<input type="hidden" name="bannerImage" id="bner" />
											</label>
										</div>
										<svg class="cv" width="15px" height="15px" viewBox="5.58 0 19.84 24.8">
											<g>
												<polygon points="20.46,0 20.46,4.96 25.42,4.96 	"></polygon>
												<path d="M17.98,0H6.82C6.076,0,5.58,0.496,5.58,1.24v22.32c0,0.744,0.496,1.239,1.24,1.239h17.36c0.744,0,1.24-0.495,1.24-1.239 V7.44H17.98V0z M11.78,2.48c1.364,0,2.48,1.116,2.48,2.48c0,1.364-1.116,2.48-2.48,2.48c-1.364,0-2.48-1.116-2.48-2.48 C9.3,3.596,10.416,2.48,11.78,2.48z M11.78,8.68c2.108,0,3.72,1.612,3.72,3.72H8.06C8.06,10.292,9.672,8.68,11.78,8.68z M17.98,22.32H9.3c-0.744,0-1.24-0.496-1.24-1.24s0.496-1.24,1.24-1.24h8.681c0.744,0,1.24,0.496,1.24,1.24 S18.725,22.32,17.98,22.32z M21.7,14.88c0.743,0,1.239,0.496,1.239,1.24s-0.496,1.239-1.239,1.239H9.3 c-0.744,0-1.24-0.495-1.24-1.239s0.496-1.24,1.24-1.24H21.7z"></path>
											</g>
										</svg>
										<img id="preview" alt="No Banner Image Selected" src="<?php echo getBannerProfile($userId); ?>" />
									</div>
								</td>
							</tr>
							<?php
						} ?>
						<tr>
							<th></th>
							<td>
								<div class="form-group">
									<input type="hidden" name="userId" value="<?php echo $userId; ?>" />
									<input type="hidden" name="action" value="update_profile" />
									<button class="custom-btn btn-blue updateProfile" type="button" name="save">Save</button>
								</div>
							</td>
						</tr>
					</table>
				</form>
				<form name="resetPassword" action="" class="hasInputIcon" id="resetPasswordForm">
					<div class="response"></div>
					<input type="hidden" id="userId" value="<?php echo $userId; ?>" />
					<table>
						<caption>Update Password</caption>
						<tr>
							<th>Old Password:</th>
							<td>
								<div class="form-group">
									<input type="password" class="form-control" name="currentPassword">
									<svg class="lock" width="15px" height="15px" viewBox="7.068 0 16.864 24.8">
										<path d="M22.072,10.252v-3.68C22.072,2.948,19.124,0,15.5,0S8.928,2.948,8.928,6.572v3.68l-1.86,0.164v13.641L15.5,24.8l8.432-0.743 V10.416L22.072,10.252z M10.912,10.077V6.572c0-2.53,2.058-4.588,4.588-4.588c2.529,0,4.588,2.058,4.588,4.588v3.505L15.5,9.672 L10.912,10.077z"></path>
									</svg>
								</div>
							</td>
						</tr>
						<tr>
							<th>New Password:</th>
							<td>
								<div class="form-group">
									<input type="password" class="form-control" name="newPassword">
									<svg class="lock" width="15px" height="15px" viewBox="7.068 0 16.864 24.8">
										<path d="M22.072,10.252v-3.68C22.072,2.948,19.124,0,15.5,0S8.928,2.948,8.928,6.572v3.68l-1.86,0.164v13.641L15.5,24.8l8.432-0.743 V10.416L22.072,10.252z M10.912,10.077V6.572c0-2.53,2.058-4.588,4.588-4.588c2.529,0,4.588,2.058,4.588,4.588v3.505L15.5,9.672 L10.912,10.077z"></path>
									</svg>
								</div>
							</td>
						</tr>
						<tr>
							<th>Confirm Password:</th>
							<td>
								<div class="form-group">
									<input type="password" class="form-control" name="confirmPassword">
									<svg class="lock" width="15px" height="15px" viewBox="7.068 0 16.864 24.8">
										<path d="M22.072,10.252v-3.68C22.072,2.948,19.124,0,15.5,0S8.928,2.948,8.928,6.572v3.68l-1.86,0.164v13.641L15.5,24.8l8.432-0.743 V10.416L22.072,10.252z M10.912,10.077V6.572c0-2.53,2.058-4.588,4.588-4.588c2.529,0,4.588,2.058,4.588,4.588v3.505L15.5,9.672 L10.912,10.077z"></path>
								</div>
							</td>
						</tr>
						<tr>
							<th></th>
							<td>
								<div class="form-group">
									<button type="button" id="resetPassword" class="custom-btn btn-blue" name="savePassword">Save</button>
								</div>
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>
	</div>
</section>
<?php
if(empty($getUserType)) {
	?>
	<section class="rating bg-gray ports">
		<div class="container-fluid">
			<h2>Update Portfolio</h2>
			<div class="responsePort"></div>
			<div class="responsePortfolio"></div>
			<div class="porfolios">
                <?php
                     $portfolioImages=getPortFolioImages($userId);
						$portfolioArray=array();    
                        if(empty($portfolioImages)) {
							?>
							<p class="w100p text-center hideport">No Portfolio images are found.</p>
							<?php
						}
                    ?>
				<form id="updatePortfolioForm" method="post">
					<input type="hidden" name="userId" value="<?php echo $userId; ?>">
					<input type="hidden" name="action" value="update_portfolio">
					<div class="row align-items-center">
						<div class="col-xs-12 col-sm-6 col-md-5div">
							<div class="port-img create-new">
								<a href="#" class="delete-tumb"><i class="fa fa-plus"></i></a>
								<input id="portfiles" multiple type="file" class="hide" name="portFolio">
							</div>
						</div>
						<?php 						
						if(!empty($portfolioImages)) {
							$counter=0;
							foreach($portfolioImages as $k=>$v) {
								$image=getAttachmentImageById($v['image']);
								if(!empty($image)) {
									?>
									<div class="col-xs-12 col-sm-6 col-md-5div">
										<div class="port-img" style="background-image: url('<?php echo $image; ?>');">
											<a href="javascript:void(0);" confirm="return 'Are you sure to delete the image ?'" data-attr-id="<?php echo $v['id']; ?>" class="delete-tumb deletePortfolio"><i class="fa fa-times"></i></a>
										</div>
									</div>
									<?php
								}
							}
						} ?>
					</div>
					<div class="row" id="resultPort"></div>
					<input type="button" id="updatePortfolioBtn" class="custom-btn btn-blue" value="Update" />
				</form>
			</div>
		</div>
	</section>
	<section class="rating bg-gray edit-profile">
		<div class="container-fluid">
			<div class="rating-section">
				<h2>Schedule</h2>
				<div id="responseSchedule"></div>
				<form id="schedule" action="javascript:void(0);">
					<input type="hidden" name="action" value="post_schedule" />
					<ul class="schedule">
						<?php 
						for($counter=0;$counter<=6;$counter++) {
							if($counter==0) {
								$day='sunday';
							} elseif($counter==1) {
								$day='monday';
							} elseif($counter==2) {
								$day='tuesday';
							} elseif($counter==3) {
								$day='wednesday';
							} elseif($counter==4) {
								$day='thursday';
							} elseif($counter==5) {
								$day='friday';
							} else {
								$day='saturday';
							}
							$day=ucfirst($day);
							$sunday=getPhotographerBusySchedule($userId,$counter);
							if(!empty($sunday)) {
								?>
								<li>
									<?php
									$count=count($sunday);
									foreach($sunday as $k=>$v) {
										?>
										<div>
											<div>
												<?php
												if($k==0) {
													?>
													<strong><?php echo $day; ?></strong>
													<?php
												} ?>
											</div>
											<div>
												<div class="form-group">
													<label>From</label>
													<input type="text" value="<?php echo $v['startTime'];?>" name="<?php echo $counter; ?>[startTime][]" class="form-control timepickerclass" readonly>
												</div>
												<div class="form-group">
													<label>to</label>
													<input type="text" value="<?php echo $v['endTime'];?>" name="<?php echo $counter; ?>[endTime][]" class="form-control timepickerclass" readonly>
												</div>
											</div>
											<div class="inner">
												<?php if($k==0) {
													?>
													<a href="javascript:void(0);" class="addmore">+</a>
													<?php
												} else {
													?>
													<a href="javascript:void(0);" class="removeContent">-</a>
													<?php
												} ?>
											</div>
										</div>
										<?php
									} ?>
								</li>
								<?php
							} else {
								?>
								<li>
									<div>
										<div><strong><?php echo $day; ?></strong></div>
										<div>
											<div class="form-group">
												<label>From</label>
												<input type="text" name="<?php echo $counter; ?>[startTime][]" class="form-control timepickerclass" readonly>
											</div>
											<div class="form-group">
												<label>to</label>
												<input type="text" name="<?php echo $counter; ?>[endTime][]" class="form-control timepickerclass" readonly>
											</div>
										</div>
										<div class="inner">
											<a href="javascript:void(0);" class="addmore">+</a>
										</div>
									</div>
								</li>
								<?php
							}
						} ?>
					</ul>
					<p id="test"></p>
					<input type="button" id="saveSchedule" class="custom-btn btn-blue" value="Save" />
				</form>
			</div>
		</div>
	</section>
	<?php } ?>
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
				/** @type {!HTMLInputElement} */
				(document.getElementById('autocomplete')), { types: ['geocode'] }
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
			if (place != undefined) {
				for (var i = 0; i < place.address_components.length; i++) {
					var addressType = place.address_components[i].types[0];
					if (componentForm[addressType]) {
						var val = place.address_components[i][componentForm[addressType]];
						if (val != '') {
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
				/** @type {!HTMLInputElement} */
				(document.getElementById('autocompleteT')), { types: ['geocode'] }
			);

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

			// Get each component of the address from the place details
			// and fill the corresponding field on the form.
			if (place != undefined) {
				for (var i = 0; i < place.address_components.length; i++) {
					var addressType = place.address_components[i].types[0];
					if (componentForm[addressType]) {
						var val = place.address_components[i][componentForm[addressType]];
						if (val != '') {
							document.getElementById(addressType).value = val;
						}
					}
				}
			}
		}
	</script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCS_kV32SWfFmAPm2HIId6zzg73iE_g39k&libraries=places&callback=initAutocomplete" async defer></script>
	<script src="<?php echo get_stylesheet_directory_uri().'/js/jquery.geocomplete.js'?>"></script>
	<script></script>
	<?php 
	get_footer('custom');
	?>