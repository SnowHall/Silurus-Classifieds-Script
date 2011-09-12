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

$query = '';
if(is_array($_GET))
	foreach ($_GET as $key=>$val) 
		$query .= '&'.$key.'='.urlencode($val);

$postVars = "host=".urlencode($_SERVER['HTTP_HOST'])."&product=silurus".$query;
$url = "http://snowhall.com/contactus.php";
$session = curl_init($url);		
curl_setopt($session, CURLOPT_URL,$url); 
curl_setopt($session, CURLOPT_RETURNTRANSFER,true); 
curl_setopt($session, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($session, CURLOPT_POST, true);
curl_setopt($session, CURLOPT_POSTFIELDS, $postVars);
curl_setopt($session, CURLOPT_HEADER, false); 
curl_setopt($session, CURLOPT_TIMEOUT,120); 
curl_setopt($session, CURLOPT_FRESH_CONNECT, true);
curl_setopt($session, CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($session, CURLOPT_SSL_VERIFYHOST,false);	
$xml = curl_exec($session);
$serviceXML = simplexml_load_string($xml);	
if((string)$serviceXML->AnswerCode=='0')
	$ans = (string)$serviceXML->Answer;	
else
	$err = (string)$serviceXML->Answer;			

if($err!='') print 'document.getElementById("act_error").innerHTML="<font color=red><b>'.$err.'</b></font><br>";';
elseif($ans!='') print 'document.getElementById("act_content").innerHTML="<center><br><font color=green><b>'.$ans.'</b></font><br><br></center>";';
?>