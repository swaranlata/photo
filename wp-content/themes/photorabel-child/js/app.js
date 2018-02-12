(function($) {
    $(window).on('resize',function(){
   // $(window).on('resize scroll',function(){
       $('.ui-timepicker-container').addClass('ui-helper-hidden ui-timepicker-hidden');            
     });
	$(window).on("load",function(){
		$(".notificationModule").next().mCustomScrollbar({
			scrollButtons:{
				enable:true
			},
			theme:"light-3"
		});

		$("#mainNav .navbar-collapse .navbar-nav.sidebar-nav ul").mCustomScrollbar({
			scrollButtons:{
				enable:true
			},
			theme:"light-3"
		});

		$(".tableContainer").mCustomScrollbar({
			axis:"x", // horizontal scrollbar
			mouseWheel:{
				enable: false
			},
			scrollButtons:{
				enable:true
			},
			theme:"light-3"
		});
	});
})(jQuery);
$(function() {
	$('.loading_image').show();
    $('body').addClass('siteLoading');
	// We can attach the `fileselect` event to all file inputs on the page
	$(document).on('change', ':file', function() {
		var input = $(this),
			numFiles = input.get(0).files ? input.get(0).files.length : 1,
			label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
		input.trigger('fileselect', [numFiles, label]);
	});
	// We can watch for our custom `fileselect` event like this
	$(document).ready(function() {
		$(':file').on('fileselect', function(event, numFiles, label) {
            console.log('aa');

			var input = $(this).parents('.input-group').find(':text'),
				log = numFiles > 1 ? numFiles + ' files selected' : label;

			if (input.length) {
				input.val(log);
			}
		});
	});

	$(document).on('keydown', '.price_error', function (e) {
        -1 !== $.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) || /65|67|86|88/.test(e.keyCode) && (!0 === e.ctrlKey || !0 === e.metaKey) || 35 <= e.keyCode && 40 >= e.keyCode || (e.shiftKey || 48 > e.keyCode || 57 < e.keyCode) && (96 > e.keyCode || 105 < e.keyCode) && e.preventDefault()

    });
	$('.input-group > input').on('click', function() {
		$(this).parent().find(':file').trigger('click');
	});
    /* Admin js start*/
    function allEvents() {
		var navHeight = $('#mainNav').outerHeight();
		var navWidth = $('#mainNav .navbar-collapse .navbar-nav.sidebar-nav').outerWidth();
		var navWidthInner = $('#mainNav .navbar-collapse .navbar-nav.sidebar-nav > ul > li').outerWidth();
		var winHeight = $(window).outerHeight();
		var winWidth = $(window).outerWidth();
		var marRight = (navWidth - navWidthInner) * -1;
		$('#mainNav .navbar-collapse .navbar-nav.sidebar-nav').removeAttr('style');
		$('#mainNav .navbar-collapse .navbar-nav.sidebar-nav').css({
			'padding-top': navHeight/*,
			'height': winHeight + 18 - navHeight*/
		});
		$('.admin-section').css({
			'margin-left': navWidth,
			'margin-top': navHeight,
			// 'width': (winWidth - navWidth) - 17
			// 'width': (winWidth - navWidth) - 17
		});

		var ua = window.navigator.userAgent;
		var msie = ua.indexOf('MSIE ');
		var trident = ua.indexOf('Trident/');
		if (msie > 0) {
			$('.admin-section').css({'width': (winWidth - navWidth) - 20});
		} else {
			$('.admin-section').css({'width': (winWidth - navWidth) - 17});
		}

		/*$('#mainNav .navbar-collapse .navbar-nav.sidebar-nav > ul').css({
			"margin-right": marRight
		});*/

		if (winWidth < 992) {
			$('#mainNav .navbar-collapse .navbar-nav.sidebar-nav, .admin-section').removeAttr('style');
		}

		var a = window.location.pathname;
		$('.sidebar-nav ul li').each(function() {
			var b = $(this).find('a').attr('href');
			if (a.indexOf(b) > -1) {
				console.log(a + ' = ' + b);
				$(this).addClass('current-menu-item');
				$(this).siblings().removeClass('current-menu-item');
			} else {
				$(this).removeClass('current-menu-item');
			}
		});

		var smallWidth = $('.noti-count small').outerWidth() + 10;
		$('.noti-count').css({
			'height': smallWidth,
			'width': smallWidth
		});
	}

	/*/////////////////////////// Event Area ///////////////////////////*/

	/* Ready Event */
	allEvents();

	/* Load Event */
	$(window).on('load', function() {
		allEvents();
	});
	/* Resize Event */
	$(window).on('resize', function() {
		allEvents();
		$('.mCustomScrollBox').removeAttr('style');
		$(".notificationModule").next().mCustomScrollbar({
			scrollButtons:{
				enable:true
			},
			theme:"light-3"
		});

		$("#mainNav .navbar-collapse .navbar-nav.sidebar-nav ul").mCustomScrollbar({
			scrollButtons:{
				enable:true
			},
			theme:"light-3"
		});

		$(".tableContainer").mCustomScrollbar({
			axis:"x", // horizontal scrollbar
			mouseWheel:{
				enable: false
			},
			scrollButtons:{
				enable:true
			},
			theme:"light-3"
		});
	});

	/*////////////////////////// Custom Events //////////////////////////*/
    
    $('.profile-img').on('click', function() {
        $(this).next(':file').trigger('click');
    });
	$(":file").on("change", function(){
		var files = !!this.files ? this.files : [];
		if ( !files.length || !window.FileReader ) return;
		if ( /^image/.test( files[0].type ) ) {
			var reader = new FileReader();
			reader.readAsDataURL( files[0] );
			reader.onloadend = function(){
				$(".profile-img").css("background-image", "url(" + this.result + ")");
			}
		}
	});
    /* Update Profile Image */
    $('.profile-img-update').on('click', function() {
        $("#selectImage").trigger('click');
    });     

    $("#selectImage").on("change", function(){
		var files = !!this.files ? this.files : [];
		if ( !files.length || !window.FileReader ) return;
		if ( /^image/.test( files[0].type ) ) {
			var reader = new FileReader();
			reader.readAsDataURL( files[0] );
			reader.onloadend = function(){
				$(".profile-img-update").css("background-image", "url(" + this.result + ")");
                $('#selectedimage').val(this.result);
			}
		}
	});
    $("#updateProfile").on("change", function(){
		var files = !!this.files ? this.files : [];
		if ( !files.length || !window.FileReader ) return;
		if ( /^image/.test( files[0].type ) ) {
			var reader = new FileReader();
			reader.readAsDataURL( files[0] );
			reader.onloadend = function(){
				$(".profile-img").css("background-image", "url(" + this.result + ")");
			}
		}
	});
    $('.create-new .delete-tumb').on('click', function(e) {
        e.preventDefault();
        $(this).next(':file').trigger('click');
    });
	$('.tabSection').on('click', 'a', function() {
		var tabtarget = $(this).data('tabtarget');
		if(tabtarget != 'undefined') {
			$(this).parent().siblings().removeClass('active');
			$(this).parent().addClass('active');
			$('.tabs').hide();
			$('.tabs.' + tabtarget).show();
		}
	})
    /* Admin js end*/
    
    function readIMG(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#preview').attr('src', e.target.result);
                $('#bner').val( e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#fileUploader").change(function(){
        readIMG(this);
    });

    jQuery('.main-footer h5').each(function() {
    	var cls = jQuery(this).hasClass('widget-title')
    	if (!cls) {
    		jQuery(this).addClass('widget-title');
    	}
    });

    jQuery('.main-footer .widget-title').each(function() {
    	var thisText = jQuery(this).text();
    	jQuery(this).after("<h5 class='widget-title'>" + thisText + "</h5>");
    	jQuery(this).remove();
    });


    /* ScrollFix */
    var currentScrollPosition = 0;
	function popFun() {
		$(document).on('focus','.modal-body .timepickerclass', function() {
			var popOff = $(this).offset().top + ($(this).outerHeight());
			setTimeout(function() {
				$(document).find('.ui-timepicker-container').css({
					'top': popOff
				});
			}, 1);
		});
		$(document).on('focus','.schedule .timepickerclass', function() {
			var popOff = $(this).offset().top - 25;
			setTimeout(function() {
				$(document).find('.ui-timepicker-container').css({
					'top': popOff
				});
			}, 1);
		});
		$(document).on('focus','#suggestForm .timepickerclass', function() {
			var popOff = $(this).offset().top - 25;
			setTimeout(function() {
				$(document).find('.ui-timepicker-container').css({
					'top': popOff
				});
			}, 1);
		});
		$(document).on('focus','.hasDatepicker', function() {
			var id=$(this).attr('id');
			if(id=='sendRequestDate'){
				var popOff = ($(this).offset().top - $('#hirePopup').offset().top)+$(this).outerHeight();
				setTimeout(function() {
					$(document).find('#ui-datepicker-div').css({
						'top': popOff
					});
				}, 1);          
			}
			else{
				var topPos = $(this).offset().top;
				var thisHeight = $(this).outerHeight();
				var popPos = topPos + thisHeight;
				setTimeout(function() {
					$('#ui-datepicker-div').css({
						// 'top': popPos
					});
				}, 0);            
			}
		});
		$(document).on('focus','.edit-profile .hasDatepicker', function() {
			var topPos = $(this).offset().top;
			var thisHeight = $(this).outerHeight();
			var popPos = topPos - 25;
			setTimeout(function() {
				$('#ui-datepicker-div').css({
					'top': popPos
				});
			}, 0);
		});
		$(document).on('focus','[name=address]', function() {
			var topPos = $(this).offset().top;
			var thisHeight = $(this).outerHeight();
			var popPos = topPos - 25;
			setTimeout(function() {
				$('.pac-container').css({
					'top': popPos
				});
			}, 0);
		});
	}
	$(document).scroll(function() {
		currentScrollPosition = $(this).scrollTop();
		popFun();
		// console.log($('input').is(':focus').offset());
	});
	$(document).on('resize', function() {
		popFun();
	});
	$(".input_selector").focus(function() {
		if ($(window).width() < 992) {
			$(document).scrollTop(currentScrollPosition);
		}
	});
});
jQuery(document).ready(function($) {
     if( /iPad/i.test(navigator.userAgent) ) {
        
     }
    
    
    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
        getLocation();
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                x.innerHTML = "Geolocation is not supported by this browser.";
            }
        }
        function showPosition(position) {
            $.ajax({
				data: {lat:position.coords.latitude,long:position.coords.longitude,action:'latlong'},
				url: SITE_URL + '/wp-admin/admin-ajax.php',
				type: 'POST',
				dataType: 'json',
				success: function(response) {
                   
				}
			});
            
       /*     var test = "Latitude: " + position.coords.latitude + 
            "<br>Longitude: " + position.coords.longitude; 
            alert(test);*/
        }

}
  /*  */  
	$(function () {
		$('[data-toggle="tooltip"]').tooltip()
	});
	$('select.form-control').each(function() {
		$(this).after('<span class="caret"></span>');
	});
	var tastimonials = $('#tastimonials');
	var mouse_is_inside = false;
    
   
	tastimonials.owlCarousel({
		autoplay: true,
		autoplayTimeout: 3000,
		center: true,
		dots: true,
		items: 1,
		loop: true,
		nav: true
	});
	$('#pop, .log-in-form').hover(function() {
		mouse_is_inside = true;
	}, function() {
		mouse_is_inside = false;
	});
	function scroller() {
		var a = $(window).scrollTop();
		if (a > 1) {
			$('#header').addClass('fixed-header');
		} else {
			$('#header').removeClass('fixed-header');
		}
	};
	function loader() {
		var a = $(window).height();
		scroller();

		$('.home-banner').css('height', a);
	}
	function popVcenter() {
		var a = $('#pop').outerHeight(true);
		var b = $(window).height();
		if (a < b) {
			$('#pop').addClass('vcenter');
			$('body').addClass('bigPop');
			$('html, body').removeClass('vhide');
		} else {
			$('#pop').removeClass('vcenter');
			$('body').removeClass('bigPop');
			$('html, body').addClass('vhide');
		}
	}
	function login() {
		$('#login-pop').show('slow');
	}

	loader();

	$(window).on('scroll', function() {
		scroller();
	});
	$(window).on('load resize', function() {
		loader();
		$('.hasDatepicker').on('focus', function() {
			var topPos = $(this).offset().top;
			var thisHeight = $(this).outerHeight();
			var popPos = topPos + thisHeight;
			setTimeout(function() {
				$('#ui-datepicker-div').css({
					// 'top': popPos
				});
			}, 0);
		});
	});
   
            
     var temp=0;
     $(document).on('click','body',function(){
         temp=1;
         if(temp==1){
           $('.ui-timepicker-container').addClass('ui-helper-hidden ui-timepicker-hidden');            
         }
     });
     $(document).on('click','.page-template-template-edit-profile',function(){
         var checkClass=$(document).hasClass('ui-timepicker-hidden');
        if(checkClass!=true){
           $('.ui-timepicker-container').addClass('ui-helper-hidden ui-timepicker-hidden'); 
         }    
     });
       

     /*$(document).on('click touchstart','*',function(){
         var checkClass=$(this).parent().attr('class');
         if(checkClass!='ui-timepicker-viewport'){
           $('.ui-timepicker-container').addClass('ui-helper-hidden ui-timepicker-hidden'); 
         }else{
             
            return true; 
         }   
     });*/
     
     $(document).on('hover','.ui-timepicker-container',function(){            
        temp=1;
     });  
	 $('.menu-toggle').click(function() {
		var a = $('.main-manu').css('top');
		if (a <= '0') {
			$('.main-manu').animate({
				"top": '0'
			}, 990);
			$(this).addClass('clicked');
			$('html, body').addClass('menu-opened');
		} else {
			$('.main-manu').animate({
				"top": '-100%'
			}, 990);
			$(this).removeClass('clicked');
			setTimeout(function() {
				$('html, body').removeClass('menu-opened');
			}, 1000);
		}
	});
	/*$(document).on('click', function() {
		if (!mouse_is_inside) {
			$('#login-pop').hide('slow');
			setTimeout(function() {
				$('html, body').removeClass('vhide');
			}, 1000);
		}
	});*/
    var mouse_is_inside_timepicker=false;
    $('.ui-timepicker-container').hover(function() {
		mouse_is_inside_timepicker = true;
	}, function() {
		mouse_is_inside_timepicker = false;
	});
    $(document).on('click', function() {
		if (!mouse_is_inside_timepicker) {
			$('.ui-timepicker-container').addClass('ui-helper-hidden ui-timepicker-hidden');
		}
	});
    $(document).on('click','.close',function(){        
        $('body,html').removeClass('modal-open');
        $('body,html').removeClass('menu-opened');
        $('body,html').removeClass('vhide');
    });
    $(document).on('click','.close',function(){
        $('.ui-timepicker-container').addClass('ui-helper-hidden ui-timepicker-hidden');
    });
	$(document).on('click', '#login-pop .pop-header .close', function() {
		$('#login-pop').hide('slow');
		setTimeout(function() {
			$('html, body').removeClass('vhide');
		}, 1000);
	});
    $(document).on('click', '.timepickerclass', function() {
        setTimeout(function() {
            $('.ui-timepicker-container').removeClass('ui-helper-hidden ui-timepicker-hidden');
        }, 10);
    });
	$('.log-in-form').on('click', function() {
		login();
		popVcenter();
	});
	$('.collapes a').on('click', function() {
		var a = $('.rating h2').offset().top;
		$('body, html').animate({ scrollTop: a - 30 }, 600);
	});
	var a = window.location.pathname;
	$('.main-manu li').each(function() {
		var b = $(this).find('a').attr('href');
		if (a.indexOf(b) > -1) {
			$(this).addClass('active');
			$(this).siblings().removeClass('active');
		} else {
			$(this).removeClass('active');
		}
	});
	$('.tabs a').on('click', function() {
		var classHass = $(this).parent().hasClass('active');
		if (!classHass) {
			var target = $(this).data('target');
			$(this).parent().siblings().removeClass('active')
			$(this).parent().addClass('active');
			$('.form-wrapper').find('form').hide('slow');
			$('.form-wrapper').find('#' + target).show('slow');
		}
	});

	$(document).on('click','.modal-body .timepickerclass', function() {
        // var popOff = ($(this).offset().top - $('#hirePopup').offset().top)+$(this).outerHeight();
        var popOff = $(this).offset().top + ($(this).outerHeight());
        setTimeout(function() {
            $(document).find('.ui-timepicker-container').css({
                'top': popOff
            });
        }, 1);
	});

	$(document).on('click','.schedule .timepickerclass', function() {
        // var popOff = ($(this).offset().top - $('#hirePopup').offset().top)+$(this).outerHeight();
        var popOff = $(this).offset().top - 25;
        setTimeout(function() {
            $(document).find('.ui-timepicker-container').css({
                'top': popOff
            });
        }, 1);
	});

	$(document).on('click','#suggestForm .timepickerclass', function() {
        // var popOff = ($(this).offset().top - $('#hirePopup').offset().top)+$(this).outerHeight();
        var popOff = $(this).offset().top - 25;
        setTimeout(function() {
            $(document).find('.ui-timepicker-container').css({
                'top': popOff
            });
        }, 1);
	});


    $(document).on('click','.hasDatepicker', function() {
        var id=$(this).attr('id');
        if(id=='sendRequestDate'){
            var popOff = ($(this).offset().top - $('#hirePopup').offset().top)+$(this).outerHeight();
            setTimeout(function() {
                $(document).find('#ui-datepicker-div').css({
                    'top': popOff
                });
            }, 1);          
        }
        else{
            var topPos = $(this).offset().top;
            var thisHeight = $(this).outerHeight();
            var popPos = topPos + thisHeight;
            setTimeout(function() {
                $('#ui-datepicker-div').css({
                    // 'top': popPos
                });
            }, 0);            
        }
		
	});

	$(document).on('click','.edit-profile .hasDatepicker', function() {
        var topPos = $(this).offset().top;
        var thisHeight = $(this).outerHeight();
        var popPos = topPos - 25;
        setTimeout(function() {
            $('#ui-datepicker-div').css({
                'top': popPos
            });
        }, 0);
	});

	$(document).on('click','[name=address]', function() {
        var topPos = $(this).offset().top;
        var thisHeight = $(this).outerHeight();
        var popPos = topPos - 25;
        setTimeout(function() {
            $('.pac-container').css({
                'top': popPos
            });
        }, 0);
	});

    /* Start Development JS */
    var defaultImage=$('#userDefaultImage').val();
	$("#user-signup").validate({
		rules: {
			firstName: {
				required: true
			},
			lastName: {
				required: true
			},
			contactNo: {
				required: true
			},
			password: {
				required: true,
				minlength: 6
			},
			confirmPassword: {
				required: true,
				minlength: 6,
				equalTo: '#password'
			},
			gender: {
				required: true
			},
			dob: {
				required: true
			},
			email: {
				required: true,
				email: true
			},
			/*country: {
				required: true
			},
			city: {
				required: true
			},
			state: {
				required: true
			},*/
             address: {
				required: true
			},
		},
		messages: {
			password: {
				required: "Please Enter your password.",
				minlength: "Your password must be at least 6 characters long"
			},
			email: "Please enter a valid email address",
		},
		submitHandler: function(form) {
            $('.loading_image').show();
			var formData = $("#user-signup").serializeArray();
			$.ajax({
				data: formData,
				url: SITE_URL + '/wp-admin/admin-ajax.php',
				type: 'POST',
				dataType: 'json',
				success: function(response) {
                    $('.loading_image').hide();
					if (response.success == 1) {
                        if(hireType=='1'){
                            window.location.href = SITE_URL;   
                        }else{
                            window.location.href = SITE_URL+'/job-requests';
                            $('#profile-img-tag').attr('style','background-image:url('+defaultImage+')');
                            $('#user-signup')[0].reset();
                            $('#result').html('');
                        }
					} else {
                        $("html, body").animate({ scrollTop: $("#response").offset().top-100 }, "slow");
						$('#response').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close"></a>' + response.error + '</div>');
                         if(response.error=='Email already exists.'){
                          $('#user-signup').find('input[name="email"]').addClass('error');  
                        }
                        
					}
				}
			});
		}
	});
	$("#photo-signup").validate({
		rules: {
			firstName: {
				required: true
			},
			lastName: {
				required: true
			},
			experience: {
				required: true
			},
            minHours: {
				required: true
			}, 
            hourlyRate: {
				required: true
			},
            bio: {
				required: true
			},
            contactNo: {
				required: true
			},
            address: {
				required: true
			},
			password: {
				required: true,
				minlength: 6
			},
			confirmPassword: {
				required: true,
				minlength: 6,
				equalTo: '#passwordPhoto'
			},
			gender: {
				required: true
			},
			dob: {
				required: true
			},
			email: {
				required: true,
				email: true
			}
            /*,
			country: {
				required: true
			},
			city: {
				required: true
			},
			state: {
				required: true
			}*/
		},
		messages: {
			password: {
				required: "Please Enter your password.",
				minlength: "Your password must be at least 6 characters long"
			},
			email: "Please enter a valid email address",
		},
		submitHandler: function(form) {
            $('.loading_image').show();
            var portFolioImg=$('#result .col-sm-4 a').length;
            if(portFolioImg>6){
                $('.loading_image').hide();
                $('.validationMsg').show();
                return false;
            }
			var formData = $("#photo-signup").serializeArray();
			$.ajax({
				data: formData,
				url: SITE_URL + '/wp-admin/admin-ajax.php',
				type: 'POST',
				dataType: 'json',
				success: function(response) {
                    $('.loading_image').hide();
					if (response.success == 1) {
                       // return false;
                        window.location.href=SITE_URL+'/photographer-job-requests/';
                       /* $('#response').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>You have successfully registered with  the website.Please wait for admin approval to activate your account.</div>');
                        $('#result').html('');
                        $("html, body").animate({ scrollTop: $("#response").offset().top-100 }, "slow"); 
                        $('#photo-signup')[0].reset();  
                        $('#profile-img-tag-photo').attr('style','background-image:url('+defaultImage+')'); */
            		} else {
                        $("html, body").animate({ scrollTop: $("#response").offset().top-100 }, "slow"); 
                        if(response.error=='Email already exists.'){
                          $('#photo-signup').find('input[name="email"]').addClass('error');  
                        }
						$('#response').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close"></a>' + response.error + '</div>');
					}
				}
			});
		}
	});
    $("#resetpassword").validate({
		rules: {
			password: {
				required: true,
				minlength: 6
			},
			confirmPassword: {
				required: true,
				minlength: 6,
				equalTo: '#pwd'
			}
		},
		messages: {
			password: {
				required: "Please Enter your password.",
				minlength: "Your password must be at least 6 characters long"
			},
			email: "Please enter a valid email address",
		},
		submitHandler: function(form) {
            $('.loading_image').show();
			var formData = $("#resetpassword").serializeArray();
			$.ajax({
				data: formData,
				url: SITE_URL + '/wp-admin/admin-ajax.php',
				type: 'POST',
				dataType: 'json',
				success: function(response) {
                    $('.loading_image').hide();
					if (response.status == 'true') {
                        $('#response').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' + response.message + '</div>');
                        $('#resetpassword')[0].reset(); 
                        $('#response').delay(3000).fadeOut();
					} else if(response.status == 'false'){
						$('#response').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' + response.message + '</div>');
					}else{
                        
                        
                    }
				}
			});
		}
	});
	/* Login */
	$('#logform').validate({
		rules: {
			email: {
				required: true,
				email: true
			},
			password: {
				required: true
			},
			userType: {
				required: true
			}
		},
		messages: {
			password: {
				required: "Please Enter your password."
			},
			email: "Please enter a valid email address",
			userType: 'Please select User Type.'
		},
		submitHandler: function(form) {
            $('.loading_image').show();
			var formData = $("#logform").serializeArray();
            var userTypedata=$('#userTypedata').val();
			$.ajax({
				data: formData,
				url: SITE_URL + '/wp-admin/admin-ajax.php',
				type: 'POST',
				dataType: 'json',
				success: function(response) {
                   var hireType=$('#hiringValue').val();
                    $('.loading_image').hide();
					if (response.success == 1) {
                        if(userTypedata=='0'){
                             window.location.href = SITE_URL+'/photographer-job-requests/';   
                        }else{
                            if(hireType=='1'){
                              window.location.href = SITE_URL+'/find-photographer/';   
                            }else{
                              window.location.href = SITE_URL+'/job-requests/';
                            }                            
                        }						
					} else {
						$('#responseLogin').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' + response.error + '</div>');
					}
				}
			});
		}
	});
    $(document).on('click','#suggestTime',function(){
        var jobId=$('#jobId').val();
        var userId=$('#userId').val();
        $('.loading_image').show();
        $.ajax({
            data: {action:'suggesttime',requestId:jobId,userId:userId},
            url: SITE_URL + '/wp-admin/admin-ajax.php',
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                $('.loading_image').hide();
              $('#suggestTimePopup').modal('show');  
              $('#startDate').val(response.response);
            }
		});     
    });   
    $(document).on('click','#hirePhotographer',function(){   
         $('#hireForm input').removeClass('error');
         $('#hireForm')[0].reset();
         $('.loading_image').show();        
         $('#hirePopup').modal('show');  
         $('.response').html('');
         $('.loading_image').hide();
    });
    $(document).on('click','#hireWithoutLogin',function(){
         $.ajax({
            data: {action:'create_session',type:'hire'},
            url: SITE_URL + '/wp-admin/admin-ajax.php',
            type: 'POST',
            dataType: 'json',
            success: function(response) {
              $('#hiringValue').val('1')
              $('.loading_image').hide();
            }
		  });           
    });
    $(document).on('click','.cancelBtn',function(){ 
         /*var data=$(this).attr('data-attr-action');
         if(data=='1'){

         }*/
         $('#cancelPopup input').removeClass('error');
         $('#cancelPopup').modal('show');  
    });   
    $(document).on('click','.remindTraveler',function(){
        var jobId=$(this).attr('data-attr-id');
        var userId=$('#crntUserLogin').val();
        $.ajax({
                data: {action:'send_reminder_to_traveler',status:2,userId:userId,jobId:jobId},
                url: SITE_URL + '/wp-admin/admin-ajax.php',
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                  $('.loading_image').hide();
                  $('.response').show();
                  if(response.success===1){
                         $('.response').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+response.result+'</div>');
                         $('.response').delay(2000).fadeOut();
                    }else{
                         $('.response').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+response.error+'</div>'); 
                         $('.response').delay(3000).fadeOut();
                    }
                }
            });
        
        
        
    });
    $(document).on('click','.markAsReadNotify',function(){
        var notificationId=$(this).attr('data-attr-id');
        var userId=$('#crntUserLogin').val();
        $('.loading_image').show();
        $.ajax({
            data: {action:'mark_as_read',notificationId:notificationId,userId:userId},
            url: SITE_URL + '/wp-admin/admin-ajax.php',
            type: 'POST',
            dataType: 'json',
            success: function(response) {
              $('.loading_image').hide();
              if(response.success===1){  
                   if(response.error>0){
                      $('.noti-counts').addClass('noti-count'); $('.noti-counts').css('display','inline-block'); 
                      $('.noti-counts').html('<small>'+response.error+'</small>');  
                  }else{
                     $('.noti-count').hide(); 
                  }
                 /* $('.noti-count').html('<small>'+response.error+'</small>');*/
                  window.location.href=SITE_URL+'/notifications';
                }else{
                   window.location.href=SITE_URL+'/notifications';  
                }
            }
        });  
    });
     if(removeSession=='1'){
         setTimeout(function(){
              $.ajax({
                data: {action:'reset_session_data'},
                url: SITE_URL + '/wp-admin/admin-ajax.php',
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                 if(response.status=='true'){
                     console.log('herer');
                   $('.signMup').delay(3000).fadeOut();

                 }
                }
		      });             
         },2000);
         
    }    
    $(document).on('click','.cancelSave',function(){
        var jobId=$('#jobId').val();
        var userId=$('#userId').val();
        var startTime='';
        var endTime='';
        var reason=$('input[name="reason"]').val();
        var temp='0';
        if(reason==''){
        $('input[name="reason"]').addClass('error');  
        temp='1';  
        }
        if(temp=='0'){
            $('.loading_image').show();
            $.ajax({
                data: {action:'changejobstatus',status:2,startTime:startTime,endTime:endTime,userId:userId,requestId:jobId,userId:userId,reason:reason},
                url: SITE_URL + '/wp-admin/admin-ajax.php',
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                  $('.loading_image').hide();
                  if(response.status=='true'){
                         $('#responseLoginData').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+response.message+'</div>');
                         setTimeout(function(){
                             location.reload();
                         },1000);
                    }else{
                         $('#responseLoginData').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+response.message+'</div>'); 
                         setTimeout(function(){
                             location.reload();
                         },1000);
                    }
                }
            });  
        }
    });
    $(document).on('click','.sendRequest',function(){
        var startTime=$('input[name="startTime"]').val();
        var endTime=$('input[name="endTime"]').val();
        var startDate=$('input[name="startDate"]').val();
        var otherUserId=$('#otherUserId').val();
        var userId=$('#userId').val();
        var temp='0';
        if(startTime==''){
           temp='1';
           $('input[name="startTime"]').addClass('error');
        }
        if(endTime==''){
           temp='1';
           $('input[name="endTime"]').addClass('error');
        }
        if(startDate==''){
           temp='1';
           $('input[name="startDate"]').addClass('error');
        }
        if(temp=='0'){
            $('.loading_image').show();
            var checkVal= $('.checkVal').val();
            $.ajax({
            data: {action:'send_request',startDate:startDate,startTime:startTime,endTime:endTime,userId:userId,otherUserId:otherUserId,checkVal:checkVal},
            url: SITE_URL + '/wp-admin/admin-ajax.php',
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                $('.response').show();
              $('.loading_image').hide();
              if(response.success===1){
                 $('.response').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+response.result+'</div>');
                 $('#hireForm')[0].reset();
                 $('.response').delay(2000).fadeOut();
                    setTimeout(function(){
                     $('.sendRequest').html('Send Request');
                     $('#hirePopup').modal('hide');
                     window.location.href=SITE_URL+'/job-requests';   
                    },1000);                    
              }else{
                  if(response.success===2){
                      $('.checkVal').val(0);
                      $('.sendRequest').html('Continue');
                      $('.response').html('<div class="alert alert-warning"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+response.error+'</div>'); 
                  }else{
                      $('.response').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+response.error+'</div>'); 
                      
                  }
                 
               }
            }
		  });             
        } 
        
    });
    $(document).on('click','#replyOnNewTimeSlot',function(){
        var jobId=$('#jobId').val();
        var userId=$('#userId').val();
        var startTime='';
        var endTime='';
        $('.loading_image').show();
         $.ajax({
            data: {action:'reply_on_new_time',startTime:startTime,endTime:endTime,userId:userId,requestId:jobId,userId:userId},
            url: SITE_URL + '/wp-admin/admin-ajax.php',
            type: 'POST',
            dataType: 'json',
            success: function(response) {
              $('.loading_image').hide();
              if(response.success===1){
                 $('.response').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+response.result+'</div>');
                 setTimeout(function(){
                   location.reload();
                 },1000);
              }else{
                 $('.response').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+response.error+'</div>');
                 setTimeout(function(){
                   location.reload();
                 },1000);
               }
            }
		});      
        
    }); 
    $(document).on('click','.changeJobStatus',function(){
        var jobStatus=$(this).attr('data-attr-action');
        var jobId=$('#jobId').val();
        var userId=$('#userId').val();
        $('.loading_image').show();
        $.ajax({
				data: {action:'changejobstatus',requestId:jobId,userId:userId,status:jobStatus},
				url: SITE_URL + '/wp-admin/admin-ajax.php',
				type: 'POST',
				dataType: 'json',
				success: function(response) {
                    $('.loading_image').hide();
					if(response.status=='true'){
                         $('.response').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+response.message+'</div>');
                         setTimeout(function(){
                             location.reload();
                         },1000);
                    }else{
                         $('.response').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+response.message+'</div>'); 
                         setTimeout(function(){
                             location.reload();
                         },1000);
                    }
				}
			});
                   
    });  
    $(document).on('click','.editTimeRequest',function(){
        var startTime=$('input[name="startTime"]').val();
        var endTime=$('input[name="endTime"]').val();
        var userId=$('#userId').val();
        var jobId=$('#jobId').val();
        var temp='0';
        if(startTime==''){
           temp='1';
           $('input[name="startTime"]').addClass('error');
        }
        if(endTime==''){
           temp='1';
           $('input[name="endTime"]').addClass('error');
        }
        if(temp=='0'){
            $('.loading_image').show();
            $.ajax({
            data: {action:'edit_time_request',startTime:startTime,endTime:endTime,requestId:jobId,userId:userId},
            url: SITE_URL + '/wp-admin/admin-ajax.php',
            type: 'POST',
            dataType: 'json',
            success: function(response) {
              $('.loading_image').hide();
                $('.responseSuggest').show();
              if(response.status=='true'){
                $('.responseSuggest').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+response.response+'</div>');
                $('#suggestForm')[0].reset();
                $('.responseSuggest').delay(2000).fadeOut();
                setTimeout(function(){
                 $('#suggestTimePopup').modal('hide');   
                  location.reload();
                },1000);  
              }else{
                 $('.responseSuggest').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+response.response+'</div>'); 
               }
            }
		});             
        }        
    });
    $(document).on('click','#resetPassword',function(){
        var old=$('input[name="currentPassword"]').val();
        var newPassword=$('input[name="newPassword"]').val();
        var confirm=$('input[name="confirmPassword"]').val();
        var userId=$('#userId').val();
        var temp='0';
        if(old==''){
           temp='1';
           $('input[name="currentPassword"]').addClass('error');
        }
        if(newPassword==''){
           temp='1';
           $('input[name="newPassword"]').addClass('error'); 
        }
        if(confirm==''){
           temp='1';
           $('input[name="confirmPassword"]').addClass('error'); 
        }
        if(confirm!=newPassword){
           temp='1';
           $('input[name="confirmPassword"]').addClass('error'); 
        }
        if(temp=='0'){
            $('.loading_image').show();
             $.ajax({
                data: {action:'change_password',currentPassword:old,newPassword:newPassword,userId:userId},
                url: SITE_URL + '/wp-admin/admin-ajax.php',
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                  $('.loading_image').hide();
                  $('.response').show(); 
                  if(response.success===1){
                    $('.response').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Password Changed successfully.</div>');
                    $('.response').delay(3000).fadeOut();
                    $('#resetPasswordForm')[0].reset();                      
                  }else{
                     $('.response').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+response.error+'</div>'); 
                   }
                }
		      });  
        }
        
        
        
    });
    $(document).on('click','.updateProfile',function(){
        var firstName=$('input[name="firstName"]').val();
        var address=$('input[name="address"]').val();
        var temp='0';
        if(firstName==''){
           temp='1';
           $('input[name="firstName"]').addClass('error');
        }
        if(address==''){
           temp='1';
           $('input[name="address"]').addClass('error'); 
        }
        if(temp=='0'){
            $('.loading_image').show();
              $.ajax({
                data: $('#updateProfileForm').serializeArray(),
                url: SITE_URL + '/wp-admin/admin-ajax.php',
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                  $('.responses').show();                    
                  $('.loading_image').hide();
                  if(response.status=='true'){
                    $('.responses').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Profile information updated successfully.</div>');
                    $('html, body').animate({
                        scrollTop:0
                    }, 1000); 
                    $('.responses').delay(3000).fadeOut();
                  }else{
                     $('.responses').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Profile is not updated.</div>'); 
                     $('html, body').animate({
                        scrollTop: 0
                     }, 1000); 
                   } 
                }
		      });  
       }
    });
    $(document).on('click','.deletePortfolio',function(){
        var delId=$(this).attr('data-attr-id');
        var $this=$(this);
        $.ajax({
            data: {action:'delete_portfolio',delId:delId},
            url: SITE_URL + '/wp-admin/admin-ajax.php',
            type: 'POST',
            dataType: 'json',
            success: function(response) {
              $('.loading_image').hide();
                $('.responsePort').show();
                if(response.status=='true'){
                   $this.parent().parent().remove();
                   $('.responsePort').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Portfolio image deleted successfully.</div>');
                   $('.responsePort').delay(3000).fadeOut();                    
                }else{
                    $('.responsePort').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>No images are deleted.</div>');
                    $('.responsePort').delay(3000).fadeOut(); 
                }
            }
		 });  
    });
    $(document).on('click','#updatePortfolioBtn',function(){
        var files=$('input[name="portFolio"]').val();
        $('.hideport').hide();
        $('.responsePortfolio').show();              
        if(files==''){
            $('.responsePortfolio').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>No file selected.</div>');
            $('.responsePortfolio').delay(3000).fadeOut();
        }else{
            $('.loading_image').show();
            $('.responsePortfolio').hide();
            $.ajax({
            data: $('#updatePortfolioForm').serializeArray(),
            url: SITE_URL + '/wp-admin/admin-ajax.php',
            type: 'POST',
            dataType: 'json',
            success: function(response) {
              $('.loading_image').hide();
              $("html, body").animate({ scrollTop: $(".responsePortfolio").offset().top-100 }, "slow"); 
              if(response.status=='true'){
                  $('.responsePortfolio').show();
                 $('.responsePortfolio').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Portfolio images updated successfully.</div>');
                 $('.responsePortfolio').delay(3000).fadeOut();
                  setTimeout(function(){
                    window.location.href=SITE_URL+'/update-profile/'+$('input[name="userId"]').val();  
                  },1000);                 
              }
            }
		  });   
        }
    });
    $(document).on('click','.notificationModule',function(){ 
        $('.loading_image').show();
         notify();
    });
    $(document).on('click','.deleteNoti',function(){  
        $('.loading_image').show();
        $this=$(this);
        var delId=$(this).attr('data-attr-id');
        var userId=$('#crntUserLogin').val();
        $.ajax({
            data: {userId:userId,notificationId:delId,type:'web'},
            url: SITE_URL + '/api/deleteNotification.php',
            type: 'POST',
            dataType:'json',
            success: function(response) {
                $('.loading_image').hide();
                if(response.success===1){
                  if(response.error>0){
                      $('.noti-counts').addClass('noti-count'); $('.noti-counts').css('display','inline-block'); 
                      $('.noti-counts').html('<small>'+response.error+'</small>');  
                  }else{
                     $('.noti-count').hide(); 
                  }
                  $this.parent().parent().delay(1500).fadeOut();  
                  $this.parent().parent().next().css('border-top','0');
                }
            }
        });       
    });
    $(document).on('click','.markCompleteJob',function(){
        var jobId=$(this).attr('data-attr-id');
        var userId=$('#crntUserLogin').val();
        $('.loading_image').show();
        $this=$(this);
        $.ajax({
            data: {action:'mark_complete_job',userId:userId,jobId:jobId,type:'0'},
            url: SITE_URL + '/wp-admin/admin-ajax.php',
            type: 'POST',
            dataType:'json',
            success: function(response) {
                $('.loading_image').hide();
                $('.response').show();
                if(response.success===1){
                  $('.response').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+response.result+'</div>'); 
                  $('.response').delay(1500).fadeOut();  
                  $this.parent().parent().parent().remove();
                }
            }
        }); 
        
        
        
    });
    $(document).on('click','.requestForLink',function(){
        var jobId=$(this).attr('data-attr-id');
        var userId=$('#crntUserLogin').val();
        $('.loading_image').show();
        $this=$(this);
        $.ajax({
            data: {action:'mark_complete_job',userId:userId,jobId:jobId,type:'1'},
            url: SITE_URL + '/wp-admin/admin-ajax.php',
            type: 'POST',
            dataType:'json',
            success: function(response) {
                $('.loading_image').hide();
                $('.response').show();
                if(response.success===1){
                  $('.response').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+response.result+'</div>');
                    $('.response').fadeIn(); 
                  $('.response').delay(2000).fadeOut(); 
                }
            }
        }); 
        
        
        
    });
    $(document).on('click','.shootLinkClick',function(){
        $('#shootLinkPopupForm input').removeClass('error');
        $('#shootLinkPopupForm')[0].reset();
        var jobId=$(this).attr('data-attr-id');
        var userId=$('#crntUserLogin').val();
        $('#sluserId').val(userId);
        $('#sljobId').val(jobId);
        $('.loading_image').show();
        $.ajax({
            data: {action:'shoot_link',jobId:jobId,userId:userId},
            url: SITE_URL + '/wp-admin/admin-ajax.php',
            type: 'POST',
            dataType: 'json',
            success: function(response) {
              $('.loading_image').hide();
              $('#shootLinkPopup').modal('show'); 
              $('#slotherUserId').val(response.response);             
            }
		}); 
    });
    $(document).on('click','.shootLinkPopupBtn',function(){
        var link=$('input[name="link"]').val();
        if(link==''){
                $('input[name="link"]').addClass('error');
            }else{
                var formData = $("#shootLinkPopupForm").serializeArray();
                $('.loading_image').show();
                $.ajax({
                    data: formData,
                    url: SITE_URL + '/wp-admin/admin-ajax.php',
                    type: 'POST',
                    dataType: 'json',
                    success: function(response) {
                        $('.loading_image').hide();  
                         $('#responseShoot').show();
                        if (response.success == 1) {
                            $('#responseShoot').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' + response.result + '</div>');
                           $('#responseShoot').delay(2000).fadeOut();
                            $('#shootLinkPopupForm')[0].reset();  
                            setTimeout(function(){
                               $('#shootLinkPopup').modal('hide'); 
                               location.reload();
                            },2000);
                        } else {
                            $('#responseShoot').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' + response.error + '</div>');
                        }
                    }
                });                 
            }
    });
    
    $(document).on('keydown','.character',function(e) {
        if (e.ctrlKey || e.altKey) {
            //e.preventDefault();

        }else {
            var key = e.keyCode;
            if (!((key == 8) || (key == 9) || (key == 32) || (key == 46) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))) {
                e.preventDefault();
            }
        }
    });
    $(document).on('click','.addmore',function(){
        var html=$(this).parent().prev().html();
        var text = html;
        $(this).closest('li').append('<div><div></div><div class="clrHtml">'+html+'</div><div class="inner"><a href="javascript:void(0);" class="removeContent">-</a></div></div>'); 
        $(this).parent().parent().parent().find('.clrHtml').find('input').val('');
        $('.timepickerclass').timepicker(); 
        
    }); 
  /*  $(document).on('click','.timepickerclass', function (){
            $(this).timepicker('setTime', new Date());
             
        });*/
    $(document).on('click','.removeContent',function(){
	  $(this).parent().prev().prev().remove();
	  $(this).parent().prev().remove();
	  $(this).parent().remove();
    });
    $(document).on('click','#saveSchedule',function(){
       $('.loading_image').show();
       var form=$('#schedule').serializeArray();
       $.ajax({
            data:form,
            url: SITE_URL + '/wp-admin/admin-ajax.php',
            type: 'POST',
            dataType:'json',
            success: function(response) {
                $('.loading_image').hide();
                $('#responseSchedule').show();
                $("html, body").animate({ scrollTop: $("#responseSchedule").offset().top-100 }, "slow"); 
                if(response.status=='true'){
                   $('#responseSchedule').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Schedule added.</div>');
                   $('#responseSchedule').delay(2000).fadeOut(); 
                }else{
                   $('#responseSchedule').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Please check your entered schedule time.</div>');
                }              
            }
        });  
    });
    $(document).on('click','#forgotPassword',function(){
        $('.loading_image').show();
        $('#forgotPasswordForm input').removeClass('error');
        $('#forgotPasswordPopup').modal('show');
        $('#login-pop').hide();
        $('.loading_image').hide();
    });
    $(document).on('click','.ratingPopup',function(){
        $('.loading_image').show();
        $('#ratingPopup').modal('show');
        var id=  $(this).attr('data-attr-id');
        $('#ratingjobId').val(id);
        var user=$('#crntUserLogin').val();
        $('#ratingUser').val(user);
        $('.loading_image').hide();
    });
    $(document).on('click','.forgotRequest',function(){
        var email=$('#forgotEmail').val();
        if(email==''){
          $('#forgotEmail').addClass('error');  
        }else{
            var form=$('#forgotPasswordForm').serializeArray();
            $('.loading_image').show();
            $.ajax({
                data:form,
                url: SITE_URL +'/wp-admin/admin-ajax.php',
                type: 'POST',
                dataType:'json',
                success: function(response) {
                    $('.loading_image').hide();
                      $('#responseForgot').show();
                    if(response.status=='true'){                     
                       $('#responseForgot').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+response.message+'</div>');
                       $('#responseForgot').delay(1000).fadeOut();    
                        setTimeout(function(){                          
                          $('#forgotPasswordPopup').modal('hide');
                          $('#forgotPasswordForm')[0].reset();
                        },2000);                       
                    }else{
                       $('#responseForgot').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+response.message+'</div>');
                    }              
                }
          });  
            
        }
    });
    $(document).on('click','#suggestRouteBtn',function(){
        $('.loading_image').show();
        $('#suggestRoutePopup').modal('show');
        $('.loading_image').hide();
    });
    $(document).on('click','.postSuggestRoute',function(){
        var route=$('input[name="route"]').val();
        var user=$('#crntUserLogin').val();
        $('.userId').val(user);
        if(route==''){
          $('input[name="route"]').addClass('error');  
        }else{
            var form=$('#suggestRouteForm').serializeArray();
            $.ajax({
                data:form,
                url: SITE_URL +'/wp-admin/admin-ajax.php',
                type: 'POST',
                dataType:'json',
                success: function(response) {
                    $('.loading_image').hide();
                    $('#responseRoute').show();
                    if(response.success===1){
                       $('#responseRoute').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+response.result+'</div>');
                       $('#responseRoute').delay(1000).fadeOut();    
                        setTimeout(function(){                          
                          $('#suggestRoutePopup').modal('hide');
                          $('#suggestRouteForm')[0].reset();
                        },2000);                       
                    }else{
                       $('#responseRoute').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+response.error+'</div>');
                    }              
                }
          });  
            
        }
        
        
        
    });
    $(document).on('keyup','input',function(){
        $(this).removeClass('error');
    });
    $(document).on('change','input',function(){
        $(this).removeClass('error');
    });
    $(document).on('click','input',function(){
        var crnt=$(this).val();
        if(crnt!=''){
           $(this).removeClass('error'); 
        }        
    });
    $(document).on('click','.paging',function(){
         var page = $(this).attr("data-page"); 
         $('input[name="page"]').val(page);
         $('.loading_image').show();
         var form =$('#pageForm').serializeArray();
         $.ajax({
                data:form,
                url: SITE_URL +'/wp-admin/admin-ajax.php',
                type: 'POST',
                //dataType:'json',
                success: function(response) {
                    $('.loading_image').hide();
                    $('#results').html(response);
                    $('#results').next().html($('#results:last nav').html());
                    $('#results:last nav').remove();
                }
          });  
        
    });    
    $(document).on('click','.payment',function(){
       var jobId=$('#jobId').val();
        $('.loading_image').show();
       $.ajax({
        data:{action:'pay',jobid:jobId},
        url: SITE_URL +'/wp-admin/admin-ajax.php',
        type: 'POST',
        dataType:'json',
        success: function(response) {
            $('.loading_image').hide();
            $('.response').show();
            if(response.status=='true'){
               $('.response').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Payment has been completed.</div>');   
                $('.response').delay(1000).fadeOut();
                setTimeout(function(){                    
                 location.reload();   
                },2000);
            }            
        }
      });  
    });
   /* $("#results").on( "click", ".pagination a", function (e){
        e.preventDefault();
        $(".loading-div").show(); //show loading element
        var page = $(this).attr("data-page"); //get page number from link
        console.log(page);
        return false;
        
        
        
        $("#results").load("fetch_pages.php",{"page":page}, function(){ //get content from PHP page
            $(".loading-div").hide(); //once done, hide loading element
        });
        
    }); */
    setInterval(function(){
       $.ajax({
			data: {
				action: 'notification_counts'
			},
			url: SITE_URL + '/wp-admin/admin-ajax.php',
			type: 'get',
			success: function(response) {
                if(response>0){
                   $('.noti-counts').addClass('noti-count'); $('.noti-counts').css('display','inline-block'); 
                   $('.noti-counts').html('<small>'+response+'</small>');  
                }
             
			}
		});       
    },2000);
    function notify(){
        $.ajax({
            data: {action:'show_notifications'},
            url: SITE_URL + '/wp-admin/admin-ajax.php',
            type: 'POST',
            success: function(response) {
                $('.loading_image').hide();
                $('.notificationContent').html(response);
            }
        }); 
    }
    loginResponse=loginResponse.trim();
    if(loginResponse==''){
       
     }else{
       if (loginResponse === '0' || loginResponse === 0) {
           console.log(userType);
            if(userType!=''){
              $('.selectUserType').parent().removeClass('active');
              $('#user'+userType).addClass('active');   
            } 
            login();
            popVcenter();                     
           if(adminApproval=='1'){
               if(msggg=='You are successfully registered with the website and Your account is awaited for admin approval.'){
                 $('#responseLogin').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+msggg+'</div>');   
               }else{
                 $('#responseLogin').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+msggg+'</div>');   
               }               
           }else{
                $('#responseLogin').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+msggg+'</div>');
               
           }           
           resetSession();
	   }
     }
	
	$('#files').on("change", function(event) {
		var files = event.target.files; //FileList object
		var output = document.getElementById("result");
        var length=$("#result .col-sm-4").length;
		for (var i = 0; i < files.length; i++) {
			var file = files[i];
			//Only pics
			// if(!file.type.match('image'))
			if (file.type.match('image.*')) {
				if (this.files[0].size < 2097152) {
					// continue;
					var picReader = new FileReader();
					picReader.addEventListener("load", function(event) {
						var picFile = event.target;
						div = '<div class="col-sm-4"><input style="display:none; " type="text" name="portfolio[]" value="' + picFile.result + '"/><a href="javascript:void(0)"><div class="img" style="background-image: url(' + picFile.result + ')"><i class="fa fa-trash-o deleteImage"></i></div></a></div>';
                        $('#result').append(div);
                        length=$("#result .col-sm-4").length;
                        console.log(length);
                        if(files.length>6){
                            $('.validationMsg').css('display','block');
                            return false;
                        }else{
                            if(length>6){
                                $('.validationMsg').css('display','block');
                                return false; 
                            }else{
                              $('.validationMsg').css('display','none');  
                            }                            
                        }
						
                        
					});
					//Read the image
					$('#clear, #result').show();
					picReader.readAsDataURL(file);
				} else {
					alert("Image Size is too big. Minimum size is 2MB.");
					$(this).val("");
				}
			} else {
				alert("You can only upload image file.");
				$(this).val("");
			}
		}
	});	
    /*$(document).on('click','#wpcf7-f919-o1 .wpcf7-submit',function(){
             $temp=0;
             setInterval(function(){
                var test= $('.wpcf7-response-output').hasClass('wpcf7-mail-sent-ok');
                console.log(test);            
                if(test=='true' || test==true){ 
                    $temp==1;
                    console.log('asdcghsdv');
                    if($temp==1){
                       window.location.href=SITE_URL+'/thank-you';   
                       return false;
                    }
                }
                return false;
            },1000);
        }        
        
    });*/
    $('#portfiles').on("change", function(event) {
		var files = event.target.files; //FileList object
		var output = document.getElementById("resultPort");
		for (var i = 0; i < files.length; i++) {
			var file = files[i];
			//Only pics
			// if(!file.type.match('image'))
			if (file.type.match('image.*')) {
				if (this.files[0].size < 2097152) {
					// continue;
					var picReader = new FileReader();
					picReader.addEventListener("load", function(event) {
						var picFile = event.target;
                        div='<div class="col-xs-12 col-sm-6 col-md-5div"><div class="port-img" style="background-image: url('+picFile.result+');"><a href="javascript:void(0);" class="delete-tumb deleteImagePort"><i class="fa fa-times"></i></a><input style="display:none; " type="text" name="portfolio[]" value="'+picFile.result+'"/> </div></div>';						
						$('#resultPort').append(div);
					});
					//Read the image
					$('#clear, #resultPort').show();
					picReader.readAsDataURL(file);
				} else {
					alert("Image Size is too big. Minimum size is 2MB.");
					$(this).val("");
				}
			} else {
				alert("You can only upload image file.");
				$(this).val("");
			}
		}
	});
	function resetSession() {
		$.ajax({
			data: {
				action: 'resetsession'
			},
			url: SITE_URL + '/wp-admin/admin-ajax.php',
			type: 'get',
			success: function(response) {

			}
		});
	}
   	$(document).on('click', '.deleteImage', function() {
        $(this).parent().parent().parent().remove();
        var portFolioImg=$('#result .col-sm-4 a').length;
        var input = $('.pim').parents('.input-group').find(':text'),
		log = portFolioImg > 1 ? portFolioImg + ' files selected' : label;
        if (input.length) {
		 input.val(log);
		}
        if(portFolioImg>6){
            $('.loading_image').hide();
            $('.validationMsg').show();
            return false;
        }else{
            $('.validationMsg').hide();
            return true;
        }        
		
	}); 	
    $(document).on('click', '.deleteImagePort', function() {
		$(this).parent().parent().remove();
	});
	$(document).on('click', '.selectUserType', function() {
		var userType = $(this).attr('data-attr-val');
		$('#userTypedata').val(userType);
	});
	$(document).on('click', '.connectFacebook', function() {
		var userType = $('#userTypedata').val();
        $('.loading_image').show();
		$.ajax({
			data: {
				action: 'setusertype',
				userType: userType
			},
			url: SITE_URL + '/wp-admin/admin-ajax.php',
			dataType: 'json',
			type: 'get',
			success: function(response) {
                $('.loading_image').hide();
                if(response.status=='true'){
                    window.location.href = SITE_URL + '/facebook/index.php';
                }
			}
		});
		
	});
