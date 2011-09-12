{include file='header.tpl'}

{if !isset($_REQUEST.go)}

<form name="search_book_adv">
<input type="hidden" name="go">
<table width="100%" cellpadding="0" cellspacing="0">
   
   <tr >
    <td  width="470px" class="formback" valign="top">
	  <table width="100%" cellpadding="0" cellspacing="0">
	  
	  {assign var="tr" value=0}
	  {foreach from=$props item=oItem} 
	   	 {if $tr==0}
	   	   <tr>
		    <td class="small_grey" width="200px" valign="top">
			  Category:
			</td>
			<td width="300px">
		        <select name="categoryID" style="width:250px;" onchange="window.location='{$_SERVER.PHP_SELF}?categoryID='+this.value;">
				  {$categ_list}
				</select><br><br>
			</td>			
		  </tr>
	   	 {/if}
	   	 {assign var="tr" value=$tr+1}   	  
		  
	   	 <tr>
	      <td class="small_grey">
			  {$oItem.Name}
		  </td>
		  <td>
	        {if $oItem.Type==4}
	          {$oItem.subprop}<br>
	        {/if}        
	        {if $oItem.Type==6 || $oItem.Type==5}
	          <select name="prop{$oItem.ID}[]" style="width:250px;height:100px;" multiple>
				  {foreach from=$oItem.subprop item=oSub} 
				    <option selected value="{$oSub.ID}" >{$oSub.Name}</option>
				  {/foreach}
			  </select><br>
	        {/if}
	        {if $oItem.Type==7}
	              {foreach from=$oItem.subprop item=oSub} 
				    <input type="checkbox" name="prop{$oItem.ID}[]" value="{$oSub.ID}" checked>{$oSub.Name}<br>
				  {/foreach}
	        {/if}<br>
	      </td>
	      </tr>	    
	      
	      {if $tr>=count($props)/2} 
	      {assign var="tr" value=-5}   	  
			 </table>
			</td>
			<td width="50px">&nbsp;</td>
			<td  width="470px" class="formback" valign="top">
			  <table width="100%" cellpadding="0" cellspacing="0">
			  
			    <tr>		    
				 <td class="small_grey" width="200px" valign="top">
				  Keywords:
				 </td>
				 <td width="300px">
				  <input type="text" name="keywords" style="width:250px" /><br><br>
				 </td>
			   </tr>
		  {/if}	 
		      
	  {/foreach}
	  {if count($props) == 0} 
	    <tr>
		    <td class="small_grey" width="200px" valign="top">
			  Category:
			</td>
			<td width="300px">
		        <select name="categoryID" style="width:250px;" onchange="window.location='{$_SERVER.PHP_SELF}?categoryID='+this.value;">
				  {$categ_list}
				</select><br><br>
			</td>			
		  </tr>
		  </table>
		</td>
		<td width="50px">&nbsp;</td>
		<td  width="470px" class="formback" valign="top">
		  <table width="100%" cellpadding="0" cellspacing="0">
		  
		    <tr>		    
			 <td class="small_grey" width="200px" valign="top">
			  Keywords:
			 </td>
			 <td width="300px">
			  <input type="text" name="keywords" style="width:250px" /><br><br>
			 </td>
		   </tr>
	  {/if} 
	  
	  </table>
	</td>
  </tr> 
  
  
  
  <tr>
    <td colspan="5">
	  <br /><br /><div class="dotted_line"></div>
    </td>
  </tr>
  
  <tr>
    <td align="right" colspan="5"><br />
	   <a href="javascript:void(0);" onclick="document.search_book_adv.submit();"><img src="/{$template_path}img/search_start.gif" border="0" /></a>
    </td>
  </tr>
</table>
</form>		

{else}

<table width="100%">
  <tr>
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
	    <td><b>Search Items for Sale:</b> </td>
		<td><input type="text" name="keywords" value="{$_REQUEST.keywords}"/> </td>
		<td>
		  <select name="categoryID" >
		        <option value="0">Select Category</option>
		          {$bookcategory}
			</select>
		</td>
		<td><a href="javascript:void(0);" onclick="document.search_form2.submit();"><img src="/{$template_path}img/search_go.gif" border="0" /></a> </td>
		<td> <b>Or, post an add for a <a href="/add_wproduct.php" style="color:#2d4f94;font-size:17px;">Items Wanted</a></b></td>
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
				     
{/if}

{include file='footer.tpl'}		