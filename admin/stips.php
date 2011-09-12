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

$smarty->assign("site_title",  "Manage Seller Tips :: Admin Panel :: ".$gConfig['site_title']);
$smarty->assign("page_header_text",  "Manage Seller Tips");

if(isset($_POST['editID']))
{	
	$Photo = '';		
	mysql_query("update STips set Title='".mysql_escape_string($_POST['Title'])."',Text='".mysql_escape_string($_POST['Text'])."' where ID=".intval($_POST['editID']));	
	header("location: /admin/stips.php");
}

if(isset($_POST['goadd']) && trim($_POST['Title'])!='')
{
	mysql_query("insert into STips set Title='".mysql_escape_string($_POST['Title'])."',Text='".mysql_escape_string($_POST['Text'])."'");
	header("location: /admin/stips.php");
}

if(isset($_GET['del']) && intval($_GET['ID']) > 0)
{
	mysql_query("delete from STips  where ID=".intval($_GET['ID']));
	header("location: /admin/stips.php");
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
	
	$ret = '<a href="/admin/stips.php?action=add">Add tip</a><br><br>
	<b>Seller Tips page preface</b><hr><table width=100%>';
	$q = mysql_query("select * from STips where ID=-1");
	$a = mysql_fetch_assoc($q);
	$ret.='<tr><td valign=top><b>'.$a['Title'].'</b></td><td valign=top><a href="/admin/stips.php?action=edit&ID='.$a['ID'].'">Edit</a><br><br></td></tr>
	<tr><td colspan=10><b>Seller Tips</b><hr></td></td>';
	
	$q = mysql_query("select * from STips where ID>0 order by ID");
	while($a = mysql_fetch_assoc($q))
	{
		$ret.='<tr><td valign=top><b>'.$a['Title'].'</b></td><td valign=top><a href="/admin/stips.php?action=edit&ID='.$a['ID'].'">Edit</a> &nbsp;&nbsp;&nbsp;<a href="/admin/stips.php?del&ID='.$a['ID'].'">Delete</a></td></tr>';
	}
	$ret.='</table>';
	return  $ret;
}

function getEdit( $iArticleID = '' )
{
	global $site;
		
	$articleQuery = "

		SELECT * from STips WHERE `ID` = '$iArticleID';
	";
	$aArticle = mysql_fetch_assoc(mysql_query( $articleQuery ));
	

	$ret = '';
	$ret .= '<div class="navigationLinks">' . "\n";
		$ret .= '<span>' . "\n";
			$ret .= '<a href="' . $site['url_admin'] . 'stips.php">' . "\n";
				$ret .= 'All tips' . "\n";
			$ret .= '</a>' . "\n";
		$ret .= '</span>' . "\n";
		

	$ret .= '</div>' . "\n";


	//$ret .= print_r( $_POST, true );
	$ret .=  "\n";
	$ret .= '<div class="articlesFormBlock">' . "\n";
		$ret .= '<form method="post" action="' . $site['url_admin'] . 'stips.php" onsubmit="return checkForm();" enctype="multipart/form-data">' . "\n";
			$ret .= '<div>' . "\n";
				$ret .= '<b>Title</b>' . "\n";
			$ret .= '</div>' . "\n";
			$ret .= '<div>' . "\n";
				$ret .= '<input type="text" name="Title" id="Name" class="catCaption" value="' . htmlspecialchars( $aArticle['Title'] ) . '" />' . "\n";
			$ret .= '</div>' . "\n";			
			$ret .= '<div>' . "\n";
				$ret .= '<b>Text</b>' . "\n";
			$ret .= '</div>' . "\n";
			$ret .= '<div style="margin-bottom:7px;">' . "\n";
			
			
			$ret .= getfceditor('Text',$aArticle['Text']);
			
									
			$ret .= '<input type="hidden" name="editID" value="'.$aArticle['ID'].'" />' . "\n";		
			$ret .= '</div>';
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
			$ret .= '<a href="' . $site['url_admin'] . 'stips.php">' . "\n";
				$ret .= 'All tips' . "\n";
			$ret .= '</a>' . "\n";
		$ret .= '</span>' . "\n";
	$ret .= '</div>' . "\n";

	$ret .=  "\n";
	$ret .= '<div class="articlesFormBlock">' . "\n";
		$ret .= '<form method="post" action="' . $site['url_admin'] . 'stips.php" onsubmit="return checkForm();" enctype="multipart/form-data">' . "\n";
			$ret .= '<div>' . "\n";
				$ret .= '<b>Title</b>' . "\n";
			$ret .= '</div>' . "\n";
			$ret .= '<div>' . "\n";
				$ret .= '<input type="text" name="Title" id="Name" class="catCaption" value="' . htmlspecialchars( $aArticle['Title'] ) . '" />' . "\n";
			$ret .= '</div>' . "\n";			
			$ret .= '<div>' . "\n";
				$ret .= '<b>Text</b>' . "\n";
			$ret .= '</div>' . "\n";
			$ret .= '<div style="margin-bottom:7px;">' . "\n";
			
			$ret .= getfceditor('Text',$aArticle['Text']);				
			
			$ret .= '</div><input type=submit name=goadd value="Add">' . "\n";

		$ret .= '</form>' . "\n";
	$ret .= '</div>' . "\n";

	return $ret;
}
?>

