<div class="admin-form theme-info mw600" style="margin-top: 13%;" id="login">
    <div class="row mb15 table-layout">

      <div class="col-xs-6 pln">
        <a href="<?php echo site_url(); ?>" title="Return Home">
          <img src="<?php echo $logo['src']; ?>" title="<?php echo $logo['title']; ?>" class="<?php echo $logo['class']; ?>" style="<?php echo $logo['style']; ?>">
        </a>
      </div>

      <div class="col-xs-6 text-right va-b pr5">
        <div class="login-links">
          <a href="#" class="" title="False Credentials">Not <?php echo $user_name_logo['name'];?>?</a>
        </div>

      </div>

    </div>
    <div class="panel panel-alert heading-border br-n">

    <?php echo validation_errors(); ?>
    <!-- end .panel-heading section -->
    <?php echo form_open('',array('id'=>'screenlock'));?>
        <div class="panel-body bg-light pn">

          <div class="row table-layout">
            <div class="col-xs-3 p20 pv15 va-m br-r bg-light">
              <img class="br-a bw4 br-grey img-responsive center-block" src="<?php echo $user_name_logo['logo']; ?>" title="<?php echo $user_name_logo['name'];?>">
            </div>
            <div class="col-xs-9 p20 pv15 va-m bg-light">

              <h3 class="mb5"> <?php echo $user_name_logo['name']; ?>
                <small> - locked for <span id="logged_out_time"></span>
              </h3>
              <p class="text-muted"><?php echo $user_name_logo['email']; ?></p>

              <div class="section mt25">
                <label for="user_password" class="field prepend-icon">
                  <input type="password" name="user_password" id="user_password" class="gui-input" placeholder="Enter password">
                  <label for="password" class="field-icon">
                    <i class="fa fa-lock"></i>
                  </label>
                </label>
              </div>
              <!-- end section -->

            </div>
          </div>
        </div>
        <!-- end .form-body section -->

      <?php 
        $data3 = array(
                'class' =>'button btn-info pull-right',
          );
        echo form_submit($data3,'Unlock'); ?>

            <!-- end .form-footer section -->
    <?php echo form_close();?>
    </div>
    
  </div>