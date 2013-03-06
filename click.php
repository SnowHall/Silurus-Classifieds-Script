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

$ID = (int)$_GET['id'];

$bann_arr = mysql_fetch_assoc(mysql_query("SELECT `ID`, `Url` FROM `Banners` WHERE `ID` = $ID LIMIT 1"));
$ID = (int)$bann_arr['ID'];
$Url = $bann_arr['Url'];

if ( $ID > 0 )
{
   $robots=array("Googlebot", "Yandex", "Aport", "StackRambler", "Slurp", "bot", "ia_archiver"); 
   $spider = 0;
   foreach($robots as $r) 
	   if(stristr($_SERVER['HTTP_USER_AGENT'],$r)!=false) 
	   	$spider=1; 	
	 if (!$spider)  
	 {
	 	$page = '';
	 	$query = getenv("HTTP_REFERER");
	 	$pos = strpos($query,".php");
	 	if($pos > 0) $page .= substr($query,0,$pos+4);
	 	$page = str_replace($site['url'],"/",$page);
	 	
	 	include("./location/geoipcity.inc");
		include("./location/geoipregionvars.php");
		include("./location/regions.php");		
		
		$gi = geoip_open( $_SERVER['DOCUMENT_ROOT']."/location/GeoLiteCity.dat", GEOIP_MEMORY_CACHE);
		$record = geoip_record_by_addr($gi,$_SERVER['REMOTE_ADDR']);
		$Country = trim($record->country_name);
		$State = $record->region;
		$City = trim($record->city);
		if(isset($regions[$State])) 
		{
			$State = $regions[$State];
			$City .= '(USA)'; 
		}
		else 
			$State = 'Not USA';
		
		geoip_close($gi);	
	
	 	mysql_query("INSERT INTO `BannersClicks` SET `ID` = $ID, `Date` = NOW(), `IP` = '". $_SERVER['REMOTE_ADDR']. "',URL='".getenv("HTTP_REFERER")."',Page='$page',Week=".date("YW").",Country='$Country',State='$State',City='$City'");
	 } 


	header ("HTTP/1.1 301 Moved Permanently");
	header ("Location: http://$Url");
	exit;
}
else
{
	echo "No such link";
}

?>