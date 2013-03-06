<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
	<title>{$site_title}</title>
	<base href="" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="description" content="{$site_description}" />
	<meta name="keywords" content="{$site_keywords}" />
	<meta http-equiv="Content-Style-Type" content="text/css" />
	<link rel="shortcut icon" href="media/settings/favicon.ico" />
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
</head>

<body leftmargin="0" topmargin="0" marginheight="0" marginwidth="0" rightmargin="0">

<table width="100%" cellpadding="0" cellspacing="0">
  <tr height="30px">
    <td class="header1">
	<form name="login_form" action="member.php" method="POST" target="top">
	  <table width="100%">

{if $memberID}
	  <tr>
		<td align="right" valign="top">
		  <span style="color:#555555"><b>Welcome, {$memberINFO.fname} {$memberINFO.lname}!</b></span>&nbsp;&nbsp;
		  <a href="profile.php" style="color:#555555;font-size:12px">My account</a>&nbsp;&nbsp;
		  <a href="category.php" class="f_reg"><b>Go to Catalog</b></a>&nbsp;&nbsp;
		  <a href="member.php?member_logout"><img src="{$template_path}img/logout.gif"  align="absmiddle"/></a>
		</td>
		<td width="40px">&nbsp;</td>
	  </tr>
{else}
	  <tr>
		<td>&nbsp;</td>
    <td width="120px" align="center"><a href="join_fb.php" class="f_reg"><img src="{$template_path}img/fb.png" /></a></td>
		<td width="120px" align="center">
			 <img src="{$template_path}img/member_login.gif" />
		</td>
		<td width="150px" align="center">
			<input type="text" name="ID" value="Username" class="login_input" onblur="if(!value)value=defaultValue" onclick="if(value==defaultValue)value=''"/>
		</td>
		<td width="150px" align="center">
			<input type="password" name="Password" value="000000" class="login_input" onblur="if(!value)value=defaultValue" onclick="if(value==defaultValue)value=''"/>
		</td>
		<td width="67px" align="center">
			<a href="javascript:void(0);" onclick="document.login_form.submit();"><img src="{$template_path}img/login.gif" /></a>
		</td>
		<td width="70px" align="center">
			<a href="join_form.php"><img src="{$template_path}img/register.gif" /></a>
		</td>
        {if ($fb_enable)}
		<td width="140px" align="center">
			<a href="join_fb.php" class="f_reg"><img src="{$template_path}img/fb.png" /></a>
		</td>
        {/if}
		<td width="130px" align="center">
			<a href="category.php" class="f_reg"><b>Go to Catalog</b></a>&nbsp;&nbsp;
		</td>
		<td width="40px">&nbsp;</td>
	  </tr>

	  {if isset($_REQUEST.loginerror) || isset($_REQUEST.loginblock)}
	  <tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td colspan=2 align="center" valign="top">
		      <span style="color:#ff0000;font-size:12px;">
		      {if isset($_REQUEST.loginerror)}Incorrect Login or Password{/if}
		      {if isset($_REQUEST.loginblock)}Your Account Blocked{/if}
		      </span>
		  </td>
		  <td width="67px" align="center">
		  	&nbsp;
		  </td>
		  <td width="70px" align="center">
		  	&nbsp;
		  </td>
		  <td width="40px">&nbsp;</td>
	  </tr>
	  {/if}
{/if}

 </table>
	</form>
    </td>
  </tr>
  <tr height="120px">
    <td valign="bottom">
	  <table width="100%" cellpadding="0" cellspacing="0">
	    <tr>
		  <td width="350px">
		    <table cellpadding="0" cellspacing="0">
		      <tr>
		        <td rowspan="2">
		          <a href="{$site_url}"><img src="{$template_path}img/logo.png" /></a>
		        </td>
		        <td valign="bottom">
		          <span style="color:#2d4f94;font-size:55px;font-family:'Trebuchet MS', Helvetica, sans-serif;"><b>{$site_slogan1}</b></span>
		        </td>
		      </tr>
		      <tr>
		        <td valign="top">
		          <span style="color:#000000;font-size:24px;font-family:'Trebuchet MS', Helvetica, sans-serif;"><b>{$site_slogan2}</b></span>
		        </td>
		      </tr>
		    </table>

		  </td>
		  <td>&nbsp;
		  </td>
		  <td width="340px">
			<span class="header_text">{$text_blocks[0].Text}</span>
		  </td>
		  <td>&nbsp;
		  </td>
		  <td width="190px" valign="bottom" align="right">
			&nbsp;
		  </td>
		</tr>
	  </table>
	</td>
  </tr>
  <tr height="342px">
    <td class="header3" valign="top">
	  <table width="100%" cellpadding="0" cellspacing="0">
	    <tr>
		  <td width="30px">&nbsp;

		  </td>
		  <td width="201px" class="main_infoblock" valign="top">
		    <a href="category.php"><img src="{$template_path}img/main_block1.jpg" /></a><br />
			<span class="block_info_text">List Your Product</span>
			<div class="header_line"></div>
			{$text_blocks[1].Text}
		  </td>
		  <td width="20px">&nbsp;

		  </td>
		  <td width="201px" class="main_infoblock" valign="top">
		    <a href="category.php"><img src="{$template_path}img/main_block2.jpg" /></a><br />
			<span class="block_info_text">Receive Offers</span>
			<div class="header_line"></div>
			{$text_blocks[2].Text}
		  </td>
		  <td width="20px">&nbsp;

		  </td>
		  <td width="201px" class="main_infoblock" valign="top">
		  <a href="category.php"><img src="{$template_path}img/main_block3.jpg" /></a><br />
			<span class="block_info_text">Get Paid</span>
			<div class="header_line"></div>
			{$text_blocks[3].Text}
		  </td>
		  <td>&nbsp;

		  </td>
		  <td align="right" valign="top">
		    &nbsp;
		  </td>
		</tr>
	  </table>
	</td>
  </tr>
  <tr>
    <td class="main_content" valign="top" align="center">
	  <table width="100%" cellpadding="0" cellspacing="0">
	    <tr>
		  <td width="20px">&nbsp;
		  </td>
		  <td class="main_content_center">
		    <table width="100%" cellpadding="0" cellspacing="0">
			  <tr>
			    <td align="left" valign="top">
				 <a href="category.php" style="color:#61a8d9;font-size:20px;"><b>Items for Sale</b></a><br>
				 <div class="recent_line"></div>

				 <table>
				  {foreach from=$recent item=oItem}
				     <tr>
				      <td width="90px" valign="top">
						  {if $oItem.img!=''}<img src="media/store/small_{$oItem.img}" width="80px">{else}<img src="{$template_path}img/empty_recent.gif" width="70px">{/if}
					  </td>
					  <td valign="top" style="color:#000099;" >
					    <b>Title: </b><a href="product.php?ID={$oItem.ID}" style="color:#000099;"><b>{$oItem.Title|escape:'html'}</b></a><br>
					    <b>Category: </b><a href="category.php?ID={$oItem.cid}" style="color:#000099;">{$oItem.ctitle|escape:'html'}</a><br>
					    <b>Owner: </b><a href="profile.php?ID={$oItem.uid}" style="color:#000099;">{$oItem.user|escape:'html'}</a>
				      </td>
				      <td width="60px" valign="center" align="center">
				        <span style="color:#cc0808;"><b>{$oItem.Price|format_price}</b></span><br>
				        <a href="product.php?ID={$oItem.ID}"><img src="{$template_path}img/buy.gif" border=0></a>
					  </td>
					  </tr><tr><td colspan="7">&nbsp; </td></tr>
				  {/foreach}
  				</table>
				</td>
				<td width="20px">&nbsp;

				</td>
				<td align="left" valign="top">
				 <a href="wcategory.php" style="color:#61a8d9;font-size:20px;"><b>Items Wanted</b></a><br>
				 <div class="recent_line"></div>

				 <table>
				  {foreach from=$wrecent item=oItem}
				     <tr>
				      <td width="90px" valign="top">
						  {if $oItem.img!=''}<img src="media/store/small_{$oItem.img}" width="80px">{else}<img src="{$template_path}img/empty_recent.gif" width="70px">{/if}
					  </td>
					  <td valign="top" style="color:#000099;" >
					    <b>Title: </b><a href="wproduct.php?ID={$oItem.ID}" style="color:#000099;"><b>{$oItem.Title|escape:'html'}</b></a><br>
					    <b>Category: </b><a href="wcategory.php?ID={$oItem.cid}" style="color:#000099;">{$oItem.ctitle|escape:'html'}</a><br>
					    <b>Owner: </b><a href="wprofile.php?ID={$oItem.uid}" style="color:#000099;">{$oItem.user|escape:'html'}</a>
				      </td>
				      <td width="60px" valign="center" align="center">
				        <span style="color:#cc0808;"><b>{$oItem.Price|format_price}</b></span><br>
				        <a href="wproduct.php?ID={$oItem.ID}"><img src="{$template_path}img/buy.gif" border=0></a>
					  </td>
					  </tr><tr><td colspan="7">&nbsp; </td></tr>
				  {/foreach}
  				</table>


				</td>
				<td width="40px">&nbsp;

				</td>
{if !$memberID}
			    <td align="right" class="main_login_block">
				<form name="big_login_main" action="member.php" method="POST">
				  <table width="80%" cellpadding="0" cellspacing="0">
				    <tr>
					  <td align="left" colspan="2">
					    <img src="{$template_path}img/member_login_big.gif" />
					  </td>
					</tr>
					<tr>
					  <td align="left" class="main_login_mail">
					    Username
					  </td>
					  <td align="right" class="main_login_mail">
					    <img src="{$template_path}img/arr.gif" />&nbsp;&nbsp;<a href="forgot.php" class="f_pass">Forgot Username?</a>
					  </td>
					</tr>
					<tr>
					  <td align="left" colspan="2" class="main_login_mail">
					    <input type="text" name="ID" value="" class="login_input_big"/>
					  </td>
					</tr>
					<tr>
					  <td align="left" class="main_login_mail">
					    Password
					  </td>
					  <td align="right" class="main_login_mail">
					    <img src="{$template_path}img/arr.gif" />&nbsp;&nbsp;<a href="forgot.php" class="f_pass">Forgot Password?</a>
					  </td>
					</tr>
					<tr>
					  <td align="left" colspan="2" class="main_login_mail">
					    <input type="password" name="Password" value="" class="login_input_big"/>
					  </td>
					</tr>
					<tr height="45px">
					  <td align="left" colspan="2" class="main_login_mail" valign="bottom">
					  {if isset($_REQUEST.loginerror)}<span style="color:#ff0000;font-size:12px;">Incorrect Login or Password</span><br><br>{/if}
		      		  {if isset($_REQUEST.loginblock)}<span style="color:#ff0000;font-size:12px;">Your Account Blocked</span><br><br>{/if}
					    <input type="checkbox" name="rememberme" value="1"> Remember Me &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					    <a href="javascript:void(0);" onclick="document.big_login_main.submit();"><img align="right" src="{$template_path}img/login_big.gif" /></a>
					  </td>
					</tr>
					<tr>
					  <td align="left" colspan="2" class="main_login_mail">
					    <br />
              <nobr><span class="big_h2"><b>Want to join?</b></span>
						&nbsp;&nbsp;<img src="{$template_path}img/arr_big.gif" />&nbsp;&nbsp;<a href="join_form.php" class="f_reg"><b>Register Here</b></a>
						</nobr>
            <br />
            <div class="fb-login">
              <span>or use </span>
              <a href="join_fb.php" class="f_reg"><img style="width: 100px;" src="{$template_path}img/fb.png" /></a>
            </div>
						<br /><br />
					  </td>
					</tr>
				  </table>
				</form>
				</td>
{else}
				<td align="right">{$insert_banner[2]}</td>
{/if}

			     </tr>
				</table>
			  </td>
			  <td width="20px">&nbsp;

			  </td>
			</tr>
			<tr height="30px"><td colspan="5">&nbsp;</td></tr>
			<tr>
			 <td width="20px">&nbsp;

			 </td>
			 <td colspan="3">
			  <table width="100%" cellpadding="0" cellspacing="0">
				<tr>
				  <td valign="top" align="left">
					<span class="small_grey">{$text_blocks[7].Text}</span>
				  </td>
				  <td width="50">&nbsp;

				  </td>
				  <td valign="top" class="footer_menu_main" align="right" nowrap>
					<a href="simple.php?ID=1" class="f_pass">Terms of Use</a>&nbsp;&nbsp;| &nbsp;&nbsp;
					<a href="simple.php?ID=2" class="f_pass">Privacy Policy</a>&nbsp;&nbsp;|&nbsp;&nbsp;
					<a href="simple.php?ID=3" class="f_pass">About Us</a>&nbsp;&nbsp;|&nbsp;&nbsp;
					<a href="faq.php" class="f_pass">FAQ</a>&nbsp;&nbsp;|&nbsp;&nbsp;
					<a href="simple.php?ID=5" class="f_pass">Contact Us</a>&nbsp;&nbsp;
					{if !$memberID}|&nbsp;&nbsp;<a href="join_form.php" class="f_pass">Sign Up</a> &nbsp;&nbsp;&nbsp;{/if}
				  </td>
				</tr>
			  </table>
			 </td>
			 <td width="20px">&nbsp;

			 </td>
			</tr>
		  </table>
		</td>
	  </tr>
	  <tr height="30px">
	    <td>&nbsp;

	    </td>
	  </tr>
	  <tr height="30px">
	    <td class="footer_main" align="right" valign="top">&nbsp;
	    <span style="color:#2d4f94;font-size:13px;"> Powered by <a href="http://snowhall.com/slides/silurus" style="color:#2d4f94;font-size:13px;">Silurus Free Classifieds Script</a> </span>
		  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	    </td>
	  </tr>
	</table>

	</body>
</html>
