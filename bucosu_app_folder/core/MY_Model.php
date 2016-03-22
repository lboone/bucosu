<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class MY_Model extends CI_Model {

	protected $_table_name = '';
	protected $_primary_key = 'id';
	protected $_primary_filter = 'intval';
	protected $_order_by = '';
	public $rules = array();
	protected $_timestamps = FALSE;

	function __construct(){
		parent::__construct();
	}

	public function set_table($tableName){
		$this->_table_name = $tableName;
	}

	public function set_order_by($orderBy){
		$this->_order_by = $orderBy;
	}

	public function get($id = NULL, $single = FALSE){
		if ($id != NULL) {
			$filter = $this->_primary_filter;
			$id = $filter($id);
			$this->db->where($this->_primary_key, $id);
			$method = 'row';

		} elseif ($single == TRUE) {
			$method = 'row';

		} else {
			$method = 'result';
		}

		$this->db->order_by($this->_order_by);
		
		return $this->db->get($this->_table_name)->$method();
	}


	public function get_by($where, $single = FALSE){
		$this->db->where($where);
		return $this->get(NULL, $single);

	}

	public function save($data, $id = NULL){

		// Set timestamps
		if ($this->_timestamps == TRUE) {
			$now = date('Y-m-d H:i:s');
			$id || $data['created'] = $now;
			$data['modified'] = $now;
			$uData = $this->session->userdata('user_id');
			$id || $data['created_by'] = $uData;
			$data['modified_by'] = $uData;
		}

		//Insert
		if($id === NULL) {
			!isset($data[$this->_primary_key]) || $data[$this->_primary_key] = NULL;
			$this->db->set($data);
			$this->db->insert($this->_table_name);
			$id = $this->db->insert_id();
		}
		//Update
		else{
			$filter = $this->_primary_filter;
			$id = $filter($id);
			$this->db->set($data);
			$this->db->where($this->_primary_key, $id);
			$this->db->update($this->_table_name);
			if ($this->db->affected_rows()>0) {
				return $id;
			} else {
				return null;
			}
		}

		return $id;
	}



	public function save_batch($data){

		$nArr = array();

		if ($this->_timestamps == TRUE) {

			$now = date('Y-m-d H:i:s');
			$uData = $this->session->userdata('user_id');
			foreach ($data as $key => $value) {

				$arr = $value;
				$arr['created'] 	= $now;
				$arr['modified'] 	= $now;
				$arr['created_by'] 	= $uData;
				$arr['modified_by'] = $uData;

				$nArr[$key] = $arr;
			}
		} else {
			$nArr = $data;
		}

		$rslt = $this->db->insert_batch($this->_table_name,$nArr);
		if (intval($rslt) == count($nArr)) 
		{
			return intval($rslt);
		} else {
				return false;
		}
	}


	public function save_where($data,$where){
		// Set timestamps
		if ($this->_timestamps == TRUE) {
			$now = date('Y-m-d H:i:s');
			$data['modified'] = $now;
			$uData = $this->session->userdata('user_id');
			$data['modified_by'] = $uData;
		}

		$this->db->set($data);
		$this->db->where($where);
		$id = $this->db->update($this->_table_name);
		return $id;
	}

	public function delete($id){
		$filter = $this->_primary_filter;
		$id = $filter($id);

		if(!$id) {
			return FALSE;
		}

		$this->db->where($this->_primary_key, $id);
		$this->db->limit(1);
		$this->db->delete($this->_table_name);
		return true;

	}

	public function delete_by($where)
	{
		$this->db->where($where);
		$this->db->delete($this->_table_name);
		return true;
	}

}