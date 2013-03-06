<?php
/**
 * Silurus Classifieds Builder
 *
 *
 * @author		SnowHall - http://snowhall.com
 * @website		http://snowhall.com/silurus
 * @email		support@snowhall.com
 *
 * @version		2.0
 * @date		March 7, 2013
 *
 * Silurus is a professionally developed PHP Classifieds script that was built for you.
 * Whether you are running classifieds for autos, motorcycles, bicycles, rv's, guns,
 * horses, or general merchandise, our product is the right package for you.
 * It has template system and no limit to usage with free for any changes.
 *
 * Copyright (c) 2009-2013
 */

require_once('install_sql_dump.php');


if($_SERVER['REQUEST_METHOD']=='POST') {
	$err = install();
	if (empty($err)) {
		header("location: " . $_REQUEST['site_url'] . 'admin/site.php');
		unlink($_REQUEST['site_path'] . '/install.php');
		die();
	}else{
		display($err);
	}
}else{
	setDefaultsToPost();
	display();
}


function install() {
	$conn = @mysql_connect($_REQUEST['base_host'].":".$_REQUEST['base_port'],$_REQUEST['base_user'],$_REQUEST['base_pass']);
	if (!$conn) return "Couldn't connect to the database";
	if (!(@mysql_select_db($_REQUEST['base_name']))) return  "Couldn't select database ".$_REQUEST['base_name'];
	$quer = preg_split("/;\/\*\*\//", getSqlDump());
	foreach($quer as $query)
		if(trim($query)!='' && !@mysql_query(trim($query)))
			return  "MySQL error: <b>\"".mysql_error()."\"</b><br/><br/>Incorrect query: <b>\"".$query."\"</b>";

	if(!mysql_query("insert into Admins set Name='".mysql_escape_string($_REQUEST['admin_login'])."',Password='".md5($_REQUEST['admin_pass'])."'") ||
	!mysql_query("insert into Settings set Name='site_title',Value='".mysql_escape_string($_REQUEST['site_title'])."'") ||
	!mysql_query("insert into Settings set Name='site_url',Value='".mysql_escape_string($_REQUEST['site_url'])."'") ||
	!mysql_query("insert into Settings set Name='site_path',Value='".mysql_escape_string($_REQUEST['site_path'])."'")) {
		return "Couldn't create config settings in database";
	}else{
		session_start();
		$_SESSION['adminID'] = 1;
		$_SESSION['adminname'] = mysql_escape_string($_REQUEST['admin_login']);
	}

	if($f = @fopen($_REQUEST['site_path'] . 'dbconfig.inc',"w")) {
		fwrite($f,trim("
			<?php
			\$gConfig = array(
			'base_host'=>'".$_REQUEST['base_host'].":".$_REQUEST['base_port']."',
			'base_user'=>'".$_REQUEST['base_user']."',
			'base_pass'=>'".$_REQUEST['base_pass']."',
			'base_name'=>'".$_REQUEST['base_name']."'
			);
		?>"));
		fclose($f);
	}else{
		return  "Couldn't create dbconfig.inc file<br>Try create it manualy and place folow text<br><br><font color=black>
		&lt;?
		\$gConfig = array(<br>
			'base_host'=>'".$_REQUEST['base_host'].":".$_REQUEST['base_port']."',<br>
			'base_user'=>'".$_REQUEST['base_user']."',<br>
			'base_pass'=>'".$_REQUEST['base_pass']."',<br>
			'base_name'=>'".$_REQUEST['base_name']."'
		);		<br>
		?&gt;</font><Br><br>";
	}

	if (!is_writeable($_REQUEST['site_path'] . '/templates_c/'))
		return "'/templates_c' folder is not writeable";
}


function setDefaultsToPost() {
	$_REQUEST['base_port'] = '3306';
	$_REQUEST['base_host'] = 'localhost';
	$_REQUEST['base_user'] = '';
	$_REQUEST['base_pass'] = '';
	$_REQUEST['base_name'] = '';
	$_REQUEST['site_url'] = $_REQUEST['site_url'] = ($_SERVER['REQUEST_URI'] == '/'.basename(__FILE__)) ? 'http://'.$_SERVER['HTTP_HOST'].'/' : 'http://'.$_SERVER['HTTP_HOST'].trim($_SERVER['REQUEST_URI'],basename(__FILE__));
	$_REQUEST['site_path'] = dirname(realpath(__FILE__)).'/';//$_SERVER['DOCUMENT_ROOT'].'/';
	$_REQUEST['site_title'] = 'Silurus';
	$_REQUEST['admin_login'] = 'admin';
	$_REQUEST['admin_pass'] = 'admin';
}


function display($err = null) {
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
		<head>
			<title>Silurus Install</title>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
			<link rel="stylesheet" href="templates/admin_default/general.css" type="text/css" />

				</head>
		<body id="admin_cont">

				<div class="top_header"></div>
	<div style="padding-left:50px;">
        <img src="http://snowhall.com/logo/1/v2_logo.jpg" />
	<div class="page_header">Silurus Install</div>	<br>

	<?php
	if($err!='') print '<font color=red><b>'.$err.'</b></font><br><br>';
	?>
	<form action="" method="POST">

	<div class="page_header" style="font-size:14px;">Database Settings</div>
	<div class="block_cont">
	<table>
	<tr>
	<td>
	Port:
	</td>
	<td width="20px">&nbsp;</td>
	<td>
	<input style="width:300px;" type="text" name="base_port" value="<?php echo htmlspecialchars($_REQUEST['base_port'])?>">
	</td>
	</tr>

	<tr>
	<td>
	Host:
	</td>
	<td width="20px">&nbsp;</td>
	<td>
	<input style="width:300px;" type="text" name="base_host" value="<?php echo htmlspecialchars($_REQUEST['base_host'])?>">
	</td>
	</tr>

	<tr>
	<td>
	User:
	</td>
	<td width="20px">&nbsp;</td>
	<td>
	<input style="width:300px;" type="text" name="base_user" value="<?php echo htmlspecialchars($_REQUEST['base_user'])?>">
	</td>
	</tr>

	<tr>
	<td>
	Password:
	</td>
	<td width="20px">&nbsp;</td>
	<td>
	<input style="width:300px;" type="text" name="base_pass" value="<?php echo htmlspecialchars($_REQUEST['base_pass'])?>">
	</td>
	</tr>

	<tr>
	<td>
	DB Name:
	</td>
	<td width="20px">&nbsp;</td>
	<td>
	<input style="width:300px;" type="text" name="base_name" value="<?php echo htmlspecialchars($_REQUEST['base_name'])?>">
	</td>
	</tr>
	</table>
	</div>
	<br><br>

	<div class="page_header" style="font-size:14px;">Site Settings</div>
	<div class="block_cont">
	<table>

	<tr>
	<td>
	Full URL (http://sitename.com/):
	</td>
	<td width="20px">&nbsp;</td>
	<td>
	<input style="width:300px;" type="text" name="site_url" value="<?php echo htmlspecialchars($_REQUEST['site_url'])?>">
	</td>
	</tr>

	<tr>
	<td>
	Path:
	</td>
	<td width="20px">&nbsp;</td>
	<td>
	<input style="width:300px;" type="text" name="site_path" value="<?php echo htmlspecialchars($_REQUEST['site_path'])?>">
	</td>
	</tr>

	<tr>
	<td>
	Site Title:
	</td>
	<td width="20px">&nbsp;</td>
	<td>
	<input style="width:300px;" type="text" name="site_title" value="<?php echo htmlspecialchars($_REQUEST['site_title'])?>">
	</td>
	</tr>
	</table>
	</div>
	<br><br>

	<div class="page_header" style="font-size:14px;">Admin Settings</div>
	<div class="block_cont">
	<table>
	<tr>
	<td>
	Admin Login:
	</td>
	<td width="20px">&nbsp;</td>
	<td>
	<input style="width:300px;" type="text" name="admin_login" value="<?php echo htmlspecialchars($_REQUEST['admin_login'])?>">
	</td>
	</tr>

	<tr>
	<td>
	Admin Password:
	</td>
	<td width="20px">&nbsp;</td>
	<td>
	<input style="width:300px;" type="text" name="admin_pass" value="<?php echo htmlspecialchars($_REQUEST['admin_pass'])?>">
	</td>
	</tr>
	</table>
	</div>
	<br><br>
	<input type="submit" name="go" value="Install">
	</form>

	</div><br>
	<div class="bottom_cont"></div>
	</body>
	</html>
	<?php
}

?>