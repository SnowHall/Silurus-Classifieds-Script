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

if(isset($_REQUEST['member_logout']))
{
	$_SESSION = array();
	setcookie( "rememberID", '',  time(), '/' );
    header("location: /");
    die();
}

$info = mysql_fetch_assoc(mysql_query("select * from Profiles where NickName='".mysql_escape_string($_REQUEST['ID'])."' limit 1"));   

if ( $info && $info['NickName']==$_REQUEST['ID'] && $info['Password']==md5($_REQUEST['Password']) )
{          	
	$md5id =  md5($info[ID].$info[NickName]); 
	$_SESSION['memberID'] =	 $info[ID];  
	if (isset($_POST['rememberme']))
	{			
		setcookie( "rememberID", $md5id,  time() + 3000000, '/' );		   		
	}
	$update_res = mysql_query( "UPDATE `Profiles` SET `LastLoggedIn` = NOW() WHERE `ID` = {$info['ID']}" );
	$back_url = '/profile.php';
	if(getenv("HTTP_REFERER")!='') $back_url = getenv("HTTP_REFERER");
	if($_POST['backurl']!='') $back_url = $_POST['backurl'];
	
	header("location: ".$back_url);
	die();	
}
else 
	header("location: /?loginerror");


?>