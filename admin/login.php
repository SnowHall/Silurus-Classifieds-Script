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
 
$no_redirect = true;
include("../include_php/admin_init.php");

if(isset($_REQUEST['admin_logout']))
{
	$_SESSION['adminID'] = 0; 
    header("location: /");
    die();
}

$smarty->assign("site_title",  "Log In :: ".$gConfig['site_title']);
$smarty->assign("page_header_text",  "Log In");

$warning_text = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $info = mysql_fetch_assoc(mysql_query("select * from Admins where Name='".mysql_escape_string($_REQUEST['ID'])."' limit 1"));    
    if ( $info && $info['Name']==$_REQUEST['ID'] && $info['Password']==md5($_REQUEST['Password']) )
    {          	  	
    	$_SESSION['adminID'] =	 1;
    	$_SESSION['adminname']	= $_REQUEST['ID'];
		header("location: /admin");
		die();	
	}
	else 
		$smarty->assign("warning_text",  'Invalid Username or Password');
}

$smarty->display('login.tpl');
?>