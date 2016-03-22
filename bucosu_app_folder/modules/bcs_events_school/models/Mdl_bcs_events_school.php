<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Mdl_bcs_events_school extends MY_Model {
											// DEFAULTS:
	protected $_table_name = 'v_bcs_events_school';			// ALWAYS ADD 
	protected $_order_by = 'school_name';				// ----------

	protected $_primary_key = 'id';			// REMOVE IF SAME / CHANGE IF DIFFERENT
	protected $_primary_filter = 'intval';	// ------------------------------------
	protected $_timestamps = FALSE;			// ------------------------------------
	

	function __construct(){
		parent::__construct();
	}

}