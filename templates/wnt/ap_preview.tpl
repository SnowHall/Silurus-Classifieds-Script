<table width="400px" cellpadding="0" cellspacing="0">
<tr>
  <td colspan="2" align="left" valign="top" class="change_location_title">
  	Product Preview
  </td>
  <td align="right" valign="top">
    <a href="javascript:void(0);" onclick="document.getElementById('info_popover').style.display='none';"><img src="{$template_path}img/clear.gif" width="40px" height="30px" /></a>
  </td>
</tr>
<tr>
  <td width="100px" align="left" valign="top"><br />
  {if $book.Photo1!=''}<img src="media/store/small_{$book.Photo1}" width="80px" style="padding-right:10px" />{else}<img src="{$template_path}img/noimg.gif" width="80px" style="padding-right:10px" />{/if}
  </td>
  <td rowspan="2" align="left" valign="top"><img src="{$template_path}img/clear.gif" width="250px" height="1px"/> <br />
    <table width="100%" cellpadding="0" cellspacing="0" style="font-size:12px;">
      <tr height="20px">
	    <td valign="top">
		  <b>Title:</b>
		</td>
		<td valign="top">
		  {$book.Title|escape:'html'}
		</td>
	  </tr>
	  <tr height="20px">
	    <td valign="top">
		  <b>Category:</b>
		</td>
		<td valign="top">
		  {$categ.Title|escape:'html'}
		</td>
	  </tr>
	  <tr height="20px">
	    <td valign="top">
		  <b>Owner:</b>
		</td>
		<td valign="top">
		  <a href="profile.php?ID={$book.user_ID}" style="color:#232323;text-decoration:none;">{$user.fname} {$user.lname}</a>
		</td>
	  </tr>
	  <tr height="20px">
	    <td valign="top"><br />
		  <a href="{$book.url}.php?ID={$book.ID}"><img src="{$template_path}img/pop_detail.gif" border="0" /></a>
		</td>
		<td valign="top"><br />
		   &nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="blacksite();document.getElementById('contact_popover').style.display='block';"><img src="/{$template_path}img/pop_contact{$book.prefix}.gif" border="0" /></a>
		</td>
	  </tr>
	</table>
  </td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td align="center" valign="top"><br />
    <span style="color:#ffffff;font-size:16px;background:#d10f0f;padding:5px"><b>${$book.price}&nbsp;</b></span>
  </td>
  <td>&nbsp;</td>
</tr>
</table>