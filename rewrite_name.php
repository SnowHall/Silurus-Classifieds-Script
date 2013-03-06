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

@list($url, $vars) = explode('?', $_SERVER['REQUEST_URI']);
if( $url == '/' )
{
	require_once('index.php');
	exit;
}


$urlArr = explode('/', $_SERVER['REQUEST_URI']);
$rewriteNick = (strlen(trim($urlArr[count($urlArr) - 1])) ? $urlArr[count($urlArr) - 1] : $urlArr[count($urlArr) - 2]);
if ( !get_magic_quotes_gpc() )
{
	$rewriteNick = addslashes($rewriteNick);
}

include("./include_php/init.php");

$sRequest = "SELECT `ID`,`NickName` FROM `Profiles` WHERE NickName='{$rewriteNick}'";
$profArr = mysql_fetch_assoc(mysql_query( $sRequest ));

if ($profArr)
{
	header( 'location: profile.php?ID='.$profArr['ID'] );
	exit();
}
else
{
	header("HTTP/1.0 404 Not Found");
	header("Status: 404 Not Found");
	echo "Page not found $tmp";
}

?>
