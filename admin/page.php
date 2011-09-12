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

$ID=intval($_GET['ID']);
$info = mysql_fetch_assoc(mysql_query("select * from Snowhall where ID=".$ID));
$smarty->assign("site_title",  $info['Title']." :: Admin Panel :: ".$gConfig['site_title']);
$smarty->assign("page_header_text", $info['Title']);

$smarty->assign("page_content",  $info['Text']);
$smarty->display('index.tpl');


?>

