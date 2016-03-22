<?php 
	$params = array('id'=>'profiles_school_form_1');
	$hidden = array('event_school_id'=>$event_school_id,'profile_id'=>$profile_id,'form_status'=>$form_status);
  if (isset($id)) { $hidden['id'] = $id; }
?>

<?php echo form_open_multipart('#',$params,$hidden);?> <!-- BEGIN: form_open_multipart -->

  <?php echo 'Profile ID: ' . $profile_id ; ?><!-- Used to display the profile id -->

  <?php echo 'Event School ID: ' . $event_school_id; ?><!-- Used to display the event school id -->

  <div class="panel mb25 mt5"><!-- BEGIN: .panel -->

    <div class="panel-heading"><!-- BEGIN: .panel-heading -->

      <span class="panel-title hidden-xs"> Manage Profiles</span><!-- .panel-title -->

      <ul class="nav panel-tabs-border panel-tabs"><!-- BEGIN: panel tabs -->

        <li id="profile_new" class="active">
          <a href="#tab1_1" data-toggle="tab"><?php if($form_status=='new'){echo 'New '; } else { echo 'Edit '; }?>Profile</a>
        </li>

        <li id="profile_saved">
          <a href="#tab1_2" data-toggle="tab">Saved <?php if(isset($tab_icon)){echo $tab_icon; }?></a>
        </li>

        <li id="profile_images">
          <a href="#tab1_3" data-toggle="tab" data-state="read">Images</a>
        </li>

      </ul><!-- END: panel tabs -->

    </div><!-- END: .panel-heading -->

    <div class="panel-body p20 pb10"> <!-- BEGIN: panel-body -->

      <div class="tab-content pn br-n admin-form theme-primary"><!-- BEGIN: .tab-content -->   

        <div id="tab1_1" class="tab-pane active"><!-- BEGIN: #tab_1 -->
  
          <div class="section-divider mb40" id="spy1">
            <span>1. Add/Edit profile</span>
          </div>

          <div id="row_1_profile_name_location" class="section row mb10"><!-- BEGIN: #row_1_profile_name_location -->
            
            <div id="row_1_col_1_profile_name" class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 pl15"><!-- BEGIN: row_1_col_1_profile_name -->
              
              <div class="section mb10 "><!-- BEGIN; .section -->

                <div class="mb5 text-primary">
                  Profile Name:
                </div>
              
                <label for="name" class="field prepend-icon">

                  <?php 
                    if (!isset($name_value)) {
                      $name_value=NULL;
                    }
                    $params = array(
                                      'name'        =>'name',
                                      'id'          =>'name',
                                      'class'       =>'event-name gui-input',
                                      'placeholder' =>'Unique Name');

                    echo form_input($params,$name_value); 
                  ?>

                  <label for="name" class="field-icon">
                    <i class="fa fa-pencil-square-o"></i>
                  </label>

                </label>
              
                <span class="help-block mt5">
                    <i class="fa fa-lightbulb-o"></i> Please create a unique name for each profile.</span>
              
              </div><!-- END: .section -->
            
            </div><!-- END: row_1_col_1_profile_name -->

            <div id="row_1_col_2_location" class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 pl15"><!-- BEGIN: row_1_col_2_location -->
              
              <div class="spacer20 visible-md-block visible-sm-block visible-xs-block"></div>
              
              <div class="section mb10 form-group"><!-- BEGIN; .section -->
                
                <div class="mb5 text-primary">
                  Location:
                </div>
                
                <div class="col-md-12 pln prn"><!-- BEGIN: .col-md-12 -->
                  
                  <select name="location[]" id="location" class="event-location gui-input" placeholder="Location" multiple>
                      <?php
                        foreach ($locations as $key => $value) {
                          $selected = "";
                          if (isset($location_value)) {
                            if (is_array($location_value)) {
                                if (in_array($value, $location_value)) {
                                  $selected = " selected";
                                }
                              }  else {
                                if ($value == $location_value) {
                                  $selected = " selected";
                                }
                              }
                          }  
                          echo '<option value="' . $value  . '"' . $selected . '>' . $value . '</option>';
                        }
                      ?>                                 
                  </select>
                 
                  <span class="help-block mt5">
                    <i class="fa fa-location-arrow"></i> Use ";" to complete new location.</span>
                 
                 </div><!-- END: .col-md-12 -->

              </div><!-- END: .section -->                       
               
            </div><!-- END: row_1_col_2_location -->

          </div><!-- END: row_1_profile_name_location -->
          
          <div id="row_2_notes" class="section row mb10 mt20"><!-- BEGIN: row_2_notes -->
            
            <div id="row2_col1_notes" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12"><!-- BEGIN: row_2_col_1_notes -->
               
              <div class="section mb10"><!-- BEGIN; .section -->
                 
                <label class="field prepend-icon"><!-- BEGIN: label.field -->
                
                 <?php 
                    if (!isset($notes_value)) {
                      $notes_value=NULL;
                    }
                    $params = array(
                                      'name'        =>'notes',
                                      'id'          =>'notes',
                                      'class'       =>'event-notes gui-textarea',
                                      'placeholder' =>'Notes');

                    echo form_textarea($params,$notes_value); 
                 ?>
                 
                  <label for="notes" class="field-icon">
                    <i class="fa fa-comments"></i>
                  </label>
               
                </label><!-- END: label.field -->

              </div><!-- END; .section -->
            
            </div><!-- END: row_2_col_1_notes -->

          </div><!-- END: row_2_notes -->
          
          <div id="row_3_facilities_alert" class="section row mb10 theme-alert"><!-- BEGIN: row_3_facilities_alert -->
            
            <div class="section-divider mb40" id="spy1">
              <span>1a. Facilities Alert</span>
            </div>

            <div id="row_3_col_1_switch" class="col-xs-3 col-sm-3 col-md-3 col-lg-2 col-xl-1 pl10 pr5"><!-- BEGIN: row_3_col_1_switch -->

              <div class="section pull-left pr5"><!-- BEGIN; .section -->

                <label class="switch switch-alert switch-inline"><!-- BEGIN: label.switch -->
                  <?php 
                    if (!isset($facilities_alert)) {
                      $isChecked=0;
                    } else {
                      $isChecked = intval($facilities_alert);
                    }
                    $params = array(
                                      'name'        =>'facilities_alert',
                                      'id'          =>'facilities_alert',
                                      'value'       => '1',
                                      'checked'     => $isChecked,
                                      );

                    echo form_checkbox($params); 
                  ?>
                  <label for="facilities_alert" data-on="YES" data-off="NO"></label>
                  <span></span>
              
                </label><!-- END: label.switch -->
              
              </div><!-- END; .section -->

            </div><!-- END: row_3_col_1_switch -->

            <div id="row_3_col_2_field" class="col-xs-9 col-sm-9 col-md-9 col-lg-10 col-xl-11 pln"><!-- BEGIN: row_3_col_2_field -->

              <div class="section"><!-- BEGIN; .section -->

                <label class="field prepend-icon"><!-- BEGIN: label.field -->
                 <?php 
                    if (!isset($facilities_alert_description)) {
                      $facilities_alert_description=NULL;
                    }
                    $params = array(
                                      'name'        =>'facilities_alert_description',
                                      'id'          =>'facilities_alert_description',
                                      'class'       =>'event-notes gui-textarea',
                                      'style'       => 'height: 80px;',
                                      'placeholder' =>'Facilities Alert Description');

                    echo form_textarea($params,$facilities_alert_description); 
                 ?>

                  <label for="facilities_alert_description" class="field-icon">
                    <i class="fa fa-bolt"></i>
                  </label>

                </label><!-- END: label.field -->

              </div><!-- END; .section -->

            </div><!-- END: row_3_col_2_field -->

          </div><!-- END: row_3_facilities_alert -->
          
          <div id="row_4_save_profile_new_profile_buttons" class="section row mbn"><!-- BEGIN: row_4_save_profile_new_profile_buttons -->
             
            <div class="section-divider mb40" id="spy1">
              <span>2. Save Profile</span>
            </div>
 
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 pull-left mb20 pln mt5"><!-- BEGIN: row_4_col_1_new_button -->

                  <button id="new_profile_school_new_button" class="btn btn-primary pull-left ladda-button" data-style="zoon-out"><span class="ladda-label">New Profile</span></button>

            </div><!-- END: row_4_col_1_new_button -->

            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 pull-right mb20 prn mt5"><!-- BEGIN: row_4_col_2_save_button -->

                  <button id="new_profile_school_save_button" class="btn btn-system pull-right ladda-button" data-style="zoom-out"><span class="ladda-label">Save Profile</span></button>
                  
            </div><!-- END: row_4_col_2_save_button -->

          </div><!-- END: row_r_save_profile_new_profile_buttons -->

        </div><!-- END: #tab_1 -->

        <div id="tab1_2" class="tab-pane" <?php if(isset($data_state_tab_2)) { echo $data_state_tab_2 ; }?>><!-- BEGIN: #tab_2 -->

          <div class="section row mbn">

            <div id="bcs_profiles_school_saved"><img src="../../assets/img/loading.gif" class="center-block img-responsive mb20 mt20">Loading...</div>

          </div>

        </div><!-- END: #tab_2 -->

        <div id="tab1_3" class="tab-pane" <?php if(isset($data_state_tab_3)) {echo $data_state_tab_3 ; }?>><!-- BEGIN: #tab_3 -->                    

          <div class="section-divider mb40" id="spy1">
            <span>5. Attach File</span>
          </div>

          <div class="col-sm-12 col-lg-12 col-xs-12 col-md-12 col-xlg-6">
            
            <input type="file" id="file_input">
            
            <div class="col-sm-12 col-lg-12 col-xs-12 col-md-12 col-xlg-6 pt20 pln prn" >
              <div class="col-sm-10 col-lg-10 col-xs-10 col-md-10 col-xlg-5 pln">
                <input type="text" id="file_input_text" name="file_input_text" class="form-control" placeholder="Type a new descriptive name here...">
              </div>
              <div class="col-sm-2 col-lg-2 col-xs-2 col-md-2 col-xlg-1 prn">
                <p class="text-system text-center mt10">Rename it!.</p>
              </div>
            </div>
          </div>  

          <div class="col-sm-12 col-lg-12 col-xs-12 col-md-12 col-xlg-6">
            <div id="image_results"><img src="../../assets/img/loading.gif" class="center-block img-responsive mb20 mt20">Loading...</div>
          </div>

        </div><!-- END: #tab_3 -->  

      </div> <!-- END: .tab-content -->

    </div><!-- END: .panel-body -->

  </div><!-- END: .panel -->

<?php echo form_close(); ?><!-- END: form_open_multipart -->

<?php if (isset($foot)) { echo $foot; } ?>