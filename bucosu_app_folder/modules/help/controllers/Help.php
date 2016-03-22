<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php
class Help extends Frontend_Controller {
	private $_results = array();

	public function __construct(){
		parent::__construct();

	/*
	 * -------------------------
	 * Load the model for the matching controller
	 * -------------------------
	 */
		$this->load->model('mdl_help');
		$this->_results = 	$this->mdl_help->get();
	}

	public function index() 
	{

		$this->data['title'] = "Help Documentation";

		$rslts = array();
		$keys = array();
		foreach ($this->_results as  $value) {
			$key = $value->type;
			$clean_key = $this->_clean_key($key);
			$rslts[$key][]=$value;
			$keys[$key] = $clean_key; 
		}
		$this->data['types'] = $rslts;
		$this->data['keys'] = $keys;

	
		
		$this->data['help_tray_left'] = $this->load_view('help_tray_left',$this->data,TRUE);
		$this->data['help_tray_center'] = $this->load_view('help_tray_center',$this->data,TRUE);

		$subview = "help_container";
		$mainview = "help_main_view";
		$this->load_structure($subview,$mainview);
	}


	private function _clean_key($key){
		$key = strtoupper(str_replace("_"," ",$key));
		return $key . " HELP";
	}

	public function embed(){
		$this->data['title'] = "Help Documentation";

		$rslts = array();
		$keys = array();
		foreach ($this->_results as  $value) {
			$key = $value->type;
			$clean_key = $this->_clean_key($key);
			$rslts[$key][]=$value;
			$keys[$key] = $clean_key; 
		}
		$this->data['types'] = $rslts;
		$this->data['keys'] = $keys;

	
		
		$this->data['help_tray_left'] = $this->load_view('help_tray_left',$this->data,TRUE);
		$this->data['help_tray_center'] = $this->load_view('help_tray_center',$this->data,TRUE);

		$subview = "help_container";
		$mainview = "help_embeded_view";
		$this->load_structure($subview,$mainview);
	}
}

