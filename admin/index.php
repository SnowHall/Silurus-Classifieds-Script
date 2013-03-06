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
$smarty->assign("site_title",  t("Admin Panel")." :: ".$gConfig['site_title']);
$smarty->assign("page_header_text",  t("Index Page"));
$menu_block3 = mysql_fetch_assoc(mysql_query("select * from Snowhall where ID=-4 limit 1"));
if($menu_block3)
{
	$index_block = $menu_block3['Text'];
}

$page_content = '
<table width="100%">
<tr>
<td valign=top>
  <table width="284px">
  <tr height="39px"><td style="background:url(templates/admin_default/images/indexmenu.gif);color:#ffffff;"><img src="templates/admin_default/images/icons/b_ico0.gif" align="left">&nbsp;&nbsp;<b>'.t('Members').'</b></td></tr>
  <tr><td style="color:#afafaf;padding-left:10px;">
    <a href="' . $gConfig['site_url'] . 'admin/profiles.php" style="color:#0098f5"><b>'.t('Members').'</b></a><br>'
    .t('List of members and functions with them.').
  '</td></tr>
  </table>
</td>
<td width="1px">&nbsp;&nbsp;&nbsp;</td>
<td valign=top>
  <table width="284px">
  <tr height="39px"><td style="background:url(templates/admin_default/images/indexmenu.gif);color:#ffffff;"><img src="templates/admin_default/images/icons/b_ico2.gif" align="left">&nbsp;&nbsp;<b>'.t('Store Settings').'</b></td></tr>
  <tr><td style="color:#afafaf;padding-left:10px;">
    <a href="' . $gConfig['site_url'] . 'admin/prop_seller.php" style="color:#0098f5"><b>'.t('Product Properties (for seller)').'</b></a><br>
    Manage property list for products for sale by category.<br>
    <a href="' . $gConfig['site_url'] . 'admin/prop_buyer.php" style="color:#0098f5"><b>'.t('Product Properties (for buyer)').'</b></a><br>'.
    t('Manage property list for wanted products by category.').
  '</td></tr>
  </table>
</td>
</tr>
<tr><td colspan=5>&nbsp;</td></tr>
<tr>
<td valign=top>
  <table width="284px">
  <tr height="39px"><td style="background:url(templates/admin_default/images/indexmenu.gif);color:#ffffff;"><img src="templates/admin_default/images/icons/b_ico1.gif" align="left">&nbsp;&nbsp;<b>'.t('Content').'</b></td></tr>
  <tr><td style="color:#afafaf;padding-left:10px;">
    <a href="' . $gConfig['site_url'] . 'admin/faq.php" style="color:#0098f5"><b>'.t('Manage FAQ').'</b></a><br>'.
    t('Manage FAQ list.').'<br>
    <a href="' . $gConfig['site_url'] . 'admin/ttips.php" style="color:#0098f5"><b>'.t('Manage Technical Tips').'</b></a><br>'.
    t('Manage Technical Tips list.').'<br>
    <a href="' . $gConfig['site_url'] . 'admin/stips.php" style="color:#0098f5"><b>'.t('Manage Seller Tips').'</b></a><br>'.
    t('Manage Seller Tips list.').'<br>
    <a href="' . $gConfig['site_url'] . 'admin/letters.php" style="color:#0098f5"><b>'.t('Manage Email templates').'</b></a><br>'.
    t('Manage Email templates for send to buyer or seller or friend or forgot password email.').'<br>
    <a href="' . $gConfig['site_url'] . 'admin/simplemain.php" style="color:#0098f5"><b>'.t('Manage text on main page').'</b></a><br>'.
    t('Edit different text on main page.').'<br>
    <a href="' . $gConfig['site_url'] . 'admin/simple.php" style="color:#0098f5"><b>'.t('Manage Text Pages').'</b></a><br>'.
    t('Edit different simple text pages.').'<br>
    <a href="' . $gConfig['site_url'] . 'admin/subscribe.php" style="color:#0098f5"><b>'.t('Send News').'</b></a><br>'.
    t('Send emails for members').
  '</td></tr>
  </table>
</td>
<td width="1px">&nbsp;&nbsp;&nbsp;</td>
<td valign=top>
  <table width="284px">
  <tr height="39px"><td style="background:url(templates/admin_default/images/indexmenu.gif);color:#ffffff;"><img src="templates/admin_default/images/icons/b_ico2.gif" align="left">&nbsp;&nbsp;<b>'.t('Moderation Member Content').'</b></td></tr>
  <tr><td style="color:#afafaf;padding-left:10px;">
    <a href="' . $gConfig['site_url'] . 'admin/pphoto.php" style="color:#0098f5"><b>'.t('Moderation Profiles Photo').'</b></a><br>'.
    t('Moderation photo was added by members.').'<br>
    <a href="' . $gConfig['site_url'] . 'admin/reviews.php" style="color:#0098f5"><b>'.t('Moderation Reviews').'</b></a><br>'.
    t('Moderation Reviews was added by members.').'<br>
    <a href="' . $gConfig['site_url'] . 'admin/flags.php" style="color:#0098f5"><b>'.t('Flaged Content').'</b></a><br>'.
    t('See content was flaged by members.').'<br>
    <a href="' . $gConfig['site_url'] . 'admin/city.php" style="color:#0098f5"><b>'.t('Manage City').'</b></a><br>'.
    t('Manage city list.').'<br>
    <a href="' . $gConfig['site_url'] . 'admin/books.php" style="color:#0098f5"><b>'.t('Moderation products for sale').'</b></a><br>'.
    t('Moderation products for sale was added by members.').'<br>
    <a href="' . $gConfig['site_url'] . 'admin/wbooks.php" style="color:#0098f5"><b>'.t('Moderation wanted products').'</b></a><br>'.
    t('Moderation wanted products was added by members.').
  '</td></tr>
  </table>
