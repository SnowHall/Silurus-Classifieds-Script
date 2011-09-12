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

$contact_type = intval($_GET['type']);
$id = intval($_GET['id']);

$book = mysql_fetch_assoc(mysql_query("select * from Store  where type=".($contact_type-1)." and ID=".$id));
$seller = mysql_fetch_assoc(mysql_query("select * from Profiles where ID=".intval($book['userID'])));
$book['title_short'] = (strlen($book['Title'])>40?substr(htmlspecialchars($book['Title']),0,40).'...':htmlspecialchars($book['Title']));

$smarty->assign("ap_contact_type",  $contact_type);
$smarty->assign("book",  $book);
$smarty->assign("ap_seller",  $seller);
$smarty->assign("content_only",  true);

show_smarty_template('ap_contact');
?>
