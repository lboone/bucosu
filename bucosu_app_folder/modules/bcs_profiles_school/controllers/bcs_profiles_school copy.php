<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php
class Bcs_profiles_school extends Authorized_Controller {

	public function __construct(){
		parent::__construct();

	/*
	 * -------------------------
	 * Load the model for the matching controller
	 * -------------------------
	 */
		$this->load->model('mdl_bcs_profiles_school');
	}

	public function index() 
	{
		$this->data['title'] = "";
		$subview = '';
		$mainview = "ui/_layout_main";
		$this->load_structure($subview,$mainview);
	}


	public function get_all($profile_id=NULL,$event_school_id=NULL){
		$p;
		$e;
		if (is_null($profile_id) || is_null($event_school_id)) {
			if ($_REQUEST['profile_id']) {
				$p = $this->input->post('profile_id',TRUE);
				$e = $this->input->post('event_school_id',TRUE);
			} else {
				echo json_encode(array('status'=>'error','message'=>'You must have a school and a profile selected!'));	
				return FALSE;
			}
		} else {
			$p = $this->security->xss_clean($profile_id);
			$e = $this->security->xss_clean($event_school_id);
		}

		$rslts = $this->mdl_bcs_profiles_school->get_by(array('profile_id'=>$p,'event_school_id'=>$e));

		if (!$rslts) {
			echo json_encode(array('status'=>'error','message'=>'No saved profiles yet!'));
			return false;
		}
		


		$this->data['table_row_data'] = $rslts;
		$this->data['table_header_data'] = array('Name', 'Location','Notes','Action');
		$this->data['table_row_data_fields'] = array(
			'Name'					=> array(
										'type'	=> 'field',
										'value' => 'name'),			
			'Location'					=> array(
										'type'	=> 'field',
										'value' => 'location'),
			'Notes'				=> array(
										'type' => 'field',
										'value' => 'notes'),
			'Action'				=> array(
										'type'	=> 'anchor',
										'value' => array('/admin/bcs/'.'value'.'/', 'id','/edit', 'Edit')),
			);
		$this->data['table_settings'] = array(
			'table_heading'	=>	'Saved Profiles',
			'table_sub_heading'	=>	'Saved Profiles For Above School District & School',
			'table_id' => 'saved-profiles-table',
			'table_new_record_anchors' => array(
											array('/admin/bcs/'.'new'.'/new_profile','New Profile'),
										  ),
		);				
		
		$this->load_view('ui/_layout_table_data');
		//$("#saved-profiles-table").dataTable();
	}

	public function new_form($profile_id=NULL,$event_school_id = NULL)
	{
		if (is_null($profile_id)) {
			return NULL;
		}

		$this->data['profile_id'] = $this->security->xss_clean($profile_id);
		$this->data['event_school_id'] = $this->security->xss_clean($event_school_id);
		$this->data['form_status'] = 'new';
		
		$this->data['foot'] = get_js('assets/js/bcs/event/profiles_school_form.js');

		echo $this->load_view('new_profiles_school',NULL,TRUE);
	}



	public function save_form()
	{

		if( $_REQUEST['name'])
		{

			$data = array(
				'name'				=> $this->input->post('name',TRUE),
				'location'			=> $this->input->post('location',TRUE),
				'event_school_id'	=> $this->input->post('event_school_id',TRUE),
				'profile_id'		=> $this->input->post('profile_id',TRUE),
				'notes'				=> $this->input->post('notes',TRUE),
				);
			$id = $this->mdl_bcs_profiles_school->save($data);

			if ($id) {
				echo json_encode(array('status'=>'success','id'=>$id));	
			} else {
				echo json_encode(array('status'=>'error','message'=>'Could not save the new profile, please try again!'));
			}
			
		} else {
			echo json_encode(array('status'=>'error','message'=>'Could not save the new profile, please try again!'));
		}
		// capture button event - '#new_profile_school_save_button';
		// after success, change form_status hidden field to 'saved';

	}


	public function load_form()
	{
		$this->data['form_status'] = 'edit';
	}


}
