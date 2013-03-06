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

error_reporting(E_ERROR);

include("./include_php/check_install.php");
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

include("./dbconfig.inc");
include("./include_php/functions.php");
require './libs/Smarty.class.php';


session_start();
mysql_connect($gConfig['base_host'],$gConfig['base_user'],$gConfig['base_pass']);
mysql_select_db($gConfig['base_name']);
mysql_query("SET NAMES utf8");
$qset = mysql_query("select * from Settings");
while($aset = mysql_fetch_assoc($qset))
	$gConfig[$aset['Name']] = $aset['Value'];

$baseDir = dirname(realpath(__FILE__));
$demo = $baseDir."/../demo.php";

if($_POST['template'] || (is_file($demo) && !isset($_SESSION['demo']) && empty($_POST)))
{
  if (!isset($_GET['demo']))
  {
    $_SESSION['demo'] = '1';
    include 'demo.php';
    die();
  }
}
unset($_SESSION['demo']);

if($_COOKIE['rememberID'] != '' && $_SESSION['memberID']==0)
{
	$userr = mysql_fetch_assoc(mysql_query("select * from Profiles where md5(CONCAT(ID,NickName))='".mysql_escape_string($_COOKIE['rememberID'])."'"));
	if($userr[ID] > 0)
	{
		$_SESSION['memberID'] = intval($userr[ID]);
		$_SESSION['memberINFO'] = $userr;
	}
	else
		$_SESSION['memberID'] = 0;
}
if($_SESSION['memberID'] > 0 && (!is_array($_SESSION['memberINFO']) || empty($_SESSION['memberINFO']) || $_SESSION['memberINFO']['ID']!=$_SESSION['memberID']))
	$_SESSION['memberINFO'] = mysql_fetch_assoc(mysql_query("select * from Profiles where ID=".intval($_SESSION['memberID'])));;

$smartyparam = $_SERVER['HTTP_HOST'];
$smarty = new Smarty;
$smarty->compile_check = false;
$smarty->debugging = false;
$smarty->force_compile = true;
$smarty->template_dir = 'templates/'.$gConfig["site_templates"].'/';
$smarty->compile_dir = 'templates_c/';
$smarty->assign("template_path",  $smarty->template_dir);

include("./include_php/design.php");
?>