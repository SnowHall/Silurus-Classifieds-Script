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
include("../include_php/TemplVotingView.php");

$smarty->assign("site_title",  "View Payment Statistic :: Admin Panel :: ".$gConfig['site_title']);
$smarty->assign("page_header_text",  "View Payment Statistic");

function getPaymentsAdminContent()
{
	global $site;
	global $sActionText;
	global $action,$itemviewid;

  $content .= getList();

	return $content;
}

function getList( $iArticleID = '' )
{
	global $site, $gConfig;

  $content = '<table width="100%">';
  $paymentList = mysql_query("SELECT *, c.sign, p.NickName, p.ID FROM PaymentsLog AS `pl` INNER JOIN Currency AS `c` ON `pl`.`currency`= `c`.`name` INNER JOIN `Profiles` AS `p` ON `p`.`ID` = `pl`.userId ORDER BY `date` DESC");
  $content.='<tr><td valign=top><b>User</b></td><td valign=top><b>Date</b></td><td valign=top><b>Amount</b></td></tr>';
  while($payment = mysql_fetch_assoc($paymentList))
  {
    $content.=
      '<tr><td valign=top><b><a target="_blank" href="profile.php?ID='.$payment['ID'].'">'.$payment['NickName'].'</a></b></td>
      <td valign=top><b>'.date("F jS, Y H:i",$payment['date']).'</b></td>
      <td valign=top><b>'.number_format($payment['amount'],2,".","").$payment['sign'].'</b></td>';
  }

	$content.='</table>';
	return  $content;
}

$smarty->assign("page_content", getPaymentsAdminContent());
$smarty->display('index.tpl');
?>
