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

$smarty->assign("site_title",  "Site Site Settings :: Admin Panel :: ".$gConfig['site_title']);
$smarty->assign("page_header_text",  "Site Site Settings");

if(isset($_POST['go']))
{
	foreach ($_POST as $key=>$val)
	{
		mysql_query("update Settings set Value='".mysql_escape_string($val)."' where Name='".mysql_escape_string($key)."'");
	}
	mysql_query("update Settings set Value='".intval($_POST['capcha_item_v'])."' where Name='capcha_item'");
    mysql_query("update Settings set Value='".intval($_POST['moderate_advertising'])."' where Name='moderate_advertising'");
	mysql_query("update Settings set Value='".intval($_POST['fb_enable'])."' where Name='fb_enable'");
    mysql_query("update Settings set Value='".intval($_POST['mail_type_v'])."' where Name='mail_type'");
	mysql_query("update Settings set Value='".intval($_POST['mail_ssl_v'])."' where Name='mail_ssl'");
    mysql_query("update Settings set Value='".doubleval(round($_POST['featured_cost'],2))."' where Name='featured_cost'");

	header("location: {$gConfig['site_url']}admin/site.php");
}

$smarty->assign("page_content",  getEdit());
$smarty->display('index.tpl');

function getEdit()
{
	global $gConfig;

	$currencies = getCurrencyList();
  $languages = getLanguages();

	$ret = '<form method="POST" enctype="multipart/form-data">

	<b>Site title</b><br>
	<input style="width:300px" type=text name="site_title" value="'.htmlspecialchars($gConfig['site_title']).'"><br><br>

	<b>Site keywords</b><br>
	<input style="width:300px" type=text name="site_keywords" value="'.htmlspecialchars($gConfig['site_keywords']).'"><br><br>

	<b>Site description</b><br>
	<input style="width:300px" type=text name="site_description" value="'.htmlspecialchars($gConfig['site_description']).'"><br><br>

	<b>Use capcha for add products</b>
	<input type=checkbox name="capcha_item_v" value="1" '.(intval($gConfig['capcha_item'])?"checked":"").'><br>

    <b>Moderate publshed advertising</b>
	<input type=checkbox name="moderate_advertising" value="1" '.(intval($gConfig['moderate_advertising'])?"checked":"").'><br>

    <hr><br>

  	<b>Currency</b><br>
  	<select name="currency">';

  	foreach ($currencies as $currency) {
  	    $ret .= '<option value="' . $currency . '" ' . ($gConfig['currency'] == $currency ? ' selected="selected"' : '') . '>' . $currency . '</option>';
  	}

    $ret .= '
  	</select><br/><br/>

    <b>Featured advertising cost</b><br>
	<input style="width:80px" type=text name="featured_cost" value="'.htmlspecialchars($gConfig['featured_cost']).'"><br><br>

  	<hr><br>
    <b>Language</b><br>
  	<select name="language">';

  	foreach($languages as $language=>$name)
    {
      $ret .= '<option value="'.$language.'" '.($gConfig['language'] == $language ? 'selected="selected"' : '').' >'.$name.'</option>';
    }

    $ret .= '
  	</select><br/><br/>
    <hr><br>

  	<b>FB App ID</b><br>
	<input style="width:300px" type=text name="fb_id" value="'.htmlspecialchars($gConfig['fb_id']).'"><br><br>

	<b>FB App secret</b><br>
	<input style="width:300px" type=text name="fb_secret" value="'.htmlspecialchars($gConfig['fb_secret']).'"><br><br>

    <b>Enable FB authorization</b>
	<input type=checkbox name="fb_enable" value="1" '.(intval($gConfig['fb_enable'])?"checked":"").'><br>

	<hr><br>

  <b>Paypal E-mail:</b><br>
	<input style="width:300px" type=text name="paypal_email" value="'.htmlspecialchars($gConfig['paypal_email']).'"><br><br>

  <hr><br>

	<b>Use SMTP</b>
	<input type=checkbox name="mail_type_v" value="1" '.(intval($gConfig['mail_type'])?"checked":"").'><br><br>

	<b>Use SSL</b>
	<input type=checkbox name="mail_ssl_v" value="1" '.(intval($gConfig['mail_ssl'])?"checked":"").'><br><br>

	<b>Mail</b><br>
	<input style="width:300px" type=text name="mail_name" value="'.htmlspecialchars($gConfig['mail_name']).'"><br><br>

	<b>Mail SMTP server</b><br>
	<input style="width:300px" type=text name="mail_server" value="'.htmlspecialchars($gConfig['mail_server']).'"><br><br>

	<b>Mail SMTP port</b><br>
	<input style="width:300px" type=text name="mail_port" value="'.htmlspecialchars($gConfig['mail_port']).'"><br><br>

	<b>Mail SMTP login</b><br>
	<input style="width:300px" type=text name="mail_user" value="'.htmlspecialchars($gConfig['mail_user']).'"><br><br>

	<b>Mail SMTP password</b><br>
	<input style="width:300px" type=text name="mail_pass" value="'.htmlspecialchars($gConfig['mail_pass']).'"><br><br>

	<input type="submit" name="go" value="Save">

	</form>

	<br><hr><br>

	<form action="admin/test_mail.php" method="POST">
	<input type="hidden" value="1" name="send" />
	<b>To check email settings enter your email and click "Check email settings"</b><br>
	<input style="width:300px" type=text name="email" value=""><br><br>

	<input type="submit" name="go" value="Check email settings">

	</form>

	';

	return $ret;
}

function getCurrencyList()
{
  $currencyList = array();
  $result = mysql_query("SELECT `name` FROM `Currency` WHERE `show` = '1'");
  if ($result)
  {
    while($list = mysql_fetch_assoc($result)) $currencyList[] = $list['name'];
  }
  return $currencyList;
}

function getLanguages()
{
  $languages = array();
  $languagesSql = mysql_query('SELECT * FROM `Languages`');
  while($lang = mysql_fetch_assoc($languagesSql))
  {
    $languages[$lang['language']] = $lang['name'];
  }

  if (!$languages) $languages = array('en'=>'English');
  return $languages;
}
?>

