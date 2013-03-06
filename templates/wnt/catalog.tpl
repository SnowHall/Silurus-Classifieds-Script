{include file='header.tpl'}

<table width="100%">
  <tr>
    <td width="200px" class="menu_left" valign="top">
	  <table width="100%" cellpadding="0" cellspacing="0"  class="menu_left_items">

{foreach from=$rel_categ item=oCat}
<tr>
  <td class="left_menu_out" onmouseover="this.className='left_menu_over';" onmouseout="this.className='left_menu_out';">&nbsp;&nbsp;&nbsp;&nbsp;<a href="{$cur_url}ID={$oCat.ID}" class="left_menu">{$oCat.Title}</a></td>
</tr>
{/foreach}
</table>
</td>
<td width="20px">&nbsp;</td>
<td valign="top">

{assign var="aBooks" value=$sbooks}
{include file='table_list.tpl'}

<div style="width:95%;background:#EEEEEE;padding-top:5px;padding-bottom:5px;" align="center">{include file='page_navigation.tpl' aPaging=`$aPaging`}</div>

<div id="info_popover" style="display:none;">
<div class="info_popover_cont">
<div style="position:relative;width:100%;" align="left" id="content_inner">

</div>
</div>
</div>

<br />
<div style="width:95%;height:1px;border-top:1px solid #eeeeee;font-size:0px;"></div>
<div style="width:95%;border-top:2px solid #eeeeee;font-size:0px;"></div>

<br />
  <div style="border:1px solid #d2d2d2;width:91%;padding:15px;font-size:16px;">
    <b>Didn't find what you were looking for?</b><br />
    <form name="search_form2" method="GET" action="/search.php">
    <input type="hidden" name="go">
	<table width="100%" style="padding-top:10px;">
	  <tr>
	    <td><b>Search Products:</b> </td>
		<td><input type="text" name="keywords"/> </td>
		<td><a href="javascript:void(0);" onclick="document.search_form2.submit();"><img src="{$template_path}img/search_go2.gif" border="0" /></a> </td>
		<td> <b>Or, post an add for a <a href="add_wproduct.php" style="color:#b9b9b9;font-size:17px;">Wanted Product</a></b></td>
	  </tr>
	</table>
	</form>
  </div>

</td>

</tr>
</table>

<div id="contact_popover" class="tellafriends_popover" style="display:none;">
<div class="tellafriends_popover_cont">
<div style="position:relative;width:100%;" align="left" id="contact_popover_inner">

</div>
</div>
</div>

{include file='footer.tpl'}