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
 
function commentNavigation($iNumber,$iDivis, $iCurr = 0,$path='',$pername = 'commPage')
{
	global $site;
	global $aFile;
	
	$query = '';
	if(is_array($_GET))
	{
		foreach($_GET as $key=>$value)
			if ($key != $pername)
			$query .= "$key=$value&";
	}
	
	$iPages = (int)($iNumber/$iDivis);
	if(($iNumber/$iDivis) > (int)($iNumber/$iDivis)) $iPages++;
  
	$sCode = '<div style="font-size:13px; font-family:Verdana, Arial, Helvetica, sans-serif;" align="center">';
	$strt = 1; 
	if($iCurr > 3) $strt = $iCurr-2;	
	$fin = $strt+5;
	if($fin > ($iPages +1)) $fin = $iPages +1;
	if($fin == $iPages +1) $strt = $fin-5;
	if($strt < 1) $strt = 1;
	
	for ($i = $strt; $i < $fin; $i++)
	{
		$sCapt = '';
		if ($i == $strt) 
		{
			if($iCurr == 1)
				$sCapt .= "&lt;&lt; Previous Page";
			else 
				$sCapt .= '<a href="'.$_SERVER['PHP_SELF'].'?'.$query.'&'.$pername.'='.($iCurr-1).$path.'">&lt;&lt; Previous Page</a>';
			$sCapt.= " | ";	
		}
				
		$sCode .= $sCapt;
		$sLink =  ($i != $iCurr ? '<a href="'.$_SERVER['PHP_SELF'].'?'.$query.'&'.$pername.'='.$i.$path.'">'.$i.'</a>' : "".$iCurr."") . " | ";
			
		$sCapt = '';
		if ($i == $iPages) 
		{
			if($iCurr == ($fin-1))
				$sCapt .= "Next Page &gt;&gt;";
			else 
				$sCapt .= '<a href="'.$_SERVER['PHP_SELF'].'?'.$query.'&'.$pername.'='.($iCurr+1).$path.'">Next Page &gt;&gt;</a>';				
		}
		
		$sCode .= $sLink.$sCapt;
	}
	$sCode .= '</div>';
	
	return $sCode;
}

function imageResize( $filename, $dstFilename, $size )
{
    $ext = strtolower(strrchr(basename($filename), ".")); 
    $extentions = array('.jpg', '.gif', '.png', '.bmp'); 
        
    if (in_array($ext, $extentions)) {           
        $percent = $size; 
    
        list($width, $height) = getimagesize($filename); 
        $newheight = $height * $percent;
        $newwidth = $newheight / $width; 
    
        $thumb = imagecreatetruecolor($percent, $newwidth);
        switch ($ext) {
            case '.jpg': $source = imagecreatefromjpeg($filename); break;
            case '.gif': $source = imagecreatefromgif($filename); break;
            case '.png': $source = imagecreatefrompng($filename); break;
            case '.bmp': $source = imagecreatefromwbmp($filename); break;
        }

        // php уменьшение изображени€
        imagecopyresized($thumb, $source, 0, 0, 0, 0, $percent, $newwidth, $width, $height);
            
        // —оздаем изображение
        switch ($ext) {
            case '.jpg': imagejpeg($thumb, $dstFilename, 90); 
                         break;
                
            case '.gif': imagegif($thumb, $dstFilename); 
                         break;
                
            case '.png': imagepng($thumb, $dstFilename, 90); 
                         break;
                
            case '.bmp': imagewbmp($thumb, $dstFilename); 
                         break;
            }            
    } else return 'typeError'; 
    
    @imagedestroy($thumb);         
    @imagedestroy($source);  
} 

