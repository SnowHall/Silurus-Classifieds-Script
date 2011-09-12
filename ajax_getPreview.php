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

$type = intval($_GET['type']);
$id = intval($_GET['id']);

$book = mysql_fetch_assoc(mysql_query("select * from Store where type=".($type-1)." and ID=".$id));
$categ = mysql_fetch_assoc(mysql_query("select * from StoreCategories where ID=".$book['categoryID']));
$user = mysql_fetch_assoc(mysql_query("select * from Profiles where ID=".intval($book['userID'])));
$oVotingView = new TemplVotingView ('gvoting', 0);
$oVotingView->_fRate = $book['rating'];
$vote1 = $oVotingView->getSmallVoting (0,'');

$book['title_short'] = strlen($book['Title'])>30?substr(htmlspecialchars($book['Title']),0,30).'...':htmlspecialchars($book['Title']);
$book['price'] = number_format($book['price'],2,".","");

if($type==1)
{
	$book['url'] = '/product';
	$book['prefix'] = '';
}
else 
{
	$book['url'] = '/wproduct';
	$book['prefix'] = '_b';
}

$img = '';
$photos = array();
$q = mysql_query("select v.* from StorePropValues v inner join StoreProp p on p.ID=v.PropID where v.itemID=".$id." and p.Type=3 limit 1");
while($arr = mysql_fetch_assoc($q))
{
	if(is_file("./media/store/small_".$arr['Value'])) 
		$book['Photo1'] = $arr['Value'];
		
}

$smarty->assign("vote1",  $vote1);
$smarty->assign("book",  $book);
$smarty->assign("categ",  $categ);
$smarty->assign("user",  $user);

show_smarty_template('ap_preview');
?>





