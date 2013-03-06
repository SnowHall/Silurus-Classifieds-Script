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

include("./include_php/init.php");
include("./include_php/TemplVotingView.php");

//if($_SESSION['memberID'] == 0) header("location: index.php");

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$err = array();
	if($gConfig['capcha_item']==1)
	{
		require_once './simg/securimage.php';
	    $image = new Securimage();
		if ($image->check($_REQUEST['securityImageValue']) == false) {
	      $smarty->assign("securityImageValueError",  true);
	      $err["securityImageValueError"] = 1;
	    }
	}
	if(floatval(str_replace(",",".",$_REQUEST['price'])) <= 0) {$err['fieldError'] = 1;$_REQUEST['price']='';}
	if(trim($_REQUEST['Title']) == '') {$err['fieldError'] = 1;}

	$q = mysql_query("select * from StoreProp where Required=1 and Type<>3 and categoryID=".intval($_REQUEST['categoryID']));
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

	$q = mysql_query("select * from StoreProp where Required=1 and Type=3 and categoryID=".intval($_REQUEST['categoryID']));
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
		}
	}

	if(empty($err))
	{
        $userID = !empty($_SESSION['memberID']) ? intval($_SESSION['memberID']) : 0;
		mysql_query("insert into Store SET
				LastModified=".time().",
				type=0,
		  		userID=".$userID.",
				Title='".mysql_escape_string($_REQUEST['Title'])."',
				date=".time().",
				categoryID=".intval($_REQUEST['categoryID']).",
				price='".floatval(str_replace(",",".",$_REQUEST['price']))."',
                password='".md5($_REQUEST['password'])."'");
		$newID = mysql_insert_id();
		$q = mysql_query("select * from StoreProp where categoryID=".intval($_REQUEST['categoryID']));
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
								mysql_query("insert into StorePropValues set PropID=".$prop['ID'].",itemID=".$newID.",Value='".$newFileName."'");
							}
						}
					}
				}
			}
		}
		header("location: product.php?ID=".$newID); die();
	}
	$smarty->assign("error",  $err);
}

$categoryID = intval($_REQUEST['categoryID']);
$ret = '';
$q = mysql_query("select * from StoreCategories where Type=0 order by Title");
while($arr = mysql_fetch_array($q))
{
	if($categoryID==0) $categoryID = $arr['ID'];
	$ret .= '<option value="'.$arr['ID'].'" '.($categoryID==$arr['ID']?'selected':'').'>'.$arr['Title'].'</option>';
}
$smarty->assign("categ_list",  $ret);

$req_props = array();
$props = array();
$oVotingView = new TemplVotingView ('gvoting', 0);
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
	if($prop['Type'] != 3) $prop['entered'] = $_REQUEST['prop'.$prop['ID']];
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

$HEADERTEXT='Add Product for Sale';
addNavigation('profile.php?ID='.$_SESSION['memberID'],'My Profile');
addNavigation('',$HEADERTEXT);
$smarty->assign("site_title",  $HEADERTEXT." :: ".$gConfig['site_title']);
$smarty->assign("HEADERTEXT",  $HEADERTEXT);
show_smarty_template('add_product');
?>