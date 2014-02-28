<?php

/*
 * admin.php
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
session_start();

define('VERSION', '1.00');

define('PATH', '../');
define('IN_BLOG', true);
define('IN_ADMIN', true);

include(PATH . 'includes/config.php');
include(PATH . 'includes/functions.php');

$link = mb_connect($sqlconfig);
unset($sqlconfig);

if(!$link)
{
	die("Connection to EasyBlog servers failed. Please refresh this page or try again later.");
}

$config = mb_config();

define('PASSWORD', $config['password']);

$mode = mysql_real_escape_string($_GET['mode']);

if(isset($_SESSION['easyblog_Admin']))
{
	if($_SESSION['easyblog_AdminPass'] == PASSWORD)
	{
		define('easyblog_ID', md5(time()));
	}
}
if(!defined('easyblog_ID') && $mode != 'login')
{
	header('Location: admin.php?mode=login');
}

$header = ($mode == 'login') ? 'simple-header.php' : 'header.php';
include($header);
include('index.php');	
include('footer.php');
ob_end_flush();
?>