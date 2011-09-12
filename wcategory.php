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
include("./include_php/TemplVotingView.php");

$oVotingView = new TemplVotingView ('gvoting', 0);

if(intval($_REQUEST['ID']) > 0)
{
	$categ = mysql_fetch_assoc(mysql_query("select * from StoreCategories where ID=".intval($_REQUEST['ID'])));
}

$q = mysql_query("select * from StoreCategories where Type=1 order by Title");
$rel_categ = array();
while($arr = mysql_fetch_assoc($q))
{
	$rel_categ[$arr['ID']] = $arr;
}	
$curUrl = '/wcategory.php?';    
$smarty->assign("rel_categ",  $rel_categ);
$smarty->assign("cur_url",  $curUrl);

if(is_array($_GET) && count($_GET)>0)
{
	foreach($_GET as $key=>$value)
		if ($key != 'border' && $key != 'bdesc')
			$curUrl .= "$key=$value&";
}
	
$order = (isset($_REQUEST['border'])?$_REQUEST['border']:'title');
$desc = (isset($_REQUEST['bdesc'])?true:false);		
$books = array('order'=>$order, 'desc'=>$desc, 'cur_url'=>$curUrl, 'prefix'=>'b', 'list'=>array());		
if($order == 'date')  {$order = 's.date';}
elseif($order == 'price')  {$order = 's.price';}
elseif($order == 'quality')  {$order = 'c.Title';}
else {$order = 's.Title';}		
if(isset($_REQUEST['bdesc'])) $order .= ' desc ';

$iDivis = 10;
$iCurr  = 1;	
if (!isset($_REQUEST['commPage']))
{
	$sLimit =  ' LIMIT 0,'.$iDivis;
}
else
{
	if($_REQUEST['commPage']<=0) $_REQUEST['commPage'] = 1;
	$iCurr = (int)$_REQUEST['commPage'];
	$sLimit =  ' LIMIT '.($iCurr - 1)*$iDivis.','.$iDivis;
}
	
$sQuery = ("select s.*,c.Title as ctitle from Store s inner join StoreCategories c on c.ID=s.categoryID where ".($_SESSION['location']['condition']!=''?'s.userID in '.$_SESSION['location']['condition'].' and ':'')." s.type=1 and  s.status=0 ".(intval($_REQUEST['ID'])>0?'and categoryID='.$_REQUEST['ID']:'')."  order by $order ");	
$rElems = mysql_query( $sQuery );		
$iNums = mysql_num_rows($rElems);	
$count = (int)($iNums/$iDivis);
if(($iNums/$iDivis) > (int)($iNums/$iDivis)) $count++;
$aPaging =  ($iNums > $iDivis ? MakePaging($iNums,$iCurr,$iDivis,4,'commPage','') : '');	

$rElems = mysql_query( $sQuery.$sLimit );
while($book = mysql_fetch_assoc($rElems))
{
	if($color == 'f5f5f5') $color = 'ffffff'; else  $color = 'f5f5f5';	
	$temp = array();
	$temp['Color'] = $color;
	$temp['ID'] = $book['ID'];
	$temp['url'] = 'javascript:void(0);" onclick="show_book_info(\''.$book['ID'].'\',this,\'2\')';
	$temp['Title'] = htmlspecialchars($book['Title']);
	$temp['Date'] = date("F jS, Y",$book['date']);
	$temp['Price'] = number_format($book['price'],2,".","");
	$temp['Vote'] = $vote1;
	$temp['ctitle'] = $book['ctitle'];
	$books['list'][] = $temp;			
}
$smarty->assign("sbooks",  $books);
$smarty->assign("aPaging",  $aPaging);

$contact_type = 1;
include("./ap_contact.php");


$HEADERTEXT='Wanted Products';
addNavigation('/wcategory.php',$HEADERTEXT);
if(isset($categ['Title'])) 
{
	addNavigation('',$categ['Title']);
	$HEADERTEXT = $categ['Title'].' :: '.$HEADERTEXT;
}
$smarty->assign("site_title",  $HEADERTEXT." :: ".$gConfig['site_title']);
$smarty->assign("HEADERTEXT",  $HEADERTEXT);
show_smarty_template('wcatalog');

?>
