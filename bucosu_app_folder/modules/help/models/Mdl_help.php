<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Mdl_help extends MY_Model {
											// DEFAULTS:
	protected $_table_name = 'help';			// ALWAYS ADD 
	protected $_order_by = 'type, id';				// ----------

	protected $_primary_key = 'id';			// REMOVE IF SAME / CHANGE IF DIFFERENT
	protected $_primary_filter = 'intval';	// ------------------------------------
	protected $_timestamps = FALSE;			// ------------------------------------
	

	function __construct(){
		parent::__construct();
	}

}