//    $(document).on('click','#profile-img-tag',function(){
    $(document).on('click','#profile-img-tag, .signup-img.updateIcon >*',function(){
        $('#imageData').trigger('click');
    }); 
    $(document).on('click','#profile-img-tag-photo, .signup-imgs.updateIcon >*',function(){
        $('#profile-img-photo').trigger('click');
    });
    
	$(document).on('click', '.connectGoogle', function() {
		var userType = $('#userTypedata').val();
        $('.loading_image').show();
		$.ajax({
			data: {
				action: 'setusertype',
				userType: userType
			},
			url: SITE_URL + '/wp-admin/admin-ajax.php',
			dataType: 'json',
			type: 'get',
			success: function(response) {
                $('.loading_image').hide();
              if(response.status=='true'){
                  window.location.href = SITE_URL + '/google/index.php';
               }  
			}
		});
		
	});
    $('.postTitle').html('SIGN UP AS PHOTOGRAPHER');
	$(document).on('click', '.changeTab', function() {
        var checkTab = $(this).attr('data-attr');
		if (checkTab == 'T') {
            $('.postTitle').html('SIGN UP AS TRAVELER');
            $('#photo-signup .form-control').removeClass('error');           
			initAutocompletetest();
			$('.localityP').attr('id', '');
			$('.countryP').attr('id', '');
			$('.latP').attr('id', '');
			$('.longP').attr('id', '');
			$('.administrative_area_level_1P').attr('id', '');
			$('.localityT').attr('id', 'locality');
			$('.countryT').attr('id', 'country');
			$('.latT').attr('id', 'lat');
			$('.longT').attr('id', 'long');
			$('.administrative_area_level_1T').attr('id', 'administrative_area_level_1');
		} else {
            $('#user-signup .form-control').removeClass('error');
            $('.postTitle').html('SIGN UP AS PHOTOGRAPHER');
			initAutocomplete();
			$('.localityT').attr('id', '');
			$('.countryT').attr('id', '');
			$('.latT').attr('id', '');
			$('.longT').attr('id', '');
			$('.administrative_area_level_1T').attr('id', '');
			$('.localityP').attr('id', 'locality');
			$('.countryP').attr('id', 'country');
			$('.latP').attr('id', 'lat');
			$('.longP').attr('id', 'long');
			$('.administrative_area_level_1P').attr('id', 'administrative_area_level_1');
		}
	});
	$('#birthday').datepicker({
       maxDate: 0,
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 1,
        yearRange: "-100:+0",
        dateFormat: "dd/mm/yy"
       
	});
	$('#birthdayP').datepicker({
		maxDate: 0,
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 1,
        yearRange: "-100:+0",
        dateFormat: "dd/mm/yy"
	});
    $('#sendRequestDate').datepicker({
		minDate: 0,
        dateFormat: "dd/mm/yy",
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 1,
	});
	$('#searchDate').datepicker({
		minDate: 0,
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 1,
        dateFormat: "dd/mm/yy"
        
	});
	function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				$('#profile-img-tag').attr('style', 'background-image: url(' + e.target.result + ')');
				$('#imageData').val(e.target.result);
			}
			reader.readAsDataURL(input.files[0]);
		}
	}
	$("#profile-img").change(function() {
		readURL(this);
	});
    function readURLImage(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				$('#profile-img-tag-photo').attr('style', 'background-image: url(' + e.target.result + ')');
				$('#imageDataPhoto').val(e.target.result);
			}
			reader.readAsDataURL(input.files[0]);
		}
	}
	$("#profile-img-photo").change(function() {
		readURLImage(this);
	});
	function addUser() {
		console.log('here');
		return false;
	}
    $("#rating_star").codexworld_rating_widget({
        starLength: '5',
        initialValue: '',
        //callbackFunctionName: 'processRating',
        imageDirectory: SITE_URL+'/wp-content/themes/photorabel-child/images/',
        inputAttr: 'postID'
    });
   
   
    
    
	/* start Search Photographer by location*/
	$(document).on('click', '.searchLocation', function(e) {
        //e.preventDefault();
		var location = $('input[name="address"]').val();
		var date = $('input[name="date"]').val();
		var startTime = $('input[name="startTime"]').val();
		var endTime = $('input[name="endTime"]').val();
		var temp = 0;
		if (location == '') {
			temp = 1;
			$('input[name="address"]').css('border', '1px solid red');
		}
		if (startTime != '') {
			if (endTime == '') {
				temp = 1;
				$('input[name="endTime"]').css('border', '1px solid red');
			}
			if (date == '') {
				temp = 1;
				$('input[name="date"]').css('border', '1px solid red');
			}
		}
		if (endTime != '') {
			if (startTime == '') {
				temp = 1;
				$('input[name="startTime"]').css('border', '1px solid red');
			}
			if (date == '') {
				temp = 1;
				$('input[name="date"]').css('border', '1px solid red');
			}
		}
		if (temp == 0) {
            $('.loading_image').show();
       }else{
            e.preventDefault();
        }
	});
	/* end Search Photographer by location*/
	/* end Development JS */
});
$(document).on('click','.ratingPopupBtn',function(){
    var comment=$('input[name="comment"]').val();
    var rating=$('input[name="rating"]').val();
    var temp='0';
    if(comment==''){
        temp='1';
      $('input[name="comment"]').addClass('error');  
    }
    if(rating=='0'){
       temp='1';
      $('.codexworld_rating_widget').addClass('error');  
    }
    if(temp=='0')
    {
        $('.loading_image').show();
        var form=$('#ratingPopupForm').serializeArray();
        $.ajax({
            url: SITE_URL +'/wp-admin/admin-ajax.php',
            type: 'POST',
            dataType:'json',
            data:form,
            success : function(response) {
               $('.loading_image').hide();
                $('.responserate').show();
               if(response.status=='true'){
                $('.responserate').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+response.message+'</div>');
                $('#ratingPopupForm')[0].reset();
                $('.responserate').delay(2000).fadeOut();
                setTimeout(function(){
                 $('#ratingPopup').modal('hide');
                    location.reload();
                },1000);                
              }else{
                 $('.responserate').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+response.message+'</div>'); 
               }
            }
        }); 
        
    }
     
});

function removeClassTest(){
    $('.loading_image').hide();
    $(document).find('body').removeClass('siteLoading');         
}