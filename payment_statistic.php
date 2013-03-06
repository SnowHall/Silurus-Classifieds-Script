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

$profileID = $_SESSION['memberID'];
if($profileID == 0) header("location: index.php");

$user = $_SESSION['memberINFO'];


$user['LastLoggedIn'] = ($user['LastLoggedIn']?date("d-m-Y H:i",strtotime($user['LastLoggedIn'])):"Never");
$user['city'] = mysql_fetch_assoc(mysql_query("select * from City where ID=".intval($user['city'])));
$user['city'] = $user['city']['Title'];
$balance = mysql_fetch_assoc(mysql_query("SELECT `balance` FROM `Profiles` WHERE `ID`=".$_SESSION['memberID']));
$user['balance'] = $balance['balance'];
$smarty->assign("user",  $user);


$contact_type = 1;
$smarty->assign("ap_contact_type",  $contact_type);

include("ap_contact.php");

$q = mysql_query("SELECT *, c.sign FROM PaymentsLog INNER JOIN Currency AS `c` ON `PaymentsLog`.`currency`= `c`.`name` WHERE userID=$profileID ORDER BY `date` DESC");
while($payment = mysql_fetch_assoc($q))
{
	$temp = array();
  $temp['Date'] = date("F jS, Y H:i",$payment['date']);
  $temp['Amount'] = number_format($payment['amount'],2,".","").$payment['sign'];

	$payments[] = $temp;
}
$smarty->assign("payments",  $payments);

$HEADERTEXT = 'My Payment Statistic';

addNavigation('',$HEADERTEXT);

$smarty->assign("site_title",  $HEADERTEXT." :: ".$gConfig['site_title']);
$smarty->assign("HEADERTEXT",  $HEADERTEXT);

show_smarty_template('payment_statistic');
?>
