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
 
$page = $_SERVER['PHP_SELF'];
include("./include_php/init.php");

$id = intval($_GET['id']);
$ip = mysql_escape_string($_GET['ip']);
$page = mysql_escape_string(urldecode($_GET['page']));
$week = date("YW");
$page = str_replace('/index.php','',$page);
mysql_query("insert into BannersShows set ID=".$id.",Date=NOW(),IP='".$ip."',Week=$week,Page='$page'");
?>





