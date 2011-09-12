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
 
$config = $_SERVER['DOCUMENT_ROOT']."/dbconfig.inc";
if(!is_file($config))
{
	header("location: /install.php");
	die();
}
else
{
	$config = join("",file($config));
	if(trim($config)=='')
	{
		header("location: /install.php");
		die();
	}
	else 
	{
		if(is_file($_SERVER['DOCUMENT_ROOT']."/install.php")) 
		{
			print '<center><br><br><b>Please remove install.php</b></center>';
			die();
		}
	}	
}
?>