{include file='header.tpl' zoomini='true'}

<table width="100%" cellpadding="0" cellspacing="0">
  <tr>    
	<td valign="top">
	  <table width="100%" cellpadding="0" cellspacing="0">
	    <tr>
		  <td valign="top"> 
		    <span class="big_h4_grey">{$book.Title|escape:'html'}</span>
			<div style="padding-top:5px;">{$book.author|escape:'html'}, et al.</div>
		  </td>
		  <td width="185px" valign="top" align="right"> 
		    <table width="100%" cellpadding="0" cellspacing="0">			  
			  <tr height="42">
			    <td align="right">
		   		  <a href="javascript:void(0);" onclick="blacksite();document.getElementById('contact_popover').style.display='block';"><img src="/{$template_path}img/contact2_b.gif" /></a>
				</td>
			  </tr>
			  <tr>
			    <td align="right">
		   		  <a href="javascript:void(0);" onclick="blacksite();document.getElementById('tellafriends_popover').style.display='block';"><img src="/{$template_path}img/tell.gif" /></a>
				</td>
			  </tr>
			</table>
		  </td>		  
		</tr>
	  </table>
	  <br />
	  <div style="height:5px;width:95%;border-bottom:1px solid #e1e1e1;font-size:1px;"></div>
	  <div style="width:100%;height:5px;font-size:1px;"></div>
	  <table width="100%" cellpadding="0" cellspacing="0">
	   <tr height="30px">
	     <td class="big_verdana">
		   Price Willing to Pay:
		 </td>
		 <td style="color:#000000;font-weight:bold;">
		   ${$book.price|escape:'html'}
		 </td>
	   </tr>
	   <tr height="20px">
	     <td class="big_verdana">
		   Minimum Acceptable Book Condition
		 </td>
		 <td>
		   {$vote1}
		 </td>
	   </tr>	  
	  </table>
	  <br /><br />
	  <span class="big_h3"><b>Book Details</b></span>
	  <div style="height:5px;width:95%;border-bottom:1px solid #e1e1e1;font-size:1px;"></div>
	  <div style="width:100%;height:5px;font-size:1px;"></div>
	  <table width="100%" cellpadding="0" cellspacing="0">
	   <tr height="20px">
	     <td style="font-size:13px;" width="130px">
		   Date of Listing:
		 </td>
		 <td style="color:#000000;font-weight:bold;">
		   {$book.date|escape:'html'}
		 </td>
	   </tr>
	   <tr height="20px">
	     <td style="font-size:13px;">
		   Book Price:
		 </td>
		 <td style="color:#000000;font-weight:bold;">
		   ${$book.price|escape:'html'}
		 </td>
	   </tr>
	   <tr height="20px">
	     <td style="font-size:13px;">
		   Edition:
		 </td>
		 <td style="color:#000000;font-weight:bold;">
		   {$book.Edition|escape:'html'}
		 </td>
	   </tr>
	   <tr height="20px">
	     <td style="font-size:13px;">
		   Author:
		 </td>
		 <td style="color:#000000;font-weight:bold;">
		   {$book.author|escape:'html'}
		 </td>
	   </tr>
	   <tr height="20px">
	     <td style="font-size:13px;">
		   ISBN#:
		 </td>
		 <td style="color:#000000;font-weight:bold;">
		   {$book.isbn|escape:'html'}
		 </td>
	   </tr>
	  </table>
	  <br /><br />
	  <span class="big_h3"><b>Additional Notes</b></span>
	  <div style="height:5px;width:95%;border-bottom:1px solid #e1e1e1;font-size:1px;"></div>
	  <div style="width:100%;height:5px;font-size:1px;"></div>		
		<div style="width:100%;height:5px;font-size:1px;"></div>
	    <span style="font-size:13px;">{$book.note|escape:'html'}</span>
    </td>
	<td width="20px">&nbsp;</td>
	<td width="285px">	
	
	  <div style="width:285px;background:#f0f0f0;padding-left:15px;padding-top:15px;">	
	    		
		<table width="270px" cellpadding="0" cellspacing="0">
		  <tr>
		    <td><span class="big_h3"><b>Seller's Info</b></span></td>
			<td align="right"><a href="/wproduct.php?ID={$book.ID}&flag"><img src="/{$template_path}img/flag_post.gif" border="0"/></a></td>
		  </tr>
		</table>
				
	    <div style="background:url(/{$template_path}img/contact.gif); background-repeat:repeat-x; background-position:top;width:270px; margin-top:10px;">
		<div style="padding:10px;">
		  <a href="/profile.php?ID={$ap_seller.ID}" style="color:#1a7694;text-decoration:none;"><b>{$ap_seller.fname} {$ap_seller.lname}</b></a><br />
		  <img src="/{$template_path}img/arr.gif" />&nbsp;
		  <a href="/profile.php?ID={$ap_seller.ID}" style="color:#1a7694;text-decoration:none;font-size:11px;">Read My Profile</a><br /><br />
		  <div style="width:95%;border-bottom:1px solid #e1e1e1;"></div><br />
		  <table width="100%" cellpadding="0" cellspacing="0">
		    {if !$ap_seller.phone_none}
		    <tr height="25px">
			  <td valign="top" width="80px">
			    <span class="main_login_mail">Phone:</span>
			  </td>
			  <td valign="top">
			    <b>{$ap_seller.phone}</b>
			  </td>
			</tr>
			{/if}
		   {if !$ap_seller.cell_none}
			<tr height="25px">
			  <td valign="top">
			    <span class="main_login_mail">Cell:</span>
			  </td>
			  <td valign="top">
			    <b>{$ap_seller.cell}</b>
			  </td>
			</tr>
			{/if}
		   {if !$ap_seller.altemail_none}
			<tr height="25px">
			  <td valign="top">
			    <span class="main_login_mail">Email:</span>
			  </td>
			  <td valign="top">
			    <b><a href="mailto:{$ap_seller.altemail}" style="color:#1a7694;text-decoration:none;">{$ap_seller.altemail}</a></b>
			  </td>
			</tr>
			{/if}
		   {if !$ap_seller.aim_none}
			<tr height="25px">
			  <td valign="top">
			    <span class="main_login_mail">AIM:</span>
			  </td>
			  <td valign="top">
			    <b>{$ap_seller.aim}</b>
			  </td>
			</tr>
			{/if}
		   {if !$ap_seller.skype_none}
			<tr height="30px">
			  <td valign="top">
			    <span class="main_login_mail">Skype:</span>
			  </td>
			  <td valign="top">
			    <b>{$ap_seller.skype}</b>
			  </td>
			</tr>	
		   {/if}				
		  </table>
		  <div style="width:95%;border-bottom:1px solid #e1e1e1;"></div>
		  </div>		  
		  <span style="font-size:16px;"><b>Seller's Policies/Notes</b></span>
		  <br />		
		  <span style="font-size:12px;">{$ap_seller.note}</span>
		  <br /><br />
		</div>
	  </div>
	  <br />
	  {$insert_banner[7]}
    </td>
  </tr>
</table>

{include file='ap_contact.tpl'}	
{include file='ap_tell.tpl'}
  
		     
{include file='footer.tpl'}		