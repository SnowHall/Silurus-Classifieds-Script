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

$smarty->assign("site_title",  "Manage Flags Elements :: Admin Panel :: ".$gConfig['site_title']);
$smarty->assign("page_header_text",  "Manage Flags Elements");


if(isset($_GET['del']) && intval($_GET['ID']) > 0)
{
	mysql_query("delete from Flags  where ID=".intval($_GET['ID']));
	header("location: {$gConfig['site_url']}admin/flags.php");
}
$action = $_GET['action'];

$smarty->assign("page_content",  getList());
$smarty->display('index.tpl');
function getList( $iArticleID = '' )
{
	global $site;

	$ret = '
	<table width=100%><tr><td valign=top><b>Type</b></td><td valign=top><b>Name</b></td><td valign=top><b>Date</b></td><td valign=top><b>From</b></td><td valign=top></td></tr>';

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
	$sQuery = "select * from Flags order by ID desc";
	$rElems = mysql_query( $sQuery );
	$iNums = mysql_num_rows($rElems);
	$count = (int)($iNums/$iDivis);
	if(($iNums/$iDivis) > (int)($iNums/$iDivis)) $count++;
	$nav =  ($iNums > $iDivis ? commentNavigation($iNums,$iDivis,$iCurr,'','commPage') : '');
	$rElems = mysql_query( $sQuery.$sLimit );

	while($a = mysql_fetch_assoc($rElems))
	{
		if($a['type']==0)
		{
			$url = 'profile';
			$type = 'Profile: ';
			$info = mysql_fetch_assoc(mysql_query("select * from Profiles where ID=".$a['itemID']));
			$info = $info['fname'].' '.$info['lname'];
		}
		elseif($a['type']==1)
		{
			$url = 'product';
			$type = 'Product(sale): ';
			$info = mysql_fetch_assoc(mysql_query("select * from Store where type=0 and ID=".$a['itemID']));
			$info = $info['Title'];
		}
		else
		{
			$url = 'wproduct';
			$type = 'Product(wanted): ';
			$info = mysql_fetch_assoc(mysql_query("select * from Store where type=1 and ID=".$a['itemID']));
			$info = $info['Title'];
		}
		$from = mysql_fetch_assoc(mysql_query("select * from Profiles where ID=".$a['userID']));
		$from = $from['fname'].' '.$from['lname'];
		$ret.='<tr>
		<td valign=top><b>'.$type.'</b></td>
		<td valign=top><a target="_blank" href="'.$url.'.php?ID='.$a['itemID'].'">'.$info.'</a></td>
		<td valign=top>'.date("d-m-Y H:i",$a['date']).'</td>
		<td valign=top><a href="profile.php?ID='.$a['userID'].'">'.$from.'</a></td>
		<td valign=top><a href="javascript:if(confirm(\'Delete flag?\')) top.window.location=\'' . $gConfig['site_url'] . 'admin/flags.php?del&ID='.$a['ID'].(isset($_GET['demo'])?'&demo=1':'').'\';">Del</a></td></tr>';
	}
	$ret.='</table><br>'.$nav;

	return  $ret;
}

?>

