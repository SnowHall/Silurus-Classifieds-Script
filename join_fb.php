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
include("./libs/facebook_data.php");

if($_SESSION['memberID']) header("location: profile.php");


$data = getFbData();

$res = mysql_query("SELECT * FROM `Profiles` WHERE fb_id = '" . mysql_escape_string($data['id']) . "' OR (Email = '" . mysql_escape_string($data['email']) . "' AND Email != '')");
$row = mysql_fetch_assoc($res);

if ($row) {
	$_SESSION['memberID'] = $row['ID'];
	header("location: profile.php".(isset($_GET['demo'])?'?demo=1':'')); exit;
} else {
	$cl_values ="INSERT INTO `Profiles` SET
				LastModified=".time().",
				Status='Active',
				NickName='" . mysql_escape_string($data['name']) . "',
				Email='".mysql_escape_string($data['email'])."',
				Password='".md5(time())."',
				zip='',
				fname='".mysql_escape_string($data['first_name'])."',
				lname='".mysql_escape_string($data['last_name'])."',
				city='',
				intro='',
				note='',
				altemail='',
				phone='',
				cell='',
				aim='',
				skype='' 	,
				phone_none='',
				cell_none='',
				aim_none='',
				altemail_none='',
				skype_none='' ,
				fb_id='" . mysql_escape_string($data['id']) . "' ,
				LastReg = NOW()";

	mysql_query($cl_values);
  $IDnormal = mysql_insert_id();

	$_SESSION['memberID'] = $IDnormal;
	header("location: edit_user.php".(isset($_GET['demo'])?'?demo=1':'')); exit;
}
?>