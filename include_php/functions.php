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

        // php ���������� �����������
        imagecopyresized($thumb, $source, 0, 0, 0, 0, $percent, $newwidth, $width, $height);

        // ������� �����������
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

function sendMail($to, $nameto, $subject, $message) {
	require '../libs/PHPMailer/class.phpmailer.php';
	global $gConfig;

	$mail             = new PHPMailer();

	if (intval($gConfig['mail_type'])) {
		$mail->IsSMTP();
		if (strlen($gConfig['mail_user'])) {
			$mail->SMTPAuth   = true;
		}
		if (intval($gConfig['mail_ssl'])) {
			$mail->SMTPSecure = 'ssl';
		}
		$mail->Host       = $gConfig['mail_server'];
		$mail->Port       = $gConfig['mail_port'];
		if (strlen($gConfig['mail_user'])) {
			$mail->Username   = $gConfig['mail_user'];
		}
		if (strlen($gConfig['mail_pass'])) {
			$mail->Password   = $gConfig['mail_pass'];
		}
	}
  if ($gConfig['mail_name']) {
    $mail->SetFrom($gConfig['mail_name'], $gConfig['site_title']);
    $mail->AddReplyTo($gConfig['mail_name'], $gConfig['site_title']);
  }
	$mail->Subject    = $subject;
	$mail->MsgHTML($message);
	$mail->AddAddress($to, $nameto);

	$result = array('success' => true);
	if(!$mail->Send()) {
		$result['success'] = false;
		$result['error'] = $mail->ErrorInfo;
	}

	return $result;
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
			$ret[$i] = '<br><input type="button" name="addban" value="ADD BANNER" onclick="window.open(\'admin/banners.php?add&id='.$i.'\');">';
		}
	}
	$q = mysql_query("select * from Banners order by ID");
	while($info = mysql_fetch_assoc($q))
	{
		$ret[$info['ID']] = '<a href="javascript:window.location=\'click.php?id='.$info['ID'].'\';">'.$info['Text'].'</a><script>set_banner_show(\''.$info['ID'].'\',\''.$_SERVER['REMOTE_ADDR'].'\',\''.$_SERVER['PHP_SELF'].'\');</script>';
		if($_SESSION['adminID']) $ret[$info['ID']] .= '<br><input type="button" name="addban" value="DELETE BANNER" onclick="window.open(\'admin/banners.php?del&id='.$info['ID'].'\');">';
	}

	return $ret;
}

