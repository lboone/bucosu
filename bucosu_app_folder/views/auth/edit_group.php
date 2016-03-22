<div class="admin-form theme-info tab-pane center-block mw700" id="create_user">
  <div class="panel panel-info heading-border">
    <div class="panel-heading">
      <span class="panel-title">
        <i class="fa fa-pencil-square"></i><?php echo lang('edit_group_heading');?>
      </span>
      <?php echo lang('create_group_subheading');?>
    </div>
    <!-- end .form-header section -->
    <div id="infoMessage"><?php echo $message;?></div>
    <?php echo form_open(uri_string(),array('id'=>'form-create-user'));?>
      <div class="panel-body p25">
      
            <div class="section">
              <label for="group_name" class="field-label">Group Name</label>
              <label for="group_name" class="field prepend-icon">
                <?php echo form_input($group_name);?>
                <label for="group_name" class="field-icon">
                  <i class="fa fa-group"></i>
                </label>
              </label>
            </div>
            <!-- end section -->

            <div class="section">
              <label for="group_level" class="field-label">Level of Group</label>
              <label for="group_level" class="field prepend-icon">
                <?php echo form_input($group_level);?>
                <label for="confirmPassword" class="field-icon">
                  <i class="fa fa-key"></i>
                </label>
              </label>
            </div>
            <!-- end section -->
              <div class="section">
              <label for="group_type" class="field-label">Type of Group</label>
              <label class="field select">
                        <?php echo form_dropdown($group_type['name'],$group_type['options'], $group_type['selected'],$group_type['additional']); ?>
                  <i class="arrow double"></i>
              </label>
            </div>


          <div class="section">
            <label for="description" class="field prepend-icon">
              <?php echo form_textarea($description);?>
              <label for="comment" class="field-icon">
                <i class="fa fa-comment-o"></i>
              </label>
              <span class="input-footer">
                <strong>Hint:</strong>Please enter a brief description less than 100 characters.</span>
            </label>
          </div>
                      
      <!-- end section row user name -->


      </div>
      <!-- end .form-body section -->
      <div class="panel-footer">
        <?php echo form_submit(array('name'=>'submit', 'class'=>'button btn-primary'), lang('edit_group_submit_btn'));?>
      </div>
      <!-- end .form-footer section -->
    <?php echo form_close();?>
  </div>
  <!-- end .admin-form section -->
</div>