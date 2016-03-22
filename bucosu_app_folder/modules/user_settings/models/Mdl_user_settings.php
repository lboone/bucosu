<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Mdl_user_settings extends MY_Model {
											// DEFAULTS:
	protected $_table_name = 'users_settings';			// ALWAYS ADD 
	protected $_order_by = 'user_id';				// ----------

	protected $_primary_key = 'id';			// REMOVE IF SAME / CHANGE IF DIFFERENT
	protected $_primary_filter = 'intval';	// ------------------------------------
	protected $_timestamps = FALSE;			// ------------------------------------

	public $rules = array();				// REMOVE IF NOT NEEDED / ADD IF NEEDED
	

	function __construct(){
		parent::__construct();
	}

}