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

$smarty->assign("site_title",  "Manage Currency :: Admin Panel :: ".$gConfig['site_title']);
$smarty->assign("page_header_text",  "Manage Currency");

if(isset($_POST['editID']))
{
  $showValue = ($_POST['Show'] == 'on') ? '1' : '0';
  mysql_query("UPDATE `Currency` SET Name='".mysql_escape_string($_POST['Name'])."',
    Sign='".mysql_escape_string($_POST['Sign'])."', `Show` = '".$showValue."'
      WHERE `ID`='".intval($_POST['editID'])."'");
	header("location: {$gConfig['site_url']}admin/currency.php");
}

if(isset($_POST['goadd']) && trim($_POST['Name'])!='' && trim($_POST['Sign'])!='')
{
  $showValue = ($_POST['Show'] == 'on') ? '1' : '0';
	mysql_query( "INSERT INTO `Currency` SET `Name`='".mysql_escape_string($_POST['Name'])."',
    `Sign`='".  mysql_escape_string($_POST['Sign'])."', `Show` = '".$showValue."'");
	header("location: {$gConfig['site_url']}admin/currency.php");
}

if(isset($_GET['del']) && intval($_GET['id']) > 0)
{
	mysql_query("DELETE FROM `Currency` WHERE `id`=".intval($_GET['id']));
	header("location: {$gConfig['site_url']}admin/currency.php");
}
$action = $_GET['action'];

$smarty->assign("page_content",  getArticlesAdminContent());
$smarty->display('index.tpl');

function getArticlesAdminContent()
{
	global $site;
	global $sActionText;
	global $action,$itemviewid;

	$content = '';
		switch ($action )
		{
			case 'edit':
				$ID = (int)$_REQUEST['ID'];
				$content .= getEdit($ID);
			break;
			case 'add':
				$content .= getAdd();
			break;

			default:
				$content .= getList();
			break;
		}

	return $content;
}

function getList( $iArticleID = '' )
{
	global $site, $gConfig;

	$content = '<a href="' . $gConfig['site_url'] . 'admin/currency.php?action=add">Add Currency</a><br><br>
	<table width="100%">';
	$currencyList = mysql_query("select * from `Currency`");
	$content.='<tr><td valign=top><b>Name</b></td><td valign=top><b>Sign</b></td><td valign=top><b>Show</b></td><td valign=top></td></tr>';
	while($currency = mysql_fetch_assoc($currencyList))
	{
		$content.=
      '<tr><td valign=top><b>'.$currency['name'].'</b></td>
      <td valign=top><b>'.$currency['sign'].'</b></td>
      <td valign=top><b>'.$currency['show'].'</b></td>
      <td valign=top><a href="' . $gConfig['site_url'] . 'admin/currency.php?action=edit&ID='.$currency['id'].'">Edit</a> &nbsp;&nbsp;&nbsp;<a href="javascript:if(confirm(\'Delete City?\')) top.window.location=\''.$gConfig['site_url'] .'admin/currency.php?del&id='.$currency['id'].(isset($_GET['demo'])?'&demo=1':'').'\';">Delete</a></td></tr>';
	}
	$content.='</table>';
	return  $content;
}

function getEdit( $currencyID = '' )
{
	global $site;

	$currencyQuery = "

		SELECT * from `Currency` WHERE `ID` = '$currencyID';
	";
	$currency = mysql_fetch_assoc(mysql_query( $currencyQuery ));

  	$content = '';
	$content .= '<div class="navigationLinks">' . "\n";
		$content .= '<span>' . "\n";
			$content .= '<a href="' . $site['url_admin'] . 'admin/currency.php">' . "\n";
				$content .= 'All Currency' . "\n";
			$content .= '</a>' . "\n";
		$content .= '</span>' . "\n";
	$content .= '</div>' . "\n";

	$content .=  "\n";
	$content .= '<div class="articlesFormBlock">' . "\n";
		$content .= '<form method="post" action="" onsubmit="return checkForm();" enctype="multipart/form-data">' . "\n";
			$content .= '<div>' . "\n";
				$content .= '<b>Name</b>' . "\n";
			$content .= '</div>' . "\n";
			$content .= '<div>' . "\n";
				$content .= '<input type="text" name="Name" id="Name" class="catCaption" value="' . htmlspecialchars( $currency['name'] ) . '" />' . "\n";
			$content .= '</div>' . "\n";
      $content .= '<div>' . "\n";
				$content .= '<b>Sign</b>' . "\n";
			$content .= '</div>' . "\n";
			$content .= '<div>' . "\n";
				$content .= '<input type="text" name="Sign" id="Sign" class="catCaption" value="' . htmlspecialchars( $currency['sign'] ) . '" />' . "\n";
			$content .= '</div>' . "\n";
      $content .= '<div>' . "\n";
				$content .= '<b>Show</b>' . "\n";
			$content .= '</div>' . "\n";
			$content .= '<div>' . "\n";
				$content .= '<input type="checkbox" name="Show" id="Show" ' . ($currency['show'] ? 'checked = "checked"' : ''). ' />' . "\n";
			$content .= '</div>' . "\n";
			$content .= '<input type="hidden" name="editID" value="'.$currency['id'].'" />' . "\n";

			$content .= '<input type=submit name=go value="Save">' . "\n";

		$content .= '</form>' . "\n";
	$content .= '</div>' . "\n";

	return $content;
}

function getAdd( )
{
	global $site;

	$content = '';
	$content .= '<div class="navigationLinks">' . "\n";
		$content .= '<span>' . "\n";
			$content .= '<a href="' . $site['url_admin'] . 'admin/currency.php">' . "\n";
				$content .= 'All Currency' . "\n";
			$content .= '</a>' . "\n";
		$content .= '</span>' . "\n";
	$content .= '</div>' . "\n";

	$content .=  "\n";
	$content .= '<div class="articlesFormBlock">' . "\n";
		$content .= '<form method="post" action="" onsubmit="return checkForm();" enctype="multipart/form-data">' . "\n";
			$content .= '<div>' . "\n";
				$content .= '<b>Name</b>' . "\n";
			$content .= '</div>' . "\n";
			$content .= '<div>' . "\n";
				$content .= '<input type="text" name="Name" id="Name" class="catCaption" value="' . htmlspecialchars( $aArticle['Name'] ) . '" />' . "\n";
			$content .= '</div>' . "\n";
      $content .= '<div>' . "\n";
				$content .= '<b>Sign</b>' . "\n";
			$content .= '</div>' . "\n";
			$content .= '<div>' . "\n";
				$content .= '<input type="text" name="Sign" id="Sign" class="catCaption" value="' . htmlspecialchars( $aArticle['Sign'] ) . '" />' . "\n";
			$content .= '</div>' . "\n";
      $content .= '<div>' . "\n";
				$content .= '<b>Show</b>' . "\n";
			$content .= '</div>' . "\n";
			$content .= '<div>' . "\n";
				$content .= '<input type="checkbox" name="Show" id="Show" checked = "checked" />' . "\n";
			$content .= '</div>' . "\n";


			$content .= '<input type=submit name=goadd value="Add">' . "\n";

		$content .= '</form>' . "\n";
	$content .= '</div>' . "\n";

	return $content;
}
?>

