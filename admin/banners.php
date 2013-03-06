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

$smarty->assign("site_title",  "Add Banner :: Admin Panel :: ".$gConfig['site_title']);
$smarty->assign("page_header_text",  "Add Banner");


if(isset($_REQUEST['add']) && intval($_REQUEST['id'])>0)
{

	if($_SERVER['REQUEST_METHOD']=="POST" && trim($_REQUEST['title'])!='')
	{
		mysql_query("insert into Banners set ID=".intval($_REQUEST['id']).",Title='".mysql_escape_string($_REQUEST['title'])."',Url='".mysql_escape_string($_REQUEST['url'])."',Text='".mysql_escape_string($_REQUEST['text'])."'");
		
		print '<script>opener.window.location.reload();window.close();</script>'; die();
	}

	global $gConfig;
	
	$ret = '
	<form method="POST">
	<b>Title</b><br><input type=text name=title><br><br>
	<b>URL</b><br><input type=text name=url><br><br>
	<b>Text</b><br>';
	include("../fckeditor/fckeditor.php") ;
	$sBasePath = $gConfig['site_url'] . '/fckeditor/' ;						
	$oFCKeditor = new FCKeditor('text') ;
	$oFCKeditor->BasePath	= $sBasePath ;
	$oFCKeditor->Height	= '300px' ;
	$oFCKeditor->Value		= '';			
	$ret .= $oFCKeditor->Create();  
	$ret .= '<input type=submit name=go value="Save"></form>';
	
}

if(isset($_REQUEST['del']) && intval($_REQUEST['id'])>0)
{

	mysql_query("delete from Banners where ID=".intval($_REQUEST['id']));
	print '<script>opener.window.location.reload();window.close();</script>'; die();	
}


$smarty->assign("page_content",  $ret);
$smarty->display('index.tpl');
?>