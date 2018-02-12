    </main>
	<!-- start Edit time/Suggest Time -->
	<div class="modal fade" id="suggestTimePopup" role="dialog" aria-labelledby="gridSystemModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<form id="suggestForm" action="javascript:void(0);">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="gridSystemModalLabel">Suggest Time</h4>
					</div>
					<div class="modal-body">
						<div class="responseSuggest"></div>
						<div class="row">
							<div class="col-md-12 form-group">
								<label>Selected Date</label>
								<input class="form-control" disabled="disabled" type="text" id="startDate" name="startDate" onfocus="blur();" >
							</div>
							<div class="col-md-6 form-group">
								<label>Start Time</label>
								<input type="text" name="startTime" class="form-control timepickerclass" onfocus="blur();">
							</div>
							<div class="col-md-6 form-group">
								<label>End Time</label>
								<input type="text" name="endTime" class="form-control timepickerclass" onfocus="blur();">
							</div>
						</div>
					</div>
					<div class="modal-footer">
                        <button type="button" class="custom-btn btn-blue editTimeRequest">Suggest Time</button>
						<!--<button type="button" class="custom-btn btn-darkBlue" data-dismiss="modal">Close</button>-->						
					</div>
				</form>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
	<!-- end Edit time/Suggest Time -->
	<!-- start Edit time/Suggest Time -->
	<div class="modal fade" id="cancelPopup" role="dialog" aria-labelledby="gridSystemModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<form id="cancelForm" action="javascript:void(0);">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="gridSystemModalLabel">Reason</h4>
					</div>
					<div class="modal-body">
						<div id="responseLoginData"></div>
						<div class="row">							
							<div class="form-group">
                                <label>Reason For Cancel</label>
								<input type="text" name="reason" class="form-control">
							</div>
						</div>
					</div>
                    
					<div class="modal-footer">						
						<button type="button" class="custom-btn btn-blue cancelSave">Submit</button>
                        <!--<button type="button" class="custom-btn btn-darkBlue" data-dismiss="modal">Close</button>-->
	        </div>
	      </form>
	    </div>
	    <!-- /.modal-content -->
	  </div>
	  <!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
	<!-- end Edit time/Suggest Time -->
	<!-- start Shoot Link popup -->
	<div class="modal fade" id="shootLinkPopup" role="dialog" aria-labelledby="gridSystemModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<form id="shootLinkPopupForm" action="javascript:void(0);">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="gridSystemModalLabel">Submit Link</h4>
					</div>
					<div class="modal-body">
						<div id="responseShoot"></div>
						<div class="row">							
							<div class="form-group">
                                <label>Enter Link:</label>
								<input type="url" name="link" class="form-control">
								<input type="hidden" name="userId"  id="sluserId">
								<input type="hidden" name="otherUserId" id="slotherUserId">
								<input type="hidden" name="jobId" id="sljobId">
								<input type="hidden" name="action" value="post_shoot_link">
					       </div>
						</div>
					</div>
					<div class="modal-footer">
                        <button type="button" class="custom-btn btn-blue shootLinkPopupBtn">Submit</button>
						<!--<button type="button" class="custom-btn btn-darkBlue" data-dismiss="modal">Close</button>-->
	               </div>
	      </form>
	    </div>
	    <!-- /.modal-content -->
	  </div>
	  <!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
<!-- end Shoot Link popup -->

	<!-- start Rating popup -->
	<div class="modal fade" id="ratingPopup" role="dialog" aria-labelledby="gridSystemModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<form id="ratingPopupForm" action="javascript:void(0);">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="gridSystemModalLabel">Feedback</h4>
					</div>
					<div class="modal-body">
						<div class="responserate"></div>
						<div class="row">							
							<div class="form-group">
                                <label>Enter Comment:</label>                            
                             	<input type="text" name="comment" class="form-control">
                                 <input name="rateValue" value="0" id="rating_star" type="hidden" postID="1" />
								<input type="hidden" name="jobId" id="ratingjobId">
								<input type="hidden" name="userId" id="ratingUser">
								<input type="hidden" name="action" value="post_rating">
					       </div>
						</div>
					</div>
					<div class="modal-footer">
						
						<button type="button" class="custom-btn btn-blue ratingPopupBtn">Submit Feedback</button>
                        <!--<button type="button" class="custom-btn btn-darkBlue" data-dismiss="modal">Close</button>-->
	        </div>
	      </form>
	    </div>
	    <!-- /.modal-content -->
	  </div>
	  <!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
<!-- end Rating popup -->
	<!-- start Questions popup -->
	<div class="modal fade" id="suggestRoutePopup" role="dialog" aria-labelledby="gridSystemModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<form id="suggestRouteForm" action="javascript:void(0);">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="gridSystemModalLabel">Suggest Route</h4>
					</div>
					<div class="modal-body">
						<div id="responseRoute"></div>
						<div class="row">							
							<div class="form-group text-center">
                               <!--<label>Enter Route</label>-->
                                <input type="hidden" name="action" value="suggest_route" />
                                <input type="hidden" class="userId" name="userId" value="" />
                                <input type="hidden"  name="jobId" value="<?php echo $_GET['jobId']; ?>" />
                                <input class="form-control"  type="text" name="route" />
					       </div>
						</div>
					</div>
					<div class="modal-footer">
						
						<button type="button" class="custom-btn btn-blue postSuggestRoute">Submit</button>
                       <!-- <button type="button" class="custom-btn btn-darkBlue" data-dismiss="modal">Close</button>-->
	        </div>
	      </form>
	    </div>
	    <!-- /.modal-content -->
	  </div>
	  <!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
