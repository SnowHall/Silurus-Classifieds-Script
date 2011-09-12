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
$smarty->assign("site_title",  "Admin Panel :: ".$gConfig['site_title']);
$smarty->assign("page_header_text",  "Index Page");
$menu_block3 = mysql_fetch_assoc(mysql_query("select * from Snowhall where ID=-4 limit 1"));
if($menu_block3)	
{
	$index_block = $menu_block3['Text'];	
}

if(!$smarty->check_cache())
{	
	$page_content2 = '	
	<script>
		function getActivate()
		{
			var ajaxObjects = new sack();					
			ajaxObjects.onCompletion = function(){eval(ajaxObjects.response);};			
			ajaxObjects.requestFile = "/admin/activation.php?code="+document.getElementById(\'act_code_m\').value+"&nocash="+(new Date().getTime());				
			ajaxObjects.runAJAX();
		}
	</script>
	<div class="main_cont" id="main_cont" >
	<div class="page_header">Web site activation<br>
	<span style="font-size:14px;">Please activate your web site by enter below your license code which you received by email with buying this web site system. If you do not have it please <a href="http://snowhall.com/silurus" target="_blank">buy your license code on snowhall.com</a></span></div>			
	<div class="page_cont">
	<div class="admin_block" >		
	<div class="block_cont" id="act_content_m">
				
	<form action="" method=POST>	
	<div id="act_error_m"></div>	
	License key: <input type="text" id="act_code_m" style="width:400px"> 
	<input type=button onclick="getActivate()" name="activate_go" value="Activate"><br>
	<font color=red><b>Important! Your activation will be based on current domain name.</b></font>
	</form>
	
	</div></div></div></div>
	';
	$smarty->assign("activate_content",  $page_content2);
}

$page_content = '
<table width="100%">
<tr>
<td valign=top>
  <table width="284px">
  <tr height="39px"><td style="background:url(/templates/admin_default/images/indexmenu.gif);color:#ffffff;"><img src="/templates/admin_default/images/icons/b_ico0.gif" align="left">&nbsp;&nbsp;<b>Members</b></td></tr>
  <tr><td style="color:#afafaf;padding-left:10px;">
    <a href="/admin/profiles.php" style="color:#0098f5"><b>Members</b></a><br>
    List of members and functions with them.
  </td></tr>  
  </table>
</td>
<td width="1px">&nbsp;&nbsp;&nbsp;</td>
<td valign=top>
  <table width="284px">
  <tr height="39px"><td style="background:url(/templates/admin_default/images/indexmenu.gif);color:#ffffff;"><img src="/templates/admin_default/images/icons/b_ico2.gif" align="left">&nbsp;&nbsp;<b>Store Settings</b></td></tr>
  <tr><td style="color:#afafaf;padding-left:10px;">
    <a href="/admin/prop_seller.php" style="color:#0098f5"><b>Product Properties (for seller)</b></a><br>
    Manage property list for products for sale by category.<br>
    <a href="/admin/prop_buyer.php" style="color:#0098f5"><b>Product Properties (for buyer)</b></a><br>
    Manage property list for wanted products by category.
  </td></tr>  
  </table>
</td>
</tr>
<tr><td colspan=5>&nbsp;</td></tr>
<tr>
<td valign=top>
  <table width="284px">
  <tr height="39px"><td style="background:url(/templates/admin_default/images/indexmenu.gif);color:#ffffff;"><img src="/templates/admin_default/images/icons/b_ico1.gif" align="left">&nbsp;&nbsp;<b>Content</b></td></tr>
  <tr><td style="color:#afafaf;padding-left:10px;">
    <a href="/admin/faq.php" style="color:#0098f5"><b>Manage FAQ</b></a><br>
    Manage FAQ list.<br>
    <a href="/admin/ttips.php" style="color:#0098f5"><b>Manage Technical Tips</b></a><br>
    Manage Technical Tips list.<br>
    <a href="/admin/stips.php" style="color:#0098f5"><b>Manage Seller Tips</b></a><br>
    Manage Seller Tips list.<br>
    <a href="/admin/letters.php" style="color:#0098f5"><b>Manage Email templates</b></a><br>
    Manage Email templates for send to buyer or seller or friend or forgot password email.<br>
    <a href="/admin/simplemain.php" style="color:#0098f5"><b>Manage text on main page</b></a><br>
    Edit different text on main page.<br>
    <a href="/admin/simple.php" style="color:#0098f5"><b>Manage Text Pages</b></a><br>
    Edit different simple text pages.<br>
    <a href="/admin/subscribe.php" style="color:#0098f5"><b>Send News</b></a><br>
    Send emails for members.
  </td></tr>  
  </table>
</td>
<td width="1px">&nbsp;&nbsp;&nbsp;</td>
<td valign=top>
  <table width="284px">
  <tr height="39px"><td style="background:url(/templates/admin_default/images/indexmenu.gif);color:#ffffff;"><img src="/templates/admin_default/images/icons/b_ico2.gif" align="left">&nbsp;&nbsp;<b>Moderation Member Content</b></td></tr>
  <tr><td style="color:#afafaf;padding-left:10px;">
    <a href="/admin/pphoto.php" style="color:#0098f5"><b>Moderation Profiles Photo</b></a><br>
    Moderation photo was added by members.<br>
    <a href="/admin/reviews.php" style="color:#0098f5"><b>Moderation Reviews</b></a><br>
     Moderation Reviews was added by members.<br>
    <a href="/admin/flags.php" style="color:#0098f5"><b>Flaged Content</b></a><br>
     See content was flaged by members.<br>
    <a href="/admin/city.php" style="color:#0098f5"><b>Manage City</b></a><br>
     Manage city list.<br>
    <a href="/admin/books.php" style="color:#0098f5"><b>Moderation products for sale</b></a><br>
    Moderation products for sale was added by members.<br>
    <a href="/admin/wbooks.php" style="color:#0098f5"><b>Moderation wanted products</b></a><br>
     Moderation wanted products was added by members..
  </td></tr>  
  </table>
</td>
</tr>

<tr><td colspan=5>&nbsp;</td></tr>
<tr>
<td valign=top>
  <table width="284px">
  <tr height="39px"><td style="background:url(/templates/admin_default/images/indexmenu.gif);color:#ffffff;"><img src="/templates/admin_default/images/icons/b_ico2.gif" align="left">&nbsp;&nbsp;<b>Site Settings</b></td></tr>
  <tr><td style="color:#afafaf;padding-left:10px;">
    <a href="/admin/global_settings.php" style="color:#0098f5"><b>Admin Password</b></a><br>
    Change admin password.<br>
    <a href="/admin/site.php" style="color:#0098f5"><b>Site settings</b></a><br>
    Edit Title, keywords, mail and other.<br>
    <a href="/admin/template.php" style="color:#0098f5"><b>Template settings</b></a><br>
    Edit template, logo, favicon.<br>
    <a href="/admin/stat_banners.php" style="color:#0098f5"><b>Banner Statistic</b></a><br>
    See banner statistic.<br>
    <a href="/admin/menu.php" style="color:#0098f5"><b>Edit Main Menu</b></a><br>
    Edit main menu elements.
  </td></tr>  
  </table>
</td>
<td width="1px">&nbsp;&nbsp;&nbsp;</td>
<td valign=top>
  <table width="284px">
  <tr height="39px"><td style="background:url(/templates/admin_default/images/indexmenu.gif);color:#ffffff;"><img src="/templates/admin_default/images/icons/ico3.gif" align="left">&nbsp;&nbsp;<b>Log Out</b><br>&nbsp;&nbsp;</td></tr>   
  <tr><td style="color:#afafaf;padding-left:10px;">
    <a href="/admin/login.php?admin_logout" style="color:#0098f5"><b>Log Out</b></a><br>
    Delete admin session and go to site
  </td></tr>
  </table>
</td>
</tr>
</table>

<table width="580px" cellpadding=0 cellspacing=0>
<td width="1px" colspan=2>&nbsp;&nbsp;&nbsp;</td>
<tr height="39px">
<td style="background:#054575;color:#ffffff;"><img src="/templates/admin_default/images/icons/b_ico3.gif" align="left">&nbsp;&nbsp;<b>Latest Activity</b></td>
<td width="284px" style="background:url(/templates/admin_default/images/indexmenu.gif);color:#ffffff;">&nbsp;</td>
</tr>
<tr>
<td valign=top>
  <table width="100%">
    <tr>
      <td width=60px rowspan=8 valign=top><img src="/templates/admin_default/images/ico.gif"></td>
      <td><img src="/templates/admin_default/images/icons/s_ico0.gif" align=left><b> &nbsp;'.intval(mysql_numrows(mysql_query("select * from Profiles"))).' Members</b></td>
      <td width=60px rowspan=8 valign=top align=right><img src="/templates/admin_default/images/news.gif"></td>
    </tr>
    <tr>
      <td><img src="/templates/admin_default/images/icons/s_ico0.gif" align=left><b> &nbsp;'.intval(mysql_numrows(mysql_query("select * from Profiles where LastReg>NOW()-interval 7 day"))).' New this Week</b></td>
    </tr>
    <tr>
      <td><img src="/templates/admin_default/images/icons/s_ico0.gif" align=left><b> &nbsp;'.intval(mysql_numrows(mysql_query("select * from Profiles where LastReg>NOW()-interval 1 month"))).' New This Month</b></td>
    </tr>
    
    <tr>
      <td><img src="/templates/admin_default/images/icons/s_ico1.gif" align=left><b> &nbsp;'.intval(mysql_numrows(mysql_query("select * from Store where type=0 and status=0"))).' Items for Sale</b></td>
    </tr>
    <tr>
      <td><img src="/templates/admin_default/images/icons/s_ico1.gif" align=left><b> &nbsp;'.intval(mysql_numrows(mysql_query("select * from Store where type=1 and status=0"))).' Items Wanted</b></td>
    </tr>
    
    <tr>
      <td><img src="/templates/admin_default/images/icons/s_ico2.gif" align=left><b> &nbsp;'.intval(mysql_numrows(mysql_query("select * from ProfilesRating"))).' Reviews</b></td>
    </tr>
    <tr>
      <td><img src="/templates/admin_default/images/icons/s_ico3.gif" align=left><b> &nbsp;'.intval(mysql_numrows(mysql_query("select * from Flags"))).' Flagged Items</b></td>
    </tr>
  </table>
</td>
<td style="padding-left:10px;"  valign=top>
'.$index_block.'  
</td></tr>  
</table>

';

$smarty->assign("page_content",  $page_content);
$smarty->display('index.tpl');
?>
