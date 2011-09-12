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

$smarty->assign("site_title",  "Edit text on main page :: Admin Panel :: ".$gConfig['site_title']);
$smarty->assign("page_header_text",  "Edit text on main page");

if(isset($_POST['go']))
{
	$q = mysql_query("select * from SimpleMain order by ID");
	while($arr = mysql_fetch_assoc($q))
	{
		mysql_query("update SimpleMain set Text='".mysql_escape_string($_POST['block'.$arr['ID']])."' where ID=".$arr['ID']);
	}	
	header("location: /admin/simplemain.php");
}

$smarty->assign("page_content",  getEdit());
$smarty->display('index.tpl');

function getEdit()
{
	global $site;
	
	$ret = '<form method="POST">';
	$q = mysql_query("select * from SimpleMain order by ID");
	while($arr = mysql_fetch_assoc($q))
	{
		$ret .= '<b>'.$arr['Title'].'</b><br><textarea name="block'.$arr['ID'].'" style="width:500px;height:100px;">'.$arr['Text'].'</textarea><br><br>';
	}
	$ret .= '<input type="submit" name="go" value="Save"></form>';

	return $ret;
}


?>

