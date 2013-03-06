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

$smarty->assign("site_title",  "Site Template Settings :: Admin Panel :: ".$gConfig['site_title']);
$smarty->assign("page_header_text",  "Site Template Settings");

if(isset($_POST['go']))
{
	mysql_query("update Settings set Value='".mysql_escape_string($_POST['template'])."' where Name='site_templates'");
	mysql_query("update Settings set Value='".mysql_escape_string($_POST['logo_title'])."' where Name='logo_title'");
	mysql_query("update Settings set Value='".mysql_escape_string($_POST['logo_slogan'])."' where Name='logo_slogan'");

  if( $_FILES['logo'] and !empty( $_FILES['logo'] ) )
	{
		if( $_FILES['logo']['error'] == 0 )
		{
			$aFileInfo = getimagesize( $_FILES['logo']['tmp_name'] );
			if( $aFileInfo )
			{
				$ext = false;
				switch( $aFileInfo['mime'] )
				{
					case 'image/png':  $ext = 'png'; break;
				}
				if( $ext )
				{
					$dir = '../templates/'.$gConfig['site_templates'].'/img/'; //"../media/settings/";
					move_uploaded_file( $_FILES['logo']['tmp_name'], $dir.'logo.png') ;
				}
			}
		}
	}
	if( $_FILES['p_logo'] and !empty( $_FILES['p_logo'] ) )
	{
		if( $_FILES['p_logo']['error'] == 0 )
		{
			$aFileInfo = getimagesize( $_FILES['p_logo']['tmp_name'] );
			if( $aFileInfo )
			{
				$ext = false;
				switch( $aFileInfo['mime'] )
				{
					case 'image/png':  $ext = 'png'; break;
				}
				if( $ext )
				{
					$dir = '../templates/'.$gConfig['site_templates'].'/img/'; //"../media/settings/";
					move_uploaded_file( $_FILES['p_logo']['tmp_name'], $dir.'p_logo.png') ;
				}
			}
		}
	}
	if( $_FILES['favicon'] and !empty( $_FILES['favicon'] ) )
	{
		if( $_FILES['favicon']['error'] == 0 )
		{
			$dir = "../media/settings/";
			move_uploaded_file( $_FILES['favicon']['tmp_name'], $dir.'favicon.ico') ;
		}
	}
	header("location: {$gConfig['site_url']}admin/template.php");
}

$smarty->assign("page_content",  getEdit());
$smarty->display('index.tpl');

function getEdit()
{
	global $gConfig;

	$ret = '<form method="POST" enctype="multipart/form-data">
	<b>Current Template</b><br>
	<select name="template">';
	$dir = "../templates/";
	if ($dh = opendir($dir))
	{
	 	while (($file = readdir($dh)) !== false)
	 	{
		   if (is_dir($dir . $file) && $file!='.' && $file!='..' && substr($file,0,6)!='admin_')
		   {
		   		$ret .= '<option value="'.$file.'" '.($gConfig['site_templates']==$file?"selected":"").'>'.$file.'</option>';
		   }
	    }
	    closedir($dh);
	}
	$ret .= '</select><br><br>

	<b>Logo Main Page (only png)</b><br>
	<img src="templates/'.$gConfig['site_templates'].'/img/logo.png"> <bR><input type="file" name="logo"><br><br>

	<b>Logo Inner Page (only png)</b><br>
	<img src="templates/'.$gConfig['site_templates'].'/img/p_logo.png"> <bR><input type="file" name="p_logo"><br><br>

	<b>Favicon (only ico)</b><br>
	<img src="media/settings/favicon.ico"> <bR><input type="file" name="favicon"><br><br>

	<b>Logo Title</b><br>
	<input type=text name="logo_title" value="'.htmlspecialchars($gConfig['logo_title']).'"><br><br>

	<b>Logo Slogan</b><br>
	<input type=text name="logo_slogan" value="'.htmlspecialchars($gConfig['logo_slogan']).'"><br><br>

	<input type="submit" name="go" value="Save"></form>';

	return $ret;
}


?>

