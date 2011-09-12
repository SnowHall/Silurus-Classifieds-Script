{include file='header.tpl'}

<table width="100%">
  <tr>
    <td width="200px" class="menu_left" valign="top" >
	  <table width="100%" cellpadding="0" cellspacing="0"  class="menu_left_items">
	    <tr>
		  <td class="left_menu_out" onmouseover="this.className='left_menu_over';" onmouseout="this.className='left_menu_out';">&nbsp;&nbsp;&nbsp;&nbsp;<a href="/faq.php" class="left_menu">Main</a></td>
		</tr>
	    <tr>
		  <td class="left_menu_out" onmouseover="this.className='left_menu_over';" onmouseout="this.className='left_menu_out';">&nbsp;&nbsp;&nbsp;&nbsp;<a href="/faq.php?faq" class="left_menu">FAQ</a></td>
		</tr>
		<tr>
		  <td class="left_menu_out" onmouseover="this.className='left_menu_over';" onmouseout="this.className='left_menu_out';">&nbsp;&nbsp;&nbsp;&nbsp;<a href="/faq.php?ttips" class="left_menu">Technical Tips</a></td>
		</tr>
		<tr>
		  <td class="left_menu_out" onmouseover="this.className='left_menu_over';" onmouseout="this.className='left_menu_out';">&nbsp;&nbsp;&nbsp;&nbsp;<a href="/faq.php?stips" class="left_menu">Tips for Sellers</a></td>
		</tr>
		<tr>
		  <td class="left_menu_out" onmouseover="this.className='left_menu_over';" onmouseout="this.className='left_menu_out';">&nbsp;&nbsp;&nbsp;&nbsp;<a href="/simple.php?ID=5" class="left_menu">Contact Us</a></td>
		</tr>		
	  </table>
	</td>
	<td width="20px">&nbsp;</td>
	<td valign="top">
	
	{if $content_g}
	
	<span class="faq_header">{$content_g[0].Title}</span><br />
	{$content_g[0].Text}<br />
	<a href="/faq.php?faq" class="faq_links"><img src="/{$template_path}img/arr.gif" border="0" /> See Full list of FAQs</a><br /><br />
	
	<span class="faq_header">{$content_g[1].Title}</span><br />
	{$content_g[1].Text}<br />
	<a href="/faq.php?ttips" class="faq_links"><img src="/{$template_path}img/arr.gif" border="0" /> Read Technical Tips</a><br /><br />
	
	<span class="faq_header">{$content_g[2].Title}</span><br />
	{$content_g[2].Text}<br />
	<a href="/faq.php?stips" class="faq_links"><img src="/{$template_path}img/arr.gif" border="0" /> See More Tips</a><br /><br />
	
	<span class="faq_header">{$content_g[3].Title}</span><br />
	{$content_g[3].Text}<br />
	<a href="/simple.php?ID=5" class="faq_links"><img src="/{$template_path}img/arr.gif" border="0" /> Contact us at Dumpthatbook.com</a><br /><br />
	
	{/if}
	{if $content}
	
	{foreach from=$content item=arr} 
		<img src="/{$template_path}img/arr_big2.gif" />&nbsp;<a href="/faq.php?{$link_url}#q{$arr.ID}" class="nav_active2">{$arr.Title}</a><br>		
	{/foreach}
	<br>
	{foreach from=$content item=arr} 
		<a name="q{$arr.ID}"></a><span class="faq_header">{$arr.Title}</span><br />{$arr.Text}<br />
	{/foreach}
		
	{/if}
	
	</td><td>{$insert_banner[3]}</td></tr></table>
  		     
{include file='footer.tpl'}		