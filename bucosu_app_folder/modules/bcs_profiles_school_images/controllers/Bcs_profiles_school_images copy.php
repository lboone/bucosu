<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php
class Bcs_profiles_school_images extends Authorized_Controller {

	public function __construct(){
		parent::__construct();

	/*
	 * -------------------------
	 * Load the model for the matching controller
	 * -------------------------
	 */
		$this->load->model('mdl_bcs_profiles_school_images');


	}

	public function index() 
	{
		$this->data['title'] = "";
		$subview = '';
		$mainview = "ui/_layout_main";
		$this->load_structure($subview,$mainview);
	}

	public function get_profile_school_images()
	{

		$profile_school_id = $this->input->post_get('id',TRUE);
		if (!$profile_school_id) {
			return $this->_return('Please select a school!');
		}
		else
		{
			$viewData = $this->_get_table($profile_school_id);
			if ($viewData) {
				return $this->_return($viewData,'success');
			} else {
				return $this->_return('');
			}
		}

	}

	public function save_image(){

		if(isset($_FILES["file_data"]) && $_FILES["file_data"]["error"]== UPLOAD_ERR_OK)
		{
			$profile_school_id = $this->input->post_get('profile_school_id',TRUE);
			if(!$profile_school_id){ return $this->_return('Please select a school.');}

		    ############ Edit settings ##############
			$tmpDir = get_profiles_school_images_location($profile_school_id);
			if (is_array($tmpDir)) {
				if ($tmpDir['error']) {

					return $this->_return($tmpDir['error']);
				}
			} else {
				return $this->_return('There was a problem saving the image, please try again!');
			}
		    $UploadDirectory    = $tmpDir['path'] . '/';

		    ##########################################
		    
		    /*
		    Note : You will run into errors or blank page if "memory_limit" or "upload_max_filesize" is set to low in "php.ini". 
		    Open "php.ini" file, and search for "memory_limit" or "upload_max_filesize" limit 
		    and set them adequately, also check "post_max_size".
		    */
		    
		    //check if this is an ajax request
		    if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
		        die();
		    }
		    
		    
		    //Is file size is less than allowed size.
		    if ($_FILES["file_data"]["size"] > 3145728) {
		        return $this->_return('File size is too big!');
		    }
		    
		    //allowed file type Server side check
		    switch(strtolower($_FILES['file_data']['type']))
		        {
		            //allowed file types
		            case 'image/png': 
		            case 'image/gif': 
		            case 'image/jpeg': 
		            case 'image/pjpeg':
		            case 'application/pdf':
		            case 'application/msword':
		            case 'application/vnd.ms-excel':
		            case 'video/mp4':
		            case 'video/mov':
		            case 'video/quicktime':
		                break;
		            default:
		                return $this->_return('Unsupported File!: ' . strtolower($_FILES['file_data']['type'])); //output error
		    }
		    
		    $File_Name          = strtolower($_FILES['file_data']['name']);
		    $File_Ext           = substr($File_Name, strrpos($File_Name, '.')); //get file extention
		    $Random_Number      = rand(0, 9999999999); //Random number to be added to name.
		    $NewFileName        = $Random_Number.$File_Ext; //new file name
		    
		    if(move_uploaded_file($_FILES['file_data']['tmp_name'], $UploadDirectory.$NewFileName ))
		       {
	    			$dta = array();
					$dta['profile_school_id'] = $profile_school_id;
					$newFN = $this->input->post_get('file_input_text',TRUE);
					if ($newFN) {
						$dta['image_title'] = $newFN;
					} else {
						$dta['image_title'] = $this->security->xss_clean($File_Name);
					}

					
					$dta['image_src'] = $this->security->xss_clean($NewFileName);
					if ($this->_save_image_to_db($dta)) {


						$viewData = $this->_get_table($profile_school_id);
						if ($viewData) {
							return $this->_return($viewData,'success');
						} else {
							return $this->_return('No images found!');
						}

					}
		            
		    }else{
		        return $this->_return('Error uploading File!');
		    }
		    
		}
		else
		{
			return $this->_return('Something wrong with upload! Is "upload_max_filesize" set correctly?');
		}
	}

	private function _save_image_to_db($dta = NULL)
	{

		$id = $this->mdl_bcs_profiles_school_images->save($dta);

		return $id;
	}

	public function delete_image($id=NULL)
	{
		
		if (!$id) {
			return $this->_return('Sorry there was an error deleting the image!');
		}

	    //check if this is an ajax request
	    //if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
	    //    die();
	    //}

		$img = $this->mdl_bcs_profiles_school_images->get($id,TRUE);

		if (!$img) {
			return $this->_return('Sorry there was an error deleting the image!');
		}

		if (intval($this->session->userdata('user_group_level')) > 2)  {
			$u = intval($this->session->userdata('user_id'));
			$i = intval($img->created_by);
			if ($u != $i) {
				return $this->_return('Sorry you are not authorized to delete this image.');
			}
		}

		$psid = $img->profile_school_id;
		$src = $img->image_src;

		$psid_loc = get_profiles_school_images_location($psid);


		if ($psid_loc['error']) {
			return $this->_return($psid_loc['error']);
		}

		$file_loc = $psid_loc['path']. '/' . $img->image_src;
		$file_url = $psid_loc['url']. '/'. $img->image_src;

		if (delete_file_from_server($file_loc)) {
			$this->mdl_bcs_profiles_school_images->delete($id);
			return $this->_return('Image deleted!','success');
		} else {
			return $this->_return('Image did not exist on the server.');	
		}
		
		
	}

	public function create_psi($id){

		$id = $this->security->xss_clean($id);

		if (!is_numeric($id)) {

			echo 'Error - Value not numeric! - (' . $id . ')';
			return FALSE;
		}

		$rslt = get_profiles_school_images_location($id);

		if (!is_array($rslt)) {
			echo 'Error - No Array Returned';
		} else {
			if (isset($rslt['error'])) {
				echo 'Error - ' . $rslt['error'] . '!';
			} else {
				echo '<pre>';
				var_dump($rslt);
				echo '</pre>';

				echo '<a href="' . $rslt['url'] . '" target="_blank">' . $rslt['url'] . '</a>';
				echo '<img src="' .$rslt['url'] . '/close.png">';
			}
		}
	}

	private function _get_for_profile_school_id($id){
		$param = array('profile_school_id'=>$id);
		return $this->mdl_bcs_profiles_school_images->get_by($param);
	}

	private function _get_table($profile_school_id){
		$rslts = $this->_get_for_profile_school_id($profile_school_id);
		
		if (!$rslts) {
			return NULL;
		}

		$ps = get_profiles_school_images_location($profile_school_id);

		$this->data['table_row_data'] = $rslts;
		$this->data['table_header_data'] = array('Img', 'Title','Action');
		$this->data['table_row_data_fields'] = array(
			'Img'					=> array(
										'type'	=> 'mixed_media',
										'src'	=> $ps['url'] .'/',
										'value' =>  'image_src'),			
			'Title'					=> array(
										'type'	=> 'field',
										'value' => 'image_title'),
			'Action'				=> array(
										'type'	=> 'anchor',
										'value' => array('?id=', 'id','', 'Delete',array('class'=>'saved_profile_image_delete_button button btn-danger'))),
			);
		$this->data['table_settings'] = array(
			'table_heading'	=>	'Images',
			'table_sub_heading'	=>	'Images attached to this profile',
			'table_id' => 'profiles-images-table',
			'table_new_record_anchors' => NULL,
		);				
		
		$viewData = $this->load_view('ui/_layout_table_data',NULL,TRUE);
		return $viewData;
	}

	private function _return($message,$status='error')
	{
		echo json_encode(array($status=>$message));
	}
}