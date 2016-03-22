<?php
defined('BASEPATH') OR exit('No direct script access allowed');

abstract class Admin_Controller extends Authorized_Controller 
{

	function __construct()
	{
		parent::__construct();
		$this->data['title'] = 'Dashboard';
		$this->_checkAdmin();
	}


	
	function _checkAdmin()
	{
		// Login check
		$exception_uris = array(
			'auth/login',
			'login',
			'auth/logout',
			'logout',
			'auth/forgot_password',
			'forgot_password',
			'auth/reset_password',
			'reset_password',
			'auth/screenlock',
			'screenlock',
			'auth/change_password',
			'change_password',
			);
		
		foreach ($exception_uris as $value) {
			if (stripos(uri_string(),$value) !== FALSE) {
					return TRUE;
			}
		}


//		if(in_array(uri_string(), $exception_uris) == FALSE )
//		{	
			if (!$this->ion_auth->is_admin()) //remove this elseif if you want to enable this for non-admins
			{

				$this->_show_401();
				

			}
//		}
	}

}