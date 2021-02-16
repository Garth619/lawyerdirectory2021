// @codekit-prepend 'googlemap.js'
// @codekit-prepend 'waypoints.js'
// @codekit-prepend 'slick.js'
// @codekit-prepend 'lity.js'
// @codekit-prepend 'modernizr-webp.js'


jQuery(document).ready(function($){
	
	
	
		// section one animation
		
		
		$('body.page-template-template-home').addClass('ready');
	
	
	 /* Modernizr - check if browser supports webp for section_one. 
     --------------------------------------------------------------------------------------- */
    
    // add data-webp and data-jpg to images in section one and you're gucci
    
     Modernizr.on('webp', function (result) {
	    
	    $('#section_one img').each(function () {
	    
				if (result) {
    
					if ($(this).attr('data-webp')) {
          
          	var img = $(this).data('webp');
          
						$(this).attr('src', img);
        	
        	}
        	
        }
  
	 			else {
		 			
		 			if ($(this).attr('data-jpg')) {
          
          	var img = $(this).data('jpg');
          
						$(this).attr('src', img);
        	
        	}
    
    		}
  		
  		});
  		
  		
  		// background images (one time load, does not reflect media queries or window width..yet)
  		
  		if (result) {
	  		
	  		var sectionOne = '#section_one';
	  		
	  		if ($(sectionOne).attr('data-webpbg')) {
		  		
		  		var imgBg = $(sectionOne).data('webpbg');
		  		
		  		$(sectionOne).css('background-image', 'url(' + imgBg + ')');
		  		
	  		}
	  		
	  	}
	  	
	  	
	  	else {
		  	
		  	if ($('#section_one').attr('data-jpgbg')) {
		  		
		  		var imgBg = $('#section_one').data('jpgbg');
		  		
		  		$('#section_one').css('background-image', 'url(' + imgBg + ')');
		  		
	  		}
		  	
	  	}
  		
			// console.log(result);
	
		});
		
		
		
		/* Load Images - Call function when you reach the a section with images using waypoints
       BG image - <div data-src=""></div>   ,   Image - <img data-src="">
      --------------------------------------------------------------------------------------- */

    function loadImages() {
      
      // images
      
      $('img').each(function () {
        
        if ($(this).attr('data-src')) {
          
          var img = $(this).data('src');
          
          $(this).attr('src', img);
        
        }
      
      });

      // background images
      
      $('div, section').each(function () {
       
        if ($(this).attr('data-src')) {
          
          var backgroundImg = $(this).data('src');
          
          $(this).css('background-image', 'url(' + backgroundImg + ')');
        
        }
      
      });

     
    }

    createWaypoint('internal_main', null, null, -10, loadImages, false);







     /* Wistia - Call function when script needs to be loaded either by hover or waypoints
     --------------------------------------------------------------------------------------- */

    //function wistiaLoad() {
     // jQuery.getScript('https://fast.wistia.com/assets/external/E-v1.js', function(data, textStatus, jqxhr) {
        //console.log('wistia load:', textStatus); // Success
     // });
   // }

    // examples:

    // jQuery(".banner-box-1").one("mouseenter", function(e){
    //   wistiaLoad();
    // });

    // createWaypoint('section-1', null, null, '100%', wistiaLoad, false)
    
    
    $('.wistia_embed').click(function () {
        //make sure to only load if Wistia is not already loaded
        if (typeof Wistia === 'undefined') {
            $.getScript("https://fast.wistia.com/assets/external/E-v1.js", function (data, textStatus, jqxhr) {
                // We got the text but, it's possible parsing could take some time on slower devices. Unfortunately, js parsing does not have
                // a hook we can listen for. So we need to set an interval to check when it's ready 
                var interval = setInterval(function () {
                    if ($('.wistia_embed').attr('id') && window._wq) {
                        var videoId = $('.wistia_embed').attr('id').split('-')[1];
                        window._wq = window._wq || [];
                        _wq.push({
                            id: videoId,
                            onReady: function (video) {
                                $('.wistia_click_to_play').trigger('click');
                            }
                        });
                        clearInterval(interval);
                    }
                }, 100)
            });
        }
    })
   
    
    
    
    
    



    /* Smooth Scroll down to section on click (<a href="#id_of_section_to_be_scrolled_to">)
      --------------------------------------------------------------------------------------- */

    $(function() {
      $('a[href*="#"]:not([href="#"])').click(function() {
        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
          var target = $(this.hash);
          target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
          if (target.length) {
            $('html, body').animate({
              scrollTop: target.offset().top
            }, 1000);
            return false;
          }
        }
      });
    });

		
		
		/* Waypoints
     --------------------------------------------------------------------------------------- */


    function createWaypoint(triggerElementId, animatedElement, className, offsetVal, functionName, reverse) {
      if(jQuery('#' + triggerElementId).length) {
        var waypoint = new Waypoint({
          element: document.getElementById(triggerElementId),
          handler: function (direction) {
            if (direction === 'down') {
              jQuery(animatedElement).addClass(className);

              if (typeof functionName === 'function') {
                functionName();
                this.destroy();
              }

            } else if (direction === 'up') {
              if (reverse) {
                jQuery(animatedElement).removeClass(className);
              }

            }
          },
          offset: offsetVal
          // Integer or percent
          // 500 means when element is 500px from the top of the page, the event triggers
          // 50% means when element is 50% from the top of the page, the event triggers
        });
      }
    }
		
		
		

    createWaypoint('internal_main', '.mobile_sticky_header', 'visible', -300, null, true);
    
    

    


/* Slick Carousel ( http://kenwheeler.github.io/slick/ )
--------------------------------------------------------------------------------------- */



$('.sec_two_grid').slick({
  infinite: true,
  slidesToShow: 1,
  slidesToScroll: 1,
  mobileFirst:true,
	arrows:true,
	prevArrow:".sec_two_button_left",
	nextArrow:".sec_two_button_right",
	responsive: [
    {
      breakpoint: 700,
      settings: {
      slidesToShow: 2,
      slidesToScroll: 2,
     }
   },
   {
      breakpoint: 1066,
      settings: "unslick"
   }
	]
 });
 
 
 
 
 $('.att_bio_case_results_slider').slick({
  infinite: true,
  slidesToShow: 3,
  slidesToScroll: 3,
  arrows:true,
	prevArrow:".cr_button_left",
	nextArrow:".cr_button_right",
	responsive: [
    {
      breakpoint: 1275,
      settings: {
      slidesToShow: 2,
      slidesToScroll: 2,
     }
   },
   {
      breakpoint: 980,
      settings: {
      slidesToShow: 1,
      slidesToScroll: 1,
      adaptiveHeight: true
     }
   }
	]
 });
 

 

	

/* Remove "#" from menu anchor items to avoid jump to the top of the page
--------------------------------------------------------------------------------------- */


$("ul > li.menu-item-has-children > a[href='#']").removeAttr("href");




$('.sec_three_tab').on('click', function(e) {
  
	$('.sec_three_tab').removeClass('active');
	
	$(this).addClass('active');

});




// Section Three Tabs



$('.sec_three_tab').on('click', function(e) {
  
	var dataTab = $(this).attr('data-tab');
	
/*
	$('.sec_three_list').fadeOut(300);
   
  $('.'+dataTab).delay(600).fadeIn(400);
*/
  
  $('.sec_three_list').fadeOut(300);
   
  $('.'+dataTab).delay(600).show(0);
  
  $('.sec_three_list_wrapper, a.view_all_button').addClass('hide');
  
  
  $('.sec_three_list_wrapper, a.view_all_button').delay(600).queue(function(){
        
  	$(this).removeClass('hide').dequeue();
     
  });
  
  

});



  // faq
  
  
  $('.single_faq').on('click', function(e) {
    
    $(this).find('.faq_answer').slideToggle(300);
    
    $(this).find('.faq_question').toggleClass('active');
    
  });
  
  
  
  //on page list filter
  
  $(".list_input").on("keyup", function() {
	  
    var value = $(this).val().toLowerCase();
    
    $(".browse_filter ul li").filter(function() {
	    
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);           
      
    });
    
    $(".single_lawyer_result").filter(function() {
	    
      $(this).toggle($(this).find('span.single_lawyer_title').text().toLowerCase().indexOf(value) > -1);
      
    });
    
  });
 
  
  // form styles
  
  $('.form_wrapper textarea').parent().parent().addClass('textarea_wrap');

	
	
	// nav
	
	
		var windowWidth = $(window).width();
	
	
	
		function navWidth() {
	    
	    if (windowWidth >= 1100) {
	        
	      
	      $('nav').addClass('desktop');
	      
	      
	      $('nav ul.menu > li.menu-item-has-children > a').on('click', function(e) {
	        
	      	$(".submenu_container").empty();
	      
					$(this).next('ul.sub-menu').clone().appendTo('.submenu_container').fadeIn();
	      
	      
	      });
	      
	      
	      // current page clone
	
				$('nav ul.menu > li.current-menu-ancestor > a').next('ul.sub-menu').clone().appendTo('.submenu_container').show();
	    		    	   		
	    		
	    }
	    
	     if (windowWidth <= 1099) {
		     
		     $('nav ul.menu > li.menu-item-has-children > a').on('click', function(e) {
			     
			     $(this).next('ul.sub-menu').slideToggle(300);
		       
		     });
		     
	     }
	    
	   
		};
		
	
	 navWidth();
	 
	 
	 $('.menu_wrapper').on('click', function(e) {
	   
	 	$('nav').slideDown(450);
	 
	 });
	 
	 
	 $('.nav_close').on('click', function(e) {
	   
	 	$('nav').slideUp(450);
	 
	 });
	 
	 
	 
	 // att bio lawyer visit website validation
	 
	 
	 var myUrl = $('a.visit_website_button').attr("href");
	 
	 if(myUrl) {
		 
	 	if(!myUrl.includes("//")){
   	
		 	//console.log(myUrl + ' doesnt have "//" at all - add in to fix broken link');
		 	
		 	$(myUrl).prepend('//');
		 	
		 	$('a.visit_website_button').attr('href',function(i,v) {
		 		
		 		return "//" + v;
			
			});
		
		 }
		 
	 }
	 
	 
	 // custom search section one
	 
	 
	 $('.sec_one_select').on('click', function(e) {
	   
	 	$('.sec_one_select_dropdown').slideToggle(300);
	 
	 });
	 
	 
	 $('.sec_one_select_dropdown ul li span').on('click', function(e) {
	   
	 	var typeoflaw = $(this).text();
	 	
	 	$('.sec_one_select span').replaceWith('<span class="select_text">' +typeoflaw+ '<span>');
	 	
	 	$('input#typeoflaw').val(typeoflaw);
	 	
	 		$('.sec_one_select_dropdown').slideUp(300);
	 	
	 });
	 
	 
	 $(document).click(function (e){

			var container = $(".sec_one_select_wrapper");

			if (!container.is(e.target) && container.has(e.target).length === 0){

				$('.sec_one_select_dropdown').slideUp(300);
		
			}

		}); 
	 
	 
	 // new search slidetoggle
	 
	 
	 $('span.make_new_search').on('click', function(e) {
		 
		$(this).delay(200).fadeOut(400);
	   
	 	$('.new_search_wrapper .three_part_search_wrapper').delay(800).slideDown();
	 
	 });
	 
	
	
	// mobile search

	
	$('.mobile_refine_wrapper').on('click', function(e) {
	  
		$('.mobile_search_overlay').slideToggle();
		
		$(this).fadeOut(300);
		
		$('.mobile_close_wrapper').delay(300).css("display", "flex").hide().fadeIn(300);
	
	});
	
	
	$('.mobile_close_wrapper').on('click', function(e) {
	  
		$('.mobile_search_overlay').slideToggle();
		
		$(this).fadeOut(300);
		
		$('.mobile_sticky_header').removeClass('show');
		
		$('.mobile_refine_wrapper').delay(300).css("display", "flex").hide().fadeIn(300);
	
	});
	
	// total count to top of page, it has to process after the loop but needs to be placed above it visually
	
	var textUpdate = $('span.overall_count').text();
		
	$('span.results_number').replaceWith('<span class="no_filter_space results_number">Total Lawyers (' + textUpdate + ')</span>');
	
	// pagination to top of page, it has to process after the loop but needs to be placed above it visually
	
	$('.bottom_pagination').clone().appendTo('.top_pagination');
	
	// adds class for proper spacing to headers if page descriptions are there or not 
	
	
	if ($(".directory_description")[0]){
    
		$('h2.browse_city, h2.featured_city').addClass('decription_exists');
	
	}
	
	
	if (!$("h2.featured_city")[0]){
    
		$('h2.browse_city').addClass('no_featured_header');
	
	} 	
	
	
	if ($(".directory_description")[0] && !$("h2.featured_city")[0] ) { 
	
		$('h2.browse_city').addClass('no_featured_header_with_description');
	
	}
	
	
	// claim overlay and upgrade to premium overlay
	
	$('a.claim_button, span.upgrade_prompt').on('click', function(e) {
		
		$('#internal_main').fadeOut(400);
		
		$('.mobile_edit').addClass('fadeout');
				
		$('.overlay').delay(800).fadeIn();
			
	});
	
	// close/back to profile
	
	$('.overlay_close, .go_back_to_profile').on('click', function(e) {
		
		$('.overlay').fadeOut(400);
		
		$('#internal_main').delay(800).fadeIn();
		
		$('.mobile_edit').removeClass('fadeout');
		
	});
	

	// claim/create profile form
	
	$('span.claim_begin').on('click', function(e) {
	  
		$('.price_description').fadeOut(300);
		
		$('.mymultistep_form, .go_back_form').delay(500).fadeIn(300);
	
	});
	
	// layout styles: target li that has a textarea child and make it flex-basis 100%
	
	function myflexWidth() {
		
		$('.mymultistep_form textarea').parent().parent().addClass('flex_width');
	
		$('.form_content_wrapper').parent().addClass('flex_width');
	
		$('.ginput_container_checkbox').parent().addClass('flex_width');
		
	}
	
	myflexWidth();
	
	function formredirectInfo() {
		
		// post id
		
		var postid = $('h1').attr('id');
		
		$('.mypost_id input').val(postid);
		
		// site url for redirect
		
		var homeurl = $('h1').data('homeurl');
		
		$('.myhomeurl input').val(homeurl);

  
	}

	formredirectInfo();
	
	// populate the claim profile form with exisiting profile info on bio pages (super hardcoded in order to map correctly)
	
	function mypopulateForm() {
		
		
		// name
  
		var iname = $('.internal_banner h1').text();
		
		$('.mylawyer_name input').val(iname);
		
		// phone
		
		var iphone = $('a.att_bio_phone').text();
		
		$('.mylawyer_phone input').val(iphone);
		
		// email
		
		var iemail = $('a.att_bio_email').text();
		
		$('.mylawyer_email input').val(iemail);
		
		// lawfirm name
		
		var ilawfirm = $('.lawfirm_name').text();
		
		$('.mylawfirm_name input').val(ilawfirm);
		 
		// website url
		 
		var iurl = $('a.visit_website_button').attr('href');
		
		$('.mylawfirm_url input').val(iurl);
		
		
		// street address
		
		var istreetaddress = $('.street_address').text();;
		
		$('.mylawyer_streetaddress input').val(istreetaddress);

		 
		// City, State and Zip Code metadata are being set up in the functions.php. This is bc I am not using these acfs onthe template and I don't want them to index along with the whole address acf in the sidebar (street address doesn't exist in this database)
		 
		// City
		 
		var icity = my_mapdata.lawyerbio_city;
		
		$('.mylawyer_city input').val(icity);
		 
		// State
		 
		var istate = my_mapdata.lawyerbio_state;
		
		$('.mylawyer_state select').val(istate);
		 
		// Zip code
		 
		var izip = my_mapdata.lawyerbio_zipcode;
		
		$('.mylawyer_zipcode input').val(izip);
		 	 
		// pa
		 
		//var paItem = [];
		 
		// $(".att_bio_pa_list ul li").each(function() { 
			 
	 //paItem.push($(this).text()) 
			 
	 //});
		 
	 //var paList = '' + paItem.join(', ') + '';
		 
	 // $('textarea#input_2_26').val(paList);
		
	 // school one name
		 
	 var ischoolonename = $('.school_one_name').text();
		
	 $('.myschool_one_name input').val(ischoolonename);
		 
	 // school one major
	
	 var ischoolonemajor = $('.school_one_major').text();
		
	 $('.myschool_one_major input').val(ischoolonemajor);
		
	 // school one degree
		
	 var ischoolonedegree = $('.school_one_degree').text();
		
	 $('.myschool_one_degree input').val(ischoolonedegree);
		
	 // school one year grad
		
	 var ischooloneyeargrad = $('.school_one_year_graduated').text();
		
	 $('.myschool_one_year_grad input').val(ischooloneyeargrad);
		
	 // school two name
		
	 var ischooltwoname = $('.school_two_name').text();
		
	 $('.myschool_two_name input').val(ischooltwoname);
		
	 // school two major
		
	 var ischooltwomajor = $('.school_two_major').text();
		
	 $('.myschool_two_major input').val(ischooltwomajor);
		
	 // school two degree
		
	 var ischooltwodegree = $('.school_two_degree').text();
		
	 $('.myschool_two_degree input').val(ischooltwodegree);
		
	 // school two year grad
		
	 var ischooltwoyeargrad = $('.school_two_year_graduated').text();
		
	 $('.myschool_two_year_grad input').val(ischooltwoyeargrad);
		
	 // years licensed for
		
	 var iyears = $('.years_licensed_for').text();
		
	 $('.my_years_liscensed input').val(iyears);
	 
	 // latitude
	 
	 var ilatitude = my_mapdata.lawyerbio_latitude;
		
	 $('.mylatitude input').val(ilatitude);
	 
	 // longitude
	 
	 var ilongitude = my_mapdata.lawyerbio_longitude;
		
	 $('.mylongitude input').val(ilongitude);
	 
	 // bio
	 
	 var ibio = $('.lawyer_bio').text();
		
	 $('.mylawyer_bio textarea').val(ibio);
	 
	 //console.log(ibio);
		
	}
	
	if($('body.single-lawyer').length >0 ){ // populate only on existing single lawyer forms

		mypopulateForm();

	}
	
	// replace the select dropdown with a better styled version
		

	function selectStyle() {
		
		// grabs all options text
		
		// state
		
		var stateSelect = '.mymultistep_form_wrapper li.mylawyer_state select';
		var stateOption = '.mymultistep_form_wrapper li.mylawyer_state option';
		
		// update sidebar state
		
		var updatestateSelect = '.update_custom_form li.mylawyer_state select';
		var updatestateOption = '.update_custom_form li.mylawyer_state option';
		
		// ccmonth
		
		var ccmonthSelect = 'select.ginput_card_expiration_month';
		var ccmonthOption = 'select.ginput_card_expiration_month option';
		
		// ccyear
		
		var ccyearSelect = 'select.ginput_card_expiration_year';
		var ccyearOption = 'select.ginput_card_expiration_year option';
		
		
		// state options
		
		var valuesArray = $(stateOption).map(function(){
			return this.value;
		});
		
		// update state options
		
		var updatestateArray = $(updatestateOption).map(function(){
			return this.value;
		});
		
		// cc month options
		
		var ccmonthArray = $(ccmonthOption).map(function(){
			return this.value;
		});
		
		// cc year options
		
		var ccyearArray = $(ccyearOption).map(function(){
			return this.value;
		});
		
		// variable to get current value
		
		var currentValue = $('li.mylawyer_state select').val();
		
		// list out all options data into new list
		
		ulstate = $('<ul>');
		
		ulupdatestate = $('<ul>');
		
		ulccmonth = $('<ul>');
		
		ulccyear = $('<ul>');
		
		// list state options

		$.each(valuesArray, function(index, value) {
  		$('<li>').text(value).appendTo(ulstate);
		});
		
		// list update state options

		$.each(updatestateArray, function(index, value) {
  		$('<li>').text(value).appendTo(ulupdatestate);
		});
		
		// list cc month options
		
		$.each(ccmonthArray, function(index, value) {
  		$('<li>').text(value).appendTo(ulccmonth);
		});
		
		// list cc year options
		
		$.each(ccyearArray, function(index, value) {
  		$('<li>').text(value).appendTo(ulccyear);
		});
		
		
		// create new markup
		
		// state

		$('<div class="state_wrapper myselect_wrapper"><div class="myselect_label"><span>'+currentValue+'</span></div><div class="myselect_dropdown"></div></div>').insertAfter(stateSelect);
		
		// update state

		$('<div class="updatestate_wrapper myselect_wrapper"><div class="myselect_label"><span>'+currentValue+'</span></div><div class="myselect_dropdown"></div></div>').insertAfter(updatestateSelect);
		
		// cc month
		
		$('<div class="ccmonth_wrapper myselect_wrapper"><div class="myselect_label"><span>Month</span></div><div class="myselect_dropdown"></div></div>').insertAfter(ccmonthSelect);
		
		// cc year
		
		$('<div class="ccyear_wrapper myselect_wrapper"><div class="myselect_label"><span>Year</span></div><div class="myselect_dropdown"></div></div>').insertAfter(ccyearSelect);


		ulstate.appendTo('.state_wrapper .myselect_dropdown');
		
		ulupdatestate.appendTo('.updatestate_wrapper .myselect_dropdown');
		
		ulccmonth.appendTo('.ccmonth_wrapper .myselect_dropdown');
		
		ulccyear.appendTo('.ccyear_wrapper .myselect_dropdown');
		
		// open dropdown
		
		$('.myselect_label').on('click', function(e) {
			
			$('.myselect_dropdown').removeClass('open');
			
			$(this).next('.myselect_dropdown').addClass('open');
		  
		});
		
		// on list item click get the text and add it to the label, also update the select val
		
		$('.myselect_dropdown ul li').on('click', function(e) {
		  
		  var selectVal = $(this).text();
		  
		  $(this).closest('.myselect_dropdown').prev('.myselect_label').find('span').replaceWith('<span>'+selectVal+'</span>');
		  
		  $(this).closest('.myselect_wrapper').prev('select').val(selectVal);
		  
		  $('.myselect_dropdown').removeClass('open');
		  
		
		});
		
		// click anywhere outside the dropdown to have it close (mimic select behavior)
		
		
		$(document).click(function (e){

			var container = $(".myselect_wrapper");

			if (!container.is(e.target) && container.has(e.target).length === 0){

				$('.myselect_dropdown').removeClass('open');
		
			}

		}); 

		
		
			 	
	 }
	 
	 selectStyle();
	 
	 
	// latitude and longitude
	
	function multisteplatlong() {
		
		var latStreet = $('.mymultistep_form_wrapper .mylawyer_streetaddress input').val();
		var latCity = $('.mymultistep_form_wrapper .mylawyer_city input').val();
		var latState = $('.mymultistep_form_wrapper .mylawyer_state select').val();
		var latZip = $('.mymultistep_form_wrapper .mylawyer_zipcode input').val();
		var address = ''+latStreet+', '+latCity+', '+latState+' '+latZip+'';
		var address_plus = address.replace(/\s/g , "+");
		
		$.ajax({
			url: 'https://maps.googleapis.com/maps/api/geocode/json?address='+address_plus+'&key=AIzaSyChzxFAVcjAp_u54o_pMNaKQhkBnfJsbzc',
		  dataType: 'json',
		  success: function(json) {
		    //console.log(json.results[0].geometry.location.lat);
		    //console.log(json.results[0].geometry.location.lng);
		            
		    var mylat = json.results[0].geometry.location.lat;
		    var mylong = json.results[0].geometry.location.lng;
		            
		    $('.mymultistep_form_wrapper .mylatitude input').val(mylat);
		    $('.mymultistep_form_wrapper .mylongitude input').val(mylong);
		  }
		});
	}
	
	function updatelatlong() {
		
		var latStreet = $('.update_custom_form .mylawyer_streetaddress input').val();
		var latCity = $('.update_custom_form .mylawyer_city input').val();
		var latState = $('.update_custom_form .mylawyer_state select').val();
		var latZip = $('.update_custom_form .mylawyer_zipcode input').val();
		var address = ''+latStreet+', '+latCity+', '+latState+' '+latZip+'';
		var address_plus = address.replace(/\s/g , "+");
		
		$.ajax({
			url: 'https://maps.googleapis.com/maps/api/geocode/json?address='+address_plus+'&key=AIzaSyChzxFAVcjAp_u54o_pMNaKQhkBnfJsbzc',
		  dataType: 'json',
		  success: function(json) {
		    console.log(json.results[0].geometry.location.lat);
		    console.log(json.results[0].geometry.location.lng);
		            
		    var mylat = json.results[0].geometry.location.lat;
		    var mylong = json.results[0].geometry.location.lng;
		            
		    $('.update_custom_form .mylatitude input').val(mylat);
		    $('.update_custom_form .mylongitude input').val(mylong);
		  }
		});
	}
	
	
	function mylatLng() {
		
		// read only input
		
		$('.mylatitude input, .mylongitude input').prop('readonly', true);
		
				
		// clear the old lat and long if the original value is changed
		
		
		$('.myaddress input').on('input', function() {
   
			$('.mylatitude input, .mylongitude input').val('');
		
		});
		
		// if all address input fields have a value, fire the ajax call to convert the address into latitude/longtitude coordinates
		
		// multistep form
		
		$('.mymultistep_form_wrapper span.calculate_lat_long').on('click', function(e) {
			
			// if all address inputs are filled out then fire the lat long coordinates on click, spaced out to target each one for validation
		
			
			if(!$('.mymultistep_form_wrapper .mylawyer_streetaddress input, .mymultistep_form_wrapper .mylawyer_city input, .mymultistep_form_wrapper .mylawyer_state input, .mymultistep_form_wrapper .mylawyer_zipcode input').val() == '') {
		  
		  	multisteplatlong();
		  	
		  
			}
		
		});
		
		// update form
		
		
		$('.update_custom_form span.calculate_lat_long').on('click', function(e) {
			
			// if all address inputs are filled out then fire the lat long coordinates on click, spaced out to target each one for validation
		
			
			if(!$('.update_custom_form .mylawyer_streetaddress input, .update_custom_form .mylawyer_city input, .update_custom_form .mylawyer_state input, .update_custom_form .mylawyer_zipcode input').val() == '') {
		  
		  	updatelatlong();
		  	
		  
			}
		
		});

		
		
		
	}
	
	mylatLng();
	
	// updates the paypal product to basic or premium from the three optioned profile radio buttons (excluding the free claim profile option)
	
	function layouttoProduct() {
		
		// adding classes to radio buttons for both forms (update and create forms)
		
		$('.myprofile_choice ul.gfield_radio li').each(function(i, el) {
    
    	if ( i === 0) {
      
      	$(this).find('input').addClass('claim');
      	
    	}

    	
    	if ( i === 1) {
      
      	$(this).find('input').addClass('basic');
      	
    	}
    	
    	if ( i === 2) {
      
      	$(this).find('input').addClass('premium');
      	
    	}
    
    });
    
    
    $('.mypaypal_product ul.gfield_radio li').each(function(i, el) {
    
    	if ( i === 0) {
      
      	$(this).find('input').addClass('basic');
      	
    	}
    	
    	if ( i === 1) {
      
      	$(this).find('input').addClass('premium');
      	
    	}
    
    });
		
		// ties values of layout and product together of both radio sets
		
		$('.myprofile_choice input').change(function(){
    	
    	$('.' + this.className).prop('checked', this.checked);

   	});
		
	}
	
	layouttoProduct();
	
	// contact info checkmark
	
	function mycontactCheck() {
		
		
		$('.mycontact_checkmark input[type="checkbox"]').change(function() {
		  
		  if ($(this).is(':checked')) {
		    
		    // name
				
				var contactname = $('.mylawyer_name input').val();
				
				$('.mypersonal_name input').val(contactname);
				
				// maps to credit card feilds (if in use)
				
				$('input#input_2_104_5, input#input_4_101_5, input#input_11_104_5').val(contactname);
				
				$('.mypersonal_name input').change(function() {
					
					var fullname = $('.mypersonal_name input').val();
					
					$('input#input_2_104_5, input#input_4_101_5, input#input_11_104_5').val(fullname);
					
				});
				
				// email
				
				var contactemail = $('.mylawyer_email input').val();
				
				$('.mypersonal_email input').val(contactemail);
				
				// phone
				
				var contactphone = $('.mylawyer_phone input').val();
				
				$('.mypersonal_phone input').val(contactphone);
				
				// street address
				
				var contactstreet = $('.mylawyer_streetaddress input').val();
				
				$('.mypersonal_streetaddress input').val(contactstreet);
				
				// city
				
				var contactcity = $('.mylawyer_city input').val();
				
				$('.mypersonal_city input').val(contactcity);
				
				// state
				
				var contactstate = $('.mylawyer_state select').val();
				
				$('.mypersonal_state input').val(contactstate);
				
				//console.log(contactstate);
				
				// zip
				
				var contactzip = $('.mylawyer_zipcode input').val();
				
				$('.mypersonal_zipcode input').val(contactzip);
				
				
			} else {
			  
			  $('.mypsersonal_address input, .mypsersonal_address select, input#input_2_104_5, input#input_4_101_5').val('');
		    
		 }
		  
		
		});


	}
	
	mycontactCheck();
	
	// fires prepare only if there isnt a gform error class added
	
	function multistepListener() {
		
			
			var target = document.querySelectorAll(".gform_wrapper");
			
			for (var i = 0; i < target.length; i++) {

			// create an observer instance
			var observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            
					if (mutation.attributeName === "class") {
            if ($(mutation.target).hasClass('gform_validation_error')){
	            			console.log('gform_validation_error class was added');
	            			$('.prepare_overlay').removeClass('fadein');
                   // alert("gform_validation_error class was added");
                    //fill();
           }
         }
            
        });
    	});

			// configuration of the observer
			var config = { attributes: true };

			// pass in the target node, as well as the observer options
			observer.observe(target[i], config);
		}

			/*
			var observer = new MutationObserver(function(mutations) {
			       mutations.forEach(function(mutation) {
			         if (mutation.attributeName === "class") {
			            if ($(mutation.target).hasClass('gform_validation_error')){
				            			console.log('gform_validation_error class was added');
				            			$('.prepare_overlay').removeClass('fadein');
			                    alert("gform_validation_error class was added");
			                    //fill();
			           }
			         }
			     });
			  });
			
			observer.observe(document.getElementById('gform_wrapper_2'), {
			  attributes: true
			});
			*/

		}


		multistepListener();
		
		
		
		// fires the same prepare overlay when clicking the acf update form submit button
		
		
		$('#acf-form input[type="submit"]').on('click', function(e) {
		  
			$('.prepare_overlay').addClass('fadein_nodelay');
		
		
		});
	
	
	
	
	// add all the custom jquery above back into the form after it does ajax validation
	
	$(document).bind('gform_post_render', function(){
		
			myflexWidth();
			mylatLng();
			formredirectInfo();
			mycontactCheck();
			layouttoProduct();
			selectStyle();
			
	});
	
	
	// success overlay
	
	//var url = location.href;

  if (location.href.search('success') >= 0) $('.show_on_success').show();
	
	// remove query on close
	
	$('span.success_close').on('click', function(e) {
		
		$('.success_overlay').fadeOut(300);
		
		var uri = window.location.toString();
		
		if (uri.indexOf("?") > 0) {
	    var clean_uri = uri.substring(0, uri.indexOf("?"));
	    window.history.replaceState({}, document.title, clean_uri);
		}
	  
	});
	
	// password
	
	$('<p class="login-forgot-password"><a href="/wp-login.php?action=lostpassword">Forgot Password?</a></p>').insertAfter('p.login-password');
	
	
	


