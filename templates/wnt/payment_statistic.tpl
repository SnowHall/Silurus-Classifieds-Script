{include file='header.tpl'}

<table width="100%" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top">
      <table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #000">

        {if $payments}
          <tr>
            <td>Date</td>
            <td>Amount</td>
          </tr>
          {foreach from=$payments item=payment}
            <tr>
              <td valign="top">
                {$payment.Date}
              </td>
              <td valign="top">
                {$payment.Amount}
              </td>
            </tr>
          {/foreach}
        {else}
          There is no payments yet.
        {/if}
      </table>
      <Br />
  </td>
  <td>&nbsp;&nbsp;</td>
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