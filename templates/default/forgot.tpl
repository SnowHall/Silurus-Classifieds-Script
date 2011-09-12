{include file='header.tpl'}

<br />
{$action_result}<br /><br /><br />
<center>
<form action="" method=post>
	<table cellspacing=0 cellpadding=0 class=text>
		<td>Email:&nbsp;</td>
		<td><input class=no type=text name="Email" value="{$_REQUEST.Email|escape:'html'}"></td>
		<td>&nbsp;</td>
		<td><input class=no type=submit value="Retrieve my information"></td>
	</table>
</form>
</center>
  
		     
{include file='footer.tpl'}		