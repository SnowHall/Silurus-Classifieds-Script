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

include("../include_php/admin_init.php");

$smarty->assign("site_title",  "Banners Statistic :: Admin Panel :: ".$gConfig['site_title']);
$smarty->assign("page_header_text",  "Banners Statistic");
ob_start();

print '<table width=70%><tr><td>
<b>Clicks and shows on banners: </b></td><td>(
<a href="admin/stat_banners.php?action=days&period=day">Day</a>, 
<a href="admin/stat_banners.php?action=days&period=week">Week</a>, 
<a href="admin/stat_banners.php?action=days&period=month">Month</a>)<br>
</td></tr><tr><td>
<b>Clicks and shows on banners in page:</b></td><td>(
<a href="admin/stat_banners.php?action=bpages&period=day">Day</a>, 
<a href="admin/stat_banners.php?action=bpages&period=week">Week</a>, 
<a href="admin/stat_banners.php?action=bpages&period=month">Month</a>)<br>
</td></tr><tr><td>
<b>Clicks and shows in page:</b></td><td>(
<a href="admin/stat_banners.php?action=pages&period=day">Day</b></a>, 
<a href="admin/stat_banners.php?action=pages&period=week">Week</a>, 
<a href="admin/stat_banners.php?action=pages&period=month">Month</a>)
</td></tr></table><hr>


<table width=70%><tr><td>
<b>Clicks by Country on banners:</b></td><td>(
<a href="admin/stat_banners.php?action=country&period=day">Day</a>, 
<a href="admin/stat_banners.php?action=country&period=week">Week</a>, 
<a href="admin/stat_banners.php?action=country&period=month">Month</a>)<br>
</td></tr><tr><td>
<b> Clicks by State(USA) on banners:</b></td><td>(
<a href="admin/stat_banners.php?action=state&period=day">Day</a>, 
<a href="admin/stat_banners.php?action=state&period=week">Week</a>, 
<a href="admin/stat_banners.php?action=state&period=month">Month</a>)<br>
</td></tr><tr><td>
<b>Clicks by City on banners:</b></td><td>(
<a href="admin/stat_banners.php?action=city&period=day">Day</a>, 
<a href="admin/stat_banners.php?action=city&period=week">Week</a>, 
<a href="admin/stat_banners.php?action=city&period=month">Month</a>)
</td></tr></table><hr>


<table width=70%><tr><td>
<b>Total clicks by Country:</b></td><td>(
<a href="admin/stat_banners.php?action=tcountry&period=day">Day</a>, 
<a href="admin/stat_banners.php?action=tcountry&period=week">Week</a>, 
<a href="admin/stat_banners.php?action=tcountry&period=month">Month</a>)<br>
</td></tr><tr><td>
<b>Total clicks by State(USA):</b></td><td>(
<a href="admin/stat_banners.php?action=tstate&period=day">Day</a>, 
<a href="admin/stat_banners.php?action=tstate&period=week">Week</a>, 
<a href="admin/stat_banners.php?action=tstate&period=month">Month</a>)<br>
</td></tr><tr><td>
<b>Total clicks by City:</b></td><td>(
<a href="admin/stat_banners.php?action=tcity&period=day">Day</a>, 
<a href="admin/stat_banners.php?action=tcity&period=week">Week</a>, 
<a href="admin/stat_banners.php?action=tcity&period=month">Month</a>)
</td></tr></table>
<hr>
<br>';

switch ($_GET['action'])
{
	case 'days':
		days();
	break;
	case 'bpages':
		bpages();
	break;
	case 'pages':
		pages();
	break;
	case 'country':
		country();
	break;
	case 'state':
		state();
	break;
	case 'city':
		city();
	break;
	case 'tcountry':
		tcountry();
	break;
	case 'tstate':
		tstate();
	break;
	case 'tcity':
		tcity();
	break;
}

//////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////
//////////////tcity///////////////////////////////////////
//////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////
function tcity()
{		
	global $site;
	if($_GET['period'] == 'month')
	{
		if(isset($_GET['date']))
		{
			$date = $_GET['date']; 
			$mdate = explode("-",$date);
			$m = $mdate[1];
			$y = $mdate[0];
		}
		else 
		{
			$date = date("Y-m");
			$m = date("m");
			$y = date("Y");
		}
		
		print '<a href="' . $gConfig['site_url'] . 'admin/stat_banners.php?period='.$_GET['period'].'&action=tcity&date='.date("Y-m",mktime(5,5,5,$m-1,5,$y)).'">'.date("Y-m",mktime(5,5,5,$m-1,5,$y)).'</a> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		print '<b>'.$date.'</b> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		if ($date != date("Y-m")) 
			print '<a href="' . $gConfig['site_url'] . 'admin/stat_banners.php?period='.$_GET['period'].'&action=tcity&date='.date("Y-m",mktime(5,5,5,$m+1,5,$y)).'">'.date("Y-m",mktime(5,5,5,$m+1,5,$y)).'</a> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		$cond = " Date like '{$date}%'";
	}
	elseif($_GET['period'] == 'week')
	{
		if(isset($_GET['date']))
		{
			$date = $_GET['date']; 
			$y = substr($date,0,4);
			$w = substr($date,4);
		}
		else 
		{
			$date = date("YW");
			$y = date('Y');
			$w = date('W');
		}
		
		print '<a href="' . $gConfig['site_url'] . 'admin/stat_banners.php?period='.$_GET['period'].'&action=tcity&date='.(($w-1)<1?($y-1).'52':$y.($w-1)).'">'.(($w-1)<1?'52/'.($y-1):($w-1).'/'.$y).'</a> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		print '<b>'.$w.'/'.$y.'</b> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		if ($date != date("YW")) 
			print '<a href="' . $gConfig['site_url'] . 'admin/stat_banners.php?period='.$_GET['period'].'&action=tcity&date='.(($w+1)>52?($y+1).'1':$y.($w+1)).'">'.(($w+1)>52?'1/'.($y+1):($w+1).'/'.$y).'</a> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		$cond = " Week='{$date}'";
	}
	else 
	{
		if(isset($_GET['date']))
		{
			$date = $_GET['date']; 
			$mdate = explode("-",$date);
			$d = $mdate[2];
			$m = $mdate[1];
			$y = $mdate[0];
		}
		else 
		{
			$date = date("Y-m-d");
			$d = date("d");
			$m = date("m");
			$y = date("Y");
		}
		print '<a href="' . $gConfig['site_url'] . 'admin/stat_banners.php?period='.$_GET['period'].'&action=tcity&date='.date("Y-m-d",mktime(5,5,5,$m,$d-1,$y)).'">'.date("Y-m-d",mktime(5,5,5,$m,$d-1,$y)).'</a> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		print '<b>'.$date.'</b> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		if ($date != date("Y-m-d")) 
			print '<a href="' . $gConfig['site_url'] . 'admin/stat_banners.php?period='.$_GET['period'].'&action=tcity&date='.date("Y-m-d",mktime(5,5,5,$m,$d+1,$y)).'">'.date("Y-m-d",mktime(5,5,5,$m,$d+1,$y)).'</a> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		$cond = " Date='{$date}'";
	}
		
	
	print '<br><br><table width=100%>
	<tr><td><b>Page</b></td><td><b>Clicks</b></td><td><b>Clicks from Unique IP</b></td></tr>';	
	$bannersq = mysql_query("select *,count(*) as num from BannersClicks where $cond group by City order by num desc");	
	while($bannersa = mysql_fetch_assoc($bannersq)) 
	{		
		$key = $bannersa['City'];
		$tempq = mysql_query("select * from BannersClicks where City='$key' and $cond group by IP");
		$uniq = mysql_numrows($tempq);
		print '<tr><td>'.($key==''?"Unknown":$key).'</td><td>'.$bannersa['num'].'</td><td>'.$uniq.'</td></tr>';		
		
	}	
	print '</table>';
}

