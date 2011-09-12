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

include("../include_php/admin_init.php");

$smarty->assign("site_title",  "Profiles :: Admin Panel :: ".$gConfig['site_title']);
$smarty->assign("page_header_text",  "Profiles");

if ( $_POST['prf_form_submit'] && !$demo_mode)
{
    $sel_str = "";
    while( list( $key, $val ) = each( $_POST ) )
        if ( (int)$key && $val )
	    $sel_str .= ",$key";
    $sel_str = substr( $sel_str, 1 );
    $sel_arr = explode( ",", $sel_str );

    $owner = $PARTNER ? $_SESSION['partnerID'] : 0;
    foreach($_POST as $val=>$key)
    {    	
    	if($key=='on')
    	{
	        switch ( $_POST['prf_form_submit'] )
	        {
			    case "Delete":
			    	profile_delete( $val );
			    break;
			    case "Send Message":
			    	profile_send_message( $val, $_POST['Message_subj'],$_POST['Message'] );
			    break;
			    case 'Activate':
			    	mysql_query( "UPDATE `Profiles` SET `Status` = 'Active' WHERE `ID` = '" . (int)$val . "'" );
				
			    break;
			    case 'Deactivate':
			    	mysql_query( "UPDATE `Profiles` SET `Status` = 'Unconfirmed' WHERE `ID` = '" . (int)$val . "'" );
		    
				break;
			}
    	}
    }
}

$page		    = (int)$_GET['page'];
$p_per_page		= (int)$_GET['p_per_page'];
$profiles  		= $_GET['profiles'];
$sorttype		= $_SESSION['sorttype'];
$sortor  		= $_GET['sortor'] ? $_GET['sortor'] : $_SESSION['sortor'];
$sex		    = $_GET['sex'];
$search			= $_GET['search'];
$showAffMembers = (int)$_GET['showAffMembers'];

if ( !$page )
    $page = 1;

if ( !$p_per_page )
    $p_per_page = 30;

if ( $showAffMembers > 0 )
{
	$aff_part_w = " AND idAff = $showAffMembers AND idProfile = ID";
	$aff_part_f = ",aff_members ";
}

switch( $profiles )
{
	case 'Active':
		$prof_part = "AND `Status` = '$profiles'";
		break;
	case 'Unconfirmed':
	case 'Approval':
	case 'Rejected':
	case 'Suspended':
		$prof_part = "AND `Status` <> 'Active'";
		break;
	default:
		$prof_part = "";
}

if ( strlen($sex) )
	$sex_part = "AND Sex = '" . mysql_escape_string($sex, 1) . "'";


if (strlen($search))
{
    if ($_GET['s_mail'])
		$email_part = " AND `Email` LIKE '%$search%' ";
    elseif ($_GET['s_nickname'])
		$email_part = " AND `NickName` LIKE '%$search%' ";
    elseif ($_GET[s_id])
        $email_part = " AND `ID` = '$search' ";

}

if (isset($_GET['media']) && isset($_GET['status']))
{
	$sType       = htmlspecialchars_adv($_GET['media']);
	$sStatus      = htmlspecialchars_adv($_GET['status']);
	$sqlJoinPart = "LEFT JOIN `media` ON (`media`.`med_prof_id` = `Profiles`.`ID`)";
	$sqlWhere    = " AND `med_status` = '$sStatus' AND `med_type`='$sType'";
	$sqlGroup    = " GROUP BY `Profiles`.`ID`";
}

$sQuery = "SELECT 
				  *
				   FROM `Profiles` 
   				   
				   WHERE 1 $email_part  $prof_part  $sqlWhere $sqlGroup";

$rData = mysql_query($sQuery);
$p_num = mysql_num_rows($rData);
$pages_num = ceil( $p_num / $p_per_page );

$real_first_p = (int)($page - 1) * $p_per_page;
$page_first_p = $real_first_p + 1;

if ( $sortor == "" )
{
    $sortor = "LastLoggedIn";
}


if ( $_GET['sortor'] && ($_GET['sortor'] != $_SESSION['sortor']) )
{
    $sorttype = "DESC";
}
elseif ( $_GET['sortor'] )
{
    if ( $_SESSION['sorttype'] == "ASC" )
    {
   		$sorttype = "DESC";
   		$sortor_image = "<img src=\"./images/desc_order.gif\">";
    }
    else
    {
    	$sorttype = "ASC";
    	$sortor_image = "<img src=\"./images/asc_order.gif\">";
    }
}

if ( $profiles != "" )
{
	$inc_profiles = "profiles=$profiles&";
}
else
{
	$inc_profiles = "";
}
$n_arr = mysql_fetch_assoc(mysql_query( 'SELECT COUNT(*) FROM `Profiles`' ));
$status_arr[0] = "Active";
$status_arr[1] = "Approval";
$status_arr[2] = "Unconfirmed";
$status_arr[3] = "Rejected";
$status_arr[4] = "Suspended";

