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
 

if(isset($_POST['tellgo']))
{
	if(trim($_REQUEST['tell_name']) != '')
	{
		$emails = explode(",",$_REQUEST['tell_name']);
		foreach ($emails as $email)
			sendMail(trim($email),trim($email),$_REQUEST['tell_subj'], '<b>'.$_SESSION['memberINFO']['fname'].' '.$_SESSION['memberINFO']['lname'].' wrote to you:</b><br><br>'.nl2br($_REQUEST['tell_text']));
	}	
	header("location: ".($contact_type==1?'product.php?ID='.$book['ID']:'wproduct.php?ID='.$book['ID']));
}

?>