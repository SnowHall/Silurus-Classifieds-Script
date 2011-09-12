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

$smarty->assign("site_title",  "Edit Text pages :: Admin Panel :: ".$gConfig['site_title']);
$smarty->assign("page_header_text",  "Edit Text pages");

if(intval($_POST['editID']) > 0)
{		
	mysql_query("update Simple set Title='".mysql_escape_string($_POST['Title'])."',Text='".mysql_escape_string($_POST['Text'])."' where ID=".intval($_POST['editID']));	
	header("location: /admin/simple.php");
}

if(isset($_POST['addgo']) && trim($_POST['Title'])!='')
{		
	mysql_query("insert into Simple set Title='".mysql_escape_string($_POST['Title'])."',Text='".mysql_escape_string($_POST['Text'])."'");	
	header("location: /admin/simple.php");
}

if(intval($_REQUEST['delID']) > 0)
{		
	mysql_query("delete from Simple where ID=".intval($_REQUEST['delID']));	
	header("location: /admin/simple.php");
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
	
	$ret = '<a href="/admin/simple.php?action=add">Add New Page</a><br><br><table>';
	$q = mysql_query("select * from Simple");
	while($a = mysql_fetch_assoc($q))
	{
		$ret.='<tr><td><a href="/simple.php?ID='.$a['ID'].'" target="_blank">'.$a['Title'].'</a></td><td><a href="/admin/simple.php?action=edit&ID='.$a['ID'].'">Edit</a>&nbsp;&nbsp;&nbsp;<a href="/admin/simple.php?delID='.$a['ID'].'">Delete</a></td></tr>';
	}
	$ret.='</table>';
	return  $ret;
}

function getAdd( )
{
		
	$ret = '';
	$ret .= '<div class="navigationLinks">' . "\n";
		$ret .= '<span>' . "\n";
			$ret .= '<a href="/admin/simple.php">' . "\n";
				$ret .= 'All Pages' . "\n";
			$ret .= '</a>' . "\n";
		$ret .= '</span>' . "\n";		

	$ret .= '</div>' . "\n";


	$ret .= '<div class="articlesFormBlock">' . "\n";
		$ret .= '<form method="post" action="" onsubmit="return checkForm();" enctype="multipart/form-data">' . "\n";
			$ret .= '<div>' . "\n";
				$ret .= '<b>Page Name</b>' . "\n";
			$ret .= '</div>' . "\n";
			$ret .= '<div>' . "\n";
				$ret .= '<input type="text" name="Title" id="Name" class="catCaption" value="' . htmlspecialchars( $_REQUEST['Title'] ) . '" />' . "\n";
			$ret .= '</div>' . "\n";			
			$ret .= '<div>' . "\n";
				$ret .= '<b>Text</b>' . "\n";
			$ret .= '</div>' . "\n";
			$ret .= '<div style="margin-bottom:7px;">' . "\n";
				$ret .= getfceditor('Text',$_REQUEST['Text']);	
			$ret .= '</div>' . "\n";
			$ret .= '</div>';
			$ret .= '</div>';
			$ret .= '<input type=submit name=addgo value="Save">' . "\n";

		$ret .= '</form>' . "\n";
	$ret .= '</div>' . "\n";

	return $ret;
}

function getEdit( $iArticleID = '' )
{
	global $site;
		
	if( (int)$iArticleID )
	{
		$articleQuery = "

			SELECT * from Simple WHERE `ID` = '$iArticleID';
		";
		$aArticle = mysql_fetch_assoc(mysql_query( $articleQuery ));
	}


	$ret = '';
	$ret .= '<div class="navigationLinks">' . "\n";
		$ret .= '<span>' . "\n";
			$ret .= '<a href="' . $site['url_admin'] . 'simple.php">' . "\n";
				$ret .= 'All Pages' . "\n";
			$ret .= '</a>' . "\n";
		$ret .= '</span>' . "\n";
		

	$ret .= '</div>' . "\n";


	//$ret .= print_r( $_POST, true );
	$ret .= '<script type="text/javascript">

			function checkForm()
			{
				var el;
				var hasErr = false;
				var fild = "";
								
				if (hasErr)
				{
					alert( "Please fill next fields first!" + fild )
					return false;

				}
				else
				{
					return true;
				}
			}

	</script>' . "\n";
	$ret .= '<div class="articlesFormBlock">' . "\n";
		$ret .= '<form method="post" action="' . $site['url_admin'] . 'simple.php" onsubmit="return checkForm();" enctype="multipart/form-data">' . "\n";
			$ret .= '<div>' . "\n";
				$ret .= '<b>Page Name</b>' . "\n";
			$ret .= '</div>' . "\n";
			$ret .= '<div>' . "\n";
				$ret .= '<input type="text" name="Title" id="Name" class="catCaption" value="' . htmlspecialchars( $aArticle['Title'] ) . '" />' . "\n";
			$ret .= '</div>' . "\n";			
			$ret .= '<div>' . "\n";
				$ret .= '<b>Text</b>' . "\n";
			$ret .= '</div>' . "\n";
			$ret .= '<div style="margin-bottom:7px;">' . "\n";
				$ret .= getfceditor('Text',$aArticle['Text']);	
			$ret .= '</div>' . "\n";
			$ret .= '<input type="hidden" name="editID" value="'.$aArticle['ID'].'" />' . "\n";		
			$ret .= '</div>';
			
			$ret .= '<input type="hidden" name="editID" value="'.$aArticle['ID'].'" />' . "\n";		
			$ret .= '</div>';
			$ret .= '<input type=submit name=go value="Save">' . "\n";

		$ret .= '</form>' . "\n";
	$ret .= '</div>' . "\n";

	return $ret;
}


?>

