<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php
class Dashboard extends Admin_Controller {

	public function __construct(){
		parent::__construct();
	}

	public function index() {
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
		
		$this->data['javascripts']['end']['dashboard_2'] 			= get_js('assets/js/dashboard/dashboard_script_2.js');

		$subview = 'dashboard_view_2';
		$mainview = 'ui/_layout_main';
		$this->load_structure($subview,$mainview);
	}

}