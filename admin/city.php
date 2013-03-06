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

$smarty->assign("site_title",  "Manage City :: Admin Panel :: ".$gConfig['site_title']);
$smarty->assign("page_header_text",  "Manage City");

if(isset($_POST['editID']))
{
	$Photo = '';
	mysql_query("update City set Title='".mysql_escape_string($_POST['Title'])."' where ID=".intval($_POST['editID']));
	header("location: {$gConfig['site_url']}admin/city.php");
}

if(isset($_POST['goadd']) && trim($_POST['Title'])!='')
{
	mysql_query("insert into City set Title='".mysql_escape_string($_POST['Title'])."'");
	header("location: {$gConfig['site_url']}admin/city.php");
}

if(isset($_GET['del']) && intval($_GET['ID']) > 0)
{
	mysql_query("delete from City  where ID=".intval($_GET['ID']));
	header("location: {$gConfig['site_url']}admin/city.php");
}
$action = $_GET['action'];

$smarty->assign("page_content",  getArticlesAdminContent());
$smarty->display('index.tpl');

function getArticlesAdminContent()
{
	global $site;
	global $sActionText;
	global $action,$itemviewid;

	$ret = '';
		switch ($action )
		{
			case 'edit':
				$ID = (int)$_REQUEST['ID'];
				$ret .= getEdit($ID);
			break;
			case 'add':
				$ret .= getAdd();
			break;

			default:
				$ret .= getList();
			break;
		}

	return $ret;
}

function getList( $iArticleID = '' )
{
	global $site, $gConfig;

	$ret = '<a href="' . $gConfig['site_url'] . 'admin/city.php?action=add">Add City</a><br><br>
	<table width="100%">';
	$q = mysql_query("select * from City where ID>0 order by ID desc");
	$ret.='<tr><td valign=top><b>Title</b></td><td valign=top><b>Count users with it</b></td><td valign=top></td></tr>';
	while($a = mysql_fetch_assoc($q))
	{
		$num = mysql_numrows(mysql_query("select * from Profiles where city=".intval($a['ID'])));
		$ret.='<tr><td valign=top><b>'.$a['Title'].'</b></td>
		<td valign=top><b>'.intval($num).'</b></td>
		<td valign=top><a href="' . $gConfig['site_url'] . 'admin/city.php?action=edit&ID='.$a['ID'].'">Edit</a> &nbsp;&nbsp;&nbsp;<a href="javascript:if(confirm(\'Delete City?\')) top.window.location=\''.$gConfig['site_url'].'admin/city.php?del&ID='.$a['ID'].(isset($_GET['demo'])?'&demo=1':'').'\';">Delete</a></td></tr>';
	}
	$ret.='</table>';
	return  $ret;
}

function getEdit( $iArticleID = '' )
{
	global $site, $gConfig;

	$articleQuery = "

		SELECT * from City WHERE `ID` = '$iArticleID';
	";
	$aArticle = mysql_fetch_assoc(mysql_query( $articleQuery ));
	$Related = unserialize($aArticle['Related']);
	if(!is_array($Related)) $Related = array();

	$ret = '';
	$ret .= '<div class="navigationLinks">' . "\n";
		$ret .= '<span>' . "\n";
			$ret .= '<a href="' . $gConfig['site_url'] . 'admin/city.php">' . "\n";
				$ret .= 'All City' . "\n";
			$ret .= '</a>' . "\n";
		$ret .= '</span>' . "\n";


	$ret .= '</div>' . "\n";


	//$ret .= print_r( $_POST, true );
	$ret .=  "\n";
	$ret .= '<div class="articlesFormBlock">' . "\n";
		$ret .= '<form method="post" action="' . $gConfig['site_url'] . 'admin/city.php" onsubmit="return checkForm();" enctype="multipart/form-data">' . "\n";
			$ret .= '<div>' . "\n";
				$ret .= '<b>Title</b>' . "\n";
			$ret .= '</div>' . "\n";
			$ret .= '<div>' . "\n";
				$ret .= '<input type="text" name="Title" id="Name" class="catCaption" value="' . htmlspecialchars( $aArticle['Title'] ) . '" />' . "\n";
			$ret .= '</div>' . "\n";

			$ret .= '<input type="hidden" name="editID" value="'.$aArticle['ID'].'" />' . "\n";
			$ret .= '';
			$ret .= '<input type=submit name=go value="Save">' . "\n";

		$ret .= '</form>' . "\n";
	$ret .= '</div>' . "\n";

	return $ret;
}

function getAdd( )
{
	global $site, $gConfig;


	$ret = '';
	$ret .= '<div class="navigationLinks">' . "\n";
		$ret .= '<span>' . "\n";
			$ret .= '<a href="' . $gConfig['site_url'] . 'admin/city.php">' . "\n";
				$ret .= 'All City' . "\n";
			$ret .= '</a>' . "\n";
		$ret .= '</span>' . "\n";
	$ret .= '</div>' . "\n";

	$ret .=  "\n";
	$ret .= '<div class="articlesFormBlock">' . "\n";
		$ret .= '<form method="post" action="' . $gConfig['site_url'] . 'admin/city.php" onsubmit="return checkForm();" enctype="multipart/form-data">' . "\n";
			$ret .= '<div>' . "\n";
				$ret .= '<b>Title</b>' . "\n";
			$ret .= '</div>' . "\n";
			$ret .= '<div>' . "\n";
				$ret .= '<input type="text" name="Title" id="Name" class="catCaption" value="' . htmlspecialchars( $aArticle['Title'] ) . '" />' . "\n";
			$ret .= '</div>' . "\n";


			$ret .= '<input type=submit name=goadd value="Add">' . "\n";

		$ret .= '</form>' . "\n";
	$ret .= '</div>' . "\n";

	return $ret;
}
?>

