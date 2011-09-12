<?php
/**
 * Silurus Classifieds Builder
 * 
 * 
 * @author		SnowHall - http://snowhall.com
 * @website		http://snowhall.com/silurus
 * @email		support@snowhall.com
 * 
 * @version		1.0
 * @date		May 7, 2009
 * 
 * Silurus is a professionally developed PHP Classifieds script that was built for you.
 * Whether you are running classifieds for autos, motorcycles, bicycles, rv's, guns,
 * horses, or general merchandise, our product is the right package for you.
 * It has template system and no limit to usage with free for any changes.
 *
 * Copyright (c) 2009
 */
 
include("../include_php/admin_init.php");
include("../include_php/TemplVotingView.php");

$smarty->assign("site_title",  "Site Site Settings :: Admin Panel :: ".$gConfig['site_title']);
$smarty->assign("page_header_text",  "Site Site Settings");

if(isset($_POST['go']))
{
	foreach ($_POST as $key=>$val) 
	{	
		mysql_query("update Settings set Value='".mysql_escape_string($val)."' where Name='".mysql_escape_string($key)."'");
	}
	mysql_query("update Settings set Value='".intval($_POST['capcha_item_v'])."' where Name='capcha_item'");
	mysql_query("update Settings set Value='".intval($_POST['mail_type_v'])."' where Name='mail_type'");

	header("location: /admin/site.php");
}

$smarty->assign("page_content",  getEdit());
$smarty->display('index.tpl');

function getEdit()
{
	global $gConfig;
	
	$ret = '<form method="POST" enctype="multipart/form-data">
		
	<b>Site title</b><br>
	<input style="width:300px" type=text name="site_title" value="'.htmlspecialchars($gConfig['site_title']).'"><br><br>
	
	<b>Site keywords</b><br>
	<input style="width:300px" type=text name="site_keywords" value="'.htmlspecialchars($gConfig['site_keywords']).'"><br><br>
	
	<b>Site description</b><br>
	<input style="width:300px" type=text name="site_description" value="'.htmlspecialchars($gConfig['site_description']).'"><br><br>
	
	<b>Use capcha for add products</b>
	<input type=checkbox name="capcha_item_v" value="1" '.(intval($gConfig['capcha_item'])?"checked":"").'><br>
	
	<hr><br>
	
	<b>Use SMTP</b> 
	<input type=checkbox name="mail_type_v" value="1" '.(intval($gConfig['mail_type'])?"checked":"").'><br><br>
	
	<b>Mail</b><br>
	<input style="width:300px" type=text name="mail_name" value="'.htmlspecialchars($gConfig['mail_name']).'"><br><br>
	
	<b>Mail SMTP server</b><br>
	<input style="width:300px" type=text name="mail_server" value="'.htmlspecialchars($gConfig['mail_server']).'"><br><br>
	
	<b>Mail SMTP port</b><br>
	<input style="width:300px" type=text name="mail_port" value="'.htmlspecialchars($gConfig['mail_port']).'"><br><br>
	
	<b>Mail SMTP login</b><br>
	<input style="width:300px" type=text name="mail_user" value="'.htmlspecialchars($gConfig['mail_user']).'"><br><br>
	
	<b>Mail SMTP password</b><br>
	<input style="width:300px" type=text name="mail_pass" value="'.htmlspecialchars($gConfig['mail_pass']).'"><br><br>
	
	
	
	<input type="submit" name="go" value="Save"></form>';

	return $ret;
}


?>

