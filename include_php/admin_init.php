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
mysql_query("set names utf8");
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
    include $demo;
    die();
  }
}
unset($_SESSION['demo']);

$admin_dop_path = '.';
if(!$_SESSION['adminID'] && !$no_redirect) header("location: {$gConfig['site_url']}admin/login.php".(isset($_GET['demo'])?'?demo=1':''));

/*if (isset($_POST['template']))
{
    $sql = "UPDATE `Settings` SET `Value` = '".  mysql_real_escape_string($_POST['template'])."'
        WHERE `Name` = 'site_templates'";
    mysql_query($sql);
    $gConfig['site_templates'] = $_POST['template'];
}

//Find all templates from templates folder
/*$templates_dir = '../templates/';
$siteTemplates = array();
$templateFiles = scandir($templates_dir);
foreach ($templateFiles as $templateFile)
{
    if (!in_array($templateFile, array('.','..','admin_default')))
    {
        $siteTemplates[] = $templateFile;
    }
}*/

$smartyparam = $_SERVER['HTTP_HOST'];
$smarty = new Smarty;
$smarty->compile_check = false;
$smarty->debugging = false;
$smarty->force_compile = true;
$smarty->template_dir = '../templates/admin_default/';
$smarty->compile_dir = '../templates_c/';
$smarty->assign("template_path",  'templates/admin_default/');
$smarty->assign("site_templates", $siteTemplates);
$smarty->assign("site_name",  $gConfig['site_title']);
$smarty->assign("site_url",  $gConfig['site_url']);
$smarty->assign("current_template", $gConfig['site_templates']);

include("./update.php");
?>