//////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////
//////////////tstate///////////////////////////////////////
//////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////
function tstate()
{		
	global $site;
	if($_GET['period'] == 'month')
	{
		if(isset($_GET['date']))
		{
			$date = $_GET['date']; 
			$mdate = explode("-",$date);
			$m = $mdate[1];
			$y = $mdate[0];
		}
		else 
		{
			$date = date("Y-m");
			$m = date("m");
			$y = date("Y");
		}
		
		print '<a href="' . $gConfig['site_url'] . 'admin/stat_banners.php?period='.$_GET['period'].'&action=tstate&date='.date("Y-m",mktime(5,5,5,$m-1,5,$y)).'">'.date("Y-m",mktime(5,5,5,$m-1,5,$y)).'</a> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		print '<b>'.$date.'</b> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		if ($date != date("Y-m")) 
			print '<a href="' . $gConfig['site_url'] . 'admin/stat_banners.php?period='.$_GET['period'].'&action=tstate&date='.date("Y-m",mktime(5,5,5,$m+1,5,$y)).'">'.date("Y-m",mktime(5,5,5,$m+1,5,$y)).'</a> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		$cond = " Date like '{$date}%'";
	}
	elseif($_GET['period'] == 'week')
	{
		if(isset($_GET['date']))
		{
			$date = $_GET['date']; 
			$y = substr($date,0,4);
			$w = substr($date,4);
		}
		else 
		{
			$date = date("YW");
			$y = date('Y');
			$w = date('W');
		}
		
		print '<a href="' . $gConfig['site_url'] . 'admin/stat_banners.php?period='.$_GET['period'].'&action=tstate&date='.(($w-1)<1?($y-1).'52':$y.($w-1)).'">'.(($w-1)<1?'52/'.($y-1):($w-1).'/'.$y).'</a> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		print '<b>'.$w.'/'.$y.'</b> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		if ($date != date("YW")) 
			print '<a href="' . $gConfig['site_url'] . 'admin/stat_banners.php?period='.$_GET['period'].'&action=tstate&date='.(($w+1)>52?($y+1).'1':$y.($w+1)).'">'.(($w+1)>52?'1/'.($y+1):($w+1).'/'.$y).'</a> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		$cond = " Week='{$date}'";
	}
	else 
	{
		if(isset($_GET['date']))
		{
			$date = $_GET['date']; 
			$mdate = explode("-",$date);
			$d = $mdate[2];
			$m = $mdate[1];
			$y = $mdate[0];
		}
		else 
		{
			$date = date("Y-m-d");
			$d = date("d");
			$m = date("m");
			$y = date("Y");
		}
		print '<a href="' . $gConfig['site_url'] . 'admin/stat_banners.php?period='.$_GET['period'].'&action=tstate&date='.date("Y-m-d",mktime(5,5,5,$m,$d-1,$y)).'">'.date("Y-m-d",mktime(5,5,5,$m,$d-1,$y)).'</a> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		print '<b>'.$date.'</b> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		if ($date != date("Y-m-d")) 
			print '<a href="' . $gConfig['site_url'] . 'admin/stat_banners.php?period='.$_GET['period'].'&action=tstate&date='.date("Y-m-d",mktime(5,5,5,$m,$d+1,$y)).'">'.date("Y-m-d",mktime(5,5,5,$m,$d+1,$y)).'</a> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		$cond = " Date='{$date}'";
	}
		
	
	print '<br><br><table width=100%>
	<tr><td><b>Page</b></td><td><b>Clicks</b></td><td><b>Clicks from Unique IP</b></td></tr>';	
	$bannersq = mysql_query("select *,count(*) as num from BannersClicks where $cond group by State order by num desc");	
	while($bannersa = mysql_fetch_assoc($bannersq)) 
	{		
		$key = $bannersa['State'];
		$tempq = mysql_query("select * from BannersClicks where State='$key' and $cond group by IP");
		$uniq = mysql_numrows($tempq);
		print '<tr><td>'.($key==''?"Unknown":$key).'</td><td>'.$bannersa['num'].'</td><td>'.$uniq.'</td></tr>';		
		
	}	
	print '</table>';
}

