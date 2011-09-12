<?php
/**
 * Silurus Classifieds Builder
 * 
 * 
 * @author		SnowHall - http://snowhall.com
 * @website		http://snowhall.com/silurus
 * @email		support@snowhall.com
 * 
 * @version		1.0
 * @date		May 7, 2009
 * 
 * Silurus is a professionally developed PHP Classifieds script that was built for you.
 * Whether you are running classifieds for autos, motorcycles, bicycles, rv's, guns,
 * horses, or general merchandise, our product is the right package for you.
 * It has template system and no limit to usage with free for any changes.
 *
 * Copyright (c) 2009
 */

include("./include_php/init.php");
include("./include_php/TemplVotingView.php");

if($_SESSION['memberID'] == 0) header("location: /");
	
$info = mysql_fetch_array(mysql_query("select * from Store where userID=".$_SESSION['memberID']." and ID=".intval($_REQUEST['ID'])));
if(!$info) header("location: /profile.php");
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$err = array();
	if(floatval(str_replace(",",".",$_REQUEST['price'])) <= 0) {$err['fieldError'] = 1;$_REQUEST['price']='';}
	if(trim($_REQUEST['Title']) == '') {$err['fieldError'] = 1;}
		
	$q = mysql_query("select * from StoreProp where Required=1 and Type<>3 and categoryID=".intval($info['categoryID']));
	while($prop = mysql_fetch_assoc($q))
	{
		if($_SERVER['REQUEST_METHOD']=='POST' && (
		(trim($_REQUEST['prop'.$prop['ID']])=='' && $prop['Type']==1) ||
		(trim($_REQUEST['prop'.$prop['ID']])=='' && $prop['Type']==2) ||
		(intval($_REQUEST['prop'.$prop['ID']])==0 && $prop['Type']==5) ||
		((!is_array($_REQUEST['prop'.$prop['ID']])||empty($_REQUEST['prop'.$prop['ID']])) && $prop['Type']==6) ||
		((!is_array($_REQUEST['prop'.$prop['ID']])||empty($_REQUEST['prop'.$prop['ID']])) && $prop['Type']==7)
		)) 
			$err["fieldError"] = 1;
	}
	
	$q = mysql_query("select * from StoreProp where Required=1 and Type=3 and categoryID=".intval($info['categoryID']));
	while($prop = mysql_fetch_assoc($q))
	{
		if( $_FILES['prop'.$prop['ID']] && !empty( $_FILES['prop'.$prop['ID']] ) )
		{
			if( $_FILES['prop'.$prop['ID']]['error'] == 0 )
			{
				$aFileInfo = getimagesize( $_FILES['prop'.$prop['ID']]['tmp_name'] );
				if( $aFileInfo )
				{
					$ext = false;
					switch( $aFileInfo['mime'] )
					{
						case 'image/jpeg': $ext = 'jpg'; break;
						case 'image/gif':  $ext = 'gif'; break;
						case 'image/png':  $ext = 'png'; break;
					}
					
					if( !$ext )
						$err['photo'.$prop['ID']] = 'Incorrect file type';
				}
				else 
					$err['photo'.$prop['ID']] = 'Incorrect file type';
			}
			else 
				$err['photo'.$prop['ID']] = 'Download error';	
		}			
	}
	
	if(empty($err))
	{
		mysql_query("update Store SET 	
				LastModified=".time().",
				Title='".mysql_escape_string($_REQUEST['Title'])."',
				price='".floatval(str_replace(",",".",$_REQUEST['price']))."' where ID=".intval($_REQUEST['ID']));		
		$newID = intval($_REQUEST['ID']);
		$q = mysql_query("select v.* from StorePropValues v inner join StoreProp p on p.ID=v.PropID where v.itemID=".intval($newID)." and p.Type=3");
		$photos = array();
		while($arr = mysql_fetch_assoc($q))
		{
			if(isset($_REQUEST['delphoto'.$arr['PropID']]))
			{
				@unlink( './media/store/'.$arr['Value'] );
				@unlink( './media/store/small_'.$arr['Value'] );
			}
			else
				$photos[$arr['PropID']] = $arr['Value'];
		}

		mysql_query( "delete from StorePropValues where itemID=".intval($newID) );
		
		$q = mysql_query("select * from StoreProp where categoryID=".intval($info['categoryID']));
		while($prop = mysql_fetch_assoc($q))
		{
			if($prop['Type']<3 || $prop['Type']==4 || $prop['Type']==5) mysql_query("insert into StorePropValues set PropID=".$prop['ID'].",itemID=".$newID.",Value='".$_REQUEST['prop'.$prop['ID']]."'");
			if($prop['Type']>5) 
			{
				if(is_array($_REQUEST['prop'.$prop['ID']]))
					foreach ($_REQUEST['prop'.$prop['ID']] as $val) 
						mysql_query("insert into StorePropValues set PropID=".$prop['ID'].",itemID=".$newID.",Value='".$val."'");			
			}
			
			if($prop['Type']==3 && $_FILES['prop'.$prop['ID']] && !empty( $_FILES['prop'.$prop['ID']] ) )
			{
				if( $_FILES['prop'.$prop['ID']]['error'] == 0 )
				{
					$aFileInfo = getimagesize( $_FILES['prop'.$prop['ID']]['tmp_name'] );
					if( $aFileInfo )
					{
						$ext = false;
						switch( $aFileInfo['mime'] )
						{
							case 'image/jpeg': $ext = 'jpg'; break;
							case 'image/gif':  $ext = 'gif'; break;
							case 'image/png':  $ext = 'png'; break;
						}						
						if( $ext )
						{
							$newFileName = 'P'.time().$_SESSION['memberID'].$prop['ID'].'.'.$ext;		
							if( move_uploaded_file( $_FILES['prop'.$prop['ID']]['tmp_name'], './media/store/'.$newFileName ) )
							{
								if($aFileInfo[0] > 300)
									@imageResize( './media/store/'.$newFileName, './media/store/small_'.$newFileName,300);
								else 
									@imageResize( './media/store/'.$newFileName, './media/store/small_'.$newFileName,$aFileInfo[0]);
								@unlink( './media/store/'.$photos[$prop['ID']] );
								@unlink( './media/store/small_'.$photos[$prop['ID']] );
								mysql_query("insert into StorePropValues set PropID=".$prop['ID'].",itemID=".$newID.",Value='".$newFileName."'");
							}
						}
					}
				}
				elseif(isset($photos[$prop['ID']]))
					mysql_query("insert into StorePropValues set PropID=".$prop['ID'].",itemID=".$newID.",Value='".$photos[$prop['ID']]."'");
			}
			elseif ($prop['Type']==3 && isset($photos[$prop['ID']]))
				mysql_query("insert into StorePropValues set PropID=".$prop['ID'].",itemID=".$newID.",Value='".$photos[$prop['ID']]."'");
		}
		header("location: /product.php?ID=".$newID); die();
	}
	$smarty->assign("error",  $err);
}