$sQuery = "SELECT *
				   FROM `Profiles` 
   				   
				   WHERE 1 $email_part $aff_part_w $prof_part $sex_part $sqlWhere $sqlGroup ORDER BY $sortor $sorttype LIMIT $real_first_p, $p_per_page;";

$result = mysql_query($sQuery);
$nav = commentNavigation($p_num,$p_per_page, $page,$path='','page');

ob_start();
?>
								<center><table cellspacing="1" cellpadding="2" border="0" width="70%" align="center" bgcolor="#cccccc" >
									<tr>
										<td bgcolor="#E5E5E5" class="text" align="left"><a href="<?php echo $site['url_admin']; ?>profiles.php">Total registered members:</a></td>
										<td bgcolor="#E5E5E5" width="50" class="text" align="right"><b><?php echo $n_arr[0]; ?></b></td>
									</tr>
<?php
$i = 0;
$iK = 1;

$sActEmColor = " #FFFFFF";

while( list( $key, $val ) = each( $status_arr ) )
{
	if ( $val == 'Active' )
	{
		$sAdd = " `Status` = '$val'";
		$sCapt = $val;
	}
	else
	{
		if ( $iK <= 1 )
		{
			$sAdd =  " `Status` <> 'Active'";
			$iK++;
			$sCapt = 'Inactive';
		}
		else
		{
			continue;
		}
	}
	
	$n_arr = mysql_fetch_assoc(mysql_query( "SELECT COUNT(*) FROM `Profiles` WHERE $sAdd" ));

	if ( $n_arr[0])
    {
?>
									<tr>
										<td class="text"  bgcolor="#ffffff" align="left" valign="middle">&nbsp;&nbsp;
											<a href="profiles.php?profiles=<? echo $val; ?>"><? echo $sCapt; ?></a>
										</td>
										<td class="prof_stat_<? echo $val; ?>" width="50" align="right"><? echo $n_arr[0]; ?></td>
									</tr>
<?
    }
    
}
$aMedia = array('photo');
foreach ($aMedia as $iK=>$sVal)
{
	$sqlUnp = "SELECT * FROM `media` WHERE `med_status` = 'passive' AND `med_type`= '$sVal' GROUP BY `med_prof_id`";
	$rUnp = mysql_query($sqlUnp);
	
	if ($rUnp && mysql_num_rows($rUnp))
	{
		?>
		<tr>
			<td class="text"  bgcolor="#ffffff" align="left" valign="middle">&nbsp;&nbsp;&nbsp;&nbsp;<img src=images/arrow.gif>
				<a href="profiles.php?media=photo&status=passive"><? echo 'With unapproved '.$sVal; ?></a>
			</td>
			<td class="text" width="50" align="right"><? echo mysql_num_rows($rUnp); ?></td>
		</tr>
		<?
	}
}

?>
								</table></center>

<br><hr><br>
	

<form method="get" action="profiles.php">
<table align="center" width="100%" cellspacing=2 cellpadding=2  border=0>
<tr>
    <td align=center colspan="3"> <input class=text name='search' size=50> </td>
	</tr>
	<tr>
	<td align="right"> <input name='s_nickname' type=submit value="Search by Nickname"> </td>
    <td align="center"> <input name='s_mail' type=submit value="Search by Email"> </td>
    <td align=left> <input name='s_id' type=submit value="Search by ID"> </td>
</tr>
</table>
</form>

<br><hr><br>


<center>

</center>
<form action="" method=post name="prf_form">
<table align="center" width=590 cellspacing=1 cellpadding=0 class=small1 border=0 bgcolor="#EEEEEE">
<?
if ( !$p_num )
    echo "<td class=panel>No profiles available</td>";
