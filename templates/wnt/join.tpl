{include file='header.tpl'}

<form enctype="multipart/form-data" name="add_prof" method="post" action="">
<table cellpadding="0" cellspacing="0">
  <tr height="35px">
    <td class="big_h2" style="background:#232323;padding:8px;color:#fff">
	  <b>Required Information:</b>
	  {if $t_error}<br /><br />{$t_error}<br />{/if}
	</td>
  </tr>

   <tr>
    <td width="470px" class="formback">
	  <table width="100%" cellpadding="0" cellspacing="0">
	    <tr height="35px">
	    <td class="small_grey">
		  Username:
		</td>
		<td>
		  <input type="text" name="NickName" style="width:250px{if $error.NickName};background:#ff0000;{/if}" value="{$_REQUEST.NickName|escape:'html'}" />
		</td>
	  </tr>
      {*
	  <tr height="35px">
	    <td class="small_grey">
		  First Name:
		</td>
		<td>
		  <input type="text" name="fname" style="width:250px{if $error.fname};background:#ff0000;{/if}" value="{$_REQUEST.fname|escape:'html'}" />
		</td>
	  </tr>

	  <tr height="35px">
	    <td class="small_grey">
		  Last Name:
		</td>
		<td>
		  <input type="text" name="lname" style="width:250px{if $error.lname};background:#ff0000;{/if}" value="{$_REQUEST.lname|escape:'html'}" />
		</td>
	  </tr>
      *}
	  <tr height="35px">
		<td class="small_grey">
		  Email:
		</td>
		<td>
		  <input type="text" name="Email" style="width:250px{if $error.Email};background:#ff0000;{/if}" value="{$_REQUEST.Email|escape:'html'}" />
		</td>
	  </tr>
      {*
	  <tr height="35px">
		<td class="small_grey">
		  Confirm Email:
		</td>
		<td>
		  <input type="text" name="Email2" style="width:250px{if $error.Email2};background:#ff0000;{/if}" value="{$_REQUEST.Email2|escape:'html'}" />
		</td>
	  </tr>
      *}
	  <tr height="35px">
		<td class="small_grey">
		  Password:
		</td>
		<td>
		  <input type="password" name="Password1" style="width:250px{if $error.Password1};background:#ff0000;{/if}" value="{$_REQUEST.Password1|escape:'html'}" />
		</td>
	  </tr>

	  <tr height="35px">
		<td class="small_grey">
		  Confirm Password:
		</td>
		<td>
		  <input type="password" name="Password2" style="width:250px{if $error.Password2};background:#ff0000;{/if}" value="{$_REQUEST.Password2|escape:'html'}" />
		</td>
	  </tr>
      {*
	  <tr height="35px">
	    <td class="small_grey">
		  Zip Code:
		</td>
		<td>
		  <input type="text" name="Zip" style="width:250px{if $error.Zip};background:#ff0000;{/if}" value="{$_REQUEST.Zip|escape:'html'}" />
		</td>
	  </tr>

	   <tr height="35px">
	    <td class="small_grey">
		  City:
		</td>
		<td>
		  <input type="text" id="autoenter_value1" name="city" style="width:250px{if $error.city};background:#ff0000;{/if}" value="{$_REQUEST.city|escape:'html'}" onkeyup="getcitylist('1')" />
		  <br>
		  <div style="width:255px;position:absolute;display:none;" id="autoenter_div1"></div>
		</td>
	  </tr>
      *}
	  <tr height="35px">
		<td class="small_grey">
		  <img alt="Security Image" src="simg/simg.php" />
		</td>
		<td>
		    Enter what you see: <input name="securityImageValue" type="text" size="15" style="{if $error.securityImageValue}background:#ff0000;{/if}">
		</td>
	  </tr>
      <tr height="35px">
	  <td class="small_grey">
		  <span style="{if $error.terms}color:#ff0000;font-weight:bold;{/if}">I agree with <a target="_blank" href="simple.php?ID=1">terms</a></span>
		</td>
		<td>
		  <input type="checkbox" {if $_REQUEST.terms}checked{/if} name="terms" value="1" style="{if $error.terms}background:#ff0000;{/if}">
		</td>
	  </tr>

	  </table>
	</td>
  </tr>

  <tr>
    <td colspan="3">
	  <br /><br /><div class="dotted_line"></div>
    </td>
  </tr>

  <tr>
    <td align="right" colspan="3"><br />

	   <a href="javascript:void(0);" onclick="document.add_prof.submit();"><img src="{$template_path}img/add_prof.gif" border="0" /></a>
    </td>
  </tr>
</table>
</form>


{include file='footer.tpl'}