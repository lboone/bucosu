<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Mdl_bcs_questions_school extends MY_Model {
											// DEFAULTS:
	protected $_table_name = 'bcs_questions_school';			// ALWAYS ADD 
	protected $_order_by = 'question_id';				// ----------

	protected $_primary_key = 'id';			// REMOVE IF SAME / CHANGE IF DIFFERENT
	protected $_primary_filter = 'intval';	// ------------------------------------
	protected $_timestamps = TRUE;			// ------------------------------------

	public $rules = array();				// REMOVE IF NOT NEEDED / ADD IF NEEDED
	

	function __construct(){
		parent::__construct();
	}

	
}