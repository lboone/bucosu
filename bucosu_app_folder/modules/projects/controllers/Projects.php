<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php
class Projects extends Authorized_Controller {
	
	protected $_the_model;
	
	public function __construct(){
		parent::__construct();

	/*
	 * -------------------------
	 * Load the model for the matching controller
	 * -------------------------
	 */
		$this->load->model('mdl_projects');
		$this->_the_model = $this->mdl_projects;

		$this->data['active_tab'] = array('new_project'=>'','view_projects'=>'','view_project'=>'class="hidden"','project_reports'=>'','project_report'=>'class="hidden"');		
		$this->data['tab_content_hidden'] = array('new_project'=>'hidden','view_projects'=>'hidden','view_project'=>'hidden','project_reports'=>'hidden','project_report'=>'hidden');

	}
	
	public function index() 
	{
		$this->data['stylesheets']['top']['my_style'] = get_css('
			.wrapper         {width:70%;height:100%;margin:0 auto;background:#CCC}
			.h_iframe        {position:relative;}
			.h_iframe .ratio {display:block;width:100%;height:auto;}
			.h_iframe iframe {position:absolute;top:0;left:0;width:100%; height:100%;}
		',true);
		$this->data['title'] = "Projects";
		$subview = 'coming_soon';
		$mainview = "ui/_layout_main";
		$this->load_structure($subview,$mainview);
	}

	public function new_project(){
	/* 
	 * -------------------------
	 * Use this if you want to restrict the page by a certain level of admin!
	 * ------------
	 */
		$this->data['title'] = "New Project";
		$this->data['active_tab']['new_project']='class="active"';
		$this->data['tab_content_hidden']['new_project']='';

		$this->data['container_div'] = 'new_project_container';
		$this->data['view_edit_project'] = 'hidden';
		$this->data['new_project_form'] = $this->load_view('tab_content/new_project_form',NULL,true);
		$this->_load_content();
	}

	public function view_projects(){
		$this->data['title'] = "View Projects";
		$this->data['active_tab']['view_projects']='class="active"';
		$this->data['tab_content_hidden']['view_projects']='';

		$this->data['view_edit_project'] = 'hidden';
		$this->data['container_div'] = 'view_projects_container';
		$psn = $this->session->userdata('project_school_district_name');
		if ($psn) {
			$this->data['project_school_district_name']= $psn;
		}
		$psd = $this->session->userdata('project_school_district');

		$rslt = $this->view_projects_body($psd);

		if($rslt['success'])
		{
			$this->data['view_projects_body'] = $rslt['msg'];
		} else {
			$msg = '<div id="new_project_message_alert2"><div class="alert alert-border-left alert-danger alert-dismissable" ><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="fa fa-exclamation-triangle pr10"></i><strong>VIEW PROJECTS: </strong>' . $rslt['msg'] . '</div></div>';
			$this->data['view_projects_body'] = $msg;
		}

		$this->_load_content();		
	}
	public function view_project($id=null){

		$this->data['title'] = "View/Edit Project";
		$this->data['active_tab']['view_project']='class="active"';
		$this->data['tab_content_hidden']['view_project']='';		
		$this->data['view_edit_project'] = '';
		$this->data['container_div'] = 'view_projects_container';

		if (!$id) {	
			$id = $this->input->post_get('id',TRUE);
		} 
		if (!$id) {
			$this->data ['project_object'] = null;
		} else {
			$proj = $this->_the_model->get($id);
		
			if ($proj) {

				$this->load->model('project_purposes/mdl_project_purposes');
				$this->load->model('project_statuses/mdl_project_statuses');
				$this->load->model('project_types/mdl_project_types');
				$this->data['project_data'] = array(
					'project_object' 			=> $proj,
					'project_purposes'			=> $this->mdl_project_purposes->get(),
					'project_statuses'			=> $this->mdl_project_statuses->get(),
					'project_types' 			=> $this->mdl_project_types->get(),
					'school_districts_schools' 	=> $this->session->userdata('school_districts_schools'),
					'project_school_district' 	=> $this->session->userdata('project_school_district'),
					'project_school'			=> $this->session->userdata('project_school'),
				);
			} else {
				$this->data ['project_object'] = null;
			}
		}
		$this->_load_content();
	}

	public function project_reports(){
		
		$this->data['title'] = "Project Reports";
		$this->data['active_tab']['project_reports']='class="active"';
		$this->data['tab_content_hidden']['project_reports']='';
		$this->data['container_div'] = 'project_reports_container';
		$this->data['view_edit_project'] = 'hidden';
		$this->_load_content();
	}

	public function project_report($rpt = null){
		$this->data['title'] = "Project Report";
		$this->data['active_tab']['project_report']='class="active"';
		$this->data['tab_content_hidden']['project_report']='';
		$this->data['container_div'] = 'project_reports_container';
		$this->data['view_edit_project'] = 'hidden';

		

		if (!$rpt) {	
			$rpt = $this->input->post_get('rpt',TRUE);
		} 

		if (!$rpt) {
			$this->data ['report_object'] = null;
		} else {

			switch ($rpt) {
				case 'building_estimate':
					$params = array('event_school_id'=>$this->session->userdata('project_school'));
					# code...
					break;
				case 'district_summary':
					$params = array('event_school_district_id'=>$this->session->userdata('project_school_district'));
					break;
				
				default:
					break;
			}

			$projs = $this->_the_model->get_by($params);
			if ($projs) {

				$this->data['report_data'] = array(
					'report_name'					=> $rpt,
					'report_object' 				=> $projs,
					'project_school_district' 		=> $this->session->userdata('project_school_district'),
					'project_school_district_name'	=> $this->session->userdata('project_school_district_name'),
					'project_school'				=> $this->session->userdata('project_school'),
					'project_school_name'			=> $this->session->userdata('project_school_name'),
				);
			} else {
				$this->data ['report_object'] = null;
			}
		}
		$this->_load_content();

	}
	private function _load_content(){
		if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin(false,2)) )
		{
			$this->_show_401();
		}
		$this->data['stylesheets']['top']['css_file_compressed']	= get_css('assets/css/project/project.compressed.css');
		$this->data['stylesheets']['top']['css_file']				= get_css('assets/css/project/project.css');
		$this->data['javascripts']['end']['js_file_compressed']		= get_js('assets/js/project/project.compressed.js');
		$this->data['javascripts']['end']['js_file']	 			= get_js('assets/js/project/project.js');

		$this->data['body_class'] = 'blank-page sb-l-m sb-r-c onload-check';

		$this->data['tab_content'] = array(
										'new_project'		=>$this->load_view('tab_content/new_project',NULL,true),
										'view_projects' 	=>$this->load_view('tab_content/view_projects',NULL,true),
										'view_project' 		=>$this->load_view('tab_content/view_project',NULL,true),
										'project_reports' 	=>$this->load_view('tab_content/project_reports',NULL,true),
										'project_report' 	=>$this->load_view('tab_content/project_report',NULL,true),
									);
		$subview = 'projects';
		$mainview = "ui/_layout_main";
		$this->load_structure($subview,$mainview);
	}

