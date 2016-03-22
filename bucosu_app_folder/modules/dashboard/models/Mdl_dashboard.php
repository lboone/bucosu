<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Mdl_dashboard extends MY_Model {
											// DEFAULTS:
	protected $_table_name = 'd_sd_school_dashboard_details';			// ALWAYS ADD 
	protected $_order_by = '';				// ----------

	protected $_primary_key = 'event_school_id';			// REMOVE IF SAME / CHANGE IF DIFFERENT
	protected $_primary_filter = 'intval';	// ------------------------------------
	protected $_timestamps = FALSE;			// ------------------------------------

	protected $_sd_school_count = 0;
	protected $_bcs_profile_count = 0;
	protected $_sd_completed = '%0.0';
	protected $_sd_cost = '0';
	protected $_sd_critical = '0';

	public $rules = array();				// REMOVE IF NOT NEEDED / ADD IF NEEDED
	

	function __construct(){
		parent::__construct();
	}

	function init($esd = null){
		if (!$esd) {
			return false;
		}

		$rslts = $this->get_by(array('event_sd_id'=>$esd));
		if ($rslts) {
			$this->_set_sd_school_count(count($rslts));
			$this->_set_bcs_profile_count();
			$this->_set_sd_complete_cost_critical($esd);
			return true;
		} else {
			return false;
		}
	}

	/* School District School Count
	 * set - integer
	 * get - integer
	 */
	private function _set_sd_school_count($cnt = 0) {

		$this->_sd_school_count = $cnt;
	}
	function get_sd_school_count(){
		return $this->_sd_school_count;
	}

	/* BCS Profile Count
	 * set - using a mysql query
	 * get - integer
	 */
	private function _set_bcs_profile_count() {
		 	$this->db->where('active','1');
		 	$this->db->from('bcs_profiles');
		 	$this->_bcs_profile_count = $this->db->count_all_results();
	}
	function get_bcs_profile_count(){
		return $this->_bcs_profile_count;
	}

	/* Complete / Cost / Critical
	 * set - school district event id
	 * get - none
	 */
	private function _set_sd_complete_cost_critical($esd){
		$this->db->select_sum('c','sum_c');
		$this->db->select_sum('estimated_cost','sum_cost');
		$this->db->select_sum('total_completed_bcs_profiles','sum_complete');
		$this->db->group_by('event_sd_id');
		$this->db->having(array('event_sd_id'=>$esd));
		$rslt = $this->db->get('d_sd_school_dashboard_details')->row();

		if ($rslt) {
			$this->_set_sd_completed($rslt->sum_complete);
			$this->_set_sd_cost($rslt->sum_cost);
			$this->_set_sd_critical($rslt->sum_c);
			return true;
		} else {
			return false;
		}
	}

	private function _set_sd_completed($completed){
		if ( $completed > 0 ) {
			$sch = $this->get_sd_school_count();
			$pro = $this->get_bcs_profile_count();
			$tot = $sch * $pro;
			$nbr = ($completed/$tot);
		} else {
			$nbr = 0;
		}
		$this->_sd_completed = $nbr;
	}
	function get_sd_completed(){
		return $this->_sd_completed;
	}
	function get_sd_completed_formated(){
		return percent($this->get_sd_completed());
	}


	private function _set_sd_cost($cost){
		
		if ($cost == null) {
			$this->_sd_cost = 0.0;
		} else {
			$this->_sd_cost = $cost;
		}
	}
	function get_sd_cost(){
		return $this->_sd_cost;
	}
	function get_sd_cost_formated(){
		setlocale(LC_MONETARY, 'en_US');
		return money_format('%.0n', ceil($this->get_sd_cost()));	
	}

	private function _set_sd_critical($critical){
		if ($critical == null) {
			$this->_sd_critical = 0;
		}  else {
			$this->_sd_critical = $critical;	
		}	
	}
	function get_sd_critical(){
		return $this->_sd_critical;
	}


	/*
	 * Begins the dashboard table collection
	 *
	 *
	 */
	function get_sd_costs($esd = null)
	{
		if ($esd) {
			$this->db->select('school_name, estimated_cost, event_sd_id, event_school_id');
			$this->db->where('event_sd_id',$esd);
			$this->db->order_by('estimated_cost','desc');
			$this->db->order_by('school_name','asc');
			return $this->db->get('d_sd_school_dashboard_details')->result();
		} else {
			return null;
		}
	}
	function get_sd_completeds($esd = null)
	{
		if ($esd) {
			$this->db->select('school_name, total_completed_bcs_profiles, percent_complete, event_sd_id, event_school_id');
			$this->db->where('event_sd_id',$esd);
			$this->db->order_by('total_completed_bcs_profiles','desc');
			$this->db->order_by('school_name','asc');
			return $this->db->get('d_sd_school_dashboard_details')->result();
		} else {
			return null;
		}
	}

	function get_sd_issues($esd)
	{
		if ($esd) {
			$this->db->select('school_name, U, P, N, C, issues_total, event_sd_id, event_school_id');
			$this->db->where('event_sd_id',$esd);
			$this->db->order_by('issues_total','desc');
			$this->db->order_by('school_name','asc');
			return $this->db->get('d_sd_school_dashboard_details')->result();
		} else {
			return null;
		}		
	}

	/*
	 * Begins the dashboard map data collection
	 *
	 *
	 */
	function get_map_data($sd = null){
		if (!$sd) {
			$sd = $this->_sd_number;
		}
		$this->db->select("*");
		$this->db->where(array('company_id'=>$sd));
		$this->db->order_by('building_name');
		$rslts = $this->db->get('v_company_buildings')->result();
		if ($rslts) {
			$map_data = array();
			foreach ($rslts as $row) {
				$map_data[] = array(
					'position' 	=> $row->building_lat . ',' . $row->building_lng,
					'label'		=> $row->building_name,
					'title'		=> $row->building_name,
					'content'	=> $row->building_name . '<br>' . $row->building_address . '<br>' . $row->building_city . ', ' . $row->building_state . '  ' . $row->building_zip,
					);
      		}
      		return $map_data;
		} else {
			return null;
		}
	}


}