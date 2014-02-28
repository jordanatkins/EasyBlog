<?php

/*
 * functions.php
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

if(!defined('IN_BLOG'))
{
	exit;
}


function mb_connect($sqlconfig)
{
	$link = @mysql_connect($sqlconfig['host'], $sqlconfig['username'], $sqlconfig['password']);
	@mysql_select_db($sqlconfig['dbname'], $link);
	return $link;
}

function mb_config()
{
	$sql = mysql_query("SELECT * FROM `easyblog_config`");
	$config = array();
	while($row = mysql_fetch_array($sql))
	{
		$config[$row['config_name']] = $row['config_value'];
	}
	return $config;
}

function mb_slug($string)
{
	$string = strtolower(trim($string));
	$string = str_replace(' ', '-', $string);
	$slug = preg_replace('/[^a-z0-9-]/', '', $string);
	
	$i = 0;
	if(mb_slug_exists($slug))
	{
		$i++;
		while(mb_slug_exists($slug . '-' . $i))
		{
			$i++;
		}
	
		$slug = ($i == 0) ? $slug : $slug . '-' . $i;
	}
	
	return $slug;
	
}

function mb_slug_exists($slug)
{
	$slug = mysql_real_escape_string($slug);
	$query = mysql_query("SELECT `post_id` FROM `easyblog` WHERE `post_slug` = '{$slug}' LIMIT 0, 1");
	
	if(mysql_num_rows($query) == 1)
	{
		return true;
	}
	else
	{
		return false;
	}
}

function generate_option_list($list_items = array(), $selected)
{ 
    foreach($list_items as $value => $label)
    {
    
        $html .= ($selected == $value) ? "<option value=\"{$value}\" selected=\"selected\">{$label}</option>" : "<option value=\"{$value}\">{$label}</option>";
        
    }
    return $html;
}
?>