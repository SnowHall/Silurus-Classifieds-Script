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


$smarty->assign("text_blocks",  $text); 
show_smarty_template("index");

?>
