<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php
class Authorized extends Authorized_Controller {

	public function __construct(){
		parent::__construct();

	/*
	 * -------------------------
	 * Load the model for the matching controller
	 * -------------------------
	 */
		$this->load->model('');
	}

	public function index() 
	{
		$this->data['title'] = "";
		$subview = '';
		$mainview = "ui/_layout_main";
		$this->load_structure($subview,$mainview);
	}
}
