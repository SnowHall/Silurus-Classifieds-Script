{include file='header.tpl'}

<table width="100%">
  <tr>
    <td width="220px" class="menu_left" valign="top">
	  <table width="100%" cellpadding="0" cellspacing="0"  class="menu_left_items">
	    <tr>
		  <td class="left_menu_out" onmouseover="this.className='left_menu_over';" onmouseout="this.className='left_menu_out';">&nbsp;&nbsp;&nbsp;&nbsp;<a href="/profile.php?ID={$user.ID}" class="left_menu">Profile</a></td>
		</tr>
		{if $user.ID==$_SESSION.memberID}
		<tr>
		  <td class="left_menu_out" onmouseover="this.className='left_menu_over';" onmouseout="this.className='left_menu_out';">&nbsp;&nbsp;&nbsp;&nbsp;<a href="edit_user.php" class="left_menu">Edit Profile</a></td>
		</tr>
		{/if}
		<tr>
		  <td class="left_menu_out" onmouseover="this.className='left_menu_over';" onmouseout="this.className='left_menu_out';">&nbsp;&nbsp;&nbsp;&nbsp;<a href="my_products.php?ID={$user.ID}" class="left_menu">Products for Sale</a></td>
		</tr>
		<tr>
		  <td class="left_menu_out" onmouseover="this.className='left_menu_over';" onmouseout="this.className='left_menu_out';">&nbsp;&nbsp;&nbsp;&nbsp;<a href="my_wproducts.php?ID={$user.ID}" class="left_menu">Wanted Products</a></td>
		</tr>
		{if $user.ID==$_SESSION.memberID}
		<tr>
		  <td class="left_menu_out" onmouseover="this.className='left_menu_over';" onmouseout="this.className='left_menu_out';"><img src="{$template_path}img/add_ico.png" /> <a href="add_product.php" class="left_menu">Post New Product for Sale</a></td>
		</tr>
		<tr>
		  <td class="left_menu_out" onmouseover="this.className='left_menu_over';" onmouseout="this.className='left_menu_out';"><img src="{$template_path}img/add_ico.png" /> <a href="add_wproduct.php" class="left_menu">Post New Wanted Product</a></td>
		</tr>
		{/if}
	  </table>
	</td>
	<td width="20px">&nbsp;</td>
	<td valign="top">
	  <a name="sale"></a>
	  <table width="95%" cellpadding="0" cellspacing="0">
	    <tr height="38px">
		  <td class="book_title_td{if $active}2{/if}" id="book_list_td_active">
		    <a href="javascript:void(0);" onclick="change_show_list('active',{$user.ID})"><img src="{$template_path}img/arrb_{if $active}up{else}left{/if}.png" border="0" id="book_list_img_active"/></a>&nbsp;&nbsp;<span class="big_h3"><b>Active Posts  Books</b></span> you've listed that {if $user.ID==$_SESSION.memberID}you{else}{$user.fname} {$user.lname}{/if} want to buy
		  </td>
		</tr>
	  </table>
	  <form method="POST" name="delete_form">
	  <div style="display:{if $active}block{else}none{/if}" id="book_list_active">

	  {assign var="aBooks" value=$sbooks}
	  {include file='table_list.tpl'}
	  <div style="width:95%;background:#EEEEEE;padding-top:5px;padding-bottom:5px;" align="center">{include file='page_navigation.tpl' aPaging=`$aPaging1`}</div>

	  {if $user.ID==$_SESSION.memberID}
	  <table width="95%" cellpadding="0" cellspacing="0">
	    <tr height="38px">
		  <td align="right">
		    <a href="javascript:void(0);" onclick="document.delete_form.submit();"><img src="{$template_path}img/del_books.gif" border="0" id="book_list_img_active"/></a><br /><br />
		  </td>
		</tr>
	  </table>
	  </div></form>

	  <a name="del"></a>
	  <table width="95%" cellpadding="0" cellspacing="0">
	    <tr height="38px">
		  <td class="book_title_td{if $deleted}2{/if}" id="book_list_td_del">
		    <a href="javascript:void(0);" onclick="change_show_list('del',{$user.ID})"><img src="{$template_path}img/arrb_{if $deleted}up{else}left{/if}.png" border="0" id="book_list_img_del"/></a>&nbsp;&nbsp;<span class="big_h3"><b>Expired/Deleted Posts </b></span>
		  </td>
		</tr>
	  </table>
	  <div style="display:{if $deleted}block{else}none{/if}" id="book_list_del">
	  {assign var="aBooks" value=$dbooks}
	  {include file='table_list.tpl'}
	  <div style="width:95%;background:#EEEEEE;padding-top:5px;padding-bottom:5px;" align="center">{include file='page_navigation.tpl' aPaging=`$aPaging2`}</div>
	  </div>
	  {/if}

	</td>
  </tr>
</table>

{include file='footer.tpl'}