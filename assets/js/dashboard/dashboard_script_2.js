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
      var markers = [{
        'position': '42.80180000000000,-73.93529400000000',
        'label': 'Dr. Martin Luther King Jr.',
        'title': 'Dr. Martin Luther King Jr.',
        'content': 'Dr. Martin Luther King Jr. <br /> 918 Stanley Street'
      }, {
        'position': '42.80742690000000,-73.90522199999998',
        'label': 'Howe Early Childhood Education Center',
        'title': 'Howe Early Childhood Education Center',
        'content': 'Howe Early Childhood Education Center <br /> 1065 Baker Street'
      }, {
        'position': '42.79699300000000,-73.97190900000000',
        'label': 'Fulton Early Childhood Education Center',
        'title': 'Fulton Early Childhood Education Center',
        'content': 'Fulton Early Childhood Education Center <br /> 408 Eleanor Stree'
      }, {
        'position': '42.81032800000000,-73.92181500000000',
        'label': 'Elmer Avenue Elementary School',
        'title': 'Elmer Avenue Elementary School',
        'content': 'Elmer Avenue Elementary School <br /> 90 Elmer Avenue'
      }, {
        'position': '42.80343600000000,-73.94828800000000',
        'label': 'Franklin D. Roosevelt Elementary School',
        'title': 'Franklin D. Roosevelt Elementary School',
        'content': 'Franklin D. Roosevelt Elementary School <br /> 570 Lansing Street'
      }, {
        'position': '42.79590600000000,-73.94965000000000',
        'label': 'Hamilton Elementary School',
        'title': 'Hamilton Elementary School',
        'content': 'Hamilton Elementary School <br /> 7th Avenue & Webster Street'
      }, {
        'position': '42.79489100000000,-73.92205600000000',
        'label': 'Lincoln Community Elementary School',
        'title': 'Lincoln Community Elementary School',
        'content': 'Lincoln Community Elementary School <br /> 2 Robinson Street'
      }, {
        'position': '42.79924000000000,-73.94078700000000',
        'label': 'Pleasant Valley',
        'title': 'Pleasant Valley',
        'content': 'Pleasant Valley <br /> 1097 Forest Rd.'
      }, {
        'position': '42.79177800000000,-73.96612200000000',
        'label': 'Van Corlaer Elementary School',
        'title': 'Van Corlaer Elementary School',
        'content': 'Van Corlaer Elementary School <br /> 2300 Guilderland Ave.'
      }, {
        'position': '42.79659300000000,-73.92472400000000',
        'label': 'William C. Keane Elementary School',
        'title': 'William C. Keane Elementary School',
        'content': 'William C. Keane Elementary School <br /> 1252 Albany Street, Schenectady'
      }, {
        'position': '42.77053800000000,-73.90596500000000',
        'label': 'Woodlawn Elementary School',
        'title': 'Woodlawn Elementary School',
        'content': 'Woodlawn Elementary School <br /> 3311 Wells Ave. and Gifford Rd.'
      }, {
        'position': '42.83004700000000,-73.91877200000000',
        'label': 'Yates Arts In Education Magnet School',
        'title': 'Yates Arts In Education Magnet School',
        'content': 'Yates Arts In Education Magnet School <br /> 725 Salina Street'
      }, {
        'position': '42.80160300000000,-73.91693600000000',
        'label': 'Central Park International Magnet School',
        'title': 'Central Park International Magnet School',
        'content': 'Central Park International Magnet School <br /> 421 Elm Street, Schenectady'
      }, {
        'position': '42.78584800000000,-73.90327600000000',
        'label': 'Paige School',
        'title': 'Paige School',
        'content': 'Paige School <br /> 104 Elliott Avenue'
      }, {
        'position': '42.82019600000000,-73.90769000000000',
        'label': 'Zoller School',
        'title': 'Zoller School',
        'content': 'Zoller School <br /> 1880 Lancaster Street'
      }, {
        'position': '42.79794500000000,-73.93919300000000',
        'label': 'Mont Pleasant Middle School',
        'title': 'Mont Pleasant Middle School',
        'content': 'Mont Pleasant Middle School <br /> 1121 Forest Rd.'
      }, {
        'position': '42.79766000000000,-73.94305500000000',
        'label': 'Success Academy',
        'title': 'Success Academy',
        'content': 'Success Academy <br /> 880 Oakwood Ave'
      }, {
        'position': '42.81466300000000,-73.91073100000000',
        'label': 'Schenectady High School',
        'title': 'Schenectady High School',
        'content': 'Schenectady High School <br /> 1445 The Plaza'
      }, {
        'position': '42.79742530000000,-73.94343270000000',
        'label': 'Steinmetz Career & Leadership Academy',
        'title': 'Steinmetz Career & Leadership Academy',
        'content': 'Steinmetz Career & Leadership Academy <br /> 880 Oakwood Avenue'
      }];
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
    });

  });