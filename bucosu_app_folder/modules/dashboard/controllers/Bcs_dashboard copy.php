<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php
class Bcs_dashboard extends Admin_Controller {

	protected $_the_model = NULL;
	protected $_dashboard_event_school_name = NULL;
	protected $_dashboard_event_school_district = NULL;

	public function __construct()
	{
		parent::__construct();



	/* 
	 * -------------------------
	 * Use this if you want to restrict the page by a certain level of admin!
	 * ------------
	 */

		// if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin(false,1)) )
		// {
		// 	$this->_show_401();
		// }


		// $u_id    = intval($this->ion_auth->get_user_id());
		// $u_type = intval($this->ion_auth->get_users_groups($u_id)->row()->type);
		// if ($u_type > 2) {
		// 	$this->_show_401();
		// }


	/*
	 * -------------------------
	 * Load the model for the matching controller
	 * -------------------------
	 */
		$this->load->model('Mdl_bcs_dashboard');
		$this->_the_model = $this->Mdl_bcs_dashboard;

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


		$user_co = $this->session->userdata('company')->name;
		//$this->data['title'] = $user_co . ' - Dashboard';
		$this->data['title'] = 'Schenectady City School District - Dashboard';

		$this->data['stylesheets']['theme']['custom'] = get_css('assets/css/admin/custom.css');

		$this->data['javascripts']['top']['google_maps_api']		= get_js('http://maps.google.com/maps/api/js?sensor=true');
		//$this->data['javascripts']['top']['google_maps_api_2']		= get_js('http://maps.google.com/maps-api-v3/api/js/22/6/main.js');


		$this->data['javascripts']['mid']['gmaps'] 					= get_js('vendor/plugins/map/gmaps.min.js');
		$this->data['javascripts']['mid']['jquery_ui_map'] 			= get_js('vendor/plugins/gmap/jquery.ui.map.min.js');
		$this->data['javascripts']['mid']['jquery_ui_map_ext'] 		= get_js('vendor/plugins/gmap/ui/jquery.ui.map.extensions.min.js');

		

		/*
		$this->data['javascripts']['mid']['highcharts'] 			= get_js('vendor/plugins/highcharts/highcharts.js');
		$this->data['javascripts']['mid']['sparkline'] 				= get_js('vendor/plugins/sparkline/jquery.sparkline.min.js');
		$this->data['javascripts']['mid']['circles'] 				= get_js('vendor/plugins/circles/circles.js');
		$this->data['javascripts']['mid']['jvectormap'] 			= get_js('vendor/plugins/jvectormap/jquery.jvectormap.min.js');
		$this->data['javascripts']['mid']['jvectormap_us_lcc_en']	= get_js('vendor/plugins/jvectormap/assets/jquery-jvectormap-us-lcc-en.js');
		*/

		$this->data['javascripts']['theme']['widgets'] 				= get_js('assets/js/demo/widgets.js'); 

		//$this->data['javascripts']['end']['dashboard'] 			= get_js('assets/js/dashboard/dashboard_script.js');
		
		$this->data['javascripts']['end']['dashboard_3'] 			= get_js('assets/js/dashboard/dashboard_script_3.js');


		$this->_setup_dashboard_selection();
		
		$this->_the_model->set_sd_data(null);


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

		$this->data['dashboard_panels'] = $this->load_view('dashboard_panels',$this->data,TRUE);
		$subview = 'dashboard_titles';
		$mainview = 'ui/_layout_main';
		$this->load_structure($subview,$mainview);
	}

	private function _get_cost_dashboard_data(){
		setlocale(LC_MONETARY, 'en_US');	
		$rslts = $this->_the_model->get_sd_costs($this->_dashboard_event_school_district_id);
		if ($rslts) {
			$costs = array();
			$x = 1;
			foreach ($rslts as $rslt) {
				$estimated_cost = 0;
				if ($rslt->estimated_cost == null) {
					$estimated_cost = money_format('%(#10n', 0.0);
				} else {
					$estimated_cost = money_format('%(#10n', $rslt->estimated_cost);
				}
				$costs[] =array('school_name'=>$rslt->school_name,'estimated_cost'=>$estimated_cost); 
			}
			return $costs;
		} else {
			return null;
		}
	}

	private function _get_completed_dashboard_data(){
		$rslts = $this->_the_model->get_sd_completeds($this->_dashboard_event_school_district_id);
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
				$completed[] =array('school_name'=>$rslt->school_name,'total_completed_bcs_profiles'=>$tot_completed,'percent_complete'=>$perc_completed); 
			}
			return $completed;
		} else {
			return null;
		}
	}

	private function _get_issues_dashboard_data(){
		$rslts = $this->_the_model->get_sd_issues($this->_dashboard_event_school_district_id);
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
				$issues[] =array('school_name'=>$rslt->school_name,'U'=>$u,'P'=>$p,'N'=>$n,'C'=>$c,'issues_total'=>$issues_total); 
			}
			return $issues;
		} else {
			return null;
		}
	}
	public function save_dashboard_defaults($sd_e)
	{
		$this->load->module('user_settings');
		$uID = $this->session->userdata('user_id');
		$data = array('dashboard_event_school_district'=>$sd_e);

		if ($this->user_settings->update_settings($data,$uID) ){
			return json_encode(array('success'=>'Defaults Saved!'));
		} else {
			return json_encode(array('error'=>'There was an error saving your settings, please try again.'));
		}
	}

	function _setup_dashboard_selection(){
		$this->load->module('bcs_events_school_district');
		$agreements = $this->session->userdata('agreements');		
		$agreement_esd = array();
		if ($agreements) {
			
			foreach ($agreements as $agreement) {
				$sd_id = $agreement['agreement_with']->id;
				$rslt = $this->bcs_events_school_district->event_by_school_district($sd_id);
				if ($rslt){
					$agreement_esd[] = $rslt;
				}
			}
			$this->data['stylesheets']['top']['animate_css'] = get_css('vendor/plugins/animate/animate.min.css'); 
			$this->data['bcs_esds'] = $agreement_esd;

			$dashboard_event_school_district = $this->session->userdata('dashboard_event_school_district');
			if (!$dashboard_event_school_district) {
				$dashboard_event_school_district = $this->session->userdata('event_school_district');
			}
			// if (!$dashboard_event_school_districtd){
			// 	$dashboard_event_school_district = 
			// }
			$this->_dashboard_event_school_district_id = $dashboard_event_school_district;

			$this->data['current_bcs_esd'] = $dashboard_event_school_district;

			$this->data['right_topbar'] = $this->load_view('ui/default_sd_event_selection',$this->data,TRUE);
		} else {
			
		}		
	}

	function get_map_data_by_event_school_district($esd = null){


		$rslt = $this->_the_model->get_map_data_by_event_school_district($esd);

		if ($rslt) {
			echo json_encode(array('result'=>'success','data'=>$rslt));		      		
		} else {
			echo json_encode(array('result'=>'error','data'=>'No results for that school district!'));
		}
	}
	
}
?>