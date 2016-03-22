jQuery(document).ready(function(){

    // Multi-Column Filtering
    $('#view_projects_table thead th').each(function() {
      var title = $('#view_projects_table tfoot th').eq($(this).index()).text();
      if (title !== ''){
        $(this).html('<input type="text" class="form-control" placeholder="' + title + '" />');
      };
    });

    // DataTable
    var view_projects_table = $('#view_projects_table').DataTable({
      "columnDefs": [
        {
          "width": "100px",
          "targets": [4, 6, -1]
        },
        {
          "width": "75px",
          "targets": [3, 5, 7, 8]
        },
        {
          "width": "100px",
          "targets" : [2]
        },
        {
          "searchable": false,
          "orderable":false,
          "targets": -1
        }
      ],
      "order": [
        [0, 'asc'],
        [1, 'asc']
      ],
      "sDom": '<"dt-panelmenu clearfix"Tfr>t<"dt-panelfooter clearfix"ip>',
      "displayLength": 10,
      "aLengthMenu": [
        [5, 10, 25, 50, -1],
        [5, 10, 25, 50, "All"]
      ],
      "oLanguage": {
        "oPaginate": {
          "sPrevious": "<",
          "sNext": ">"
        }
      },
      "oTableTools": {
        "sSwfPath": "../../../../vendor/plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf"
      },
    });

    // Apply the search
    view_projects_table.columns().eq(0).each(function(colIdx) {
      $('input', view_projects_table.column(colIdx).header()).on('keyup change', function() {
        view_projects_table
          .column(colIdx)
          .search(this.value)
          .draw();
      });
    });


    $('#new_project_message_alert').delay(3000).fadeOut("slow","linear",function(){$(this).remove()});
    $('#new_project_message_alert2').delay(3000).fadeOut("slow","linear",function(){$(this).remove()});
    $('#school_select').prop('disabled',true);
    $('#projects_choose_title').html('Select School District BCS Events');



  $(document).on('click','.project_delete_button',function(e){
    e.preventDefault();
    var id = get_id($(this).prop('id'));
    if (!confirm('Are you sure you want to delete that project?'))
      {
        return false;
      }

      $.ajax({
          method:"POST",
          data: {id:id},
          url:'delete_project',
          success: function(resp){
            var arr = JSON.parse(resp);
            if (arr.success){
              alert(arr.msg);
            } else {
              alert(arr.msg);
              return false;
            }
          },
      });     

  });

  function get_id(id){
    var loc = id.search('_') + 1;
    var id = id.substr(loc,3).trim();
    return id;

  }


});