<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Frontend_Controller extends MY_Controller 
{

	function __construct()
	{
		parent::__construct();
		$this->data['title'] = 'BUCOSU';
	}
}