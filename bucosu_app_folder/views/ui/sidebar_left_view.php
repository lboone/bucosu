    <!--
          "#sidebar_left" Helper Classes: 
        
         * Positioning Classes: 
          '.affix' - Sets Sidebar Left to the fixed position 

         * Available Skin Classes:
           .sidebar-dark (default no class needed)
           .sidebar-light  
           .sidebar-light.light   
        
         Example: <aside id="sidebar_left" class="affix sidebar-light">
         Results: Fixed Left Sidebar with light/white background
        -->

    <!-- Start: Sidebar Left -->
    <aside id="sidebar_left" class="nano nano-primary affix hidden-print">

      <!-- Start: Sidebar Left Content -->
      <div class="sidebar-left-content nano-content">

        <!-- Start: Sidebar Header -->
        <header class="sidebar-header">
          <div class="user-menu">
            <div class="row text-center mbn">
              <div class="col-xs-4">
                <a href="dashboard.html" class="text-primary" data-toggle="tooltip" data-placement="top" title="Dashboard">
                  <span class="glyphicon glyphicon-home"></span>
                </a>
              </div>
              <div class="col-xs-4">
                <a href="pages_messages.html" class="text-info" data-toggle="tooltip" data-placement="top" title="Messages">
                  <span class="glyphicon glyphicon-inbox"></span>
                </a>
              </div>
              <div class="col-xs-4">
                <a href="pages_profile.html" class="text-alert" data-toggle="tooltip" data-placement="top" title="Tasks">
                  <span class="glyphicon glyphicon-bell"></span>
                </a>
              </div>
              <div class="col-xs-4">
                <a href="pages_timeline.html" class="text-system" data-toggle="tooltip" data-placement="top" title="Activity">
                  <span class="fa fa-desktop"></span>
                </a>
              </div>
              <div class="col-xs-4">
                <a href="pages_profile.html" class="text-danger" data-toggle="tooltip" data-placement="top" title="Settings">
                  <span class="fa fa-gears"></span>
                </a>
              </div>
              <div class="col-xs-4">
                <a href="pages_gallery.html" class="text-warning" data-toggle="tooltip" data-placement="top" title="Cron Jobs">
                  <span class="fa fa-flask"></span>
                </a>
              </div>
            </div>
          </div>
        </header>
        <!-- End: Sidebar Header -->

        <!-- Start: Sidebar Left Menu -->
        
        <?php

          echo '<ul class="nav sidebar-menu">';
          display_children(0, 1, $menu_user_group['type'], $menu_user_group['level']);
          echo '</ul>';
        ?>
        
        <!-- End: Sidebar Menu -->


        <!-- Start: Sidebar Collapse Button -->
        <div class="sidebar-toggle-mini">
          <a href="#">
            <span class="fa fa-sign-out"></span>
          </a>
        </div>
        <!-- End: Sidebar Collapse Button -->

      </div>
      <!-- End: Sidebar Left Content -->

    </aside>
    <!-- End: Sidebar Left -->

<?php 
  function display_children($parent, $level, $group_type, $group_level) {
      $MY_CI = get_instance();

      $MY_CI->load->database();

      $result = $MY_CI->db->query("SELECT a.id, a.label, a.header_label, a.link, a.icon, Deriv1.Count FROM `menu` a LEFT OUTER JOIN (SELECT parent, COUNT(*) AS Count FROM `menu` GROUP BY parent) Deriv1 ON a.id = Deriv1.parent WHERE a.parent=" . $parent . " AND " . $group_type . "<= a.group_type AND " . $group_level . " <= a.group_level order by a.sort");




      foreach ($result->result_array() as $row) {
          


          if (!trim($row['header_label']) == "") {
            echo  '<li class="sidebar-label pt20">' . $row['header_label'] . '</li>';
          }
          echo  '<li>';
          if ($parent == 0 && $row['Count'] > 0 ) {
            echo  '<a class="accordion-toggle" href="#">';
          } else {
            echo  '<a href="'. site_url($row['link']) . '">';
          }

          $icon = $row['icon'];

          if (!trim($icon) == "" ) {
              echo  '<span class="fa ' . $row['icon'] . '"></span>';    
          }

          if ($parent == 0) {
            echo  '<span class="sidebar-title">' . $row['label'] . '</span>';
          } else {
            echo $row['label'];
          }
          

          if ($row['Count'] > 0) {

              echo  '<span class="caret"></span>';
              echo  '</a>';

                echo '<ul class="nav sub-nav">';          
                display_children($row['id'], $level + 1, $group_type, $group_level);
                echo '</ul>';
              echo  '</li>';
          } else {
              echo  '</a>';
              echo  '</li>';
          } 
      }
     
  }
?>

