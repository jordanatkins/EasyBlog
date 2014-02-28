<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Home / <?php echo $siteTitle ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="My personal blog">
    <meta name="author" content="<?php echo $userName ?>">

    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <script type="text/javascript" src="../assets/js/dialog.js"></script>

    <style>
      body {
        padding-top: 60px;
      }
    </style>
    <link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
    <link rel="shortcut icon" href="assets/ico/favicon.png">

    <!--[if lt IE 9]>
      <script src="assets/js/html5shiv.js"></script>
    <![endif]-->
  
  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="#"><?php echo $siteTitle ?></a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="active"><a href="index.php">Home</a></li>
              <li><a href="../about.php">About</a></li>
              <li><a href="../contact.php">Contact</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>