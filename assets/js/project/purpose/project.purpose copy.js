jQuery(document).ready(function(){

	var datTab = $('#project_purposes_table').DataTable({
	  "aoColumnDefs": [{
        'bSortable': false,
        'aTargets': [-1]
      }],
      "iDisplayLength": 5,
      "aLengthMenu": [
        [5, 10, 25, 50, -1],
        [5, 10, 25, 50, "All"]
      ],
      "sDom": '<"dt-panelmenu clearfix"lfr>t<"dt-panelfooter clearfix"ip>',
      "oTableTools": {
        "sSwfPath": "vendor/plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf"
      }
    });

	// Handles the edit of the value.
    $('#project_purposes_table').editable({
        selector: 'td.x-editable-cell a',
        url: 'http://bucosu.com/project_purposes/update_item',
        success: function(response, newValue) {
          if(!response.success) return response.msg;
        },
        validate: function(value) {
          if($.trim(value) == '') {
            return 'This field is required';
          }
        }
    });


	$(document).on('click','.project_purposes_delete_button',function(e){
		e.preventDefault();
		var id = get_id($(this).prop('id'));
		if (!confirm('Are you sure you want to delete that Project Purpose?'))
  		{
  			return false;
  		}

  		$.ajax({
          method:"GET",
          url:"project_purposes/delete_item/?project_purpose_id=" + id,
          success: function(resp){
            var arr = JSON.parse(resp);
            if (arr.success){
            	window.location.href = "http://bucosu.com/project_purposes";
            } else {
            	alert(arr.msg);
            	return false;
            }
          },
	    });  		

	});






	var dialog, form;
	var project_purpose = $("#project_purpose_field");
    var allFields = $( [] ).add( project_purpose );
    var tips = $( ".validateTips" );
    var pp_new_id;

    dialog = $( "#dialog-form-project_purpose" ).dialog({
      autoOpen: false,
      height: 250,
      width: 350,
      modal: true,
      buttons: {
        "Add Project Purpose": addProjectPurpose,
        Cancel: function() {
          dialog.dialog( "close" );
        }
      },
      open: clearDialogValues,
      close: function() {
        form[ 0 ].reset();
        allFields.removeClass( "ui-state-error" );
      }
    });
 
    form = dialog.find( "form" ).on( "submit", function( event ) {
      event.preventDefault();
      addProjectPurpose();
    });


	$(document).on('click','#project_purposes_new_button',function(e){
		e.preventDefault();
		dialog.dialog( "open" );
	});

 
    function updateTips( t ) {
      tips
        .text( t )
        .addClass( "ui-state-highlight" );
      setTimeout(function() {
        tips.removeClass( "ui-state-highlight", 1500 );
      }, 500 );
    }
 
    function checkLength( o, n, min, max ) {
      if ( o.val().length > max || o.val().length < min ) {
        o.addClass( "ui-state-error" );
        updateTips( "Length of " + n + " must be between " +
          min + " and " + max + "." );
        return false;
      } else {
        return true;
      }
    }
 	
 	function clearDialogValues(){
 		tips.text('All form fields are required.');	
 	}
 
    function addProjectPurpose() {
      var valid = true;
      allFields.removeClass( "ui-state-error" );

      valid = valid && checkLength( project_purpose, "project purpose", 1, 50 );
	  
      if ( valid ) {
		  $.ajax({
	          method:"GET",
	          url:"project_purposes/add_new_item/?new_project_purpose=" + project_purpose.val(),
	          success: function(resp){
	            var arr = JSON.parse(resp);
	            if (arr.success){
	            	pp_new_id = arr.msg;
	            	var rowNode = datTab.row.add([
						'<a href="#" id="project_purpose" data-pk="' + pp_new_id + '" data-type="text" data-placement="top" data-placeholder="Required" data-title="Change the purpose title" class="editable editable-click">' + project_purpose.val() + '</a>',
						'<a href="http://bucosu.com/project_purposes?id=' + pp_new_id + '" class="project_purposes_delete_button btn btn-danger" id="delete_' + pp_new_id + '">Delete</a>']
						).draw(false).node();
					$(rowNode).find('td:first').addClass('x-editable-cell');
					$(rowNode).addClass('bg-warning light pastel');
					setTimeout(function(){
						$(rowNode).removeClass('bg-warning light pastel', 1500);
					}, 500);

			        dialog.dialog( "close" );
	            } else {
	            	valid = false;
	            	project_purpose.addClass( "ui-state-error" );
	            	updateTips( arr.msg );
	            }
	          },
	        });
      }
      return valid;
    }

	function get_id(id){
		var loc = id.search('_') + 1;
		var id = id.substr(loc,3).trim();
		return id;

	}
});