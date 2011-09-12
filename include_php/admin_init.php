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
 
include("../include_php/check_install.php");
function stripslashes_for_array(&$arr) 
{ 
   foreach($arr as $k=>$v) 
   { 
      if(is_string($v))
         	$arr[$k] = stripslashes($v);  
      else
      		$arr[$k] = $v;  
   } 
} 

stripslashes_for_array($_POST); 
stripslashes_for_array($_GET); 
stripslashes_for_array($_REQUEST);

include("../dbconfig.inc");
include("../include_php/functions.php");
require '../libs/Smarty.class.php';
session_start();
mysql_connect($gConfig['base_host'],$gConfig['base_user'],$gConfig['base_pass']);
$MySQL = mysql_select_db($gConfig['base_name']);
$qset = mysql_query("select * from Settings");
while($aset = mysql_fetch_assoc($qset))
	$gConfig[$aset['Name']] = $aset['Value'];
	
$admin_dop_path = '.';
if(!$_SESSION['adminID'] && !$no_redirect) header("location: /admin/login.php");

$smartyparam = $_SERVER['HTTP_HOST'];
$smarty = new Smarty;
$smarty->compile_check = false;
$smarty->debugging = false;
$smarty->force_compile = true;
$smarty->template_dir = '../templates/admin_default/';
$smarty->compile_dir = '../templates_c/';
$smarty->assign("template_path",  $smarty->template_dir);
$smarty->assign("site_name",  $gConfig['site_title']);
$smarty->assign("site_url",  $gConfig['site_url']);

include("./update.php");
?>