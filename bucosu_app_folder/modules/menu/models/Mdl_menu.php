<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Mdl_menu extends MY_Model {
											
	protected $_table_name = 'v_menues';			
	protected $_order_by = 'parent , sort';


	function __construct(){
		parent::__construct();
	}

}