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

if($_SESSION['memberID'] && isset($_POST['contactgo']))
{
	if(!$seller)
	{ 
		$contact_type = $_REQUEST['contact_type'];
		$book = mysql_fetch_assoc(mysql_query("select * from Store where type=".($contact_type-1)." and ID=".intval($_REQUEST['book'])));
		$seller = mysql_fetch_assoc(mysql_query("select * from Profiles where ID=".intval($book['userID'])));		
	}

	$backurl = '/';
	if(trim($seller['Email']) != '')
	{
		if(intval($book['ID']) > 0)
		{
			if($contact_type == 1)
			{
				$templates = mysql_fetch_assoc(mysql_query("select * from LTemplates where ID=1"));
				$message = nl2br($templates['text']);
				$message = str_replace("{BOOK_LINK}","<a href=\"".$gConfig['site_url']."product.php?ID=".$book['ID']."\">".$book['Title']."</a>",$message);
				$backurl = "/product.php?ID=".$book['ID'];
			}
			else 
			{
				$templates = mysql_fetch_assoc(mysql_query("select * from LTemplates where ID=2"));	
				$message = nl2br($templates['text']);			
				$message = str_replace("{BOOK_LINK}","<a href=\"".$gConfig['site_url']."wproduct.php?ID=".$book['ID']."\">".$book['Title']."</a>",$message);
				$backurl = "/wproduct.php?ID=".$book['ID'];
			}
			$subj = $templates['subj'];			
			$message = str_replace("{FROM_NAME}",$_SESSION['memberINFO']['fname'].' '.$_SESSION['memberINFO']['lname'],$message);	
			$message = str_replace("{SENDER_PRICE}",$_REQUEST['contact_price'],$message);
			$message = str_replace("{SENDER_TEXT}",nl2br($_REQUEST['contact_text']),$message);
			$message = str_replace("{FROM_MAIL}",$_SESSION['memberINFO']['Email'],$message);
			$message = str_replace("{TO_NAME}",$seller['fname'].' '.$seller['lname'],$message);
		}
		else 
		{
			$templates = mysql_fetch_assoc(mysql_query("select * from LTemplates where ID=4"));	
			$subj = $templates['subj'];
			$message = nl2br($templates['text']);
			$message = str_replace("{FROM_NAME}",$_SESSION['memberINFO']['fname'].' '.$_SESSION['memberINFO']['lname'],$message);
			$message = str_replace("{BOOK_LINK}","",$message);
			$message = str_replace("{SENDER_PRICE}",'',$message);
			$message = str_replace("{SENDER_TEXT}",nl2br($_REQUEST['contact_text']),$message);
			$message = str_replace("{FROM_MAIL}",$_SESSION['memberINFO']['Email'],$message);
			$message = str_replace("{TO_NAME}",$seller['fname'].' '.$seller['lname'],$message);	
			$backurl = "/profile.php?ID=".$seller['ID'];		
		}
		
		sendMail(trim($seller['Email']),$seller['fname'].' '.$seller['lname'],$subj,$message);
	}	
	header("location: ".$backurl);
}
?>