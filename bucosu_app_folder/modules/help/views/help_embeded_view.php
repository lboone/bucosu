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

  <!-- Begin: Content -->
      <section id="content" class="table-layout animated fadeIn">

        <!-- begin: .tray-left -->
        <!-- end: .tray-left -->

        <!-- begin: .tray-center -->
        
            <?php if(isset($subview)){ echo $subview; } else { echo '<h1>Sorry there was no content found...</h1>';} ?>
        
        <!-- end: .tray-center -->
      </section>
      <!-- End: Content -->


  </div>
  <!-- End: Main -->

<!-- get footer file -->
<?php if(isset($_footer_view)){ echo $_footer_view; } ?>