<?php 
	$params = array('id'=>'profiles_school_form_1');
	$hidden = array('event_school_id'=>$event_school_id,'profile_id'=>$profile_id,'form_status'=>$form_status);
  if (isset($id)) { $hidden['id'] = $id; }
?>
<?php echo form_open_multipart('#',$params,$hidden);?>


	<?php echo 'Profile ID: ' . $profile_id ; ?>

	<?php echo 'Event School ID: ' . $event_school_id; ?>

<div class="panel mb25 mt5">
            <div class="panel-heading">
              <span class="panel-title hidden-xs"> Manage Profiles</span>
              <ul class="nav panel-tabs-border panel-tabs">
                <li id="profile_new" class="active">
                  <a href="#tab1_1" data-toggle="tab"><?php if($form_status=='new'){echo 'New '; } else { echo 'Edit '; }?>Profile</a>
                </li>
                <li id="profile_saved">
                  <a href="#tab1_2" data-toggle="tab">Saved <?php if(isset($tab_icon)){echo $tab_icon; }?></a>
                </li>
                <li id="profile_images">
                  <a href="#tab1_3" data-toggle="tab" data-state="read">Images</a>
                </li>
              </ul>
            </div>
            <div class="panel-body p20 pb10">
              <div class="tab-content pn br-n admin-form theme-primary">
                
                <div id="tab1_1" class="tab-pane active">
                  <div class="section-divider mb40" id="spy1">
                    <span>1. Add/Save profile</span>
                  </div>
                
                  <div class="section row mbn">
                  	
	                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-7 col-xl-6 pl15">
	                      <div class="section mb10 ">
                        <div class="mb5 text-primary">Profile Name:</div>
	                        <label for="name" class="field prepend-icon">
	                         <?php 
                              if (!isset($name_value)) {
                                $name_value=NULL;
                              }
                              $params = array(
                                                'name'        =>'name',
                                                'id'          =>'name',
                                                'class'       =>'event-name gui-input br-light light',
                                                'placeholder' =>'Unique Name');

                              echo form_input($params,$name_value); 
                           ?>
	                          <label for="name" class="field-icon">
	                            <i class="fa fa-pencil-square-o"></i>
	                          </label>
	                        </label>
	                      </div>
	                      <div class="section mb10 form-group">
                          <div class="mb5 mt20 text-primary">Location:</div>
                          <div class="col-md-12 pln prn mb10">
                            <select name="location[]" id="location" class="event-location gui-input br-light light" placeholder="Location" multiple>
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
                           </div>
	                      </div>	                      
                        <div class="col-xs-6 col-sm-6 col-md-9 col-lg-10 col-xl-11 pull-left mb20 pln mt5">                              
                              <input type="button" id="new_profile_school_new_button" value="New Profile"  class="button btn-primary pull-left">
                        </div>


                        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 col-xl-1 pull-right mb20 prn mt5">                              
                              <input type="submit" id="new_profile_school_save_button" value="Save Profile"  class="button btn-system pull-right">
                        </div>  	                      
	                    </div>
	              		<div class="col-xs-12 col-sm-12 col-md-4 col-lg-5 col-xl-6">
							           <div class="section mb10">
		                        <label class="field prepend-icon">
                             <?php 
                                if (!isset($notes_value)) {
                                  $notes_value=NULL;
                                }
                                $params = array(
                                                  'name'        =>'notes',
                                                  'id'          =>'notes',
                                                  'class'       =>'event-notes gui-textarea br-light bg-light',
                                                  'placeholder' =>'Notes');

                                echo form_textarea($params,$notes_value); 
                             ?>
		                          <label for="notes" class="field-icon">
		                            <i class="fa fa-comments"></i>
		                          </label>
		                        </label>
	                      </div>
	              		</div>
                  </div>
                  <div class="section-divider mb40" id="spy1">
                    <span>1a. Facilities Alert</span>
                  </div>
                  <div class="section row mbn theme-alert">
                    <div class="col-xs-3 col-sm-2 col-md-2 col-lg-2 col-xl-1 pl15 prn">
                      <div class="section">
                        <label class="block switch switch-alert mrn">
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
                        </label>
                      </div>
                    </div>
                    <div class="col-xs-9 col-sm-10 col-md-10 col-lg-10 col-xl-11 pln">
                      <div class="section">
                        <label class="field prepend-icon">
                         <?php 
                            if (!isset($facilities_alert_description)) {
                              $facilities_alert_description=NULL;
                            }
                            $params = array(
                                              'name'        =>'facilities_alert_description',
                                              'id'          =>'facilities_alert_description',
                                              'class'       =>'event-notes gui-textarea br-light bg-light',
                                              'style'       => 'height: 80px;',
                                              'placeholder' =>'Facilities Alert Description');

                            echo form_textarea($params,$facilities_alert_description); 
                         ?>
                          <label for="facilities_alert_description" class="field-icon">
                            <i class="fa fa-bolt"></i>
                          </label>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>

                <div id="tab1_2" class="tab-pane" <?php if(isset($data_state_tab_2)) { echo $data_state_tab_2 ; }?>>
                  <div class="section row mbn">
                    <div id="bcs_profiles_school_saved"><img src="../../assets/img/loading.gif" class="center-block img-responsive mb20 mt20">Loading...</div>
                  </div>
                </div>

                <div id="tab1_3" class="tab-pane" <?php if(isset($data_state_tab_3)) {echo $data_state_tab_3 ; }?>>                    
                    <div class="section-divider mb40" id="spy1">
                      <span>4. Attach File</span>
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
                </div>
              </div>  
              </div>
          </div>
<?php echo form_close(); ?>
<?php if (isset($foot)) { echo $foot; } ?>