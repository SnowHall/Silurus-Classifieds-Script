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


if(isset($_GET['flag']))
{
	mysql_query("insert into Flags set date=".time().",userID=".$_SESSION['memberID'].",type=1,itemID=".intval($_REQUEST['ID']));
	header("location: /product.php?ID=".intval($_REQUEST['ID']));
}

$book = mysql_fetch_assoc(mysql_query("select * from Store where type=0 and  ID=".intval($_REQUEST['ID'])));
if(!$book || intval($book['ID']) == 0) header("location: /profile.php");
$seller = mysql_fetch_assoc(mysql_query("select * from Profiles where ID=".intval($book['userID'])));

$photos = array();
$q = mysql_query("select v.* from StorePropValues v inner join StoreProp p on p.ID=v.PropID where v.itemID=".intval($_REQUEST['ID'])." and p.Type=3");
while($arr = mysql_fetch_assoc($q))
{
	if(is_file("./media/store/small_".$arr['Value'])) {$info = getimagesize('./media/store/small_'.$arr['Value']);$photos[]=array('path'=>$arr['Value'],'width'=>($info[0]>=300?300:$info[0]),'height'=>($info[0]>=300?($info[1]*300/$info[0]):$info[1]));}
}

$book['title_short'] = (strlen($book['Title'])>40?substr(htmlspecialchars($book['Title']),0,40).'...':htmlspecialchars($book['Title']));
$book['price'] = number_format($book['price'],2,"."," ");

$q = mysql_query("select * from StoreProp where Type<>3 and categoryID=".$book['categoryID']."  order by Prior");
$props = array();
$oVotingView = new TemplVotingView ('gvoting', 0);
while($prop = mysql_fetch_assoc($q))
{
	$subitems = array();
	if($prop['Type'] > 5)
	{
		$qq = mysql_query("select n.* from StorePropMulti n inner join StorePropValues v on v.Value=n.ID where v.PropID=".intval($prop['ID'])." and v.itemID=".$book['ID']);
		while($subprop = mysql_fetch_assoc($qq))
			$subitems[] = $subprop['Name'];
		
	}
	elseif($prop['Type'] == 5)
	{
		$qq = mysql_query("select n.* from StorePropMulti n inner join StorePropValues v on v.Value=n.ID where v.PropID=".intval($prop['ID'])." and v.itemID=".$book['ID']);
		while($subprop = mysql_fetch_assoc($qq))
			$subitems = $subprop['Name'];
	}
	elseif($prop['Type'] == 4)
	{
		$qq = mysql_fetch_assoc(mysql_query("select * from StorePropValues where PropID=".intval($prop['ID'])." and itemID=".$book['ID']));
		$subitems = $qq['Value'];		
		$oVotingView->_fRate = $subitems;
		$subitems = $oVotingView->getSmallVoting (0,'');
	}
	else 
	{
		$qq = mysql_fetch_assoc(mysql_query("select * from StorePropValues where PropID=".intval($prop['ID'])." and itemID=".$book['ID']));
		$subitems = $qq['Value'];
	}
	$prop['value'] = $subitems;
	$props[] = $prop;
}
$book['props'] = $props;
$smarty->assign("categ",  mysql_fetch_assoc(mysql_query("select * from StoreCategories where ID=".$book['categoryID'])));
$smarty->assign("book",  $book);
$smarty->assign("ap_seller",  $seller);
if(!empty($photos)) $smarty->assign("photos",  $photos);

$contact_type = 1;
$smarty->assign("ap_contact_type",  $contact_type);
include("./ap_contact.php");
include("./ap_tell.php");

$HEADERTEXT='Product for Sale';
addNavigation('/category.php','Products for Sale');
addNavigation('',$book['Title']);
$smarty->assign("site_title",  $book['Title']." :: ".$gConfig['site_title']);
$smarty->assign("HEADERTEXT",  $HEADERTEXT);
show_smarty_template('product');
?>