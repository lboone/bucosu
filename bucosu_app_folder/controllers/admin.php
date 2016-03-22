<?php
class Admin extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();

		if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin(false,1)) )
		{
			$this->_show_401();
		}

		$u_id    = intval($this->ion_auth->get_user_id());
		$u_type = intval($this->ion_auth->get_users_groups($u_id)->row()->type);
		if ($u_type > 2) {
			$this->_show_401();
		}
		$this->data['stylesheets']['end']['admin-forms']	= get_css('assets/admin-tools/admin-forms/css/admin-forms.css');
		$this->data['stylesheets']['top']['datatables_bootstrap'] 	= get_css('vendor/plugins/datatables/media/css/dataTables.bootstrap.css');
		$this->data['stylesheets']['top']['datatables_plugin']		= get_css('vendor/plugins/datatables/media/css/dataTables.plugins.css');

		$this->data['javascripts']['mid']['jquery_datatables']		= get_js('vendor/plugins/datatables/media/js/jquery.dataTables.js');
		$this->data['javascripts']['mid']['datatables_bootstrap']	= get_js('vendor/plugins/datatables/media/js/dataTables.bootstrap.js');

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
	
		$this->load->model('admin/bcs/headings_model');
		$this->load->model('admin/bcs/profiles_model');
		$this->load->model('admin/bcs/questions_model');
	}

	public function index() 
	{
		$this->data['javascripts']['end']['googleMaps'] = get_js("http://maps.google.com/maps/api/js?sensor=false");
		$this->data['javascripts']['end']['user_main']	= get_js("
jQuery(document).ready(function() {
	$('#lkupAddForm').submit(function(e){
		getAddress();
		e.preventDefault();
	});
	$('#lkupAdd').blur(function(){
		getAddress();
	});
	function getAddress(){
		var address = $('#lkupAdd').val();
		var geocoder = new google.maps.Geocoder();
		if (geocoder) {
			geocoder.geocode({ 'address': address }, function (results, status) {
			    if (status == google.maps.GeocoderStatus.OK) {
			    	var coords = results[0].geometry.location;
			    	$('#addLong').val(coords.lng());
			    	$('#addLat').val(coords.lat());
			    }
			    else {
			    	alert('Geocoding failed: ' + status);
			    }
		 	});
		}
	}
});
																	  ",TRUE);



	// jQuery(document).ready(function() {

	// 	'use strict';

	// 	 $(':submit').on('click', function() { // This event fires when a button is clicked
	// 	    var addr = $('#lkupAdd').val();
	// 		var addrClean = addr.split(' ').join('+');
	// 	    $.ajax({ 
	// 	      url: 'http://maps.googleapis.com/maps/api/geocode/json?address=' + addrClean + '&sensor=false',
	// 	      dataType: 'json',
	// 	    })
	// 	    .done(function(data) {
	// 	    	$('#addrInfo').html('Made It');
	// 			$('#addrInfo').append(data);			
	// 	    });
	// 	    return false; // keeps the page from not refreshing 
	// 	  });
	// });

	// Init DataTables
		// $('#lkupAddForm').submit(function(e){
		// 	var addr = $('#lkupAdd').val();
		// 	var addrClean = addr.split(' ').join('+');
		// 	$.ajax( {
		// 		url  : 'http://maps.googleapis.com/maps/api/geocode/json?address=4+green+acres+drive+latham+ny,+12110&sensor=false',
		// 		dataType: 'json',
		// 	    } )
		// 	.done(function(data){

		// 	});
		// 	e.preventDefault();
		// });

		// $address = '725 Broadway Albany, NY 12207'; // Google HQ
		// $prepAddr = str_replace(' ','+',$address);
		 
		// $geocode=file_get_contents("http://maps.google.com/maps/api/geocode/json?address=".$prepAddr."&sensor=false");
		 
		// $output= json_decode($geocode);
		 
		// $lat = $output->results[0]->geometry->location->lat;
		// $long = $output->results[0]->geometry->location->lng;
		 
		//  $this->data['coords'] = array(
		//  		'lat'=>$lat,
		//  		'long'=>$long,
		//  	);

		//  $this->data['coords'] = $output->results;



		$this->data['title'] = "ADMIN";
		$subView = 'admin/home_view';
		$mainView = 'ui/_layout_main';
		$this->load_structure($subView,$mainView);		
	}
	public function menus(){
		$this->data['title'] = "NAV MENUS";
		$subView = 'admin/home_view';
		$mainView = 'ui/_layout_main';
		$this->load_structure($subView,$mainView);	
	}


	/*
	 * #############################################################################
	 *
	 * ------------------ URL Routing for bcs admin Section ------------------------
	 *
	 * #############################################################################
	 */ 
	/*
	 * $method should only have NULL / edit
	 *    ---- allowing for editing a question or nothing
	 *
	 * $questionVal should be NULL / new / questions / slug (which will allow editing that question)
	 *    ---- if null - ignore it
	 *    ---- if new send to _new_question()function.
	 *    ---- if questions send to _questions() function.
	 * 
	 */	
	public function bcs($headingVal = NULL, $profileVal = NULL, $questionVal = NULL, $method=NULL)
	{

		if ($headingVal == NULL) {
			$method = '_render_bcs_admin_home_page';
			if(method_exists( $this,$method))
			{
				call_user_func(array($this,$method));
				return TRUE;
			} else {
				throw new Exception('Undefined method Admin BCS::' . $method . '() called');
				return FALSE;
			}

		}

		// ---- /admin/bcs/heading/profile/question/edit ---- edit the question

		// This should only mean that we want to edit a question.
		if (!$method == NULL)
		{
			$meth = $method;
			$method = '_render_question';
			if ($meth == 'edit' && method_exists( $this,$method)) {
				
				$arguments = array(
								'heading'=>$headingVal,
								'profile'=>$profileVal,
								'question'=>$questionVal,
								'mode' => 'edit',
							);
				call_user_func_array(array($this,$method),$arguments);
				return TRUE;

			} else {
				throw new Exception('Undefined method Admin BCS::' . $method . '("edit") called');
				return FALSE;
			}
		} 


		// ---- /admin/bcs/heading/profile/new_question ---- create a new question for the heading/profile
		// This shouls always mean that we want to create a new question
		if ($questionVal=='new_question')
		{
			$method = '_render_question';
			if(method_exists( $this,$method))
			{
				$arguments = array(
								'heading'=>$headingVal,
								'profile'=>$profileVal,
								'quesiton'=>NULL,
								'mode'=>'new',
							);
				call_user_func_array(array($this,$method),$arguments);
				return TRUE;
			} else {
				throw new Exception('Undefined method Admin BCS::' . $method . '() called');
				return FALSE;
			}
		}

		// ---- /admin/bcs/heading/profile/edit ---- edit a profile document
		// This shouls always mean that we want to edit an existing profile document
		if ($questionVal == 'edit') 
		{

			$method = '_render_profile';
			if(method_exists( $this,$method))
			{
				$arguments = array(
								'heading'=>$headingVal,
								'profile'=>$profileVal,
								'mode'=>'edit',
							);
				call_user_func_array(array($this,$method),$arguments);
				return TRUE;
			} else {
				throw new Exception('Undefined method Admin BCS::' . $method . '("edit") called');
				return FALSE;
			}
		}

		// ---- /admin/bcs/heading/profile/question ---- reads the question.
		if (!$questionVal == NULL) 
		{

			$method = '_render_question';
			if(method_exists( $this,$method))
			{
				$arguments = array(
								'heading'=>$headingVal,
								'profile'=>$profileVal,
								'quesiton'=>$questionVal,
								'mode'=>'read',
							);
				call_user_func_array(array($this,$method),$arguments);
				return TRUE;
			} else {
				throw new Exception('Undefined method Admin BCS::' . $method . '("read") called');
				return FALSE;
			}
		}


		// ---- /admin/bcs/heading/new_profile ---- create a new profile document
		// This shouls always mean that we want to create a new profile
		if ($profileVal == 'new_profile') 
		{

			$method = '_render_profile';
			if(method_exists( $this,$method))
			{
				$arguments = array(
								'heading'=>$headingVal,
								'profile'=>NULL,
								'mode'=>'new',
							);
				call_user_func_array(array($this,$method),$arguments);
				return TRUE;
			} else {
				throw new Exception('Undefined method Admin BCS::' . $method . '() called');
				return FALSE;
			}
		}

				// ---- /admin/bcs/heading/new_profile ---- create a new profile document
		// This shouls always mean that we want to create a new profile
		if ($profileVal == 'edit') 
		{


			$method = '_render_heading';
			if(method_exists( $this,$method))
			{
				$arguments = array(
								'heading'=>$headingVal,
								'mode'=>'edit',
							);
				call_user_func_array(array($this,$method),$arguments);
				return TRUE;
			} else {
				throw new Exception('Undefined method Admin BCS::' . $method . '("edit") called');
				return FALSE;
			}
		}


		// ---- /admin/bcs/heading/profile/question ---- reads the question.
		if (!$profileVal == NULL) 
		{

			$method = '_render_profile';
			if(method_exists( $this,$method))
			{
				$arguments = array(
								'heading'=>$headingVal,
								'profile'=>$profileVal,
								'mode'=>'read',
							);
				call_user_func_array(array($this,$method),$arguments);
				return TRUE;
			} else {
				throw new Exception('Undefined method Admin BCS::' . $method . '("read") called');
				return FALSE;
			}
		}

				// ---- /admin/bcs/heading/new_profile ---- create a new profile document
		// This shouls always mean that we want to create a new profile
		if ($headingVal == 'new_heading') 
		{

			$method = '_render_heading';
			if(method_exists( $this,$method))
			{
				$arguments = array(
								'heading'=>NULL,
								'mode'=>'new',
							);
				call_user_func_array(array($this,$method),$arguments);
				return TRUE;
			} else {
				throw new Exception('Undefined method Admin BCS::' . $method . '() called');
				return FALSE;
			}
		}

				// ---- /admin/bcs/heading/profile/question ---- reads the question.
		if (!$headingVal == NULL) 
		{

			$method = '_render_heading';
			if(method_exists( $this,$method))
			{
				$arguments = array(
								'heading'=>$headingVal,
								'mode'=>'read',
							);
				call_user_func_array(array($this,$method),$arguments);
				return TRUE;
			} else {
				throw new Exception('Undefined method Admin BCS::' . $method . '("read") called');
				return FALSE;
			}
		}
	
	}

	/*
	 * #############################################################################
	 *
	 * ------------------------ Interface rendering section ------------------------
	 *
	 * #############################################################################
	 */ 

	protected function _render_bcs_admin_home_page()
	{
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

		$headings = $this->headings_model->get_bcs_headings();

		
		$this->data['table_row_data'] = $headings;
		$this->data['table_header_data'] = array('Order', 'Name','Profile Count','Action');
		$this->data['table_row_data_fields'] = array(
			'Order'					=> array(
										'type'	=> 'field',
										'value' => 'order'),			
			'Name'					=> array(
										'type'	=> 'field',
										'value' => 'name'),
			'Profile Count'			=> array(
										'type'	=> 'field',
										'value' => 'profiles'),
			'Action'				=> array(
										'type'	=> 'anchor',
										'value' => array('/admin/bcs/', 'slug','/edit', 'Edit')),
			);
		$this->data['table_settings'] = array(
			'table_heading'	=>	'BCS Headings',
			'table_sub_heading'	=>	'Main Heading Divisions',
			'table_id' => 'headings-table',
			'table_new_record_anchors' => array(
											array('/admin/bcs/new_heading','New Heading'),
										  ),
			);


		$this->data['title'] = "BCS - All the BCS Headings Listed Here";
		$subView = 'ui/_layout_table_data';
		$mainView = 'ui/_layout_main';
		$this->load_structure($subView,$mainView);	
	}

	/*
	 * --Edit / Read a question for a heading/profile based on mode
	 * $arguments contain
	 * $heading - the heading to pull
	 * $profile - the profile to pull
	 * $question - the question to pull
	 * $mode
	 */
	protected function _render_question($heading, $profile, $question, $mode)
	{
		$slug = $question;

		// First step - verify that question slug exists!
		// List all secitons / select passed heading
		// List all profiles for passed heading / select passed profile
		// List all questions for passed profile / select passed question and put in edit/read mode.

		if ($mode == 'edit') 
		{
			$this->data['title'] = "BCS - Edit Question for heading: " . $heading . " profile: " . $profile . " question: " . $question . '/';

		} 
		elseif ($mode == 'read')
		{
			$this->data['title'] = "BCS - Read Question for heading: " . $heading . " profile: " . $profile . " question: " . $question . '/';
		}
		elseif ($mode == 'new')
		{
			$this->data['title'] = "BCS - New Question for heading: " . $heading . " profile: " . $profile . " / ";
		}
		else 
		{
			throw new Exception('Undefined method Admin BCS _render_question() mode::' . $mode . '() called');
			return FALSE;
		}

			$subView = 'admin/home_view';
			$mainView = 'ui/_layout_main';
			$this->load_structure($subView,$mainView);	

	}


	/*
	 * --Edit / Read a question for a heading/profile based on mode
	 * $arguments contain
	 * $heading - the heading to pull
	 * $profile - the profile to pull
	 * $question - the question to pull
	 * $mode
	 */
	protected function _render_profile($heading, $profile, $mode)
	{

			$slug = $profile;


		// Check the mode to ensure it's a good mode.  new/edit/read
		if ($this->_is_valid_mode($mode) == FALSE)
		{
			throw new Exception('Undefined method Admin BCS _render_profile() mode::' . $mode . '() called');
			return FALSE;
		}

		// If Edit / Read & Slug is missing then redirect cause there was an error
		if((!$mode == 'new') && (!$slug || empty($slug)))
		{
			throw new Exception('No profile passed to the function Admin BCS _render_profile() mode::' . $mode . '() called');
			return FALSE;
		}


		//$this->data['title'] = "BCS - " . ucwords($mode) . " profile: / ";

		// If Edit / Read get header & profiles else it is new so don' need to do it.
		if($mode == 'edit' || $mode == 'read')
		{
			// Get the current header
			$bcs_profile = $this->profiles_model->get_bcs_profile($slug);
			// Get the current header's profiles
			$bcs_questions = $this->profiles_model->get_bcs_profile_questions($slug);			
		}

		// If it is read then put all fields in read only mode.
		if($mode == 'read')  
		{ 
			// If it's read then don't need form validation
			$readonly = 'readonly'; 
		} 
		else  
		{
			$readonly = '';
			// If it's not read then set up the form validation.
			$this->form_validation->set_rules('profile_name', 'Profile Name', 'required');
			//$this->form_validation->set_rules('heading_slug', 'Heading Slug', 'required');
		} 

		// Check to see if we submitted the form.
		if (isset($_POST) && !empty($_POST))
		{
			if ($this->form_validation->run() === TRUE)
			{

				if ($mode == 'edit') {

					$pID = $this->profiles_model->update_profile($slug,array('name'=>$this->input->post('profile_name')));

					if($pID)
					{
						$this->session->set_flashdata('message', 'Profile Update Saved');
						redirect('admin/bcs/' . $heading);
					}
					else
					{
						$this->session->set_flashdata('message', $this->ion_auth->errors());
						redirect("admin/bcs/".$heading . '/' . $slug.'/edit', 'refresh');
					}	
				} else {

					
					$header_update = $this->headings_model->insert_heading(array('name'=>$this->input->post('heading_name')));
					$this->headings_model->reset_model();

					if($header_update)
					{
						$this->session->set_flashdata('message', 'Profile Inserted');
						redirect("admin/bcs/" . $heading, 'refresh');
					}
					else
					{
						$this->session->set_flashdata('message', $this->ion_auth->errors());
					}	
				}
				
				
			}
		}


		//set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		//$this->config->item('admin_group', 'ion_auth') === $group->name ? 'readonly' : '';
			
		// Gether information needed to load edit form
		$this->data['title'] = "BCS - " . ucwords($mode) . " " . strtoupper(str_replace("_", " ",$profile));
		$this->data['link_url']['new'] = 'admin/bcs/' . $heading . '/new_profile';
		$this->data['container_form_id'] = 'edit_profile'.$slug;
		$this->data['heading_title'] = ucwords($mode) . ' Profile.';
		$this->data['sub_heading_title']='complete fields below.';
		$this->data['submit_url'] = '';
		$this->data['form_id']=array('id'=>'form-edit-profile-'.$slug);
		// The field data
		$this->data['fields'][] = array(
									'type'	=>'text',
									'label' => 'Name',
									'id'    => 'profile_name',
									'icon'  => 'fa-home',
									'params'=>array(
												'name'  => 'profile_name',
												'id'    => 'profile_name',
												'type'  => 'text',
												'class' => 'gui-input',
												'value' => (($mode == 'new') ? $this->form_validation->set_value('profile_name') : $this->form_validation->set_value('profile_name',$bcs_profile->name)),
												$readonly => $readonly,
											   ),
								);
		$readonly = 'readonly';
		$this->data['fields'][] = array(
									'type'	=>'text',
									'label' => 'Slug',
									'id'    => 'profile_slug',
									'icon'  => 'fa-home',
									'params'=>array(
												'name'  => 'profile_slug',
												'id'    => 'profile_slug',
												'type'  => 'text',
												'class' => 'gui-input',
												'value' => (($mode == 'new') ? $this->form_validation->set_value('profile_slug') : $this->form_validation->set_value('profile_slug',$bcs_profile->slug)),
												$readonly => $readonly,
												'disabled' => "",
											   ),
								);
		//Load the update view
		$this->_set_view_data('edit_object','admin/crud/read_update');

		
		// if edit/read - load the profiles for this heading
		if($mode == 'edit' || $mode == 'read') {
					// Setup for loading the table at the bottom of the page.
			$this->data['javascripts']['end']['user_main']				= get_js('
	jQuery(document).ready(function() {

		"use strict";
		// Init DataTables
		$("#questions-table").dataTable({
	      "sDom": \'t<"dt-panelfooter clearfix"ip>\',
	      "oTableTools": {
	        "sSwfPath": "vendor/plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf"
	      }
	    });

	});
																	  ',TRUE);
			
			//Start compiling the data for the table
			$this->data['table_row_data'] = $bcs_questions;
			$this->data['table_header_data'] = array('BCS#', 'Order', 'Alpha', 'Question', 'Type', 'Rule', 'cp?', 'desc?', 'Action');
			$this->data['table_row_data_fields'] = array(
				'BCS#'						=> array(
											'type'	=> 'field',
											'value' => 'bcs_question_number'),					
				'Order'						=> array(
											'type'	=> 'field',
											'value' => 'q_order'),
				'Alpha'						=> array(
											'type'	=> 'field',
											'value' => 'alpha'),
				'Question'					=> array(
											'type'	=> 'field',
											'value' => 'text'),
				'Type'						=> array(
											'type' => 'field',
											'value' => 'type'),
				'Rule'						=> array(
											'type' => 'field',
											'value' => 'rule'),
				'cp?'						=> array(
											'type' => 'field',
											'value' => 'is_capital_planning'),
				'desc?'						=> array(
											'type'	=> 'field',
											'value' => 'show_description'),		
				'Action'					=> array(
											'type'	=> 'anchor',
											'value' => array('/admin/bcs/'.$heading . '/'. $profile . '/', 'slug','/edit', 'Edit')),
				);
			$this->data['table_settings'] = array(
				'table_heading'	=>	'BCS Questions',
				'table_sub_heading'	=>	'Questions for above profile.',
				'table_id' => 'profiles-table',
				'table_new_record_anchors' => array(
												array('/admin/bcs/'.$heading . '/' . $slug.'/new_question','New Question'),
											  ),
				);
				//Load the table view
				$this->_set_view_data('list_objects','ui/_layout_table_data');

		}

		$subView = 'admin/home_view';
		$mainView = 'ui/_layout_main';
		$this->load_structure($subView,$mainView);
	}

	protected function _render_heading($heading, $mode)
	{
		$slug = $heading;

		// First step - verify that heading slug exists!
		// List all secitons / select passed heading
		// List all profiles for passed heading / select passed profile
		// List all questions for passed profile / select passed question and put in edit/read mode.

		// Check the mode to ensure it's a good mode.  new/edit/read
		if ($this->_is_valid_mode($mode) == FALSE)
		{
			throw new Exception('Undefined method Admin BCS _render_heading() mode::' . $mode . '() called');
			return FALSE;
		}

		// If Edit / Read & Slug is missing then redirect cause there was an error
		if((!$mode == 'new') && (!$slug || empty($slug)))
		{
			throw new Exception('No header passed to the function Admin BCS _render_profile() mode::' . $mode . '() called');
			return FALSE;
		}


		$this->data['title'] = "BCS - " . ucwords($mode) . " heading: / ";

		// If Edit / Read get header & profiles else it is new so don' need to do it.
		if($mode == 'edit' || $mode == 'read')
		{
			// Get the current header
			$bcs_heading = $this->headings_model->get_bcs_heading($slug);
			// Get the current header's profiles
			$bcs_profiles = $this->headings_model->get_bcs_heading_profiles($slug);			
		}

		// If it is read then put all fields in read only mode.
		if($mode == 'read')  
		{ 
			// If it's read then don't need form validation
			$readonly = 'readonly'; 
		} 
		else  
		{
			$readonly = '';
			// If it's not read then set up the form validation.
			$this->form_validation->set_rules('heading_name', 'Heading Name', 'required');
			//$this->form_validation->set_rules('heading_slug', 'Heading Slug', 'required');
		} 

		// Check to see if we submitted the form.
		if (isset($_POST) && !empty($_POST))
		{
			if ($this->form_validation->run() === TRUE)
			{

				if ($mode == 'edit') {

					$hID = $this->headings_model->update_heading($slug,array('name'=>$this->input->post('heading_name')));

					if($hID)
					{
						$this->session->set_flashdata('message', 'Header Update Saved');
						redirect('admin/bcs');
					}
					else
					{
						$this->session->set_flashdata('message', $this->ion_auth->errors());
						redirect("admin/bcs/".$slug.'/edit', 'refresh');
					}	
				} else {

					
					$header_update = $this->headings_model->insert_heading(array('name'=>$this->input->post('heading_name')));
					$this->headings_model->reset_model();

					if($header_update)
					{
						$this->session->set_flashdata('message', 'Header Inserted');
						redirect("admin/bcs/", 'refresh');
					}
					else
					{
						$this->session->set_flashdata('message', $this->ion_auth->errors());
					}	
				}
				
				
			}
		}


		//set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		//$this->config->item('admin_group', 'ion_auth') === $group->name ? 'readonly' : '';
			
		// Gether information needed to load edit form
		$this->data['title'] = "BCS - " . ucwords($mode) . " " . strtoupper(str_replace("_", " ",$heading));
		$this->data['link_url']['new'] = 'admin/bcs/new_heading';
		$this->data['container_form_id'] = 'edit_heading'.$slug;
		$this->data['heading_title'] = ucwords($mode) . ' Heading.';
		$this->data['sub_heading_title']='complete fields below.';
		$this->data['submit_url'] = '';
		$this->data['form_id']=array('id'=>'form-edit-heading-'.$slug);
		// The field data
		$this->data['fields'][] = array(
									'type'	=>'text',
									'label' => 'Name',
									'id'    => 'heading_name',
									'icon'  => 'fa-home',
									'params'=>array(
												'name'  => 'heading_name',
												'id'    => 'heading_name',
												'type'  => 'text',
												'class' => 'gui-input',
												'value' => (($mode == 'new') ? $this->form_validation->set_value('heading_name') : $this->form_validation->set_value('heading_name',$bcs_heading->name)),
												$readonly => $readonly,
											   ),
								);
		$readonly = 'readonly';
		$this->data['fields'][] = array(
									'type'	=>'text',
									'label' => 'Slug',
									'id'    => 'heading_slug',
									'icon'  => 'fa-home',
									'params'=>array(
												'name'  => 'heading_slug',
												'id'    => 'heading_slug',
												'type'  => 'text',
												'class' => 'gui-input',
												'value' => (($mode == 'new') ? $this->form_validation->set_value('heading_slug') : $this->form_validation->set_value('heading_slug',$bcs_heading->slug)),
												$readonly => $readonly,
												'disabled' => "",
											   ),
								);
		//Load the update view
		$this->_set_view_data('edit_object','admin/crud/read_update');

		
		// if edit/read - load the profiles for this heading
		if($mode == 'edit' || $mode == 'read') {
					// Setup for loading the table at the bottom of the page.
			$this->data['javascripts']['end']['user_main']				= get_js('
	jQuery(document).ready(function() {

		"use strict";
		// Init DataTables
		$("#profiles-table").dataTable({
	      "sDom": \'t<"dt-panelfooter clearfix"ip>\',
	      "oTableTools": {
	        "sSwfPath": "vendor/plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf"
	      }
	    });

	});
																	  ',TRUE);
			
			//Start compiling the data for the table
			$this->data['table_row_data'] = $bcs_profiles;
			$this->data['table_header_data'] = array('BCS Q #', 'Name','Max Level','Question Count','Action');
			$this->data['table_row_data_fields'] = array(
				'BCS Q #'					=> array(
											'type'	=> 'field',
											'value' => 'bcs_question_number'),			
				'Name'					=> array(
											'type'	=> 'field',
											'value' => 'name'),
				'Max Level'				=> array(
											'type' => 'field',
											'value' => 'group_level'),
				'Question Count'		=> array(
											'type'	=> 'field',
											'value' => 'questions'),
				'Action'				=> array(
											'type'	=> 'anchor',
											'value' => array('/admin/bcs/'.$slug.'/', 'slug','/edit', 'Edit')),
				);
			$this->data['table_settings'] = array(
				'table_heading'	=>	'BCS Profiles',
				'table_sub_heading'	=>	'Profiles for above heading.',
				'table_id' => 'profiles-table',
				'table_new_record_anchors' => array(
												array('/admin/bcs/'.$slug.'/new_profile','New Profile'),
											  ),
				);
				//Load the table view
				$this->_set_view_data('list_objects','ui/_layout_table_data');

		}

		$subView = 'admin/home_view';
		$mainView = 'ui/_layout_main';
		$this->load_structure($subView,$mainView);	

	}


	protected function _is_valid_mode($mode)
	{
		$isValid = FALSE;
		$mode = trim(strtolower($mode));
		switch ($mode) {
			case 'edit':
			case 'new':
			case 'read':
				$isValid = TRUE;
				break;
			default:
				$isValid = FALSE;
				break;
		}
		return $isValid;
	}



}
?>