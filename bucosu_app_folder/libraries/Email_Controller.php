<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email_Controller extends Admin_Controller 
{

	function __construct()
	{
		parent::__construct();
		
		$config['protocol']	= 'smtp';
		$config['smtp_host'] = 'ssl://smtp.googlemail.com';
		$config['smtp_port'] = 465;
		$config['smtp_user'] = 'lloydaboone@gmail.com';
		$config['smtp_pass'] = 'Jbakids#3';

		$this->load->library('email',$config);
		$this->email->set_newline("\r\n");
	}
}