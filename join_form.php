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

include("./include_php/init.php");

if($_SESSION['memberID']) header("location: profile.php");

$enable_security_image = $_SERVER['enable_security_image'];

if($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_REQUEST['banid']))
{

	$add_on = '';

	require_once './simg/securimage.php';
    $image = new Securimage();
	if ($image->check($_POST['securityImageValue']) == false) {
      $add_on .= report_err ( "Incorrect secret image value");
      $err['securityImageValue'] = 1;
    }

	/*if($_POST['Email'] != $_POST['Email2'])
	{
		$add_on .= report_err('Email and confirm not similar');
		$err['Email2'] = 1;
	}*/
	if(trim($_POST['Password1']) == '')
	{
		$add_on .= report_err('Enter Password');
		$err['Password1'] = 1;
	}
	if(trim($_POST['NickName']) == '')
	{
		$add_on .= report_err('Enter NickName');
		$err['NickName'] = 1;
	}
	/*if(strpos($_POST['NickName'], '@') !== '@')
	{
		$add_on .= report_err('Incorrect NickName');
		$err['NickName'] = 1;
	}*/
	if(trim($_POST['Email']) == '')
	{
		$add_on .= report_err('Enter Email');
		$err['Email'] = 1;
	}
	/*if(trim($_POST['Zip']) == '')
	{
		$add_on .= report_err('Enter zip');
		$err['Zip'] = 1;
	}*/
	if($_POST['Password1'] != $_POST['Password2'])
	{
		$add_on .= report_err('Password and confirm not similar');
		$err['Password2'] = 1;
	}
	if(!isset($_POST['terms']))
	{
		$add_on .= report_err('Please agree with terms');
		$err['terms'] = 1;
	}
	/*if(trim($_POST['fname']) == '')
	{
		$add_on .= report_err('Enter First Name');
		$err['fname'] = 1;
	}
	if(trim($_POST['lname']) == '')
	{
		$add_on .= report_err('Enter Last Name');
		$err['lname'] = 1;
	}
	if(trim($_POST['city']) == '')
	{
		$add_on .= report_err('Enter City');
		$err['city'] = 1;
	}*/

	$us = mysql_numrows(mysql_query("select * from Profiles where NickName='".mysql_escape_string($_POST['NickName'])."'"));
	if($us > 0)
	{
		$add_on.= report_err("This NickName already use");
		$err['NickName'] = 1;
	}
	$us = mysql_numrows(mysql_query("select * from Profiles where Email='".mysql_escape_string($_POST['Email'])."'"));
	if($us > 0 && $_POST['Email']!='')
	{
		$add_on.= report_err("This E-mail already use");
		$err['Email'] = 1;
	}
	if($_SERVER['REQUEST_METHOD']!='POST') $add_on = '';


	if(trim($add_on)=='')
	{

		$collge = mysql_fetch_assoc(mysql_query("select * from City where Title = '".mysql_escape_string(trim($_POST['city']))."'"));
		if(intval($collge['ID']) > 0)
			$collgeid = intval($collge['ID']);
		else
		{
			mysql_query("insert into City set Title='".mysql_escape_string(trim($_POST['city']))."'");
			$collgeid = mysql_insert_id();
		}
		$cl_values ="INSERT INTO `Profiles` SET
            LastLoggedIn=NOW(),
						LastModified=".time().",
						Status='Active',
						NickName='".mysql_escape_string($_POST['NickName'])."',
						Email='".mysql_escape_string($_POST['Email'])."',
						Password='".md5($_POST['Password1'])."',
						zip='".mysql_escape_string($_POST['Zip'])."',
						fname='".mysql_escape_string($_POST['fname'])."',
						lname='".mysql_escape_string($_POST['lname'])."',
						city=".$collgeid.",
						$Photo
						intro='".mysql_escape_string($_POST['intro'])."',
						note='".mysql_escape_string($_POST['note'])."',
						altemail='".mysql_escape_string($_POST['altemail'])."',
						phone='".mysql_escape_string($_POST['phone'])."',
						cell='".mysql_escape_string($_POST['cell'])."',
						aim='".mysql_escape_string($_POST['aim'])."',
						skype='".mysql_escape_string($_POST['skype'])."' 	,
						phone_none='".intval($_POST['phone_none'])."',
						cell_none='".intval($_POST['cell_none'])."',
						aim_none='".intval($_POST['aim_none'])."',
						altemail_none='".intval($_POST['altemail_none'])."',
						skype_none='".intval($_POST['skype_none'])."' ,
						LastReg = NOW()";

		mysql_query($cl_values);
		$IDnormal = mysql_insert_id();
		if($IDnormal > 0)
		{
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
							$dir = "media/images/profile/".$IDnormal."/";
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
								mysql_query("update Profiles set PrimPhoto='$newFileName' where ID=".$IDnormal);
							}
						}
					}
				}
			}
			$_SESSION['memberID'] = $IDnormal;
			header("location: profile.php");
		}
	}
	$smarty->assign("error",  $err);
	$smarty->assign("t_error",  $add_on);
}


function report_err( $str )
{
    return "<span style=\"font-size:18px;color:#880000\"><b>" . ( "Error" ) . ":</b> $str</span><br />";
}


$HEADERTEXT = 'Join Now';

addNavigation('',$HEADERTEXT);

$smarty->assign("site_title",  $HEADERTEXT." :: ".$gConfig['site_title']);
$smarty->assign("HEADERTEXT",  $HEADERTEXT);

show_smarty_template('join');
?>