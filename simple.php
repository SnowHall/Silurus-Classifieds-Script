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


if(intval($_GET['ID']) > 0)
{
	$page = mysql_fetch_assoc(mysql_query("select * from Simple where ID=".intval($_GET['ID'])));
	if($page)
	{
		$HEADERTEXT = $page['Title'];
		$ret = ($page['Text']);	
	}
	else 
	{
		$HEADERTEXT = 'Error';
		$ret = '<div align=center><br><br><br>Page not found.</div>';
	}
}
else 
{
	$HEADERTEXT = 'Error';
	$ret = '<div align=center><br><br><br>Page not found.</div>';
}


$smarty->assign("content",  $ret);

addNavigation('',$HEADERTEXT);
$smarty->assign("site_title",  $HEADERTEXT." :: ".$gConfig['site_title']);
$smarty->assign("HEADERTEXT",  $HEADERTEXT);

show_smarty_template('simple');

?>