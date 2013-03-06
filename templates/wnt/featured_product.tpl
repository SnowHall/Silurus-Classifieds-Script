{include file='header.tpl'}
<div class="errors">
    {if $error.terms}
        <p>You have to accept <a href="#">paid terms</a></p>
    {/if}
    {if $error.balance}
        <p>Your have to update your balance. Now your balance {$user.balance}$</p>
    {/if}
    {if $error.already_paid}
        <p>Your already paid for this advertise!</p>
    {/if}
</div>
<form name="featured_product_form" method="POST" action="">
    <p>Your want featured advertising "{$product.Title}"</p>
    <p>Your have to paid {$featured_cost}$</p>

    <div>
        <input type="checkbox" {if $_REQUEST.terms}checked{/if} name="terms" value="1" style="{if $error.terms}background:#ff0000;{/if}">
        <span style="{if $error.terms}color:#ff0000;font-weight:bold;{/if}">I agree with <a target="_blank" href="#">terms</a></span>
    </div>
    <br/>

    <input type="submit" name="Confirm" value="Confirm" />
</form>


{include file='footer.tpl'}