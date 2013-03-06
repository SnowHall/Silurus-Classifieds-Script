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
 
session_start();
$type = trim($_GET['type']);
$user = intval($_GET['user']);
$param = intval($_GET['param']);
if(!is_array($_SESSION['booklist'])) $_SESSION['booklist'] = array();
if(!is_array($_SESSION['booklist'][$user])) $_SESSION['booklist'][$user] = array();
$_SESSION['booklist'][$user][$type] = $param;
?>