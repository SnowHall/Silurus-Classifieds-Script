{include file='header.tpl'}

<table width="100%" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top">
	  <table width="100%" cellpadding="0" cellspacing="0">
	    <tr>
		  <td width="185px" valign="top">
		    {if $prof_photo}
		    	<div style="width:170px;margin-top:10px;" align=center><img src="{$prof_photo.src}" {if $prof_photo.width > 170}style="width:170px;"{/if}></div>
		    {else}
		    	<div style="width:170px;margin-top:10px;" align=center><img src="{$template_path}img/nophoto.gif" style="width:155px;"></div>
		    {/if}
		  </td>
		  <td valign="top">
		    <span class="big_h4_grey">{$user.fname} {$user.lname}</span>
		    {$vote1}
		    <br>
		    {if $user.intro!=''}
		    	<div style="width:100%;border-bottom:1px solid #cccccc;height:10px;margin-bottom:10px">&nbsp;</div>
				{$user.intro}
			{/if}
			<div style="width:100%;border-bottom:1px solid #cccccc;height:10px;margin-bottom:10px">&nbsp;</div>
			<div style="width:100%;height:5px;font-size:1px;"></div>
		  <table width="100%" cellpadding="0" cellspacing="0">

		   <tr>
		     <td style="font-size:13px;" width="130px" valign="top">
			   Email:
			 </td>
			 <td style="color:#000000;" valign="top">
			  <a href="mailto:{$user.Email}" style="color:#2d4f94">{$user.Email}</a>
			 </td>
		   </tr>
		   <tr>
		     <td style="font-size:13px;" width="130px" valign="top">
			   Last Logged In:
			 </td>
			 <td style="color:#000000;" valign="top">
			  {$user.LastLoggedIn}
			 </td>
		   </tr>
		   <tr>
		     <td style="font-size:13px;" width="130px" valign="top">
			   Zip:
			 </td>
			 <td style="color:#000000;" valign="top">
			  {$user.zip}
			 </td>
		   </tr>
		   <tr>
		     <td style="font-size:13px;" width="130px" valign="top">
			   City:
			 </td>
			 <td style="color:#000000;" valign="top">
			  {$user.city}
			 </td>
		   </tr>
		  </table>

			{if $user.ID!=$_SESSION.memberID &&  $memberID}
			<br>
			<div id="review_popover" class="tellafriends_popover" style="display:none;">
				<div class="tellafriends_popover_cont">
				<div style="position:relative;width:100%;" align="left">
				<form name="review_form" method="POST">
				  <table width="650px" cellpadding="0" cellspacing="0">
					<tr>
					  <td colspan="2" align="left" valign="top" class="tellafriends_title">
						Review Seller : {$user.fname} {$user.lname}
					  </td>
					  <td align="right" valign="top">
						<a href="javascript:void(0);" onclick="whitesite(); document.getElementById('review_popover').style.display='none';"><img src="{$template_path}img/clear.gif" width="40px" height="35px" /></a>
					  </td>
					</tr>
					<tr>
					  <td colspan="2" align="left" valign="top"><br /><br />
						&nbsp;<span class="main_login_mail">This review will be posted and made public.</span><br /><br />
					  </td>
					  <td>&nbsp;</td>
					</tr>
					<tr>
					  <td align="left" valign="center">
						&nbsp;<span class="tell_lables"><b>Headline:</b></span>
					  </td>
					  <td align="left" valign="top">
						<input type="text" name="review_name" value="" class="big_input" style="width:450px;"/>
					  </td>
					   <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					</tr>
					<tr><td colspan="3">&nbsp;</td></tr>
					<tr>
					  <td align="left" valign="center" nowrap="nowrap">
						&nbsp;<span class="tell_lables"><b>Rating:</b></span><BR />
						&nbsp;<span style="font-size:12px;">Rollover stars to select</span> &nbsp;&nbsp;
					  </td>
					  <td align="left" valign="top">
					  {$voter}
					  </td>
					   <td>&nbsp;</td>
					</tr>
					<tr><td colspan="3">&nbsp;</td></tr>
					<tr>
					  <td align="left" valign="top">
						&nbsp;<span class="tell_lables"><b>Review:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
					  </td>
					  <td align="left" valign="top">
						<textarea name="review_text" class="big_input_area" style="width:450px;"></textarea>
					  </td>
					   <td>&nbsp;</td>
					</tr>
					<tr><td colspan="3">&nbsp;</td></tr>
					<tr>
					  <td align="left">&nbsp;

					  </td>
					  <td align="right" valign="top">
					  {if $user.ID!=$_SESSION.memberID &&  $memberID}
						<a href="javascript:void(0);" onclick="document.review_form.submit();"><img src="{$template_path}img/review_butt.gif" /></a>
					  {/if}
						&nbsp;&nbsp;&nbsp;&nbsp;
					  </td>
					   <td>&nbsp;</td>
					</tr>
				  </table>
				</form>
				</div>
				</div>
				</div>
				<br>
				<a href="javascript:void(0);" onclick="blacksite();document.getElementById('review_popover').style.display='block';"><img src="{$template_path}img/all_review.gif" /></a>
		{/if}

		  </td>
	    </tr>
	  </table>
	  <Br />

	  <a name="sale"></a>
	  <table width="95%" cellpadding="0" cellspacing="0">
	    <tr>
		  <td>
		    <span class="big_h3"><b>Products for Sale</b></span>
		  </td>
		  <td align="right">
		    <a href="my_products.php?ID={$user.ID}"><img src="{$template_path}img/all_sale.gif" border="0" /></a>
		  </td>
		</tr>
	  </table>

	  {assign var="aBooks" value=$sbooks}
	  {include file='table_list.tpl'}
	  <br /><br />

	  <table width="95%" cellpadding="0" cellspacing="0">
	    <tr>
		  <td>
		    <span class="big_h3"><b>Wanted Products</b></span>
		  </td>
		  <td align="right">
		    <a href="my_wproducts.php?ID={$user.ID}"><img src="{$template_path}img/all_wanted.gif" border="0" /></a>
		  </td>
		</tr>
	  </table>

	  {assign var="aBooks" value=$wbooks}
	  {include file='table_list.tpl'}
	  <br /><br />

	  <a name="reviews"></a>
	  <table width="95%" cellpadding="0" cellspacing="0">
	    <tr>
		  <td>
		    <span class="big_h3"><b>Seller's Reviews</b></span>
		  </td>
		  <td align="right">
		   {if $user.ID!=$_SESSION.memberID &&  $memberID}<a href="javascript:void(0);" onclick="blacksite();document.getElementById('review_popover').style.display='block';"><img src="{$template_path}img/all_review.gif" border="0" /></a>{/if}
		  </td>
		</tr>
		<tr><td colspan="2" style="border-top:1px solid #cccccc;">&nbsp;</td></tr>
	  </table>
	  <table width="95%" cellpadding="0" cellspacing="0">

	    {foreach from=$aRews item=oRew}
	    <tr>
		  <td valign="top" class="black_text">
		    <b>{$oRew.Title}</b><br />
			{$oRew.Text}
			<br />
			- <a href="{$oRew.Author_url}" >{$oRew.Author}</a>  &nbsp; <span style="color:#787878;"><i>Posted: {$oRew.Date}</i></span>
		  </td>
		  <td valign="top" width="100px">
		    {$oRew.Vote}
		  </td>
		</tr>
		<tr><td>&nbsp;</td></tr>
	    {/foreach}
	  </table>
	  <br />
	  <div style="width:95%;border-bottom:1px solid #e1e1e1;"></div>
	  <br />
	  <div style="font-size:13px; font-family:Verdana, Arial, Helvetica, sans-serif;" align="center">
	  {include file='page_navigation.tpl' aPaging=`$aPaging`}
	  </div>
    </td>
	<td width="262px" valign=top>
	<table width="100%" cellpadding="0" cellspacing="0">
	  <tr height="12px"><td style="background:url({$template_path}img/top.gif);background-repeat:no-repeat;background-position:bottom;">&nbsp;</td></tr>
	  <tr><td style="background:#e1e1e1">

	  <div style="width:100%;">

		{if $user.ID!=$_SESSION.memberID}
		<table width="95%" cellpadding="0" cellspacing="0">
		  <tr>
		    <td>&nbsp;&nbsp;&nbsp;<span class="big_h3" style="color:#868686"><b>Contact Info</b></span></td>
			<td align="right"><a href="profile.php?ID={$user.ID}&flag"><img src="{$template_path}img/flag.gif" border="0"/></a></td>
		  </tr>
		</table>
		{else}
		&nbsp;&nbsp;&nbsp;<a class="red-button button" href="edit_user.php">Edit My Profile</a>
    &nbsp;&nbsp;&nbsp;<a class="blue-button button" href="fill_balance.php">Fill Balance</a>
    <br /><br />

        <table width="95%" cellpadding="0" cellspacing="0">
		  <tr>
		    <td>&nbsp;&nbsp;&nbsp;<span class="big_h3" style="color:#868686"><b>My balance:</b></span></td>
            <td><span class="big_h3"  style="color:#2d4f94;"><b>{$user.balance} $</b></span></td>
          </tr>
          <tr><td>&nbsp</td></tr>
          <tr>

          </tr>
          <tr><td>&nbsp</td></tr>
		</table>

        &nbsp;&nbsp;&nbsp;<span class="big_h3" style="color:#868686"><b>Contact Info</b></span><bR />
		{/if}
	    <div style="width:100%; margin-top:10px;">
		<div style="padding:10px;">
		  <table width="100%" cellpadding="0" cellspacing="0">
		   {if $user.phone!='' && !$user.phone_none}
		    <tr height="25px">
			  <td valign="top" width="80px">
			    <span class="main_login_mail" style="color:#868686">Phone:</span>
			  </td>
			  <td valign="top">
			    <b>{$user.phone}</b>
			  </td>
			</tr>
		   {/if}
		   {if $user.cell!='' && !$user.cell_none}
			<tr height="25px">
			  <td valign="top">
			    <span class="main_login_mail" style="color:#868686">Cell:</span>
			  </td>
			  <td valign="top">
			    <b>{$user.cell}</b>
			  </td>
			</tr>
		   {/if}
		   {if $user.altemail!='' && !$user.altemail_none}
			<tr height="25px">
			  <td valign="top">
			    <span class="main_login_mail" style="color:#868686">Email:</span>
			  </td>
			  <td valign="top">
			    <b><a href="mailto:{$user.altemail}" style="color:#2d4f94;text-decoration:none;">{$user.altemail}</a></b>
			  </td>
			</tr>
		   {/if}
		   {if $user.aim!='' && !$user.aim_none}
			<tr height="25px">
			  <td valign="top">
			    <span class="main_login_mail" style="color:#868686">AIM:</span>
			  </td>
			  <td valign="top">
			    <b>{$user.aim}</b>
			  </td>
			</tr>
		   {/if}
		   {if $user.skype!='' && !$user.skype_none}
			<tr height="30px">
			  <td valign="top">
			    <span class="main_login_mail" style="color:#868686">Skype:</span>
			  </td>
			  <td valign="top">
			    <b>{$user.skype}</b>
			  </td>
			</tr>
		   {/if}
		  </table>
		  </div>

		  {if $user.ID!=$_SESSION.memberID}
		  &nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="blacksite();document.getElementById('contact_popover').style.display='block';"><img src="{$template_path}img/contact2.gif" /></a><br>{/if}
		  {if $user.note!=''}
			  &nbsp;&nbsp;<span style="font-size:16px;color:#868686" ><b>Seller's Policies/Notes</b></span>
			  <br />
			  <div style="padding:12px;width:100%;">
			  <span style="font-size:12px;color:#868686">{$user.note}</span>
			  </div>
		  {/if}
		  <br />
		</div>
	  </div>
	  </td></tr>
	  <tr height="12px"><td style="background:url(/{$template_path}img/bottom.gif);background-repeat:no-repeat;background-position:top;">&nbsp;</td></tr>
	  </table>
	  <br />
	  {$text_blocks[5].Text}
    </td>
  </tr>
</table>

{include file='ap_contact.tpl'}


{include file='footer.tpl'}