/*
var $div = $("#gform_wrapper_2");
var observer = new MutationObserver(function(mutations) {
  mutations.forEach(function(mutation) {
    if (mutation.attributeName === "class") {
      var attributeValue = $(mutation.target).prop(mutation.attributeName);
      console.log("Class attribute changed to:", attributeValue);
      $('.prepare_overlay').removeClass('fadein');
     
    }
  });
});
observer.observe($div[0], {
  attributes: true
});
*/


/*
var target = document.querySelectorAll(".gform_wrapper");
for (var i = 0; i < target.length; i++) {

    // create an observer instance
    var observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            var foo = mutation.target.getAttribute("class")

            if (foo == "gform_validation_error")
                mutation.target.style.backgroundColor = "red";
        });
    });

    // configuration of the observer
    var config = { attributes: true };

    // pass in the target node, as well as the observer options
    observer.observe(target[i], config);
}
*/

// let's change an attribute in a second
/*
setTimeout(function(){
  target[2].setAttribute('someAttribute', 'someValue');
}, 1000);
*/


/*
var e = document.getElementById('gform_wrapper_2')
var observer = new MutationObserver(function (event) {
  console.log(event)   
})

observer.observe(e, {
  attributes: true, 
  attributeFilter: ['class'],
  childList: false, 
  characterData: false
})

setTimeout(function () {
  e.className = 'gfrom_validation_error'
}, 1000)
*/