<!-- end Questions popup -->
<div class="loading_image" style="display:none;">
    <div class="loaderWrapper">
    <img  alt="loader"  src="<?php echo get_stylesheet_directory_uri();?>/images/loader.gif">
        </div>
</div>
<?php 
session_start();
$hireType='0';
if(isset($_SESSION['type']) and !empty($_SESSION['type']) and $_SESSION['type']=='hire'){
  $hireType='1';  
}
$loginUserDetails=get_custom_user_id();
?><input type="hidden" id="hiringValue" value="<?php echo $hireType; ?>" name="hT"/>
	<script>
	var loginResponse='';
	var SITE_URL='<?php echo site_url(); ?>';
    var hireType='<?php echo $hireType; ?>';
    var loginUserDetails='<?php echo $loginUserDetails; ?>';
    if(loginUserDetails!='' || loginUserDetails!=0){
       $('#menu-item-924').hide(); 
       $('.menu-item-924').hide(); 
    }
	</script>
<script src="<?php echo get_stylesheet_directory_uri().'/js/jquery.timepicker.min.js'; ?>"></script>
<script>
$(document).ready(function() {
        $('.timepickerclass').timepicker();
        $(document).on('blur','#searchDataForm .timepickerclass', function (){
            var current_day=$('#searchDate').val();
            var d = new Date();
            var day = d.getDate();
            var month = d.getMonth() + 1;
            var year = d.getFullYear();
            if (day < 10) {
                day = "0" + day;
            }
            if (month < 10) {
                month = "0" + month;
            }
            var date = day + "/" + month + "/" + year;          
            if(current_day == date)
            {               
              $('#searchDataForm .timepickerclass').timepicker('option', 'minTime', new Date());
            }else{
              $('#searchDataForm .timepickerclass').timepicker('option', 'minTime', '00:00'); 
            }

        }); 
        $(document).on('change','#searchDate',function(){
            var current_day=$('#searchDate').val();
            var d = new Date();
            var day = d.getDate();
            var month = d.getMonth() + 1;
            var year = d.getFullYear();
            if (day < 10) {
                day = "0" + day;
            }
            if (month < 10) {
                month = "0" + month;
            }
            var date = day + "/" + month + "/" + year;          
            if(current_day == date)
            {               
              $('#searchDataForm .timepickerclass').timepicker('option', 'minTime', new Date());
            }else{
              $('#searchDataForm .timepickerclass').timepicker('option', 'minTime', '00:00'); 
            }
        }); 
        $(document).on('blur','#hireForm .timepickerclass', function (){
            var current_day=$('#sendRequestDate').val();
            var d = new Date();
            var day = d.getDate();
            var month = d.getMonth() + 1;
            var year = d.getFullYear();
            if (day < 10) {
                day = "0" + day;
            }
            if (month < 10) {
                month = "0" + month;
            }
            var date = day + "/" + month + "/" + year;          
            if(current_day == date)
            {
             /* $('#hireForm .timepickerclass').timepicker('setTime',new Date()); */ 
              $('#hireForm .timepickerclass').timepicker('option', 'minTime',new Date()); 
            }else{
              $('#hireForm .timepickerclass').timepicker('option', 'minTime', '00:00'); 
            }

        });
        $(document).on('change','#sendRequestDate',function(){
            var current_day=$('#sendRequestDate').val();
            var d = new Date();
            var day = d.getDate();
            var month = d.getMonth() + 1;
            var year = d.getFullYear();
            if (day < 10) {
                day = "0" + day;
            }
            if (month < 10) {
                month = "0" + month;
            }
            var date = day + "/" + month + "/" + year;          
            if(current_day == date)
            {               
              $('#hireForm .timepickerclass').timepicker('option', 'minTime', new Date());
            }else{
              $('#hireForm .timepickerclass').timepicker('option', 'minTime', '00:00'); 
            } 
        });	
        $(document).on('blur','#suggestForm .timepickerclass', function (){
            var current_day=$('#startDate').val();
            var d = new Date();
            var day = d.getDate();
            var month = d.getMonth() + 1;
            var year = d.getFullYear();
            if (day < 10) {
                day = "0" + day;
            }
            if (month < 10) {
                month = "0" + month;
            }
            var date = day + "/" + month + "/" + year;          
            if(current_day == date)
            {
              $('#suggestForm .timepickerclass').timepicker('option', 'minTime', new Date());           
            }else{
              $('#suggestForm .timepickerclass').timepicker('option', 'minTime', '00:00');  
            }

        });
        $(document).on('change','#startDate',function(){
            var current_day=$(this).val();
            var d = new Date();
            var day = d.getDate();
            var month = d.getMonth() + 1;
            var year = d.getFullYear();
            if (day < 10) {
                day = "0" + day;
            }
            if (month < 10) {
                month = "0" + month;
            }
            var date = day + "/" + month + "/" + year;          
            if(current_day == date)
            {
              $('#suggestForm .timepickerclass').timepicker('option', 'minTime', new Date());           
            }else{
              $('#suggestForm .timepickerclass').timepicker('option', 'minTime', '00:00');  
            } 
       });   
});
</script>
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
</body>
</html>