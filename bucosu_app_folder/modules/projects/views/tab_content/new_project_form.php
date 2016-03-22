<div class="admin-form theme-primary tab-pane mw800 center-block" id="project_form_pane" role="tabpanel">
      <div class="panel heading-border">
        <div class="panel-heading">
          <span class="panel-title">
            <i class="fa fa-building"></i>Create Project
          </span>
        </div>
        <!-- end .form-header section -->

        <?php $hidden1 = array('name'=>'event_school_district_id','type'=>'hidden','id'=>'event_school_district_id');?>
        <?php $hidden2 = array('name'=>'event_school_id','type'=>'hidden','id'=>'event_school_id');?>
        <?php $hidden3 = array('name'=>'associated_profiles','type'=>'hidden','id'=>'associated_profiles');?>
        <?php $hidden4 = array('name'=>'is_bcs_project','type'=>'hidden','id'=>'is_bcs_project');?>
        <?php $params = array('id'=>'project_form'); ?>
        <?php echo form_open('projects/save_new_project',$params);?>
          <?php echo form_input($hidden1);?>
          <?php echo form_input($hidden2);?>
          <?php echo form_input($hidden3);?>
          <?php echo form_input($hidden4);?>
          <div class="panel-body p25">
            
            <!-- BEGIN: Item Details - Detailed Description -->
            <div class="section row">
              <div class="col-md-12">
                <div class="section">
                  <?php echo form_label('Item Description','item_description',array('class'=>'field-label')); ?>
                  <label for="item_description" class="field prepend_icon">
                    <?php echo form_input(array('name'=>'item_description','type'=>'text','id'=>'item_description', 'class'=>"gui-input")); ?>
                  </label>
                </div>
              </div>
              <div class="col-md-12">
                <div class="section">
                  <?php echo form_label('Detailed Description','detailed_description',array('class'=>'field-label')); ?>
                  <label for="detailed_description" class="field prepend_icon">
                    <?php echo form_textarea(array('name'=>'detailed_description','type'=>'text','id'=>'detailed_description', 'class'=>"gui-textarea")); ?>
                    <span class="input-footer">
                      <strong>Hint:</strong>Provide a more detailed description of the project, for later reference.  Not used in the 5 Year Plan.</span>
                  </label>
                </div>
              </div>
            </div>
            <!-- END: Item Details - Detailed Description -->

            <!-- BEGIN: Year To Complete - Cost -->
            <div class="section row">
              <div class="col-md-3">
                <div class="section">
                  <?php echo form_label('Year To Complete','year_to_complete',array('class'=>'field-label')); ?>
                  <label for="year_to_complete" class="field prepend_icon">
                    <?php echo form_input(array('name'=>'year_to_complete','type'=>'text','id'=>'year_to_complete', 'class'=>"gui-input")); ?>
                  </label>
                </div>
              </div>
              <div class="col-md-3">
                <div class="section">
                  <?php echo form_label('Priority','priority',array('class'=>'field-label')); ?>
                  <label for="priority" class="field prepend_icon">
                    <?php echo form_input(array('name'=>'priority','type'=>'text','id'=>'priority', 'class'=>"gui-input")); ?>
                  </label>
                </div>
              </div>
              <div class="col-md-3">
                <div class="section">
                  <?php echo form_label('BCS Question Number','bcs_question_number',array('class'=>'field-label')); ?>
                  <label for="bcs_question_number" class="field prepend_icon">
                    <?php echo form_input(array('name'=>'bcs_question_number','type'=>'text','id'=>'bcs_question_number', 'class'=>"gui-input")); ?>
                  </label>
                </div>
              </div>
              <div class="col-md-3">
                <div class="section">
                  <?php echo form_label('Cost','cost',array('class'=>'field-label')); ?>
                  <label for="cost" class="field prepend_icon">
                    <?php echo form_input(array('name'=>'cost','type'=>'text','id'=>'cost', 'class'=>"gui-input")); ?>
                  </label>
                </div>
              </div>
            </div>            
            <!-- END: Year To Complete - Cost -->

            <!-- BEGIN: Project Purpose - Project Type -->
            <div class="section row mb5">
              <div class="col-md-6">
                <div class="section">
                  <?php echo form_label('Project Purpose','purpose_id',array('class'=>'field-label')); ?>
                  <label for="purpose_id" class="field select">
                    <?php echo form_dropdown(array('name'=>'purpose_id','type'=>'text','id'=>'purpose_id')); ?>
                    <i class="arrow double"></i>
                  </label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="section">
                  <?php echo form_label('Project Type','type_id',array('class'=>'field-label')); ?>
                  <label for="type_id" class="field select">
                    <?php echo form_dropdown(array('name'=>'type_id','type'=>'text','id'=>'type_id')); ?>
                    <i class="arrow double"></i>
                  </label>
                </div>
              </div>
            </div>            
            <!-- END: Project Purpose - Project Type -->

          </div>                        <!-- END .panel-body -->
          <div class="panel-footer">
            <button type="submit" class="button btn-primary">Create Project</button>
          </div>
        <?php echo form_close(); ?>     <!-- END: #project_form -->
      </div>                            <!-- .panel heading-border -->
    </div>                              <!-- end .admin-form section -->