//var elements = document.getElementsByClassName("gform_wrapper");elements[0].className += " garrett";




// login overlay





/*
$('.login_link').on('click', function(e) {
  
	$('.custom_login').addClass('fadein');

});
*/


/*
$('span.back_to_site').on('click', function(e) {
	
	
	
	var url = window.location.href.split('?')[0];
	
	window.history.back();
	
});
*/



// edit buttons and update profile when user is logged in

// this needs to be more specific to only show on the persons editable post

if($('.current_author_form').length >0 ){
	
	function formEdit() {
		
		$('html, body').addClass('fixed');
  
		$('.update_custom_form').addClass('open');
		
		$('#internal_main').addClass('blur');
		
	}
	
	function hideAcf() {
		
		$('.acf-tab-wrap, .acf-field, .acf-form-submit').css('display','none');
		
	}
	
	
	function hideGravity() {
		
		$('.update_custom_form .gform_wrapper').hide();
		
	}
	
	function repeaterPlaceholder() {
		
		$('[data-type="repeater"] input, [data-type="repeater"] textarea').each(function(){
    
  		var phText = $(this).closest('.acf-field').find('label').text();
  	
  		$(this).attr("placeholder", phText);
  	
  	});
				
	}
	
	repeaterPlaceholder();
	
	
	
	$('.myedit').append('<span class="edit_icon"></span>');

	// acf form

	$('.myedit.acf_edit span.edit_icon').on('click', function(e) {
	
		formEdit();
		
		hideGravity();
		
		hideAcf();
  
		var showField = $(this).parent('.myedit').data('acfupdate');

		$('[data-name="'+showField+'"], [data-name="'+showField+'"] .acf-field, .acf-form-submit').css('display','block');
		
		// custom premium selling section needs specific and multiple acf fields open
		
		if ($(this).parent().data('acfupdate') === 'selling_points_section') {
			
			$('[data-name="disable_selling_point_section"], [data-name="selling_points_title"], [data-name="selling_points_description"], [data-name="selling_point_banner_options"], [data-name="selling_point_banner_image_custom"]').css('display','block');
			
		}
		
		// custom premium case results section needs specific and multiple acf fields open
		
		if ($(this).parent().data('acfupdate') === 'case_result_section') {
			
			$('[data-name="disable_case_results_section"], [data-name="lawyer_case_result_slides"], [data-name="lawyer_case_result_slides"] .acf-field').css('display','block');
			
		}
		
		// custom premium faq section needs specific and multiple acf fields open
		
		if ($(this).parent().data('acfupdate') === 'lawyer_faq_col') {
			
			$('[data-name="disable_faq_section"], [data-name="lawyer_faq"], [data-name="lawyer_faq"] .acf-field').css('display','block');
			
		}
		
  
  
	});
	
	
	// acf form enable options in the premium banner

	$('span.enable').on('click', function(e) {
	
		formEdit();
		
		hideGravity();
		
		hideAcf();
  
		var showField = $(this).parent().data('acfupdate');

		$('[data-name="'+showField+'"], [data-name="'+showField+'"] .acf-field, .acf-form-submit').css('display','block');
		
		// custom premium selling section needs specific and multiple acf fields open
		
		if ($(this).parent().data('acfupdate') === 'selling_points_section') {
			
			$('[data-name="disable_selling_point_section"], [data-name="selling_points_title"], [data-name="selling_points_description"], [data-name="selling_point_banner_options"], [data-name="selling_point_banner_image_custom"]').css('display','block');
			
		}
		
		// custom premium case results section needs specific and multiple acf fields open
		
		if ($(this).parent().data('acfupdate') === 'case_result_section') {
			
			$('[data-name="disable_case_results_section"], [data-name="lawyer_case_result_slides"], [data-name="lawyer_case_result_slides"] .acf-field').css('display','block');
			
		}
		
		// custom premium faq section needs specific and multiple acf fields open
		
		if ($(this).parent().data('acfupdate') === 'lawyer_faq_col') {
			
			$('[data-name="disable_faq_section"], [data-name="lawyer_faq"], [data-name="lawyer_faq"] .acf-field').css('display','block');
			
		}
		
		
		
		
  
  
	});

	
	
	// gravity form

	$('.myedit.gravity_edit span.edit_icon').on('click', function(e) {
	
		formEdit();
		
		hideAcf();
		
		var showGform = $(this).parent('.myedit').data('gravityupdate');
				
		$('.update_custom_form .gform_wrapper').hide();
		
		$('#'+showGform+'').css('display','block');
		
  
	});


	// close

	$('.acf_close, .update_custom_form_left').on('click', function(e) {
	
		$('html, body').removeClass('fixed');
  
		$('.update_custom_form').removeClass('open');
  
		$('#internal_main').removeClass('blur');
  
	});


}