function sendMail($to, $nameto, $subject, $message)
{
 global $gConfig;
 
 if(intval($gConfig['mail_type']))
 {
		 $smtpServer = $gConfig['mail_server'];
		 $port = $gConfig['mail_port'];
		 $username = $gConfig['mail_user'];
		 $password = $gConfig['mail_pass'];
		 $from = $gConfig['mail_name'];
		 $namefrom = $gConfig['site_title'];
		/*  your configuration here  */
		$timeout = "45"; //typical timeout. try 45 for slow servers
		$localhost = $_SERVER['REMOTE_ADDR']; //requires a real ip
		$newLine = "\r\n"; //var just for newlines 
		
		/*  you shouldn't need to mod anything else */
		
		//connect to the host and port
		$smtpConnect = fsockopen($smtpServer, $port, $errno, $errstr, $timeout);
		//echo $errstr." - ".$errno;
		$smtpResponse = fgets($smtpConnect, 4096);
		if(empty($smtpConnect))
		{
		   $output = "Failed to connect: $smtpResponse";
		   //echo $output;
		   return $output;
		}
		else
		{
		   $logArray['connection'] = "Connected to: $smtpResponse";
		   //echo "connection accepted<br>".$smtpResponse."<p />Continuing<p />";
		}
		
		//you have to say HELO again after TLS is started
		   fputs($smtpConnect, "HELO $localhost". $newLine);
		   $smtpResponse = fgets($smtpConnect, 4096);
		   $logArray['heloresponse2'] = "$smtpResponse";
		   
		//request for auth login
		fputs($smtpConnect,"AUTH LOGIN" . $newLine);
		$smtpResponse = fgets($smtpConnect, 4096);
		$logArray['authrequest'] = "$smtpResponse";
		
		//send the username
		fputs($smtpConnect, base64_encode($username) . $newLine);
		$smtpResponse = fgets($smtpConnect, 4096);
		$logArray['authusername'] = "$smtpResponse";
		
		//send the password
		fputs($smtpConnect, base64_encode($password) . $newLine);
		$smtpResponse = fgets($smtpConnect, 4096);
		$logArray['authpassword'] = "$smtpResponse";
		
		//email from
		fputs($smtpConnect, "MAIL FROM: <$from>" . $newLine);
		$smtpResponse = fgets($smtpConnect, 4096);
		$logArray['mailfromresponse'] = "$smtpResponse";
		
		//email to
		fputs($smtpConnect, "RCPT TO: <$to>" . $newLine);
		$smtpResponse = fgets($smtpConnect, 4096);
		$logArray['mailtoresponse'] = "$smtpResponse";
		
		//the email
		fputs($smtpConnect, "DATA" . $newLine);
		$smtpResponse = fgets($smtpConnect, 4096);
		$logArray['data1response'] = "$smtpResponse";
		
		//construct headers
		$headers = "MIME-Version: 1.0" . $newLine;
		$headers .= "Content-type: text/html; charset=iso-8859-1" . $newLine;
		$headers .= "To: $nameto <$to>" . $newLine;
		$headers .= "From: $namefrom <$from>" . $newLine;
		$headers .= "Message-ID: <". uniqid() ."@" . $_SERVER['HTTP_HOST'] . ">" . $newLine;
		//observe the . after the newline, it signals the end of message
		fputs($smtpConnect, "Subject: $subject\r\n$headers\r\n\r\n$message\r\n.\r\n");
		$smtpResponse = fgets($smtpConnect, 4096);
		$logArray['data2response'] = "$smtpResponse";
		
		// say goodbye
		fputs($smtpConnect,"QUIT" . $newLine);
		$smtpResponse = fgets($smtpConnect, 4096);
		$logArray['quitresponse'] = "$smtpResponse";
		$logArray['quitcode'] = substr($smtpResponse,0,3);
		fclose($smtpConnect);
		
		//a return value of 221 in $retVal["quitcode"] is a success
		return($logArray);
	}
	else 
		@mail ($to, $subject, $message, "Content-type: text/html; charset=utf-8\n".
	                    "From: $gConfig[site_title] \n" .
	                    "Reply-To: $gConfig[mail_name]\n".
	                    "X-Mailer: PHP/" . phpversion());
} 

