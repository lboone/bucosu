<!DOCTYPE html>
<html>

<head>
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <title><?php echo $title; ?></title>
  <meta name="keywords" content="<?php //echo $keywords; ?>">
  <meta name="description" content="<?php //echo $description; ?>">
  <meta name="author" content="LAMB Apps">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Font CSS -->
  <?php 
    if(isset($stylesheets['font']))
    {
      foreach ($stylesheets['font'] as $ss)
      { 
        echo $ss; 
      }
    }
  ?>

  <!-- begin: top -->
  <?php 
    if(isset($stylesheets['top']))
    {
      foreach ($stylesheets['top'] as $ss)
      { 
        echo $ss; 
      }
    }
  ?>
  <!-- end: top -->

  <!-- Theme CSS -->
  <?php 
    if(isset($stylesheets['theme']))
    {
      foreach ($stylesheets['theme'] as $ss)
      { 
        echo $ss; 
      }
    }
  ?>

  <!-- begin: end -->
  <?php 
    if(isset($stylesheets['end']))
    {
      foreach ($stylesheets['end'] as $ss)
      { 
        echo $ss; 
      }
    }
  ?>
  <!-- begin: end -->

  <!-- begin: header js -->
  <?php 
    if(isset($javascripts['header']))
    { 
      foreach ($javascripts['header'] as $js)
      { 
        echo $js; 
      }
    }
  ?>
  <!-- end: header js -->

  <!-- Favicon -->
  <link rel="shortcut icon" href="<?php echo site_url('assets/img/favicon.ico'); ?>">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
  <![endif]-->
</head>