// acf submit button

$('#acf-form input[type="submit"]').on('click', function(e) {
  
  
  
});

// viewport for custom login screen

if($('.custom_login').length >0 ){

	var viewPortTag=document.createElement('meta');
	viewPortTag.id="viewport";
	viewPortTag.name = "viewport";
	viewPortTag.content = "width=device-width, minimum-scale=1.0, maximum-scale=1.0";
	document.getElementsByTagName('head')[0].appendChild(viewPortTag);

}


// additional nav 

 var loginnav = '<li><a href="'+my_mapdata.current_domain+'/login">Login</a></li>';
 var logoutnav = '<li><a href="'+my_mapdata.nav_logout+'">Logout</a></li>';
 var searchnav = '<li class="search_nav"><a>Search</a></li>';

 if(my_mapdata.logged_in == "loggedin") {
	 
	 $(logoutnav).appendTo('.nav_col_two ul');
 
 }
 
 if(my_mapdata.logged_in == "loggedout") {
	 
	  $(loginnav).appendTo('.nav_col_two ul');
 
 }
 
 
 $(searchnav).appendTo('.nav_col_two ul');
 

$('li.search_nav').on('click', function(e) {
	
		$('nav').fadeOut();
		
		$('.mobile_sticky_header').addClass('show');
		
		$('.mobile_search_overlay').fadeIn();
		
		$('.mobile_refine_wrapper').hide();
		
		$('.mobile_close_wrapper').addClass('from_nav');
		
		$('.mobile_close_wrapper').css("display", "flex").show();
	
	});
	
	
	
	// temp switch labels on gforms adjust conditionals on backend later
	
	
	
	
	$('label#label_2_42_1, label#label_4_42_1, label#label_11_42_1').text('Basic Profile $99/Year');
	
	$('label#label_2_42_2, label#label_4_42_2, label#label_11_42_2').text('Premium Profile $199/Year');
	

  
  
}); // document ready
