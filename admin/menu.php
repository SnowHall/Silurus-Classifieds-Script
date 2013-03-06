<?php
/**
 * Silurus Classifieds Builder
 * 
 * 
 * @author		SnowHall - http://snowhall.com
 * @website		http://snowhall.com/silurus
 * @email		support@snowhall.com
 * 
 * @version		2.0
 * @date		March 7, 2013
 * 
 * Silurus is a professionally developed PHP Classifieds script that was built for you.
 * Whether you are running classifieds for autos, motorcycles, bicycles, rv's, guns,
 * horses, or general merchandise, our product is the right package for you.
 * It has template system and no limit to usage with free for any changes.
 *
 * Copyright (c) 2009-2013
 */

include("../include_php/admin_init.php");
include("../include_php/TemplVotingView.php");

$smarty->assign("site_title",  "Edit main menu elements :: Admin Panel :: ".$gConfig['site_title']);
$smarty->assign("page_header_text",  "Edit main menu elements");

$action = $_GET['action'];
 
if($action=='del')
{
	mysql_query("delete from Menu where ID=".intval($_REQUEST['ID']));
	mysql_query("update Menu set Parent=0 where Parent=".intval($_REQUEST['ID']));
	header("location: {$gConfig['site_url']}admin/menu.php");
	die();	
}

$smarty->assign("page_content",  getArticlesAdminContent());
$smarty->display('index.tpl');

function getArticlesAdminContent()
{
	global $site;
	global $sActionText;
	global $action,$itemviewid;

	$ret = '';



		switch ($action )
		{
			case 'edit':
				$ret .= getEdit();
			break;
			
			case 'add':
				$ret .= getAdd();
			break;
						
			default:
				$ret .= getList();
			break;
		}

	return $ret;
}

function getList(  )
{
	global $gConfig;
	
	$ret = '<a href="' . $gConfig['site_url'] . 'admin/menu.php?action=add">Add New Item</a><br><br><table width=100%>';
	$q = mysql_query("select * from Menu where Parent=0 order by Prior");
	while($a = mysql_fetch_assoc($q))
	{
		$ret.='<tr><td><a href="admin/menu.php?action=edit&ID='.$a['ID'].'">'.$a['Title'].'</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="admin/menu.php?action=del&ID='.$a['ID'].'" style="color:red">Delete</a></td></tr>';
		$qq = mysql_query("select * from Menu where Parent=".$a['ID']." order by Prior");
		if(mysql_numrows($qq)>0)
		{
			while($aa = mysql_fetch_assoc($qq))
				$ret.='<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="admin/menu.php?action=edit&ID='.$aa['ID'].'">'.$aa['Title'].'</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="admin/menu.php?action=del&ID='.$aa['ID'].'" style="color:red">Delete</a></td></tr>';
		}
		
	}
	$ret.='</table>';
	return  $ret;
}

function getEdit()
{
	global $gConfig;
		
	$err = '';
	if($_SERVER['REQUEST_METHOD']=='POST')
	{
		if(trim($_REQUEST['Title'])=='') $err .= 'Enter Title<br>';
		if(trim($_REQUEST['Url'])=='') $err .= 'Enter Path';
		if($err=='')
		{
			mysql_query("update Menu set Title='".mysql_escape_string($_REQUEST['Title'])."',Url='".mysql_escape_string($_REQUEST['Url'])."',Login='".intval($_REQUEST['Login'])."',Parent='".intval($_REQUEST['Parent'])."',Photo='".mysql_escape_string($_REQUEST['Photo'])."',Prior='".intval($_REQUEST['Prior'])."' where ID=".intval($_REQUEST['ID']));
			if(intval($_REQUEST['Parent'])>0) mysql_query("update Menu set Parent=0 where Parent=".intval($_REQUEST['ID']));
			header("location: {$gConfig['site_url']}admin/menu.php");
			die();
		}
	}
	else 
		$_REQUEST = mysql_fetch_assoc(mysql_query("select * from Menu where ID=".intval($_REQUEST['ID'])));
	
	$ret = '<font color=red><b>'.$err.'</b></font><br>
	<form method=POST>
	<b>Title</b><br>
	<input type="text" name="Title" id="Name" class="catCaption" value="' . htmlspecialchars( $_REQUEST['Title'] ) . '" /><br><br>
	
	<b>Path (ex. for "http://site.com/script.php?param1=value1" need enter only "script.php?param1=value1")</b><br>
	<input type="text" name="Url" id="Name" class="catCaption" value="' . htmlspecialchars( $_REQUEST['Url'] ) . '" /><br><br>
		
	<b>Priority</b><br>
	<input type="text" name="Prior" id="Name" class="catCaption" value="' . htmlspecialchars( $_REQUEST['Prior'] ) . '" /><br><br>
	
	<b>Visible</b><br>
	<input type="radio" name="Login" value="0" '.($_REQUEST['Login']==0?"checked":"").'> for all<br>
	<input type="radio" name="Login" value="1" '.($_REQUEST['Login']==1?"checked":"").'> for member only<br>
	<input type="radio" name="Login" value="2" '.($_REQUEST['Login']==2?"checked":"").'> for guest only<br>
	<br>
	
	<b>Parent element</b><br>
	<select name="Parent">
	<option value="0">No Parent Element</option>';
	$q = mysql_query("select * from Menu where Parent=0 and ID<>".intval($_REQUEST['ID'])." order by Prior");
	while ($arr = mysql_fetch_assoc($q))
		$ret .= '<option value="'.$arr['ID'].'" '.($_REQUEST['Parent']==$arr['ID']?"selected":"").'>'.$arr['Title'].'</option>';
	$ret .= '</select>
	<br><br>
	
	<script>			
	function change_images_cat(obj)
	{
		var photo_saved_div_obj = document.getElementById("photo_saved_div");
		var photo_saved_img_obj = document.getElementById("photo_saved_img");
		if(obj.value=="")
		{
			photo_saved_div_obj.style.display="none";
		}
		else
		{
			photo_saved_img_obj.src="templates/'.$gConfig['site_templates'].'/img/icons/"+obj.value;
			photo_saved_div_obj.style.display="block";					
		}
	}
	</script>
	<b>Image (only for top elements)</b><br>
	<select name="Photo" onchange="change_images_cat(this);">
	<option value="">No Image</option>'; 
	$dir = "../templates/".$gConfig['site_templates']."/img/icons/";

	if ($dh = opendir($dir)) 
	{
	 	while (($file = readdir($dh)) !== false) 
	 	{
		   if (is_file($dir . $file)) 
		   {	   	
		   		$ret .= '<option value="'.$file.'" '.($_REQUEST['Photo']==$file?"selected":"").'>'.$file.'</option>';		
		   }
	    }
	    closedir($dh);
	}
	$ret .= '</select>
	<div style="'.(trim($_REQUEST['Photo'])==''?'display:none':'').'" id="photo_saved_div"><img src="templates/'.$gConfig['site_templates'].'/img/icons/'.$_REQUEST['Photo'].'" id="photo_saved_img" /></div><Br><br>
	
	<input type=submit value="Save">
	</form>	
	';
	
	return $ret;
}