function get_banners()
{
	if(isset($_GET['delban']) && intval($_GET['banid'])>0 && $_SESSION['adminID'])
	{
		mysql_query("delete from Banners where ID=".intval($_GET['delban'])." limit 1");
		header("location: ".$_SERVER['REQUEST_URI']);
		die();
	}	
	$ret = array();
	if($_SESSION['adminID'])
	{
		for($i=1;$i<100;$i++)
		{
			$ret[$i] = '<br><input type="button" name="addban" value="ADD BANNER" onclick="window.open(\'/admin/banners.php?add&id='.$i.'\');">';
		}	
	}
	$q = mysql_query("select * from Banners order by ID");
	while($info = mysql_fetch_assoc($q))
	{
		$ret[$info['ID']] = '<a href="javascript:window.location=\'/click.php?id='.$info['ID'].'\';">'.$info['Text'].'</a><script>set_banner_show(\''.$info['ID'].'\',\''.$_SERVER['REMOTE_ADDR'].'\',\''.$_SERVER['PHP_SELF'].'\');</script>';
		if($_SESSION['adminID']) $ret[$info['ID']] .= '<br><input type="button" name="addban" value="DELETE BANNER" onclick="window.open(\'/admin/banners.php?del&id='.$info['ID'].'\');">'; 
	}
	
	return $ret;
}

function getfceditor($name,$text)
{
        include_once("../fckeditor/fckeditor.php");
		$oFCKeditor = new FCKeditor($name) ;
        $oFCKeditor->Value    =  $text;
        $oFCKeditor->BasePath = "/fckeditor/" ;
        $oFCKeditor->Width    = '100%' ;
        $oFCKeditor->Height   = '500' ;
        $ret = $oFCKeditor->Create() ;
	        
        return $ret;
}

$navigation_code = array();
function addNavigation($url,$title) 
{		
	global $navigation_code;
	$navigation_code[] = array('url'=>$url, 'title'=>$title);
}

function MakePaging($iCount,$iCurrentPage,$iCountPerPage,$iCountPageLine,$pername,$aGetParamsList='') 
{		
	if ($iCount==0) {
		return false;
	}
	
	$query = $_SERVER['PHP_SELF'].'?';
	if(is_array($_GET))
	{
		foreach($_GET as $key=>$value)
			if ($key != $pername)
			$query .= "$key=$value&";
	}
	
	$iCountPage=ceil($iCount/$iCountPerPage); 
	if (!preg_match("/^[1-9]\d*$/i",$iCurrentPage)) {
		$iCurrentPage=1;
	}		
	if ($iCurrentPage>$iCountPage) {
		$iCurrentPage=$iCountPage;
	}
	
	$aPagesLeft=array();		
	$iTemp=$iCurrentPage-$iCountPageLine;
	$iTemp = $iTemp<1 ? 1 : $iTemp; 
	for ($i=$iTemp;$i<$iCurrentPage;$i++) {
		$aPagesLeft[]=$i;
	}
	
	$aPagesRight=array();				 
	for ($i=$iCurrentPage+1;$i<=$iCurrentPage+$iCountPageLine and $i<=$iCountPage;$i++) {
		$aPagesRight[]=$i;
	}
	
	$iNextPage = $iCurrentPage<$iCountPage ? $iCurrentPage+1 : false;
	$iPrevPage = $iCurrentPage>1 ? $iCurrentPage-1 : false;
		
	$aPaging=array(
		'name' => $pername,
		'query' => $query,
		'aPagesLeft' => $aPagesLeft,
		'aPagesRight' => $aPagesRight,
		'iCountPage' => $iCountPage,
		'iCurrentPage' => $iCurrentPage,
		'iNextPage' => $iNextPage,
		'iPrevPage' => $iPrevPage,
		'sGetParams' => $aGetParamsList,
	);
	return $aPaging;
}

function show_smarty_template($name)
{
	global $smarty,$navigation_code,$gConfig;
	
	if(intval($_SESSION['memberID']) > 0) 
	{
		$smarty->assign("memberID",  $_SESSION['memberID']);
		$smarty->assign("memberINFO",  $_SESSION['memberINFO']);
	}
	if(intval($_SESSION['adminID']) > 0) 
	{
		$smarty->assign("adminID",  true);
	}	 	

	$smarty->assign("aNavi",  $navigation_code);
	$smarty->assign("insert_banner",  get_banners());
	$smarty->assign("_SERVER",  $_SERVER);
	$smarty->assign("_SESSION",  $_SESSION);
	$smarty->assign("_REQUEST",  $_REQUEST);
	$smarty->assign("_GCONFIG",  $gConfig);

	$smarty->display($name.'.tpl');	
}


?>