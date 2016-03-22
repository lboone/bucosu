jQuery(document).ready(function(){

    $(document).on('change','#bcs_events_school_district_1', function() {
      $("#bcs_events_school_1").load("../bcs_events_school/all_by_school_district_event_input_options/" + $("#bcs_events_school_district_1").val());
     var esd = $("#bcs_events_school_district_1 :selected").html();
     $("#event_content_district").html(esd);
    });

    $(document).on('change','#bcs_events_school_1', function(){
      var es = $("#bcs_events_school_1 :selected").html();
      $("#event_content_school").html(es);
      $("#event_content_school_2").html(es);
      $.ajax({
        type:"GET",
        url:"bcs/save_bcs_defaults/" + $("#bcs_events_school_district_1").val() + "/" + $("#bcs_events_school_1").val(),
        success: function(resp){
          location.reload(true);
        }
      });
    });

    $(document).one('click','#update_button_1', function(){
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

	$("#event_tree").fancytree({
	  extensions: ["filter"],
	  quicksearch: true,
	  source: {
	    url: "../bcs_headings/get_all_nodes_json/"
	  },
	  filter: {
        autoApply: true,
        autoExpand: true,
        mode: "hide",
        leavesOnly: false,
      },
	  checkbox: false,
	  cache: true,
	  generateIds: true,
	  click: function(event, data){
	  	var node = data.node;
	  	var cs = $("#bcs_events_school_1").val();
	  	if (node.isTopLevel() && (data.targetType == "title" || data.targetType == "icon")) {
	  		if (node.isExpanded()) {
	  			node.setExpanded(false);
	  		} else {
	  			node.setExpanded(true);
	  		}
	  	};

	  	process_node(node);
	  }
	});


	function process_node(node){
		if (node.getLevel() > 1) {

	  		if (get_form_status('form_status').val() == 'edited') {
  				
  				if (!confirm('You have unsaved changes in the current profile, hit cancel to stay and save them.'))
  				{
  					return false;
  				}
  			}

			var bcs_e_s_1 = $("#bcs_events_school_1").val();

      if(bcs_e_s_1 == null || bcs_e_s_1 == "Please select a School District Event..." )
      {
        alert("You must select a school district, and a school before you are able to perform an event, please do so now!");
        return false;
      }

			var results = new Array();
			$('#tab1_1').html('<img src="../../assets/img/loading.gif" class="center-block img-responsive mb20 mt20">Loading...');
			$('#bcs_event_question_content_container').html('<img src="../../assets/img/loading.gif" class="center-block img-responsive mb20 mt20">Loading...');
			$.when(
				$.get("../bcs_profiles_school/new_form/" + node.key + "/" + bcs_e_s_1, function(resp){
					results[0] = resp;
				}),
				$.get("../bcs_questions/profile/" + node.key + "/html", function(resp){
					results[1] = resp;
					results[2] = node.title;
				})		
			).then(function(){

				// Get the results for the empty profile form.
				var arr =  JSON.parse(results[0]);
				if (arr.status == 'success') 
				{
					$('#event_school_profile').html(arr.data);
				} else {
					$('#event_school_profile').html(arr.message);	
				}
				
				// Get the results for the empty question form.
				arr =  JSON.parse(results[1]);
				if (arr.status == 'success') 
				{
					$("#bcs_event_question_content").html(arr.data);

          if (arr.hasOwnProperty('rules')){
            get_validation_code(arr.rules);
          }
				} else {
					$("#bcs_event_question_content").html(arr.message);
				}
				
				// Hide the images tab
				hide_profile_images_tab()
				//$('#profile_images').hide("slow");

        // Display the question area
        $('#bcs_event_question_content').removeClass('hidden');

				// Place the profile title on the screen.
				$('#event_content_profile_title').html(results[2]);

        var nodeTitle =   results[2];
        var fnd = nodeTitle.indexOf(")")+1;
        var newTitle = nodeTitle.substr(fnd);

        $('#profiles_school_form_1 #name').val(newTitle.trim());		
			});
      $('html, body').animate({scrollTop: '0px'}, 300);
	  	}

	}
	// Get a handle on the Event Tree object for later use.
 	var tree = $("#event_tree").fancytree("getTree");

  
    /*
     * Used for filtering the event tree list by typing.
     */

    $("input[name=search]").keyup(function(e){
      var n;
      var match = $(this).val();

      if(e && e.which === $.ui.keyCode.ESCAPE || $.trim(match) === ""){
        $("button#btnResetSearch").click();
        return;
      }
      $('.ui-fancytree li').removeClass('eventTreeForceHideElement');
      // Pass a string to perform case insensitive matching
      n = tree.filterNodes(match);
      tree.visit(function(node){node.setExpanded(true);});

      $("button#btnResetSearch").attr("disabled", false);
      $("span#matches").text("(" + n + " matches)");

      $(".fancytree-hide").parent().closest('li').addClass('eventTreeForceHideElement');
    }).focus();

    $("button#btnResetSearch").click(function(e){
      $("input[name=search]").val("");
      $("span#matches").text("");
      $('.ui-fancytree li').removeClass('eventTreeForceHideElement');
      tree.visit(function(node){node.setExpanded(false);});
      tree.clearFilter();
    }).attr("disabled", true);


 	// Get a handle on the form status object.
    function get_form_status(fs)
    {
      var sel = "input:hidden[name=" + fs + "]";
      var form_status = $(sel);
      return form_status;
    }


	/*
	 * Gives us a way to update the bar at the top of the content
	 * This loads when the event tree is built, because we only have to build it when the settings are updated.
	 */
	 var esd = $('#bcs_events_school_district_1 :selected').html();
	 $('#event_content_district').html(esd);
	 var es = $('#bcs_events_school_1 :selected').html();
	 $('#event_content_school').html(es);
   $('#event_content_school_2').html(es);


	 /*
	  * functions used for toggling the profile image tabs
	  *
	  */

	function hide_profile_images_tab(){
		$('#profile_images').hide("slow");
	}
	function show_profile_images_tab(){
		$('#profile_images').fadeIn(700);
	}


  get_validation_code = function (p)
  {
    var js = '<script>\n';
    js += 'jQuery(document).ready(function(){\n';
    js += '$("#bcs_questions_form_1").validate({\n';
    js += 'errorClass: "state-error",\n';
    js += 'validClass: "state-success",\n';
    js += 'errorElement: "em",\n';
    js += 'rules: {\n';
    //p = arr.rules;
    for (var key in p) {
      if (p.hasOwnProperty(key)) {
        js += p[key] + ',\n';
      }
    }
    js += '},\n';
    js += 'highlight: function(element, errorClass, validClass) { $(element).closest(".field").addClass(errorClass).removeClass(validClass);},\n';
    js += 'unhighlight: function(element, errorClass, validClass) { $(element).closest(".field").removeClass(errorClass).addClass(validClass); },\n';
    js += 'errorPlacement: function(error, element) { if (element.is(":radio") || element.is(":checkbox")) { element.closest(".option-group").after(error); } else { error.insertAfter(element.parent()); } }\n';
    js += '});\n';
    js += '});\n';
    js += '</script>';
    $("#dynamic_javascript_validation_content").html(js);
  }


/*
 * ################# BEGIN NEW PROFILES SCHOOL JS
 */


    $(document).on('click','a.saved_profile_edit_button',function(e){
    	e.preventDefault();

    	if (get_form_status('form_status').val() == 'edited') {
	    	if (!confirm('You have unsaved changes in the current profile, hit cancel to stay and save them.'))
  			{
  				return false;
  			}
		  }

      var status = $("input:hidden[name='form_status']").val();
      
      if (status !== 'new')
      {
        var edit = 'edit_';
        var id = $("input:hidden[name='id']").val();
        edit = edit.concat(id);
        var id2 = $(this).attr('id');
        if (edit == id2) 
        {
          $('li#profile_new a').trigger('click');
          return false;
        };
      };


      var url = $(this)[0].search.substring(1);

      var id = getUrlParameter(url, 'id');

		var results = new Array();
      
  		$.when(
  			$.get("../bcs_profiles_school/edit_form/" + id, function(resp){
  				results[0] = resp;
  			}),
        $.get("../bcs_questions_school/edit_form/" + id, function(resp){
          results[1] = resp;
        })		
  		).then(function(){

  			// Get the results for the empty profile form.
  			var arr =  JSON.parse(results[0]);
  			if (arr.status == 'success') 
  			{
  				$('#event_school_profile').html(arr.data);
          $('#new_profile_school_new_button').show();
  			} else {
  				$('#event_school_profile').html(arr.message);	
  			}

        arr =  JSON.parse(results[1]);
        if (arr.status == 'success') 
        {
          $('#bcs_event_question_content').html(arr.data);
          $('#read_only_message').hide();
          inputs_enabled();
          $('#bcs_questions_form_1 input:hidden[name=profile_school_id]').val(id);

          if (arr.hasOwnProperty('rules')){
            get_validation_code(arr.rules);
          }

        } else {
          $('#bcs_event_question_content').html(arr.message); 
        }

  		});
      $('#bcs_event_question_content').removeClass('hidden');
      $('html, body').animate({scrollTop: '0px'}, 300);   
    });

    $(document).on('click','a.saved_profile_delete_button',function(e){
      	e.preventDefault();
  		if (!confirm('Are you sure you want to delete that profile?'))
  		{
  			return false;
  		}

      var status = $("input:hidden[name='form_status']").val();
      
      if (status !== 'new')
      {
        var del = 'delete_';
        var id = $("input:hidden[name='id']").val();
        del = del.concat(id);
        var id2 = $(this).attr('id');
        if (del == id2) 
        {
          alert('You have to close the profile before you delete it.');
          return false;
        };
      };

  	    var url = $(this)[0].search.substring(1);
      	var id = getUrlParameter(url, 'id');


  		var results = new Array();
      
  		$.when(
  			$.get("../bcs_profiles_school/delete_form/" + id, function(resp){
  				results[0] = resp;
  			})		
  		).then(function(){

  			// Get the results for the empty profile form.
  			var arr =  JSON.parse(results[0]);
  			if (arr.status == 'success') 
  			{
  			
  			    
        			var tree = $("#event_tree").fancytree("getTree");
        			var node = tree.getActiveNode();
       			process_node(node);

  			//	$('#event_school_profile').html(arr.data);
  			//	hide_profile_images_tab();
  			} else {
  				$('#event_school_profile').html(arr.message);	
  			}

  		});
       
    });

    $(document).on('click','a.saved_profile_image_delete_button',function(e){
    	e.preventDefault();
		if (!confirm('Are you sure you want to delete that image?'))
		{
			return false;
		}
        var url = $(this)[0].search.substring(1);
        var id = getUrlParameter(url, 'id');
    	delete_an_image(id);
    });



    function delete_an_image(id){
		$.ajax({
          method:"GET",
          url:"../bcs_profiles_school_images/delete_image/" + id,
          success: function(resp){
            var arr = JSON.parse(resp);
            if (arr.hasOwnProperty('error')){
            	alert(arr.error);
            } else {
              $('#image_results').html(arr.success);  
              get_all_image_data();
            }
          },
        });
    
    }


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



    $(document).on('click','a#profile_school_get_all_new_profile',function(e){
      e.preventDefault();
      var tree = $("#event_tree").fancytree("getTree");
      var node = tree.getActiveNode();
      process_node(node);
    });

    $(document).on('click','#new_profile_school_new_button', function(e){
      e.preventDefault();
      var tree = $("#event_tree").fancytree("getTree");
      var node = tree.getActiveNode();
      process_node(node);
    });



  /*
   * Events for the profiles school form
   */

    window.onbeforeunload = confirmExit;
    function confirmExit() {
        if (get_form_status('form_status').val() == 'edited') {
            return "Unsaved Changes. Do you still wish to navigate away from the page?";
        }
    }


/* @custom validation method (smartCaptcha) 
    ------------------------------------------------------------------ */
    function return_validator(){
    var validator = $("#profiles_school_form_1").validate({

      /* @validation states + elements 
      ------------------------------------------- */

      errorClass: "state-error",
      validClass: "state-success",
      errorElement: "em",

      /* @validation rules 
      ------------------------------------------ */

      rules: {
        name: {
          required: true
        },
        location: {
          required: true
        },
        event_school_id: {
          required: true
        },
        profile_id: {
          required: true
        },
        facilities_alert_description: {
          required: "#facilities_alert:checked"
        },
      },

      /* @validation error messages 
      ---------------------------------------------- */

      messages: {
        name: {
          required: 'A unique Profile Name is required.'
        },
        location: {
          required: 'A Profile Location is required!'
        },
        event_school_id: {
          required: 'You must select a school district in the defaults tab!'
        },
        profile_id: {
          required: 'You must select a school in the default tab!'
        },
        facilities_alert_description: {
          required: 'You must profice description for facilities alert, if you select "Yes"'
        },
      },

      /* @validation highlighting + error placement  
      ---------------------------------------------------- */

      highlight: function(element, errorClass, validClass) {
        $(element).closest('.field').addClass(errorClass).removeClass(validClass);
      },
      unhighlight: function(element, errorClass, validClass) {
        $(element).closest('.field').removeClass(errorClass).addClass(validClass);
      },
      errorPlacement: function(error, element) {
        if (element.is(":radio") || element.is(":checkbox")) {
          element.closest('.option-group').after(error);
        } else {
          error.insertAfter(element.parent());
        }
      }

    });

	return validator;
}

    return_validator2 = function (){
    var validator = $("#bcs_questions_form_1").validate({

      /* @validation states + elements 
      ------------------------------------------- */

      errorClass: "state-error",
      validClass: "state-success",
      errorElement: "em",

      /* @validation highlighting + error placement  
      ---------------------------------------------------- */

      highlight: function(element, errorClass, validClass) {
        $(element).closest('.field').addClass(errorClass).removeClass(validClass);
      },
      unhighlight: function(element, errorClass, validClass) {
        $(element).closest('.field').removeClass(errorClass).addClass(validClass);
      },
      errorPlacement: function(error, element) {
        if (element.is(":radio") || element.is(":checkbox")) {
          element.closest('.option-group').after(error);
        } else {
          error.insertAfter(element.parent());
        }
      }

    });

  return validator;
}
// Main profile school form button operations / save from new, save from edited.
   $(document).on("submit","#profiles_school_form_1",function (e) {
      e.preventDefault();
      var form_status = get_form_status('form_status');
      var fs = form_status.val();
	  var validator = return_validator();
      switch (fs) {	
        case 'new':

          if (validator.form()) {
            $.ajax({
                method:"POST",
                data:$('#profiles_school_form_1').serialize(),
                url:"../bcs_profiles_school/save_form",
                success: function(resp){
                  var arr = JSON.parse(resp);
                  if (arr.status== 'success'){
                    $('#event_school_profile').html(arr.data);
                    // $("#profiles_school_form_1").append('<input type="hidden" name="id" value="' + arr.id + '" style="display:none;"/>');  
                    $('<div class="alert alert-success alert-dismissable animated fadeInDown"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="fa fa-check pr10"></i><strong>You new profile has been saved!</strong></div>').prependTo('#tab1_1').delay(3000).fadeOut('slow','linear',function(){$(this).remove()});
                    inputs_enabled();
                    //form_status.val('saved');
                    $('#profile_images').fadeIn(700);
                    $('#tab1_3 #image_results').html('Please "Attach" an image...');
                    $('#new_profile_school_new_button').show();
                    var id = arr.id;
                    $('#bcs_questions_form_1 input:hidden[name=profile_school_id]').val(id);
                  } else {
                    $('<div class="alert alert-danger alert-dismissable animated fadeInDown"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="fa fa-frown-o pr10"></i><strong>You profile has not been saved! ' + arr.message + '</strong></div>').prependTo('#tab1_1').delay(3000).fadeOut('slow','linear',function(){$(this).remove()});                    
                  }
                },
             });
            
          }

          break;

        case 'edited':

          if (validator.form()) {
            
            $.ajax({
                method:"POST",
                data:$('#profiles_school_form_1').serialize(),
                url:"../bcs_profiles_school/save_form",
                success: function(resp){
                  var arr = JSON.parse(resp);
                  if (arr.status == 'success'){
                    $('#event_school_profile').html(arr.data);
                    $('<div class="alert alert-success alert-dismissable animated fadeInDown"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="fa fa-check pr10"></i><strong>Your profile has been saved!</strong></div>').prependTo('#tab1_1').delay(3000).fadeOut('slow','linear',function(){$(this).remove()});
                  } else {
                    $('<div class="alert alert-danger alert-dismissable animated fadeInDown"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="fa fa-frown-o pr10"></i><strong>You profile has not been saved! ' + arr.message + '</strong></div>').prependTo('#tab1_1').delay(3000).fadeOut('slow','linear',function(){$(this).remove()});                    
                  }
                  $('#new_profile_school_new_button').show();
                },
             });
            
          }
           break;

        default:
          /* do nothing! */
          break;

      }; 

      $('html, body').animate({scrollTop: '0px'}, 300);
      return false;     

   });



// Main profile school form button operations / save from new, save from edited.
   $(document).on("submit","#bcs_questions_form_1",function (e) {
      e.preventDefault();
      var form_status = get_form_status('form_status_2');
      var fs = form_status.val();

      // var validator = return_validator();
      switch (fs) { 
        case 'new':

      //  if (validator.form()) {
            
            $.ajax({
                method:"POST",
                data:$('#bcs_questions_form_1').serialize(),
                url:"../bcs_questions_school/save",
                success: function(resp){
                  var arr = JSON.parse(resp);
                  if (arr.status == 'success'){
                    var form_stat = get_form_status('form_status_2');
                    form_stat.val('saved');
                    $('<div class="alert alert-success alert-dismissable animated fadeInDown"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="fa fa-check pr10"></i><strong>Your quesitons have been saved!</strong></div>').prependTo('#bcs_event_question_content_container').delay(3000).fadeOut('slow','linear',function(){$(this).remove()});
                  } else {
                    $('<div class="alert alert-danger alert-dismissable animated fadeInDown"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="fa fa-frown-o pr10"></i><strong>Your questions have not been saved! ' + arr.message + '</strong></div>').prependTo('#bcs_event_question_content_container').delay(3000).fadeOut('slow','linear',function(){$(this).remove()});                    
                  }
                },
             });
            
      //  }

          break;

        case 'saved':

      //  if (validator.form()) {
            
            $.ajax({
                method:"POST",
                data:$('#bcs_questions_form_1').serialize(),
                url:"../bcs_questions_school/edit",
                success: function(resp){
                  var arr = JSON.parse(resp);
                  if (arr.status == 'success'){
                    var form_stat = get_form_status('form_status_2');
                    form_stat.val('saved');
                    $('<div class="alert alert-success alert-dismissable animated fadeInDown"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="fa fa-check pr10"></i><strong>Your questions have been saved!</strong></div>').prependTo('#bcs_event_question_content_container').delay(3000).fadeOut('slow','linear',function(){$(this).remove()});
                  } else {
                    $('<div class="alert alert-danger alert-dismissable animated fadeInDown"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="fa fa-frown-o pr10"></i><strong>Your questions have not been saved! ' + arr.message + '</strong></div>').prependTo('#bcs_event_question_content_container').delay(3000).fadeOut('slow','linear',function(){$(this).remove()});                    
                  }
                  $('#new_profile_school_new_button').show();
                },
             });
            
      //  }
           break;

        default:
          /* do nothing! */
          break;

      }; 
      $('html, body').animate({scrollTop: $('#bcs_event_question_content').offset().top - 50 }, 300);
      
      return false;     

   });

  
    $(document).on('click','li#profile_new a', function(){
      $('#bcs_event_question_content').removeClass('hidden');
    });

   $(document).on('click','li#profile_saved a', function(e){
      if (get_data_state($('#tab1_2')) == 'update')
      {
      	get_all_profile_data();
      }
      $('#bcs_event_question_content').addClass('hidden');
      $('.saved_profile_edit_button').prop("disabled",false);
      $('.saved_profile_delete_button').prop("disabled",false);      

   });

   function get_all_profile_data()
   {        
        $.ajax({
                 method:"POST",
                 data:$('#profiles_school_form_1').serialize(),
                 url:"../bcs_profiles_school/get_all",
                 success: function(resp){
                    var arr = JSON.parse(resp);
                    if (arr.status == 'success'){
                      $('#bcs_profiles_school_saved').html(arr.data);
                      //$('footer').html(arr.foot);
                      $('#tab1_2').data('state','read');
                    } else {
                      $('#bcs_profiles_school_saved').html(arr.message);  
                    }
                  },
         });
         
   }

    $(document).on('click','li#profile_images a', function(e){
       setup_images();
      if (get_data_state($('#tab1_3')) == 'update')
      {
       get_all_image_data();
      }
      $('#bcs_event_question_content').addClass('hidden');
    });


    function get_all_image_data(){
      
    	 $.ajax({
          method:"POST",
          data:$('#profiles_school_form_1').serialize(),
          url:"../bcs_profiles_school_images/get_profile_school_images",
          success: function(resp){
            var arr = JSON.parse(resp);
            if (arr.hasOwnProperty('error')){
              $('#image_results').html(arr.error);  
            } else {
              $('#image_results').html(arr.success);  
            }
          },
        });
    }

   function setup_images(){
      $("#file_input").fileinput({
        uploadUrl:'../bcs_profiles_school_images/save_image',
        dropZoneEnabled: false,
        allowedFileTypes:['image','text','video','object','audio'],
        allowedFileExtensions:['jpg','gif','png','txt','doc','pdf','mp4','mov'],
        uploadAsync:true,        
        maxFileSize:3000,
        browseClass: "btn btn-system",
        browseLabel: "Attach",
        browseIcon: "<i class=\"mr10 fa fa-paperclip\"></i>",
        removeClass: "btn btn-danger mr5",
        removeLabel: "Undo",
        removeIcon: "<i class=\"fa fa-undo\"></i> ",
        uploadClass: "btn btn-info mr5",
        uploadLabel: "Upload",
        uploadIcon: "<i class=\"fa fa-upload\"></i> ",
        uploadExtraData: function() {
            return {
                profile_school_id:$('#profiles_school_form_1 input:hidden[name=id]').val(),
                file_input_text:$('#file_input_text').val()
            };
        }
      });
   }
  

  $(document).on('fileuploaded','#file_input', function(event, data, previewId, index) {
        var form = data.form, files = data.files, extra = data.extra,
            response = data.response, reader = data.reader;
            $("#image_results").html(response.success);
            $("#file_input_text").val('');
            $(this).fileinput('clear');
    });


   $(document).on('change',"#profiles_school_form_1",function(){
      evaluate_form_status('form_status');
   });


    function inputs_enabled(){
      $("#bcs_questions_form_1 :input:not(:button)").prop("disabled",false);
      $(".checkbox-disabled").removeClass('checkbox-disabled');
      $(".radio-disabled").removeClass('radio-disabled');
      $("#new_questions_school_save_button").prop("disabled",false);
      $("#read_only_message").remove();

    }

    function evaluate_form_status(fs)
    {
      
      var form_status = get_form_status(fs);
      switch (form_status.val()) {

        case 'saved':
   
          form_status.val('edited');
          break;

        default:
        /*do nothing*/
        break;
      
      }
    }

    function get_form_status(fs)
    {
      var sel = "input:hidden[name=" + fs + "]";
      var form_status = $(sel);
      return form_status;
    }


    function get_data_state(jObj)
    {
      return $(jObj).data().state;
    }

    $.magnificPopup.open({
        removalDelay: 500, //delay removal by X to allow out-animation,
        items: {
          src: '#modal-panel'
        },
        closeOnContentClick: true,
        closeOnBgClick: true,
        enableEscapeKey: true,
        // overflowY: 'hidden', // 
        callbacks: {
          beforeOpen: function(e) {
            var Animation = 'mfp-flipInY';
            this.st.mainClass = Animation;
          }
        },
        midClick: true // allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source.
      });

    $('#sd_s_reminder_panel_button').on('click',function(){

    });


    lightbox.option({
      'alwaysShowNavOnTouchDevices': true,
      'wrapAround': true
    });

    $(function() {
      $("img.lazyload").lazyload({
        event: "scrollstop"
      });
    });

    $('#event_school_profile').editable({
        selector: 'td.x-editable-cell a',
        url: 'http://bucosu.com/bcs_profiles_school_images/update_image_title',
        success: function(response, newValue) {
          if(!response.success) return response.msg;
        },
        validate: function(value) {
          if($.trim(value) == '') {
            return 'This field is required';
          }
        }
    });

    $(document).on('click','#image_rotate_left',function(e){
      e.preventDefault();
      process_image_rotate_data(get_image_rotate_data($(this),90,'rotate the image left?'));
    });

    $(document).on('click','#image_rotate_flip',function(e){
      e.preventDefault();
      process_image_rotate_data(get_image_rotate_data($(this),-180,'flip the image?'));
    });

    $(document).on('click','#image_rotate_right',function(e){
      e.preventDefault();
      process_image_rotate_data(get_image_rotate_data($(this),270,'rotate the image right?'));
    });

    function get_image_rotate_data(button,deg,adjust_message){
      var data = {
                  id:       button.data('image-id'),
                  psid:     button.data('image-psid'),
                  filename: button.data('image-filename'),
                  degrees:  deg,
                  message:  adjust_message,
                 };
      return data;
    }

    function process_image_rotate_data(data){
      if (window.confirm("Are you sure you want to ".concat(data.message)))
      {
        var url_beg = "http://bucosu.com/bcs_profiles_school_images/rotate_image/";
        var url = url_beg.concat(data.id,"/",data.psid,"/",data.filename,"/",data.degrees);
        var results = new Array();
      $.when(
        $.get(url, function(resp){
          results[0] = resp;
        })    
      ).then(function(){
        // Get the results.
        var arr =  JSON.parse(results[0]);
        if (arr.success ) 
        {
          $('li#profile_images a').trigger('click');
        } else {
          alert(arr.msg);
        }
      });

      };
    }

    function cleaner(key, value)
    {
      return value;
    }


    $(document).on('click','#go_to_top',function(e){
      e.preventDefault();
      $('html, body').animate({scrollTop: '0px'}, 300);
    });

});