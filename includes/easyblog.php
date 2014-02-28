<?php

/*
 * easyblog.php
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

date_default_timezone_set("Australia/Sydney");  // Change this to suit your area.

if(!defined('IN_BLOG'))
{
	exit;
}

include(PATH . 'includes/config.php');
include(PATH . 'includes/functions.php');

$link = mb_connect($sqlconfig);
unset($sqlconfig);

if(!$link)
{
	die("Connection to database failed. Please check your credentials.");
}

$config = mb_config();

$post	= (string) mysql_real_escape_string($_GET['post']);
$page	= (int) mysql_real_escape_string(intval($_GET['page']));
$ppp	= (int) intval($config['posts-per-page']);
$from	= (int) intval($ppp * $page);


$sql = ($post == '') ? 'SELECT * FROM `easyblog` WHERE `published` = 1 ORDER BY `date` DESC LIMIT ' . $from . ', ' . $ppp : "SELECT * FROM `easyblog` WHERE `post_slug` = '{$post}' AND `published` = 1";

$result = mysql_query($sql);
$total  = mysql_result(mysql_query("SELECT COUNT(*) FROM `easyblog` WHERE `published` = 1"), 0);

if(mysql_num_rows($result) > 0)
{ 
	while($posts = mysql_fetch_array($result))
	{
		
		$vars = array(
			'$postid$'		=> $posts['post_id'],
			'$posturl$'		=> ($config['use-modrewrite'] == 1) ? $posts['post_slug'] : $config['easyblog-filename'] . '?post=' . $posts['post_slug'],
			'$posttitle$'	=> stripslashes($posts['post_title']),
			'$postdate$'	=> date($config['date-format'], $posts['date']),
			'$postcontent$'	=> stripslashes($posts['post_content']),
		);
		
		$template_vars		= array_keys($vars);
		$template_values	= array_values($vars);
		
		$output = file_get_contents(PATH . 'includes/template.html');
		$output = str_replace($template_vars, $template_values, $output);
		
		$easyblog_posts .= $output;
	}
}

$single = ($post == '') ? false : true;

if($total > ($from + $ppp))
{
	$easyblog_previous = '<a href="' . $config['easyblog-filename'] . '?page=' . ($page + 1)  . '">&laquo; View older posts</a>';
}
if($from > 0)
{
	$easyblog_next = '<a href="' . $config['easyblog-filename'] . '?page=' . ($page - 1)  . '">View newer posts &raquo;</a>';
}
?>