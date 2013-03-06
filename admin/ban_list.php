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

$smarty->assign("site_title",  "Ban list :: Admin Panel :: ".$gConfig['site_title']);
$smarty->assign("page_header_text",  "Ban list");

$ban_table = 'BanList';

if (isset($_POST['Ban']))
{
    $sql = 'INSERT IGNORE INTO `'.$ban_table.'` (`ip`) VALUES ('.  mysql_real_escape_string($_POST['Ban']['BannIp']).')';
    mysql_query($sql);
}

if (isset($_GET['action']))
{
    switch ($_GET['action'])
    {
        case 'delete':
            if (!isset($_GET['ip'])) die('You should choose unbanned ip!');
            mysql_query('DELETE FROM `'.$ban_table.'` WHERE `ip` = "'.mysql_real_escape_string($_GET['ip']).'"');
            break;
    }
}

ob_start();
?>
<h2>Banned Ip's</h2>
<table class="text" width="100%" cellpadding="0" cellspacing="0" border="0">
    <?php
        $sql = 'SELECT * FROM `'.$ban_table.'`';
        $searchBannedIp = mysql_query($sql);
        while($bannedIp = mysql_fetch_assoc($searchBannedIp)):
    ?>
        <tr>
            <td><?php echo $bannedIp['ip'] ?></td>
            <td><a href="/admin/ban_list.php?action=delete&ip=<?php echo $bannedIp['ip']; ?>">Delete</a></td>
        </tr>
    <?php endwhile; ?>
<tr>
    <form action="" method="post" name="Ban">
    <td  align="center"><hr style="width:90%; color:#e4e4e4; height:1px;">
    <b>Add IP to the ban list</b><br>
    <input type=text name="Ban[BannIp]" style="width:540px;"><br>
</tr>
<tr>
    <td  align="center"><input class=text type=submit name="Ban[ban_submit]" value="Ban IP"></td>
    </form>
</tr>
</table>


<?
$ret = ob_get_clean();
$smarty->assign("page_content",  $ret);
$smarty->display('index.tpl');