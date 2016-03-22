<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php
class User_settings extends Authorized_Controller {

	public function __construct(){
		parent::__construct();

	/*
	 * -------------------------
	 * Load the model for the matching controller
	 * -------------------------
	 */
		$this->load->model('mdl_user_settings');
	}


	public function get_user_settings($id=NULL)
	{
		//if no id was passed use the current users id
		$id || $id = $this->session->userdata('user_id');
		$param = array('user_id'=>$id);
		$rslts = $this->mdl_user_settings->get_by($param);

		if ($rslts) {
			return $rslts;
		} else {
			return array('error'=>'No user settings!');
		}
	}

	public function get_user_setting($setting_name,$id=NULL)
	{
		//if no id was passed use the current users id
		$id || $id = $this->session->userdata('user_id');
		$param = array('user_id'=>$id, 'setting_name'=>$setting_name);
		$result = $this->mdl_user_settings->get_by($param,TRUE);
		if ($result) {
			return $result;
		} else {
			return FALSE;
		}
	}

	public function get_user_setting_json($setting_name,$id=NULL){
		$rslt = $this->get_user_setting($setting_name,$id);
		if (!$rslt) {
			return json_encode(array('success'=>false,'msg'=>'Error, that setting does not exist!'));
		} else {
			return json_encode(array('success'=>true,'msg'=>$rslt));
		}
	}

	public function setting_exists($setting_name,$id=NULL)
	{
		//if no id was passed use the current users id
		$id || $id = $this->session->userdata('user_id');

		$u_s = $this->get_user_setting($setting_name,$id);

		if($u_s)
		{
			return $u_s->id;
		} else {
			return FALSE;        
		}
	}

	public function update_settings($settings,$id=NULL){

		//if no id was passed use the current users id
		$id || $id = $this->session->userdata('user_id');


		if (!is_array($settings)) {
			return FALSE;
		}

		foreach ($settings as $key => $value) {
			$u_s_e = $this->setting_exists($key,$id);
			$u_s_e || $u_s_e = NULL;
			$data = array('user_id'=>$id,'setting_name'=>$key, 'setting_value'=>$value);
			if ($this->mdl_user_settings->save($data,$u_s_e))
			{
				$this->update_session_for_settings(array($key=>$value));
			}
		}
		return TRUE;		
	}

	public function update_setting($id=NULL){
		//if no id was passed use the current users id
		$id || $id = $this->session->userdata('user_id');
		
		$setting = $this->input->get('setting');
		$value = $this->input->get('value');

		$u_s_e = $this->setting_exists($setting,$id);
		$u_s_e || $u_s_e = NULL;


		$data = array('user_id'=>$id,'setting_name'=>$setting, 'setting_value'=>$value);
		if ($this->mdl_user_settings->save($data,$u_s_e))
		{
			$this->update_session_for_settings(array($setting=>$value));
		}
		return json_encode(array('success'=>true,'msg'=>'Updated setting!'));
	}

	public function delete_setting($setting_name,$id=NULL)
	{
		//if no id was passed use the current users id
		$id || $id = $this->session->userdata('user_id');

		$u_s = $this->setting_exists($setting_name,$id);

		if($u_s)
		{
			$this->mdl_user_settings->delete($u_s->id);
			return TRUE;
		} else {
			return FALSE;
		}

	}

	public function update_session_for_settings($settings,$id=NULL)
	{
		//if no id was passed use the current users id
		$id || $id = $this->session->userdata('user_id');

		if (is_array($settings)) {
			foreach ($settings as $key => $value) {
				$this->session->set_userdata($key,$value);
			}
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function update_session_with_settings($id=NULL)
	{
		//if no id was passed use the current users id
		$id || $id = $this->session->userdata('user_id');

		$u_ss = $this->get_user_settings($id);
		if (! array_key_exists('error',$u_ss) ) 
		{ 
			foreach ($u_ss as $u_s){
				$this->session->set_userdata($u_s->setting_name,$u_s->setting_value);
			}
		}
	}

}
