<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php
class Home extends Frontend_Controller {

	public function __construct(){
		parent::__construct();
	}

	public function index() 
	{
		$subview = "home_view";
		$mainview = "ui/_layout_main";
		$this->load_structure($subview,$mainview);
	}

	/*
	 * used to sent confirmation messages to the user.
	 *
	 * @param $whatkind 
	 *		'pres' = Password Reset Email Sent
	 *		''
	 */

	public function confirm($whatkind = 'pres',$data = NULL)
	{
		if ($whatkind == 'pres') 
		{
			if ($data) 
			{

				$this->data['javascripts']['end']['forgot_password_form_submit'] = get_js('
	jQuery(document).ready(function() {

		"use strict";
		$( "#presv_btn" ).click(function() {
  			window.location="' . site_url() . '";
		});
	});
																			',TRUE);

				$this->data['email_sent_to'] = $data;
				$this->data['body_class'] = 'blank-page sb-l-c sb-r-c onload-check';
				$subview = 'confirm/password_reset_email_sent_view';
				$mainview = 'ui/_layout_modal';
				$this->load_structure($subview,$mainview);
				return TRUE;
			}
		}
		redirect('/');
	}

	public function get_session_user_data()
	{
		if ($this->is_user_logged_in() == FALSE) {
			redirect(site_url() . 'login');
		}
		$this->data['session_user_data'] = $this->session->get_userdata();
		$this->data['stylesheets']['end']['admin_forms'] = get_js('assets/admin-tools/admin-forms/css/admin-forms.css');
		$this->data['body_class'] = 'ui-tabs-page sb-l-o sb-r-c mobile-view tray-rescale onload-check';

		$subview = "session_user_data_view";
		$mainview = "ui/_layout_main";
		$this->load_structure($subview,$mainview);

	}
}


