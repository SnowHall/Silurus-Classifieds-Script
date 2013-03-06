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

$oVotingView = new TemplVotingView ('gvoting', 0);

if(isset($_REQUEST['go']))
{
	$where = '';	
	$inid = array();
	if(trim($_REQUEST['keywords'])!='')
	{
		if(isset($_REQUEST['keywords'])&&trim($_REQUEST['keywords'])!='')
		{
			$masskey = explode(" ",mysql_escape_string($_REQUEST['keywords']));		
			if(count($masskey) > 0)
			{			
				$inid[0] = array();	
				$in = 0;				
				$where .= " AND ( ";
				foreach($masskey as $word)
				{
					if($in > 0)  $where .= " OR ";
					$where .= " ss.Title like '%$word%' ";
					$in++;
				}
				$where .= ") ";	
				
				$cq = mysql_query("select ss.* from Store ss where ss.type=0 ".$where);			
				while($carr = mysql_fetch_assoc($cq)) $inid[0][] = $carr['ID'];
				$cq = mysql_query("select v.* from StorePropValues v inner join StoreProp p on p.ID=v.PropID where p.Type<3 and p.InSearch=1 ".str_replace("ss.Title","v.Value",$where));			
				while($carr = mysql_fetch_assoc($cq)) $inid[0][] = $carr['itemID'];				
			}
		}
	}
	$categoryID = intval($_REQUEST['categoryID']);
	$propq = mysql_query("select * from StoreProp where categoryID=".$categoryID." and InSearch=1 and Type>3 "); 
	while($masprop = mysql_fetch_assoc($propq))
	{
		if(isset($_REQUEST['prop'.$masprop['ID']]))
		{
			$inid[$masprop['ID']] = array();
			if($masprop['Type'] > 4)
			{
				if(is_array($_REQUEST['prop'.$masprop['ID']]) && count($_REQUEST['prop'.$masprop['ID']])>0)
				{
					$twhere = " AND ( ";
					$in = 0;
					foreach($_REQUEST['prop'.$masprop['ID']] as $item)
					{
						if($in > 0)  $twhere .= " OR ";
						$twhere .= " Value = '".intval($item)."' ";
						$in++;
					}
					$twhere .= ") ";					
					$cq = mysql_query("select * from StorePropValues where PropID=".$masprop['ID']." $twhere");
					while($carr = mysql_fetch_assoc($cq)) $inid[$masprop['ID']][] = $carr['itemID'];
				}			
			}
			if($masprop['Type'] == 4)
			{			
				$cq = mysql_query("select * from StorePropValues where PropID=".$masprop['ID']." and Value='".mysql_escape_string($_REQUEST['prop'.$masprop['ID']])."'");
				while($carr = mysql_fetch_assoc($cq)) $inid[$masprop['ID']][] = $carr['itemID'];			
			}		
			$masprop['subprop'] = $subitems;
			$properties[] = $masprop;
		}
	}	

	$inid_w = array();
	if(count($inid)>0)
		foreach ($inid as $val)
		{
			if(empty($inid_w))
			{
				$inid_w = $val;
				if(empty($inid_w)) break;
			}
			else 
			{
				$inid_w = array_intersect($inid_w,$val);
				if(empty($inid_w)) break;
			}
		}

	$order = (isset($_REQUEST['border'])?$_REQUEST['border']:'title');
	$desc = (isset($_REQUEST['bdesc'])?true:false);		
	$books = array('order'=>$order, 'desc'=>$desc, 'cur_url'=>$curUrl, 'prefix'=>'b', 'list'=>array());		
	if($order == 'date')  {$order = 's.date';}
	elseif($order == 'price')  {$order = 's.price';}
	elseif($order == 'quality')  {$order = 'c.Title';}
	else {$order = 's.Title';}		
	if(isset($_REQUEST['bdesc'])) $order .= ' desc ';
	
	$iDivis = 10;
	$iCurr  = 1;	
	if (!isset($_REQUEST['commPage']))
	{
		$sLimit =  ' LIMIT 0,'.$iDivis;
	}
	else
	{
		if($_REQUEST['commPage']<=0) $_REQUEST['commPage'] = 1;
		$iCurr = (int)$_REQUEST['commPage'];
		$sLimit =  ' LIMIT '.($iCurr - 1)*$iDivis.','.$iDivis;
	}
		
	$sQuery = ("select s.*,c.Title as ctitle from Store s inner join StoreCategories c on c.ID=s.categoryID where ".($_SESSION['location']['condition']!=''?'s.userID in '.$_SESSION['location']['condition'].' and ':'')." s.type=0 and  s.status=0 ".(intval($_REQUEST['categoryID'])>0?" and categoryID=".intval($_REQUEST['categoryID']):"")."  and s.ID in (-1".(count($inid_w)>0?','.implode(",",$inid_w):'').") order by $order ");
	
	$rElems = mysql_query( $sQuery );		
	$iNums = mysql_num_rows($rElems);	
	$count = (int)($iNums/$iDivis);
	if(($iNums/$iDivis) > (int)($iNums/$iDivis)) $count++;
	$aPaging =  ($iNums > $iDivis ? MakePaging($iNums,$iCurr,$iDivis,4,'commPage','') : '');	
	
	$rElems = mysql_query( $sQuery.$sLimit );
	while($book = mysql_fetch_assoc($rElems))
	{
		if($color == 'f5f5f5') $color = 'ffffff'; else  $color = 'f5f5f5';
		
		$temp = array();
		$temp['Color'] = $color;
		$temp['ID'] = $book['ID'];
		$temp['url'] = 'javascript:void(0);" onclick="show_book_info(\''.$book['ID'].'\',this,\'1\')';
		$temp['Title'] = htmlspecialchars($book['Title']);
		$temp['Date'] = date("F jS, Y",$book['date']);
		$temp['Price'] = number_format($book['price'],2,".","");
		$temp['ctitle'] = $book['ctitle'];
		$books['list'][] = $temp;			
	}
	$smarty->assign("sbooks",  $books);
	$smarty->assign("aPaging",  $aPaging);
		
}  
else 
{
	$categoryID = intval($_REQUEST['categoryID']);
	$ret = '';
	$q = mysql_query("select * from StoreCategories where Type=0 order by Title");
	while($arr = mysql_fetch_array($q))
	{
		if($categoryID==0) $categoryID = $arr['ID'];
		$ret .= '<option value="'.$arr['ID'].'" '.($categoryID==$arr['ID']?'selected':'').'>'.$arr['Title'].'</option>';
	}
	$smarty->assign("categ_list",  $ret);

	$properties = array();	
	$propq = mysql_query("select * from StoreProp where categoryID=".$categoryID." and InSearch=1 and Type>3 order by Prior "); 
	while($masprop = mysql_fetch_assoc($propq))
	{
		$subitems = array();
		if($masprop['Type'] > 4)
		{
			$qq = mysql_query("select * from StorePropMulti where PropID=".intval($masprop['ID'])." order by Name");
			while($subprop = mysql_fetch_assoc($qq))
				$subitems[] = $subprop;
		}
		if($masprop['Type'] == 4)
		{			
			$oVotingView->_fRate = 1;
			$voter = $oVotingView->getBigVoting (1,'',$masprop['ID']);
			$subitems = '<input type="hidden" name="prop'.$masprop['ID'].'" id="gvotingbig'.$masprop['ID'].'" value="1">'.$voter;
		}		
		$masprop['subprop'] = $subitems;
		$properties[] = $masprop;
	}	
	$smarty->assign("props",  $properties);
}

if(isset($_REQUEST['go']))
	$HEADERTEXT = 'Search Results'.(trim($_REQUEST['keywords'])!=''?' for "'.$_GET['keywords'].'"':'');	
else 
	$HEADERTEXT = 'Advanced Search';	
	
$contact_type = 1;
include("./ap_contact.php");

addNavigation('','Advanced Search');
$smarty->assign("site_title",  $HEADERTEXT." :: ".$gConfig['site_title']);
$smarty->assign("HEADERTEXT",  $HEADERTEXT);
show_smarty_template('search');		
?>
