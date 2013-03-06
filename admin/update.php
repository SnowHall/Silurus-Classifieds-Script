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
$l_upd = mysql_query("select * from Snowhall where ID='-1' limit 1");
$update = 1;

if(mysql_num_rows($l_upd) > 0) {
  $last_update = mysql_fetch_object($l_upd);
  if((time()-intval($last_update->Text)) < 60*60*24) $update = 0;
} else {
    mysql_query("insert into Snowhall set ID='-1', Title='Last Update',Text='".time()."'");
  }

if($update == 1) {
  $url = "http://snowhall.com/getnewinfo.php";
  $postVars = "?license=".urlencode($gConfig['site_license'])."&host=".urlencode($_SERVER['HTTP_HOST'])."&product=silurus";

  $q = http_request($url.$postVars);

  if(strlen($q->data) > 10) {

    if(function_exists('simplexml_load_string')) {
      $xml = $q->data;
      $serviceXML = simplexml_load_string($xml);
      if((string)$serviceXML->Answer=='0') {
		mysql_query("delete from Snowhall");
		foreach ($serviceXML->Params->Param as $param) {
          mysql_query("insert into Snowhall set ID='".intval((int)$param->ID)."',Title='".mysql_escape_string((string)$param->Title)."',Text='".mysql_escape_string((string)$param->Text)."'");
		}
		mysql_query("update Snowhall set Text='".time()."' where ID='-1'");
	  } elseif((string)$serviceXML->Answer=='3') {
          mysql_query("update Settings set Value='' where Name='site_license'");
          mysql_query("delete from Snowhall");
          foreach ($serviceXML->Params->Param as $param) {
			mysql_query("insert into Snowhall set ID='".intval((int)$param->ID)."',Title='".mysql_escape_string((string)$param->Title)."',Text='".mysql_escape_string((string)$param->Text)."'");
		  }
		  mysql_query("update Snowhall set Text='".time()."' where ID='-1'");
	    } // --- elseif((string)$serviceXML->Answer=='3')
    } // --- if(function_exists('simplexml_load_string'))
    elseif(function_exists('xml_parser_create') and function_exists('xml_parse_into_struct')) {

      $xml_parser = xml_parser_create();
      xml_parse_into_struct($xml_parser, $q->data, $vals, $index);
      if(isset($index['ANSWER'][0]) and $index['ANSWER'][0] == '3') {
        mysql_query("update Settings set Value='' where Name='site_license'");
      }

      if(isset($index['ID']) and count($index['ID'])) {
        mysql_query("delete from Snowhall");

        $i = 0;
        foreach($index['ID'] as $id) {
          $param_id = '';
          $param_title = '';
          $param_text = '';
          if(isset($vals[$id]['value'])) $param_id = $vals[$id]['value'];
          if(isset($index['TITLE'][$i])) $param_title = $vals[$index['TITLE'][$i]]['value'];
          if(isset($index['TEXT'][$i])) $param_text = $vals[$index['TEXT'][$i]]['value'];

          if($param_id != '') mysql_query("insert into Snowhall set ID='".$param_id."',Title='".mysql_escape_string($param_title)."',Text='".mysql_escape_string($param_text)."'");
          $i++;
        }
        mysql_query("update Snowhall set Text='".time()."' where ID='-1'");
      }
      
    } // --- elseif(function_exists('xml_parser_create') and function_exists('xml_parse_into_struct'))
  
  }
}

$menu_block = mysql_query("select * from Snowhall where ID='-2' limit 1");
if(mysql_num_rows($menu_block) > 0) {
  $m_block = mysql_fetch_object($menu_block);
  $smarty->assign("menu_block",  $m_block->Text);
}

$menu_block2 = mysql_query("select * from Snowhall where ID='-3' limit 1");
if(mysql_num_rows($menu_block2) > 0) {
  $m_block2 = mysql_fetch_object($menu_block2);
  $smarty->assign("menu_block2",  $m_block2->Text);
}



