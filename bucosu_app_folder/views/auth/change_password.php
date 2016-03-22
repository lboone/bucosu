<div class="admin-form theme-info dark tab-pane mw800 active" id="login1" role="tabpanel">
                <div class="panel panel-info dark heading-border">
                  <div class="panel-heading">
                    <span class="panel-title">
                      <i class="fa fa-exchange"></i><?php echo lang('change_password_heading');?></span>
                  </div>
                  <!-- end .form-header section -->

                  <?php echo form_open("auth/change_password",array('id'=>'form-login1'));?>
                    <div class="panel-body p25 pt10">
                     <?php
                       if ($message)
                       {
                          echo $message;;
                          echo '<div class="section-divider mv40"></div>';
                       }
                     ?>
                      
                      <!-- .section-divider -->

                      <div class="section">
                        <label for="<?php echo $old_password['name'];?>" class="field prepend-icon">
                          <?php echo form_input($old_password);?>
                          <label for="<?php echo $old_password['name'];?>" class="field-icon">
                            <i class="fa fa-lock"></i>
                          </label>
                        </label>
                      </div>
                      <!-- end section -->

                      <div class="section">
                        <label for="<?php echo $new_password['name'];?>" class="field prepend-icon">
                          <?php echo form_input($new_password);?>
                          <label for="<?php echo $new_password['name'] ;?>" class="field-icon">
                            <i class="fa fa-lock"></i>
                          </label>
                        </label>
                      </div>
                      <!-- end section -->

                      <div class="section">
                        <label for="<?php echo $new_password_confirm['name'];?>" class="field prepend-icon">
                          <?php echo form_input($new_password_confirm);?>
                          <label for="<?php echo $new_password_confirm['name'] ;?>" class="field-icon">
                            <i class="fa fa-lock"></i>
                          </label>
                        </label>
                      </div>
                      <!-- end section -->

                    </div>
                    <!-- end .form-body section -->
                    <div class="panel-footer">
                      <?php echo form_submit(array('name'=>'submit', 'value'=> lang("change_password_submit_btn"), 'class'=> 'button btn-info dark'));?>
                    </div>
                    <!-- end .form-footer section -->
                  <?php echo form_close();?>
                </div>
                <!-- end .panel-->
              </div>
