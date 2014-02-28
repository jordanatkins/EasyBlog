<!DOCTYPE HTML>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; UTF-8" />
<title>Admin Panel / EasyBlog</title>
<link rel="stylesheet" href="images/styles.css" type="text/css" />
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px;
      }
    </style>
    <link href="../assets/css/bootstrap-responsive.css" rel="stylesheet">

<script type="text/javascript" src="../assets/js/dialog.js"></script>
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
          <a class="brand" href="/adm/admin.php?mode=list">EasyBlog Admin</a>
          <div class="nav-collapse collapse">
        <ul class="nav">
		<li><a href="admin.php?mode=list">Posts</a></li>
		<li><a href="admin.php?mode=add">New post</a></li>
		<li><a href="admin.php?mode=options">Options</a></li>
		<li><a href="admin.php?mode=password">Change password</a></li>
		<li><a href="admin.php?mode=logout" onclick="return confirm_dialog('admin.php?mode=logout', 'Are you sure you want to logout?');">Logout</a></li>
        </ul>
        <form class="navbar-form pull-right">
              <a class="btn btn-primary" href="admin.php?mode=logout" onclick="return confirm_dialog('admin.php?mode=logout', 'Are you sure you want to logout?');"><i class="icon-white icon-user"></i> Logout</a>
            </form>
          </div>
        </div>
      </div>
    </div>
