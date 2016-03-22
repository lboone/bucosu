<div class="admin-form theme-info tab-pane center-block mw700" id="<?php echo $container_form_id; ?>">
  <div class="panel panel-info heading-border">
    <div class="panel-heading">
      <span class="panel-title">
        <i class="fa fa-pencil-square"></i><?php echo $heading_title; ?>
      </span>
      <?php echo $sub_heading_title; ?>
    </div>
    <!-- end .form-header section -->
    <div id="infoMessage"><?php echo $message;?></div>
    <?php echo form_open($submit_url,$form_id);?>
      <div class="panel-body p25">
        <?php foreach ($fields as $field): ?>
          <div class="section">

            <?php if ($field['type'] == 'password'): ?>             
              <label for="<?php echo $field['id']?>" class="field-label"><?php echo $field['label']?></label>
              <label for="<?php echo $field['id']?>" class="field prepend-icon">
                <?php echo form_input($field['params']);?>
                <label for="<?php echo $field['id']?>" class="field-icon">
                  <i class="fa <?php echo $field['icon']?>"></i>
                </label>
              </label>
             
            <?php elseif($field['type'] == 'dropdown'): ?>

              <div class="col-md-6">
                <label class="field select">
                  <?php echo form_dropdown($field['params']['name'],$field['params']['options'], $field['params']['selected'],$field['params']['additional']); ?>
                  <i class="arrow double"></i>
                </label>
              </div>

            <?php elseif($field['type'] == 'textarea'): ?>    

              <label for="<?php echo $field['id']?>" class="field prepend-icon">
                <?php echo form_textarea($field['params']);?>
                <label for="<?php echo $field['id']?>t" class="field-icon">
                  <i class="fa <?php echo $field['icon']?>"</i>
                </label>
                <span class="input-footer">
                  <strong>Hint:</strong><?php echo $field['hint']?></span>
              </label>
            
            <?php elseif($field['type'] == 'upload'): ?>  

              <!-- add upload later -->

            <?php elseif($field['type'] == 'hidden'): ?>  

            
            <?php else: ?>  
            
            <label for="<?php echo $field['id']?>" class="field-label"><?php echo $field['label']?></label>
              <label for="<?php echo $field['id']?>" class="field prepend-icon">
                <?php echo form_input($field['params']);?>
                <label for="<?php echo $field['id']?>" class="field-icon">
                  <i class="fa <?php echo $field['icon']?>"></i>
                </label>
              </label>
            <?php endif; ?>

          </div>
        <?php endforeach; ?>
                      
      <!-- end section row user name -->

      </div>
      <!-- end .form-body section -->
      <div class="panel-footer">
        <?php echo form_submit(array('name'=>'submit', 'class'=>'button btn-primary'), 'Submit');?>
      </div>
      <!-- end .form-footer section -->
    <?php echo form_close();?>
  </div>
  <!-- end .admin-form section -->