<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends Admin_Controller {

	function __construct()
	{
		parent::__construct();
		$this->data['stylesheets']['end']['admin-forms']	= get_css('assets/admin-tools/admin-forms/css/admin-forms.css');

		$this->data['nav_menu']['menu_items'] = array(
													'users'			=> array(
																		 'label' 	=> 'Users',
																		 'url'		=> site_url('users'),
																	   ),
													'groups'		=> array(
																		 'label'	=> 'Groups',
																		 'url'		=> site_url('groups'),
																	   ),
													'companies'		=> array(
																		 'label'	=> 'Companies',
																		 'url'		=> site_url('companies'),
																	   ),
													'group_types' 	=> array(
																		 'label'	=> 'Group Types',
																		 'url'		=> site_url('group_types'),
																	   ),
										  		);
		$this->data['nav_menu']['buttons']	=   array(
													array(
													 'label' 	=> 'New User',
													 'url'		=> site_url('auth/create_user'),
												    ),
													array(
													 'label'	=> 'New Group',
													 'url'		=> site_url('auth/create_group'),
													),
												);

		$this->data['nav_menu']['active']   =   'users';

	}

	//redirect if needed, otherwise display the user list
	function index()
	{
		//$this->data['stylesheets']['end']['admin-forms']	= NULL;
		$this->data['stylesheets']['top']['datatables_bootstrap'] 	= get_css('vendor/plugins/datatables/media/css/dataTables.bootstrap.css');
		$this->data['stylesheets']['top']['datatables_plugin']		= get_css('vendor/plugins/datatables/media/css/dataTables.plugins.css');

		$this->data['javascripts']['mid']['jquery_datatables']		= get_js('vendor/plugins/datatables/media/js/jquery.dataTables.js');
		$this->data['javascripts']['mid']['datatables_bootstrap']	= get_js('vendor/plugins/datatables/media/js/dataTables.bootstrap.js');

		$this->data['javascripts']['end']['user_main']				= get_js('
	jQuery(document).ready(function() {

		"use strict";
		// Init DataTables
		$("#users-table").dataTable({
	      "sDom": \'t<"dt-panelfooter clearfix"ip>\',
	      "oTableTools": {
	        "sSwfPath": "vendor/plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf"
	      }
	    });

	});
																	  ',TRUE);

		#users-table

		$this->data['title'] = 'Users';
		$this->data['body_class'] = 'datatables-page sb-l-o sb-r-c mobile-view tray-rescale onload-check';
		$user_can_add_groups = $this->session->user_can_add_groups;

		if (!isset($user_can_add_groups) || !is_array($user_can_add_groups)) {
			$this->ion_auth->set_user_group_data($this->session->userdata('user_id'));
		} else {
			$group_ids = array();
			foreach ($user_can_add_groups as $key => $value) {
				foreach ($value as $value2) {
					$group_ids[] = intval($value2['can_add_id']);
				}
			}
			$this->data['user_can_add_groups'] = $group_ids;

		}

		
		//set the flash data error message if there is one
		$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

		//get the current users level
		$this->data['cur_user_level'] = intval($this->session->userdata('user_group_level'));
		//list the company for all users
		$this->data['user_companies'] = $this->ion_auth->get_all_users_companies();
		//list the users
		$this->data['users'] = $this->ion_auth->filter_users_by_company($this->ion_auth->users()->result());
		// $this->data['users'] = $this->ion_auth->users()->result();
		
		// $user_group_type = $this->session->user_group_type;
		// $user_company_id = intval($this->session->company->id);

		// foreach ($this->data['users'] as $k => $user)
		// {
		// 	if ($user_group_type == 'SCHOOL DISTRICT') {
				

		// 		$f_user_groups = $this->ion_auth->get_users_groups($user->id)->result();	

		// 		if ($f_user_groups[0]->type == 'SCHOOL DISTRICT')
		// 		{
		// 			$f_user_company = $this->ion_auth->get_company_data($this->data['users'][$k]->company);
		// 			$f_user_company_id = intval($f_user_company->id);
		// 			if ($f_user_company_id !== $user_company_id) 
		// 			{
		// 				unset($this->data['users'][$k]);
		// 			} else {
		// 				$this->data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();	
		// 			}
		// 		} else {
		// 			unset($this->data['users'][$k]);
		// 		}

		// 	} else {
		// 		$this->data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();	
		// 	}
		// }

		
		

		$subView = 'auth/index';
		$mainView = 'ui/_layout_main';
		$this->load_structure($subView,$mainView,TRUE);	
	}


	//log the user in
	function login()
	{
		$this->data['stylesheets']['end']['cf-hidden']		= get_css('.cf-hidden { display: none; } .cf-invisible { visibility: hidden; }',TRUE);
		$this->data['javascripts']['mid']['bs-timeout'] = NULL; 
		$this->data['javascripts']['end']['screen_lock_code'] = NULL;		

		// 
		$dashboard = 'dashboard';
		$bcs 	   = '/';
		
		if ($this->ion_auth->logged_in() == TRUE) 
		{
			if (!$this->ion_auth->is_admin()) 
			{
				redirect($bcs);
			} else {
				redirect($dashboard);
			}
		} 
		
		$this->data['title'] = 'Login to BUCOSU';
		$this->data['body_class'] = 'external-page external-alt sb-l-c sb-r-c';
		$this->data['logo']['class'] = 'center-block img-responsive';
		$this->data['logo']['style'] = 'max-width: 275px;';


		
		//validate form input
		$this->form_validation->set_rules('identity', 'Identity', 'required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required');
			
		if ($this->form_validation->run() == true)
		{

			//check to see if the user is logging in
			//check for "remember me"
			$remember = (bool) $this->input->post('remember');

			if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember))
			{
				//if the login is successful
				//redirect them back to the home page
				$this->session->set_flashdata('message', $this->ion_auth->messages());

				if (!$this->ion_auth->is_admin()) 
				{
					redirect($bcs);
				} else {
					redirect($dashboard);
				}
			}
			else
			{
				//if the login was un-successful
				//redirect them back to the login page
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('auth/login', 'refresh'); //use redirects instead of loading views for compatibility with MY_Controller libraries
			}
		}
		else
		{
			//the user is not logging in so display the login page
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->data['identity'] = array('name' => 'identity',
				'id' => 'identity',
				'type' => 'text',
				'value' => $this->form_validation->set_value('identity'),
				'class' => 'gui-input',
				'placeholder' => 'Enter username',
			);
			$this->data['password'] = array('name' => 'password',
				'id' => 'password',
				'type' => 'password',
				'class' => 'gui-input',
				'placeholder' => 'Enter password',
			);
			$subView = 'auth/login';
			$mainView = 'ui/_layout_modal';
			$this->load_structure($subView,$mainView);


			//$this->_render_page('auth/login', $this->data);
		}
	}

	//log the user out
	function logout()
	{
		$this->data['title'] = "Logout";

		//log the user out
		$logout = $this->ion_auth->logout();

		//redirect them to the login page
		$this->session->set_flashdata('message', $this->ion_auth->messages());
		redirect('auth/login', 'refresh');
	}

	//change password
	function change_password()
	{
		$this->form_validation->set_rules('old', $this->lang->line('change_password_validation_old_password_label'), 'required');
		$this->form_validation->set_rules('new', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
		$this->form_validation->set_rules('new_confirm', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required');
		$this->data['title'] = 'Change Password';

		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}

		$user = $this->ion_auth->user()->row();

		if ($this->form_validation->run() == false)
		{
			//display the form
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
			$this->data['old_password'] = array(
				'name' => 'old',
				'id'   => 'old',
				'type' => 'password',
				'class' => 'gui-input',
				'placeholder' => 'Old Password',

			);
			$this->data['new_password'] = array(
				'name' => 'new',
				'id'   => 'new',
				'type' => 'password',
				'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
				'class' => 'gui-input',
				'placeholder' => 'New Password: min length '.$this->data['min_password_length'],
			);
			$this->data['new_password_confirm'] = array(
				'name' => 'new_confirm',
				'id'   => 'new_confirm',
				'type' => 'password',
				'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
				'class' => 'gui-input',
				'placeholder' => 'Confirm New Password',
			);
			$this->data['user_id'] = array(
				'name'  => 'user_id',
				'id'    => 'user_id',
				'type'  => 'hidden',
				'value' => $user->id,
			);

			$subView = 'auth/change_password';
			$mainView = 'ui/_layout_main';
			$this->load_structure($subView,$mainView);

			//render
			//$this->_render_page('auth/change_password', $this->data);
		}
		else
		{
			$identity = $this->session->userdata('identity');

			$change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

			if ($change)
			{
				//if the password was successfully changed
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				$this->logout();
			}
			else
			{
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('auth/change_password', 'refresh');
			}
		}
	}

	//forgot password
	function forgot_password()
	{
		$this->data['javascripts']['mid']['bs-timeout'] = NULL; 
		$this->data['javascripts']['end']['screen_lock_code'] = NULL;		
		$this->data['body_class'] = 'external-page external-alt sb-l-c sb-r-c onload-check';
		$this->data['javascripts']['end']['forgot_password_form_submit'] = get_js('
	jQuery(document).ready(function() {

		"use strict";
		$( "#forgot_password_btn" ).click(function() {
  			$("#forgot_password_form").submit();
		});
	});
																			',TRUE);

		//setting validation rules by checking wheather identity is username or email
		if($this->config->item('identity', 'ion_auth') == 'username' )
		{
		   $this->form_validation->set_rules('email', $this->lang->line('forgot_password_username_identity_label'), 'required');
		}
		else
		{
		   $this->form_validation->set_rules('email', $this->lang->line('forgot_password_validation_email_label'), 'required|valid_email');
		}


		if ($this->form_validation->run() == false)
		{
			//setup the input
			$this->data['email'] = array('name' => 'email',
				'id' => 'email',
				'class' => 'gui-input',
				'placeholder' => 'Your Email Address'
			);

			if ( $this->config->item('identity', 'ion_auth') == 'username' ){
				$this->data['identity_label'] = $this->lang->line('forgot_password_username_identity_label');
			}
			else
			{
				$this->data['identity_label'] = $this->lang->line('forgot_password_email_identity_label');
			}

			//set any errors and display the form
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$subView = 'auth/forgot_password';
			$mainView = 'ui/_layout_modal';
			$this->load_structure($subView,$mainView);
			//$this->_render_page('auth/forgot_password', $this->data);
		}
		else
		{
			// get identity from username or email
			if ( $this->config->item('identity', 'ion_auth') == 'username' ){
				$identity = $this->ion_auth->where('username', strtolower($this->input->post('email')))->users()->row();
			}
			else
			{
				$identity = $this->ion_auth->where('email', strtolower($this->input->post('email')))->users()->row();
			}
	            	if(empty($identity)) {

	            		if($this->config->item('identity', 'ion_auth') == 'username')
		            	{
                                   $this->ion_auth->set_message('forgot_password_username_not_found');
		            	}
		            	else
		            	{
		            	   $this->ion_auth->set_message('forgot_password_email_not_found');
		            	}

		                $this->session->set_flashdata('message', $this->ion_auth->messages());
                		redirect("auth/forgot_password", 'refresh');
            		}

			//run the forgotten password method to email an activation code to the user
			$forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});

			if ($forgotten)
			{
				//if there were no errors
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect("home/confirm/pres/".urlencode(strtolower($this->input->post('email')))); //we should display a confirmation page here instead of the login page
			}
			else
			{
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect("auth/forgot_password", 'refresh');
			}
		}
	}

	//reset password - final step for forgotten password
	public function reset_password($code = NULL)
	{
		if (!$code)
		{
			show_404();
		}

		$user = $this->ion_auth->forgotten_password_check($code);

		if ($user)
		{
			//if the code is valid then display the password reset form

			$this->form_validation->set_rules('new', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
			$this->form_validation->set_rules('new_confirm', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');

			if ($this->form_validation->run() == false)
			{
				//display the form

				//set the flash data error message if there is one
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

				$this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
				$this->data['new_password'] = array(
					'name' => 'new',
					'id'   => 'new',
				'type' => 'password',
					'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
				);
				$this->data['new_password_confirm'] = array(
					'name' => 'new_confirm',
					'id'   => 'new_confirm',
					'type' => 'password',
					'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
				);
				$this->data['user_id'] = array(
					'name'  => 'user_id',
					'id'    => 'user_id',
					'type'  => 'hidden',
					'value' => $user->id,
				);
				$this->data['csrf'] = $this->_get_csrf_nonce();
				$this->data['code'] = $code;

				$subView = 'auth/reset_password';
				$mainView = 'ui/_layout_main';
				$this->load_structure($subView,$mainView);

				//render
				$this->_render_page('auth/reset_password', $this->data);
			}
			else
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id'))
				{

					//something fishy might be up
					$this->ion_auth->clear_forgotten_password_code($code);

					show_error($this->lang->line('error_csrf'));

				}
				else
				{
					// finally change the password
					$identity = $user->{$this->config->item('identity', 'ion_auth')};

					$change = $this->ion_auth->reset_password($identity, $this->input->post('new'));

					if ($change)
					{
						//if the password was successfully changed
						$this->session->set_flashdata('message', $this->ion_auth->messages());
						redirect("auth/login", 'refresh');
					}
					else
					{
						$this->session->set_flashdata('message', $this->ion_auth->errors());
						redirect('auth/reset_password/' . $code, 'refresh');
					}
				}
			}
		}
		else
		{
			//if the code is invalid then send them back to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("auth/forgot_password", 'refresh');
		}
	}


	//activate the user
	function activate($id, $code=false)
	{
		if ($code !== false)
		{
			$activation = $this->ion_auth->activate($id, $code);
		}
		else if ($this->ion_auth->is_admin())
		{
			$activation = $this->ion_auth->activate($id);
		}

		if ($activation)
		{
			//redirect them to the auth page
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			redirect("auth", 'refresh');
		}
		else
		{
			//redirect them to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("auth/forgot_password", 'refresh');
		}
	}

	//deactivate the user
	function deactivate($id = NULL)
	{
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			//redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}

		$id = (int) $id;

		$this->load->library('form_validation');
		$this->form_validation->set_rules('confirm', $this->lang->line('deactivate_validation_confirm_label'), 'required');
		$this->form_validation->set_rules('id', $this->lang->line('deactivate_validation_user_id_label'), 'required|alpha_numeric');

		if ($this->form_validation->run() == FALSE)
		{
			// insert csrf check
			$this->data['csrf'] = $this->_get_csrf_nonce();
			$this->data['user'] = $this->ion_auth->user($id)->row();

			$subView = 'auth/deactivate_user';
			$mainView = 'ui/_layout_modal';
			$this->load_structure($subView,$mainView);
			
			//$this->_render_page('auth/deactivate_user', $this->data);
		}
		else
		{
			// do we really want to deactivate?
			if ($this->input->post('confirm') == 'yes')
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
				{
					show_error($this->lang->line('error_csrf'));
				}

				// do we have the right userlevel?
				if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
				{
					$this->ion_auth->deactivate($id);
				}
			}

			//redirect them back to the auth page
			redirect('auth', 'refresh');
		}
	}

	//activate the user
	function activate_group($id)
	{
		if ($this->ion_auth->is_admin())
		{
			$activation = $this->ion_auth->activate_group($id);
		}

		if ($activation)
		{
			//redirect them to the auth page
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			redirect("auth/groups", 'refresh');
		}
		else
		{
			//redirect them to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("auth/groups", 'refresh');
		}
	}

	//deactivate the user
	function deactivate_group($id = NULL)
	{

		$id = (int) $id;

		$this->load->library('form_validation');
		$this->form_validation->set_rules('confirm', $this->lang->line('deactivate_validation_confirm_label'), 'required');
		$this->form_validation->set_rules('id', $this->lang->line('deactivate_validation_user_id_label'), 'required|alpha_numeric');

		if ($this->form_validation->run() == FALSE)
		{
			// insert csrf check
			$this->data['csrf'] = $this->_get_csrf_nonce();
			$this->data['group'] = $this->ion_auth->group($id)->row();

			$subView = 'auth/deactivate_group';
			$mainView = 'ui/_layout_modal';
			$this->load_structure($subView,$mainView);
			
			//$this->_render_page('auth/deactivate_user', $this->data);
		}
		else
		{
			// do we really want to deactivate?
			if ($this->input->post('confirm') == 'yes')
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
				{
					show_error($this->lang->line('error_csrf'));
				}

				// do we have the right userlevel?
				if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
				{
					$this->ion_auth->deactivate_group($id);
				}
			}

			//redirect them back to the auth page
			redirect('auth/groups', 'refresh');
		}
	}


	//create a new user
	function create_user()
	{
		$this->data['stylesheets']['end']['multiselect'] = get_css('http://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css');
		$this->data['javascripts']['mid']['multiselect'] = get_js('http://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js');
		$this->data['javascripts']['mid']['masked_input']	= get_js('vendor/plugins/jquerymask/jquery.maskedinput.min.js');
		$this->data['javascripts']['end']['multi_select_raw'] = get_js('jQuery(document).ready(function() {"use strict"; $("#multiselect1").select2(); $("#multiselect0").select2();  $(".phone").mask("(999) 999-9999"); });',TRUE);
		$this->data['title'] = "Create User";

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('auth', 'refresh');
		}
		
		$this->data['user_can_add_groups'] = $this->session->userdata('user_can_add_groups');
		
		//$user = $this->ion_auth->user($id)->row();
		$groups=$this->ion_auth->groups()->result_array();
		//$currentGroups = $this->ion_auth->get_users_groups()->result();

		$tables = $this->config->item('tables','ion_auth');

		//validate form input
		$this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'required');
		$this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'required');
		$this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email|is_unique['.$tables['users'].'.email]');
		$this->form_validation->set_rules('phone', 'Phone', 'required');
		$this->form_validation->set_rules('company', $this->lang->line('create_user_validation_company_label'), 'required');
		$this->form_validation->set_rules('groups', 'Member of group', 'required');
		$this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
		$this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');

		if ($this->form_validation->run() == true)
		{
			$username = strtolower($this->input->post('first_name')) . ' ' . strtolower($this->input->post('last_name'));
			$email    = strtolower($this->input->post('email'));
			$password = $this->input->post('password');

			$additional_data = array(
				'first_name' => $this->input->post('first_name'),
				'last_name'  => $this->input->post('last_name'),
				'company'    => $this->input->post('company'),
				'phone'      => $this->input->post('phone'),
			);
		}
		if ($this->form_validation->run() == true && $this->ion_auth->register($username, $password, $email, $additional_data,array(intval($this->input->post('groups')))))
		{
			//check to see if we are creating the user
			//redirect them back to the admin page
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			redirect("auth", 'refresh');
		}
		else
		{
			//display the create user form
			//set the flash data error message if there is one

			//pass the user to the view
			//$this->data['user'] = $user;
			$this->data['groups'] = $groups;
			$this->data['currentGroups'] = intval($this->input->post('groups'));
			$this->data['user_can_add_groups'] = $this->session->user_can_add_groups;
			$this->data['assoc_companies'] = $this->session->associated_companies;

			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));


		$this->data['first_name'] = array(
			'name'  => 'first_name',
			'id'    => 'first_name',
			'type'  => 'text',
			'class' => 'gui-input',
			'placeholder' => 'First name...',
			'value' => $this->form_validation->set_value('first_name'),
		);
		$this->data['last_name'] = array(
			'name'  => 'last_name',
			'id'    => 'last_name',
			'type'  => 'text',
			'class' => 'gui-input',
			'placeholder' => 'Last name...',
			'value' => $this->form_validation->set_value('last_name'),
		);
		$this->data['email'] = array(
			'name'  => 'email',
			'id'    => 'email',
			'type'  => 'text',
			'class' => 'gui-input',
			'placeholder' => 'Email...',
			'value' => $this->form_validation->set_value('email'),
		);
		$this->data['company'] = array(
			'name'  => 'company',
			'id'    => 'company',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('company'),
		);
		$this->data['phone'] = array(
			'name'  => 'phone',
			'id'    => 'phone',
			'type'  => 'text',
			'class' => 'gui-input form-control phone',
			'max-length' => "10",
			'placeholder' => '(518) 123-4567',
			'value' => $this->form_validation->set_value('phone'),
		);
		$this->data['password'] = array(
			'name' => 'password',
			'id'   => 'password',
			'class' => 'gui-input',
			'type' => 'password'
		);
		$this->data['password_confirm'] = array(
			'name' => 'password_confirm',
			'id'   => 'password_confirm',
			'class' => 'gui-input',
			'type' => 'password'
		);

			$subView = 'auth/create_user';
			$mainView = 'ui/_layout_main';
			$this->load_structure($subView,$mainView);			
			//$this->_render_page('auth/create_user', $this->data);
		}
	}

	//edit a user
	function edit_user($id = NULL)
	{
		$this->data['nav_menu']['buttons']	=   array(
											array(
											 'label'	=> 'Back to Users',
											 'url'		=> site_url('users'),
											 'logo'		=> 'fa-angle-left',
											),
											array(
											 'label' 	=> 'New User',
											 'url'		=> site_url('auth/create_user'),
										    ),
											array(
											 'label'	=> 'New Group',
											 'url'		=> site_url('auth/create_group'),
											),
										);

		$this->data['nav_menu']['active']   =   'users';
		if ($id == NULL) {
			redirect('auth', 'refresh');
		}
		$this->data['stylesheets']['end']['multiselect'] = get_css('http://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css');
		$this->data['javascripts']['mid']['multiselect'] = get_js('http://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js');
		$this->data['javascripts']['mid']['masked_input']	= get_js('vendor/plugins/jquerymask/jquery.maskedinput.min.js');
		$this->data['javascripts']['end']['multi_select_raw'] = get_js('jQuery(document).ready(function() {"use strict"; $("#multiselect1").select2(); $("#multiselect0").select2();  $(".phone").mask("(999) 999-9999"); });',TRUE);
		$this->data['title'] = "Edit User";

		$u_level = intval($this->ion_auth->get_users_groups($id)->row()->level);
		$u_level = ($u_level <= 1) ? $u_level : $u_level-1 ;


		if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin(false,$u_level)) )
		{
			redirect('auth', 'refresh');
		}

		$user = $this->ion_auth->user($id)->row();
		$groups=$this->ion_auth->groups()->result_array();
		$currentGroups = $this->ion_auth->get_users_groups($id)->result();
		//$assoc_companies = $this->ion_auth->get_associated_companies();

		//validate form input
		$this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'required');
		$this->form_validation->set_rules('last_name', $this->lang->line('edit_user_validation_lname_label'), 'required');
		$this->form_validation->set_rules('phone', $this->lang->line('edit_user_validation_phone_label'), 'required');
		$this->form_validation->set_rules('company', $this->lang->line('edit_user_validation_company_label'), 'required');
		$this->form_validation->set_rules('groups', 'Member of group', 'required');

		if (isset($_POST) && !empty($_POST))
		{
			// do we have a valid request?
			if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
			{
				show_error($this->lang->line('error_csrf'));
			}

			//update the password if it was posted
			if ($this->input->post('password'))
			{
				$this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
				$this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
			}

			if ($this->form_validation->run() === TRUE)
			{
				$data = array(
					'first_name' => $this->input->post('first_name'),
					'last_name'  => $this->input->post('last_name'),
					'company'    => $this->input->post('company'),
					'phone'      => $this->input->post('phone'),
				);

				//update the password if it was posted
				if ($this->input->post('password'))
				{
					$data['password'] = $this->input->post('password');
				}



				// Only allow updating groups if user is admin
				if ($this->ion_auth->is_admin())
				{
					//Update the groups user belongs to
					$groupData = $this->input->post('groups');

					if (isset($groupData) && !empty($groupData)) {

						$this->ion_auth->remove_from_group('', $id);

						if (! is_array($groupData)) {
								$groupData = array($groupData);
						}
						foreach ($groupData as $grp) {
							$this->ion_auth->add_to_group($grp, $id);
						}

					}
				}

			//check to see if we are updating the user
			   if($this->ion_auth->update($user->id, $data))
			    {
			    	//redirect them back to the admin page if admin, or to the base url if non admin
				    $this->session->set_flashdata('message', $this->ion_auth->messages() );
				    if ($this->ion_auth->is_admin())
					{
						redirect('auth', 'refresh');
					}
					else
					{
						redirect('/', 'refresh');
					}

			    }
			    else
			    {
			    	//redirect them back to the admin page if admin, or to the base url if non admin
				    $this->session->set_flashdata('message', $this->ion_auth->errors() );
				    if ($this->ion_auth->is_admin())
					{
						redirect('auth', 'refresh');
					}
					else
					{
						redirect('/', 'refresh');
					}

			    }

			}
		}

		//display the edit user form
		$this->data['csrf'] = $this->_get_csrf_nonce();

		//set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		//pass the user to the view
		$this->data['user'] = $user;
		$this->data['groups'] = $groups;
		$this->data['currentGroups'] = $currentGroups;
		$this->data['user_can_add_groups'] = $this->session->user_can_add_groups;
		$this->data['assoc_companies'] = $this->session->associated_companies;



		$this->data['first_name'] = array(
			'name'  => 'first_name',
			'id'    => 'first_name',
			'type'  => 'text',
			'class' => 'gui-input',
			'placeholder' => 'First name...',
			'value' => $this->form_validation->set_value('first_name', $user->first_name),
		);
		$this->data['last_name'] = array(
			'name'  => 'last_name',
			'id'    => 'last_name',
			'type'  => 'text',
			'class' => 'gui-input',
			'placeholder' => 'Last name...',
			'value' => $this->form_validation->set_value('last_name', $user->last_name),
		);
		$this->data['company'] = array(
			'name'  => 'company',
			'id'    => 'company',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('company', $user->company),
		);
		$this->data['phone'] = array(
			'name'  => 'phone',
			'id'    => 'phone',
			'type'  => 'text',
			'class' => 'gui-input form-control phone',
			'max-length' => "10",
			'placeholder' => '(518) 123-4567',
			'value' => $this->form_validation->set_value('phone', $user->phone),
		);
		$this->data['password'] = array(
			'name' => 'password',
			'id'   => 'password',
			'class' => 'gui-input',
			'type' => 'password'
		);
		$this->data['password_confirm'] = array(
			'name' => 'password_confirm',
			'id'   => 'password_confirm',
			'class' => 'gui-input',
			'type' => 'password'
		);

		$subView = 'auth/edit_user';
		$mainView = 'ui/_layout_main';
		$this->load_structure($subView,$mainView,TRUE);
		//$this->_render_page('auth/edit_user', $this->data);
	}

	// list all groups
	function groups()
	{
		//$this->data['stylesheets']['end']['admin-forms']	= NULL;
		$this->data['stylesheets']['top']['datatables_bootstrap'] 	= get_css('vendor/plugins/datatables/media/css/dataTables.bootstrap.css');
		$this->data['stylesheets']['top']['datatables_plugin']		= get_css('vendor/plugins/datatables/media/css/dataTables.plugins.css');

		$this->data['javascripts']['mid']['jquery_datatables']		= get_js('vendor/plugins/datatables/media/js/jquery.dataTables.js');
		$this->data['javascripts']['mid']['datatables_bootstrap']	= get_js('vendor/plugins/datatables/media/js/dataTables.bootstrap.js');

		$this->data['javascripts']['end']['user_main']				= get_js('
	jQuery(document).ready(function() {

		"use strict";
		// Init DataTables
		$("#users-table").dataTable({
	      "sDom": \'t<"dt-panelfooter clearfix"ip>\',
	      "oTableTools": {
	        "sSwfPath": "vendor/plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf"
	      }
	    });

	});
																	  ',TRUE);

		$this->data['nav_menu']['buttons']	=   array(
											array(
											 'label'	=> 'New Group',
											 'url'		=> site_url('auth/create_group'),
											),
										);

		$this->data['nav_menu']['active']   =   'groups';


		$this->data['title'] = 'Groups';
		$this->data['body_class'] = 'datatables-page sb-l-o sb-r-c onload-check';
		$this->data['nav_menu']['active']   =   'groups';
		$this->data['nav_menu']['buttons']	=   array(
											array(
											 'label' 	=> 'New Group',
											 'url'		=> site_url('auth/create_group'),
										    ),
										);

		
		//set the flash data error message if there is one
		$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

		//get the current users level
		$this->data['cur_user_level'] = intval($this->session->userdata('user_group_level'));

		//list the users
		$this->data['groups'] = $this->ion_auth->groups()->result();	

		$subView = 'auth/groups';
		$mainView = 'ui/_layout_main';
		$this->load_structure($subView,$mainView,TRUE);	
	}

	// create a new group
	function create_group()
	{
		//$this->data['stylesheets']['end']['multiselect'] = get_css('http://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css');
		//$this->data['javascripts']['mid']['multiselect'] = get_js('http://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js');
		//$this->data['javascripts']['end']['multi_select_raw'] = get_js('jQuery(document).ready(function() {"use strict"; $("#group_type").select2(); });',TRUE);
		
		//$this->data['javascripts']['mid']['multiselect'] = get_js('http://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js');

		$this->data['title'] = "Create Group";

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin(false,0))
		{
			redirect('auth', 'refresh');
		}

		$u_level = intval($this->session->userdata['user_group_level']);

		

		//validate form input
		$this->form_validation->set_rules('group_name', $this->lang->line('create_group_validation_name_label'), 'required|alpha_dash');
		$this->form_validation->set_rules('group_type', 'Type Of Group', 'required');
		$this->form_validation->set_rules('group_level', 'Group Level', 'required|less_than[1000]|greater_than[1]');
		$this->form_validation->set_rules('description', 'Description', 'max_length[100]');
		
		if ($this->form_validation->run() == TRUE)
		{
			$new_group_id = $this->ion_auth->create_group($this->input->post('group_name'), $this->input->post('description'), $this->input->post('group_type'), $this->input->post('group_level'));
			if($new_group_id)
			{
				// check to see if we are creating the group
				// redirect them back to the admin page
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect("auth", 'refresh');
			}
		}
		else
		{

			$group_opts = $this->ion_auth->group_types()->result();
			foreach ($group_opts as $group) {
				$group_options[$group->id] = $group->name;
			}
			//display the create group form
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

			$this->data['group_name'] = array(
				'name'  => 'group_name',
				'id'    => 'group_name',
				'type'  => 'text',
				'class' => 'gui-input',
				'placeholder' => 'Group name...',
				'value' => $this->form_validation->set_value('group_name'),
			);
			$this->data['group_level'] = array(
				'name'  => 'group_level',
				'id'    => 'group_level',
				'type'  => 'text',
				'class' => 'form-control ui-spinner-input',
				'placeholder' => 'Group level... [1-999]',
				'value' => $this->form_validation->set_value('group_level'),
			);

			$this->data['group_type'] = array(
				'name'  => 'group_type',
				'options' => $group_options,
				'selected' => $this->form_validation->set_value('group_type'),
				'additional' => array(
									'id'    => 'group_type',
								),
			);			
			$this->data['description'] = array(
				'name'  => 'description',
				'id'    => 'description',
				'type'  => 'text',
				'class' => 'gui-textarea',
				'placeholder' => 'Brief description...',
				'value' => $this->form_validation->set_value('description'),
			);
			$subView = 'auth/create_group';
			$mainView = 'ui/_layout_main';
			$this->load_structure($subView,$mainView);	
			//$this->_render_page('auth/create_group', $this->data);
		}
	}

	//edit a group
	function edit_group($id = NULL)
	{
		$this->data['nav_menu']['buttons']	=   array(
											array(
											 'label'	=> 'Back to Groups',
											 'url'		=> site_url('auth/groups'),
											 'logo'		=> 'fa-angle-left',
											),
											array(
											 'label'	=> 'New Group',
											 'url'		=> site_url('auth/create_group'),
											),
										);

		$this->data['nav_menu']['active']   =   'groups';

		// bail if no group id given
		if(!$id || empty($id))
		{
			redirect('auth/groups', 'refresh');
		}

		$this->data['title'] = $this->lang->line('edit_group_title');

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin(false,0))
		{
			redirect('auth', 'refresh');
		}

		$group = $this->ion_auth->group($id)->row();


		$group_opts = $this->ion_auth->group_types()->result();
		foreach ($group_opts as $grp) {
			$group_options[$grp->id] = $grp->name;
		}

		//validate form input
		$this->form_validation->set_rules('group_name', $this->lang->line('create_group_validation_name_label'), 'required|alpha_dash');
		$this->form_validation->set_rules('group_type', 'Type Of Group', 'required');
		$this->form_validation->set_rules('group_level', 'Group Level', 'required|less_than[1000]');
		$this->form_validation->set_rules('description', 'Description', 'max_length[100]');

		if (isset($_POST) && !empty($_POST))
		{
			if ($this->form_validation->run() === TRUE)
			{
				$group_update = $this->ion_auth->update_group($id, $this->input->post('group_name'), array('description'=>$this->input->post('description'), 'type'=>$this->input->post('group_type'), 'level'=>$this->input->post('group_level')));

				if($group_update)
				{
					$this->session->set_flashdata('message', $this->lang->line('edit_group_saved'));
				}
				else
				{
					$this->session->set_flashdata('message', $this->ion_auth->errors());
				}
				redirect("auth/groups", 'refresh');
			}
		}

		//set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
		//pass the group_types to the view
		//$this->data['group_types'] = $group_types;

		$readonly = $this->config->item('admin_group', 'ion_auth') === $group->name ? 'readonly' : '';

		$this->data['group_name'] = array(
			'name'  => 'group_name',
			'id'    => 'group_name',
			'type'  => 'text',
			'class' => 'gui-input',
			'value' => $this->form_validation->set_value('group_name',$group->name),
			$readonly => $readonly,
		);
		$this->data['group_level'] = array(
			'name'  => 'group_level',
			'id'    => 'group_level',
			'type'  => 'text',
			'class' => 'gui-input',
			$readonly => $readonly,
			'value' => $this->form_validation->set_value('group_level',$group->level),
		);

		$this->data['group_type'] = array(
			'name'  => 'group_type',
			'options' => $group_options,
			'selected' => $this->form_validation->set_value('group_type',$group->type),
			'additional' => array(
								'id'    => 'group_type',
								$readonly => $readonly,
							),
		);			
		$this->data['description'] = array(
			'name'  => 'description',
			'id'    => 'description',
			'type'  => 'text',
			'class' => 'gui-textarea',
			'placeholder' => 'Brief description...',
			'value' => $this->form_validation->set_value('description',$group->description),
		);

		$subView = 'auth/edit_group';
		$mainView = 'ui/_layout_main';
		$this->load_structure($subView,$mainView,TRUE);
		//$this->_render_page('auth/edit_group', $this->data);
	}



	// list all companies
	function companies()
	{
		//$this->data['stylesheets']['end']['admin-forms']	= NULL;
		$this->data['stylesheets']['top']['datatables_bootstrap'] 	= get_css('vendor/plugins/datatables/media/css/dataTables.bootstrap.css');
		$this->data['stylesheets']['top']['datatables_plugin']		= get_css('vendor/plugins/datatables/media/css/dataTables.plugins.css');

		$this->data['javascripts']['mid']['jquery_datatables']		= get_js('vendor/plugins/datatables/media/js/jquery.dataTables.js');
		$this->data['javascripts']['mid']['datatables_bootstrap']	= get_js('vendor/plugins/datatables/media/js/dataTables.bootstrap.js');

		$this->data['javascripts']['end']['companies_main']				= get_js('
	jQuery(document).ready(function() {

		"use strict";
		// Init DataTables
		$("#users-table").dataTable({
	      "sDom": \'t<"dt-panelfooter clearfix"ip>\',
	      "oTableTools": {
	        "sSwfPath": "vendor/plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf"
	      }
	    });

	});
																	  ',TRUE);

		#users-table

		$this->data['title'] = 'Companies';
		$this->data['body_class'] = 'datatables-page sb-l-o sb-r-c onload-check';
		$this->data['nav_menu']['active']   =   'companies';
		$this->data['nav_menu']['buttons']	=   array(
											array(
											 'label' 	=> 'New Company',
											 'url'		=> site_url('auth/create_company'),
										    ),
										);

		
		//set the flash data error message if there is one
		$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

		//get the current users level
		$this->data['cur_user_level'] = intval($this->session->userdata('user_group_level'));
		$this->data['cur_user_group_type'] = intval($this->session->userdata('user_group_type'));

		//list the users
		$this->data['companies'] = $this->ion_auth->companies()->result();	

		$subView = 'auth/companies';
		$mainView = 'ui/_layout_main';
		$this->load_structure($subView,$mainView,TRUE);	
	}

	function create_company()
	{
		$this->data['javascripts']['mid']['masked_input']	= get_js('vendor/plugins/jquerymask/jquery.maskedinput.min.js');
		$this->data['javascripts']['end']['multi_select_raw'] = get_js('jQuery(document).ready(function() {"use strict"; $(".phone_number").mask("(999) 999-9999"); $(".fax_number").mask("(999) 999-9999");});',TRUE);

		$this->data['nav_menu']['buttons']	=   array(
											array(
											 'label'	=> 'Back to Companies',
											 'url'		=> site_url('companies'),
											 'logo'		=> 'fa-angle-left',
											),
											array(
											 'label'	=> 'New Company',
											 'url'		=> site_url('auth/create_company'),
											),
										);

		$this->data['nav_menu']['active']   =   'companies';


		$this->data['title'] = 'New company';

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin(false,0))
		{
			redirect('auth', 'refresh');
		}

		$group_opts = $this->ion_auth->group_types()->result();
		foreach ($group_opts as $grp) {
			$group_options[$grp->id] = $grp->name;
		}

		//validate form input
		$this->form_validation->set_rules('company_name', 'Name of Company', 'required');
		$this->form_validation->set_rules('group_type', 'Type Of Group', 'required');
		$this->form_validation->set_rules('company_address', 'Company Address', 'required');
		$this->form_validation->set_rules('company_city', 'Company City', 'required');
		$this->form_validation->set_rules('company_state', 'Company State', 'required|exact_length[2]');
		$this->form_validation->set_rules('company_zip', 'Company Zip', 'required');
		$this->form_validation->set_rules('company_phone', 'Company Phone Number', 'required');
		$this->form_validation->set_rules('company_website', 'Company Phone Number', 'required|valid_url');

		if (isset($_POST) && !empty($_POST))
		{
			if ($this->form_validation->run() === TRUE)
			{
				$uVals = array(
						'name'		=>$this->input->post('company_name'),
						'type'		=>$this->input->post('group_type'),
						'address'	=>$this->input->post('company_address'),
						'city'		=>$this->input->post('company_city'),
						'state'		=>$this->input->post('company_state'),
						'zip'		=>$this->input->post('company_zip'),
						'phone'		=>preg_replace('/\D+/', '', $this->input->post('company_phone')),
						'fax'		=>preg_replace('/\D+/', '', $this->input->post('company_fax')),
						'website'	=>$this->input->post('company_website'),
						'logo'		=>$this->input->post('company_logo'),
						'company_id'=>$this->input->post('company_id'),
					);


				$company_id = $this->ion_auth->create_company($uVals);

				if($company_id)
				{
					$this->session->set_userdata(array('associated_companies'=> $this->ion_auth->get_associated_companies()));
					$this->session->set_flashdata('message', 'Company has been created.');
				}
				else
				{
					$this->session->set_flashdata('message', $this->ion_auth->errors());
				}
				redirect("auth/companies", 'refresh');
			}
		}

		//set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
		//pass the group_types to the view
		//$this->data['group_types'] = $group_types;

		

		$this->data['company_name'] = array(
			'name'  => 'company_name',
			'id'    => 'company_name',
			'type'  => 'text',
			'class' => 'gui-input',
			'placeholder' => 'Company Name...',
			'value' => $this->form_validation->set_value('company_name'),
		);

		$this->data['group_type'] = array(
			'name'  => 'group_type',
			'options' => $group_options,
			'selected' => $this->form_validation->set_value('group_type'),
			'additional' => array(
								'id'    => 'group_type',
							),
		);			
		$this->data['company_id'] = array(
			'name'  => 'company_id',
			'id'    => 'company_id',
			'type'  => 'text',
			'class' => 'gui-input',
			'placeholder' => 'Company Unique ID...',
			'value' => $this->form_validation->set_value('company_id'),
		);

		$this->data['company_address'] = array(
			'name'  => 'company_address',
			'id'    => 'company_address',
			'type'  => 'text',
			'class' => 'gui-input',
			'placeholder' => 'Company Address...',
			'value' => $this->form_validation->set_value('company_address'),
		);
		$this->data['company_city'] = array(
			'name'  => 'company_city',
			'id'    => 'company_city',
			'type'  => 'text',
			'class' => 'gui-input',
			'placeholder' => 'Company City...',
			'value' => $this->form_validation->set_value('company_city'),
		);
		$this->data['company_state'] = array(
			'name'  => 'company_state',
			'options' => $this->get_states(),
			'selected' => $this->form_validation->set_value('company_state'),
			'additional' => array(
								'id'    => 'company_state',
							),
		);
		$this->data['company_zip'] = array(
			'name'  => 'company_zip',
			'id'    => 'company_zip',
			'type'  => 'text',
			'class' => 'gui-input',
			'placeholder' => 'Company Zip...',
			'value' => $this->form_validation->set_value('company_zip'),
		);
		$this->data['company_phone'] = array(
			'name'  => 'company_phone',
			'id'    => 'company_phone',
			'type'  => 'text',
			'class' => 'gui-input phone_number',
			'placeholder' => 'Company Phone...',
			'value' => $this->form_validation->set_value('company_phone'),
		);
		$this->data['company_fax'] = array(
			'name'  => 'company_fax',
			'id'    => 'company_fax',
			'type'  => 'text',
			'class' => 'gui-input fax_number',
			'placeholder' => 'Company Fax...',
			'value' => $this->form_validation->set_value('company_fax'),
		);
		$this->data['company_website'] = array(
			'name'  => 'company_website',
			'id'    => 'company_website',
			'type'  => 'text',
			'class' => 'gui-input',
			'placeholder' => 'Company Web Site...',
			'value' => $this->form_validation->set_value('company_website'),
		);
		$this->data['company_logo'] = array(
			'name'  => 'company_logo',
			'id'    => 'company_logo',
			'type'  => 'text',
			'class' => 'gui-input',
			'placeholder' => 'Company Logo...',
			'value' => $this->form_validation->set_value('company_logo'),
		);		
		$subView = 'auth/create_company';
		$mainView = 'ui/_layout_main';
		$this->load_structure($subView,$mainView,TRUE);
	}

	function edit_company($id = NULL)
	{
		//$this->data['stylesheets']['end']['multiselect'] = get_css('http://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css');
		//$this->data['javascripts']['mid']['multiselect'] = get_js('http://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js');
		$this->data['javascripts']['mid']['masked_input']	= get_js('vendor/plugins/jquerymask/jquery.maskedinput.min.js');
		$this->data['javascripts']['end']['multi_select_raw'] = get_js('jQuery(document).ready(function() {"use strict"; $(".phone_number").mask("(999) 999-9999"); $(".fax_number").mask("(999) 999-9999");});',TRUE);

		$this->data['javascripts']['end']['googleMaps'] = get_js("http://maps.google.com/maps/api/js?sensor=false");
		$this->data['javascripts']['end']['gmapsMain'] = get_js("vendor/plugins/map/gmaps.min.js");
		$this->data['javascripts']['end']['uiMapMin'] = get_js("vendor/plugins/gmap/jquery.ui.map.min.js");
		$this->data['javascripts']['end']['uiMapExt'] = get_js("vendor/plugins/gmap/ui/jquery.ui.map.extensions.min.js");
		$this->data['javascripts']['end']['user_main']	= get_js("
jQuery(document).ready(function() {
	$('#company_state').blur(function(){
		getAddress();
	});
	function getAddress(){
		var addr = $('#company_address').val();
		var city = $('#company_city').val();
		var state = $('#company_state').val();
		var zip = $('#company_zip').val();
		var address = addr + ' ' + city + ' ' + state + ' ' + zip;

		var geocoder = new google.maps.Geocoder();
		if (geocoder) {
			geocoder.geocode({ 'address': address }, function (results, status) {
			    if (status == google.maps.GeocoderStatus.OK) {
			    	var coords = results[0].geometry.location;
			    	$('#company_lng').val(coords.lng());
			    	$('#company_lat').val(coords.lat());
			    }
			    else {
			    	alert('Geocoding failed: ' + status);
			    }
		 	});
		}
	}
});
																	  ",TRUE);


		$this->data['javascripts']['endzzz']['google_map_code']	= get_js("
jQuery(document).ready(function() {
	var lat = $('#company_lat').val();
	var lng = $('#company_lng').val();
	var site = $('#company_website').val();
	var cnam = $('#company_name').val();
    if ($('#company_map').length) {
      $('#company_map').gmap({
        'center': lng + ',' +lat ,
        'zoom': 18,
        'disableDefaultUI': true,
        'callback': function() {
          var self = this;
          self.addMarker({
            'position': this.get('map').getCenter()
          }).click(function() {
            self.openInfoWindow({
              'content': '<a href=" . '"' . "' +  site + '" . '"' . " target=blank >Visit ' + cnam + ' on the web!</a>'
            }, this);
          });
        }
      });
    }
});
																	  ",TRUE);


		$this->data['javascripts']['end']['google_map_code']	= get_js("
jQuery(document).ready(function() {

	var lat = $('#company_lat').val();
	var lng = $('#company_lng').val();
	var site = $('#company_website').val();
	var cnam = $('#company_name').val();
	
    var map = new GMaps({
      div: '#company_map',
      lat: $('#company_lat').val(),
      lng: $('#company_lng').val(),
    });

    map.setCenter(lat,lng);
    map.setZoom(18);

    
    map.addMarker({
    	lat:lat,
    	lng:lng,
    	title: cnam,
    	infoWindow: {
    		content:'<a href=" . '"' . "' +  site + '" . '"' . " target=blank >Visit ' + cnam + ' on the web!</a>'
    	}
    });

});
																	  ",TRUE);



     





		$this->data['nav_menu']['buttons']	=   array(
											array(
											 'label'	=> 'Back to Companies',
											 'url'		=> site_url('companies'),
											 'logo'		=> 'fa-angle-left',
											),
											array(
											 'label'	=> 'New Company',
											 'url'		=> site_url('auth/create_company'),
											),
										);

		$this->data['nav_menu']['active']   =   'companies';

		// bail if no group id given
		if(!$id || empty($id))
		{
			redirect('auth/companies', 'refresh');
		}

		$this->data['title'] = 'Edit company';

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin(false,1))
		{
			redirect('auth', 'refresh');
		}

		$company = $this->ion_auth->company($id)->row();

		$group_opts = $this->ion_auth->group_types()->result();
		foreach ($group_opts as $grp) {
			$group_options[$grp->id] = $grp->name;
		}

		//validate form input
		$this->form_validation->set_rules('company_name', 'Name of Company', 'required');
		$this->form_validation->set_rules('group_type', 'Type Of Group', 'required');
		$this->form_validation->set_rules('company_address', 'Company Address', 'required');
		$this->form_validation->set_rules('company_city', 'Company City', 'required');
		$this->form_validation->set_rules('company_state', 'Company State', 'required|exact_length[2]');
		$this->form_validation->set_rules('company_zip', 'Company Zip', 'required');
		$this->form_validation->set_rules('company_phone', 'Company Phone Number', 'required');
		$this->form_validation->set_rules('company_website', 'Company Phone Number', 'required|valid_url');

		if (isset($_POST) && !empty($_POST))
		{
			
			if ($this->form_validation->run() === TRUE)
			{
				$uVals = array(
						'type'		=>$this->input->post('group_type'),
						'address'	=>$this->input->post('company_address'),
						'city'		=>$this->input->post('company_city'),
						'state'		=>$this->input->post('company_state'),
						'zip'		=>$this->input->post('company_zip'),
						'lat'		=>$this->input->post('company_lat'),
						'lng'		=>$this->input->post('company_lng'),
						'phone'		=>preg_replace('/\D+/', '', $this->input->post('company_phone')),
						'fax'		=>preg_replace('/\D+/', '', $this->input->post('company_fax')),
						'website'	=>$this->input->post('company_website'),
						'logo'		=>$this->input->post('company_logo'),
						'company_id'=>$this->input->post('company_id'),
					);
				$company_update = $this->ion_auth->update_company($id, $this->input->post('company_name'), $uVals);

				if($company_update)
				{
					$this->session->set_flashdata('message', 'Company has been updated.');
				}
				else
				{
					$this->session->set_flashdata('message', $this->ion_auth->errors());
				}
				redirect("auth/companies", 'refresh');
			}
		}

		//set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
		//pass the group_types to the view
		//$this->data['group_types'] = $group_types;

		$agreements = $this->ion_auth->get_bcs_agreements($company);

		$this->data['agreements'] = $agreements;


		$this->data['company_name'] = array(
			'name'  => 'company_name',
			'id'    => 'company_name',
			'type'  => 'text',
			'class' => 'gui-input',
			'value' => $this->form_validation->set_value('company_name',$company->name),
		);

		$this->data['group_type'] = array(
			'name'  => 'group_type',
			'options' => $group_options,
			'selected' => $this->form_validation->set_value('group_type',$company->type),
			'additional' => array(
								'id'    => 'group_type',
							),
		);			
		$this->data['company_id'] = array(
			'name'  => 'company_id',
			'id'    => 'company_id',
			'type'  => 'text',
			'class' => 'gui-input',
			'value' => $this->form_validation->set_value('company_id',$company->company_id),
		);

		$this->data['company_address'] = array(
			'name'  => 'company_address',
			'id'    => 'company_address',
			'type'  => 'text',
			'class' => 'gui-input',
			'value' => $this->form_validation->set_value('company_address',$company->address),
		);
		$this->data['company_city'] = array(
			'name'  => 'company_city',
			'id'    => 'company_city',
			'type'  => 'text',
			'class' => 'gui-input',
			'value' => $this->form_validation->set_value('company_city',$company->city),
		);
		$this->data['company_state'] = array(
			'name'  => 'company_state',
			'options' => $this->get_states(),
			'selected' => $this->form_validation->set_value('company_state',$company->state),
			'additional' => array(
								'id'    => 'company_state',
							),
		);
		$this->data['company_zip'] = array(
			'name'  => 'company_zip',
			'id'    => 'company_zip',
			'type'  => 'text',
			'class' => 'gui-input',
			'value' => $this->form_validation->set_value('company_zip',$company->zip),
		);

		$this->data['company_lat'] = array(
			'name'  => 'company_lat',
			'id'    => 'company_lat',
			'type'  => 'text',
			'class' => 'gui-input',
			'value' => $this->form_validation->set_value('company_lat',$company->lat),
		);

		$this->data['company_lng'] = array(
			'name'  => 'company_lng',
			'id'    => 'company_lng',
			'type'  => 'text',
			'class' => 'gui-input',
			'value' => $this->form_validation->set_value('company_lng',$company->lng),
		);

		$this->data['company_phone'] = array(
			'name'  => 'company_phone',
			'id'    => 'company_phone',
			'type'  => 'text',
			'class' => 'gui-input phone_number',
			'value' => $this->form_validation->set_value('company_phone',$company->phone),
		);
		$this->data['company_fax'] = array(
			'name'  => 'company_fax',
			'id'    => 'company_fax',
			'type'  => 'text',
			'class' => 'gui-input fax_number',
			'value' => $this->form_validation->set_value('company_fax',$company->fax),
		);
		$this->data['company_website'] = array(
			'name'  => 'company_website',
			'id'    => 'company_website',
			'type'  => 'text',
			'class' => 'gui-input',
			'value' => $this->form_validation->set_value('company_website',$company->website),
		);
		$this->data['company_logo'] = array(
			'name'  => 'company_logo',
			'id'    => 'company_logo',
			'type'  => 'text',
			'class' => 'gui-input',
			'value' => $this->form_validation->set_value('company_logo',$company->logo),
		);

		if (!$agreements == NULL) {

			$known_agreements = array();
			foreach ($agreements as $agreement) {
				$known_agreements[] = (object) array(
										'id'=>$agreement['agreement_id'],
										'name'=>$agreement['agreement_with']->name,
										'date'=>$agreement['date_started'],
									   );
			}
			$this->data['table_row_data'] = $known_agreements;
			$this->data['table_header_data'] = array('Name', 'Date', 'Action');
			$this->data['table_row_data_fields'] = array(
				'Name'					=> array(
											'type'	=> 'field',
											'value' => 'name'),			
				'Date'					=> array(
											'type'	=> 'field',
											'value' => 'date'),
				'Action'				=> array(
											'type'	=> 'anchor',
											'value' => array('/admin/edit_agreement/', 'id','', 'Edit')),
				);
			$this->data['table_settings'] = array(
				'table_heading'	=>	'BCS Agreements',
				'table_sub_heading'	=>	'for '.$company->name,
				'table_id' => 'company-table',
				'table_new_record_anchors' => array(
												array('/auth/create_agreement','New Agreement'),
											  ),
				);

			$this->_set_view_data('agreements_view','ui/_layout_table_data');
		}
		




		$subView = 'auth/edit_company';
		$mainView = 'ui/_layout_main';
		$this->load_structure($subView,$mainView,TRUE);
		//$this->_render_page('auth/edit_group', $this->data);
	}

	function group_types(){
			//$this->data['stylesheets']['end']['admin-forms']	= NULL;
		$this->data['stylesheets']['top']['datatables_bootstrap'] 	= get_css('vendor/plugins/datatables/media/css/dataTables.bootstrap.css');
		$this->data['stylesheets']['top']['datatables_plugin']		= get_css('vendor/plugins/datatables/media/css/dataTables.plugins.css');

		$this->data['javascripts']['mid']['jquery_datatables']		= get_js('vendor/plugins/datatables/media/js/jquery.dataTables.js');
		$this->data['javascripts']['mid']['datatables_bootstrap']	= get_js('vendor/plugins/datatables/media/js/dataTables.bootstrap.js');

		$this->data['javascripts']['end']['companies_main']				= get_js('
	jQuery(document).ready(function() {

		"use strict";
		// Init DataTables
		$("#users-table").dataTable({
	      "sDom": \'t<"dt-panelfooter clearfix"ip>\',
	      "oTableTools": {
	        "sSwfPath": "vendor/plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf"
	      }
	    });

	});
																	  ',TRUE);

		#users-table

		$this->data['title'] = 'Group Types';
		$this->data['body_class'] = 'datatables-page sb-l-o sb-r-c onload-check';
		$this->data['nav_menu']['active']   =   'group_types';
		$this->data['nav_menu']['buttons']	=   NULL;

		
		//set the flash data error message if there is one
		$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

		//get the current users level
		$this->data['cur_user_level'] = intval($this->session->userdata('user_group_level'));
		$this->data['cur_user_group_type'] = intval($this->session->userdata('user_group_type'));

		//list the group_types
		$this->data['group_types'] = $this->ion_auth->group_types()->result();	

		$subView = 'auth/group_types';
		$mainView = 'ui/_layout_main';
		$this->load_structure($subView,$mainView,TRUE);	
	}

	function _get_csrf_nonce()
	{
		$this->load->helper('string');
		$key   = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);
		return array($key => $value);
	}

	function _valid_csrf_nonce()
	{
		return TRUE;
		
		if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE &&
			$this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue'))
		{      
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	function _render_page($view, $data=null, $render=false)
	{

		$this->viewdata = (empty($data)) ? $this->data: $data;

		$view_html = $this->load->view($view, $this->viewdata, $render);

		if (!$render) return $view_html;
	}

//Screen Locking From Here
	function screenlock()
	{

		if (!$this->ion_auth->logged_in())
		{

			//redirect them to the login page
			redirect('auth/login', 'refresh');
		}


		$this->data['body_class'] = 'external-page external-alt sb-l-c sb-r-c onload-check';
		$this->data['javascripts']['mid']['bs-timeout'] = NULL;
		$this->data['javascripts']['end']['screen_lock_code'] = NULL;		
		$this->data['title'] = 'BUCOSU is Locked';
		$this->data['javascripts']['end']['time_locked'] = get_js("
	jQuery(document).ready(function() {

		'use strict';

		var start = new Date;
		setInterval(function() {
			if (getTimeDiff(start) >= 1){
				location.href = 'http://bucosu.com/logout';
			}
		}, 1000);

		function getTimeDiff(startTime){
			// later record end time
			var endTime = new Date();

			// time difference in ms
			var timeDiff = endTime - startTime;

			// strip the ms
			timeDiff /= 1000;

			// get seconds (Original had 'round' which incorrectly counts 0:28, 0:29, 1:30 ... 1:59, 1:0)
			var seconds = Math.round(timeDiff % 60);

			// remove seconds from the date
			timeDiff = Math.floor(timeDiff / 60);

			// get minutes
			var minutes = Math.round(timeDiff % 60);

			// remove minutes from the date
			timeDiff = Math.floor(timeDiff / 60);

			// get hours
			var hours = Math.round(timeDiff % 24);

			return hours;
		}
	});
",TRUE);

		$this->data['javascripts']['end']['timer_locked'] = get_js('
function DaysHMSCounter(initDate, id){
    this.counterDate = new Date(initDate);
    this.container = document.getElementById(id);
    this.update();
}
 
DaysHMSCounter.prototype.calculateUnit=function(secDiff, unitSeconds){
    var tmp = Math.abs((tmp = secDiff/unitSeconds)) < 1? 0 : tmp;
    return Math.abs(tmp < 0 ? Math.ceil(tmp) : Math.floor(tmp));
}
 
DaysHMSCounter.prototype.calculate=function(){
    var secDiff = Math.abs(Math.round(((new Date()) - this.counterDate)/1000));
    this.days = this.calculateUnit(secDiff,86400);
    this.hours = this.calculateUnit((secDiff-(this.days*86400)),3600);
    this.mins = this.calculateUnit((secDiff-(this.days*86400)-(this.hours*3600)),60);
    this.secs = this.calculateUnit((secDiff-(this.days*86400)-(this.hours*3600)-(this.mins*60)),1);
}
 
DaysHMSCounter.prototype.update=function(){ 
    this.calculate();
    this.container.innerHTML =
        " <strong>" + this.days + "</strong> " + (this.days == 1? "day" : "days") +
        " <strong>" + this.hours + "</strong> " + (this.hours == 1? "hour" : "hours") +
        " <strong>" + this.mins + "</strong> " + (this.mins == 1? "min" : "mins") +
        " <strong>" + this.secs + "</strong> " + (this.secs == 1? "sec" : "secs");
    var self = this;
    setTimeout(function(){self.update();}, (1000));
}

var start = new Date;
window.onload=function(){ new DaysHMSCounter(start, "logged_out_time"); }
			',TRUE);
		
		$method = NULL;

		if 	($this->session->userdata('fromscreen')){
			$fromScreen = $this->session->fromscreen;
		} else {
			$fromScreen = site_url();
		}

		$urlStr = parse_url($_SERVER['REQUEST_URI']);
		if(isset($urlStr['query'])){
			$urlQuery = $urlStr['query'];
			parse_str($urlQuery,$result);
			if ($result['method']) {
				$method = $result['method'];
			}
			if ($result['fromscreen']) {
				$fromScreen = $result['fromscreen'];
				$this->session->set_userdata(array('fromscreen'=>$fromScreen));
			}
		}

		if ($method == 'autolockout') { 
			$this->ion_auth->lockscreen();
		}
		
		if ($this->ion_auth->screenlocked() == FALSE) {
			redirect($fromScreen);
		}
		$this->load_site();

		$this->load->helper('security');
		$rulez = array(
		'password' => array(
			'field' => 'user_password', 
			'label' => 'Password', 
			'rules' => 'trim|required'
			),
		);
		$this->form_validation->set_rules($rulez);
		$this->form_validation->set_error_delimiters('<br /><span class="error">', '</span>');

		if ($this->form_validation->run() == TRUE) {
			// We can login and redirect
			if ($this->ion_auth->unlockscreen()) {
				redirect($fromScreen);
			} else {
				$this->session->set_flashdata('error', 'That password was wrong');
				redirect('auth/screenlock');
			}
		} else {
			$this->session->set_flashdata('error', 'Form did not validate');
		}
		$this->_set_view_data('subview','auth/screenlock');
		$this->load_view('ui/_layout_modal');
	}




	function get_states()
	{
		return array(

                              ""=>"Choose state",
                              "AL"=>"Alabama",
                              "AK"=>"Alaska",
                              "AZ"=>"Arizona",
                              "AR"=>"Arkansas",
                              "CA"=>"California",
                              "CO"=>"Colorado",
                              "CT"=>"Connecticut",
                              "DE"=>"Delaware",
                              "DC"=>"District Of Columbia",
                              "FL"=>"Florida",
                              "GA"=>"Georgia",
                              "HI"=>"Hawaii",
                              "ID"=>"Idaho",
                              "IL"=>"Illinois",
                              "IN"=>"Indiana",
                              "IA"=>"Iowa",
                              "KS"=>"Kansas",
                              "KY"=>"Kentucky",
                              "LA"=>"Louisiana",
                              "ME"=>"Maine",
                              "MD"=>"Maryland",
                              "MA"=>"Massachusetts",
                              "MI"=>"Michigan",
                              "MN"=>"Minnesota",
                              "MS"=>"Mississippi",
                              "MO"=>"Missouri",
                              "MT"=>"Montana",
                              "NE"=>"Nebraska",
                              "NV"=>"Nevada",
                              "NH"=>"New Hampshire",
                              "NJ"=>"New Jersey",
                              "NM"=>"New Mexico",
                              "NY"=>"New York",
                              "NC"=>"North Carolina",
                              "ND"=>"North Dakota",
                              "OH"=>"Ohio",
                              "OK"=>"Oklahoma",
                              "OR"=>"Oregon",
                              "PA"=>"Pennsylvania",
                              "RI"=>"Rhode Island",
                              "SC"=>"South Carolina",
                              "SD"=>"South Dakota",
                              "TN"=>"Tennessee",
                              "TX"=>"Texas",
                              "UT"=>"Utah",
                              "VT"=>"Vermont",
                              "VA"=>"Virginia",
                              "WA"=>"Washington",
                              "WV"=>"West Virginia",
                              "WI"=>"Wisconsin",
                              "WY"=>"Wyoming",
                              );
	}
}
