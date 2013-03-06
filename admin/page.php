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

$ID=intval($_GET['ID']);
$info = mysql_fetch_assoc(mysql_query("select * from Snowhall where ID=".$ID));
$smarty->assign("site_title",  $info['Title']." :: Admin Panel :: ".$gConfig['site_title']);
$smarty->assign("page_header_text", $info['Title']);

$smarty->assign("page_content",  $info['Text']);
$smarty->display('index.tpl');


?>

