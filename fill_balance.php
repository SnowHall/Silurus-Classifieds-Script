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

include("./include_php/init.php");

if($_SESSION['memberID'] == 0) header("location: index.php");

$uniqueId = strtoupper(md5(uniqid()));
mysql_query("update `Profiles` SET `unique_id`='".$uniqueId."' where ID=".$_SESSION['memberID']);
$smarty->assign("uniqueId",$uniqueId);
$smarty->assign("paypal_email",$gConfig['paypal_email']);
$smarty->assign("currency",$gConfig['currency']);


addNavigation('profile.php','My Profile');
addNavigation('','Fill My Balance');
$smarty->assign("site_title",  'Fill My Balance'." :: ".$gConfig['site_title']);
$smarty->assign("HEADERTEXT",  'Fill My Balance');
show_smarty_template('fill_balance');
?>
