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

$text = array();
$q = mysql_query("select * from SimpleMain order by ID");
while($arr = mysql_fetch_assoc($q))
{
	$text[$arr['ID']] = $arr;
}

$sQuery = ("select s.*,c.Title as ctitle,c.ID as cid,p.ID as uid,CONCAT(p.fname,' ',lname) as user from Store s inner join StoreCategories c on c.ID=s.categoryID inner join Profiles p on p.ID=s.userID where ".($_SESSION['location']['condition']!=''?'s.userID in '.$_SESSION['location']['condition'].' and ':'')." s.type=0 and  s.status=0 order by s.ID desc limit 2 ");
$rElems = mysql_query( $sQuery );
while($book = mysql_fetch_assoc($rElems))
{
	$temp = array();
	$temp['ID'] = $book['ID'];
	$temp['Title'] = htmlspecialchars($book['Title']);
	$temp['Date'] = date("F jS, Y",$book['date']);
	$temp['Price'] = number_format($book['price'],2,".","");
	$temp['ctitle'] = $book['ctitle'];
	$temp['cid'] = $book['cid'];
	$temp['uid'] = $book['uid'];
	$temp['user'] = $book['user'];

	$img = '';
	$photos = array();
	$q = mysql_query("select v.* from StorePropValues v inner join StoreProp p on p.ID=v.PropID where v.itemID=".$book['ID']." and p.Type=3 limit 1");
	while($arr = mysql_fetch_assoc($q))
	{
		if(is_file("./media/store/small_".$arr['Value']))
			$img = $arr['Value'];

	}
	$temp['img'] = $img;
	$books[] = $temp;
}
$smarty->assign("recent",  $books);
$smarty->assign("recent_c", count($books));

$books = array();
$sQuery = ("select s.*,c.Title as ctitle,c.ID as cid,p.ID as uid,CONCAT(p.fname,' ',lname) as user from Store s inner join StoreCategories c on c.ID=s.categoryID inner join Profiles p on p.ID=s.userID where ".($_SESSION['location']['condition']!=''?'s.userID in '.$_SESSION['location']['condition'].' and ':'')." s.type=1 and  s.status=0 order by s.ID desc limit 2 ");
$rElems = mysql_query( $sQuery );
while($book = mysql_fetch_assoc($rElems))
{
	$temp = array();
	$temp['ID'] = $book['ID'];
	$temp['Title'] = htmlspecialchars($book['Title']);
	$temp['Date'] = date("F jS, Y",$book['date']);
	$temp['Price'] = number_format($book['price'],2,".","");
	$temp['ctitle'] = $book['ctitle'];
	$temp['cid'] = $book['cid'];
	$temp['uid'] = $book['uid'];
	$temp['user'] = $book['user'];

	$img = '';
	$photos = array();
	$q = mysql_query("select v.* from StorePropValues v inner join StoreProp p on p.ID=v.PropID where v.itemID=".$book['ID']." and p.Type=3 limit 1");
	while($arr = mysql_fetch_assoc($q))
	{
		if(is_file("./media/store/small_".$arr['Value']))
			$img = $arr['Value'];

	}
	$temp['img'] = $img;
	$books[] = $temp;
}
$smarty->assign("wrecent",  $books);
$smarty->assign("wrecent_c", count($books));

$saleCategories = array();
$wantedCategories = array();
$categoriesResult = mysql_query("SELECT `Cat`.`ID`, `Cat`.Title, `Cat`.Type, COUNT(*) AS Count
    FROM `StoreCategories` AS `Cat`, `Store` WHERE `Cat`.`ID` = `Store`.categoryID
    GROUP BY `Cat`.Title, `Cat`.Type");
while ($row = mysql_fetch_assoc($categoriesResult))
{
  switch ($row['Type'])
  {
    case '0': $saleCategories[] = $row;  break;
    case '1': $wantedCategories[] = $row; break;
    default: break;
  }
}
$smarty->assign('pcategs',$saleCategories);
$smarty->assign('pwcategs',$wantedCategories);

$featuredProducts = array();
$featuredProductsResult = mysql_query("SELECT s.*,c.Title as ctitle,c.ID as cid,p.ID as uid,CONCAT(p.fname,' ',lname) as user FROM Store s INNER JOIN StoreCategories c ON c.ID=s.categoryID INNER JOIN Profiles p ON p.ID=s.userID WHERE `featured` = 1");
while($row = mysql_fetch_assoc($featuredProductsResult))
{
  $img = '';
	$photos = array();
	$q = mysql_query("select v.* from StorePropValues v inner join StoreProp p on p.ID=v.PropID where v.itemID=".$row['ID']." and p.Type=3 limit 1");
	while($arr = mysql_fetch_assoc($q))
	{
		if(is_file("./media/store/small_".$arr['Value']))	$img = $arr['Value'];
	}
	$row['img'] = $img;
  $row['Price'] = number_format($row['price'],2,".","");
  $featuredProducts[] = $row;
}
$smarty->assign('ptop',$featuredProducts);

// Sale product count
$productsCountResult = mysql_query("SELECT COUNT(*) FROM `Store` WHERE `type`= 0");
$productCount = mysql_fetch_row($productsCountResult);
$smarty->assign('pcountprod',$productCount[0]);

// Wanted product count
$wproductsCountResult = mysql_query("SELECT COUNT(*) FROM `Store` WHERE `type`= 1");
$wproductCount = mysql_fetch_row($wproductsCountResult);
$smarty->assign('pcountwprod',$wproductCount[0]);


$smarty->assign("fb_enable",$gConfig['fb_enable']);
$smarty->assign("text_blocks",  $text);
show_smarty_template("index");

?>
