<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php
class Project_purposes extends Authorized_Controller {
	protected $_the_model = NULL;

	public function __construct(){
		parent::__construct();

	/*
	 * -------------------------
	 * Load the model for the matching controller
	 * -------------------------
	 */
		$this->load->model('mdl_project_purposes');
		$this->_the_model = $this->mdl_project_purposes;
	}

	public function index() 
	{

	/* 
	 * -------------------------
	 * Use this if you want to restrict the page by a certain level of admin!
	 * ------------
	 */

		 if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin(false,1)) )
		 {
		 	$this->_show_401();
		 }


		// $u_id    = intval($this->ion_auth->get_user_id());
		// $u_type = intval($this->ion_auth->get_users_groups($u_id)->row()->type);
		// if ($u_type > 2) {
		// 	$this->_show_401();
		// }

		$this->data['stylesheets']['top']['project_purpose_compressed'] = get_css('assets/css/project/purpose/project.purpose.compressed.css');
		$this->data['stylesheets']['top']['datatables_plugin']			= get_css('assets/css/project/purpose/project.purpose.css');

		$this->data['javascripts']['end']['project_purpose_compressed']	= get_js('assets/js/project/purpose/project.purpose.compressed.js');
		$this->data['javascripts']['end']['project_purpose'] 			= get_js('assets/js/project/purpose/project.purpose.js');

		$this->data['title'] = "Project Purposes";
		$this->data['project_purposes_table'] = $this->_get_project_purposes_table("true","false");

		$subview = "project_purposes_table";
		$mainview = "ui/_layout_main";
		$this->load_structure($subview,$mainview);
	}

	public function add_project_purpose(){
		if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin(false,1)) )
		{
			$this->_show_401();
		}

		$val = $this->input->get('new_project_purpose');
		
		if ($this->_the_model->get_by(array('project_purpose'=>$val),true)) {
			echo json_encode(array('success'=>false,'msg'=>'That value already exists, please try a different value.'));
			return false;
		}
		

		if ($val) {
			$id = $this->_the_model->save(array('project_purpose'=>$val));
			if ($id) {
				echo json_encode(array('success'=>true,'msg'=>$id));
				return true;
			} else {
				echo json_encode(array('success'=>false,'msg'=>$this->db->_error_message()));
				return false;
			}
		} else {
			echo json_encode(array('success'=>false,'msg'=>'You have to provide a valid value!'));
		}
	}

	public function delete_project_purpose(){

		if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin(false,1)) )
		{
			$this->_show_401();
		}

		$id = $this->input->get('project_purpose_id');

		if ($id) {
			if ($this->_the_model->delete($id)) {
				echo json_encode(array('success'=>true,'msg'=>'Project Purpose Deleted!'));
				return true;
			} else {
				echo json_encode(array('success'=>false,'msg'=>$this->db->_error_message()));
				return false;
			}
		} else {
			echo json_encode(array('success'=>false,'msg'=>'You have to provide a valid project purpose to delete!'));
		}

	}

	public function update_project_purpose($echo=true){
		if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin(false,1)) )
		{
			$this->_show_401();
		}


		$pk = $this->input->post('pk');
		$name = $this->input->post('name');
		$value = $this->input->post('value');

		$vals = stringify_attributes(array('pk'=>$pk,'name'=>$name,'value'=>$value));
		if ($pk && $name && $value) {
			$params = array($name=>$value);
			if($this->_the_model->save($params,$pk)){
				if ($echo) {
					echo json_encode(array('success'=>true,'msg'=>'The purpose has been changed.'));
					return true;
				} else {
					return json_encode(array('success'=>true,'msg'=>'The purpose has been changed.'));		
				}	
			} else {
				if ($echo) {
					echo json_encode(array('success'=>false,'msg'=>'There was an error saving the purpose: ' . $this->db->_error_message() . '.  Please try again!'));
					return false;
				} else {
					return json_encode(array('success'=>false,'msg'=>'There was an error saving the purpose: ' . $this->db->_error_message() . '.  Please try again!'));
				}				
			}
		}
		if ($echo) {
			echo json_encode(array('success'=>false,'msg'=>'There was an error updating the purpose: ' . $vals . '.  Please try again!'));
			return false;
		} else {
			return json_encode(array('success'=>false,'msg'=>'There was an error updating the purpose: ' . $vals . '.  Please try again!'));
		}
	}

	private function _get_project_purposes_table($ret="false",$json="false"){
		$return = NULL;
		$rslts = $this->_the_model->get();
		
		if ($rslts) {
			$this->data['table_row_data'] = $rslts;
			$this->data['table_header_data'] = array('Purposes', 'Delete');
			$this->data['table_row_data_fields'] = array(
				'Purposes'					=> array(
											'type'	=> 'x-editable-text',
											'value' => array(
															'#',
															'id',
															'project_purpose',
															'project_purposes/update_project_purpose',
															stringify_attributes(
																				array(
																					'data-type'=>'text',
																					'data-placement'=>'top',
																					'data-placeholder'=>'Required',
																					'data-title'=>'Change the purpose title',
																					'class'=>'editable editable-click'
																					)
																				)
														)
											),			
				'Delete'			=> array(
											'type'	=> 'anchor',
											'value' => array('project_purposes?id=', 'id','', 'Delete',array('class'=>'project_purposes_delete_button btn btn-danger'))),
				);
			$this->data['table_settings'] = array(
				'table_heading'	=>	'Project Purposes',
				'table_sub_heading'	=>	'The purposes of a project!',
				'table_id' => 'project-purposes-table',
				'table_new_record_anchors' => array(
												array('#','New Project Purpose',array('id'=>'project_purposes_new_button','class'=>'btn btn-system')),
											  ),
			);				
			
			$viewData = $this->load_view('ui/_layout_table_data',NULL,TRUE);
			$return =  $viewData;
		}

		if ($ret=="true") {
			if ($json=="true") {
				if (!$return) {
					return json_encode(array('success'=>false,'msg'=>'No values found!'));
				} else {
					return json_encode(array('success'=>true,'msg'=>$return));
				}
			} else {
				return $return;
			}
		} else {
			if ($json=="true") {
				if (!$return) {
					echo json_encode(array('success'=>false,'msg'=>'No values found!'));
				} else {
					echo json_encode(array('success'=>true,'msg'=>$return));
				}
			} else {
				echo $return;
			}
		}
	}
}
