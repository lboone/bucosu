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
		$this->load->library('Upload');


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

	public function get_all_images_by_profile_school_id($profile_school_id=null){
		if (!$profile_school_id) {
			return null;
		}
		$this->mdl_bcs_profiles_school_images->set_table("v_bcs_profiles_school_images");
		$img_path = get_profiles_school_images_location($profile_school_id);
		$img_src = null;
		if ($img_path['error']) {
			return null;
		} else {
			$img_src = $img_path['url'];
		}
		$params = array('profile_school_id'=>$profile_school_id);
		$this->mdl_bcs_profiles_school_images->set_order_by('created');

		$imgs = $this->mdl_bcs_profiles_school_images->get_by($params);

		if ($imgs) {
			$psi_images = array();
			foreach ($imgs as $img) {
				$psi_images[] = array('image_src'=>$img_src . '/' . $img->image_src,'image_psi'=>$img->profile_id,'width'=>$img->width,'height'=>$img->height,'image_title'=>strtoupper($img->image_title) . '<br />Uploaded By: ' . $img->uploaded_by . ', ' . $img->company_name . ' <br />' . date('D, M d Y',strtotime($img->created)));
			}
			return $psi_images;
		} else {
			return null;
		}
	}

	public function get_all_images_by_profile_school_id_json($profile_school_id=null){
		$imgs = $this->get_all_images_by_profile_school_id($profile_school_id);
		if ($imgs) {
			echo json_encode($imgs);
		} else {
			echo json_encode(array('error'=>'nothing returned'));
		}
	}


	public function rotate_image($id=null,$profile_school_id=null,$filename=null,$deg=0){
		/* 90  - Turns it left
		 * 180 - Flips it
		 * 270 - Turns it right
		 * TODO:
		 * 		if 180 - don't update the database.
		 * 		if 90 or 270 - inverse the values on the database.
		 * 		test for file on server before following code after - line 127
		 */

		

		$degrees = intval($deg);
		if (!$id || !$profile_school_id || !$filename || ($degrees !== 90 && $degrees !== -180 && $degrees !== 270)) {
			echo json_encode(array('success'=>false,'msg'=>'Please provide a filename and degrees of 90,180 and 270!'));
			return false;
		}


		$fileExt = get_file_extension($filename);
		if ($fileExt !== "jpg" && $fileExt !== "png" && $fileExt !== "gif" && $fileExt !== 'jpeg') {
			echo json_encode(array('success'=>false,'msg'=>'Sorry you can not rotate images of this type: ' . $fileExt . '!'));
			return false;	
		}

		$tmpDir = get_profiles_school_images_location($profile_school_id);
		if (is_array($tmpDir)) {
			if ($tmpDir['error']) {
				echo json_encode(array('success'=>false,'msg'=>'Sorry that file does not exist!'));
				return false;
			}
		} else {
			echo json_encode(array('success'=>false,'msg'=>'Sorry that file does not exist!'));
			return false;
		}

	    $UploadDirectory    = $tmpDir['path'] . '/';

	    $new_filename = $UploadDirectory . $filename;

		if (!file_exists($new_filename) ) {
				echo json_encode(array('success'=>false,'msg'=>'Sorry that file does not exist!'));
				return false;
		}

		set_error_handler("handleImageCreateError");
		switch ($fileExt) {
			case 'png':
				$source = imagecreatefromstring(file_get_contents($new_filename));
				break;

			case 'gif':
				$source = imagecreatefromstring(file_get_contents($new_filename));
				break;

			default:
				$source = imagecreatefromjpeg($new_filename);		
				break;
		}
		
		// Rotate
		$rotate = imagerotate($source, $degrees, 0);
		

		// Output
		if(!imagejpeg($rotate,$new_filename)){
			echo json_encode(array('success'=>false,'msg'=>'Sorry there was a problem rotating the image: . ' . $new_filename . '!'));
			return false;
		}

		// Free the memory
		imagedestroy($source);
		imagedestroy($rotate);


		// Now update the image if image was not flipped.

		if ($degrees !== 180) {
			$rslt = $this->mdl_bcs_profiles_school_images->get($id,true);
			if ($rslt) {
				$width = $rslt->height;
				$height = $rslt->width;
				$params = array('width'=>$width,'height'=>$height);
				$this->mdl_bcs_profiles_school_images->save($params,$id);
			}
		}

		echo json_encode(array('success'=>true,'msg'=>'Image ' . $new_filename . ' was rotated: ' . $degrees . ' degrees successfully!'));
		return true;

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
		          //  case 'image/pjpeg':
		          //  case 'application/pdf':
		          //  case 'application/msword':
		          //  case 'application/vnd.ms-excel':
		          //  case 'video/mp4':
		          //  case 'video/mov':
		          //  case 'video/quicktime':
		                break;
		            default:
		                return $this->_return('Unsupported File!: ' . strtolower($_FILES['file_data']['type'])); //output error
		    }
		    
		    $File_Name          = strtolower($_FILES['file_data']['name']);
		    $File_Ext           = substr($File_Name, strrpos($File_Name, '.')); //get file extention
		    $Random_Number      = rand(0, 9999999999); //Random number to be added to name.
		    $NewFileName        = $Random_Number.$File_Ext; //new file name
		    
		   // if(move_uploaded_file($_FILES['file_data']['tmp_name'], $UploadDirectory.$NewFileName ))
		    //list($w, $h) = getimagesize($_FILES['file_data']['tmp_name']);

		    list($w,$h,$c) = $this->_return_new_size_and_compression();

		    //if($this->_resize(ceil($w/2),ceil($h/2),$UploadDirectory.$NewFileName))
		    //if($this->_compress($_FILES['file_data']['tmp_name'],$UploadDirectory.$NewFileName,50))
		    if($this->_resize($w,$h,$UploadDirectory.$NewFileName,$c))
		       {
	    			$dta = array();
					$dta['profile_school_id'] = $profile_school_id;
					$newFN = $this->input->post_get('file_input_text',TRUE);
					if ($newFN) {
						$dta['image_title'] = $newFN;
					} else {
						$dta['image_title'] = $this->security->xss_clean($File_Name);
					}
					$dta['width'] = $w;
					$dta['height'] = $h;
					
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

	public function update_image_title($echo=false){
		$pk = $this->input->post('pk');
		$name = $this->input->post('name');
		$value = $this->input->post('value');


		if ($pk && $name && $value) {
			$params = array($name=>$value);
			if($this->mdl_bcs_profiles_school_images->save($params,$pk)){
				if ($echo) {
					echo json_encode(array('success'=>true,'msg'=>'The image title has been changed.'));
					return true;
				} else {
					return json_encode(array('success'=>true,'msg'=>'The image title has been changed.'));		
				}	
			}
		}
		if ($echo) {
			echo json_encode(array('success'=>false,'msg'=>'There was an error updating the image title, please try again!'));
			return false;
		} else {
			return json_encode(array('success'=>false,'msg'=>'There was an error updating the image title, please try again!'));
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
		$this->mdl_bcs_profiles_school_images->set_table("v_bcs_profiles_school_images");
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
										'type'	=> 'x-editable-text',
										'value' => array(
															'#',
															'id',
															'image_title',
															'../../bcs_profiles_school_images/update_image_title',
															stringify_attributes(
																						array(
																							'data-type'=>'text',
																							'data-placement'=>'top',
																							'data-placeholder'=>'Required',
																							'data-title'=>'Change the image title',
																							'class'=>'editable editable-click'
																							)
																						)
														)
											),
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

	private function _resize($width, $height,$path,$quality=50){
	  /* Get original image x y*/
	  list($w, $h) = getimagesize($_FILES['file_data']['tmp_name']);
	  /* calculate new image size with ratio */
	  $ratio = max($width/$w, $height/$h);
	  $h = ceil($height / $ratio);
	  $x = ($w - $width / $ratio) / 2;
	  $w = ceil($width / $ratio);
	  /* new file name */
	  //$path = 'uploads/'.$width.'x'.$height.'_'.$_FILES['image']['name'];
	  /* read binary data from image file */
	  $imgString = file_get_contents($_FILES['file_data']['tmp_name']);
	  /* create image from string */
	  $image = imagecreatefromstring($imgString);
	  $tmp = imagecreatetruecolor($width, $height);
	  imagecopyresampled($tmp, $image,
	    0, 0,
	    $x, 0,
	    $width, $height,
	    $w, $h);
	  /* Save image */
	  // switch ($_FILES['file_data']['type']) {
	  //   case 'image/jpeg':
	  //     imagejpeg($tmp, $path, 100);
	  //     break;
	  //   case 'image/png':
	  //     imagepng($tmp, $path, 0);
	  //     break;
	  //   case 'image/gif':
	  //     imagegif($tmp, $path);
	  //     break;
	  //   default:
	  //     exit;
	  //     break;
	  // }

	  imagejpeg($tmp, $path, $quality);
	  return $path;
	  /* cleanup memory */
	  imagedestroy($image);
	  imagedestroy($tmp);
	}

	private function _compress($source, $destination, $quality=50) 
	{ 
		$info = getimagesize($source); 

		if ($info['mime'] == 'image/jpeg') 
			$image = imagecreatefromjpeg($source); 
		elseif ($info['mime'] == 'image/gif') 
			$image = imagecreatefromgif($source); 
		elseif ($info['mime'] == 'image/png') 
			$image = imagecreatefrompng($source); 

		imagejpeg($image, $destination, $quality); 
		return $destination; 
		/* cleanup memory */
		imagedestroy($image);

	}

	private function _return_new_size_and_compression($max = 1280)
	{
		list($w, $h) = getimagesize($_FILES['file_data']['tmp_name']);

		if ($w > $h) {				//This is a Horizontal Image
			if ($w > $max) {
				$rat = $max/$w;
				$newH = ceil($h*$rat);
				$newW = $max;
				return array($newW,$newH,50);
			} else {
				return array($w,$h,75);
			}
		} elseif ($h > $w) { 		//This is a Vertical Image
			if ($h > $max) {
				$rat = $max/$h;
				$newH = $max;
				$newW = ceil($w*$rat);
				return array($newW,$newH,50);
			} else {
				return array($w,$h,75);
			}
		} else {					//This is a Square Image
			if ($w > $max) {
				return array($max,$max,50);
			} else {
				return array($w,$h,75);
			}
		}


	}


}