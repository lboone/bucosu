<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php
class Menu extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();



/* 
 * -------------------------
 * Use this if you want to restrict the page by a certain level of admin!
 * ------------
 */

		if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin(false,1)) )
		{
			$this->_show_401();
		}


		$u_id    = intval($this->ion_auth->get_user_id());
		$u_type = intval($this->ion_auth->get_users_groups($u_id)->row()->type);
		if ($u_type > 2) {
			$this->_show_401();
		}

		$this->load->model('mdl_menu');
		

/* 
 * -------------------------
 * Use this section to inject css/js into the page
 * ------------
 */

		// $this->data['stylesheets']['top'][''] = get_css('');
		// $this->data['stylesheets']['theme'][''] = get_css('');
		// $this->data['stylesheets']['end'][''] = get_css('');

		// $this->data['javascripts']['header'] = get_js('');
		// $this->data['javascripts']['top'] = get_js('');
		// $this->data['javascripts']['jquery'] = get_js('');
		// $this->data['javascripts']['mid'] = get_js('');
		// $this->data['javascripts']['theme'] = get_js('');
		// $this->data['javascripts']['end'] = get_js('');

		// $this->data['footer'][] = get_js('');

	}

	public function index(){

		$this->data['javascripts']['end']['user_main']				= get_js('
	jQuery(document).ready(function() {

		"use strict";
		// Init DataTables
		$("#headings-table").dataTable({
	      "sDom": \'t<"dt-panelfooter clearfix"ip>\',
	      "oTableTools": {
	        "sSwfPath": "vendor/plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf"
	      }
	    });

	});
																	  ',TRUE);

		$results = $this->mdl_menu->get();

		
		$this->data['table_row_data'] = $results;
		$this->data['table_header_data'] = array('ID', 'Header Label','Label','Link','Icon','Parent','Sort','Group Type','Group Level','Action');
		$this->data['table_row_data_fields'] = array(
			'ID'					=> array(
										'type'	=> 'field',
										'value' => 'id'),			
			'Header Label'			=> array(
										'type'	=> 'field',
										'value' => 'header_label'),
			'Label'					=> array(
										'type'	=> 'field',
										'value' => 'label'),
			'Link'					=> array(
										'type'	=> 'field',
										'value' => 'link'),			
			'Icon'					=> array(
										'type'	=> 'image',
										'value' => 'icon'),
			'Parent'				=> array(
										'type'	=> 'field',
										'value' => 'parent'),		
			'Sort'					=> array(
										'type'	=> 'field',
										'value' => 'sort'),	
			'Group Type'			=> array(
										'type'	=> 'field',
										'value' => 'group_type'),	
			'Group Level'			=> array(
										'type'	=> 'field',
										'value' => 'group_level'),												
			'Action'				=> array(
										'type'	=> 'anchor',
										'value' => array('/menu/edit_menu/', 'id', '' , 'Edit')),
			);
		$this->data['table_settings'] = array(
			'table_heading'	=>	'Nav Menus',
			'table_sub_heading'	=>	'The main navigation menus.',
			'table_id' => 'menus-table',
			'table_new_record_anchors' => array(
											array('/menu/new_menu','New Menu'),
										  ),
			);


		$this->data['title'] = "Navigation Menus";
		$subView = 'ui/_layout_table_data';
		$mainView = 'ui/_layout_main';
		$this->load_structure($subView,$mainView);	

	}


	public function create()
	{

	}

	public function read($id)
	{

	}


	public function update($id)
	{

	}

	public function delete($id)
	{

	}

	public function edit_menu($id)
	{
		echo "Edited this menu item: " . $id;
	}
}
?>