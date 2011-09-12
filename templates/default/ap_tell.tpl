
<div id="tellafriends_popover" class="tellafriends_popover" style="display:none;">
<div class="tellafriends_popover_cont">
<div style="position:relative;width:100%;" align="left">
<form name="tellafriends_form" method="POST">
<input type="hidden" name="tellgo">
  <table width="650px" cellpadding="0" cellspacing="0">
	<tr>
	  <td colspan="2" align="left" valign="top" class="tellafriends_title">			    
		Email A Friend
	  </td>
	  <td align="right" valign="top">
		<a href="javascript:void(0);" onclick="whitesite(); document.getElementById('tellafriends_popover').style.display='none';"><img src="/{$template_path}img/clear.gif" width="40px" height="35px" /></a>
	  </td>
	</tr>
	<tr>
	  <td colspan="2" align="left" valign="top"><br /><br />			    
		
	  </td>	
	  <td>&nbsp;</td>			  
	</tr>
	<tr>
	  <td align="left" valign="center">		    
		<span class="tell_lables"><b>Send to:</b></span>
	  </td>	
	  <td align="left" valign="top">
		<input type="text" name="tell_name" value="" class="big_input"/> 				
	  </td>	
	   <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>		  
	</tr>
	<tr><td colspan="3">&nbsp;</td></tr>
	<tr>
	  <td align="left" valign="center">		    
		<span class="tell_lables"><b>Subject:</b></span>
	  </td>	
	  <td align="left" valign="top">
		<input type="text" name="tell_subj" value="" class="big_input"/> 				
	  </td>	
	   <td>&nbsp;</td>		  
	</tr>
	<tr><td colspan="3">&nbsp;</td></tr>
	<tr>
	  <td align="left" valign="top">		    
		<span class="tell_lables"><b>Message:</b>&nbsp;&nbsp;&nbsp;&nbsp;</span>
	  </td>	
	  <td align="left" valign="top">
		<textarea name="tell_text" class="big_input_area">Hi. 
		
I would like show you this product <a href="{$site_url}{if $ap_contact_type==1}product{else}wproduct{/if}.php?ID={$book.ID}">{$book.Title|escape:'html'}</a></textarea> 				
	  </td>	
	   <td>&nbsp;</td>		  
	</tr>
	<tr><td colspan="3">&nbsp;</td></tr>
	<tr>
	  <td align="left">&nbsp;		    
		
	  </td>	
	  <td align="right" valign="top">
		<a href="javascript:void(0);" onclick="document.tellafriends_form.submit();"><img src="/{$template_path}img/tellafriends_butt.gif" /></a>
		&nbsp;&nbsp;&nbsp;&nbsp;		
	  </td>	
	   <td>&nbsp;</td>		  
	</tr>
  </table>
</form>
</div>
</div>
</div>
