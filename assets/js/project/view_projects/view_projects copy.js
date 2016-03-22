jQuery(document).ready(function(){
 // ROW GROUPING
 console.log('logged from view projects: ');
 console.log($('#school_district_select').val());

    var view_projects_table = $('#view_projects_table').DataTable({
      "columnDefs": [
        {
          "visible": false,
          "targets": 2
        },
        {
          "searchable": false,
          "orderable":false,
          "targets": -1
        }
      ],
      "order": [
        [2, 'asc']
      ],
      "sDom": '<"dt-panelmenu clearfix"Tfr>t<"dt-panelfooter clearfix"ip>',
      "displayLength": 25,
      "aLengthMenu": [
        [5, 10, 25, 50, -1],
        [5, 10, 25, 50, "All"]
      ],
      "oLanguage": {
        "oPaginate": {
          "sPrevious": "",
          "sNext": ""
        }
      },
      "oTableTools": {
        "sSwfPath": "../../../../vendor/plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf"
      },
      "drawCallback": function(settings) {
        var api = this.api();
        var rows = api.rows({
          page: 'current'
        }).nodes();
        var last = null;

        api.column(2, {
          page: 'current'
        }).data().each(function(group, i) {
          if (last !== group) {
            $(rows).eq(i).before(
              '<tr class="row-label ' + group.replace(/ /g, '').toLowerCase() + '"><td colspan="10">' + group + '</td></tr>'
            );
            last = group;
          }
        });
      }
    });

    // Order by the grouping
    $('#view_projects_table tbody').on('click', 'tr.row-label', function() {
      var currentOrder = view_projects_table.order()[0];
      if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
        view_projects_table.order([2, 'desc']).draw();
      } else {
        view_projects_table.order([2, 'asc']).draw();
      }
    });


    $('#new_project_message_alert').delay(3000).fadeOut("slow","linear",function(){$(this).remove()});

    $('#projects_choose_school').hide();
    $('#projects_choose_title').html('Select School District BCS Events');

});