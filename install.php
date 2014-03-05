<?

/*
 * install.php
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

ob_start();
?>
<!DOCTYPE HTML>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Installation / EasyBlog</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<div class="container">
	<div class="hero-unit">
		<h1>Welcome to EasyBlog</h2>
			<p>EasyBlog is installing... Please refer to the installer below.</a>
	</div>
	<div class="well well-small"> 
<?php

	define('IN_BLOG', true);
	define('PATH', '');
	
	include(PATH . 'includes/config.php');
	include(PATH . 'includes/functions.php');
	
	$link = mb_connect($sqlconfig);
	$install_step = (int) $_GET['step'];	
	$dbl = mysql_select_db($sqlconfig['dbname'], $link);
	$success = '<span class="success text-success">Success!</span><br />';
	$fail    = '<span class="error text-error">Failed!</span><br />';
	$sql_error = '<br /><span class="sqlerror"><strong>Error: </strong><span>%s</span></span><br />';
	
	$tip  = '<span class="tip"><strong>Info: </strong><span>%s</span></span>';
	$code = '<span class="tip"><strong>Info: </strong><span>%s</span></span>';
	
	$continue = '<br /><a class="btn btn-success" href="install.php?step=%d">Continue &raquo;</a>';
	
	if($install_step == 1 || $install_step == 0)
	{
		echo 'Connecting to MySQL Server. <b>Status</b>: ';

		if(!$link)
		{
			echo $fail;
			echo(sprintf($sql_error, mysql_error()));
			echo(sprintf($tip, 'An error occured. Please check your credentials in /includes/config.php'));		
		}
		else 
		{
			echo $success;
			echo 'Opening database. <b>Status</b>: ';
			
			if(!$dbl)
			{
				echo $fail;
				echo(sprintf($sql_error, mysql_error()));
				echo(sprintf($tip, 'An error occured. Please check your credentials in /includes/config.php'));		
			}
			else
			{
				echo $success;
				echo(sprintf($continue, 2));
				
			}
		}

	}
	
	
	if($install_step == 2)
	{
		if(!$link || !$dbl)
		{
			header("Location: install.php");
			exit;
		}
		
		echo 'Creating a new instance of EasyBlog. <b>Status</b>: ';
		
		$sql = "CREATE TABLE `easyblog` (
				  `post_id` int(20) NOT NULL auto_increment,
				  `post_slug` varchar(255) NOT NULL default '',
				  `post_title` varchar(255) NOT NULL default '',
				  `post_content` longtext NOT NULL,
				  `date` int(20) NOT NULL default '0',
				  `published` int(1) NOT NULL default '0',
				  PRIMARY KEY  (`post_id`)
				)";
				
		$result = mysql_query($sql, $link);
		
		$sql = "CREATE TABLE `easyblog_config` (
				  `config_name` varchar(255) NOT NULL default '',
				  `config_value` varchar(255) NOT NULL default '',
				  `config_explain` longtext NOT NULL
				)";
		
		$result2 = mysql_query($sql, $link);
		
		if(!$result || !$result2)
		{	
			echo $fail;
			echo(sprintf($sql_error, mysql_error()));
			echo(sprintf($tip, 'An error occured. Be sure that there\'s nothing in the dabatase already.'));		
		}
		else
		{
			echo $success;
			echo 'Inserting record data...';
			
			$sql = "INSERT INTO `easyblog_config` (`config_name`, `config_value`, `config_explain`) VALUES
					('posts-per-page', '5', 'Posts displayed each page'),
					('date-format', 'F d, Y', 'Date format as per the PHP date function <a href=\"http://www.php.net/date\">here</a>'),
					('password', '5f4dcc3b5aa765d61d8327deb882cf99', 'Admin password'),
					('easyblog-filename', 'index.php', 'Name of the file which easyblog.php is included into'),
					('use-modrewrite', 0, 'Use modrewrite for post URLs - use 1 for yes, 0 for no.')";
			
			$result = mysql_query($sql, $link);	
			
			$sql = "INSERT INTO `easyblog` (`post_slug`, `post_title`, `post_content`, `date`, `published`) VALUES
('welcome-to-easyblog', 'Welcome to EasyBlog!', '<p>Welcome to your new installation of EasyBlog. To remove or edit this post, add new posts and change options login to your admin panel.</p>', " . time() . ", 1)";
	
			$result2 = mysql_query($sql, $link);

			if(!$result || !$result2)
			{
					echo $fail;
					echo(sprintf($sql_error, mysql_error()));
					echo(sprintf($tip, 'An error occurred.'));
			}
			else
			{
				echo $success;
				echo(sprintf($continue, 3));
			}
			
		}
		
	}
	
	if($install_step == 3)
	{
	
		?>
			<p>
			The EasyBlog Installer has finished.<br /><br />
			<a class="btn btn-primary" href="index.php">View your new blog</a>
			<a class="btn btn-success" href="adm/admin.php">Login to the Admin Panel</a>
			</p>
				<p><strong>Please delete install.php for security reasons.</strong></p>
			</code>
				
<?
	}
?>
</div>

<div class="alert alert-error">
			  <h2>Admin panel info</h2>
			    <p>Your admin panel password is currently <code>password</code></p>
			    This password is extremely insecure, and not changing it could result in people taking over your personal blog. Please change it immediately.</p>
			    <a class="btn btn-danger" href="adm/admin.php?mode=password">Change password</a>
			    <a class="btn" href="#" data-dismiss="alert">Close this alert</a>
			</div>
			
</div>
</body>
</html>
<?
ob_end_flush();
?>
		