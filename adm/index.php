<?php

/*
 * index.php (admin)
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

 date_default_timezone_set('Australia/Sydney');

if(!defined('IN_ADMIN') || !defined('IN_BLOG'))
{
	header('Location: admin.php');
	exit;
}

switch($mode)
{
	default:
	case 'list':
				
		$result = mysql_query('SELECT * FROM `easyblog`') or die(mysql_error());
		
		while($row = mysql_fetch_assoc($result))
		{
			$published = ($row['published'] == 1) ? 'Published' : 'Unpublished';
			
			$preview_link = ($row['published'] == 1) ? "<a href=\"../{$config['easyblog-filename']}?post={$row['post_slug']}\"><img src=\"images/view.png\" alt=\"View post\" /></a>&nbsp;&nbsp;&nbsp;" : '';
			$post_list .= "<tr>
								<td><a href=\"admin.php?mode=edit&id={$row['post_id']}\">{$row['post_title']}</a></td>
								<td>" . date($config['date-format'], $row['date']) . "</td>
								<td>{$published}</td>
								<td>
								{$preview_link}
								<a href=\"admin.php?mode=delete&id={$row['post_id']}\" onclick=\"return confirm_dialog('admin.php?mode=delete&id={$row['post_id']}', 'Are you sure you wish to delete this post forever? (That's a very long time!) )\"><img src=\"images/delete.png\" alt=\"Remove\" /></a>
								</td>
							</tr>";
		}
		
			
		include('list.php');
	break;
	


	case 'edit':
		
		$id = mysql_real_escape_string($_GET['id']);
		
		$post_sql = "SELECT * FROM `easyblog` WHERE `post_id` = '{$id}'";
		$result = mysql_query($post_sql);
		$post = mysql_fetch_assoc($result);

		if(mysql_num_rows($result) == 1)
		{
			
			if(isset($_POST['easyblog_PostBack']))
			{
				
				$data = $_POST['data'];
				
				if($_POST['data']['post_title'] != $post['post_title'])
				{
					$data['post_slug'] = mb_slug($_POST['data']['post_title']);
				}
				
				$sql = '';
				$i = 1;
				foreach($data as $field => $value)
				{
					if($value == '')
					{
						$failed = true;
						break;
					}
					
					$sql .= "`" . mysql_real_escape_string($field) . "` = '" . mysql_real_escape_string($value) . "'";
					$sql .= ($i == sizeof($data)) ? '' : ', ';
										
					$i++;
				}
				
				if($failed)
				{			
					$response_text = 'Looks like you missed a spot. You must fill out all fields';
				}
				else 
				{	
					$sql = mysql_query("UPDATE `easyblog` SET {$sql} WHERE `post_id` = '{$id}'") or die(mysql_error());
					$result = mysql_query($post_sql);
					$post = mysql_fetch_assoc($result);
					
					$response_text = 'The changes you\'ve made to the post have taken effect';
				}
			}
		
						
			include('edit.php');
		}
	break;
	
	
	
	
	
	
	
	
	
	
	case 'options':
	
		if(isset($_POST['easyblog_PostBack']))
		{
			
				$data = $_POST['data'];

				foreach($data as $name => $value)
				{
					
					if($value == '')
					{
						$failed = true;
						break;
					}
					
					$name = mysql_real_escape_string($name);
					$value = mysql_real_escape_string($value);
					
					$sql = mysql_query("UPDATE `easyblog_config` SET `config_value` = '{$value}' WHERE `config_name` = '{$name}'") or die(mysql_error());
				
				}
				
				if($failed)
				{
					$response_text = 'You must fill out all fields';
				}
				else
				{
					$response_text = 'Settings have been updated.';
				}			
				
			
		}
		
		$sql = mysql_query("SELECT * FROM `easyblog_config` WHERE `config_name` <> 'password'");
		
		while($row = mysql_fetch_array($sql))
		{
			$option_list .= "<p>
								<label for=\"{$row['config_name']}\">" . str_replace('-', ' ', trim(ucfirst($row['config_name']))) . "</label><br />
								<input type=\"text\" name=\"data[{$row['config_name']}]\" value=\"" . stripslashes($row['config_value']) . "\" id=\"{$row['config_name']}\" /><br /><span class=\"form-text\">{$row['config_explain']}</span>
							</p>";
		}
	
		include('options.php');
		
	break;
	
	
	
	
	
	
	
	case 'add':
		
		if(isset($_POST['easyblog_PostBack']))
		{
				$data = $_POST['data'];
				
				$data['post_slug'] = mb_slug($_POST['data']['post_title']);
				$data['date']      = time();
				
				$sql ='';
				$i = 1;
				foreach($data as $field => $value)
				{
					if($value == '')
					{
						$failed = true;
						break;
					}
					$fields .= "`" . mysql_real_escape_string($field) . "`";
					$values .= "'" . mysql_real_escape_string($value) . "'";
					
					$values .= ($i == sizeof($data)) ? '' : ', ';
					$fields .= ($i == sizeof($data)) ? '' : ', ';
					
					$i++;
				}
				
				$post = $_POST['data'];
				
				if($failed)
				{
					$response_text = 'Please fill out all the fields.';
				}
				else
				{
					$result = mysql_query("INSERT INTO `easyblog` ({$fields}) VALUES({$values})");
					$response_text = ($result) ? 'Your post has been published' : 'Your post could not be published';
				}
			
		}
		
		include('edit.php');
		
	break;












	case 'delete':
		
		$id = mysql_real_escape_string($_GET['id']);
		
		$post_sql = "SELECT * FROM `easyblog` WHERE `post_id` = '{$id}'";
		$result = mysql_query($post_sql);
		
		if(mysql_num_rows($result) == 1)
		{
			$result = mysql_query("DELETE FROM `easyblog` WHERE `post_id` = '{$id}'");
			if($result)
			{
				header("Location: admin.php?mode=list");
			}
			else
			{
				die(mysql_error());
			}
		}
		else
		{
			header("Location: admin.php?mode=list");
		}
	break;









	case 'login':
	
		if(isset($_POST['SimplePoll_Login']))
		{
			if(md5($_POST['password']) == PASSWORD)
			{
				session_start();
				$_SESSION['easyblog_Admin'] = true;
				$_SESSION['easyblog_AdminPass'] = PASSWORD;
				define('easyblog_ID', md5(time()));
				
				header('Location: admin.php?mode=list');
			}
			else
			{
				$error_text = 'Incorrect password';
			}
		}
		
		include('login.php');
	
	
	break;
	
	
	
	
	
	
	
	
	
	
	
	
	case 'password':
		
		if(isset($_POST['easyblog_PostBack']))
		{
		
			if($_POST['current_password'] != '' && $_POST['new_password'] != '' && $_POST['confirm_password'] != '')
			{
				$current_password = md5($_POST['current_password']);
				$new_password	  = md5($_POST['new_password']);
				$confirm_password = md5($_POST['confirm_password']);
				
				$real_current_pass = mysql_result(mysql_query("SELECT `config_value` FROM `easyblog_config` WHERE `config_name` = 'password'"), 0);
				
				if($current_password == $real_current_pass)
				{
					
					if($new_password == $confirm_password)
					{
						$result = mysql_query("UPDATE `easyblog_config` SET `config_value` = '{$new_password}' WHERE `config_name` = 'password'");
						if($result)
						{
							$response_text = 'Your password has been changed.';
						}
						else
						{
							$response_text = 'Could not update password';
						}
					}
					else
					{
						$response_text = 'Both passwords must match';
					}
	
				}
				else
				{
					$response_text = 'Current password incorrect';
				}			
			}
			else
			{
				$response_text = 'You must fill out all fields';
			}
		}
		
		
		
		include('password.php');
		
	break;



	case 'logout':
		$_SESSION['easyblog_Admin'] = false;
		unset($_SESSION['easyblog_Admin']);
		unset($_SESSION['easyblog_AdminPass']);
		session_destroy();
		header('Location: admin.php?mode=login');
	break;
		
}
?>