function getAdd()
{
	global $gConfig;
		
	$err = '';
	if($_SERVER['REQUEST_METHOD']=='POST')
	{
		if(trim($_REQUEST['Title'])=='') $err .= 'Enter Title<br>';
		if(trim($_REQUEST['Url'])=='') $err .= 'Enter Path';
		if($err=='')
		{
			mysql_query("insert into Menu set Title='".mysql_escape_string($_REQUEST['Title'])."',Url='".mysql_escape_string($_REQUEST['Url'])."',Login='".intval($_REQUEST['Login'])."',Parent='".intval($_REQUEST['Parent'])."',Photo='".mysql_escape_string($_REQUEST['Photo'])."',Prior='".intval($_REQUEST['Prior'])."'");
			header("location: {$gConfig['site_url']}admin/menu.php");
			die();
		}
	}
	
	$ret = '<font color=red><b>'.$err.'</b></font><br>
	<form method=POST>
	<b>Title</b><br>
	<input type="text" name="Title" id="Name" class="catCaption" value="' . htmlspecialchars( $_REQUEST['Title'] ) . '" /><br><br>
	
	<b>Path (ex. for "http://site.com/script.php?param1=value1" need enter only "script.php?param1=value1")</b><br>
	<input type="text" name="Url" id="Name" class="catCaption" value="' . htmlspecialchars( $_REQUEST['Url'] ) . '" /><br><br>
		
	<b>Priority</b><br>
	<input type="text" name="Prior" id="Name" class="catCaption" value="' . htmlspecialchars( $_REQUEST['Prior'] ) . '" /><br><br>
	
	<b>Visible</b><br>
	<input type="radio" name="Login" value="0" '.($_REQUEST['Login']==0?"checked":"").'> for all<br>
	<input type="radio" name="Login" value="1" '.($_REQUEST['Login']==1?"checked":"").'> for member only<br>
	<input type="radio" name="Login" value="2" '.($_REQUEST['Login']==2?"checked":"").'> for guest only<br>
	<br>
	
	<b>Parent element</b><br>
	<select name="Parent">
	<option value="0">No Parent Element</option>';
	$q = mysql_query("select * from Menu where Parent=0 order by Prior");
	while ($arr = mysql_fetch_assoc($q))
		$ret .= '<option value="'.$arr['ID'].'" '.($_REQUEST['Parent']==$arr['ID']?"selected":"").'>'.$arr['Title'].'</option>';
	$ret .= '</select>
	<br><br>
	
	<script>			
	function change_images_cat(obj)
	{
		var photo_saved_div_obj = document.getElementById("photo_saved_div");
		var photo_saved_img_obj = document.getElementById("photo_saved_img");
		if(obj.value=="")
		{
			photo_saved_div_obj.style.display="none";
		}
		else if(obj.value=="-1")
		{
			photo_saved_div_obj.style.display="none";
		}
		else
		{
			photo_saved_img_obj.src="templates/'.$gConfig['site_templates'].'/img/icons/"+obj.value;
			photo_saved_div_obj.style.display="block";					
		}
	}
	</script>
	<b>Image (only for top elements)</b><br>
	<select name="Photo" onchange="change_images_cat(this);">
	<option value="">No Image</option>'; 
	$dir = "../templates/".$gConfig['site_templates']."/img/icons/";

	if ($dh = opendir($dir)) 
	{
	 	while (($file = readdir($dh)) !== false) 
	 	{
		   if (is_file($dir . $file)) 
		   {	   	
		   		$ret .= '<option value="'.$file.'" '.($_REQUEST['Photo']==$file?"selected":"").'>'.$file.'</option>';		
		   }
	    }
	    closedir($dh);
	}
	$ret .= '</select>
	<div style="'.(trim($_REQUEST['Photo'])==''?'display:none':'').'" id="photo_saved_div"><img src="templates/'.$gConfig['site_templates'].'/img/icons/'.$_REQUEST['Photo'].'" id="photo_saved_img" /></div><Br><br>
	
	<input type=submit value="Save">
	</form>	
	';
	
	return $ret;
}



?>

