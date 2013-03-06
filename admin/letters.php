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

$smarty->assign("site_title",  "Edit email templates :: Admin Panel :: ".$gConfig['site_title']);
$smarty->assign("page_header_text",  "Edit email templates");


if(isset($_POST['go']))
{
	$q = mysql_query("select * from LTemplates order by ID");
	while($arr = mysql_fetch_assoc($q))
	{
		mysql_query("update LTemplates set text='".mysql_escape_string($_POST['text'.$arr['ID']])."',subj='".mysql_escape_string($_POST['subj'.$arr['ID']])."' where ID=".$arr['ID']);
	}	
	header("location: {$gConfig['site_url']}admin/letters.php");
}

$smarty->assign("page_content",  getEdit());
$smarty->display('index.tpl');

function getEdit()
{
	global $site;
	
	$ret = '<form method="POST">';
	
	$arr = mysql_fetch_assoc(mysql_query("select * from LTemplates where ID=4"));
	$ret .= '<b>Notify for member</b><br>
	Subject<br>
	<input type="text" name="subj4" value="'.$arr['subj'].'"><br>
	Text<bR>
	<textarea name="text4" style="width:500px;height:100px;">'.$arr['text'].'</textarea><br><br>
	<b>Special variables:</b><br>
	{TO_NAME} - Recipient name.<br>
	{FROM_NAME} - Sender name.<br>
	{FROM_MAIL} - Sender email.<br>	
	{SENDER_TEXT} - Text written by the sender.<br>
	<br><br>';
	
	$arr = mysql_fetch_assoc(mysql_query("select * from LTemplates where ID=1"));	
	$ret .= '<b>Notify for seller</b><br>
	Subject<br>
	<input type="text" name="subj1" value="'.$arr['subj'].'"><br>
	Text<bR>
	<textarea name="text1" style="width:500px;height:100px;">'.$arr['text'].'</textarea><br><br>';
	
	$arr = mysql_fetch_assoc(mysql_query("select * from LTemplates where ID=2"));
	$ret .= '<b>Notify for buyer</b><br>
	Subject<br>
	<input type="text" name="subj2" value="'.$arr['subj'].'"><br>
	Text<bR>
	<textarea name="text2" style="width:500px;height:100px;">'.$arr['text'].'</textarea><br><br>
	<b>Special variables:</b><br>
	{TO_NAME} - Recipient name.<br>
	{FROM_NAME} - Sender name.<br>
	{FROM_MAIL} - Sender email.<br>
	{BOOK_LINK} - Link on book with title.<br>
	{SENDER_PRICE} - Price for selected book.<br>
	{SENDER_TEXT} - Text written by the sender.<br>
	<br><br>';
	
	$arr = mysql_fetch_assoc(mysql_query("select * from LTemplates where ID=3"));
	$ret .= '<b>Forgot password or login</b><br>
	Subject<br>
	<input type="text" name="subj3" value="'.$arr['subj'].'"><br>
	Text<bR>
	<textarea name="text3" style="width:500px;height:100px;">'.$arr['text'].'</textarea><br><br>
	<b>Special variables:</b><br>
	{TO_NAME} - Recipient name.<br>
	{LOGIN} - Login.<br>
	{PASSWORD} - Password.<br>	
	<br><br>';
	
	$ret .= '<input type="submit" name="go" value="Save"></form>';

	return $ret;
}


?>

