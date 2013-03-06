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
	<script defer type="text/javascript" src="/include_js/pngfix.js"></script>
	<![endif]-->
	<script defer type="text/javascript" src="/include_js/csshorizontalmenu.js"></script>
	<script type="text/javascript" src="/include_js/ajax.js"></script>
	<script type="text/javascript" src="/include_js/main.js"></script>
	{*<script type="text/javascript" src="/include_js/select.js"></script>*}
	<script src="/include_js/DolVoting.js" type="text/javascript" language="javascript"></script>
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

  <tr>
    <td class="header_img">

    	<table width="100%" cellpadding="0" cellspacing="0">
		    <tr>
			  <td width="30px">&nbsp;

			  </td>
			  <td width="301px" class="main_infoblock" valign="top">
			    <a href="category.php"><img src="{$template_path}img/main_block1.jpg" /></a><br />
				<span class="block_info_text">List Your Product</span>
				<div class="header_line"></div>
				{$text_blocks[1].Text}
			  </td>
			  <td width="20px">&nbsp;

			  </td>
			  <td width="301px" class="main_infoblock" valign="top">
			    <a href="category.php"><img src="{$template_path}img/main_block2.jpg" /></a><br />
				<span class="block_info_text">Receive Offers</span>
				<div class="header_line"></div>
				{$text_blocks[2].Text}
			  </td>
			  <td width="20px">&nbsp;

			  </td>
			  <td width="301px" class="main_infoblock" valign="top">
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
		  </table><br/>

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

  <tr>
	<td>
	  <table width="100%" cellpadding="0" cellspacing="0">
	    <tr height="270px">
		  <td class="main_content_center" align="left" valign="top">



