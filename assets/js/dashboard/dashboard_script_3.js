jQuery(document).ready(function() {

    "use strict";
    // Init Widget Demo JS
    // demoHighCharts.init();

    // Because we are using Admin Panels we use the OnFinish 
    // callback to activate the demoWidgets. It's smoother if
    // we let the panels be moved and organized before 
    // filling them with content from various plugins

    // Init plugins used on this page
    // HighCharts, JvectorMap, Admin Panels

    // Init Admin Panels on widgets inside the ".admin-panels" container
    $('.admin-panels').adminpanel({
      grid: '.admin-grid',
      draggable: true,
      preserveGrid: true,
      mobile: false,
      onFinish: function() {
        $('.admin-panels').addClass('animated fadeIn').removeClass('fade-onload');

        // Init the rest of the plugins now that the panels
        // have had a chance to be moved and organized.
        // It's less taxing to organize empty panels
        demoHighCharts.init();
      },
      onSave: function() {
        $(window).trigger('resize');
      }
    });

 // Initilize Gmap3 - Navigation Pager
    $(function() {
      $.ajax({
        type:"GET",
        url:"dashboard/get_map_data_by_event_school_district/"+ $("#bcs_events_school_district_1").val(),
        success: function(resp){
          var arr = JSON.parse(resp);
          if (arr.result == 'success'){
            var markers = arr.data;
            $('#map_canvas3').gmap({
              'zoom': 12,
              'disableDefaultUI': true,
              'zoomControl': true,
              'scaleControl': true,
              'streetViewControl': true,
              'rotateControl': true,
              'callback': function() {
                var self = this;
                $.each(markers, function(i, marker) {
                  self.addMarker(marker).click(function() {
                    self.openInfoWindow({
                      'content': this.content
                    }, this);
                  });
                });
              }
            }).gmap('pagination', 'title');
          } else {
            alert(arr.data);
          };
        }
      });

    });



    $(document).on('change','#bcs_events_school_district_1', function(){
      $.ajax({
        type:"GET",
        url:"dashboard/save_dashboard_defaults/" + $("#bcs_events_school_district_1").val(),
        success: function(resp){
          //$("<div class=\"alert alert-success alert-dismissable animated fadeInDown\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button><i class=\"fa fa-check pr10\"></i><strong>Your default settings have been updated!</strong></div>").insertBefore("#default_event_selection_form-group_1").delay(3000).fadeOut("slow","linear",function(){$(this).remove();});
          window.location.href = "http://bucosu.com/dashboard";
        }
      });
    });

  });