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

$smarty->assign("site_title",  "Manage Products for Sale :: Admin Panel :: ".$gConfig['site_title']);
$smarty->assign("page_header_text",  "Manage Products for Sale");


if(isset($_GET['del']) && intval($_GET['ID']) > 0)
{
	$q = mysql_query("select v.* from StorePropValues v inner join StoreProp p on p.ID=v.PropID where v.itemID=".intval($_GET['ID'])." and p.Type=3");
	while($arr = mysql_fetch_assoc($q))
	{
		@unlink( '../media/store/'.$arr['Value'] );
		unlink( '../media/store/small_'.$arr['Value'] );
	}
	mysql_query( "delete from StorePropValues where itemID=".intval($_GET['ID']) );
	mysql_query( "delete from Store where ID=".intval($_GET['ID']) );

	header("location: {$gConfig['site_url']}admin/books.php");
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
	global $site, $gConfig;

	$ret = '<a href="' . $gConfig['site_url'] . 'admin/books.php">All by create date</a><br><form method="GET">Search by title: <input type="text" name="searchID"> <input type=submit name=find value="Find"></form><br><br>
	<table width=100%>';

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
	$sQuery = "select b.*,p.NickName,p.ID uID from Store b inner join Profiles p on p.ID=b.userID where b.ID>0 ".(trim($_GET['searchID'])!=''?' and (b.Title like "%'.mysql_escape_string($_GET['searchID']).'%" ) ':'')." and type=0 order by b.ID desc";
	$rElems = mysql_query( $sQuery );
	$iNums = mysql_num_rows($rElems);
	$count = (int)($iNums/$iDivis);
	if(($iNums/$iDivis) > (int)($iNums/$iDivis)) $count++;
	$nav =  ($iNums > $iDivis ? commentNavigation($iNums,$iDivis,$iCurr,'','commPage') : '');
	$rElems = mysql_query( $sQuery.$sLimit );

	$ret.='<tr><td valign=top><b>Title</b></td><td valign=top><b>Date</b></td><td valign=top><b>Author</b></td><td valign=top></td></tr>';
	while($book = mysql_fetch_assoc($rElems))
	{
		$ret.='<tr><td valign=top><a href="product.php?ID='.$book['ID'].'" target="blank">'.$book['Title'].'</a></td>
		<td valign=top nowrap>'.date("d-m-Y H:i",$book['date']).' </td>
		<td valign=top> <a href="profile.php?ID='.$book['uID'].'" target="blank">'.$book['NickName'].'</a></td>
		<td valign=top>&nbsp;&nbsp;&nbsp;<a href="javascript:if(confirm(\'Delete product?\')) top.window.location=\'' . $gConfig['site_url'] . '/admin/books.php?del&ID='.$book['ID'].(isset($_GET['demo'])?'&demo=1':'').'\';">Delete</a></td></tr>';
	}
	$ret.='</table><br><br>'.$nav;
	return  $ret;
}
?>

