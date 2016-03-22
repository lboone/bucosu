<h1><?php echo $table_settings['table_heading'];?></h1>
<p><?php echo $table_settings['table_sub_heading'];?></p>
<div class="col-md-12">
  <div class="panel panel-visible" id="spy2">
    <div class="panel-heading">
      <div class="panel-title hidden-xs">
        <span class="glyphicon glyphicon-tasks"></span><?php echo $table_settings['table_heading'];?></div>
    </div>
    <div class="panel-body pn">
        <table id="<?php echo $table_settings['table_id']; ?>" class="table table-striped table-hover" cellpadding=0 cellspacing=10 width="100%">
          <thead>
        	<tr>
          <?php foreach ($table_header_data as $thd): ?>
            <th><?php echo $thd; ?></th>
          <?php endforeach; ?>
        	</tr>
          </thead>
        	<tfoot>
            <tr>
          <?php foreach ($table_header_data as $thd): ?>
            <th><?php echo $thd; ?></th>
          <?php endforeach; ?>
            </tr>
          </tfoot>
          <?php foreach ($table_row_data as $row):?>
            <tr>
            <?php foreach ($table_header_data as $thd): ?>
              <?php
                $type = $table_row_data_fields[$thd]['type'];
                $val = $table_row_data_fields[$thd]['value'];
                if ($type == 'mixed_media') {
                    $src = $table_row_data_fields[$thd]['src'];
                  	$ext = pathinfo($row->$val,PATHINFO_EXTENSION);             
          					switch(strtolower($ext))
          						{
          							//allowed file types
          							case 'png': 
          							case 'gif': 
          							case 'jpeg': 
                        case 'jpg':
          							case 'pjpeg':
                        case 'doc':
          							case 'xls':
                          echo '<td>';
                          echo '<a 
    href="' . $src . $row->$val . '?lastmod=' . $row->modified .'" 
    data-lightbox="'. $row->profile_school_id .'" 
    data-title="' . strtoupper($row->image_title) . '<br />Uploaded By: ' . $row->uploaded_by . ', ' . $row->company_name . ' <br />' . date('D, M d Y',strtotime($row->created)) .'" 
    class="">
    <img 
      src="' . $src . $row->$val . '?lastmod=' . $row->modified .'"
      class="img-responsive thumbnail"
      width="' .  ceil($row->width*.15) . '"
      height="' . ceil($row->height*.15) . '">
</a>';
                          
                          echo '<div class="btn-group">
  <button id="image_rotate_left" data-toggle="tooltip" data-placement="top" title="Rotate Left" data-image-id="' . $row->id . '" data-image-psid="' . $row->profile_school_id . '" data-image-filename="' . $row->$val . '" type="button" class="btn btn-warning light">
    <i class="fa fa-rotate-left"></i>
  </button>
  <button id="image_rotate_flip" data-toggle="tooltip" title="Flip" data-placement="top" data-image-id="' . $row->id . '" data-image-psid="' . $row->profile_school_id . '" data-image-filename="' . $row->$val . '" type="button" class="btn btn-warning">
    <i class="fa fa-arrow-up"></i>
  </button>
  <button id="image_rotate_right" data-toggle="tooltip" title="Rotate Right" data-placement="top" data-image-id="' . $row->id . '" data-image-psid="' . $row->profile_school_id . '" data-image-filename="' . $row->$val . '" type="button" class="btn btn-warning dark">
    <i class="fa fa-rotate-right"></i>
  </button>
</div>';
                          echo '</td>';
          								//echo '<td><img src="' . $src . $row->$val .'" class="img-thumbnail img-responsive" style="height:100px; width:100px;"></td>';
          								break;

                        case 'pdf':
                          echo '<td><embed src=' . $src . $row->$val .' style="max-width: 200px; height: auto; " alt=”'. $row->$val .'” pluginspage=http://www.adobe.com/products/acrobat/readstep2.html></td>';
                          break;

          							case 'mp4':
          							case 'mov':
          							case 'ogg':
                        			  	echo '<td><img src="' . site_url('assets/img/interface/bcs/VideoDefault.png') . '" class="img-thumbnail img-responsive" style="height:100px; width:100px;"></td>';
          								//echo '<td><video controls><source src="' . $src . $row->$val .'" type="video/'.$ext.'">Not Supported.</video>';	
          								break;
          							default:
          								echo '<td><img src="' . $src . $row->$val .'" class="img-thumbnail img-responsive" style="height:100px; width:100px;"></td>';
          					}
                } elseif ($type == 'x-editable-text'){
                  if (!trim($val[1]) == '') {
                    $id = $row->$val[1];
                  }
                  if (!trim($val[2]) == '') {
                   $text = $row->$val[2];
                  }
                  if (count($val) > 4) {
                    echo '<td class="x-editable-cell"><a href="#" id="' . $val[2] . '" data-pk = "'. $id . '" ' . $val[4] . '>' . $text . '</a></td>';                
                  }else{
                    echo '<td>' . anchor("#", $text) . '</td>';                
                  }

                } elseif ($type == 'anchor') {
                  $id = '';
                  $command = '';
                  $url = $val[0];
                  if (!trim($val[1]) == '') {
                    $id = $row->$val[1];
                  }
                  if (!trim($val[2]) == '') {
                    $command = $val[2];  
                  }
                  $text = $val[3];
                  
                  if (count($val) > 4) {
                    
                    $val[4]['id'] = strtolower($text) . '_' . $id;
                    echo '<td>' . anchor($url . $id . $command, $text,$val[4]) . '</td>';                
                  }else{
                    echo '<td>' . anchor($url . $id . $command, $text) . '</td>';                
                  }
                  
                } 
                elseif ($type == 'unserialize')
                {
                  $rslt = unserialize($row->$val);
                  if (is_array($rslt)) {
                    echo '<td>' . implode('<br/>',$rslt) . '</td>';
                  } else {
                    echo '<td>' . $rslt . '</td>';
                  }
                  
                }
                elseif ($type == 'image')
                {
                  echo '<td><span class="fa ' . $row->$val . '"></span></td>';
                } 
                elseif ($type == 'img')
                {
                  $src = $table_row_data_fields[$thd]['src'];
                  echo '<td><img src="' . $src . $row->$val .'" class="img-thumbnail img-responsive" style="height:100px; width:100px;"></td>';
                }
                else
                {
                  $dat = $row->$val;
                  echo '<td>' . $dat . '</td>';
                }
              ?>
          <?php endforeach; ?>
          </tr>
          <?php endforeach; ?>
        </table>
  </div>
</div>
<p>
<?php 
if (is_array($table_settings['table_new_record_anchors'])) {
  foreach($table_settings['table_new_record_anchors'] as $tr_anc){
    if (count($tr_anc) > 2) {
      echo anchor($tr_anc[0],$tr_anc[1],$tr_anc[2]);
    } else {
      echo anchor($tr_anc[0],$tr_anc[1]);
    }
  }
}
?>
</p>