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
include("../include_php/TemplVotingView.php");

$smarty->assign("site_title",  "Site Site Settings :: Admin Panel :: ".$gConfig['site_title']);
$smarty->assign("page_header_text",  "Site Site Settings");
if (@$_POST['send']) {
	$res = sendMail($_POST['email'], '', 'Silurus test email', 'If you can read this mesage, then your mail settings configured right.');
	if ($res['success']) {
		$ret = 'We sent mail to your email, please check. If you got email, then your settings right, else please check your mail settings.';
	} else {
		$ret = $res['error'];
	}
	$ret .= '<br><br><a href="admin/site.php">Back to settings</a>';
} else {
	$ret = '<script type="text/javascript">location.href = "admin/site.php"</script>';
}

$smarty->assign("page_content", $ret);
$smarty->display('index.tpl');

?>