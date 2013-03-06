<table width="95%" cellpadding="0" cellspacing="0">
<tr height="24px" class="table_title_tr" >
  <td style="padding-left:15px;" nowrap>
    {if $aBooks.order=='title'}
    	{if $aBooks.desc}<img src="{$template_path}img/arr_up.png" />{else}<img src="{$template_path}img/arr_down.png" />{/if}
    {/if}
    &nbsp;<a href="{$aBooks.cur_url}&{$aBooks.prefix}order=title{if !$aBooks.desc}&{$aBooks.prefix}desc{/if}#sale" class="table_title" style="color:#000000">Title</a>
  </td>
  <td width="15px">&nbsp;</td>
  <td nowrap>
    {if $aBooks.order=='date'}
    	{if $aBooks.desc}<img src="{$template_path}img/arr_up.png" />{else}<img src="{$template_path}img/arr_down.png" />{/if}
    {/if}
    &nbsp;<a href="{$aBooks.cur_url}&{$aBooks.prefix}order=date{if !$aBooks.desc}&{$aBooks.prefix}desc{/if}#sale" class="table_title"  style="color:#000000">Date Posted</a>
  </td>
  <td width="15px">&nbsp;</td>
  <td nowrap>
    {if $aBooks.order=='price'}
    	{if $aBooks.desc}<img src="{$template_path}img/arr_up.png" />{else}<img src="{$template_path}img/arr_down.png" />{/if}
    {/if}
    &nbsp;<a href="{$aBooks.cur_url}&{$aBooks.prefix}order=price{if !$aBooks.desc}&{$aBooks.prefix}desc{/if}#sale" class="table_title" style="color:#000000">Price</a>
  </td>
  <td width="15px">&nbsp;</td>
  <td nowrap>
    {if $aBooks.order=='quality'}
    	{if $aBooks.desc}<img src="{$template_path}img/arr_up.png" />{else}<img src="{$template_path}img/arr_down.png" />{/if}
    {/if}
    &nbsp;<a href="{$aBooks.cur_url}&{$aBooks.prefix}order=quality{if !$aBooks.desc}&{$aBooks.prefix}desc{/if}#sale" class="table_title" style="color:#000000">Category</a>
  </td>

  {if $aBooks.show_action1}
  <td width="15px">&nbsp;</td>
  <td>
    &nbsp;
  </td>
  {/if}
  {if $aBooks.show_action2}
  <td width="15px">&nbsp;</td>
  <td>
    &nbsp;
  </td>
  {/if}

</tr>

{foreach from=$aBooks.list item=oBook}
<tr {if $oBook.featured == 1}class="featured"{/if} height="35px">
  <td style="padding-left:15px;border-bottom:1px solid #d5daf0" >
    <a href="{$oBook.url}" class="table_title">{$oBook.Title}</a>
  </td>
  <td style="border-bottom:1px solid #d5daf0">&nbsp;</td>
  <td class="black_text" nowrap style="border-bottom:1px solid #d5daf0">
    {$oBook.Date}
  </td>
  <td style="border-bottom:1px solid #d5daf0">&nbsp;</td>
  <td class="black_text" nowrap style="border-bottom:1px solid #d5daf0">
    <span style="color:#d10f0f"><b>{$oBook.Price|format_price}</b></span>
  </td>
  <td style="border-bottom:1px solid #d5daf0">&nbsp;</td>
  <td style="border-bottom:1px solid #d5daf0">
    <b>{$oBook.ctitle}</b>
  </td>

  {if $aBooks.show_action1}
  <td width="15px" style="border-bottom:1px solid #d5daf0">&nbsp;</td>
  <td style="border-bottom:1px solid #d5daf0">
    <a href="{$aBooks.show_action1}?ID={$oBook.ID}"><img src="{$template_path}img/edit.png" border="0" /></a>
  </td>
  {/if}
  {if $aBooks.show_action3}
  <td width="15px" style="border-bottom:1px solid #d5daf0">&nbsp;</td>
  <td style="border-bottom:1px solid #d5daf0">
    <a href="{$aBooks.show_action3}?ID={$oBook.ID}">Featured</a>
  </td>
  {/if}
  {if $aBooks.show_action2}
  <td width="15px" style="border-bottom:1px solid #d5daf0">&nbsp;</td>
  <td style="border-bottom:1px solid #d5daf0">
    {if $aBooks.show_action2=='delete'}
    	<input type="checkbox" name="delbook[]" value="{$oBook.ID}" />&nbsp;&nbsp;&nbsp;
    {/if}
    {if $aBooks.show_action2=='repost'}
   	    <a href="{$aBooks.cur_url}&bookID={$oBook.ID}">Repost</a>&nbsp;&nbsp;&nbsp;
    {/if}
  </td>
  {/if}

</tr>
{/foreach}

</table>

