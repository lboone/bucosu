<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php
class Admin extends Admin_Controller {

	protected $_the_model = NULL;

	public function __construct()
	{
		parent::__construct();



	/* 
	 * -------------------------
	 * Use this if you want to restrict the page by a certain level of admin!
	 * ------------
	 */

		// if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin(false,1)) )
		// {
		// 	$this->_show_401();
		// }


		// $u_id    = intval($this->ion_auth->get_user_id());
		// $u_type = intval($this->ion_auth->get_users_groups($u_id)->row()->type);
		// if ($u_type > 2) {
		// 	$this->_show_401();
		// }


	/*
	 * -------------------------
	 * Load the model for the matching controller
	 * -------------------------
	 */
		$this->load->model('');
		$this->_the_model = $this->model_name;

	/* 
	 * -------------------------
	 * Use this section to inject css/js into the page
	 * ------------
	 */

		// $this->data['stylesheets']['font'][''] = get_css('');
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
		$this->data['title'] = "";
		$subView = '';
		$mainView = 'ui/_layout_main';
		$this->load_structure($subView,$mainView);	
	}

	public function create()
	{

		$this->data['title'] = "";

		// If it's not read then set up the form validation.

		if (isset($this->_the_model->rules)) {

		}
		$this->form_validation->set_rules($this->_the_model->rules);
		 

		// Check to see if we submitted the form.
		if (isset($_POST) && !empty($_POST))
		{
			if ($this->form_validation->run() === TRUE)
			{
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


		//set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		//$this->config->item('admin_group', 'ion_auth') === $group->name ? 'readonly' : '';
			
		// Gether information needed to load edit form
		$this->data['title'] = '';
		$this->data['link_url']['new'] = '';
		$this->data['container_form_id'] = '';
		$this->data['heading_title'] = '';
		$this->data['sub_heading_title']='';
		$this->data['submit_url'] = '';
		$this->data['form_id']=array('id'=>'form-edit--'.$slug);
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
		$this->_set_view_data('edit_object','');

		$subView = '';
		$mainView = 'create_read_update';
		$this->load_structure($subView,$mainView);	

	}

	public function read($id){

	}

	public function update($id){

	}

	public function delete($id){

	}
	
}
?>