//////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////
//////////////tcountry///////////////////////////////////////
//////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////
function tcountry()
{		
	global $site;
	if($_GET['period'] == 'month')
	{
		if(isset($_GET['date']))
		{
			$date = $_GET['date']; 
			$mdate = explode("-",$date);
			$m = $mdate[1];
			$y = $mdate[0];
		}
		else 
		{
			$date = date("Y-m");
			$m = date("m");
			$y = date("Y");
		}
		
		print '<a href="' . $gConfig['site_url'] . 'admin/stat_banners.php?period='.$_GET['period'].'&action=tcountry&date='.date("Y-m",mktime(5,5,5,$m-1,5,$y)).'">'.date("Y-m",mktime(5,5,5,$m-1,5,$y)).'</a> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		print '<b>'.$date.'</b> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		if ($date != date("Y-m")) 
			print '<a href="' . $gConfig['site_url'] . 'admin/stat_banners.php?period='.$_GET['period'].'&action=tcountry&date='.date("Y-m",mktime(5,5,5,$m+1,5,$y)).'">'.date("Y-m",mktime(5,5,5,$m+1,5,$y)).'</a> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		$cond = " Date like '{$date}%'";
	}
	elseif($_GET['period'] == 'week')
	{
		if(isset($_GET['date']))
		{
			$date = $_GET['date']; 
			$y = substr($date,0,4);
			$w = substr($date,4);
		}
		else 
		{
			$date = date("YW");
			$y = date('Y');
			$w = date('W');
		}
		
		print '<a href="' . $gConfig['site_url'] . 'admin/stat_banners.php?period='.$_GET['period'].'&action=tcountry&date='.(($w-1)<1?($y-1).'52':$y.($w-1)).'">'.(($w-1)<1?'52/'.($y-1):($w-1).'/'.$y).'</a> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		print '<b>'.$w.'/'.$y.'</b> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		if ($date != date("YW")) 
			print '<a href="' . $gConfig['site_url'] . 'admin/stat_banners.php?period='.$_GET['period'].'&action=tcountry&date='.(($w+1)>52?($y+1).'1':$y.($w+1)).'">'.(($w+1)>52?'1/'.($y+1):($w+1).'/'.$y).'</a> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		$cond = " Week='{$date}'";
	}
	else 
	{
		if(isset($_GET['date']))
		{
			$date = $_GET['date']; 
			$mdate = explode("-",$date);
			$d = $mdate[2];
			$m = $mdate[1];
			$y = $mdate[0];
		}
		else 
		{
			$date = date("Y-m-d");
			$d = date("d");
			$m = date("m");
			$y = date("Y");
		}
		print '<a href="' . $gConfig['site_url'] . 'admin/stat_banners.php?period='.$_GET['period'].'&action=tcountry&date='.date("Y-m-d",mktime(5,5,5,$m,$d-1,$y)).'">'.date("Y-m-d",mktime(5,5,5,$m,$d-1,$y)).'</a> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		print '<b>'.$date.'</b> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		if ($date != date("Y-m-d")) 
			print '<a href="' . $gConfig['site_url'] . 'admin/stat_banners.php?period='.$_GET['period'].'&action=tcountry&date='.date("Y-m-d",mktime(5,5,5,$m,$d+1,$y)).'">'.date("Y-m-d",mktime(5,5,5,$m,$d+1,$y)).'</a> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		$cond = " Date='{$date}'";
	}
		
	
	print '<br><br><table width=100%>
	<tr><td><b>Page</b></td><td><b>Clicks</b></td><td><b>Clicks from Unique IP</b></td></tr>';	
	$bannersq = mysql_query("select *,count(*) as num from BannersClicks where $cond group by Country order by num desc");	
	while($bannersa = mysql_fetch_assoc($bannersq)) 
	{		
		$key = $bannersa['Country'];
		$tempq = mysql_query("select * from BannersClicks where Country='$key' and $cond group by IP");
		$uniq = mysql_numrows($tempq);
		print '<tr><td>'.($key==''?"Unknown":$key).'</td><td>'.$bannersa['num'].'</td><td>'.$uniq.'</td></tr>';		
		
	}	
	print '</table>';
}

