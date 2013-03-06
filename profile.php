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

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['review_name']))
{
	if(trim($_POST['review_name'])!='' && trim($_POST['review_text'])!='' && $profileID != $_SESSION['memberID'])
	{
		if($_POST['review_rating']<1 || $_POST['review_rating']>5) $_POST['review_rating'] = 1;
		$rating = mysql_fetch_assoc(mysql_query("select * from ProfilesRating where userID=".intval($_SESSION['memberID'])." and voteID=$profileID"));
		mysql_query("insert into ProfilesRating set userID=".intval($_SESSION['memberID']).",voteID=$profileID,Title='".mysql_escape_string($_POST['review_name'])."',Text='".mysql_escape_string($_POST['review_text'])."',date=".time().",rating=".(intval($rating['rating'])>0?intval($rating['rating']):intval($_POST['review_rating'])));
		if(intval($rating['rating'])==0)
		{
			mysql_query("update Profiles set rating=(rating*(rating_count)+".intval($_POST['review_rating']).")/(rating_count+1),rating_count=rating_count+1 where ID=".intval($_REQUEST['ID']));
		}
	}
	header("location: profile.php?ID=".$profileID);
}

if(isset($_GET['flag']))
{
	mysql_query("insert into Flags set date=".time().",userID=".$_SESSION['memberID'].",type=0,itemID=".intval($_REQUEST['ID']));
	header("location: profile.php?ID=".intval($_REQUEST['ID']));
}

if($profileID != $_SESSION['memberID'])
	$user = mysql_fetch_assoc(mysql_query("select * from Profiles where ID=".$profileID));
else
	$user = $_SESSION['memberINFO'];

$seller = $user;
$prof_photo = 'media/images/profile/'.$user['ID'].'/thumb_' . $user['PrimPhoto'];
if( is_file( $prof_photo ) )
{
	$fileinfo = getimagesize($prof_photo);
	$prof_photo = array("src"=>$prof_photo,"width"=>$fileinfo[0]);
	$smarty->assign("prof_photo",  $prof_photo);
}

$oVotingView = new TemplVotingView ('gvoting', 0);
$votecount = intval($user['rating_count']);
$oVotingView->_fRate = $user['rating'];
$vote1 = $oVotingView->getSmallVoting (0,intval($votecount).' votes');

$rating = mysql_fetch_assoc(mysql_query("select * from ProfilesRating where userID=".intval($_SESSION['memberID'])." and voteID=$profileID"));
$oVotingView->_fRate = intval($rating['rating'])>0?intval($rating['rating']):'1';
$voter = '<input type="hidden" name="review_rating" id="gvotingbig" value="'.(intval($rating['rating'])>0?intval($rating['rating']):'1').'">'.$oVotingView->getBigVoting (intval($rating['rating'])>0?'0':'1','');

$user['LastLoggedIn'] = ($user['LastLoggedIn']?date("d-m-Y H:i",strtotime($user['LastLoggedIn'])):"Never");
$user['city'] = mysql_fetch_assoc(mysql_query("select * from City where ID=".intval($user['city'])));
$user['city'] = $user['city']['Title'];
$balance = mysql_fetch_assoc(mysql_query("SELECT `balance` FROM `Profiles` WHERE `ID`=".$_SESSION['memberID']));
$user['balance'] = $balance['balance'];
$smarty->assign("user",  $user);
$smarty->assign("ap_seller",  $seller);
$smarty->assign("vote1",  $vote1);
$smarty->assign("voter",  $voter);


$order = (isset($_REQUEST['border'])?$_REQUEST['border']:'title');
$desc = (isset($_REQUEST['bdesc'])?true:false);
$books = array('order'=>$order, 'desc'=>$desc, 'cur_url'=>'profile.php?ID='.$profileID, 'prefix'=>'b', 'list'=>array());

if($order == 'date')  {$order = 's.date';}
elseif($order == 'price')  {$order = 's.price';}
elseif($order == 'quality')  {$order = 'c.Title';}
else {$order = 's.Title';}
if(isset($_REQUEST['bdesc'])) $order .= ' desc ';

