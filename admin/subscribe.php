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

$smarty->assign("site_title",  "Send Site News for All Users :: Admin Panel :: ".$gConfig['site_title']);
$smarty->assign("page_header_text",  "Send Site News for All Users");

if(isset($_POST[save]))
{
	if(intval($_POST[ID]) > 0)
	{
		mysql_query("update letters set Count=0,status=0,Subject='".mysql_escape_string($_POST[Subject])."',Text='".mysql_escape_string($_POST[Text])."' where ID=".intval($_POST[ID]));
	}
	else 
	{
		mysql_query("insert into letters set Count=0,Subject='".mysql_escape_string($_POST[Subject])."',Text='".mysql_escape_string($_POST[Text])."'");
	}
	header("location: /admin/subscribe.php");
}

if(isset($_POST[send]))
{
	$ID = intval($_POST[ID]);
	if(!isset($_POST[show]))
	{
		$subj = $_POST[Subject];
		$Text = $_POST[Text];
		if(intval($_POST[ID]) > 0)
		{
			mysql_query("update letters set Count=0,status=1,Subject='".mysql_escape_string($_POST[Subject])."',Text='".mysql_escape_string($_POST[Text])."' where ID=".intval($_POST[articleID]));
		}
		else 
		{
			mysql_query("insert into letters set Count=0,status=1,Subject='".mysql_escape_string($_POST[Subject])."',Text='".mysql_escape_string($_POST[Text])."'");
			$ID = mysql_insert_id();
		}
	}
	else 
	{
		$info = mysql_fetch_assoc(mysql_query("select * from letters where ID=$ID"));
		$subj = $info[Subject];
		$Text = $info[Text];
	}
	mysql_query("update letters set Count=0,status=1 where ID=$ID");
				                    
	header("location: /admin/subscribe.php");
}
	

$smarty->assign("page_content",  getArticlesAdminContent());
$smarty->display('index.tpl');

function getArticlesAdminContent()
{
	global $site;
	global $sActionText;

	$ret = '';

//	$ret .= '<div id="artBlock">' . "\n";

		if (strlen($sActionText)!=0)
		{
			$ret .= '<div class="categoryAction">' . "\n";
				$ret .= $sActionText . "\n";
			$ret .= '</div>' . "\n";
		}
		$ret .= '<div>' . "\n";
		switch ($_GET['action'] )
		{
			case 'create':
				$ret .= getArticleEditForm() . "\n";
			break;		
			case 'edit':
				$ret .= getArticleEditForm(intval($_GET[ID])) . "\n";
			break;
			case 'show':
				$ret .= show(intval($_GET[ID])) . "\n";
			break;
			
			default:
				$ret .= letterlist() . "\n";
			break;
		}


		$ret .= '</div>' . "\n";
//	$ret .= '</div>' . "\n";


	return $ret;
}

function show($ID)
{
	$ret .= '<div class="navigationLinks">' . "\n";
		$ret .= '<span>' . "\n";
			$ret .= '<a href="' . $site['url_admin'] . 'subscribe.php">' . "\n";
				$ret .= '<b>All letters</b>' . "\n";
			$ret .= '</a>' . "\n";
		$ret .= '</span>' . "\n";		
	$ret .= '</div>' . "\n";
	$info = mysql_fetch_assoc(mysql_query("select * from letters where ID=".$ID));
	$ret .= "
	<form method=post>
	<input type=hidden name=ID value='$ID'> <input type=hidden name=show value=1> 
	<b>Subject:</b> $info[Subject]<br><br>
	<b>Text:</b><br>$info[Text]<br><br><input type=submit name=send value='Send'> <input type=button onclick='window.location=\"/admin/subscribe.php?action=edit&ID=$ID\";' value='Edit'> 
	</form>" ;
	return $ret;
}

