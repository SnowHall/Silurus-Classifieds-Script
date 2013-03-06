<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
	<title>{$site_title}</title>
	<base href="{$site_url}" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="description" content="{$site_description}" />
	<meta name="keywords" content="{$site_keywords}" />
	<link rel="shortcut icon" href="media/settings/favicon.ico" />
	<meta http-equiv="Content-Style-Type" content="text/css" />
	<link href="{$template_path}general.css" rel="stylesheet" type="text/css" />
	<script defer type="text/javascript">
		var template_path = '{$template_path}';
	</script>
	<!--[if lt IE 7.]>
	<script defer type="text/javascript">
		var site_url = '{$site_url}';
	</script>
	<script defer type="text/javascript" src="include_js/pngfix.js"></script>
	<![endif]-->
	<script defer type="text/javascript" src="include_js/csshorizontalmenu.js"></script>
	<script type="text/javascript" src="include_js/ajax.js"></script>
	<script type="text/javascript" src="include_js/main.js"></script>
	{*<script type="text/javascript" src="include_js/select.js"></script>*}
	<script src="include_js/DolVoting.js" type="text/javascript" language="javascript"></script>
</head>
<body leftmargin="0" topmargin="0" marginheight="0" marginwidth="0" rightmargin="0" {if $zoomini}onload="zoom_ini()"{/if} >
<div id="div_body" style="width:100%;">
<div id="back"></div>
<table width="100%" cellpadding="0" cellspacing="0">
  <tr height="67px">
    <td class="header">
	  <table width="100%" cellpadding="0" cellspacing="0">
	    <tr height="67px">
		  <td class="header_2">
		      <table width="100%" cellpadding="0" cellspacing="0">
			    <tr height="67px">
				  <td class="logo" valign="middle">
				    <a href="{$site_url}"><img src="{$template_path}img/logo.png" /></a>
				  </td>
				  <td width="400px" align="left">

				{if $memberID}

					<form name="login_form" action="member.php" method="POST">
					  <table width="370px" cellpadding="0" cellspacing="0">
					  <tr>
						<td align="center">
							<span style="color:#fff"><b>Welcome, {$memberINFO.fname} {$memberINFO.lname}!</b></span>
						</td>
						<td align="right">
							<a href="category.php"><img src="{$template_path}img/register.gif" /></a>
						</td>
						<td align="left">&nbsp;
							<a href="category.php" class="login_link">Go to Catalog</a>
						</td>
					  </tr>
					  <tr>
						<td  align="center">
						    <a href="profile.php" style="color:#fff;font-size:12px"><b>My account</b></a>
						</td>
						<td align="right">
						    <a href="member.php?member_logout"><img src="{$template_path}img/login.gif" /></a>
						</td>
						<td align="left">&nbsp;
						    <a href="member.php?member_logout" class="login_link">Log Out</a>
						</td>
					  </tr>
					  </table>
					</form>

				{else}
					<form name="login_form" action="member.php" method="POST">
					  <table width="370px" cellpadding="0" cellspacing="0">
					  <tr>
						<td style="color:#dadada;" width="110px"><b>Member Login</b></td>
						<td align="center">
							<input type="text" name="ID" value="Username" class="login_input" onblur="if(!value)value=defaultValue" onclick="if(value==defaultValue)value=''"/>
						</td>
						<td align="right">
							<a href="join_form.php"><img src="{$template_path}img/register.gif" /></a>
						</td>
						<td align="left">&nbsp;
							<a href="join_form.php" class="login_link">Register</a>
						</td>
					  </tr>
					  <tr>
						<td align="center">
							{if isset($_REQUEST.loginerror) || isset($_REQUEST.loginblock)}
							      <span style="color:#ff0000;font-size:12px;"><b>
							      {if isset($_REQUEST.loginerror)}Incorrect Data{/if}
							      {if isset($_REQUEST.loginblock)}Your Account Blocked{/if}
							      </b></span>
							  {else}
							  	&nbsp;
							  {/if}
						</td>
						<td  align="center">
						    <input type="password" name="Password" value="000000" class="login_input" onblur="if(!value)value=defaultValue" onclick="if(value==defaultValue)value=''"/>

						</td>
						<td align="right">
						    <a href="javascript:document.login_form.submit();"><img src="{$template_path}img/login.gif" /></a>
						</td>
						<td align="left">&nbsp;
						    <a href="javascript:document.login_form.submit();" class="login_link">Log In</a>
						</td>
					  </tr>
					  </table>
					</form>

					{/if}

				  </td>
				</tr>
			  </table>
		  </td>
		</tr>
	  </table>
	</td>
  </tr>

  <tr height="33px">
    <td class="header_inner" valign="top">
    <form name="search_form" method="GET" action="/search.php">
    <input type="hidden" name="go">
    <table width="100%" cellpadding="0" cellspacing="0">
    <tr>
    <td width="10px">&nbsp;</td>
    <td>
		<div class="horizontalcssmenu">
		  <ul id="cssmenu1">
		    {assign var="tr" value=0}
		    {foreach from=$topmenu item=oMenu}
		    {assign var="tr" value=$tr+1}

		    <li><a class="p_menu" href="{$oMenu.Url}"><nobr><img src="{$template_path}img/icons/{$oMenu.Photo}" border=0 align="absmiddle"/> {$oMenu.Title}</nobr></a>
		    <ul>
		    {if count($oMenu.list)>0}

				  {assign var="tr" value=0}
			      {foreach from=$oMenu.list item=sMenu}
			      {assign var="tr" value=$tr+1}
			       <li><a href="{$sMenu.Url}" class="{if $tr==1}top_{else}{if $tr==count($oMenu.list)}bottom_{/if}{/if}menu_item">{$sMenu.Title}</a></li>
			      {/foreach}

			{/if}
			</ul>
			</li>

			{if $tr<count($topmenu)}
			<li>&nbsp;&nbsp;<img src="{$template_path}img/inner_menu_sep.gif" width="2px" height="25px"/>&nbsp;&nbsp;</li>
			{/if}

		    {/foreach}
		  </ul>
		</div>
	</td>
	<td width="150px">
		<input type="text" name="keywords" value="{$_REQUEST.keywords}" class="login_input" style="width:140px;height:16px;"/>
	</td>
	<td width="30px">
		<a href="javascript:document.search_form.submit();"><img src="{$template_path}img/search_go.gif" border=0 style="vertical-align:top"/></a>
	</td>
	<td width="115px" align="right">
		<a href="search.php" style="color:#dadada;font-family:Arial;text-decoration:none;font-size:12px;"><b>Advanced Search</b></a>
	</td>
	<td width="10px">&nbsp;</td>
	</tr>
	</table>
	</form>
	</td>
  </tr>

  <tr height="35px">
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
		    <a href="javascript:void(0);" onclick="whitesite(); document.getElementById('change_location_popover').style.display='none';"><img src="{$template_path}img/clear.gif" width="40px" height="30px" /></a>
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
		    <input type="radio" name="loc_type" id="loc_type_city" value="1" checked/> <span class="main_login_mail"><b>City &nbsp;&nbsp;</b></span>
			<input type="radio" name="loc_type" value="2" /> <span class="main_login_mail"><b>ZIP code</b></span>
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
		    <a href="javascript:void(0);" onclick="document.change_loc_form.submit();"><img src="{$template_path}img/change_location_butt.gif" /></a>
		  </td>
		   <td>&nbsp;</td>
		</tr>
	  </table>
	</form>
	</div>
	</div>
	</div>

	  <table align="left" width="100%" cellpadding="0" cellspacing="0">
	    <tr height="35px">
	      <td width="10px">&nbsp;</td>
		  <td>
		    <span class="big_location"><b>{if $_SESSION.location.title}{$_SESSION.location.title}{else}EVERYWHERE{/if}</b></span>
		  </td>
		  <td>
		    <a href="javascript:void(0);" onclick="blacksite();document.getElementById('change_location_popover').style.display='block';"><img src="{$template_path}img/p_change_location.gif" /></a>
		  </td>
		  <td width="10px">&nbsp;</td>
		</tr>
	  </table>

	</td>
  </tr>

  <tr>
	<td>
	  <table width="100%" cellpadding="0" cellspacing="0">
	    <tr height="270px">
		  <td class="main_content_center" align="left" valign="top">

	{if !isset($header)}
	  <table width="100%" cellpadding="0" cellspacing="0">
        <tr height="46px">
          <td colspan="3">
            <table width="100%" cellpadding="0" cellspacing="0">
        	  <tr height="46px">
        	      <td valign="top" width="8px" style="background:url({$template_path}img/2block_111.gif) no-repeat bottom left;" >
		            &nbsp;
		          </td>
		          <td valign="top" style="background:url({$template_path}img/2block_112.gif) repeat-x bottom;color:#dadada;" >
		            <div style="padding-top:12px;"><b>{$HEADERTEXT}</b></div>
		          </td>
		          <td valign="top" width="30px" style="background:url({$template_path}img/2block_113.gif) no-repeat bottom left;" >
		            &nbsp;
		          </td>
		          <td style="background:url({$template_path}img/2block_12.gif) repeat-x bottom;" align="right" valign="bottom">
		            {include file='top_navigation.tpl' aNavi=$aNavi} &nbsp;<br>
		            <div class="opera"><img src="{$template_path}img/2block_13.gif" align="right"/></div>
		          </td>
        	  </tr>
        	</table>
          </td>
        </tr>
        <tr>
          <td width="12px" style="background:url({$template_path}img/block_21.gif) repeat-y left;">
            &nbsp;
          </td>
          <td><br>
            <table width="100%" cellpadding="0" cellspacing="0">
              <tr>
			     <td valign="top">
	    {/if}