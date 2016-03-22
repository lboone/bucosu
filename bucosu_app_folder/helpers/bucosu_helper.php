<?php
/*
 * returns the full result of the js url/raw
 *
 * params:
 *
 * data - url string or raw js
 * 
 */
function get_js($data, $isRaw = FALSE){
  return _get_dynamic($data, $isRaw, 'js');
}

/*
 * returns the full result of the css url/raw
 *
 * params:
 *
 * data - url string or raw css
 * 
 */
function get_css($data, $isRaw = FALSE){
    return _get_dynamic($data, $isRaw, 'css');
}

function _get_dynamic($data, $isRaw, $type){
  $returnVal = '';
  if (isset($data)){
    if($isRaw){
      $params = array('type' => $type, 'format' => 'raw' , 'data' => $data);
    } else {
      $params = array('type' => $type, 'format' => 'href' , 'data' => $data);
    }
    $returnVal = _render_dynamic($params);
  }
  return $returnVal;
}

/*
 * returns a string as a css link or as inline css.
 *
 * param: associative array
 * keys: array("type" => "css/js", 
 *             "format" => "href / raw",
 *             "data" => "uri / raw css/js"
 * value: string of href or raw css.
 */
function _render_dynamic($params = array()){
  
  
  $returnVal = NULL;
  
  if (isset($params)) {

    extract($params, EXTR_SKIP);


    if (isset($type) && isset($format) && isset($data)) {

      // ----- work with js file
      if ($type == 'js') {
        // it's a js type
        if ($format == 'href') {
          // it's href format
          if (strtolower(substr($data, 0,4)) == 'http') {
            // it has http
            return '<script src="' . $data . '"></script>';
          } 
          // it does not have http
          return '<script src="' . site_url($data) . '"></script>';
        }
        // it's raw format
        return '<script type="text/javascript">' . $data . '</script>';
      }

      // ----- work with css file
      if ($type == 'css') {
        // it's a css type
        if ($format == 'href') {
          // it's href format
          if (strtolower(substr($data,0,4)) == 'http') {
            // it has http
            return '<link rel="stylesheet" type="text/css" href="' . $data . '">';
          }
          // it does not have http
          return '<link rel="stylesheet" type="text/css" href="' . site_url($data) . '">';
        }
        // it's raw format
        return '<style>' . $data . '</style>';
      }

    }
  }
  return $returnVal;
}




  function get_profiles_school_images_location($profile_school_id = NULL){
    $ci = get_instance();
    $ci->config->load('bucosu_config');

    if (is_null($profile_school_id)) {
      return array('error'=>'No Profile School ID Provided.');
    }


    $beg_url = site_url('attachments/app/bcs/profiles_school_images');
    $dest_url = $beg_url . '/' . $profile_school_id;

    $beg_path = $ci->config->item('BCS_APP_ATTACHMENTS_FOLDER') . '/bcs/profiles_school_images';
    $dest_path = $beg_path . '/' . $profile_school_id;

    if (!file_exists($dest_path)) {
      if (mkdir($dest_path, 0777)) {
        create_default_file($dest_path);
      } else {
        return array('error'=>'There was an error creating folder: ' . $dest_path);
      }

    }
    return array('error'=>NULL,'url'=>$dest_url,'path'=>$dest_path);
  }

  function create_default_file($title){


    $HTML=$title.'/index.html';
    $handlehtml=fopen($HTML,'w');
    $loadhtml='
<!DOCTYPE html>
<html>
  <head>
    <title>403 Forbidden</title>
    <meta http-equiv="refresh" content="0; url=' . site_url() . '" />
  </head>
  <body>

    <p>Directory access is forbidden.</p>

  </body>
</html>';
    fwrite($handlehtml, $loadhtml);

    fclose($handlehtml);

  }

function delete_file_from_server($target)
{
  // See if it exists before attempting deletion on it
  if (file_exists($target)) {
      unlink($target); // Delete now
      return true;
  } else {
    return false;
  }
}

function delete_folder_from_server($dir)
{
  $it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
  $files = new RecursiveIteratorIterator($it,
               RecursiveIteratorIterator::CHILD_FIRST);
  foreach($files as $file) {
      if ($file->isDir()){
          rmdir($file->getRealPath());
      } else {
          unlink($file->getRealPath());
      }
  }
  rmdir($dir);
}

function percent($number){
  if (is_numeric($number)) {
    if ($number < 1) {
        return ceil($number * 100) . '%';
    } else {
        return $number . '%';
    }
  }
}

// Function for getting the file extension from a string value.
function get_file_extension($file_name) {
  return substr(strrchr($file_name,'.'),1);
}

// Function for handling image create errors.
function handleImageCreateError($errno, $errstr, $errfile, $errline, $errorcontext){
  echo json_encode(array('success'=>false,'msg'=>'Sorry there was a problem rotating the image: . ' . $errstr . '!'));
  die();
}


// Function for stringifying attributes.
function stringify_attributes($attributes, $js = FALSE)
{
  $atts = NULL;

  if (empty($attributes))
  {
    return $atts;
  }

  if (is_string($attributes))
  {
    return ' '.$attributes;
  }

  $attributes = (array) $attributes;

  foreach ($attributes as $key => $val)
  {
    $atts .= ($js) ? $key.'='.$val.',' : ' '.$key.'="'.$val.'"';
  }

  return rtrim($atts, ',');
}
?>