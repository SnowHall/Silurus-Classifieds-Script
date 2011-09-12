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

$smarty->assign("site_title",  "Manage Book Categories :: Admin Panel :: ".$gConfig['site_title']);
$smarty->assign("page_header_text",  "Manage Book Categories");


if(isset($_POST['editID']))
{	
	$Photo = '';		
	mysql_query("update BookCategories set Title='".mysql_escape_string($_POST['Title'])."',Related='".mysql_escape_string(serialize($_POST['Related']))."' where ID=".intval($_POST['editID']));	
	header("location: /admin/category.php");
}

if(isset($_POST['goadd']) && trim($_POST['Title'])!='')
{
	mysql_query("insert into BookCategories set Title='".mysql_escape_string($_POST['Title'])."',Related='".mysql_escape_string(serialize($_POST['Related']))."'");
	header("location: /admin/category.php");
}

if(isset($_GET['del']) && intval($_GET['ID']) > 0)
{
	mysql_query("delete from BookCategories  where ID=".intval($_GET['ID']));
	header("location: /admin/category.php");
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
	global $site;
	
	$ret = '<a href="/admin/category.php?action=add">Add category</a><br><br>
	<table width=100%>';	
	$q = mysql_query("select * from BookCategories where ID>0 order by Title");
	$ret.='<tr><td valign=top><b>Title</b></td>
		<td valign=top><b>Count books for sale</b></td>
		<td valign=top><b>Count Wanted books</b></td>
		<td valign=top></td></tr>';
	while($a = mysql_fetch_assoc($q))
	{
		$num1 = mysql_numrows(mysql_query("select * from Books where categoryID=".intval($a['ID'])));
		$num2 = mysql_numrows(mysql_query("select * from WBooks where categoryID=".intval($a['ID'])));
		$ret.='<tr><td valign=top><b>'.$a['Title'].'</b></td>
		<td valign=top><b>'.intval($num1).'</b></td>
		<td valign=top><b>'.intval($num2).'</b></td>
		<td valign=top><a href="/admin/category.php?action=edit&ID='.$a['ID'].'">Edit</a> &nbsp;&nbsp;&nbsp;<a href="javascript:if(confirm(\'Delete category?\')) window.location=\'/admin/category.php?del&ID='.$a['ID'].'\';">Delete</a></td></tr>';
	}
	$ret.='</table>';
	return  $ret;
}

function getEdit( $iArticleID = '' )
{
	global $site;
		
	$articleQuery = "

		SELECT * from BookCategories WHERE `ID` = '$iArticleID';
	";
	$aArticle = mysql_fetch_assoc(mysql_query( $articleQuery ));
	$Related = unserialize($aArticle['Related']);
	if(!is_array($Related)) $Related = array();
	
	$ret = '';
	$ret .= '<div class="navigationLinks">' . "\n";
		$ret .= '<span>' . "\n";
			$ret .= '<a href="' . $site['url_admin'] . 'category.php">' . "\n";
				$ret .= 'All categories' . "\n";
			$ret .= '</a>' . "\n";
		$ret .= '</span>' . "\n";
		

	$ret .= '</div>' . "\n";


	//$ret .= print_r( $_POST, true );
	$ret .=  "\n";
	$ret .= '<div class="articlesFormBlock">' . "\n";
		$ret .= '<form method="post" action="' . $site['url_admin'] . 'category.php" onsubmit="return checkForm();" enctype="multipart/form-data">' . "\n";
			$ret .= '<div>' . "\n";
				$ret .= '<b>Title</b>' . "\n";
			$ret .= '</div>' . "\n";
			$ret .= '<div>' . "\n";
				$ret .= '<input type="text" name="Title" id="Name" class="catCaption" value="' . htmlspecialchars( $aArticle['Title'] ) . '" />' . "\n";
			$ret .= '</div>' . "\n";	
			
			$ret .= '<div>' . "\n";
				$ret .= '<b>Related Categories</b>' . "\n";
			$ret .= '</div>' . "\n";
			$ret .= '<div>' . "\n";
			$q = mysql_query("select * from BookCategories order by Title");
			while($arr = mysql_fetch_assoc($q))
			{
				if($arr['ID'] != $iArticleID)
				$ret .= '
				<input type="checkbox" name="Related[]" value="'.$arr['ID'].'" '.(in_array($arr['ID'],$Related)?'checked':'').'> '.$arr['Title'].' <bR>
				';
			}	
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
	global $site;
		
	
	$ret = '';
	$ret .= '<div class="navigationLinks">' . "\n";
		$ret .= '<span>' . "\n";
			$ret .= '<a href="' . $site['url_admin'] . 'category.php">' . "\n";
				$ret .= 'All categories' . "\n";
			$ret .= '</a>' . "\n";
		$ret .= '</span>' . "\n";
	$ret .= '</div>' . "\n";

	$ret .=  "\n";
	$ret .= '<div class="articlesFormBlock">' . "\n";
		$ret .= '<form method="post" action="' . $site['url_admin'] . 'category.php" onsubmit="return checkForm();" enctype="multipart/form-data">' . "\n";
			$ret .= '<div>' . "\n";
				$ret .= '<b>Title</b>' . "\n";
			$ret .= '</div>' . "\n";
			$ret .= '<div>' . "\n";
				$ret .= '<input type="text" name="Title" id="Name" class="catCaption" value="' . htmlspecialchars( $aArticle['Title'] ) . '" />' . "\n";
			$ret .= '</div>' . "\n";			
					
			$ret .= '<div>' . "\n";
				$ret .= '<b>Related Categories</b>' . "\n";
			$ret .= '</div>' . "\n";
			$ret .= '<div>' . "\n";
			$q = mysql_query("select * from BookCategories order by Title");
			while($arr = mysql_fetch_assoc($q))
			{
				$ret .= '
				<input type="checkbox" name="Related[]" value="'.$arr['ID'].'"> '.$arr['Title'].' <bR>
				';
			}	
			$ret .= '</div>' . "\n";
				
			$ret .= '<input type=submit name=goadd value="Add">' . "\n";

		$ret .= '</form>' . "\n";
	$ret .= '</div>' . "\n";

	return $ret;
}
?>

