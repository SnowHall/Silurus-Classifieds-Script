{if $memberID}

{if !$content_only}
	<div id="contact_popover" class="tellafriends_popover" style="display:none;">
	<div class="tellafriends_popover_cont">
	<div style="position:relative;width:100%;" align="left">
{/if}
<form name="contact_form" method="POST">
<input type="hidden" name="contactgo">
<input type="hidden" name="book" value="{if $book}{$book.ID}{/if}">
<input type="hidden" name="contact_type" value="{$ap_contact_type}">
  <table width="650px" cellpadding="0" cellspacing="0">
	<tr>
	  <td colspan="2" align="left" valign="top" class="tellafriends_title">
		Contact {if $ap_contact_type==1}Seller{else}Buyer{/if} : {$ap_seller.fname} {$ap_seller.lname}
	  </td>
	  <td align="right" valign="top">
		<a href="javascript:void(0);" onclick="whitesite(); document.getElementById('contact_popover').style.display='none';"><img src="{$template_path}img/clear.gif" width="40px" height="35px" /></a>
	  </td>
	</tr>
	<tr>
	  <td colspan="2" align="left" valign="top"><br /><br />
		&nbsp;<span class="main_login_mail">The {if $ap_contact_type==1}Seller{else}Buyer{/if} will be emailed your contact information.</span><br /><br />
	  </td>
	  <td>&nbsp;</td>
	</tr>

	{if $book}
	<tr>
	  <td align="left" valign="center">
		&nbsp;<span class="tell_lables"><b>Product:</b></span>
	  </td>
	  <td align="left" valign="top">
		<span class="big_h3"><b>{$book.title_short}</b>
	  </td>
	   <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	</tr>
	<tr><td colspan="3">&nbsp;</td></tr>
	<tr>
	  <td align="left" valign="center" nowrap="nowrap">
		&nbsp;<span class="tell_lables"><b>Price:</b></span><BR />
		&nbsp;<span style="font-size:12px;">If other then selling price</span> &nbsp;&nbsp;
	  </td>
	  <td align="left" valign="top">
		<input type="text" name="contact_price" value="${$book.price|escape:'html'}" class="big_input" style="width:430px;"/>
	  </td>
	   <td>&nbsp;</td>
	</tr>
	<tr><td colspan="3">&nbsp;</td></tr>
	{/if}

	<tr>
	  <td align="left" valign="top">
		&nbsp;<span class="tell_lables"><b>Message:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
	  </td>
	  <td align="left" valign="top">
		<textarea name="contact_text" class="big_input_area"  style="width:430px;"></textarea>
	  </td>
	   <td>&nbsp;</td>
	</tr>
	<tr><td colspan="3">&nbsp;</td></tr>
	<tr>
	  <td align="left">&nbsp;

	  </td>
	  <td align="right" valign="top">
		<a href="javascript:void(0);" onclick="document.contact_form.submit();"><img src="{$template_path}img/send.gif" /></a>
		&nbsp;&nbsp;&nbsp;&nbsp;
	  </td>
	   <td>&nbsp;</td>
	</tr>
  </table>
</form>

{if !$content_only}
	</div>
	</div>
	</div>
{/if}

{else}

{if !$content_only}
	<div id="contact_popover" class="tellafriends_popover" style="display:none;">
	<div class="tellafriends_popover_cont">
	<div style="position:relative;width:100%;" align="left">
{/if}
	  <table width="650px" cellpadding="0" cellspacing="0">
		<tr>
		  <td colspan="2" align="left" valign="top" class="tellafriends_title">
			Error
		  </td>
		  <td align="right" valign="top">
			<a href="javascript:void(0);" onclick="whitesite(); document.getElementById('contact_popover').style.display='none';"><img src="{$template_path}img/clear.gif" width="40px" height="35px" /></a>
		  </td>
		</tr>
		<tr>
		  <td colspan="2" align="left" valign="top"><br /><br />
			<br><br><br><center>Please <a href="/" class="f_reg"><b>Log In</b></a></center>
		  </td>
		  <td>&nbsp;</td>
		</tr>
	  </table>

{if !$content_only}
	</div>
	</div>
	</div>
{/if}

{/if}