$categoryID = intval($info['categoryID']);
$oVotingView = new TemplVotingView ('gvoting', 0);

if($_SERVER['REQUEST_METHOD']!='POST')
{
	$_REQUEST['Title'] = $info['Title'];
	$_REQUEST['price'] = number_format($info['price'],2,"."," ");
	$q = mysql_query("select * from StoreProp where Type<>3 and categoryID=".$categoryID);
	while($prop = mysql_fetch_assoc($q))
	{
		$subitems = array();
		if($prop['Type'] > 5)
		{
			$qq = mysql_query("select * from StorePropValues where PropID=".intval($prop['ID'])." and itemID=".$info['ID']);
			while($subprop = mysql_fetch_assoc($qq))
				$subitems[] = $subprop['Value'];
			
		}
		else 
		{
			$qq = mysql_fetch_assoc(mysql_query("select * from StorePropValues where PropID=".intval($prop['ID'])." and itemID=".$info['ID']));
			$subitems = $qq['Value'];
		}
		$_REQUEST['prop'.$prop['ID']] = $subitems;
	}
}
$q = mysql_query("select * from StoreProp where Type=3 and categoryID=".$categoryID);
while($prop = mysql_fetch_assoc($q))
{
	$qq = mysql_query("select * from StorePropValues where PropID=".intval($prop['ID'])." and itemID=".$info['ID']);
	$subitems = mysql_fetch_assoc($qq);	
	$_REQUEST['photo'.$prop['ID']] = $subitems['Value'];
}

$req_props = array();
$props = array();
$q = mysql_query("select * from StoreProp where categoryID=".$categoryID." order by Prior");
while($prop = mysql_fetch_assoc($q))
{
	$subitems = array();
	if($prop['Type'] > 4)
	{
		$qq = mysql_query("select * from StorePropMulti where PropID=".intval($prop['ID'])." order by Name");
		while($subprop = mysql_fetch_assoc($qq))
			$subitems[] = $subprop;
	}
	if($prop['Type'] == 4)
	{
		$oVotingView->_fRate = (intval($_REQUEST['prop'.$prop['ID']])>0?intval($_REQUEST['prop'.$prop['ID']]):1);
		$voter = $oVotingView->getBigVoting (1,'',$prop['ID']);
		$subitems = '<input type="hidden" name="prop'.$prop['ID'].'" id="gvotingbig'.$prop['ID'].'" value="'.(intval($_REQUEST['prop'.$prop['ID']])>0?intval($_REQUEST['prop'.$prop['ID']]):1).'">'.$voter;
	}
	$prop['subprop'] = $subitems;
	
	if($prop['Type'] != 3) $prop['entered'] = $_REQUEST['prop'.$prop['ID']]; else {$prop['photo'] = $_REQUEST['photo'.$prop['ID']];}	
	$prop['error'] = $err['photo'.$prop['ID']];
	if($prop['Required'])
	{		
		if($_SERVER['REQUEST_METHOD']=='POST' && (
		(trim($_REQUEST['prop'.$prop['ID']])=='' && $prop['Type']==1) ||
		(trim($_REQUEST['prop'.$prop['ID']])=='' && $prop['Type']==2) ||
		(isset($err['photo'.$prop['ID']]) && $prop['Type']==3) ||
		(intval($_REQUEST['prop'.$prop['ID']])==0 && $prop['Type']==5) ||
		((!is_array($_REQUEST['prop'.$prop['ID']])||empty($_REQUEST['prop'.$prop['ID']])) && $prop['Type']==6) ||
		((!is_array($_REQUEST['prop'.$prop['ID']])||empty($_REQUEST['prop'.$prop['ID']])) && $prop['Type']==7)
		)) 
			$prop['color'] = 'background:#ff0000;';
		$req_props[] = $prop;
	}
	else 
		$props[] = $prop;
}
$smarty->assign("req_props",  $req_props);
$smarty->assign("props",  $props);

$HEADERTEXT='Edit Product for Sale';
addNavigation('/profile.php?ID='.$_SESSION['memberID'],'My Profile');
addNavigation('',$HEADERTEXT);
$smarty->assign("site_title",  $HEADERTEXT." :: ".$gConfig['site_title']);
$smarty->assign("HEADERTEXT",  $HEADERTEXT);
show_smarty_template('add_product');
?>