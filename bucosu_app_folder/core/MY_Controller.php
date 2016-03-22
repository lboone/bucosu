<?php
defined('BASEPATH') OR exit('No direct script access allowed');


abstract class MY_Controller extends MX_Controller {

	public $data = array();
	
	function __construct(){
		parent::__construct();

		$this->_load_css_and_js_files();

		//Set some final values for the data array
		$this->data['errors'] = array();
		$this->data['site_name'] = $this->config_item('site_name');
		$this->data['body_class'] = 'blank-page sb-l-o sb-r-c mobile-view tray-rescale onload-check';
		$this->data['logo'] = array(
									'src'	=> site_url('assets/img/logos/logo_116x116.png'),
									'title'	=> 'Bucosu',
									'class' => 'center-block img-responsive',
									'style' => 'max-width: 275px;',
								);

		$this->data['login_link'] = array(
											'href'	=> site_url('auth/change_password'),
											'class' => '',
											'title' => 'Change Password',

			);
	}


	// Used for autoloading subview, site structure and mainview
	public function load_structure($subView,$mainView,$menu = FALSE){
		$this->_set_view_data('subview',$subView);
		$this->load_site($menu);		
		$this->load_view($mainView);
	}

	public function load_view($vName, $dataVal = NULL, $retVal = FALSE){
		if (!is_array($dataVal)) { $dataVal = $this->data; }
		if ($retVal) {
			return $this->load->view($vName, $dataVal, $retVal);
		}
		$this->load->view($vName,$dataVal);
	}

	public function load_site($menu = FALSE){
		$this->_set_view_data('_header_view','ui/inc/_header_view');
		$this->_set_view_data('theme_settings_panel_view','ui/theme_settings_panel_view');
		
		// Set up the login/out label & url for the header
		// Set up the user name and logo

		//The default
		$lio_url = site_url('auth/login');
		$lio_url_cpw = NULL;
		$lio_label = 'Log In/Register';
		$u_nam = 'Guest';
		$u_email = 'Please Login In/Register';
		$u_company = 'Public';
		$u_company_url = site_url();
		$u_type = 'Public';
		$u_group = 'Non-Member';
		

		// If the user is logged in change default
		if ($this->is_user_logged_in()) {	
			$lio_url = site_url('auth/logout');
			$lio_url_cpw = site_url('auth/change_password');
			$lio_label = 'Log Out';
			$u_nam = $this->session->userdata('username');
			$u_email = $this->session->userdata('email');
			$u_company = $this->session->userdata('company')->name;
			$u_company_url = $this->session->userdata('company')->website;
			$u_type = $this->session->userdata('user_group_type_name');
			$u_group = $this->session->userdata('user_group_name');

			$this->data['menu_user_group'] = array
												(
													'type' => $this->session->userdata['user_group_type'],
													'level' => $this->session->userdata['user_group_level'],
												);
		} else {
			$this->data['menu_user_group'] = array
												(
													'type' => 4,
													'level' => 999,
												);
		}
		//Set log_in_out data array
		$this->data['log_in_out'] = array(
							'url' => $lio_url,
							'url_cpw' => $lio_url_cpw,
							'label' => $lio_label,
			);
		//Set user_name_logo data array
		$this->data['user_name_logo'] = array(
							'name' => $u_nam,
							'logo' => $this->get_user_logo(),
							'email'=> $u_email,
							'company' => $u_company,
							'url'  => $u_company_url,
							'type' => $u_type,
							'group'=> $u_group,
			);

		$this->_set_view_data('navbar_header_view','ui/navbar_header_view');
		$this->_set_view_data('sidebar_left_view','ui/sidebar_left_view');
		$this->_set_view_data('topbar_dropdown_view','ui/topbar_dropdown_view');
		$this->data['bread_crumbs'] = $this->get_crumbs();

		if ($menu) {
			$this->_set_view_data('topbar_view','ui/topbar_auth_view');
		} else {
			$this->_set_view_data('topbar_view','ui/topbar_view');
		}
		
		if (!isset($this->data['sidebar_right_view'])) {
			$this->_set_view_data('sidebar_right_view','ui/sidebar_right_view');
		}
		
		$this->_set_view_data('_footer_view','ui/inc/_footer_view');
	}

	public function config_item($itemName){
		return $this->config->item($itemName);
	}


	protected function _set_view_data($dataName, $viewName, $dataVal = NULL ){
		$this->data[$dataName] = $this->load_view($viewName,$dataVal, TRUE);
	}

