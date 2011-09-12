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

$smarty->assign("site_title",  "Manage Profile Photos :: Admin Panel :: ".$gConfig['site_title']);
$smarty->assign("page_header_text",  "Manage Profile Photos");

if(isset($_GET['del']) && intval($_GET['ID']) > 0)
{
	$ID = intval($_GET['ID']);
	$rMedia = mysql_query( "SELECT * FROM Profiles WHERE `ID` = {$ID}" );
	$aMedia = mysql_fetch_assoc( $rMedia );
	$medDir = "../media/images/profile/" . $ID . "/";
	@unlink( $medDir . 'icon_' . $aMedia['PrimPhoto'] );
	@unlink( $medDir . 'photo_' . $aMedia['PrimPhoto'] );
	@unlink( $medDir . 'thumb_' . $aMedia['PrimPhoto'] );
	@unlink( $medDir  );
				
	mysql_query("update  Profiles set PrimPhoto='' where ID=".intval($_GET['ID']));
	header("location: /admin/pphoto.php");
}
$action = $_GET['action'];
 
$smarty->assign("page_content",  getArticlesAdminContent());
$smarty->display('index.tpl');


function getArticlesAdminContent()
{
	global $site;
	global $sActionText;
	global $action,$itemviewid;

	$ret = getList();

	return $ret;
}

function getList( $iArticleID = '' )
{
	global $site;
	
	$ret = '<a href="/admin/pphoto.php">All</a> <br><form method="GET">Search by user ID or NickName: <input type="text" name="searchID"> <input type=submit name=find value="Find"></form><br><br>
	<table width=100%>';	
		
	$iDivis = 30;
	$iCurr  = 1;	
	if (!isset($_REQUEST['commPage']))
	{
		$sLimit =  ' LIMIT 0,'.$iDivis;
	}
	else
	{
		if($_REQUEST['commPage']<=0) $_REQUEST['commPage'] = 1;
		$iCurr = (int)$_REQUEST['commPage'];
		$sLimit =  ' LIMIT '.($iCurr - 1)*$iDivis.','.$iDivis;
	}			
	$sQuery = "select * from Profiles where ID>0 ".(trim($_GET['searchID'])!=''?' and (ID='.intval($_GET['searchID']).' or NickName like "%'.mysql_escape_string(trim($_GET['searchID'])).'%")':'')." and PrimPhoto<>'' order by LastModified desc";	
	$rElems = mysql_query( $sQuery );		
	$iNums = mysql_num_rows($rElems);	
	$count = (int)($iNums/$iDivis);
	if(($iNums/$iDivis) > (int)($iNums/$iDivis)) $count++;
	$nav =  ($iNums > $iDivis ? commentNavigation($iNums,$iDivis,$iCurr,'','commPage') : '');	
	$rElems = mysql_query( $sQuery.$sLimit );	
		   
	$ret.='<tr><td valign=top width=100px></td><td valign=top><b>User</b></td><td valign=top><b>Download Date</b></td><td valign=top></td></tr>';
	
	while($book = mysql_fetch_assoc($rElems))
	{		
		$prof_photo = 'media/images/profile/'.$book['ID'].'/thumb_' . $book['PrimPhoto'];
		$groupImageUrl = '/'.$prof_photo;		
			
		$ret.='<tr><td valign=top width=100px><a href="'.$groupImageUrl.'" target="blank"><img src="'.$groupImageUrl.'" style="width:80px"></a></td>
		<td valign=top><a target="_blank" href="/profile.php?ID='.$book['ID'].'" target="blank">'.$book['NickName'].'</a></td>
		<td valign=top>'.date("d-m-Y H:i",$book['LastModified']).'</td>
		<td valign=top>&nbsp;&nbsp;&nbsp;<a href="javascript:if(confirm(\'Delete photo?\')) window.location=\'/admin/pphoto.php?del&ID='.$book['ID'].'\';">Delete photo</a></td></tr>';		
	}
	$ret.='</table><br><br>'.$nav;
	return  $ret;
}
?>