else
{
?>
<tr class=panel>
	<td>&nbsp;</td>
	<td align=center>&nbsp;<a href="profiles.php?<? echo "$inc_profiles"?>sortor=ID&p_per_page=<? echo "$p_per_page"?>">ID</a>&nbsp;<? if ( $sortor=="ID" ) echo "$sortor_image" ?></td>
	
	<td align=center>&nbsp;<a href="profiles.php?<? echo "$inc_profiles"?>sortor=NickName&p_per_page=<? echo "$p_per_page"?>">NickName</a>&nbsp;<? if ( $sortor =="NickName" ) echo "$sortor_image" ?></td>
	
	<td align=center>&nbsp;E-mail&nbsp;</td>
	
	<td align=center>Registered</td>
	
	<td align=center>&nbsp;<a href="profiles.php?<? echo "$inc_profiles"?>sortor=LastLoggedIn&p_per_page=<? echo "$p_per_page"?>">Last Visited</a>&nbsp;<? if ( $sortor=="LastLoggedIn" ) echo "$sortor_image" ?></td>
	
</tr>
<?
    
	while ( $p_arr = mysql_fetch_array( $result ) )
    {
		$col = "table";
		$sEmail = $p_arr['Status'] == 'Unconfirmed' ? '<span style="background-color: #FF6666;">'.$p_arr['Email'].'</span>' : '<span style="background-color:'.$sActEmColor.';">'.$p_arr['Email'].'</span>';
?>
<tr class=<? echo $col; ?> bgcolor="#ffffff">
	<td align=center><input type=checkbox name="<? echo $p_arr[ID]?>"></td>
	
	<td>&nbsp;<a target="_blank" href="/profile.php?ID=<? echo $p_arr[ID]; ?>"><? echo $p_arr[ID]; ?></a>&nbsp;</td>
	
	<td>&nbsp;<? echo $p_arr['NickName']; ?>&nbsp;</td>
	
	<td>&nbsp;<? echo $sEmail; ?>&nbsp;</td>
	
	<td align=center><?echo date("d-m-Y H:i",strtotime($p_arr['LastReg']))?></td>
	
	<td align=center><?echo date("d-m-Y H:i",strtotime($p_arr['LastLoggedInCur']))?></td>
	

</tr>
<?
    }
}
?>
</table>

<center><?=$nav?></center>

<table class=text border=0 width=590 align=center>
<tr>
	<td>
		<table cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td width="60">&nbsp;</td>
				<td align="left" width="140"> &nbsp;</td>
				<td width="90" align="center"><input class=text type=submit name="prf_form_submit" value="Delete"></td>
			    <td width="90" align="center"></td>
			    <td width="90" align="center"><input class=text type=submit name="prf_form_submit" value="Activate"></td>
			    <td width="90" align="center"><input class=text type=submit name="prf_form_submit" value="Deactivate"></td>
			</tr>
		</table>
	</td>
</tr>
<tr>

    <td  align="center"><hr style="width:90%; color:#e4e4e4; height:1px;">
    <b>Subject</b><br>
    <input type=text name=Message_subj style="width:540px;"><br>
    <b>Text</b><br>    
    <textarea name="Message" style="width:540px; height:100px;"></textarea></td>
</tr>
<tr>
    <td  align="center"><input class=text type=submit name="prf_form_submit" value="Send Message"></td>
</tr>
</table>
</form>
<center>

</center>
<?


$ret = ob_get_clean();
$smarty->assign("page_content",  $ret);
$smarty->display('index.tpl');

function profile_delete( $ID )
{
	$ID = (int)$ID;
	
	if ( !$ID )
	    return false;
				
		
	$aMedia = mysql_fetch_assoc(mysql_query("select * from Profiles where ID=".$ID));
    $medDir = "../media/images/profile/" . $ID . "/";
	@unlink( $medDir . 'icon_' . $aMedia['PrimPhoto'] );
	@unlink( $medDir . 'photo_' . $aMedia['PrimPhoto'] );
	@unlink( $medDir . 'thumb_' . $aMedia['PrimPhoto'] );
	@unlink( $medDir  );
	
	mysql_query( "DELETE FROM `Profiles` WHERE `ID` = '{$ID}'" );	
	mysql_query( "DELETE FROM `ProfilesRating` WHERE `voteID` = {$ID}" );
	$sCacheFile = $dir['cache'] . 'user' . $ID . '.php';
	@unlink( $sCacheFile );
	
	$q = mysql_query("select * from Books where userID=$ID");
	while($arr = mysql_fetch_assoc($q))
	{
		mysql_query("delete from Books where ID=".intval($arr['ID']));
		if($arr['Photo1'] != '')
		{
			@unlink( '../media/books/small_'.$arr['Photo1'] );
			@unlink( '../media/books/'.$arr['Photo1'] );
		}
		if($arr['Photo2'] != '')
		{
			@unlink( '../media/books/small_'.$arr['Photo2'] );
			@unlink( '../media/books/'.$arr['Photo2'] );
		}
		if($arr['Photo3'] != '')
		{
			@unlink( '../media/books/small_'.$arr['Photo3'] );
			@unlink( '../media/books/'.$arr['Photo3'] );
		}
		if($arr['Photo4'] != '')
		{
			@unlink( '../media/books/small_'.$arr['Photo4'] );
			@unlink( '../media/books/'.$arr['Photo4'] );
		}
	}
	$q = mysql_query("delete from WBooks where userID=$ID");
}

function profile_send_message( $ID, $subj,$message )
{
	global $site;

	$p_arr = mysql_fetch_assoc(mysql_query( "SELECT `ID`, `Email` FROM `Profiles` WHERE `ID` = '$ID'" ));

	if ( !$p_arr )
	    return false;

	sendMail( $p_arr['Email'],$p_arr['fname'].' '.$p_arr['lname'], $subj, $message );

}
?>
