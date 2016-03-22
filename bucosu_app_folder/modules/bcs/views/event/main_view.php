<!-- get header file -->
<?php if(isset($_header_view)){ echo $_header_view; } ?>


<!--
  <body> Helper Classes: 

  '.sb-l-o' - Sets Left Sidebar to "open"
  '.sb-l-m' - Sets Left Sidebar to "minified"
  '.sb-l-c' - Sets Left Sidebar to "closed"

  '.sb-r-o' - Sets Right Sidebar to "open"
  '.sb-r-c' - Sets Right Sidebar to "closed"

 Example: <body class="example-page sb-l-o sb-r-c">
 Results: Sidebar left Open, Sidebar right Closed
-->

<body class="<?php echo $body_class; ?>">

  <!-- Start: Main -->
  <div id="main">

    <!-- check for $navbar_header variable -->
    <?php if(isset($navbar_header_view)){ echo $navbar_header_view; } ?>

    <!-- check for $sidebar_left variable -->
    <?php if(isset($sidebar_left_view)){ echo $sidebar_left_view; } ?>

    <!-- Start: Content-Wrapper -->
    <section id="content_wrapper">

    <!-- check for $topbar_dropdown variable -->
    <?php if(isset($topbar_dropdown_view)){ echo $topbar_dropdown_view; } ?>


    <!-- check for $topbar variable -->
    <?php if(isset($topbar_view)){ echo $topbar_view; } ?>


      <!-- Begin: Content -->
      <section id="content" class="table-layout animated fadeIn">

        <!-- begin: .tray-left -->
        <?php if(isset($tray_left)){ echo $tray_left; } ?>
        <!-- end: .tray-left -->

        <!-- begin: .tray-center -->
        <div class="tray tray-center">
            <?php if(isset($subview)){ echo $subview; } else { echo '<h1>Sorry there was no content found...</h1>';} ?>
        </div>
        <!-- end: .tray-center -->
      </section>
      <!-- End: Content -->

    </section>
    <!-- End: Content-Wrapper -->


    <!-- right panel goes here-->
    <?php if(isset($sidebar_right_view)) { echo $sidebar_right_view; } ?>

  </div>
  <!-- End: Main -->

<!-- get footer file -->
<?php if(isset($_footer_view)){ echo $_footer_view; } ?>