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
$sql_dump = "
DROP TABLE IF EXISTS `Admins`;/**/
CREATE TABLE `Admins` (
  `Name` varchar(10) NOT NULL default '',
  `Password` varchar(32) NOT NULL default '',
  PRIMARY KEY  (`Name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;/**/

DROP TABLE IF EXISTS `Banners`;/**/
CREATE TABLE `Banners` (
  `ID` int(11) unsigned NOT NULL auto_increment,
  `Title` varchar(32) NOT NULL default '',
  `Url` varchar(255) NOT NULL default '',
  `Text` mediumtext NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 PACK_KEYS=0 AUTO_INCREMENT=1 ;/**/

DROP TABLE IF EXISTS `BannersClicks`;/**/
CREATE TABLE `BannersClicks` (
  `ID` int(10) unsigned NOT NULL default '0',
  `Date` date NOT NULL default '0000-00-00',
  `IP` varchar(16) NOT NULL default '',
  `URL` varchar(255) default NULL,
  `Page` varchar(255) default NULL,
  `Week` int(11) default NULL,
  `Country` varchar(255) default NULL,
  `State` varchar(255) default NULL,
  `City` varchar(255) default NULL,
  KEY `ID` (`ID`),
  KEY `iddate` (`ID`,`Date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;/**/

DROP TABLE IF EXISTS `BannersShows`;/**/
CREATE TABLE `BannersShows` (
  `ID` int(10) unsigned NOT NULL default '0',
  `Date` date NOT NULL,
  `IP` varchar(16) NOT NULL default '',
  `Week` int(11) default NULL,
  `Page` varchar(255) default NULL,
  KEY `ID` (`ID`),
  KEY `Date` (`Date`),
  KEY `IDDate` (`Date`,`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;/**/

DROP TABLE IF EXISTS `City`;/**/
CREATE TABLE `City` (
  `ID` int(11) NOT NULL auto_increment,
  `Title` varchar(255) default NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;/**/

INSERT INTO `City` (`ID`, `Title`) VALUES
(1, 'Boston'),
(2, 'New York');/**/

DROP TABLE IF EXISTS `FAQ`;/**/
CREATE TABLE `FAQ` (
  `ID` int(11) NOT NULL auto_increment,
  `Title` varchar(255) default NULL,
  `Text` text,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;/**/

INSERT INTO `FAQ` (`ID`, `Title`, `Text`) VALUES
(-1, 'Frequently Asked Questions', 'Disclaimer: Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat eiusmod tempor incididunt.'),
(-2, 'Still Have Questions?', 'Disclaimer: Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat eiusmod tempor incididunt.');/**/

DROP TABLE IF EXISTS `Flags`;/**/
CREATE TABLE `Flags` (
  `ID` int(11) NOT NULL auto_increment,
  `date` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `type` int(11) NOT NULL default '0',
  `itemID` int(11) NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;/**/

DROP TABLE IF EXISTS `letters`;/**/
CREATE TABLE `letters` (
  `ID` int(11) NOT NULL auto_increment,
  `Subject` varchar(255) default NULL,
  `Text` text,
  `Time` int(11) NOT NULL,
  `Count` int(11) NOT NULL default '0',
  `status` int(11) NOT NULL default '0',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;/**/

DROP TABLE IF EXISTS `LTemplates`;/**/
CREATE TABLE `LTemplates` (
  `ID` int(11) NOT NULL auto_increment,
  `subj` varchar(200) default NULL,
  `text` text,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;/**/

INSERT INTO `LTemplates` (`ID`, `subj`, `text`) VALUES
(1, 'Order from silurus.com', 'Hi {TO_NAME}. \r\n\r\n{FROM_NAME} would like buy your product {BOOK_LINK} for {SENDER_PRICE}.\r\n\r\n{FROM_NAME} wrote to you: \r\n{SENDER_TEXT}\r\n\r\nYou can send answer on {FROM_MAIL}\r\n\r\nBest regards, silurus.com'),
(2, 'Order from silurus.com', 'Hi {TO_NAME}. \r\n\r\n{FROM_NAME} have this product: {BOOK_LINK} for {SENDER_PRICE}.\r\n\r\n{FROM_NAME} wrote to you: \r\n{SENDER_TEXT}\r\n\r\nIf you would like buy it you can send answer on {FROM_MAIL}\r\n\r\nBest regards, silurus.com'),
(3, 'Your login and password from silurus.com ', 'Hi {TO_NAME}. \r\n\r\nYour login: {LOGIN} \r\nYour password: {PASSWORD} \r\n\r\nYou can login <a href=\"http://silurus.com\">here</a>\r\n\r\nBest regards, silurus.com'),
(4, 'Message from silurus.com', 'Hi {TO_NAME}. \r\n\r\n{FROM_NAME} wrote to you: \r\n{SENDER_TEXT}\r\n\r\nYou can send answer on {FROM_MAIL}\r\n\r\nBest regards, silurus.com');/**/

DROP TABLE IF EXISTS `Menu`;/**/
CREATE TABLE `Menu` (
  `ID` int(11) NOT NULL auto_increment,
  `Parent` int(11) NOT NULL default '0',
  `Title` varchar(255) default NULL,
  `Photo` varchar(50) default NULL,
  `Url` varchar(255) default NULL,
  `Login` int(11) NOT NULL default '0',
  `Prior` int(11) NOT NULL default '0',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;/**/

INSERT INTO `Menu` (`ID`, `Parent`, `Title`, `Photo`, `Url`, `Login`, `Prior`) VALUES
(1, 0, 'Home', 'ico1.gif', 'index.php', 0, 0),
(2, 0, 'Add Product', 'ico2.gif', 'add_product.php', 1, 2),
(3, 0, 'My Account', 'ico4.gif', 'profile.php', 1, 3),
(4, 0, 'Register', 'ico3.gif', 'join_form.php', 2, 2),
(5, 0, 'Learn More', 'ico5.gif', 'simple.php?ID=6', 2, 3),
(6, 0, 'Help', 'ico4.gif', 'faq.php', 0, 4),
(7, 0, 'Store', 'ico2.gif', 'category.php', 0, 1),
(8, 7, 'Products for Sale', '', 'category.php', 0, 0),
(9, 7, 'Wanted Products', '', 'wcategory.php', 0, 1),
(10, 2, 'Add Product for Sale', '', 'add_product.php', 1, 0),
(11, 2, 'Add Wanted Product', '', 'add_wproduct.php', 1, 1),
(12, 3, 'View My Profile', '', 'profile.php', 1, 0),
(13, 3, 'Edit My Profile', '', 'edit_user.php', 1, 1),
(15, 3, 'View My Books for Sale', '', 'my_products.php', 1, 3),
(16, 3, 'View My Books Wanted', '', 'my_wproducts.php', 1, 4),
(17, 6, 'FAQ', '', 'faq.php?faq', 0, 0),
(18, 6, 'Tech Tips', '', 'faq.php?ttips', 0, 1),
(19, 6, 'Tips for Sellers', '', 'faq.php?stips', 0, 2),
(20, 6, 'Contact Us', '', 'simple.php?ID=5', 0, 3);/**/

DROP TABLE IF EXISTS `Profiles`;/**/
CREATE TABLE `Profiles` (
  `ID` bigint(8) unsigned NOT NULL auto_increment,
  `NickName` varchar(48) NOT NULL default '',
  `Password` varchar(32) NOT NULL default '',
  `Country` int(2) NOT NULL,
  `city` varchar(255) default NULL,
  `Email` varchar(50) NOT NULL default '',
  `Status` enum('Unconfirmed','Approval','Active','Rejected','Suspended') NOT NULL default 'Unconfirmed',
  `LastLoggedIn` datetime default NULL,
  `LastReg` datetime NOT NULL default '0000-00-00 00:00:00',
  `PrimPhoto` varchar(255) default '0',
  `zip` varchar(23) NOT NULL default '',
  `Subscribe` int(11) NOT NULL default '1',
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `college` int(11) default '0',
  `intro` text NOT NULL,
  `note` text NOT NULL,
  `phone` varchar(255) NOT NULL,
  `cell` varchar(255) NOT NULL,
  `altemail` varchar(255) NOT NULL,
  `aim` varchar(255) NOT NULL,
  `skype` varchar(255) NOT NULL,
  `rating` float default '0',
  `LastModified` int(11) NOT NULL,
  `rating_count` int(11) NOT NULL default '0',
  `phone_none` int(11) NOT NULL default '0',
  `cell_none` int(11) NOT NULL default '0',
  `altemail_none` int(11) NOT NULL default '0',
  `aim_none` int(11) NOT NULL default '0',
  `skype_none` int(11) NOT NULL default '0',
  PRIMARY KEY  (`ID`),
  UNIQUE KEY `NickName` (`NickName`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;/**/

INSERT INTO `Profiles` (`ID`, `NickName`, `Password`, `Country`, `city`, `Email`, `Status`, `LastLoggedIn`, `LastReg`, `PrimPhoto`, `zip`, `Subscribe`, `fname`, `lname`, `college`, `intro`, `note`, `phone`, `cell`, `altemail`, `aim`, `skype`, `rating`, `LastModified`, `rating_count`, `phone_none`, `cell_none`, `altemail_none`, `aim_none`, `skype_none`) VALUES
(1, 'demo', 'fe01ce2a7fbac8fafaed7c982a04e229', 0, NULL, 'demo@gmail.com', 'Active', '2009-05-07 15:07:02', '2009-05-07 06:34:09', '1241699650.jpg', '451256', 1, 'Demo', 'Demo', 1, 'My Introduction and Personal Statement', 'My Seller''s Policies and Notes', '456-789-123', 'mycell', 'mymai@gmail.com', 'myaim', 'myskype', 0, 1241699649, 0, 0, 0, 0, 0, 0);/**/

DROP TABLE IF EXISTS `ProfilesRating`;/**/
CREATE TABLE `ProfilesRating` (
  `ID` int(11) NOT NULL auto_increment,
  `userID` int(11) NOT NULL,
  `voteID` int(11) NOT NULL,
  `Title` varchar(255) default NULL,
  `Text` text,
  `date` int(11) NOT NULL,
  `rating` int(11) NOT NULL default '0',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;/**/

DROP TABLE IF EXISTS `Settings`;/**/
CREATE TABLE `Settings` (
  `Name` varchar(100) default NULL,
  `Value` varchar(100) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;/**/

INSERT INTO `Settings` (`Name`, `Value`) VALUES
('site_templates', 'default'),
('site_license', ''),
('site_keywords', ''),
('capcha_item', '1'),
('logo_title', 'Silurus'),
('logo_slogan', 'your slogan here'),
('site_description', ''),
('mail_type', '0'),
('mail_name', ''),
('mail_server', ''),
('mail_port', ''),
('mail_user', ''),
('mail_pass', '');/**/

DROP TABLE IF EXISTS `Simple`;/**/
CREATE TABLE `Simple` (
  `ID` int(11) NOT NULL auto_increment,
  `Text` longtext,
  `Title` varchar(255) default NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 PACK_KEYS=0 AUTO_INCREMENT=8 ;/**/

INSERT INTO `Simple` (`ID`, `Text`, `Title`) VALUES
(1, 'Disclaimer: Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat eiusmod tempor incididunt.Disclaimer: Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat eiusmod tempor incididunt.', 'Terms of Use'),
(2, 'Disclaimer: Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat eiusmod tempor incididunt.Disclaimer: Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat eiusmod tempor incididunt.Disclaimer: Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat eiusmod tempor incididunt.', 'Privacy Policy'),
(3, '<p>Disclaimer: Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat eius<span style=\"color:#FF6600;\">mod tempor incididunt.Disclaimer: Lorem ipsum dolor sit amet, consectetur adipisicing eli</span>t, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat eiusmod tempor incididunt.Disclaimer: Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat eiusmod tempor incididunt.</p>', 'About Us'),
(5, 'Disclaimer: Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat eiusmod tempor incididunt.Disclaimer: Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat eiusmod tempor incididunt.Disclaimer: Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat eiusmod tempor incididunt.', 'Contact Us'),
(6, 'Disclaimer: Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat eiusmod tempor incididunt.Disclaimer: Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat eiusmod tempor incididunt.Disclaimer: Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat eiusmod tempor incididunt.', 'Learn More');/**/

DROP TABLE IF EXISTS `SimpleMain`;/**/
CREATE TABLE `SimpleMain` (
  `ID` int(11) NOT NULL auto_increment,
  `Text` longtext,
  `Title` varchar(255) default NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 PACK_KEYS=0 AUTO_INCREMENT=8 ;/**/

INSERT INTO `SimpleMain` (`ID`, `Text`, `Title`) VALUES
(1, 'Post anything with price, photos, \r\nand information about your selling.', 'Header block'),
(2, 'Post anything with price, photos, and information about your selling.', 'Block #1'),
(3, 'Members contact you by email, phone, AIM, or however you prefer', 'Block #2'),
(4, 'Meet members to exchange anything for payment', 'Block #3'),
(7, 'Disclaimer: Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat eiusmod tempor incididunt.', 'Footer block');/**/

DROP TABLE IF EXISTS `Snowhall`;/**/
CREATE TABLE `Snowhall` (
  `ID` int(11) NOT NULL,
  `Title` varchar(255) default NULL,
  `Text` mediumtext,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;/**/

INSERT INTO `Snowhall` (`ID`, `Title`, `Text`) VALUES
(-1, 'Last Update', '1241770113'),
(-3, 'Contact Us', '\n<script>\n	function send_feed()\n	{\n		var ajaxObjects = new sack();					\n		ajaxObjects.onCompletion = function(){eval(ajaxObjects.response);};			\n		ajaxObjects.requestFile = \"/admin/asenddata.php?type=\"+document.getElementById(''feed_type'').value+\"&text=\"+document.getElementById(''feed_text'').value+\"&nocash=\"+(new Date().getTime());	\n		ajaxObjects.runAJAX();\n	}\n</script>\n\n<div style=\"text-align:center; margin:20px;\" id=\"act_content\">\n<span style=\"font-size:18px;color:#054575;\"><b>Contact Snowhall</b></span><br><br>\n\n<div id=\"act_error\"></div>	\n\n<select id=\"feed_type\">\n<option value=\"1\">General Enquires</option>\n<option value=\"2\">Report a Bug</option>\n<option value=\"3\">Order a Work</option>\n</select><br><br>\n<textarea id=\"feed_text\" style=\"width:200px;height:80px;\"></textarea><br><br>\n<input type=\"button\" onclick=\"send_feed()\" value=\"Send\">						\n</div>\n'),
(-4, 'Index page', '<br><span style=\"font-size:18px;color:#054575;\"><b>SnowHall News</b></span><br>\n<table width=\"100%\">\n    <tr>\n      <td>\n        <a href=\"http://snowhall.com/fulldevelopment\" style=\"color:#504393\"><b>Full Development Project</b></a>\n        <br>SnowHall is a team of proficient web developers and design experts.\n      </td>\n    </tr>\n    <tr>\n      <td>\n        <a href=\"http://snowhall.com/develop\" style=\"color:#504393\"><b>Web Developing</b></a>\n        <br>Our specialists are skilled in creating dynamic, highly interactive and functional websites.\n      </td>\n    </tr>\n    <tr>\n      <td>\n        <a href=\"http://snowhall.com/design\" style=\"color:#504393\"><b>Web Design</b></a>\n        <br>We design and develop excellent user interface with a great look and feel and easy to use functionalities.      </td>\n    </tr>  \n    <tr>\n      <td>\n        <a href=\"http://snowhall.com/promote\" style=\"color:#504393\"><b>Web Site Promoting</b></a>\n        <br>Our SEO and website promotion services guarantees to drive potential clients from the search engines to your website.\n      </td>\n    </tr>    \n  </table>\n');/**/

DROP TABLE IF EXISTS `STips`;/**/
CREATE TABLE `STips` (
  `ID` int(11) NOT NULL auto_increment,
  `Title` varchar(255) default NULL,
  `Text` text,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;/**/

INSERT INTO `STips` (`ID`, `Title`, `Text`) VALUES
(-1, 'Tips for Sellers', 'Disclaimer: Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat eiusmod tempor incididunt.');/**/

DROP TABLE IF EXISTS `Store`;/**/
CREATE TABLE `Store` (
  `ID` int(10) unsigned NOT NULL auto_increment,
  `categoryID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `price` float NOT NULL,
  `date` int(11) NOT NULL,
  `status` int(11) NOT NULL default '0',
  `LastModified` int(11) NOT NULL,
  `type` int(11) NOT NULL default '0',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;/**/

INSERT INTO `Store` (`ID`, `categoryID`, `userID`, `Title`, `price`, `date`, `status`, `LastModified`, `type`) VALUES
(1, 8, 1, 'DELL LATITUDE D600', 275, 1241699783, 0, 1241699783, 1),
(2, 7, 1, 'Catana 431 Catamaran Norfolk VA LOW RESERVE', 200000, 1241699936, 0, 1241699936, 1),
(3, 5, 1, 'SCHWINN S2132WM MANTA RAY', 1000, 1241700055, 0, 1241700055, 1),
(4, 3, 1, 'Algebra for students', 120, 1241700120, 0, 1241700120, 0),
(5, 1, 1, 'Lexus IS ', 20000, 1241700222, 0, 1241700222, 0),
(6, 2, 1, 'TOUCH SCREEN UNLOCKED PHONE CELL I9 AT&T T-MOBILE', 200, 1241700331, 0, 1241700331, 0);/**/

DROP TABLE IF EXISTS `StoreCategories`;/**/
CREATE TABLE `StoreCategories` (
  `ID` int(11) NOT NULL auto_increment,
  `Title` varchar(255) default NULL,
  `Type` int(11) NOT NULL default '0',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;/**/

INSERT INTO `StoreCategories` (`ID`, `Title`, `Type`) VALUES
(1, 'Cars', 0),
(2, 'Cell Phones & PDAs', 0),
(3, 'Books', 0),
(4, 'Real Estate', 0),
(5, 'Cycling', 1),
(6, 'Home Security', 1),
(7, 'Boats', 1),
(8, 'Computers & Networking', 1);/**/

DROP TABLE IF EXISTS `StoreProp`;/**/
CREATE TABLE `StoreProp` (
  `ID` int(11) NOT NULL auto_increment,
  `Name` varchar(20) NOT NULL,
  `Type` int(11) NOT NULL default '1',
  `Prior` int(11) NOT NULL default '0',
  `InSearch` int(11) NOT NULL default '0',
  `categoryID` int(11) NOT NULL,
  `Required` int(11) NOT NULL default '0',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=48 ;/**/


INSERT INTO `StoreProp` (`ID`, `Name`, `Type`, `Prior`, `InSearch`, `categoryID`, `Required`) VALUES
(1, 'Mileage', 1, 0, 1, 1, 1),
(2, 'VIN', 1, 1, 1, 1, 1),
(3, 'Body type', 5, 3, 1, 1, 1),
(4, 'Transmission', 5, 4, 1, 1, 0),
(5, 'Fuel type', 5, 0, 1, 1, 0),
(6, 'Exterior color', 5, 0, 1, 1, 0),
(7, 'Interior color', 6, 0, 1, 1, 0),
(8, 'Brand', 5, 0, 1, 2, 1),
(9, 'Model', 1, 1, 1, 2, 0),
(10, 'Camera', 1, 0, 1, 2, 0),
(11, 'Condition', 4, 10, 0, 1, 1),
(12, 'Photo #1', 3, 10, 0, 1, 0),
(13, 'Photo', 3, 0, 0, 2, 0),
(14, 'Features', 2, 0, 1, 2, 1),
(15, 'Condition', 4, 0, 0, 2, 0),
(16, 'Photo', 3, 0, 0, 3, 0),
(17, 'Condition', 4, 0, 0, 3, 0),
(18, 'ISBN', 1, 0, 0, 3, 1),
(19, 'Author', 1, 0, 1, 3, 1),
(20, 'Edition', 1, 0, 0, 3, 0),
(21, 'Photo #2', 3, 10, 0, 1, 0),
(22, 'Photo #3', 3, 10, 0, 1, 0),
(23, 'Area Acreage', 1, 0, 0, 4, 1),
(24, 'Property Address', 1, 0, 0, 4, 0),
(25, 'City', 1, 0, 0, 4, 1),
(26, 'Photo', 3, 0, 0, 4, 1),
(27, 'Brand', 1, 0, 1, 5, 1),
(28, 'Model', 1, 0, 1, 5, 0),
(29, 'Condition', 4, 0, 0, 5, 0),
(30, 'Model Year', 1, 0, 0, 5, 1),
(31, 'Frame Size', 1, 0, 0, 5, 0),
(32, 'Photo', 3, 0, 0, 5, 0),
(33, 'Condition', 4, 0, 0, 6, 1),
(34, 'Photo', 3, 0, 0, 6, 0),
(35, 'Brand', 1, 0, 0, 6, 1),
(36, 'Length', 1, 0, 0, 7, 1),
(37, 'Beam', 1, 0, 0, 7, 1),
(38, 'Photo', 3, 0, 0, 7, 0),
(39, 'Condition', 1, 0, 0, 7, 1),
(40, 'Hull material', 1, 0, 0, 7, 0),
(41, 'Rigging', 1, 0, 0, 7, 0),
(42, 'Brand', 5, 0, 0, 8, 1),
(43, 'Screen Size', 1, 0, 0, 8, 1),
(44, 'Operating System', 1, 0, 0, 8, 1),
(45, 'Processor Type', 1, 0, 0, 8, 0),
(46, 'Photo', 3, 0, 0, 8, 1),
(47, 'Condition', 4, 0, 0, 8, 1);/**/


DROP TABLE IF EXISTS `StorePropMulti`;/**/
CREATE TABLE IF NOT EXISTS `StorePropMulti` (
  `ID` int(11) NOT NULL auto_increment,
  `Name` varchar(255) NOT NULL,
  `PropID` int(11) NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=39 ;/**/

INSERT INTO `StorePropMulti` (`ID`, `Name`, `PropID`) VALUES
(1, 'Sedan', 3),
(2, 'Coupe', 3),
(3, 'Cabriolet', 3),
(4, 'Modell', 3),
(5, 'Hatchback', 3),
(6, 'Automatic', 4),
(7, 'Manual', 4),
(8, 'Gasoline', 5),
(9, 'Disel', 5),
(10, 'Electric', 5),
(11, 'Red', 6),
(12, 'Green', 6),
(13, 'Black', 6),
(14, 'White', 6),
(15, 'Blue', 6),
(16, 'Red', 7),
(17, 'Green', 7),
(18, 'White', 7),
(19, 'Black', 7),
(20, 'Blue', 7),
(21, 'Grey', 7),
(22, 'Sony', 8),
(23, 'Apple', 8),
(24, 'Nokia', 8),
(25, 'Samsung', 8),
(26, 'HTC', 8),
(27, 'Asus', 8),
(28, 'HP', 8),
(29, 'Other...', 8),
(30, 'Dell', 42),
(31, 'Sony', 42),
(32, 'HP', 42),
(33, 'Asus', 42),
(34, 'Aser', 42),
(35, 'Samsung', 42);/**/

DROP TABLE IF EXISTS `StorePropValues`;/**/
CREATE TABLE `StorePropValues` (
  `PropID` int(11) NOT NULL,
  `itemID` int(11) default NULL,
  `Value` text,
  `ID` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=40 ;/**/

INSERT INTO `StorePropValues` (`PropID`, `itemID`, `Value`, `ID`) VALUES
(42, 1, '30', 1),
(43, 1, '15.9', 2),
(44, 1, 'Windows XP Professional', 3),
(45, 1, 'Intel Pentium 4 M', 4),
(46, 1, 'P1241699783146.jpg', 5),
(47, 1, '4', 6),
(36, 2, '43.0 feet', 7),
(37, 2, '24.0 feet', 8),
(38, 2, 'P1241699936138.jpg', 9),
(39, 2, 'Good condition', 10),
(40, 2, 'Fiberglass', 11),
(41, 2, 'Sloop/Cutter', 12),
(27, 3, 'schwinn', 13),
(28, 3, '', 14),
(29, 3, '3', 15),
(30, 3, '1998', 16),
(31, 3, '40', 17),
(32, 3, 'P1241700055132.jpg', 18),
(17, 4, '4', 19),
(18, 4, '549-452353-5634-5635463-6535', 20),
(19, 4, 'John Doe', 21),
(20, 4, 'Second', 22),
(1, 5, '15000', 23),
(2, 5, '	JTHBK262062001247', 24),
(3, 5, '1', 25),
(4, 5, '6', 26),
(5, 5, '8', 27),
(6, 5, '11', 28),
(7, 5, '19', 29),
(7, 5, '21', 30),
(11, 5, '5', 31),
(12, 5, 'P1241700222112.jpg', 32),
(21, 5, 'P1241700222121.jpg', 33),
(8, 6, '24', 34),
(9, 6, '', 35),
(10, 6, '1-2 Megapixels', 36),
(13, 6, 'P1241700331113.jpg', 37),
(14, 6, 'Unlocked, Bluetooth Enabled, Calendar, Color Screen, Email Access, Internet Browser, Java Enabled, MMS Enabled, MP3 Player, Radio, SMS-Text Messaging, Speakerphone, Touch Screen, USB Interface, Video Recording, Video Streaming', 38),
(15, 6, '3', 39);/**/

DROP TABLE IF EXISTS `TTips`;/**/
CREATE TABLE `TTips` (
  `ID` int(11) NOT NULL auto_increment,
  `Title` varchar(255) default NULL,
  `Text` text,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;/**/

INSERT INTO `TTips` ( `ID` , `Title` , `Text` ) 
VALUES (
'-1', 'Tips', 'Tips Tips'
);/**/

";


$err = '';
if($_SERVER['REQUEST_METHOD']=='POST')
{
	/*foreach ($_POST as $val)
		if(trim($val)=='') 
			$err = 'All fields required';
*/
	if($err=='')
	{
		$conn = @mysql_connect($_REQUEST['base_host'].":".$_REQUEST['base_port'],$_REQUEST['base_user'],$_REQUEST['base_pass']); 
		if ($conn)
		{
			if ((@mysql_select_db($_REQUEST['base_name']))) 
			{
				$quer = preg_split("/;\/\*\*\//", $sql_dump); 
	            foreach($quer as $query) 
	            { 
	            	if(trim($query)!='' && !@mysql_query(trim($query))) 
	                { 		              	
	                   $err =  "MySQL error: <b>\"".mysql_error()."\"</b><br/><br/>Incorrect query: <b>\"".$query."\"</b>";
	                   break;
	                }
	            } 
			}
			else			
				$err =  "Couldn't select database ".$_REQUEST['base_name'];
		}
		else
			$err = "Couldn't connect to the database";
	}
	if($err=='')
	{
		if(!mysql_query("insert into Admins set Name='".mysql_escape_string($_REQUEST['admin_login'])."',Password='".md5($_REQUEST['admin_pass'])."'") ||
		   !mysql_query("insert into Settings set Name='site_title',Value='".mysql_escape_string($_REQUEST['site_title'])."'") ||
		   !mysql_query("insert into Settings set Name='site_url',Value='".mysql_escape_string($_REQUEST['site_url'])."'") ||
		   !mysql_query("insert into Settings set Name='site_path',Value='".mysql_escape_string($_REQUEST['site_path'])."'"))
        	 $err =  "Couldn't create config settings in database";
	}
	if($err=='')
	{
		if($f = @fopen($_REQUEST['site_path'].'dbconfig.inc',"w"))
		{
			fwrite($f,trim("
<?
\$gConfig = array(
'base_host'=>'".$_REQUEST['base_host'].":".$_REQUEST['base_port']."',
'base_user'=>'".$_REQUEST['base_user']."',
'base_pass'=>'".$_REQUEST['base_pass']."',
'base_name'=>'".$_REQUEST['base_name']."'
);		
?>"));
			fclose($f);
		}
		else 
		{
			$err =  "Couldn't create dbconfig.inc file<br>Try create it manualy and place folow text<br><br><font color=black>
			&lt;?
			\$gConfig = array(<br>
				'base_host'=>'".$_REQUEST['base_host'].":".$_REQUEST['base_port']."',<br>
				'base_user'=>'".$_REQUEST['base_user']."',<br>
				'base_pass'=>'".$_REQUEST['base_pass']."',<br>
				'base_name'=>'".$_REQUEST['base_name']."'
			);		<br>
			?&gt;</font><Br><br>";
		}
	}
	if($err=='')
	{
		header("location: ".$_REQUEST['site_url']);
		die();
	}
}
else 
{	
	$_REQUEST['base_port'] = '3306';
	$_REQUEST['base_host'] = 'localhost';
	$_REQUEST['site_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/';
	$_REQUEST['site_path'] = $_SERVER['DOCUMENT_ROOT'].'/';
	$_REQUEST['site_title'] = 'Silurus';
	$_REQUEST['admin_login'] = 'admin';
	$_REQUEST['admin_pass'] = 'admin';
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
	<head>
		<title>Silurus Install</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" href="/templates/admin_default/general.css" type="text/css" />

			</head>
	<body id="admin_cont">
		
			<div class="top_header"></div>
<div style="padding-left:50px;">
			
<div class="page_header">Silurus Install</div>	<br>

<?
if($err!='') print '<font color=red><b>'.$err.'</b></font><br><br>';
?>
<form action="" method="POST">

<div class="page_header" style="font-size:14px;">Database Settings</div>	
<div class="block_cont">
<table>
<tr>
<td>
Port: 
</td>
<td width="20px">&nbsp;</td>
<td>
<input style="width:300px;" type="text" name="base_port" value="<?=htmlspecialchars($_REQUEST['base_port'])?>">
</td>
</tr>

<tr>
<td>
Host: 
</td>
<td width="20px">&nbsp;</td>
<td>
<input style="width:300px;" type="text" name="base_host" value="<?=htmlspecialchars($_REQUEST['base_host'])?>">
</td>
</tr>

<tr>
<td>
User: 
</td>
<td width="20px">&nbsp;</td>
<td>
<input style="width:300px;" type="text" name="base_user" value="<?=htmlspecialchars($_REQUEST['base_user'])?>">
</td>
</tr>

<tr>
<td>
Password: 
</td>
<td width="20px">&nbsp;</td>
<td>
<input style="width:300px;" type="text" name="base_pass" value="<?=htmlspecialchars($_REQUEST['base_pass'])?>">
</td>
</tr>

<tr>
<td>
DB Name: 
</td>
<td width="20px">&nbsp;</td>
<td>
<input style="width:300px;" type="text" name="base_name" value="<?=htmlspecialchars($_REQUEST['base_name'])?>">
</td>
</tr>
</table>
</div>
<br><br>

<div class="page_header" style="font-size:14px;">Site Settings</div>	
<div class="block_cont">
<table>

<tr>
<td>
Full URL (http://sitename.com/): 
</td>
<td width="20px">&nbsp;</td>
<td>
<input style="width:300px;" type="text" name="site_url" value="<?=htmlspecialchars($_REQUEST['site_url'])?>">
</td>
</tr>

<tr>
<td>
Path: 
</td>
<td width="20px">&nbsp;</td>
<td>
<input style="width:300px;" type="text" name="site_path" value="<?=htmlspecialchars($_REQUEST['site_path'])?>">
</td>
</tr>

<tr>
<td>
Site Title: 
</td>
<td width="20px">&nbsp;</td>
<td>
<input style="width:300px;" type="text" name="site_title" value="<?=htmlspecialchars($_REQUEST['site_title'])?>">
</td>
</tr>
</table>
</div>
<br><br>

<div class="page_header" style="font-size:14px;">Admin Settings</div>	
<div class="block_cont">
<table>
<tr>
<td>
Admin Login: 
</td>
<td width="20px">&nbsp;</td>
<td>
<input style="width:300px;" type="text" name="admin_login" value="<?=htmlspecialchars($_REQUEST['admin_login'])?>">
</td>
</tr>

<tr>
<td>
Admin Password: 
</td>
<td width="20px">&nbsp;</td>
<td>
<input style="width:300px;" type="text" name="admin_pass" value="<?=htmlspecialchars($_REQUEST['admin_pass'])?>">
</td>
</tr>
</table>
</div>
<br><br>
<input type="submit" name="go" value="Install">
</form>
</div><br>
		<div class="bottom_cont">
		</div>
			</body>
	</html>