	public function project_defaults(){
		$success = false;
		$msg = "Oops, you don't have any school districts or schools!";

		$sds 	= $this->session->userdata('school_districts_schools');
		$sd 	= $this->session->userdata('project_school_district');
		$s 		= $this->session->userdata('project_school');

		if ($sds) {
			$success = true;
			$msg = $sds;
		}

		if ($sd){
			$defaults = array('sd'=>$sd,'s'=>$s);
		} else {
			$defaults = NULL;
		}

		return array('success'=>$success,'msg'=>$msg,'defaults'=>$defaults);
	}

	public function project_defaults_json(){
		echo json_encode($this->project_defaults());
	}

	public function project_heading_defaults(){
		$success = false;
		$msg = "Oops, there was a problem loading the BCS Headings & Profiles!";

		$hp 	= $this->session->userdata('bcs_headings_profiles');
		$h 		= $this->session->userdata('project_bcs_heading');
		$p 		= $this->session->userdata('project_bcs_profile');

		if ($hp) {
			$success = true;
			$msg = $hp;
		}

		if ($h){
			$defaults = array('h'=>$h,'p'=>$p);
		} else {
			$defaults = NULL;
		}

		return array('success'=>$success,'msg'=>$msg,'defaults'=>$defaults);
	}

	public function project_heading_defaults_json(){
		echo json_encode($this->project_heading_defaults());
	}


