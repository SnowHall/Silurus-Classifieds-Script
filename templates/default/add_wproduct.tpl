{include file='header.tpl'}

<form name="book_wanted_form" method="POST" enctype="multipart/form-data">
<table width="100%" cellpadding="0" cellspacing="0">
  <tr height="35px">
    <td width="220px" style="background:#e6e5e5;">
	  &nbsp;&nbsp;&nbsp;&nbsp;<span class="big_verdana">Required Information:</span>
	</td>
	<td  style="background:#e6e5e5;">&nbsp;</td>
	<td width="20px">&nbsp;</td>
	<td width="280px">
	  {if $props && !empty($props)}
	  &nbsp;&nbsp;&nbsp;&nbsp;<span class="big_verdana">Optional Information:</span>
	  {/if}
	</td>
	<td>&nbsp;</td>	
  </tr>
  <tr>
    <td colspan="2" class="book_tab" style="background:#e6e5e5;" valign="top">
	  <table width="100%">
	    <tr>
	      <td>
	        Title<br>
	         <input type="text" style="{if $_SERVER.REQUEST_METHOD=='POST'&&$_REQUEST.Title==''}background:#ff0000;{/if}width:420px" name="Title" value="{$_REQUEST.Title|escape:'html'}" />
	      </td>
	    </tr>
	    <tr><td>&nbsp; </td></tr>
	    {if !$_REQUEST.ID}
	    <tr>
	      <td>
	        Category<br>
	        <select name="categoryID" style="width:420px;" onchange="window.location='{$_SERVER.PHP_SELF}?categoryID='+this.value;">
			  {$categ_list}
			</select>
	      </td>
	    </tr>
	    <tr><td>&nbsp; </td></tr>
	    {/if}
	    <tr>
	      <td>
	        Price<br>
	        <b>$ </b><input type="text" style="{if $_SERVER.REQUEST_METHOD=='POST'&&$_REQUEST.price==''}background:#ff0000;{/if}width:420px" name="price" value="{$_REQUEST.price|escape:'html'}" />
	      </td>
	    </tr>
	    <tr><td>&nbsp; </td></tr>
	  {foreach from=$req_props item=oItem} 
	    <tr>
	      <td  style="{if $oItem.Type==7}{$oItem.color}th{/if}">
	        {$oItem.Name}<br>
	        {if $oItem.Type==1}
	          <input type="text" style="{$oItem.color}width:420px" name="prop{$oItem.ID}" value="{$oItem.entered|escape:'html'}" />
	        {/if}
	        {if $oItem.Type==2}
	          <textarea name="prop{$oItem.ID}" style="{$oItem.color}width:420px;height:100px">{$oItem.entered|escape:'html'}</textarea>
	        {/if}
	        {if $oItem.Type==3}
	          {if $oItem.error && $oItem.error!=''}<font color=red>{$oItem.error}</font><br>{/if}
	           <table width="100%" style="padding-top:10px;">
				  <tr><td>{if $oItem.photo!=''}<img src="/media/store/small_{$oItem.photo}" style="width:50px;"><br><input type="checkbox" name="delphoto{$oItem.ID}" value="1"> delete{/if}</td><td><input type="file" name="prop{$oItem.ID}" style="width:320px"/></td></tr>				  
			  </table>
	        {/if}
	        {if $oItem.Type==4}
	          {$oItem.subprop}
	        {/if}
	        {if $oItem.Type==5}
	            <select name="prop{$oItem.ID}" style="{$oItem.color}width:420px;" >
				  {foreach from=$oItem.subprop item=oSub} 
				    <option value="{$oSub.ID}" {if $oSub.ID==$oItem.entered}selected{/if}>{$oSub.Name}</option>
				  {/foreach}
				</select>
	        {/if}
	        {if $oItem.Type==6}
	          <select name="prop{$oItem.ID}[]" style="{$oItem.color}width:420px;height:100px;" multiple>
				  {foreach from=$oItem.subprop item=oSub} 
				    <option value="{$oSub.ID}" {if is_array($oItem.entered)&&in_array($oSub.ID,$oItem.entered)}selected{/if}>{$oSub.Name}</option>
				  {/foreach}
			  </select>
	        {/if}
	        {if $oItem.Type==7}
	              {foreach from=$oItem.subprop item=oSub} 
				    <input type="checkbox" name="prop{$oItem.ID}[]" value="{$oSub.ID}" {if is_array($oItem.entered)&&in_array($oSub.ID,$oItem.entered)}checked{/if}>{$oSub.Name} &nbsp;
				  {/foreach}
	        {/if}
	      </td>
	    </tr>	    
	    <tr><td>&nbsp; </td></tr>
	  {/foreach}	
	  {if !$_REQUEST.ID && $_GCONFIG.capcha_item==1}
	    <tr>
	      <td>
	        Enter what you see:<br>
			  <img alt="Security Image" src="/simg/simg.php" /><br>
			  <input name="securityImageValue" type="text" size="15" style="{if $securityImageValueError}background:#ff0000;{/if}"> 
	      </td>
	    </tr>
	    <tr><td>&nbsp; </td></tr>
	    {/if}    
	  </table> 
	</td>
	<td width="20px">&nbsp;</td>
	
	<td colspan="2" class="book_tab" valign="top">
	{if $props && !empty($props)}
	  <table width="100%">
	  {foreach from=$props item=oItem} 
	    <tr>
	      <td>
	        {$oItem.Name}<br>
	        {if $oItem.Type==1}
	          <input type="text" style="{$oItem.color}width:180px" name="prop{$oItem.ID}" value="{$oItem.entered|escape:'html'}" />
	        {/if}
	        {if $oItem.Type==2}
	          <textarea name="prop{$oItem.ID}" style="{$oItem.color}width:420px;height:100px">{$oItem.entered|escape:'html'}</textarea>
	        {/if}
	        {if $oItem.Type==3}
	          {if $oItem.error && $oItem.error!=''}<font color=red>{$oItem.error}</font><br>{/if}
	           <table width="100%" style="padding-top:10px;">
				  <tr><td>{if $oItem.photo!=''}<img src="/media/store/small_{$oItem.photo}" style="width:50px;"><br><input type="checkbox" name="delphoto{$oItem.ID}" value="1"> delete{/if}</td><td><input type="file" name="prop{$oItem.ID}" style="width:320px"/></td></tr>				  
			  </table>
	        {/if}
	        {if $oItem.Type==4}
	          {$oItem.subprop}
	        {/if}
	        {if $oItem.Type==5}
	            <select name="prop{$oItem.ID}" style="{$oItem.color}width:420px;" >
				  {foreach from=$oItem.subprop item=oSub} 
				    <option value="{$oSub.ID}" {if $oSub.ID==$oItem.entered}selected{/if}>{$oSub.Name}</option>
				  {/foreach}
				</select>
	        {/if}
	        {if $oItem.Type==6}
	          <select name="prop{$oItem.ID}[]" style="{$oItem.color}width:420px;" multiple>
				  {foreach from=$oItem.subprop item=oSub} 
				    <option value="{$oSub.ID}" {if is_array($oItem.entered)&&in_array($oSub.ID,$oItem.entered)}selected{/if}>{$oSub.Name}</option>
				  {/foreach}
			  </select>
	        {/if}
	        {if $oItem.Type==7}
	              {foreach from=$oItem.subprop item=oSub} 
				    <input type="checkbox" name="prop{$oItem.ID}[]" value="{$oSub.ID}" {if is_array($oItem.entered)&&in_array($oSub.ID,$oItem.entered)}checked{/if}>{$oSub.Name} &nbsp;
				  {/foreach}
	        {/if}
	      </td>
	    </tr>
	    <tr><td>&nbsp; </td></tr>
	  {/foreach}	    
	  </table>   
	  {/if}	
	</td>
	
  </tr>
    
  <tr>
    <td colspan="2" style="background:#e6e5e5;">&nbsp;	
	  
	</td>
	<td width="20px">&nbsp;</td>
  </tr>
  
  <tr>
    <td colspan="5">
	  <br /><br /><div class="dotted_line"></div>
    </td>
  </tr>
  <tr>
    <td align="right" colspan="5"><br />       
	   <a href="/profile.php"><img src="/{$template_path}img/prof_edit_back.gif" border="0" /></a>&nbsp;&nbsp;
	   <a href="javascript:void(0);" onclick="document.book_wanted_form.submit();"><img src="/{$template_path}img/book_post_go.gif" border="0" /></a>
    </td>
  </tr>
</table>  
</form>						

	     
{include file='footer.tpl'}		