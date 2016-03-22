<?php
class Dashboard_model extends MY_Model 
{
	protected $_table_name = '';
	protected $_primary_key = 'id';
	protected $_primary_filter = 'intval';
	protected $_order_by = '';

	public function __construct()
	{
		parent::__construct();
	}

	function index(){

	}


}