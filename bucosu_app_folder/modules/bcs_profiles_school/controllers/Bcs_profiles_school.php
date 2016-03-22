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

		$this->data['foot'] = get_js("

  jQuery(document).ready(function() {

  	$('#location').select2({
	  tags: true,
	  tokenSeparators: [',', ';']
	});

  });
			",TRUE);		
	}

	public function index() 
	{
		$this->data['title'] = "";
		$subview = '';
		$mainview = "ui/_layout_main";
		$this->load_structure($subview,$mainview);
	}

	public function get($profile_id=NULL)
	{
		if (is_null($profile_id)) {
			return false;
		}

		return $this->mdl_bcs_profiles_school->get($profile_id,TRUE);
	}

	public function get_all_school_profiles_array($event_school_id=NULL){
		$e;
		if (is_null($event_school_id)) {
			if ($_REQUEST['event_school_id']) {
				$e = $this->input->post('event_school_id',TRUE);
			} else {
				return array('status'=>'error','message'=>'You must have a profile selected!');	
			}
		} else {
			$e = $this->security->xss_clean($event_school_id);
		}
		$this->mdl_bcs_profiles_school->set_order_by('profile_id');
		$rslts = $this->mdl_bcs_profiles_school->get_by(array('event_school_id'=>$e));
		$this->mdl_bcs_profiles_school->set_order_by('id');
		if (!$rslts) {
			return array('status'=>'error','message'=>'No saved profiles yet!');
			
		}
		return $rslts;
	}

	public function get_all_data_json(){
		$p = $this->input->get('p_id',TRUE);
		$e = $this->input->get('e_id',TRUE);

		$rslts = $this->mdl_bcs_profiles_school->get_by(array('profile_id'=>$p,'event_school_id'=>$e));
		if (!$rslts) {
			echo json_encode(array('success'=>false,'msg'=>'No saved profiles yet!'));
		} else {
			echo json_encode(array('success'=>true,'msg'=>$rslts));
		}
	}

	public function get_all_data_for_project(){
		$p = $this->input->get('p_id',TRUE);
		$e = $this->input->get('e_id',TRUE);
		$jsonData = array();
		$rslts = $this->mdl_bcs_profiles_school->get_by(array('profile_id'=>$p,'event_school_id'=>$e));
		if (!$rslts) {
			return array('success'=>false,'msg'=>'No saved profiles yet!');
		} else {
			$this->load->module('bcs_questions_school');
			$this->load->module('bcs_profiles_school_images');
			$this->load->module('projects_profiles_schools');
			foreach ($rslts as $key => $value) {
				$qResults = $this->bcs_questions_school->get_question_school_results_for_project($value->id);
				$qForm = $this->bcs_questions_school->edit_form_for_project($value->id);
				$qImages = $this->bcs_profiles_school_images->get_all_images_by_profile_school_id($value->id);
				$pProjects = $this->projects_profiles_schools->get_all_projects_by_profile_school_id($value->id);
				$jsonData[$value->id] = array(
						'school_profile'=>$value,
						'question_results'=>$qResults,
						'question_form'=>$qForm,
						'profile_images'=>$qImages,
						'profile_projects'=>$pProjects,
					);
			}
			return array('success'=>true,'msg'=>$jsonData);
		}
	}

	public function get_all_data_for_project_json(){
		echo json_encode($this->get_all_data_for_project());
	}

	// Used to pull all of the profiles for a given school event into the "Saved" tab.
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
		
		// set-up the data for the table.
		$this->data['table_row_data'] = $rslts;
		$this->data['table_header_data'] = array('Name', 'Location(s)','Notes','Edit','Delete');
		$this->data['table_row_data_fields'] = array(
			'Name'					=> array(
										'type'	=> 'field',
										'value' => 'name'),			
			'Location(s)'					=> array(
										'type'	=> 'unserialize',
										'value' => 'location'),
			'Notes'				=> array(
										'type' => 'field',
										'value' => 'notes'),
			'Edit'				=> array(
										'type'	=> 'anchor',
										'value' => array('?id=', 'id','', 'Edit',array('class'=>'saved_profile_edit_button button btn-system'))
										),
			'Delete'				=> array(
										'type'	=> 'anchor',
										'value' => array('?id=', 'id','', 'Delete',array('class'=>'saved_profile_delete_button button btn-danger'))
										),

			);
		$this->data['table_settings'] = array(
			'table_heading'	=>	'Saved Profiles',
			'table_sub_heading'	=>	'Saved Profiles For Above School District & School',
			'table_id' => 'saved-profiles-table',
			'table_new_record_anchors' => array(
											array('/bcs_profiles_school/new_form/' . $p . '/' . $e . '/','New Profile',array('id'=>'profile_school_get_all_new_profile','class'=>'button btn-system')),
										  ),
		);				
		
		$viewData = $this->load_view('ui/_layout_table_data',NULL,TRUE);
		echo json_encode(array('status'=>'success','data'=>$viewData));
	}

	public function new_form($profile_id=NULL,$event_school_id = NULL)
	{
		if (is_null($profile_id)) {
			return NULL;
		}
		$p = $this->security->xss_clean($profile_id);
		$e = $this->security->xss_clean($event_school_id);
		$this->data['profile_id'] = $p;
		$this->data['event_school_id'] = $e;
		$this->data['form_status'] = 'new';


		$this->data['data_state_tab_2'] = 'data-state="update"';
		$this->data['data_state_tab_3'] = 'data-state="read"';
		$this->data['locations'] = $this->locations('dropdown');

		$this->_set_saved_profile_tab_count($p,$e);

		$viewData = $this->load_view('new_profiles_school',NULL,TRUE);

		echo json_encode(array('status'=>'success','data'=>$viewData));
	}

	private function _get_all_count($profile_id=NULL,$event_school_id = NULL)
	{
		if (is_null($profile_id) || is_null($event_school_id)) {
			return 0;
		}
		$rslts = $this->mdl_bcs_profiles_school->get_by(array('profile_id'=>$profile_id,'event_school_id'=>$event_school_id));
		return count($rslts);

	}

	private function _set_saved_profile_tab_count($p=NULL,$e=NULL){
		$cnt = $this->_get_all_count($p,$e);
		if ( $cnt > 0) {
			$this->data['tab_icon'] = '<span class="badge badge-rounded badge-alert lighter">' . $cnt . '</span>';
		} else {
			$this->data['tab_icon'] = '<span class="badge badge-rounded badge lighter">0</span>';
		}
	}

	public function edit_form($id=NULL){
		if (!$id) {
			echo json_encode(array('status'=>'error','message'=>'Could not load the saved profile!'));
			return false;
		}

		$row = $this->mdl_bcs_profiles_school->get($id,TRUE);
		if (!$row) {
			echo json_encode(array('status'=>'error','message'=>'Could not load the saved profile!'));
			return false;
		}

		$name = $row->name;
		$location = unserialize($row->location);
		$notes = $row->notes;
		$esi = $row->event_school_id;
		$pid = $row->profile_id;
		$fa = $row->facilities_alert;
		$fad = $row->facilities_alert_description;
				
		$this->data['name_value'] 		= $name;
		$this->data['location_value'] 	= $location;
		$this->data['notes_value']		= $notes;
		$this->data['profile_id'] 		= $pid;
		$this->data['event_school_id'] 	= $esi;
		$this->data['facilities_alert']	= $fa;
		$this->data['facilities_alert_description']	= $fad;		
		$this->data['form_status'] 		= 'saved';
		$this->data['id'] = $id;
		$this->data['locations'] = $this->locations('dropdown');

		//$this->data['image_view'] = $this->load_view('bcs_profiles_school_images/bcs_profiles_school_images',NULL,TRUE);
		$this->data['data_state_tab_2'] = 'data-state="update"';
		$this->data['data_state_tab_3'] = 'data-state="update"';

		$this->_set_saved_profile_tab_count($pid,$esi);

		$viewData = $this->load_view('new_profiles_school',NULL,TRUE);
		echo json_encode(array('status'=>'success','data'=>$viewData));

	}
	public function save_form()
	{

		if( $_REQUEST['name'])
		{

			$name = $this->input->post('name',TRUE);
			$location = $this->input->post('location',TRUE);
			$notes = $this->input->post('notes',TRUE);
			$esi = $this->input->post('event_school_id',TRUE);
			$pid = $this->input->post('profile_id',TRUE);
			$fa = $this->input->post('facilities_alert',TRUE);
			$fad = $this->input->post('facilities_alert_description',TRUE);
			
			$data = array(
				'name'				=> $name,
				'location'			=> serialize(array_filter($location)),
				'event_school_id'	=> $esi,
				'profile_id'		=> $pid,
				'notes'				=> $notes,
				'facilities_alert'	=> $fa,
				'facilities_alert_description' => $fad,
				);

			if ($this->input->post('id',TRUE)) {
				$id = $this->input->post('id',TRUE);
				$this->data['data_state_tab_3'] = 'data-state="update"';
			} else {
				$id = NULL;
				$this->data['data_state_tab_3'] = 'data-state="read"';
			}
			$id = $this->mdl_bcs_profiles_school->save($data,$id);

			if ($id) {
				
				$this->data['name_value'] 		= $name;
				$this->data['location_value'] 	= $location;
				$this->data['notes_value']		= $notes;
				$this->data['profile_id'] 		= $pid;
				$this->data['event_school_id'] 	= $esi;
				$this->data['facilities_alert']	= $fa;
				$this->data['facilities_alert_description']	= $fad;		
				$this->data['form_status'] 		= 'saved';
				$this->data['id'] = $id;

				$this->data['locations'] = $this->locations('dropdown');

				//$this->data['image_view'] = $this->load_view('bcs_profiles_school_images/bcs_profiles_school_images',NULL,TRUE);
				$this->data['data_state_tab_2'] = 'data-state="update"';

				$this->_set_saved_profile_tab_count($pid,$esi);
				
				$viewData = $this->load_view('new_profiles_school',NULL,TRUE);
				echo json_encode(array('status'=>'success','data'=>$viewData,'id'=>$id));

			} else {
				echo json_encode(array('status'=>'error','message'=>'Could not save the new profile, please try again!'));
			}
			
		} else {
			echo json_encode(array('status'=>'error','message'=>'Could not save the new profile, please try again!'));
		}
		// capture button event - '#new_profile_school_save_button';
		// after success, change form_status hidden field to 'saved';

	}

	public function delete_form($id=NULL)
	{

		if (!$id) {
			echo json_encode(array('status'=>'error','message'=>'Could not delete the profile!'));
			return false;
		}

		$frm = $this->mdl_bcs_profiles_school->get($id,TRUE);

		if (!$frm)
		{
			echo json_encode(array('status'=>'error','message'=>'Could not delete the profile!'));
			return false;
		}



		if (intval($this->session->userdata('user_group_level')) > 2)  {
			$u = intval($this->session->userdata('user_id'));
			$i = intval($frm->created_by);
			if ($u != $i) {
				echo json_encode(array('status'=>'error','message'=>'Sorry, you are not authorized to delete this profile!'));
				return false;
			}
		}

		$e = $frm->event_school_id;
		$p = $frm->profile_id;

		// Delete the questions results first
		$this->load->model('bcs_questions_school/mdl_bcs_questions_school');
		$where = array('profile_school_id'=>$id);
		$this->mdl_bcs_questions_school->delete_by($where);


		// Delete the images next
		$this->load->model('bcs_profiles_school_images/mdl_bcs_profiles_school_images');
		$where = array('profile_school_id'=>$id);		
		if ($this->mdl_bcs_profiles_school_images->delete_by($where)) {
			delete_folder_from_server(get_profiles_school_images_location($id)['path']);
		}

		// Delete the profile last
		$this->mdl_bcs_profiles_school->delete($id);
		$this->new_form($p,$e);


	}

	public function locations($type='json'){
		$rslt = $this->mdl_bcs_profiles_school->locations()->result();
		$locs = array();
		foreach ($rslt as $key => $value) {
			$val = unserialize($value->location);
			if (is_array($val)) {
				$locs = array_merge($locs,$val);
			} else {
				$locs = array_merge($locs,array($val));
			}
		}

		asort($locs);
		if ($type =='json') {
			if (count($locs)>0) {
				echo json_encode(array('status'=>'success','data'=>$locs));
			} else {
				echo json_encode(array('status'=>'error','error'=>$this->db->error()));
			}
		} elseif ($type == 'dropdown') {
			$dropdowns = array();
			foreach ($locs as $value) {
				$loc = $value;
				$dropdowns[$loc]=$loc;	
			}
			return $dropdowns;
		} elseif ($type == 'objects') {
			return $rslt;
		} else {
			return $locs;
		}
	}


	private function _get_saved_profiles_count($profile_id=NULL,$event_school_id=NULL)
	{
		$p = $this->security->xss_clean($profile_id);
		$e = $this->security->xss_clean($event_school_id);

		$rslts = $this->mdl_bcs_profiles_school->get_by(array('profile_id'=>$p,'event_school_id'=>$e));
		if ($rslts) {
			return count($rslts);
		} else {
			return 0;
		}

		
	}

	public function load_form()
	{
		$this->data['form_status'] = 'edit';
	}


}