</td>
</tr>

<tr><td colspan=5>&nbsp;</td></tr>
<tr>
<td valign=top>
  <table width="284px">
  <tr height="39px"><td style="background:url(templates/admin_default/images/indexmenu.gif);color:#ffffff;"><img src="templates/admin_default/images/icons/b_ico2.gif" align="left">&nbsp;&nbsp;<b>'.t('Site Settings').'</b></td></tr>
  <tr><td style="color:#afafaf;padding-left:10px;">
    <a href="' . $gConfig['site_url'] . 'admin/global_settings.php" style="color:#0098f5"><b>'.t('Admin Password').'</b></a><br>'.
    t('Change admin password.').'<br>
    <a href="' . $gConfig['site_url'] . 'admin/site.php" style="color:#0098f5"><b>'.t('Site settings').'</b></a><br>'.
    t('Edit Title, keywords, mail and other.').'<br>
    <a href="' . $gConfig['site_url'] . 'admin/template.php" style="color:#0098f5"><b>'.t('Template settings').'</b></a><br>'.
    t('Edit template, logo, favicon.').'<br>
    <a href="' . $gConfig['site_url'] . 'admin/stat_banners.php" style="color:#0098f5"><b>'.t('Banner Statistic').'</b></a><br>'.
    t('See banner statistic.').'<br>
    <a href="' . $gConfig['site_url'] . 'admin/menu.php" style="color:#0098f5"><b>'.t('Edit Main Menu').'</b></a><br>'.
    t('Edit main menu elements.').
  '</td></tr>
  </table>
</td>
<td width="1px">&nbsp;&nbsp;&nbsp;</td>
<td valign=top>
  <table width="284px">
  <tr height="39px"><td style="background:url(templates/admin_default/images/indexmenu.gif);color:#ffffff;"><img src="templates/admin_default/images/icons/ico3.gif" align="left">&nbsp;&nbsp;<b>'.t('Log Out').'</b><br>&nbsp;&nbsp;</td></tr>
  <tr><td style="color:#afafaf;padding-left:10px;">
    <a href="' . $gConfig['site_url'] . 'admin/login.php?admin_logout" style="color:#0098f5"><b>'.t('Log Out').'</b></a><br>'.
    t('Delete admin session and go to site').
  '</td></tr>
  </table>
</td>
</tr>
</table>

<table width="580px" cellpadding=0 cellspacing=0>
<td width="1px" colspan=2>&nbsp;&nbsp;&nbsp;</td>
<tr height="39px">
<td style="background:#054575;color:#ffffff;"><img src="templates/admin_default/images/icons/b_ico3.gif" align="left">&nbsp;&nbsp;<b>'.t('Latest Activity').'</b></td>
<td width="284px" style="background:url(templates/admin_default/images/indexmenu.gif);color:#ffffff;">&nbsp;</td>
</tr>
<tr>
<td valign=top>
  <table width="100%">
    <tr>
      <td width=60px rowspan=8 valign=top><img src="templates/admin_default/images/ico.gif"></td>
      <td><img src="templates/admin_default/images/icons/s_ico0.gif" align=left><b> &nbsp;'.intval(mysql_numrows(mysql_query("select * from Profiles"))).' '.t('Members').'</b></td>
      <td width=60px rowspan=8 valign=top align=right><img src="templates/admin_default/images/news.gif"></td>
    </tr>
    <tr>
      <td><img src="templates/admin_default/images/icons/s_ico0.gif" align=left><b> &nbsp;'.intval(mysql_numrows(mysql_query("select * from Profiles where LastReg>NOW()-interval 7 day"))).' '.t('New this Week').'</b></td>
    </tr>
    <tr>
      <td><img src="templates/admin_default/images/icons/s_ico0.gif" align=left><b> &nbsp;'.intval(mysql_numrows(mysql_query("select * from Profiles where LastReg>NOW()-interval 1 month"))).' '.t('New This Month').'</b></td>
    </tr>

    <tr>
      <td><img src="templates/admin_default/images/icons/s_ico1.gif" align=left><b> &nbsp;'.intval(mysql_numrows(mysql_query("select * from Store where type=0 and status=0"))).' '.t('Items for Sale').'</b></td>
    </tr>
    <tr>
      <td><img src="templates/admin_default/images/icons/s_ico1.gif" align=left><b> &nbsp;'.intval(mysql_numrows(mysql_query("select * from Store where type=1 and status=0"))).' '.t('Items Wanted').'</b></td>
    </tr>

    <tr>
      <td><img src="templates/admin_default/images/icons/s_ico2.gif" align=left><b> &nbsp;'.intval(mysql_numrows(mysql_query("select * from ProfilesRating"))).' '.t('Reviews').'</b></td>
    </tr>
    <tr>
      <td><img src="templates/admin_default/images/icons/s_ico3.gif" align=left><b> &nbsp;'.intval(mysql_numrows(mysql_query("select * from Flags"))).' '.t('Flagged Items').'</b></td>
    </tr>
  </table>
</td>
<td style="padding-left:10px;"  valign=top>'.$index_block.'
</td></tr>
</table>';

$smarty->assign("page_content",  $page_content);
$smarty->display('index.tpl');
?>
