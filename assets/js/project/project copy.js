jQuery(document).ready(function(){

/* ------ START OFF BY CLEARING & RESETTING ALL VALUES ------*/
reset_default_fields_and_values();

/* ------ SCHOOL DISTRICT & SCHOOL CODE ------*/

  /* ------ AJAX CALL THAT RETRIEVES ALL THE USER DISTRICT & SCHOOL INFO ------*/
  $.ajax({
    beforeSend: function(){
      openLoadingPopup();
    },
    complete: function(){
      closeLoadingPopup();
    },
    type:"GET",
    url:"project_defaults_json",
    success: function(resp){
      var arr = JSON.parse(resp);
      if (arr.success)
      {
        school_districts = arr.msg;

        if (empty(arr.defaults['sd']))
        {
          set_sd_data();
        } else {
          if (empty(arr.defaults['s']))
          {
            set_sd_data(arr.defaults['sd']);
          } else {
            set_sd_data(arr.defaults['sd'],arr.defaults['s']);
          }
        }

        build_sd_field();
        build_s_field();
        log_the_data();


          $.ajax({
          type:"GET",
          url:"project_heading_defaults_json",
          success: function(resp){
            var arr = JSON.parse(resp);
            if (arr.success)
            {
              headings = arr.msg;


              if (empty(arr.defaults['h']))
              {
                set_h_data();
              } else {
                if (empty(arr.defaults['p']))
                {
                  set_h_data(arr.defaults['h']);
                } else {
                  set_h_data(arr.defaults['h'],arr.defaults['p']);
                }
              }
              log_the_data2();
            } 
          }
        });

      } else {
        alert(arr.msg);
        window.location = '/';
      } 
    }
  });

  /* ------ VARIABLES FOR SCHOOL DISTRICT & SCHOOL EVENT ------*/
  var school_districts = {};
  var sd_keys = {};
  var chosen_sd;
  var chosen_sd_event;
  var schools = {};
  var s_keys = {};
  var chosen_s;
  var data_array = {};

  /* ------  SCHOOL DISTRICT FIELD & DATA ------*/
  $(document).on('change','#school_district_select', function(){
    var val = $(this).val();
    var txt = $(this).find('option:selected').html();
    var results = {};
    openLoadingPopup();
    $.when(
      $.get("../../user_settings/update_setting/?setting=project_school_district&value="+val, function(resp){
        results[0] = resp;
      }),
      $.get("../../user_settings/update_setting/?setting=project_school_district_name&value="+txt, function(resp){
        results[1] = resp;
      })    
    ).then(function(){
        set_sd_data(val);
        build_s_field();
        closeLoadingPopup();
        $('#school_select').trigger('change');
        log_the_data();
    });
  });
  function set_sd_data(sd_id,s_id){
    var x = 0;
    $.each(school_districts, function (key, value){
            sd_keys[x] = key;
            x++;
          });
    
    if (empty(sd_id))
    {
      sd_id = sd_keys[0];
    }

    chosen_sd = school_districts[sd_id];

    chosen_sd_event = chosen_sd['sd_event'];

    if (empty(s_id))
    {
      set_s_data();  
    } else {
      set_s_data(s_id);
    }
  }
  function build_sd_field(){
      var $el = $('#school_district_select');
      $el.empty();

      $.each(school_districts, function (key, value){
        var ev = value['sd_event'];
        var ev_n = ev['event_name'];
        var ev_id = ev['id'];
        var cur_ev_id = chosen_sd_event['id'];
        if (cur_ev_id === ev_id)
        {
          $el.append($("<option selected></option>").attr("value",ev_id).text(ev_n));
        } else {
          $el.append($("<option></option>").attr("value",ev['id']).text(ev['event_name']));
        }
        
      });
  }

  /* ------  SCHOOL FIELD & DATA ------*/
  $(document).on('change','#school_select',function(){
    var val = $(this).val();
    var txt = $(this).find('option:selected').html();
    var results = {};
    openLoadingPopup();
    $.when(
      $.get("../../user_settings/update_setting/?setting=project_school&value="+val, function(resp){
        results[0] = resp;
      }),
      $.get("../../user_settings/update_setting/?setting=project_school_name&value="+txt, function(resp){
        results[1] = resp;
      })    
    ).then(function(){
      set_s_data(val);
      closeLoadingPopup();
      $('#project_direction_bcs_non').val('non_bcs_project').trigger('change');
      log_the_data();
    });
  });
  function set_s_data(s_id){
    // Reset the values so we can start fresh.
    schools = {};

    var csd = chosen_sd['s_events'];
    $.each(csd, function (key, value){
      schools[value['id']]= value;
    });
    
    x = 0;
    $.each(schools, function (key, value){
      s_keys[x] = key;
      x++;
    });

    if (empty(s_id))
    {
      s_id = s_keys[0];
    }
  
    //console.log(s_id);

    chosen_s = schools[s_id];
  }
  function build_s_field(){
    var $el = $('#school_select');
    $el.empty();

    $.each(schools, function (key, value){
      var s_n = value['school_name'];
      var s_id = value['school_id'];
      var cur_s_id = chosen_s['id'];
      if (cur_s_id === s_id)
      {
        $el.append($("<option selected></option>").attr("value",s_id).text(s_n));
      } else {
        $el.append($("<option></option>").attr("value",s_id).text(s_n));
      }

    });
  }


/* ------ NEW PROJECT TAB ------*/

  /* ------ BCS project direction bcs non field ------*/
  $(document).on('change','#project_direction_bcs_non',function(){
    // Just in case we are not starging over with a fresh page, we will clear the fields!=
    clear_all_fields();

    // 1. Get the value
    var val = $(this).val();

    if (val == 'bcs_project')
    {
      // a:
      $('#project_direction_who_for').val('school_project');
      build_h_field();
      build_p_field();
      $('#project_details_profile').trigger('change');
      //c:
      $('#bcs_info_container').removeClass('hidden').animate({
        opacity: 1,
        height: '100%',
      },1000);
      $('#new_project_btn-generate_project').text("Generate BCS Project");
      $('#save_default_project_details_profile').addClass('hidden').prev().addClass('col-xs-12').removeClass('col-xs-10 col-sm-11 col-md-10 col-lg-10 col-xl-11');
      log_the_data2();
    } else {
      reset_default_fields_and_values();
    }      
  });
  /* ------- BCS project direction who for field ------*/
  $(document).on('change','#project_direction_who_for',function(){
    // 1. Get the value
    var val = $(this).val();
    var val2 = $('#project_direction_bcs_non').val();

    // 2. Check BCS Project Field
    //    a. check to see if BCS Project is set to "BCS Project", if it is, don't allow District Project.
    if (val2 == 'bcs_project')
    {
      if (val == 'district_project') {alert('You can only have a School Project for a BCS Project.  If you want a District Project, please change to a Non BCS Project!')};
      $(this).val('school_project');
    }
  });

  /* ------ VARIABLES FOR HEADINGS & PROFILES ------*/
  var headings = {};
  var chosen_h;
  var chosen_heading;
  var profiles = {};
  var z_keys = {};
  var chosen_p;
  var data_array2 = {};
  var heading_dirty = false;
  var profile_dirty = false;

  /* ------ BCS HEADINGS FIELD & DATA ------*/
  $(document).on('change','#project_details_heading', function(){
    heading_dirty = true;
    var val = $(this).val();
    set_h_data(val,'');
    build_p_field();
    $('#save_default_project_details_heading').removeClass('hidden').prev().removeClass('col-xs-12').addClass('col-xs-10 col-sm-11 col-md-10 col-lg-10 col-xl-11');
    $('#project_details_profile').trigger('change');
    log_the_data2();
  });
  /* ------ PROJECT DETAILS HEADING SAVE SETTINGS BUTTON ------*/
  $(document).on('click','#save_default_project_details_heading button', function(e){
    e.preventDefault;
    heading_dirty = false;
     var val = $('#project_details_heading').val();
     var txt = $('#project_details_heading').find('option:selected').html();
     var results = {};
     openLoadingPopup();
     $.when(
       $.get("../../user_settings/update_setting/?setting=project_bcs_heading&value="+val, function(resp){
         results[0] = resp;
       }),
       $.get("../../user_settings/update_setting/?setting=project_bcs_heading_name&value="+txt, function(resp){
         results[1] = resp;
       })    
     ).then(function(){
         closeLoadingPopup();
         $('#save_default_project_details_heading').addClass('hidden').prev().removeClass('col-xs-10 col-sm-11 col-md-10 col-lg-10 col-xl-11').addClass('col-xs-12');
         if (profile_dirty)
         {
          $('#save_default_project_details_profile button').trigger('click');
        } 
     });
  })
  function set_h_data(h_id,z_id){

    chosen_h = headings[h_id];

    chosen_heading = chosen_h['heading'];

    if (empty(z_id))
    {
      set_p_data();  
    } else {
      console.log('h_id: ' + h_id);
      console.log('z_id: ' + z_id);
      set_p_data(z_id);
    }
  }
  function build_h_field(){
      var $el = $('#project_details_heading');
      $el.empty();

      $.each(headings, function (key, value){
        var ev = value['heading'];
        var ev_n = ev['name'];
        var ev_id = ev['id'];
        var cur_ev_id = chosen_heading['id'];
        if (cur_ev_id == ev_id)
        {
          $el.append($("<option selected></option>").attr("value",ev_id).text(ev_n));
        } else {
          $el.append($("<option></option>").attr("value",ev_id).text(ev_n));
        }
        
      });
  }

  /* ------ BCS PROFILE FIELD & DATA ------*/
  $(document).on('change','#project_details_profile',function(){
    var val = $(this).val();
    profile_dirty = true;
    set_p_data(val);
    $('#save_default_project_details_profile').removeClass('hidden').prev().removeClass('col-xs-12').addClass('col-xs-10 col-sm-11 col-md-10 col-lg-10 col-xl-11');;
    $('#bcs_info_profile_school_list').addClass('hidden').css('height','25%').css('opacity','.25');
  });
  /* ------ PROJECT DETAILS PROFILE SAVE SETTINGS BUTTON ------*/
  $(document).on('click','#save_default_project_details_profile button', function(e){
    e.preventDefault;
    var val = $('#project_details_profile').val();
    var txt = $('#project_details_profile').find('option:selected').html();
    console.log('Profile New Val: ' + val);
    var results = {};
    openLoadingPopup();
    $.when(  
      $.get("../../user_settings/update_setting/?setting=project_bcs_profile&value="+val, function(resp){
        results[0] = resp;
      }),
      $.get("../../user_settings/update_setting/?setting=project_bcs_profile_name&value="+txt, function(resp){
        results[1] = resp;
      })    
    ).then(function(){
      $('#save_default_project_details_profile').addClass('hidden').prev().removeClass('col-xs-10 col-sm-11 col-md-10 col-lg-10 col-xl-11').addClass('col-xs-12');;
      closeLoadingPopup();
      profile_dirty = false;
      if (heading_dirty)
      {
        $('#save_default_project_details_heading button').trigger('click');
      };

    });
  })  
  function set_p_data(z_id){
    // Reset the values so we can start fresh.
    profiles = {};

    var cps = chosen_h['profiles'];
    $.each(cps, function (key, value){
      profiles[value['key']]= value;
    });

    x = 0;
    $.each(profiles, function (key, value){
      z_keys[x] = key;
      x++;
    });
    
    console.log('z_id On Pass: ' + z_id);
    
    if (empty(z_id))
    {
      z_id = z_keys[0];
    }

    console.log('z_id: ' + z_id);

    chosen_p = profiles[z_id];
    log_the_data2();
  }
  function build_p_field(){
    var $el = $('#project_details_profile');
    $el.empty();

    $.each(profiles, function (key, value){
      var s_n = value['title'];
      var s_id = value['key'];
      var cur_s_id = chosen_p['key'];
      console.log('s_id: ' + s_id + ' & cur_s_id: ' + cur_s_id);
      if (cur_s_id === s_id)
      {
        $el.append($("<option selected></option>").attr("value",s_id).text(s_n));
      } else {
        $el.append($("<option></option>").attr("value",s_id).text(s_n));
      }

    });
  }

  /* ------ MAIN FORM SEARCH BUTTON ------*/
  $(document).on('click','#search_for_school_profiles',function(e){
    e.preventDefault;

    var pdbn  = $('#project_direction_bcs_non');
    var pdwf  = $('#project_direction_who_for');
    var pfc   = $('#project_filter_condition');
    var pfrul = $('#project_filter_remaining_useful_life');

    $.ajax({
      beforeSend: function(){
        openLoadingPopup();
      },
      complete: function(){
        closeLoadingPopup();
      },        
      type:"GET",
      url:"../../bcs_profiles_school/get_all_data_json?p_id="+ chosen_p['key'] +"&e_id=" + chosen_s['id'],
      success: function(resp){
        var arr = JSON.parse(resp);
        if (arr.success)
        { 
          $('#bcs_profiles_school_results').html('');
          $.each(arr.msg, function (key,value){
            console.log(value);
            $.ajax({
              type:"GET",
              url:"../../bcs_questions_school/edit_form_for_project/" + value['id'],
              success: function(resp2){
                var arr2 = JSON.parse(resp2);
                var locs = unserialize(value['location']);
                if (empty(locs))
                { 
                  locs = ''; 
                }else{
                  locs = locs.toString().split(',').join(', ');
                }
                 
                $('#bcs_profiles_school_results').append('<!-- begin: #dashboard-c1-p1 --><div id="new_project-c1-p' + value["id"] + '" class="panel panel-default"><div class="panel-heading" style="line-height:15px !important;"><span class="panel-title"><span class="fa fa-calendar"></span>' + value["name"] + '</span><div id="new_project_check_button" class="pull-right"><div class="bs-component"><div class="checkbox-custom mb5"><input type="checkbox" value="' + value['id'] +'" name= "project_profiles[]" id="project_profile_' + value['id'] + '"><label style="line-height: 20px;" for="project_profile_' + value["id"] + '">'+ value["name"] + '</label></div></div></div></div><div class="panel-body"><table class="table table-condensed responsive"><tbody><tr><td>Created On:</td><td>'+value["created"]+'</td></tr><tr><td>Locations:</td><td>'+locs+'</td></tr><tr><td>Notes:</td><td>'+value["notes"]+'</td></tr><tr><td>Alert:</td><td>'+value["facilities_alert_description"]+'</td></tr><tr><td>BCS Answers</td><td>' + arr2.data + '</td></tr></tbody></table></div></div><!-- end: #dashboard-c1-p1 -->');
              }
            });
          });

          $('#bcs_info_profile_school_list').removeClass('hidden').animate({
            opacity: 1,
            height: '100%',
          },1000);
          $('#how_many_profiles_chosen_panel').show();
          $('#how_many_profiles_chosen_panel #how_many_profiles_chosen').html('0');

          console.log(arr.msg);
        } else {
          $('#bcs_info_profile_school_list').removeClass('hidden').animate({
            opacity: 1,
            height: '100%',
          },1000);
          $('#bcs_profiles_school_results').html('<h2>' + arr.msg + '</h2>');
        } 
      }
    });
  });

  /* ------ RESULTS PROFILE SELECTION INPUT ------*/
  $(document).on('click','input[name^=project_profiles]',function(){
    var len = $('input[name^=project_profiles]:checked').length;
    $('#how_many_profiles_chosen').html(len);
  });

  /* ------ NEW BCS/NON BCS PROJECT BUTTON ------*/
  $(document).on('click','#new_project_btn-generate_project',function(e){
    e.preventDefault;
    var el = $('#project_direction_bcs_non');
    var proj_type = el.val();
    if (proj_type == 'bcs_project')
    {
      var len = $('input[name^=project_profiles]:checked').length;
      if (len < 1){
        alert("Please select a bcs profile to add to your project.  If you don't want to attach a bcs profile, select 'Non BCS Project' type.");
        $('html,body').animate({scrollTop: el.offset().top - 100}, 200, function() {
            el.focus();
        });
        return;
      }
    } else {
      alert('non bcs project');
    }
  });

/* ------ UTILITY FUNCTIONS ------*/
  /* ------ A FUNCTION THAT CAPTURES ALL OF THE DEFAULT RESETS ------*/
  function reset_default_fields_and_values(){
    /* ------ HIDE THESE DIVS AND SET DEFAULTS ------*/
    $('#how_many_profiles_chosen_panel #how_many_profiles_chosen').html('0');
    $('#how_many_profiles_chosen_panel').addClass('hidden');
    $('#bcs_info_container').addClass('hidden').css('height','25%').css('opacity','.25');
    $('#bcs_info_profile_school_list').addClass('hidden').css('height','25%').css('opacity','.25');
    $('#save_default_project_details_heading').addClass('hidden').prev().removeClass('col-xs-10 col-sm-11 col-md-10 col-lg-10 col-xl-11').addClass('col-xs-12');
    $('#save_default_project_details_profile').addClass('hidden').prev().removeClass('col-xs-10 col-sm-11 col-md-10 col-lg-10 col-xl-11').addClass('col-xs-12');;
    clear_all_fields();
  }
  /* ------ CEARING ALL NECESSARY FIELDS ------*/
  function clear_all_fields(){
    $('#project_details_heading').val([]);
    $('#project_details_profile').val([]);
    $('#project_filter_condition').val('none');
    $('#project_filter_remaining_useful_life').val('none');
  }
  /* ------ Log the data to the console for debugging. ------*/
  function log_the_data(){
    data_array = {
      schoolDistricts:            school_districts, 
      schoolDistrictKeys:         sd_keys,
      chosenSchoolDistrict:       chosen_sd,
      chosenSchoolDistrictEvent:  chosen_sd_event,
      schools:                    schools,
      schoolKeys:                 s_keys,
      chosenSchool:               chosen_s, 
    }
    console.log(data_array);
  }
  /* ------ Log the data to the console for debugging - for the heading & profile values ------*/
  function log_the_data2(){
    data_array2 = {
      headings:       headings, 
      chosen_h:       chosen_h,
      chosen_heading: chosen_heading,
      profiles:       profiles,
      profileKeys:    z_keys, 
      chosen_p:       chosen_p, 
    }
    console.log(data_array2);
  }
  /* ------ Used for loading popup on all ajax calls ------*/
  function openLoadingPopup(){
    $.magnificPopup.open({
      removalDelay: 500,
      modal: true,
      items: {
        src: '<div id="magnificPopupNewProject"><img id="magnificPopupNewProjectImg" src="../../assets/img/loading.gif"><span class="caption">Loading...</span></div><div style="display: inline-block; vertical-align: middle; height:100%;"></div>',
      },
      type: 'inline',
    });
  }
  function closeLoadingPopup(){
    $.magnificPopup.close();
  }
  /* ------ Check a value for empty ------*/
  function empty(data){
    if(typeof(data) == 'number' || typeof(data) == 'boolean')
    { 
      return false; 
    }
    if(typeof(data) == 'undefined' || data === null)
    {
      return true; 
    }
    if(typeof(data.length) != 'undefined')
    {
      return data.length == 0;
    }
    var count = 0;
    for(var i in data)
    {
      if(data.hasOwnProperty(i))
      {
        count ++;
      }
    }
    return count == 0;
  }
  /* ------ Unserialize Location Data From PHP ------*/
  function unserialize(data) {
    //  discuss at: http://phpjs.org/functions/unserialize/
    // original by: Arpad Ray (mailto:arpad@php.net)
    // improved by: Pedro Tainha (http://www.pedrotainha.com)
    // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // improved by: Chris
    // improved by: James
    // improved by: Le Torbi
    // improved by: Eli Skeggs
    // bugfixed by: dptr1988
    // bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // bugfixed by: Brett Zamir (http://brett-zamir.me)
    //  revised by: d3x
    //    input by: Brett Zamir (http://brett-zamir.me)
    //    input by: Martin (http://www.erlenwiese.de/)
    //    input by: kilops
    //    input by: Jaroslaw Czarniak
    //        note: We feel the main purpose of this function should be to ease the transport of data between php & js
    //        note: Aiming for PHP-compatibility, we have to translate objects to arrays
    //   example 1: unserialize('a:3:{i:0;s:5:"Kevin";i:1;s:3:"van";i:2;s:9:"Zonneveld";}');
    //   returns 1: ['Kevin', 'van', 'Zonneveld']
    //   example 2: unserialize('a:3:{s:9:"firstName";s:5:"Kevin";s:7:"midName";s:3:"van";s:7:"surName";s:9:"Zonneveld";}');
    //   returns 2: {firstName: 'Kevin', midName: 'van', surName: 'Zonneveld'}

    var that = this,
      utf8Overhead = function(chr) {
        // http://phpjs.org/functions/unserialize:571#comment_95906
        var code = chr.charCodeAt(0);
        if (code < 0x0080) {
          return 0;
        }
        if (code < 0x0800) {
          return 1;
        }
        return 2;
      };
    error = function(type, msg, filename, line) {
      throw new that.window[type](msg, filename, line);
    };
    read_until = function(data, offset, stopchr) {
      var i = 2,
        buf = [],
        chr = data.slice(offset, offset + 1);

      while (chr != stopchr) {
        if ((i + offset) > data.length) {
          error('Error', 'Invalid');
        }
        buf.push(chr);
        chr = data.slice(offset + (i - 1), offset + i);
        i += 1;
      }
      return [buf.length, buf.join('')];
    };
    read_chrs = function(data, offset, length) {
      var i, chr, buf;

      buf = [];
      for (i = 0; i < length; i++) {
        chr = data.slice(offset + (i - 1), offset + i);
        buf.push(chr);
        length -= utf8Overhead(chr);
      }
      return [buf.length, buf.join('')];
    };
    _unserialize = function(data, offset) {
      var dtype, dataoffset, keyandchrs, keys, contig,
        length, array, readdata, readData, ccount,
        stringlength, i, key, kprops, kchrs, vprops,
        vchrs, value, chrs = 0,
        typeconvert = function(x) {
          return x;
        };

      if (!offset) {
        offset = 0;
      }
      dtype = (data.slice(offset, offset + 1))
        .toLowerCase();

      dataoffset = offset + 2;

      switch (dtype) {
        case 'i':
          typeconvert = function(x) {
            return parseInt(x, 10);
          };
          readData = read_until(data, dataoffset, ';');
          chrs = readData[0];
          readdata = readData[1];
          dataoffset += chrs + 1;
          break;
        case 'b':
          typeconvert = function(x) {
            return parseInt(x, 10) !== 0;
          };
          readData = read_until(data, dataoffset, ';');
          chrs = readData[0];
          readdata = readData[1];
          dataoffset += chrs + 1;
          break;
        case 'd':
          typeconvert = function(x) {
            return parseFloat(x);
          };
          readData = read_until(data, dataoffset, ';');
          chrs = readData[0];
          readdata = readData[1];
          dataoffset += chrs + 1;
          break;
        case 'n':
          readdata = null;
          break;
        case 's':
          ccount = read_until(data, dataoffset, ':');
          chrs = ccount[0];
          stringlength = ccount[1];
          dataoffset += chrs + 2;

          readData = read_chrs(data, dataoffset + 1, parseInt(stringlength, 10));
          chrs = readData[0];
          readdata = readData[1];
          dataoffset += chrs + 2;
          if (chrs != parseInt(stringlength, 10) && chrs != readdata.length) {
            error('SyntaxError', 'String length mismatch');
          }
          break;
        case 'a':
          readdata = {};

          keyandchrs = read_until(data, dataoffset, ':');
          chrs = keyandchrs[0];
          keys = keyandchrs[1];
          dataoffset += chrs + 2;

          length = parseInt(keys, 10);
          contig = true;

          for (i = 0; i < length; i++) {
            kprops = _unserialize(data, dataoffset);
            kchrs = kprops[1];
            key = kprops[2];
            dataoffset += kchrs;

            vprops = _unserialize(data, dataoffset);
            vchrs = vprops[1];
            value = vprops[2];
            dataoffset += vchrs;

            if (key !== i)
              contig = false;

            readdata[key] = value;
          }

          if (contig) {
            array = new Array(length);
            for (i = 0; i < length; i++)
              array[i] = readdata[i];
            readdata = array;
          }

          dataoffset += 1;
          break;
        default:
          error('SyntaxError', 'Unknown / Unhandled data type(s): ' + dtype);
          break;
      }
      return [dtype, dataoffset - offset, typeconvert(readdata)];
    };

    return _unserialize((data + ''), 0)[2];
  }

});