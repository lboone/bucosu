jQuery(document).ready(function(){

	var table_div = $('#' + list_item_table);


	var datTab = table_div.DataTable({
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
    table_div.editable({
        selector: 'td.x-editable-cell a',
        url: list_item_plural + '/update_item',
        success: function(response, newValue) {
          if(!response.success) return response.msg;
        },
        validate: function(value) {
          if($.trim(value) == '') {
            return 'This field is required';
          }
        }
    });


	$(document).on('click','.' + list_item_plural + '_delete_button',function(e){
		e.preventDefault();
		var id = get_id($(this).prop('id'));
		if (!confirm('Are you sure you want to delete that ' + list_item_title + '?'))
  		{
  			return false;
  		}

  		$.ajax({
          method:"GET",
          url:list_item_plural + '/delete_item/?' + list_item_single +'_id=' + id,
          success: function(resp){
            var arr = JSON.parse(resp);
            if (arr.success){
            	window.location.href = list_item_plural;
            } else {
            	alert(arr.msg);
            	return false;
            }
          },
	    });  		

	});






	var dialog, form;
	var list_item = $("#" + list_item_single + "_field");
    var allFields = $( [] ).add( list_item );
    var tips = $( ".validateTips" );
    var pp_new_id;

    dialog = $( "#dialog-form-" + list_item_single ).dialog({
      autoOpen: false,
      height: 250,
      width: 350,
      modal: true,
      buttons: {
        "Add New Item": addListItem,
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
      addListItem();
    });


	$(document).on('click','#'+list_item_plural+'_new_button',function(e){
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
 
    function addListItem() {
      var valid = true;
      allFields.removeClass( "ui-state-error" );

      valid = valid && checkLength( list_item, list_item_title, 1, 50 );
	  
      if ( valid ) {
		  $.ajax({
	          method:"GET",
	          url:list_item_plural + "/add_new_item/?"+list_item_single+"=" + list_item.val(),
	          success: function(resp){
	            var arr = JSON.parse(resp);
	            if (arr.success){
	            	pp_new_id = arr.msg;
	            	var rowNode = datTab.row.add([
						'<a href="#" id="'+list_item_single+'" data-pk="' + pp_new_id + '" data-type="text" data-placement="top" data-placeholder="Required" data-title="Change the '+list_item_title+' title" class="editable editable-click">' + list_item.val() + '</a>',
						'<a href="'+list_item_plural+'?id=' + pp_new_id + '" class="'+list_item_plural+'_delete_button btn btn-danger" id="delete_' + pp_new_id + '">Delete</a>']
						).draw(false).node();
					$(rowNode).find('td:first').addClass('x-editable-cell');
					$(rowNode).addClass('bg-warning light pastel');
					setTimeout(function(){
						$(rowNode).removeClass('bg-warning light pastel', 1500);
					}, 500);
			        dialog.dialog( "close" );

	            } else {

	            	valid = false;
	            	list_item.addClass( "ui-state-error" );
	            	updateTips( arr.msg );
	            }
	          },
	         error: function(xhr,stat,err){
	         	valid = false;
	            list_item.addClass( "ui-state-error" );
	            updateTips( err );
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