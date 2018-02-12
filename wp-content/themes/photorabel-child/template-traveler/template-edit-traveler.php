<?php
/* Template Name: Update Traveler Profile after Login */
get_header('custom');
$userId=get_custom_user_id();
$profileImage=getUserProfile($userId);
if(empty($profileImage)){
  $profileImage=get_site_url().'/wp-content/uploads/2017/08/avatar.png';
}
?>
<section class="photo-profile edit-profile">
	<div class="container-fluid">
		<!--<div class="customHead">
			<div class="customBox">
				<h1>payment history</h1>
			</div>
			<div class="customBox">
				<a href="#" class="custom-btn btn-blue">Edit</a>
			</div>
		</div>-->

		<div class="row">
			<div class="col-md-3">
				<div class="avatar-section">
					<span class="profile-img" style="background-image: url('<?php echo $profileImage; ?>');"></span>
				</div>
			</div>
			<div class="col-md-9">
				<table>
					<caption>Update Personal Information</caption>
					<tr>
						<th>First Name:</th>
						<td>
							<div class="form-group">
								<input type="text" class="form-control" name="firstName" value="">
							</div>
						</td>
					</tr>
                    <tr>
						<th>Name:</th>
						<td>
							<div class="form-group">
								<input type="text" class="form-control" name="lastName"  value="">
							</div>
						</td>
					</tr>
					<tr>
						<th>Email:</th>
						<td>
							<div class="form-group">
								<input type="text" class="form-control" name="email"  value="">
							</div>
						</td>
					</tr>
					<tr>
						<th>Contact Number:</th>
						<td>
							<div class="form-group">
								<input type="text" class="form-control" name="contactNo" value="">
							</div>
						</td>
					</tr>
					<tr>
						<th>Gender:</th>
						<td>
							<div class="form-group gender">
								<select name="gender" class="form-control">
									<option value="">Male</option>
									<option value="">Female</option>
									<option value="">Other</option>
								</select>
							</div>
						</td>
					</tr>
					<tr>
						<th>Date of Birth:</th>
						<td>
							<div class="form-group bdate">
								<select class="form-control">
									<option value="">1</option>
									<option value="">2</option>
									<option value="">3</option>
								</select>
								<select class="form-control">
									<option value="">1</option>
									<option value="">2</option>
									<option value="">3</option>
								</select>
								<select class="form-control">
									<option value="">1</option>
									<option value="">2</option>
									<option value="">3</option>
								</select>
							</div>
						</td>
					</tr>
					<tr>
						<th>Location:</th>
						<td>
							<div class="form-group">
								<input name="address" type="text" class="form-control">
							</div>
						</td>
					</tr>
                    <tr>
						<th>Location:</th>
						<td>
							<div class="form-group">
								<input name="address" type="button" class="form-control">
							</div>
						</td>
					</tr>
					
				</table>

				<table>
					<caption>Update Password</caption>
					<tr>
						<th>Old Password:</th>
						<td>
							<div class="form-group">
								<input type="text" class="form-control" name="currentPassword">
							</div>
						</td>
					</tr>
					<tr>
						<th>New Password:</th>
						<td>
							<div class="form-group">
								<input type="text" class="form-control" name="newPassword">
							</div>
						</td>
					</tr>
					<tr>
						<th>Confirm Password:</th>
						<td>
							<div class="form-group">
								<input type="text" class="form-control" name="confirmPassword">
							</div>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</section>


<?php 
get_footer('custom');
?>