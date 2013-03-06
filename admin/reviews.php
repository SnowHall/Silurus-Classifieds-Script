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

$smarty->assign("site_title",  "Manage Reviews :: Admin Panel :: ".$gConfig['site_title']);
$smarty->assign("page_header_text",  "Manage Reviews");


if(isset($_GET['del']) && intval($_GET['ID']) > 0)
{
	mysql_query("delete from ProfilesRating where ID=".intval($_GET['ID']));

	header("location: {$gConfig['site_url']}admin/reviews.php");
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

	$ret = '<form method="GET">Search by author ID: <input type="text" name="searchID"> or review text <input type="text" name="searchTEXT"> <input type=submit name=find value="Find"></form><br><br>
	<table cellspacing=0 cellpadding=0 width=100%>';

	$iDivis = 20;
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
	$sQuery = "select m.*,p.NickName from ProfilesRating m left join Profiles p on p.ID=m.userID where m.ID>0 ".(intval($_GET['searchID'])>0?' and m.userID='.intval($_GET['searchID']):'')." ".(trim($_GET['searchTEXT'])!=''?' and (m.Title like "%'.mysql_escape_string($_GET['searchTEXT']).'%" or m.Text like "%'.mysql_escape_string($_GET['searchTEXT']).'%") ':'')." order by m.ID desc";
	$rElems = mysql_query( $sQuery );
	$iNums = mysql_num_rows($rElems);
	$count = (int)($iNums/$iDivis);
	if(($iNums/$iDivis) > (int)($iNums/$iDivis)) $count++;
	$nav =  ($iNums > $iDivis ? commentNavigation($iNums,$iDivis,$iCurr,'','commPage') : '');
	$rElems = mysql_query( $sQuery.$sLimit );

	$ret.='<tr ><td><b>Author UserName</b></td><td><b>Title</b></td><td><b>Text</b></td><td><b>Date</b></td><td></td></tr>';
	while($book = mysql_fetch_assoc($rElems))
	{
		$ret.='<tr ><td style="border:1px solid #cccccc;padding:3px;" valign=top nowrap> <a href="profile.php?ID='.$book['userID'].'" target="blank">'.($book['NickName']!=''?$book['NickName']:'').'</a></td>
		<td style="border:1px solid #cccccc;padding:3px;" valign=top><a href="profile.php?ID='.$book['voteID'].'#reviews" target="blank">'.$book['Title'].'</a></td>
		<td style="border:1px solid #cccccc;padding:3px;" valign=top>'.$book['Text'].'</td>
		<td style="border:1px solid #cccccc;padding:3px;" valign=top nowrap>'.date("d-m-Y H:i",$book['date']).'</td>
		<td style="border:1px solid #cccccc;padding:3px;" valign=top>&nbsp;<a href="javascript:if(confirm(\'Delete?\')) top.window.location=\''.$gConfig['site_url'].'admin/reviews.php?del&ID='.$book['ID'].(isset($_GET['demo'])?'&demo=1':'').'\';">Del</a></td></tr>';
	}
	$ret.='</table><br><br>'.$nav;
	return  $ret;
}
?>

