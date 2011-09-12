{include file='header.tpl' zoomini='true'}

<table width="100%" cellpadding="0" cellspacing="0">
  <tr>
  <td width="120px" valign="top">
  {if !$photos}
    <img src="/{$template_path}img/bignopic.gif">
  {else}
	  <table width="100%">	
		{assign var="tr" value=0}
		{assign var="tr2" value=0}
		{foreach from=$photos item=val} 
			{if $tr2==0}
				<tr>
				  <td colspan="3" align="center">
				    <img src="/media/store/small_{$val.path}" width="120px" onmouseover="enable_zoom(this,{$val.width},{$photos[0].height});" onmouseout="disable_zoom();"/>
				  </td>
				</tr>
			{else}
				{if $tr==0}<tr>{/if}
				<td valign=top align="center">
				<img src="/media/store/small_{$val.path}"  width="30px" onmouseover="enable_zoom(this,{$val.width},{$val.height});" onmouseout="disable_zoom();"/>
				</td>
				{assign var="tr" value=$tr+1}
				
				{if $tr>3} 
				{assign var="tr" value=0}
				</tr>
				{/if}	
			{/if}
			{assign var="tr2" value=1}
		{/foreach}
		{if $tr > 0} </tr>{/if}
	  </table>	 
	  <div style="position:absolute;z-index:1000;display:none;" id="image_zoom">
	    <img src="" id="image_zoom_img" />
	  </div> 
	     
  {/if}
  	  <br>
	  <table cellpadding="0" cellspacing="0">
	  <tr height="95px">
	  <td width="61px" style="background:url(/{$template_path}img/price1.gif);background-repeat:no-repeat;background-position:right;" nowrap>&nbsp;</td>
	  <td style="background:url(/{$template_path}img/price2.gif);background-repeat:repeat-x;color:#d10f0f" nowrap><b>${$book.price|escape:'html'}&nbsp;</b></td>
	  <td width="13px" style="background:url(/{$template_path}img/price3.gif);background-repeat:no-repeat;background-position:left;" nowrap>&nbsp;</td>
	  </tr>
	  </table> 
  </td>
	<td width="20px">&nbsp;</td>
	<td valign="top">
	  <table width="100%" cellpadding="0" cellspacing="0">
	    <tr>
		  <td valign="top"> 
		    <span class="big_h4_grey">{$book.Title|escape:'html'}</span><bR>
		    from <a href="/category.php?ID={$categ.ID}">{$categ.Title|escape:'html'}</a>
		    <br /><br />
			  <span class="big_h3"><b>Properties</b></span>
			  <div style="height:5px;width:95%;border-bottom:1px solid #e1e1e1;font-size:1px;"></div>
			  <div style="width:100%;height:5px;font-size:1px;"></div>
			  <table width="100%" cellpadding="0" cellspacing="0">
			  {foreach from=$book.props item=val} 
			   <tr>
			     <td style="font-size:13px;" width="130px" valign="top">
				   {$val.Name|escape:'html'}:
				 </td>
				 <td style="color:#000000;" valign="top">
				   {if $val.Type==1 || $val.Type==2 || $val.Type==5}
				     {$val.value|escape:'html'}
				   {/if}
				   {if $val.Type==4}
				     {$val.value}
				   {/if}		   
				   {if $val.Type==6}
				     {foreach from=$val.value item=val2} 
				       {$val2}&nbsp;&nbsp;&nbsp;
				     {/foreach}
				   {/if}
				   {if $val.Type==7}
				     {foreach from=$val.value item=val2} 
				       {$val2}&nbsp;&nbsp;&nbsp;
				     {/foreach}
				   {/if}	   
				 </td>
			   </tr>	
			   
			   {/foreach}   
			  </table>	 
	  
		  </td>
		  <td width="185px" valign="top" align="right"> 
		    <table width="100%" cellpadding="0" cellspacing="0">
			 
			  <tr height="35">
			    <td align="right">
		   		  <a href="javascript:void(0);" onclick="blacksite();document.getElementById('contact_popover').style.display='block';"><img src="/{$template_path}img/contact2.gif" /></a>
				</td>
			  </tr>
			  <tr height="40">
			    <td align="right">
		   		  <a href="javascript:void(0);" onclick="blacksite();document.getElementById('tellafriends_popover').style.display='block';"><img src="/{$template_path}img/tell.gif" /></a>
				</td>
			  </tr>
			  <tr>
			    <td align="right">
		   		 <a href="/product.php?ID={$book.ID}&flag"><img src="/{$template_path}img/flag_post.gif" border="0"/></a>
				</td>
			  </tr>
			  
			</table>
		  </td>		  
		</tr>
	  </table>
	  
    </td>
	<td width="20px">&nbsp;</td>
	<td width="262px">	
	
	  <div style="width:100%">	
	  <table width="100%" cellpadding="0" cellspacing="0">
	  <tr height="12px"><td style="background:url(/{$template_path}img/top.gif);background-repeat:no-repeat;background-position:bottom;">&nbsp;</td></tr>
	  <tr><td style="background:#e1e1e1">
		<table width="240px" cellpadding="0" cellspacing="0">
		  <tr>
		    <td>&nbsp;&nbsp;&nbsp;<span class="big_h3" style="color:#616161"><b>Seller's Info</b></span></td>
			<td align="right"></td>
		  </tr>
		</table>
				
	    <div style="background:#e1e1e1;width:100%; margin-top:10px;">
		<div style="padding:10px;">
		  <a href="/profile.php?ID={$ap_seller.ID}" style="color:#616161;text-decoration:none;"><b>{$ap_seller.fname} {$ap_seller.lname}</b></a>
		  &nbsp;&nbsp;&nbsp;&nbsp;
		  <a href="/profile.php?ID={$ap_seller.ID}" style="color:#616161;text-decoration:none;font-size:11px;">View Profile</a><br /><br />
		
		  <table width="100%" cellpadding="0" cellspacing="0">
		    {if $ap_seller.phone!='' && !$ap_seller.phone_none}
		    <tr height="25px">
			  <td valign="top" width="80px">
			    <span class="main_login_mail" style="color:#868686">Phone:</span>
			  </td>
			  <td valign="top">
			    <b>{$ap_seller.phone}</b>
			  </td>
			</tr>
			{/if}
		   {if $ap_seller.cell!='' && !$ap_seller.cell_none}
			<tr height="25px">
			  <td valign="top">
			    <span class="main_login_mail" style="color:#868686">Cell:</span>
			  </td>
			  <td valign="top">
			    <b>{$ap_seller.cell}</b>
			  </td>
			</tr>
			{/if}
		   {if $ap_seller.altemail!='' && !$ap_seller.altemail_none}
			<tr height="25px">
			  <td valign="top">
			    <span class="main_login_mail" style="color:#868686">Email:</span>
			  </td>
			  <td valign="top">
			    <b><a href="mailto:{$ap_seller.altemail}" style="color:#2d4f94;text-decoration:none;">{$ap_seller.altemail}</a></b>
			  </td>
			</tr>
			{/if}
		   {if $ap_seller.aim!='' && !$ap_seller.aim_none}
			<tr height="25px">
			  <td valign="top">
			    <span class="main_login_mail" style="color:#868686">AIM:</span>
			  </td>
			  <td valign="top">
			    <b>{$ap_seller.aim}</b>
			  </td>
			</tr>
			{/if}
		   {if $ap_seller.skype!='' && !$ap_seller.skype_none}
			<tr height="30px">
			  <td valign="top">
			    <span class="main_login_mail" style="color:#868686">Skype:</span>
			  </td>
			  <td valign="top">
			    <b>{$ap_seller.skype}</b>
			  </td>
			</tr>	
		   {/if}				
		  </table>
		 
		  {if $ap_seller.note!=''} 
			  <span style="font-size:16px;color:#616161"><b>Seller's Policies/Notes</b></span>
			  <br />		
			   <div style="padding:12px;width:100%;">
			  <span style="font-size:12px;color:#868686">{$ap_seller.note}</span>
			  </div>	
		  {/if}	 	
		  
		  
		  </div>		 
		</div>
	  </td></tr>
	  <tr height="12px"><td style="background:url(/{$template_path}img/bottom.gif);background-repeat:no-repeat;background-position:top;">&nbsp;</td></tr>
	  </table>  		
	  </div>
	  <br />
	  {$insert_banner[8]}	
    </td>
  </tr>
</table>

{include file='ap_contact.tpl'}	
{include file='ap_tell.tpl'}
  
		     
{include file='footer.tpl'}		