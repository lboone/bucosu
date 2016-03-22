<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php
class Project_types extends Authorized_Controller {
	// -------- HOLDS THE MODEL ------------- //
	protected $_the_model = NULL;

	// -------- MODIFY THESE VALUES TO MATCH THE CONTROLLER ------------- //
	protected $_p 				= 'Project';
	protected $_q				= 'project';
	protected $_t				= 'Type';
	protected $_n				= 'type';



	// -------- BUILD THE VALUES -------------- //
	protected $_title			= '';
	protected $_single			= '';
	protected $_plural			= '';
	protected $_model			= '';
	protected $_table			= '';
	protected $_compressed		= '';
	protected $_non_compressed	= '';

	public function __construct(){
		parent::__construct();

	$this->_title			= $this->_p.' '.$this->_t.'s';
	$this->_single			= $this->_q.'_'.$this->_n;
	$this->_plural			= $this->_q.'_'.$this->_n.'s';
	$this->_model			= 'mdl_'.$this->_q.'_'.$this->_n.'s';
	$this->_table			= $this->_q.'_'.$this->_n.'s_table';
	$this->_compressed		= $this->_q.'/'.$this->_n.'/'.$this->_q.'.'.$this->_n.'.compressed';
	$this->_non_compressed	= $this->_q.'/'.$this->_n.'/'.$this->_q.'.'.$this->_n;


		$this->data['module_items'] = array(
										'title'				=>$this->_title,
										'single'			=>$this->_single,
										'plural'			=>$this->_plural,
										'model'				=>$this->_model,
										'table'				=>$this->_table,
										'compressed'		=>$this->_compressed,
										'non_compressed'	=>$this->_non_compressed,
									);

	/*
	 * -------------------------
	 * Load the model for the matching controller
	 * -------------------------
	 */
		$model  = $this->data['module_items']['model'];
		$this->load->model($model);
		$this->_the_model = $this->$model;
	}

