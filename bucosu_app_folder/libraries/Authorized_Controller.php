<?php
defined('BASEPATH') OR exit('No direct script access allowed');

abstract class Authorized_Controller extends MY_Controller 
{

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth'));
		$this->load->helper(array('language'));
		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
		$this->lang->load('auth');

		$this->data['title'] = 'BUCOSU BCS';
		$this->_checkLogin();
		$this->_checkScreenLocked();
		
		$this->data['javascripts']['mid']['bs-timeout'] = get_js('vendor/plugins/bstimeout/bs-timeout.min.js'); 
		
		$this->data['javascripts']['end']['screen_lock_code'] = get_js("
  jQuery(document).ready(function() {

    'use strict';

    // Init Bootstrap Timeout Demo
    $.sessionTimeout({
        keepAliveUrl: '',
        logoutUrl: '" . site_url() . "logout/',
        redirUrl:   '" . site_url() . "screenlock?method=autolockout&fromscreen=' + window.location.href,
        warnAfter:  9000000,
        redirAfter: 9600000,
        countdownBar: true,
        countdownMessage: 'Redirecting in {timer} seconds.',
        onStart: function (opts) {},
    });

  });
", TRUE);
	}


	
	function _checkLogin()
	{
		// Login check
		$exception_uris = array(
			'auth/login',
			'login',
			'auth/logout',
			'logout',
			'auth/forgot_password',
			'auth/reset_password/',
			'auth/screenlock',
			'screenlock',
			);
		

		foreach ($exception_uris as $value) {
			if (stripos(uri_string(),$value) !== FALSE) {
					return TRUE;
			}
		}

//		if(in_array(uri_string(), $exception_uris) == FALSE )
//		{	
			
			if (!$this->ion_auth) 
			{
				//redirect them to the login page
				redirect('auth/login');
			} 
			elseif (!$this->ion_auth->logged_in())
			{
				//redirect them to the login page
				redirect('auth/login');
			} 
			elseif (intval($this->session->userdata('user_group_level')) > 899) //This is a public user they should not see this area.
			{
				$this->_show_401();
			}
//		}
	}

	function _checkScreenLocked()
	{
		// Check if user has been locked
		$exception_uris = array(
			'auth/login',
			'login',
			'auth/logout',
			'logout',
			'auth/screenlock',
			'screenlock',
			'auth/change_password',
			);

		foreach ($exception_uris as $value) {
			if (stripos(uri_string(),$value) !== FALSE) {
					return TRUE;
			}
		}


//		if (in_array(uri_string(), $exception_uris) == FALSE ) {
			if ($this->ion_auth->screenlocked() == TRUE) {
				redirect('auth/screenlock');
			}
//		}
	}

	function _show_401(){
				//redirect them to the home page because they must be an administrator to view this
				$this->data['body_class'] = 'error-page alt sb-l-o sb-r-c';
				$this->data['javascripts']['mid']['bs-timeout'] = NULL; 
				$this->data['javascripts']['end']['screen_lock_code'] = NULL;	
				$this->data['logo']['class'] = 'center-block img-responsive';
				$this->_set_view_data('subview','errors/html/error_401');
				$this->data['title'] = 'BUCOSU | Forbidden Area';

				$this->data['javascripts']['end']['disable_span_click'] = get_js('
	jQuery(document).ready(function() {

		"use strict";
		$("#toggle_sidemenu_l").hide();

	});
					'



					,TRUE);
				$this->load_site();		
				$this->data['topbar_view'] = NULL;	
				$this->data['sidebar_left_view'] = NULL;	
				$this->_set_view_data('mainview','ui/_layout_main');


				//header( "refresh:5;url=" . site_url() . "" );
				
				//return show_error('You must be an administrator to view this page.');
				return show_error($this->data['mainview'],401);
	}
}