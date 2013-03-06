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

$smarty->assign("site_title",  "Site Language Settings :: Admin Panel :: ".$gConfig['site_title']);
$smarty->assign("page_header_text",  "Site Language Settings");
if(isset($_POST['editID']))
{
  if( $_FILES['Translation'] and !empty( $_FILES['Translation'] ) )
	{
    uploadTranslationFile($_FILES['Translation']);
	}

  mysql_query("UPDATE `Languages` SET `Name`='".mysql_escape_string($_POST['Name'])."',
    `Language`='".mysql_escape_string($_POST['Language'])."'
      WHERE `ID`='".intval($_POST['editID'])."'");
	header("location: {$gConfig['site_url']}admin/languages.php");
}

if(isset($_POST['goadd']) && trim($_POST['Name'])!='' && trim($_POST['Language'])!='')
{
  if( $_FILES['Translation'] and !empty( $_FILES['Translation'] ) )
	{
		uploadTranslationFile($_FILES['Translation']);
	}

  mysql_query("INSERT INTO `Languages` SET `Name`='".mysql_escape_string($_POST['Name'])."',
    `Language`='".  mysql_escape_string($_POST['Language'])."'");

	header("location: {$gConfig['site_url']}admin/languages.php");
}

if(isset($_GET['del']) && intval($_GET['id']) > 0)
{
	mysql_query("DELETE FROM `Languages` WHERE `id`=".intval($_GET['id']));
	header("location: {$gConfig['site_url']}admin/languages.php");
}
$action = $_GET['action'];

$smarty->assign("page_content",  getLanguagesAdminContent());
$smarty->display('index.tpl');

function getLanguagesAdminContent()
{
	global $action;

	$content = '';
		switch ($action)
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

function getList()
{
	global $gConfig;

	$content = '<a href="' . $gConfig['site_url'] . 'admin/languages.php?action=add">Add Language</a><br><br>
	<table width="100%">';
	$languagesList = mysql_query("select * from `Languages`");
	$content.='<tr><td valign=top><b>Name</b></td><td valign=top><b>Language Mark</b></td><td valign=top></td></tr>';
	while($language = mysql_fetch_assoc($languagesList))
	{
		$content.=
      '<tr><td valign=top><b>'.$language['name'].'</b></td>
      <td valign=top><b>'.$language['language'].'</b></td>
      <td valign=top><a href="' . $gConfig['site_url'] . 'admin/languages.php?action=edit&ID='.$language['id'].'">Edit</a> &nbsp;&nbsp;&nbsp;<a href="javascript:if(confirm(\'Delete Language?\')) top.window.location=\''.$gConfig['site_url'] .'admin/languages.php?del&id='.$language['id'].(isset($_GET['demo'])?'&demo=1':'').'\';">Delete</a></td></tr>';
	}
	$content.='</table>';
	return  $content;
}

function getEdit( $languageID = '' )
{
	global $site;

	$languagesSql = "SELECT * from `Languages` WHERE `ID` = '$languageID'";
	$language = mysql_fetch_assoc(mysql_query( $languagesSql ));

  	$content = '';
	$content .= '<div class="navigationLinks">' . "\n";
		$content .= '<span>' . "\n";
			$content .= '<a href="' . $site['url_admin'] . 'admin/languages.php">' . "\n";
				$content .= 'All Languages' . "\n";
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
				$content .= '<input type="text" name="Name" id="Name" class="catCaption" value="' . htmlspecialchars( $language['name'] ) . '" />' . "\n";
			$content .= '</div>' . "\n";
      $content .= '<div>' . "\n";
				$content .= '<b>Language mark</b>' . "\n";
			$content .= '</div>' . "\n";
			$content .= '<div>' . "\n";
				$content .= '<input type="text" name="Language" id="Language" class="catCaption" value="' . htmlspecialchars( $language['language'] ) . '" />' . "\n";
			$content .= '</div>' . "\n";
      $content .= '<div>' . "\n";
				$content .= '<b>Import translation (only .po files)</b>' . "\n";
			$content .= '</div>' . "\n";
			$content .= '<div>' . "\n";
				$content .= '<input type="file" name="Translation" />' . "\n";
			$content .= '</div>' . "\n";
			$content .= '<input type="hidden" name="editID" value="'.$language['id'].'" />' . "\n";

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
			$content .= '<a href="' . $site['url_admin'] . 'admin/languages.php">' . "\n";
				$content .= 'All Languages' . "\n";
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
				$content .= '<input type="text" name="Name" id="Name" class="catCaption" value="" />' . "\n";
			$content .= '</div>' . "\n";
      $content .= '<div>' . "\n";
				$content .= '<b>Language mark</b>' . "\n";
			$content .= '</div>' . "\n";
			$content .= '<div>' . "\n";
				$content .= '<input type="text" name="Language" id="Language" class="catCaption" value="" />' . "\n";
			$content .= '</div>' . "\n";
      $content .= '<div>' . "\n";
				$content .= '<b>Import translation (only .po files)</b>' . "\n";
			$content .= '</div>' . "\n";
			$content .= '<div>' . "\n";
				$content .= '<input type="file" name="Translation" />' . "\n";
			$content .= '</div>' . "\n";


			$content .= '<input type=submit name=goadd value="Add">' . "\n";

		$content .= '</form>' . "\n";
	$content .= '</div>' . "\n";

	return $content;
}

//upload translation .po file
function uploadTranslationFile($uploadFile)
{
  if( $uploadFile['error'] == 0 )
  {
    $ext = array_pop(explode('.',$uploadFile['name']));

    if( $ext == 'po')
    {
      $dir = "../media/translations/";
      $filename = $uploadFile['name'];
      move_uploaded_file($uploadFile['tmp_name'], $dir.$filename);

      if (file_exists($dir.$filename))
      {
        parseTranslationFile($filename,$dir);
        return true;
      }
    }
  }

  return false;
}