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
 
$smarty->assign("site_url", $gConfig['site_url']);
$smarty->assign("site_title", $gConfig['site_title']);
$smarty->assign("site_keywords", $gConfig['site_keywords']);
$smarty->assign("site_description", $gConfig['site_description']);
$smarty->assign("site_slogan1", $gConfig['logo_title']);
$smarty->assign("site_slogan2", $gConfig['logo_slogan']);
addNavigation('index.php','Home');
	
$topmenu = array();
$q = mysql_query("select * from Menu where Parent=0 and ((Login=0)or(Login=1&&".intval($_SESSION['memberID']).">0)or(Login=2&&".intval($_SESSION['memberID'])."=0)) order by Prior");
while($a = mysql_fetch_assoc($q))
{
	$temp = array();
	$qq = mysql_query("select * from Menu where Parent=".$a['ID']." and ((Login=0)or(Login=1&&".intval($_SESSION['memberID']).">0)or(Login=2&&".intval($_SESSION['memberID'])."=0)) order by Prior");
	if(mysql_numrows($qq)>0)
	{
		while($aa = mysql_fetch_assoc($qq))
			$temp[] = $aa;
	}
	$a['list'] = $temp;
	$topmenu[] = $a;	
}
$smarty->assign("topmenu",  $topmenu);

if(!is_array($_SESSION['location'])) 
	$_SESSION['location'] = array('title'=>'EVERYWHERE','condition'=>'');

if(isset($_REQUEST['change_loc_go']))
{
	if($_REQUEST['loc_type'] == 1 && trim($_REQUEST['loc_name']) != '')
	{					
		$loc_city = mysql_fetch_assoc(mysql_query("select * from City where Title='".mysql_escape_string(trim($_REQUEST['loc_name']))."'"));		
		if(intval($loc_city['ID']) > 0)
		{
			$_SESSION['location']['condition'] = "(select ID from Profiles where city=".intval($loc_city['ID']).")";
			$_SESSION['location']['title'] = (strlen(trim($loc_city['Title']))>30?substr(trim($loc_city['Title']),0,30).'...':trim($loc_city['Title']));					
		}	
		else 
			$_SESSION['location'] = array('title'=>'EVERYWHERE','condition'=>'');			
	}
	elseif($_REQUEST['loc_type'] == 2 && trim($_REQUEST['loc_name']) != '')
	{
		$_SESSION['location']['condition'] = "(select ID from Profiles where zip='".mysql_escape_string(trim($_REQUEST['loc_name']))."')";
		$_SESSION['location']['title'] = 'ZIP - '.trim($_REQUEST['loc_name']);	
	}
	else 
		$_SESSION['location'] = array('title'=>'EVERYWHERE','condition'=>'');
}

$ctgr = '';
$q = mysql_query("select * from StoreCategories where Type=0 order by Title");
while($arr = mysql_fetch_array($q))
	$ctgr .= '<option value="'.$arr['ID'].'">'.$arr['Title'].'</option>';
$smarty->assign("bookcategory",  $ctgr);

$footer_block = mysql_fetch_assoc(mysql_query("select * from SimpleMain where ID=7"));
$smarty->assign("FOOTER_BLOCK",  $footer_block['Text']);



?>