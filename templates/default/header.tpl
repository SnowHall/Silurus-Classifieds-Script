<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
	<title>{$site_title}</title>
	<base href="{$site_url}" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="description" content="{$site_description}" />
	<meta name="keywords" content="{$site_keywords}" />
	<link rel="shortcut icon" href="/media/settings/favicon.ico" />
	<meta http-equiv="Content-Style-Type" content="text/css" />
	<link href="/{$template_path}general.css" rel="stylesheet" type="text/css" />
	<script defer type="text/javascript">
		var template_path = '{$template_path}';
	</script>
	<!--[if lt IE 7.]>
	<script defer type="text/javascript">
		var site_url = '{$site_url}';
	</script>
	<script defer type="text/javascript" src="/include_js/pngfix.js"></script>				
	<![endif]-->
	<script defer type="text/javascript" src="/include_js/csshorizontalmenu.js"></script>	
	<script type="text/javascript" src="/include_js/ajax.js"></script>
	<script type="text/javascript" src="/include_js/main.js"></script>		
	<script type="text/javascript" src="/include_js/select.js"></script>
	<script src="/include_js/DolVoting.js" type="text/javascript" language="javascript"></script>
</head>
<body leftmargin="0" topmargin="0" marginheight="0" marginwidth="0" rightmargin="0" {if $zoomini}onload="zoom_ini()"{/if} >
<div id="div_body" style="width:100%;">
<div id="back"></div> 
<table width="100%" cellpadding="0" cellspacing="0">
  <tr height="158px">
    <td class="p_header_blue">&nbsp;</td>
	<td class="p_header" valign="top" colspan="2">
	  <table width="100%" cellpadding="0" cellspacing="0">	     	  
		<tr height="158px">
		  <td valign="center" width="330px"><br>	    
		    
		    <table  cellpadding="0" cellspacing="0">
		      <tr height="20px">
		        <td rowspan="2">
		          <a href="/"><img src="/media/settings/p_logo.png" /></a>
		        </td>
		        <td valign="bottom" style="padding-top:13px;">
		          <span style="color:#ffffff;font-size:55px;font-family:'Trebuchet MS', Helvetica, sans-serif;"><b>{$site_slogan1}</b></span>
		        </td>			                		      
		      </tr>
		      <tr>
		        <td valign="top">
		          <span style="color:#000000;font-size:24px;font-family:'Trebuchet MS', Helvetica, sans-serif;"><b>{$site_slogan2}</b></span>
		        </td>		      
		      </tr>
		    </table>
		    
		  </td>
		  <td valign="center">
		    {$insert_banner[4]}
		  </td>
		  <td valign="top" align="right">
		   {if !$memberID}
				  <form name="login_form" action="/member.php" method="POST">
				  <input type="hidden" name="backurl" value="{$_SERVER.REQUEST_URI}">
				  <table>
				    <tr>		 
					  <td colspan="2" align="left">
					  	<span style="color:#2d4f94"><b>Member Login</b></span>
					  </td>
					  <td width="10px">&nbsp;				  			    
					  </td>
					  </tr>
				    <tr>		 
					  <td colspan="2" align="left">
					  	<input type="text" name="ID" value="Username" class="login_input" onblur="if(!value)value=defaultValue" onclick="if(value==defaultValue)value=''"/>				  	
					  </td>
					  <td width="10px">&nbsp;				  			    
					  </td>
					  </tr>
					  <tr>		 
					  <td colspan="2" align="left">				  	
					  	<input type="password" name="Password" value="000000" class="login_input" onblur="if(!value)value=defaultValue" onclick="if(value==defaultValue)value=''"/>
					  </td>
					  <td width="10px">&nbsp;				  			    
					  </td>
					  </tr>
					  <tr>
					  <td  align="left">
					  	<a href="javascript:void(0);" onclick="document.login_form.submit();"><img src="/{$template_path}img/login.gif" /></a>
					  </td>
					  <td align="center">
					  	<a href="/join_form.php"><img src="/{$template_path}img/register.gif" /></a>
					  </td>
					  <td width="10px">&nbsp;				  			    
					  </td>
					</tr>
				  </table>
				</form> 
				{/if}  
		    <div class="welcome_header">
	          	        
		    {if $memberID}<br><br>
		      <span class="p_welcome"><b>Welcome, {$memberINFO.fname} {$memberINFO.lname}!</b></span>&nbsp;&nbsp;<br><br>
			  <a href="/member.php?member_logout"><img src="/{$template_path}img/logout.gif"  align="absmiddle"/></a>&nbsp;&nbsp;			
			{/if}  
			  
			</div>
		  </td>
		</tr>
	  </table> 
	</td>	
  </tr>  
  
  <tr height="48px">
    <td class="header_inner">&nbsp;</td>
    <td class="header_inner" valign="top">
	<div class="horizontalcssmenu">
	  <ul id="cssmenu1">
	    {assign var="tr" value=0}
	    {foreach from=$topmenu item=oMenu} 
	    {assign var="tr" value=$tr+1}
	    
	    <li><a class="p_menu" href="/{$oMenu.Url}"><nobr><img src="/{$template_path}img/icons/{$oMenu.Photo}" border=0 align="left"/> {$oMenu.Title}</nobr></a>
	    {if count($oMenu.list)>0}
			<ul>
			
			  {assign var="tr" value=0}
		      {foreach from=$oMenu.list item=sMenu} 
		      {assign var="tr" value=$tr+1}		      
		       <li><a href="/{$sMenu.Url}" class="{if $tr==1}top_{else}{if $tr==count($oMenu.list)}bottom_{/if}{/if}menu_item">{$sMenu.Title}</a></li>		      
		      {/foreach}
		      
			</ul>
		</li>
		{/if}
		
		{if $tr<count($topmenu)}
		<li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="/{$template_path}img/inner_menu_sep.gif" width="2px" height="30px"/>&nbsp;&nbsp;&nbsp;&nbsp;</li>
		{/if}
		
	    {/foreach}	    	
	  </ul>
	</div>
	</td>
	<td class="header_inner">&nbsp;</td>
  </tr>
  <tr height="4px">
    <td class="header_green" colspan="3">&nbsp;</td>
  </tr> 
  
  <tr height="62px">
    <td class="header_location_dark">&nbsp;</td>       
	<td class="header_location">		
	<div id="change_location_popover" style="display:none;">
	<div class="change_location_popover_cont">
	<div style="position:relative;width:100%;" align="left">
	<form name="change_loc_form">
	<input type="hidden" name="change_loc_go" value="1">
	  <table width="400px" cellpadding="0" cellspacing="0">
	    <tr>
		  <td colspan="2" align="left" valign="top" class="change_location_title">				    
		  	Change Location
		  </td>
		  <td align="right" valign="top">
		    <a href="javascript:void(0);" onclick="whitesite(); document.getElementById('change_location_popover').style.display='none';"><img src="/{$template_path}img/clear.gif" width="40px" height="30px" /></a>
		  </td>
		</tr>
		<tr>
		  <td colspan="2" align="left" valign="top"><br />			    
		  	<span class="main_login_mail"><i>To change the geographic area in which to see ads, select 'Type' of area then type in the name of the area, e.g. 21021,  or Boston.</i></span><br /><br />
		  </td>	
		  <td>&nbsp;</td>			  
		</tr>
		<tr height="40px">
		  <td align="left" valign="top">		    
		  	<span class="main_login_mail"><b>Type:</b></span>
		  </td>	
		  <td align="right" valign="top">
		    <input type="radio" name="loc_type" id="loc_type_city" value="1" checked/> City &nbsp;&nbsp;
			<input type="radio" name="loc_type" value="2" /> ZIP code
		  </td>	
		   <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>		  
		</tr>
		<tr height="40px">
		  <td align="left" valign="top">		    
		  	<span class="main_login_mail"><b>Name:</b></span>
		  </td>	
		  <td align="right" valign="top">
		    <input type="text" name="loc_name" value="" id="autoenter_value2" style="width:275px" onkeyup="if(document.getElementById('loc_type_city').checked)getcitylist('2')"/> <br>
		    <div align=left><div style="width:280px;position:absolute;display:none;padding-left:35px;" id="autoenter_div2"></div></div>
		  </td>	
		   <td>&nbsp;</td>		  
		</tr>
		<tr>
		  <td align="left">&nbsp;		    
		  	
		  </td>	
		  <td align="right" valign="top">
		    <a href="javascript:void(0);" onclick="document.change_loc_form.submit();"><img src="/{$template_path}img/change_location_butt.gif" /></a>		
		  </td>	
		   <td>&nbsp;</td>		  
		</tr>
	  </table>
	</form>
	</div>
	</div>
	</div>				
			
	<form name="search_form" method="GET" action="/search.php">
	<input type="hidden" name="go">
	  <table align="left" width="100%" cellpadding="0" cellspacing="0">
	    <tr height="31px">
	      <td rowspan="2" width="94px"><img src="/{$template_path}img/location_ico.gif" style="vertical-align:bottom"></td> 
		  <td width="400px" class="header_location_ver">
		    <span class="big_location"><b>{if $_SESSION.location.title}{$_SESSION.location.title}{else}EVERYWHERE{/if}</b></span>
		  </td>		
		  <td rowspan="2" width="4px"><img src="/{$template_path}img/zoom.png"></td>   
		  <td align="left" width="170px">	
		    <span style="color:#626262;"><b>Search for Products:</b></span>			
		  </td>
		  <td align="left">	
		    <a href="/search.php" style="color:#3e6cbb;font-family:Arial;text-decoration:none;font-size:12px;"><b>Advanced Search</b></a>			
		  </td>
		  <td align="left">	
		    
		  </td>
		</tr>
		
		<tr height="31px">	      
		  <td width="400px" class="header_location_ver">		    
		    <a href="javascript:void(0);" onclick="blacksite();document.getElementById('change_location_popover').style.display='block';"><img src="/{$template_path}img/p_change_location.gif" /></a>	
		  </td>

		  <td align="left" style="padding-bottom:8px;">	
		    <input type="text" name="keywords" value="{$_REQUEST.keywords}" class="login_input" style="width:150px;height:16px;"/>	
		  </td>
		  <td align="left" width="200px" >
		    <select name="categoryID" class="select" id="selectid">
		        <option value="0">Select Category</option>
		          {$bookcategory}
			</select>
		  </td>
		  <td style="padding-bottom:5px;">	
		    <a href="javascript:void(0);" onclick="document.search_form.submit();"><img src="/{$template_path}img/search_go.gif" border=0 style="vertical-align:top"/></a>
		  </td>
		</tr>
	  </table>
	  </form>
	</td>	
	<td class="header_location">&nbsp;</td>
  </tr>  
 
  <tr>
    <td>&nbsp;</td>
	<td>
	  <table width="100%" cellpadding="0" cellspacing="0">
	    <tr height="50px">
		  <td align="left">	
		    <table width="100%" cellpadding="0" cellspacing="0">
			  <tr>
			    <td><span class="big_h4"><b>{$HEADERTEXT}</b></span></td>
				<td align="right" class="nav_chain">
				  {include file='top_navigation.tpl' aNavi=$aNavi}	
				</td>
			  </tr>
			</table>	     			 
		  </td>
	    </tr>
	    <tr height="270px">
		  <td class="main_content_center" align="left" valign="top">
		  