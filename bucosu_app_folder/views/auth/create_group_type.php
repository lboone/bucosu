<div class="admin-form theme-info tab-pane center-block mw700" id="create_user">
  <div class="panel panel-info heading-border">
    <div class="panel-heading">
      <span class="panel-title">
        <i class="fa fa-pencil-square"></i><?php echo lang('create_group_heading');?>
      </span>
      <?php echo lang('create_group_subheading');?>
    </div>
    <!-- end .form-header section -->
    <div id="infoMessage"><?php echo $message;?></div>
    <?php echo form_open(uri_string(),array('id'=>'form-create-user'));?>
      <div class="panel-body p25">
        <label for="group_name" class="field-label">Group's Name</label>
        <div class="section row">
          <div class="col-md-6">
            <label for="group_name" class="field prepend-icon">
              <?php echo form_input($group_name);?>
              <label for="group_name" class="field-icon">
                <i class="fa fa-user"></i>
              </label>
            </label>
          </div>
          <!-- end section first name -->
          <div class="col-md-6">
            <label for="group_level" class="field prepend-icon">
              <?php echo form_input($last_level);?>
              <label for="last_level" class="field-icon">
                <i class="fa fa-user"></i>
              </label>
            </label>
          </div>
          <!-- end section last name-->
        </div>
      <!-- end section row user name -->

      <div class= "section row">    
       <?php if ($this->ion_auth->is_admin()): ?>
            <div class="col-md-6" >
              <label for="assoc_companies[]" class="col-md-6 control-label mb5 mln pln"><?php echo lang('create_user_company_label', 'company');?></label>
              <label class="field select">
                <select id="multiselect0" class="multiselect-withlabels select2-single" style="display: none;" name="company">
                  <?php foreach ($assoc_companies as $key => $value):?>
                        <optgroup label="<?php echo $key; ?>">
                        <?php foreach ($value as $co): ?>
                          <?php
                              $coID=$co['id'];
                              $checked = null;
                                  if (intval($coID) == intval($company['value'])) {
                                      $checked= ' selected="selected"';
                                  }
                          ?>
                          <option value="<?php echo $coID; ?>" <?php echo $checked; ?>><?php echo $co['name'] ;?></option>
                        <?php endforeach; ?>
                        </optgroup>
                  <?php endforeach; ?>
                </select>
              </label>
            </div>
        <?php endif ?>

        <?php if ($this->ion_auth->is_admin() ) : ?>
            <div class="col-md-6">
              <label for="groups[]" class="col-md-6 control-label mb5 mln pln">Member of group</label>
              <label class="field select">
                <select id="multiselect1" class="multiselect-withlabels" style="display: none;" name="groups">
                  <?php foreach ($user_can_add_groups as $key => $value):?>
                        <optgroup label="<?php echo $key; ?>">
                        <?php foreach ($value as $grp): ?>
                          <?php
                              $gID=$grp['can_add_id'];
                              $checked = null;
                              $item = null;
                              if ($gID == $currentGroups) {
                                    $checked= ' selected="selected"';
                              }
                          ?>
                          <option value="<?php echo $grp['can_add_id']; ?>" <?php echo $checked; ?>><?php echo $grp['can_add_name'] ;?></option>
                        
                        <?php endforeach; ?>
                        </optgroup>
                  <?php endforeach; ?>
                </select>
              </label>
            </div>
        <?php endif ?>
      </div>


            
        
        <div class="section">
          <label for="email" class="field-label"><?php echo lang('create_user_email_label', 'email');?></label>
          <label for="email" class="field prepend-icon">
            <?php echo form_input($email);?>
            <label for="email" class="field-icon">
              <i class="fa fa-envelope-o"></i>
            </label>
          </label>
        </div>


        <div class="section">
          <label for="description" class="field-label"><?php echo lang('create_user_phone_label', 'phone');?></label>
          <label for="description" class="field prepend-icon">
            <?php echo form_input($description);?>
            <label for="description" class="field-icon">
              <i class="fa fa-phone-square"></i>
            </label>
          </label>
        </div>
        <!-- end section phone-->
      </div>
      <!-- end .form-body section -->
      <div class="panel-footer">
        <?php echo form_submit(array('name'=>'submit', 'class'=>'button btn-primary'), lang('create_group_submit_btn'));?>
      </div>
      <!-- end .form-footer section -->
    <?php echo form_close();?>
  </div>
  <!-- end .admin-form section -->
</div>



$.each({ name: "John", lang: "JS" }, function( k, v ) {
  alert( "Key: " + k + ", Value: " + v );
});