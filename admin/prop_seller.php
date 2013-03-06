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

include("../include_php/admin_init.php");

$smarty->assign("site_title",  "Manage Product Properties (for seller) :: Admin Panel :: ".$gConfig['site_title']);
$smarty->assign("page_header_text",  "Manage Product Properties (for seller)");

$action = $_GET['action'];

if( isset($_POST['addcategory']) && trim($_POST['Name']) != '')
{
	mysql_query( "insert into StoreCategories set Title='".trim($_POST['Name'])."', Type=0");
	header("location: {$gConfig['site_url']}admin/prop_seller.php");
}
if( isset($_POST['editcategory']) && trim($_POST['Name']) != '' && intval($_POST['ID']) > 0)
{
	mysql_query( "update  StoreCategories set Title='".trim($_POST['Name'])."' where ID=".intval($_POST['ID']));
	header("location: {$gConfig['site_url']}admin/prop_seller.php");
}
if($_GET['action'] == 'delcategory' && intval($_GET['id']) > 0)
{
	mysql_query( "delete from StoreCategories where ID=".intval($_GET['id']));
	$props = mysql_query("select * from StoreProp where categoryID=".intval($_GET['id']));
	while($propsar = mysql_fetch_assoc($props))
		delprop(intval($propsar['ID']));
	$props = mysql_query("select * from Store where categoryID=".intval($_GET['id']));
	while($propsar = mysql_fetch_assoc($props))
		delstore(intval($propsar['ID']));
	header("location: {$gConfig['site_url']}admin/prop_seller.php");
}

if( isset($_POST['additem']) && trim($_POST['Name']) != '' && intval($_POST['ID']) > 0)
{
	mysql_query( "insert into  StoreProp set Name='".trim($_POST['Name'])."',Prior =".intval($_POST['Prior']).",Type={$_POST['Type']},categoryID={$_POST['ID']},InSearch=".(isset($_POST['InSearch'])?"1":"0").",Required=".(isset($_POST['Required'])?"1":"0"));
	$propID = mysql_insert_id();
	if($propID > 0 && $_POST['Type'] > 4)
		for($i=1;$i<21;$i++)
			if(trim($_POST['field'.$i]) != '')
				mysql_query( "insert into  StorePropMulti set Name='".trim($_POST['field'.$i])."',PropID=".$propID);

	header("location: {$gConfig['site_url']}admin/prop_seller.php");
}
if($_GET['action'] == 'delprop' && intval($_GET['id']) > 0)
{
	if(intval($_GET['id']) > 0)
		delprop(intval($_GET['id']));
	header("location: {$gConfig['site_url']}admin/prop_seller.php");
}
if( isset($_POST['edititem']) && trim($_POST['Name']) != '' && intval($_POST['ID']) > 0)
{
	$ID = intval($_POST['ID']);
	mysql_query( "update  StoreProp set Name='".trim($_POST['Name'])."',Prior =".intval($_POST['Prior']).",Type={$_POST['Type']},InSearch=".(isset($_POST['InSearch'])?"1":"0").",Required=".(isset($_POST['Required'])?"1":"0")." where ID=".$ID);

	//// create new
	if($_POST['Type'] > 4)
	{
		if(is_array($_POST['oldfield']))
			foreach($_POST['oldfield'] as $key=>$val)
				if(trim($val) == '')
				{
					mysql_query("delete from StorePropMulti where ID=$key");
					mysql_query("delete from StorePropValues where Value=$key and PropID=$ID");
				}
				else
					mysql_query("update StorePropMulti set Name='{$val}' where ID=$key");

		for($i=1;$i<21;$i++)
			if(trim($_POST['field'.$i]) != '')
				mysql_query( "insert into  StorePropMulti set Name='".trim($_POST['field'.$i])."',PropID=".$ID);
	}
	else
	{
		mysql_query("delete from StorePropMulti where PropID=$ID");
		mysql_query("delete from StorePropValues where PropID=$ID");
	}

	header("location: {$gConfig['site_url']}admin/prop_seller.php");
}