	protected function _load_css_and_js_files(){
		//Setup the stylesheets, javascripts & footer variables
		$this->data['stylesheets'] =	array(
											'font'	=> array(
																'open_sans' 	=> get_css('http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700'),
															),
											'theme'	=> array(
																'default_theme' =>get_css('assets/skin/default_skin/css/theme.css'),
															),
											'top'	=> array(),
											'end'	=> array(),
										);

		$this->data['javascripts'] =	array(
											'header'	=> array(),
											'jquery'	=> array(
																	'jquery_1.11.1'	=> get_js('vendor/jquery/jquery-1.11.1.min.js'), 
																	'jquery_ui'		=> get_js('vendor/jquery/jquery_ui/jquery-ui.min.js'),
																),
											'theme'		=> array(
																	'utility'		=> get_js('assets/js/utility/utility.js'),
																	'main'			=> get_js('assets/js/main.js'),
																),
											'top'		=> array(),
											'mid'		=> array(),
											'end'		=> array(	'main'			=> get_js('assets/js/custom.js'),
																	'core'			=> get_js('
	jQuery(document).ready(function() {

		"use strict";

		// Init Theme Core    
		Core.init();

		// Fullscreen Functionality
		var screenCheck = $.fullscreen.isNativelySupported();

		// Attach handler to navbar fullscreen button
		$(".request-fullscreen").click(function() {

		 // Check for fullscreen browser support
		 if (screenCheck) {
		    if ($.fullscreen.isFullScreen()) {
		       $.fullscreen.exit();
		    } else {
		       $("html").fullscreen({
		          overflow: "visible"
		       });
		    }
		 } else {
		    alert("Your browser does not support fullscreen mode.")
		 }
		});

		var pgurl = window.location.href; 
		
    	$(".sidebar-menu a").each(function(){
    		
        	if($(this).attr("href") == pgurl){
        		$(this).parent("li").addClass("active");
        		$(this).parent("li").parent("ul").siblings(".accordion-toggle").addClass("menu-open");;
        	};
     	});
	});
																			',TRUE),
																),
										);
		$this->data['javascripts'] =	array(
												'header'	=> array(),
												'jquery'	=> array(
																		'my_controller_compressed'	=> get_js('assets/js/my_controller_compressed.js'),
																	),
												'theme'		=> array(),
												'top'		=> array(),
												'mid'		=> array(),
												'end'		=> array(
																		'main'						=> get_js('assets/js/custom.js'),
																	),
											);
		$this->data['footer'] = array();

	}


	public function is_user_logged_in()
	{
		$un = $this->session->userdata('user_id');
		if (empty($un)) {
			return FALSE;
		} else {
			return TRUE;
		}
	}

	public function get_user_logo() 
	{
		$logo = site_url() . 'assets/img/avatars/placeholder.png';
		if (!$this->is_user_logged_in())
		{
			return $logo;
		}
		$co = $this->session->userdata('company');
		if (is_null($co)) {
			return $logo;
		}
		if (empty($co->logo)) {
			return $logo;
		}
		$logo = site_url() . 'attachments/user/company/' . $co->id . '/' . $co->logo;
		return $logo;
	}

	public function get_crumbs()
	{
		$path = $_SERVER["REQUEST_URI"];
		$parts = explode('/',$path);
		$paths = array();
		$paths[] = array('url'=>'/', 'label' => 'HOME');

		if (count($parts) < 2)
		{
			return $paths;
		}
		else
		{
			for ($i = 1; $i < count($parts); $i++)
		    {	
		    	if (trim($parts[$i]) !== '') {
			    	if (!strstr($parts[$i],"."))
			    	{
			    		if(strstr($parts[$i],"?")){
				    	    $str = $parts[$i];
				    	    $pos = strrpos($str,"?");
				    	    $parts[$i] = substr($str, 0, $pos);
				    	    $paths[] = array('url' => '', 'label' => strtoupper(str_replace('_', ' ' ,str_replace('-', ' ', $parts[$i]))),);

			    		} else {
				    		$prt = '/';
				    	    for ($j = 1; $j <= $i; $j++)
				    	    {
				    	    	$prt .= $parts[$j]."/";
				    	    }
				    	    $paths[] = array('url' => $prt, 'label' => strtoupper(str_replace('_', ' ' ,str_replace('-', ' ', $parts[$i]))),);	
			    		}
			    		
			    	}
			    	else
			    	{
			    	    $str = $parts[$i];
			    	    $pos = strrpos($str,".");
			    	    $parts[$i] = substr($str, 0, $pos);
			    	    $paths[] = array('url' => '', 'label' => strtoupper(str_replace('_', ' ' ,str_replace('-', ' ', $parts[$i]))),);
			    	}
		    	}
			}
		}
		return $paths;
	}



}