<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php
class Bcs extends Authorized_Controller {

	public function __construct(){
		parent::__construct();

	}


	public function index() 
	{
		if (intval($this->session->userdata('user_group_type')) > 2) //This is a area of the site that only admins & firms should see.
		{
			$this->_show_401();
		}

		$this->_setup_default_requirements();

		$this->data['javascripts']['end']['select_change'] = get_js('
		jQuery(document).ready(function() {

			"use strict";
			// Init DataTables
			$("#bcs_events_school_district_1").change(function() {
			  $("#bcs_events_school_1").load("../bcs_events_school/all_by_school_district_event_input_options/" + $("#bcs_events_school_district_1").val());
			 var esd = $("#bcs_events_school_district_1 :selected").html();
			 $("#event_content_district").html(esd);
			});

			$("#bcs_events_school_1").change(function(){
				var es = $("#bcs_events_school_1 :selected").html();
				$("#event_content_school").html(es);
			});

			$("#update_button_1").click(function(){
				$.ajax({
					type:"GET",
					url:"bcs/save_bcs_defaults/" + $("#bcs_events_school_district_1").val() + "/" + $("#bcs_events_school_1").val(),
					success: function(resp){
						$("<div class=\"alert alert-success alert-dismissable animated fadeInDown\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button><i class=\"fa fa-check pr10\"></i><strong>Your default settings have been updated!</strong></div>").insertBefore("#default_event_selection_form-group_1").delay(3000).fadeOut("slow","linear",function(){$(this).remove();});
					}
				});
			});

		});
																	  ',TRUE);

		$this->data['title'] = "BCS";
		$subview = 'home/content_view';
		$mainview = "home/main_view";
		$this->load_structure($subview,$mainview);
	}

	public function event($esd = null, $es = null){

		if (!$esd || !$es) {
			$this->_show_401();
		}

		$esd_name = null;
		$es_name = null;

		$this->load->model('bcs_events_school_district/Mdl_bcs_events_school_district');
		$rslt = $this->Mdl_bcs_events_school_district->get($esd);
		if (!$rslt) {
			$this->_show_401();
		} else {
			$esd_name = $rslt->school_district;
		}

		$this->load->model('bcs_events_school/Mdl_bcs_events_school');
		$rslt = $this->Mdl_bcs_events_school->get($es);
		if (!$rslt) {
			$this->_show_401();
		} else {
			$es_name = $rslt->school_name;
		}		

		$this->data['title'] = $esd_name . ' / ' . $es_name;


		$this->data['stylesheets']['top']['custom'] 					= get_css('assets/css/admin/custom.css');
		$this->data['stylesheets']['top']['magnific-popup']				= get_css('vendor/plugins/magnific/magnific-popup.css');
		$this->data['stylesheets']['top']['form'] 						= get_css('assets/admin-tools/admin-forms/css/admin-forms.css');
		$this->data['stylesheets']['top']['datatables_bootstrap'] 		= get_css('vendor/plugins/datatables/media/css/dataTables.bootstrap.css');
		$this->data['stylesheets']['top']['datatables_plugin']			= get_css('vendor/plugins/datatables/media/css/dataTables.plugins.css');
		$this->data['stylesheets']['top']['nestable']					= get_css('vendor/plugins/nestable/nestable.css');
		$this->data['stylesheets']['top']['animate_css'] 				= get_css('vendor/plugins/animate/animate.min.css'); 

		$this->data['javascripts']['mid']['jquery_datatables']			= get_js('vendor/plugins/datatables/media/js/jquery.dataTables.js');
		$this->data['javascripts']['mid']['datatables_bootstrap']		= get_js('vendor/plugins/datatables/media/js/dataTables.bootstrap.js');
		$this->data['javascripts']['end']['pnotify']					= get_js('vendor/plugins/pnotify/pnotify.js');
		$this->data['javascripts']['end']['moment'] 					= get_js('vendor/plugins/moment/moment.min.js');
		$this->data['javascripts']['end']['fancytree_implementation'] 	= get_js('assets/js/bcs/event/event_tree_2.js');
		$this->data['javascripts']['end']['nestable']				 	= get_js('vendor/plugins/nestable/jquery.nestable.js');
		$this->data['javascripts']['end']['magnific-popup']				= get_js('vendor/plugins/magnific/jquery.magnific-popup.js');
		
		$this->data['current_bcs_esd'] = $esd;
		$this->data['current_bcs_esd_name'] = $esd_name;
		$this->data['current_bcs_es'] = $es;
		$this->data['current_bcs_es_name'] = $es_name;
		
		if (isset($this->data['current_bcs_es'])) {
			$this->_setup_bcs_results2();
		}

		
		$subview = "event/content_view";
		$mainview = "event/main_view";
		$this->load_structure($subview,$mainview);		
	}


	public function events()
	{	
		if (intval($this->session->userdata('user_group_type')) > 2) //This is a area of the site that only admins & firms should see.
		{
			$this->_show_401();
		}

		$this->data['stylesheets']['top']['custom'] 					= get_css('assets/css/admin/custom.css');
		$this->data['stylesheets']['top']['magnific-popup']				= get_css('vendor/plugins/magnific/magnific-popup.css');
		$this->data['stylesheets']['top']['form'] 						= get_css('assets/admin-tools/admin-forms/css/admin-forms.css');
		$this->data['stylesheets']['top']['fancytree'] 					= get_css('vendor/plugins/fancytree/skin-win8/ui.fancytree.min.css'); 
		$this->data['stylesheets']['top']['date_time_picker'] 			= get_css('vendor/plugins/datepicker/css/bootstrap-datetimepicker.css');
		$this->data['stylesheets']['top']['datatables_bootstrap'] 		= get_css('vendor/plugins/datatables/media/css/dataTables.bootstrap.css');
		$this->data['stylesheets']['top']['datatables_plugin']			= get_css('vendor/plugins/datatables/media/css/dataTables.plugins.css');
		$this->data['stylesheets']['top']['fileinput']					= get_css('vendor/plugins/fileinput/fileinput.min.css');
		$this->data['stylesheets']['top']['select2']					= get_css('vendor/plugins/select2/css/core.css');
		$this->data['stylesheets']['top']['nestable']					= get_css('vendor/plugins/nestable/nestable.css');



		$this->data['javascripts']['mid']['jquery_datatables']			= get_js('vendor/plugins/datatables/media/js/jquery.dataTables.js');
		$this->data['javascripts']['mid']['datatables_bootstrap']		= get_js('vendor/plugins/datatables/media/js/dataTables.bootstrap.js');
		$this->data['javascripts']['end']['pnotify']					= get_js('vendor/plugins/pnotify/pnotify.js');
		$this->data['javascripts']['end']['fancytree'] 					= get_js('vendor/plugins/fancytree/jquery.fancytree-all.min.js');
		$this->data['javascripts']['end']['fancytree_filter'] 			= get_js('vendor/plugins/fancytree/extensions/jquery.fancytree.filter.js');
		$this->data['javascripts']['end']['moment'] 					= get_js('vendor/plugins/moment/moment.min.js');
		$this->data['javascripts']['end']['form_validation'] 			= get_js('assets/admin-tools/admin-forms/js/jquery.validate.min.js');
		$this->data['javascripts']['end']['form_validation_additioinal']= get_js('assets/admin-tools/admin-forms/js/additional-methods.min.js');
		$this->data['javascripts']['end']['fileinput'] 					= get_js('vendor/plugins/fileinput/fileinput.min.js');
		$this->data['javascripts']['end']['fancytree_implementation'] 	= get_js('assets/js/bcs/event/event_tree.js');
		$this->data['javascripts']['end']['select2']				 	= get_js('vendor/plugins/select2/select2.min.js');
		$this->data['javascripts']['end']['nestable']				 	= get_js('vendor/plugins/nestable/jquery.nestable.js');
		$this->data['javascripts']['end']['magnific-popup']				= get_js('vendor/plugins/magnific/jquery.magnific-popup.js');

		$this->_setup_default_requirements();
		
		if (isset($this->data['current_bcs_es'])) {
			$this->_setup_bcs_results2();
		}
		

		//$this->_setup_bcs_results();

		$this->data['event_tree'] = $this->load_view('event/event_tree',$this->data,TRUE);
		$this->data['tray_left'] = $this->load_view('event/tray_left',$this->data,TRUE);

		
		$subview = "event/content_view";
		$mainview = "event/main_view";
		$this->load_structure($subview,$mainview);
	}


	private function _setup_bcs_results2(){
		//Load all the modules
		$this->load->module('bcs_headings');
		$this->load->module('bcs_profiles');
		$this->load->module('bcs_profiles_school');
		$this->load->module('bcs_questions');
		$this->load->module('bcs_questions_school');

		//Get all the headings
		$headings = $this->bcs_headings->get_all();
		
		//Get all the system profiles
		$profiles = $this->bcs_profiles->all();
		//Get the system profiles count
		$profiles_count = count($profiles);
		
		//Get all the school profiles
		$sp = $this->bcs_profiles_school->get_all_school_profiles_array($this->data['current_bcs_es']);
		$school_profiles = array();
		if (isset($sp['status'])) {
			$school_profiles_count = 0;
		} else {
			foreach ($sp as $value) {
				$school_profiles[$value->profile_id][] = array('profile'=>$value,'answers'=>$this->bcs_questions_school->get_answers_by_profile_school_id_clean($value->id),'images'=>$this->bcs_profile_school_images->get_all_images_by_profile_school_id($value->id));
			}
			//Get the school profiles count
			$school_profiles_count = count($school_profiles);			
		}
		
		//Use the school profile count & profile count to get the progress bar
		$this->data['bcs_percent_complete'] =  $this->_get_progress_bar($school_profiles_count,$profiles_count,TRUE);
		//$this->data['bcs_percent_complete'] = $sp;

		//echo '<pre>';
		//var_dump($school_profiles);
		//echo '</pre>';


		$bcs = array();
		foreach ($headings as $heading) {
			$heading_profiles = $this->bcs_profiles->by_heading_array($heading->id);
			$heading_profiles_count = count($heading_profiles);
			$heading_profiles_array = array();
			$hsp_count = 0;
			if (is_array($heading_profiles)) {
				foreach ($heading_profiles as $heading_profile) {
					$pqs = array();
					if (array_key_exists($heading_profile['key'], $school_profiles)) {
						$hsp_count = $hsp_count + 1;
						foreach ($school_profiles[$heading_profile['key']] as $v) {
							array_push($pqs, $v['answers']);
						}
					}
					$qs = $this->bcs_questions->by_profile($heading_profile['key']);
					$qarr = array();
					foreach ($qs as $q) {
						if ($pqs) {
							$pq = array();
							foreach ($pqs as $p) {
								if (($p) && (array_key_exists($q->id, $p))) {
									array_push($pq,$p[$q->id]);
								}
							}
							if ($pq) {
								$qarr[$q->id]=array('text'=>$q->text,'answers'=>$pq);	
							} else {
								$qarr[$q->id]=array('text'=>$q->text,'answers'=>'none');	
							}
							
						} else {
							$qarr[$q->id]=array('text'=>$q->text,'answers'=>'none'); 	
						}
						

					}
					$heading_profiles_array[$heading_profile['title']] = $qarr;
				}
			}
			

			if ($hsp_count == 0) {
				$bcs[$heading->name] = array('bar_chart'=>$this->_get_progress_bar($hsp_count,1),'profiles'=>$heading_profiles_array);
			} else {
				$bcs[$heading->name] = array('bar_chart'=>$this->_get_progress_bar($hsp_count,$heading_profiles_count),'profiles'=>$heading_profiles_array);
			}
			
		}


		$this->data['bcs_headings'] = $bcs;
	}

	private function _get_progress_bar($a,$b,$large=FALSE){
		$pc = number_format($a/$b,2)*100;
		if ($pc < 26) {
			$pg_bar = 'warning';	
		} elseif ($pc < 51) {
			$pg_bar = 'alert';
		} elseif ($pc < 76) {
			$pg_bar = 'success';
		} else {
			$pg_bar = 'primary';
		}
		if ($large) {
			return '<div class="progress mt10"><div class="progress-bar progress-bar-' . $pg_bar . ' progress-bar-striped" role="progressbar" aria-valuenow="' . $pc . '" aria-valuemin="0" aria-valuemax="100" style="width: ' . $pc . '%;">' . $pc . '%</div></div>';	
		} else {
			return '<div><span class="custom-progress-bar-label">'.$pc.'%</span><div class="progress progress-bar-sm mn"><div class="progress-bar progress-bar-' . $pg_bar . ' progress-bar-striped" style="width: ' . $pc . '%"></div></div></div>';	
		}
		
		
	}
	private function _setup_bcs_results(){
		$this->load->module('bcs_headings');
		$this->load->module('bcs_profiles');
		$this->load->module('bcs_questions');
		$this->load->module('bcs_profiles_school');
		$this->load->module('bcs_questions_school');

		$heads = $this->bcs_headings->get_all();
		$bcs = array();
		foreach ($heads as $value) {
			$prof = $this->bcs_profiles->by_heading_array($value->id);
			$profs = array();
			foreach ($prof as $pro) {
				$qs = $this->bcs_questions->by_profile($pro['key']);
				$qarr = array();
				foreach ($qs as $q) {
					$qarr[$q->id]=$q->text; 

				}
				$profs[$pro['title']] = $qarr;
			}
			$bcs[$value->name] = $profs;
		}
		$this->data['bcs_headings'] = $bcs;
	}

	public function save_bcs_defaults($sd_e,$s_e)
	{
		$this->load->module('user_settings');
		$uID = $this->session->userdata('user_id');
		$data = array('event_school_district'=>$sd_e,'event_school'=>$s_e);

		if ($this->user_settings->update_settings($data,$uID) ){
			return json_encode(array('success'=>'Defaults Saved!'));
		} else {
			return json_encode(array('error'=>'There was an error saving your settings, please try again.'));
		}
	}

	private function _setup_default_requirements()
	{
		$this->load->module('bcs_events_school_district');

		$agreements = $this->session->userdata('agreements');
		$event_school_district = $this->session->userdata('event_school_district');
		$event_school = $this->session->userdata('event_school');

		$agreement_esd = array();
		if ($agreements) {
			
			foreach ($agreements as $agreement) {
				$sd_id = $agreement['agreement_with']->id;
				$rslt = $this->bcs_events_school_district->event_by_school_district($sd_id);
				if ($rslt){
					$agreement_esd[] = $rslt;
				}
			}

			if (intval($event_school_district) >0 ) {
				$this->load->module('bcs_events_school');

				$agreement_es = $this->bcs_events_school->all_by_school_district_event($event_school_district);
			} else {
				$agreement_es = 'Please select a School District Event...';
			}

			$this->data['stylesheets']['top']['animate_css'] = get_css('vendor/plugins/animate/animate.min.css'); 
			$this->data['bcs_esds'] = $agreement_esd;
			$this->data['bcs_ess'] = $agreement_es;
			$this->data['current_bcs_esd'] = $event_school_district;
			$this->data['current_bcs_es'] = $event_school;

			$this->data['default_event_selection'] = $this->load_view('ui/default_event_selection',$this->data,TRUE);
		} else {
			$this->data['default_event_selection'] = $this->load_view('ui/default_event_selection_none',$this->data,TRUE);
		}		
	}

//alert("key: " + node.key + " - title: " + node.title + " - current school: " + cs );
}