//////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////
//////////////city////////////////////////////////////////
//////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////
function city()
{		
	global $site;
	if($_GET['period'] == 'month')
	{
		if(isset($_GET['date']))
		{
			$date = $_GET['date']; 
			$mdate = explode("-",$date);
			$m = $mdate[1];
			$y = $mdate[0];
		}
		else 
		{
			$date = date("Y-m");
			$m = date("m");
			$y = date("Y");
		}
		
		print '<a href="' . $gConfig['site_url'] . 'admin/stat_banners.php?period='.$_GET['period'].'&action=city&date='.date("Y-m",mktime(5,5,5,$m-1,5,$y)).'">'.date("Y-m",mktime(5,5,5,$m-1,5,$y)).'</a> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		print '<b>'.$date.'</b> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		if ($date != date("Y-m")) 
			print '<a href="' . $gConfig['site_url'] . 'admin/stat_banners.php?period='.$_GET['period'].'&action=city&date='.date("Y-m",mktime(5,5,5,$m+1,5,$y)).'">'.date("Y-m",mktime(5,5,5,$m+1,5,$y)).'</a> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		$cond = " Date like '{$date}%'";
	}
	elseif($_GET['period'] == 'week')
	{
		if(isset($_GET['date']))
		{
			$date = $_GET['date']; 
			$y = substr($date,0,4);
			$w = substr($date,4);
		}
		else 
		{
			$date = date("YW");
			$y = date('Y');
			$w = date('W');
		}
		
		print '<a href="' . $gConfig['site_url'] . 'admin/stat_banners.php?period='.$_GET['period'].'&action=city&date='.(($w-1)<1?($y-1).'52':$y.($w-1)).'">'.(($w-1)<1?'52/'.($y-1):($w-1).'/'.$y).'</a> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		print '<b>'.$w.'/'.$y.'</b> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		if ($date != date("YW")) 
			print '<a href="' . $gConfig['site_url'] . 'admin/stat_banners.php?period='.$_GET['period'].'&action=city&date='.(($w+1)>52?($y+1).'1':$y.($w+1)).'">'.(($w+1)>52?'1/'.($y+1):($w+1).'/'.$y).'</a> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		$cond = " Week='{$date}'";
	}
	else 
	{
		if(isset($_GET['date']))
		{
			$date = $_GET['date']; 
			$mdate = explode("-",$date);
			$d = $mdate[2];
			$m = $mdate[1];
			$y = $mdate[0];
		}
		else 
		{
			$date = date("Y-m-d");
			$d = date("d");
			$m = date("m");
			$y = date("Y");
		}
		
		print '<a href="' . $gConfig['site_url'] . 'admin/stat_banners.php?period='.$_GET['period'].'&action=city&date='.date("Y-m-d",mktime(5,5,5,$m,$d-1,$y)).'">'.date("Y-m-d",mktime(5,5,5,$m,$d-1,$y)).'</a> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		print '<b>'.$date.'</b> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		if ($date != date("Y-m-d")) 
			print '<a href="' . $gConfig['site_url'] . 'admin/stat_banners.php?period='.$_GET['period'].'&action=city&date='.date("Y-m-d",mktime(5,5,5,$m,$d+1,$y)).'">'.date("Y-m-d",mktime(5,5,5,$m,$d+1,$y)).'</a> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		$cond = " Date='{$date}'";
	}
	
	print '<br><br><b>Click(Clicks from Unique IP)</b><br><table width=100%><tr><td><b>Page</b></td>';
	$banners = array();
	$list_banners = array();
	$tempq = mysql_query("select * from BannersClicks where $cond");		
	while($tempa = mysql_fetch_assoc($tempq))
	{
		if(!key_exists($tempa['ID'],$list_banners)) 
		{
			$ban = mysql_fetch_assoc(mysql_query("select Title from Banners where ID=".$tempa['ID']));
			if(is_array($ban))
				$list_banners[$tempa['ID']] = $ban['Title'];
		}
		
		if (!is_array($banners[$tempa['City']])) $banners[$tempa['City']] = array();
		if (!is_array($banners[$tempa['City']][$tempa['ID']])) $banners[$tempa['City']][$tempa['ID']] = array('click'=>0,'uclick'=>0,'ip'=>array());
		if(!in_array($tempa['IP'],$banners[$tempa['City']][$tempa['ID']]['ip']))
		{
			$banners[$tempa['City']][$tempa['ID']]['uclick']++;
			$banners[$tempa['City']][$tempa['ID']]['ip'][] = $tempa['IP'];
		}
		$banners[$tempa['City']][$tempa['ID']]['click']++;
	}
	
	foreach($list_banners as $key=>$val)
		print '<td><b>'.$val.'</b></td>';
	print '</tr><tr>';


	foreach($banners as $key=>$val) 
	{
		print '<tr><td>'.($key==''?'Unknown':$key).'</td>';
		foreach($list_banners as $key2=>$val2)
		{
			
			if(isset($val[$key2])) 
				print '<td>'.$val[$key2]['click'].'('.$val[$key2]['uclick'].')</td>';
			else 
				print '<td>0-0(0)</td>';
		}
		print '</tr>';
	}
	print '</table>';
	
}

