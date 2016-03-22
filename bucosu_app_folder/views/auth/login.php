<div class="admin-form theme-info mw500" id="login">

          <!-- Login Logo -->
          <div class="row table-layout">
            <a href="<?php echo site_url(); ?>" title="Return to Bucosu">
              <img src="<?php echo $logo['src']; ?>" title="<?php echo $logo['title']; ?>" class="<?php echo $logo['class']; ?>" style="<?php echo $logo['style']; ?>">
            </a>
          </div>

          <!-- Login Panel/Form -->
          <div class="panel mt30 mb25">

            <?php echo form_open("auth/login",array('id'=>'contact'));?>
              <div class="panel-body bg-light p25 pb15">

                <div class="alert alert-border-left alert-info dark alert-dismissable mb20">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <i class="fa fa-info pr10"></i>Please enter your Credentials to log in. </div>

               <?php 
                if ($message) {
                  echo $message;
                  echo '<!-- Divider -->';
                  echo '<div class="section-divider mv30"></div>';
                }
               ?>    

                <!-- Username Input -->
                <div class="section">
                  <label for="<?php echo $identity['name']; ?>" class="field-label text-muted fs18 mb10"><?php echo lang('login_identity_label', 'identity');?></label>
                  <label for="<?php echo $identity['name']; ?>" class="field prepend-icon">
                    <?php echo form_input($identity);?>
                    <label for="<?php echo $identity['name']; ?>" class="field-icon">
                      <i class="fa fa-user"></i>
                    </label>
                  </label>
                </div>

                <!-- Password Input -->
                <div class="section">
                  <label for="<?php echo $password['name']; ?>" class="field-label text-muted fs18 mb10"><?php echo lang('login_password_label', 'password');?></label>
                  <label for="<?php echo $password['name']; ?>" class="field prepend-icon">
                    <?php echo form_input($password);?>
                    <label for="<?php echo $password['name']; ?>" class="field-icon">
                      <i class="fa fa-lock"></i>
                    </label>
                  </label>
                </div>

              </div>

              <div class="panel-footer clearfix">
                <div class="col-md-9">
                  <label class="switch block switch-primary mt10">
                    <?php echo form_checkbox('remember', '1', FALSE, 'id="remember" checked');?>
                    <!-- <input type="checkbox" name="remember" id="remember" checked> -->
                    <label for="remember" data-on="YES" data-off="NO"></label>
                    <span>Remember me</span>
                  </label>
                </div>
                <div class="col-md-3">
                  <?php echo form_submit(array('type'=>'submit', 'value' => lang("login_submit_btn"), 'class' => 'button btn-primary mr10 pull-right'));?>
                </div>
              </div>

            <?php echo form_close();?>
          </div>

          <!-- Registration Links -->
          <div class="login-links">
            <p>
              <a href="<?php echo site_url() . 'auth/forgot_password'; ?>" class="active" title="Forgot Password">Forgot Password?</a>
            </p>
          </div>
        </div>