	public function save_new_project(){
		$data = $this->input->post(NULL,true);

		if (!isset($data['is_bcs_project'])) {
			echo json_encode(array('success'=>false,'msg'=>'Oops, something went wrong with your form!'));
			return;
		}

		// set up general rules.
		$this->form_validation->set_rules('event_school_district_id','School District','required',array('required'=>'You have to select a School District to create a Project!'));
		$this->form_validation->set_rules('item_description','Item Description','required',array('required'=>'You have to provide an Item Description to create a Project!'));
		$this->form_validation->set_rules('cost','Cost','required|is_natural_no_zero',array('required'=>'You have to provide the Cost to create a Project!','is_natural_no_zero'=>'A project has to have a dollar amount greater than 0!'));
		
		// BCS Project Specific Validations
		if(intval($data['is_bcs_project']) == 1){
			$this->form_validation->set_rules('event_school_id','School','required',array('required'=>'You have to select a School to create a BCS Project!'));
			$this->form_validation->set_rules('associated_profiles','Project Profiles','required',array('required'=>'You have to select at least 1 Project Profile to create a BCS Project!'));
			$this->form_validation->set_rules('year_to_complete','Year To Complete','required|is_natural_no_zero',array('required'=>'You have to provide the Year To Complete to create a BCS Project!','is_natural_no_zero'=>'Year To Complete has to be at least 1 year.'));
			$this->form_validation->set_rules('priority','Priority','required|is_natural',array('required'=>'You have to provide a Priority to create a BCS Project!','is_natural'=>'You have to provide a valid Priority.'));
			$this->form_validation->set_rules('bcs_question_number','BCS Question Number','required|is_natural_no_zero',array('required'=>'You have to provide the BCS Question Number to create a BCS Project!','is_natural_no_zero'=>'You have to provide a valid BCS Question Number.'));
			$this->form_validation->set_rules('purpose_id','Purpose','required',array('required'=>'You have to select a Project Purpose to create a BCS Project!'));
			$this->form_validation->set_rules('type_id','Type','required',array('required'=>'You have to select a Project Type to create a BCS Project!'));
		}
 		
 		// If the form does not pass validation return the errors back to the ajax call
 		if ($this->form_validation->run() == FALSE)
        {
			echo json_encode(array('success'=>false,'msg'=>validation_errors('<div class="alert alert-danger alert-dismissable temp_project_message"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="fa fa-warning pr10"></i><strong>ERROR! - </strong>','</div>')));
			return;
		}

		$profs = explode(',',$data['associated_profiles']);
		unset($data['associated_profiles']);
		unset($data['csrf_bcs_token_name']);

		$id = $this->_the_model->save($data);

		// If it's a bcs project create the project-profiles documents for each profile selected.
		if ($id  && intval($data['is_bcs_project'])==1 ) {
			$this->load->model('projects_profiles_schools/mdl_projects_profiles_schools');
			
			$str = '';

			foreach ($profs as $val) {
				$params = array('profiles_school_id'=>$val,'project_id'=>$id);
				$this->mdl_projects_profiles_schools->save($params);
			}
			$this->session->set_flashdata('new_project_message', 'Your Project Was Saved Successfully!');
			echo json_encode(array('success'=>true,'msg'=>'Your Project Was Saved Successfully!'));

		} else if (!$id) {

			echo json_encode(array('success'=>false,'msg'=>'Error saving the Project, please try again!'));

		} else {
			echo json_encode(array('success'=>true,'msg'=>'Your Project Was Saved Successfully'));
		}
	}

