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

$tag = trim($_GET['tag']);
$type = intval($_GET['type']);
if($tag!='')
{
	$q = mysql_query("select * from City where Title like '%".mysql_escape_string($tag)."%' order by Title");
	if(mysql_numrows($q) > 0)
	{
		print '<table width="100%" cellspacing="0" cellpadding="0">';
		while($arr = mysql_fetch_assoc($q))
		{
			$pos = strpos(strtolower($arr['Title']),strtolower($tag));
			print '<tr><td class="autoenter_class" onmouseover="this.style.background=\'eeeeee\';" onmouseout="this.style.background=\'dddddd\';" onclick="insertcity('.$type.',\''.str_replace("'","\'",$arr['Title']).'\')" align=left>'.substr($arr['Title'],0,$pos).'<b>'.substr($arr['Title'],$pos,strlen($tag)).'</b>'.substr($arr['Title'],$pos+strlen($tag)).'</td></tr>
			';
		}
		print '</table>';
	}
}
?>