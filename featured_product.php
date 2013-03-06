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

if($_SESSION['memberID'] == 0) header("location: index.php");

$info = mysql_fetch_array(mysql_query("select * from Store where userID=".$_SESSION['memberID']." and ID=".intval($_REQUEST['ID'])));
if(!$info) header("location: profile.php");


$productId = isset($_REQUEST['ID']) ? intval($_REQUEST['ID']) : null;

if ($productId)
{
    $productSearch = mysql_query("SELECT * FROM `Store` WHERE `id` = '".$productId."'");
    $product = mysql_fetch_assoc($productSearch);
    $smarty->assign("product", $product);
}

$user = mysql_fetch_assoc(mysql_query("select * from Profiles where ID=".intval($_SESSION['memberID'])));
$smarty->assign('user',$user);

$smarty->assign('featured_cost',$gConfig['featured_cost']);

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Confirm']))
{
	$err = array();
	//if(floatval(str_replace(",",".",$_REQUEST['price'])) <= 0) {$err['fieldError'] = 1;$_REQUEST['price']='';}
	//if(trim($_REQUEST['Title']) == '') {$err['fieldError'] = 1;}
    if (intval($_POST['terms']) === 0) {$err['terms'] = 1;}
    if ($user['balance'] < $gConfig['featured_cost']) {$err['balance'] = 1;}
    if ($product['featured'] == '1') {$err['already_paid'] = 1;}

	if(empty($err))
	{
        $result = mysql_query("UPDATE Store SET
                        `featured_date`='".date('Y-m-d H:i:s')."',
                        `featured`='1'
                    WHERE `ID`='".$product['ID']."'");
        if ($result)
        {
            $newBalance = $user['balance'] - $gConfig['featured_cost'];
            mysql_query("UPDATE Profiles SET ".
                        "`balance` = '".doubleval($newBalance)."' ".
                        " WHERE `ID` = '".$user['ID']."'");
        }

		header("location: product.php?ID=".$product['ID']); die();
	}
	$smarty->assign("error",  $err);
}

$HEADERTEXT='Featured Product for Sale';
$smarty->assign("site_title",  $HEADERTEXT." :: ".$gConfig['site_title']);
$smarty->assign("HEADERTEXT",  $HEADERTEXT);
show_smarty_template('featured_product');
?>