	public function update_project(){
		$data = $this->input->post(NULL,true);

		if (!isset($data['id'])) {
			echo json_encode(array('success'=>false,'msg'=>'<div class="alert alert-danger alert-dismissable temp_project_message"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="fa fa-warning pr10"></i><strong>ERROR! - Oops, something went wrong with your form!</strong></div>'));
			return;
		}


		if (isset($data['item_description'])) {
			$this->form_validation->set_rules('item_description','Item Description','required',array('required'=>'You have to provide an Item Description to update a Project!'));	
		}
		if (isset($data['cost'])) {
			$this->form_validation->set_rules('cost','Cost','required|is_natural_no_zero',array('required'=>'You have to provide the Cost to update a Project!','is_natural_no_zero'=>'A project has to have a dollar amount greater than 0!'));
		}
		if (isset($data['status_id'])) {
			$this->form_validation->set_rules('status_id','Status','required',array('required'=>'You have to provide a status to update a Project!'));	
		}

		// BCS Project Specific Validations
		if(intval($data['is_bcs_project']) == 1){

			if (isset($data['year_to_complete'])) {
				$this->form_validation->set_rules('year_to_complete','Year To Complete','required|is_natural_no_zero',array('required'=>'You have to provide the Year To Complete to update a BCS Project!','is_natural_no_zero'=>'Year To Complete has to be at least 1 year.'));
			}
			if (isset($data['priority'])) {
				$this->form_validation->set_rules('priority','Priority','required|is_natural',array('required'=>'You have to provide a Priority to update a BCS Project!','is_natural'=>'You have to provide a valid Priority.'));
			}
			if (isset($data['bcs_question_number'])) {
				$this->form_validation->set_rules('bcs_question_number','BCS Question Number','required|is_natural_no_zero',array('required'=>'You have to provide the BCS Question Number to update a BCS Project!','is_natural_no_zero'=>'You have to provide a valid BCS Question Number.'));
			}
			if (isset($data['purpose_id'])) {
				$this->form_validation->set_rules('purpose_id','Purpose','required',array('required'=>'You have to select a Project Purpose to update a BCS Project!'));
			}
			if (isset($data['type_id'])) {
				$this->form_validation->set_rules('type_id','Type','required',array('required'=>'You have to select a Project Type to update a BCS Project!'));
			}
		}
 		
 		// If the form does not pass validation return the errors back to the ajax call
 		if ($this->form_validation->run() == FALSE)
        {
			echo json_encode(array('success'=>false,'msg'=>validation_errors('<div class="alert alert-danger alert-dismissable temp_project_message"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="fa fa-warning pr10"></i><strong>ERROR! - </strong>','</div>')));
			return;
		}

		if (isset($data['status_id'])) {
			$stid=$data['status_id'];

			$now = date('Y-m-d H:i:s');
			$uData = $this->session->userdata('user_id');
			switch ($stid) {
				case '2':
					$data['started'] = $now;
					$data['started_by'] = $uData;
					break;
				case '3':
					$data['completed'] = $now;
					$data['completed_by'] = $uData;
					break;
				case '4':
					$data['cancelled'] = $now;
					$data['cancelled_by'] = $uData;
					break;
				default:
					break;
			}
		}

		$id = $data['id'];
		unset($data['id']);
		unset($data['is_bcs_project']);
		unset($data['csrf_bcs_token_name']);

		$id = $this->_the_model->save($data,$id);

		// If it's a bcs project create the project-profiles documents for each profile selected.
		if ($id) {
			echo json_encode(array('success'=>true,'msg'=>'<div class="alert alert-success alert-dismissable temp_project_message"><button type="button" class="close" data-dismiss="success" aria-hidden="true">×</button><i class="fa fa-check pr10"></i><strong>SUCCESS! - Your Project Was Updated Successfully!</strong></div>'));

		} else if (!$id) {

			echo json_encode(array('success'=>false,'msg'=>'<div class="alert alert-danger alert-dismissable temp_project_message"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="fa fa-warning pr10"></i><strong>ERROR! - Updating the Project, please try again</strong></div>'));

		} else {
			echo json_encode(array('success'=>true,'msg'=>'<div class="alert alert-success alert-dismissable temp_project_message"><button type="button" class="close" data-dismiss="success" aria-hidden="true">×</button><i class="fa fa-check pr10"></i><strong>SUCCESS! - Your Project Was Updated Successfully!</strong></div>'));
		}
	}

	public function delete_project(){
		$data = $this->input->post(NULL,true);

		if (!isset($data['id'])) {
			echo json_encode(array('success'=>false,'msg'=>'<div class="alert alert-danger alert-dismissable temp_project_message"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="fa fa-warning pr10"></i><strong>ERROR! - Oops, something went wrong with deleting that project!</strong></div>'));
			return;
		}

		if ($this->_the_model->delete($data['id'])) {
			echo json_encode(array('success'=>true,'msg'=>'<div class="alert alert-success alert-dismissable temp_project_message"><button type="button" class="close" data-dismiss="success" aria-hidden="true">×</button><i class="fa fa-check pr10"></i><strong>SUCCESS! - Your Project Was Deleted Successfully!</strong></div>'));
		} else {
			echo json_encode(array('success'=>false,'msg'=>'<div class="alert alert-danger alert-dismissable temp_project_message"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="fa fa-warning pr10"></i><strong>ERROR! - Deleting the Project, please try again</strong></div>'));
		}
	}

	public function view_projects_body($sd_id=null,$s_id=null){
		$sd = $this->input->post_get('sd_id');
		if (isset($sd) ) {
			$s = $this->input->post_get('s_id');
			if (isset($s)) {
				$params = array('event_school_district_id'=>$sd,'event_school_id'=>$s);
			} else {
				$params = array('event_school_district_id'=>$sd);
			}

		} elseif (isset($sd_id)) {
			if (isset($s_id)) {
				$params = array('event_school_district_id'=>$sd_id,'event_school_id'=>$s_id);
			} else {
				$params = array('event_school_district_id'=>$sd_id);
			}

		} else {
			return array('success'=>false,'msg'=>'Error, no school district provided!');	
		}
			
			$this->_the_model->set_table('v_projects_bcs');
			$rslts = $this->_the_model->get_by($params);
			if ($rslts) {
				$this->data['project_data'] = $rslts;
				return array('success'=>true,'msg'=>$this->load_view('tab_content/view_projects_body',NULL,true));
			} else {
				return array('success'=>false,'msg'=>'Oops, there are no projects yet.!');
			}

	}

	public function view_projects_body_json($sd_id=null,$s_id=null){
		echo json_encode($this->view_projects_body($sd_id,$s_id));
	}

}