function getArticlesAdminContent()
{

	$ret = '';
	$action = $_GET['action'];
	switch ($action )
	{

		case 'editcategory':
			$ID = (int)$_REQUEST['id'];
			if ($ID > 0)
				$ret .= editcategory( $ID );
			else
				$ret .= getTree(  );
		break;

		case 'addprop':
			$ID = (int)$_REQUEST['id'];
			if ($ID > 0)
				$ret .= addprop( $ID );
			else
				$ret .= getTree(  );
		break;

		case 'editprop':
			$ID = (int)$_REQUEST['id'];
			if ($ID > 0)
				$ret .= editprop( $ID );
			else
				$ret .= getTree(  );
		break;

		default:
			$ret .= getTree() ;
		break;
	}

	return $ret;
}

function delstore($ID)
{
	$q = mysql_query("select v.* from StorePropValues v inner join StoreProp p on p.ID=v.PropID where v.itemID=".intval($ID)." and p.Type=3");
	while($arr = mysql_fetch_assoc($q))
	{
		@unlink( '../media/store/'.$arr['Value'] );
		unlink( '../media/store/small_'.$arr['Value'] );
	}
	mysql_query( "delete from StorePropValues where itemID=".intval($ID) );
	mysql_query( "delete from Store where ID=".intval($ID) );
	return '';
}

function delprop($ID)
{
	$q = mysql_query("select v.* from StorePropValues v inner join StoreProp p on p.ID=v.PropID where v.PropID=".intval($ID)." and p.Type=3");
	while($arr = mysql_fetch_assoc($q))
	{
		@unlink( '../media/store/'.$arr['Value'] );
		@unlink( '../media/store/small_'.$arr['Value'] );
	}
	mysql_query( "delete from StoreProp where ID=$ID" );
	mysql_query( "delete from StorePropMulti where PropID=$ID" );
	mysql_query( "delete from StorePropValues where PropID=$ID" );
	return '';
}

function editprop($ID)
{
	global $site;

	$prop = mysql_fetch_assoc(mysql_query("select * from StoreProp where ID=$ID"));

	$ret = '<form method="post" action="" enctype="multipart/form-data">';
	$ret .= "<b>Name</b><br><input type=text name='Name' value='{$prop['Name']}'><input type=hidden name='ID' value=$ID><br>";
	$ret .= "<b>Priority</b><br><input type=text name='Prior' value='{$prop['Prior']}' ><br>";
	$ret .= "<b>Type</b><br>
	<select name=Type>
	<option value=1 ".($prop['Type']==1?"selected":"").">Text field</option>
	<option value=2 ".($prop['Type']==2?"selected":"").">Big text field</option>
	<option value=3 ".($prop['Type']==3?"selected":"").">Photo</option>
	<option value=4 ".($prop['Type']==4?"selected":"").">Stars</option>
	<option value=5 ".($prop['Type']==5?"selected":"").">Array of items (select one field)</option>
	<option value=6 ".($prop['Type']==6?"selected":"").">Array of items (select several items)</option>
	<option value=7 ".($prop['Type']==7?"selected":"").">Array of items (select several items as checkboxes)</option>
	</select><br><br>
	<input type=checkbox name=InSearch value=1 ".($prop['InSearch']==1?"checked":"")."><b>Add in search</b>
	<br><br>
	<input type=checkbox name=Required value=1 ".($prop['Required']==1?"checked":"")."><b>Required field</b>
	<br><br>";
	if($prop['Type']>4)
	{
		$ret .= "<b>Edit property fields items for Array of items type (for delete clear fieldname)</b><br>";
		$fielss = mysql_query("select * from StorePropMulti where PropID=$ID");
		while($fiels = mysql_fetch_assoc($fielss))
			$ret .= "Field {$fiels['ID']}: <input type=text name=oldfield[{$fiels['ID']}] value='{$fiels['Name']}'><br>";
	}
	$ret .= "
	<br><br>
	<b>Add property for multi fields (only for Array of items type)</b><br>";
	for($i=1;$i<21;$i++)
		$ret .= "Field $i: <input type=text name=field$i><br>";

	$ret .= "<input type=submit name=edititem value='Save'></form>";
	return $ret;
}

