    <!--
          ".navbar" Helper Classes: 
        
         * Positioning Classes: 
          '.navbar-static-top' - Static top positioned navbar
          '.navbar-static-top' - Fixed top positioned navbar

         * Available Skin Classes:
           .bg-light     .bg-dark    .bg-primary
           .bg-success   .bg-info    .bg-warning
           .bg-danger    .bg-alert   .bg-system 
        
         Example: <header class="navbar navbar-fixed-top bg-primary">
         Results: Fixed top navbar with blue background 
        -->
    <!-- Start: Header -->
    <header class="navbar navbar-fixed-top bg-system hidden-print">
      <div class="navbar-branding">
        <a class="navbar-brand" href="<?php echo site_url('/');?>">
          <b>BUCOSU</b>.com
        </a>
        <span id="toggle_sidemenu_l" class="ad ad-lines"></span>
      </div>
      <ul class="nav navbar-nav navbar-left">
       <!-- <li>
          <a class="sidebar-menu-toggle" href="#">
            <span class="ad ad-ruby fs18"></span>
          </a>
        </li>
        <li>
          <a class="topbar-menu-toggle" href="#">
            <span class="ad ad-wand fs16"></span>
          </a>
        </li> -->
        <li class="hidden-xs">
          <a class="request-fullscreen toggle-active" href="#">
            <span class="ad ad-screen-full fs18"></span>
          </a>
        </li>
      </ul>
      <?php $params = array('class'=>'navbar-form navbar-left navbar-search', 'role'=>'search'); ?>
      <?php echo form_open('',$params); ?>
        <!-- <form class="navbar-form navbar-left navbar-search" role="search"> -->
        <!--<div class="form-group">
          <input type="text" class="form-control" placeholder="Search..." value="Search...">
        </div>-->
      <!--</form>-->
      <?php echo form_close(); ?>

      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle fw600 p15" data-toggle="dropdown"> 
            <img src="<?php echo $user_name_logo['logo']; ?>" alt="avatar" class="mw30 br64 mr15"> 
            <?php echo ucwords($user_name_logo['name']); ?>
            <span class="caret caret-tp hidden-xs"></span>
          </a>
          <ul class="dropdown-menu list-group dropdown-persist w250" role="menu">

            <li class="list-group-item">
              <a href="<?php echo $user_name_logo['url']; ?>" target="_blank" class="animated animated-short fadeInUp">
              <span class="fa fa-external-link"></span> <?php echo $user_name_logo['company']; ?> </a>
            </li>
            <li class="list-group-item">
              <a href="#" class="animated animated-short fadeInUp">
              <span class="fa fa-key"></span> <?php echo $user_name_logo['type']; ?> </a>
            </li>
            <li class="list-group-item">
              <a href="#" class="animated animated-short fadeInUp">
              <span class="fa fa-group"></span> <?php echo $user_name_logo['group']; ?> </a>
            </li>
            <?php if (!$log_in_out['url_cpw'] == NULL): ?>
              <li class="list-group-item">
                  <a href="<?php echo $log_in_out['url_cpw']; ?>" class="animated animated-short fadeInUp">
                    <span class="fa fa-exchange"></span>Change Password</a>
              </li>
            <?php endif; ?>
            <li class="list-group-item">
                <a href="<?php echo $log_in_out['url']; ?>" class="animated animated-short fadeInUp">
                  <span class="fa fa-power-off"></span><?php echo $log_in_out['label']; ?></a>
            </li>
          </ul>
        </li>
      </ul>

    </header>
    <!-- End: Header -->