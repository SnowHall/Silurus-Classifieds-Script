{include file='header.tpl'}

{if $payment}
  <form >
    <input type="submit" value="{$_LANG_TEXT.key276}" {$_LANG_EDIT.key276}/>

    <script type="text/javascript">
      document.getElementById('payment_form').submit();
    </script>
  </form>
{else}
  <form action="https://www.paypal.com/cgi-bin/webscr" id="payment_form" method="POST" name="fill_balance" method="POST">
    <div class="row">
      <label for="Sum" />Enter sum:</label><br/>
      <input type="text" name="amount" style="width:200px" value="{$price_sum|string_format:"%.2f"}" />
      <input type="hidden" name="cmd" value="_xclick"/>
      <input type="hidden" name="business" value="{$paypal_email}"/>
      <input type="hidden" name="item_name" value="Fill Silurus balance"/>
      <input type="hidden" name="item_number" value="{$uniqueId}"/>
      <input type="hidden" name="no_shipping" value="1"/>
      <input type="hidden" name="return" value="{$site_url}profile.php"/>
      <input type="hidden" name="cancel_return" value="{$site_url}profile.php"/>
      <input type="hidden" name="currency_code" value="{$currency}"/>
      <input type="hidden" name="rm" value="POST"/>
      <input type="hidden" name="notify_url" value="{$site_url}parsebuy_paypal.php"/>
    </div>
    <div class="buttons">
      <a class="blue-button button" href="javascript:void(0);" onclick="document.getElementById('payment_form').submit();">Pay</a>
    </div>
  </form>
{/if}

{include file='footer.tpl'}
