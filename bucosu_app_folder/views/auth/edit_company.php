              <!-- Order Form 1 -->
              <div class="admin-form theme-info tab-pane center-block mw700" id="order1" role="tabpanel">
                <div class="panel panel-info heading-border">
                  <div class="panel-heading">
                    <span class="panel-title">
                      <i class="fa fa-truck"></i><?php echo $title ;?>
                    </span>
                  </div>
                  <!-- end .form-header section -->

                  <?php echo form_open(current_url());?>
                    <div class="panel-body p25">
                      <div id="infoMessage"><?php echo $message;?></div>

                      <div class="section row">

                        <div class="col-md-6">
                          <label for="company_name" class="field prepend-icon">
                            <?php echo form_input($company_name);?>
                            <label for="company_name" class="field-icon">
                              <i class="fa fa-user"></i>
                            </label>
                          </label>
                        </div>
                        <!-- end section -->

                        <div class="col-md-6">
                          <label class="field select">
                            <?php echo form_dropdown($group_type['name'],$group_type['options'], $group_type['selected'],$group_type['additional']); ?>
                            <i class="arrow double"></i>
                          </label>
                        </div>
                      </div>
                      <!-- end section row section -->

                      <div class="section row">
                        <div class="col-md-8">
                          <label for="company_address" class="field prepend-icon">
                            <?php echo form_input($company_address);?>
                            <label for="company_address" class="field-icon">
                              <i class="fa fa-map-marker"></i>
                            </label>
                          </label>
                        </div>
                        <!-- end section -->
                        <div class="col-md-4">
                          <label for="company_zip" class="field prepend-icon">
                            <?php echo form_input($company_zip);?>
                            <label for="company_zip" class="field-icon">
                              <i class="fa fa-certificate"></i>
                            </label>
                          </label>
                        </div>
                        <!-- end section -->                 
                      </div>
                      <!-- end section row section -->

                      <div class="section row">


                        <div class="col-md-6">
                          <label for="company_city" class="field prepend-icon">
                            <?php echo form_input($company_city);?>
                            <label for="company_city" class="field-icon">
                              <i class="fa fa-building-o"></i>
                            </label>
                          </label>
                        </div>
                        <!-- end section -->

                        <div class="col-md-6">
                          <label for="company_state" class="field select">
                          <?php echo form_dropdown($company_state['name'],$company_state['options'], $company_state['selected'],$company_state['additional']); ?>
                            <i class="arrow double"></i>
                          </label>
                        </div>
                      </div>
                      <!-- end section row section -->

                      <div class="section row">


                        <div class="col-md-6">
                          <label for="company_lat" class="field prepend-icon">
                            <?php echo form_input($company_lat);?>
                            <b class="tooltip tip-left-top"><em> Latitude </em></b>
                            <label for="company_lat" class="field-icon">
                              <i class="fa fa-map-marker"></i>
                            </label>
                          </label>
                        </div>
                        <!-- end section -->

                        <div class="col-md-6">
                          <label for="company_lng" class="field prepend-icon">
                            <?php echo form_input($company_lng);?>
                            <b class="tooltip tip-left-top"><em> Longitude </em></b>
                            <label for="company_lng" class="field-icon">
                              <i class="fa fa-map-marker"></i>
                            </label>
                          </label>
                        </div>

                      </div>
                      <!-- end section row section -->



                      <div class="section row">

                        <div class="col-md-6">
                          <label for="company_phone" class="field prepend-icon">
                            <?php echo form_input($company_phone);?>
                            <b class="tooltip tip-left-top"><em> PHone # </em></b>
                            <label for="company_phone" class="field-icon">
                              <i class="fa fa-phone-square"></i>
                            </label>
                          </label>
                        </div>
                        <!-- end section -->
                        <div class="col-md-6">
                          <label for="company_fax" class="field prepend-icon">
                            <?php echo form_input($company_fax);?>
                            <b class="tooltip tip-left-top"><em> Fax # </em></b>
                            <label for="company_fax" class="field-icon">
                              <i class="fa fa-phone-square"></i>
                            </label>
                          </label>
                        </div>

                      </div>

                      <div class="section row">
                        <div class="col-md-6">
                          <label for="company_website" class="field prepend-icon">
                            <?php echo form_input($company_website);?>
                            <label for="company_website" class="field-icon">
                              <i class="fa fa-external-link"></i>
                            </label>
                          </label>
                        </div>

                        <div class="col-md-6">
                          <label for="company_logo" class="field prepend-icon">
                            <?php echo form_input($company_logo);?>
                            <label for="company_logo" class="field-icon">
                              <i class="fa fa-upload"></i>
                            </label>
                          </label>
                        </div>
                      </div>

                      <div class="section row">
                       <div class="col-md-12">
                          <label for="company_id" class="field prepend-icon">
                            <?php echo form_input($company_id);?>
                            <b class="tooltip tip-left-top"><em> ie: SED District Number - for school district. </em></b>
                            <label for="company_id" class="field-icon">
                              <i class="fa fa-barcode"></i>
                            </label>
                          </label>
                        </div>
                        <!-- end section -->
                      </div>
                      <!-- end section row section -->
                    </div>
                    <!-- end .form-body section -->
                    <div class="panel-footer align-right">
                      <?php echo form_submit(array('name'=>'submit', 'class'=>'button btn-primary'), 'Save Company');?>
                    </div>
                    <!-- end .form-footer section -->
                  <?php echo form_close();?>
                </div>
                <!-- end .admin-form section -->
                <?php if(isset($agreements_view) && !$agreements_view == NULL){echo $agreements_view;}else{echo '';} ?>


                <?php if (isset($company_lng) && isset($company_lat)): ?>
                  <div class="panel">
                    <div class="panel-heading">
                      <span class="panel-title">
                        <span class="glyphicon glyphicon-map-marker"></span><?php echo $company_name['value']; ?> 's Location</span>
                    </div>
                    <div class="panel-body">
                      <div id="company_map" class="map"></div>
                    </div>
                  </div>
                <?php endif; ?>

              </div>

              <!-- end: .admin-form -->