function getfceditor($name,$text)
{
		global $gConfig;
        include_once("../fckeditor/fckeditor.php");
		$oFCKeditor = new FCKeditor($name) ;
        $oFCKeditor->Value    =  $text;
        $oFCKeditor->BasePath = $gConfig['site_url'] . "/fckeditor/" ;
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

function get_ip()
{
     if(isset($HTTP_SERVER_VARS))
     {
        if(isset($HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"])) $realip = $HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"];
        elseif(isset($HTTP_SERVER_VARS["HTTP_CLIENT_IP"])) $realip = $HTTP_SERVER_VARS["HTTP_CLIENT_IP"];
        else $realip = $HTTP_SERVER_VARS["REMOTE_ADDR"];
    }
    else
    {
        if(getenv( 'HTTP_X_FORWARDED_FOR' ) ) $realip = getenv( 'HTTP_X_FORWARDED_FOR' );
        elseif ( getenv( 'HTTP_CLIENT_IP' ) ) $realip = getenv( 'HTTP_CLIENT_IP' );
        else $realip = getenv( 'REMOTE_ADDR' );
    }
    return $realip;
}

// removes files and non-empty directories
function rrmdir($dir) {
  if (is_dir($dir)) {
    $files = scandir($dir);
    foreach ($files as $file)
    if ($file != "." && $file != "..") rrmdir("$dir/$file");
    rmdir($dir);
  }
  else if (file_exists($dir)) unlink($dir);
}

// copies files and non-empty directories
function rcopy($src, $dst) {
  if (file_exists($dst)) rrmdir($dst);
  if (is_dir($src)) {
    mkdir($dst);
    $files = scandir($src);
    foreach ($files as $file)
    if ($file != "." && $file != "..") rcopy("$src/$file", "$dst/$file");
  }
  else if (file_exists($src)) copy($src, $dst);
}

// parse .po file into database
function parseTranslationFile($filename,$dir)
{
  $localeFile = fopen($dir.$filename,'rb');

  $lang = basename($filename, '.po');

  $context = 'COMMENT';
  $current = array();
  $lineNum = 0;

  mysql_query('DELETE FROM `Locales` WHERE `language` = "'.substr($lang,-2).'"');

  while (!feof($localeFile))
  {
    // A line should not be longer than 10 * 1024.
    $line = fgets($localeFile, 10 * 1024);

    // The first line might come with a UTF-8 BOM, which should be removed.
    if ($lineNum == 0) $line = str_replace("\xEF\xBB\xBF", '', $line);

    $lineNum++;

    // Trim away the linefeed.
    $line = trim(strtr($line, array("\\\n" => "")));

    if (!strncmp('#', $line, 1))
    {
      // Lines starting with '#' are comments.

      if ($context == 'COMMENT') $current['#'][] = substr($line, 1);
      elseif ($context == 'MSGSTR')
      {
        // We are currently in string token, close it out.
        addTranslateToDb($current, $lang);

        // Start a new entry for the comment.
        $current         = array();
        $current['#'][]  = substr($line, 1);

        $context = 'COMMENT';
      }
      else
      {
        return 'The translation file %filename contains an error: "msgstr" was expected but not found on line '.$lineNum;
      }
    }
    elseif (!strncmp('msgid', $line, 5))
    {
      if ($context == 'MSGSTR')
      {
        addTranslateToDb($current, $lang);
        $current = array();
      }
      elseif ($context == 'MSGID')
      {
        return 'The translation file %filename contains an error: "msgid" is unexpected on line'.$lineNum;
      }

      // Remove 'msgid' and trim away whitespace.
      $line = trim(substr($line, 5));

      $quoted = parseQuotedString($line);
      if ($quoted === false)
      {
        return 'The translation file contains a syntax error on line '.$lineNum;
      }

      $current['msgid'] = $quoted;
      $context = 'MSGID';
    }
    elseif (!strncmp("msgstr", $line, 6))
    {
      // A string for the an id or context.
      if ($context != 'MSGID')
      {
        return 'The translation file %filename contains an error: "msgstr" is unexpected on line '.$lineNum;
      }

      // Remove 'msgstr' and trim away away whitespaces.
      $line = trim(substr($line, 6));

      $quoted = parseQuotedString($line);
      if ($quoted === FALSE)
      {
        return 'The translation file %filename contains a syntax error on line '.$lineNum;
      }

      $current['msgstr'] = $quoted;
      $context = 'MSGSTR';
    }
    elseif ($line != '')
    {
      // Anything that is not a token may be a continuation of a previous token.

      $quoted = parseQuotedString($line);
      if ($quoted === false)
      {
        return 'The translation file %filename contains a syntax error on line '.$lineNum.'.';
      }

      // Append the string to the current context.
      if ($context == 'MSGID') $current['msgid'] .= $quoted;
      elseif ($context == 'MSGSTR') $current['msgstr'] .= $quoted;
      else
      {
        return 'The translation file contains an error: there is an unexpected string on line '.$line.'.';
      }
    }
  }

  // End of PO file, closed out the last entry.
  if ($context == 'MSGSTR') addTranslateToDb($current, $lang);
  elseif ($context != 'COMMENT')
  {
    return 'The translation file ended unexpectedly.';
  }
}

function parseQuotedString($string)
{
    if (substr($string, 0, 1) != substr($string, -1, 1))  return false;

    $quote = substr($string, 0, 1);
    $string = substr($string, 1, -1);

    if ($quote == '"') return stripcslashes($string);
    elseif ($quote == "'") return $string;
    else return false;
}

function addTranslateToDb($value, $lang = NULL)
{
    $english = $value['msgid'];
    $translation = $value['msgstr'];
    if ($english && $translation)
    {
      mysql_query('INSERT INTO `Locales` (`language`,`source`,`translation`) VALUES ("'.$lang.'","'.$english.'","'.$translation.'")');
    }
}

function t($message, $language = NULL)
{
  global $translations;

  if (!$language)
  {
    $langSql = mysql_query('SELECT `Value` FROM `Settings` WHERE `Name` = "language"');
    $language = mysql_fetch_assoc($langSql);
    $language = isset($language['Value']) ? $language['Value'] : 'en';
  }

  //if english - return message as-is
  if ($language == 'en') return $message;

  if (!$translations)
  {
    $translateSql = mysql_query('SELECT * FROM `Locales` WHERE `language` = "'.$language.'"');
    while ($translateRow = mysql_fetch_assoc($translateSql))
    {
      $translations[$translateRow['source']] = $translateRow['translation'];
    }
  }

  return $translations[$message] ? $translations[$message] : $message;
}
?>