//////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////
//////////////state///////////////////////////////
//////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////
function state()
{		
	global $site;
	if($_GET['period'] == 'month')
	{
		if(isset($_GET['date']))
		{
			$date = $_GET['date']; 
			$mdate = explode("-",$date);
			$m = $mdate[1];
			$y = $mdate[0];
		}
		else 
		{
			$date = date("Y-m");
			$m = date("m");
			$y = date("Y");
		}
		
		print '<a href="' . $gConfig['site_url'] . 'admin/stat_banners.php?period='.$_GET['period'].'&action=state&date='.date("Y-m",mktime(5,5,5,$m-1,5,$y)).'">'.date("Y-m",mktime(5,5,5,$m-1,5,$y)).'</a> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		print '<b>'.$date.'</b> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		if ($date != date("Y-m")) 
			print '<a href="' . $gConfig['site_url'] . 'admin/stat_banners.php?period='.$_GET['period'].'&action=state&date='.date("Y-m",mktime(5,5,5,$m+1,5,$y)).'">'.date("Y-m",mktime(5,5,5,$m+1,5,$y)).'</a> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		$cond = " Date like '{$date}%'";
	}
	elseif($_GET['period'] == 'week')
	{
		if(isset($_GET['date']))
		{
			$date = $_GET['date']; 
			$y = substr($date,0,4);
			$w = substr($date,4);
		}
		else 
		{
			$date = date("YW");
			$y = date('Y');
			$w = date('W');
		}
		
		print '<a href="' . $gConfig['site_url'] . 'admin/stat_banners.php?period='.$_GET['period'].'&action=state&date='.(($w-1)<1?($y-1).'52':$y.($w-1)).'">'.(($w-1)<1?'52/'.($y-1):($w-1).'/'.$y).'</a> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		print '<b>'.$w.'/'.$y.'</b> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		if ($date != date("YW")) 
			print '<a href="' . $gConfig['site_url'] . 'admin/stat_banners.php?period='.$_GET['period'].'&action=state&date='.(($w+1)>52?($y+1).'1':$y.($w+1)).'">'.(($w+1)>52?'1/'.($y+1):($w+1).'/'.$y).'</a> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		$cond = " Week='{$date}'";
	}
	else 
	{
		if(isset($_GET['date']))
		{
			$date = $_GET['date']; 
			$mdate = explode("-",$date);
			$d = $mdate[2];
			$m = $mdate[1];
			$y = $mdate[0];
		}
		else 
		{
			$date = date("Y-m-d");
			$d = date("d");
			$m = date("m");
			$y = date("Y");
		}
		
		print '<a href="' . $gConfig['site_url'] . 'admin/stat_banners.php?period='.$_GET['period'].'&action=state&date='.date("Y-m-d",mktime(5,5,5,$m,$d-1,$y)).'">'.date("Y-m-d",mktime(5,5,5,$m,$d-1,$y)).'</a> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		print '<b>'.$date.'</b> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		if ($date != date("Y-m-d")) 
			print '<a href="' . $gConfig['site_url'] . 'admin/stat_banners.php?period='.$_GET['period'].'&action=state&date='.date("Y-m-d",mktime(5,5,5,$m,$d+1,$y)).'">'.date("Y-m-d",mktime(5,5,5,$m,$d+1,$y)).'</a> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		$cond = " Date='{$date}'";
	}
	
	print '<br><br><b>Click(Clicks from Unique IP)</b><br><table width=100%><tr><td><b>Page</b></td>';
	$banners = array();
	$list_banners = array();
	$tempq = mysql_query("select * from BannersClicks where $cond");		
	while($tempa = mysql_fetch_assoc($tempq))
	{
		if(!key_exists($tempa['ID'],$list_banners)) 
		{
			$ban = mysql_fetch_assoc(mysql_query("select Title from Banners where ID=".$tempa['ID']));
			if(is_array($ban))
				$list_banners[$tempa['ID']] = $ban['Title'];
		}
		
		if (!is_array($banners[$tempa['State']])) $banners[$tempa['State']] = array();
		if (!is_array($banners[$tempa['State']][$tempa['ID']])) $banners[$tempa['State']][$tempa['ID']] = array('click'=>0,'uclick'=>0,'ip'=>array());
		if(!in_array($tempa['IP'],$banners[$tempa['State']][$tempa['ID']]['ip']))
		{
			$banners[$tempa['State']][$tempa['ID']]['uclick']++;
			$banners[$tempa['State']][$tempa['ID']]['ip'][] = $tempa['IP'];
		}
		$banners[$tempa['State']][$tempa['ID']]['click']++;
	}
	
	foreach($list_banners as $key=>$val)
		print '<td><b>'.$val.'</b></td>';
	print '</tr><tr>';


	foreach($banners as $key=>$val) 
	{
		print '<tr><td>'.($key==''?'Unknown':$key).'</td>';
		foreach($list_banners as $key2=>$val2)
		{
			
			if(isset($val[$key2])) 
				print '<td>'.$val[$key2]['click'].'('.$val[$key2]['uclick'].')</td>';
			else 
				print '<td>0-0(0)</td>';
		}
		print '</tr>';
	}
	print '</table>';
	
}

//////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////
//////////////country///////////////////////////////
//////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////
function country()
{		
	global $site;
	if($_GET['period'] == 'month')
	{
		if(isset($_GET['date']))
		{
			$date = $_GET['date']; 
			$mdate = explode("-",$date);
			$m = $mdate[1];
			$y = $mdate[0];
		}
		else 
		{
			$date = date("Y-m");
			$m = date("m");
			$y = date("Y");
		}
		
		print '<a href="' . $gConfig['site_url'] . 'admin/stat_banners.php?period='.$_GET['period'].'&action=country&date='.date("Y-m",mktime(5,5,5,$m-1,5,$y)).'">'.date("Y-m",mktime(5,5,5,$m-1,5,$y)).'</a> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		print '<b>'.$date.'</b> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		if ($date != date("Y-m")) 
			print '<a href="' . $gConfig['site_url'] . 'admin/stat_banners.php?period='.$_GET['period'].'&action=country&date='.date("Y-m",mktime(5,5,5,$m+1,5,$y)).'">'.date("Y-m",mktime(5,5,5,$m+1,5,$y)).'</a> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		$cond = " Date like '{$date}%'";
	}
	elseif($_GET['period'] == 'week')
	{
		if(isset($_GET['date']))
		{
			$date = $_GET['date']; 
			$y = substr($date,0,4);
			$w = substr($date,4);
		}
		else 
		{
			$date = date("YW");
			$y = date('Y');
			$w = date('W');
		}
		
		print '<a href="' . $gConfig['site_url'] . 'admin/stat_banners.php?period='.$_GET['period'].'&action=country&date='.(($w-1)<1?($y-1).'52':$y.($w-1)).'">'.(($w-1)<1?'52/'.($y-1):($w-1).'/'.$y).'</a> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		print '<b>'.$w.'/'.$y.'</b> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		if ($date != date("YW")) 
			print '<a href="' . $gConfig['site_url'] . 'admin/stat_banners.php?period='.$_GET['period'].'&action=country&date='.(($w+1)>52?($y+1).'1':$y.($w+1)).'">'.(($w+1)>52?'1/'.($y+1):($w+1).'/'.$y).'</a> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		$cond = " Week='{$date}'";
	}
	else 
	{
		if(isset($_GET['date']))
		{
			$date = $_GET['date']; 
			$mdate = explode("-",$date);
			$d = $mdate[2];
			$m = $mdate[1];
			$y = $mdate[0];
		}
		else 
		{
			$date = date("Y-m-d");
			$d = date("d");
			$m = date("m");
			$y = date("Y");
		}
		
		print '<a href="' . $gConfig['site_url'] . 'admin/stat_banners.php?period='.$_GET['period'].'&action=country&date='.date("Y-m-d",mktime(5,5,5,$m,$d-1,$y)).'">'.date("Y-m-d",mktime(5,5,5,$m,$d-1,$y)).'</a> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		print '<b>'.$date.'</b> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		if ($date != date("Y-m-d")) 
			print '<a href="' . $gConfig['site_url'] . 'admin/stat_banners.php?period='.$_GET['period'].'&action=country&date='.date("Y-m-d",mktime(5,5,5,$m,$d+1,$y)).'">'.date("Y-m-d",mktime(5,5,5,$m,$d+1,$y)).'</a> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		$cond = " Date='{$date}'";
	}
	
	print '<br><br><b>Click(Clicks from Unique IP)</b><br><table width=100%><tr><td><b>Page</b></td>';
	$banners = array();
	$list_banners = array();
	$tempq = mysql_query("select * from BannersClicks where $cond");		
	while($tempa = mysql_fetch_assoc($tempq))
	{
		if(!key_exists($tempa['ID'],$list_banners)) 
		{
			$ban = mysql_fetch_assoc(mysql_query("select Title from Banners where ID=".$tempa['ID']));
			if(is_array($ban))
				$list_banners[$tempa['ID']] = $ban['Title'];
		}
		
		if (!is_array($banners[$tempa['Country']])) $banners[$tempa['Country']] = array();
		if (!is_array($banners[$tempa['Country']][$tempa['ID']])) $banners[$tempa['Country']][$tempa['ID']] = array('click'=>0,'uclick'=>0,'ip'=>array());
		if(!in_array($tempa['IP'],$banners[$tempa['Country']][$tempa['ID']]['ip']))
		{
			$banners[$tempa['Country']][$tempa['ID']]['uclick']++;
			$banners[$tempa['Country']][$tempa['ID']]['ip'][] = $tempa['IP'];
		}
		$banners[$tempa['Country']][$tempa['ID']]['click']++;
	}
	
	foreach($list_banners as $key=>$val)
		print '<td><b>'.$val.'</b></td>';
	print '</tr><tr>';


	foreach($banners as $key=>$val) 
	{
		print '<tr><td>'.($key==''?'Unknown':$key).'</td>';
		foreach($list_banners as $key2=>$val2)
		{
			
			if(isset($val[$key2])) 
				print '<td>'.$val[$key2]['click'].'('.$val[$key2]['uclick'].')</td>';
			else 
				print '<td>0-0(0)</td>';
		}
		print '</tr>';
	}
	print '</table>';
	
}

