jQuery(document).ready(function(){

    $('#bcs_event_back_button').removeClass('hidden');
    $('#bcs_event_print_button').removeClass('hidden');
    $('#bcs_event_print_page_button').removeClass('hidden');
    $('#event_centent_heading').hide().parent().hide();
    $('#event_content_profile_title').hide().parent().hide();
    $('#topbar').hide();

    $(document).on('click','#bcs_event_back_button', function(){
        window.location.href = "http://bucosu.com/dashboard";
    });

    $(document).on('click','#bcs_event_print_button', function(){
        window.location.href = window.location.href + "/print/images";
    });

    $(document).on('click','#bcs_event_print_page_button', function(){
        window.print();
    });

    $(document).on('click','#print_to_pdf_button', function(){
      $.ajax({
        type:"GET",
        url:"bcs/save_bcs_defaults/" + $("#bcs_events_school_district_1").val() + "/" + $("#bcs_events_school_1").val(),
        success: function(resp){
          $("<div class=\"alert alert-success alert-dismissable animated fadeInDown\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button><i class=\"fa fa-check pr10\"></i><strong>Your default settings have been updated!</strong></div>").insertBefore("#default_event_selection_form-group_1").delay(3000).fadeOut("slow","linear",function(){$(this).remove();});
          window.location.href = "http://bucosu.com/bcs/events";
        }
      });
    });

  $('.dd').nestable('collapseAll');

  $('#nestable-menu').on('click', function(e){
        var target = $(e.target),
            action = target.data('action');
        if (action === 'expand-all') {
            $('.dd').nestable('expandAll');
        }
        if (action === 'collapse-all') {
            $('.dd').nestable('collapseAll');
        }
    });

  $( ".dd-nodrag" ).on('mousedown',function(){return false;});
  $( ".dd-nodrag" ).on('touchmove',function(){return false;});




	/*
	 * Gives us a way to update the bar at the top of the content
	 * This loads when the event tree is built, because we only have to build it when the settings are updated.
	 */
	 var esd = $('#bcs_events_school_district_1 :selected').html();
	 $('#event_content_district').html(esd);
	 var es = $('#bcs_events_school_1 :selected').html();
	 $('#event_content_school').html(es);
   $('#event_content_school_2').html(es);





	var getUrlParameter = function getUrlParameter(sPageURLz, sParam) {
   		var sPageURL = decodeURIComponent(sPageURLz),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

	    for (i = 0; i < sURLVariables.length; i++) {
	        sParameterName = sURLVariables[i].split('=');

	        if (sParameterName[0] === sParam) {
	            return sParameterName[1] === undefined ? true : sParameterName[1];
	        }
	    }
	}

    lightbox.option({
      'alwaysShowNavOnTouchDevices': true,
      'wrapAround': true
    });

    $(function() {
      $("img.lazyload").lazyload({
        event: "scrollstop"
      });
    });
    
    $(document).on('click','#go_to_top',function(e){
      e.preventDefault();
      $('html, body').animate({scrollTop: '0px'}, 300);
    });



// See if this is a touch device
      if ('ontouchstart' in window)
      {
        // Set the correct body class
        $('tr').removeClass('no-touch').addClass('touch');
        
        // Add the touch toggle to show text
        $('div.boxInner img').click(function(){
          $(this).closest('.boxInner').toggleClass('touchFocus');
        });
      }

});