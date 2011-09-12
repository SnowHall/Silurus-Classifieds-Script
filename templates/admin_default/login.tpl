<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
	<head>
		<title>{$site_title}</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />		
		<link rel="stylesheet" href="/{$template_path}general.css" type="text/css" />
			</head>
	<body id="admin_cont">
		<div id="FloatDesc"></div>					
	
<div class="login">
	<div class="login_header" style="padding-left:150px">&nbsp;</div>
	
	<div class="login_form">	
	
		<form action="" method="POST">
		
		{if $warning_text}<div style="padding-left:120px"><font color=red><b>{$warning_text}</b></font></div>{/if}
		
			<div class="login_form_row">
				<div class="clear_both"></div>
				<div class="login_form_label">Login:</div>
				<div class="login_form_val">					
					<input type="text" name="ID" class="login_form_input" />
				</div>
				<div class="clear_both"></div>
			</div>			
			<div class="login_form_row">
				<div class="clear_both"></div>
				<div class="login_form_label">Password:</div>
				<div class="login_form_val">
					<input type="password" name="Password" class="login_form_input" />
				</div>
				<div class="clear_both"></div>
			</div>
			<div class="login_form_row">
				<div class="clear_both"></div>
				<div class="login_form_label"></div>
				<div class="login_form_val">
					<input type="submit" value="Enter" class="login_form_submit" />
				</div>
				<div class="clear_both"></div>
			</div>
		</form>
	</div>
</div>	</body>
</html>
	