//////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////
//////////////pages///////////////////////////////////////
//////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////
function pages()
{		
	global $site;
	if($_GET['period'] == 'month')
	{
		if(isset($_GET['date']))
		{
			$date = $_GET['date']; 
			$mdate = explode("-",$date);
			$m = $mdate[1];
			$y = $mdate[0];
		}
		else 
		{
			$date = date("Y-m");
			$m = date("m");
			$y = date("Y");
		}
		
		print '<a href="' . $gConfig['site_url'] . 'admin/stat_banners.php?period='.$_GET['period'].'&action=pages&date='.date("Y-m",mktime(5,5,5,$m-1,5,$y)).'">'.date("Y-m",mktime(5,5,5,$m-1,5,$y)).'</a> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		print '<b>'.$date.'</b> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		if ($date != date("Y-m")) 
			print '<a href="' . $gConfig['site_url'] . 'admin/stat_banners.php?period='.$_GET['period'].'&action=pages&date='.date("Y-m",mktime(5,5,5,$m+1,5,$y)).'">'.date("Y-m",mktime(5,5,5,$m+1,5,$y)).'</a> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		$cond = " Date like '{$date}%'";
	}
	elseif($_GET['period'] == 'week')
	{
		if(isset($_GET['date']))
		{
			$date = $_GET['date']; 
			$y = substr($date,0,4);
			$w = substr($date,4);
		}
		else 
		{
			$date = date("YW");
			$y = date('Y');
			$w = date('W');
		}
		
		print '<a href="' . $gConfig['site_url'] . 'admin/stat_banners.php?period='.$_GET['period'].'&action=pages&date='.(($w-1)<1?($y-1).'52':$y.($w-1)).'">'.(($w-1)<1?'52/'.($y-1):($w-1).'/'.$y).'</a> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		print '<b>'.$w.'/'.$y.'</b> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		if ($date != date("YW")) 
			print '<a href="' . $gConfig['site_url'] . 'admin/stat_banners.php?period='.$_GET['period'].'&action=pages&date='.(($w+1)>52?($y+1).'1':$y.($w+1)).'">'.(($w+1)>52?'1/'.($y+1):($w+1).'/'.$y).'</a> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		$cond = " Week='{$date}'";
	}
	else 
	{
		if(isset($_GET['date']))
		{
			$date = $_GET['date']; 
			$mdate = explode("-",$date);
			$d = $mdate[2];
			$m = $mdate[1];
			$y = $mdate[0];
		}
		else 
		{
			$date = date("Y-m-d");
			$d = date("d");
			$m = date("m");
			$y = date("Y");
		}
		print '<a href="' . $gConfig['site_url'] . 'admin/stat_banners.php?period='.$_GET['period'].'&action=pages&date='.date("Y-m-d",mktime(5,5,5,$m,$d-1,$y)).'">'.date("Y-m-d",mktime(5,5,5,$m,$d-1,$y)).'</a> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		print '<b>'.$date.'</b> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		if ($date != date("Y-m-d")) 
			print '<a href="' . $gConfig['site_url'] . 'admin/stat_banners.php?period='.$_GET['period'].'&action=pages&date='.date("Y-m-d",mktime(5,5,5,$m,$d+1,$y)).'">'.date("Y-m-d",mktime(5,5,5,$m,$d+1,$y)).'</a> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		$cond = " Date='{$date}'";
	}
		
	
	print '<br><br><table width=100%>
	<tr><td><b>Page</b></td><td><b>Clicks</b></td><td><b>Clicks from Unique IP</b></td><td><b>Shows</b></td></tr>';
	$banners = array();
	$bannersq = mysql_query("select *,count(*) as num from BannersClicks where $cond group by Page order by num desc");
	while($bannersa = mysql_fetch_assoc($bannersq)) 
	{		
		$key = $bannersa['Page'];
		$tempq = mysql_query("select * from BannersClicks where Page='$key' and $cond group by IP");
		$uniq = mysql_numrows($tempq);
		if(!key_exists($key,$banners)) $banners[$key] = array('click'=>$bannersa['num'],'uclick'=>$uniq,'shows'=>0,);
		
		
	}
	$bannersq = mysql_query("select *,count(*) as num from BannersShows where $cond group by Page order by num desc");
	while($bannersa = mysql_fetch_assoc($bannersq)) 
	{		
		$key = $bannersa['Page'];		
		if(!key_exists($key,$banners)) $banners[$key] = array('click'=>0,'uclick'=>0,'shows'=>0,);
		$banners[$key]['shows'] = $bannersa['num'];		
	}
	foreach($banners as $key=>$val)
		print '<tr><td><a href="'.$site['url'].str_replace("/","",$key).'">'.($key==''?"/":$key).'</a></td><td>'.$val['click'].'</td><td>'.$val['uclick'].'</td><td>'.$val['shows'].'</td></tr>';
	print '</table>';
}