	public function index() 
	{

	/* 
	 * -------------------------
	 * Use this if you want to restrict the page by a certain level of admin!
	 * ------------
	 */

		 if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin(false,0)) )
		 {
		 	$this->_show_401();
		 }


		// $u_id    = intval($this->ion_auth->get_user_id());
		// $u_type = intval($this->ion_auth->get_users_groups($u_id)->row()->type);
		// if ($u_type > 2) {
		// 	$this->_show_401();
		// }

		$this->data['stylesheets']['top']['css_file_compressed']	= get_css('assets/css/' . $this->_compressed . '.css');
		$this->data['stylesheets']['top']['css_file']				= get_css('assets/css/' . $this->_non_compressed . '.css');

		$this->data['javascripts']['end']['js_file_compressed']		= get_js('assets/js/' . $this->_compressed . '.js');
		$this->data['javascripts']['end']['js_variables']			= get_js('

			var list_item_table  = "'.$this->_table.'";
			var list_item_single = "'.$this->_single.'";
			var list_item_plural = "'.$this->_plural.'";
			var list_item_title  = "'.$this->_title.'";

			',true);

		$this->data['javascripts']['end']['js_file']	 			= get_js('assets/js/' . $this->_non_compressed .'.js');

		$this->data['title'] = $this->_title;
		$this->data['list_item_table'] = $this->_get_list_items_table("true","false");

		$subview = "list_items_table";
		$mainview = "ui/_layout_main";
		$this->load_structure($subview,$mainview);
	}

	public function get_all_json(){
		$rslts = $this->_the_model->get();
		if ($rslts) {
			echo json_encode(array('success'=>true,'msg'=>$rslts));
		} else {
			echo json_encode(array('success'=>false,'msg'=>$rslts));
		}
	}

	public function add_new_item(){
		if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin(false,0)) )
		{
			$this->_show_401();
		}

		$val = $this->input->get($this->_single);
		
		if ($this->_the_model->get_by(array($this->_single=>$val),true)) {
			echo json_encode(array('success'=>false,'msg'=>'That value already exists, please try a different value.'));
			return false;
		}
		

		if ($val) {
			$id = $this->_the_model->save(array($this->_single=>$val));
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

	public function delete_item(){

		if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin(false,0)) )
		{
			$this->_show_401();
		}

		$id = $this->input->get($this->_single . '_id');

		if ($id) {
			if ($this->_the_model->delete($id)) {
				echo json_encode(array('success'=>true,'msg'=>'The ' . $this->_title . ' was deleted!'));
				return true;
			} else {
				echo json_encode(array('success'=>false,'msg'=>$this->db->_error_message()));
				return false;
			}
		} else {
			echo json_encode(array('success'=>false,'msg'=>'You have to provide a valid ' . $this->_title . ' to delete!'));
		}

	}

	public function update_item($echo=true){
		if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin(false,0)) )
		{
			$this->_show_401();
		}


		$pk = $this->input->post('pk');
		$name = $this->input->post('name');
		$value = $this->input->post('value');
		

		if ($this->_the_model->get_by(array($this->_single=>$value),true)) {
			http_response_code(400);
			echo 'Sorry that value already exists!';
			exit;
		}


		$vals = stringify_attributes(array('pk'=>$pk,'name'=>$name,'value'=>$value));
		if ($pk && $name && $value) {
			$params = array($name=>$value);
			if($this->_the_model->save($params,$pk)){
				if ($echo) {
					echo json_encode(array('success'=>true,'msg'=>'The ' . $this->_title . ' has been changed.'));
					return true;
				} else {
					return json_encode(array('success'=>true,'msg'=>'The ' . $this->_title . ' has been changed.'));		
				}	
			} else {
				if ($echo) {
					echo json_encode(array('success'=>false,'msg'=>'There was an error saving the ' . $this->_title . ': ' . $this->db->_error_message() . '.  Please try again!'));
					return true;
				} else {
					return json_encode(array('success'=>false,'msg'=>'There was an error saving the ' . $this->_title . ': ' . $this->db->_error_message() . '.  Please try again!'));
				}				
			}
		}
		if ($echo) {
			echo json_encode(array('success'=>false,'msg'=>'There was an error updating the ' . $this->_title . ': ' . $vals . '.  Please try again!'));
			return true;
		} else {
			return json_encode(array('success'=>false,'msg'=>'There was an error updating the ' . $this->_title . ': ' . $vals . '.  Please try again!'));
		}
	}

	private function _get_list_items_table($ret="false",$json="false"){
		$return = NULL;
		$rslts = $this->_the_model->get();
		
		if ($rslts) {
			$this->data['table_row_data'] = $rslts;
			$this->data['table_header_data'] = array($this->_title, 'Delete');
			$this->data['table_row_data_fields'] = array(
				$this->_title			=> array(
											'type'	=> 'x-editable-text',
											'value' => array(
															'#',
															'id',
															$this->_single,
															$this->_plural . '/update_item',
															stringify_attributes(
																				array(
																					'data-type'=>'text',
																					'data-placement'=>'top',
																					'data-placeholder'=>'Required',
																					'data-title'=>'Change the ' . $this->_title . ' title',
																					'class'=>'editable editable-click'
																					)
																				)
														)
											),			
				'Delete'			=> array(
											'type'	=> 'anchor',
											'value' => array($this->_plural . '?id=', 'id','', 'Delete',array('class'=>$this->_plural . '_delete_button btn btn-danger'))),
				);
			$this->data['table_settings'] = array(
				'table_heading'	=>	$this->_title,
				'table_sub_heading'	=>	'A list of all the items.',
				'table_id' => $this->_table,
				'table_new_record_anchors' => array(
												array('#','New '.$this->_title,array('id'=>$this->_plural . '_new_button','class'=>'btn btn-system')),
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
