<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php
class Dashboard extends Authorized_Controller {

	protected $_event_module = null;
	protected $_user_module = null;

	protected $_the_model = null;
	protected $_event_model = null;

	protected $_esd_id = null;
	protected $_esd_name = null;

	public function __construct()
	{
		parent::__construct();

	/* 
	 * -------------------------
	 * Use this if you want to restrict the page by a certain level of admin!
	 * ------------
	 */

		if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin(false,3)) )
		{
			$this->_show_401();
		}


		// $u_id    = intval($this->ion_auth->get_user_id());
		// $u_type = intval($this->ion_auth->get_users_groups($u_id)->row()->type);
		// if ($u_type > 2) {
		// 	$this->_show_401();
		// }


	/*
	 * -------------------------
	 * Load the model & modules for the matching controller
	 * -------------------------
	 */

		$this->load->module('bcs_events_school_district');
		$this->_event_module = $this->bcs_events_school_district;

		$this->load->module('user_settings');
		$this->_user_module = $this->user_settings;

		$this->load->model('Mdl_dashboard');
		$this->_the_model = $this->Mdl_dashboard;

		$this->load->model('Mdl_bcs_events_school_district');
		$this->_event_model = $this->Mdl_bcs_events_school_district;

	/* 
	 * -------------------------
	 * Use this section to inject css/js into the page
	 * ------------
	 */

		// $this->data['stylesheets']['font'][''] = get_css('');
		// $this->data['stylesheets']['top'][''] = get_css('');
		// $this->data['stylesheets']['theme'][''] = get_css('');
		// $this->data['stylesheets']['end'][''] = get_css('');

		// $this->data['javascripts']['header'] = get_js('');
		// $this->data['javascripts']['top'] = get_js('');
		// $this->data['javascripts']['jquery'] = get_js('');
		// $this->data['javascripts']['mid'] = get_js('');
		// $this->data['javascripts']['theme'] = get_js('');
		// $this->data['javascripts']['end'] = get_js('');

		// $this->data['footer'][] = get_js('');

	}

	public function index(){
		$this->data['stylesheets']['theme']['custom'] = get_css('assets/css/admin/custom.css');
		$this->data['stylesheets']['top']['animate_css'] = get_css('vendor/plugins/animate/animate.min.css'); 
		$this->data['javascripts']['theme']['widgets'] 				= get_js('assets/js/demo/widgets.js'); 

	
		if (!$this->get_event_school_district_id()){
			$this->_show_401();

			//$this->data['title'] = "Oops you can not view that page.";
			//$subview = 'dashboard_oops';
			//$mainview = 'ui/_layout_main';
			//$this->load_structure($subview,$mainview);
			return null;
		} 


		//$this->data['javascripts']['top']['google_maps_api']		= get_js('http://maps.google.com/maps/api/js?sensor=true');
		//$this->data['javascripts']['top']['google_maps_api_2']		= get_js('http://maps.google.com/maps-api-v3/api/js/22/6/main.js');
		// No longer need the sensor
		$this->data['javascripts']['top']['google_maps_api']		= get_js('http://maps.google.com/maps/api/js');
		$this->data['javascripts']['mid']['gmaps'] 					= get_js('vendor/plugins/map/gmaps.min.js');
		$this->data['javascripts']['mid']['jquery_ui_map'] 			= get_js('vendor/plugins/gmap/jquery.ui.map.min.js');
		$this->data['javascripts']['mid']['jquery_ui_map_ext'] 		= get_js('vendor/plugins/gmap/ui/jquery.ui.map.extensions.min.js');

		$this->data['javascripts']['mid']['gmaps'] 					= null;
		$this->data['javascripts']['mid']['jquery_ui_map'] 			= null;
		$this->data['javascripts']['mid']['jquery_ui_map_ext'] 		= null;
		$this->data['javascripts']['mid']['dashboard_maps_compressed'] = get_js('assets/js/dashboard_maps_compressed.js');


		/*
		$this->data['javascripts']['mid']['highcharts'] 			= get_js('vendor/plugins/highcharts/highcharts.js');
		$this->data['javascripts']['mid']['sparkline'] 				= get_js('vendor/plugins/sparkline/jquery.sparkline.min.js');
		$this->data['javascripts']['mid']['circles'] 				= get_js('vendor/plugins/circles/circles.js');
		$this->data['javascripts']['mid']['jvectormap'] 			= get_js('vendor/plugins/jvectormap/jquery.jvectormap.min.js');
		$this->data['javascripts']['mid']['jvectormap_us_lcc_en']	= get_js('vendor/plugins/jvectormap/assets/jquery-jvectormap-us-lcc-en.js');
		*/		

		//$this->data['javascripts']['end']['dashboard'] 			= get_js('assets/js/dashboard/dashboard_script.js');
		$this->data['javascripts']['end']['dashboard_3'] 			= get_js('assets/js/dashboard/dashboard_script_3.js');		

		
		
		
		$this->data['title'] = $this->_esd_name . ' - Dashboard';
		
		$this->_the_model->init($this->_esd_id);


		$this->data['dashboard_title_data'] = array(
												array(
													'color'=>'bg-primary', 
													'icon'=>'fa-building',
													'data'=>$this->_the_model->get_sd_school_count(),
													'title'=>'Total Schools'),
												array(
													'color'=>'bg-alert', 
													'icon'=>'fa-check-square-o',
													'data'=>$this->_the_model->get_sd_completed_formated(),
													'title'=>'BCS Complete'),
												array(
													'color'=>'bg-success', 
													'icon'=>'fa-dollar',
													'data'=>$this->_the_model->get_sd_cost_formated(),
													'title'=>'Estimated Cost'),
												array(
													'color'=>'bg-danger', 
													'icon'=>'fa-warning',
													'data'=>$this->_the_model->get_sd_critical(),
													'title'=>'Critical Items'),
			);

		$this->data['costs'] = $this->_get_cost_dashboard_data();
		$this->data['completeds'] = $this->_get_completed_dashboard_data();
		$this->data['issues'] = $this->_get_issues_dashboard_data();

		$this->data['current_bcs_esd'] = $this->_esd_id;

		$this->data['bcs_esds'] = $this->_get_event_school_district_list();
		$this->data['right_topbar'] = $this->load_view('ui/default_sd_event_selection',$this->data,TRUE);

		$this->data['dashboard_panels'] = $this->load_view('dashboard_panels',$this->data,TRUE);

		$subview = 'dashboard_titles';
		$mainview = 'ui/_layout_main';
		$this->load_structure($subview,$mainview);
	}

	function save_dashboard_defaults($esd){
		$this->_set_event_school_district_id($esd);
		if ($this->_esd_id) {
			return json_encode(array('success'=>'Defaults Saved!'));
		} else {
			return json_encode(array('error'=>'There was an error saving your settings, please try again.'));
		}
	}

	function get_map_data_by_event_school_district($esd = null){

		$rslt = $this->_the_model->get_map_data($this->_event_model->get($esd)->sd_id);

		if ($rslt) {
			echo json_encode(array('result'=>'success','data'=>$rslt));		      		
		} else {
			echo json_encode(array('result'=>'error','data'=>'No results for that school district!'));
		}
	}

	/*
	 * Begin gathering the Event School District ID
	 *
	 */
	function get_event_school_district_id(){
		if(! $this->_esd_id)
		{
			//Try to get it from the dashboard event user setting
			$id = $this->session->userdata('dashboard_event_school_district');
			if (!$id) {
				$id = $this->session->userdata('event_school_district');
			}

			//If not set & user is from a school, use the school id.
			if (!$id && $this->session->userdata('user_group_type') == 3) {
				$id = $this->_get_esd_id_by_sd_id($this->session->userdata('company')->id);
			}

			//If not set & user has agreements, use the first agreement id.
			if (!$id && $this->session->userdata('agreements')) {
				$agreements = $this->session->userdata('agreements');
				$sd_id = $agreements[0]['agreement_with']->id;
				$id = $this->_get_esd_id_by_sd_id($sd_id);
			}

			//If set after all of above, then set it to the private id, and update the school district id user setting
			if ($id) {
				$this->_set_event_school_district_id($id);	
			}
		}
		return $this->_esd_id; 
	}
	private function _get_esd_id_by_sd_id($sd_id){
		$esd = null;
		$rslt = $this->_event_model->get_by(array('sd_id'=>$sd_id),true);
		if ($rslt) {
			$esd = $rslt->id;
		}
		return $esd;
	}
	private function _set_event_school_district_id($esd_id){
		$this->_esd_id = $esd_id;
		$uID = $this->session->userdata('user_id');
		$data = array('dashboard_event_school_district'=>$esd_id);
		$this->_user_module->update_settings($data,$uID);
		$this->_set_esd_name_by_esd_id($esd_id);
	}
	/*
	 * End gathering the Event School District ID
	 *
	 */


	/*
	 * Begin gathering the Event School District Name
	 *
	 */
	function get_event_school_district_name(){

		if (! $this->_esd_name) {
			$nam = $this->session->userdata('dashboard_event_school_district_name');
			if ($nam) {
				$this->_set_event_school_district_name($nam);
			} else {
				$this->_set_esd_name_by_esd_id($this->get_event_school_district_id());
			}
		}
		return $this->_esd_name;
	}
	private function _set_esd_name_by_esd_id($esd){
		$rslt = $this->_event_model->get($esd);
		if ($rslt) {
			$this->_set_event_school_district_name($rslt->school_district);
		}
	}
	private function _set_event_school_district_name($esd_nam){
		$this->_esd_name = $esd_nam;
		$uID = $this->session->userdata('user_id');
		$data = array('dashboard_event_school_district_name'=>$esd_nam);
		$this->_user_module->update_settings($data,$uID);
	}


	
	private function _get_event_school_district_list(){
		
		$agreements = $this->session->userdata('agreements');		
		$agreement_esd = array();
		if ($agreements) {	
			foreach ($agreements as $agreement) {
				$sd_id = $agreement['agreement_with']->id;
				$rslt = $this->_event_module->event_by_school_district($sd_id);
				if ($rslt){
					$agreement_esd[] = $rslt;
				}
			}
		} else {
			if ($this->session->userdata('user_group_type')==3) {
				$sd_id = $this->session->userdata('company')->id;
				$rslt = $this->_event_module->event_by_school_district($sd_id);
				if ($rslt){
					$agreement_esd[] = $rslt;
				}
			} 
		}	
		return $agreement_esd;
	}
	private function _get_cost_dashboard_data(){
		setlocale(LC_MONETARY, 'en_US');	
		$rslts = $this->_the_model->get_sd_costs($this->_esd_id);
		if ($rslts) {
			$costs = array();
			$x = 1;
			foreach ($rslts as $rslt) {
				$estimated_cost = 0;
				if ($rslt->estimated_cost == null) {
					$estimated_cost = money_format('%.0n', 0.0);
				} else {
					$estimated_cost = money_format('%.0n', floor($rslt->estimated_cost));
				}
				$costs[] =array('school_name'=>$rslt->school_name,'estimated_cost'=>$estimated_cost,'event_sd_id'=>$rslt->event_sd_id,'event_school_id'=>$rslt->event_school_id); 
			}
			return $costs;
		} else {
			return null;
		}
	}
	private function _get_completed_dashboard_data(){
		$rslts = $this->_the_model->get_sd_completeds($this->_esd_id);
		if ($rslts) {
			$completed = array();
			$x = 1;
			foreach ($rslts as $rslt) {
				$tot_completed = 0;
				$perc_completed = 0;

				if ($rslt->total_completed_bcs_profiles == null) {
					$tot_completed = 0;
				} else {
					$tot_completed = $rslt->total_completed_bcs_profiles;
				}
				if ($rslt->percent_complete == null) {
					$perc_completed = 0;
				} else {
					$perc_completed = percent($rslt->percent_complete);
				}
				$completed[] =array('school_name'=>$rslt->school_name,'total_completed_bcs_profiles'=>$tot_completed,'percent_complete'=>$perc_completed,'event_sd_id'=>$rslt->event_sd_id,'event_school_id'=>$rslt->event_school_id); 
			}
			return $completed;
		} else {
			return null;
		}
	}
	private function _get_issues_dashboard_data(){
		$rslts = $this->_the_model->get_sd_issues($this->_esd_id);
		if ($rslts) {
			$issues = array();
			$x = 1;
			foreach ($rslts as $rslt) {
				$u = 0;
				$p = 0;
				$n = 0;
				$c = 0;
				$issues_total = 0;
				if ($rslt->U){
					$u = $rslt->U;
				}
				if ($rslt->P)
				{
					$p = $rslt->P;
				}
				if ($rslt->N)
				{
					$n = $rslt->N;
				}
				if ($rslt->C)
				{
					$c = $rslt->C;
				}
				if ($rslt->issues_total)
				{
					$issues_total = $rslt->issues_total;
				}				
				$issues[] =array('school_name'=>$rslt->school_name,'U'=>$u,'P'=>$p,'N'=>$n,'C'=>$c,'issues_total'=>$issues_total,'event_sd_id'=>$rslt->event_sd_id,'event_school_id'=>$rslt->event_school_id); 
			}
			return $issues;
		} else {
			return null;
		}
	}

}
?>