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

include("./include_php/init.php");

if($_SESSION['memberID'] == 0) header("location: /");
	
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$err = array();
	$add_on = '';
	if($_POST['Email'] != $_POST['Email2']) 
		$err['Email2'] = 1;	
	if(trim($_POST['fname']) == '') 
		$err['fname'] = 1;
	if(trim($_POST['lname']) == '') 
		$err['lname'] = 1;
	if(trim($_POST['city']) == '') 
		$err['city'] = 1;
	if(trim($_POST['Email']) == '') 
		$err['Email'] = 1;	
	if(trim($_POST['zip']) == '') 
		$err['Zip'] = 1;	
	if($_POST['Password1'] != '' && $_POST['Password1'] != $_POST['Password2']) 
		$err['Password2'] = 1;	
	$us = mysql_numrows(mysql_query("select * from Profiles where ID<>".$_SESSION['memberID']." and Email='".mysql_escape_string($_POST['Email'])."'"));
	if($us > 0 && $_POST['Email']!='')
	{
		$add_on = "<span style=\"font-size:14px;color:#880000\"><b>Error:</b> This E-mail already use</span><br />";
		$err['Email'] = 1;	
	}
	if(empty($err))
	{
		$collge = mysql_fetch_assoc(mysql_query("select * from City where Title = '".mysql_escape_string(trim($_POST['city']))."'"));
		if(intval($collge['ID']) > 0) 
			$collgeid = intval($collge['ID']);
		else 
		{
			mysql_query("insert into City set Title='".mysql_escape_string(trim($_POST['city']))."'");
			$collgeid = mysql_insert_id();
		}
		$Photo = '';
		if( !$_FILES['Photo'] or empty( $_FILES['Photo'] ) )
			$add_on .= report_err('File not uploaded');
		else
		{
			if( $_FILES['Photo']['error'] != 0 )
				$sActionText = 'File upload error<br>';
			else
			{
				
				$aFileInfo = getimagesize( $_FILES['Photo']['tmp_name'] );
				if( !$aFileInfo )
					$sActionText = 'You uploaded not image file<br>';
				else
				{
					$ext = false;
					switch( $aFileInfo['mime'] )
					{
						case 'image/jpeg': $ext = 'jpg'; break;
						case 'image/gif':  $ext = 'gif'; break;
						case 'image/png':  $ext = 'png'; break;
					}
					
					if( !$ext )
						$sActionText = 'You uploaded not JPEG, GIF or PNG file<br>';
					else
					{
						$dir = "media/images/profile/".$_SESSION['memberID']."/";
						if(!is_dir($dir)) mkdir($dir, 0755, true);					
						if(trim($_SESSION['memberINFO']['PrimPhoto'])!='' && trim($_SESSION['memberINFO']['PrimPhoto'])!='0')	
							$newFileName = $_SESSION['memberINFO']['PrimPhoto'];	
						else				
							$newFileName = time().'.'.$ext;		
							
						if( !move_uploaded_file( $_FILES['Photo']['tmp_name'], $dir.'photo_'.$newFileName ) )
							$sActionText =  'Couldn\'t download file.';
						else
						{																								
							imageResize( $dir.'photo_'.$newFileName, $dir.'thumb_'.$newFileName,200);
							$Photo = "PrimPhoto='$newFileName',";								
						}
					}
				}
			}
		}
		mysql_query("update `Profiles` SET 		
				fname='".mysql_escape_string($_POST['fname'])."',
				lname='".mysql_escape_string($_POST['lname'])."',
				Email='".mysql_escape_string($_POST['Email'])."',
				".($_POST['Password1'] != ''?"Password='".mysql_escape_string($_POST['Password1'])."',":"")."
				zip='".mysql_escape_string($_POST['zip'])."',
				city=".$collgeid.",				
				$Photo
				LastModified=".time().",	
				intro='".mysql_escape_string($_POST['intro'])."',
				note='".mysql_escape_string($_POST['note'])."',
				altemail='".mysql_escape_string($_POST['altemail'])."',
				phone='".mysql_escape_string($_POST['phone'])."',
				cell='".mysql_escape_string($_POST['cell'])."',
				aim='".mysql_escape_string($_POST['aim'])."',
				skype='".mysql_escape_string($_POST['skype'])."',
				phone_none='".intval($_POST['phone_none'])."',
				cell_none='".intval($_POST['cell_none'])."',
				aim_none='".intval($_POST['aim_none'])."',
				altemail_none='".intval($_POST['altemail_none'])."',
				skype_none='".intval($_POST['skype_none'])."'  			
				where ID=".$_SESSION['memberID']);
				
		$_SESSION['memberINFO'] = mysql_fetch_assoc(mysql_query("select * from Profiles where ID=".$_SESSION['memberID']));
		header("location: /profile.php"); die();
	}
	
	$smarty->assign("error",  $err);
	$smarty->assign("t_error",  $add_on);
}
else 
{
	$_REQUEST = $_SESSION['memberINFO'];
	$_REQUEST['Email2'] = $_REQUEST['Email'];
	$city = mysql_fetch_assoc(mysql_query("select * from City where ID=".intval($_REQUEST['city'])));
	$_REQUEST['city'] = $city['Title'];
}

addNavigation('/profile.php','My Profile');
addNavigation('','Edit My Account Information');
$smarty->assign("site_title",  'Edit My Account Information'." :: ".$gConfig['site_title']);
$smarty->assign("HEADERTEXT",  'Edit My Account Information');
show_smarty_template('edit_user');
?>