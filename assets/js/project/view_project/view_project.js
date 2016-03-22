jQuery(document).ready(function(){

  var hasChanged = {};
  var hcl = 0;
  var formData = {};

  $(document).on('change',"form[id^=project_form] :input",function() {
    $(this).data('changed', true);
    hasChanged[hcl] = $(this);
    hcl = hcl+1;
    $('#view_project_save_btn').prop("disabled", false);
  });


  $('#school_district_select').prop('disabled',true);
  var esi = $('#event_school_id').val();
  $('#school_select').val(esi);
  $('#school_select').prop('disabled',true);
  $('#projects_choose_title').html('Projects');
  

  $(document).on('submit','form[id^=project_form]',function(e){
    e.preventDefault();
    if (hcl > 0) 
    {
      $(this).validate();
      if ($(this).valid()){
        formData = {};
        $.each(hasChanged,function (i, val) {
          formData[val.attr('id')] = val.val();
        });
        hcl = 0;
        hasChanged = {};
        formData['id'] = $('#id').val();
        formData['csrf_bcs_token_name'] = $('[name=csrf_bcs_token_name]').val();
        formData['is_bcs_project'] = $('#is_bcs_project').val();


        console.log(formData);
        $.ajax({
          type:   'POST',
          url:    'update_project',
          data:   formData
        })
        .done(function(data){
          arr = JSON.parse(data);
          msg = arr.msg;

          if (arr.success)
          {
            console.log(arr.msg);
            $('#view_project_tab_container .panel-heading').append(arr.msg);
            setTimeout(function() {
              $('.temp_project_message').remove();
            }, 7500);
            var el = $('#view_project_tab_container .panel-heading');
            $('html,body').animate({scrollTop: el.offset().top - 100}, 200, function() {
              el.focus();
            });

          } else {
            $('#view_project_tab_container .panel-heading').append(arr.msg);
            setTimeout(function() {
              $('.temp_project_message').remove();
            }, 7500);
            var el = $('#view_project_tab_container .panel-heading');
            $('html,body').animate({scrollTop: el.offset().top - 100}, 200, function() {
              el.focus();
            });
          }
        })
        .fail(function(data){
          arr = JSON.parse(data);
            $('#view_project_tab_container .panel-heading').append(arr.msg);
            setTimeout(function() {
              $('.temp_project_message').remove();
            }, 7500);
            var el = $('#view_project_tab_container .panel-heading');
            $('html,body').animate({scrollTop: el.offset().top - 100}, 200, function() {
              el.focus();
            });
          });


        $('#view_project_save_btn').prop("disabled", true);
      }
    } else {
      console.log('nothing to see here!');
    };
  });         

});