$q = mysql_query("select s.*,c.Title as ctitle from Store s inner join StoreCategories c on c.ID=s.categoryID where s.type=0 and  s.status=0 and s.userID=$profileID  order by $order limit 8");
while($book = mysql_fetch_assoc($q))
{
	if($color == 'f5f5f5') $color = 'ffffff'; else  $color = 'f5f5f5';

	$temp = array();
	$temp['Color'] = $color;
	$temp['url'] = 'product.php?ID='.$book['ID'];
	$temp['Title'] = htmlspecialchars($book['Title']);
	$temp['Date'] = date("F jS, Y",$book['date']);
	$temp['Price'] = number_format($book['price'],2,".","");
	$temp['Vote'] = $vote1;
	$temp['ctitle'] = $book['ctitle'];
	$books['list'][] = $temp;
}
$smarty->assign("sbooks",  $books);


$order = (isset($_REQUEST['worder'])?$_REQUEST['worder']:'title');
$desc = (isset($_REQUEST['wdesc'])?true:false);
$books = array('order'=>$order, 'desc'=>$desc, 'cur_url'=>'profile.php?ID='.$profileID, 'prefix'=>'w', 'list'=>array());

if($order == 'date')  {$order = 's.date';}
elseif($order == 'price')  {$order = 's.price';}
elseif($order == 'quality')  {$order = 'c.Title';}
else {$order = 's.Title';}
if(isset($_REQUEST['wdesc'])) $order .= ' desc ';

$q = mysql_query("select s.*,c.Title as ctitle from Store s inner join StoreCategories c on c.ID=s.categoryID where s.type=1 and  s.status=0 and s.userID=$profileID  order by $order limit 8");
while($book = mysql_fetch_assoc($q))
{
	if($color == 'f5f5f5') $color = 'ffffff'; else  $color = 'f5f5f5';

	$temp = array();
	$temp['Color'] = $color;
	$temp['url'] = 'wproduct.php?ID='.$book['ID'];
	$temp['Title'] = htmlspecialchars($book['Title']);
	$temp['Date'] = date("F jS, Y",$book['date']);
	$temp['Price'] = number_format($book['price'],2,".","");
	$temp['Vote'] = $vote1;
	$temp['ctitle'] = $book['ctitle'];
	$books['list'][] = $temp;
}
$smarty->assign("wbooks",  $books);


$iDivis = 10;
$iCurr  = 1;
if (!isset($_GET['commPage']))
{
	$sLimit =  ' LIMIT 0,'.$iDivis;
}
else
{
	if($_GET['commPage']<=0) $_GET['commPage'] = 1;
	$iCurr = (int)$_GET['commPage'];
	$sLimit =  ' LIMIT '.($iCurr - 1)*$iDivis.','.$iDivis;
}

$sQuery = "select r.*,p.fname,p.lname,p.ID as pid from ProfilesRating r inner join Profiles p on p.ID=r.userID where r.voteID=$profileID order by p.ID desc";
$rElems = mysql_query( $sQuery );
$iNums = mysql_num_rows($rElems);
$count = (int)($iNums/$iDivis);
if(($iNums/$iDivis) > (int)($iNums/$iDivis)) $count++;
$aPaging =  ($iNums > $iDivis ? MakePaging($iNums,$iCurr,$iDivis,4,'commPage','#reviews') : '');
$rElems = mysql_query( $sQuery.$sLimit );
$rews = array();
while($arr = mysql_fetch_assoc($rElems))
{
	$oVotingView->_fRate = $arr['rating'];
	$vote1 = $oVotingView->getSmallVoting (0,'');
	$temp['Title'] = htmlspecialchars($arr['Title']);
	$temp['Text'] = htmlspecialchars($arr['Text']);
	$temp['Author_url'] = 'profile.php?ID='.$arr['pid'];
	$temp['Author'] = $arr['fname'].' '.$arr['lname'];
	$temp['Date'] = date("d/m/Y",$arr['date']);
	$temp['Vote'] = $vote1;
	$rews[] = $temp;
}
$smarty->assign("aRews",  $rews);
$smarty->assign("aPaging",  $aPaging);

$contact_type = 1;
$smarty->assign("ap_contact_type",  $contact_type);

include("ap_contact.php");

if($profileID == $_SESSION['memberID'])
	$HEADERTEXT = 'My Profile';
else
	$HEADERTEXT = $user['fname'].' '.$user['lname'];

addNavigation('',$HEADERTEXT);

$smarty->assign("site_title",  $HEADERTEXT." :: ".$gConfig['site_title']);
$smarty->assign("HEADERTEXT",  $HEADERTEXT);

show_smarty_template('profile');
?>
