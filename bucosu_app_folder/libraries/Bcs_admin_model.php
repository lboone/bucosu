<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Bcs_admin_model extends MY_Model {

	protected $_table_name = '';
	protected $_primary_key = 'id';
	protected $_primary_filter = 'intval';
	protected $_order_by = 'order';
	protected $_timestamps = FALSE;

	protected $_config = array(
    	'table' => '',
    	'id' => 'id',
    	'field' => 'slug',
    	'title' => 'Slug',
    	'replacement' => 'dash' // Either dash or underscore
	);


	function __construct(){
		parent::__construct();
	}


	public function set_table_name($table_name)
	{
		$this->_table_name = $table_name;
	}

	public function get_table_name()
	{
		return $this->_table_name;
	}

	public function set_primary_key($primary_key)
	{
		$this->_primary_key = $primary_key;	
	}
	public function get_primary_key()
	{
		return $this->_primary_key;
	}
	
	public function set_order_by($order_by)
	{
		$this->_order_by = $order_by;
	}

	public function get_order_by()
	{
		return $this->_order_by;
	}


	public function reset_model($tableName = '', $order_by = 'order', $primary_key = 'id'){
		$this->set_table_name($tableName);
		$this->set_primary_key($primary_key);
		$this->set_order_by($order_by);
	}


	public function get_id($slug = ''){

		if (empty($slug)) { return FALSE; }


		if (is_numeric($slug)) {
			$filter = $this->_primary_filter;
			return $filter($slug);
		}

		$params = array(
			'slug' => $slug
		);

		$hdngs = $this->get_by($params,TRUE);
		
		return $hdngs->id;
	}

	public function get_slug($id = ''){

		if ( empty($id) ) { return FALSE; }

		if ( !is_numeric($id) ) { return $id; }

		$hdngs = $this->get($id);
		return $hdngs->slug;
	}


	public function return_slug($name, $id = NULL)
	{
		$this->load->library('slug', $this->_config);

		$data = array( 
				'slug'=>$name,
			);
		return $this->slug->create_uri($data,$id);
	}


	public function to_permalink($str)
	{
		if($str !== mb_convert_encoding( mb_convert_encoding($str, 'UTF-32', 'UTF-8'), 'UTF-8', 'UTF-32') )
			$str = mb_convert_encoding($str, 'UTF-8', mb_detect_encoding($str));
		$str = htmlentities($str, ENT_NOQUOTES, 'UTF-8');
		$str = preg_replace('`&([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i', '\\1', $str);
		$str = html_entity_decode($str, ENT_NOQUOTES, 'UTF-8');
		$str = preg_replace(array('`[^a-z0-9]`i','`[-]+`'), '-', $str);
		$str = strtolower( trim($str, '-') );
		return $str;
	}

}