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




if(isset($_GET['faq']))
{
	$HEADERTEXT = 'Frequently Asked Questions';
	$text = array();
	$q = mysql_query("select * from FAQ where ID>0 order by Title");
	while($arr = mysql_fetch_assoc($q))
	{
		$text[] = $arr;
	}

	$smarty->assign("link_url",  'faq');
	$smarty->assign("content",  $text);
}
elseif(isset($_GET['ttips']))
{
	$HEADERTEXT = 'Technical Tips';
	$text = array();
	$q = mysql_query("select * from TTips where ID>0 order by Title");
	while($arr = mysql_fetch_assoc($q))
	{
		$text[] = $arr;
	}
		
	$smarty->assign("link_url",  'ttips');
	$smarty->assign("content",  $text);
}
elseif(isset($_GET['stips']))
{
	$HEADERTEXT = 'Tips for Sellers';
	$text = array();
	$q = mysql_query("select * from STips where ID>0 order by Title");
	while($arr = mysql_fetch_assoc($q))
	{
		$text[] = $arr;
	}
	
	$smarty->assign("link_url",  'stips');
	$smarty->assign("content",  $text);
}
else 
{
	$HEADERTEXT = 'Help';
		
	$text = array();
	$arr = mysql_fetch_assoc(mysql_query("select * from FAQ where ID=-1"));
	$text[] = $arr;
	$arr = mysql_fetch_assoc(mysql_query("select * from TTips where ID=-1"));
	$text[] = $arr;
	$arr = mysql_fetch_assoc(mysql_query("select * from STips where ID=-1"));
	$text[] = $arr;
	$arr = mysql_fetch_assoc(mysql_query("select * from FAQ where ID=-2"));
	$text[] = $arr;
	
	$ret .= '
	<span class="faq_header">'.$text[0]['Title'].'</span><br />
	'.$text[0]['Text'].'<Br />
	<a href="/faq.php?faq" class="faq_links"><img src="/img/arr.gif" border="0" /> See Full list of FAQs</a><br /><br />
	
	<span class="faq_header">'.$text[1]['Title'].'</span><br />
	'.$text[1]['Text'].'<Br />
	<a href="/faq.php?ttips" class="faq_links"><img src="/img/arr.gif" border="0" /> Read Technical Tips</a><br /><br />
	
	<span class="faq_header">'.$text[2]['Title'].'</span><br />
	'.$text[2]['Text'].'<Br />
	<a href="/faq.php?stips" class="faq_links"><img src="/img/arr.gif" border="0" /> See More Tips</a><br /><br />
	
	<span class="faq_header">'.$text[3]['Title'].'</span><br />
	'.$text[3]['Text'].'<Br />
	<a href="/simple.php?ID=5" class="faq_links"><img src="/img/arr.gif" border="0" /> Contact us at Dumpthatbook.com</a><br /><br />
	';	
	
	$smarty->assign("content_g",  $text);
}

addNavigation('',$HEADERTEXT);
$smarty->assign("site_title",  $HEADERTEXT." :: ".$gConfig['site_title']);
$smarty->assign("HEADERTEXT",  $HEADERTEXT);

show_smarty_template('faq');
?>