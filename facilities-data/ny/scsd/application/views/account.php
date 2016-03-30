<!DOCTYPE html>
<html lang="en">
<head>
    <?php $this->load->view("shared/head");?>
</head>
<body>

	<?php $this->load->view("shared/nav");?>
	
    <div class="container main extra-top-padding">
    
    	<div class="row">
    	
    		<div class="col-md-8 col-md-offset-2" id="mainContent">
    		
    			<!-- form errors -->
    			<?php if(validation_errors() != ''):?>
    			<div class="alert alert-error">
    				<button type="button" class="close fui-cross" data-dismiss="alert"></button>
    				<h4>Ouch!</h4>
    			  	<?php echo validation_errors(); ?>
    			</div>
    			<?php endif;?>
    		
    			<?php if($this->session->flashdata('error_message')):?>
    			<div class="alert alert-error">
    				<button type="button" class="close fui-cross" data-dismiss="alert"></button>
    				<h4>Ouch!</h4>
    			  	<?php echo $this->session->flashdata('error_message');?>
    			</div>
    			<?php endif;?>
    			
    			<?php if($this->session->flashdata('success_message')):?>
    			<div class="alert alert-success">
    				<button type="button" class="close fui-cross" data-dismiss="alert"></button>
    				<h4>Joy!</h4>
    			  	<?php echo $this->session->flashdata('success_message');?>
    			</div>
    			<?php endif;?>
    		    			
    			<ul class="nav nav-tabs nav-append-content">
    				<li class="active"><a href="#tab1"><span class="fui-user"></span> My Profile</a></li>
    				<li><a href="#tab2"><span class="fui-gear"></span> More</a></li>
    			</ul> <!-- /tabs -->
    			
    			<div class="tab-content">
    			
    				<div class="tab-pane fade in active" id="tab1">
    				
    					<h4>My profile</h4>
    				
    					<hr>
    			    	
    			    	<form class="form-horizontal" role="form" action="<?php echo site_url('account/updateLogin/'.$theUser->user_id);?>" method="post">
    			    		<input type="hidden" name="_token" value="<?php echo $this->session->userdata('session_id');?>">
    			    		<div class="form-group">
    			    	    	<label for="email" class="col-sm-offset-1 col-sm-2 control-label">Email <span class="red">*</span></label>
    			    	    	<div class="col-sm-8">
    			    	      		<input type="email" class="form-control" name="email" id="email" placeholder="Email" value="<?php echo $theUser->email;?>">
    			    	    	</div>
    			    	  	</div>
    			    	  	<div class="form-group">
    			    	    	<label for="password" class="col-sm-offset-1 col-sm-2 control-label">Password <span class="red">*</span></label>
    			    	    	<div class="col-sm-8">
    			    	      		<input type="password" class="form-control" name="password" id="password" placeholder="Password">
    			    	    	</div>
    			    	  	</div>
    			    	  	<div class="form-group">
    			    	    	<div class="col-sm-offset-3 col-sm-8">
    			    	      		<button type="submit" class="btn btn-info btn-embossed">Update username / password</button>
    			    	    	</div>
    			    	  	</div>
    			    	</form>
    			    	
    			    	<hr>
    			    	
    			    	<form class="form-horizontal" role="form" action="<?php echo site_url('account/update/'.$theUser->user_id);?>" method="post">
    			    		<input type="hidden" name="_token" value="<?php echo $this->session->userdata('session_id');?>">
    			    		<div class="form-group">
    			    	    	<label for="firstname" class="col-sm-offset-1 col-sm-2 control-label">First name <span class="red">*</span></label>
    			    	    	<div class="col-sm-8">
    			    	      		<input type="text" class="form-control" name="firstname" id="firstname" placeholder="First name" value="<?php echo $theUser->first_name;?>">
    			    	    	</div>
    			    	  	</div>
    			    	  	<div class="form-group">
    			    	  		<label for="lastname" class="col-sm-offset-1 col-sm-2 control-label">Last name <span class="red">*</span></label>
    			    	  		<div class="col-sm-8">
    			    	  	  		<input type="text" class="form-control" name="lastname" id="lastname" placeholder="Last name" value="<?php echo $theUser->last_name;?>">
    			    	  		</div>
    			    	  		</div>
    			    	  	<div class="form-group">
    			    	    	<label for="company" class="col-sm-offset-1 col-sm-2 control-label">Company</label>
    			    	    	<div class="col-sm-8">
    			    	      		<input type="text" class="form-control" name="company" id="company" placeholder="Company" value="<?php echo $theUser->company;?>">
    			    	    	</div>
    			    	  	</div>
    			    	  	<div class="form-group">
    			    	  		<label for="phone" class="col-sm-offset-1 col-sm-2 control-label">Phone</label>
    			    	  		<div class="col-sm-8">
    			    	  			<input type="text" class="form-control" name="phone" id="phone" placeholder="Phone number" value="<?php echo $theUser->phone;?>">
    			    	  		</div>
    			    	  	</div>
    			    	  	<div class="form-group">
    			    	  		<label for="phone" class="col-sm-offset-1 col-sm-2 control-label">User role</label>
    			    	  		<div class="col-sm-8">
    			    	  			<input type="text" class="form-control" disabled name="" id="" placeholder="Role" value="<?php echo $theUser->description;?>">
    			    	  		</div>
    			    	  	</div>
    			    	  	<div class="form-group">
    			    	    	<div class="col-sm-offset-3 col-sm-9">
    			    	      		<button type="submit" class="btn btn-info btn-embossed">Update profile</button>
    			    	    	</div>
    			    	  	</div>
    			    	</form>
    			    	
    				</div><!-- /#tab1 -->
    				<div class="tab-pabe fade" id="tab2">
    					
    					<h4>More actions for this user</h4>
    					
    					
    					
    				</div><!-- /.#tab2 -->
    			    			    
    			</div> <!-- /tab-content -->
    			    			
    		</div><!-- /.col-md-9 -->
    	</div><!-- /.row -->
    </div>
    <!-- /.container -->
    
    <?php $this->load->view("users/includes/modal_newuser");?>

    <!-- Load JS here for greater good =============================-->
    <script src="<?php echo $this->config->item('base_url');?>js/jquery-1.8.3.min.js"></script>
    <script src="<?php echo $this->config->item('base_url');?>js/jquery-ui-1.10.3.custom.min.js"></script>
    <script src="<?php echo $this->config->item('base_url');?>js/jquery.ui.touch-punch.min.js"></script>
    <script src="<?php echo $this->config->item('base_url');?>js/bootstrap.min.js"></script>
    <script src="<?php echo $this->config->item('base_url');?>js/bootstrap-select.js"></script>
    <script src="<?php echo $this->config->item('base_url');?>js/bootstrap-switch.js"></script>
    <script src="<?php echo $this->config->item('base_url');?>js/flatui-checkbox.js"></script>
    <script src="<?php echo $this->config->item('base_url');?>js/flatui-radio.js"></script>
    <script src="<?php echo $this->config->item('base_url');?>js/jquery.tagsinput.js"></script>
    <script src="<?php echo $this->config->item('base_url');?>js/jquery.placeholder.js"></script>
    <script src="<?php echo $this->config->item('base_url');?>js/application.js"></script>
    <script src="<?php echo $this->config->item('base_url');?>js/jquery.dataTables.min.js"></script>
    <script src="<?php echo $this->config->item('base_url');?>js/TableTools.min.js"></script>
    <script src="<?php echo $this->config->item('base_url');?>js/ZeroClipboard.js"></script>
    <script src="<?php echo $this->config->item('base_url');?>js/bootstrap-datatables.js"></script>
    <script src="<?php echo $this->config->item('base_url');?>js/datatables.plugins.js"></script>
    <script src="<?php echo $this->config->item('base_url');?>assets/redactor/redactor.js"></script>
    <script src="<?php echo $this->config->item('base_url');?>js/dbapp/dbapp_users.js"></script>
  </body>
</html>
