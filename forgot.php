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


$action_result =  "Forgot your NickName or password? No problem! Please, supply your e-mail address below and you will be sent your account Username and password." ;

if ( $_POST['Email'] )
{
	if ( !eregi("^[_.0-9a-z-]+@([0-9a-z][0-9a-z-]+.)+[a-z]{2,4}$", $_POST['Email']) )
	{
		$action_result = "The e-mail you entered doesn't seem to be valid. Please, try again.";
	}
	else
	{
		// Check if entered email is in the base
		$sEmail = mysql_escape_string($_POST['Email']);
	    $memb_arr = mysql_fetch_assoc(mysql_query( "SELECT `ID` FROM `Profiles` WHERE `Email` = '$sEmail'" ));
	    if ( $memb_arr['ID'] )
	    {
	    	$recipient = $sEmail;
			
			$newp = substr( base64_encode( microtime () ), 0, 7 );
			
			$templates = mysql_fetch_assoc(mysql_query("select * from LTemplates where ID=3"));	
			$subj = $templates['subj'];
			$message = nl2br($templates['text']);
			$message = str_replace("{LOGIN}",$memb_arr['NickName'],$message);
			$message = str_replace("{PASSWORD}",$newp,$message);
			$message = str_replace("{TO_NAME}",$memb_arr['fname'].' '.$memb_arr['lname'],$message);	
			$mail_ret = sendMail(trim($memb_arr['Email']),$memb_arr['fname'].' '.$memb_arr['lname'],$subj,$message);				
			$sQuery = "UPDATE `Profiles` SET `Password` = md5('".$newp."') WHERE `ID`='{$memb_arr['ID']}'";
			mysql_query( $sQuery );					
			
			$action_result =  "You have been recognized as a member and your account details have just been sent to you.";
	    }
	    else
	    {
			$action_result =  "Sorry, you have not been recognized as a member. Please, make sure that you entered the e-mail you used in creating your account.";
	    }
	}
}

	
$smarty->assign("action_result",  $action_result);

$HEADERTEXT = 'Forgot Username or Password';
	
addNavigation('',$HEADERTEXT);

$smarty->assign("site_title",  $HEADERTEXT." :: ".$gConfig['site_title']);
$smarty->assign("HEADERTEXT",  $HEADERTEXT);

show_smarty_template('forgot');
?>