function addprop($ID)
{

	$ret = '<form method="post" action="" enctype="multipart/form-data">';
	$ret .= "<b>Name</b><br><input type=text name='Name' ><input type=hidden name='ID' value=$ID><br>";
	$ret .= "<b>Priority</b><br><input type=text name='Prior' ><br>";
	$ret .= "<b>Type</b><br>
	<select name=Type>
	<option value=1 selected>Text field</option>
	<option value=2 >Big text field</option>
	<option value=3 >Photo</option>
	<option value=4 >Stars</option>
	<option value=5 >Array of items (select one field)</option>
	<option value=6 >Array of items (list of several fields)</option>
	<option value=7 >Array of items (list of several fields as checkboxes)</option>
	</select><br><br>
	<input type=checkbox name=InSearch value=1><b>Add in search</b>
	<br><br>
	<input type=checkbox name=Required value=1><b>Required field</b>
	<br><br>
	<b>Property for multi fields (only for Array of items type)</b><br>";
	for($i=1;$i<21;$i++)
		$ret .= "Field $i: <input type=text name=field$i><br>";

	$ret .= "<input type=submit name=additem value='Save'></form>";
	return $ret;
}

function editcategory($ID)
{
	$Name = mysql_fetch_assoc( mysql_query( "select * from StoreCategories where ID=$ID" ) );
	$ret = '<form method="post" action="" enctype="multipart/form-data">';
	$ret .= "<b>Name</b><br><input type=text name='Name' value='{$Name['Title']}'><br>
	<input type=hidden name='ID' value=$ID><br><br>";
	$ret .= "<input type=submit name=editcategory value='Save'></form>";
	return $ret;
}

function getTree()
{

	$ret = '<form method="post" action="" enctype="multipart/form-data">' . "\n";
	$ret .= '<div>' . "\n";
		$ret .= '<b>Add Category for Seller</b>' . "\n";
	$ret .= '</div>' . "\n";
	$ret .= '<div>' . "\n";
		$ret .= 'Name: <input type="text" name="Name" id="Name"  value="" /> ';
	$ret .= '' . "<input type=submit name='addcategory' value='Add Category'></div><br></form>";

	$ret .= "<table width=100%>";
	$rSelect = mysql_query( "select * from StoreCategories where Type=0 order by Title" );
	while ( $aSelect = mysql_fetch_assoc( $rSelect ))
	{
		$ret .= '<tr><td width=50%><b>'.$aSelect['Title'].'</b></td><td> </td>
		<td><a href="admin/prop_seller.php?action=addprop&id='.$aSelect['ID'].'">Add property</a></td>
		<td><a href="admin/prop_seller.php?action=editcategory&id='.$aSelect['ID'].'">Edit</a> </td>
		<td><a href="javascript:if(confirm(\'Are you shure delete '.$aSelect['Title'].'? All products and properties will be delete.\')) top.window.location=\''.$gConfig['site_url'].'admin/prop_seller.php?action=delcategory&id='.$aSelect['ID'].(isset($_GET['demo'])?'&demo=1':'').'\';">Delete</a> </td></tr>';

		$rSelect2 = mysql_query( "select * from StoreProp where categoryID=".$aSelect['ID']." order by Prior" );
		while ( $aSelect2 = mysql_fetch_assoc($rSelect2))
		{
			$ret .= '<tr><td style="padding-left:20px"><b>'.$aSelect2['Name'].'</b></td><td></td><td></td>
			<td><a href="admin/prop_seller.php?action=editprop&id='.$aSelect2['ID'].'">Edit</a> </td><td><a href="javascript:if(confirm(\'Are you shure delete '.$aSelect2['Name'].'?\')) top.window.location=\'/admin/prop_seller.php?action=delprop&id='.$aSelect2['ID'].'\';">Delete</a> </td></tr>';
		}
	}
	$ret .= "</table>";
	return $ret;

}

$smarty->assign("page_content",  getArticlesAdminContent());
$smarty->display('index.tpl');


?>


