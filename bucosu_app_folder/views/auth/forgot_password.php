<div class="admin-form theme-info mw500" style="margin-top: 10%;" id="login">
  <div class="row mb15 table-layout">

    <div class="col-xs-6 pln">
      <a href="<?php echo site_url(); ?>" title="Return to Bucosu">
        <img src="<?php echo $logo['src']; ?>" title="<?php echo $logo['title']; ?>" class="<?php echo $logo['class']; ?>" style="<?php echo $logo['style']; ?>">
      </a>
    </div>

    <div class="col-xs-6 va-b">
      <div class="login-links text-right">
        <a href="<?php echo $login_link['href']; ?>" class="<?php echo $login_link['class']; ?>" title="<?php echo $login_link['title']; ?>"><?php echo $login_link['title']; ?></a>
      </div>
    </div>
  </div>

  <div class="panel">

	<?php echo form_open("auth/forgot_password", array('id'=>'forgot_password_form'));?>

	<div class="panel-body p15">
		<div class="alert  alert-border-left alert-info dark alert-dismissable mn">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		    <i class="fa fa-info pr10"></i><?php echo sprintf(lang('forgot_password_subheading'), $identity_label);?>
		</div>
		<!-- Error Message Begin -->
		<?php if ($message){ echo $message;	} ?>
	</div>

              <div class="panel-footer p25 pv15">

                <div class="section mn">

                  <div class="smart-widget sm-right smr-80">
                    <label for="email" class="field prepend-icon">

                    	<?php echo form_input($email);?>
                      <label for="email" class="field-icon">
                        <i class="fa fa-envelope-o"></i>
                      </label>
                    </label>
                    <label for="email" id="forgot_password_btn" class="button">Reset</label>
                </div>
               </div>
              </div>
	      <!-- <p><?php echo form_submit('submit', lang('forgot_password_submit_btn'));?></p> -->

	<?php echo form_close();?>

  </div>

</div>