//////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////
//////////////banner - pages///////////////////////////////
//////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////
function bpages()
{		
	global $site;
	if($_GET['period'] == 'month')
	{
		if(isset($_GET['date']))
		{
			$date = $_GET['date']; 
			$mdate = explode("-",$date);
			$m = $mdate[1];
			$y = $mdate[0];
		}
		else 
		{
			$date = date("Y-m");
			$m = date("m");
			$y = date("Y");
		}
		
		print '<a href="' . $gConfig['site_url'] . 'admin/stat_banners.php?period='.$_GET['period'].'&action=bpages&date='.date("Y-m",mktime(5,5,5,$m-1,5,$y)).'">'.date("Y-m",mktime(5,5,5,$m-1,5,$y)).'</a> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		print '<b>'.$date.'</b> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		if ($date != date("Y-m")) 
			print '<a href="' . $gConfig['site_url'] . 'admin/stat_banners.php?period='.$_GET['period'].'&action=bpages&date='.date("Y-m",mktime(5,5,5,$m+1,5,$y)).'">'.date("Y-m",mktime(5,5,5,$m+1,5,$y)).'</a> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		$cond = " Date like '{$date}%'";
	}
	elseif($_GET['period'] == 'week')
	{
		if(isset($_GET['date']))
		{
			$date = $_GET['date']; 
			$y = substr($date,0,4);
			$w = substr($date,4);
		}
		else 
		{
			$date = date("YW");
			$y = date('Y');
			$w = date('W');
		}
		
		print '<a href="' . $gConfig['site_url'] . 'admin/stat_banners.php?period='.$_GET['period'].'&action=bpages&date='.(($w-1)<1?($y-1).'52':$y.($w-1)).'">'.(($w-1)<1?'52/'.($y-1):($w-1).'/'.$y).'</a> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		print '<b>'.$w.'/'.$y.'</b> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		if ($date != date("YW")) 
			print '<a href="' . $gConfig['site_url'] . 'admin/stat_banners.php?period='.$_GET['period'].'&action=bpages&date='.(($w+1)>52?($y+1).'1':$y.($w+1)).'">'.(($w+1)>52?'1/'.($y+1):($w+1).'/'.$y).'</a> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		$cond = " Week='{$date}'";
	}
	else 
	{
		if(isset($_GET['date']))
		{
			$date = $_GET['date']; 
			$mdate = explode("-",$date);
			$d = $mdate[2];
			$m = $mdate[1];
			$y = $mdate[0];
		}
		else 
		{
			$date = date("Y-m-d");
			$d = date("d");
			$m = date("m");
			$y = date("Y");
		}
		
		print '<a href="' . $gConfig['site_url'] . 'admin/stat_banners.php?period='.$_GET['period'].'&action=bpages&date='.date("Y-m-d",mktime(5,5,5,$m,$d-1,$y)).'">'.date("Y-m-d",mktime(5,5,5,$m,$d-1,$y)).'</a> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		print '<b>'.$date.'</b> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		if ($date != date("Y-m-d")) 
			print '<a href="' . $gConfig['site_url'] . 'admin/stat_banners.php?period='.$_GET['period'].'&action=bpages&date='.date("Y-m-d",mktime(5,5,5,$m,$d+1,$y)).'">'.date("Y-m-d",mktime(5,5,5,$m,$d+1,$y)).'</a> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		$cond = " Date='{$date}'";
	}
	
	print '<br><br><b>Shows-Click(Clicks from Unique IP)</b><br><table width=100%><tr><td><b>Page</b></td>';
	$banners = array();
	$list_banners = array();
	$tempq = mysql_query("select * from BannersClicks where $cond");		
	while($tempa = mysql_fetch_assoc($tempq))
	{
		if(!key_exists($tempa['ID'],$list_banners)) 
		{
			$ban = mysql_fetch_assoc(mysql_query("select Title from Banners where ID=".$tempa['ID']));
			if(is_array($ban))
				$list_banners[$tempa['ID']] = $ban['Title'];
		}
		
		if (!is_array($banners[$tempa['Page']])) $banners[$tempa['Page']] = array();
		if (!is_array($banners[$tempa['Page']][$tempa['ID']])) $banners[$tempa['Page']][$tempa['ID']] = array('shows'=>0,'click'=>0,'uclick'=>0,'ip'=>array());
		if(!in_array($tempa['IP'],$banners[$tempa['Page']][$tempa['ID']]['ip']))
		{
			$banners[$tempa['Page']][$tempa['ID']]['uclick']++;
			$banners[$tempa['Page']][$tempa['ID']]['ip'][] = $tempa['IP'];
		}
		$banners[$tempa['Page']][$tempa['ID']]['click']++;
	}
	$tempq = mysql_query("select * from BannersShows where $cond");		
	while($tempa = mysql_fetch_assoc($tempq))
	{
		if(!key_exists($tempa['ID'],$list_banners)) 
		{
			$ban = mysql_fetch_assoc(mysql_query("select Title from Banners where ID=".$tempa['ID']));
			if(is_array($ban))
				$list_banners[$tempa['ID']] = $ban['Title'];
		}
		
		if (!is_array($banners[$tempa['Page']])) $banners[$tempa['Page']] = array();
		if (!is_array($banners[$tempa['Page']][$tempa['ID']])) $banners[$tempa['Page']][$tempa['ID']] = array('shows'=>0,'click'=>0,'uclick'=>0,'ip'=>array());
		$banners[$tempa['Page']][$tempa['ID']]['shows']++;
	}
	foreach($list_banners as $key=>$val)
		print '<td><b>'.$val.'</b></td>';
	print '</tr><tr>';


	foreach($banners as $key=>$val) 
	{
		print '<tr><td><a href="'.$site['url'].str_replace("/","",$key).'">'.($key==''?'/':$key).'</a></td>';
		foreach($list_banners as $key2=>$val2)
		{
			
			if(isset($val[$key2])) 
				print '<td>'.$val[$key2]['shows'].'-'.$val[$key2]['click'].'('.$val[$key2]['uclick'].')</td>';
			else 
				print '<td>0-0(0)</td>';
		}
		print '</tr>';
	}
	print '</table>';
	
}


