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
 
include("../include_php/admin_init.php");

$smarty->assign("site_title",  "Change Password :: Admin Panel :: ".$gConfig['site_title']);
$smarty->assign("page_header_text",  "Change Password");
ob_start();


define('E_INVALID_OLD_PASSWORD', 1);
define('E_PASSWORD_CONFIRMATION_FAILED', 2);
define('E_INVALID_PASSWORD_LENGTH', 3);
define('S_OK', 0);
define('E_INVALID_PARAMETER', 1);

// SAVE CHANGES
$save_settings = ('yes' == $_POST['save_settings']);

// Admin password was changed.  Try to save it.
if (FALSE != $save_settings)
{
	if ( $demo_mode )
	{
		echo '<span class="succ">Password can\'t be changed in this demo.</span><br />';
	}
	else
	{
		$result = save_admin_password($_SESSION['adminname'], $_POST['pwd_new'], $_POST['pwd_new_confirm']);
        switch ($result)
        {
            case S_OK:
            {
                // No error.  Display message.
                echo '<span class="succ">Password changed.</span><br />';
            }
            break;
            case E_INVALID_OLD_PASSWORD:
            {
                echo '<div class="err">Error saving new password: wrong old password!</div><br>';
            }
            break;
            case E_INVALID_PASSWORD_LENGTH:
            {
                echo '<div class="err">Error saving new password: invalid password length (between 3 and 11 characters).</div><br>';
            }
            break;
            case E_PASSWORD_CONFIRMATION_FAILED:
            {
                echo '<div class="err">Error saving new passowrd: password not confirmed.</div><br>';
            }
        }
	}
}    


// Display forms and controls for editing settings.
if ( strlen($cat) > 0)
{
    $pageHeader = display_admin_password();    
}

echo display_admin_password();


function display_admin_password()
{
    ?>
    <center>
    <form method="post" action="<? echo $_SERVER[PHP_SELF].'?cat=ap'; ?>">
    <input type="hidden" name="save_settings" value="yes">
    <table width="100%" cellspacing="2" cellpadding="3" class="text">
        <tr>
            <td align="right" width="50%"> New Password: </td>
            <td align="left"><input type="password" size="14" name="pwd_new"></td>
        </tr>
        <tr>
            <td align="right" width="50%"> Confirm New Password: </td>
            <td align="left"><input type="password" size="14" name="pwd_new_confirm"></td>
        </tr>
    </table>
    <br />
    <input class=no type="submit" value="Save Password" class=text>
    </form>
    </center>
    <?php

}

function save_admin_password($admin_name, $pwd_new, $pwd_new_confirm)
{
//    $q_str = "SELECT * FROM Admins WHERE Password =md5('$pwd_old')";
//    $row = mysql_fetch_assoc(mysql_query($q_str));
/*
    if ($row['Password'] != md5($pwd_old)) 
    {
        $result = E_INVALID_OLD_PASSWORD;
    }
    else */
    if (strlen($pwd_new) > 10 || strlen($pwd_new) < 3) // Check password length.
    {
        $result = E_INVALID_PASSWORD_LENGTH;
    }
    else if ($pwd_new != $pwd_new_confirm) // Check if password confirmed correctly.
    {
        $result = E_PASSWORD_CONFIRMATION_FAILED;
    }
    else // no errors, save new password
    {
        // Write new password to database.
        $q_str = "UPDATE Admins SET Password = md5('$pwd_new') WHERE Name = '$admin_name'";
        mysql_query($q_str);
        $result = S_OK;
    }
    return $result;
}

$smarty->assign("page_content",  ob_get_clean());
$smarty->display('index.tpl');

?>