<table width="100%" cellpadding="0" cellspacing="0">
<tr><td colspan="5">{$insert_banner[3]}</td></tr>
  <tr>
    <td valign="top" width="34%">

      <table width="100%" cellpadding="0" cellspacing="0">
        <tr height="46px">
          <td colspan="3">
            <table width="100%" cellpadding="0" cellspacing="0">
        	  <tr height="46px">
        	      <td valign="top" width="187px" style="background:url({$template_path}img/block_11.gif) no-repeat bottom left;color:#dadada;" >
		            <div style="padding-top:5px;">&nbsp;<b>New Products for Sale:</b></div>
		            <div style="padding-top:7px;font-size:11px;color:#000000;">&nbsp;&nbsp;&nbsp;Results 1-{$recent_c} of {$pcountprod.ccc}</div>
		          </td>
		          <td style="background:url({$template_path}img/block_12.gif) repeat-x bottom;">
		           &nbsp;
		          </td>
		          <td width="102px" style="background:url({$template_path}img/block_13.gif) no-repeat bottom right;" valign="top" align="right" nowrap>
		            <a href="index.php{if !isset($_REQUEST.sort1)}?sort1=desc{/if}"><img src="{$template_path}img/sort{if isset($_REQUEST.sort1)}d{/if}.gif" align="right"/></a><span style="font-size:12px;color:#000;"><b>sort by</b> </span>&nbsp;
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

               {foreach from=$recent item=oItem}
               <tr>
			     <td valign="top" align="center" width="100px">
					  {if $oItem.img!=''}<img src="media/store/small_{$oItem.img}" width="80px" style="border:1px solid #065263;"/>{else}<img src="{$template_path}img/empty_recent.gif" width="70px" style="border:1px solid #065263;"/>{/if}
				  </td>
				  <td valign="top" align="left" width="200px">
				    <a href="product.php?ID={$oItem.ID}" style="color:#065263;font-size:12px;text-decoration:none;"><b>{$oItem.Title|escape:'html'}</b></a><br>
				    <a href="category.php?ID={$oItem.cid}" style="color:#000099;text-decoration:none;">{$oItem.ctitle|escape:'html'}</a><br>
				    <b style="color:#000099;">Seller: </b><a href="profile.php?ID={$oItem.uid}" style="color:#000099;">{$oItem.user|escape:'html'}</a>	<br>
			        <span style="color:#cc0808;"><b>${$oItem.Price}</b></span>	<br/><br/>
				  </td>
				 </tr>
			    {/foreach}

            </table>
          </td>
          <td width="12px" style="background:url({$template_path}img/block_23.gif) repeat-y right;">
            &nbsp;
          </td>
        </tr>
        <tr height="24px">
          <td colspan="3">
            <table width="100%" cellpadding="0" cellspacing="0">
        	  <tr height="24px">
        	      <td width="187px" style="background:url({$template_path}img/block_31.gif) no-repeat bottom left;">
		            &nbsp;
		          </td>
		          <td style="background:url({$template_path}img/block_32.gif) repeat-x top;">
		            &nbsp;
		          </td>
		          <td width="102px" style="background:url({$template_path}img/block_33.gif) no-repeat bottom right;" align="right">
		            <div style="padding-right:5px;padding-bottom:3px;">
		            <a href="category.php?&border=date&bdesc#sale"><img src="{$template_path}img/view.gif" align="right"/></a><a href="category.php?&border=date&bdesc#sale" style="font-size:12px;color:#848484;text-decoration:none;"><b>view all</b></a>&nbsp;
		            </div>
		        </td>
        	  </tr>
        	</table>
          </td>
        </tr>
      </table>

    </td>
    <td width="1%">&nbsp;</td>

    <td valign="top" width="34%">

      <table width="100%" cellpadding="0" cellspacing="0">
        <tr height="46px">
          <td colspan="3">
            <table width="100%" cellpadding="0" cellspacing="0">
        	  <tr height="46px">
        	      <td valign="top" width="187px" style="background:url({$template_path}img/sblock_11.gif) no-repeat bottom left;color:#dadada;" >
		            <div style="padding-top:5px;">&nbsp;<b>New Products for Want:</b></div>
		            <div style="padding-top:7px;font-size:11px;color:#000000;">&nbsp;&nbsp;&nbsp;Results 1-{$wrecent_c} of {$pcountwprod.ccc}</div>
		          </td>
		          <td style="background:url({$template_path}img/sblock_12.gif) repeat-x bottom;">
		           &nbsp;
		          </td>
		          <td width="102px" style="background:url({$template_path}img/sblock_13.gif) no-repeat bottom right;" valign="top" align="right" nowrap>
		            <a href="index.php{if !isset($_REQUEST.sort1)}?sort1=desc{/if}"><img src="{$template_path}img/sort{if isset($_REQUEST.sort1)}d{/if}.gif" align="right"/></a><span style="font-size:12px;color:#000;"><b>sort by</b> </span>&nbsp;
		          </td>
        	  </tr>
        	</table>
          </td>
        </tr>
        <tr>
          <td width="12px" style="background:url({$template_path}img/sblock_21.gif) repeat-y left;">
            &nbsp;
          </td>
          <td><br>
            <table width="100%" cellpadding="0" cellspacing="0">

               {foreach from=$wrecent item=oItem}
               <tr>
			     <td valign="top" align="center" width="100px">
					  {if $oItem.img!=''}<img src="media/store/small_{$oItem.img}" width="80px" style="border:1px solid #065263;"/>{else}<img src="{$template_path}img/empty_recent.gif" width="70px" style="border:1px solid #065263;"/>{/if}
				  </td>
				  <td valign="top" align="left" width="200px">
				    <a href="wproduct.php?ID={$oItem.ID}" style="color:#065263;font-size:12px;text-decoration:none;"><b>{$oItem.Title|escape:'html'}</b></a><br>
				    <a href="wcategory.php?ID={$oItem.cid}" style="color:#000099;text-decoration:none;">{$oItem.ctitle|escape:'html'}</a><br>
				    <b style="color:#000099;">Buyer: </b><a href="profile.php?ID={$oItem.uid}" style="color:#000099;">{$oItem.user|escape:'html'}</a>	<br>
			        <span style="color:#cc0808;"><b>${$oItem.Price}</b></span>	<br/><br/>
				  </td>
				 </tr>
			    {/foreach}

            </table>
          </td>
          <td width="12px" style="background:url({$template_path}img/sblock_23.gif) repeat-y right;">
            &nbsp;
          </td>
        </tr>
        <tr height="24px">
          <td colspan="3">
            <table width="100%" cellpadding="0" cellspacing="0">
        	  <tr height="24px">
        	      <td width="187px" style="background:url({$template_path}img/sblock_31.gif) no-repeat bottom left;">
		            &nbsp;
		          </td>
		          <td style="background:url({$template_path}img/sblock_32.gif) repeat-x top;">
		            &nbsp;
		          </td>
		          <td width="102px" style="background:url({$template_path}img/sblock_33.gif) no-repeat bottom right;" align="right">
		            <div style="padding-right:5px;padding-bottom:3px;">
		            <a href="wcategory.php?&border=date&bdesc#sale"><img src="{$template_path}img/view.gif" align="right"/></a><a href="wcategory.php?&border=date&bdesc#sale" style="font-size:12px;color:#848484;text-decoration:none;"><b>view all</b></a>&nbsp;
		            </div>
		        </td>
        	  </tr>
        	</table>
          </td>
        </tr>
      </table>

    </td>
    <td width="1%">&nbsp;</td>
    <td valign="top" width="30%">

      <table width="100%" cellpadding="0" cellspacing="0">
        <tr height="33px">
          <td colspan="3">
            <table width="100%" cellpadding="0" cellspacing="0">
        	  <tr height="33px">
        	      <td width="102px" style="background:url({$template_path}img/gblock_13.gif) no-repeat bottom right;" valign="top" align="right" nowrap>
		            &nbsp;
		          </td>
		          <td style="background:url({$template_path}img/gblock_12.gif) repeat-x bottom;">
		           &nbsp;
		          </td>
		          <td valign="top" align="right" width="187px" style="background:url({$template_path}img/gblock_11.gif) no-repeat bottom left;color:#dadada;" >
		            <div style="padding-top:5px;"><b>Sale Categories:</b>&nbsp;</div>
		          </td>
        	  </tr>
        	</table>
          </td>
        </tr>
        <tr>
          <td width="12px" style="background:url({$template_path}img/gblock_23.gif) repeat-y left;">
            &nbsp;
          </td>
          <td><br>
            <table width="100%" cellpadding="0" cellspacing="0">
               <tr>
			      <td style="color:#065263; font-size:11px;border-bottom:1px solid #065263;padding-top:5px;padding-bottom:5px;">
					<b>Category</b>
				  </td>
				  <td style="color:#065263; font-size:11px;border-bottom:1px solid #065263;padding-top:5px;padding-bottom:5px;" align="right">
					<b>Products</b>
				  </td>
				  </tr>
				</tr>
               {foreach from=$pcategs item=oItem}
                <tr>
			      <td style="border-bottom:1px solid #065263;padding-top:5px;padding-bottom:5px;">
			      	<a href="category.php?ID={$oItem.ID}" style="text-decoration:none;color:#848484;font-size:11px;">{$oItem.Title}</a>
				  </td>
				  <td style="color:#065263; font-size:11px;border-bottom:1px solid #065263;padding-top:5px;padding-bottom:5px;" align="right">
					{$oItem.Count}
				  </td>
				  </tr>
				</tr>
			    {/foreach}
            </table>
          </td>
          <td width="12px" style="background:url({$template_path}img/gblock_21.gif) repeat-y right;">
            &nbsp;
          </td>
        </tr>
        <tr height="24px">
          <td colspan="3">
            <table width="100%" cellpadding="0" cellspacing="0">
        	  <tr height="24px">
        	      <td width="187px" style="background:url({$template_path}img/gblock_31.gif) no-repeat bottom left;">
		            &nbsp;
		          </td>
		          <td style="background:url({$template_path}img/gblock_32.gif) repeat-x top;">
		            &nbsp;
		          </td>
		          <td width="102px" style="background:url({$template_path}img/gblock_33.gif) no-repeat bottom right;" align="right">
		            <div style="padding-right:5px;padding-bottom:3px;">
		            <a href="category.php"><img src="{$template_path}img/view.gif" align="right"/></a><a href="category.php" style="font-size:12px;color:#848484;text-decoration:none;"><b>view all</b></a>&nbsp;
		            </div>
		        </td>
        	  </tr>
        	</table>
          </td>
        </tr>
      </table>

    </td>
  </tr>
  <tr><td colspan="5">&nbsp;</td></tr>

  <tr>
    <td valign="top" colspan="3">

    <table width="100%" cellpadding="0" cellspacing="0">
        <tr height="33px">
          <td colspan="3">
            <table width="100%" cellpadding="0" cellspacing="0">
        	  <tr height="33px">
        	      <td width="102px" style="background:url({$template_path}img/rblock_13.gif) no-repeat bottom right;" valign="top" align="right" nowrap>
		            &nbsp;
		          </td>
		          <td style="background:url({$template_path}img/rblock_12.gif) repeat-x bottom;">
		           &nbsp;
		          </td>
		          <td valign="top" align="right" width="187px" style="background:url({$template_path}img/rblock_11.gif) no-repeat bottom left;color:#dadada;" >
		            <div style="padding-top:5px;"><b>Top Sales Products:</b>&nbsp;</div>
		          </td>
        	  </tr>
        	</table>
          </td>
        </tr>
        <tr>
          <td width="12px" style="background:url({$template_path}img/rblock_23.gif) repeat-y left;">
            &nbsp;
          </td>
          <td><br>
            <table width="100%" cellpadding="0" cellspacing="0">
              <tr>
               {foreach from=$ptop item=oItem}
			     <td valign="top" align="center" width="200px">
					  {if $oItem.img!=''}<img src="media/store/small_{$oItem.img}" width="80px" style="border:1px solid #065263;"/>{else}<img src="{$template_path}img/empty_recent.gif" width="70px" style="border:1px solid #065263;"/>{/if}
				    <br>
				    <a href="product.php?ID={$oItem.ID}" style="color:#065263;font-size:12px;text-decoration:none;"><b>{$oItem.Title|escape:'html'}</b></a><br>
				    <a href="category.php?ID={$oItem.cid}" style="color:#000099;text-decoration:none;">{$oItem.ctitle|escape:'html'}</a><br>
				    <b style="color:#000099;">Seller: </b><a href="profile.php?ID={$oItem.uid}" style="color:#000099;">{$oItem.user|escape:'html'}</a>	<br>
			        <span style="color:#cc0808;"><b>${$oItem.Price}</b></span>
				  </td>
				  <td>&nbsp;</td>
			    {/foreach}
              </tr>
            </table>
          </td>
          <td width="12px" style="background:url({$template_path}img/rblock_21.gif) repeat-y right;">
            &nbsp;
          </td>
        </tr>
        <tr height="24px">
          <td colspan="3">
            <table width="100%" cellpadding="0" cellspacing="0">
        	  <tr height="24px">
        	      <td width="187px" style="background:url({$template_path}img/rblock_31.gif) no-repeat bottom left;">
		            &nbsp;
		          </td>
		          <td style="background:url({$template_path}img/rblock_32.gif) repeat-x top;">
		            &nbsp;
		          </td>
		          <td width="102px" style="background:url({$template_path}img/rblock_33.gif) no-repeat bottom right;" align="right">
		            <div style="padding-right:5px;padding-bottom:3px;">
		            <a href="category.php"><img src="{$template_path}img/view.gif" align="right"/></a><a href="category.php" style="font-size:12px;color:#848484;text-decoration:none;"><b>view all</b></a>&nbsp;
		            </div>
		        </td>
        	  </tr>
        	</table>
          </td>
        </tr>
      </table>
      <br/>
      {$insert_banner[2]}

    </td>
    <td width="1%">&nbsp;</td>
    <td valign="top" width="30%">

    <table width="100%" cellpadding="0" cellspacing="0">
        <tr height="33px">
          <td colspan="3">
            <table width="100%" cellpadding="0" cellspacing="0">
        	  <tr height="33px">
        	      <td width="102px" style="background:url({$template_path}img/gblock_13.gif) no-repeat bottom right;" valign="top" align="right" nowrap>
		            &nbsp;
		          </td>
		          <td style="background:url({$template_path}img/gblock_12.gif) repeat-x bottom;">
		           &nbsp;
		          </td>
		          <td valign="top" align="right" width="187px" style="background:url({$template_path}img/gblock_11.gif) no-repeat bottom left;color:#dadada;" >
		            <div style="padding-top:5px;"><b>Wanted Categories:</b>&nbsp;</div>
		          </td>
        	  </tr>
        	</table>
          </td>
        </tr>
        <tr>
          <td width="12px" style="background:url({$template_path}img/gblock_23.gif) repeat-y left;">
            &nbsp;
          </td>
          <td><br>
            <table width="100%" cellpadding="0" cellspacing="0">
               <tr>
			      <td style="color:#065263; font-size:11px;border-bottom:1px solid #065263;padding-top:5px;padding-bottom:5px;">
					<b>Category</b>
				  </td>
				  <td style="color:#065263; font-size:11px;border-bottom:1px solid #065263;padding-top:5px;padding-bottom:5px;" align="right">
					<b>Products</b>
				  </td>
				  </tr>
				</tr>
               {foreach from=$pwcategs item=oItem}
                <tr>
			      <td style="border-bottom:1px solid #065263;padding-top:5px;padding-bottom:5px;">
			      	<a href="wcategory.php?ID={$oItem.ID}" style="text-decoration:none;color:#848484;font-size:11px;">{$oItem.Title}</a>
				  </td>
				  <td style="color:#065263; font-size:11px;border-bottom:1px solid #065263;padding-top:5px;padding-bottom:5px;" align="right">
					{$oItem.Count}
				  </td>
				  </tr>
				</tr>
			    {/foreach}
            </table>
          </td>
          <td width="12px" style="background:url({$template_path}img/gblock_21.gif) repeat-y right;">
            &nbsp;
          </td>
        </tr>
        <tr height="24px">
          <td colspan="3">
            <table width="100%" cellpadding="0" cellspacing="0">
        	  <tr height="24px">
        	      <td width="187px" style="background:url({$template_path}img/gblock_31.gif) no-repeat bottom left;">
		            &nbsp;
		          </td>
		          <td style="background:url({$template_path}img/gblock_32.gif) repeat-x top;">
		            &nbsp;
		          </td>
		          <td width="102px" style="background:url({$template_path}img/gblock_33.gif) no-repeat bottom right;" align="right">
		            <div style="padding-right:5px;padding-bottom:3px;">
		            <a href="wcategory.php"><img src="{$template_path}img/view.gif" align="right"/></a><a href="wcategory.php" style="font-size:12px;color:#848484;text-decoration:none;"><b>view all</b></a>&nbsp;
		            </div>
		        </td>
        	  </tr>
        	</table>
          </td>
        </tr>
      </table>
      <br/>
      {$insert_banner[1]}

    </td>
  </tr>
  <tr><td colspan="5">&nbsp;</td></tr>

</table>

{include file='footer.tpl' header=1}
