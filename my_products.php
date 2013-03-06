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
include("./include_php/TemplVotingView.php");

$profileID = intval( $_REQUEST['ID'] );
if($profileID==0) $profileID = $_SESSION['memberID'];
if($profileID == 0) header("location: index.php");

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	if(is_array($_POST['delbook']))
		foreach ($_POST['delbook'] as $val)
		{
			mysql_query("update Store set status=1 where userID=".$_SESSION['memberID']." and ID=".intval($val));
		}
}

if(intval($_REQUEST['bookID']) > 0)
{
	mysql_query("update Store set status=0,date=".time()." where userID=".$_SESSION['memberID']." and ID=".intval($_REQUEST['bookID']));
}

$user = mysql_fetch_assoc(mysql_query("select * from Profiles where ID=".$profileID));
$smarty->assign("user",  $user);

if(isset($_SESSION['booklist'][$profileID]['active']) && $_SESSION['booklist'][$profileID]['active'] == 1)
{
	$smarty->assign("active",  false);
}
else
	$smarty->assign("active",  true);

if(isset($_SESSION['booklist'][$profileID]['del']) && $_SESSION['booklist'][$profileID]['del'] == 1)
{
	$smarty->assign("deleted",  false);
}
else
	$smarty->assign("deleted",  true);

if($profileID == $_SESSION['memberID'])
	$smarty->assign("show_action",  true);

$oVotingView = new TemplVotingView ('gvoting', 0);


$order = (isset($_REQUEST['border'])?$_REQUEST['border']:'title');
$desc = (isset($_REQUEST['bdesc'])?true:false);
$books = array('order'=>$order, 'desc'=>$desc, 'cur_url'=>'my_products.php?ID='.$profileID, 'prefix'=>'b', 'list'=>array());
if($profileID == $_SESSION['memberID'])
{
	$books['show_action1'] = 'edit_product.php';
	$books['show_action2'] = 'delete';
    $books['show_action3'] = 'featured_product.php';
}

if($order == 'date')  {$order = 's.date';}
elseif($order == 'price')  {$order = 's.price';}
elseif($order == 'quality')  {$order = 'c.Title';}
else {$order = 's.Title';}
if(isset($_REQUEST['bdesc'])) $order .= ' desc ';

$iDivis = 10;
$iCurr  = 1;
if (!isset($_REQUEST['commPage1']))
{
	$sLimit =  ' LIMIT 0,'.$iDivis;
}
else
{
	if($_REQUEST['commPage1']<=0) $_REQUEST['commPage1'] = 1;
	$iCurr = (int)$_REQUEST['commPage1'];
	$sLimit =  ' LIMIT '.($iCurr - 1)*$iDivis.','.$iDivis;
}

$sQuery = ("select s.*,c.Title as ctitle from Store s inner join StoreCategories c on c.ID=s.categoryID where s.type=0 and  s.status=0 and s.userID=$profileID  order by $order ");
$rElems = mysql_query( $sQuery );
$iNums = mysql_num_rows($rElems);
$count = (int)($iNums/$iDivis);
if(($iNums/$iDivis) > (int)($iNums/$iDivis)) $count++;
$aPaging =  ($iNums > $iDivis ? MakePaging($iNums,$iCurr,$iDivis,4,'commPage1','#sale') : '');

$rElems = mysql_query( $sQuery.$sLimit );
while($book = mysql_fetch_assoc($rElems))
{
	if($color == 'f5f5f5') $color = 'ffffff'; else  $color = 'f5f5f5';

	$temp = array();
	$temp['Color'] = $color;
	$temp['ID'] = $book['ID'];
	$temp['url'] = 'product.php?ID='.$book['ID'];
	$temp['Title'] = htmlspecialchars($book['Title']);
	$temp['Date'] = date("F jS, Y",$book['date']);
	$temp['Price'] = number_format($book['price'],2,".","");
	$temp['Vote'] = $vote1;
	$temp['ctitle'] = $book['ctitle'];
	$books['list'][] = $temp;
}
$smarty->assign("sbooks",  $books);
$smarty->assign("aPaging1",  $aPaging);



if($profileID == $_SESSION['memberID'])
{
	$order = (isset($_REQUEST['dorder'])?$_REQUEST['dorder']:'title');
	$desc = (isset($_REQUEST['ddesc'])?true:false);
	$books = array('order'=>$order, 'desc'=>$desc, 'cur_url'=>'my_products.php?ID='.$profileID, 'prefix'=>'d', 'list'=>array());
	if($profileID == $_SESSION['memberID'])
	{
		$books['show_action1'] = '';
		$books['show_action2'] = 'repost';
	}

	if($order == 'date')  {$order = 'date';}
	elseif($order == 'price')  {$order = 'price';}
	elseif($order == 'quality')  {$order = 'rating';}
	else {$order = 'Title';}
	if(isset($_REQUEST['ddesc'])) $order .= ' desc ';

	$iDivis = 10;
	$iCurr  = 1;
	if (!isset($_REQUEST['commPage2']))
	{
		$sLimit =  ' LIMIT 0,'.$iDivis;
	}
	else
	{
		if($_REQUEST['commPage2']<=0) $_REQUEST['commPage2'] = 1;
		$iCurr = (int)$_REQUEST['commPage2'];
		$sLimit =  ' LIMIT '.($iCurr - 1)*$iDivis.','.$iDivis;
	}

	$sQuery = ("select s.*,c.Title as ctitle from Store s inner join StoreCategories c on c.ID=s.categoryID where s.type=0 and  s.status=1 and s.userID=$profileID  order by $order ");
	$rElems = mysql_query( $sQuery );
	$iNums = mysql_num_rows($rElems);
	$count = (int)($iNums/$iDivis);
	if(($iNums/$iDivis) > (int)($iNums/$iDivis)) $count++;
	$aPaging =  ($iNums > $iDivis ? MakePaging($iNums,$iCurr,$iDivis,4,'commPage2','#del') : '');

	$rElems = mysql_query( $sQuery.$sLimit );
	while($book = mysql_fetch_assoc($rElems))
	{
		$oVotingView->_fRate = $book['rating'];
		$vote1 = $oVotingView->getSmallVoting (0,'');
		if($color == 'f5f5f5') $color = 'ffffff'; else  $color = 'f5f5f5';

		$temp = array();
		$temp['Color'] = $color;
		$temp['ID'] = $book['ID'];
		$temp['url'] = 'product.php?ID='.$book['ID'];
		$temp['Title'] = htmlspecialchars($book['Title']);
		$temp['Date'] = date("F jS, Y",$book['date']);
		$temp['Price'] = number_format($book['price'],2,".","");
		$temp['Vote'] = $vote1;
		$temp['ctitle'] = $book['ctitle'];
		$books['list'][] = $temp;
	}
	$smarty->assign("dbooks",  $books);
	$smarty->assign("aPaging2",  $aPaging);

}


if($profileID == $_SESSION['memberID'])
	addNavigation('profile.php?ID='.$user['ID'],'My Profile');
else
	addNavigation('profile.php?ID='.$user['ID'],$user['fname'].' '.$user['lname']);

$HEADERTEXT='Products for Sale';
addNavigation('',$HEADERTEXT);
$smarty->assign("site_title",  $HEADERTEXT." :: ".$gConfig['site_title']);
$smarty->assign("HEADERTEXT",  $HEADERTEXT);
show_smarty_template('my_products');
?>