function letterlist()
{
	global $site;

	$ret = '';

	$iDivis = 20;	
	$iCurr  = 1;	
	if (!isset($_GET['commPage']))
	{
		$sLimit =  ' LIMIT 0,'.$iDivis;
	}
	else
	{
		$iCurr = (int)$_GET['commPage'];
		$sLimit =  ' LIMIT '.($iCurr - 1)*$iDivis.','.$iDivis;
	}
	$sArticlesQuery = "SELECT * from letters order by Time desc ";
	$rArticles = mysql_query( $sArticlesQuery );
	$iNums = mysql_num_rows($rArticles);	
	$count = (int)($iNums/$iDivis);
	if(($iNums/$iDivis) > (int)($iNums/$iDivis)) $count++;
	$nav =  ($iNums > $iDivis ? commentNavigation($iNums,$iDivis,$iCurr,'&perpage='.$_GET['perpage']) : '');
	$rArticles = mysql_query( $sArticlesQuery . $sLimit);
	$ret .= "<a href='/admin/subscribe.php?action=create'><b>Create New Letter</b></a><br><br>
	<table width=100%><tr><td><b>Subject</b></td><td><b>Last Send Date</b></td><td><b>Recipients</b></td><td><b>Status</b></td><td></td></tr>";
	while($arr = mysql_fetch_assoc($rArticles))
	{
		$ret .= "<tr><td><a href='/admin/subscribe.php?action=show&ID=$arr[ID]'>$arr[Subject]</a></td><td>".(intval($arr[Time])?date("d-m-Y H:i",$arr[Time]):'Never Sended')."</td>
		<td>".$arr[Count]."</td>
		<td>".($arr[status]==0?'<b>Draft</b>':'').($arr[status]==1?'Wait':'').($arr[status]==3?'Sent':'')."</td>
		<td><a href='/admin/subscribe.php?action=edit&ID=$arr[ID]'>Edit</a></td></tr>";
	}
	$ret .= "</table>";
	return $ret;
}

function getArticleEditForm( $iArticleID = '' )
{
	global $site;
	global $site;

	

	if( (int)$iArticleID )
	{
		$articleQuery = "select * from letters where ID=".$iArticleID;
		$aArticle = mysql_fetch_assoc(mysql_query( $articleQuery ));
	}


	$ret = '';
	$ret .= '<div class="navigationLinks">' . "\n";
		$ret .= '<span>' . "\n";
			$ret .= '<a href="' . $site['url_admin'] . 'subscribe.php">' . "\n";
				$ret .= '<b>All letters</b>' . "\n";
			$ret .= '</a>' . "\n";
		$ret .= '</span>' . "\n";		
	$ret .= '</div>' . "\n";


	//$ret .= print_r( $_POST, true );	
	$ret .= '<div class="articlesFormBlock">' . "\n";
		$ret .= '<form method="post" action="' . $site['url_admin'] . 'subscribe.php"  enctype="multipart/form-data">' . "\n";
			$ret .= '<div>' . "\n";
				$ret .= 'Subject' . "\n";
			$ret .= '</div>' . "\n";
			$ret .= '<div>' . "\n";
				$ret .= '<input type="text" name="Subject" id="Subject" class="catCaption" value="' . htmlspecialchars( $aArticle['Subject'] ) . '" />' . "\n";
			$ret .= '</div>' . "\n";		
			
			$ret .= '<div>' . "\n";
				$ret .= 'Text' . "\n";
			$ret .= '</div>' . "\n";
			$ret .= '<div style="margin-bottom:7px;">' . "\n";
				$ret .= getfceditor('Text',$aArticle['Text']);	
			$ret .= '</div>' . "\n";
						
			$ret .= '<div>' . "\n";
				$ret .= '<input type="submit" name=send value="Send"> <input type="submit" name=save value="Save">' . "\n";

				if( (int)$iArticleID )
				{
					$ret .= '<input type="hidden" name="edit_article" value="true" />' . "\n";
					$ret .= '<input type="hidden" name="ID" value="' . $iArticleID . '" />' . "\n";
				}
				else
				{
					$ret .= '<input type="hidden" name="add_article" value="true" />' . "\n";
				}

			$ret .= '</div>' . "\n";

		$ret .= '</form>' . "\n";
	$ret .= '</div>' . "\n";

	return $ret;
}


?>