//////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////
//////////////days///////////////////////////////////////
//////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////
function days()
{		
	global $gConfig;		
	if($_GET['period'] == 'month')
	{
		if(isset($_GET['date']))
		{
			$date = $_GET['date']; 
			$mdate = explode("-",$date);
			$m = $mdate[1];
			$y = $mdate[0];
		}
		else 
		{
			$date = date("Y-m");
			$m = date("m");
			$y = date("Y");
		}
		
		print '<a href="' . $gConfig['site_url'] . 'admin/stat_banners.php?period='.$_GET['period'].'&action=days&date='.date("Y-m",mktime(5,5,5,$m-1,5,$y)).'">'.date("Y-m",mktime(5,5,5,$m-1,5,$y)).'</a> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		print '<b>'.$date.'</b> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		if ($date != date("Y-m")) 
			print '<a href="' . $gConfig['site_url'] . 'admin/stat_banners.php?period='.$_GET['period'].'&action=days&date='.date("Y-m",mktime(5,5,5,$m+1,5,$y)).'">'.date("Y-m",mktime(5,5,5,$m+1,5,$y)).'</a> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		$cond = " Date like '{$date}%'";
	}
	elseif($_GET['period'] == 'week')
	{
		if(isset($_GET['date']))
		{
			$date = $_GET['date']; 
			$y = substr($date,0,4);
			$w = substr($date,4);
		}
		else 
		{
			$date = date("YW");
			$y = date('Y');
			$w = date('W');
		}
		
		print '<a href="' . $gConfig['site_url'] . 'admin/stat_banners.php?period='.$_GET['period'].'&action=days&date='.(($w-1)<1?($y-1).'52':$y.($w-1)).'">'.(($w-1)<1?'52/'.($y-1):($w-1).'/'.$y).'</a> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		print '<b>'.$w.'/'.$y.'</b> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		if ($date != date("YW")) 
			print '<a href="' . $gConfig['site_url'] . 'admin/stat_banners.php?period='.$_GET['period'].'&action=days&date='.(($w+1)>52?($y+1).'1':$y.($w+1)).'">'.(($w+1)>52?'1/'.($y+1):($w+1).'/'.$y).'</a> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		$cond = " Week='{$date}'";
	}
	else 
	{
		if(isset($_GET['date']))
		{
			$date = $_GET['date']; 
			$mdate = explode("-",$date);
			$d = $mdate[2];
			$m = $mdate[1];
			$y = $mdate[0];
		}
		else 
		{
			$date = date("Y-m-d");
			$d = date("d");
			$m = date("m");
			$y = date("Y");
		}
		
		print '<a href="' . $gConfig['site_url'] . 'admin/stat_banners.php?period='.$_GET['period'].'&action=days&date='.date("Y-m-d",mktime(5,5,5,$m,$d-1,$y)).'">'.date("Y-m-d",mktime(5,5,5,$m,$d-1,$y)).'</a> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		print '<b>'.$date.'</b> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		if ($date != date("Y-m-d")) 
			print '<a href="' . $gConfig['site_url'] . 'admin/stat_banners.php?period='.$_GET['period'].'&action=days&date='.date("Y-m-d",mktime(5,5,5,$m,$d+1,$y)).'">'.date("Y-m-d",mktime(5,5,5,$m,$d+1,$y)).'</a> &nbsp;&nbsp;|&nbsp;&nbsp; ';
		$cond = " Date='{$date}'";
	}
	
	print '<br><br><table width=100%>
	<tr><td><b>Banner</b></td><td><b>Clicks</b></td><td><b>Clicks from Unique IP</b></td><td><b>Shows</b></td></tr>';
	$bannersq = mysql_query("select * from Banners");
	while($bannersa = mysql_fetch_assoc($bannersq)) 
	{
		$tempq = mysql_query("select * from BannersShows where ID={$bannersa['ID']} and $cond");
		$numshows = mysql_numrows($tempq);
		$tempq = mysql_query("select * from BannersClicks where ID={$bannersa['ID']} and $cond");
		$numclicks = mysql_numrows($tempq);
		$tempq = mysql_query("select * from BannersClicks where ID={$bannersa['ID']} and $cond group by IP");
		$numclicksq = mysql_numrows($tempq);
		print '<tr><td>'.$bannersa['Title'].'</td><td>'.$numclicks.'</td><td>'.$numclicksq.'</td><td>'.$numshows.'</td></tr>';
	}
	print '</table>';	
}

$smarty->assign("page_content",  ob_get_clean());
$smarty->display('index.tpl');
?>