<?php
include("./include_php/init.php");
/*$logtimefile = fopen('pp_log.txt',"w");
fputs($logtimefile,time().print_r($_POST,true)."


");
fputs($logtimefile,time().print_r($_SERVER,true)."


");
fputs($logtimefile,time().print_r($_REQUEST,true)."


");*/


$postdata="";
foreach ($_POST as $key=>$value) $postdata.=$key."=".urlencode($value)."&";
$postdata .= "cmd=_notify-validate";
$curl = curl_init("https://www.paypal.com/cgi-bin/webscr");
curl_setopt ($curl, CURLOPT_HEADER, 0);
curl_setopt ($curl, CURLOPT_POST, 1);
curl_setopt ($curl, CURLOPT_POSTFIELDS, $postdata);
curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt ($curl, CURLOPT_SSL_VERIFYHOST, 1);
$response = curl_exec ($curl);
curl_close ($curl);

if ($response == "VERIFIED" && mysql_result(mysql_query("SELECT COUNT(*) FROM PaymentsLog WHERE uniqueId='".mysql_escape_string($_POST['item_number'])."'"), 0) == 0)
{
  $profile = mysql_query("select * from Profiles where unique_id='".mysql_escape_string($_POST['item_number'])."' LIMIT 1");
  if ($profile)
  {
    while($user = mysql_fetch_assoc($profile))
    {
      mysql_query("INSERT INTO `PaymentsLog` (`date`,`userId`,`amount`,`currency`,`uniqueId`) VALUES (".time().",{$user['ID']},{$_POST['mc_gross']},'{$_POST['mc_currency']}','{$_POST['item_number']}')");
      mysql_query("UPDATE `Profiles` SET `balance`=".floatval($user['balance'] + $_POST['mc_gross'])." WHERE `ID`=".$user['ID']);
    }
  }
}
header("location: ".$gConfig['site_url'].'profile.php');
die();
?>