function http_request($url, $headers = array(), $method = 'GET', $data = NULL, $retry = 1) {
  $result = new stdClass();
  $useragent = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10';
  // Parse the URL, and make sure we can handle the schema.
  $uri = parse_url($url);
  switch ($uri['scheme']) {
    case 'http':
      $port = isset($uri['port']) ? $uri['port'] : 80;
      $host = $uri['host'] . ($port != 80 ? ':'. $port : '');
      $fp = @fsockopen($uri['host'], $port, $errno, $errstr, 15);
      break;
    case 'https':
      // Note: Only works for PHP 4.3 compiled with OpenSSL.
      $port = isset($uri['port']) ? $uri['port'] : 443;
      $host = $uri['host'] . ($port != 443 ? ':'. $port : '');
      $fp = @fsockopen('ssl://'. $uri['host'], $port, $errno, $errstr, 20);
      break;
    default:
      $result->error = 'invalid schema '. $uri['scheme'];
      return $result;
  }

  // Make sure the socket opened properly.
  if (!$fp) {
    $result->error = trim($errno .' '. $errstr);
    return $result;
  }

  // Construct the path to act on.
  $path = isset($uri['path']) ? $uri['path'] : '/';
  if (isset($uri['query'])) {
    $path .= '?'. $uri['query'];
  }

  // Create HTTP request.
  $defaults = array(
    // RFC 2616: "non-standard ports MUST, default ports MAY be included".
    // We don't add the port to prevent from breaking rewrite rules checking
    // the host that do not take into account the port number.
    'Host' => "Host: $host",
    'User-Agent' => 'User-Agent: '.$useragent,
    'Content-Length' => 'Content-Length: '. strlen($data)
  );

  foreach ($headers as $header => $value) {
    $defaults[$header] = $header .': '. $value;
  }

  $request = $method .' '. $path ." HTTP/1.0\r\n";
  $request .= implode("\r\n", $defaults);
  $request .= "\r\n\r\n";
  if ($data) {
    $request .= $data ."\r\n";
  }
  $result->request = $request;

  fwrite($fp, $request);

  // Fetch response.
  $response = '';
  while (!feof($fp) && $chunk = fread($fp, 1024)) {
    $response .= $chunk;
  }
  fclose($fp);

  // Parse response.
  list($split, $result->data) = explode("\r\n\r\n", $response, 2);
  $split = preg_split("/\r\n|\n|\r/", $split);

  list($protocol, $code, $text) = explode(' ', trim(array_shift($split)), 3);
  $result->headers = array();

  // Parse headers.
  while ($line = trim(array_shift($split))) {
    list($header, $value) = explode(':', $line, 2);
    if (isset($result->headers[$header]) && $header == 'Set-Cookie') {
      // RFC 2109: the Set-Cookie response header comprises the token Set-
      // Cookie:, followed by a comma-separated list of one or more cookies.
      $result->headers[$header] .= ','. trim($value);
    }
    else {
      $result->headers[$header] = trim($value);
    }
  }

  $responses = array(
    100 => 'Continue', 101 => 'Switching Protocols',
    200 => 'OK', 201 => 'Created', 202 => 'Accepted', 203 => 'Non-Authoritative Information', 204 => 'No Content', 205 => 'Reset Content', 206 => 'Partial Content',
    300 => 'Multiple Choices', 301 => 'Moved Permanently', 302 => 'Found', 303 => 'See Other', 304 => 'Not Modified', 305 => 'Use Proxy', 307 => 'Temporary Redirect',
    400 => 'Bad Request', 401 => 'Unauthorized', 402 => 'Payment Required', 403 => 'Forbidden', 404 => 'Not Found', 405 => 'Method Not Allowed', 406 => 'Not Acceptable', 407 => 'Proxy Authentication Required', 408 => 'Request Time-out', 409 => 'Conflict', 410 => 'Gone', 411 => 'Length Required', 412 => 'Precondition Failed', 413 => 'Request Entity Too Large', 414 => 'Request-URI Too Large', 415 => 'Unsupported Media Type', 416 => 'Requested range not satisfiable', 417 => 'Expectation Failed',
    500 => 'Internal Server Error', 501 => 'Not Implemented', 502 => 'Bad Gateway', 503 => 'Service Unavailable', 504 => 'Gateway Time-out', 505 => 'HTTP Version not supported'
  );
  // RFC 2616 states that all unknown HTTP codes must be treated the same as
  // the base code in their class.
  if (!isset($responses[$code])) {
    $code = floor($code / 100) * 100;
  }

  switch ($code) {
    case 200: // OK
    case 304: // Not modified
      break;
    case 301: // Moved permanently
    case 302: // Moved temporarily
    case 307: // Moved temporarily
      $location = $result->headers['Location'];

      if ($retry) {
        $result = http_request($result->headers['Location'], $headers, $method, $data, --$retry);
        $result->redirect_code = $result->code;
      }
      $result->redirect_url = $location;

      break;
    default:
      $result->error = $text;
  }

  $result->code = $code;
  return $result;
}

?>