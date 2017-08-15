/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50709
Source Host           : localhost:3306
Source Database       : pmassetmanager

Target Server Type    : MYSQL
Target Server Version : 50709
File Encoding         : 65001

Date: 2016-10-01 17:43:59
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for authassignment
-- ----------------------------
DROP TABLE IF EXISTS `authassignment`;
CREATE TABLE `authassignment` (
  `itemname` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `userid` int(64) NOT NULL,
  `bizrule` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `data` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  PRIMARY KEY (`itemname`,`userid`),
  KEY `userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of authassignment
-- ----------------------------
INSERT INTO `authassignment` VALUES ('AMP Master Admin', '1', null, null);
INSERT INTO `authassignment` VALUES ('AMP Master Admin', '3', null, 'N;');
INSERT INTO `authassignment` VALUES ('AMP Master Admin', '4', null, 'N;');
INSERT INTO `authassignment` VALUES ('AMP Master Admin', '11', null, 'N;');
INSERT INTO `authassignment` VALUES ('AMP Master Admin', '12', null, 'N;');
INSERT INTO `authassignment` VALUES ('AMP Master Admin', '13', null, 'N;');
INSERT INTO `authassignment` VALUES ('AMP Master Admin', '14', null, 'N;');
INSERT INTO `authassignment` VALUES ('AMP Master Admin', '15', null, 'N;');
INSERT INTO `authassignment` VALUES ('AMP Office', '2', null, 'N;');
INSERT INTO `authassignment` VALUES ('AMP Office', '7', null, 'N;');
INSERT INTO `authassignment` VALUES ('AMP Office', '10', null, 'N;');
INSERT INTO `authassignment` VALUES ('AMP Operator', '3', null, 'N;');
INSERT INTO `authassignment` VALUES ('AMP Shipper ', '3', null, 'N;');
INSERT INTO `authassignment` VALUES ('AMP Shipper ', '8', null, 'N;');
INSERT INTO `authassignment` VALUES ('AMP Shipper ', '9', null, 'N;');

-- ----------------------------
-- Table structure for authitem
-- ----------------------------
DROP TABLE IF EXISTS `authitem`;
CREATE TABLE `authitem` (
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `bizrule` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `data` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  PRIMARY KEY (`name`,`type`),
  UNIQUE KEY `idx_name` (`name`,`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of authitem
-- ----------------------------
INSERT INTO `authitem` VALUES ('Admin', '2', null, null, null);
INSERT INTO `authitem` VALUES ('Super Admin', '2', null, null, null);

-- ----------------------------
-- Table structure for authitemchild
-- ----------------------------
DROP TABLE IF EXISTS `authitemchild`;
CREATE TABLE `authitemchild` (
  `parent` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of authitemchild
-- ----------------------------

-- ----------------------------
-- Table structure for tbl_client
-- ----------------------------
DROP TABLE IF EXISTS `tbl_client`;
CREATE TABLE `tbl_client` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `address1` varchar(1024) NOT NULL,
  `address2` varchar(1024) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state_id` int(11) NOT NULL,
  `zipcode` varchar(255) NOT NULL,
  `country` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `fax` varchar(20) DEFAULT NULL,
  `company_name` varchar(50) NOT NULL,
  `contact_name` varchar(50) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `created_time` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_client
-- ----------------------------
INSERT INTO `tbl_client` VALUES ('1', 'Phil', 'LA, US', '', '', '0', '', 'US', 'phil@example.com', '123', '1212112', 'Ball Media', 'Philip Kul', '1', '1426097092');
INSERT INTO `tbl_client` VALUES ('2', 'CUSTOMER1 TEST', '202-446 grey st', '', 'Brantford', '59', 'N3S 7L6', 'Canada', 'c1@ballmedia.com', '5197550853', '5197568641', 'CUSTOMER TEST COMPANY', 'JOHN TEST', '1', '1429086792');
INSERT INTO `tbl_client` VALUES ('3', 'HungTN', 'Hanoi VN', '', 'Hanoi', '2', '100000', 'US', 'hungtn87@gmail.com', '0909098788989', '9987978', 'HVD companry', 'Hung', '1', '1430448573');
INSERT INTO `tbl_client` VALUES ('4', 'GFW', '485 Conestoga Blvd.', '', 'Cambridge', '59', 'N1R 7P4', 'Canada', 'dherteis@gfw.ca', '519-740-8680', '519-740-7658', 'GFW TECHNOLOGIES INC.', 'DAN HERTEIS', '1', '1442329851');
INSERT INTO `tbl_client` VALUES ('5', 'SNS INDUSTRIAL', '142 Sugar Maple Rd.', '', 'St. George', '59', 'N0E 1N0', 'Canada', 'cindy.hancock@snsindustrial.com', '(519) 448-3055', '519-448-3060', 'SNS INDUSTRIAL GROUP', 'CINDY HANDCOCK', '1', '1442406741');
INSERT INTO `tbl_client` VALUES ('6', 'GFW', '485 Conestoga Boulevard', '', 'Cambridge', '59', 'N1P 7P4', 'Canada', 'dadam@gfw.ca', '519-740-8680', '519-740-7658', 'GWF TECHNOLOGIES', 'Daniel Adam', '1', '1443875474');
INSERT INTO `tbl_client` VALUES ('7', 'Morrow Crane', '', '', 'Brantford', '59', '', 'Canada', '', '', '', 'Morrow Crane', 'Jason Stewart', '1', '1446835918');
INSERT INTO `tbl_client` VALUES ('8', 'Kuriyama Canada Inc.', '140 Roy Blvd.', '', 'Brantford', '59', 'N35 7W9', 'Canada', 'kciwalt@kuritech.com', '519-759-1673  x114', '519-759-7478', 'Kuriyama Canada Inc.', 'Walter Vogt', '1', '1448410429');
INSERT INTO `tbl_client` VALUES ('9', 'SNS INDUSTRIAL (SAM)', '142 Sugar Maple Rd.', '', 'St. George', '59', 'N0E 1N0', 'Canada', 'sam.sheets@snsindustrial.com', '(519) 448-3055', '519-448-3060', 'SNS INDUSTRIAL', 'Sam Sheets', '1', '1448452013');
INSERT INTO `tbl_client` VALUES ('10', 'DOMITE', '20 Lee Ave.', '', 'Paris', '59', 'N3L 3T6', 'Canada', 'chris@domite.com', '519-442-3129   Cell ', '519-442-2604', 'DOMITE (MMI)', 'Chris Otway', '1', '1455293223');
INSERT INTO `tbl_client` VALUES ('11', 'SOLARSHIP INC', '175 Aviation Avenue,  Brantford Municipal Airport', '', 'Brantford', '59', 'N3T 5L7', 'Canada', 'abezkorow@solarship.com', '519-751-2590', '', 'SOLARSHIP INC', 'Andrew Bezkorow', '1', '1457728744');
INSERT INTO `tbl_client` VALUES ('12', 'Redetec (David L)', '442-T DUFFERIN STREET', '', 'TORONTO', '59', 'M6K 2A3', 'CANADA', 'david@redetec.com', '416-788-2403', '', 'Redetec Inc.', 'David Laciak', '1', '1462294139');
INSERT INTO `tbl_client` VALUES ('13', 'Reynolds', '155 Sugar Maple Rd.', '', 'St. George', '59', 'N0E 1N0', 'Canada', 'don@reynoldsmachine.ca', '519-448-1180', '519-448-1006', 'Reynolds Custom Machine', 'Don Reynolds', '1', '1469461499');
INSERT INTO `tbl_client` VALUES ('14', 'North Robotics', '1731 Mortimer St.', '', 'Vancouver', '53', 'V8P 3AP', 'Canada', 'ahendry@northrobotics.com', '250-508-7037', '', 'North Robotics', 'Allan Hendry', '1', '1472745027');

-- ----------------------------
-- Table structure for tbl_client_category
-- ----------------------------
DROP TABLE IF EXISTS `tbl_client_category`;
CREATE TABLE `tbl_client_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `created_time` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=armscii8;

-- ----------------------------
-- Records of tbl_client_category
-- ----------------------------
INSERT INTO `tbl_client_category` VALUES ('2', 'PREFFERED', '1', '12');
INSERT INTO `tbl_client_category` VALUES ('3', 'STANDARD', '1', '12');

-- ----------------------------
-- Table structure for tbl_client_file
-- ----------------------------
DROP TABLE IF EXISTS `tbl_client_file`;
CREATE TABLE `tbl_client_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of tbl_client_file
-- ----------------------------

-- ----------------------------
-- Table structure for tbl_email_template
-- ----------------------------
DROP TABLE IF EXISTS `tbl_email_template`;
CREATE TABLE `tbl_email_template` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `description` varchar(255) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `created_time` int(11) unsigned NOT NULL,
  `created_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=armscii8;

-- ----------------------------
-- Records of tbl_email_template
-- ----------------------------
INSERT INTO `tbl_email_template` VALUES ('1', 'EMAIL_ORDER_TO_CLIENT', 'ORDER CONFIRMATION Order #%ORDER%', 'Dear %CUSTOMER% \n\nThank you for the recent order #%ORDER%  you made on %DATE%. This is a confirmation that your order has been successfully received and all details are correct. Please review the order and confirm as soon as \npossible using the approve/ confirm button and optional signature pad.You may use the upload button to upload a ORDER or REVISED ORDER if needed. When we receive this, we can move the order into production.\nAttached to this message is a copy of your order, which also includes the details of your order. \n\nAM PRECISION TOOL values your business and is continuously looking for ways to better satisfy their customers. Please do share with us if there is a way we can serve you better.', 'Email Order to client', '1', '0', '1');
INSERT INTO `tbl_email_template` VALUES ('2', 'EMAIL_ORDER_TO_CLIENT_REVISED', 'REVISED ORDER CONFIRMATION Order #%ORDER%', 'Dear %CUSTOMER% \n\nThank you for the recent order #%ORDER%  you made on %DATE%. This is an confirmation that your order has been successfully received. In reviewing the details, we have made revisions to certain items. Please review the order and confirm as soon as \npossible using the approve/ confirm button and optional signature pad.You may use the upload button to upload a ORDER or REVISED ORDER if needed. When we receive this, we can move the order into production.\nAttached to this message is a copy of your order, which also includes the details of your order. \n\nAM PRECISION TOOL values your business and is continuously looking for ways to better satisfy their customers. Please do share with us if there is a way we can serve you better.', 'Email Order to client', '1', '0', '1');
INSERT INTO `tbl_email_template` VALUES ('3', 'EMAIL_ORDER_TO_CLIENT_SHORT', 'SHORT FORM ORDER CONFIRMATION #%ORDER%', 'Hello %CUSTOMER%,\r\n\r\nThank you for the recent order #%ORDER%  made on %DATE%. Your price list and delivery dates have all been confirmed.  Any  revisions may be uploaded using the UPLOAD button or via email.  By clicking confirm your order will immediately move into production.', 'Email Order to Client | Short version', '1', '0', '1');
INSERT INTO `tbl_email_template` VALUES ('4', 'EMAIL_ORDER_TO_CLIENT_REVISED_SHORT', 'SHORT FORM ORDER CONFIRMATION : REVISED %ORDER%', 'Hello %CUSTOMER%,\r\n\r\nThank you for the recent order #%ORDER%  made on %DATE%.   This is a revised order confirmation. Please review the revised order and confirm as soon as possible.   Any further revisions may be uploaded using the UPLOAD button or communicated via email.  By clicking confirm & uploading your revised PURCHASE ORDER your order will immediately move into production.', 'Email Order to Client Revised | Short Version', '1', '0', '1');

-- ----------------------------
-- Table structure for tbl_employee
-- ----------------------------
DROP TABLE IF EXISTS `tbl_employee`;
CREATE TABLE `tbl_employee` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `created_time` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=armscii8;

-- ----------------------------
-- Records of tbl_employee
-- ----------------------------
INSERT INTO `tbl_employee` VALUES ('1', 'Nam Nguyen', '1', '3');
INSERT INTO `tbl_employee` VALUES ('2', 'Linh Pham', '1', '1441257639');
INSERT INTO `tbl_employee` VALUES ('3', 'Thành Lê', '1', '1441258150');
INSERT INTO `tbl_employee` VALUES ('4', 'Hung Tran', '1', '1441258173');
INSERT INTO `tbl_employee` VALUES ('5', 'Huong Duong', '1', '1441258175');
INSERT INTO `tbl_employee` VALUES ('6', 'Giang Nguyen Thi', '1', '1441258177');
INSERT INTO `tbl_employee` VALUES ('7', 'GFW', '1', '1442329583');
INSERT INTO `tbl_employee` VALUES ('8', 'Kevin Beamer', '1', '1448017819');
INSERT INTO `tbl_employee` VALUES ('9', 'Dave Sandilands', '1', '1448017836');
INSERT INTO `tbl_employee` VALUES ('10', 'Mark Symington', '1', '1448017847');
INSERT INTO `tbl_employee` VALUES ('11', 'Joe Mansour', '1', '1448017854');
INSERT INTO `tbl_employee` VALUES ('12', 'Nick Cioerta', '1', '1448017874');
INSERT INTO `tbl_employee` VALUES ('13', 'Debbie Gadke', '1', '1448017884');
INSERT INTO `tbl_employee` VALUES ('14', 'Ed Mansour', '1', '1448017892');

-- ----------------------------
-- Table structure for tbl_file
-- ----------------------------
DROP TABLE IF EXISTS `tbl_file`;
CREATE TABLE `tbl_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(256) NOT NULL,
  `extension` varchar(32) NOT NULL,
  `dirname` varchar(256) NOT NULL,
  `filesize` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_time` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=249 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_file
-- ----------------------------
INSERT INTO `tbl_file` VALUES ('1', 'hung_nt_4', 'png', 'data/upload/image/2015/04/03', '474385', '1', '1428045440', '1');
INSERT INTO `tbl_file` VALUES ('2', 'hung_nt_5', 'png', 'data/upload/image/2015/04/03', '474385', '1', '1428045640', '1');
INSERT INTO `tbl_file` VALUES ('3', 'load_certificate', 'png', 'data/upload/image/2015/04/03', '25937', '1', '1428045890', '1');
INSERT INTO `tbl_file` VALUES ('4', 'load_certificate_1', 'png', 'data/upload/image/2015/04/03', '25937', '1', '1428045920', '1');
INSERT INTO `tbl_file` VALUES ('5', 'load_certificate_2', 'png', 'data/upload/image/2015/04/03', '25937', '1', '1428045970', '1');
INSERT INTO `tbl_file` VALUES ('6', 'Mua_Chung', 'jpg', 'data/upload/image/2015/04/03', '403294', '1', '1428050469', '1');
INSERT INTO `tbl_file` VALUES ('7', 'load_certificate_3', 'png', 'data/upload/image/2015/04/03', '25937', '1', '1428052487', '1');
INSERT INTO `tbl_file` VALUES ('8', 'load_certificate_4', 'png', 'data/upload/image/2015/04/03', '25937', '1', '1428052914', '1');
INSERT INTO `tbl_file` VALUES ('9', 'load_certificate_5', 'png', 'data/upload/image/2015/04/03', '25937', '1', '1428053925', '1');
INSERT INTO `tbl_file` VALUES ('10', 'load_certificate_6', 'png', 'data/upload/image/2015/04/03', '25937', '1', '1428054124', '1');
INSERT INTO `tbl_file` VALUES ('11', 'load_certificate_7', 'png', 'data/upload/image/2015/04/03', '25937', '1', '1428054269', '1');
INSERT INTO `tbl_file` VALUES ('12', 'load_certificate_8', 'png', 'data/upload/image/2015/04/03', '25937', '1', '1428054291', '1');
INSERT INTO `tbl_file` VALUES ('13', 'load_certificate_9', 'png', 'data/upload/image/2015/04/03', '25937', '1', '1428054340', '1');
INSERT INTO `tbl_file` VALUES ('14', 'load_certificate_10', 'png', 'data/upload/image/2015/04/03', '25937', '1', '1428054436', '1');
INSERT INTO `tbl_file` VALUES ('15', 'load_certificate_11', 'png', 'data/upload/image/2015/04/03', '25937', '1', '1428054477', '1');
INSERT INTO `tbl_file` VALUES ('16', 'load_certificate_12', 'png', 'data/upload/image/2015/04/03', '25937', '1', '1428054560', '1');
INSERT INTO `tbl_file` VALUES ('17', 'load_certificate_13', 'png', 'data/upload/image/2015/04/03', '25937', '1', '1428054629', '1');
INSERT INTO `tbl_file` VALUES ('18', 'load_certificate_14', 'png', 'data/upload/image/2015/04/03', '25937', '1', '1428054678', '1');
INSERT INTO `tbl_file` VALUES ('19', 'load_certificate_15', 'png', 'data/upload/image/2015/04/03', '25937', '1', '1428054712', '1');
INSERT INTO `tbl_file` VALUES ('20', 'load_certificate_16', 'png', 'data/upload/image/2015/04/03', '25937', '1', '1428054829', '1');
INSERT INTO `tbl_file` VALUES ('21', 'Mua_Chung_1', 'jpg', 'data/upload/image/2015/04/03', '403294', '1', '1428054844', '1');
INSERT INTO `tbl_file` VALUES ('22', 'load_certificate_17', 'png', 'data/upload/image/2015/04/03', '25937', '1', '1428054896', '1');
INSERT INTO `tbl_file` VALUES ('23', 'load_certificate_18', 'png', 'data/upload/image/2015/04/03', '25937', '1', '1428055665', '1');
INSERT INTO `tbl_file` VALUES ('24', 'load_certificate_19', 'png', 'data/upload/image/2015/04/03', '25937', '1', '1428055717', '1');
INSERT INTO `tbl_file` VALUES ('25', 'load_certificate_20', 'png', 'data/upload/image/2015/04/03', '25937', '1', '1428055882', '1');
INSERT INTO `tbl_file` VALUES ('26', 'load_certificate_21', 'png', 'data/upload/image/2015/04/03', '25937', '1', '1428055901', '1');
INSERT INTO `tbl_file` VALUES ('27', 'load_certificate_22', 'png', 'data/upload/image/2015/04/03', '25937', '1', '1428055968', '1');
INSERT INTO `tbl_file` VALUES ('28', 'load_certificate_23', 'png', 'data/upload/image/2015/04/03', '25937', '1', '1428056555', '1');
INSERT INTO `tbl_file` VALUES ('29', 'load_certificate_24', 'png', 'data/upload/image/2015/04/03', '25937', '1', '1428056560', '1');
INSERT INTO `tbl_file` VALUES ('30', 'load_certificate_25', 'png', 'data/upload/image/2015/04/03', '25937', '1', '1428056769', '1');
INSERT INTO `tbl_file` VALUES ('31', 'load_certificate_26', 'png', 'data/upload/image/2015/04/03', '25937', '1', '1428056798', '1');
INSERT INTO `tbl_file` VALUES ('32', 'load_certificate_27', 'png', 'data/upload/image/2015/04/03', '25937', '1', '1428056814', '1');
INSERT INTO `tbl_file` VALUES ('33', 'load_certificate_28', 'png', 'data/upload/image/2015/04/03', '25937', '1', '1428056867', '1');
INSERT INTO `tbl_file` VALUES ('34', 'load_certificate_29', 'png', 'data/upload/image/2015/04/03', '25937', '1', '1428056929', '1');
INSERT INTO `tbl_file` VALUES ('35', 'load_certificate_30', 'png', 'data/upload/image/2015/04/03', '25937', '1', '1428056979', '1');
INSERT INTO `tbl_file` VALUES ('36', 'load_certificate_31', 'png', 'data/upload/image/2015/04/03', '25937', '1', '1428057078', '1');
INSERT INTO `tbl_file` VALUES ('37', 'load_certificate_32', 'png', 'data/upload/image/2015/04/03', '25937', '1', '1428057264', '1');
INSERT INTO `tbl_file` VALUES ('38', 'Mua_Chung_2', 'jpg', 'data/upload/image/2015/04/03', '403294', '1', '1428057284', '1');
INSERT INTO `tbl_file` VALUES ('39', 'Mua_Chung_3', 'jpg', 'data/upload/image/2015/04/03', '403294', '1', '1428057373', '1');
INSERT INTO `tbl_file` VALUES ('45', 'load_certificate_36', 'png', 'data/upload/image/2015/04/03', '25937', '1', '1428075521', '1');
INSERT INTO `tbl_file` VALUES ('47', 'load_certificate_38', 'png', 'data/upload/image/2015/04/03', '25937', '1', '1428079036', '0');
INSERT INTO `tbl_file` VALUES ('48', 'load_certificate_39', 'png', 'data/upload/image/2015/04/03', '25937', '1', '1428079644', '0');
INSERT INTO `tbl_file` VALUES ('49', 'load_certificate_40', 'png', 'data/upload/image/2015/04/03', '25937', '1', '1428079719', '2');
INSERT INTO `tbl_file` VALUES ('50', 'load_certificate_46', 'png', 'data/upload/image/2015/04/03', '25937', '1', '1428080490', '2');
INSERT INTO `tbl_file` VALUES ('51', 'load_certificate_47', 'png', 'data/upload/image/2015/04/03', '25937', '1', '1428080552', '1');
INSERT INTO `tbl_file` VALUES ('52', 'DWG_load_certificate', 'png', 'data/upload/image/2015/04/03', '25937', '1', '1428081035', '1');
INSERT INTO `tbl_file` VALUES ('53', 'PDF_Tamkinh_104cmx68_5cm', 'png', 'data/upload/image/2015/04/04', '121198', '1', '1428125136', '2');
INSERT INTO `tbl_file` VALUES ('54', 'DWG_aaaa', 'png', 'data/upload/image/2015/04/05', '60930', '1', '1428261377', '1');
INSERT INTO `tbl_file` VALUES ('55', 'PDF_aaaa', 'png', 'data/upload/image/2015/04/05', '60930', '1', '1428261405', '2');
INSERT INTO `tbl_file` VALUES ('56', 'CERT_AM Designation Mill Cert', 'pdf', 'data/upload/other/2015/04/06', '4410345', '1', '1428355181', '3');
INSERT INTO `tbl_file` VALUES ('57', 'DWG_banner_fb_2-0412', 'jpg', 'data/upload/image/2015/04/08', '84833', '1', '1428473547', '1');
INSERT INTO `tbl_file` VALUES ('65', 'SHAPE_shape_square', 'png', 'data/upload/image/2015/04/09', '1096', '1', '1428599757', '0');
INSERT INTO `tbl_file` VALUES ('66', 'SHAPE_shape_tb', 'png', 'data/upload/image/2015/04/09', '3182', '1', '1428599760', '0');
INSERT INTO `tbl_file` VALUES ('70', 'OTHER_Quote_KELOWNA_TEST', 'pdf', 'data/upload/other/2015/04/15', '7623', '1', '1429112760', '0');
INSERT INTO `tbl_file` VALUES ('72', 'OTHER_15984671010_82a8608383_k', 'jpg', 'data/upload/image/2015/04/15', '821381', '1', '1429112859', '0');
INSERT INTO `tbl_file` VALUES ('73', 'OTHER_Corner Close Display (1)', 'png', 'data/upload/image/2015/04/15', '28606', '1', '1429112995', '0');
INSERT INTO `tbl_file` VALUES ('74', 'OTHER_button', 'JPG', 'data/upload/other/2015/04/15', '8926', '1', '1429113049', '0');
INSERT INTO `tbl_file` VALUES ('75', '[123doc.vn] - thi nghiem vat lieu dien_2', 'pdf', 'data/upload/other/2015/04/15', '2192', '1', '1429113050', '0');
INSERT INTO `tbl_file` VALUES ('77', 'OTHER_carrier confirm ', 'pdf', 'data/upload/other/2015/04/15', '103002', '1', '1429114990', '0');
INSERT INTO `tbl_file` VALUES ('78', 'OTHER_Lecture-Notes-1', 'pdf', 'data/upload/other/2015/04/15', '565748', '1', '1429115080', '0');
INSERT INTO `tbl_file` VALUES ('79', 'OTHER_ket_handbook', 'pdf', 'data/upload/other/2015/04/15', '3930786', '1', '1429115103', '0');
INSERT INTO `tbl_file` VALUES ('80', 'OTHER_Hexagonal_bar', 'png', 'data/upload/image/2015/04/17', '5924', '1', '1429236017', '0');
INSERT INTO `tbl_file` VALUES ('81', 'OTHER_Square_bar', 'png', 'data/upload/image/2015/04/17', '5195', '1', '1429236035', '0');
INSERT INTO `tbl_file` VALUES ('82', 'OTHER_Rectangular_bar', 'png', 'data/upload/image/2015/04/17', '5176', '1', '1429236059', '0');
INSERT INTO `tbl_file` VALUES ('83', 'OTHER_Round_bar', 'png', 'data/upload/image/2015/04/17', '5536', '1', '1429236085', '0');
INSERT INTO `tbl_file` VALUES ('84', 'Hexagonal_bar_1', 'png', 'data/upload/image/2015/04/17', '5924', '1', '1429236578', '0');
INSERT INTO `tbl_file` VALUES ('85', 'OTHER_Hexagonal_bar', 'png', 'data/upload/image/2015/04/19', '5924', '1', '1429436193', '0');
INSERT INTO `tbl_file` VALUES ('86', 'Hexagonal_bar_1', 'png', 'data/upload/image/2015/04/19', '5924', '1', '1429437782', '0');
INSERT INTO `tbl_file` VALUES ('87', 'Hexagonal_bar_2', 'png', 'data/upload/image/2015/04/19', '5924', '1', '1429437818', '0');
INSERT INTO `tbl_file` VALUES ('88', 'Material 20150419', 'png', 'data/upload/image/2015/04/19', '380663', '1', '1429471075', '-1');
INSERT INTO `tbl_file` VALUES ('89', 'OTHER_3', 'png', 'data/upload/image/2015/04/22', '22499', '1', '1429674180', '0');
INSERT INTO `tbl_file` VALUES ('91', 'OTHER_CASTING', 'JPG', 'data/upload/other/2015/05/06', '24501', '1', '1430876778', '0');
INSERT INTO `tbl_file` VALUES ('92', 'OTHER_TUBING', 'JPG', 'data/upload/other/2015/05/06', '19577', '1', '1430876817', '0');
INSERT INTO `tbl_file` VALUES ('96', 'OTHER_316threadedrod', 'pdf', 'data/upload/other/2015/05/27', '265017', '1', '1432740790', '0');
INSERT INTO `tbl_file` VALUES ('97', '316threadedrod_1', 'pdf', 'data/upload/other/2015/05/27', '265017', '1', '1432740942', '0');
INSERT INTO `tbl_file` VALUES ('98', 'OTHER_Desert', 'jpg', 'data/upload/image/2015/07/29', '845941', '1', '1438138125', '0');
INSERT INTO `tbl_file` VALUES ('99', 'Desert_1', 'jpg', 'data/upload/image/2015/07/29', '845941', '1', '1438138251', '0');
INSERT INTO `tbl_file` VALUES ('100', 'Desert_2', 'jpg', 'data/upload/image/2015/07/29', '845941', '1', '1438138956', '0');
INSERT INTO `tbl_file` VALUES ('101', 'OTHER_Hydrangeas', 'jpg', 'data/upload/image/2015/07/31', '595284', '1', '1438316054', '0');
INSERT INTO `tbl_file` VALUES ('102', 'SHEET_28513OP2', 'doc', 'data/upload/other/2015/08/14', '116736', '1', '1439596023', '10');
INSERT INTO `tbl_file` VALUES ('103', 'DWG_28513STEMHEAD', 'pdf', 'data/upload/other/2015/08/15', '38172', '1', '1439650508', '1');
INSERT INTO `tbl_file` VALUES ('104', 'BP_CCF07292015 3', 'pdf', 'data/upload/other/2015/09/01', '560517', '1', '1441150142', '7');
INSERT INTO `tbl_file` VALUES ('105', 'BP_CCF07292015 3', 'pdf', 'data/upload/other/2015/09/15', '560517', '1', '1442328486', '7');
INSERT INTO `tbl_file` VALUES ('106', 'BP_YC98413-717', 'pdf', 'data/upload/other/2015/09/15', '129272', '1', '1442328838', '7');
INSERT INTO `tbl_file` VALUES ('107', 'PO_RFQGFW1008', 'xlsx', 'data/upload/other/2015/09/15', '51509', '1', '1442328862', '4');
INSERT INTO `tbl_file` VALUES ('108', 'PO_0690_001', 'pdf', 'data/upload/other/2015/09/15', '36471', '1', '1442329527', '4');
INSERT INTO `tbl_file` VALUES ('109', 'BP_CCF06302015_0003', 'pdf', 'data/upload/other/2015/09/16', '999949', '1', '1442404379', '7');
INSERT INTO `tbl_file` VALUES ('110', 'RFQEXC_RFQSNS1008', 'xlsx', 'data/upload/other/2015/09/16', '51688', '1', '1442406004', '18');
INSERT INTO `tbl_file` VALUES ('111', 'BP_VA001-533-84 - 6 PISTON', 'PDF', 'data/upload/other/2015/09/16', '81778', '1', '1442406055', '7');
INSERT INTO `tbl_file` VALUES ('112', 'BP_VA001-533-84 - 7 PISTON ROD', 'PDF', 'data/upload/other/2015/09/16', '88301', '1', '1442410590', '7');
INSERT INTO `tbl_file` VALUES ('113', 'RFQEXC_RFQSNS1009', 'xlsx', 'data/upload/other/2015/09/16', '51457', '1', '1442410614', '18');
INSERT INTO `tbl_file` VALUES ('114', 'VA001-533-84 - 7 PISTON ROD_1', 'PDF', 'data/upload/other/2015/09/16', '88301', '1', '1442411978', '7');
INSERT INTO `tbl_file` VALUES ('115', 'RFQSNS1009_1', 'xlsx', 'data/upload/other/2015/09/16', '51457', '1', '1442411989', '18');
INSERT INTO `tbl_file` VALUES ('118', 'TOOL_3.07mmOsg', 'JPG', 'data/upload/other/2015/09/29', '88258', '1', '1443529636', '11');
INSERT INTO `tbl_file` VALUES ('119', 'RFQEXC_E2GEN28124430', 'PDF', 'data/upload/other/2015/09/29', '64874', '1', '1443529643', '18');
INSERT INTO `tbl_file` VALUES ('120', 'RFQEXC_RFQnylonrollerSep28_15', 'xlsx', 'data/upload/other/2015/09/29', '52563', '1', '1443529647', '18');
INSERT INTO `tbl_file` VALUES ('121', 'RFQEXC_RFQSNS1011', 'xlsx', 'data/upload/other/2015/10/12', '52505', '1', '1444692172', '18');
INSERT INTO `tbl_file` VALUES ('122', 'RFQEXC_RFQGFW1013BOLT&COUPLING', 'xlsx', 'data/upload/other/2015/10/16', '52972', '1', '1445039779', '18');
INSERT INTO `tbl_file` VALUES ('123', 'RFQEXC_RFQGFW1014_OCT_19_15', 'xlsx', 'data/upload/other/2015/10/19', '52655', '1', '1445298599', '18');
INSERT INTO `tbl_file` VALUES ('124', 'PDF_YC70185-933', 'pdf', 'data/upload/other/2015/10/19', '115444', '1', '1445298649', '2');
INSERT INTO `tbl_file` VALUES ('125', 'RFQEXC_RFQSNS14INPISTON3INTHREAD', 'xlsx', 'data/upload/other/2015/11/02', '52683', '1', '1446495599', '18');
INSERT INTO `tbl_file` VALUES ('126', 'PDF_VA001-ED-001-2573 - 6 PISTON', 'PDF', 'data/upload/other/2015/11/02', '82194', '1', '1446495687', '2');
INSERT INTO `tbl_file` VALUES ('127', 'PDF_VA001-ED-001-2573 - 7 PISTON ROD', 'PDF', 'data/upload/other/2015/11/03', '87810', '1', '1446511947', '2');
INSERT INTO `tbl_file` VALUES ('128', 'PDF_VA-ED-001-2588 7 PISTON ROD', 'PDF', 'data/upload/other/2015/11/03', '87794', '1', '1446512160', '2');
INSERT INTO `tbl_file` VALUES ('129', 'PDF_tie-in adapter plate', 'pdf', 'data/upload/other/2015/11/06', '1376910', '1', '1446836110', '2');
INSERT INTO `tbl_file` VALUES ('130', 'RFQEXC_RFQ1001MR_MastPlates_Nov6_15', 'xlsx', 'data/upload/other/2015/11/06', '52719', '1', '1446836155', '18');
INSERT INTO `tbl_file` VALUES ('131', 'PDF_8DIA_TOPPLATE', 'pdf', 'data/upload/other/2015/11/18', '28408', '1', '1447807970', '2');
INSERT INTO `tbl_file` VALUES ('132', 'PDF_8DIA_BOTTOMPLATE', 'pdf', 'data/upload/other/2015/11/18', '23746', '1', '1447808295', '2');
INSERT INTO `tbl_file` VALUES ('133', '8DIA_BOTTOMPLATE_1', 'pdf', 'data/upload/other/2015/11/18', '23746', '1', '1447808673', '2');
INSERT INTO `tbl_file` VALUES ('134', '8DIA_TOPPLATE_1', 'pdf', 'data/upload/other/2015/11/18', '28408', '1', '1447808690', '2');
INSERT INTO `tbl_file` VALUES ('135', 'PDF_1.0DIAx15.875LgSHAFT', 'pdf', 'data/upload/other/2015/11/18', '25380', '1', '1447853761', '2');
INSERT INTO `tbl_file` VALUES ('136', 'RFQEXC_RFQGFW1023_NOV17_2015', 'xlsx', 'data/upload/other/2015/11/18', '52781', '1', '1447853769', '18');
INSERT INTO `tbl_file` VALUES ('137', '1.0DIAx15.875LgSHAFT_1', 'pdf', 'data/upload/other/2015/11/18', '25380', '1', '1447854150', '2');
INSERT INTO `tbl_file` VALUES ('138', 'RFQGFW1023_NOV17_2015_1', 'xlsx', 'data/upload/other/2015/11/18', '52781', '1', '1447854162', '18');
INSERT INTO `tbl_file` VALUES ('139', '1.0DIAx15.875LgSHAFT_2', 'pdf', 'data/upload/other/2015/11/18', '25380', '1', '1447854374', '2');
INSERT INTO `tbl_file` VALUES ('140', '1.0DIAx15.875LgSHAFT_3', 'pdf', 'data/upload/other/2015/11/18', '25380', '1', '1447854598', '2');
INSERT INTO `tbl_file` VALUES ('141', 'RFQGFW1023_NOV17_2015_2', 'xlsx', 'data/upload/other/2015/11/18', '52781', '1', '1447854606', '18');
INSERT INTO `tbl_file` VALUES ('142', '1.0DIAx15.875LgSHAFT_4', 'pdf', 'data/upload/other/2015/11/18', '25380', '1', '1447854851', '2');
INSERT INTO `tbl_file` VALUES ('143', '1.0DIAx15.875LgSHAFT_5', 'pdf', 'data/upload/other/2015/11/18', '25380', '1', '1447855052', '2');
INSERT INTO `tbl_file` VALUES ('144', 'OTHER_A1885. HT 387928. 1.000 INCH DIA', 'pdf', 'data/upload/other/2015/11/20', '89015', '1', '1448016544', '0');
INSERT INTO `tbl_file` VALUES ('145', 'OTHER_A1869. HT N1B0. .2500 INCH DIA', 'pdf', 'data/upload/other/2015/11/20', '89384', '12', '1448025243', '0');
INSERT INTO `tbl_file` VALUES ('146', 'OTHER_A1850. HT CH-1118. .375 INCH DIA', 'pdf', 'data/upload/other/2015/11/20', '52463', '12', '1448026856', '0');
INSERT INTO `tbl_file` VALUES ('147', 'A1850. HT CH-1118. .375 INCH DIA_1', 'pdf', 'data/upload/other/2015/11/20', '52463', '12', '1448027799', '0');
INSERT INTO `tbl_file` VALUES ('148', 'OTHER_A1598. HT 9SB0059-G26. .625 INCH DIA', 'pdf', 'data/upload/other/2015/11/20', '773809', '12', '1448028590', '0');
INSERT INTO `tbl_file` VALUES ('149', 'OTHER_A1880. HT W0Y2. .6250 INCH DIA', 'pdf', 'data/upload/other/2015/11/20', '104784', '12', '1448028944', '0');
INSERT INTO `tbl_file` VALUES ('150', 'OTHER_A1847. HT E120244. .7500 INCH DIA', 'pdf', 'data/upload/other/2015/11/20', '69636', '12', '1448029397', '0');
INSERT INTO `tbl_file` VALUES ('151', 'OTHER_A1855. HT 35454. .750 INCH DIA', 'pdf', 'data/upload/other/2015/11/20', '42144', '12', '1448029572', '0');
INSERT INTO `tbl_file` VALUES ('152', 'OTHER_A1822. HT 3Q384. .625 INCH DIA', 'pdf', 'data/upload/other/2015/11/20', '44829', '12', '1448029817', '0');
INSERT INTO `tbl_file` VALUES ('153', 'OTHER_A1196. HT #2U288. .875 IN DIA', 'pdf', 'data/upload/other/2015/11/20', '709098', '12', '1448030049', '0');
INSERT INTO `tbl_file` VALUES ('154', 'OTHER_A1610. HT H9R9. .4375 INCH DIA', 'pdf', 'data/upload/other/2015/11/20', '492146', '12', '1448031539', '0');
INSERT INTO `tbl_file` VALUES ('155', 'PDF_UHMW_SLEEVE_4.5DIA', 'pdf', 'data/upload/other/2015/11/25', '39466', '1', '1448470091', '2');
INSERT INTO `tbl_file` VALUES ('156', 'RFQEXC_RFQ_KUR_1001_NOV24_2015', 'xlsx', 'data/upload/other/2015/11/25', '52813', '1', '1448470110', '18');
INSERT INTO `tbl_file` VALUES ('157', 'PDF_CCF11252015', 'pdf', 'data/upload/other/2015/11/26', '1324530', '1', '1448557397', '2');
INSERT INTO `tbl_file` VALUES ('158', 'CCF11252015_1', 'pdf', 'data/upload/other/2015/11/26', '1324530', '1', '1448557896', '2');
INSERT INTO `tbl_file` VALUES ('159', 'PDF_CCF11302015', 'pdf', 'data/upload/other/2015/11/30', '484689', '1', '1448908746', '2');
INSERT INTO `tbl_file` VALUES ('161', 'PDF_CCF12022015_0001 7', 'pdf', 'data/upload/other/2015/12/09', '658881', '1', '1449666282', '2');
INSERT INTO `tbl_file` VALUES ('162', 'RFQEXC_RFQ_DEC7_2015_JACKSCREW_BODY', 'xlsx', 'data/upload/other/2015/12/09', '53080', '1', '1449666296', '18');
INSERT INTO `tbl_file` VALUES ('163', 'PDF_CCF12022015_0001 4', 'pdf', 'data/upload/other/2015/12/09', '578253', '1', '1449666487', '2');
INSERT INTO `tbl_file` VALUES ('164', 'PDF_CCF12022015_0001 5', 'pdf', 'data/upload/other/2015/12/09', '771708', '1', '1449666496', '2');
INSERT INTO `tbl_file` VALUES ('165', 'PDF_CCF12022015_0001 6', 'pdf', 'data/upload/other/2015/12/09', '740200', '1', '1449666502', '2');
INSERT INTO `tbl_file` VALUES ('166', 'PDF_CCF12022015_0001 (2) 2', 'pdf', 'data/upload/other/2015/12/09', '661399', '1', '1449666899', '2');
INSERT INTO `tbl_file` VALUES ('167', 'RFQEXC_RFQ_DEC7_2015_JACKSCREW_ASSEMBLY', 'xlsx', 'data/upload/other/2015/12/09', '54260', '1', '1449667268', '18');
INSERT INTO `tbl_file` VALUES ('168', 'RFQ_DEC7_2015_JACKSCREW_ASSEMBLY_1', 'xlsx', 'data/upload/other/2015/12/09', '54260', '1', '1449667298', '18');
INSERT INTO `tbl_file` VALUES ('169', 'PDF_CCF12022015_0001 (2) 1', 'pdf', 'data/upload/other/2015/12/09', '664552', '1', '1449667470', '2');
INSERT INTO `tbl_file` VALUES ('170', 'PDF_CCF12022015_0001 (2) 3', 'pdf', 'data/upload/other/2015/12/09', '647882', '1', '1449667477', '2');
INSERT INTO `tbl_file` VALUES ('171', 'PDF_CCF12022015_0001 (2) 9', 'pdf', 'data/upload/other/2015/12/09', '739308', '1', '1449667876', '2');
INSERT INTO `tbl_file` VALUES ('172', 'RFQEXC_RFQ_DEC7_2015_JACKSCREWACMENUT', 'xlsx', 'data/upload/other/2015/12/09', '53099', '1', '1449667973', '18');
INSERT INTO `tbl_file` VALUES ('173', 'RFQEXC_RFQ_DEC7_2015_JACKSCREW_RAMSTOP', 'xlsx', 'data/upload/other/2015/12/09', '52771', '1', '1449668116', '18');
INSERT INTO `tbl_file` VALUES ('174', 'PDF_CCF12022015_0001 8', 'pdf', 'data/upload/other/2015/12/09', '667766', '1', '1449668168', '2');
INSERT INTO `tbl_file` VALUES ('175', 'RFQEXC_Quotation 1601557', 'pdf', 'data/upload/other/2015/12/09', '111578', '1', '1449668398', '18');
INSERT INTO `tbl_file` VALUES ('176', 'OTHER_B299. HT 1-11-1-1. 5.125 INCH DIA', 'pdf', 'data/upload/other/2015/12/14', '736623', '12', '1450109232', '0');
INSERT INTO `tbl_file` VALUES ('177', 'B299. HT 1-11-1-1. 5.125 INCH DIA_1', 'pdf', 'data/upload/other/2015/12/14', '736623', '12', '1450109757', '0');
INSERT INTO `tbl_file` VALUES ('178', 'B299. HT 1-11-1-1. 5.125 INCH DIA_2', 'pdf', 'data/upload/other/2015/12/14', '736623', '12', '1450110042', '0');
INSERT INTO `tbl_file` VALUES ('179', 'B299. HT 1-11-1-1. 5.125 INCH DIA_3', 'pdf', 'data/upload/other/2015/12/14', '736623', '12', '1450110214', '0');
INSERT INTO `tbl_file` VALUES ('180', 'B299. HT 1-11-1-1. 5.125 INCH DIA_4', 'pdf', 'data/upload/other/2015/12/14', '736623', '12', '1450110792', '0');
INSERT INTO `tbl_file` VALUES ('181', 'B299. HT 1-11-1-1. 5.125 INCH DIA_5', 'pdf', 'data/upload/other/2015/12/14', '736623', '12', '1450110884', '0');
INSERT INTO `tbl_file` VALUES ('182', 'OTHER_B099. HT# MA1568. 5 IN DIA', 'pdf', 'data/upload/other/2015/12/14', '131301', '12', '1450111320', '0');
INSERT INTO `tbl_file` VALUES ('183', 'B099. HT# MA1568. 5 IN DIA_1', 'pdf', 'data/upload/other/2015/12/14', '131301', '12', '1450111459', '0');
INSERT INTO `tbl_file` VALUES ('184', 'OTHER_B327. HT 1504102911. 3.250 INCH DIA', 'pdf', 'data/upload/other/2015/12/14', '80493', '12', '1450112110', '0');
INSERT INTO `tbl_file` VALUES ('185', 'OTHER_B329. HT 1504103881. 3.000 INCH DIA', 'pdf', 'data/upload/other/2015/12/14', '42595', '12', '1450112451', '0');
INSERT INTO `tbl_file` VALUES ('186', 'OTHER_B289. HT C15908 1-2-1. 4.500 INCH DIA', 'pdf', 'data/upload/other/2015/12/14', '940656', '12', '1450114465', '0');
INSERT INTO `tbl_file` VALUES ('187', 'OTHER_B191. HT#1-5-1-1. 4.50 IN DIA. TEST CERT', 'doc', 'data/upload/other/2015/12/14', '3888128', '12', '1450114672', '0');
INSERT INTO `tbl_file` VALUES ('188', 'B289. HT C15908 1-2-1. 4.500 INCH DIA_1', 'pdf', 'data/upload/other/2015/12/14', '940656', '12', '1450114775', '0');
INSERT INTO `tbl_file` VALUES ('189', 'OTHER_B175. TEST CERT', 'pdf', 'data/upload/other/2015/12/14', '368944', '12', '1450115068', '0');
INSERT INTO `tbl_file` VALUES ('190', 'OTHER_A886. HT 2JN7. 2.5 IN RD', 'pdf', 'data/upload/other/2015/12/14', '344951', '12', '1450116456', '0');
INSERT INTO `tbl_file` VALUES ('191', 'OTHER_A1444. HT# D1A7. 1.500 INCH DIA', 'pdf', 'data/upload/other/2015/12/14', '594118', '12', '1450116544', '0');
INSERT INTO `tbl_file` VALUES ('192', 'A1444. HT# D1A7. 1.500 INCH DIA_1', 'pdf', 'data/upload/other/2015/12/14', '594118', '12', '1450117225', '0');
INSERT INTO `tbl_file` VALUES ('193', 'A1444. HT# D1A7. 1.500 INCH DIA_2', 'pdf', 'data/upload/other/2015/12/14', '594118', '12', '1450117360', '0');
INSERT INTO `tbl_file` VALUES ('194', 'OTHER_A1783. HT 252354. 2.500 INCH DIA', 'pdf', 'data/upload/other/2015/12/14', '1655154', '12', '1450117446', '0');
INSERT INTO `tbl_file` VALUES ('195', 'OTHER_A1063. HT#5KC2. 2.1250 IN DIA.', 'doc', 'data/upload/other/2015/12/14', '4137984', '12', '1450117749', '0');
INSERT INTO `tbl_file` VALUES ('196', 'OTHER_A747. HT# FS-4876.  2  IN DIA', 'pdf', 'data/upload/other/2015/12/14', '271373', '12', '1450117987', '0');
INSERT INTO `tbl_file` VALUES ('197', 'OTHER_A726. HT E43324', 'pdf', 'data/upload/other/2015/12/14', '334423', '12', '1450118314', '0');
INSERT INTO `tbl_file` VALUES ('198', 'OTHER_A1557. HT H2D4. 2.500 INCH DIA', 'pdf', 'data/upload/other/2015/12/14', '573104', '12', '1450118522', '0');
INSERT INTO `tbl_file` VALUES ('199', 'OTHER_A1455. HT D2K4. 3.750 INCH DIA', 'pdf', 'data/upload/other/2015/12/14', '580452', '12', '1450118804', '0');
INSERT INTO `tbl_file` VALUES ('200', 'PDF_DMCM-TLWP-010RA  Retention Block A, Square Twist Lock-2016-01-15', 'pdf', 'data/upload/other/2016/02/12', '256936', '1', '1455294380', '2');
INSERT INTO `tbl_file` VALUES ('202', 'PDF_DMCM-TLWP-011RA  Retention Block B, Square Twist Lock-2016-01-15', 'pdf', 'data/upload/other/2016/02/12', '711053', '1', '1455295410', '2');
INSERT INTO `tbl_file` VALUES ('203', 'DMCM-TLWP-010RA  Retention Block A, Square Twist Lock-2016-01-15_2', 'pdf', 'data/upload/other/2016/02/12', '256936', '1', '1455296039', '2');
INSERT INTO `tbl_file` VALUES ('205', 'OTHER_20160211_114617', 'jpg', 'data/upload/image/2016/02/14', '4668711', '1', '1455472010', '0');
INSERT INTO `tbl_file` VALUES ('206', 'OTHER_20160211_114629', 'jpg', 'data/upload/image/2016/02/14', '4649732', '1', '1455472015', '0');
INSERT INTO `tbl_file` VALUES ('207', 'E-012002431_PartPriceList_2', 'pdf', '/data/pdf/', '7007', '1', '1455508292', '2');
INSERT INTO `tbl_file` VALUES ('208', 'PDF_CCF02292016_0004', 'pdf', 'data/upload/other/2016/03/12', '1214438', '1', '1457793886', '2');
INSERT INTO `tbl_file` VALUES ('209', 'CCF02292016_0004_1', 'pdf', 'data/upload/other/2016/03/12', '1214438', '1', '1457794190', '2');
INSERT INTO `tbl_file` VALUES ('210', 'RFQEXC_RFQSNS1011APR22_2016', 'xlsx', 'data/upload/other/2016/04/22', '52708', '1', '1461329253', '18');
INSERT INTO `tbl_file` VALUES ('211', '18InX6.875X3-12THD_PartPriceList', 'pdf', '/data/pdf/', '7086', '1', '1461329465', '18');
INSERT INTO `tbl_file` VALUES ('212', '18InX6.875X3-12THD_PartPriceList_1', 'pdf', '/data/pdf/', '7086', '1', '1461329629', '18');
INSERT INTO `tbl_file` VALUES ('213', 'PDF_R-1000-20-02-0001-V2', 'pdf', 'data/upload/other/2016/05/03', '70261', '15', '1462299053', '2');
INSERT INTO `tbl_file` VALUES ('214', 'PDF_R-1000-20-02-023', 'pdf', 'data/upload/other/2016/05/03', '79147', '15', '1462300630', '2');
INSERT INTO `tbl_file` VALUES ('215', 'PDF_R-1000-20-02-025', 'pdf', 'data/upload/other/2016/05/03', '77355', '15', '1462300859', '2');
INSERT INTO `tbl_file` VALUES ('216', 'PDF_R-1000-20-02-036', 'pdf', 'data/upload/other/2016/05/03', '82949', '15', '1462301127', '2');
INSERT INTO `tbl_file` VALUES ('217', 'PDF_R-1000-40-02-0009', 'pdf', 'data/upload/other/2016/05/03', '65319', '15', '1462301335', '2');
INSERT INTO `tbl_file` VALUES ('218', 'PDF_R-1000-60-02-0002', 'pdf', 'data/upload/other/2016/05/03', '71482', '15', '1462302251', '2');
INSERT INTO `tbl_file` VALUES ('219', 'PDF_R-1000-40-02-0019', 'pdf', 'data/upload/other/2016/05/03', '82064', '15', '1462302420', '2');
INSERT INTO `tbl_file` VALUES ('220', 'PDF_R-1000-10-02-0015', 'pdf', 'data/upload/other/2016/05/03', '77173', '15', '1462302991', '2');
INSERT INTO `tbl_file` VALUES ('221', 'PDF_R-1000-10-02-0003', 'pdf', 'data/upload/other/2016/05/03', '103906', '15', '1462303259', '2');
INSERT INTO `tbl_file` VALUES ('222', 'PDF_R-1000-10-02-0004-1 - BLANK', 'pdf', 'data/upload/other/2016/05/03', '79257', '15', '1462303555', '2');
INSERT INTO `tbl_file` VALUES ('223', 'PDF_R-1000-40-02-0005', 'pdf', 'data/upload/other/2016/05/03', '76237', '15', '1462303809', '2');
INSERT INTO `tbl_file` VALUES ('224', 'PDF_R-1000-10-02-0010', 'pdf', 'data/upload/other/2016/05/03', '76621', '15', '1462303994', '2');
INSERT INTO `tbl_file` VALUES ('225', 'PDF_R-1000-40-02-0002', 'pdf', 'data/upload/other/2016/05/03', '72316', '15', '1462304135', '2');
INSERT INTO `tbl_file` VALUES ('226', 'PDF_R-1000-10-02-0003 - BLANK', 'pdf', 'data/upload/other/2016/05/04', '87943', '15', '1462366805', '2');
INSERT INTO `tbl_file` VALUES ('227', 'PDF_R-1000-20-02-006', 'pdf', 'data/upload/other/2016/05/04', '120595', '15', '1462367374', '2');
INSERT INTO `tbl_file` VALUES ('228', 'PDF_R-1000-20-02-003', 'pdf', 'data/upload/other/2016/05/04', '120183', '15', '1462368264', '2');
INSERT INTO `tbl_file` VALUES ('229', 'PDF_R-1000-20-02-028', 'pdf', 'data/upload/other/2016/05/04', '89786', '15', '1462368561', '2');
INSERT INTO `tbl_file` VALUES ('230', 'PDF_R-1000-20-02-022', 'pdf', 'data/upload/other/2016/05/04', '89174', '15', '1462368845', '2');
INSERT INTO `tbl_file` VALUES ('231', 'R-1000-10-02-0010_PartPriceList', 'pdf', '/data/pdf/', '6945', '1', '1462441580', '18');
INSERT INTO `tbl_file` VALUES ('232', 'R-1000-40-02-0002_PartPriceList', 'pdf', '/data/pdf/', '7015', '1', '1462441900', '18');
INSERT INTO `tbl_file` VALUES ('233', 'R-000-10-02-0014_PartPriceList', 'pdf', '/data/pdf/', '6926', '1', '1462443122', '18');
INSERT INTO `tbl_file` VALUES ('234', 'R-1000-10-02-0015_PartPriceList', 'pdf', '/data/pdf/', '6932', '1', '1462443301', '18');
INSERT INTO `tbl_file` VALUES ('235', 'RFQEXC_RFQ_May3_2016_1InAluminum_parts', 'xlsx', 'data/upload/other/2016/05/05', '53362', '1', '1462453827', '18');
INSERT INTO `tbl_file` VALUES ('236', 'R-1000-10-02-0015_PartPriceList_1', 'pdf', '/data/pdf/', '6962', '1', '1462454511', '18');
INSERT INTO `tbl_file` VALUES ('237', 'R-000-10-02-0014_PartPriceList_1', 'pdf', '/data/pdf/', '6966', '1', '1462454668', '18');
INSERT INTO `tbl_file` VALUES ('239', 'PDF_R-1000-20-02-033', 'pdf', 'data/upload/other/2016/05/05', '70923', '15', '1462471623', '2');
INSERT INTO `tbl_file` VALUES ('240', 'R-1000-10-02-0006_PartPriceList', 'pdf', '/data/pdf/', '7049', '1', '1462626431', '18');
INSERT INTO `tbl_file` VALUES ('241', 'R-1000-10-02-0013_PartPriceList', 'pdf', '/data/pdf/', '7046', '1', '1462626552', '18');
INSERT INTO `tbl_file` VALUES ('242', 'R-1000-40-02-0002_PartPriceList_1', 'pdf', '/data/pdf/', '7009', '1', '1462627988', '18');
INSERT INTO `tbl_file` VALUES ('243', 'R-1000-10-02-0010_PartPriceList_1', 'pdf', '/data/pdf/', '7013', '1', '1462628378', '18');
INSERT INTO `tbl_file` VALUES ('244', 'R-1000-10-02-0015_PartPriceList_2', 'pdf', '/data/pdf/', '7013', '1', '1462628693', '18');
INSERT INTO `tbl_file` VALUES ('245', 'R-000-10-02-0014_PartPriceList_2', 'pdf', '/data/pdf/', '7016', '1', '1462630070', '18');
INSERT INTO `tbl_file` VALUES ('246', 'RFQEXC_RFQMay3_2016_Gears', 'xlsx', 'data/upload/other/2016/05/14', '52870', '1', '1463244299', '18');
INSERT INTO `tbl_file` VALUES ('247', 'REY4.25ELC_PartPriceList', 'pdf', '/data/pdf/', '7026', '1', '1469466575', '18');
INSERT INTO `tbl_file` VALUES ('248', '4068R1_PartPriceList', 'pdf', '/data/pdf/', '7377', '1', '1472745936', '18');

-- ----------------------------
-- Table structure for tbl_file_category
-- ----------------------------
DROP TABLE IF EXISTS `tbl_file_category`;
CREATE TABLE `tbl_file_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `code` varchar(32) NOT NULL,
  `created_time` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=armscii8;

-- ----------------------------
-- Records of tbl_file_category
-- ----------------------------
INSERT INTO `tbl_file_category` VALUES ('1', 'DWG File', '1', 'DWG', '1');
INSERT INTO `tbl_file_category` VALUES ('2', 'Cad PDF', '1', 'PDF', '0');
INSERT INTO `tbl_file_category` VALUES ('3', 'Mill Certificate', '1', 'CERT', '1');
INSERT INTO `tbl_file_category` VALUES ('4', 'Purchase order', '1', 'PO', '1428336324');
INSERT INTO `tbl_file_category` VALUES ('5', 'Invoice', '1', 'Inv', '1428336336');
INSERT INTO `tbl_file_category` VALUES ('6', 'COC', '1', 'COC', '1428336337');
INSERT INTO `tbl_file_category` VALUES ('7', 'BLUEPRINT', '1', 'BP', '1428355256');
INSERT INTO `tbl_file_category` VALUES ('8', 'Material Code data sheet', '1', 'MCDS', '1428355342');
INSERT INTO `tbl_file_category` VALUES ('9', 'SCAR', '1', 'SCAR', '1428355351');
INSERT INTO `tbl_file_category` VALUES ('10', 'Setup Sheets', '1', 'SHEET', '1429549216');
INSERT INTO `tbl_file_category` VALUES ('11', 'Tooling', '1', 'TOOL', '1429549230');
INSERT INTO `tbl_file_category` VALUES ('12', 'Maintenance', '1', 'MTN', '1430879265');
INSERT INTO `tbl_file_category` VALUES ('13', 'Quality-Control', '1', 'QC', '1430879277');
INSERT INTO `tbl_file_category` VALUES ('14', 'Healthy & Safety', '1', 'HAS', '1430879316');
INSERT INTO `tbl_file_category` VALUES ('15', 'Procedure', '1', 'PCD', '1430879335');
INSERT INTO `tbl_file_category` VALUES ('16', 'Client', '1', 'CLIENT', '1430879354');
INSERT INTO `tbl_file_category` VALUES ('17', 'Certificate', '1', 'CERT', '1430879416');
INSERT INTO `tbl_file_category` VALUES ('18', 'RFQ', '1', 'RFQEXC', '1442329300');

-- ----------------------------
-- Table structure for tbl_history
-- ----------------------------
DROP TABLE IF EXISTS `tbl_history`;
CREATE TABLE `tbl_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `object_id` int(11) NOT NULL,
  `class` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_time` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=331 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of tbl_history
-- ----------------------------
INSERT INTO `tbl_history` VALUES ('9', '9', 'Part', '{\"part_code\":{\"name\":\"Part Code\",\"old\":\"111123 Nam 1234\",\"new\":\"111123 Please\"},\"arr_machine_ids\":{\"name\":\"Arr Machine Ids\",\"old\":[\"2\"],\"new\":[\"2\",\"3\"]}}', '', '1429531129', '1');
INSERT INTO `tbl_history` VALUES ('10', '9', 'Part', '{\"description\":{\"name\":\"Description\",\"old\":\"111\",\"new\":\"Description\"},\"design\":{\"name\":\"Design\",\"old\":\"111\",\"new\":\"Designation\"},\"arr_machine_ids\":{\"name\":\"Related machines\",\"old\":[\"2\",\"3\"],\"new\":[\"2\",\"3\",\"4\"]}}', '', '1429546769', '1');
INSERT INTO `tbl_history` VALUES ('11', '9', 'Material', '{\"shape_id\":{\"name\":\"Shape\",\"old\":\"6\",\"new\":\"1\"},\"am_designation\":{\"name\":\"Am Designation\",\"old\":\"\",\"new\":\"General\"},\"heat_number\":{\"name\":\"Heat Number\",\"old\":\"\",\"new\":\"ABDE23\"},\"sizes\":{\"name\":\"Sizes\",\"old\":\"\",\"new\":\"{\\\"od\\\":\\\"23\\\",\\\"id\\\":\\\"144\\\"}\"},\"stock_in_hand\":{\"name\":\"Stock In Hand\",\"old\":\"0\",\"new\":\"2999\"}}', '', '1429674117', '1');
INSERT INTO `tbl_history` VALUES ('12', '7', 'Material', '{\"shape_id\":{\"name\":\"Shape\",\"old\":\"1\",\"new\":\"4\"},\"am_designation\":{\"name\":\"Am Designation\",\"old\":\"\",\"new\":\"Brass\"},\"upload_file_id\":{\"name\":\"Upload File Id\",\"old\":\"0\",\"new\":\"89\"},\"sizes\":{\"name\":\"Sizes\",\"old\":\"\",\"new\":\"{\\\"od\\\":\\\"\\\",\\\"id\\\":\\\"\\\"}\"}}', '', '1429674183', '1');
INSERT INTO `tbl_history` VALUES ('13', '9', 'Material', '{\"designation_id\":{\"name\":\"Designation Id\",\"old\":\"\",\"new\":\"C9\"}}', '', '1429674522', '1');
INSERT INTO `tbl_history` VALUES ('14', '9', 'Material', '{\"shape_id\":{\"name\":\"Shape\",\"old\":\"1\",\"new\":\"4\"},\"sizes\":{\"name\":\"Sizes\",\"old\":\"{\\\"od\\\":\\\"23\\\",\\\"id\\\":\\\"144\\\"}\",\"new\":\"{\\\"od\\\":\\\"11\\\",\\\"id\\\":\\\"123\\\"}\"}}', '', '1429674536', '1');
INSERT INTO `tbl_history` VALUES ('15', '3', 'Material', '{\"am_designation\":{\"name\":\"Am Designation\",\"old\":\"\",\"new\":\"General\"},\"sizes\":{\"name\":\"Sizes\",\"old\":\"\",\"new\":\"null\"}}', '', '1429685530', '1');
INSERT INTO `tbl_history` VALUES ('16', '9', 'Material', '{\"am_designation\":{\"name\":\"Am Designation\",\"old\":\"General\",\"new\":\"Brass\"}}', '', '1429685709', '1');
INSERT INTO `tbl_history` VALUES ('17', '9', 'Material', '{\"stock_in_hand\":{\"name\":\"Stock In Hand\",\"old\":\"2999\",\"new\":3099}}', '', '1429685887', '1');
INSERT INTO `tbl_history` VALUES ('18', '9', 'Material', '{\"stock_in_hand\":{\"name\":\"Stock In Hand\",\"old\":\"3099\",\"new\":3084}}', '', '1429685894', '1');
INSERT INTO `tbl_history` VALUES ('19', '1', 'Part', '{\"inventory_on_hand\":{\"name\":\"Inventory On Hand\",\"old\":\"2133\",\"new\":2033}}', '', '1430035185', '1');
INSERT INTO `tbl_history` VALUES ('20', '9', 'Material', '{\"quantity\":{\"name\":\"Quantity\",\"old\":\"0\",\"new\":12},\"stock_in_hand\":{\"name\":\"Stock In Hand\",\"old\":\"3084\",\"new\":3360}}', '', '1430202165', '1');
INSERT INTO `tbl_history` VALUES ('21', '10', 'Material', '{\"designation_id\":{\"name\":\"Designation Id\",\"old\":\"\",\"new\":\"C10\"}}', '', '1430388410', '1');
INSERT INTO `tbl_history` VALUES ('22', '9', 'Material', '{\"quantity\":{\"name\":\"Quantity\",\"old\":\"12\",\"new\":22},\"stock_in_hand\":{\"name\":\"Stock In Hand\",\"old\":\"3360\",\"new\":3480}}', '', '1430445493', '0');
INSERT INTO `tbl_history` VALUES ('23', '9', 'Material', '{\"optimum_inventory\":{\"name\":\"Optimum Inventory\",\"old\":\"0\",\"new\":\"200\"}}', '', '1430465808', '0');
INSERT INTO `tbl_history` VALUES ('24', '12', 'Part', '{\"arr_machine_ids\":{\"name\":\"Related machines\",\"old\":[],\"new\":[\"6\"]}}', '', '1430877140', '1');
INSERT INTO `tbl_history` VALUES ('25', '9', 'Material', '{\"quantity\":{\"name\":\"Quantity\",\"old\":\"22\",\"new\":10},\"stock_in_hand\":{\"name\":\"Stock In Hand\",\"old\":\"3480\",\"new\":3360}}', '', '1430878352', '1');
INSERT INTO `tbl_history` VALUES ('26', '12', 'Part', '{\"inventory_on_hand\":{\"name\":\"Inventory On Hand\",\"old\":\"120\",\"new\":95}}', '', '1431314026', '1');
INSERT INTO `tbl_history` VALUES ('27', '13', 'Part', '{\"arr_machine_ids\":{\"name\":\"Related machines\",\"old\":[],\"new\":[\"2\",\"4\"]}}', '', '1431922776', '0');
INSERT INTO `tbl_history` VALUES ('28', '13', 'Part', '{\"inventory_on_hand\":{\"name\":\"Inventory On Hand\",\"old\":\"21300\",\"new\":21200}}', '', '1432179967', '1');
INSERT INTO `tbl_history` VALUES ('29', '19', 'Part', '{\"inventory_on_hand\":{\"name\":\"Inventory On Hand\",\"old\":\"50\",\"new\":35}}', '', '1433176082', '1');
INSERT INTO `tbl_history` VALUES ('30', '9', 'Material', '{\"quantity\":{\"name\":\"Quantity\",\"old\":\"10\",\"new\":0},\"stock_in_hand\":{\"name\":\"Stock In Hand\",\"old\":\"3360\",\"new\":3310}}', '', '1435052397', '1');
INSERT INTO `tbl_history` VALUES ('31', '10', 'Material', '{\"stock_in_hand\":{\"name\":\"Stock In Hand\",\"old\":\"0\",\"new\":500}}', '', '1436345645', '1');
INSERT INTO `tbl_history` VALUES ('32', '10', 'Material', '{\"stock_in_hand\":{\"name\":\"Stock In Hand\",\"old\":\"500\",\"new\":1000}}', '', '1436345766', '1');
INSERT INTO `tbl_history` VALUES ('33', '10', 'Material', '{\"stock_in_hand\":{\"name\":\"Stock In Hand\",\"old\":\"1000\",\"new\":3200}}', '', '1436346231', '1');
INSERT INTO `tbl_history` VALUES ('34', '10', 'Material', '{\"stock_in_hand\":{\"name\":\"Stock In Hand\",\"old\":\"3200\",\"new\":3400}}', '', '1436346560', '1');
INSERT INTO `tbl_history` VALUES ('35', '10', 'Material', '{\"stock_in_hand\":{\"name\":\"Stock In Hand\",\"old\":\"3400\",\"new\":4020}}', '', '1436346843', '1');
INSERT INTO `tbl_history` VALUES ('36', '10', 'Material', '{\"stock_in_hand\":{\"name\":\"Stock In Hand\",\"old\":\"4020\",\"new\":4130}}', '', '1436347018', '1');
INSERT INTO `tbl_history` VALUES ('37', '10', 'Material', '{\"stock_in_hand\":{\"name\":\"Stock In Hand\",\"old\":\"4130\",\"new\":2230}}', '', '1436359950', '1');
INSERT INTO `tbl_history` VALUES ('38', '10', 'Material', '{\"stock_in_hand\":{\"name\":\"Stock In Hand\",\"old\":\"2230\",\"new\":3830}}', '', '1437551291', '1');
INSERT INTO `tbl_history` VALUES ('39', '10', 'Material', '{\"quantity\":{\"name\":\"Quantity\",\"old\":\"0\",\"new\":114},\"stock_in_hand\":{\"name\":\"Stock In Hand\",\"old\":\"3830\",\"new\":3852}}', '', '1438138292', '1');
INSERT INTO `tbl_history` VALUES ('40', '10', 'Material', '{\"quantity\":{\"name\":\"Quantity\",\"old\":\"114\",\"new\":116},\"stock_in_hand\":{\"name\":\"Stock In Hand\",\"old\":\"3852\",\"new\":3872}}', '', '1438138813', '1');
INSERT INTO `tbl_history` VALUES ('41', '10', 'Material', '{\"quantity\":{\"name\":\"Quantity\",\"old\":\"116\",\"new\":118},\"stock_in_hand\":{\"name\":\"Stock In Hand\",\"old\":\"3872\",\"new\":4145}}', '', '1438138958', '1');
INSERT INTO `tbl_history` VALUES ('42', '10', 'Material', '{\"quantity\":{\"name\":\"Quantity\",\"old\":\"118\",\"new\":139},\"stock_in_hand\":{\"name\":\"Stock In Hand\",\"old\":\"4145\",\"new\":4244.4}}', '', '1438314944', '1');
INSERT INTO `tbl_history` VALUES ('43', '10', 'Material', '{\"quantity\":{\"name\":\"Quantity\",\"old\":\"139\",\"new\":147},\"stock_in_hand\":{\"name\":\"Stock In Hand\",\"old\":\"4244.4\",\"new\":4108.4}}', '', '1438315268', '1');
INSERT INTO `tbl_history` VALUES ('44', '10', 'Material', '{\"stock_in_hand\":{\"name\":\"Stock In Hand\",\"old\":\"4108.4\",\"new\":4070.8}}', '', '1438315282', '1');
INSERT INTO `tbl_history` VALUES ('45', '10', 'Material', '{\"quantity\":{\"name\":\"Quantity\",\"old\":\"147\",\"new\":144}}', '', '1438315704', '1');
INSERT INTO `tbl_history` VALUES ('46', '10', 'Material', '{\"stock_in_hand\":{\"name\":\"Stock In Hand\",\"old\":\"4070.8\",\"new\":4084}}', '', '1438316057', '1');
INSERT INTO `tbl_history` VALUES ('47', '10', 'Material', '{\"quantity\":{\"name\":\"Quantity\",\"old\":\"144\",\"new\":155},\"stock_in_hand\":{\"name\":\"Stock In Hand\",\"old\":\"4084\",\"new\":4106.1}}', '', '1438317172', '1');
INSERT INTO `tbl_history` VALUES ('48', '10', 'Material', '{\"stock_in_hand\":{\"name\":\"Stock In Hand\",\"old\":\"4106.1\",\"new\":4108.3}}', '', '1438317332', '1');
INSERT INTO `tbl_history` VALUES ('49', '10', 'Material', '{\"quantity\":{\"name\":\"Quantity\",\"old\":\"155\",\"new\":157},\"stock_in_hand\":{\"name\":\"Stock In Hand\",\"old\":\"4108.3\",\"new\":4229.2}}', '', '1438482604', '1');
INSERT INTO `tbl_history` VALUES ('50', '10', 'Material', '{\"quantity\":{\"name\":\"Quantity\",\"old\":\"157\",\"new\":169},\"stock_in_hand\":{\"name\":\"Stock In Hand\",\"old\":\"4229.2\",\"new\":4167.4}}', '', '1438482688', '1');
INSERT INTO `tbl_history` VALUES ('51', '19', 'Part', '{\"inventory_on_hand\":{\"name\":\"Inventory On Hand\",\"old\":\"35\",\"new\":20}}', '', '1439378801', '1');
INSERT INTO `tbl_history` VALUES ('52', '19', 'Part', '{\"inventory_on_hand\":{\"name\":\"Inventory On Hand\",\"old\":\"20\",\"new\":5}}', '', '1439378904', '1');
INSERT INTO `tbl_history` VALUES ('53', '13', 'Part', '{\"inventory_on_hand\":{\"name\":\"Inventory On Hand\",\"old\":\"21200\",\"new\":21100}}', '', '1439379013', '1');
INSERT INTO `tbl_history` VALUES ('54', '8', 'Material', '{\"shape_id\":{\"name\":\"Shape\",\"old\":\"1\",\"new\":\"4\"},\"am_designation\":{\"name\":\"Am Designation\",\"old\":\"\",\"new\":\"General\"},\"sizes\":{\"name\":\"Sizes\",\"old\":\"\",\"new\":\"{\\\"od\\\":\\\".625\\\",\\\"id\\\":\\\"\\\"}\"}}', '', '1439596219', '1');
INSERT INTO `tbl_history` VALUES ('55', '10', 'Material', '{\"uol_id\":{\"name\":\"Uol Id\",\"old\":\"1\",\"new\":\"2\"},\"quantity\":{\"name\":\"Quantity\",\"old\":\"169\",\"new\":163}}', '', '1439643097', '1');
INSERT INTO `tbl_history` VALUES ('56', '10', 'Material', '{\"uol_id\":{\"name\":\"Uol Id\",\"old\":\"2\",\"new\":\"1\"}}', '', '1439643112', '1');
INSERT INTO `tbl_history` VALUES ('57', '21', 'Part', '{\"arr_location_ids\":{\"name\":\"Arr Location Ids\",\"old\":[],\"new\":[\"1\"]}}', '', '1439649791', '1');
INSERT INTO `tbl_history` VALUES ('58', '15', 'Material', '{\"designation_id\":{\"name\":\"Designation Id\",\"old\":\"\",\"new\":\"C15\"},\"stock_in_hand\":{\"name\":\"Stock In Hand\",\"old\":\"0\",\"new\":235}}', '', '1442327905', '1');
INSERT INTO `tbl_history` VALUES ('59', '26', 'Part', '{\"material_id\":{\"name\":\"Material\",\"old\":\"13\",\"new\":\"15\"}}', '', '1442328345', '1');
INSERT INTO `tbl_history` VALUES ('60', '26', 'Part', '{\"tmp_file_ids\":{\"name\":\"Uploaded file\",\"old\":\"\",\"new\":\"106,107\"}}', '', '1442328892', '1');
INSERT INTO `tbl_history` VALUES ('61', '30', 'Part', '{\"tmp_file_ids\":{\"name\":\"Uploaded file\",\"old\":\"\",\"new\":\"114,115\"}}', '', '1442411996', '1');
INSERT INTO `tbl_history` VALUES ('62', '7', 'PurchaseOrder', '[]', 'Order updated', '1444649150', '1');
INSERT INTO `tbl_history` VALUES ('63', '7', 'PurchaseOrder', '[]', 'Order updated', '1444649162', '1');
INSERT INTO `tbl_history` VALUES ('64', '8', 'PurchaseOrder', '[]', 'Order created', '1444692856', '1');
INSERT INTO `tbl_history` VALUES ('65', '8', 'PurchaseOrder', '[]', 'Order updated', '1444693002', '1');
INSERT INTO `tbl_history` VALUES ('66', '8', 'PurchaseOrder', '[]', 'Order updated', '1444745209', '1');
INSERT INTO `tbl_history` VALUES ('67', '8', 'PurchaseOrder', '[]', 'Order updated', '1444745242', '1');
INSERT INTO `tbl_history` VALUES ('68', '33', 'Part', '{\"tmp_file_ids\":{\"name\":\"Uploaded file\",\"old\":\"\",\"new\":\"122\"}}', '', '1445039834', '1');
INSERT INTO `tbl_history` VALUES ('69', '35', 'Part', '{\"arr_location_ids\":{\"name\":\"Arr Location Ids\",\"old\":[],\"new\":[\"2\",\"3\"]}}', '', '1445083529', '1');
INSERT INTO `tbl_history` VALUES ('70', '14', 'Material', '{\"designation_id\":{\"name\":\"Designation Id\",\"old\":\"\",\"new\":\"B14\"}}', '', '1445241020', '1');
INSERT INTO `tbl_history` VALUES ('71', '36', 'Part', '{\"arr_location_ids\":{\"name\":\"Arr Location Ids\",\"old\":[],\"new\":[\"1\",\"2\"]}}', '', '1445684539', '1');
INSERT INTO `tbl_history` VALUES ('72', '8', 'Material', '{\"material_code_id\":{\"name\":\"Material Code Id\",\"old\":\"0\",\"new\":\"1\"},\"shape_id\":{\"name\":\"Shape\",\"old\":\"4\",\"new\":\"2\"},\"designation_id\":{\"name\":\"Designation Id\",\"old\":\"\",\"new\":\"C8\"},\"material_code\":{\"name\":\"Material Code\",\"old\":\"Material_2\",\"new\":\"Material Code 132\"},\"sizes\":{\"name\":\"Sizes\",\"old\":\"{\\\"od\\\":\\\".625\\\"}\",\"new\":\"{\\\"w\\\":\\\"32\\\",\\\"h\\\":\\\"312\\\"}\"},\"optimum_inventory\":{\"name\":\"Optimum Inventory\",\"old\":\"0\",\"new\":\"1000\"}}', '', '1445765241', '1');
INSERT INTO `tbl_history` VALUES ('73', '19', 'Part', '{\"drawing\":{\"name\":\"Drawing\",\"old\":\"\",\"new\":\"333\"},\"arr_location_ids\":{\"name\":\"Arr Location Ids\",\"old\":[],\"new\":[\"1\"]}}', '', '1445948714', '1');
INSERT INTO `tbl_history` VALUES ('74', '6', 'Part', '{\"drawing\":{\"name\":\"Drawing\",\"old\":\"\",\"new\":\"303401X171-010\"},\"arr_location_ids\":{\"name\":\"Arr Location Ids\",\"old\":[],\"new\":[\"2\",\"3\"]}}', '', '1445949285', '1');
INSERT INTO `tbl_history` VALUES ('75', '6', 'Part', '{\"arr_location_ids\":{\"name\":\"Arr Location Ids\",\"old\":[\"2\",\"3\"],\"new\":[\"2\"]}}', '', '1445949657', '1');
INSERT INTO `tbl_history` VALUES ('76', '8', 'PurchaseOrder', '[]', 'Order updated', '1446491043', '1');
INSERT INTO `tbl_history` VALUES ('77', '25', 'Part', '{\"part_length\":{\"name\":\"Part Length\",\"old\":\"4\",\"new\":\"4.25\"}}', '', '1446495447', '1');
INSERT INTO `tbl_history` VALUES ('78', '25', 'Part', '{\"client_id\":{\"name\":\"Client Id\",\"old\":\"0\",\"new\":\"5\"},\"tmp_file_ids\":{\"name\":\"Uploaded file\",\"old\":\"\",\"new\":\"125,126\"}}', '', '1446495691', '1');
INSERT INTO `tbl_history` VALUES ('79', '37', 'Part', '{\"tmp_file_ids\":{\"name\":\"Uploaded file\",\"old\":\"\",\"new\":\"127\"}}', '', '1446511953', '1');
INSERT INTO `tbl_history` VALUES ('80', '9', 'PurchaseOrder', '[]', 'Order created', '1446512812', '1');
INSERT INTO `tbl_history` VALUES ('81', '10', 'PurchaseOrder', '[]', 'Order created', '1446512822', '1');
INSERT INTO `tbl_history` VALUES ('82', '9', 'PurchaseOrder', '[]', 'Order updated', '1446513056', '1');
INSERT INTO `tbl_history` VALUES ('83', '9', 'PurchaseOrder', '[]', 'Order updated', '1446513081', '1');
INSERT INTO `tbl_history` VALUES ('84', '9', 'PurchaseOrder', '[]', 'Order updated', '1446550099', '1');
INSERT INTO `tbl_history` VALUES ('85', '24', 'Material', '{\"designation_id\":{\"name\":\"Designation Id\",\"old\":\"\",\"new\":\"C24\"}}', '', '1446634220', '1');
INSERT INTO `tbl_history` VALUES ('86', '39', 'Part', '{\"tmp_file_ids\":{\"name\":\"Uploaded file\",\"old\":\"129\",\"new\":\"129,130\"}}', '', '1446836176', '1');
INSERT INTO `tbl_history` VALUES ('87', '11', 'PurchaseOrder', '[]', 'Order created', '1446836288', '1');
INSERT INTO `tbl_history` VALUES ('88', '12', 'PurchaseOrder', '[]', 'Order created', '1446836340', '1');
INSERT INTO `tbl_history` VALUES ('89', '12', 'PurchaseOrder', '[]', 'Order updated', '1446836369', '1');
INSERT INTO `tbl_history` VALUES ('90', '12', 'PurchaseOrder', '[]', 'Order updated', '1446836388', '1');
INSERT INTO `tbl_history` VALUES ('91', '12', 'PurchaseOrder', '[]', 'Order updated', '1446836412', '1');
INSERT INTO `tbl_history` VALUES ('92', '11', 'PurchaseOrder', '[]', 'Order updated', '1446994150', '1');
INSERT INTO `tbl_history` VALUES ('93', '11', 'PurchaseOrder', '[]', 'Order updated', '1446994269', '1');
INSERT INTO `tbl_history` VALUES ('94', '11', 'PurchaseOrder', '[]', 'Order updated', '1446994407', '1');
INSERT INTO `tbl_history` VALUES ('95', '11', 'PurchaseOrder', '[]', 'Order updated', '1446994444', '1');
INSERT INTO `tbl_history` VALUES ('96', '11', 'PurchaseOrder', '[]', 'Order updated', '1446995617', '1');
INSERT INTO `tbl_history` VALUES ('97', '13', 'PurchaseOrder', '[]', 'Order created', '1447808696', '1');
INSERT INTO `tbl_history` VALUES ('98', '13', 'PurchaseOrder', '[]', 'Order updated', '1447808770', '1');
INSERT INTO `tbl_history` VALUES ('99', '13', 'PurchaseOrder', '[]', 'Order updated', '1447855151', '1');
INSERT INTO `tbl_history` VALUES ('100', '14', 'PurchaseOrder', '[]', 'Order created', '1447855486', '1');
INSERT INTO `tbl_history` VALUES ('101', '14', 'PurchaseOrder', '[]', 'Order updated', '1447864962', '1');
INSERT INTO `tbl_history` VALUES ('102', '14', 'PurchaseOrder', '[]', 'Order updated', '1448016071', '1');
INSERT INTO `tbl_history` VALUES ('103', '35', 'Material', '{\"designation_id\":{\"name\":\"Designation Id\",\"old\":\"\",\"new\":\"C35\"}}', '', '1448016462', '1');
INSERT INTO `tbl_history` VALUES ('104', '37', 'Material', '{\"designation_id\":{\"name\":\"Designation Id\",\"old\":\"\",\"new\":\"A37\"},\"quantity\":{\"name\":\"Quantity\",\"old\":\"0\",\"new\":2}}', '', '1448028040', '12');
INSERT INTO `tbl_history` VALUES ('105', '39', 'Material', '{\"designation_id\":{\"name\":\"Designation Id\",\"old\":\"\",\"new\":\"A39\"},\"quantity\":{\"name\":\"Quantity\",\"old\":\"0\",\"new\":6}}', '', '1448029001', '12');
INSERT INTO `tbl_history` VALUES ('106', '40', 'Material', '{\"designation_id\":{\"name\":\"Designation Id\",\"old\":\"\",\"new\":\"A40\"},\"quantity\":{\"name\":\"Quantity\",\"old\":\"0\",\"new\":1}}', '', '1448029468', '12');
INSERT INTO `tbl_history` VALUES ('107', '14', 'PurchaseOrder', '[]', 'Order updated', '1448285412', '1');
INSERT INTO `tbl_history` VALUES ('108', '14', 'PurchaseOrder', '[]', 'Order updated', '1448285648', '1');
INSERT INTO `tbl_history` VALUES ('109', '48', 'Part', '{\"tmp_file_ids\":{\"name\":\"Uploaded file\",\"old\":\"\",\"new\":\"155,156\"}}', '', '1448470228', '1');
INSERT INTO `tbl_history` VALUES ('110', '15', 'PurchaseOrder', '[]', 'Order created', '1448470385', '1');
INSERT INTO `tbl_history` VALUES ('111', '15', 'PurchaseOrder', '[]', 'Order updated', '1448470439', '1');
INSERT INTO `tbl_history` VALUES ('112', '16', 'PurchaseOrder', '[]', 'Order created', '1448486437', '1');
INSERT INTO `tbl_history` VALUES ('113', '16', 'PurchaseOrder', '[]', 'Order updated', '1448486627', '1');
INSERT INTO `tbl_history` VALUES ('114', '16', 'PurchaseOrder', '[]', 'Order updated', '1448486650', '1');
INSERT INTO `tbl_history` VALUES ('115', '16', 'PurchaseOrder', '[]', 'Order updated', '1448486991', '1');
INSERT INTO `tbl_history` VALUES ('116', '16', 'PurchaseOrder', '[]', 'Order updated', '1448487100', '1');
INSERT INTO `tbl_history` VALUES ('117', '16', 'PurchaseOrder', '[]', 'Order updated', '1448487259', '1');
INSERT INTO `tbl_history` VALUES ('118', '16', 'PurchaseOrder', '[]', 'Order updated', '1448487343', '1');
INSERT INTO `tbl_history` VALUES ('119', '17', 'PurchaseOrder', '[]', 'Order created', '1448487898', '1');
INSERT INTO `tbl_history` VALUES ('120', '17', 'PurchaseOrder', '[]', 'Order updated', '1448487968', '1');
INSERT INTO `tbl_history` VALUES ('121', '17', 'PurchaseOrder', '[]', 'Order updated', '1448488003', '1');
INSERT INTO `tbl_history` VALUES ('122', '17', 'PurchaseOrder', '[]', 'Order updated', '1448488271', '1');
INSERT INTO `tbl_history` VALUES ('123', '17', 'PurchaseOrder', '[]', 'Order updated', '1448488290', '1');
INSERT INTO `tbl_history` VALUES ('124', '18', 'PurchaseOrder', '[]', 'Order created', '1448559170', '1');
INSERT INTO `tbl_history` VALUES ('125', '18', 'PurchaseOrder', '[]', 'Order updated', '1448559206', '1');
INSERT INTO `tbl_history` VALUES ('126', '4', 'PurchaseOrder', '[]', 'Order updated', '1448606469', '1');
INSERT INTO `tbl_history` VALUES ('127', '18', 'PurchaseOrder', '[]', 'Order updated', '1448893159', '1');
INSERT INTO `tbl_history` VALUES ('128', '18', 'PurchaseOrder', '[]', 'Order updated', '1448893234', '1');
INSERT INTO `tbl_history` VALUES ('129', '18', 'PurchaseOrder', '[]', 'Order updated', '1448893253', '1');
INSERT INTO `tbl_history` VALUES ('130', '18', 'PurchaseOrder', '[]', 'Order updated', '1448893539', '1');
INSERT INTO `tbl_history` VALUES ('131', '18', 'PurchaseOrder', '[]', 'Order updated', '1448893557', '1');
INSERT INTO `tbl_history` VALUES ('132', '18', 'PurchaseOrder', '[]', 'Order updated', '1448896919', '1');
INSERT INTO `tbl_history` VALUES ('133', '18', 'PurchaseOrder', '[]', 'Order updated', '1448907991', '1');
INSERT INTO `tbl_history` VALUES ('134', '53', 'Part', '{\"tmp_file_ids\":{\"name\":\"Uploaded file\",\"old\":\"\",\"new\":\"159\"}}', '', '1448908751', '1');
INSERT INTO `tbl_history` VALUES ('135', '18', 'PurchaseOrder', '[]', 'Order updated', '1448908857', '1');
INSERT INTO `tbl_history` VALUES ('136', '18', 'PurchaseOrder', '[]', 'Order updated', '1448908876', '1');
INSERT INTO `tbl_history` VALUES ('137', '18', 'PurchaseOrder', '[]', 'Order updated', '1448908950', '1');
INSERT INTO `tbl_history` VALUES ('138', '18', 'PurchaseOrder', '[]', 'Order updated', '1448908957', '1');
INSERT INTO `tbl_history` VALUES ('139', '18', 'PurchaseOrder', '[]', 'Order updated', '1448909003', '1');
INSERT INTO `tbl_history` VALUES ('140', '18', 'PurchaseOrder', '[]', 'Order updated', '1448909018', '1');
INSERT INTO `tbl_history` VALUES ('141', '18', 'PurchaseOrder', '[]', 'Order updated', '1448909027', '1');
INSERT INTO `tbl_history` VALUES ('142', '18', 'PurchaseOrder', '[]', 'Order updated', '1448909089', '1');
INSERT INTO `tbl_history` VALUES ('143', '18', 'PurchaseOrder', '[]', 'Order updated', '1448909119', '1');
INSERT INTO `tbl_history` VALUES ('144', '19', 'PurchaseOrder', '[]', 'Order created', '1448909774', '1');
INSERT INTO `tbl_history` VALUES ('145', '18', 'PurchaseOrder', '[]', 'Order updated', '1448969383', '1');
INSERT INTO `tbl_history` VALUES ('146', '18', 'PurchaseOrder', '[]', 'Order updated', '1449154713', '1');
INSERT INTO `tbl_history` VALUES ('147', '18', 'PurchaseOrder', '[]', 'Order updated', '1449155455', '1');
INSERT INTO `tbl_history` VALUES ('148', '18', 'PurchaseOrder', '[]', 'Order updated', '1449510600', '1');
INSERT INTO `tbl_history` VALUES ('149', '18', 'PurchaseOrder', '[]', 'Order updated', '1449510774', '1');
INSERT INTO `tbl_history` VALUES ('150', '18', 'PurchaseOrder', '[]', 'Order updated', '1449510796', '1');
INSERT INTO `tbl_history` VALUES ('151', '4', 'PurchaseOrder', '[]', 'Order updated', '1449546336', '1');
INSERT INTO `tbl_history` VALUES ('152', '4', 'PurchaseOrder', '[]', 'Order updated', '1449546463', '1');
INSERT INTO `tbl_history` VALUES ('153', '4', 'PurchaseOrder', '[]', 'Order updated', '1449547475', '1');
INSERT INTO `tbl_history` VALUES ('154', '4', 'PurchaseOrder', '[]', 'Order updated', '1449548199', '1');
INSERT INTO `tbl_history` VALUES ('155', '4', 'PurchaseOrder', '[]', 'Order updated', '1449548580', '1');
INSERT INTO `tbl_history` VALUES ('156', '4', 'PurchaseOrder', '[]', 'Order updated', '1449548605', '1');
INSERT INTO `tbl_history` VALUES ('157', '4', 'PurchaseOrder', '[]', 'Order updated', '1449549771', '1');
INSERT INTO `tbl_history` VALUES ('158', '18', 'PurchaseOrder', '[]', 'Order updated', '1449583662', '1');
INSERT INTO `tbl_history` VALUES ('159', '4', 'PurchaseOrder', '[]', 'Order updated', '1449585466', '1');
INSERT INTO `tbl_history` VALUES ('160', '4', 'PurchaseOrder', '[]', 'Order updated', '1449585544', '1');
INSERT INTO `tbl_history` VALUES ('161', '4', 'PurchaseOrder', '[]', 'Order updated', '1449585717', '1');
INSERT INTO `tbl_history` VALUES ('162', '4', 'PurchaseOrder', '[]', 'Order updated', '1449585818', '1');
INSERT INTO `tbl_history` VALUES ('163', '4', 'PurchaseOrder', '[]', 'Order updated', '1449585966', '1');
INSERT INTO `tbl_history` VALUES ('164', '4', 'PurchaseOrder', '[]', 'Order updated', '1449586115', '1');
INSERT INTO `tbl_history` VALUES ('165', '4', 'PurchaseOrder', '[]', 'Order updated', '1449586334', '1');
INSERT INTO `tbl_history` VALUES ('166', '4', 'PurchaseOrder', '[]', 'Order updated', '1449587271', '1');
INSERT INTO `tbl_history` VALUES ('167', '4', 'PurchaseOrder', '[]', 'Order updated', '1449589320', '1');
INSERT INTO `tbl_history` VALUES ('168', '4', 'PurchaseOrder', '[]', 'Order updated', '1449589341', '1');
INSERT INTO `tbl_history` VALUES ('169', '4', 'PurchaseOrder', '[]', 'Order updated', '1449589385', '1');
INSERT INTO `tbl_history` VALUES ('170', '4', 'PurchaseOrder', '[]', 'Order updated', '1449589445', '1');
INSERT INTO `tbl_history` VALUES ('171', '54', 'Part', '{\"part_code\":{\"name\":\"Part Code\",\"old\":\"Nam_PART_SEP_10\",\"new\":\"HUNGHUNG_PART_SEP_10\"}}', '', '1449589654', '1');
INSERT INTO `tbl_history` VALUES ('172', '18', 'PurchaseOrder', '[]', 'Order updated', '1449590585', '1');
INSERT INTO `tbl_history` VALUES ('173', '18', 'PurchaseOrder', '[]', 'Order updated', '1449590964', '1');
INSERT INTO `tbl_history` VALUES ('174', '18', 'PurchaseOrder', '[]', 'Order updated', '1449591010', '1');
INSERT INTO `tbl_history` VALUES ('175', '18', 'PurchaseOrder', '[]', 'Order updated', '1449592150', '1');
INSERT INTO `tbl_history` VALUES ('176', '4', 'PurchaseOrder', '[]', 'Order updated', '1449593000', '1');
INSERT INTO `tbl_history` VALUES ('177', '4', 'PurchaseOrder', '[]', 'Order updated', '1449593016', '1');
INSERT INTO `tbl_history` VALUES ('178', '4', 'PurchaseOrder', '[]', 'Order updated', '1449593055', '1');
INSERT INTO `tbl_history` VALUES ('179', '20', 'PurchaseOrder', '[]', 'Order created', '1449593199', '1');
INSERT INTO `tbl_history` VALUES ('180', '18', 'PurchaseOrder', '[]', 'Order updated', '1449622188', '1');
INSERT INTO `tbl_history` VALUES ('181', '18', 'PurchaseOrder', '[]', 'Order updated', '1449622233', '1');
INSERT INTO `tbl_history` VALUES ('182', '61', 'Part', '{\"tmp_file_ids\":{\"name\":\"Uploaded file\",\"old\":\"\",\"new\":\"161,162\"}}', '', '1449666307', '1');
INSERT INTO `tbl_history` VALUES ('183', '56', 'Part', '{\"tmp_file_ids\":{\"name\":\"Uploaded file\",\"old\":\"\",\"new\":\"163,164,165\"}}', '', '1449666565', '1');
INSERT INTO `tbl_history` VALUES ('184', '59', 'Part', '{\"tmp_file_ids\":{\"name\":\"Uploaded file\",\"old\":\"\",\"new\":\"166\"}}', '', '1449667096', '1');
INSERT INTO `tbl_history` VALUES ('185', '59', 'Part', '{\"tmp_file_ids\":{\"name\":\"Uploaded file\",\"old\":\"166\",\"new\":\"166,168\"}}', '', '1449667325', '1');
INSERT INTO `tbl_history` VALUES ('186', '58', 'Part', '{\"tmp_file_ids\":{\"name\":\"Uploaded file\",\"old\":\"\",\"new\":\"167,169,170\"}}', '', '1449667572', '1');
INSERT INTO `tbl_history` VALUES ('187', '57', 'Part', '{\"tmp_file_ids\":{\"name\":\"Uploaded file\",\"old\":\"\",\"new\":\"171,172\"}}', '', '1449667986', '1');
INSERT INTO `tbl_history` VALUES ('188', '60', 'Part', '{\"tmp_file_ids\":{\"name\":\"Uploaded file\",\"old\":\"\",\"new\":\"173,174\"}}', '', '1449668293', '1');
INSERT INTO `tbl_history` VALUES ('189', '21', 'PurchaseOrder', '[]', 'Order created', '1449676050', '1');
INSERT INTO `tbl_history` VALUES ('190', '21', 'PurchaseOrder', '[]', 'Order updated', '1449676253', '1');
INSERT INTO `tbl_history` VALUES ('191', '21', 'PurchaseOrder', '[]', 'Order updated', '1449677627', '1');
INSERT INTO `tbl_history` VALUES ('192', '21', 'PurchaseOrder', '[]', 'Order updated', '1449677716', '1');
INSERT INTO `tbl_history` VALUES ('193', '22', 'PurchaseOrder', '[]', 'Order created', '1449678969', '1');
INSERT INTO `tbl_history` VALUES ('194', '22', 'PurchaseOrder', '[]', 'Order updated', '1449679034', '1');
INSERT INTO `tbl_history` VALUES ('195', '22', 'PurchaseOrder', '[]', 'Order updated', '1449679056', '1');
INSERT INTO `tbl_history` VALUES ('196', '55', 'Material', '{\"designation_id\":{\"name\":\"Designation Id\",\"old\":\"\",\"new\":\"A55\"}}', '', '1450096178', '12');
INSERT INTO `tbl_history` VALUES ('197', '57', 'Material', '{\"designation_id\":{\"name\":\"Designation Id\",\"old\":\"\",\"new\":\"A57\"}}', '', '1450101219', '12');
INSERT INTO `tbl_history` VALUES ('198', '58', 'Material', '{\"designation_id\":{\"name\":\"Designation Id\",\"old\":\"\",\"new\":\"A58\"},\"note\":{\"name\":\"Note\",\"old\":\"<p>MAZAK TESTING. NO HEAT. TOOLING ONLY<\\/p>\\n\",\"new\":\"\"}}', '', '1450101572', '12');
INSERT INTO `tbl_history` VALUES ('199', '58', 'Material', '{\"note\":{\"name\":\"Note\",\"old\":\"\",\"new\":\"<p>MAZAK TESTING. NO HEAT. TOOLING ONLY<\\/p>\\n\"},\"quantity\":{\"name\":\"Quantity\",\"old\":\"0\",\"new\":6}}', '', '1450106585', '12');
INSERT INTO `tbl_history` VALUES ('200', '59', 'Material', '{\"designation_id\":{\"name\":\"Designation Id\",\"old\":\"\",\"new\":\"B59\"}}', '', '1450109109', '12');
INSERT INTO `tbl_history` VALUES ('201', '60', 'Material', '{\"designation_id\":{\"name\":\"Designation Id\",\"old\":\"\",\"new\":\"B60\"}}', '', '1450111380', '12');
INSERT INTO `tbl_history` VALUES ('202', '61', 'Material', '{\"designation_id\":{\"name\":\"Designation Id\",\"old\":\"\",\"new\":\"B61\"}}', '', '1450111852', '12');
INSERT INTO `tbl_history` VALUES ('203', '62', 'Material', '{\"designation_id\":{\"name\":\"Designation Id\",\"old\":\"\",\"new\":\"B62\"}}', '', '1450112420', '12');
INSERT INTO `tbl_history` VALUES ('204', '63', 'Material', '{\"designation_id\":{\"name\":\"Designation Id\",\"old\":\"\",\"new\":\"B63\"}}', '', '1450114410', '12');
INSERT INTO `tbl_history` VALUES ('205', '63', 'Material', '{\"quantity\":{\"name\":\"Quantity\",\"old\":\"0\",\"new\":1}}', '', '1450114594', '12');
INSERT INTO `tbl_history` VALUES ('206', '64', 'Material', '{\"designation_id\":{\"name\":\"Designation Id\",\"old\":\"\",\"new\":\"B64\"}}', '', '1450115027', '12');
INSERT INTO `tbl_history` VALUES ('207', '65', 'Material', '{\"designation_id\":{\"name\":\"Designation Id\",\"old\":\"\",\"new\":\"A65\"}}', '', '1450116308', '12');
INSERT INTO `tbl_history` VALUES ('208', '65', 'Material', '{\"quantity\":{\"name\":\"Quantity\",\"old\":\"0\",\"new\":1}}', '', '1450117151', '12');
INSERT INTO `tbl_history` VALUES ('209', '66', 'Material', '{\"designation_id\":{\"name\":\"Designation Id\",\"old\":\"\",\"new\":\"C66\"}}', '', '1450117685', '12');
INSERT INTO `tbl_history` VALUES ('210', '66', 'Material', '{\"quantity\":{\"name\":\"Quantity\",\"old\":\"0\",\"new\":1}}', '', '1450117798', '12');
INSERT INTO `tbl_history` VALUES ('211', '67', 'Material', '{\"designation_id\":{\"name\":\"Designation Id\",\"old\":\"\",\"new\":\"C67\"}}', '', '1450117944', '12');
INSERT INTO `tbl_history` VALUES ('212', '68', 'Material', '{\"designation_id\":{\"name\":\"Designation Id\",\"old\":\"\",\"new\":\"C68\"}}', '', '1450118274', '12');
INSERT INTO `tbl_history` VALUES ('213', '65', 'Material', '{\"quantity\":{\"name\":\"Quantity\",\"old\":\"1\",\"new\":3}}', '', '1450118456', '12');
INSERT INTO `tbl_history` VALUES ('214', '69', 'Material', '{\"designation_id\":{\"name\":\"Designation Id\",\"old\":\"\",\"new\":\"C69\"}}', '', '1450118766', '12');
INSERT INTO `tbl_history` VALUES ('215', '34', 'Material', '{\"designation_id\":{\"name\":\"Designation Id\",\"old\":\"\",\"new\":\"A34\"}}', '', '1450269944', '12');
INSERT INTO `tbl_history` VALUES ('216', '22', 'Material', '{\"designation_id\":{\"name\":\"Designation Id\",\"old\":\"\",\"new\":\"C22\"}}', '', '1450270787', '12');
INSERT INTO `tbl_history` VALUES ('217', '32', 'Material', '{\"category_id\":{\"name\":\"Material Type\",\"old\":\"19\",\"new\":\"18\"},\"designation_id\":{\"name\":\"Designation Id\",\"old\":\"\",\"new\":\"A32\"}}', '', '1450275264', '12');
INSERT INTO `tbl_history` VALUES ('218', '22', 'Material', '{\"quantity\":{\"name\":\"Quantity\",\"old\":\"0\",\"new\":12}}', '', '1450275521', '12');
INSERT INTO `tbl_history` VALUES ('219', '14', 'PurchaseOrder', '[]', 'Order updated', '1450876584', '12');
INSERT INTO `tbl_history` VALUES ('220', '13', 'PurchaseOrder', '[]', 'Order updated', '1450876748', '12');
INSERT INTO `tbl_history` VALUES ('221', '69', 'Material', '{\"quantity\":{\"name\":\"Quantity\",\"old\":\"0\",\"new\":1}}', '', '1451922506', '12');
INSERT INTO `tbl_history` VALUES ('222', '70', 'Material', '{\"designation_id\":{\"name\":\"Designation Id\",\"old\":\"\",\"new\":\"A70\"}}', '', '1451922937', '12');
INSERT INTO `tbl_history` VALUES ('223', '71', 'Material', '{\"designation_id\":{\"name\":\"Designation Id\",\"old\":\"\",\"new\":\"A71\"}}', '', '1451923243', '12');
INSERT INTO `tbl_history` VALUES ('224', '71', 'Material', '{\"quantity\":{\"name\":\"Quantity\",\"old\":\"0\",\"new\":1}}', '', '1453822875', '12');
INSERT INTO `tbl_history` VALUES ('225', '26', 'Material', '{\"designation_id\":{\"name\":\"Designation Id\",\"old\":\"\",\"new\":\"B26\"}}', '', '1453823468', '12');
INSERT INTO `tbl_history` VALUES ('226', '62', 'Part', '{\"tmp_file_ids\":{\"name\":\"Uploaded file\",\"old\":\"\",\"new\":\"200\"}}', '', '1455294392', '1');
INSERT INTO `tbl_history` VALUES ('227', '63', 'Part', '{\"tmp_file_ids\":{\"name\":\"Uploaded file\",\"old\":\"\",\"new\":\"201\"}}', '', '1455294859', '1');
INSERT INTO `tbl_history` VALUES ('228', '23', 'PurchaseOrder', '[]', 'Order created', '1455295996', '1');
INSERT INTO `tbl_history` VALUES ('229', '63', 'Part', '{\"tmp_file_ids\":{\"name\":\"Uploaded file\",\"old\":\"\",\"new\":\"203\"}}', '', '1455296085', '1');
INSERT INTO `tbl_history` VALUES ('230', '23', 'PurchaseOrder', '[]', 'Order updated', '1455296451', '1');
INSERT INTO `tbl_history` VALUES ('231', '23', 'PurchaseOrder', '[]', 'Order updated', '1455298103', '1');
INSERT INTO `tbl_history` VALUES ('232', '23', 'PurchaseOrder', '[]', 'Order updated', '1455298266', '1');
INSERT INTO `tbl_history` VALUES ('233', '24', 'PurchaseOrder', '[]', 'Order created', '1455298456', '1');
INSERT INTO `tbl_history` VALUES ('234', '24', 'PurchaseOrder', '[]', 'Order updated', '1455298595', '1');
INSERT INTO `tbl_history` VALUES ('235', '25', 'PurchaseOrder', '[]', 'Order created', '1455298951', '1');
INSERT INTO `tbl_history` VALUES ('236', '25', 'PurchaseOrder', '[]', 'Order updated', '1455300498', '1');
INSERT INTO `tbl_history` VALUES ('237', '26', 'PurchaseOrder', '[]', 'Order created', '1455300624', '1');
INSERT INTO `tbl_history` VALUES ('238', '26', 'PurchaseOrder', '[]', 'Order updated', '1455300635', '1');
INSERT INTO `tbl_history` VALUES ('239', '26', 'PurchaseOrder', '[]', 'Order updated', '1455300837', '1');
INSERT INTO `tbl_history` VALUES ('240', '27', 'PurchaseOrder', '[]', 'Order created', '1455300997', '1');
INSERT INTO `tbl_history` VALUES ('241', '27', 'PurchaseOrder', '[]', 'Order updated', '1455301313', '1');
INSERT INTO `tbl_history` VALUES ('242', '27', 'PurchaseOrder', '[]', 'Order updated', '1455301508', '1');
INSERT INTO `tbl_history` VALUES ('243', '28', 'PurchaseOrder', '[]', 'Order created', '1455301530', '1');
INSERT INTO `tbl_history` VALUES ('244', '28', 'PurchaseOrder', '[]', 'Order updated', '1455301586', '1');
INSERT INTO `tbl_history` VALUES ('245', '28', 'PurchaseOrder', '[]', 'Order updated', '1455301633', '1');
INSERT INTO `tbl_history` VALUES ('246', '28', 'PurchaseOrder', '[]', 'Order updated', '1455302092', '1');
INSERT INTO `tbl_history` VALUES ('247', '28', 'PurchaseOrder', '[]', 'Order updated', '1455302123', '1');
INSERT INTO `tbl_history` VALUES ('248', '28', 'PurchaseOrder', '[]', 'Order updated', '1455302184', '1');
INSERT INTO `tbl_history` VALUES ('249', '28', 'PurchaseOrder', '[]', 'Order updated', '1455302268', '1');
INSERT INTO `tbl_history` VALUES ('250', '71', 'Material', '{\"sizes\":{\"name\":\"Sizes\",\"old\":\"{\\\"od\\\":\\\"\\\"}\",\"new\":\"{\\\"od\\\":\\\"3.25\\\"}\"},\"quantity\":{\"name\":\"Quantity\",\"old\":\"1\",\"new\":3}}', '', '1455474545', '1');
INSERT INTO `tbl_history` VALUES ('251', '29', 'PurchaseOrder', '[]', 'Order created', '1455497620', '1');
INSERT INTO `tbl_history` VALUES ('252', '29', 'PurchaseOrder', '[]', 'Order updated', '1455497706', '1');
INSERT INTO `tbl_history` VALUES ('253', '29', 'PurchaseOrder', '[]', 'Order updated', '1455508996', '1');
INSERT INTO `tbl_history` VALUES ('254', '23', 'PurchaseOrder', '[]', 'Order updated', '1456160321', '1');
INSERT INTO `tbl_history` VALUES ('255', '26', 'PurchaseOrder', '[]', 'Order updated', '1456430896', '1');
INSERT INTO `tbl_history` VALUES ('256', '26', 'PurchaseOrder', '[]', 'Order updated', '1456431075', '1');
INSERT INTO `tbl_history` VALUES ('257', '26', 'PurchaseOrder', '[]', 'Order updated', '1456431171', '1');
INSERT INTO `tbl_history` VALUES ('258', '26', 'PurchaseOrder', '[]', 'Order updated', '1456432266', '1');
INSERT INTO `tbl_history` VALUES ('259', '26', 'PurchaseOrder', '[]', 'Order updated', '1456432287', '1');
INSERT INTO `tbl_history` VALUES ('260', '26', 'PurchaseOrder', '[]', 'Order updated', '1456432335', '1');
INSERT INTO `tbl_history` VALUES ('261', '26', 'PurchaseOrder', '[]', 'Order updated', '1456432429', '1');
INSERT INTO `tbl_history` VALUES ('262', '26', 'PurchaseOrder', '[]', 'Order updated', '1456433234', '1');
INSERT INTO `tbl_history` VALUES ('263', '30', 'PurchaseOrder', '[]', 'Order created', '1456433424', '1');
INSERT INTO `tbl_history` VALUES ('264', '30', 'PurchaseOrder', '[]', 'Order updated', '1456433615', '1');
INSERT INTO `tbl_history` VALUES ('265', '30', 'PurchaseOrder', '[]', 'Order updated', '1456434027', '1');
INSERT INTO `tbl_history` VALUES ('266', '30', 'PurchaseOrder', '[]', 'Order updated', '1456434245', '1');
INSERT INTO `tbl_history` VALUES ('267', '26', 'PurchaseOrder', '[]', 'Order updated', '1456434617', '1');
INSERT INTO `tbl_history` VALUES ('268', '31', 'PurchaseOrder', '[]', 'Order created', '1456499754', '1');
INSERT INTO `tbl_history` VALUES ('269', '31', 'PurchaseOrder', '[]', 'Order updated', '1456499980', '1');
INSERT INTO `tbl_history` VALUES ('270', '31', 'PurchaseOrder', '[]', 'Order updated', '1456500026', '1');
INSERT INTO `tbl_history` VALUES ('271', '32', 'PurchaseOrder', '[]', 'Order created', '1457729776', '1');
INSERT INTO `tbl_history` VALUES ('272', '32', 'PurchaseOrder', '[]', 'Order updated', '1457729913', '1');
INSERT INTO `tbl_history` VALUES ('273', '69', 'Part', '{\"tmp_file_ids\":{\"name\":\"Uploaded file\",\"old\":\"\",\"new\":\"209\"}}', '', '1457794221', '1');
INSERT INTO `tbl_history` VALUES ('274', '33', 'PurchaseOrder', '[]', 'Order created', '1457794313', '1');
INSERT INTO `tbl_history` VALUES ('275', '33', 'PurchaseOrder', '[]', 'Order updated', '1457794379', '1');
INSERT INTO `tbl_history` VALUES ('276', '70', 'Part', '{\"tmp_file_ids\":{\"name\":\"Uploaded file\",\"old\":\"\",\"new\":\"213\"}}', '', '1462299059', '15');
INSERT INTO `tbl_history` VALUES ('277', '72', 'Part', '{\"tmp_file_ids\":{\"name\":\"Uploaded file\",\"old\":\"\",\"new\":\"214\"}}', '', '1462300637', '15');
INSERT INTO `tbl_history` VALUES ('278', '73', 'Part', '{\"tmp_file_ids\":{\"name\":\"Uploaded file\",\"old\":\"\",\"new\":\"215\"}}', '', '1462300863', '15');
INSERT INTO `tbl_history` VALUES ('279', '74', 'Part', '{\"tmp_file_ids\":{\"name\":\"Uploaded file\",\"old\":\"\",\"new\":\"216\"}}', '', '1462301131', '15');
INSERT INTO `tbl_history` VALUES ('280', '75', 'Part', '{\"tmp_file_ids\":{\"name\":\"Uploaded file\",\"old\":\"\",\"new\":\"217\"}}', '', '1462301342', '15');
INSERT INTO `tbl_history` VALUES ('281', '80', 'Part', '{\"description\":{\"name\":\"Description\",\"old\":\"1.00 x 3.31\",\"new\":\"1.00 x 5.56\"},\"part_length\":{\"name\":\"Part Length\",\"old\":\"3.31\",\"new\":\"5.56\"}}', '', '1462366077', '15');
INSERT INTO `tbl_history` VALUES ('282', '88', 'Part', '{\"description\":{\"name\":\"Description\",\"old\":\"X 6.83\",\"new\":\".625 X 1.3\"}}', '', '1462369424', '15');
INSERT INTO `tbl_history` VALUES ('283', '76', 'Part', '{\"description\":{\"name\":\"Description\",\"old\":\".375 X 7.75\",\"new\":\".375 X 7.75 Sooler Shaft 1\\/4-20Thds\"}}', '', '1462393004', '1');
INSERT INTO `tbl_history` VALUES ('284', '75', 'Part', '{\"description\":{\"name\":\"Description\",\"old\":\".250 X 1.375\",\"new\":\".250 X 1.375 Shoulder Pins(UI SHaft)\"}}', '', '1462393397', '1');
INSERT INTO `tbl_history` VALUES ('285', '77', 'Part', '{\"description\":{\"name\":\"Description\",\"old\":\".375 X 1.435\",\"new\":\".375 X 1.435 w\\/1\\/4-20thrd\"}}', '', '1462393572', '1');
INSERT INTO `tbl_history` VALUES ('286', '74', 'Part', '{\"description\":{\"name\":\"Description\",\"old\":\".375 X 1.171\",\"new\":\".375 X 1.171 + 8-32Tap\"}}', '', '1462393761', '1');
INSERT INTO `tbl_history` VALUES ('287', '73', 'Part', '{\"description\":{\"name\":\"Description\",\"old\":\".375 X 2.140\",\"new\":\".375 X 2.140 w\\/.029\\\" grvs\"}}', '', '1462393908', '1');
INSERT INTO `tbl_history` VALUES ('288', '72', 'Part', '{\"description\":{\"name\":\"Description\",\"old\":\".375 X 1.864\",\"new\":\".375 X 1.864 w\\/.029\\\" Grvs & 8-32Tap\"}}', '', '1462394727', '1');
INSERT INTO `tbl_history` VALUES ('289', '71', 'Part', '{\"description\":{\"name\":\"Description\",\"old\":\"3\\/8 X 4.901\",\"new\":\"3\\/8 X 4.901 w\\/8-32Tap Grinder Input Shaft\"}}', '', '1462394870', '1');
INSERT INTO `tbl_history` VALUES ('290', '70', 'Part', '{\"description\":{\"name\":\"Description\",\"old\":\"3\\/4\\\" X 5.7 LNG SHAFT\",\"new\":\"3\\/4\\\" X 5.7 LNG Hex Shaft\"}}', '', '1462395082', '1');
INSERT INTO `tbl_history` VALUES ('291', '71', 'Part', '{\"description\":{\"name\":\"Description\",\"old\":\"3\\/8 X 4.901 w\\/8-32Tap Grinder Input Shaft\",\"new\":\"3\\/8 X 4.901 w\\/8-32Tap Grinder Input Crank Shaft\"}}', '', '1462395208', '1');
INSERT INTO `tbl_history` VALUES ('292', '72', 'Part', '{\"description\":{\"name\":\"Description\",\"old\":\".375 X 1.864 w\\/.029\\\" Grvs & 8-32Tap\",\"new\":\".029\\\" Grvs & 8-32Tap Grinder Interlock Gearshaft\"}}', '', '1462395263', '1');
INSERT INTO `tbl_history` VALUES ('293', '73', 'Part', '{\"description\":{\"name\":\"Description\",\"old\":\".375 X 2.140 w\\/.029\\\" grvs\",\"new\":\".374 w\\/.029\\\" grvs Grinder Interlock Pivot Shaft\"}}', '', '1462395307', '1');
INSERT INTO `tbl_history` VALUES ('294', '74', 'Part', '{\"description\":{\"name\":\"Description\",\"old\":\".375 X 1.171 + 8-32Tap\",\"new\":\".374 + 8-32Tap Grinder Interlock Shaft\"}}', '', '1462395349', '1');
INSERT INTO `tbl_history` VALUES ('295', '77', 'Part', '{\"description\":{\"name\":\"Description\",\"old\":\".375 X 1.435 w\\/1\\/4-20thrd\",\"new\":\".374 w\\/1\\/4-20thrd Sensor Adjuster\"}}', '', '1462397362', '1');
INSERT INTO `tbl_history` VALUES ('296', '34', 'PurchaseOrder', '[]', 'Order created', '1462397922', '1');
INSERT INTO `tbl_history` VALUES ('297', '34', 'PurchaseOrder', '[]', 'Order updated', '1462398669', '1');
INSERT INTO `tbl_history` VALUES ('298', '34', 'PurchaseOrder', '[]', 'Order updated', '1462398953', '1');
INSERT INTO `tbl_history` VALUES ('299', '34', 'PurchaseOrder', '[]', 'Order updated', '1462399111', '1');
INSERT INTO `tbl_history` VALUES ('300', '83', 'Part', '{\"description\":{\"name\":\"Description\",\"old\":\"1.00 X .50\",\"new\":\"1.00 X .50 Extruder Bearing Spacer\"},\"material_id\":{\"name\":\"Material\",\"old\":\"79\",\"new\":\"78\"}}', '', '1462441440', '1');
INSERT INTO `tbl_history` VALUES ('301', '84', 'Part', '{\"description\":{\"name\":\"Description\",\"old\":\"1.00 X 1.51\",\"new\":\"1.00 X 1.51 PULLER WHEEL\"},\"material_id\":{\"name\":\"Material\",\"old\":\"79\",\"new\":\"80\"}}', '', '1462441706', '1');
INSERT INTO `tbl_history` VALUES ('302', '82', 'Part', '{\"description\":{\"name\":\"Description\",\"old\":\"1.00 X .630\",\"new\":\"1.00 X .630 PULLER IDLER\"}}', '', '1462442290', '1');
INSERT INTO `tbl_history` VALUES ('303', '81', 'Part', '{\"description\":{\"name\":\"Description\",\"old\":\"1.00 X 2.38\",\"new\":\"1.00 X 2.38 INSERT BLANK\"},\"part_length\":{\"name\":\"Part Length\",\"old\":\"2.38\",\"new\":\"3.505\"}}', '', '1462442429', '1');
INSERT INTO `tbl_history` VALUES ('304', '80', 'Part', '{\"description\":{\"name\":\"Description\",\"old\":\"1.00 x 5.56\",\"new\":\"1.00 x 5.56 Extruder Auger\"}}', '', '1462442539', '1');
INSERT INTO `tbl_history` VALUES ('305', '81', 'Part', '{\"description\":{\"name\":\"Description\",\"old\":\"1.00 X 2.38 INSERT BLANK\",\"new\":\"1.00 X 3.505 INSERT BLANK\"}}', '', '1462442563', '1');
INSERT INTO `tbl_history` VALUES ('306', '85', 'Part', '{\"description\":{\"name\":\"Description\",\"old\":\"1.00 x 5.56\",\"new\":\"1.00 x 5.56 Extruder Auger Blank\"}}', '', '1462442653', '1');
INSERT INTO `tbl_history` VALUES ('307', '78', 'Part', '{\"description\":{\"name\":\"Description\",\"old\":\"2.00 X 3.50\",\"new\":\"2.00 X 3.50 Extruder Cold Section\"}}', '', '1462442773', '1');
INSERT INTO `tbl_history` VALUES ('308', '79', 'Part', '{\"description\":{\"name\":\"Description\",\"old\":\"2.00 X 4.14\",\"new\":\"2.00 X 4.14 EXTRUDER HOT SECTION\"}}', '', '1462443233', '1');
INSERT INTO `tbl_history` VALUES ('309', '90', 'Part', '{\"description\":{\"name\":\"Description\",\"old\":\".375  X 4.00 PLATE\",\"new\":\".375  X 4.00 FRONT PLATE\"}}', '', '1462449933', '1');
INSERT INTO `tbl_history` VALUES ('310', '88', 'Part', '{\"description\":{\"name\":\"Description\",\"old\":\".625 X 1.3\",\"new\":\".625 X 1.3 Grinder Sprocket Housing\"}}', '', '1462450072', '1');
INSERT INTO `tbl_history` VALUES ('311', '89', 'Part', '{\"description\":{\"name\":\"Description\",\"old\":\"1.07 X 1.50 INTERLOCK ARM\",\"new\":\"1.07 X 1.50 GRINDER INTERLOCK ARM\"}}', '', '1462450346', '1');
INSERT INTO `tbl_history` VALUES ('312', '35', 'PurchaseOrder', '[]', 'Order created', '1462452973', '1');
INSERT INTO `tbl_history` VALUES ('313', '35', 'PurchaseOrder', '[]', 'Order updated', '1462452999', '1');
INSERT INTO `tbl_history` VALUES ('314', '35', 'PurchaseOrder', '[]', 'Order updated', '1462453026', '1');
INSERT INTO `tbl_history` VALUES ('315', '36', 'PurchaseOrder', '[]', 'Order created', '1462453726', '1');
INSERT INTO `tbl_history` VALUES ('316', '36', 'PurchaseOrder', '[]', 'Order updated', '1462453831', '1');
INSERT INTO `tbl_history` VALUES ('317', '37', 'PurchaseOrder', '[]', 'Order created', '1462562413', '1');
INSERT INTO `tbl_history` VALUES ('318', '37', 'PurchaseOrder', '[]', 'Order updated', '1462562502', '1');
INSERT INTO `tbl_history` VALUES ('319', '38', 'PurchaseOrder', '[]', 'Order created', '1462565988', '1');
INSERT INTO `tbl_history` VALUES ('320', '38', 'PurchaseOrder', '[]', 'Order updated', '1462566610', '1');
INSERT INTO `tbl_history` VALUES ('321', '39', 'PurchaseOrder', '[]', 'Order created', '1462627445', '1');
INSERT INTO `tbl_history` VALUES ('322', '39', 'PurchaseOrder', '[]', 'Order updated', '1462627517', '1');
INSERT INTO `tbl_history` VALUES ('323', '40', 'PurchaseOrder', '[]', 'Order created', '1463244508', '1');
INSERT INTO `tbl_history` VALUES ('324', '40', 'PurchaseOrder', '[]', 'Order updated', '1463244637', '1');
INSERT INTO `tbl_history` VALUES ('325', '40', 'PurchaseOrder', '[]', 'Order updated', '1463244694', '1');
INSERT INTO `tbl_history` VALUES ('326', '41', 'PurchaseOrder', '[]', 'Order created', '1463244823', '1');
INSERT INTO `tbl_history` VALUES ('327', '41', 'PurchaseOrder', '[]', 'Order updated', '1463244918', '1');
INSERT INTO `tbl_history` VALUES ('328', '41', 'PurchaseOrder', '[]', 'Order updated', '1463244999', '1');
INSERT INTO `tbl_history` VALUES ('329', '42', 'PurchaseOrder', '[]', 'Order created', '1463245122', '1');
INSERT INTO `tbl_history` VALUES ('330', '42', 'PurchaseOrder', '[]', 'Order updated', '1463245148', '1');

-- ----------------------------
-- Table structure for tbl_in_out_material
-- ----------------------------
DROP TABLE IF EXISTS `tbl_in_out_material`;
CREATE TABLE `tbl_in_out_material` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) NOT NULL,
  `material_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `inch_bar` float NOT NULL,
  `total_inch` float NOT NULL,
  `total_lbs` float NOT NULL,
  `cost_inch` float NOT NULL,
  `cost_lbs` float NOT NULL,
  `location_ids` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL,
  `heatnumber_ids` varchar(1024) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `heatnumbers` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL,
  `received_by` int(11) NOT NULL,
  `received_date` int(11) NOT NULL,
  `mill_cert_file_id` int(11) NOT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_time` int(11) NOT NULL,
  `created_time` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `scribed_tagged` tinyint(1) NOT NULL,
  `job_order_id` int(11) NOT NULL,
  `part_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=140 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of tbl_in_out_material
-- ----------------------------
INSERT INTO `tbl_in_out_material` VALUES ('1', '0', '15', '5', '12', '30', '0', '31', '32', '0', '0', 'null', '', '0', '1428357600', '110', 'Good quality, need to check more', '1430124714', '1430124714', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('2', '0', '15', '2', '20', '14', '0', '310', '32', '0', '0', 'null', '', '0', '1429653600', '0', 'Chekc note', '1430126141', '1430126141', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('3', '0', '15', '4', '10', '12', '0', '320', '40', '0', '0', '\"Hn32\"', '', '0', '1430085600', '0', '', '1430126343', '1430126343', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('4', '0', '15', '4', '30', '10', '300', '13', '3', '69.23', '0', 'null', '', '0', '1430085600', '0', '', '1430126561', '1430126561', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('5', '0', '15', '3', '15', '10', '150', '20', '15', '112.5', '0', '\"H#\"', '', '0', '1428444000', '0', '', '1430127750', '1430127750', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('6', '1', '15', '0', '5', '2', '10', '3', '0', '0', '0', '\"#12\"', '', '0', '1430258400', '0', 'No note', '1430127780', '1430127780', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('7', '0', '14', '5', '1000', '4', '4000', '1000', '50', '0', '0', '\"H2\"', '', '0', '1428444000', '0', 'No Note', '1430128861', '1430128861', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('8', '0', '9', '4', '12', '23', '276', '31', '5', '44.52', '0', 'null', '', '0', '1429574400', '0', 'Good quality.', '1430202165', '1430202165', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('9', '0', '9', '4', '10', '12', '120', '48', '5', '12.5', '0', '\"Heat 1\"', '', '0', '1430870400', '0', 'Check in 120', '1430445493', '1430445493', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('10', '1', '9', '0', '12', '10', '120', '48', '0', '0', '0', '\"xyz\"', '', '0', '1430438400', '0', 'TEst check out', '1430878352', '1430878352', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('11', '1', '9', '0', '10', '5', '50', '120', '0', '0', '0', '[{\"text\":\"122\"}]', '', '0', '1433289600', '0', 'HUNG', '1435052396', '1435052396', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('12', '0', '10', '4', '0', '50', '500', '10', '15', '750', '', '[null]', '[{\"heatnumber\":\"Material Heat 1\",\"designation\":\"Designation 1\",\"quantity\":10,\"quantity_detail\":[{\"quantity\":4,\"length\":100},{\"quantity\":6,\"length\":80}]}]', '0', '1438041600', '0', 'by Mr Nam', '1436345645', '1436345645', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('13', '0', '10', '4', '0', '50', '500', '10', '15', '750', '', '[null]', '[{\"heatnumber\":\"Material Heat 1\",\"designation\":\"Designation 1\",\"quantity\":10,\"quantity_detail\":[{\"quantity\":4,\"length\":100},{\"quantity\":6,\"length\":80}]}]', '0', '1438041600', '0', 'by Mr Nam', '1436345766', '1436345766', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('14', '0', '10', '1', '0', '100', '0', '15', '20', '0', '', '[\"7\"]', '[{\"id\":\"7\",\"heatnumber\":\"Material Heat 2\",\"designation\":\"Designation 2\",\"quantity\":0,\"quantity_detail\":[{\"quantity\":10,\"length\":100}]}]', '0', '1437436800', '0', '', '1436345857', '1436345857', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('15', '0', '10', '3', '0', '100', '2200', '20', '40', '4', '', '[\"6\",\"7\"]', '[{\"id\":\"7\",\"heatnumber\":\"Material Heat 2\",\"designation\":\"Designation 2\",\"quantity\":15,\"quantity_detail\":[{\"quantity\":10,\"length\":55},{\"quantity\":5,\"length\":20}]},{\"id\":\"6\",\"heatnumber\":\"Material Heat 1\",\"designation\":\"Designation 1\",\"quantity\":7,\"quantity_detail\":[{\"quantity\":2,\"length\":100},{\"quantity\":5,\"length\":80}]}]', '0', '1438128000', '0', '', '1436346231', '1436346231', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('16', '0', '10', '2', '0', '10', '200', '5', '2', '80', '', '[\"7\"]', '[{\"id\":\"7\",\"heatnumber\":\"Material Heat 2\",\"designation\":\"Designation 2\",\"quantity\":20,\"quantity_detail\":[{\"quantity\":20,\"length\":55}]}]', '0', '1437955200', '0', '', '1436346560', '1436346560', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('17', '0', '10', '3', '0', '20', '620', '30', '32', '661.33', '', '[\"7\"]', '[{\"id\":\"7\",\"heatnumber\":\"Material Heat 2\",\"designation\":\"Designation 2\",\"quantity\":31,\"quantity_detail\":[{\"quantity\":31,\"length\":13}]}]', '0', '1436227200', '0', '', '1436346843', '1436346843', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('18', '0', '10', '1', '0', '10', '110', '17', '23', '148.82', '', '[\"6\"]', '[{\"id\":\"6\",\"heatnumber\":\"Material Heat 1\",\"designation\":\"Designation 1\",\"quantity\":11,\"quantity_detail\":[{\"quantity\":5,\"length\":120},{\"quantity\":6,\"length\":100}]}]', '0', '1438128000', '0', '', '1436347018', '1436347018', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('19', '1', '10', '0', '0', '75', '0', '120', '0', '0', '[\"2\"]', '[\"7\"]', '[{\"id\":\"7\",\"heatnumber\":\"Material Heat 2\",\"quantity\":0,\"quantity_detail\":[]}]', '0', '1435536000', '0', 'TEST', '1436359758', '1436359758', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('20', '0', '10', '4', '0', '0', '1600', '0', '1.2', '0', '', '[\"6\"]', '[{\"id\":\"6\",\"heatnumber\":\"Material Heat 1\",\"designation\":\"Designation 1\",\"quantity\":20,\"quantity_detail\":[{\"quantity\":20,\"length\":80}],\"length\":1600}]', '0', '1435708800', '0', 'HUNGTE', '1437551291', '1437551291', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('21', '0', '10', '3', '0', '0', '22', '0', '1', '0', '', '[\"6\"]', '[{\"id\":\"6\",\"heatnumber\":\"Material Heat 1\",\"designation\":\"Designation 1\",\"quantity\":2,\"quantity_detail\":[{\"quantity\":2,\"length\":11}],\"length\":22}]', '0', '1436140800', '99', 'HUNG TEst', '1438138291', '1438138291', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('22', '0', '10', '4', '0', '0', '20', '0', '1', '0', '', '[\"6\"]', '[{\"id\":\"6\",\"heatnumber\":\"Material Heat 1\",\"designation\":\"Designation 1\",\"quantity\":2,\"quantity_detail\":[{\"quantity\":2,\"length\":10}],\"length\":20}]', '0', '1438214400', '0', 'daf', '1438138813', '1438138813', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('23', '0', '10', '4', '0', '0', '273', '0', '2', '0', '', '[\"6\"]', '[{\"id\":\"6\",\"heatnumber\":\"Material Heat 1\",\"designation\":\"Designation 1\",\"quantity\":21,\"quantity_detail\":[{\"quantity\":21,\"length\":13}],\"length\":273}]', '0', '1438300800', '100', 'HUNG', '1438138958', '1438138958', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('24', '0', '10', '4', '0', '0', '99.4', '0', '1.1', '0', '', '[\"6\"]', '[{\"id\":\"6\",\"heatnumber\":\"Material Heat 1\",\"designation\":\"Designation 1\",\"quantity\":8,\"quantity_detail\":[{\"quantity\":3,\"length\":\"12.3\"},{\"quantity\":5,\"length\":\"12.5\"}],\"length\":99.4}]', '0', '1438300800', '0', 'HUNG Sklk', '1438314944', '1438314944', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('26', '1', '10', '0', '0', '0', '37.6', '0', '0', '0', '', '[\"6\",\"7\"]', '[{\"id\":\"6\",\"heatnumber\":\"Material Heat 1\",\"quantity\":2,\"list_length\":[100,80,120,11,10,13,\"12.3\",\"12.5\"],\"quantity_detail\":[{\"quantity\":2,\"length\":\"12.3\"}],\"length\":24.6},{\"id\":\"7\",\"heatnumber\":\"Material Heat 2\",\"quantity\":1,\"list_length\":[100,55,20,13],\"quantity_detail\":[{\"quantity\":1,\"length\":13}],\"length\":13}]', '0', '1438300800', '0', '', '1438315281', '1438315281', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('27', '0', '10', '4', '0', '0', '0', '0', '1', '0', '', '[\"6\"]', '[{\"id\":\"6\",\"heatnumber\":\"Material Heat 1\",\"designation\":\"Designation 1\",\"quantity\":0,\"quantity_detail\":[]}]', '0', '1438300800', '0', '', '1438315703', '1438315703', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('28', '0', '10', '4', '0', '0', '0', '0', '1', '0', '', '[\"6\"]', '[{\"id\":\"6\",\"heatnumber\":\"Material Heat 1\",\"designation\":\"Designation 1\",\"quantity\":0,\"quantity_detail\":[]}]', '0', '1438300800', '0', '', '1438315765', '1438315765', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('29', '0', '10', '4', '0', '0', '13.2', '0', '1', '0', '', '[\"6\"]', '[{\"id\":\"6\",\"heatnumber\":\"Material Heat 1\",\"designation\":\"Designation 1\",\"quantity\":11,\"quantity_detail\":[{\"quantity\":11,\"length\":\"1.2\"}],\"length\":13.2}]', '0', '1435708800', '101', '', '1438316057', '1438316057', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('30', '0', '10', '3', '0', '0', '22.1', '0', '1', '0', '', '[null]', '[{\"heatnumber\":\"Heat 3\",\"designation\":\"Desg3\",\"quantity\":17,\"quantity_detail\":[{\"quantity\":17,\"length\":\"1.3\"}],\"length\":22.1}]', '0', '1438300800', '0', 'HUNGTE', '1438317172', '1438317172', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('31', '0', '10', '4', '0', '0', '2.2', '0', '1', '0', '', '[\"8\"]', '[{\"id\":\"8\",\"heatnumber\":\"Heat 3\",\"designation\":\"Desg3\",\"quantity\":2,\"quantity_detail\":[{\"quantity\":2,\"length\":\"1.1\"}],\"length\":2.2}]', '0', '1438300800', '0', '', '1438317332', '1438317332', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('32', '0', '10', '3', '0', '0', '120.9', '0', '1.2', '0', '', '[\"6\",\"8\"]', '[{\"id\":\"6\",\"heatnumber\":\"Material Heat 1\",\"designation\":\"Designation 1\",\"quantity\":5,\"quantity_detail\":[{\"quantity\":5,\"length\":\"10.6\"}],\"length\":53},{\"id\":\"8\",\"heatnumber\":\"Heat 3\",\"designation\":\"Desg3\",\"quantity\":7,\"quantity_detail\":[{\"quantity\":7,\"length\":\"9.7\"}],\"length\":67.9}]', '0', '1438387200', '0', 'HUNG Checks in', '1438482604', '1438482604', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('33', '1', '10', '0', '0', '0', '61.8', '0', '0', '0', '[\"1\"]', '[\"6\",\"8\"]', '[{\"id\":\"6\",\"heatnumber\":\"Material Heat 1\",\"quantity\":4,\"list_length\":[100,80,120,11,10,13,\"12.3\",\"12.5\",\"1.2\",\"10.6\"],\"quantity_detail\":[{\"quantity\":4,\"length\":\"10.6\"}],\"length\":42.4},{\"id\":\"8\",\"heatnumber\":\"Heat 3\",\"quantity\":2,\"list_length\":[\"1.1\",\"9.7\"],\"quantity_detail\":[{\"quantity\":2,\"length\":\"9.7\"}],\"length\":19.4}]', '0', '1438387200', '0', 'HUNG does check out', '1438482688', '1438482688', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('34', '0', '15', '4', '0', '0', '235', '0', '0', '0', '[\"1\"]', '[\"14\"]', '[{\"id\":\"14\",\"heatnumber\":\"NULL-GFW\",\"designation\":\"C14\",\"quantity\":47,\"quantity_detail\":[{\"quantity\":47,\"length\":\"5\"}],\"length\":235}]', '1', '1442275200', '0', '', '1442327905', '1442327905', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('35', '0', '14', '4', '0', '0', '1500', '0', '0', '0', '', '[\"12\"]', '[{\"id\":\"12\",\"heatnumber\":\"Heat 1\",\"designation\":\"B12\",\"quantity\":15,\"quantity_detail\":[{\"quantity\":5,\"length\":\"100\",\"location_id\":\"1\"},{\"quantity\":10,\"length\":\"100\",\"location_id\":\"2\"}],\"length\":1500}]', '1', '1446076800', '0', '<p>Nam test 1st</p>\n', '1445241067', '1445241067', '0', '1', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('36', '0', '14', '4', '0', '0', '800', '0', '0', '0', '', '[\"13\"]', '[{\"id\":\"13\",\"heatnumber\":\"Heat 2\",\"designation\":\"\",\"quantity\":8,\"quantity_detail\":[{\"quantity\":8,\"length\":\"100\",\"location_id\":\"1\"}],\"length\":800}]', '1', '1446076800', '0', '<p>Nam test 2nd</p>\n', '1445241097', '1445241097', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('37', '0', '10', '4', '0', '0', '156', '0', '0', '0', '', '[\"7\"]', '[{\"id\":\"7\",\"heatnumber\":\"Material Heat 2\",\"designation\":\"Designation 2\",\"quantity\":12,\"quantity_detail\":[{\"quantity\":12,\"length\":13,\"location_id\":\"1\"}],\"length\":156}]', '2', '1444262400', '0', '', '1445340619', '1445340619', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('38', '0', '10', '3', '0', '0', '2000', '0', '0', '0', '', '[\"7\"]', '[{\"id\":\"7\",\"heatnumber\":\"Material Heat 2\",\"designation\":\"Designation 2\",\"quantity\":20,\"quantity_detail\":[{\"quantity\":20,\"length\":100,\"location_id\":\"1\"}],\"length\":2000}]', '2', '1447372800', '0', '', '1446517017', '1446517017', '0', '1', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('40', '0', '10', '4', '0', '0', '300', '0', '0', '0', '', '[\"6\"]', '[{\"id\":\"6\",\"heatnumber\":\"Material Heat 1\",\"designation\":\"Designation 1\",\"quantity\":3,\"quantity_detail\":[{\"quantity\":3,\"length\":100,\"location_id\":\"1\"}],\"length\":300}]', '2', '1447113600', '0', '', '1446519237', '1446519237', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('41', '1', '10', '0', '0', '0', '100', '0', '0', '0', '', '[\"6\"]', '[{\"id\":\"6\",\"heatnumber\":\"Material Heat 1\",\"designation\":\"Designation 1\",\"quantity\":1,\"quantity_detail\":[{\"length\":100,\"location_id\":\"1\",\"quantity\":1}],\"list_length\":[100,80,120,11,10,13,\"12.3\",\"12.5\",\"1.2\",\"10.6\"],\"length\":100}]', '2', '1446681600', '0', '', '1446519319', '1446519319', '0', '0', '16', '38');
INSERT INTO `tbl_in_out_material` VALUES ('42', '0', '10', '4', '0', '0', '172', '0', '0', '0', '', '[\"7\"]', '[{\"id\":\"7\",\"heatnumber\":\"Material Heat 2\",\"designation\":\"Designation 2\",\"quantity\":2,\"quantity_detail\":[{\"quantity\":2,\"length\":\"86\",\"location_id\":\"2\"}],\"length\":172}]', '6', '1447113600', '0', '', '1446521232', '1446521232', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('43', '0', '10', '3', '0', '0', '100', '0', '0', '0', '', '[\"7\"]', '[{\"id\":\"7\",\"heatnumber\":\"Material Heat 2\",\"designation\":\"Designation 2\",\"quantity\":1,\"quantity_detail\":[{\"quantity\":1,\"length\":\"100\",\"location_id\":\"1\"}],\"length\":100}]', '6', '1447718400', '0', '', '1446521310', '1446521310', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('44', '0', '10', '3', '0', '0', '264', '0', '0', '0', '', '[\"7\"]', '[{\"id\":\"7\",\"heatnumber\":\"Material Heat 2\",\"designation\":\"Designation 2\",\"quantity\":3,\"quantity_detail\":[{\"quantity\":3,\"length\":\"88\",\"location_id\":\"3\"}],\"length\":264}]', '6', '1447804800', '0', '', '1446521398', '1446521398', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('45', '0', '10', '3', '0', '0', '700', '0', '0', '0', '', '[\"7\"]', '[{\"id\":\"7\",\"heatnumber\":\"Material Heat 2\",\"designation\":\"Designation 2\",\"quantity\":7,\"quantity_detail\":[{\"quantity\":7,\"length\":100,\"location_id\":\"3\"}],\"length\":700}]', '5', '1446681600', '0', '', '1446534131', '1446534131', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('46', '0', '10', '3', '0', '0', '900', '0', '0', '0', '', '[\"7\"]', '[{\"id\":\"7\",\"heatnumber\":\"Material Heat 2\",\"designation\":\"Designation 2\",\"quantity\":9,\"quantity_detail\":[{\"quantity\":9,\"length\":\"100\",\"location_id\":\"3\"}],\"length\":900}]', '5', '1447891200', '0', '', '1446534335', '1446534335', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('47', '0', '10', '3', '0', '0', '576', '0', '0', '0', '', '[\"7\"]', '[{\"id\":\"7\",\"heatnumber\":\"Material Heat 2\",\"designation\":\"Designation 2\",\"quantity\":8,\"quantity_detail\":[{\"quantity\":8,\"length\":\"72\",\"location_id\":\"3\"}],\"length\":576}]', '5', '1447718400', '0', '', '1446534476', '1446534476', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('48', '0', '10', '3', '0', '0', '792', '0', '0', '0', '', '[\"7\"]', '[{\"id\":\"7\",\"heatnumber\":\"Material Heat 2\",\"designation\":\"Designation 2\",\"quantity\":11,\"quantity_detail\":[{\"quantity\":11,\"length\":\"72\",\"location_id\":\"2\"}],\"length\":792}]', '5', '1448409600', '0', '', '1446535644', '1446535644', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('49', '0', '10', '3', '0', '0', '720', '0', '0', '0', '', '[\"7\"]', '[{\"id\":\"7\",\"heatnumber\":\"Material Heat 2\",\"designation\":\"Designation 2\",\"quantity\":10,\"quantity_detail\":[{\"quantity\":10,\"length\":\"72\",\"location_id\":\"3\"}],\"length\":720}]', '5', '1446508800', '0', '', '1446535924', '1446535924', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('50', '0', '10', '2', '0', '0', '720', '0', '0', '0', '', '[\"7\"]', '[{\"id\":\"7\",\"heatnumber\":\"Material Heat 2\",\"designation\":\"Designation 2\",\"quantity\":10,\"quantity_detail\":[{\"quantity\":10,\"length\":\"72\",\"location_id\":\"2\"}],\"length\":720}]', '6', '1447804800', '0', '<p>Test</p>\n', '1446630097', '1446630097', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('51', '0', '10', '3', '0', '0', '1056', '0', '0', '0', '', '[\"7\"]', '[{\"id\":\"7\",\"heatnumber\":\"Material Heat 2\",\"designation\":\"Designation 2\",\"quantity\":12,\"quantity_detail\":[{\"quantity\":12,\"length\":\"88\",\"location_id\":\"3\"}],\"length\":1056}]', '4', '1447891200', '0', '', '1446630354', '1446630354', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('52', '0', '10', '3', '0', '0', '792', '0', '0', '0', '', '[\"7\"]', '[{\"id\":\"7\",\"heatnumber\":\"Material Heat 2\",\"designation\":\"Designation 2\",\"quantity\":11,\"quantity_detail\":[{\"quantity\":11,\"length\":\"72\",\"location_id\":\"1\"}],\"length\":792}]', '4', '1447804800', '0', '', '1446630675', '1446630675', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('53', '0', '10', '3', '0', '0', '360', '0', '0', '0', '', '[\"7\"]', '[{\"id\":\"7\",\"heatnumber\":\"Material Heat 2\",\"designation\":\"Designation 2\",\"quantity\":5,\"quantity_detail\":[{\"quantity\":5,\"length\":\"72\",\"location_id\":\"1\"}],\"length\":360}]', '5', '1447891200', '0', '', '1446630994', '1446630994', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('55', '0', '24', '4', '0', '0', '500', '0', '0', '0', '', '[\"18\"]', '[{\"id\":\"18\",\"heatnumber\":\"Heatnumber 1\",\"designation\":\"C18\",\"quantity\":5,\"quantity_detail\":[{\"quantity\":5,\"length\":\"100\",\"location_id\":\"3\"}],\"length\":500}]', '5', '1446508800', '0', '<p>Test 1</p>\n', '1446634318', '1446634318', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('56', '0', '24', '2', '0', '0', '500', '0', '0', '0', '', '[\"18\"]', '[{\"id\":\"18\",\"heatnumber\":\"Heatnumber 1\",\"designation\":\"\",\"quantity\":5,\"quantity_detail\":[{\"quantity\":5,\"length\":\"100\",\"location_id\":\"3\"}],\"length\":500}]', '4', '1447200000', '0', '<p>Test 2</p>\n', '1446634355', '1446634355', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('57', '0', '24', '4', '0', '0', '600', '0', '0', '0', '', '[\"18\"]', '[{\"id\":\"18\",\"heatnumber\":\"Heatnumber 1\",\"designation\":\"\",\"quantity\":6,\"quantity_detail\":[{\"quantity\":6,\"length\":\"100\",\"location_id\":\"2\"}],\"length\":600}]', '6', '1447372800', '0', '<p>Test 4</p>\n', '1446634431', '1446634431', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('58', '1', '24', '0', '0', '0', '600', '0', '0', '0', '', '[\"18\"]', '[{\"id\":\"18\",\"heatnumber\":\"Heatnumber 1\",\"designation\":\"\",\"quantity\":6,\"quantity_detail\":[{\"quantity\":6,\"length\":\"100\",\"location_id\":\"3\"}],\"list_length\":[\"100\"],\"length\":600}]', '6', '1446595200', '0', '<p>Test 5</p>\n', '1446634486', '1446634486', '0', '0', '37', '38');
INSERT INTO `tbl_in_out_material` VALUES ('59', '0', '24', '3', '0', '0', '950', '0', '0', '0', '', '[\"19\"]', '[{\"id\":\"19\",\"heatnumber\":\"Heatnumber 2\",\"designation\":\"\",\"quantity\":10,\"quantity_detail\":[{\"quantity\":3,\"length\":\"200\",\"location_id\":\"2\"},{\"quantity\":7,\"length\":\"50\",\"location_id\":\"3\"}],\"length\":950}]', '6', '1447286400', '0', '<p>Test 6</p>\n', '1446634570', '1446634570', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('66', '1', '24', '0', '0', '0', '100', '0', '0', '0', '', '[\"19\"]', '[{\"id\":\"19\",\"heatnumber\":\"Heatnumber 2\",\"designation\":\"\",\"quantity\":2,\"quantity_detail\":[{\"quantity\":2,\"length\":\"50\",\"location_id\":\"3\"}],\"list_length\":[\"200\",\"50\"],\"length\":100}]', '3', '1447286400', '0', '<p>Test 6</p>\n', '1446635597', '1446635597', '0', '0', '38', '18');
INSERT INTO `tbl_in_out_material` VALUES ('67', '0', '24', '3', '0', '0', '400', '0', '0', '0', '', '[\"19\"]', '[{\"id\":\"19\",\"heatnumber\":\"Heatnumber 2\",\"designation\":\"\",\"quantity\":2,\"quantity_detail\":[{\"quantity\":2,\"length\":\"200\",\"location_id\":\"2\"}],\"length\":400}]', '4', '1445990400', '0', '', '1446635679', '1446635679', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('68', '1', '24', '0', '0', '0', '400', '0', '0', '0', '', '[\"19\"]', '[{\"id\":\"19\",\"heatnumber\":\"Heatnumber 2\",\"designation\":\"\",\"quantity\":2,\"quantity_detail\":[{\"length\":\"200\",\"location_id\":\"2\",\"quantity\":2}],\"list_length\":[\"200\",\"50\"],\"length\":400}]', '6', '1448928000', '0', '<p>Test 7</p>\n', '1446635761', '1446635761', '0', '0', '38', '23');
INSERT INTO `tbl_in_out_material` VALUES ('69', '0', '28', '3', '0', '0', '460', '0', '0', '0', '', '[\"20\",\"21\"]', '[{\"id\":\"20\",\"heatnumber\":\"Nov_4_Heat1\",\"designation\":\"C20\",\"quantity\":17,\"quantity_detail\":[{\"quantity\":5,\"length\":\"10\",\"location_id\":\"1\"},{\"quantity\":7,\"length\":\"12\",\"location_id\":\"1\"},{\"quantity\":3,\"length\":\"22\",\"location_id\":\"2\"},{\"quantity\":2,\"length\":\"31\",\"location_id\":\"3\"}],\"length\":262},{\"id\":\"21\",\"heatnumber\":\"Nov_4_Heat2\",\"designation\":\"C21\",\"quantity\":48,\"quantity_detail\":[{\"quantity\":3,\"length\":\"21\",\"location_id\":\"2\"},{\"quantity\":45,\"length\":\"3\",\"location_id\":\"3\"}],\"length\":198}]', '5', '1447804800', '0', '', '1446636328', '1446636328', '0', '1', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('70', '0', '28', '3', '0', '0', '72', '0', '0', '0', '', '[\"21\"]', '[{\"id\":\"21\",\"heatnumber\":\"Nov_4_Heat2\",\"designation\":\"\",\"quantity\":24,\"quantity_detail\":[{\"quantity\":2,\"length\":\"3\",\"location_id\":\"1\"},{\"quantity\":7,\"length\":\"3\",\"location_id\":\"2\"},{\"quantity\":15,\"length\":\"3\",\"location_id\":\"3\"}],\"length\":72}]', '3', '1448496000', '0', '', '1446636543', '1446636543', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('71', '0', '28', '3', '0', '0', '525', '0', '0', '0', '', '[\"21\"]', '[{\"id\":\"21\",\"heatnumber\":\"Nov_4_Heat2\",\"designation\":\"\",\"quantity\":25,\"quantity_detail\":[{\"length\":\"21\",\"location_id\":\"2\",\"quantity\":25}],\"length\":525}]', '2', '1448409600', '0', '', '1446636607', '1446636607', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('72', '1', '28', '0', '0', '0', '168', '0', '0', '0', '', '[\"21\"]', '[{\"id\":\"21\",\"heatnumber\":\"Nov_4_Heat2\",\"designation\":\"\",\"quantity\":8,\"quantity_detail\":[{\"length\":\"21\",\"location_id\":\"2\",\"quantity\":8}],\"list_length\":[\"21\",\"3\"],\"length\":168}]', '5', '1447977600', '0', '', '1446636671', '1446636671', '0', '0', '30', '25');
INSERT INTO `tbl_in_out_material` VALUES ('73', '1', '14', '0', '0', '0', '100', '0', '0', '0', '', '[\"12\"]', '[{\"id\":\"12\",\"heatnumber\":\"Heat 1\",\"designation\":\"B12\",\"quantity\":1,\"quantity_detail\":[{\"quantity\":1,\"length\":\"100\",\"location_id\":\"1\"}],\"list_length\":[\"100\"],\"detail_information\":[{\"location_id\":\"1\",\"location_name\":\"rack 1 | row 1 | box 1\",\"quantity\":\"5\",\"quantity_detail\":[{\"length\":\"100\",\"quantity\":5}]},{\"location_id\":\"2\",\"location_name\":\"rack 2 | row 2 | box 2\",\"quantity\":\"10\",\"quantity_detail\":[{\"length\":\"100\",\"quantity\":10}]}],\"length\":100}]', '5', '1447372800', '0', '', '1447937695', '1447937695', '0', '0', '37', '43');
INSERT INTO `tbl_in_out_material` VALUES ('74', '0', '14', '3', '0', '0', '35', '0', '0', '0', '', '[\"12\"]', '[{\"id\":\"12\",\"heatnumber\":\"Heat 1\",\"designation\":\"\",\"quantity\":1,\"quantity_detail\":[{\"quantity\":1,\"length\":\"35\",\"location_id\":\"1\"}],\"length\":35}]', '7', '1447891200', '0', '', '1447937960', '1447937960', '0', '1', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('75', '0', '35', '3', '0', '0', '787', '0', '0', '0', '', '[\"23\"]', '[{\"id\":\"23\",\"heatnumber\":\"678908\",\"designation\":\"A1689\",\"quantity\":6,\"quantity_detail\":[{\"quantity\":5,\"length\":\"144\",\"location_id\":\"1\"},{\"quantity\":1,\"length\":\"67\",\"location_id\":\"1\"}],\"detail_information\":[],\"length\":787}]', '5', '1447891200', '144', '', '1448016590', '1448016590', '0', '1', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('76', '0', '36', '6', '0', '0', '1498', '0', '0', '0', '', '[\"24\"]', '[{\"id\":\"24\",\"heatnumber\":\"N1B0\",\"designation\":\"A1869\",\"quantity\":11,\"quantity_detail\":[{\"quantity\":10,\"length\":\"145\",\"location_id\":\"17\"},{\"quantity\":1,\"length\":\"48\",\"location_id\":\"17\"}],\"length\":1498}]', '8', '1447891200', '145', '', '1448025256', '1448025256', '0', '1', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('77', '0', '37', '5', '0', '0', '13', '0', '0', '0', '', '[\"25\"]', '[{\"id\":\"25\",\"heatnumber\":\"H9R7\",\"designation\":\"A25\",\"quantity\":2,\"quantity_detail\":[{\"quantity\":2,\"length\":\"6.500\",\"location_id\":\"26\"}],\"length\":13}]', '8', '1447977600', '0', '', '1448025712', '1448025712', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('78', '0', '38', '7', '0', '0', '574.75', '0', '0', '0', '', '[\"26\"]', '[{\"id\":\"26\",\"heatnumber\":\"CH-1118\",\"designation\":\"A26\",\"quantity\":5,\"quantity_detail\":[{\"quantity\":3,\"length\":\"159\",\"location_id\":\"37\"},{\"quantity\":1,\"length\":\"61.75\",\"location_id\":\"37\"},{\"quantity\":1,\"length\":\"36\",\"location_id\":\"37\"}],\"length\":574.75}]', '8', '1447977600', '147', '', '1448027877', '1448027877', '0', '1', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('79', '0', '39', '5', '0', '0', '66', '0', '0', '0', '', '[\"27\"]', '[{\"id\":\"27\",\"heatnumber\":\"9SB0059-G26\",\"designation\":\"A1598\",\"quantity\":1,\"quantity_detail\":[{\"quantity\":1,\"length\":\"66\",\"location_id\":\"40\"}],\"length\":66}]', '8', '1447977600', '148', '', '1448028622', '1448028622', '0', '1', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('80', '0', '39', '5', '0', '0', '720', '0', '0', '0', '', '[\"28\"]', '[{\"id\":\"28\",\"heatnumber\":\"W0Y2\",\"designation\":\"A28\",\"quantity\":5,\"quantity_detail\":[{\"quantity\":5,\"length\":\"144\",\"location_id\":\"36\"}],\"length\":720}]', '8', '1447977600', '149', '', '1448028983', '1448028983', '0', '1', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('81', '0', '40', '8', '0', '0', '48', '0', '0', '0', '', '[\"29\"]', '[{\"id\":\"29\",\"heatnumber\":\"E120244\",\"designation\":\"A1847\",\"quantity\":1,\"quantity_detail\":[{\"quantity\":1,\"length\":\"48\",\"location_id\":\"25\"}],\"length\":48}]', '8', '1447977600', '150', '', '1448029440', '1448029440', '0', '1', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('82', '0', '40', '5', '0', '0', '146', '0', '0', '0', '', '[\"30\"]', '[{\"id\":\"30\",\"heatnumber\":\"35454\",\"designation\":\"A30\",\"quantity\":1,\"quantity_detail\":[{\"quantity\":1,\"length\":\"146\",\"location_id\":\"24\"}],\"length\":146}]', '8', '1447977600', '151', '', '1448029604', '1448029604', '0', '1', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('83', '0', '39', '5', '0', '0', '7', '0', '0', '0', '', '[\"31\"]', '[{\"id\":\"31\",\"heatnumber\":\"3Q384\",\"designation\":\"A1822\",\"quantity\":1,\"quantity_detail\":[{\"quantity\":1,\"length\":\"7\",\"location_id\":\"27\"}],\"length\":7}]', '8', '1447977600', '152', '', '1448029838', '1448029838', '0', '1', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('84', '0', '41', '5', '0', '0', '9', '0', '0', '0', '', '[\"32\"]', '[{\"id\":\"32\",\"heatnumber\":\"2U288\",\"designation\":\"A1196\",\"quantity\":2,\"quantity_detail\":[{\"quantity\":2,\"length\":\"4.5\",\"location_id\":\"26\"}],\"length\":9}]', '8', '1447977600', '153', '', '1448030083', '1448030083', '0', '1', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('85', '0', '42', '9', '0', '0', '432', '0', '0', '0', '', '[\"33\"]', '[{\"id\":\"33\",\"heatnumber\":\"H9R9\",\"designation\":\"A33\",\"quantity\":3,\"quantity_detail\":[{\"quantity\":3,\"length\":\"144\",\"location_id\":\"27\"}],\"length\":432}]', '8', '1447977600', '154', '', '1448031562', '1448031562', '0', '1', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('86', '0', '55', '10', '0', '0', '120', '0', '0', '0', '', '[\"34\"]', '[{\"id\":\"34\",\"heatnumber\":\"NULL\",\"designation\":\"-\",\"quantity\":5,\"quantity_detail\":[{\"quantity\":5,\"length\":\"24\",\"location_id\":\"150\"}],\"length\":120}]', '9', '1450051200', '0', '<p>NO HEAT NUMBER. MATERIAL PURCHASED FOR MACHINE TESTING. TO BE USED FOR TOOLNG.</p>\n', '1450096815', '1450096815', '0', '1', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('87', '0', '56', '10', '0', '0', '48', '0', '0', '0', '', '[\"35\"]', '[{\"id\":\"35\",\"heatnumber\":\"NULL\",\"designation\":\"-\",\"quantity\":2,\"quantity_detail\":[{\"quantity\":2,\"length\":\"24\",\"location_id\":\"150\"}],\"length\":48}]', '9', '1450051200', '0', '<p>MAZAK TESTING. NO HEAT. TOOLING ONLY.</p>\n', '1450101032', '1450101032', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('88', '0', '57', '10', '0', '0', '120', '0', '0', '0', '', '[\"36\"]', '[{\"id\":\"36\",\"heatnumber\":\"NULL\",\"designation\":\"-\",\"quantity\":5,\"quantity_detail\":[{\"quantity\":5,\"length\":\"24\",\"location_id\":\"150\"}],\"length\":120}]', '9', '1450051200', '0', '<p>MAZAK TESTING MATERIAL. NO HEAT. TOOLING ONLY.</p>\n', '1450101392', '1450101392', '0', '1', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('89', '0', '58', '10', '0', '0', '140', '0', '0', '0', '', '[\"37\"]', '[{\"id\":\"37\",\"heatnumber\":\"NULL\",\"designation\":\"-\",\"quantity\":6,\"quantity_detail\":[{\"quantity\":5,\"length\":\"24\",\"location_id\":\"150\"},{\"quantity\":1,\"length\":\"20\",\"location_id\":\"150\"}],\"length\":140}]', '9', '1450051200', '0', '<p>MAZAK TESTING. NO HEAT. TOOLING ONLY</p>\n', '1450101686', '1450101686', '0', '1', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('90', '0', '59', '11', '0', '0', '0', '0', '0', '0', '', '[\"38\"]', '[{\"id\":\"38\",\"heatnumber\":\"1-11-1-1\",\"designation\":\"B299\",\"quantity\":0,\"quantity_detail\":[]}]', '9', '1450051200', '177', '', '1450109786', '1450109786', '0', '1', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('91', '0', '59', '11', '0', '0', '8', '0', '0', '0', '', '[\"38\"]', '[{\"id\":\"38\",\"heatnumber\":\"1-11-1-1\",\"designation\":\"B299\",\"quantity\":2,\"quantity_detail\":[{\"quantity\":2,\"length\":\"4\",\"location_id\":\"135\"}],\"length\":8}]', '9', '1450051200', '178', '', '1450110096', '1450110096', '0', '1', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('92', '0', '59', '11', '0', '0', '2', '0', '0', '0', '', '[\"38\"]', '[{\"id\":\"38\",\"heatnumber\":\"1-11-1-1\",\"designation\":\"B299\",\"quantity\":1,\"quantity_detail\":[{\"quantity\":1,\"length\":\"2\",\"location_id\":\"135\"}],\"length\":2}]', '9', '1450051200', '181', '', '1450110932', '1450110932', '0', '1', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('93', '0', '60', '11', '0', '0', '4.5', '0', '0', '0', '', '[\"39\"]', '[{\"id\":\"39\",\"heatnumber\":\"MA1568\",\"designation\":\"B099\",\"quantity\":1,\"quantity_detail\":[{\"quantity\":1,\"length\":\"4.5\",\"location_id\":\"136\"}],\"length\":4.5}]', '9', '1450051200', '183', '', '1450111520', '1450111520', '0', '1', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('94', '0', '61', '11', '0', '0', '1.625', '0', '0', '0', '', '[\"41\"]', '[{\"id\":\"41\",\"heatnumber\":\"129401.12.1\",\"designation\":\"B248\",\"quantity\":1,\"quantity_detail\":[{\"quantity\":1,\"length\":\"1.625\",\"location_id\":\"136\"}],\"length\":1.625}]', '9', '1450051200', '0', '<p>MILL CERT. FILE EXCEEDED MAX CAPACITY. DESIGNATION B248</p>\n', '1450112074', '1450112074', '0', '1', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('95', '0', '61', '11', '0', '0', '3', '0', '0', '0', '', '[\"40\"]', '[{\"id\":\"40\",\"heatnumber\":\"1504102911\",\"designation\":\"B327\",\"quantity\":1,\"quantity_detail\":[{\"quantity\":1,\"length\":\"3\",\"location_id\":\"136\"}],\"length\":3}]', '9', '1450051200', '184', '', '1450112159', '1450112159', '0', '1', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('96', '0', '62', '11', '0', '0', '1', '0', '0', '0', '', '[\"42\"]', '[{\"id\":\"42\",\"heatnumber\":\"150410388\",\"designation\":\"B329\",\"quantity\":1,\"quantity_detail\":[{\"quantity\":1,\"length\":\"1\",\"location_id\":\"136\"}],\"length\":1}]', '9', '1450051200', '185', '', '1450112479', '1450112479', '0', '1', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('97', '0', '63', '11', '0', '0', '1', '0', '0', '0', '', '[\"43\"]', '[{\"id\":\"43\",\"heatnumber\":\"C15908\\/1-2\",\"designation\":\"B289\",\"quantity\":1,\"quantity_detail\":[{\"quantity\":1,\"length\":\"1\",\"location_id\":\"137\"}],\"length\":1}]', '9', '1450051200', '186', '', '1450114537', '1450114537', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('98', '0', '63', '11', '0', '0', '3', '0', '0', '0', '', '[\"44\"]', '[{\"id\":\"44\",\"heatnumber\":\"1-5-1-1\",\"designation\":\"B191\",\"quantity\":1,\"quantity_detail\":[{\"quantity\":1,\"length\":\"3\",\"location_id\":\"137\"}],\"length\":3}]', '9', '1450051200', '187', '', '1450114710', '1450114710', '0', '1', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('99', '0', '63', '11', '0', '0', '3', '0', '0', '0', '', '[\"43\"]', '[{\"id\":\"43\",\"heatnumber\":\"C15908\\/1-2\",\"designation\":\"B289\",\"quantity\":1,\"quantity_detail\":[{\"quantity\":1,\"length\":\"3\",\"location_id\":\"137\"}],\"length\":3}]', '9', '1450051200', '188', '', '1450114801', '1450114801', '0', '1', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('100', '0', '64', '11', '0', '0', '2.25', '0', '0', '0', '', '[\"45\"]', '[{\"id\":\"45\",\"heatnumber\":\"1-3-1-1\",\"designation\":\"B175\",\"quantity\":1,\"quantity_detail\":[{\"quantity\":1,\"length\":\"2.250\",\"location_id\":\"138\"}],\"length\":2.25}]', '9', '1450051200', '189', '', '1450115110', '1450115110', '0', '1', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('101', '0', '65', '5', '0', '0', '3', '0', '0', '0', '', '[\"47\"]', '[{\"id\":\"47\",\"heatnumber\":\"2JN7\",\"designation\":\"A886\",\"quantity\":1,\"quantity_detail\":[{\"quantity\":1,\"length\":\"3\",\"location_id\":\"139\"}],\"length\":3}]', '9', '1450051200', '190', '', '1450116496', '1450116496', '0', '1', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('106', '0', '65', '5', '0', '0', '5.5', '0', '0', '0', '', '[\"46\"]', '[{\"id\":\"46\",\"heatnumber\":\"D1A7\",\"designation\":\"A1444\",\"quantity\":1,\"quantity_detail\":[{\"quantity\":1,\"length\":\"5.500\",\"location_id\":\"139\"}],\"length\":5.5}]', '9', '1450051200', '193', '', '1450117389', '1450117389', '0', '1', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('107', '0', '65', '5', '0', '0', '5.25', '0', '0', '0', '', '[\"48\"]', '[{\"id\":\"48\",\"heatnumber\":\"252354\",\"designation\":\"A1783\",\"quantity\":1,\"quantity_detail\":[{\"quantity\":1,\"length\":\"5.250\",\"location_id\":\"139\"}],\"length\":5.25}]', '9', '1450051200', '194', '', '1450117484', '1450117484', '0', '1', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('108', '0', '66', '5', '0', '0', '1.75', '0', '0', '0', '', '[\"49\"]', '[{\"id\":\"49\",\"heatnumber\":\"5KC2\",\"designation\":\"A1663\",\"quantity\":1,\"quantity_detail\":[{\"quantity\":1,\"length\":\"1.750\",\"location_id\":\"139\"}],\"length\":1.75}]', '9', '1450051200', '195', '', '1450117783', '1450117783', '0', '1', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('109', '0', '67', '5', '0', '0', '2', '0', '0', '0', '', '[\"50\"]', '[{\"id\":\"50\",\"heatnumber\":\"FS4876\",\"designation\":\"A747\",\"quantity\":1,\"quantity_detail\":[{\"quantity\":1,\"length\":\"2.00\",\"location_id\":\"139\"}],\"length\":2}]', '9', '1450051200', '196', '', '1450118011', '1450118011', '0', '1', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('110', '0', '68', '5', '0', '0', '6.5', '0', '0', '0', '', '[\"51\"]', '[{\"id\":\"51\",\"heatnumber\":\"E43324\",\"designation\":\"A726\",\"quantity\":1,\"quantity_detail\":[{\"quantity\":1,\"length\":\"6.500\",\"location_id\":\"140\"}],\"length\":6.5}]', '9', '1450051200', '197', '', '1450118353', '1450118353', '0', '1', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('111', '0', '65', '5', '0', '0', '10', '0', '0', '0', '', '[\"52\"]', '[{\"id\":\"52\",\"heatnumber\":\"H2D4\",\"designation\":\"A1557\",\"quantity\":2,\"quantity_detail\":[{\"quantity\":2,\"length\":\"5\",\"location_id\":\"140\"}],\"length\":10}]', '9', '1450051200', '198', '', '1450118559', '1450118559', '0', '1', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('112', '0', '69', '5', '0', '0', '6', '0', '0', '0', '', '[\"53\"]', '[{\"id\":\"53\",\"heatnumber\":\"D2K4\",\"designation\":\"A1455\",\"quantity\":1,\"quantity_detail\":[{\"quantity\":1,\"length\":\"6.000\",\"location_id\":\"141\"}],\"length\":6}]', '9', '1450051200', '199', '', '1450118839', '1450118839', '0', '1', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('113', '0', '34', '5', '0', '0', '54', '0', '0', '0', '', '[\"54\"]', '[{\"id\":\"54\",\"heatnumber\":\"100084\",\"designation\":\"A54\",\"quantity\":1,\"quantity_detail\":[{\"quantity\":1,\"length\":\"54\",\"location_id\":\"1\"}],\"length\":54}]', '9', '1450137600', '0', '', '1450270020', '1450270020', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('115', '0', '22', '5', '0', '0', '1728', '0', '0', '0', '', '[\"55\"]', '[{\"id\":\"55\",\"heatnumber\":\"w4w9\",\"designation\":\"C55\",\"quantity\":12,\"quantity_detail\":[{\"quantity\":12,\"length\":\"144\",\"location_id\":\"154\"}],\"length\":1728}]', '9', '1450224000', '0', '', '1450270993', '1450270993', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('116', '0', '32', '5', '0', '0', '720', '0', '0', '0', '', '[\"56\"]', '[{\"id\":\"56\",\"heatnumber\":\"w4w9\",\"designation\":\"A56\",\"quantity\":5,\"quantity_detail\":[{\"quantity\":5,\"length\":\"144\",\"location_id\":\"154\"}],\"length\":720}]', '9', '1450224000', '0', '', '1450275387', '1450275387', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('117', '1', '32', '0', '0', '0', '720', '0', '0', '0', '', '[\"56\"]', '[{\"id\":\"56\",\"heatnumber\":\"w4w9\",\"quantity\":5,\"list_length\":[\"144\"],\"quantity_detail\":[{\"quantity\":5,\"length\":\"144\",\"location_id\":\"154\"}],\"length\":720}]', '9', '1450828800', '0', '', '1450877065', '1450877065', '0', '0', '44', '43');
INSERT INTO `tbl_in_out_material` VALUES ('120', '0', '32', '5', '0', '0', '60', '0', '0', '0', '', '[\"56\"]', '[{\"id\":\"56\",\"heatnumber\":\"W4W9\",\"designation\":\"\",\"quantity\":4,\"quantity_detail\":[{\"quantity\":4,\"length\":\"15\",\"location_id\":\"\"}],\"length\":60}]', '9', '1450828800', '0', '', '1450877625', '1450877625', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('121', '0', '70', '5', '0', '0', '3.5', '0', '0', '0', '', '[\"57\"]', '[{\"id\":\"57\",\"heatnumber\":\"83622\",\"designation\":\"A1284\",\"quantity\":1,\"quantity_detail\":[{\"quantity\":1,\"length\":\"3.5\",\"location_id\":\"141\"}],\"length\":3.5}]', '9', '1451865600', '0', '', '1451923023', '1451923023', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('122', '0', '71', '5', '0', '0', '2', '0', '0', '0', '', '[\"58\"]', '[{\"id\":\"58\",\"heatnumber\":\"252352\",\"designation\":\"A1345\",\"quantity\":1,\"quantity_detail\":[{\"quantity\":1,\"length\":\"2\",\"location_id\":\"141\"}],\"length\":2}]', '9', '1451865600', '0', '', '1451923320', '1451923320', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('123', '0', '70', '5', '0', '0', '24.5', '0', '0', '0', '', '[\"57\"]', '[{\"id\":\"57\",\"heatnumber\":\"83622\",\"designation\":\"A1284\",\"quantity\":7,\"quantity_detail\":[{\"quantity\":7,\"length\":\"3.5\",\"location_id\":\"141\"}],\"length\":24.5}]', '11', '1452643200', '0', '', '1453051572', '1453051572', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('124', '0', '69', '5', '0', '0', '1', '0', '0', '0', '', '[null]', '[{\"heatnumber\":\"A7B6\",\"designation\":\"\",\"quantity\":1,\"quantity_detail\":[{\"quantity\":1,\"length\":\"1\",\"location_id\":\"142\"}],\"length\":1}]', '9', '1453766400', '0', '', '1453822491', '1453822491', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('125', '0', '69', '5', '0', '0', '1', '0', '0', '0', '', '[\"59\"]', '[{\"id\":\"59\",\"heatnumber\":\"A7B6\",\"designation\":\"C1353\",\"quantity\":1,\"quantity_detail\":[{\"quantity\":1,\"length\":\"1\",\"location_id\":\"142\"}],\"length\":1}]', '9', '1453766400', '0', '', '1453822815', '1453822815', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('126', '0', '71', '5', '0', '0', '2.75', '0', '0', '0', '', '[\"60\"]', '[{\"id\":\"60\",\"heatnumber\":\"62121\",\"designation\":\"A608\",\"quantity\":1,\"quantity_detail\":[{\"quantity\":1,\"length\":\"2.75\",\"location_id\":\"142\"}],\"length\":2.75}]', '9', '1453766400', '0', '', '1453822987', '1453822987', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('127', '0', '71', '5', '0', '0', '1.5', '0', '0', '0', '', '[\"61\"]', '[{\"id\":\"61\",\"heatnumber\":\"98006\",\"designation\":\"A1873\",\"quantity\":1,\"quantity_detail\":[{\"quantity\":1,\"length\":\"1.5\",\"location_id\":\"142\"}],\"length\":1.5}]', '9', '1453766400', '0', '', '1453823093', '1453823093', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('128', '0', '26', '11', '0', '0', '3', '0', '0', '0', '', '[\"62\"]', '[{\"id\":\"62\",\"heatnumber\":\"12808831\",\"designation\":\"B242\",\"quantity\":1,\"quantity_detail\":[{\"quantity\":1,\"length\":\"3\",\"location_id\":\"145\"}],\"length\":3}]', '9', '1453766400', '0', '', '1453823549', '1453823549', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('129', '0', '26', '11', '0', '0', '11.25', '0', '0', '0', '', '[\"63\"]', '[{\"id\":\"63\",\"heatnumber\":\"H202660\",\"designation\":\"B193\",\"quantity\":5,\"quantity_detail\":[{\"quantity\":5,\"length\":\"2.250\",\"location_id\":\"145\"}],\"length\":11.25}]', '9', '1453766400', '0', '', '1453823696', '1453823696', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('130', '0', '30', '10', '0', '0', '800', '0', '0', '0', '', '[\"22\",null]', '[{\"heatnumber\":\"Heatnumber 25022016_3\",\"designation\":\"NN3\",\"quantity\":5,\"quantity_detail\":[{\"quantity\":5,\"length\":\"100\",\"location_id\":\"1\"}],\"length\":500},{\"id\":\"22\",\"heatnumber\":\"Heat1_HVD_NOV_11\",\"designation\":\"B22\",\"quantity\":6,\"quantity_detail\":[{\"quantity\":6,\"length\":\"50\",\"location_id\":\"1\"}],\"length\":300}]', '13', '1454371200', '0', '<p>Nam check in 1</p>\n', '1456389805', '1456389805', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('131', '0', '30', '10', '0', '0', '150', '0', '0', '0', '', '[\"22\",\"64\"]', '[{\"id\":\"64\",\"heatnumber\":\"Heatnumber 25022016_3\",\"designation\":\"NN3\",\"quantity\":2,\"quantity_detail\":[{\"quantity\":2,\"length\":\"50\",\"location_id\":\"1\"}],\"length\":100},{\"id\":\"22\",\"heatnumber\":\"Heat1_HVD_NOV_11\",\"designation\":\"B22\",\"quantity\":1,\"quantity_detail\":[{\"quantity\":1,\"length\":\"50\",\"location_id\":\"\"}],\"length\":50}]', '13', '1454284800', '0', '<p>Nam check in 2</p>\n', '1456389935', '1456389935', '0', '0', '0', '0');
INSERT INTO `tbl_in_out_material` VALUES ('132', '2', '14', '0', '0', '0', '70', '0', '0', '0', '', '[\"12\"]', '[{\"id\":\"12\",\"heatnumber\":\"Heat 1\",\"quantity\":2,\"list_length\":[\"100\",\"35\"],\"quantity_detail\":[{\"quantity\":2,\"length\":\"35\",\"location_id\":\"2\"}],\"length\":70}]', '14', '1454371200', '0', '<p>Nam return 1</p>\n', '1456390646', '1456390646', '0', '0', '48', '64');
INSERT INTO `tbl_in_out_material` VALUES ('133', '1', '28', '0', '0', '0', '0', '0', '0', '0', '', '[\"21\"]', '[{\"id\":\"21\",\"heatnumber\":\"Nov_4_Heat2\",\"designation\":\"C21\",\"quantity\":0,\"quantity_detail\":[],\"list_length\":[\"21\",\"3\"]}]', '4', '1455148800', '0', '', '1456399046', '1456399046', '0', '0', '48', '64');
INSERT INTO `tbl_in_out_material` VALUES ('136', '1', '70', '0', '0', '0', '3.5', '0', '0', '0', '', '[\"57\"]', '[{\"id\":\"57\",\"heatnumber\":\"83622\",\"designation\":\"A1284\",\"quantity\":1,\"quantity_detail\":[{\"quantity\":1,\"length\":\"3.5\",\"location_id\":\"141\"}],\"list_length\":[\"3.5\"],\"length\":3.5}]', '11', '1457654400', '0', '', '1457695767', '1457695767', '0', '0', '47', '59');
INSERT INTO `tbl_in_out_material` VALUES ('137', '1', '70', '0', '0', '0', '7', '0', '0', '0', '', '[\"57\"]', '[{\"id\":\"57\",\"heatnumber\":\"83622\",\"designation\":\"A1284\",\"quantity\":2,\"quantity_detail\":[{\"quantity\":2,\"length\":\"3.5\",\"location_id\":\"141\"}],\"list_length\":[\"3.5\"],\"length\":7}]', '9', '1457654400', '0', '', '1457695969', '1457695969', '0', '0', '49', '59');
INSERT INTO `tbl_in_out_material` VALUES ('139', '0', '46', '3', '0', '0', '96.4', '0', '0', '0', '', '[\"81\"]', '[{\"id\":\"81\",\"heatnumber\":\"100KCHROME\",\"designation\":\"C81\",\"quantity\":2,\"quantity_detail\":[{\"quantity\":2,\"length\":\"48.2\",\"location_id\":\"154\"}],\"length\":96.4}]', '11', '1457481600', '0', '', '1457794821', '1457794821', '0', '1', '0', '0');

-- ----------------------------
-- Table structure for tbl_in_out_part
-- ----------------------------
DROP TABLE IF EXISTS `tbl_in_out_part`;
CREATE TABLE `tbl_in_out_part` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) NOT NULL,
  `part_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `location_ids` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL,
  `heatnumber_ids` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `heatnumbers` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `received_by` int(11) NOT NULL,
  `received_date` int(11) NOT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_time` int(11) NOT NULL,
  `created_time` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `purchase_order_id` int(11) NOT NULL,
  `coc_files` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of tbl_in_out_part
-- ----------------------------
INSERT INTO `tbl_in_out_part` VALUES ('1', '0', '21', '0', '[\"1\"]', '[\"4\"]', '[{\"id\":\"4\",\"heatnumber\":\"Part Heat 1\",\"drawing\":\"Drawing 1\",\"quantity\":15}]', '0', '1438300800', 'HUNG', '1438139338', '1438139338', '0', '0', '');
INSERT INTO `tbl_in_out_part` VALUES ('2', '0', '21', '0', '[\"1\"]', '[\"4\"]', '[{\"id\":\"4\",\"heatnumber\":\"Part Heat 1\",\"drawing\":\"Drawing 1\",\"quantity\":7}]', '0', '1438214400', 'dđ', '1438139384', '1438139384', '0', '0', '');
INSERT INTO `tbl_in_out_part` VALUES ('3', '1', '21', '0', '[\"1\"]', '[\"4\"]', '[{\"id\":\"4\",\"heatnumber\":\"Part Heat 1\",\"drawing\":\"Drawing 1\",\"quantity\":10}]', '0', '1438214400', 'hug', '1438139594', '1438139594', '0', '0', '');
INSERT INTO `tbl_in_out_part` VALUES ('4', '0', '21', '0', '[\"1\"]', '[\"4\"]', '[{\"id\":\"4\",\"heatnumber\":\"Part Heat 1\",\"drawing\":\"Drawing 1\",\"quantity\":13}]', '0', '1437436800', 'Nam nt', '1438161490', '1438161490', '0', '0', '');
INSERT INTO `tbl_in_out_part` VALUES ('5', '0', '21', '0', '', '[\"4\"]', '[{\"id\":\"4\",\"heatnumber\":\"Part Heat 1\",\"drawing\":\"Drawing 1\",\"quantity\":0}]', '0', '1438300800', '', '1438316577', '1438316577', '0', '0', '');
INSERT INTO `tbl_in_out_part` VALUES ('7', '0', '21', '0', '', '[\"4\"]', '[{\"id\":\"4\",\"heatnumber\":\"Part Heat 1\",\"drawing\":\"Drawing 1\",\"quantity\":-1}]', '0', '1438300800', '', '1438316741', '1438316741', '0', '0', '');
INSERT INTO `tbl_in_out_part` VALUES ('8', '0', '21', '0', '[\"2\"]', '[null]', '[{\"heatnumber\":\"#1035\",\"drawing\":\"Dr9098\",\"quantity\":10}]', '0', '1438300800', '', '1438316908', '1438316908', '0', '0', '');
INSERT INTO `tbl_in_out_part` VALUES ('9', '0', '21', '0', '[\"2\"]', '[null]', '[{\"heatnumber\":\"#1035\",\"drawing\":\"Dr9098\",\"quantity\":10}]', '0', '1438300800', '', '1438316921', '1438316921', '0', '0', '');
INSERT INTO `tbl_in_out_part` VALUES ('10', '0', '21', '0', '[\"1\"]', '[\"5\"]', '[{\"id\":\"5\",\"heatnumber\":\"#1035\",\"drawing\":\"Dr9098\",\"quantity\":10}]', '0', '1438300800', '', '1438316954', '1438316954', '0', '0', '');
INSERT INTO `tbl_in_out_part` VALUES ('11', '0', '21', '0', '[\"1\"]', '[\"4\",\"5\"]', '[{\"id\":\"4\",\"heatnumber\":\"Part Heat 1\",\"drawing\":\"Drawing 1\",\"quantity\":10},{\"id\":\"5\",\"heatnumber\":\"#1035\",\"drawing\":\"Dr9098\",\"quantity\":5}]', '0', '1438387200', 'HUNG Checks in 15', '1438482348', '1438482348', '0', '0', '');
INSERT INTO `tbl_in_out_part` VALUES ('14', '1', '21', '0', '[\"1\"]', '[\"4\",\"5\"]', '[{\"id\":\"4\",\"heatnumber\":\"Part Heat 1\",\"drawing\":\"Drawing 1\",\"quantity\":9},{\"id\":\"5\",\"heatnumber\":\"#1035\",\"drawing\":\"Dr9098\",\"quantity\":4}]', '0', '1441065600', 'HUNG does check-out', '1438482452', '1438482452', '0', '0', '');
INSERT INTO `tbl_in_out_part` VALUES ('15', '0', '21', '0', '[\"1\"]', '[\"5\"]', '[{\"id\":\"5\",\"heatnumber\":\"#1035\",\"drawing\":\"Dr9098\",\"quantity\":8}]', '0', '1438905600', 'HUNG checks in 8', '1438933187', '1438933187', '0', '0', '');
INSERT INTO `tbl_in_out_part` VALUES ('16', '0', '19', '0', '[\"2\"]', '[null]', '[{\"heatnumber\":\"456356\",\"drawing\":\"\",\"quantity\":100}]', '0', '1438819200', '', '1439379786', '1439379786', '0', '0', '');
INSERT INTO `tbl_in_out_part` VALUES ('17', '0', '19', '0', '[\"2\"]', '[null]', '[{\"heatnumber\":\"456356\",\"drawing\":\"\",\"quantity\":100}]', '0', '1439424000', '', '1439379801', '1439379801', '0', '0', '');
INSERT INTO `tbl_in_out_part` VALUES ('18', '0', '19', '0', '[\"1\"]', '[null]', '[{\"heatnumber\":\"456356\",\"drawing\":\"\",\"quantity\":100}]', '0', '1439424000', '', '1439379809', '1439379809', '0', '0', '');
INSERT INTO `tbl_in_out_part` VALUES ('19', '0', '19', '0', '[\"1\"]', '[null]', '[{\"heatnumber\":\"456356\",\"drawing\":\"\",\"quantity\":50}]', '0', '1439424000', '', '1439379816', '1439379816', '0', '0', '');
INSERT INTO `tbl_in_out_part` VALUES ('20', '0', '19', '0', '[\"1\"]', '[\"7\"]', '[{\"id\":\"7\",\"heatnumber\":\"456356\",\"drawing\":\"566345\",\"quantity\":0}]', '0', '1439251200', '', '1439379867', '1439379867', '0', '0', '');
INSERT INTO `tbl_in_out_part` VALUES ('21', '0', '19', '0', '[\"1\"]', '[\"7\"]', '[{\"id\":\"7\",\"heatnumber\":\"456356\",\"quantity\":6}]', '0', '1439510400', '', '1439597302', '1439597302', '0', '0', '');
INSERT INTO `tbl_in_out_part` VALUES ('22', '0', '19', '0', '[\"1\"]', '[\"7\"]', '[{\"id\":\"7\",\"heatnumber\":\"456356\",\"drawing\":\"566345\",\"quantity\":10}]', '0', '1439510400', '', '1439597357', '1439597357', '0', '0', '');
INSERT INTO `tbl_in_out_part` VALUES ('23', '0', '21', '0', '[\"3\"]', '[\"5\"]', '[{\"id\":\"5\",\"heatnumber\":\"#1035\",\"drawing\":\"Dr9098\",\"quantity\":4}]', '0', '1439856000', '', '1439649835', '1439649835', '0', '0', '');
INSERT INTO `tbl_in_out_part` VALUES ('24', '0', '21', '0', '[\"3\"]', '[\"5\"]', '[{\"id\":\"5\",\"heatnumber\":\"#1035\",\"drawing\":\"Dr9098\",\"quantity\":13}]', '0', '1439596800', '', '1439650645', '1439650645', '0', '0', '');
INSERT INTO `tbl_in_out_part` VALUES ('25', '1', '21', '0', '[\"2\"]', '[\"5\"]', '[{\"id\":\"5\",\"heatnumber\":\"#1035\",\"drawing\":\"Dr9098\",\"quantity\":2}]', '1', '1441065600', 'Nam Nguyen 1', '1441691402', '1441691402', '0', '4', '');
INSERT INTO `tbl_in_out_part` VALUES ('27', '1', '21', '0', '[\"1\"]', '[\"4\"]', '[{\"id\":\"4\",\"heatnumber\":\"Part Heat 1\",\"drawing\":\"Drawing 1\",\"quantity\":5}]', '4', '1442016000', 'Hung tests checking out', '1441888661', '1441888661', '0', '4', '');
INSERT INTO `tbl_in_out_part` VALUES ('28', '1', '19', '0', '[\"1\"]', '[\"7\"]', '[{\"id\":\"7\",\"heatnumber\":\"456356\",\"drawing\":\"566345\",\"quantity\":10}]', '1', '1441843200', '', '1442074818', '1442074818', '0', '4', '');
INSERT INTO `tbl_in_out_part` VALUES ('29', '0', '22', '0', '', '[\"8\"]', '[{\"id\":\"8\",\"heatnumber\":\"Heat A\",\"drawing\":\"D\",\"quantity\":13,\"quantity_detail\":{\"2\":13}}]', '1', '1444003200', '<p>Nam test 2</p>\n', '1444589063', '1444589063', '0', '0', '');
INSERT INTO `tbl_in_out_part` VALUES ('30', '0', '35', '0', '', '[\"11\"]', '[{\"id\":\"11\",\"heatnumber\":\"Heat number A\",\"drawing\":\"Design A\",\"quantity\":17,\"quantity_details\":[\"2\",\"3\"],\"quantity_detail\":{\"2\":12,\"3\":5}}]', '1', '1445126400', '<p>Check in Part by NamNT 18102015 - 1st</p>\n', '1445135215', '1445135215', '0', '0', '');
INSERT INTO `tbl_in_out_part` VALUES ('31', '0', '35', '0', '', '[\"11\"]', '[{\"id\":\"11\",\"heatnumber\":\"Heat number A\",\"drawing\":\"Design A\",\"quantity\":12,\"quantity_details\":[\"2\"],\"quantity_detail\":{\"2\":12}}]', '1', '1444176000', '<p>Nam test 1st</p>\n', '1445241141', '1445241141', '0', '0', '');
INSERT INTO `tbl_in_out_part` VALUES ('32', '0', '36', '0', '', '[\"14\"]', '[{\"id\":\"14\",\"heatnumber\":\"Heat number 1\",\"drawing\":\"Drawing 1\",\"quantity\":15,\"quantity_details\":[{\"quantity\":10,\"location_id\":\"2\"},{\"quantity\":5,\"location_id\":\"1\"}]}]', '1', '1444176000', '<p>Nam nguyen test 1st</p>\n', '1445684731', '1445684731', '0', '0', '');
INSERT INTO `tbl_in_out_part` VALUES ('33', '0', '36', '0', '', '[\"14\"]', '[{\"id\":\"14\",\"heatnumber\":\"Heat number 1\",\"quantity\":4,\"quantity_details\":[{\"quantity\":4,\"location_id\":\"1\"}]}]', '4', '1444867200', '<p>Hung tests Checkin</p>\n', '1445764188', '1445764188', '0', '0', '');
INSERT INTO `tbl_in_out_part` VALUES ('34', '1', '36', '0', '', '[\"14\"]', '[{\"id\":\"14\",\"heatnumber\":\"Heat number 1\",\"quantity\":4,\"quantity_details\":[{\"quantity\":4,\"location_id\":\"2\"}]}]', '4', '1446163200', '<p>Hung checks out</p>\n', '1445764234', '1445764234', '0', '3', '');
INSERT INTO `tbl_in_out_part` VALUES ('35', '0', '19', '0', '', '[\"7\"]', '[{\"id\":\"7\",\"heatnumber\":\"456356\",\"quantity\":50,\"quantity_details\":[{\"quantity\":50,\"location_id\":\"1\"}]}]', '1', '1445990400', '', '1445948777', '1445948777', '0', '0', '');
INSERT INTO `tbl_in_out_part` VALUES ('41', '0', '6', '0', '', '[\"16\"]', '[{\"id\":\"16\",\"heatnumber\":\"789345\",\"drawing\":\"A567\",\"quantity\":100,\"quantity_details\":[{\"quantity\":100,\"location_id\":\"2\"}]}]', '2', '1445904000', '', '1445949238', '1445949238', '0', '0', '');
INSERT INTO `tbl_in_out_part` VALUES ('63', '1', '21', '0', '', '[\"4\"]', '[{\"id\":\"4\",\"heatnumber\":\"Part Heat 1\",\"quantity\":2,\"quantity_details\":[{\"quantity\":2,\"location_id\":\"1\"}]}]', '5', '1446508800', '', '1446584324', '1446584324', '0', '3', '[\"\\/server\\/data\\/pdf\\/COC_newpart10_Part_Heat_1_20151103_63.pdf\"]');
INSERT INTO `tbl_in_out_part` VALUES ('64', '0', '21', '0', '', '[\"4\"]', '[{\"id\":\"4\",\"heatnumber\":\"Part Heat 1\",\"drawing\":\"Drawing 1\",\"quantity\":50,\"quantity_details\":[{\"quantity\":50,\"location_id\":\"1\"}]}]', '5', '1446508800', '', '1446584413', '1446584413', '0', '0', '');
INSERT INTO `tbl_in_out_part` VALUES ('67', '1', '21', '0', '', '[\"4\"]', '[{\"id\":\"4\",\"heatnumber\":\"Part Heat 1\",\"quantity\":0,\"quantity_details\":[{\"quantity\":\"\",\"location_id\":\"1\"}]}]', '4', '1446681600', '', '1446916278', '1446916278', '0', '4', '');
INSERT INTO `tbl_in_out_part` VALUES ('70', '0', '31', '0', '', '[\"17\"]', '[{\"id\":\"17\",\"heatnumber\":\"NYLON BLUE\",\"drawing\":\"NLB\",\"quantity\":90,\"quantity_details\":[{\"quantity\":90,\"location_id\":\"1\"}]}]', '7', '1447200000', '', '1447099902', '1447099902', '0', '0', '');
INSERT INTO `tbl_in_out_part` VALUES ('73', '1', '21', '0', '', '[\"5\"]', '[{\"id\":\"5\",\"heatnumber\":\"#1035\",\"drawing\":\"Dr9098\",\"quantity\":5,\"quantity_details\":[{\"quantity\":5,\"location_id\":\"\"}],\"detail_information\":[]}]', '11', '1449532800', '', '1449593089', '1449593089', '0', '4', '');
INSERT INTO `tbl_in_out_part` VALUES ('74', '1', '19', '0', '', '[\"7\"]', '[{\"id\":\"7\",\"heatnumber\":\"456356\",\"drawing\":\"566345\",\"quantity\":50,\"quantity_details\":[{\"quantity\":50,\"location_id\":\"\"}]}]', '11', '1449532800', '', '1449593170', '1449593170', '0', '4', '[\"\\/server\\/data\\/pdf\\/COC_303401X17-010q_456356_20151208_74.pdf\"]');
INSERT INTO `tbl_in_out_part` VALUES ('78', '1', '21', '0', '', '[\"5\"]', '[{\"id\":\"5\",\"heatnumber\":\"#1035\",\"drawing\":\"Dr9098\",\"quantity\":20,\"detail_information\":[],\"quantity_details\":[{\"quantity\":20,\"location_id\":\"\"}]}]', '11', '1449532800', '', '1449593337', '1449593337', '0', '4', '');
INSERT INTO `tbl_in_out_part` VALUES ('80', '1', '21', '0', '', '[\"4\"]', '[{\"id\":\"4\",\"heatnumber\":\"Part Heat 1\",\"drawing\":\"Drawing 1\",\"quantity\":20,\"quantity_details\":[{\"quantity\":20,\"location_id\":\"\"}]}]', '11', '1449532800', '', '1449593535', '1449593535', '0', '4', '[\"\\/server\\/data\\/pdf\\/COC_newpart10_Part_Heat_1_20151208_80.pdf\"]');
INSERT INTO `tbl_in_out_part` VALUES ('81', '1', '21', '0', '', '[\"4\"]', '[{\"id\":\"4\",\"heatnumber\":\"Part Heat 1\",\"drawing\":\"Drawing 1\",\"quantity\":5,\"quantity_details\":[{\"quantity\":5,\"location_id\":\"\"}]}]', '11', '1449532800', '', '1449593592', '1449593592', '0', '4', '[\"\\/server\\/data\\/pdf\\/COC_newpart10_Part_Heat_1_20151208_81.pdf\"]');
INSERT INTO `tbl_in_out_part` VALUES ('82', '1', '21', '0', '', '[\"4\"]', '[{\"id\":\"4\",\"heatnumber\":\"Part Heat 1\",\"drawing\":\"Drawing 1\",\"quantity\":5,\"quantity_details\":[{\"quantity\":5,\"location_id\":\"\"}]}]', '11', '1449532800', '', '1449598962', '1449598962', '0', '4', '[\"\\/server\\/data\\/pdf\\/COC_newpart10_Part_Heat_1_20151208_82.pdf\"]');
INSERT INTO `tbl_in_out_part` VALUES ('84', '0', '52', '0', '', '[\"18\"]', '[{\"id\":\"18\",\"heatnumber\":\"NULL\",\"drawing\":\"-\",\"quantity\":4,\"quantity_details\":[{\"quantity\":4,\"location_id\":\"341\"}]}]', '11', '1449446400', '<p>4 PISTONS ON 2 SPEREATE P.O.&#39;S</p>\n', '1449943509', '1449943509', '0', '0', '');
INSERT INTO `tbl_in_out_part` VALUES ('85', '1', '52', '0', '', '[\"18\"]', '[{\"id\":\"18\",\"heatnumber\":\"NULL\",\"quantity\":2,\"quantity_details\":[{\"quantity\":2,\"location_id\":\"341\"}]}]', '11', '1449878400', '', '1449943654', '1449943654', '0', '17', '[\"\\/server\\/data\\/pdf\\/COC_10INX4.750X2.25THD_NULL_20151212_85.pdf\"]');
INSERT INTO `tbl_in_out_part` VALUES ('87', '1', '52', '0', '', '[\"18\"]', '[{\"id\":\"18\",\"heatnumber\":\"NULL\",\"drawing\":\"-\",\"quantity\":2,\"quantity_details\":[{\"quantity\":2,\"location_id\":\"\"}]}]', '11', '1449878400', '', '1449943825', '1449943825', '0', '18', '[\"\\/server\\/data\\/pdf\\/COC_10INX4.750X2.25THD_NULL_20151212_87.pdf\"]');
INSERT INTO `tbl_in_out_part` VALUES ('88', '1', '21', '0', '', '[\"4\"]', '[{\"id\":\"4\",\"heatnumber\":\"Part Heat 1\",\"drawing\":\"Drawing 1\",\"quantity\":4,\"detail_information\":[{\"location_id\":\"1\",\"location_name\":\"Shelf 1 | Section 1 | Box 1\",\"quantity\":\"20\"}],\"quantity_details\":[{\"quantity\":4,\"location_id\":\"\"}]}]', '11', '1453075200', '', '1453036886', '1453036886', '0', '4', '[\"\\/server\\/data\\/pdf\\/COC_newpart10_Part_Heat_1_20160117_88.pdf\"]');
INSERT INTO `tbl_in_out_part` VALUES ('91', '0', '21', '0', '', '[\"5\"]', '[{\"id\":\"5\",\"heatnumber\":\"#1035\",\"drawing\":\"Dr9098\",\"quantity\":30,\"quantity_details\":[{\"quantity\":30,\"location_id\":\"1\"}]}]', '11', '1453161600', '', '1453038040', '1453038040', '0', '0', '');
INSERT INTO `tbl_in_out_part` VALUES ('92', '1', '21', '0', '', '[\"5\"]', '[{\"id\":\"5\",\"heatnumber\":\"#1035\",\"drawing\":\"Dr9098\",\"quantity\":10,\"quantity_details\":[{\"quantity\":10,\"location_id\":\"1\"}],\"detail_information\":[{\"location_id\":\"1\",\"location_name\":\"Shelf 1 | Section 1 | Box 1\",\"quantity\":\"30\"}]}]', '11', '1453161600', '', '1453038119', '1453038119', '0', '4', '[\"\\/server\\/data\\/pdf\\/COC_newpart10_#1035_20160117_92.pdf\"]');
INSERT INTO `tbl_in_out_part` VALUES ('93', '0', '21', '0', '', '[\"5\"]', '[{\"id\":\"5\",\"heatnumber\":\"#1035\",\"quantity\":4,\"quantity_details\":[{\"quantity\":4,\"location_id\":\"1\"}]}]', '12', '1451952000', '<p>correction</p>\n', '1453051704', '1453051704', '0', '0', '');
INSERT INTO `tbl_in_out_part` VALUES ('94', '0', '54', '0', '', '[\"19\"]', '[{\"id\":\"19\",\"heatnumber\":\"345h56\",\"drawing\":\"000\",\"quantity\":50,\"quantity_details\":[{\"quantity\":50,\"location_id\":\"1\"}]}]', '11', '1455840000', '', '1455472576', '1455472576', '0', '0', '');
INSERT INTO `tbl_in_out_part` VALUES ('95', '1', '54', '0', '', '[\"19\"]', '[{\"id\":\"19\",\"heatnumber\":\"345h56\",\"drawing\":\"000\",\"quantity\":2,\"quantity_details\":[{\"quantity\":2,\"location_id\":\"1\"}]}]', '11', '1455753600', '', '1455472625', '1455472625', '0', '20', '[\"\\/server\\/data\\/pdf\\/COC_HUNGHUNG_PART_SEP_10_345h56_20160214_95.pdf\"]');
INSERT INTO `tbl_in_out_part` VALUES ('96', '1', '21', '0', '', '[\"5\"]', '[{\"id\":\"5\",\"heatnumber\":\"#1035\",\"drawing\":\"Dr9098\",\"quantity\":10,\"detail_information\":[{\"location_id\":\"1\",\"location_name\":\"Shelf 1 | Section 1 | Box 1\",\"quantity\":\"24\"}],\"quantity_details\":[{\"quantity\":10,\"location_id\":\"1\"}]}]', '11', '1458172800', '', '1457095336', '1457095336', '0', '4', '[\"\\/server\\/data\\/pdf\\/COC_newpart10_#1035_20160304_96.pdf\"]');
INSERT INTO `tbl_in_out_part` VALUES ('97', '1', '21', '0', '', '[\"5\"]', '[{\"id\":\"5\",\"heatnumber\":\"#1035\",\"drawing\":\"Dr9098\",\"quantity\":4,\"detail_information\":[{\"location_id\":\"1\",\"location_name\":\"Shelf 1 | Section 1 | Box 1\",\"quantity\":\"14\"}],\"quantity_details\":[{\"quantity\":4,\"location_id\":\"1\"}]}]', '14', '1458172800', '', '1457095406', '1457095406', '0', '4', '[\"\\/server\\/data\\/pdf\\/COC_newpart10_#1035_20160304_97.pdf\"]');
INSERT INTO `tbl_in_out_part` VALUES ('98', '1', '54', '0', '', '[\"19\"]', '[{\"id\":\"19\",\"heatnumber\":\"345h56\",\"drawing\":\"000\",\"quantity\":3,\"quantity_details\":[{\"quantity\":3,\"location_id\":\"1\"}]}]', '12', '1457654400', '', '1457696164', '1457696164', '0', '20', '[\"\\/server\\/data\\/pdf\\/COC_HUNGHUNG_PART_SEP_10_345h56_20160311_98.pdf\"]');

-- ----------------------------
-- Table structure for tbl_item
-- ----------------------------
DROP TABLE IF EXISTS `tbl_item`;
CREATE TABLE `tbl_item` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `price` float NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `created_time` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=armscii8;

-- ----------------------------
-- Records of tbl_item
-- ----------------------------
INSERT INTO `tbl_item` VALUES ('1', 'Order Item A1', '12.5', '1', '1444469680');
INSERT INTO `tbl_item` VALUES ('2', 'Order Item A2', '30.6', '1', '1444469701');
INSERT INTO `tbl_item` VALUES ('3', 'Order Item A3', '310', '1', '1444469710');

-- ----------------------------
-- Table structure for tbl_job_order
-- ----------------------------
DROP TABLE IF EXISTS `tbl_job_order`;
CREATE TABLE `tbl_job_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jo_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jo_group` int(11) NOT NULL,
  `purchase_order_id` int(11) NOT NULL,
  `total_part` int(11) NOT NULL,
  `updated_time` int(11) NOT NULL,
  `created_time` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of tbl_job_order
-- ----------------------------
INSERT INTO `tbl_job_order` VALUES ('15', '', '0', '1', '0', '1430035194', '1430035194', '1');
INSERT INTO `tbl_job_order` VALUES ('16', '', '0', '1', '0', '1430269377', '1430269377', '1');
INSERT INTO `tbl_job_order` VALUES ('17', '', '0', '2', '0', '1430345496', '1430345496', '1');
INSERT INTO `tbl_job_order` VALUES ('18', '', '0', '2', '0', '1430484404', '1430484404', '1');
INSERT INTO `tbl_job_order` VALUES ('19', '', '0', '2', '0', '1430946050', '1430946050', '1');
INSERT INTO `tbl_job_order` VALUES ('20', '', '0', '2', '0', '1431314032', '1431314032', '1');
INSERT INTO `tbl_job_order` VALUES ('21', '', '0', '2', '0', '1431379811', '1431379811', '1');
INSERT INTO `tbl_job_order` VALUES ('22', '', '0', '2', '0', '1431551426', '1431551426', '1');
INSERT INTO `tbl_job_order` VALUES ('23', '', '0', '3', '0', '1431793520', '1431793520', '1');
INSERT INTO `tbl_job_order` VALUES ('24', '', '0', '3', '0', '1432051028', '1432051028', '1');
INSERT INTO `tbl_job_order` VALUES ('25', '', '0', '3', '0', '1432180234', '1432180234', '1');
INSERT INTO `tbl_job_order` VALUES ('26', '', '0', '3', '0', '1433021454', '1433021454', '1');
INSERT INTO `tbl_job_order` VALUES ('27', '', '0', '4', '0', '1433175830', '1433175830', '1');
INSERT INTO `tbl_job_order` VALUES ('28', '', '0', '2', '0', '1433199973', '1433199973', '1');
INSERT INTO `tbl_job_order` VALUES ('29', '', '0', '2', '0', '1433332088', '1433332088', '1');
INSERT INTO `tbl_job_order` VALUES ('30', '', '0', '3', '0', '1433338494', '1433338494', '1');
INSERT INTO `tbl_job_order` VALUES ('31', '', '0', '3', '0', '1436885029', '1436885029', '1');
INSERT INTO `tbl_job_order` VALUES ('32', '', '0', '4', '0', '1439380001', '1439380001', '1');
INSERT INTO `tbl_job_order` VALUES ('33', '', '0', '4', '0', '1439384643', '1439384643', '1');
INSERT INTO `tbl_job_order` VALUES ('34', '', '0', '4', '0', '1439650875', '1439650875', '1');
INSERT INTO `tbl_job_order` VALUES ('35', '', '0', '4', '0', '1441982965', '1441982965', '1');
INSERT INTO `tbl_job_order` VALUES ('36', '', '0', '5', '0', '1442330329', '1442330329', '1');
INSERT INTO `tbl_job_order` VALUES ('37', '', '0', '8', '0', '1445299862', '1445299862', '1');
INSERT INTO `tbl_job_order` VALUES ('38', '', '0', '4', '0', '1446466289', '1446466289', '1');
INSERT INTO `tbl_job_order` VALUES ('39', '', '0', '4', '0', '1447099097', '1447099097', '1');
INSERT INTO `tbl_job_order` VALUES ('40', '', '0', '4', '0', '1448018273', '1448018273', '1');
INSERT INTO `tbl_job_order` VALUES ('41', '', '0', '19', '0', '1448909807', '1448909807', '1');
INSERT INTO `tbl_job_order` VALUES ('42', '', '0', '18', '0', '1448969477', '1448969477', '1');
INSERT INTO `tbl_job_order` VALUES ('43', '', '0', '18', '0', '1450107341', '1450107341', '12');
INSERT INTO `tbl_job_order` VALUES ('44', '', '0', '14', '0', '1450876838', '1450876838', '12');
INSERT INTO `tbl_job_order` VALUES ('45', '', '0', '19', '0', '1452040366', '1452040366', '1');
INSERT INTO `tbl_job_order` VALUES ('46', '', '0', '3', '0', '1453662875', '1453662875', '1');
INSERT INTO `tbl_job_order` VALUES ('47', '', '0', '19', '0', '1453663290', '1453663290', '1');
INSERT INTO `tbl_job_order` VALUES ('48', 'Jo 1', '48', '22', '0', '1454670402', '1454670402', '1');
INSERT INTO `tbl_job_order` VALUES ('49', 'Jo 2', '48', '22', '0', '1454670402', '1454670402', '1');
INSERT INTO `tbl_job_order` VALUES ('50', '8567', '50', '20', '0', '1455472680', '1455472680', '1');
INSERT INTO `tbl_job_order` VALUES ('51', '5', '51', '4', '0', '1457095507', '1457095507', '1');
INSERT INTO `tbl_job_order` VALUES ('52', '55', '51', '4', '0', '1457095508', '1457095508', '1');
INSERT INTO `tbl_job_order` VALUES ('53', '555', '51', '4', '0', '1457095508', '1457095508', '1');
INSERT INTO `tbl_job_order` VALUES ('54', '5555', '51', '4', '0', '1457095508', '1457095508', '1');
INSERT INTO `tbl_job_order` VALUES ('55', 'SNS1020', '55', '33', '0', '1457794486', '1457794486', '1');
INSERT INTO `tbl_job_order` VALUES ('56', 'SNS1021', '55', '33', '0', '1457794486', '1457794486', '1');
INSERT INTO `tbl_job_order` VALUES ('57', 'RED01', '57', '41', '0', '1464360808', '1464360808', '1');
INSERT INTO `tbl_job_order` VALUES ('58', 'RED02', '57', '41', '0', '1464360808', '1464360808', '1');
INSERT INTO `tbl_job_order` VALUES ('59', 'RED03', '57', '41', '0', '1464360808', '1464360808', '1');
INSERT INTO `tbl_job_order` VALUES ('60', 'RED04', '57', '41', '0', '1464360808', '1464360808', '1');
INSERT INTO `tbl_job_order` VALUES ('61', 'RED05', '57', '41', '0', '1464360808', '1464360808', '1');
INSERT INTO `tbl_job_order` VALUES ('62', 'RED06', '57', '41', '0', '1464360808', '1464360808', '1');

-- ----------------------------
-- Table structure for tbl_job_order_detail
-- ----------------------------
DROP TABLE IF EXISTS `tbl_job_order_detail`;
CREATE TABLE `tbl_job_order_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job_order_id` int(11) NOT NULL,
  `part_id` int(11) NOT NULL,
  `quantity_manufacture` int(11) NOT NULL,
  `material_id` int(11) NOT NULL,
  `quantity_drew` int(11) NOT NULL,
  `quantity_returned` int(11) NOT NULL,
  `drew_date` int(11) NOT NULL,
  `created_time` int(11) NOT NULL,
  `updated_time` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of tbl_job_order_detail
-- ----------------------------
INSERT INTO `tbl_job_order_detail` VALUES ('28', '15', '1', '13067', '1', '0', '0', '0', '1430035194', '1430035194', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('29', '15', '2', '200', '1', '0', '0', '0', '1430035194', '1430035194', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('30', '16', '1', '13067', '1', '0', '0', '0', '1430269377', '1430269377', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('31', '16', '2', '200', '1', '0', '0', '0', '1430269377', '1430269377', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('32', '17', '19', '62', '3', '0', '0', '0', '1430345496', '1430345496', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('33', '17', '12', '5', '3', '0', '0', '0', '1430345497', '1430345497', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('34', '17', '21', '12', '4', '0', '0', '0', '1430345497', '1430345497', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('35', '18', '19', '62', '3', '0', '0', '0', '1430484404', '1430484404', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('36', '18', '12', '5', '3', '0', '0', '0', '1430484405', '1430484405', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('37', '18', '21', '12', '4', '0', '0', '0', '1430484405', '1430484405', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('38', '19', '19', '62', '3', '0', '0', '0', '1430946050', '1430946050', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('39', '19', '12', '5', '3', '0', '0', '0', '1430946050', '1430946050', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('40', '19', '21', '12', '4', '0', '0', '0', '1430946050', '1430946050', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('41', '20', '19', '62', '3', '0', '0', '0', '1431314032', '1431314032', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('42', '20', '12', '30', '3', '0', '0', '0', '1431314032', '1431314032', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('43', '20', '21', '12', '4', '0', '0', '0', '1431314032', '1431314032', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('44', '21', '19', '62', '3', '0', '0', '0', '1431379811', '1431379811', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('45', '21', '12', '30', '3', '0', '0', '0', '1431379812', '1431379812', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('46', '21', '21', '12', '4', '0', '0', '0', '1431379812', '1431379812', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('47', '22', '19', '62', '3', '0', '0', '0', '1431551426', '1431551426', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('48', '22', '12', '30', '3', '0', '0', '0', '1431551427', '1431551427', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('49', '22', '21', '12', '4', '0', '0', '0', '1431551427', '1431551427', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('50', '23', '13', '234', '1', '0', '0', '0', '1431793520', '1431793520', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('51', '24', '13', '6', '1', '0', '0', '0', '1432051028', '1432051028', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('52', '25', '13', '12', '1', '0', '0', '0', '1432180234', '1432180234', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('53', '26', '13', '1', '1', '0', '0', '0', '1433021454', '1433021454', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('54', '27', '21', '30', '4', '0', '0', '0', '1433175830', '1433175830', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('55', '27', '19', '100', '3', '0', '0', '0', '1433175831', '1433175831', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('56', '27', '17', '40', '4', '0', '0', '0', '1433175831', '1433175831', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('57', '27', '16', '17', '1', '0', '0', '0', '1433175831', '1433175831', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('58', '28', '19', '400', '3', '0', '0', '0', '1433199974', '1433199974', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('59', '28', '12', '30', '3', '0', '0', '0', '1433199974', '1433199974', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('60', '28', '21', '50', '4', '0', '0', '0', '1433199974', '1433199974', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('61', '29', '19', '115', '3', '0', '0', '0', '1433332088', '1433332088', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('62', '29', '12', '905', '3', '0', '0', '0', '1433332088', '1433332088', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('63', '29', '21', '25', '4', '0', '0', '0', '1433332088', '1433332088', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('64', '30', '13', '500', '1', '0', '0', '0', '1433338494', '1433338494', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('65', '31', '13', '300', '1', '0', '0', '0', '1436885029', '1436885029', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('66', '32', '21', '20', '4', '0', '0', '0', '1439380001', '1439380001', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('67', '32', '19', '110', '3', '0', '0', '0', '1439380001', '1439380001', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('68', '32', '17', '25', '4', '0', '0', '0', '1439380002', '1439380002', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('69', '32', '16', '10', '1', '0', '0', '0', '1439380002', '1439380002', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('70', '33', '21', '20', '4', '0', '0', '0', '1439384644', '1439384644', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('71', '33', '19', '110', '3', '0', '0', '0', '1439384644', '1439384644', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('72', '33', '17', '25', '4', '0', '0', '0', '1439384644', '1439384644', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('73', '33', '16', '10', '1', '0', '0', '0', '1439384644', '1439384644', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('74', '34', '21', '20', '4', '0', '0', '0', '1439650875', '1439650875', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('75', '34', '19', '110', '3', '0', '0', '0', '1439650875', '1439650875', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('76', '34', '17', '25', '4', '0', '0', '0', '1439650875', '1439650875', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('77', '34', '16', '10', '1', '0', '0', '0', '1439650875', '1439650875', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('78', '35', '21', '20', '4', '0', '0', '0', '1441982966', '1441982966', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('79', '35', '19', '110', '3', '0', '0', '0', '1441982966', '1441982966', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('80', '35', '17', '25', '4', '0', '0', '0', '1441982966', '1441982966', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('81', '35', '16', '10', '1', '0', '0', '0', '1441982966', '1441982966', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('82', '36', '26', '16', '15', '0', '0', '0', '1442330329', '1442330329', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('83', '37', '32', '5', '21', '0', '0', '0', '1445299862', '1445299862', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('84', '38', '17', '25', '4', '0', '0', '0', '1446466290', '1446466290', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('85', '38', '16', '10', '1', '0', '0', '0', '1446466290', '1446466290', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('86', '39', '17', '25', '4', '0', '0', '0', '1447099097', '1447099097', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('87', '39', '16', '10', '1', '0', '0', '0', '1447099097', '1447099097', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('88', '40', '21', '20', '4', '0', '0', '0', '1448018273', '1448018273', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('89', '40', '19', '110', '3', '0', '0', '0', '1448018274', '1448018274', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('90', '40', '17', '25', '4', '0', '0', '0', '1448018274', '1448018274', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('91', '40', '16', '10', '1', '0', '0', '0', '1448018274', '1448018274', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('92', '41', '46', '35', '33', '0', '0', '0', '1448909807', '1448909807', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('93', '41', '47', '35', '33', '0', '0', '0', '1448909807', '1448909807', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('94', '42', '51', '2', '46', '0', '0', '0', '1448969477', '1448969477', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('95', '42', '52', '2', '47', '0', '0', '0', '1448969477', '1448969477', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('96', '42', '53', '2', '48', '0', '0', '0', '1448969477', '1448969477', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('97', '43', '51', '2', '46', '0', '0', '0', '1450107341', '1450107341', '12');
INSERT INTO `tbl_job_order_detail` VALUES ('98', '43', '53', '2', '48', '0', '0', '0', '1450107341', '1450107341', '12');
INSERT INTO `tbl_job_order_detail` VALUES ('99', '44', '42', '102', '31', '0', '0', '0', '1450876839', '1450876839', '12');
INSERT INTO `tbl_job_order_detail` VALUES ('100', '44', '43', '102', '32', '0', '0', '0', '1450876839', '1450876839', '12');
INSERT INTO `tbl_job_order_detail` VALUES ('101', '45', '46', '35', '33', '0', '0', '0', '1452040366', '1452040366', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('102', '45', '47', '35', '33', '0', '0', '0', '1452040366', '1452040366', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('103', '46', '13', '100', '1', '0', '0', '0', '1453662875', '1453662875', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('104', '47', '46', '35', '33', '0', '0', '0', '1453663290', '1453663290', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('105', '47', '47', '35', '33', '0', '0', '0', '1453663290', '1453663290', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('106', '48', '56', '1', '54', '0', '0', '0', '1454670402', '1454670402', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('107', '49', '56', '3', '54', '0', '0', '0', '1454670402', '1454670402', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('108', '50', '54', '1002', '1', '0', '0', '0', '1455472680', '1455472680', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('109', '51', '21', '20', '4', '0', '0', '0', '1457095508', '1457095508', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('110', '52', '19', '110', '3', '0', '0', '0', '1457095508', '1457095508', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('111', '53', '17', '25', '4', '0', '0', '0', '1457095508', '1457095508', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('112', '54', '16', '10', '1', '0', '0', '0', '1457095508', '1457095508', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('113', '55', '69', '2', '46', '0', '0', '0', '1457794486', '1457794486', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('114', '56', '68', '2', '76', '0', '0', '0', '1457794486', '1457794486', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('115', '57', '103', '500', '83', '0', '0', '0', '1464360808', '1464360808', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('116', '58', '101', '500', '83', '0', '0', '0', '1464360808', '1464360808', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('117', '59', '99', '500', '86', '0', '0', '0', '1464360808', '1464360808', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('118', '60', '97', '500', '84', '0', '0', '0', '1464360808', '1464360808', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('119', '61', '95', '500', '85', '0', '0', '0', '1464360808', '1464360808', '1');
INSERT INTO `tbl_job_order_detail` VALUES ('120', '62', '93', '500', '85', '0', '0', '0', '1464360808', '1464360808', '1');

-- ----------------------------
-- Table structure for tbl_machine
-- ----------------------------
DROP TABLE IF EXISTS `tbl_machine`;
CREATE TABLE `tbl_machine` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `created_time` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=armscii8;

-- ----------------------------
-- Records of tbl_machine
-- ----------------------------
INSERT INTO `tbl_machine` VALUES ('1', 'HAAS22', '1', '1');
INSERT INTO `tbl_machine` VALUES ('2', 'MAZAK2', '1', '1425199249');
INSERT INTO `tbl_machine` VALUES ('3', 'MAZAK1', '1', '0');
INSERT INTO `tbl_machine` VALUES ('4', 'OKUMA', '1', '0');
INSERT INTO `tbl_machine` VALUES ('5', 'HAAS1', '1', '0');
INSERT INTO `tbl_machine` VALUES ('6', 'HAAS3', '1', '0');
INSERT INTO `tbl_machine` VALUES ('7', 'WS/3-123', '1', '1');
INSERT INTO `tbl_machine` VALUES ('8', 'NAM_MACHINE', '1', '14');
INSERT INTO `tbl_machine` VALUES ('9', 'HUNG_MACHINE', '1', '1431657213');
INSERT INTO `tbl_machine` VALUES ('10', 'Mori Seiki', '1', '1463170504');

-- ----------------------------
-- Table structure for tbl_machine_job
-- ----------------------------
DROP TABLE IF EXISTS `tbl_machine_job`;
CREATE TABLE `tbl_machine_job` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `machine_id` int(11) unsigned NOT NULL,
  `point` varchar(20) NOT NULL,
  `value` tinyint(3) unsigned NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `created_time` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_machine_job
-- ----------------------------
INSERT INTO `tbl_machine_job` VALUES ('1', '1', '301279-0102', '30', '1', '1425489967');

-- ----------------------------
-- Table structure for tbl_machine_schedule
-- ----------------------------
DROP TABLE IF EXISTS `tbl_machine_schedule`;
CREATE TABLE `tbl_machine_schedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job_order_id` int(11) NOT NULL,
  `job_order_detail_id` int(11) NOT NULL,
  `part_id` int(11) NOT NULL,
  `material_id` int(11) NOT NULL,
  `machine_id` int(11) NOT NULL,
  `operation_id` int(11) NOT NULL,
  `start_date` int(11) NOT NULL,
  `employee` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `quantity_good` int(11) NOT NULL,
  `quantity_scarp` int(11) NOT NULL,
  `heat_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `designation` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `setup_time` int(11) NOT NULL,
  `cleanup_time` int(11) NOT NULL,
  `has_problem` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_time` int(11) NOT NULL,
  `updated_time` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `scheduled_hour` float NOT NULL,
  `actual_hour` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of tbl_machine_schedule
-- ----------------------------
INSERT INTO `tbl_machine_schedule` VALUES ('1', '14', '26', '9', '3', '2', '32', '1429912800', 'ms Huong', '0', '0', '0', 'C', '32', '10', '0', '0', '1429960804', '1429960804', '1', '0', '0');
INSERT INTO `tbl_machine_schedule` VALUES ('2', '14', '26', '9', '3', '3', '23', '1430172000', 'ms Nam', '0', '0', '0', 'D', '23', '32', '0', '0', '1429961179', '1429961179', '1', '0', '0');
INSERT INTO `tbl_machine_schedule` VALUES ('3', '18', '36', '12', '3', '6', '0', '1431993600', 'Ms Nam', '132', '0', '0', 'C', '3', '1', '0', '1', '1430877235', '1430877235', '1', '0', '0');
INSERT INTO `tbl_machine_schedule` VALUES ('4', '24', '51', '13', '1', '2', '0', '1431302400', 'EMP1', '0', '0', '0', '', '2', '9', '0', '1', '1432051098', '1432080403', '1', '0', '0');
INSERT INTO `tbl_machine_schedule` VALUES ('5', '24', '51', '13', '1', '4', '0', '1432252800', 'de', '6', '1', '0', '', '4', '4', '0', '1', '1432080433', '1432080433', '1', '0', '0');
INSERT INTO `tbl_machine_schedule` VALUES ('6', '25', '52', '13', '1', '1', '1', '1432857600', 'ms Nam', '321', '2', 'AC', 'D', '32', '2', '0', '1', '1432913297', '1432913297', '1', '12', '11');
INSERT INTO `tbl_machine_schedule` VALUES ('7', '22', '47', '19', '3', '1', '1', '1432857600', 'mr Hung', '411', '31', 'A', 'DE', '30', '33', '0', '1', '1432913367', '1432913367', '1', '12', '33');
INSERT INTO `tbl_machine_schedule` VALUES ('8', '22', '48', '12', '3', '1', '2', '1432857600', 'Peter', '300', '12', '#A', 'A', '10', '15', '1', '1', '1432913407', '1432913407', '1', '33', '44');
INSERT INTO `tbl_machine_schedule` VALUES ('9', '22', '47', '19', '3', '6', '2', '1432857600', 'Henry', '110', '7', '#ABD', 'C', '12', '8', '0', '1', '1432913611', '1432913611', '1', '100', '90');
INSERT INTO `tbl_machine_schedule` VALUES ('10', '26', '53', '13', '1', '1', '1', '1433462400', 'Tony', '50', '10', '', '', '1', '2', '0', '1', '1433127466', '1433127472', '1', '5', '3');
INSERT INTO `tbl_machine_schedule` VALUES ('11', '27', '54', '21', '4', '1', '1', '1433116800', 'HUNG', '100', '25', '', '', '1', '2', '1', '1', '1433175932', '1433201789', '1', '5', '4.5');
INSERT INTO `tbl_machine_schedule` VALUES ('12', '28', '58', '19', '3', '4', '7', '1434067200', 'kb', '0', '0', '', '', '0', '0', '0', '1', '1433200328', '1433200328', '1', '34', '0');
INSERT INTO `tbl_machine_schedule` VALUES ('13', '28', '58', '19', '3', '4', '6', '1435104000', '', '0', '0', '', '', '0', '0', '0', '1', '1433200348', '1433200348', '1', '5', '0');
INSERT INTO `tbl_machine_schedule` VALUES ('14', '28', '58', '19', '3', '3', '8', '1433894400', '', '0', '0', '', '', '0', '0', '0', '1', '1433200378', '1433200378', '1', '7', '0');
INSERT INTO `tbl_machine_schedule` VALUES ('15', '28', '58', '19', '3', '8', '3', '1435104000', '', '0', '0', '', '', '0', '0', '0', '1', '1433200695', '1433200695', '1', '3', '0');
INSERT INTO `tbl_machine_schedule` VALUES ('16', '22', '47', '19', '3', '1', '6', '1433721600', '', '0', '0', '', '', '0', '0', '0', '1', '1433201011', '1433201011', '1', '23', '0');
INSERT INTO `tbl_machine_schedule` VALUES ('17', '30', '64', '13', '1', '3', '7', '1433376000', '', '0', '0', '', '', '0', '0', '0', '1', '1433338556', '1433338556', '1', '30', '0');
INSERT INTO `tbl_machine_schedule` VALUES ('18', '32', '66', '21', '4', '1', '7', '1439424000', 'JM', '0', '0', '', '', '0', '0', '0', '1', '1439380661', '1439380661', '1', '8', '0');
INSERT INTO `tbl_machine_schedule` VALUES ('19', '35', '78', '21', '4', '1', '7', '1442275200', '', '0', '0', '', '', '0', '0', '0', '1', '1441983054', '1441983054', '1', '9', '5');
INSERT INTO `tbl_machine_schedule` VALUES ('20', '36', '82', '26', '15', '5', '1', '1442361600', '', '0', '0', '', '', '0', '0', '0', '1', '1442330408', '1442330433', '1', '2', '0');
INSERT INTO `tbl_machine_schedule` VALUES ('21', '36', '82', '26', '15', '5', '5', '1441756800', '', '0', '0', '', '', '0', '0', '0', '1', '1442330438', '1442330438', '1', '2', '0');
INSERT INTO `tbl_machine_schedule` VALUES ('22', '38', '84', '17', '4', '1', '7', '1447200000', '', '0', '0', '', '', '0', '0', '0', '1', '1446466372', '1446466372', '1', '22', '0');
INSERT INTO `tbl_machine_schedule` VALUES ('23', '41', '92', '46', '33', '3', '2', '1447113600', '', '0', '0', '', '', '0', '0', '0', '1', '1448909877', '1448909877', '1', '45', '0');
INSERT INTO `tbl_machine_schedule` VALUES ('24', '42', '94', '51', '46', '3', '1', '1448928000', '', '0', '0', '', '', '0', '0', '0', '1', '1448969525', '1448969525', '1', '3', '0');
INSERT INTO `tbl_machine_schedule` VALUES ('25', '42', '94', '51', '46', '3', '5', '1448928000', '', '0', '0', '', '', '0', '0', '0', '1', '1448969544', '1448969544', '1', '3', '0');
INSERT INTO `tbl_machine_schedule` VALUES ('26', '42', '95', '52', '47', '4', '1', '1449014400', '', '0', '0', '', '', '0', '0', '0', '1', '1448969596', '1448969596', '1', '4', '0');
INSERT INTO `tbl_machine_schedule` VALUES ('27', '42', '95', '52', '47', '4', '5', '1449100800', '', '0', '0', '', '', '0', '0', '0', '1', '1448969609', '1448969609', '1', '4', '0');
INSERT INTO `tbl_machine_schedule` VALUES ('28', '43', '97', '51', '46', '3', '1', '1450137600', '', '0', '0', '', '', '0', '0', '0', '1', '1450107400', '1450107400', '12', '6', '0');
INSERT INTO `tbl_machine_schedule` VALUES ('29', '55', '113', '69', '46', '3', '10', '1457740800', '', '0', '0', '', '', '0', '0', '0', '1', '1457795800', '1457796054', '1', '5', '0');
INSERT INTO `tbl_machine_schedule` VALUES ('30', '55', '113', '69', '46', '3', '9', '1458000000', '', '0', '0', '', '', '0', '0', '0', '1', '1457796089', '1457797472', '1', '4.5', '0');
INSERT INTO `tbl_machine_schedule` VALUES ('31', '56', '114', '68', '76', '3', '7', '1466467200', '', '0', '0', '', '', '0', '0', '0', '1', '1466171676', '1466171676', '1', '5', '0');

-- ----------------------------
-- Table structure for tbl_material
-- ----------------------------
DROP TABLE IF EXISTS `tbl_material`;
CREATE TABLE `tbl_material` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `material_code` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `material_code_id` int(11) NOT NULL,
  `material_type` int(11) unsigned NOT NULL,
  `category_id` int(11) NOT NULL,
  `date` int(11) unsigned NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `created_time` int(11) unsigned NOT NULL,
  `shape_id` int(11) NOT NULL,
  `uom_id` int(11) NOT NULL,
  `uoq_id` int(11) NOT NULL,
  `uol_id` int(11) NOT NULL,
  `receiver` varchar(255) NOT NULL,
  `note` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `am_designation` varchar(64) NOT NULL,
  `designation_id` varchar(255) NOT NULL,
  `heat_number` varchar(255) NOT NULL,
  `upload_file_id` int(11) NOT NULL,
  `sizes` varchar(255) NOT NULL,
  `inches` float NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_lbs` float NOT NULL,
  `cost_lbs` float NOT NULL,
  `cost_inch` float NOT NULL,
  `optimum_inventory` float NOT NULL,
  `stock_in_hand` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=armscii8;

-- ----------------------------
-- Records of tbl_material
-- ----------------------------
INSERT INTO `tbl_material` VALUES ('1', '12L14 & C1018', '5', '12', '0', '1425168000', '1', '1426089244', '0', '0', '0', '0', '', '', '', '', '', '', '0', '', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_material` VALUES ('2', '316 SS', '6', '12', '0', '1425168000', '1', '1426089244', '0', '0', '0', '0', '', '', '', '', '', '', '0', '', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_material` VALUES ('3', 'HAST C276', '7', '1', '3', '1426809600', '1', '1427648529', '2', '1', '1', '0', 'Ms T', 'Please take care of concrete material', 'Ny, US', 'General', '', '', '0', 'null', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_material` VALUES ('4', 'New Material', '8', '15', '0', '1421193600', '1', '1427649051', '0', '0', '0', '0', '', '', '', '', '', '', '0', '', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_material` VALUES ('5', 'Newmat', '9', '1', '0', '1427648400', '1', '1427649407', '0', '0', '0', '0', '', '', '', '', '', '', '0', '', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_material` VALUES ('6', 'newmaterial', '10', '1', '3', '1423958400', '1', '1427649510', '1', '3', '2', '0', 'Peter Smith', 'Please take care', 'NY, US', '', '', '', '0', '', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_material` VALUES ('7', 'Steel', '11', '0', '5', '1424304000', '1', '1428683379', '4', '4', '5', '0', 'Carter', 'Buy more to get good price', 'North Storage', 'Brass', '', '', '89', '{\"od\":\"\"}', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_material` VALUES ('8', 'Material Code 132', '12', '0', '3', '1428883200', '1', '1428860522', '2', '3', '3', '0', 'Peter Smith', 'note', 'row 2,  level 1', 'General', 'C8', '', '0', '{\"w\":\"32\",\"h\":\"312\"}', '0', '0', '0', '0', '0', '1000', '0');
INSERT INTO `tbl_material` VALUES ('9', 'HVD_Mat_001', '13', '0', '3', '1448755200', '1', '1428945623', '4', '2', '2', '0', 'Wellbeck', 'Good price', 'box 1 rOw 2', 'Brass', 'C9', 'ABDE23', '0', '{\"od\":\"11\"}', '0', '0', '0', '0', '0', '200', '3310');
INSERT INTO `tbl_material` VALUES ('10', 'test 12 jb', '14', '0', '3', '0', '1', '1430388310', '2', '0', '5', '1', '', '', '', 'General', 'C10', '', '0', '{\"w\":\"3\",\"h\":\"2\"}', '0', '163', '0', '0', '0', '0', '13675.4');
INSERT INTO `tbl_material` VALUES ('11', '009', '15', '0', '5', '0', '1', '1439597619', '1', '0', '5', '1', '', '', '', 'Brass', '', '', '0', '{\"size\":\"1.5\"}', '0', '0', '0', '0', '0', '144', '0');
INSERT INTO `tbl_material` VALUES ('12', '010', '16', '0', '17', '0', '1', '1441709493', '4', '0', '0', '1', '', '', '', 'General', '', '', '0', '{\"od\":\"1\"}', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_material` VALUES ('13', 'AMP501', '17', '0', '22', '0', '1', '1441843487', '4', '0', '0', '1', '', 'MATERIAL SUPPLIED IN FLAME CUT BILLETS', '', 'General', '', '', '0', '{\"od\":\"14\"}', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_material` VALUES ('14', 'NEW_MAT_SEP_10_HUNG', '18', '0', '3', '0', '1', '1441852431', '1', '0', '0', '1', '', '', '', 'Brass', 'B14', '', '0', '{\"size\":\"5\"}', '0', '0', '0', '0', '0', '100', '2305');
INSERT INTO `tbl_material` VALUES ('15', 'AMP5002', '19', '0', '21', '0', '1', '1442327704', '4', '0', '0', '1', '', '', '', 'General', 'C15', '', '0', '{\"od\":\"1\"}', '0', '0', '0', '0', '0', '1', '235');
INSERT INTO `tbl_material` VALUES ('16', 'AMP503', '20', '0', '22', '0', '1', '1442403551', '4', '0', '0', '1', '', '<p>FLAME CUT PLATE STEEL PROVIDED BY COSTUMER<br />\n&nbsp;</p>\n', '', 'Other', '', '', '0', '{\"od\":\"12.44\"}', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_material` VALUES ('17', 'AMP504', '21', '0', '22', '0', '1', '1442403620', '4', '0', '0', '1', '', '<p>FLAME CUT PLATE STEEL</p>\n', '', 'General', '', '', '0', '{\"od\":\"16.5\"}', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_material` VALUES ('18', 'AMP505', '22', '0', '23', '0', '1', '1442403691', '4', '0', '0', '1', '', '<p>CHROMED SHAFTING PROVIDED BY COSTUMER</p>\n', '', 'Other', '', '', '0', '{\"od\":\"2.5\"}', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_material` VALUES ('19', 'AMP506', '23', '0', '23', '0', '1', '1442403825', '4', '0', '0', '1', '', '<p>CHROMED SHAFTING PROVIDED BY CUSTOMER</p>\n', '', 'Other', '', '', '0', '{\"od\":\"4.0\"}', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_material` VALUES ('20', 'NYLON901', '24', '0', '25', '0', '1', '1443529347', '4', '0', '0', '1', '', '<p>NYLON BARSTOCK SUPPLIED BY CUSTOMER<br />\n&nbsp;</p>\n', '', 'General', '', '', '0', '{\"od\":\"1.5\"}', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_material` VALUES ('21', '18inch Plate', '25', '0', '22', '0', '1', '1444692402', '4', '0', '0', '1', '', '<p>Flame cut billets with 2.2&quot;dia hole</p>\n', '', 'General', '', '', '0', '{\"od\":\"18.5\"}', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_material` VALUES ('22', '1\" DIA 304SS', '26', '0', '18', '0', '1', '1445039069', '4', '0', '0', '1', '', '', '', 'General', 'C22', '', '0', '{\"od\":\"1\"}', '0', '12', '0', '0', '0', '0', '1728');
INSERT INTO `tbl_material` VALUES ('23', '2-3/4\" DIA. 304SS', '27', '0', '18', '0', '1', '1445039211', '4', '0', '0', '1', '', '', '', 'Other', '', '', '0', '{\"od\":\"2-3\\/4\"}', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_material` VALUES ('24', 'Newmat', '9', '0', '3', '0', '1', '1445838294', '1', '0', '0', '1', '', '<p>Hung adds new mat</p>\n', '', 'General', 'C24', '', '0', '{\"size\":\"10\"}', '0', '0', '0', '0', '0', '20', '1850');
INSERT INTO `tbl_material` VALUES ('25', '009', '15', '0', '16', '0', '1', '1446292609', '4', '0', '0', '1', '', '', '', 'Brass', '', '', '0', '{\"od\":\"1.5\"}', '0', '0', '0', '0', '0', '144', '0');
INSERT INTO `tbl_material` VALUES ('26', '2.125RD-009', '28', '0', '16', '0', '1', '1446476745', '4', '0', '0', '1', '', '', '', 'Brass', 'B26', '', '0', '{\"od\":\"2.125\"}', '0', '0', '0', '0', '0', '0', '14.25');
INSERT INTO `tbl_material` VALUES ('27', '4.00RD100K-CR', '30', '0', '23', '0', '1', '1446510829', '4', '0', '0', '1', '', '<p>SHAFTING IS SUPPLIED BY COSTUMERS<br />\n&nbsp;</p>\n', '', 'Other', '', '', '0', '{\"od\":\"4.0\"}', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_material` VALUES ('28', 'Nov_4_Mat_HVD', '44', '0', '6', '0', '1', '1446636157', '1', '0', '0', '1', '', '<p>Hung test new material on OCT 10</p>\n', '', 'General', '', '', '0', '{\"size\":\"10.5\"}', '0', '0', '0', '0', '0', '20', '889');
INSERT INTO `tbl_material` VALUES ('29', '7 X 14.75WD  G40.21-', '51', '0', '27', '0', '1', '1446835696', '3', '0', '0', '1', '', '<p>20&#39; LENGTHS OF C CHANNEL STEEL</p>\n', '', 'Other', '', '', '0', '{\"w\":\"14.75\",\"h\":\"6\"}', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_material` VALUES ('30', 'HUNG_NOV_11', '52', '0', '6', '0', '1', '1447214413', '1', '0', '0', '1', '', '', '', 'Brass', '', '', '0', '{\"size\":\"3\"}', '0', '0', '0', '0', '0', '100', '950');
INSERT INTO `tbl_material` VALUES ('31', '1.00RD-AM304', '56', '0', '18', '0', '1', '1447807553', '4', '0', '0', '1', '', '<p>MATERIAL QUOTED</p>\n', '', 'Other', '', '', '0', '{\"od\":\"1.0\"}', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_material` VALUES ('32', '.750RD-AM304', '55', '0', '18', '0', '1', '1447807587', '4', '0', '0', '1', '', '', '', 'Other', 'A32', '', '0', '{\"od\":\".750\"}', '0', '0', '0', '0', '0', '0', '60');
INSERT INTO `tbl_material` VALUES ('33', '.625RD-AM304', '54', '0', '18', '0', '1', '1447807623', '4', '0', '0', '1', '', '', '', 'Other', '', '', '0', '{\"od\":\".625\"}', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_material` VALUES ('34', '8.00RD-AM304', '53', '0', '18', '0', '1', '1447807657', '4', '0', '0', '1', '', '', '', 'Other', 'A34', '', '0', '{\"od\":\"8.0\"}', '0', '0', '0', '0', '0', '0', '54');
INSERT INTO `tbl_material` VALUES ('35', '1.000RD-316', '68', '0', '17', '0', '1', '1448016439', '4', '0', '0', '1', '', '', '', 'General', 'C35', '', '0', '{\"od\":\"1.0\"}', '0', '0', '0', '0', '0', '288', '787');
INSERT INTO `tbl_material` VALUES ('36', '.250RD-316', '41', '0', '17', '0', '1', '1448024981', '4', '0', '0', '1', '', '', '', 'Other', '', '', '0', '{\"od\":\".250\"}', '0', '0', '0', '0', '0', '720', '1498');
INSERT INTO `tbl_material` VALUES ('37', '.500RD-316', '43', '0', '17', '0', '1', '1448025590', '4', '0', '0', '1', '', '', '', 'Other', 'A37', '', '0', '{\"od\":\".500\"}', '0', '2', '0', '0', '0', '0', '13');
INSERT INTO `tbl_material` VALUES ('38', '.375RD-316', '42', '0', '17', '0', '1', '1448026701', '4', '0', '0', '1', '', '', '', 'Other', '', '', '0', '{\"od\":\".375\"}', '0', '0', '0', '0', '0', '0', '574.75');
INSERT INTO `tbl_material` VALUES ('39', '.625RD-316', '63', '0', '17', '0', '1', '1448028518', '4', '0', '0', '1', '', '', '', 'Other', 'A39', '', '0', '{\"od\":\".625\"}', '0', '6', '0', '0', '0', '0', '793');
INSERT INTO `tbl_material` VALUES ('40', '.750RD-316', '64', '0', '17', '0', '1', '1448029341', '4', '0', '0', '1', '', '', '', 'Other', 'A40', '', '0', '{\"od\":\".750\"}', '0', '1', '0', '0', '0', '0', '194');
INSERT INTO `tbl_material` VALUES ('41', '.875RD-316', '65', '0', '17', '0', '1', '1448029993', '4', '0', '0', '1', '', '', '', 'Other', '', '', '0', '{\"od\":\".875\"}', '0', '0', '0', '0', '0', '0', '9');
INSERT INTO `tbl_material` VALUES ('42', '.4375RD-316', '66', '0', '17', '0', '1', '1448031429', '4', '0', '0', '1', '', '', '', 'Other', '', '', '0', '{\"od\":\".4375\"}', '0', '0', '0', '0', '0', '0', '432');
INSERT INTO `tbl_material` VALUES ('43', '4.500RD-UHMW', '338', '0', '29', '0', '1', '1448411474', '4', '0', '0', '1', '', '<p>QUOTED MATERIAL</p>\n\n<p>(COMES IN TUBING AS WELL)</p>\n', '', 'Other', '', '', '0', '{\"od\":\"4.5\"}', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_material` VALUES ('44', '2.00RD-4140 Q&T T.G.', '340', '0', '21', '0', '1', '1448411706', '4', '0', '0', '1', '', '<p>51.70&quot; LENGTHS CUT</p>\n', '', 'General', '', '', '0', '{\"od\":\"2.0\"}', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_material` VALUES ('45', '4.00RD-C1045 T.G. & ', '341', '0', '30', '0', '1', '1448411846', '4', '0', '0', '1', '', '', '', 'General', '', '', '0', '{\"od\":\"4.0\"}', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_material` VALUES ('46', '2.500RD-100KCR', '342', '0', '23', '0', '1', '1448557611', '4', '0', '0', '1', '', '<p>CHROME SHAFTING PROVIDED CUT TO LENGTH BY CUSTOMER</p>\n', '', 'General', '', '', '0', '{\"od\":\"2.5\"}', '0', '0', '0', '0', '0', '0', '96.4');
INSERT INTO `tbl_material` VALUES ('47', '10.50RD-PLTSTL', '343', '0', '22', '0', '1', '1448557787', '4', '0', '0', '1', '', '<p>MATERIAL USUALLY PROVIDED BY COSTUMER</p>\n', '', 'General', '', '', '0', '{\"od\":\"10.5\"}', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_material` VALUES ('48', '10.750RDTB-STL/HONED', '345', '0', '22', '0', '1', '1448908339', '8', '0', '0', '1', '', '', '', 'General', '', '', '0', '{\"od\":\"11.750\",\"id\":\"10.003\"}', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_material` VALUES ('49', '1.750RD-1045', '351', '0', '30', '0', '1', '1449622720', '4', '0', '0', '1', '', '<p>QUOTED MATERIAL</p>\n', '', 'Other', '', '', '0', '{\"od\":\"1.75\"}', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_material` VALUES ('50', '3.500TB-A53-B PIPE', '350', '0', '31', '0', '1', '1449622958', '8', '0', '0', '1', '', '<p>QUOTED FROM GOLDEN &amp; CASTLE</p>\n\n<p>$35.00/PP FOR 7.06&quot;LNG PCS</p>\n', '', 'Other', '', '', '0', '{\"od\":\"3.5\",\"id\":\"2.40\"}', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_material` VALUES ('51', '1.250RD-4140 HTSR', '347', '0', '21', '0', '1', '1449623074', '4', '0', '0', '1', '', '', '', 'Other', '', '', '0', '{\"od\":\"1.20\"}', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_material` VALUES ('52', '3.750RD-1215 CD', '346', '0', '33', '0', '1', '1449623150', '4', '0', '0', '1', '', '', '', 'Other', '', '', '0', '{\"od\":\"3.75\"}', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_material` VALUES ('53', '2.7500RD-1215 CD', '349', '0', '33', '0', '1', '1449623237', '4', '0', '0', '1', '', '', '', 'Other', '', '', '0', '{\"od\":\"2.75\"}', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_material` VALUES ('54', '15.00RDPLx3.25-A516-', '352', '0', '34', '0', '1', '1449623466', '4', '0', '0', '1', '', '<p>15.00&quot;DIA X 3.25&quot; THICK PLATE</p>\n', '', 'Other', '', '', '0', '{\"od\":\"15.00\"}', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_material` VALUES ('55', '1.500RD-1018', '356', '0', '3', '0', '1', '1450096080', '4', '0', '0', '1', '', '', '', 'Other', 'A55', '', '0', '{\"od\":\"1.5\"}', '0', '0', '0', '0', '0', '0', '120');
INSERT INTO `tbl_material` VALUES ('56', '1.625RD-1018', '355', '0', '3', '0', '1', '1450100563', '4', '0', '0', '1', '', '<p>No heat, tooling only. MAZAK testing material.</p>\n', '', 'Other', '', '', '0', '{\"od\":\"1.625\"}', '0', '0', '0', '0', '0', '0', '48');
INSERT INTO `tbl_material` VALUES ('57', '.750RD-1018', '354', '0', '5', '0', '1', '1450101180', '4', '0', '0', '1', '', '<p>MAZAK TESTING. NO HEAT. TOOLING ONLY</p>\n', '', 'Other', 'A57', '', '0', '{\"od\":\".750\"}', '0', '0', '0', '0', '0', '0', '120');
INSERT INTO `tbl_material` VALUES ('58', '2.125RD-1018', '353', '0', '3', '0', '1', '1450101547', '4', '0', '0', '1', '', '<p>MAZAK TESTING. NO HEAT. TOOLING ONLY</p>\n', '', 'Other', 'A58', '', '0', '{\"od\":\"2.125\"}', '0', '6', '0', '0', '0', '0', '140');
INSERT INTO `tbl_material` VALUES ('59', '5.125RD-B16', '144', '0', '16', '0', '1', '1450108942', '4', '0', '0', '1', '', '', '', 'Brass', 'B59', '', '0', '{\"od\":\"5.125\"}', '0', '0', '0', '0', '0', '0', '10');
INSERT INTO `tbl_material` VALUES ('60', '5.000RD-B16', '143', '0', '16', '0', '1', '1450111259', '4', '0', '0', '1', '', '', '', 'Brass', 'B60', '', '0', '{\"od\":\"5.000\"}', '0', '0', '0', '0', '0', '0', '4.5');
INSERT INTO `tbl_material` VALUES ('61', '3.250RD-B16', '139', '0', '16', '0', '1', '1450111812', '4', '0', '0', '1', '', '', '', 'Brass', 'B61', '', '0', '{\"od\":\"3.250\"}', '0', '0', '0', '0', '0', '0', '4.625');
INSERT INTO `tbl_material` VALUES ('62', '3.000RD-B16', '138', '0', '16', '0', '1', '1450112394', '4', '0', '0', '1', '', '', '', 'Brass', 'B62', '', '0', '{\"od\":\"3.000\"}', '0', '0', '0', '0', '0', '0', '1');
INSERT INTO `tbl_material` VALUES ('63', '4.500RD-B16', '142', '0', '16', '0', '1', '1450114391', '4', '0', '0', '1', '', '', '', 'Brass', 'B63', '', '0', '{\"od\":\"4.500\"}', '0', '1', '0', '0', '0', '0', '7');
INSERT INTO `tbl_material` VALUES ('64', '6.000RD-B16', '145', '0', '16', '0', '1', '1450114998', '4', '0', '0', '1', '', '', '', 'Brass', 'B64', '', '0', '{\"od\":\"6.000\"}', '0', '0', '0', '0', '0', '0', '2.25');
INSERT INTO `tbl_material` VALUES ('65', '2.500RD-316', '81', '0', '17', '0', '1', '1450115770', '4', '0', '0', '1', '', '', '', 'Other', 'A65', '', '0', '{\"od\":\"2.500\"}', '0', '3', '0', '0', '0', '0', '23.75');
INSERT INTO `tbl_material` VALUES ('66', '2.125RD-316', '83', '0', '17', '0', '1', '1450117638', '4', '0', '0', '1', '', '', '', 'General', 'C66', '', '0', '{\"od\":\"2.125\"}', '0', '1', '0', '0', '0', '0', '1.75');
INSERT INTO `tbl_material` VALUES ('67', '2.000RD-316', '79', '0', '17', '0', '1', '1450117923', '4', '0', '0', '1', '', '', '', 'General', 'C67', '', '0', '{\"od\":\"2.000\"}', '0', '0', '0', '0', '0', '0', '2');
INSERT INTO `tbl_material` VALUES ('68', '2.750RD-316', '82', '0', '17', '0', '1', '1450118250', '4', '0', '0', '1', '', '', '', 'General', 'C68', '', '0', '{\"od\":\"2.750\"}', '0', '0', '0', '0', '0', '0', '6.5');
INSERT INTO `tbl_material` VALUES ('69', '3.750RD-316', '89', '0', '17', '0', '1', '1450118722', '4', '0', '0', '1', '', '', '', 'General', 'C69', '', '0', '{\"od\":\"3.750\"}', '0', '1', '0', '0', '0', '0', '8');
INSERT INTO `tbl_material` VALUES ('70', '3.625RD-316', '91', '0', '17', '0', '1', '1451922856', '4', '0', '0', '1', '', '', '', 'Other', 'A70', '', '0', '{\"od\":\"3.625\"}', '0', '0', '0', '0', '0', '0', '17.5');
INSERT INTO `tbl_material` VALUES ('71', '3.250RD-316', '88', '0', '17', '0', '1', '1451923182', '4', '0', '0', '2', '', '', '', 'Other', 'A71', '', '0', '{\"od\":\"3.25\"}', '0', '3', '0', '0', '0', '0', '6.25');
INSERT INTO `tbl_material` VALUES ('72', '1.625RD-1018', '355', '0', '3', '0', '1', '1453462133', '1', '0', '0', '1', '', '', '', 'General', '', '', '0', '{\"size\":\"\"}', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_material` VALUES ('73', '3.00RD-4130 ANN', '357', '0', '35', '0', '1', '1455293522', '4', '0', '0', '1', '', '', '', 'Other', '', '', '0', '{\"od\":\"3.0\"}', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_material` VALUES ('74', '1.125RD-4130 ANN', '358', '0', '35', '0', '1', '1455293547', '4', '0', '0', '1', '', '', '', 'Other', '', '', '0', '{\"od\":\"1.125\"}', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_material` VALUES ('75', '6061-T6 Aluminum Blo', '359', '0', '37', '0', '1', '1457729017', '2', '0', '0', '1', '', '', '', 'Other', '', '', '0', '{\"w\":\"\",\"h\":\"\"}', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_material` VALUES ('76', '12.00RD-GreyIron', '360', '0', '38', '0', '1', '1457793639', '4', '0', '0', '1', '', '<p>Material is Usual supplied by SNS</p>\n', '', 'Other', '', '', '0', '{\"od\":\"12.0\"}', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_material` VALUES ('77', '2.00RD-6061', '361', '0', '37', '0', '1', '1462297858', '4', '0', '0', '1', '', '', '', 'Other', '', '', '0', '{\"od\":\"2.00\"}', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_material` VALUES ('78', '1.125RD-6061', '362', '0', '37', '0', '1', '1462297954', '4', '0', '0', '1', '', '', '', 'Other', '', '', '0', '{\"od\":\"1.125\"}', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_material` VALUES ('79', '1.00RD-6061', '363', '0', '37', '0', '1', '1462298002', '4', '0', '0', '1', '', '', '', 'Other', '', '', '0', '{\"od\":\"1.00\"}', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_material` VALUES ('80', '1.50RD 6061', '364', '0', '37', '0', '1', '1462298381', '4', '0', '0', '1', '', '', '', 'Other', '', '', '0', '{\"od\":\"1.50\"}', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_material` VALUES ('81', '.750HX-316', '104', '0', '17', '0', '1', '1462298852', '1', '0', '0', '1', '', '', '', 'Other', '', '', '0', '{\"size\":\".750\"}', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_material` VALUES ('82', '.750RD-6061', '365', '0', '37', '0', '1', '1462625817', '4', '0', '0', '1', '', '', '', 'Other', '', '', '0', '{\"od\":\".750\"}', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_material` VALUES ('83', '1.166\" T-12 DP-12 PA', '366', '0', '24', '0', '1', '1463171135', '4', '0', '0', '1', '', '<p>GEAR STOCK</p>\n', '', 'Other', '', '', '0', '{\"od\":\"1.25\"}', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_material` VALUES ('84', '2.166\" T-24 DP-12 PA', '367', '0', '33', '0', '1', '1463171177', '4', '0', '0', '1', '', '<p>GEAR STOCK</p>\n', '', 'Other', '', '', '0', '{\"od\":\"2.166\"}', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_material` VALUES ('85', '1.25\" T-28 DP-24 PA-', '368', '0', '33', '0', '1', '1463171223', '4', '0', '0', '1', '', '<p>GEAR STOCK FROM SUMMIT OR ODG</p>\n', '', 'Other', '', '', '0', '{\"od\":\"1.25\"}', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_material` VALUES ('86', '2.50\" T-58 DP-24 PA-', '369', '0', '33', '0', '1', '1463171269', '4', '0', '0', '1', '', '<p>GEAR STOCK FROM SUMMIT OR ODG</p>\n', '', 'Other', '', '', '0', '{\"od\":\"2.50\"}', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_material` VALUES ('87', '4.25DIA-Cast Elec BX', '370', '0', '41', '0', '1', '1469465948', '7', '0', '0', '1', '', '<p>Electtric Box Castings</p>\n', '', 'Other', '', '', '0', '{\"w\":\"5.0\",\"h\":\"2.438\"}', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `tbl_material` VALUES ('88', '1.625RD-6061T6', '371', '0', '37', '0', '1', '1472745251', '4', '0', '0', '1', '', '', '', 'Other', '', '', '0', '{\"od\":\"1.625\"}', '0', '0', '0', '0', '0', '0', '0');

-- ----------------------------
-- Table structure for tbl_materiallocation
-- ----------------------------
DROP TABLE IF EXISTS `tbl_materiallocation`;
CREATE TABLE `tbl_materiallocation` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `status` tinyint(1) unsigned NOT NULL,
  `rack` varchar(255) CHARACTER SET armscii8 NOT NULL,
  `row` varchar(255) CHARACTER SET armscii8 NOT NULL,
  `box` varchar(255) CHARACTER SET armscii8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=159 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of tbl_materiallocation
-- ----------------------------
INSERT INTO `tbl_materiallocation` VALUES ('1', '1', 'rack 1', 'row 1', 'box 1');
INSERT INTO `tbl_materiallocation` VALUES ('2', '1', 'rack 2', 'row 2', 'box 2');
INSERT INTO `tbl_materiallocation` VALUES ('3', '1', 'rack 3', 'row 3', 'box 3');
INSERT INTO `tbl_materiallocation` VALUES ('4', '1', 'RACK1', 'ROW1', '-');
INSERT INTO `tbl_materiallocation` VALUES ('5', '1', 'RACK1', 'ROW2', '-');
INSERT INTO `tbl_materiallocation` VALUES ('6', '1', 'RACK1', 'ROW3', '-');
INSERT INTO `tbl_materiallocation` VALUES ('7', '1', 'RACK1', 'ROW4', '-');
INSERT INTO `tbl_materiallocation` VALUES ('8', '1', 'RACK1', 'ROW5', '-');
INSERT INTO `tbl_materiallocation` VALUES ('9', '1', 'RACK1', 'ROW6', '-');
INSERT INTO `tbl_materiallocation` VALUES ('10', '1', 'RACK1', 'ROW7', '-');
INSERT INTO `tbl_materiallocation` VALUES ('11', '1', 'RACK2', 'ROW1', '-');
INSERT INTO `tbl_materiallocation` VALUES ('12', '1', 'RACK2', 'ROW2', '-');
INSERT INTO `tbl_materiallocation` VALUES ('13', '1', 'RACK2', 'ROW3', '-');
INSERT INTO `tbl_materiallocation` VALUES ('14', '1', 'RACK2', 'ROW4', '-');
INSERT INTO `tbl_materiallocation` VALUES ('15', '1', 'RACK2', 'ROW5', '-');
INSERT INTO `tbl_materiallocation` VALUES ('16', '1', 'RACK2', 'ROW6', '-');
INSERT INTO `tbl_materiallocation` VALUES ('17', '1', 'RACK2', 'ROW7', '-');
INSERT INTO `tbl_materiallocation` VALUES ('18', '1', 'RACK2', 'ROW8', '-');
INSERT INTO `tbl_materiallocation` VALUES ('19', '1', 'RACK3', 'ROW1', '-');
INSERT INTO `tbl_materiallocation` VALUES ('20', '1', 'RACK3', 'ROW2', '-');
INSERT INTO `tbl_materiallocation` VALUES ('21', '1', 'RACK3', 'ROW3', '-');
INSERT INTO `tbl_materiallocation` VALUES ('22', '1', 'RACK3', 'BACK SHELF', '-');
INSERT INTO `tbl_materiallocation` VALUES ('23', '1', 'RACK4', 'ROW1', '-');
INSERT INTO `tbl_materiallocation` VALUES ('24', '1', 'RACK4', 'ROW2', '-');
INSERT INTO `tbl_materiallocation` VALUES ('25', '1', 'RACK4', 'ROW3', '-');
INSERT INTO `tbl_materiallocation` VALUES ('26', '1', 'RACK4', 'BACK SHELF', '-');
INSERT INTO `tbl_materiallocation` VALUES ('27', '1', 'RACK5', 'ROW1', '-');
INSERT INTO `tbl_materiallocation` VALUES ('28', '1', 'RACK5', 'ROW2', '-');
INSERT INTO `tbl_materiallocation` VALUES ('29', '1', 'RACK5', 'ROW3', '-');
INSERT INTO `tbl_materiallocation` VALUES ('30', '1', 'RACK5', 'BACK SHELF', '-');
INSERT INTO `tbl_materiallocation` VALUES ('31', '1', 'RACK6', 'ROW1', '-');
INSERT INTO `tbl_materiallocation` VALUES ('32', '1', 'RACK6', 'ROW2', '-');
INSERT INTO `tbl_materiallocation` VALUES ('33', '1', 'RACK6', 'ROW3', '-');
INSERT INTO `tbl_materiallocation` VALUES ('34', '1', 'RACK6', 'BACK SHELF', '-');
INSERT INTO `tbl_materiallocation` VALUES ('35', '1', 'RACK7', 'ROW1', '-');
INSERT INTO `tbl_materiallocation` VALUES ('36', '1', 'RACK7', 'ROW2', '-');
INSERT INTO `tbl_materiallocation` VALUES ('37', '1', 'RACK7', 'ROW3', '-');
INSERT INTO `tbl_materiallocation` VALUES ('38', '1', 'RACK7', 'ROW4', '-');
INSERT INTO `tbl_materiallocation` VALUES ('39', '1', 'RACK7', 'ROW5', '-');
INSERT INTO `tbl_materiallocation` VALUES ('40', '1', 'RACK7', 'ROW6', '-');
INSERT INTO `tbl_materiallocation` VALUES ('41', '1', 'RACK7', 'ROW7', '-');
INSERT INTO `tbl_materiallocation` VALUES ('42', '1', 'RACK7', 'ROW8', '-');
INSERT INTO `tbl_materiallocation` VALUES ('43', '1', 'RACK7', 'ROW9', '-');
INSERT INTO `tbl_materiallocation` VALUES ('44', '1', 'RACK7', 'ROW10', '-');
INSERT INTO `tbl_materiallocation` VALUES ('45', '1', 'RACK7', 'ROW11', '-');
INSERT INTO `tbl_materiallocation` VALUES ('46', '1', 'RACK7', 'ROW12', '-');
INSERT INTO `tbl_materiallocation` VALUES ('47', '1', 'RACK8', 'ROW1', '-');
INSERT INTO `tbl_materiallocation` VALUES ('48', '1', 'RACK8', 'ROW2', 'BOX30-A');
INSERT INTO `tbl_materiallocation` VALUES ('49', '1', 'RACK8', 'ROW2', '-');
INSERT INTO `tbl_materiallocation` VALUES ('50', '1', 'RACK8', 'ROW2', 'BOX30-B');
INSERT INTO `tbl_materiallocation` VALUES ('51', '1', 'RACK8', 'ROW2', 'BOX30-C');
INSERT INTO `tbl_materiallocation` VALUES ('52', '1', 'RACK8', 'ROW2', 'BOC30-D');
INSERT INTO `tbl_materiallocation` VALUES ('53', '1', 'RACK8', 'ROW2', 'BOX30-E');
INSERT INTO `tbl_materiallocation` VALUES ('54', '1', 'RACK8', 'ROW2', 'BOX31-A');
INSERT INTO `tbl_materiallocation` VALUES ('55', '1', 'RACK8', 'ROW2', 'BOX31-B');
INSERT INTO `tbl_materiallocation` VALUES ('56', '1', 'RACK8', 'ROW2', 'BOX31-C');
INSERT INTO `tbl_materiallocation` VALUES ('57', '1', 'RACK8', 'ROW2', 'BOX31-D');
INSERT INTO `tbl_materiallocation` VALUES ('58', '1', 'RACK8', 'ROW2', 'BOX31-E');
INSERT INTO `tbl_materiallocation` VALUES ('59', '1', 'RACK8', 'ROW2', 'BOX32-A');
INSERT INTO `tbl_materiallocation` VALUES ('60', '1', 'RACK8', 'ROW2', 'BOX32-B');
INSERT INTO `tbl_materiallocation` VALUES ('61', '1', 'RACK8', 'ROW2', 'BOX32-C');
INSERT INTO `tbl_materiallocation` VALUES ('62', '1', 'RACK8', 'ROW2', 'BOX32-D');
INSERT INTO `tbl_materiallocation` VALUES ('63', '1', 'RACK8', 'ROW2', 'BOX32-E');
INSERT INTO `tbl_materiallocation` VALUES ('64', '1', 'RACK8', 'ROW2', 'BOX33-A');
INSERT INTO `tbl_materiallocation` VALUES ('65', '1', 'RACK8', 'ROW2', 'BOX33-B');
INSERT INTO `tbl_materiallocation` VALUES ('66', '1', 'RACK8', 'ROW2', 'BOX33-C');
INSERT INTO `tbl_materiallocation` VALUES ('67', '1', 'RACK8', 'ROW2', 'BOX33-D');
INSERT INTO `tbl_materiallocation` VALUES ('68', '1', 'RACK8', 'ROW2', 'BOX33-D');
INSERT INTO `tbl_materiallocation` VALUES ('69', '1', 'RACK8', 'ROW2', 'BOX33-E');
INSERT INTO `tbl_materiallocation` VALUES ('70', '1', 'RACK8', 'ROW2', 'BOX34-A');
INSERT INTO `tbl_materiallocation` VALUES ('71', '1', 'RACK8', 'ROW2', 'BOX34-B');
INSERT INTO `tbl_materiallocation` VALUES ('72', '1', 'RACK8', 'ROW2', 'BOX34-C');
INSERT INTO `tbl_materiallocation` VALUES ('73', '1', 'RACK8', 'ROW2', 'BOX34-D');
INSERT INTO `tbl_materiallocation` VALUES ('74', '1', 'RACK8', 'ROW2', 'BOX34-E');
INSERT INTO `tbl_materiallocation` VALUES ('75', '1', 'RACK8', 'ROW2', 'BOX35-A');
INSERT INTO `tbl_materiallocation` VALUES ('76', '1', 'RACK8', 'ROW2', 'BOX35-B');
INSERT INTO `tbl_materiallocation` VALUES ('77', '1', 'RACK8', 'ROW2', 'BOX35-C');
INSERT INTO `tbl_materiallocation` VALUES ('78', '1', 'RACK8', 'ROW2', 'BOX35-D');
INSERT INTO `tbl_materiallocation` VALUES ('79', '1', 'RACK8', 'ROW2', 'BOX35-E');
INSERT INTO `tbl_materiallocation` VALUES ('80', '1', 'RACK8', 'ROW3', 'BOX1');
INSERT INTO `tbl_materiallocation` VALUES ('81', '1', 'RACK8', 'ROW3', 'BOX2');
INSERT INTO `tbl_materiallocation` VALUES ('82', '1', 'RACK8', 'ROW3', 'BOX3');
INSERT INTO `tbl_materiallocation` VALUES ('83', '1', 'RACK8', 'ROW3', 'BOX4');
INSERT INTO `tbl_materiallocation` VALUES ('84', '1', 'RACK8', 'ROW3', 'BOX5');
INSERT INTO `tbl_materiallocation` VALUES ('85', '1', 'RACK8', 'ROW3', 'BOX6');
INSERT INTO `tbl_materiallocation` VALUES ('86', '1', 'RACK8', 'ROW3', 'BOX7');
INSERT INTO `tbl_materiallocation` VALUES ('87', '1', 'RACK8', 'ROW3', 'BOX8');
INSERT INTO `tbl_materiallocation` VALUES ('88', '1', 'RACK8', 'ROW3', 'BOX9');
INSERT INTO `tbl_materiallocation` VALUES ('89', '1', 'RACK8', 'ROW3', 'BOX10');
INSERT INTO `tbl_materiallocation` VALUES ('90', '1', 'RACK8', 'ROW3', 'BOX11');
INSERT INTO `tbl_materiallocation` VALUES ('91', '1', 'RACK8', 'ROW3', 'BOX12');
INSERT INTO `tbl_materiallocation` VALUES ('92', '1', 'RACK8', 'ROW3', 'BOX13');
INSERT INTO `tbl_materiallocation` VALUES ('93', '1', 'RACK8', 'ROW3', 'BOX14');
INSERT INTO `tbl_materiallocation` VALUES ('94', '1', 'RACK8', 'ROW3', 'BOX15');
INSERT INTO `tbl_materiallocation` VALUES ('95', '1', 'RACK8', 'ROW3', 'BOX16');
INSERT INTO `tbl_materiallocation` VALUES ('96', '1', 'RACK8', 'ROW3', 'BOX17');
INSERT INTO `tbl_materiallocation` VALUES ('97', '1', 'RACK8', 'ROW3', 'BOX18');
INSERT INTO `tbl_materiallocation` VALUES ('98', '1', 'RACK8', 'ROW3', 'BOX19');
INSERT INTO `tbl_materiallocation` VALUES ('99', '1', 'RACK8', 'ROW3', 'BOX20');
INSERT INTO `tbl_materiallocation` VALUES ('100', '1', 'RACK8', 'ROW3', 'BOX21');
INSERT INTO `tbl_materiallocation` VALUES ('101', '1', 'RACK8', 'ROW3', 'BOX22');
INSERT INTO `tbl_materiallocation` VALUES ('102', '1', 'RACK8', 'ROW3', 'BOX23');
INSERT INTO `tbl_materiallocation` VALUES ('103', '1', 'RACK8', 'ROW3', 'BOX24');
INSERT INTO `tbl_materiallocation` VALUES ('104', '1', 'RACK8', 'ROW3', 'BOX25');
INSERT INTO `tbl_materiallocation` VALUES ('105', '1', 'RACK8', 'ROW3', 'BOX26');
INSERT INTO `tbl_materiallocation` VALUES ('106', '1', 'RACK8', 'ROW3', 'BOX27');
INSERT INTO `tbl_materiallocation` VALUES ('107', '1', 'RACK8', 'ROW3', 'BOX28');
INSERT INTO `tbl_materiallocation` VALUES ('108', '1', 'RACK8', 'ROW3', 'BOX29');
INSERT INTO `tbl_materiallocation` VALUES ('109', '1', 'RACK8', 'ROW3', '-');
INSERT INTO `tbl_materiallocation` VALUES ('110', '1', 'RACK8', 'ROW4', '-');
INSERT INTO `tbl_materiallocation` VALUES ('111', '1', 'RACK8', 'ROW4', 'BOX1');
INSERT INTO `tbl_materiallocation` VALUES ('112', '1', 'RACK8', 'ROW4', 'BOX2');
INSERT INTO `tbl_materiallocation` VALUES ('113', '1', 'RACK8', 'ROW4', 'BOX3');
INSERT INTO `tbl_materiallocation` VALUES ('114', '1', 'RACK8', 'ROW4', 'BOX4');
INSERT INTO `tbl_materiallocation` VALUES ('115', '1', 'RACK8', 'ROW4', 'BOX5');
INSERT INTO `tbl_materiallocation` VALUES ('116', '1', 'RACK8', 'ROW5', '-');
INSERT INTO `tbl_materiallocation` VALUES ('117', '1', 'RACK8', 'ROW5', 'BOX1');
INSERT INTO `tbl_materiallocation` VALUES ('118', '1', 'RACK8', 'ROW5', 'BOX2');
INSERT INTO `tbl_materiallocation` VALUES ('119', '1', 'RACK8', 'ROW5', 'BOX3');
INSERT INTO `tbl_materiallocation` VALUES ('120', '1', 'RACK8', 'ROW5', 'BOX4');
INSERT INTO `tbl_materiallocation` VALUES ('121', '1', 'RACK8', 'ROW5', 'BOX5');
INSERT INTO `tbl_materiallocation` VALUES ('122', '1', 'RACK8', 'ROW5', 'BOX6');
INSERT INTO `tbl_materiallocation` VALUES ('123', '1', 'RACK8', 'ROW5', 'BOX6');
INSERT INTO `tbl_materiallocation` VALUES ('124', '1', 'RACK8', 'ROW5', 'BOX7');
INSERT INTO `tbl_materiallocation` VALUES ('125', '1', 'RACK8', 'ROW5', 'BOX8');
INSERT INTO `tbl_materiallocation` VALUES ('126', '1', 'RACK8', 'ROW5', 'BOX9');
INSERT INTO `tbl_materiallocation` VALUES ('127', '1', 'RACK8', 'ROW5', 'BOX10');
INSERT INTO `tbl_materiallocation` VALUES ('128', '1', 'RACK8', 'ROW5', 'BOX11');
INSERT INTO `tbl_materiallocation` VALUES ('129', '1', 'RACK8', 'ROW5', 'BOX12');
INSERT INTO `tbl_materiallocation` VALUES ('130', '1', 'RACK8', 'ROW5', 'BOX13');
INSERT INTO `tbl_materiallocation` VALUES ('131', '1', 'RACK8', 'ROW5', 'BOX14');
INSERT INTO `tbl_materiallocation` VALUES ('132', '1', 'RACK8', 'ROW6', '-');
INSERT INTO `tbl_materiallocation` VALUES ('133', '1', 'RACK8', 'ROW6', 'BOX1');
INSERT INTO `tbl_materiallocation` VALUES ('134', '1', 'RACK9', 'ROW1', '-');
INSERT INTO `tbl_materiallocation` VALUES ('135', '1', 'RACK9', 'ROW2', 'BOX1');
INSERT INTO `tbl_materiallocation` VALUES ('136', '1', 'RACK9', 'ROW2', 'BOX2');
INSERT INTO `tbl_materiallocation` VALUES ('137', '1', 'RACK9', 'ROW2', 'BOX3');
INSERT INTO `tbl_materiallocation` VALUES ('138', '1', 'RACK9', 'ROW2', 'BOX4');
INSERT INTO `tbl_materiallocation` VALUES ('139', '1', 'RACK9', 'ROW2', 'BOX5');
INSERT INTO `tbl_materiallocation` VALUES ('140', '1', 'RACK9', 'ROW2', 'BOX6');
INSERT INTO `tbl_materiallocation` VALUES ('141', '1', 'RACK9', 'ROW2', 'BOX7');
INSERT INTO `tbl_materiallocation` VALUES ('142', '1', 'RACK9', 'ROW2', 'BOX8');
INSERT INTO `tbl_materiallocation` VALUES ('143', '1', 'RACK9', 'ROW2', 'BOX9');
INSERT INTO `tbl_materiallocation` VALUES ('144', '1', 'RACK9', 'ROW3', '-');
INSERT INTO `tbl_materiallocation` VALUES ('145', '1', 'RACK9', 'ROW3', 'BOX1');
INSERT INTO `tbl_materiallocation` VALUES ('146', '1', 'RACK9', 'ROW3', 'BOX2');
INSERT INTO `tbl_materiallocation` VALUES ('147', '1', 'RACK9', 'ROW3', 'BOX3');
INSERT INTO `tbl_materiallocation` VALUES ('148', '1', 'RACK9', 'ROW3', 'BOX4');
INSERT INTO `tbl_materiallocation` VALUES ('149', '1', 'RACK9', 'ROW4', '-');
INSERT INTO `tbl_materiallocation` VALUES ('150', '1', 'RACK9', 'ROW5', '-');
INSERT INTO `tbl_materiallocation` VALUES ('151', '1', 'RACK9', 'ROW6', '-');
INSERT INTO `tbl_materiallocation` VALUES ('152', '1', 'RACK1', 'FLOOR', '-');
INSERT INTO `tbl_materiallocation` VALUES ('153', '1', 'RACK2', 'FLOOR', '-');
INSERT INTO `tbl_materiallocation` VALUES ('154', '1', 'SAW', 'FLOOR', '-');
INSERT INTO `tbl_materiallocation` VALUES ('155', '1', 'ORANGE RACK', 'FLOOR', '-');
INSERT INTO `tbl_materiallocation` VALUES ('156', '1', 'ORANGE RACK', 'ROW1', '-');
INSERT INTO `tbl_materiallocation` VALUES ('157', '1', 'ORANGE RACK', 'ROW2', '-');
INSERT INTO `tbl_materiallocation` VALUES ('158', '1', 'ORANGE RACK', 'ROW3', '-');

-- ----------------------------
-- Table structure for tbl_materiallocation_material
-- ----------------------------
DROP TABLE IF EXISTS `tbl_materiallocation_material`;
CREATE TABLE `tbl_materiallocation_material` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `material_id` int(10) NOT NULL,
  `location_id` int(11) NOT NULL,
  `created_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of tbl_materiallocation_material
-- ----------------------------
INSERT INTO `tbl_materiallocation_material` VALUES ('1', '14', '1', '1445241020');
INSERT INTO `tbl_materiallocation_material` VALUES ('2', '14', '2', '1445241020');
INSERT INTO `tbl_materiallocation_material` VALUES ('3', '10', '1', '1445340480');
INSERT INTO `tbl_materiallocation_material` VALUES ('4', '10', '2', '1445340480');
INSERT INTO `tbl_materiallocation_material` VALUES ('5', '10', '3', '1445340480');
INSERT INTO `tbl_materiallocation_material` VALUES ('6', '8', '2', '1445765240');
INSERT INTO `tbl_materiallocation_material` VALUES ('7', '24', '2', '1445838294');
INSERT INTO `tbl_materiallocation_material` VALUES ('8', '24', '3', '1446634220');
INSERT INTO `tbl_materiallocation_material` VALUES ('9', '28', '1', '1446636157');
INSERT INTO `tbl_materiallocation_material` VALUES ('10', '28', '2', '1446636157');
INSERT INTO `tbl_materiallocation_material` VALUES ('11', '28', '3', '1446636157');
INSERT INTO `tbl_materiallocation_material` VALUES ('12', '30', '1', '1447214414');
INSERT INTO `tbl_materiallocation_material` VALUES ('13', '31', '1', '1447807553');
INSERT INTO `tbl_materiallocation_material` VALUES ('14', '32', '2', '1447807587');
INSERT INTO `tbl_materiallocation_material` VALUES ('15', '33', '1', '1447807623');
INSERT INTO `tbl_materiallocation_material` VALUES ('16', '34', '1', '1447807657');
INSERT INTO `tbl_materiallocation_material` VALUES ('17', '35', '1', '1448016439');
INSERT INTO `tbl_materiallocation_material` VALUES ('18', '36', '17', '1448024982');
INSERT INTO `tbl_materiallocation_material` VALUES ('19', '37', '26', '1448025590');
INSERT INTO `tbl_materiallocation_material` VALUES ('20', '38', '37', '1448026701');
INSERT INTO `tbl_materiallocation_material` VALUES ('21', '39', '40', '1448028622');
INSERT INTO `tbl_materiallocation_material` VALUES ('22', '39', '36', '1448028983');
INSERT INTO `tbl_materiallocation_material` VALUES ('23', '40', '25', '1448029440');
INSERT INTO `tbl_materiallocation_material` VALUES ('24', '40', '24', '1448029604');
INSERT INTO `tbl_materiallocation_material` VALUES ('25', '39', '27', '1448029838');
INSERT INTO `tbl_materiallocation_material` VALUES ('26', '41', '26', '1448029993');
INSERT INTO `tbl_materiallocation_material` VALUES ('27', '42', '27', '1448031430');
INSERT INTO `tbl_materiallocation_material` VALUES ('28', '55', '150', '1450096178');
INSERT INTO `tbl_materiallocation_material` VALUES ('29', '56', '150', '1450100563');
INSERT INTO `tbl_materiallocation_material` VALUES ('30', '57', '150', '1450101180');
INSERT INTO `tbl_materiallocation_material` VALUES ('31', '58', '150', '1450101548');
INSERT INTO `tbl_materiallocation_material` VALUES ('32', '59', '135', '1450108942');
INSERT INTO `tbl_materiallocation_material` VALUES ('33', '60', '136', '1450111259');
INSERT INTO `tbl_materiallocation_material` VALUES ('34', '61', '136', '1450111812');
INSERT INTO `tbl_materiallocation_material` VALUES ('35', '62', '136', '1450112394');
INSERT INTO `tbl_materiallocation_material` VALUES ('36', '63', '137', '1450114392');
INSERT INTO `tbl_materiallocation_material` VALUES ('37', '64', '138', '1450114998');
INSERT INTO `tbl_materiallocation_material` VALUES ('38', '65', '139', '1450115770');
INSERT INTO `tbl_materiallocation_material` VALUES ('39', '66', '139', '1450117638');
INSERT INTO `tbl_materiallocation_material` VALUES ('40', '67', '139', '1450117923');
INSERT INTO `tbl_materiallocation_material` VALUES ('41', '68', '140', '1450118251');
INSERT INTO `tbl_materiallocation_material` VALUES ('42', '65', '140', '1450118456');
INSERT INTO `tbl_materiallocation_material` VALUES ('43', '69', '141', '1450118722');
INSERT INTO `tbl_materiallocation_material` VALUES ('44', '22', '154', '1450270911');
INSERT INTO `tbl_materiallocation_material` VALUES ('45', '32', '154', '1450275277');
INSERT INTO `tbl_materiallocation_material` VALUES ('46', '70', '141', '1451922857');
INSERT INTO `tbl_materiallocation_material` VALUES ('47', '71', '141', '1451923182');
INSERT INTO `tbl_materiallocation_material` VALUES ('48', '72', '151', '1453462134');
INSERT INTO `tbl_materiallocation_material` VALUES ('49', '69', '142', '1453822745');
INSERT INTO `tbl_materiallocation_material` VALUES ('50', '71', '142', '1453822875');
INSERT INTO `tbl_materiallocation_material` VALUES ('51', '26', '145', '1453823468');
INSERT INTO `tbl_materiallocation_material` VALUES ('52', '76', '154', '1457793639');
INSERT INTO `tbl_materiallocation_material` VALUES ('53', '46', '154', '1457794821');

-- ----------------------------
-- Table structure for tbl_material_attribute
-- ----------------------------
DROP TABLE IF EXISTS `tbl_material_attribute`;
CREATE TABLE `tbl_material_attribute` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `material_id` int(11) unsigned NOT NULL,
  `size_in_ft` float unsigned NOT NULL,
  `count` int(11) unsigned NOT NULL,
  `weight` int(11) unsigned NOT NULL,
  `optimum_inventory` int(11) unsigned NOT NULL,
  `stock_in_hand` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_time` int(11) unsigned NOT NULL,
  `vendor_size_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_material_attribute
-- ----------------------------
INSERT INTO `tbl_material_attribute` VALUES ('1', '1', '3', '400', '480', '1000', '1789', '1', '1425199249', '0');
INSERT INTO `tbl_material_attribute` VALUES ('2', '2', '3', '400', '480', '1000', '1789', '1', '1425199249', '0');
INSERT INTO `tbl_material_attribute` VALUES ('3', '3', '4', '22', '200', '1000', '794', '1', '1427648529', '0');
INSERT INTO `tbl_material_attribute` VALUES ('4', '4', '15', '42', '15', '15', '120', '1', '1427649051', '0');
INSERT INTO `tbl_material_attribute` VALUES ('5', '4', '16', '32', '16', '16', '100', '1', '1427649196', '0');
INSERT INTO `tbl_material_attribute` VALUES ('6', '4', '17', '35', '17', '17', '80', '1', '1427649282', '0');
INSERT INTO `tbl_material_attribute` VALUES ('7', '5', '1', '1', '1', '1', '-99', '1', '1427649407', '0');
INSERT INTO `tbl_material_attribute` VALUES ('8', '6', '1', '1', '1', '1', '1', '1', '1427649510', '0');
INSERT INTO `tbl_material_attribute` VALUES ('9', '7', '10', '100', '2000', '300', '500', '1', '1428683379', '0');
INSERT INTO `tbl_material_attribute` VALUES ('10', '7', '20', '200', '1200', '500', '800', '1', '1428683917', '0');
INSERT INTO `tbl_material_attribute` VALUES ('12', '7', '30', '150', '3400', '600', '900', '1', '1428684599', '0');
INSERT INTO `tbl_material_attribute` VALUES ('13', '7', '40', '160', '3500', '900', '1100', '1', '1428684748', '0');
INSERT INTO `tbl_material_attribute` VALUES ('14', '7', '12', '32', '32', '23', '11', '1', '1428860003', '0');
INSERT INTO `tbl_material_attribute` VALUES ('15', '8', '12', '12', '3', '4', '12', '1', '1428860522', '0');
INSERT INTO `tbl_material_attribute` VALUES ('16', '8', '12', '4', '5', '6', '1', '1', '1428860522', '0');
INSERT INTO `tbl_material_attribute` VALUES ('17', '9', '10', '150', '1200', '900', '1000', '1', '1428945623', '0');
INSERT INTO `tbl_material_attribute` VALUES ('18', '9', '15', '20', '3000', '90', '210', '1', '1428945623', '0');
INSERT INTO `tbl_material_attribute` VALUES ('19', '9', '20', '300', '6000', '900', '1300', '1', '1428945623', '0');

-- ----------------------------
-- Table structure for tbl_material_category
-- ----------------------------
DROP TABLE IF EXISTS `tbl_material_category`;
CREATE TABLE `tbl_material_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `created_time` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=armscii8;

-- ----------------------------
-- Records of tbl_material_category
-- ----------------------------
INSERT INTO `tbl_material_category` VALUES ('3', 'Steel', '1', '1');
INSERT INTO `tbl_material_category` VALUES ('5', 'Copper', '1', '1');
INSERT INTO `tbl_material_category` VALUES ('6', 'Alumina', '1', '1428684900');
INSERT INTO `tbl_material_category` VALUES ('7', '4140 Gr B7M', '1', '1439641700');
INSERT INTO `tbl_material_category` VALUES ('8', '12l14', '1', '1439641703');
INSERT INTO `tbl_material_category` VALUES ('9', '1018', '1', '1439641706');
INSERT INTO `tbl_material_category` VALUES ('10', 'Duplex 2205', '1', '1439641709');
INSERT INTO `tbl_material_category` VALUES ('11', 'Duplex Zeron 100', '1', '1439641711');
INSERT INTO `tbl_material_category` VALUES ('12', 'HactC', '1', '1439641712');
INSERT INTO `tbl_material_category` VALUES ('13', 'HastB', '1', '1439641714');
INSERT INTO `tbl_material_category` VALUES ('14', 'Monel Alloy 400', '1', '1439641716');
INSERT INTO `tbl_material_category` VALUES ('15', 'Titanium Gr. 2', '1', '1439641718');
INSERT INTO `tbl_material_category` VALUES ('16', 'Brass', '1', '1439641719');
INSERT INTO `tbl_material_category` VALUES ('17', '316ss', '1', '1439641724');
INSERT INTO `tbl_material_category` VALUES ('18', '304ss', '1', '1439641726');
INSERT INTO `tbl_material_category` VALUES ('19', '303ss', '1', '1439641730');
INSERT INTO `tbl_material_category` VALUES ('20', '317ss', '1', '1439641732');
INSERT INTO `tbl_material_category` VALUES ('21', '4140HT', '1', '15');
INSERT INTO `tbl_material_category` VALUES ('22', 'PLATE STEEL', '1', '1441843350');
INSERT INTO `tbl_material_category` VALUES ('23', '100K CHROMED SHAFTING', '1', '1441843365');
INSERT INTO `tbl_material_category` VALUES ('24', '4140AN', '1', '1442326433');
INSERT INTO `tbl_material_category` VALUES ('25', 'NYLON MC901', '1', '1443529282');
INSERT INTO `tbl_material_category` VALUES ('26', 'O-1\\Steel', '1', '1445038645');
INSERT INTO `tbl_material_category` VALUES ('27', '50W(350W) STRUCTUAL STEEL', '1', '1446835627');
INSERT INTO `tbl_material_category` VALUES ('28', '317SS', '1', '1447938110');
INSERT INTO `tbl_material_category` VALUES ('29', 'UHMW POLY', '1', '1448410496');
INSERT INTO `tbl_material_category` VALUES ('30', 'C1045', '1', '1448411787');
INSERT INTO `tbl_material_category` VALUES ('31', 'A53-B PIPE', '1', '1449600390');
INSERT INTO `tbl_material_category` VALUES ('32', '1213 CD', '1', '1449600410');
INSERT INTO `tbl_material_category` VALUES ('33', '1215 CD', '1', '1449600422');
INSERT INTO `tbl_material_category` VALUES ('34', 'A516-70 PLATE', '1', '1449600531');
INSERT INTO `tbl_material_category` VALUES ('35', '4130AN', '1', '1455293459');
INSERT INTO `tbl_material_category` VALUES ('36', '4130HT', '1', '1455293467');
INSERT INTO `tbl_material_category` VALUES ('37', '6061-T6', '1', '1457728832');
INSERT INTO `tbl_material_category` VALUES ('38', 'Grey Iron (Cast Iron)', '1', '1457793398');
INSERT INTO `tbl_material_category` VALUES ('39', '1215 Steel', '1', '1463169996');
INSERT INTO `tbl_material_category` VALUES ('40', 'AISI 1117', '1', '1463169998');
INSERT INTO `tbl_material_category` VALUES ('41', 'Casting', '1', '1469465751');

-- ----------------------------
-- Table structure for tbl_material_code
-- ----------------------------
DROP TABLE IF EXISTS `tbl_material_code`;
CREATE TABLE `tbl_material_code` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `created_time` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=372 DEFAULT CHARSET=armscii8;

-- ----------------------------
-- Records of tbl_material_code
-- ----------------------------
INSERT INTO `tbl_material_code` VALUES ('5', '12L14 & C1018', '', '1', '1445791831');
INSERT INTO `tbl_material_code` VALUES ('6', '316 SS', '', '1', '1445791831');
INSERT INTO `tbl_material_code` VALUES ('7', 'HAST C276', '', '1', '1445791831');
INSERT INTO `tbl_material_code` VALUES ('8', 'New Material', '', '1', '1445791831');
INSERT INTO `tbl_material_code` VALUES ('9', 'Newmat', '', '1', '1445791831');
INSERT INTO `tbl_material_code` VALUES ('10', 'newmaterial', '', '1', '1445791832');
INSERT INTO `tbl_material_code` VALUES ('11', 'Steel', '', '1', '1445791832');
INSERT INTO `tbl_material_code` VALUES ('12', 'Material Code 132', '', '1', '1445791832');
INSERT INTO `tbl_material_code` VALUES ('13', 'HVD_Mat_001', '', '1', '1445791832');
INSERT INTO `tbl_material_code` VALUES ('14', 'test 12 jb', '', '1', '1445791833');
INSERT INTO `tbl_material_code` VALUES ('15', '009', '', '1', '1445791833');
INSERT INTO `tbl_material_code` VALUES ('16', '010', '', '1', '1445791833');
INSERT INTO `tbl_material_code` VALUES ('17', 'AMP501', '', '1', '1445791833');
INSERT INTO `tbl_material_code` VALUES ('18', 'NEW_MAT_SEP_10_HUNG', '', '1', '1445791833');
INSERT INTO `tbl_material_code` VALUES ('19', 'AMP5002', '', '1', '1445791834');
INSERT INTO `tbl_material_code` VALUES ('20', 'AMP503', '', '1', '1445791834');
INSERT INTO `tbl_material_code` VALUES ('21', 'AMP504', '', '1', '1445791834');
INSERT INTO `tbl_material_code` VALUES ('22', 'AMP505', '', '1', '1445791834');
INSERT INTO `tbl_material_code` VALUES ('23', 'AMP506', '', '1', '1445791835');
INSERT INTO `tbl_material_code` VALUES ('24', 'NYLON901', '', '1', '1445791835');
INSERT INTO `tbl_material_code` VALUES ('25', '18inch Plate', '', '1', '1445791835');
INSERT INTO `tbl_material_code` VALUES ('26', '1\" DIA 304SS', '', '1', '1445791835');
INSERT INTO `tbl_material_code` VALUES ('27', '2-3/4\" DIA. 304SS', '', '1', '1445791836');
INSERT INTO `tbl_material_code` VALUES ('28', '2.125RD-009', '', '1', '1446476675');
INSERT INTO `tbl_material_code` VALUES ('29', '1.500RD-009', 'C3600 H02 BRASS', '1', '2');
INSERT INTO `tbl_material_code` VALUES ('30', '4.00RD100K-CR', '', '1', '1446510610');
INSERT INTO `tbl_material_code` VALUES ('31', '2.500RD100K-CR', '', '1', '1446510632');
INSERT INTO `tbl_material_code` VALUES ('32', '14.500PLATE-FLCUT', '', '1', '1446510677');
INSERT INTO `tbl_material_code` VALUES ('33', '16.500PLATE-FLCUT', '', '1', '1446510701');
INSERT INTO `tbl_material_code` VALUES ('34', '.500RD-009 C3600', '', '1', '1446557453');
INSERT INTO `tbl_material_code` VALUES ('35', '.625RD-009', 'C3600 H02 BRASS', '1', '1446575043');
INSERT INTO `tbl_material_code` VALUES ('36', '1.00RD-009', 'C3600 H02 BRASS', '1', '1446575085');
INSERT INTO `tbl_material_code` VALUES ('37', '1.125RD-009', 'C3600 H02 BRASS', '1', '1446575183');
INSERT INTO `tbl_material_code` VALUES ('38', '1.625RD-009', 'C3600 H02 BRASS', '1', '1446575185');
INSERT INTO `tbl_material_code` VALUES ('39', '1.750RD-009', 'C3600 H02 BRASS', '1', '1446575187');
INSERT INTO `tbl_material_code` VALUES ('40', '2.500RD-009', 'C3600 H02 BRASS', '1', '1446575225');
INSERT INTO `tbl_material_code` VALUES ('41', '.250RD-316', '316/L-SS SA479 UNS_S31600 FA-010', '1', '3');
INSERT INTO `tbl_material_code` VALUES ('42', '.375RD-316', '316/L-SS SA479 UNS_S31600 FA-010', '1', '3');
INSERT INTO `tbl_material_code` VALUES ('43', '.500RD-316', '316/L-SS SA479 UNS_S31600 FA-010', '1', '3');
INSERT INTO `tbl_material_code` VALUES ('44', 'Nov_4_Mat_HVD', 'Mat for test of OCT 4', '1', '1446636006');
INSERT INTO `tbl_material_code` VALUES ('45', '.375RD-857', '2205 DUPLEX', '1', '1446734013');
INSERT INTO `tbl_material_code` VALUES ('46', '.500RD-872', 'DUPLEX ZERON100', '1', '1446734036');
INSERT INTO `tbl_material_code` VALUES ('47', '.250RD-857', '2205 DUPLEX UNS31803 SA-479 A267', '1', '1446734278');
INSERT INTO `tbl_material_code` VALUES ('48', '.500RD-857', '2205 DUPLEX UNS31803 SA-479 A267', '1', '1446734324');
INSERT INTO `tbl_material_code` VALUES ('49', '.625RD-857', '2205 DUPLEX UNS31803 SA-479 A267', '1', '1446734327');
INSERT INTO `tbl_material_code` VALUES ('50', '.750RD-857', '2205 DUPLEX UNS31803 SA-479 A267', '1', '1446734329');
INSERT INTO `tbl_material_code` VALUES ('51', '7 X 14.75WD  G40.21-13 55W(350W)', 'C CHANNEL STEEL', '1', '1446835484');
INSERT INTO `tbl_material_code` VALUES ('52', 'HUNG_NOV_11', 'HUNG NOV 11 Test', '1', '1447214291');
INSERT INTO `tbl_material_code` VALUES ('53', '8.00RD-AM304', '304SS SA-479 FA-007 BARSTOCK', '1', '1447806964');
INSERT INTO `tbl_material_code` VALUES ('54', '.625RD-AM304', '304SS SA-479 FA-007 BARSTOCK', '1', '1447807043');
INSERT INTO `tbl_material_code` VALUES ('55', '.750RD-AM304', '304SS SA-479 FA-007 BARSTOCK', '1', '1447807047');
INSERT INTO `tbl_material_code` VALUES ('56', '1.00RD-AM304', '304SS BARSTOCK', '1', '1447807049');
INSERT INTO `tbl_material_code` VALUES ('57', '.250RD-AM304', '304SS SA-479 FA-007', '1', '1447939048');
INSERT INTO `tbl_material_code` VALUES ('58', '1.500RD-AM304', '304SS SA-479 FA-007', '1', '1447939164');
INSERT INTO `tbl_material_code` VALUES ('59', '.500X.312FL-AM304', '304SS SA-479 FA-007', '1', '1447940125');
INSERT INTO `tbl_material_code` VALUES ('60', '.750X.375FL-AM304', '304SS SA-479 FA-007', '1', '1447940167');
INSERT INTO `tbl_material_code` VALUES ('61', '1.000X.375FL-AM304', '304SS SA-479 FA-007', '1', '1447940273');
INSERT INTO `tbl_material_code` VALUES ('62', '1.75HX-AM304', '304SS SA-479 FA-007', '1', '1447940313');
INSERT INTO `tbl_material_code` VALUES ('63', '.625RD-316', '316/L-SS SA479 UNS_S31600 FA-010', '1', '1447940498');
INSERT INTO `tbl_material_code` VALUES ('64', '.750RD-316', '316/L-SS SA479 UNS_S31600 FA-010', '1', '1447940518');
INSERT INTO `tbl_material_code` VALUES ('65', '.875RD-316', '316/L-SS SA479 UNS_S31600 FA-010', '1', '1447940536');
INSERT INTO `tbl_material_code` VALUES ('66', '.4375RD-316', '316/L-SS SA479 UNS_S31600 FA-010', '1', '1447940570');
INSERT INTO `tbl_material_code` VALUES ('67', '.5625RD-316', '316/L-SS SA479 UNS_S31600 FA-010', '1', '1447940591');
INSERT INTO `tbl_material_code` VALUES ('68', '1.000RD-316', '316/L-SS SA479 UNS_S31600 FA-010', '1', '1447940616');
INSERT INTO `tbl_material_code` VALUES ('69', '1.250RD-316', '316/L-SS SA479 UNS_S31600 FA-010', '1', '1447940634');
INSERT INTO `tbl_material_code` VALUES ('70', '1.500RD-316', '316/L-SS SA479 UNS_S31600 FA-010', '1', '1447940652');
INSERT INTO `tbl_material_code` VALUES ('71', '1.125RD-316', '316/L-SS SA479 UNS_S31600 FA-010', '1', '1447940681');
INSERT INTO `tbl_material_code` VALUES ('72', '1.375RD-316', '316/L-SS SA479 UNS_S31600 FA-010', '1', '1447940697');
INSERT INTO `tbl_material_code` VALUES ('73', '1.625RD-316', '316/L-SS SA479 UNS_S31600 FA-010', '1', '1447940717');
INSERT INTO `tbl_material_code` VALUES ('74', '1.750RD-316', '316/L-SS SA479 UNS_S31600 FA-010', '1', '1447940741');
INSERT INTO `tbl_material_code` VALUES ('75', '1.875RD-316', '316/L-SS SA479 UNS_S31600 FA-010', '1', '1447940764');
INSERT INTO `tbl_material_code` VALUES ('76', '1.1875RD-316', '316/L-SS SA479 UNS_S31600 FA-010', '1', '1447940795');
INSERT INTO `tbl_material_code` VALUES ('77', '1.3125RD-316', '316/L-SS SA479 UNS_S31600 FA-010', '1', '1447940813');
INSERT INTO `tbl_material_code` VALUES ('78', '1.5625RD-316', '316/L-SS SA479 UNS_S31600 FA-010', '1', '1447940831');
INSERT INTO `tbl_material_code` VALUES ('79', '2.000RD-316', '316/L-SS SA479 UNS_S31600 FA-010', '1', '1447940863');
INSERT INTO `tbl_material_code` VALUES ('80', '2.250RD-316', '316/L-SS SA479 UNS_S31600 FA-010', '1', '1447940928');
INSERT INTO `tbl_material_code` VALUES ('81', '2.500RD-316', '316/L-SS SA479 UNS_S31600 FA-010', '1', '1447940956');
INSERT INTO `tbl_material_code` VALUES ('82', '2.750RD-316', '316/L-SS SA479 UNS_S31600 FA-010', '1', '1447940969');
INSERT INTO `tbl_material_code` VALUES ('83', '2.125RD-316', '316/L-SS SA479 UNS_S31600 FA-010', '1', '1447940983');
INSERT INTO `tbl_material_code` VALUES ('84', '2.375RD-316', '316/L-SS SA479 UNS_S31600 FA-010', '1', '1447941002');
INSERT INTO `tbl_material_code` VALUES ('85', '2.875RD-316', '316/L-SS SA479 UNS_S31600 FA-010', '1', '1447941015');
INSERT INTO `tbl_material_code` VALUES ('86', '3.000RD-316', '316/L-SS SA479 UNS_S31600 FA-010', '1', '1447941033');
INSERT INTO `tbl_material_code` VALUES ('87', '3.500RD-316', '316/L-SS SA479 UNS_S31600 FA-010', '1', '1447941049');
INSERT INTO `tbl_material_code` VALUES ('88', '3.250RD-316', '316/L-SS SA479 UNS_S31600 FA-010', '1', '1447941069');
INSERT INTO `tbl_material_code` VALUES ('89', '3.750RD-316', '316/L-SS SA479 UNS_S31600 FA-010', '1', '1447941090');
INSERT INTO `tbl_material_code` VALUES ('90', '3.125RD-316', '316/L-SS SA479 UNS_S31600 FA-010', '1', '1447941107');
INSERT INTO `tbl_material_code` VALUES ('91', '3.625RD-316', '316/L-SS SA479 UNS_S31600 FA-010', '1', '1447941133');
INSERT INTO `tbl_material_code` VALUES ('92', '4.000RD-316', '316/L-SS SA479 UNS_S31600 FA-010', '1', '1447941148');
INSERT INTO `tbl_material_code` VALUES ('93', '4.250RD-316', '316/L-SS SA479 UNS_S31600 FA-010', '1', '1447941164');
INSERT INTO `tbl_material_code` VALUES ('94', '4.500RD-316', '316/L-SS SA479 UNS_S31600 FA-010', '1', '1447941182');
INSERT INTO `tbl_material_code` VALUES ('95', '4.750RD-316', '316/L-SS SA479 UNS_S31600 FA-010', '1', '1447941201');
INSERT INTO `tbl_material_code` VALUES ('96', '5.000RD-316', '316/L-SS SA479 UNS_S31600 FA-010', '1', '1447941212');
INSERT INTO `tbl_material_code` VALUES ('97', '6.000RD-316', '316/L-SS SA479 UNS_S31600 FA-010', '1', '1447941229');
INSERT INTO `tbl_material_code` VALUES ('98', '6.500RD-316', '316/L-SS SA479 UNS_S31600 FA-010', '1', '1447941247');
INSERT INTO `tbl_material_code` VALUES ('99', '6.750RD-316', '316/L-SS SA479 UNS_S31600 FA-010', '1', '1447941262');
INSERT INTO `tbl_material_code` VALUES ('100', '7.000RD-316', '316/L-SS SA479 UNS_S31600 FA-010', '1', '1447941277');
INSERT INTO `tbl_material_code` VALUES ('101', '7.500RD-316', '316/L-SS SA479 UNS_S31600 FA-010', '1', '1447941294');
INSERT INTO `tbl_material_code` VALUES ('102', '.5000HX-316', '316/L-SS SA479 UNS_S31600 FA-010', '1', '1447941463');
INSERT INTO `tbl_material_code` VALUES ('103', '.625HX-316', '316/L-SS SA479 UNS_S31600 FA-010', '1', '1447941477');
INSERT INTO `tbl_material_code` VALUES ('104', '.750HX-316', '316/L-SS SA479 UNS_S31600 FA-010', '1', '1447941492');
INSERT INTO `tbl_material_code` VALUES ('105', '.875HX-316', '316/L-SS SA479 UNS_S31600 FA-010', '1', '1447941509');
INSERT INTO `tbl_material_code` VALUES ('106', '.3125HX-316', '316/L-SS SA479 UNS_S31600 FA-010', '1', '1447941614');
INSERT INTO `tbl_material_code` VALUES ('107', '.4375HX-316', '316/L-SS SA479 UNS_S31600 FA-010', '1', '1447941631');
INSERT INTO `tbl_material_code` VALUES ('108', '.6875HX-316', '316/L-SS SA479 UNS_S31600 FA-010', '1', '1447941651');
INSERT INTO `tbl_material_code` VALUES ('109', '1.000HX-316', '316/L-SS SA479 UNS_S31600 FA-010', '1', '1447941673');
INSERT INTO `tbl_material_code` VALUES ('110', '1.250HX-316', '316/L-SS SA479 UNS_S31600 FA-010', '1', '1447941698');
INSERT INTO `tbl_material_code` VALUES ('111', '1.500HX-316', '316/L-SS SA479 UNS_S31600 FA-010', '1', '1447941737');
INSERT INTO `tbl_material_code` VALUES ('112', '1.750HX-316', '316/L-SS SA479 UNS_S31600 FA-010', '1', '1447941752');
INSERT INTO `tbl_material_code` VALUES ('113', '1.125HX-316', '316/L-SS SA479 UNS_S31600 FA-010', '1', '1447941769');
INSERT INTO `tbl_material_code` VALUES ('114', '1.375HX-316', '316/L-SS SA479 UNS_S31600 FA-010', '1', '1447941786');
INSERT INTO `tbl_material_code` VALUES ('115', '1.625HX-316', '316/L-SS SA479 UNS_S31600 FA-010', '1', '1447941803');
INSERT INTO `tbl_material_code` VALUES ('116', '2.000HX-316', '316/L-SS SA479 UNS_S31600 FA-010', '1', '1447941822');
INSERT INTO `tbl_material_code` VALUES ('117', '2.250HX-316', '316/L-SS SA479 UNS_S31600 FA-010', '1', '1447941835');
INSERT INTO `tbl_material_code` VALUES ('118', '2.500HX-316', '316/L-SS SA479 UNS_S31600 FA-010', '1', '1447941851');
INSERT INTO `tbl_material_code` VALUES ('119', '1.500X.625FL-316', '316/L-SS SA479 UNS_S31600 FA-010', '1', '1447942077');
INSERT INTO `tbl_material_code` VALUES ('120', '.250RD-B16', 'BRASS B16 H02 UNS_C36000 FA-009', '1', '1447942630');
INSERT INTO `tbl_material_code` VALUES ('121', '.5000RD-B16', 'BRASS B16 H02 UNS_C36000 FA-009', '1', '1447942671');
INSERT INTO `tbl_material_code` VALUES ('122', '.625RD-B16', 'BRASS B16 H02 UNS_C36000 FA-009', '1', '1447942692');
INSERT INTO `tbl_material_code` VALUES ('123', '.750RD-B16', 'BRASS B16 H02 UNS_C36000 FA-009', '1', '1447942708');
INSERT INTO `tbl_material_code` VALUES ('124', '.875RD-B16', 'BRASS B16 H02 UNS_C36000 FA-009', '1', '1447942724');
INSERT INTO `tbl_material_code` VALUES ('125', '.4375RD-B16', 'BRASS B16 H02 UNS_C36000 FA-009', '1', '1447942749');
INSERT INTO `tbl_material_code` VALUES ('126', '1.000RD-B16', 'BRASS B16 H02 UNS_C36000 FA-009', '1', '1447942763');
INSERT INTO `tbl_material_code` VALUES ('127', '1.250RD-B16', 'BRASS B16 H02 UNS_C36000 FA-009', '1', '1447942781');
INSERT INTO `tbl_material_code` VALUES ('128', '1.500RD-B16', 'BRASS B16 H02 UNS_C36000 FA-009', '1', '1447942797');
INSERT INTO `tbl_material_code` VALUES ('129', '1.750RD-B16', 'BRASS B16 H02 UNS_C36000 FA-009', '1', '1447942819');
INSERT INTO `tbl_material_code` VALUES ('130', '1.125RD-B16', 'BRASS B16 H02 UNS_C36000 FA-009', '1', '1447942834');
INSERT INTO `tbl_material_code` VALUES ('131', '1.375RD-B16', 'BRASS B16 H02 UNS_C36000 FA-009', '1', '1447942848');
INSERT INTO `tbl_material_code` VALUES ('132', '1.625RD-B16', 'BRASS B16 H02 UNS_C36000 FA-009', '1', '1447942863');
INSERT INTO `tbl_material_code` VALUES ('133', '1.1875RD-B16', 'BRASS B16 H02 UNS_C36000 FA-009', '1', '1447942878');
INSERT INTO `tbl_material_code` VALUES ('134', '2.000RD-B16', 'BRASS B16 H02 UNS_C36000 FA-009', '1', '1447942895');
INSERT INTO `tbl_material_code` VALUES ('135', '2.500RD-B16', 'BRASS B16 H02 UNS_C36000 FA-009', '1', '1447942910');
INSERT INTO `tbl_material_code` VALUES ('136', '2.125RD-B16', 'BRASS B16 H02 UNS_C36000 FA-009', '1', '1447942982');
INSERT INTO `tbl_material_code` VALUES ('137', '2.375RD-B16', 'BRASS B16 H02 UNS_C36000 FA-009', '1', '1447942998');
INSERT INTO `tbl_material_code` VALUES ('138', '3.000RD-B16', 'BRASS B16 H02 UNS_C36000 FA-009', '1', '1447943014');
INSERT INTO `tbl_material_code` VALUES ('139', '3.250RD-B16', 'BRASS B16 H02 UNS_C36000 FA-009', '1', '1447943033');
INSERT INTO `tbl_material_code` VALUES ('140', '3.750RD-B16', 'BRASS B16 H02 UNS_C36000 FA-009', '1', '1447943050');
INSERT INTO `tbl_material_code` VALUES ('141', '4.000RD-B16', 'BRASS B16 H02 UNS_C36000 FA-009', '1', '1447943063');
INSERT INTO `tbl_material_code` VALUES ('142', '4.500RD-B16', 'BRASS B16 H02 UNS_C36000 FA-009', '1', '1447943111');
INSERT INTO `tbl_material_code` VALUES ('143', '5.000RD-B16', 'BRASS B16 H02 UNS_C36000 FA-009', '1', '1447943123');
INSERT INTO `tbl_material_code` VALUES ('144', '5.125RD-B16', 'BRASS B16 H02 UNS_C36000 FA-009', '1', '1447943138');
INSERT INTO `tbl_material_code` VALUES ('145', '6.000RD-B16', 'BRASS B16 H02 UNS_C36000 FA-009', '1', '1447943151');
INSERT INTO `tbl_material_code` VALUES ('146', '6.500RD-B16', 'BRASS B16 H02 UNS_C36000 FA-009', '1', '1447943169');
INSERT INTO `tbl_material_code` VALUES ('147', '.625HX-B16', 'BRASS B16 H02 UNS_C36000 FA-009', '1', '1447943198');
INSERT INTO `tbl_material_code` VALUES ('148', '.875HX-B16', 'BRASS B16 H02 UNS_C36000 FA-009', '1', '1447943212');
INSERT INTO `tbl_material_code` VALUES ('149', '.4375HX-B16', 'BRASS B16 H02 UNS_C36000 FA-009', '1', '1447943232');
INSERT INTO `tbl_material_code` VALUES ('150', '.5625HX-B16', 'BRASS B16 H02 UNS_C36000 FA-009', '1', '1447943252');
INSERT INTO `tbl_material_code` VALUES ('151', '1.250HX-B16', 'BRASS B16 H02 UNS_C36000 FA-009', '1', '1447943266');
INSERT INTO `tbl_material_code` VALUES ('152', '1.500HX-B16', 'BRASS B16 H02 UNS_C36000 FA-009', '1', '1447943281');
INSERT INTO `tbl_material_code` VALUES ('153', '1.750HX-B16', 'BRASS B16 H02 UNS_C36000 FA-009', '1', '1447943297');
INSERT INTO `tbl_material_code` VALUES ('154', '1.125HX-B16', 'BRASS B16 H02 UNS_C36000 FA-009', '1', '1447943315');
INSERT INTO `tbl_material_code` VALUES ('155', '1.625HX-B16', 'BRASS B16 H02 UNS_C36000 FA-009', '1', '1447943388');
INSERT INTO `tbl_material_code` VALUES ('156', '2.000HX-B16', 'BRASS B16 H02 UNS_C36000 FA-009', '1', '1447943402');
INSERT INTO `tbl_material_code` VALUES ('157', '.875RD-1018', '1018 CRS A108 UNS_G10180 FA-003', '1', '1447945009');
INSERT INTO `tbl_material_code` VALUES ('158', '2.750RD-1018', '1018 CRS A108 UNS_G10180 FA-003', '1', '1447945030');
INSERT INTO `tbl_material_code` VALUES ('159', '3.000RD-1018', '1018 CRS A108 UNS_G10180 FA-003', '1', '1447945050');
INSERT INTO `tbl_material_code` VALUES ('160', '3.500RD-1018', '1018 CRS A108 UNS_G10180 FA-003', '1', '1447945065');
INSERT INTO `tbl_material_code` VALUES ('161', '4.750RD-1018', '1018 CRS A108 UNS_G10180 FA-003', '1', '1447945080');
INSERT INTO `tbl_material_code` VALUES ('162', '5.000RD-1018', '1018 CRS A108 UNS_G10180 FA-003', '1', '1447945101');
INSERT INTO `tbl_material_code` VALUES ('163', '1.500X.625FL-1018', '1018 CRS A108 UNS_G10180 FA-003', '1', '1447945132');
INSERT INTO `tbl_material_code` VALUES ('164', '1.250HX-1018', '1018 CRS A108 UNS_G10180 FA-003', '1', '1447945154');
INSERT INTO `tbl_material_code` VALUES ('165', '1.500HX-1018', '1018 CRS A108 UNS_G10180 FA-003', '1', '1447945171');
INSERT INTO `tbl_material_code` VALUES ('166', '1.750HX-1018', '1018 CRS A108 UNS_G10180 FA-003', '1', '1447945185');
INSERT INTO `tbl_material_code` VALUES ('167', '1.000RD-17.4 H1025', '17-4SS A564 TYPE 630 H1025 UNS_S17400 FA-011', '1', '1447947802');
INSERT INTO `tbl_material_code` VALUES ('168', '2.000RD-17.4H1025', '17-4SS A564 TYPE 630 H1025 UNS_S17400 FA-011', '1', '1447947839');
INSERT INTO `tbl_material_code` VALUES ('169', '2.500RD-17.4H1025', '17-4SS A564 TYPE 630 H1025 UNS_S17400 FA-011', '1', '1447947872');
INSERT INTO `tbl_material_code` VALUES ('170', '2.250RD-17.4H1025', '17-4SS A564 TYPE 630 H1025 UNS_S17400 FA-011', '1', '1447947890');
INSERT INTO `tbl_material_code` VALUES ('171', '3.000RD-17.4H1025', '17-4SS A564 TYPE 630 H1025 UNS_S17400 FA-011', '1', '1447947941');
INSERT INTO `tbl_material_code` VALUES ('172', '4.500RD-17.4H1025', '17-4SS A564 TYPE 630 H1025 UNS_S17400 FA-011', '1', '1447947960');
INSERT INTO `tbl_material_code` VALUES ('173', '6.500RD-17.4H1025', '17-4SS A564 TYPE 630 H1025 UNS_S17400 FA-011', '1', '1447947980');
INSERT INTO `tbl_material_code` VALUES ('174', '7.000RD-17.4H1025', '17-4SS A564 TYPE 630 H1025 UNS_S17400 FA-011', '1', '1447948000');
INSERT INTO `tbl_material_code` VALUES ('175', '3.750RD-17.4HD1150', '17-4SS A564 TYPE 630 HD1150 UNS_S17400 FA-308', '1', '1447948211');
INSERT INTO `tbl_material_code` VALUES ('176', '.750RD-17.4HD1150', '17-4SS A564 TYPE 630 HD1150 UNS_S17400 FA-308', '1', '1447948269');
INSERT INTO `tbl_material_code` VALUES ('177', '.875RD-17.4HD1150', '17-4SS A564 TYPE 630 HD1150 UNS_S17400 FA-308', '1', '1447948289');
INSERT INTO `tbl_material_code` VALUES ('178', '1.000RD-HD1150', '17-4SS A564 TYPE 630 HD1150 UNS_S17400 FA-308', '1', '1447948310');
INSERT INTO `tbl_material_code` VALUES ('179', '1.250RD-17.4HD1150', '17-4SS A564 TYPE 630 HD1150 UNS_S17400 FA-308', '1', '1447948326');
INSERT INTO `tbl_material_code` VALUES ('180', '1.500RD-17.4HD1150', '17-4SS A564 TYPE 630 HD1150 UNS_S17400 FA-308', '1', '1447948350');
INSERT INTO `tbl_material_code` VALUES ('181', '1.125RD-17.4HD1150', '17-4SS A564 TYPE 630 HD1150 UNS_S17400 FA-308', '1', '1447948370');
INSERT INTO `tbl_material_code` VALUES ('182', '1.375RD-17.4HD1150', '17-4SS A564 TYPE 630 HD1150 UNS_S17400 FA-308', '1', '1447948393');
INSERT INTO `tbl_material_code` VALUES ('183', '1.750RD-17.4HD1150', '17-4SS A564 TYPE 630 HD1150 UNS_S17400 FA-308', '1', '1447948415');
INSERT INTO `tbl_material_code` VALUES ('184', '2.000RD-17.4HD1150', '17-4SS A564 TYPE 630 HD1150 UNS_S17400 FA-308', '1', '1447948430');
INSERT INTO `tbl_material_code` VALUES ('185', '2.500RD-17.4HD1150', '17-4SS A564 TYPE 630 HD1150 UNS_S17400 FA-308', '1', '1447948446');
INSERT INTO `tbl_material_code` VALUES ('186', '2.125RD-17.4HD1150', '17-4SS A564 TYPE 630 HD1150 UNS_S17400 FA-308', '1', '1447948462');
INSERT INTO `tbl_material_code` VALUES ('187', '3.000RD-17.4HD1150', '17-4SS A564 TYPE 630 HD1150 UNS_S17400 FA-308', '1', '1447948479');
INSERT INTO `tbl_material_code` VALUES ('188', '3.375RD-17.4HD1150', '17-4SS A564 TYPE 630 HD1150 UNS_S17400 FA-308', '1', '1447948493');
INSERT INTO `tbl_material_code` VALUES ('189', '5.000RD-17.4HD1150', '17-4SS A564 TYPE 630 HD1150 UNS_S17400 FA-308', '1', '1447948513');
INSERT INTO `tbl_material_code` VALUES ('190', '.750RD-DUPLEX 2205', 'DUPLEX857 A276 UNS_S31803 FA-857', '1', '19');
INSERT INTO `tbl_material_code` VALUES ('191', '.250RD-DUPLEX 2205', 'DUPLEX857 A276 UNS_S31803 F-857', '1', '19');
INSERT INTO `tbl_material_code` VALUES ('192', '.375RD-DUPLEX 2205', 'DUPLEX857 A276 UNS_S31803 F-857', '1', '1447949990');
INSERT INTO `tbl_material_code` VALUES ('193', '.500RD-DUPLEX 2205', 'DUPLEX857 A276 UNS_S31803 F-857', '1', '1447950009');
INSERT INTO `tbl_material_code` VALUES ('194', '.625RD-DUPLEX 2205', 'DUPLEX857 A276 UNS_S31803 F-857', '1', '1447950033');
INSERT INTO `tbl_material_code` VALUES ('195', '1.000RD-DUPLEX 2205', 'DUPLEX857 A276 UNS_S31803 F-857', '1', '1447950047');
INSERT INTO `tbl_material_code` VALUES ('196', '1.250RD-DUPLEX 2205', 'DUPLEX857 A276 UNS_S31803 F-857', '1', '1447950067');
INSERT INTO `tbl_material_code` VALUES ('197', '1.500RD-DUPLEX 2205', 'DUPLEX857 A276 UNS_S31803 F-857', '1', '1447950084');
INSERT INTO `tbl_material_code` VALUES ('198', '1.750RD-DUPLEX 2205', 'DUPLEX857 A276 UNS_S31803 F-857', '1', '1447950101');
INSERT INTO `tbl_material_code` VALUES ('199', '2.250RD-DUPLEX 2205', 'DUPLEX857 A276 UNS_S31803 F-857', '1', '1447950123');
INSERT INTO `tbl_material_code` VALUES ('200', '.500RD-DUPLEX ZERON 100', 'DUPLEX872 A479 UNS_S32760 FA-872', '1', '1447950361');
INSERT INTO `tbl_material_code` VALUES ('201', '.625RD-DUPLEX ZERON 100', 'DUPLEX872 A479 UNS_S32760 FA-872', '1', '1447950436');
INSERT INTO `tbl_material_code` VALUES ('202', '.750RD-DUPLEX ZERON 100', 'DUPLEX872 A479 UNS_S32760 FA-872', '1', '1447950458');
INSERT INTO `tbl_material_code` VALUES ('203', '1.500RD-DUPLEX ZERON 100', 'DUPLEX872 A479 UNS_S32760 FA-872', '1', '1447950510');
INSERT INTO `tbl_material_code` VALUES ('204', '1.125RD-DUPLEX ZERON 100', 'DUPLEX872 A479 UNS_S32760 FA-872', '1', '1447950532');
INSERT INTO `tbl_material_code` VALUES ('205', '1.250RD-DUPLEX ZERON 100', 'DUPLEX872 A479 UNS_S32760 FA-872', '1', '1447950557');
INSERT INTO `tbl_material_code` VALUES ('206', '1.625RD-DUPLEX ZERON 100', 'DUPLEX872 A479 UNS_S32760 FA-872', '1', '1447950574');
INSERT INTO `tbl_material_code` VALUES ('207', '1.198RD-DUPLEX ZERON 100', 'DUPLEX872 A479 UNS_S32760 FA-872', '1', '1447950612');
INSERT INTO `tbl_material_code` VALUES ('208', '2.000RD-DUPLEX ZERON 100', 'DUPLEX872 A479 UNS_S32760 FA-872', '1', '1447950631');
INSERT INTO `tbl_material_code` VALUES ('209', '2.500RD-DUPLEX ZERON 100', 'DUPLEX872 A479 UNS_S32760 FA-872', '1', '1447950648');
INSERT INTO `tbl_material_code` VALUES ('210', '.500RD-DUPLEX SMO 254', 'DUPLEXSMO254 A479 UNS_S31254 FA-976', '1', '19');
INSERT INTO `tbl_material_code` VALUES ('211', '1.00RD-DUPLEX SMO 254', 'DUPLEXSMO254 A479 UNS_S31254 FA-976', '1', '19');
INSERT INTO `tbl_material_code` VALUES ('212', '1.500RD-DUPLEX SMO 254', 'DUPLEXSMO254 A479 UNS_S31254 FA-976', '1', '19');
INSERT INTO `tbl_material_code` VALUES ('213', '1.125RD-DUPLEX SMO 254', 'DUPLEXSMO254 A479 UNS_S31254 FA-976', '1', '19');
INSERT INTO `tbl_material_code` VALUES ('214', '.250RD-ALLOY 400', 'MONEL ALLOY 400 B-164 UNS_N04400 FA-006', '1', '1447951400');
INSERT INTO `tbl_material_code` VALUES ('215', '.500RD-ALLOY 400', 'MONEL ALLOY 400 B-164 UNS_N04400 FA-006', '1', '1447951418');
INSERT INTO `tbl_material_code` VALUES ('216', '.625RD-ALLOY 400', 'MONEL ALLOY 400 B-164 UNS_N04400 FA-006', '1', '1447951434');
INSERT INTO `tbl_material_code` VALUES ('217', '.750RD-ALLOY 400', 'MONEL ALLOY 400 B-164 UNS_N04400 FA-006', '1', '1447951452');
INSERT INTO `tbl_material_code` VALUES ('218', '.875RD-ALLOY 400', 'MONEL ALLOY 400 B-164 UNS_N04400 FA-006', '1', '1447951468');
INSERT INTO `tbl_material_code` VALUES ('219', '1.000RD-ALLOY 400', 'MONEL ALLOY 400 B-164 UNS_N04400 FA-006', '1', '1447951525');
INSERT INTO `tbl_material_code` VALUES ('220', '1.250RD-ALLOY 400', 'MONEL ALLOY 400 B-164 UNS_N04400 FA-006', '1', '1447951542');
INSERT INTO `tbl_material_code` VALUES ('221', '1.500RD-ALLOY 400', 'MONEL ALLOY 400 B-164 UNS_N04400 FA-006', '1', '1447951557');
INSERT INTO `tbl_material_code` VALUES ('222', '1.750RD-ALLOY 400', 'MONEL ALLOY 400 B-164 UNS_N04400 FA-006', '1', '1447951573');
INSERT INTO `tbl_material_code` VALUES ('223', '1.625RD-ALLOY 400', 'MONEL ALLOY 400 B-164 UNS_N04400 FA-006', '1', '1447951592');
INSERT INTO `tbl_material_code` VALUES ('224', '2.000RD-ALLOY 400', 'MONEL ALLOY 400 B-164 UNS_N04400 FA-006', '1', '1447951607');
INSERT INTO `tbl_material_code` VALUES ('225', '2.250RD-ALLOY 400', 'MONEL ALLOY 400 B-164 UNS_N04400 FA-006', '1', '1447951620');
INSERT INTO `tbl_material_code` VALUES ('226', '2.500RD-ALLOY 400', 'MONEL ALLOY 400 B-164 UNS_N04400 FA-006', '1', '1447951635');
INSERT INTO `tbl_material_code` VALUES ('227', '3.000RD-ALLOY 400', 'MONEL ALLOY 400 B-164 UNS_N04400 FA-006', '1', '1447951654');
INSERT INTO `tbl_material_code` VALUES ('228', '3.500RD-ALLOY 400', 'MONEL ALLOY 400 B-164 UNS_N04400 FA-006', '1', '1447951668');
INSERT INTO `tbl_material_code` VALUES ('229', '5.000RD-ALLOY 400', 'MONEL ALLOY 400 B-164 UNS_N04400 FA-006', '1', '1447951685');
INSERT INTO `tbl_material_code` VALUES ('230', '7.500RD-ALLOY 400', 'MONEL ALLOY 400 B-164 UNS_N04400 FA-006', '1', '1447951704');
INSERT INTO `tbl_material_code` VALUES ('231', '9.000RD-ALLOY 400', 'MONEL ALLOY 400 B-164 UNS_N04400 FA-006', '1', '1447951723');
INSERT INTO `tbl_material_code` VALUES ('232', '9.250RD-ALLOY 400', 'MONEL ALLOY 400 B-164 UNS_N04400 FA-006', '1', '1447951743');
INSERT INTO `tbl_material_code` VALUES ('233', '1.250RD-303', '303SS COND-A A581(UNDER 1/2\") A582(OVER 1/2\") FA-004', '1', '1447954063');
INSERT INTO `tbl_material_code` VALUES ('234', '2.125RD-303', '303SS COND-A A581(UNDER 1/2\") A582(OVER 1/2\") FA-004', '1', '1447954080');
INSERT INTO `tbl_material_code` VALUES ('235', '2.250RD-303', '303SS COND-A A581(UNDER 1/2\") A582(OVER 1/2\") FA-004', '1', '1447954094');
INSERT INTO `tbl_material_code` VALUES ('236', '.375RD-HAST B', 'HASTELLOY B SB-335 B-446 UNS_N10665 FA-016', '1', '1447954317');
INSERT INTO `tbl_material_code` VALUES ('237', '.625RD-HAST B', 'HASTELLOY B SB-335 B-446 UNS_N10665 FA-016', '1', '1447954336');
INSERT INTO `tbl_material_code` VALUES ('238', '1.500RD-HAST B', 'HASTELLOY B SB-335 B-446 UNS_N10665 FA-016', '1', '1447954357');
INSERT INTO `tbl_material_code` VALUES ('239', '1.250RD-HAST B', 'HASTELLOY B SB-335 B-446 UNS_N10665 FA-016', '1', '1447954373');
INSERT INTO `tbl_material_code` VALUES ('240', '.500RD-HAST C', 'HASTELLOY C SB-574 B574 UNS_N10276 FA-022', '1', '1447954518');
INSERT INTO `tbl_material_code` VALUES ('241', '.250RD-HAST C', 'HASTELLOY C SB-574 B574 UNS_N10276 FA-022', '1', '1447954540');
INSERT INTO `tbl_material_code` VALUES ('242', '.625RD-HAST C', 'HASTELLOY C SB-574 B574 UNS_N10276 FA-022', '1', '1447954562');
INSERT INTO `tbl_material_code` VALUES ('243', '.750RD-HAST C', 'HASTELLOY C SB-574 B574 UNS_N10276 FA-022', '1', '1447954597');
INSERT INTO `tbl_material_code` VALUES ('244', '.875RD-HAST C', 'HASTELLOY C SB-574 B574 UNS_N10276 FA-022', '1', '1447954611');
INSERT INTO `tbl_material_code` VALUES ('245', '1.000RD-HAST C', 'HASTELLOY C SB-574 B574 UNS_N10276 FA-022', '1', '1447954625');
INSERT INTO `tbl_material_code` VALUES ('246', '1.500RD-HAST C', 'HASTELLOY C SB-574 B574 UNS_N10276 FA-022', '1', '1447954646');
INSERT INTO `tbl_material_code` VALUES ('247', '1.250RD-HACT C', 'HASTELLOY C SB-574 B574 UNS_N10276 FA-022', '1', '1447954660');
INSERT INTO `tbl_material_code` VALUES ('248', '1.750RD-HAST C', 'HASTELLOY C SB-574 B574 UNS_N10276 FA-022', '1', '1447954679');
INSERT INTO `tbl_material_code` VALUES ('249', '1.125RD-HAST C', 'HASTELLOY C SB-574 B574 UNS_N10276 FA-022', '1', '1447954694');
INSERT INTO `tbl_material_code` VALUES ('250', '2.000RDHAST C', 'HASTELLOY C SB-574 B574 UNS_N10276 FA-022', '1', '1447954706');
INSERT INTO `tbl_material_code` VALUES ('251', '.312RD-INCONEL 625', 'INCONEL 625 B446 UNS_N06625 FA-020', '1', '1447955759');
INSERT INTO `tbl_material_code` VALUES ('252', '.375RD-INCONEL 625', 'INCONEL 625 B446 UNS_N06625 FA-020', '1', '1447955914');
INSERT INTO `tbl_material_code` VALUES ('253', '.625RD-INCONEL 625', 'INCONEL 625 B446 UNS_N06625 FA-020', '1', '1447955929');
INSERT INTO `tbl_material_code` VALUES ('254', '.875RD-INCONEL 625', 'INCONEL 625 B446 UNS_N06625 FA-020', '1', '1447955948');
INSERT INTO `tbl_material_code` VALUES ('255', '1.250RD-INCONEL 625', 'INCONEL 625 B446 UNS_N06625 FA-020', '1', '1447955970');
INSERT INTO `tbl_material_code` VALUES ('256', '1.260RD-INCONEL 625', 'INCONEL 625 B446 UNS_N06625 FA-020', '1', '1447956001');
INSERT INTO `tbl_material_code` VALUES ('257', '5.000RD-INCONEL 625', 'INCONEL 625 B446 UNS_N06625 FA-020', '1', '1447956024');
INSERT INTO `tbl_material_code` VALUES ('258', '.625RD-INCONOLY 825', 'INCONOLY 825 B425 UNS_N08825 FA-577', '1', '1447956175');
INSERT INTO `tbl_material_code` VALUES ('259', '1.500RD-INCONOLY 825', 'INCONOLY 825 B425 UNS_N08825 FA-577', '1', '1447956202');
INSERT INTO `tbl_material_code` VALUES ('260', '1.250RD-INCONOLY 825', 'INCONOLY 825 B425 UNS_N08825 FA-577', '1', '1447956218');
INSERT INTO `tbl_material_code` VALUES ('261', '.750RD-12L14', '12L14 CRS A576 UNS_G12144', '1', '1447956373');
INSERT INTO `tbl_material_code` VALUES ('262', '1.125RD-12L14', '12L14 CRS A576 UNS_G12144', '1', '1447956389');
INSERT INTO `tbl_material_code` VALUES ('263', '2.00RD-12L14', '12L14 CRS A576 UNS_G12144', '1', '19');
INSERT INTO `tbl_material_code` VALUES ('264', '2.750RD-12L14', '12L14 CRS A576 UNS_G12144', '1', '19');
INSERT INTO `tbl_material_code` VALUES ('265', '3.000RD-12L14', '12L14 CRS A576 UNS_G12144', '1', '19');
INSERT INTO `tbl_material_code` VALUES ('266', '3.500RD-12L14', '12L14 CRS A576 UNS_G12144', '1', '19');
INSERT INTO `tbl_material_code` VALUES ('267', '4.25RD-12L14', '12L14 CRS A576 UNS_G12144', '1', '19');
INSERT INTO `tbl_material_code` VALUES ('268', '4.75RD-12L14', '12L14 CRS A576 UNS_G12144', '1', '19');
INSERT INTO `tbl_material_code` VALUES ('269', '5.000RD-12L14', '12L14 CRS A576 UNS_G12144', '1', '19');
INSERT INTO `tbl_material_code` VALUES ('270', '1.250HX-12L14', '12L14 CRS A576 UNS_G12144', '1', '1447956715');
INSERT INTO `tbl_material_code` VALUES ('271', '1.500HX-12L14', '12L14 CRS A576 UNS_G12144', '1', '1447956728');
INSERT INTO `tbl_material_code` VALUES ('272', '1.750HX-12L14', '12L14 CRS A576 UNS_G12144', '1', '1447956747');
INSERT INTO `tbl_material_code` VALUES ('273', '.250RD-ALLOY20', 'ALLOY 20 B473 UNS_N08020 FA-017', '1', '1447957223');
INSERT INTO `tbl_material_code` VALUES ('274', '.625RD-ALLOY 20', 'ALLOY 20 B473 UNS_N08020 FA-017', '1', '1447957238');
INSERT INTO `tbl_material_code` VALUES ('275', '.750RD-ALLOY 20', 'ALLOY 20 B473 UNS_N08020 FA-017', '1', '1447957253');
INSERT INTO `tbl_material_code` VALUES ('276', '1.000RD-ALLOY 20', 'ALLOY 20 B473 UNS_N08020 FA-017', '1', '1447957267');
INSERT INTO `tbl_material_code` VALUES ('277', '1.125RD-ALLOY 20', 'ALLOY 20 B473 UNS_N08020 FA-017', '1', '1447957283');
INSERT INTO `tbl_material_code` VALUES ('278', '1.250RD-ALLOY 20', 'ALLOY 20 B473 UNS_N08020 FA-017', '1', '1447957296');
INSERT INTO `tbl_material_code` VALUES ('279', '1.500RD-ALLOY 20', 'ALLOY 20 B473 UNS_N08020 FA-017', '1', '1447957310');
INSERT INTO `tbl_material_code` VALUES ('280', '1.750RD-ALLOY 20', 'ALLOY 20 B473 UNS_N08020 FA-017', '1', '1447957326');
INSERT INTO `tbl_material_code` VALUES ('281', '4.250RD-ALLOY 20', 'ALLOY 20 B473 UNS_N08020 FA-017', '1', '1447957342');
INSERT INTO `tbl_material_code` VALUES ('282', '.625HX-ALLOY 20', 'ALLOY 20 B473 UNS_N08020 FA-017', '1', '1447957362');
INSERT INTO `tbl_material_code` VALUES ('283', '.250RD-317', '317SS A479 UNS_31700 FA-171', '1', '1447957505');
INSERT INTO `tbl_material_code` VALUES ('284', '.3125RD-317', '317SS A479 UNS_31700 FA-171', '1', '1447957597');
INSERT INTO `tbl_material_code` VALUES ('285', '1.500RD-317', '317SS A479 UNS_31700 FA-171', '1', '1447957611');
INSERT INTO `tbl_material_code` VALUES ('286', '2.500RD-317', '317SS A479 UNS_31700 FA-171', '1', '1447957624');
INSERT INTO `tbl_material_code` VALUES ('287', '7.000RD-317', '317SS A479 UNS_31700 FA-171', '1', '1447957641');
INSERT INTO `tbl_material_code` VALUES ('288', '1.250RD-410', '410SS A479 UNS_S41000 FA-161', '1', '1447958172');
INSERT INTO `tbl_material_code` VALUES ('289', '1.750RD-410', '410SS A479 UNS_S41000 FA-161', '1', '1447958192');
INSERT INTO `tbl_material_code` VALUES ('290', '1.875RD-410', '410SS A479 UNS_S41000 FA-161', '1', '1447958209');
INSERT INTO `tbl_material_code` VALUES ('291', '.375RD-347', '347SS SA-479 UNS_S34700 FA-051', '1', '1447958316');
INSERT INTO `tbl_material_code` VALUES ('292', '1.500RD-347', '347SS SA-479 UNS_S34700 FA-051', '1', '1447958339');
INSERT INTO `tbl_material_code` VALUES ('293', '1.250RD-347', '347SS SA-479 UNS_S34700 FA-051', '1', '1447958353');
INSERT INTO `tbl_material_code` VALUES ('294', '1.250RD-416', '416SS A582 UNS_S41600 FA-588', '1', '1447958452');
INSERT INTO `tbl_material_code` VALUES ('295', '2.000RD-416', '416SS A582 UNS_S41600 FA-588', '1', '1447958471');
INSERT INTO `tbl_material_code` VALUES ('296', '2.50RD-416', '416SS A582 UNS_S41600 FA-588', '1', '1447958485');
INSERT INTO `tbl_material_code` VALUES ('297', '2.375RD-416', '416SS A582 UNS_S41600 FA-588', '1', '1447958498');
INSERT INTO `tbl_material_code` VALUES ('298', '.750RD-ALLOY B16', 'ALLOY B16 A193 FA-576', '1', '1447958848');
INSERT INTO `tbl_material_code` VALUES ('299', '1.000RD-4140 ALLOY', '4140 ALLOY SA193 FA-235', '1', '1447958926');
INSERT INTO `tbl_material_code` VALUES ('300', '.625RD-ZIRCONIUM', 'ZIRCONIUM B550 UNS_R60702 FA-648', '1', '1447959325');
INSERT INTO `tbl_material_code` VALUES ('301', '2.500RD-ZIRCONIUM', 'ZIRCONIUM B550 UNS_R60702 FA-648', '1', '1447959355');
INSERT INTO `tbl_material_code` VALUES ('302', '.250RD-ZIRCONIUM', 'ZIRCONIUM B550 UNS_R60702 FA-648', '1', '1447959372');
INSERT INTO `tbl_material_code` VALUES ('303', '.250RD-TITANIUM', 'TITANIUM B348 GR.2 UNS_R50400 FA-628', '1', '1447959466');
INSERT INTO `tbl_material_code` VALUES ('304', '.750RD-TITANIUM', 'TITANIUM B348 GR.2 UNS_R50400 FA-628', '1', '1447959482');
INSERT INTO `tbl_material_code` VALUES ('305', '.375RD-TITANIUM', 'TITANIUM B348 GR.2 UNS_R50400 FA-628', '1', '1447959505');
INSERT INTO `tbl_material_code` VALUES ('306', '.500RD-TITANIUM', 'TITANIUM B348 GR.2 UNS_R50400 FA-628', '1', '1447959518');
INSERT INTO `tbl_material_code` VALUES ('307', '1.250RD-TITANIUM', 'TITANIUM B348 GR.2 UNS_R50400 FA-628', '1', '1447959534');
INSERT INTO `tbl_material_code` VALUES ('308', '2.250RD-TITANIUM', 'TITANIUM B348 GR.2 UNS_R50400 FA-628', '1', '1447959553');
INSERT INTO `tbl_material_code` VALUES ('309', '1.000RD-TITANIUM', 'TITANIUM B348 GR.2 UNS_R50400 FA-628', '1', '1447959567');
INSERT INTO `tbl_material_code` VALUES ('310', '1.500RD-TITANIUM', 'TITANIUM B348 GR.2 UNS_R50400 FA-628', '1', '1447959584');
INSERT INTO `tbl_material_code` VALUES ('311', '1.375RD-NICKEL GR CZ100', 'NICKEL GRADE CZ100 B160 UNS_N02200 FA-018', '1', '1447959698');
INSERT INTO `tbl_material_code` VALUES ('312', '2.500RD-440C', '440C A276 UNS_S44004 FA-015', '1', '1447961431');
INSERT INTO `tbl_material_code` VALUES ('313', '4.500RD-NITRONIC 60', 'NITRONIC 60 A276, A314, A479 UNS_S21800', '1', '1447961703');
INSERT INTO `tbl_material_code` VALUES ('314', '.750RD-NITRONIC 60', 'NITRONIC 60 A276, A314, A479 UNS_S21800', '1', '1447961736');
INSERT INTO `tbl_material_code` VALUES ('315', '1.000RD-NITRONIC 60', 'NITRONIC 60 A276, A314, A479 UNS_S21800', '1', '1447962770');
INSERT INTO `tbl_material_code` VALUES ('316', '.500RD-K MONEL', 'K MONEL B865 UNS_N04400', '1', '1447963377');
INSERT INTO `tbl_material_code` VALUES ('317', '.625RD-K MONEL', 'K MONEL B865 UNS_N04400', '1', '1447963394');
INSERT INTO `tbl_material_code` VALUES ('318', '.750RD-K MONEL', 'K MONEL B865 UNS_N04400', '1', '1447963414');
INSERT INTO `tbl_material_code` VALUES ('319', '1.000RD-K MONEL', 'K MONEL B865 UNS_N04400', '1', '1447963430');
INSERT INTO `tbl_material_code` VALUES ('320', '1.500RD-K MONEL', 'K MONEL B865 UNS_N04400', '1', '1447963450');
INSERT INTO `tbl_material_code` VALUES ('321', '.625RD-NAVAL BRASS', 'NAVAL BRASS B21 UNS_R30006', '1', '1447963932');
INSERT INTO `tbl_material_code` VALUES ('322', '.875RD-STELLITE 12', 'STELLITE 12 UNS_R30012', '1', '1447964229');
INSERT INTO `tbl_material_code` VALUES ('323', '1.000RD-STELLITE 12', 'STELLITE 12 UNS_R30012', '1', '1447964348');
INSERT INTO `tbl_material_code` VALUES ('324', '1.250RD-STELLITE 12', 'STELLITE 12 UNS_R30012', '1', '1447964364');
INSERT INTO `tbl_material_code` VALUES ('325', '.625RD-STELLITE 6B', 'STELLITE 6B UNS_R30006', '1', '1447964403');
INSERT INTO `tbl_material_code` VALUES ('326', '.750RD-STELLITE 6B', 'STELLITE 6B UNS_R30006', '1', '1447964421');
INSERT INTO `tbl_material_code` VALUES ('327', '.875RD-STELLITE 6B', 'STELLITE 6B UNS_R30006', '1', '1447964435');
INSERT INTO `tbl_material_code` VALUES ('328', '1.000RD-STELLITE 6B', 'STELLITE 6B UNS_R30006', '1', '1447964449');
INSERT INTO `tbl_material_code` VALUES ('329', '1.250RD-STELLITE 6B', 'STELLITE 6B UNS_R30006', '1', '1447964465');
INSERT INTO `tbl_material_code` VALUES ('330', '1.750RD-STELLITE 6B', 'STELLITE 6B UNS_R30006', '1', '1447964482');
INSERT INTO `tbl_material_code` VALUES ('331', '1.125RD-STELLITE 6B', 'STELLITE 6B UNS_R30006', '1', '1447964497');
INSERT INTO `tbl_material_code` VALUES ('332', '1.375RD-STELLITE 6B', 'STELLITE 6B UNS_R30006', '1', '1447964517');
INSERT INTO `tbl_material_code` VALUES ('333', '2.000RD-STELLITE 6B', 'STELLITE 6B UNS_R30006', '1', '1447964533');
INSERT INTO `tbl_material_code` VALUES ('334', '2.250RD-STELLITE 6B', 'STELLITE 6B UNS_R30006', '1', '1447964549');
INSERT INTO `tbl_material_code` VALUES ('335', '2.500RD-STELLITE 6B', 'STELLITE 6B UNS_R30006', '1', '1447964572');
INSERT INTO `tbl_material_code` VALUES ('336', '2.750RD-STELLITE 6B', 'STELLITE 6B UNS_R30006', '1', '1447964587');
INSERT INTO `tbl_material_code` VALUES ('337', '3.000RD-STELLITE 6B', 'STELLITE 6B UNS_R30006', '1', '1447964603');
INSERT INTO `tbl_material_code` VALUES ('338', '4.500RD-UHMW', 'UHMW POLYETHYLENE', '1', '1448410746');
INSERT INTO `tbl_material_code` VALUES ('339', '4.500RD-UHMW TUBE', 'UHMW POLYETHYLENE', '1', '1448410872');
INSERT INTO `tbl_material_code` VALUES ('340', '2.00RD-4140 Q&T T.G.&P.', '4140 GROUND SHAFTING', '1', '1448411077');
INSERT INTO `tbl_material_code` VALUES ('341', '4.00RD-C1045 T.G. & P.', '1045 GROUND STEEL', '1', '1448411233');
INSERT INTO `tbl_material_code` VALUES ('342', '2.500RD-100KCR', '100K CHROMED CHAFTING', '1', '1448557558');
INSERT INTO `tbl_material_code` VALUES ('343', '10.50RD-PLTSTL', 'FLAME CUT PLATE STEEL', '1', '1448557741');
INSERT INTO `tbl_material_code` VALUES ('345', '10.750RDTB-STL/HONED', 'HONED TUBING', '1', '1448908294');
INSERT INTO `tbl_material_code` VALUES ('346', '3.750RD-1215 CD', '1215 COLD DRAWN STEEL ASTM A108', '0', '1449600924');
INSERT INTO `tbl_material_code` VALUES ('347', '1.250RD-4140 HTSR', '4140 HTSR', '0', '1449601360');
INSERT INTO `tbl_material_code` VALUES ('348', '3.000RD-A516-70', 'A516-70 PLATE STEEL', '0', '1449622375');
INSERT INTO `tbl_material_code` VALUES ('349', '2.7500RD-1215 CD', '1215 COLD DRAWN STEEL ASTM A108', '0', '1449622462');
INSERT INTO `tbl_material_code` VALUES ('350', '3.500TB-A53-B PIPE', 'A53-B PIPE/TUBING', '0', '1449622567');
INSERT INTO `tbl_material_code` VALUES ('351', '1.750RD-1045', 'A311 GR 1045 CL B', '0', '1449622648');
INSERT INTO `tbl_material_code` VALUES ('352', '15.00RDPLx3.25-A516-70', 'A516-70 PLATE STEEL', '0', '1449623387');
INSERT INTO `tbl_material_code` VALUES ('353', '2.125RD-1018', '1018 CRS A108 UNS_G10180 FA-003', '0', '1450095650');
INSERT INTO `tbl_material_code` VALUES ('354', '.750RD-1018', '1018 CRS A108 UNS_G10180 FA-003', '0', '1450095859');
INSERT INTO `tbl_material_code` VALUES ('355', '1.625RD-1018', '1018 CRS A108 UNS_G10180 FA-003', '0', '1450095862');
INSERT INTO `tbl_material_code` VALUES ('356', '1.500RD-1018', '1018 CRS A108 UNS_G10180 FA-003', '0', '1450095892');
INSERT INTO `tbl_material_code` VALUES ('357', '3.00RD-4130 ANN', '4130 ANNELED @ 865', '0', '1455293348');
INSERT INTO `tbl_material_code` VALUES ('358', '1.125RD-4130 ANN', '4130 ANNELED @ 865', '0', '1455293368');
INSERT INTO `tbl_material_code` VALUES ('359', '6061-T6 Aluminum Block', '6061-T6 Aluminum', '0', '1457728980');
INSERT INTO `tbl_material_code` VALUES ('360', '12.00RD-GreyIron', 'GrayIron (Cast Iron) ASTM A48', '0', '1457793508');
INSERT INTO `tbl_material_code` VALUES ('361', '2.00RD-6061', 'ALUMINUM 6061 ASTM B308/B308M', '0', '1462295231');
INSERT INTO `tbl_material_code` VALUES ('362', '1.125RD-6061', 'ALUMINUM 6061 ASTM B308/B308M', '0', '1462295431');
INSERT INTO `tbl_material_code` VALUES ('363', '1.00RD-6061', 'ALUMINUM 6061 ASTM B308/B308M', '0', '1462295498');
INSERT INTO `tbl_material_code` VALUES ('364', '1.50RD 6061', 'ALUMINUM 6061 ASTM B308/B308M', '0', '1462298320');
INSERT INTO `tbl_material_code` VALUES ('365', '.750RD-6061', '6061-T6 ALUMINUM', '0', '1462625658');
INSERT INTO `tbl_material_code` VALUES ('366', '1.166\" T-12 DP-12 PA20 4140ANN', '4140 Gear Stock', '0', '1463170852');
INSERT INTO `tbl_material_code` VALUES ('367', '2.166\" T-24 DP-12 PA-20 AISI1215', 'AISI1215 GEAR STK', '0', '1463170950');
INSERT INTO `tbl_material_code` VALUES ('368', '1.25\" T-28 DP-24 PA-20 AISI1215', 'AISI 1215 GEAR STOCK', '0', '1463171001');
INSERT INTO `tbl_material_code` VALUES ('369', '2.50\" T-58 DP-24 PA-20 AISI 1215', 'AISI1215 GEAR STOCK', '0', '1463171046');
INSERT INTO `tbl_material_code` VALUES ('370', '4.25DIA-Cast Elec BX', 'Electtric Box Reynolds', '0', '1469465877');
INSERT INTO `tbl_material_code` VALUES ('371', '1.625RD-6061T6', '6061-T6 ALUMINUM', '0', '1472745211');

-- ----------------------------
-- Table structure for tbl_material_heatnumber
-- ----------------------------
DROP TABLE IF EXISTS `tbl_material_heatnumber`;
CREATE TABLE `tbl_material_heatnumber` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `material_id` int(11) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `heatnumber` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `designation` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `quantity_detail` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of tbl_material_heatnumber
-- ----------------------------
INSERT INTO `tbl_material_heatnumber` VALUES ('6', '10', '0', 'Material Heat 1', 'Designation 1', '83', '[{\"quantity\":10,\"length\":100},{\"quantity\":25,\"length\":80},{\"quantity\":5,\"length\":120},{\"quantity\":2,\"length\":11},{\"quantity\":2,\"length\":10},{\"quantity\":21,\"length\":13},{\"quantity\":1,\"length\":\"12.3\"},{\"quantity\":5,\"length\":\"12.5\"},{\"quantity\":11,\"length\":\"1.2\"},{\"quantity\":1,\"length\":\"10.6\"}]');
INSERT INTO `tbl_material_heatnumber` VALUES ('7', '10', '0', 'Material Heat 2', 'Designation 2', '196', '[{\"quantity\":47,\"length\":100},{\"quantity\":30,\"length\":55},{\"quantity\":5,\"length\":20},{\"quantity\":42,\"length\":13},{\"quantity\":2,\"length\":\"86\"},{\"quantity\":15,\"length\":\"88\"},{\"quantity\":55,\"length\":\"72\"}]');
INSERT INTO `tbl_material_heatnumber` VALUES ('8', '10', '0', 'Heat 3', 'Desg3', '7', '[{\"quantity\":2,\"length\":\"1.1\"},{\"quantity\":5,\"length\":\"9.7\"}]');
INSERT INTO `tbl_material_heatnumber` VALUES ('9', '10', '0', 'Heat 3', 'ddg', '0', '');
INSERT INTO `tbl_material_heatnumber` VALUES ('10', '10', '0', 'H#45', '', '0', '');
INSERT INTO `tbl_material_heatnumber` VALUES ('11', '10', '0', '56676', '', '0', '');
INSERT INTO `tbl_material_heatnumber` VALUES ('12', '14', '0', 'Heat 1', '', '17', '[{\"quantity\":14,\"length\":\"100\"},{\"quantity\":3,\"length\":\"35\"}]');
INSERT INTO `tbl_material_heatnumber` VALUES ('13', '14', '0', 'Heat 2', '', '8', '[{\"quantity\":8,\"length\":\"100\"}]');
INSERT INTO `tbl_material_heatnumber` VALUES ('14', '15', '0', 'NULL-GFW', '', '47', '[{\"quantity\":47,\"length\":\"5\"}]');
INSERT INTO `tbl_material_heatnumber` VALUES ('15', '16', '0', 'NONE', '', '0', '');
INSERT INTO `tbl_material_heatnumber` VALUES ('16', '8', '0', 'Nam heat 1', '', '0', '');
INSERT INTO `tbl_material_heatnumber` VALUES ('17', '8', '0', 'Nam heat 2', '', '0', '');
INSERT INTO `tbl_material_heatnumber` VALUES ('18', '24', '0', 'Heatnumber 1', '', '10', '[{\"quantity\":10,\"length\":\"100\"}]');
INSERT INTO `tbl_material_heatnumber` VALUES ('19', '24', '0', 'Heatnumber 2', '', '8', '[{\"quantity\":3,\"length\":\"200\"},{\"quantity\":5,\"length\":\"50\"}]');
INSERT INTO `tbl_material_heatnumber` VALUES ('20', '28', '0', 'Nov_4_Heat1', '', '17', '[{\"quantity\":5,\"length\":\"10\"},{\"quantity\":7,\"length\":\"12\"},{\"quantity\":3,\"length\":\"22\"},{\"quantity\":2,\"length\":\"31\"}]');
INSERT INTO `tbl_material_heatnumber` VALUES ('21', '28', '0', 'Nov_4_Heat2', 'C21', '89', '[{\"quantity\":20,\"length\":\"21\"},{\"quantity\":69,\"length\":\"3\"}]');
INSERT INTO `tbl_material_heatnumber` VALUES ('22', '30', '0', 'Heat1_HVD_NOV_11', '', '7', '[{\"quantity\":7,\"length\":\"50\"}]');
INSERT INTO `tbl_material_heatnumber` VALUES ('23', '35', '0', '678908', 'A1689', '6', '[{\"quantity\":5,\"length\":\"144\"},{\"quantity\":1,\"length\":\"67\"}]');
INSERT INTO `tbl_material_heatnumber` VALUES ('24', '36', '0', 'N1B0', 'A1869', '11', '[{\"quantity\":10,\"length\":\"145\"},{\"quantity\":1,\"length\":\"48\"}]');
INSERT INTO `tbl_material_heatnumber` VALUES ('25', '37', '0', 'H9R7', 'A1588', '2', '[{\"quantity\":2,\"length\":\"6.500\"}]');
INSERT INTO `tbl_material_heatnumber` VALUES ('26', '38', '0', 'CH-1118', 'A1850', '5', '[{\"quantity\":3,\"length\":\"159\"},{\"quantity\":1,\"length\":\"61.75\"},{\"quantity\":1,\"length\":\"36\"}]');
INSERT INTO `tbl_material_heatnumber` VALUES ('27', '39', '0', '9SB0059-G26', 'A1598', '1', '[{\"quantity\":1,\"length\":\"66\"}]');
INSERT INTO `tbl_material_heatnumber` VALUES ('28', '39', '0', 'W0Y2', '1880', '5', '[{\"quantity\":5,\"length\":\"144\"}]');
INSERT INTO `tbl_material_heatnumber` VALUES ('29', '40', '0', 'E120244', 'A1847', '1', '[{\"quantity\":1,\"length\":\"48\"}]');
INSERT INTO `tbl_material_heatnumber` VALUES ('30', '40', '0', '35454', '1855', '1', '[{\"quantity\":1,\"length\":\"146\"}]');
INSERT INTO `tbl_material_heatnumber` VALUES ('31', '39', '0', '3Q384', 'A1822', '1', '[{\"quantity\":1,\"length\":\"7\"}]');
INSERT INTO `tbl_material_heatnumber` VALUES ('32', '41', '0', '2U288', 'A1196', '2', '[{\"quantity\":2,\"length\":\"4.5\"}]');
INSERT INTO `tbl_material_heatnumber` VALUES ('33', '42', '0', 'H9R9', '', '3', '[{\"quantity\":3,\"length\":\"144\"}]');
INSERT INTO `tbl_material_heatnumber` VALUES ('34', '55', '0', 'NULL', '-', '5', '[{\"quantity\":5,\"length\":\"24\"}]');
INSERT INTO `tbl_material_heatnumber` VALUES ('35', '56', '0', 'NULL', '-', '2', '[{\"quantity\":2,\"length\":\"24\"}]');
INSERT INTO `tbl_material_heatnumber` VALUES ('36', '57', '0', 'NULL', '-', '5', '[{\"quantity\":5,\"length\":\"24\"}]');
INSERT INTO `tbl_material_heatnumber` VALUES ('37', '58', '0', 'NULL', '-', '6', '[{\"quantity\":5,\"length\":\"24\"},{\"quantity\":1,\"length\":\"20\"}]');
INSERT INTO `tbl_material_heatnumber` VALUES ('38', '59', '0', '1-11-1-1', 'B299', '3', '[{\"quantity\":2,\"length\":\"4\"},{\"quantity\":1,\"length\":\"2\"}]');
INSERT INTO `tbl_material_heatnumber` VALUES ('39', '60', '0', 'MA1568', 'B099', '1', '[{\"quantity\":1,\"length\":\"4.5\"}]');
INSERT INTO `tbl_material_heatnumber` VALUES ('40', '61', '0', '1504102911', 'B327', '1', '[{\"quantity\":1,\"length\":\"3\"}]');
INSERT INTO `tbl_material_heatnumber` VALUES ('41', '61', '0', '129401.12.1', 'B248', '1', '[{\"quantity\":1,\"length\":\"1.625\"}]');
INSERT INTO `tbl_material_heatnumber` VALUES ('42', '62', '0', '150410388', 'B329', '1', '[{\"quantity\":1,\"length\":\"1\"}]');
INSERT INTO `tbl_material_heatnumber` VALUES ('43', '63', '0', 'C15908/1-2', 'B289', '2', '[{\"quantity\":1,\"length\":\"1\"},{\"quantity\":1,\"length\":\"3\"}]');
INSERT INTO `tbl_material_heatnumber` VALUES ('44', '63', '0', '1-5-1-1', 'B191', '1', '[{\"quantity\":1,\"length\":\"3\"}]');
INSERT INTO `tbl_material_heatnumber` VALUES ('45', '64', '0', '1-3-1-1', 'B175', '1', '[{\"quantity\":1,\"length\":\"2.250\"}]');
INSERT INTO `tbl_material_heatnumber` VALUES ('46', '65', '0', 'D1A7', 'A1444', '1', '[{\"quantity\":1,\"length\":\"5.500\"}]');
INSERT INTO `tbl_material_heatnumber` VALUES ('47', '65', '0', '2JN7', 'A886', '1', '[{\"quantity\":1,\"length\":\"3\"}]');
INSERT INTO `tbl_material_heatnumber` VALUES ('48', '65', '0', '252354', 'A1783', '1', '[{\"quantity\":1,\"length\":\"5.250\"}]');
INSERT INTO `tbl_material_heatnumber` VALUES ('49', '66', '0', '5KC2', 'A1063', '1', '[{\"quantity\":1,\"length\":\"1.750\"}]');
INSERT INTO `tbl_material_heatnumber` VALUES ('50', '67', '0', 'FS4876', 'A747', '1', '[{\"quantity\":1,\"length\":\"2.00\"}]');
INSERT INTO `tbl_material_heatnumber` VALUES ('51', '68', '0', 'E43324', 'A726', '1', '[{\"quantity\":1,\"length\":\"6.500\"}]');
INSERT INTO `tbl_material_heatnumber` VALUES ('52', '65', '0', 'H2D4', 'A1557', '2', '[{\"quantity\":2,\"length\":\"5\"}]');
INSERT INTO `tbl_material_heatnumber` VALUES ('53', '69', '0', 'D2K4', 'A1455', '1', '[{\"quantity\":1,\"length\":\"6.000\"}]');
INSERT INTO `tbl_material_heatnumber` VALUES ('54', '34', '0', '100084', '', '1', '[{\"quantity\":1,\"length\":\"54\"}]');
INSERT INTO `tbl_material_heatnumber` VALUES ('55', '22', '0', '397497', 'C55', '12', '[{\"quantity\":12,\"length\":\"144\"}]');
INSERT INTO `tbl_material_heatnumber` VALUES ('56', '32', '0', 'W4W9', '', '4', '[{\"quantity\":0,\"length\":\"144\"},{\"quantity\":4,\"length\":\"15\"}]');
INSERT INTO `tbl_material_heatnumber` VALUES ('57', '70', '0', '83622', 'A1284', '5', '[{\"quantity\":5,\"length\":\"3.5\"}]');
INSERT INTO `tbl_material_heatnumber` VALUES ('58', '71', '0', '252352', 'A1345', '1', '[{\"quantity\":1,\"length\":\"2\"}]');
INSERT INTO `tbl_material_heatnumber` VALUES ('59', '69', '0', 'A7B6', 'C1353', '1', '[{\"quantity\":1,\"length\":\"1\"}]');
INSERT INTO `tbl_material_heatnumber` VALUES ('60', '71', '0', '62121', 'A608', '1', '[{\"quantity\":1,\"length\":\"2.75\"}]');
INSERT INTO `tbl_material_heatnumber` VALUES ('61', '71', '0', '98006', 'A1873', '1', '[{\"quantity\":1,\"length\":\"1.5\"}]');
INSERT INTO `tbl_material_heatnumber` VALUES ('62', '26', '0', '12808831', 'B242', '1', '[{\"quantity\":1,\"length\":\"3\"}]');
INSERT INTO `tbl_material_heatnumber` VALUES ('63', '26', '0', 'H202660', 'B193', '5', '[{\"quantity\":5,\"length\":\"2.250\"}]');
INSERT INTO `tbl_material_heatnumber` VALUES ('64', '30', '0', 'Heatnumber 25022016_3', 'NN3', '2', '[{\"quantity\":2,\"length\":\"50\"}]');
INSERT INTO `tbl_material_heatnumber` VALUES ('65', '30', '0', 'Heatnumber 25022016_4', 'NN4', '0', '');
INSERT INTO `tbl_material_heatnumber` VALUES ('66', '30', '0', 'Heatnumber 25022016_5', 'NN5', '0', '');
INSERT INTO `tbl_material_heatnumber` VALUES ('67', '30', '0', 'Heatnumber 25022016_6', 'NN6', '0', '');
INSERT INTO `tbl_material_heatnumber` VALUES ('68', '14', '0', 'Heatnumber 25022016_3', 'NN3', '0', '');
INSERT INTO `tbl_material_heatnumber` VALUES ('69', '14', '0', 'Heatnumber 25022016_4', 'NN4', '0', '');
INSERT INTO `tbl_material_heatnumber` VALUES ('70', '14', '0', 'Heatnumber 25022016_5', 'NN5', '0', '');
INSERT INTO `tbl_material_heatnumber` VALUES ('71', '14', '0', 'Heatnumber 25022016_6', 'NN6', '0', '');
INSERT INTO `tbl_material_heatnumber` VALUES ('72', '14', '0', 'Heatnumber 25022016_7', 'NN7', '0', '');
INSERT INTO `tbl_material_heatnumber` VALUES ('73', '14', '0', 'Heatnumber 25022016_8', 'NN8', '0', '');
INSERT INTO `tbl_material_heatnumber` VALUES ('74', '28', '0', 'HEAT TEST 1010', 'ABC', '0', '');
INSERT INTO `tbl_material_heatnumber` VALUES ('75', '28', '0', 'HEAT TEST 102ee', 'DEF', '0', '');
INSERT INTO `tbl_material_heatnumber` VALUES ('76', '28', '0', 'đâsfdad', '', '0', '');
INSERT INTO `tbl_material_heatnumber` VALUES ('77', '28', '0', 'ddd', '', '0', '');
INSERT INTO `tbl_material_heatnumber` VALUES ('78', '28', '0', '0lk hE', 'ABC', '0', '');
INSERT INTO `tbl_material_heatnumber` VALUES ('79', '28', '0', 'jhkhj1', 'DEF', '0', '');
INSERT INTO `tbl_material_heatnumber` VALUES ('80', '28', '0', 'sad', '', '0', '');
INSERT INTO `tbl_material_heatnumber` VALUES ('81', '46', '0', '100KCHROME', '', '2', '[{\"quantity\":2,\"length\":\"48.2\"}]');

-- ----------------------------
-- Table structure for tbl_material_heatnumber_location
-- ----------------------------
DROP TABLE IF EXISTS `tbl_material_heatnumber_location`;
CREATE TABLE `tbl_material_heatnumber_location` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `material_heatnumber_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `quantity_detail` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `created_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of tbl_material_heatnumber_location
-- ----------------------------
INSERT INTO `tbl_material_heatnumber_location` VALUES ('1', '12', '1', '4', '[{\"length\":\"100\",\"quantity\":4},{\"length\":\"35\",\"quantity\":1}]', '1445241067');
INSERT INTO `tbl_material_heatnumber_location` VALUES ('2', '12', '2', '10', '[{\"length\":\"100\",\"quantity\":10},{\"length\":\"35\",\"quantity\":2}]', '1445241067');
INSERT INTO `tbl_material_heatnumber_location` VALUES ('3', '13', '1', '8', '[{\"length\":\"100\",\"quantity\":8}]', '1445241098');
INSERT INTO `tbl_material_heatnumber_location` VALUES ('4', '7', '1', '16', '[{\"length\":13,\"quantity\":12},{\"length\":100,\"quantity\":21},{\"length\":\"72\",\"quantity\":16}]', '1445340619');
INSERT INTO `tbl_material_heatnumber_location` VALUES ('5', '6', '1', '2', '[{\"length\":100,\"quantity\":2}]', '1446519238');
INSERT INTO `tbl_material_heatnumber_location` VALUES ('6', '7', '2', '21', '[{\"length\":\"86\",\"quantity\":2},{\"length\":\"72\",\"quantity\":21}]', '1446521233');
INSERT INTO `tbl_material_heatnumber_location` VALUES ('7', '7', '3', '15', '[{\"length\":\"88\",\"quantity\":15},{\"length\":100,\"quantity\":16},{\"length\":\"72\",\"quantity\":18}]', '1446521398');
INSERT INTO `tbl_material_heatnumber_location` VALUES ('8', '18', '3', '4', '[{\"length\":\"100\",\"quantity\":4}]', '1446634318');
INSERT INTO `tbl_material_heatnumber_location` VALUES ('9', '18', '2', '6', '[{\"length\":\"100\",\"quantity\":6}]', '1446634431');
INSERT INTO `tbl_material_heatnumber_location` VALUES ('10', '19', '2', '3', '[{\"length\":\"200\",\"quantity\":3}]', '1446634570');
INSERT INTO `tbl_material_heatnumber_location` VALUES ('11', '19', '3', '5', '[{\"length\":\"50\",\"quantity\":5}]', '1446634570');
INSERT INTO `tbl_material_heatnumber_location` VALUES ('12', '20', '1', '5', '[{\"length\":\"10\",\"quantity\":5},{\"length\":\"12\",\"quantity\":7}]', '1446636328');
INSERT INTO `tbl_material_heatnumber_location` VALUES ('13', '20', '2', '3', '[{\"length\":\"22\",\"quantity\":3}]', '1446636328');
INSERT INTO `tbl_material_heatnumber_location` VALUES ('14', '20', '3', '2', '[{\"length\":\"31\",\"quantity\":2}]', '1446636328');
INSERT INTO `tbl_material_heatnumber_location` VALUES ('15', '21', '2', '20', '[{\"length\":\"21\",\"quantity\":20},{\"length\":\"3\",\"quantity\":7}]', '1446636328');
INSERT INTO `tbl_material_heatnumber_location` VALUES ('16', '21', '3', '60', '[{\"length\":\"3\",\"quantity\":60}]', '1446636328');
INSERT INTO `tbl_material_heatnumber_location` VALUES ('17', '21', '1', '2', '[{\"length\":\"3\",\"quantity\":2}]', '1446636543');
INSERT INTO `tbl_material_heatnumber_location` VALUES ('18', '23', '1', '5', '[{\"length\":\"144\",\"quantity\":5},{\"length\":\"67\",\"quantity\":1}]', '1448016590');
INSERT INTO `tbl_material_heatnumber_location` VALUES ('19', '24', '17', '10', '[{\"length\":\"145\",\"quantity\":10},{\"length\":\"48\",\"quantity\":1}]', '1448025256');
INSERT INTO `tbl_material_heatnumber_location` VALUES ('20', '25', '26', '2', '[{\"length\":\"6.500\",\"quantity\":2}]', '1448025712');
INSERT INTO `tbl_material_heatnumber_location` VALUES ('21', '26', '37', '3', '[{\"length\":\"159\",\"quantity\":3},{\"length\":\"61.75\",\"quantity\":1},{\"length\":\"36\",\"quantity\":1}]', '1448027877');
INSERT INTO `tbl_material_heatnumber_location` VALUES ('22', '27', '40', '1', '[{\"length\":\"66\",\"quantity\":1}]', '1448028622');
INSERT INTO `tbl_material_heatnumber_location` VALUES ('23', '28', '36', '5', '[{\"length\":\"144\",\"quantity\":5}]', '1448028983');
INSERT INTO `tbl_material_heatnumber_location` VALUES ('24', '29', '25', '1', '[{\"length\":\"48\",\"quantity\":1}]', '1448029440');
INSERT INTO `tbl_material_heatnumber_location` VALUES ('25', '30', '24', '1', '[{\"length\":\"146\",\"quantity\":1}]', '1448029604');
INSERT INTO `tbl_material_heatnumber_location` VALUES ('26', '31', '27', '1', '[{\"length\":\"7\",\"quantity\":1}]', '1448029838');
INSERT INTO `tbl_material_heatnumber_location` VALUES ('27', '32', '26', '2', '[{\"length\":\"4.5\",\"quantity\":2}]', '1448030083');
INSERT INTO `tbl_material_heatnumber_location` VALUES ('28', '33', '27', '3', '[{\"length\":\"144\",\"quantity\":3}]', '1448031562');
INSERT INTO `tbl_material_heatnumber_location` VALUES ('29', '34', '150', '5', '[{\"length\":\"24\",\"quantity\":5}]', '1450096815');
INSERT INTO `tbl_material_heatnumber_location` VALUES ('30', '35', '150', '2', '[{\"length\":\"24\",\"quantity\":2}]', '1450101032');
INSERT INTO `tbl_material_heatnumber_location` VALUES ('31', '36', '150', '5', '[{\"length\":\"24\",\"quantity\":5}]', '1450101392');
INSERT INTO `tbl_material_heatnumber_location` VALUES ('32', '37', '150', '5', '[{\"length\":\"24\",\"quantity\":5},{\"length\":\"20\",\"quantity\":1}]', '1450101686');
INSERT INTO `tbl_material_heatnumber_location` VALUES ('33', '38', '135', '2', '[{\"length\":\"4\",\"quantity\":2},{\"length\":\"2\",\"quantity\":1}]', '1450110096');
INSERT INTO `tbl_material_heatnumber_location` VALUES ('34', '39', '136', '1', '[{\"length\":\"4.5\",\"quantity\":1}]', '1450111520');
INSERT INTO `tbl_material_heatnumber_location` VALUES ('35', '41', '136', '1', '[{\"length\":\"1.625\",\"quantity\":1}]', '1450112074');
INSERT INTO `tbl_material_heatnumber_location` VALUES ('36', '40', '136', '1', '[{\"length\":\"3\",\"quantity\":1}]', '1450112159');
INSERT INTO `tbl_material_heatnumber_location` VALUES ('37', '42', '136', '1', '[{\"length\":\"1\",\"quantity\":1}]', '1450112479');
INSERT INTO `tbl_material_heatnumber_location` VALUES ('38', '43', '137', '1', '[{\"length\":\"1\",\"quantity\":1},{\"length\":\"3\",\"quantity\":1}]', '1450114537');
INSERT INTO `tbl_material_heatnumber_location` VALUES ('39', '44', '137', '1', '[{\"length\":\"3\",\"quantity\":1}]', '1450114710');
INSERT INTO `tbl_material_heatnumber_location` VALUES ('40', '45', '138', '1', '[{\"length\":\"2.250\",\"quantity\":1}]', '1450115110');
INSERT INTO `tbl_material_heatnumber_location` VALUES ('41', '47', '139', '1', '[{\"length\":\"3\",\"quantity\":1}]', '1450116496');
INSERT INTO `tbl_material_heatnumber_location` VALUES ('42', '46', '139', '1', '[{\"length\":\"5.500\",\"quantity\":1}]', '1450117389');
INSERT INTO `tbl_material_heatnumber_location` VALUES ('43', '48', '139', '1', '[{\"length\":\"5.250\",\"quantity\":1}]', '1450117484');
INSERT INTO `tbl_material_heatnumber_location` VALUES ('44', '49', '139', '1', '[{\"length\":\"1.750\",\"quantity\":1}]', '1450117783');
INSERT INTO `tbl_material_heatnumber_location` VALUES ('45', '50', '139', '1', '[{\"length\":\"2.00\",\"quantity\":1}]', '1450118011');
INSERT INTO `tbl_material_heatnumber_location` VALUES ('46', '51', '140', '1', '[{\"length\":\"6.500\",\"quantity\":1}]', '1450118353');
INSERT INTO `tbl_material_heatnumber_location` VALUES ('47', '52', '140', '2', '[{\"length\":\"5\",\"quantity\":2}]', '1450118559');
INSERT INTO `tbl_material_heatnumber_location` VALUES ('48', '53', '141', '1', '[{\"length\":\"6.000\",\"quantity\":1}]', '1450118839');
INSERT INTO `tbl_material_heatnumber_location` VALUES ('49', '54', '1', '1', '[{\"length\":\"54\",\"quantity\":1}]', '1450270020');
INSERT INTO `tbl_material_heatnumber_location` VALUES ('50', '55', '154', '12', '[{\"length\":\"144\",\"quantity\":12}]', '1450270993');
INSERT INTO `tbl_material_heatnumber_location` VALUES ('51', '56', '154', '0', '[{\"length\":\"144\",\"quantity\":0},{\"length\":\"15\",\"quantity\":4}]', '1450275387');
INSERT INTO `tbl_material_heatnumber_location` VALUES ('52', '57', '141', '5', '[{\"length\":\"3.5\",\"quantity\":5}]', '1451923023');
INSERT INTO `tbl_material_heatnumber_location` VALUES ('53', '58', '141', '1', '[{\"length\":\"2\",\"quantity\":1}]', '1451923320');
INSERT INTO `tbl_material_heatnumber_location` VALUES ('54', '59', '142', '1', '[{\"length\":\"1\",\"quantity\":1}]', '1453822815');
INSERT INTO `tbl_material_heatnumber_location` VALUES ('55', '60', '142', '1', '[{\"length\":\"2.75\",\"quantity\":1}]', '1453822987');
INSERT INTO `tbl_material_heatnumber_location` VALUES ('56', '61', '142', '1', '[{\"length\":\"1.5\",\"quantity\":1}]', '1453823093');
INSERT INTO `tbl_material_heatnumber_location` VALUES ('57', '62', '145', '1', '[{\"length\":\"3\",\"quantity\":1}]', '1453823549');
INSERT INTO `tbl_material_heatnumber_location` VALUES ('58', '63', '145', '5', '[{\"length\":\"2.250\",\"quantity\":5}]', '1453823696');
INSERT INTO `tbl_material_heatnumber_location` VALUES ('59', '22', '1', '7', '[{\"length\":\"50\",\"quantity\":7}]', '1456389805');
INSERT INTO `tbl_material_heatnumber_location` VALUES ('60', '64', '1', '2', '[{\"length\":\"50\",\"quantity\":2}]', '1456389935');
INSERT INTO `tbl_material_heatnumber_location` VALUES ('62', '81', '154', '2', '[{\"length\":\"48.2\",\"quantity\":2}]', '1457794821');

-- ----------------------------
-- Table structure for tbl_material_price
-- ----------------------------
DROP TABLE IF EXISTS `tbl_material_price`;
CREATE TABLE `tbl_material_price` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `date` int(11) NOT NULL,
  `material_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `created_time` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `total_inch` float NOT NULL,
  `weight` float NOT NULL,
  `price_per_inch` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of tbl_material_price
-- ----------------------------
INSERT INTO `tbl_material_price` VALUES ('1', '1446159600', '16', '2', '1', '1', '120', '13', '5');
INSERT INTO `tbl_material_price` VALUES ('2', '1444168800', '6', '1', '1441612557', '1', '12', '3', '6');
INSERT INTO `tbl_material_price` VALUES ('3', '1442361600', '9', '3', '1441822488', '1', '100', '1', '2');
INSERT INTO `tbl_material_price` VALUES ('4', '1452124800', '36', '7', '1452040238', '1', '580', '7000', '2');

-- ----------------------------
-- Table structure for tbl_operation
-- ----------------------------
DROP TABLE IF EXISTS `tbl_operation`;
CREATE TABLE `tbl_operation` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `created_time` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=armscii8;

-- ----------------------------
-- Records of tbl_operation
-- ----------------------------
INSERT INTO `tbl_operation` VALUES ('1', '1', 'Operation A1', '1', '1');
INSERT INTO `tbl_operation` VALUES ('2', '2', 'Operation B1', '1', '29');
INSERT INTO `tbl_operation` VALUES ('3', '1', 'A', '1', '1432877267');
INSERT INTO `tbl_operation` VALUES ('5', '1', 'A2', '1', '1432877574');
INSERT INTO `tbl_operation` VALUES ('6', '3', '.200dia drill', '1', '1433199530');
INSERT INTO `tbl_operation` VALUES ('7', '5', 'first side hub', '1', '1433199774');
INSERT INTO `tbl_operation` VALUES ('8', '5', 'drill/finsh Rad side', '1', '1433199807');
INSERT INTO `tbl_operation` VALUES ('9', '6', '8TPI+FLATS', '1', '1457796004');
INSERT INTO `tbl_operation` VALUES ('10', '5', 'OD/ID THREADS', '1', '1457796028');

-- ----------------------------
-- Table structure for tbl_operation_category
-- ----------------------------
DROP TABLE IF EXISTS `tbl_operation_category`;
CREATE TABLE `tbl_operation_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `created_time` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=armscii8;

-- ----------------------------
-- Records of tbl_operation_category
-- ----------------------------
INSERT INTO `tbl_operation_category` VALUES ('1', 'Group A', '1', '29');
INSERT INTO `tbl_operation_category` VALUES ('2', 'Group B', '1', '1432875338');
INSERT INTO `tbl_operation_category` VALUES ('3', 'Axial Drilling', '1', '1433199471');
INSERT INTO `tbl_operation_category` VALUES ('4', 'Radial Drilling', '1', '1433199491');
INSERT INTO `tbl_operation_category` VALUES ('5', 'Op1', '1', '1');
INSERT INTO `tbl_operation_category` VALUES ('6', 'Op2', '1', '1433199657');
INSERT INTO `tbl_operation_category` VALUES ('7', 'Op3', '1', '1433199669');
INSERT INTO `tbl_operation_category` VALUES ('8', 'Op4', '1', '1433199681');
INSERT INTO `tbl_operation_category` VALUES ('9', 'Op5', '1', '1433199691');

-- ----------------------------
-- Table structure for tbl_part
-- ----------------------------
DROP TABLE IF EXISTS `tbl_part`;
CREATE TABLE `tbl_part` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `part_code` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `category_id` int(11) unsigned NOT NULL,
  `description` varchar(2048) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `design` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `revision` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `uom_id` int(11) NOT NULL,
  `optimum_inventory` int(11) unsigned NOT NULL,
  `inventory_on_hand` int(11) unsigned NOT NULL,
  `notes` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `machine_id` int(11) unsigned NOT NULL,
  `location` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `shop_floor` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `material_id` int(11) unsigned NOT NULL,
  `bar_length_pc` int(11) unsigned NOT NULL,
  `bars_needed` int(11) unsigned NOT NULL,
  `slug_length` float unsigned NOT NULL,
  `heat_code` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `designation` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `created_time` int(11) unsigned NOT NULL,
  `created_by` int(11) NOT NULL,
  `drawing_file_id` int(11) NOT NULL,
  `bar_length` float NOT NULL,
  `part_length` float NOT NULL,
  `drawing` varchar(256) NOT NULL,
  `client_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=107 DEFAULT CHARSET=armscii8;

-- ----------------------------
-- Records of tbl_part
-- ----------------------------
INSERT INTO `tbl_part` VALUES ('1', '301279-010', '2', 'Jam Nut 2600 without X', 'X', 'A', '0', '15000', '2033', '<p>f</p>\n', '1', 'BOX 104', 'shopfloor', '1', '223', '752', '18', '', 'D1, D4', '1', '1426090233', '0', '0', '0', '0', '', '0');
INSERT INTO `tbl_part` VALUES ('2', '301279-010X', '1', 'Jam Nut 2600', 'X', 'A', '0', '15000', '15000', '', '1', 'BOX 104', 'shopfloor', '1', '223', '752', '18', '', null, '1', '1426090233', '0', '0', '0', '0', '', '0');
INSERT INTO `tbl_part` VALUES ('3', 'a', '3', 'a', 'a', 'a', '0', '0', '0', '', '1', '', 'a', '1', '0', '0', '1', '', '', '1', '1426090233', '0', '0', '0', '0', '', '0');
INSERT INTO `tbl_part` VALUES ('4', '123456Q', '2', 'Spring Button 2600', 'X', 'B', '0', '25000', '25000', '', '1', '', 'shopfloor', '1', '342', '123', '12', '', '', '1', '1427617415', '0', '0', '0', '0', '', '0');
INSERT INTO `tbl_part` VALUES ('5', '301951-010', '2', 'Spring Button 2600', 'X', 'B', '0', '25000', '25000', '', '2', '', '', '3', '342', '123', '12', '', '', '1', '1427649803', '0', '0', '0', '0', '', '0');
INSERT INTO `tbl_part` VALUES ('6', '303401X171-010', '1', 'desc2', '2', 'H', '2', '0', '0', '', '1', '', '', '3', '10', '10', '10', '', '', '1', '1427649910', '0', '0', '0', '0', '303401X171-010', '0');
INSERT INTO `tbl_part` VALUES ('7', '1234561Q', '1', 'desc5', '2', 'H', '2', '0', '0', '', '1', '', '', '1', '123', '123', '123', '', '', '1', '1427649976', '0', '0', '0', '0', '', '0');
INSERT INTO `tbl_part` VALUES ('8', '301279-010X1', '1', 'desc6', '3', 'H', '3', '0', '0', '', '4', '', '', '4', '12', '12', '12', '', '', '1', '1427650072', '0', '0', '0', '0', '', '0');
INSERT INTO `tbl_part` VALUES ('9', '301279-010X2', '1', 'desc', '2', 'H', '2', '0', '0', '', '4', '', '', '3', '12', '12', '12', '', '', '1', '1427650184', '0', '0', '0', '0', '', '0');
INSERT INTO `tbl_part` VALUES ('10', '301279-0102f', '1', 'desc', '2', 'H', '2', '0', '0', '', '5', '', '', '4', '15', '15', '15', '', '', '1', '1427650263', '0', '0', '0', '0', '', '0');
INSERT INTO `tbl_part` VALUES ('11', '301279-010X3', '2', 'desc', '1', 'H', '1', '100', '100', '<p>Test notes</p>\n', '5', '', '', '3', '15', '15', '15', '', '', '1', '1427650342', '0', '0', '0', '0', '', '0');
INSERT INTO `tbl_part` VALUES ('12', '301279-01022', '2', 'desc', '2', 'H', '3', '100', '95', '', '5', '', '', '3', '15', '0', '15', '', '', '1', '1427650435', '0', '0', '0', '0', '', '0');
INSERT INTO `tbl_part` VALUES ('13', '303401X17-010', '4', 'Stud Lock Screw 2600', 'X', 'C', '3', '1200', '21100', '', '4', '', '', '1', '431', '432', '13', '', '', '1', '1427650563', '0', '0', '0', '0', '', '0');
INSERT INTO `tbl_part` VALUES ('14', '301279-010Y', '5', 'Spring Button 2600', 'X', 'e', '3', '2000', '2000', '', '5', '', '', '2', '178', '178', '12.3', '', '', '1', '1427650652', '0', '0', '0', '0', '', '0');
INSERT INTO `tbl_part` VALUES ('15', '301279-0102', '5', 'Spring Button 2600', 'x', 'H', '3', '2000', '2000', '', '5', '', '', '2', '178', '178', '12.3', '', '', '1', '1427650738', '0', '0', '0', '0', '', '0');
INSERT INTO `tbl_part` VALUES ('16', 'q123', '1', 'wq', 'design', 'H', '0', '0', '0', '', '5', '', '', '1', '123', '234', '345', '', '', '1', '1427650812', '0', '0', '0', '0', '', '0');
INSERT INTO `tbl_part` VALUES ('17', 'newpart1', '1', 'newdescr1', 'testdesign', 'H', '3', '0', '0', '', '6', '', '', '4', '2', '2', '2', '', '', '1', '1427650929', '0', '0', '0', '0', '', '0');
INSERT INTO `tbl_part` VALUES ('18', 'newpart2', '9', 'newdescr2', 'test design', 'H', '3', '0', '0', '', '4', '', '', '5', '1', '1', '1', '', '', '1', '1427651023', '0', '0', '0', '0', '', '0');
INSERT INTO `tbl_part` VALUES ('19', '303401X17-010q', '2', 'desc', '1', 'H', '3', '100', '5', '', '4', 'row 4 box 12', '', '3', '12', '12', '12', '', '', '1', '1427651122', '0', '0', '0', '0', '333', '0');
INSERT INTO `tbl_part` VALUES ('20', 'newpart', '1', 'desc', 'design', 'H', '3', '0', '0', '', '4', '', '', '2', '1', '1', '1', '', '', '1', '1427651184', '0', '0', '0', '0', '', '0');
INSERT INTO `tbl_part` VALUES ('21', 'newpart10', '4', 'part 123', '100', 'H', '3', '0', '0', '', '7', '', '', '4', '10', '10', '10', '', '', '1', '1427651264', '0', '0', '0', '0', '', '0');
INSERT INTO `tbl_part` VALUES ('22', 'Nam_Test_1', '4', 'Description for Nam Test 1 Part', '', 'R1', '4', '1200', '0', 'This is the part created by Nam, for testing purpose', '0', '', '', '9', '0', '0', '0', null, '', '1', '1441851602', '1', '0', '10', '13', 'DE', '0');
INSERT INTO `tbl_part` VALUES ('23', 'HUNG_PART_SEP_10', '1', 'HUNG TEST PART SEP 10', '', 'Rev 1', '4', '1000', '0', '', '0', '', '', '1', '0', '0', '0', null, '', '1', '1441855125', '1', '0', '4', '5', 'Draw102', '0');
INSERT INTO `tbl_part` VALUES ('24', 'PART_TEST_BY_HUNG', '1', 'HUNG TESTS PART CREATION', '', 'REV 1', '4', '1000', '0', '', '0', '', '', '1', '0', '0', '0', null, '', '1', '1441888954', '1', '0', '10', '10', 'Drawing', '0');
INSERT INTO `tbl_part` VALUES ('25', '14INCH PISTON', '15', '14\" PISTON W/3\"-12THD', '', '-', '4', '0', '0', '<p>FLAME CUT PLATE STILL PROVIDED BY COSTUMER</p>\n', '0', '', '', '13', '0', '0', '0', null, '', '1', '1441891858', '1', '0', '4', '4.25', '14INCH PISTON', '5');
INSERT INTO `tbl_part` VALUES ('26', '15314-010-002', '17', 'LOCATION PIN - HUG JIG', '', '01', '4', '0', '0', '', '0', null, '', '15', '0', '0', '0', null, null, '1', '1442328224', '1', '0', '4', '3.9173', '15314-010-002', '0');
INSERT INTO `tbl_part` VALUES ('27', '12INX5.625X2-12THD', '15', '12\" PISTON WITH 2-12 ID THREAD', '', '-', '4', '0', '0', '', '0', '', '', '16', '0', '0', '0', null, '', '1', '1442405570', '1', '0', '1', '5.625', '12\" PISTON', '0');
INSERT INTO `tbl_part` VALUES ('28', '16INX5.875X3-12THD', '15', '16\" PISTON W/3-12 ID THREAD', '', '-', '4', '0', '0', '', '0', '', '', '17', '0', '0', '0', null, '', '1', '1442406106', '1', '0', '1', '5.875', '16\" PISTON', '0');
INSERT INTO `tbl_part` VALUES ('29', '4InX51.50X3-12THD', '16', '4\"dia Piston Rod 51.500lng W/3-12\"thd', '', '-', '4', '0', '0', '', '0', '', '', '19', '0', '0', '0', null, '', '1', '1442410638', '1', '0', '1', '51.5', '3 1/2-8 Mx 4\" PISTON ROD', '0');
INSERT INTO `tbl_part` VALUES ('30', '2.5InX40.875X2-12THD', '16', '2.5\"DIA X40.875 PISTON SHAFT W/2-12 THREAD', '', '-', '4', '0', '0', '', '0', '', '', '18', '0', '0', '0', null, '', '1', '1442411558', '1', '0', '1', '40.875', '2-8 M X 2.5\" PISTON ROD', '0');
INSERT INTO `tbl_part` VALUES ('31', '16123-122-015', '18', 'WINDOW PRIMER - NYLON ROLLER', '', '-', '4', '0', '0', '<p>MATERIAL SUPPLIED</p>\n', '0', '', '', '20', '0', '0', '0', null, '', '1', '1443529686', '1', '0', '48', '1.0826', '16123-122-015', '0');
INSERT INTO `tbl_part` VALUES ('32', '18InX6.875X3-12THD', '15', '18 piston with 3-12 thread', '', '-', '4', '0', '0', '<p>supplied billets</p>\n', '0', '', '', '21', '0', '0', '0', null, '', '1', '1444692444', '1', '0', '1', '5.875', '18Inch Piston', '5');
INSERT INTO `tbl_part` VALUES ('33', '5156791', '19', '1/2-13 BUTTON HEAD BOLTS', '', '-', '4', '0', '0', '<p>MATERIAL SUPPLIED</p>\n\n<p>JOB IS RFQ ONLY</p>\n', '0', '', '', '22', '0', '0', '0', null, '', '1', '1445039696', '1', '0', '48', '2.69', '5156791', '6');
INSERT INTO `tbl_part` VALUES ('34', '5156792', '20', '1/2-13 X 1-1/2LNG COUPLING', '', '-', '4', '0', '0', '<p>MATERIAL SUPPLIED</p>\n\n<p>JOB IS RFQ</p>\n', '0', '', '', '22', '0', '0', '0', null, '', '1', '1445040349', '1', '0', '47', '1.5', '5156792', '6');
INSERT INTO `tbl_part` VALUES ('35', '5156827', '20', 'DRAIN COUPLING', '', '-', '4', '0', '0', '<p>MATERIAL SUPPLIED</p>\n\n<p>RFQ ONLY</p>\n', '0', '', '', '23', '0', '0', '0', null, '', '1', '1445040612', '1', '0', '40', '0.75', '5156827', '6');
INSERT INTO `tbl_part` VALUES ('36', 'YC70185-933', '17', '37.7MM PIN MILL SQUARE', '', '-', '4', '0', '0', '<p>1-1/2 DIA STOCK</p>\n', '0', '', '', '15', '0', '0', '0', null, '', '1', '1445298713', '1', '0', '20', '1.6535', 'YC70185-933', '6');
INSERT INTO `tbl_part` VALUES ('37', '4InX36.375X3-12THD_P', '16', '36.375lg Chrome Piston Rod', '', '-', '4', '0', '0', '<p>material supplied by costumer</p>\n', '0', '', '', '27', '0', '0', '0', null, '', '1', '1446511709', '1', '0', '37', '36.375', '3 1/2-8 M x4\" Piston Rod', '5');
INSERT INTO `tbl_part` VALUES ('38', '4InX40.563X3-12THD_P', '16', '40.563PISTON ROD CHROMED', '', '-', '4', '0', '0', '', '0', '', '', '27', '0', '0', '0', null, '', '1', '1446512242', '1', '0', '41', '40.563', '3 1/2-8 M X 4\" Piston Rod', '5');
INSERT INTO `tbl_part` VALUES ('39', 'MS.T.ADP-F-01', '21', '3\'6\" MAST TIE ADAPTER', '', '3', '4', '0', '0', '<p>GFW PRICE $182.48 COMPLETE</p>\n', '0', '', '', '29', '0', '0', '0', null, '', '1', '1446836117', '1', '0', '240', '42', 'F-01', '7');
INSERT INTO `tbl_part` VALUES ('40', '1/2X8INCH-TOP PLATE', '23', '8\" DIA TOP PLATE X 1/2 THICK', '', '-', '4', '0', '0', '<p>MATERIAL QUOTED</p>\n', '0', '', '', '34', '0', '0', '0', null, '', '1', '1447807990', '1', '0', '0.5', '0.5', '1/2X8INCH-TOP PLATE', '6');
INSERT INTO `tbl_part` VALUES ('41', '1/2X8.0-BOTTOM PLATE', '23', '8INCH DIA. X 1/2 THICK BOTTOM PLATE', '', '-', '4', '0', '0', '', '0', '', '', '34', '0', '0', '0', null, '', '1', '1447808320', '1', '0', '0.5', '0.5', 'UNKNOWN', '6');
INSERT INTO `tbl_part` VALUES ('42', '1.0DIAx15.875LgSHAFT', '22', '1\"dia. x 15-7/8\"lng Top Support Shaft', '', '-', '4', '0', '0', '', '0', '', '', '31', '0', '0', '0', null, '', '1', '1447853802', '1', '0', '50', '15.875', 'unkown', '6');
INSERT INTO `tbl_part` VALUES ('43', '.750DIAX7.125SHAFT', '22', '3/4\"Dia X 7-1/8Lng Bottom Support Shaft', '', '-', '4', '0', '0', '', '0', '', '', '32', '0', '0', '0', null, '', '1', '1447854182', '1', '0', '50', '7.125', 'Uknown', '6');
INSERT INTO `tbl_part` VALUES ('44', 'SH-28.125X.625DIA', '22', '.625DIA X 28-1/8LN X 1/4-28THD', '', '-', '4', '0', '0', '', '0', '', '', '33', '0', '0', '0', null, '', '1', '1447854409', '1', '0', '144', '28.125', 'UKNOWN', '4');
INSERT INTO `tbl_part` VALUES ('45', 'BS-1/4X5/8DIA', '24', '5/8DIA X 1/4LNG X .308 HOLE BUSHING', '', '-', '4', '0', '0', '', '0', '', '', '33', '0', '0', '0', null, '', '1', '1447854734', '1', '0', '15', '0.25', 'UNKNOWN', '6');
INSERT INTO `tbl_part` VALUES ('46', 'BS-5/16X5/8DIA', '24', '5/8DIA X 5/16LG X.400HOLE', '', '-', '4', '0', '0', '', '0', '', '', '33', '0', '0', '0', null, '', '1', '1447854885', '1', '0', '19', '0.3125', 'UNKNOWN', '6');
INSERT INTO `tbl_part` VALUES ('47', 'BS-1.0X5/8DIA', '24', '5/8DIA X 1LG X.380GHOLE', '', '-', '4', '0', '0', '', '0', '', '', '33', '0', '0', '0', null, '', '1', '1447855073', '1', '0', '43', '1', 'UNKNOWN', '6');
INSERT INTO `tbl_part` VALUES ('48', '4.5DIAX2.5SLV', '25', 'SLEEVE FOR AIH REEL', '', '0', '4', '0', '0', '<p>NEED 66 PCS</p>\n', '0', '', '', '43', '0', '0', '0', null, '', '1', '1448412237', '1', '0', '144', '2.5', 'KCI-DWG', '8');
INSERT INTO `tbl_part` VALUES ('49', '40-4-0012', '26', '40.4 DRUM SHAFT HUB', '', '-', '4', '0', '0', '<p>current prices do not have material added</p>\n', '0', '', '', '45', '0', '0', '0', null, '', '1', '1448412437', '1', '0', '144', '1.5', '40-4-0012', '5');
INSERT INTO `tbl_part` VALUES ('50', '40-4-0013', '27', '40.4 DRUM SHAFT', '', '=', '4', '0', '0', '', '0', '', '', '44', '0', '0', '0', null, '', '1', '1448412716', '1', '0', '1', '51.5', '40-4-0013', '5');
INSERT INTO `tbl_part` VALUES ('51', '2.5INX22.688X2.25THD', '16', '2.5INX22.688X2.25THD CRHOM SHAFTING', '', '-', '4', '0', '0', '', '0', '', '', '46', '0', '0', '0', null, '', '1', '1448557638', '1', '0', '1', '22.688', '10R_CA_TR', '9');
INSERT INTO `tbl_part` VALUES ('52', '10INX4.750X2.25THD', '15', '10INX4.750X2.25THD  PISTONS', '', '-', '4', '0', '0', '', '0', '', '', '47', '0', '0', '0', null, '', '1', '1448557915', '1', '0', '5', '4.75', 'E10P_CA', '9');
INSERT INTO `tbl_part` VALUES ('53', '11.750INX13.437LG-TB', '28', '11.750DIA OD X 10IN ID X 13.437LNG BARREL', '', '-', '4', '0', '0', '', '0', '', '', '48', '0', '0', '0', null, '', '1', '1448908536', '1', '0', '14', '13.437', 'E10B_CA', '5');
INSERT INTO `tbl_part` VALUES ('54', 'HUNGHUNG_PART_SEP_10', '1', 'HUNG TEST PART SEP 10', '', 'Rev 1', '4', '1000', '0', '', '0', '', '', '1', '0', '0', '0', null, '', '1', '1449589084', '1', '0', '4', '5', 'Draw102', '0');
INSERT INTO `tbl_part` VALUES ('55', 'PART_SEP_10', '1', 'HUNG TEST PART SEP 10', '', 'Rev 1', '4', '1000', '0', '', '0', '', '', '1', '0', '0', '0', null, '', '1', '1449589627', '1', '0', '4', '5', 'Draw102', '0');
INSERT INTO `tbl_part` VALUES ('56', 'E-012002431', '29', '15\"DIA. END CAP ASSEMBLY WITH BOLT PATTERN', '', 'A', '4', '0', '0', '<p>PEICES TO BE WELDING WITH INSPECTION AND MACHINED AFTER.</p>\n\n<p><br />\n&nbsp;</p>\n', '0', '', '', '54', '0', '0', '0', null, '', '1', '1449623929', '1', '0', '1', '3', 'E-012002431', '9');
INSERT INTO `tbl_part` VALUES ('57', 'E-00000074', '31', 'JACKSCREW RAM NUT 3\" HEX OD', '', 'C', '4', '0', '0', '', '0', '', '', '52', '0', '0', '0', null, '', '1', '1449664859', '1', '0', '3', '1.94', 'E-00000074', '9');
INSERT INTO `tbl_part` VALUES ('58', 'E-01002179', '32', 'CHROMED JACKSCREW RAM WITH 3/4 BALL', '', '01', '4', '0', '0', '<p>PEICE TO GET HARD CHROMED ADD COSTS TO QUOTE</p>\n', '0', '', '', '49', '0', '0', '0', null, '', '1', '1449665673', '1', '0', '30', '7.75', 'E-01002179', '9');
INSERT INTO `tbl_part` VALUES ('59', 'E-01002405', '33', 'JACK SCREW W/OD ACME THREAD', '', '00', '4', '0', '0', '<p>ZINC PLATING ADDED TO PRICE</p>\n', '0', '', '', '51', '0', '0', '0', null, '', '1', '1449665788', '1', '0', '35', '8', 'E-01002405', '9');
INSERT INTO `tbl_part` VALUES ('60', 'E-00000076', '30', 'JACKSCREW RAM W/2-3/4-8 OD THREAD', '', 'B', '4', '0', '0', '<p>ADD E-COATED BLACK DFT FIN TO QUOTE</p>\n\n<p>$150.00MIN FROM A-CANADIAN GROUP</p>\n', '0', '', '', '53', '0', '0', '0', null, '', '1', '1449665912', '1', '0', '3', '0.75', 'E-00000076', '9');
INSERT INTO `tbl_part` VALUES ('61', 'E-01002178', '34', 'JACKSCREW BODY 3.5\"DIA TUBING', '', '01', '4', '0', '0', '', '0', '', '', '50', '0', '0', '0', null, '', '1', '1449666045', '1', '0', '25', '6.88', 'E-01002178', '9');
INSERT INTO `tbl_part` VALUES ('62', '012RA', '36', 'RET. BLOCK PIN 1\"DIA X1.344\"LNG', '', 'A', '4', '0', '0', '', '0', '', '', '74', '0', '0', '0', null, '', '1', '1455294253', '1', '0', '48', '1.344', 'DMCM-TLWP-012RA', '10');
INSERT INTO `tbl_part` VALUES ('63', '010RA', '35', 'RETENTION BLOCK A W/O-RING FACE GROOVE', '', 'A', '4', '0', '0', '', '0', '', '', '73', '0', '0', '0', null, '', '1', '1455294755', '1', '0', '40', '0.898', 'DMCM-TLWP-010RA', '10');
INSERT INTO `tbl_part` VALUES ('64', '011RA', '35', 'RETENTION BLOCK B W/.250 HOLES', '', 'A', '4', '0', '0', '', '0', '', '', '73', '0', '0', '0', null, '', '1', '1455295494', '1', '0', '40', '0.44', 'DMCM-TLWP-011RA', '10');
INSERT INTO `tbl_part` VALUES ('65', '301951fake', '2', '2.75 \"\\ spring button', '', 'J', '4', '300', '0', '<p>PARTS ARE SLUGGED</p>\n', '0', '', '', '69', '0', '0', '0', null, '', '1', '1455474128', '1', '0', '1', '0.91', '1951', '6');
INSERT INTO `tbl_part` VALUES ('66', '61-DAQ CLAMP PLATE', '37', 'ALUMINUM CLAMP PLATE 3.0\"X3.5\"X3/8\"', '', 'A', '4', '0', '0', '', '0', '', '', '75', '0', '0', '0', null, '', '1', '1457729375', '1', '0', '3', '3', '61-DAQ CLAMP PLATE', '11');
INSERT INTO `tbl_part` VALUES ('67', '61-SPLIT CLAMP 1.00 ', '38', 'ALUMINUM SPLIT CLAMP 1.250\"X3.0\" W/1\"HOLE', '', 'A', '4', '0', '0', '', '0', '', '', '75', '0', '0', '0', null, '', '1', '1457729526', '1', '0', '3', '3', '61-SPLIT CLAMP 1.00 IN DIA', '11');
INSERT INTO `tbl_part` VALUES ('68', '12InX2.625X 2.25-12 ', '15', '12\"x2.625lng Grey Iron Piston', '', '-', '4', '0', '0', '<p>cast billets</p>\n', '0', '', '', '76', '0', '0', '0', null, '', '1', '1457793912', '1', '0', '3', '2.625', '12 INCH PISTON', '9');
INSERT INTO `tbl_part` VALUES ('69', 'PR2.5InX48.1x2.250Th', '16', '2.5\"dia x 48.1lng Piston Rod', '', '-', '4', '0', '0', '<p>Chrome Shafting supplied</p>\n', '0', '', '', '46', '0', '0', '0', null, '', '1', '1457794153', '1', '0', '48.2', '48.1', '2-1/4x2.5 PS Rod w/Cushion', '9');
INSERT INTO `tbl_part` VALUES ('70', 'R-1000-20-02-0001-V2', '47', '3/4\" X 5.7 LNG Hex Shaft', '', '-', '4', '0', '0', '', '0', '', '', '81', '0', '0', '0', null, '', '1', '1462298908', '15', '0', '144', '5.7', 'R-1000-20-02-0001-V2', '12');
INSERT INTO `tbl_part` VALUES ('71', 'R-1000-20-02-035', '52', '3/8 X 4.901 w/8-32Tap Grinder Input Crank Shaft', '', '-', '4', '0', '0', '', '0', '', '', '38', '0', '0', '0', null, '', '1', '1462300147', '15', '0', '144', '4.901', 'R-1000-20-02-035', '12');
INSERT INTO `tbl_part` VALUES ('72', 'R-1000-20-02-023', '51', '.029\" Grvs & 8-32Tap Grinder Interlock Gearshaft', '', '-', '4', '0', '0', '<p>.374 grnd stock</p>\n', '0', '', '', '38', '0', '0', '0', null, '', '1', '1462300590', '15', '0', '144', '1.034', 'R-1000-20-02-023', '12');
INSERT INTO `tbl_part` VALUES ('73', 'R-1000-20-02-025', '51', '.374 w/.029\" grvs Grinder Interlock Pivot Shaft', '', '-', '4', '0', '0', '<p>.374 grnd stk</p>\n', '0', '', '', '38', '0', '0', '0', null, '', '1', '1462300738', '15', '0', '144', '2.14', 'R-1000-20-02-025', '12');
INSERT INTO `tbl_part` VALUES ('74', 'R-1000-20-02-036', '51', '.374 + 8-32Tap Grinder Interlock Shaft', '', '-', '4', '0', '0', '<p>.374 grnd stk</p>\n', '0', '', '', '38', '0', '0', '0', null, '', '1', '1462301092', '15', '0', '144', '1.171', 'R-1000-20-02-036', '12');
INSERT INTO `tbl_part` VALUES ('75', 'R-1000-40-02-0009', '50', '.250 X 1.375 Shoulder Pins(UI SHaft)', '', '-', '4', '0', '0', '<p>1/4stk with a -.002 50 -.005 tolerance.</p>\n', '0', '', '', '36', '0', '0', '0', null, '', '1', '1462301287', '15', '0', '144', '1.375', 'R-1000-40-02-0009', '12');
INSERT INTO `tbl_part` VALUES ('76', 'R-1000-60-02-0002', '49', '.375 X 7.75 Sooler Shaft 1/4-20Thds', '', '-', '4', '0', '0', '<p>from .374 ground stock</p>\n', '0', '', '', '38', '0', '0', '0', null, '', '1', '1462302276', '15', '0', '144', '7.75', 'R-1000-60-02-0002', '12');
INSERT INTO `tbl_part` VALUES ('77', 'R-1000-40-02-0019', '48', '.374 w/1/4-20thrd Sensor Adjuster', '', '-', '4', '0', '0', '', '0', '', '', '38', '0', '0', '0', null, '', '1', '1462302424', '15', '0', '144', '1.435', 'R-1000-40-02-0019', '12');
INSERT INTO `tbl_part` VALUES ('78', 'R-000-10-02-0014', '39', '2.00 X 3.50 Extruder Cold Section', '', '-', '4', '0', '0', '', '0', '', '', '77', '0', '0', '0', null, '', '1', '1462302853', '15', '0', '144', '3.5', 'R-000-10-02-0014', '12');
INSERT INTO `tbl_part` VALUES ('79', 'R-1000-10-02-0015', '39', '2.00 X 4.14 EXTRUDER HOT SECTION', '', '-', '4', '0', '0', '', '0', '', '', '77', '0', '0', '0', null, '', '1', '1462303038', '15', '0', '144', '4.14', 'R-1000-10-02-0015', '12');
INSERT INTO `tbl_part` VALUES ('80', 'R-1000-10-02-0003', '39', '1.00 x 5.56 Extruder Auger', '', '-', '4', '0', '0', '', '0', '', '', '79', '0', '0', '0', null, '', '1', '1462303319', '15', '0', '144', '5.56', 'R-1000-10-02-0003', '12');
INSERT INTO `tbl_part` VALUES ('81', 'R-1000-10-02-0004-1', '40', '1.00 X 3.505 INSERT BLANK', '', '-', '4', '0', '0', '', '0', '', '', '79', '0', '0', '0', null, '', '1', '1462303684', '15', '0', '144', '3.505', 'R-1000-10-02-0004-1', '12');
INSERT INTO `tbl_part` VALUES ('82', 'R-1000-40-02-0005', '41', '1.00 X .630 PULLER IDLER', '', '-', '4', '0', '0', '', '0', '', '', '79', '0', '0', '0', null, '', '1', '1462303843', '15', '0', '144', '0.63', 'R-1000-40-02-0005', '12');
INSERT INTO `tbl_part` VALUES ('83', 'R-1000-10-02-0010', '42', '1.00 X .50 Extruder Bearing Spacer', '', '-', '4', '0', '0', '', '0', '', '', '78', '0', '0', '0', null, '', '1', '1462304012', '15', '0', '144', '0.5', 'R-1000-10-02-0010', '12');
INSERT INTO `tbl_part` VALUES ('84', 'R-1000-40-02-0002', '43', '1.00 X 1.51 PULLER WHEEL', '', '-', '4', '0', '0', '', '0', '', '', '80', '0', '0', '0', null, '', '1', '1462304142', '15', '0', '144', '1.51', 'R-1000-40-02-0002', '12');
INSERT INTO `tbl_part` VALUES ('85', 'R-1000-10-02-0003-BL', '39', '1.00 x 5.56 Extruder Auger Blank', '', '-', '4', '0', '0', '', '0', '', '', '79', '0', '0', '0', null, '', '1', '1462367018', '15', '0', '144', '5.56', 'R-1000-10-02-0003-BLANK', '12');
INSERT INTO `tbl_part` VALUES ('86', 'R-1000-20-02-006', '45', '.250 X 1.50 PLATES', '', '-', '4', '0', '0', '<p>$16.85 GFW 500pcs</p>\n\n<p>$41.05 gfw 10pc</p>\n', '0', '', '', '75', '0', '0', '0', null, '', '1', '1462367634', '15', '0', '144', '4.83', 'R-1000-20-02-006', '12');
INSERT INTO `tbl_part` VALUES ('87', 'R-1000-20-02-003', '45', '.375 X 2.250 PLATE', '', '-', '4', '0', '0', '<p>$18.60GFW 500PCS</p>\n\n<p>$41.05 GFW 10PCS</p>\n', '0', '', '', '75', '0', '0', '0', null, '', '1', '1462368474', '15', '0', '144', '4.75', 'R-1000-20-02-003', '12');
INSERT INTO `tbl_part` VALUES ('88', 'R-1000-20-02-028', '46', '.625 X 1.3 Grinder Sprocket Housing', '', '-', '4', '0', '0', '<p>$26.52 GFW 500pcs</p>\n\n<p>$50.76 GFW 10PCS</p>\n', '0', '', '', '75', '0', '0', '0', null, '', '1', '1462368791', '15', '0', '144', '6.83', 'R-1000-20-02-028', '12');
INSERT INTO `tbl_part` VALUES ('89', 'R-1000-20-02-022', '51', '1.07 X 1.50 GRINDER INTERLOCK ARM', '', '-', '4', '0', '0', '<p>$32.60 GFW&nbsp; 500PCS</p>\n\n<p>$60.80 GFW 10PCS</p>\n', '0', '', '', '75', '0', '0', '0', null, '', '1', '1462369347', '15', '0', '144', '3.32', 'R-1000-20-02-022', '12');
INSERT INTO `tbl_part` VALUES ('90', 'GND GBX FRONTPLATE C', '45', '.375  X 4.00 FRONT PLATE', '', 'R2', '4', '0', '0', '<p>$39.86 GFW 500pcs</p>\n\n<p>$68.25 gfw 10pcs</p>\n', '0', '', '', '75', '0', '0', '0', null, '', '1', '1462370050', '15', '0', '144', '4.25', 'GND GBX FRONTPLATE CO.2 R2', '12');
INSERT INTO `tbl_part` VALUES ('91', 'R-1000-10-02-0013', '53', 'EXTRUDER NOZZLE (.6875\"DIA W/5/8-24 2A)', '', '-', '4', '0', '0', '', '0', '', '', '82', '0', '0', '0', null, '', '1', '1462625993', '1', '0', '144', '1.25', 'R-1000-10-02-0013', '12');
INSERT INTO `tbl_part` VALUES ('92', 'R-1000-10-02-0006', '54', 'TORQUE SENSOR SHAFT (.250DIA MILLED FLATS x4.245LNG)', '', '-', '4', '0', '0', '', '0', '', '', '36', '0', '0', '0', null, '', '1', '1462626278', '1', '0', '144', '4.245', 'R-1000-10-02-0006', '12');
INSERT INTO `tbl_part` VALUES ('93', 'R-1000-20-02-034', '44', 'GRINDER INTERLOCK GEAR(28T 1.25OD)', '', '-', '4', '0', '0', '', '0', '', '', '85', '0', '0', '0', null, '', '1', '1463171570', '1', '0', '135', '0.25', 'R-1000-20-02-034', '12');
INSERT INTO `tbl_part` VALUES ('94', 'R-1000-20-02-034-GRS', '44', 'GRINDER INTERLOCK GEAR(28T 1.25OD)', '', '-', '4', '0', '0', '', '0', '', '', '85', '0', '0', '0', null, '', '1', '1463171646', '1', '0', '135', '0.25', 'R-1000-20-02-034', '12');
INSERT INTO `tbl_part` VALUES ('95', 'R-1000-20-02-033', '44', 'GRINDER INTERLOCK INPUT GEAR(28T X 1.25OD)', '', '-', '4', '0', '0', '', '0', '', '', '85', '0', '0', '0', null, '', '1', '1463242518', '1', '0', '130', '0.25', 'R-1000-20-02-033', '12');
INSERT INTO `tbl_part` VALUES ('96', 'R-1000-20-02-033-GRS', '44', 'GRINDER INTERLOCK INPUT GEAR(28T X 1.25OD)', '', '-', '4', '0', '0', '', '0', '', '', '85', '0', '0', '0', null, '', '1', '1463242574', '1', '0', '130', '0.25', 'R-1000-20-02-033', '12');
INSERT INTO `tbl_part` VALUES ('97', 'R-1000-20-002', '44', 'GND_WHEEL_12DP24TSPUR(3/4 BROACH)', '', '-', '4', '0', '0', '<p>ODG PRICING COMPLETE</p>\n', '0', '', '', '84', '0', '0', '0', null, '', '1', '1463243005', '1', '0', '130', '0.75', 'R-1000-20-002', '12');
INSERT INTO `tbl_part` VALUES ('98', 'R-1000-20-002-GRS', '44', 'GND_WHEEL_12DP24TSPUR(3/4 BROACH)', '', '-', '4', '0', '0', '<p>GEAR STOCK $9.00/PP</p>\n', '0', '', '', '84', '0', '0', '0', null, '', '1', '1463243040', '1', '0', '130', '0.75', 'R-1000-20-002', '12');
INSERT INTO `tbl_part` VALUES ('99', 'R-1000-20-02-020', '44', 'GRINDER INTERLOCK OUTPUT GEAR(2.5DIA X 58T)', '', '-', '4', '0', '0', '<p>ODG COMPLETE 6-8WEEKS</p>\n', '0', '', '', '86', '0', '0', '0', null, '', '1', '1463243331', '1', '0', '130', '0.28', 'R-1000-20-02-020', '12');
INSERT INTO `tbl_part` VALUES ('100', 'R-1000-20-02-020-GRS', '44', 'GRINDER INTERLOCK OUTPUT GEAR(2.5DIA X 58T)', '', '-', '4', '0', '0', '<p>FROM GEARS STOCK $7.0/PP</p>\n', '0', '', '', '86', '0', '0', '0', null, '', '1', '1463243379', '1', '0', '130', '0.28', 'R-1000-20-02-020', '12');
INSERT INTO `tbl_part` VALUES ('101', 'R-1000-20-02-029', '44', 'GRINDER GEAR BOX OUTPUT SHAFT/DRIVE(1.25X 12T)', '', '-', '4', '0', '0', '<p>ODG COMPLETE 6-8WEEK DELIVERY</p>\n', '0', '', '', '83', '0', '0', '0', null, '', '1', '1463243654', '1', '0', '130', '1.881', 'R-1000-20-02-029', '12');
INSERT INTO `tbl_part` VALUES ('102', 'R-1000-20-02-029-GRS', '44', 'GRINDER GEAR BOX OUTPUT SHAFT/DRIVE(1.25X 12T)', '', '-', '4', '0', '0', '<p>GEAR STOCK $8.50/PP&nbsp; 14-15 WEEK DEL.</p>\n', '0', '', '', '83', '0', '0', '0', null, '', '1', '1463243776', '1', '0', '130', '1.881', 'R-1000-20-02-029', '12');
INSERT INTO `tbl_part` VALUES ('103', 'R-1000-20-02-030', '44', 'GRINDER GEARBOX OUTPUT SHAFT/DRIVE', '', '-', '4', '0', '0', '<p>ODG COMPLETE 6-8WEEK DEL</p>\n', '0', '', '', '83', '0', '0', '0', null, '', '1', '1463244022', '1', '0', '130', '1.27', 'R-1000-20-02-030', '12');
INSERT INTO `tbl_part` VALUES ('104', 'R-1000-20-02-030-GRS', '44', 'GRINDER GEARBOX OUTPUT SHAFT/DRIVE', '', '-', '4', '0', '0', '<p>GEAR STOCK $6.15/PP 13-15 WK DEL</p>\n', '0', '', '', '83', '0', '0', '0', null, '', '1', '1463244069', '1', '0', '130', '1.27', 'R-1000-20-02-030', '12');
INSERT INTO `tbl_part` VALUES ('105', 'REY4.25ELC', '55', '5x 3/4NPT x4.25DIA Elec. Box', '', '-', '4', '0', '0', '<p>Casting supplied</p>\n', '0', '', '', '87', '0', '0', '0', null, '', '1', '1469466135', '1', '0', '2', '2.438', '0000', '13');
INSERT INTO `tbl_part` VALUES ('106', '4068R1', '56', '38MM X75MM BASE CORNER W/MILLED FLATS', '', 'R1', '4', '0', '0', '', '0', '', '', '88', '0', '0', '0', null, '', '1', '1472745603', '1', '0', '144', '2.953', '4068R1', '14');

-- ----------------------------
-- Table structure for tbl_partlocation
-- ----------------------------
DROP TABLE IF EXISTS `tbl_partlocation`;
CREATE TABLE `tbl_partlocation` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `status` tinyint(1) unsigned NOT NULL,
  `shelf` varchar(255) CHARACTER SET armscii8 NOT NULL,
  `section` varchar(255) CHARACTER SET armscii8 NOT NULL,
  `box` varchar(255) CHARACTER SET armscii8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=343 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of tbl_partlocation
-- ----------------------------
INSERT INTO `tbl_partlocation` VALUES ('1', '1', 'Shelf 1', 'Section 1', 'Box 1');
INSERT INTO `tbl_partlocation` VALUES ('2', '1', 'Shelf 2', 'Section 2', 'Box 2');
INSERT INTO `tbl_partlocation` VALUES ('3', '1', 'SH1', 'SEC03', 'BX3');
INSERT INTO `tbl_partlocation` VALUES ('4', '1', 'SH03', 'SEC-03', 'BX52');
INSERT INTO `tbl_partlocation` VALUES ('5', '1', 'SH1', 'R1', '-');
INSERT INTO `tbl_partlocation` VALUES ('6', '1', 'SH1', 'R2', 'BX1');
INSERT INTO `tbl_partlocation` VALUES ('7', '1', 'SH1', 'R2', 'BX2');
INSERT INTO `tbl_partlocation` VALUES ('8', '1', 'SH1', 'R2', 'BX3');
INSERT INTO `tbl_partlocation` VALUES ('9', '1', 'SH1', 'R2', 'BX4');
INSERT INTO `tbl_partlocation` VALUES ('10', '1', 'SH1', 'R2', 'BX5');
INSERT INTO `tbl_partlocation` VALUES ('11', '1', 'SH1', 'R2', 'BX6');
INSERT INTO `tbl_partlocation` VALUES ('12', '1', 'SH1', 'R2', 'BX7');
INSERT INTO `tbl_partlocation` VALUES ('13', '1', 'SH1', 'R2', 'BX8');
INSERT INTO `tbl_partlocation` VALUES ('14', '1', 'SH1', 'R2', 'BX9');
INSERT INTO `tbl_partlocation` VALUES ('15', '1', 'SH1', 'R2', 'BX9A');
INSERT INTO `tbl_partlocation` VALUES ('16', '1', 'SH1', 'R2', 'BX10');
INSERT INTO `tbl_partlocation` VALUES ('17', '1', 'SH1', 'R2', 'BX11');
INSERT INTO `tbl_partlocation` VALUES ('18', '1', 'SH1', 'R2', 'BX12');
INSERT INTO `tbl_partlocation` VALUES ('19', '1', 'SH1', 'R2', 'BX13');
INSERT INTO `tbl_partlocation` VALUES ('20', '1', 'SH1', 'R2', 'BX13A');
INSERT INTO `tbl_partlocation` VALUES ('21', '1', 'SH1', 'R2', 'BX13B');
INSERT INTO `tbl_partlocation` VALUES ('22', '1', 'SH1', 'R2', 'BX14');
INSERT INTO `tbl_partlocation` VALUES ('23', '1', 'SH1', 'R2', 'BX15');
INSERT INTO `tbl_partlocation` VALUES ('24', '1', 'SH1', 'R2', 'BX16');
INSERT INTO `tbl_partlocation` VALUES ('25', '1', 'SH1', 'R2', 'BX17');
INSERT INTO `tbl_partlocation` VALUES ('26', '1', 'SH1', 'R2', 'BX18');
INSERT INTO `tbl_partlocation` VALUES ('27', '1', 'SH1', 'R2', 'BX19');
INSERT INTO `tbl_partlocation` VALUES ('28', '1', 'SH1', 'R2', 'BX20');
INSERT INTO `tbl_partlocation` VALUES ('29', '1', 'SH1', 'R2', 'BX21');
INSERT INTO `tbl_partlocation` VALUES ('30', '1', 'SH1', 'R2', 'BX22');
INSERT INTO `tbl_partlocation` VALUES ('31', '1', 'SH1', 'R2', 'BX23');
INSERT INTO `tbl_partlocation` VALUES ('32', '1', 'SH1', 'R2', 'BX23');
INSERT INTO `tbl_partlocation` VALUES ('33', '1', 'SH1', 'R2', 'BX24');
INSERT INTO `tbl_partlocation` VALUES ('34', '1', 'SH1', 'R2', 'BX25');
INSERT INTO `tbl_partlocation` VALUES ('35', '1', 'SH1', 'R2', 'BX26');
INSERT INTO `tbl_partlocation` VALUES ('36', '1', 'SH1', 'R2', 'BX27');
INSERT INTO `tbl_partlocation` VALUES ('37', '1', 'SH1', 'R2', 'BX28');
INSERT INTO `tbl_partlocation` VALUES ('38', '1', 'SH1', 'R2', 'BX29');
INSERT INTO `tbl_partlocation` VALUES ('39', '1', 'SH1', 'R2', 'BX30');
INSERT INTO `tbl_partlocation` VALUES ('40', '1', 'SH1', 'R2', 'BX31');
INSERT INTO `tbl_partlocation` VALUES ('41', '1', 'SH1', 'R2', 'BX32');
INSERT INTO `tbl_partlocation` VALUES ('42', '1', 'SH1', 'R2', 'BX33');
INSERT INTO `tbl_partlocation` VALUES ('43', '1', 'SH1', 'R2', 'BX34');
INSERT INTO `tbl_partlocation` VALUES ('44', '1', 'SH1', 'R2', 'BX35');
INSERT INTO `tbl_partlocation` VALUES ('45', '1', 'SH1', 'R3', 'BX36');
INSERT INTO `tbl_partlocation` VALUES ('46', '1', 'SH1', 'R3', 'BX37');
INSERT INTO `tbl_partlocation` VALUES ('47', '1', 'SH1', 'R3', 'BX38');
INSERT INTO `tbl_partlocation` VALUES ('48', '1', 'SH1', 'R3', 'BX39');
INSERT INTO `tbl_partlocation` VALUES ('49', '1', 'SH1', 'R3', 'BX40');
INSERT INTO `tbl_partlocation` VALUES ('50', '1', 'SH1', 'R3', 'BX41');
INSERT INTO `tbl_partlocation` VALUES ('51', '1', 'SH1', 'R3', 'BX42');
INSERT INTO `tbl_partlocation` VALUES ('52', '1', 'SH1', 'R3', 'BX43');
INSERT INTO `tbl_partlocation` VALUES ('53', '1', 'SH1', 'R3', 'BX44');
INSERT INTO `tbl_partlocation` VALUES ('54', '1', 'SH1', 'R3', 'BX46');
INSERT INTO `tbl_partlocation` VALUES ('55', '1', 'SH1', 'R3', 'BX45');
INSERT INTO `tbl_partlocation` VALUES ('56', '1', 'SH1', 'R3', 'BX47');
INSERT INTO `tbl_partlocation` VALUES ('57', '1', 'SH1', 'R3', 'BX48');
INSERT INTO `tbl_partlocation` VALUES ('58', '1', 'SH1', 'R3', 'BX49');
INSERT INTO `tbl_partlocation` VALUES ('59', '1', 'SH1', 'R3', 'BX50');
INSERT INTO `tbl_partlocation` VALUES ('60', '1', 'SH1', 'R3', 'BX51');
INSERT INTO `tbl_partlocation` VALUES ('61', '1', 'SH1', 'R3', 'BX52');
INSERT INTO `tbl_partlocation` VALUES ('62', '1', 'SH1', 'R3', 'BX53');
INSERT INTO `tbl_partlocation` VALUES ('63', '1', 'SH1', 'R3', 'BX54');
INSERT INTO `tbl_partlocation` VALUES ('64', '1', 'SH1', 'R3', 'BX55');
INSERT INTO `tbl_partlocation` VALUES ('65', '1', 'SH1', 'R3', 'BX56');
INSERT INTO `tbl_partlocation` VALUES ('66', '1', 'SH1', 'R3', 'BX57');
INSERT INTO `tbl_partlocation` VALUES ('67', '1', 'SH1', 'R3', 'BX58');
INSERT INTO `tbl_partlocation` VALUES ('68', '1', 'SH1', 'R3', 'BX58A');
INSERT INTO `tbl_partlocation` VALUES ('69', '1', 'SH1', 'R3', 'BX59');
INSERT INTO `tbl_partlocation` VALUES ('70', '1', 'SH1', 'R3', 'BX60');
INSERT INTO `tbl_partlocation` VALUES ('71', '1', 'SH1', 'R3', 'BX61');
INSERT INTO `tbl_partlocation` VALUES ('72', '1', 'SH1', 'R3', 'BX62');
INSERT INTO `tbl_partlocation` VALUES ('73', '1', 'SH1', 'R3', 'BX62');
INSERT INTO `tbl_partlocation` VALUES ('74', '1', 'SH1', 'R3', 'BX63');
INSERT INTO `tbl_partlocation` VALUES ('75', '1', 'SH1', 'R3', 'BX64');
INSERT INTO `tbl_partlocation` VALUES ('76', '1', 'SH1', 'R3', 'BX65');
INSERT INTO `tbl_partlocation` VALUES ('77', '1', 'SH1', 'R3', 'BX66');
INSERT INTO `tbl_partlocation` VALUES ('78', '1', 'SH1', 'R3', 'BX67');
INSERT INTO `tbl_partlocation` VALUES ('79', '1', 'SH1', 'R3', 'BX68');
INSERT INTO `tbl_partlocation` VALUES ('80', '1', 'SH1', 'R3', 'BX69');
INSERT INTO `tbl_partlocation` VALUES ('81', '1', 'SH1', 'R3', 'BX70');
INSERT INTO `tbl_partlocation` VALUES ('82', '1', 'SH1', 'R3', 'BX71');
INSERT INTO `tbl_partlocation` VALUES ('83', '1', 'SH1', 'R4', 'BX72');
INSERT INTO `tbl_partlocation` VALUES ('84', '1', 'SH1', 'R4', 'BX73');
INSERT INTO `tbl_partlocation` VALUES ('85', '1', 'SH1', 'R4', 'BX74');
INSERT INTO `tbl_partlocation` VALUES ('86', '1', 'SH1', 'R4', 'BX75');
INSERT INTO `tbl_partlocation` VALUES ('87', '1', 'SH1', 'R4', 'BX76');
INSERT INTO `tbl_partlocation` VALUES ('88', '1', 'SH1', 'R4', 'BX77');
INSERT INTO `tbl_partlocation` VALUES ('89', '1', 'SH1', 'R4', 'BX78');
INSERT INTO `tbl_partlocation` VALUES ('90', '1', 'SH1', 'R4', 'BX79');
INSERT INTO `tbl_partlocation` VALUES ('91', '1', 'SH1', 'R4', 'BX80');
INSERT INTO `tbl_partlocation` VALUES ('92', '1', 'SH1', 'R4', 'BX81');
INSERT INTO `tbl_partlocation` VALUES ('93', '1', 'SH1', 'R4', 'BX82');
INSERT INTO `tbl_partlocation` VALUES ('94', '1', 'SH1', 'R4', 'BX83');
INSERT INTO `tbl_partlocation` VALUES ('95', '1', 'SH1', 'R4', 'BX84');
INSERT INTO `tbl_partlocation` VALUES ('96', '1', 'SH1', 'R4', 'BX85');
INSERT INTO `tbl_partlocation` VALUES ('97', '1', 'SH1', 'R4', 'BX86');
INSERT INTO `tbl_partlocation` VALUES ('98', '1', 'SH1', 'R4', 'BX87');
INSERT INTO `tbl_partlocation` VALUES ('99', '1', 'SH1', 'R4', 'BX88');
INSERT INTO `tbl_partlocation` VALUES ('100', '1', 'SH1', 'R4', 'BX88A');
INSERT INTO `tbl_partlocation` VALUES ('101', '1', 'SH1', 'R4', 'BX88B');
INSERT INTO `tbl_partlocation` VALUES ('102', '1', 'SH1', 'R4', 'BX88C');
INSERT INTO `tbl_partlocation` VALUES ('103', '1', 'SH1', 'R4', 'BX89');
INSERT INTO `tbl_partlocation` VALUES ('104', '1', 'SH1', 'R4', 'BX89A');
INSERT INTO `tbl_partlocation` VALUES ('105', '1', 'SH1', 'R4', 'BX89B');
INSERT INTO `tbl_partlocation` VALUES ('106', '1', 'SH1', 'R4', 'BX90');
INSERT INTO `tbl_partlocation` VALUES ('107', '1', 'SH1', 'R4', 'BX91');
INSERT INTO `tbl_partlocation` VALUES ('108', '1', 'SH1', 'R4', 'BX91A');
INSERT INTO `tbl_partlocation` VALUES ('109', '1', 'SH1', 'R4', 'BX92');
INSERT INTO `tbl_partlocation` VALUES ('110', '1', 'SH1', 'R4', 'BX93');
INSERT INTO `tbl_partlocation` VALUES ('111', '1', 'SH1', 'R4', 'BX94');
INSERT INTO `tbl_partlocation` VALUES ('112', '1', 'SH1', 'R4', 'BX95');
INSERT INTO `tbl_partlocation` VALUES ('113', '1', 'SH1', 'R4', 'BX96');
INSERT INTO `tbl_partlocation` VALUES ('114', '1', 'SH1', 'R4', 'BX97');
INSERT INTO `tbl_partlocation` VALUES ('115', '1', 'SH1', 'R4', 'BX97');
INSERT INTO `tbl_partlocation` VALUES ('116', '1', 'SH1', 'R4', 'BX98');
INSERT INTO `tbl_partlocation` VALUES ('117', '1', 'SH1', 'R4', 'BX98A');
INSERT INTO `tbl_partlocation` VALUES ('118', '1', 'SH1', 'R4', 'BX99');
INSERT INTO `tbl_partlocation` VALUES ('119', '1', 'SH1', 'R5', 'BX100');
INSERT INTO `tbl_partlocation` VALUES ('120', '1', 'SH1', 'R5', 'BX101');
INSERT INTO `tbl_partlocation` VALUES ('121', '1', 'SH1', 'R5', 'BX101');
INSERT INTO `tbl_partlocation` VALUES ('122', '1', 'SH1', 'R5', 'BX102');
INSERT INTO `tbl_partlocation` VALUES ('123', '1', 'SH1', 'R5', 'BX103');
INSERT INTO `tbl_partlocation` VALUES ('124', '1', 'SH1', 'R5', 'BX103');
INSERT INTO `tbl_partlocation` VALUES ('125', '1', 'SH1', 'R5', 'BX103A');
INSERT INTO `tbl_partlocation` VALUES ('126', '1', 'SH1', 'R5', 'BX104');
INSERT INTO `tbl_partlocation` VALUES ('127', '1', 'SH1', 'R5', 'BX105');
INSERT INTO `tbl_partlocation` VALUES ('128', '1', 'SH1', 'R5', 'BX105A');
INSERT INTO `tbl_partlocation` VALUES ('129', '1', 'SH1', 'R5', 'BX105A');
INSERT INTO `tbl_partlocation` VALUES ('130', '1', 'SH1', 'R5', 'BX106');
INSERT INTO `tbl_partlocation` VALUES ('131', '1', 'SH1', 'R5', 'BX107');
INSERT INTO `tbl_partlocation` VALUES ('132', '1', 'SH1', 'R5', 'BX108');
INSERT INTO `tbl_partlocation` VALUES ('133', '1', 'SH1', 'R5', 'BX108A');
INSERT INTO `tbl_partlocation` VALUES ('134', '1', 'SH1', 'R5', 'BX108B');
INSERT INTO `tbl_partlocation` VALUES ('135', '1', 'SH1', 'R5', 'BX109');
INSERT INTO `tbl_partlocation` VALUES ('136', '1', 'SH1', 'R5', 'BX110');
INSERT INTO `tbl_partlocation` VALUES ('137', '1', 'SH1', 'R5', 'BX110A');
INSERT INTO `tbl_partlocation` VALUES ('138', '1', 'SH1', 'R5', 'BX111');
INSERT INTO `tbl_partlocation` VALUES ('139', '1', 'SH1', 'R5', 'BX112');
INSERT INTO `tbl_partlocation` VALUES ('140', '1', 'SH1', 'R5', 'BX112A');
INSERT INTO `tbl_partlocation` VALUES ('141', '1', 'SH1', 'R5', 'BX113');
INSERT INTO `tbl_partlocation` VALUES ('142', '1', 'SH1', 'R6', 'BX114');
INSERT INTO `tbl_partlocation` VALUES ('143', '1', 'SH1', 'R6', 'BX115');
INSERT INTO `tbl_partlocation` VALUES ('144', '1', 'SH1', 'R6', 'BX115A');
INSERT INTO `tbl_partlocation` VALUES ('145', '1', 'SH1', 'R6', 'BX115B');
INSERT INTO `tbl_partlocation` VALUES ('146', '1', 'SH1', 'R6', 'BX115B');
INSERT INTO `tbl_partlocation` VALUES ('147', '1', 'SH1', 'R6', 'BX116');
INSERT INTO `tbl_partlocation` VALUES ('148', '1', 'SH1', 'R6', 'BX116A');
INSERT INTO `tbl_partlocation` VALUES ('149', '1', 'SH1', 'R6', 'BX117');
INSERT INTO `tbl_partlocation` VALUES ('150', '1', 'SH1', 'R7', '-');
INSERT INTO `tbl_partlocation` VALUES ('151', '1', 'SH2', 'R1', '-');
INSERT INTO `tbl_partlocation` VALUES ('152', '1', 'SH2', 'R2', 'BX1');
INSERT INTO `tbl_partlocation` VALUES ('153', '1', 'SH2', 'R2', 'BX2');
INSERT INTO `tbl_partlocation` VALUES ('154', '1', 'SH2', 'R2', 'BX3');
INSERT INTO `tbl_partlocation` VALUES ('155', '1', 'SH2', 'R2', 'BX3A');
INSERT INTO `tbl_partlocation` VALUES ('156', '1', 'SH2', 'R2', 'BX4');
INSERT INTO `tbl_partlocation` VALUES ('157', '1', 'SH2', 'R2', 'BX4A');
INSERT INTO `tbl_partlocation` VALUES ('158', '1', 'SH2', 'R2', 'BX4B');
INSERT INTO `tbl_partlocation` VALUES ('159', '1', 'SH2', 'R2', 'BX5');
INSERT INTO `tbl_partlocation` VALUES ('160', '1', 'SH2', 'R2', 'BX6');
INSERT INTO `tbl_partlocation` VALUES ('161', '1', 'SH2', 'R2', 'BX7');
INSERT INTO `tbl_partlocation` VALUES ('162', '1', 'SH2', 'R2', 'BX7A');
INSERT INTO `tbl_partlocation` VALUES ('163', '1', 'SH2', 'R3', 'BX8');
INSERT INTO `tbl_partlocation` VALUES ('164', '1', 'SH2', 'R3', 'BX8A');
INSERT INTO `tbl_partlocation` VALUES ('165', '1', 'SH2', 'R3', 'BX9');
INSERT INTO `tbl_partlocation` VALUES ('166', '1', 'SH2', 'R3', 'BX9A');
INSERT INTO `tbl_partlocation` VALUES ('167', '1', 'SH2', 'R3', 'BX9B');
INSERT INTO `tbl_partlocation` VALUES ('168', '1', 'SH2', 'R3', 'BX10');
INSERT INTO `tbl_partlocation` VALUES ('169', '1', 'SH2', 'R3', 'BX11');
INSERT INTO `tbl_partlocation` VALUES ('170', '1', 'SH2', 'R3', 'BX12');
INSERT INTO `tbl_partlocation` VALUES ('171', '1', 'SH2', 'R3', 'BX13');
INSERT INTO `tbl_partlocation` VALUES ('172', '1', 'SH2', 'R3', 'BX13A');
INSERT INTO `tbl_partlocation` VALUES ('173', '1', 'SH2', 'R3', 'BX14');
INSERT INTO `tbl_partlocation` VALUES ('174', '1', 'SH2', 'R3', 'BX14A');
INSERT INTO `tbl_partlocation` VALUES ('175', '1', 'SH2', 'R3', 'BX15');
INSERT INTO `tbl_partlocation` VALUES ('176', '1', 'SH2', 'R4', '-');
INSERT INTO `tbl_partlocation` VALUES ('177', '1', 'SH3', 'R1', '-');
INSERT INTO `tbl_partlocation` VALUES ('178', '1', 'SH3', 'R2', 'BX1');
INSERT INTO `tbl_partlocation` VALUES ('179', '1', 'SH3', 'R2', 'BX1A');
INSERT INTO `tbl_partlocation` VALUES ('180', '1', 'SH3', 'R2', 'BX2');
INSERT INTO `tbl_partlocation` VALUES ('181', '1', 'SH3', 'R2', 'BX3');
INSERT INTO `tbl_partlocation` VALUES ('182', '1', 'SH3', 'R2', 'BX4');
INSERT INTO `tbl_partlocation` VALUES ('183', '1', 'SH3', 'R2', 'BX5');
INSERT INTO `tbl_partlocation` VALUES ('184', '1', 'SH3', 'R2', 'BX6');
INSERT INTO `tbl_partlocation` VALUES ('185', '1', 'SH3', 'R2', 'BX7');
INSERT INTO `tbl_partlocation` VALUES ('186', '1', 'SH3', 'R2', 'BX8');
INSERT INTO `tbl_partlocation` VALUES ('187', '1', 'SH3', 'R2', 'BX9');
INSERT INTO `tbl_partlocation` VALUES ('188', '1', 'SH3', 'R2', 'BX10');
INSERT INTO `tbl_partlocation` VALUES ('189', '1', 'SH3', 'R2', 'BX11');
INSERT INTO `tbl_partlocation` VALUES ('190', '1', 'SH3', 'R2', 'BX12');
INSERT INTO `tbl_partlocation` VALUES ('191', '1', 'SH3', 'R2', 'BX13');
INSERT INTO `tbl_partlocation` VALUES ('192', '1', 'SH3', 'R2', 'BX13A');
INSERT INTO `tbl_partlocation` VALUES ('193', '1', 'SH3', 'R2', 'BX13A');
INSERT INTO `tbl_partlocation` VALUES ('194', '1', 'SH3', 'R2', 'BX14');
INSERT INTO `tbl_partlocation` VALUES ('195', '1', 'SH3', 'R2', 'BX14A');
INSERT INTO `tbl_partlocation` VALUES ('196', '1', 'SH3', 'R2', 'BX15');
INSERT INTO `tbl_partlocation` VALUES ('197', '1', 'SH3', 'R3', 'BX16');
INSERT INTO `tbl_partlocation` VALUES ('198', '1', 'SH3', 'R3', 'BX17');
INSERT INTO `tbl_partlocation` VALUES ('199', '1', 'SH3', 'R3', 'BX17');
INSERT INTO `tbl_partlocation` VALUES ('200', '1', 'SH3', 'R3', 'BX18');
INSERT INTO `tbl_partlocation` VALUES ('201', '1', 'SH3', 'R3', 'BX19');
INSERT INTO `tbl_partlocation` VALUES ('202', '1', 'SH3', 'R3', 'BX20');
INSERT INTO `tbl_partlocation` VALUES ('203', '1', 'SH3', 'R3', 'BX21');
INSERT INTO `tbl_partlocation` VALUES ('204', '1', 'SH3', 'R3', 'BX22');
INSERT INTO `tbl_partlocation` VALUES ('205', '1', 'SH3', 'R3', 'BX22A');
INSERT INTO `tbl_partlocation` VALUES ('206', '1', 'SH3', 'R3', 'BX22B');
INSERT INTO `tbl_partlocation` VALUES ('207', '1', 'SH3', 'R3', 'BX23');
INSERT INTO `tbl_partlocation` VALUES ('208', '1', 'SH3', 'R3', 'BX25');
INSERT INTO `tbl_partlocation` VALUES ('209', '1', 'SH3', 'R3', 'BX25');
INSERT INTO `tbl_partlocation` VALUES ('210', '1', 'SH3', 'R3', 'BX25A');
INSERT INTO `tbl_partlocation` VALUES ('211', '1', 'SH3', 'R3', 'BX26');
INSERT INTO `tbl_partlocation` VALUES ('212', '1', 'SH3', 'R3', 'BX27');
INSERT INTO `tbl_partlocation` VALUES ('213', '1', 'SH3', 'R3', 'BX28');
INSERT INTO `tbl_partlocation` VALUES ('214', '1', 'SH3', 'R3', 'BX29');
INSERT INTO `tbl_partlocation` VALUES ('215', '1', 'SH3', 'R3', 'BX30');
INSERT INTO `tbl_partlocation` VALUES ('216', '1', 'SH3', 'R4', '-');
INSERT INTO `tbl_partlocation` VALUES ('217', '1', 'SH4', 'R1', '-');
INSERT INTO `tbl_partlocation` VALUES ('218', '1', 'SH4', 'R2', 'BX1');
INSERT INTO `tbl_partlocation` VALUES ('219', '1', 'SH4', 'R2', 'BX1A');
INSERT INTO `tbl_partlocation` VALUES ('220', '1', 'SH4', 'R2', 'BX2');
INSERT INTO `tbl_partlocation` VALUES ('221', '1', 'SH4', 'R2', 'BX3');
INSERT INTO `tbl_partlocation` VALUES ('222', '1', 'SH4', 'R2', 'BX3A');
INSERT INTO `tbl_partlocation` VALUES ('223', '1', 'SH4', 'R2', 'BX4');
INSERT INTO `tbl_partlocation` VALUES ('224', '1', 'SH4', 'R2', 'BX5');
INSERT INTO `tbl_partlocation` VALUES ('225', '1', 'SH4', 'R2', 'BX6');
INSERT INTO `tbl_partlocation` VALUES ('226', '1', 'SH4', 'R2', 'BX7');
INSERT INTO `tbl_partlocation` VALUES ('227', '1', 'SH4', 'R2', 'BX8');
INSERT INTO `tbl_partlocation` VALUES ('228', '1', 'SH4', 'R2', 'BX8A');
INSERT INTO `tbl_partlocation` VALUES ('229', '1', 'SH4', 'R2', 'BX9');
INSERT INTO `tbl_partlocation` VALUES ('230', '1', 'SH4', 'R2', 'BX10');
INSERT INTO `tbl_partlocation` VALUES ('231', '1', 'SH4', 'R2', 'BX11');
INSERT INTO `tbl_partlocation` VALUES ('232', '1', 'SH4', 'R2', 'BX12');
INSERT INTO `tbl_partlocation` VALUES ('233', '1', 'SH4', 'R2', 'BX13');
INSERT INTO `tbl_partlocation` VALUES ('234', '1', 'SH4', 'R2', 'BX14');
INSERT INTO `tbl_partlocation` VALUES ('235', '1', 'SH4', 'R2', 'BX15');
INSERT INTO `tbl_partlocation` VALUES ('236', '1', 'SH4', 'R2', 'BX16');
INSERT INTO `tbl_partlocation` VALUES ('237', '1', 'SH4', 'R2', 'BX17');
INSERT INTO `tbl_partlocation` VALUES ('238', '1', 'SH4', 'R2', 'BX17A');
INSERT INTO `tbl_partlocation` VALUES ('239', '1', 'SH4', 'R2', 'BX18');
INSERT INTO `tbl_partlocation` VALUES ('240', '1', 'SH4', 'R2', 'BX19');
INSERT INTO `tbl_partlocation` VALUES ('241', '1', 'SH4', 'R2', 'BX20');
INSERT INTO `tbl_partlocation` VALUES ('242', '1', 'SH4', 'R2', 'BX21');
INSERT INTO `tbl_partlocation` VALUES ('243', '1', 'SH4', 'R2', 'BX22');
INSERT INTO `tbl_partlocation` VALUES ('244', '1', 'SH4', 'R2', 'BX22A');
INSERT INTO `tbl_partlocation` VALUES ('245', '1', 'SH4', 'R3', 'BX23');
INSERT INTO `tbl_partlocation` VALUES ('246', '1', 'SH4', 'R3', 'BX23A');
INSERT INTO `tbl_partlocation` VALUES ('247', '1', 'SH4', 'R3', 'BX24');
INSERT INTO `tbl_partlocation` VALUES ('248', '1', 'SH4', 'R3', 'BX25');
INSERT INTO `tbl_partlocation` VALUES ('249', '1', 'SH4', 'R3', 'BX26');
INSERT INTO `tbl_partlocation` VALUES ('250', '1', 'SH4', 'R3', 'BX27');
INSERT INTO `tbl_partlocation` VALUES ('251', '1', 'SH4', 'R3', 'BX28');
INSERT INTO `tbl_partlocation` VALUES ('252', '1', 'SH4', 'R3', 'BX29');
INSERT INTO `tbl_partlocation` VALUES ('253', '1', 'SH4', 'R3', 'BX29A');
INSERT INTO `tbl_partlocation` VALUES ('254', '1', 'SH4', 'R3', 'BX30');
INSERT INTO `tbl_partlocation` VALUES ('255', '1', 'SH4', 'R3', 'BX31');
INSERT INTO `tbl_partlocation` VALUES ('256', '1', 'SH4', 'R3', 'BX32');
INSERT INTO `tbl_partlocation` VALUES ('257', '1', 'SH4', 'R3', 'BX32A');
INSERT INTO `tbl_partlocation` VALUES ('258', '1', 'SH4', 'R3', 'BX33');
INSERT INTO `tbl_partlocation` VALUES ('259', '1', 'SH4', 'R3', 'BX33A');
INSERT INTO `tbl_partlocation` VALUES ('260', '1', 'SH4', 'R3', 'BX34');
INSERT INTO `tbl_partlocation` VALUES ('261', '1', 'SH4', 'R3', 'BX35');
INSERT INTO `tbl_partlocation` VALUES ('262', '1', 'SH4', 'R3', 'BX36');
INSERT INTO `tbl_partlocation` VALUES ('263', '1', 'SH4', 'R3', 'BX37');
INSERT INTO `tbl_partlocation` VALUES ('264', '1', 'SH4', 'R3', 'BX38');
INSERT INTO `tbl_partlocation` VALUES ('265', '1', 'SH4', 'R3', 'BX39');
INSERT INTO `tbl_partlocation` VALUES ('266', '1', 'SH4', 'R4', '-');
INSERT INTO `tbl_partlocation` VALUES ('267', '1', 'SH5', 'R1', 'BX1');
INSERT INTO `tbl_partlocation` VALUES ('268', '1', 'SH5', 'R1', 'BX1');
INSERT INTO `tbl_partlocation` VALUES ('269', '1', 'SH5', 'R1', 'BX2');
INSERT INTO `tbl_partlocation` VALUES ('270', '1', 'SH5', 'R1', 'BX3');
INSERT INTO `tbl_partlocation` VALUES ('271', '1', 'SH5', 'R1', 'BX3');
INSERT INTO `tbl_partlocation` VALUES ('272', '1', 'SH5', 'R1', 'BX4');
INSERT INTO `tbl_partlocation` VALUES ('273', '1', 'SH5', 'R1', 'BX5');
INSERT INTO `tbl_partlocation` VALUES ('274', '1', 'SH5', 'R1', 'BX6');
INSERT INTO `tbl_partlocation` VALUES ('275', '1', 'SH5', 'R1', 'BX6A');
INSERT INTO `tbl_partlocation` VALUES ('276', '1', 'SH5', 'R1', 'BX7');
INSERT INTO `tbl_partlocation` VALUES ('277', '1', 'SH5', 'R1', 'BX8');
INSERT INTO `tbl_partlocation` VALUES ('278', '1', 'SH5', 'R1', 'BX9');
INSERT INTO `tbl_partlocation` VALUES ('279', '1', 'SH5', 'R1', 'BX10');
INSERT INTO `tbl_partlocation` VALUES ('280', '1', 'SH5', 'R1', 'BX11');
INSERT INTO `tbl_partlocation` VALUES ('281', '1', 'SH5', 'R1', 'BX12');
INSERT INTO `tbl_partlocation` VALUES ('282', '1', 'SH5', 'R1', 'BX13');
INSERT INTO `tbl_partlocation` VALUES ('283', '1', 'SH5', 'R1', 'BX13');
INSERT INTO `tbl_partlocation` VALUES ('284', '1', 'SH5', 'R1', 'BX14');
INSERT INTO `tbl_partlocation` VALUES ('285', '1', 'SH5', 'R1', 'BX14');
INSERT INTO `tbl_partlocation` VALUES ('286', '1', 'SH5', 'R1', 'BX15');
INSERT INTO `tbl_partlocation` VALUES ('287', '1', 'SH5', 'R1', 'BX15A');
INSERT INTO `tbl_partlocation` VALUES ('288', '1', 'SH5', 'R1', 'BX16');
INSERT INTO `tbl_partlocation` VALUES ('289', '1', 'SH5', 'R1', 'BX17');
INSERT INTO `tbl_partlocation` VALUES ('290', '1', 'SH5', 'R1', 'BX18');
INSERT INTO `tbl_partlocation` VALUES ('291', '1', 'SH5', 'R1', 'BX19');
INSERT INTO `tbl_partlocation` VALUES ('292', '1', 'SH5', 'R1', 'BX20');
INSERT INTO `tbl_partlocation` VALUES ('293', '1', 'SH5', 'R1', 'BX21');
INSERT INTO `tbl_partlocation` VALUES ('294', '1', 'SH5', 'R1', 'BX22');
INSERT INTO `tbl_partlocation` VALUES ('295', '1', 'SH5', 'R1', 'BX23');
INSERT INTO `tbl_partlocation` VALUES ('296', '1', 'SH5', 'R1', 'BX23A');
INSERT INTO `tbl_partlocation` VALUES ('297', '1', 'SH5', 'R1', 'BX24');
INSERT INTO `tbl_partlocation` VALUES ('298', '1', 'SH5', 'R1', 'BX25');
INSERT INTO `tbl_partlocation` VALUES ('299', '1', 'SH5', 'R1', 'BX26');
INSERT INTO `tbl_partlocation` VALUES ('300', '1', 'SH5', 'R2', 'BX27');
INSERT INTO `tbl_partlocation` VALUES ('301', '1', 'SH5', 'R2', 'BX28');
INSERT INTO `tbl_partlocation` VALUES ('302', '1', 'SH5', 'R2', 'BX28');
INSERT INTO `tbl_partlocation` VALUES ('303', '1', 'SH5', 'R2', 'BX28A');
INSERT INTO `tbl_partlocation` VALUES ('304', '1', 'SH5', 'R2', 'BX29');
INSERT INTO `tbl_partlocation` VALUES ('305', '1', 'SH5', 'R2', 'BX30');
INSERT INTO `tbl_partlocation` VALUES ('306', '1', 'SH5', 'R2', 'BX31');
INSERT INTO `tbl_partlocation` VALUES ('307', '1', 'SH5', 'R2', 'BX31A');
INSERT INTO `tbl_partlocation` VALUES ('308', '1', 'SH5', 'R3', 'BX32');
INSERT INTO `tbl_partlocation` VALUES ('309', '1', 'SH5', 'R3', 'BX33');
INSERT INTO `tbl_partlocation` VALUES ('310', '1', 'SH5', 'R3', 'BX34');
INSERT INTO `tbl_partlocation` VALUES ('311', '1', 'SH5', 'R3', 'BX35');
INSERT INTO `tbl_partlocation` VALUES ('312', '1', 'SH5', 'R3', 'BX36');
INSERT INTO `tbl_partlocation` VALUES ('313', '1', 'SH5', 'R3', 'BX37');
INSERT INTO `tbl_partlocation` VALUES ('314', '1', 'SH5', 'R3', 'BX37A');
INSERT INTO `tbl_partlocation` VALUES ('315', '1', 'SH5', 'R3', 'BX38');
INSERT INTO `tbl_partlocation` VALUES ('316', '1', 'SH5', 'R3', 'BX38A');
INSERT INTO `tbl_partlocation` VALUES ('317', '1', 'SH5', 'R3', 'BX38B');
INSERT INTO `tbl_partlocation` VALUES ('318', '1', 'SH5', 'R3', 'BX39');
INSERT INTO `tbl_partlocation` VALUES ('319', '1', 'SH5', 'R3', 'BX39A');
INSERT INTO `tbl_partlocation` VALUES ('320', '1', 'SH5', 'R4', '-');
INSERT INTO `tbl_partlocation` VALUES ('321', '1', 'SH6', 'R1', '-');
INSERT INTO `tbl_partlocation` VALUES ('322', '1', 'SH6', 'R2', '-');
INSERT INTO `tbl_partlocation` VALUES ('323', '1', 'SH6', 'R3', '-');
INSERT INTO `tbl_partlocation` VALUES ('324', '1', 'SH6', 'R4', '-');
INSERT INTO `tbl_partlocation` VALUES ('325', '1', 'SH6', 'R5', '-');
INSERT INTO `tbl_partlocation` VALUES ('326', '1', 'SH1', 'R2', '-');
INSERT INTO `tbl_partlocation` VALUES ('327', '1', 'SH1', 'R3', '-');
INSERT INTO `tbl_partlocation` VALUES ('328', '1', 'SH1', 'R4', '-');
INSERT INTO `tbl_partlocation` VALUES ('329', '1', 'SH1', 'R5', '-');
INSERT INTO `tbl_partlocation` VALUES ('330', '1', 'SH1', 'R6', '-');
INSERT INTO `tbl_partlocation` VALUES ('331', '1', 'SH2', 'R2', '-');
INSERT INTO `tbl_partlocation` VALUES ('332', '1', 'SH2', 'R3', '-');
INSERT INTO `tbl_partlocation` VALUES ('333', '1', 'SH3', 'R2', '-');
INSERT INTO `tbl_partlocation` VALUES ('334', '1', 'SH3', 'R3', '-');
INSERT INTO `tbl_partlocation` VALUES ('335', '1', 'SH4', 'R2', '-');
INSERT INTO `tbl_partlocation` VALUES ('336', '1', 'SH4', 'R3', '-');
INSERT INTO `tbl_partlocation` VALUES ('337', '1', 'SH5', 'R1', '-');
INSERT INTO `tbl_partlocation` VALUES ('338', '1', 'SH5', 'R2', '-');
INSERT INTO `tbl_partlocation` VALUES ('339', '1', 'SH5', 'R3', '-');
INSERT INTO `tbl_partlocation` VALUES ('340', '1', 'SHOP FLOOR', '-', '-');
INSERT INTO `tbl_partlocation` VALUES ('341', '1', 'SHIPPING FLOOR', '-', '-');
INSERT INTO `tbl_partlocation` VALUES ('342', '1', 'QC', '-', '-');

-- ----------------------------
-- Table structure for tbl_partlocation_part
-- ----------------------------
DROP TABLE IF EXISTS `tbl_partlocation_part`;
CREATE TABLE `tbl_partlocation_part` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `part_id` int(10) unsigned NOT NULL,
  `location_id` int(11) NOT NULL,
  `created_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of tbl_partlocation_part
-- ----------------------------
INSERT INTO `tbl_partlocation_part` VALUES ('1', '9', '2', '0');
INSERT INTO `tbl_partlocation_part` VALUES ('2', '8', '2', '0');
INSERT INTO `tbl_partlocation_part` VALUES ('3', '21', '1', '1439649791');
INSERT INTO `tbl_partlocation_part` VALUES ('4', '22', '2', '1441851602');
INSERT INTO `tbl_partlocation_part` VALUES ('5', '23', '1', '1441855125');
INSERT INTO `tbl_partlocation_part` VALUES ('6', '35', '2', '1445083528');
INSERT INTO `tbl_partlocation_part` VALUES ('7', '35', '3', '1445083528');
INSERT INTO `tbl_partlocation_part` VALUES ('8', '36', '1', '1445684539');
INSERT INTO `tbl_partlocation_part` VALUES ('9', '36', '2', '1445684539');
INSERT INTO `tbl_partlocation_part` VALUES ('10', '19', '1', '1445948714');
INSERT INTO `tbl_partlocation_part` VALUES ('11', '6', '2', '1445949285');
INSERT INTO `tbl_partlocation_part` VALUES ('12', '54', '1', '1449589084');
INSERT INTO `tbl_partlocation_part` VALUES ('13', '55', '1', '1449589628');
INSERT INTO `tbl_partlocation_part` VALUES ('14', '52', '341', '1449943509');
INSERT INTO `tbl_partlocation_part` VALUES ('15', '65', '327', '1455474128');
INSERT INTO `tbl_partlocation_part` VALUES ('16', '68', '341', '1457793913');
INSERT INTO `tbl_partlocation_part` VALUES ('17', '68', '340', '1457793913');
INSERT INTO `tbl_partlocation_part` VALUES ('18', '69', '341', '1457794153');
INSERT INTO `tbl_partlocation_part` VALUES ('19', '69', '340', '1457794153');

-- ----------------------------
-- Table structure for tbl_part_category
-- ----------------------------
DROP TABLE IF EXISTS `tbl_part_category`;
CREATE TABLE `tbl_part_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `created_time` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=armscii8;

-- ----------------------------
-- Records of tbl_part_category
-- ----------------------------
INSERT INTO `tbl_part_category` VALUES ('1', 'Jamnuts', '1', '1');
INSERT INTO `tbl_part_category` VALUES ('2', 'Spin Buttons', '1', '1425794177');
INSERT INTO `tbl_part_category` VALUES ('3', 'category test 1', '1', '1425837433');
INSERT INTO `tbl_part_category` VALUES ('4', 'Stud Lock Screw', '1', '0');
INSERT INTO `tbl_part_category` VALUES ('5', 'Spring Button 21', '1', '0');
INSERT INTO `tbl_part_category` VALUES ('8', 'Stud Lock Screw', '1', '0');
INSERT INTO `tbl_part_category` VALUES ('9', 'newcategory', '1', '0');
INSERT INTO `tbl_part_category` VALUES ('10', 'new category10', '1', '0');
INSERT INTO `tbl_part_category` VALUES ('12', 'HUNG_CAT', '1', '1431569933');
INSERT INTO `tbl_part_category` VALUES ('13', 'Stem Retainer', '1', '1439594327');
INSERT INTO `tbl_part_category` VALUES ('14', 'Discs', '1', '1439594331');
INSERT INTO `tbl_part_category` VALUES ('15', 'Pistons', '1', '1439594334');
INSERT INTO `tbl_part_category` VALUES ('16', 'Piston Rods', '1', '1441149790');
INSERT INTO `tbl_part_category` VALUES ('17', 'LOCATING PIN', '1', '1442326479');
INSERT INTO `tbl_part_category` VALUES ('18', 'NYLON ROLLER', '1', '1443529427');
INSERT INTO `tbl_part_category` VALUES ('19', 'ALIGNMENT BOLT', '1', '1445038837');
INSERT INTO `tbl_part_category` VALUES ('20', 'COUPLING', '1', '1445038840');
INSERT INTO `tbl_part_category` VALUES ('21', 'MAST TIE ADAPTER', '1', '1446835752');
INSERT INTO `tbl_part_category` VALUES ('22', 'PUMP SHAFTS', '1', '1447806760');
INSERT INTO `tbl_part_category` VALUES ('23', 'CIRCLE BOLT PLATES', '1', '1447806806');
INSERT INTO `tbl_part_category` VALUES ('24', 'BUSHINGS', '1', '1447806818');
INSERT INTO `tbl_part_category` VALUES ('25', 'SLEEVE', '1', '1448411280');
INSERT INTO `tbl_part_category` VALUES ('26', 'SHAFT HUB', '1', '1448411317');
INSERT INTO `tbl_part_category` VALUES ('27', 'SHAFT', '1', '1448411325');
INSERT INTO `tbl_part_category` VALUES ('28', 'BARREL', '1', '1448908430');
INSERT INTO `tbl_part_category` VALUES ('29', 'JACKSCREW END CAP ASSEMBLY', '1', '1449623598');
INSERT INTO `tbl_part_category` VALUES ('30', 'JACKSCREW RAM STOP', '1', '1449623655');
INSERT INTO `tbl_part_category` VALUES ('31', 'JACKSCREW NUT', '1', '1449623658');
INSERT INTO `tbl_part_category` VALUES ('32', 'JACKSCREW RAM', '1', '1449623660');
INSERT INTO `tbl_part_category` VALUES ('33', 'JACKSCREW SCREW', '1', '1449623694');
INSERT INTO `tbl_part_category` VALUES ('34', 'JACKSCREW BODY', '1', '1449623711');
INSERT INTO `tbl_part_category` VALUES ('35', 'RETENTION BLOCK', '1', '1455293616');
INSERT INTO `tbl_part_category` VALUES ('36', 'RETENTION BLOCK PIN', '1', '1455293619');
INSERT INTO `tbl_part_category` VALUES ('37', 'CLAMP PLATE', '1', '1457729061');
INSERT INTO `tbl_part_category` VALUES ('38', 'SPLIT CLAMP', '1', '1457729079');
INSERT INTO `tbl_part_category` VALUES ('39', 'EXTRUDER', '1', '1462294293');
INSERT INTO `tbl_part_category` VALUES ('40', 'INSERT BLANK', '1', '1462294315');
INSERT INTO `tbl_part_category` VALUES ('41', 'PULLER IDLER', '1', '1462294329');
INSERT INTO `tbl_part_category` VALUES ('42', 'EXTRUDER BEARING', '1', '1462294340');
INSERT INTO `tbl_part_category` VALUES ('43', 'PULLER WHEEL', '1', '1462294349');
INSERT INTO `tbl_part_category` VALUES ('44', 'SPUR GEAR', '1', '1462294376');
INSERT INTO `tbl_part_category` VALUES ('45', 'ALUMINUM PLATE', '1', '1462294416');
INSERT INTO `tbl_part_category` VALUES ('46', 'SPROCKET HOUSING', '1', '1462294451');
INSERT INTO `tbl_part_category` VALUES ('47', 'HEX SHAFT', '1', '1462294491');
INSERT INTO `tbl_part_category` VALUES ('48', 'SENSOR ADJUSTER', '1', '1462294522');
INSERT INTO `tbl_part_category` VALUES ('49', 'SPOOLER', '1', '1462294529');
INSERT INTO `tbl_part_category` VALUES ('50', 'UI SHAFT', '1', '1462294541');
INSERT INTO `tbl_part_category` VALUES ('51', 'GRINDER INTERLOCK', '1', '1462294562');
INSERT INTO `tbl_part_category` VALUES ('52', 'GRINDER INPUT', '1', '1462294580');
INSERT INTO `tbl_part_category` VALUES ('53', 'EXTRUDER NOZZLE', '1', '1462625493');
INSERT INTO `tbl_part_category` VALUES ('54', 'SENSOR SHAFT', '1', '1462625515');
INSERT INTO `tbl_part_category` VALUES ('55', 'Electrical Box', '1', '1469465782');
INSERT INTO `tbl_part_category` VALUES ('56', 'Alum Base Corner', '1', '1472745111');

-- ----------------------------
-- Table structure for tbl_part_file
-- ----------------------------
DROP TABLE IF EXISTS `tbl_part_file`;
CREATE TABLE `tbl_part_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `part_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=106 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of tbl_part_file
-- ----------------------------
INSERT INTO `tbl_part_file` VALUES ('1', '1', '1');
INSERT INTO `tbl_part_file` VALUES ('2', '1', '2');
INSERT INTO `tbl_part_file` VALUES ('3', '1', '36');
INSERT INTO `tbl_part_file` VALUES ('4', '1', '39');
INSERT INTO `tbl_part_file` VALUES ('5', '5', '40');
INSERT INTO `tbl_part_file` VALUES ('6', '5', '41');
INSERT INTO `tbl_part_file` VALUES ('9', '5', '51');
INSERT INTO `tbl_part_file` VALUES ('10', '26', '106');
INSERT INTO `tbl_part_file` VALUES ('11', '26', '107');
INSERT INTO `tbl_part_file` VALUES ('12', '27', '109');
INSERT INTO `tbl_part_file` VALUES ('13', '28', '110');
INSERT INTO `tbl_part_file` VALUES ('14', '28', '111');
INSERT INTO `tbl_part_file` VALUES ('15', '29', '112');
INSERT INTO `tbl_part_file` VALUES ('16', '29', '113');
INSERT INTO `tbl_part_file` VALUES ('17', '30', '114');
INSERT INTO `tbl_part_file` VALUES ('18', '30', '115');
INSERT INTO `tbl_part_file` VALUES ('19', '31', '116');
INSERT INTO `tbl_part_file` VALUES ('20', '31', '117');
INSERT INTO `tbl_part_file` VALUES ('21', '31', '118');
INSERT INTO `tbl_part_file` VALUES ('22', '31', '119');
INSERT INTO `tbl_part_file` VALUES ('23', '31', '120');
INSERT INTO `tbl_part_file` VALUES ('24', '32', '121');
INSERT INTO `tbl_part_file` VALUES ('25', '33', '122');
INSERT INTO `tbl_part_file` VALUES ('26', '36', '123');
INSERT INTO `tbl_part_file` VALUES ('27', '36', '124');
INSERT INTO `tbl_part_file` VALUES ('28', '25', '125');
INSERT INTO `tbl_part_file` VALUES ('29', '25', '126');
INSERT INTO `tbl_part_file` VALUES ('30', '37', '127');
INSERT INTO `tbl_part_file` VALUES ('31', '38', '128');
INSERT INTO `tbl_part_file` VALUES ('32', '39', '129');
INSERT INTO `tbl_part_file` VALUES ('33', '39', '130');
INSERT INTO `tbl_part_file` VALUES ('34', '40', '131');
INSERT INTO `tbl_part_file` VALUES ('35', '41', '132');
INSERT INTO `tbl_part_file` VALUES ('36', '42', '135');
INSERT INTO `tbl_part_file` VALUES ('37', '42', '136');
INSERT INTO `tbl_part_file` VALUES ('38', '43', '137');
INSERT INTO `tbl_part_file` VALUES ('39', '43', '138');
INSERT INTO `tbl_part_file` VALUES ('40', '44', '139');
INSERT INTO `tbl_part_file` VALUES ('41', '45', '140');
INSERT INTO `tbl_part_file` VALUES ('42', '45', '141');
INSERT INTO `tbl_part_file` VALUES ('43', '46', '142');
INSERT INTO `tbl_part_file` VALUES ('44', '47', '143');
INSERT INTO `tbl_part_file` VALUES ('45', '48', '155');
INSERT INTO `tbl_part_file` VALUES ('46', '48', '156');
INSERT INTO `tbl_part_file` VALUES ('47', '51', '157');
INSERT INTO `tbl_part_file` VALUES ('48', '52', '158');
INSERT INTO `tbl_part_file` VALUES ('49', '53', '159');
INSERT INTO `tbl_part_file` VALUES ('50', '61', '161');
INSERT INTO `tbl_part_file` VALUES ('51', '61', '162');
INSERT INTO `tbl_part_file` VALUES ('52', '56', '163');
INSERT INTO `tbl_part_file` VALUES ('53', '56', '164');
INSERT INTO `tbl_part_file` VALUES ('54', '56', '165');
INSERT INTO `tbl_part_file` VALUES ('55', '59', '166');
INSERT INTO `tbl_part_file` VALUES ('56', '59', '168');
INSERT INTO `tbl_part_file` VALUES ('57', '58', '167');
INSERT INTO `tbl_part_file` VALUES ('58', '58', '169');
INSERT INTO `tbl_part_file` VALUES ('59', '58', '170');
INSERT INTO `tbl_part_file` VALUES ('60', '57', '171');
INSERT INTO `tbl_part_file` VALUES ('61', '57', '172');
INSERT INTO `tbl_part_file` VALUES ('62', '60', '173');
INSERT INTO `tbl_part_file` VALUES ('63', '60', '174');
INSERT INTO `tbl_part_file` VALUES ('64', '62', '200');
INSERT INTO `tbl_part_file` VALUES ('66', '64', '201');
INSERT INTO `tbl_part_file` VALUES ('67', '64', '202');
INSERT INTO `tbl_part_file` VALUES ('68', '63', '203');
INSERT INTO `tbl_part_file` VALUES ('69', '56', '207');
INSERT INTO `tbl_part_file` VALUES ('70', '68', '208');
INSERT INTO `tbl_part_file` VALUES ('71', '69', '209');
INSERT INTO `tbl_part_file` VALUES ('72', '32', '211');
INSERT INTO `tbl_part_file` VALUES ('73', '32', '212');
INSERT INTO `tbl_part_file` VALUES ('74', '70', '213');
INSERT INTO `tbl_part_file` VALUES ('75', '72', '214');
INSERT INTO `tbl_part_file` VALUES ('76', '73', '215');
INSERT INTO `tbl_part_file` VALUES ('77', '74', '216');
INSERT INTO `tbl_part_file` VALUES ('78', '75', '217');
INSERT INTO `tbl_part_file` VALUES ('79', '76', '218');
INSERT INTO `tbl_part_file` VALUES ('80', '77', '219');
INSERT INTO `tbl_part_file` VALUES ('81', '79', '220');
INSERT INTO `tbl_part_file` VALUES ('82', '80', '221');
INSERT INTO `tbl_part_file` VALUES ('83', '81', '222');
INSERT INTO `tbl_part_file` VALUES ('84', '82', '223');
INSERT INTO `tbl_part_file` VALUES ('85', '83', '224');
INSERT INTO `tbl_part_file` VALUES ('86', '84', '225');
INSERT INTO `tbl_part_file` VALUES ('87', '85', '226');
INSERT INTO `tbl_part_file` VALUES ('88', '86', '227');
INSERT INTO `tbl_part_file` VALUES ('89', '87', '228');
INSERT INTO `tbl_part_file` VALUES ('90', '88', '229');
INSERT INTO `tbl_part_file` VALUES ('91', '89', '230');
INSERT INTO `tbl_part_file` VALUES ('92', '83', '231');
INSERT INTO `tbl_part_file` VALUES ('93', '84', '232');
INSERT INTO `tbl_part_file` VALUES ('94', '78', '233');
INSERT INTO `tbl_part_file` VALUES ('95', '79', '234');
INSERT INTO `tbl_part_file` VALUES ('96', '79', '236');
INSERT INTO `tbl_part_file` VALUES ('97', '78', '237');
INSERT INTO `tbl_part_file` VALUES ('98', '92', '240');
INSERT INTO `tbl_part_file` VALUES ('99', '91', '241');
INSERT INTO `tbl_part_file` VALUES ('100', '84', '242');
INSERT INTO `tbl_part_file` VALUES ('101', '83', '243');
INSERT INTO `tbl_part_file` VALUES ('102', '79', '244');
INSERT INTO `tbl_part_file` VALUES ('103', '78', '245');
INSERT INTO `tbl_part_file` VALUES ('104', '105', '247');
INSERT INTO `tbl_part_file` VALUES ('105', '106', '248');

-- ----------------------------
-- Table structure for tbl_part_heatnumber
-- ----------------------------
DROP TABLE IF EXISTS `tbl_part_heatnumber`;
CREATE TABLE `tbl_part_heatnumber` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `part_id` int(11) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `heatnumber` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `drawing` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `designation` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of tbl_part_heatnumber
-- ----------------------------
INSERT INTO `tbl_part_heatnumber` VALUES ('4', '21', '0', 'Part Heat 1', 'Drawing 1', '', '34');
INSERT INTO `tbl_part_heatnumber` VALUES ('5', '21', '0', '#1035', 'Dr9098', '', '79');
INSERT INTO `tbl_part_heatnumber` VALUES ('6', '21', '0', '#1035', 'đ', '', '0');
INSERT INTO `tbl_part_heatnumber` VALUES ('7', '19', '0', '456356', '566345', '', '6');
INSERT INTO `tbl_part_heatnumber` VALUES ('8', '22', '0', 'Heat A', 'D', '', '13');
INSERT INTO `tbl_part_heatnumber` VALUES ('9', '22', '0', 'Heat B', 'C', '', '0');
INSERT INTO `tbl_part_heatnumber` VALUES ('10', '24', '0', 'HEAT0001', 'DEG 0001', '', '0');
INSERT INTO `tbl_part_heatnumber` VALUES ('11', '35', '0', 'Heat number A', 'Design A', '', '29');
INSERT INTO `tbl_part_heatnumber` VALUES ('12', '35', '0', 'Heat number B', 'Design B', '', '0');
INSERT INTO `tbl_part_heatnumber` VALUES ('13', '35', '0', 'Heat number C', 'Design C', '', '0');
INSERT INTO `tbl_part_heatnumber` VALUES ('14', '36', '0', 'Heat number 1', 'Drawing 1', '', '15');
INSERT INTO `tbl_part_heatnumber` VALUES ('15', '36', '0', 'Heat number 2', 'Drawing 2', '', '0');
INSERT INTO `tbl_part_heatnumber` VALUES ('16', '6', '0', '789345', 'A567', '', '150');
INSERT INTO `tbl_part_heatnumber` VALUES ('17', '31', '0', 'NYLON BLUE', 'NLB', '', '180');
INSERT INTO `tbl_part_heatnumber` VALUES ('18', '52', '0', 'Heat test 1', 'Design A', '', '4');
INSERT INTO `tbl_part_heatnumber` VALUES ('19', '54', '0', '345h56', '000', '', '45');
INSERT INTO `tbl_part_heatnumber` VALUES ('20', '65', '0', '8907', 'A34567', '', '0');
INSERT INTO `tbl_part_heatnumber` VALUES ('21', '23', '0', 'Nov_4_Heat1', '', 'C20', '0');

-- ----------------------------
-- Table structure for tbl_part_heatnumber_location
-- ----------------------------
DROP TABLE IF EXISTS `tbl_part_heatnumber_location`;
CREATE TABLE `tbl_part_heatnumber_location` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `part_heatnumber_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of tbl_part_heatnumber_location
-- ----------------------------
INSERT INTO `tbl_part_heatnumber_location` VALUES ('1', '2', '2', '6', '1444585580');
INSERT INTO `tbl_part_heatnumber_location` VALUES ('2', '2', '3', '4', '1444585580');
INSERT INTO `tbl_part_heatnumber_location` VALUES ('3', '2', '5', '5', '1444585580');
INSERT INTO `tbl_part_heatnumber_location` VALUES ('4', '1', '2', '11', '1444585846');
INSERT INTO `tbl_part_heatnumber_location` VALUES ('5', '1', '3', '2', '1444585846');
INSERT INTO `tbl_part_heatnumber_location` VALUES ('6', '1', '4', '3', '1444585846');
INSERT INTO `tbl_part_heatnumber_location` VALUES ('7', '1', '5', '4', '1444585846');
INSERT INTO `tbl_part_heatnumber_location` VALUES ('8', '2', '4', '3', '1444585916');
INSERT INTO `tbl_part_heatnumber_location` VALUES ('9', '8', '2', '13', '1444589063');
INSERT INTO `tbl_part_heatnumber_location` VALUES ('10', '11', '2', '24', '1445135215');
INSERT INTO `tbl_part_heatnumber_location` VALUES ('11', '11', '3', '5', '1445135216');
INSERT INTO `tbl_part_heatnumber_location` VALUES ('12', '14', '2', '6', '1445684731');
INSERT INTO `tbl_part_heatnumber_location` VALUES ('13', '14', '1', '9', '1445684731');
INSERT INTO `tbl_part_heatnumber_location` VALUES ('14', '7', '1', '0', '1445948777');
INSERT INTO `tbl_part_heatnumber_location` VALUES ('15', '16', '2', '100', '1445949238');
INSERT INTO `tbl_part_heatnumber_location` VALUES ('16', '4', '1', '16', '1446584413');
INSERT INTO `tbl_part_heatnumber_location` VALUES ('17', '17', '1', '90', '1447099902');
INSERT INTO `tbl_part_heatnumber_location` VALUES ('18', '18', '341', '0', '1449943509');
INSERT INTO `tbl_part_heatnumber_location` VALUES ('19', '5', '1', '10', '1453038040');
INSERT INTO `tbl_part_heatnumber_location` VALUES ('20', '19', '1', '45', '1455472576');

-- ----------------------------
-- Table structure for tbl_part_machine
-- ----------------------------
DROP TABLE IF EXISTS `tbl_part_machine`;
CREATE TABLE `tbl_part_machine` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `part_id` int(11) NOT NULL,
  `machine_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of tbl_part_machine
-- ----------------------------
INSERT INTO `tbl_part_machine` VALUES ('39', '5', '2');
INSERT INTO `tbl_part_machine` VALUES ('40', '5', '3');
INSERT INTO `tbl_part_machine` VALUES ('41', '5', '5');
INSERT INTO `tbl_part_machine` VALUES ('42', '17', '2');
INSERT INTO `tbl_part_machine` VALUES ('43', '12', '6');
INSERT INTO `tbl_part_machine` VALUES ('44', '13', '2');
INSERT INTO `tbl_part_machine` VALUES ('45', '13', '4');

-- ----------------------------
-- Table structure for tbl_part_price
-- ----------------------------
DROP TABLE IF EXISTS `tbl_part_price`;
CREATE TABLE `tbl_part_price` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `part_id` int(11) NOT NULL,
  `price` float NOT NULL,
  `min` int(11) NOT NULL,
  `max` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=255 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of tbl_part_price
-- ----------------------------
INSERT INTO `tbl_part_price` VALUES ('2', '5', '150', '100', '199');
INSERT INTO `tbl_part_price` VALUES ('9', '5', '1200000', '1', '99');
INSERT INTO `tbl_part_price` VALUES ('10', '5', '1200', '200', '299');
INSERT INTO `tbl_part_price` VALUES ('11', '5', '1576', '300', '150');
INSERT INTO `tbl_part_price` VALUES ('12', '5', '123400', '0', '41');
INSERT INTO `tbl_part_price` VALUES ('13', '5', '1111100', '1', '2');
INSERT INTO `tbl_part_price` VALUES ('14', '5', '11223300', '3', '4');
INSERT INTO `tbl_part_price` VALUES ('15', '5', '1255600', '1', '1');
INSERT INTO `tbl_part_price` VALUES ('16', '5', '13400', '1', '3');
INSERT INTO `tbl_part_price` VALUES ('17', '5', '45600', '44', '12');
INSERT INTO `tbl_part_price` VALUES ('18', '0', '12300', '0', '100');
INSERT INTO `tbl_part_price` VALUES ('19', '0', '20000', '0', '1');
INSERT INTO `tbl_part_price` VALUES ('20', '0', '10000', '0', '2');
INSERT INTO `tbl_part_price` VALUES ('21', '0', '7500', '0', '5');
INSERT INTO `tbl_part_price` VALUES ('22', '0', '5000', '0', '10');
INSERT INTO `tbl_part_price` VALUES ('23', '0', '3500', '0', '25');
INSERT INTO `tbl_part_price` VALUES ('24', '0', '2500', '0', '50');
INSERT INTO `tbl_part_price` VALUES ('25', '0', '1800', '0', '100');
INSERT INTO `tbl_part_price` VALUES ('26', '0', '1500', '0', '250');
INSERT INTO `tbl_part_price` VALUES ('27', '0', '1200', '0', '500');
INSERT INTO `tbl_part_price` VALUES ('28', '0', '900', '0', '1000');
INSERT INTO `tbl_part_price` VALUES ('29', '0', '600', '0', '2500');
INSERT INTO `tbl_part_price` VALUES ('30', '0', '300', '0', '5000');
INSERT INTO `tbl_part_price` VALUES ('31', '0', '199', '0', '10000');
INSERT INTO `tbl_part_price` VALUES ('32', '0', '40000', '0', '1');
INSERT INTO `tbl_part_price` VALUES ('33', '0', '0', '0', '10');
INSERT INTO `tbl_part_price` VALUES ('34', '0', '0', '0', '10');
INSERT INTO `tbl_part_price` VALUES ('43', '20', '1', '0', '6000');
INSERT INTO `tbl_part_price` VALUES ('52', '1', '10', '0', '25');
INSERT INTO `tbl_part_price` VALUES ('53', '1', '12', '0', '10');
INSERT INTO `tbl_part_price` VALUES ('54', '1', '15', '0', '5');
INSERT INTO `tbl_part_price` VALUES ('55', '1', '25', '0', '2');
INSERT INTO `tbl_part_price` VALUES ('56', '1', '50', '0', '1');
INSERT INTO `tbl_part_price` VALUES ('57', '19', '45', '0', '567');
INSERT INTO `tbl_part_price` VALUES ('58', '19', '133', '0', '450');
INSERT INTO `tbl_part_price` VALUES ('59', '19', '23', '0', '35');
INSERT INTO `tbl_part_price` VALUES ('60', '21', '2', '0', '400');
INSERT INTO `tbl_part_price` VALUES ('61', '21', '3', '0', '300');
INSERT INTO `tbl_part_price` VALUES ('62', '21', '3', '0', '200');
INSERT INTO `tbl_part_price` VALUES ('63', '20', '5', '0', '1000');
INSERT INTO `tbl_part_price` VALUES ('64', '15', '7', '0', '30');
INSERT INTO `tbl_part_price` VALUES ('65', '15', '6', '0', '20');
INSERT INTO `tbl_part_price` VALUES ('66', '15', '7', '0', '30');
INSERT INTO `tbl_part_price` VALUES ('67', '15', '6', '0', '20');
INSERT INTO `tbl_part_price` VALUES ('68', '15', '7', '0', '30');
INSERT INTO `tbl_part_price` VALUES ('69', '15', '6', '0', '20');
INSERT INTO `tbl_part_price` VALUES ('70', '13', '5.2', '0', '40');
INSERT INTO `tbl_part_price` VALUES ('71', '13', '4.3', '0', '30');
INSERT INTO `tbl_part_price` VALUES ('72', '13', '3', '0', '20');
INSERT INTO `tbl_part_price` VALUES ('73', '13', '2', '0', '10');
INSERT INTO `tbl_part_price` VALUES ('74', '19', '25', '0', '5');
INSERT INTO `tbl_part_price` VALUES ('75', '19', '10.5', '0', '10');
INSERT INTO `tbl_part_price` VALUES ('76', '19', '8.2', '0', '20');
INSERT INTO `tbl_part_price` VALUES ('77', '19', '25', '0', '5');
INSERT INTO `tbl_part_price` VALUES ('78', '19', '10.5', '0', '10');
INSERT INTO `tbl_part_price` VALUES ('79', '19', '8.2', '0', '20');
INSERT INTO `tbl_part_price` VALUES ('80', '26', '29', '0', '16');
INSERT INTO `tbl_part_price` VALUES ('81', '26', '34', '0', '17');
INSERT INTO `tbl_part_price` VALUES ('86', '27', '450', '0', '1');
INSERT INTO `tbl_part_price` VALUES ('87', '28', '425', '0', '3');
INSERT INTO `tbl_part_price` VALUES ('88', '28', '480', '0', '2');
INSERT INTO `tbl_part_price` VALUES ('89', '28', '600', '0', '1');
INSERT INTO `tbl_part_price` VALUES ('90', '29', '345', '0', '3');
INSERT INTO `tbl_part_price` VALUES ('91', '29', '427', '0', '2');
INSERT INTO `tbl_part_price` VALUES ('92', '29', '585', '0', '1');
INSERT INTO `tbl_part_price` VALUES ('93', '30', '280', '0', '1');
INSERT INTO `tbl_part_price` VALUES ('94', '30', '0', '0', '1');
INSERT INTO `tbl_part_price` VALUES ('95', '31', '5.5', '0', '90');
INSERT INTO `tbl_part_price` VALUES ('96', '32', '414', '0', '5');
INSERT INTO `tbl_part_price` VALUES ('97', '33', '3.9', '0', '2784');
INSERT INTO `tbl_part_price` VALUES ('99', '34', '1.9', '0', '2784');
INSERT INTO `tbl_part_price` VALUES ('100', '35', '5.3', '0', '363');
INSERT INTO `tbl_part_price` VALUES ('101', '36', '65', '0', '6');
INSERT INTO `tbl_part_price` VALUES ('102', '25', '300', '0', '4');
INSERT INTO `tbl_part_price` VALUES ('103', '25', '345', '0', '3');
INSERT INTO `tbl_part_price` VALUES ('106', '37', '230', '0', '5');
INSERT INTO `tbl_part_price` VALUES ('107', '37', '255', '0', '4');
INSERT INTO `tbl_part_price` VALUES ('108', '37', '300', '0', '3');
INSERT INTO `tbl_part_price` VALUES ('109', '37', '390', '0', '2');
INSERT INTO `tbl_part_price` VALUES ('110', '37', '520', '0', '1');
INSERT INTO `tbl_part_price` VALUES ('116', '38', '230', '0', '5');
INSERT INTO `tbl_part_price` VALUES ('117', '38', '255', '0', '4');
INSERT INTO `tbl_part_price` VALUES ('118', '38', '300', '0', '3');
INSERT INTO `tbl_part_price` VALUES ('119', '38', '390', '0', '2');
INSERT INTO `tbl_part_price` VALUES ('120', '38', '520', '0', '1');
INSERT INTO `tbl_part_price` VALUES ('121', '39', '250', '0', '20');
INSERT INTO `tbl_part_price` VALUES ('122', '40', '115', '0', '35');
INSERT INTO `tbl_part_price` VALUES ('123', '41', '95', '0', '35');
INSERT INTO `tbl_part_price` VALUES ('124', '42', '21', '0', '105');
INSERT INTO `tbl_part_price` VALUES ('125', '43', '15', '0', '105');
INSERT INTO `tbl_part_price` VALUES ('126', '45', '11', '0', '35');
INSERT INTO `tbl_part_price` VALUES ('127', '46', '9.8', '0', '35');
INSERT INTO `tbl_part_price` VALUES ('128', '47', '12.75', '0', '35');
INSERT INTO `tbl_part_price` VALUES ('129', '44', '48', '0', '35');
INSERT INTO `tbl_part_price` VALUES ('130', '44', '0', '0', '35');
INSERT INTO `tbl_part_price` VALUES ('131', '48', '48', '0', '66');
INSERT INTO `tbl_part_price` VALUES ('132', '50', '39', '0', '100');
INSERT INTO `tbl_part_price` VALUES ('133', '50', '300', '0', '1');
INSERT INTO `tbl_part_price` VALUES ('136', '49', '52', '0', '100');
INSERT INTO `tbl_part_price` VALUES ('137', '49', '960', '0', '1');
INSERT INTO `tbl_part_price` VALUES ('140', '51', '120', '0', '5');
INSERT INTO `tbl_part_price` VALUES ('141', '51', '140', '0', '4');
INSERT INTO `tbl_part_price` VALUES ('142', '51', '175', '0', '3');
INSERT INTO `tbl_part_price` VALUES ('143', '51', '245', '0', '2');
INSERT INTO `tbl_part_price` VALUES ('144', '51', '380', '0', '1');
INSERT INTO `tbl_part_price` VALUES ('145', '52', '370', '0', '2');
INSERT INTO `tbl_part_price` VALUES ('146', '53', '140', '0', '2');
INSERT INTO `tbl_part_price` VALUES ('147', '61', '355', '0', '3');
INSERT INTO `tbl_part_price` VALUES ('148', '61', '880', '0', '1');
INSERT INTO `tbl_part_price` VALUES ('151', '59', '375', '0', '3');
INSERT INTO `tbl_part_price` VALUES ('152', '59', '940', '0', '1');
INSERT INTO `tbl_part_price` VALUES ('153', '58', '175', '0', '3');
INSERT INTO `tbl_part_price` VALUES ('154', '58', '450', '0', '1');
INSERT INTO `tbl_part_price` VALUES ('155', '57', '550', '0', '3');
INSERT INTO `tbl_part_price` VALUES ('156', '57', '1390', '0', '1');
INSERT INTO `tbl_part_price` VALUES ('157', '60', '235', '0', '3');
INSERT INTO `tbl_part_price` VALUES ('158', '60', '590', '0', '1');
INSERT INTO `tbl_part_price` VALUES ('159', '56', '910', '0', '3');
INSERT INTO `tbl_part_price` VALUES ('160', '56', '1990', '0', '1');
INSERT INTO `tbl_part_price` VALUES ('161', '62', '5.2', '0', '500');
INSERT INTO `tbl_part_price` VALUES ('162', '62', '8.5', '0', '100');
INSERT INTO `tbl_part_price` VALUES ('163', '62', '16.7', '0', '20');
INSERT INTO `tbl_part_price` VALUES ('164', '63', '13.9', '0', '500');
INSERT INTO `tbl_part_price` VALUES ('165', '63', '18.9', '0', '100');
INSERT INTO `tbl_part_price` VALUES ('166', '63', '33', '0', '20');
INSERT INTO `tbl_part_price` VALUES ('170', '64', '8.3', '0', '500');
INSERT INTO `tbl_part_price` VALUES ('171', '64', '12.4', '0', '100');
INSERT INTO `tbl_part_price` VALUES ('172', '64', '23.65', '0', '20');
INSERT INTO `tbl_part_price` VALUES ('173', '66', '137.5', '0', '4');
INSERT INTO `tbl_part_price` VALUES ('174', '67', '98.5', '0', '8');
INSERT INTO `tbl_part_price` VALUES ('175', '68', '370', '0', '2');
INSERT INTO `tbl_part_price` VALUES ('176', '69', '215', '0', '2');
INSERT INTO `tbl_part_price` VALUES ('177', '32', '720', '0', '2');
INSERT INTO `tbl_part_price` VALUES ('178', '32', '550', '0', '3');
INSERT INTO `tbl_part_price` VALUES ('179', '76', '10.3', '0', '500');
INSERT INTO `tbl_part_price` VALUES ('181', '75', '1.75', '0', '500');
INSERT INTO `tbl_part_price` VALUES ('182', '77', '3.1', '0', '500');
INSERT INTO `tbl_part_price` VALUES ('183', '74', '4.55', '0', '500');
INSERT INTO `tbl_part_price` VALUES ('184', '73', '2.75', '0', '500');
INSERT INTO `tbl_part_price` VALUES ('185', '72', '3.35', '0', '500');
INSERT INTO `tbl_part_price` VALUES ('186', '71', '6.65', '0', '500');
INSERT INTO `tbl_part_price` VALUES ('187', '70', '7.9', '0', '500');
INSERT INTO `tbl_part_price` VALUES ('188', '83', '1.45', '0', '500');
INSERT INTO `tbl_part_price` VALUES ('189', '84', '5', '0', '500');
INSERT INTO `tbl_part_price` VALUES ('190', '82', '2.5', '0', '500');
INSERT INTO `tbl_part_price` VALUES ('191', '81', '4.85', '0', '500');
INSERT INTO `tbl_part_price` VALUES ('192', '85', '6.3', '0', '500');
INSERT INTO `tbl_part_price` VALUES ('193', '78', '16.39', '0', '500');
INSERT INTO `tbl_part_price` VALUES ('194', '79', '18.8', '0', '500');
INSERT INTO `tbl_part_price` VALUES ('195', '90', '40.9', '0', '500');
INSERT INTO `tbl_part_price` VALUES ('196', '88', '27.52', '0', '500');
INSERT INTO `tbl_part_price` VALUES ('197', '89', '33.6', '0', '500');
INSERT INTO `tbl_part_price` VALUES ('198', '87', '19.6', '0', '500');
INSERT INTO `tbl_part_price` VALUES ('199', '86', '17.85', '0', '500');
INSERT INTO `tbl_part_price` VALUES ('200', '80', '8.9', '0', '500');
INSERT INTO `tbl_part_price` VALUES ('201', '86', '45.1', '0', '10');
INSERT INTO `tbl_part_price` VALUES ('202', '90', '68.25', '0', '10');
INSERT INTO `tbl_part_price` VALUES ('203', '88', '55', '0', '10');
INSERT INTO `tbl_part_price` VALUES ('204', '87', '46.1', '0', '10');
INSERT INTO `tbl_part_price` VALUES ('205', '89', '60.8', '0', '10');
INSERT INTO `tbl_part_price` VALUES ('206', '74', '32.9', '0', '10');
INSERT INTO `tbl_part_price` VALUES ('207', '73', '23.75', '0', '10');
INSERT INTO `tbl_part_price` VALUES ('208', '72', '24.3', '0', '10');
INSERT INTO `tbl_part_price` VALUES ('209', '71', '34.65', '0', '10');
INSERT INTO `tbl_part_price` VALUES ('210', '75', '16.5', '0', '10');
INSERT INTO `tbl_part_price` VALUES ('211', '77', '28.5', '0', '10');
INSERT INTO `tbl_part_price` VALUES ('212', '76', '47.25', '0', '10');
INSERT INTO `tbl_part_price` VALUES ('213', '70', '42.15', '0', '10');
INSERT INTO `tbl_part_price` VALUES ('214', '91', '5.8', '0', '500');
INSERT INTO `tbl_part_price` VALUES ('215', '91', '34.25', '0', '10');
INSERT INTO `tbl_part_price` VALUES ('216', '92', '6.05', '0', '500');
INSERT INTO `tbl_part_price` VALUES ('217', '92', '34.05', '0', '10');
INSERT INTO `tbl_part_price` VALUES ('218', '82', '24.65', '0', '10');
INSERT INTO `tbl_part_price` VALUES ('219', '81', '34.5', '0', '10');
INSERT INTO `tbl_part_price` VALUES ('220', '80', '58.67', '0', '10');
INSERT INTO `tbl_part_price` VALUES ('221', '85', '38.47', '0', '10');
INSERT INTO `tbl_part_price` VALUES ('222', '84', '36.9', '0', '10');
INSERT INTO `tbl_part_price` VALUES ('223', '83', '24.15', '0', '10');
INSERT INTO `tbl_part_price` VALUES ('224', '79', '71.25', '0', '10');
INSERT INTO `tbl_part_price` VALUES ('225', '78', '69', '0', '10');
INSERT INTO `tbl_part_price` VALUES ('226', '93', '22', '0', '500');
INSERT INTO `tbl_part_price` VALUES ('227', '93', '77', '0', '10');
INSERT INTO `tbl_part_price` VALUES ('228', '94', '12.9', '0', '500');
INSERT INTO `tbl_part_price` VALUES ('229', '94', '77', '0', '10');
INSERT INTO `tbl_part_price` VALUES ('230', '95', '25', '0', '500');
INSERT INTO `tbl_part_price` VALUES ('231', '95', '72.5', '0', '10');
INSERT INTO `tbl_part_price` VALUES ('232', '96', '13.8', '0', '500');
INSERT INTO `tbl_part_price` VALUES ('233', '96', '72.5', '0', '10');
INSERT INTO `tbl_part_price` VALUES ('234', '97', '20', '0', '500');
INSERT INTO `tbl_part_price` VALUES ('235', '97', '94', '0', '10');
INSERT INTO `tbl_part_price` VALUES ('236', '98', '16.85', '0', '500');
INSERT INTO `tbl_part_price` VALUES ('237', '98', '94', '0', '10');
INSERT INTO `tbl_part_price` VALUES ('238', '99', '22.5', '0', '500');
INSERT INTO `tbl_part_price` VALUES ('239', '99', '87', '0', '10');
INSERT INTO `tbl_part_price` VALUES ('240', '100', '16.75', '0', '500');
INSERT INTO `tbl_part_price` VALUES ('241', '100', '87', '0', '10');
INSERT INTO `tbl_part_price` VALUES ('242', '101', '29', '0', '500');
INSERT INTO `tbl_part_price` VALUES ('243', '101', '123.5', '0', '10');
INSERT INTO `tbl_part_price` VALUES ('244', '102', '19.2', '0', '500');
INSERT INTO `tbl_part_price` VALUES ('245', '102', '123.5', '0', '10');
INSERT INTO `tbl_part_price` VALUES ('246', '103', '22', '0', '500');
INSERT INTO `tbl_part_price` VALUES ('247', '103', '103', '0', '10');
INSERT INTO `tbl_part_price` VALUES ('248', '104', '15.55', '0', '500');
INSERT INTO `tbl_part_price` VALUES ('249', '104', '103', '0', '10');
INSERT INTO `tbl_part_price` VALUES ('250', '105', '15', '0', '500');
INSERT INTO `tbl_part_price` VALUES ('251', '106', '9.65', '0', '300');
INSERT INTO `tbl_part_price` VALUES ('252', '106', '13.25', '0', '100');
INSERT INTO `tbl_part_price` VALUES ('253', '106', '25.9', '0', '25');
INSERT INTO `tbl_part_price` VALUES ('254', '106', '117.4', '0', '4');

-- ----------------------------
-- Table structure for tbl_purchase_order
-- ----------------------------
DROP TABLE IF EXISTS `tbl_purchase_order`;
CREATE TABLE `tbl_purchase_order` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `po_code` varchar(20) NOT NULL,
  `client_id` int(11) unsigned NOT NULL,
  `shipping_address` varchar(255) NOT NULL,
  `ship_via` varchar(20) NOT NULL,
  `order_date` int(11) unsigned NOT NULL,
  `file_id` int(11) unsigned DEFAULT NULL,
  `status` tinyint(1) unsigned DEFAULT NULL,
  `reply_status` tinyint(1) NOT NULL,
  `reply_time` int(11) NOT NULL,
  `created_time` int(11) unsigned DEFAULT NULL,
  `delivery_date` int(11) NOT NULL,
  `entered_date` int(11) NOT NULL,
  `customer_po` varchar(255) NOT NULL,
  `note` text NOT NULL,
  `comment` text NOT NULL,
  `tax` float NOT NULL,
  `category` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_purchase_order
-- ----------------------------
INSERT INTO `tbl_purchase_order` VALUES ('1', 'PO1', '1', '', 'car', '1426377600', '0', '1', '0', '0', '1426516650', '0', '0', '', '', '', '0', '0');
INSERT INTO `tbl_purchase_order` VALUES ('2', '123456jb', '3', 'Hanoi VN', 'TRUCK', '1428883200', '0', '1', '2', '1430448809', '1429087690', '1430352000', '1429056000', 'CPO12345', '', '', '0', '0');
INSERT INTO `tbl_purchase_order` VALUES ('3', '4pr003782', '1', 'LA, US', 'our truck', '1430611200', '0', '1', '0', '0', '1431525533', '1433808000', '1430697600', '4pr003782', '', '', '0', '0');
INSERT INTO `tbl_purchase_order` VALUES ('4', 'HUNGORDER', '3', 'Hanoi VN', 'Truck', '1433116800', '0', '1', '0', '0', '1433175660', '1433548800', '1433116800', 'HUNGORDER1', '<p>This is hung&#39;s order abc def</p>\n', '<p>hung comment here</p>\n', '0', '0');
INSERT INTO `tbl_purchase_order` VALUES ('5', '13375', '4', '485 Conestoga Blvd.', 'Us', '1442275200', '0', '1', '0', '0', '1442330235', '1442880000', '1442275200', '13375', '', '', '0', '0');
INSERT INTO `tbl_purchase_order` VALUES ('6', 'RFQSNS1009', '5', '142 Sugar Maple Rd.', 'Our truck', '1442361600', '0', '1', '0', '0', '1442407089', '1444348800', '1442361600', '', 'SNS RFQ BEST POSSIBLE PRICING FOR THIS QUOTE', '', '0', '0');
INSERT INTO `tbl_purchase_order` VALUES ('7', 'RFQGFW1010', '4', '485 Conestoga Blvd.', 'OUT TRUCKS', '1443484800', '0', '1', '0', '0', '1443529965', '1444608000', '1443484800', '', '<p>CUSTOMER TO SUPPLY MATERIAL DELIVERY DATE IS 1-1/2 WEEKS FROM ISSUED P.O.</p>\n', '', '13', '0');
INSERT INTO `tbl_purchase_order` VALUES ('8', 'RFQ1011', '5', '142 Sugar Maple Rd.', 'OUR TRUCK', '1444348800', '0', '1', '0', '0', '1444692856', '1445558400', '1444608000', 'QUOTE', '<p>RE-QUOTE WITHOUT FLAME CUT HOLE</p>\n', '<p>DELIVERY 2 WEEKS OR LESS. mATERIAL TO BE SUPPLIED</p>\n', '0', '0');
INSERT INTO `tbl_purchase_order` VALUES ('9', 'RFQSNS_11_02_15', '5', '142 Sugar Maple Rd.', 'OUR TRUCKS', '1446422400', '0', '1', '0', '0', '1446512809', '1450224000', '1446422400', 'RFQ', '<p>SHAFTS AND PISTONS GROUPED TOGETHER FOR BETTER PRICING</p>\n', '<p>SHAFTS AND PISTONS GROUPED TOGETHER FOR BETTER PRICING</p>\n', '0', '0');
INSERT INTO `tbl_purchase_order` VALUES ('10', 'RFQSNS_11_02_15', '5', '142 Sugar Maple Rd.', 'OUR TRUCKS', '1446422400', '0', '1', '0', '0', '1446512821', '1450224000', '1446422400', 'RFQ', '<p>PISTONS &amp; SHAFTS GROUPED TOGETHER</p>\n', '<p>PISTONS &amp; SHAFTS GROUPED TOGETHER</p>\n', '13', '0');
INSERT INTO `tbl_purchase_order` VALUES ('11', 'RFQ1001_MRC', '7', '', 'OUR TRUCK', '1446768000', '0', '1', '0', '0', '1446836288', '1446768000', '1446768000', 'RFQ1001_MRC', '', '', '0', '0');
INSERT INTO `tbl_purchase_order` VALUES ('12', 'RFQ1001_MRC', '7', '', 'OUR TRUCK', '1446768000', '0', '1', '0', '0', '1446836340', '1446768000', '1446768000', 'RFQ1001_MRC', '<p>PRICE IS FOR COMPLETE PART</p>\n', '', '0', '0');
INSERT INTO `tbl_purchase_order` VALUES ('13', 'RFQ_GFW1024-14026', '4', '485 Conestoga Blvd.', 'OUR TRUCKS', '1449705600', '0', '1', '0', '0', '1447808695', '1450828800', '1447718400', '14026', '', '', '0', '0');
INSERT INTO `tbl_purchase_order` VALUES ('14', 'GFW14026-1025', '4', '485 Conestoga Blvd.', 'OUR TRUCK', '1447804800', '0', '1', '0', '0', '1447855485', '1450828800', '1447804800', '14026', '', '<p>testing</p>\n', '13', '0');
INSERT INTO `tbl_purchase_order` VALUES ('15', 'RFQ_KUR_1001', '8', '140 Roy Blvd.', 'OUR TRUCKS', '1448409600', '0', '1', '0', '0', '1448470384', '1449532800', '1448409600', 'RFQ_KUR_1001', '<p>2 WEEK OR SOONER DELIVERY - PARTS TO BE MADE COMPLETE TO PRINT.<br />\n&nbsp;</p>\n', '', '15', '0');
INSERT INTO `tbl_purchase_order` VALUES ('16', 'RFQSNS_1012_MATERIAL', '9', '142 Sugar Maple Rd.', 'OUR TRUCK', '1448409600', '0', '1', '0', '0', '1448486436', '1450224000', '1448409600', 'RFQSNS_1012', '<p>MATERIAL &amp; MACHINING RFQ IS 1 PROTOYPE &amp; 100PCS ORDER.</p>\n\n<p>PROTOTYPES 2-1/2 WEEKS DELIVERY FROM P.O.</p>\n\n<p>100PC ORDER WOULD BE 5-6WEEKS DELIVERY FROM ISSUED P.O.</p>\n\n<p>DUE TO MATERIAL LEAD TIME<br />\n&nbsp;</p>\n', '', '0', '0');
INSERT INTO `tbl_purchase_order` VALUES ('17', 'RFQSNS_1013', '9', '142 Sugar Maple Rd.', 'OUR TRUCK', '1448409600', '0', '1', '0', '0', '1448487898', '1450224000', '1448409600', 'RFQSNS_1013', '', '', '0', '0');
INSERT INTO `tbl_purchase_order` VALUES ('18', 'RFQSNS_1014', '9', '142 Sugar Maple Rd.', 'OUR TURCK', '1448496000', '0', '1', '0', '0', '1448559169', '1449532800', '1448496000', 'RFQSNS_1014', '<p>PRICE CHANGED VERBALLY UPON 2 MORE PEICES BEING ADDED TO PISTON ORDER</p>\n', '<p>PRICE CHANGED VERBALLY UPON 2 MORE PEICES BEING ADDED TO PISTON ORDER</p>\n', '0', '0');
INSERT INTO `tbl_purchase_order` VALUES ('19', '4PR005678', '5', '142 Sugar Maple Rd.', 'OUR TRUCK', '1448409600', '0', '1', '0', '0', '1448909773', '1449619200', '1448841600', '4PR005678', '', '', '15', '0');
INSERT INTO `tbl_purchase_order` VALUES ('20', 'HUNG_DEC_08', '9', '142 Sugar Maple Rd.', 'Boat', '1449792000', '0', '1', '0', '0', '1449593199', '1450310400', '1449532800', '120988', '<p>HUNG</p>\n', '<p>Commne</p>\n', '15', '0');
INSERT INTO `tbl_purchase_order` VALUES ('21', 'RFQ_SNS1028', '9', '142 Sugar Maple Rd.', 'OUR TRUCK', '1449619200', '0', '1', '0', '0', '1449676050', '1452038400', '1449619200', 'RFQ_SNS1028', '<p>PART# E-01002179 CHROME IS NOT INCLUDED IN PRICE PER PEICE.CHROMING PRICE IS $2120.00 AS PER SNS QUOTE FROM &quot;ONTARIO CHROME&quot;.</p>\n\n<p>PART#E-01002405 IS COMPLETE WITH PLATING PRICES INCLUDE FINAL ASSEMBLY OF 2 PARTS.</p>\n', '<p>CHROMING FOR PART NUMBER E-01002179 IS NOT INCLUDED IN PRICE PER PEICE.</p>\n\n<p>CHROMING PRICE IS $2120.00 AS PER SNS QUOTE FROM &quot;ONTARIO CHROME&quot;</p>\n\n<p>PART#E-01002405 IS COMPLETE PRICE PER PEICE WITH ZINC PLATE &amp; OLIVE DRAB CHROMATE.</p>\n\n<p>PRICES INCLUDE FINAL ASSEMBLY OF 2 PARTS.</p>\n', '0', '0');
INSERT INTO `tbl_purchase_order` VALUES ('22', 'RFQ_SNS1029', '9', '142 Sugar Maple Rd.', 'OUR TRUCK', '1449619200', '0', '1', '0', '0', '1449678969', '1452038400', '1449619200', 'RFQ_SNS1029', '<p>PRICE PER/PC IS FULL ASSEMBLY W/WELDING AND MACHINING BEFORE &amp; AFTER.&nbsp; PRICE DEOS NOT INCLUDE MACHINING BOLT HOLE PATTERN(SNS).&nbsp;</p>\n\n<p>DELIVERY IS 4WEEKS OR SOONER.</p>\n', '<p>PRICE PER/PC IS FULL ASSEMBLY W/WELDING AND MACHINING BEFORE &amp; AFTER.&nbsp; PRICE DEOS NOT INCLUDE MACHINING BOLT HOLE PATTERN(SNS).&nbsp;</p>\n\n<p>DELIVERY IS 4WEEKS OR SOONER.</p>\n', '0', '0');
INSERT INTO `tbl_purchase_order` VALUES ('23', 'RFQDMO1001_20pcs', '10', '20 Lee Ave.', 'OUR TRUCKS', '1455235200', '0', '1', '0', '0', '1455295996', '1458864000', '1455235200', 'RFQ_DMO_1001', '<p>Price is with No assembly.&nbsp; Note high prices on Assembly parts due to low quantity orders.</p>\n\n<p>Delivery is 4-5 Weeks or sooner.<br />\n&nbsp;</p>\n', '', '0', '1');
INSERT INTO `tbl_purchase_order` VALUES ('24', 'RFQDMO1001_20pcASSBM', '10', '20 Lee Ave.', 'OUR TRUCKS', '1455235200', '0', '1', '0', '0', '1455298455', '1458864000', '1455235200', 'RFQ_DMO_1001-2', '<p>Price includes Assembly Fee.</p>\n\n<p>4-5 weeks or sooner Delivery</p>\n', '', '0', '1');
INSERT INTO `tbl_purchase_order` VALUES ('25', 'RFQDMO1001_100pcASBM', '10', '20 Lee Ave.', 'OUR TRUCKS', '1455235200', '0', '1', '0', '0', '1455298950', '1458864000', '1455235200', 'RFQ_DMO_1001-3', '<p>Price is for 100 units with assembly.</p>\n\n<p>3-4 weeks Delivery for 100PC quantity</p>\n', '', '0', '1');
INSERT INTO `tbl_purchase_order` VALUES ('26', 'RFQDMO1001_100pc', '10', '20 Lee Ave.', 'OUR TRUCKS', '1455235200', '0', '1', '0', '0', '1455300624', '1458864000', '1455235200', 'RFQ_DMO_1001-3', '<p>100pc Order with Retention block B as one peice with Center Pin</p>\n\n<p>3-4 Weeks delivery.&nbsp; Delivery Time may decrease as orders repeat.</p>\n\n<p>Price works out to <strong>$38.10/PP&nbsp; QTY:100pcs &amp;</strong></p>\n\n<p><strong>$40.70/PP W/Assembly</strong></p>\n', '', '0', '1');
INSERT INTO `tbl_purchase_order` VALUES ('27', 'RFQDMO1001_500pc', '10', '20 Lee Ave.', 'OUR TRUCKS', '1455235200', '0', '1', '0', '0', '1455300996', '1458864000', '1455235200', 'RFQ_DMO_1001-4', '<p>500PC Orders No Assembly</p>\n\n<p>6-7 Weeks Or sooner delivery</p>\n\n<p>&nbsp;</p>\n\n<p>&nbsp;</p>\n', '', '0', '1');
INSERT INTO `tbl_purchase_order` VALUES ('28', 'RFQDMO1001_500pcASBM', '10', '20 Lee Ave.', 'OUR TRUCKS', '1455235200', '0', '1', '0', '0', '1455301529', '1458864000', '1455235200', 'RFQ_DMO_1001-4', '<p>500PC Orders With Assembly</p>\n\n<p>6-7 Weeks Or sooner delivery</p>\n', '', '0', '1');
INSERT INTO `tbl_purchase_order` VALUES ('29', 'HUNG_Feb13', '10', '20 Lee Ave.', 'OUR TRUCKS', '1455235200', '0', '1', '0', '0', '1455497619', '1458864000', '1455235200', 'RFQ_DMO_1001-4', '', '', '0', '0');
INSERT INTO `tbl_purchase_order` VALUES ('30', 'RFQDMO1001_50pc', '10', '20 Lee Ave.', 'OUR TRUCKS', '1455235200', '0', '1', '0', '0', '1456433424', '1458864000', '1455235200', 'RFQ_DMO_1001-4', '<p>50pcs Order made W/retention Block B as one piece with Pin</p>\n\n<p>2-3 Weeks Delivery on first order.</p>\n\n<p>This works out to <strong>$45.40/pp QTY:50pcs&nbsp; &amp;</strong></p>\n\n<p><strong>$48.00/pp W/Assembly</strong></p>\n\n<p>&nbsp;</p>\n', '', '0', '1');
INSERT INTO `tbl_purchase_order` VALUES ('31', 'RFQDMO1001_300pc', '10', '20 Lee Ave.', 'OUR TRUCKS', '1455235200', '0', '1', '0', '0', '1456499752', '1458864000', '1455235200', 'RFQ_DMO_1001-4', '', '<p>Sample price</p>\n', '0', '1');
INSERT INTO `tbl_purchase_order` VALUES ('32', 'RFQ_SOL_0001', '11', '175 Aviation Avenue,  Brantford Municipal Airport', 'OUR TRUCKS', '1457654400', '0', '1', '0', '0', '1457729775', '1458518400', '1457654400', 'RFQ_SOL_0001', '<p>Delivery is 1 week or sooner if needed. We would request solid models if available.&nbsp; If not price will increase slightly due to extra setup costs.<br />\n&nbsp;</p>\n', '', '0', '1');
INSERT INTO `tbl_purchase_order` VALUES ('33', 'SNS_86936', '9', '142 Sugar Maple Rd.', 'Our Trucks', '1457308800', '0', '1', '0', '0', '1457794313', '1459123200', '1457654400', '86936', '', '', '15', '0');
INSERT INTO `tbl_purchase_order` VALUES ('34', 'RFQ_RDT_1001', '12', '442-T DUFFERIN STREET', 'OUR TRUCKS', '1462147200', '0', '1', '0', '0', '1462397921', '1465516800', '1462320000', 'RFQ_RDT_1001', '<p>We are offering 316SS for all of these parts &amp; .374-/+ .0005 will be made from ground stock material.</p>\n\n<p>FULL PRODUCTION ON THESE STAINLESS PARTS IS 6-8WEEKS From issued P.O.</p>\n\n<p>Bulk delivery Charge of $100.00 May apply.&nbsp; Any small rush orders are sent standard UPS, FedEX, Purolator ect...and are usually around $25-30.</p>\n\n<p>Payment Terms Nagotiable</p>\n', '', '0', '1');
INSERT INTO `tbl_purchase_order` VALUES ('35', 'RFQ_RDT_1006', '12', '442-T DUFFERIN STREET', 'Our Trucks', '1462320000', '0', '1', '0', '0', '1462452972', '1466726400', '1462320000', 'RFQ_RDT_1006', '<p>5-6 Week Delivery on these parts.</p>\n', '', '0', '1');
INSERT INTO `tbl_purchase_order` VALUES ('36', 'RFQ_RDT_1007_1\"ALUM', '12', '442-T DUFFERIN STREET', 'OUR TRUCKS', '1462406400', '0', '1', '0', '0', '1462453725', '1466726400', '1462406400', 'RFQ_RDT_1007_1\"ALUM', '<p><span class=\"marker\"><strong>5-6WEEKS DELIVERY</strong></span></p>\n', '', '0', '1');
INSERT INTO `tbl_purchase_order` VALUES ('37', 'RFQ_RDT_1006_10PCS', '12', '442-T DUFFERIN STREET', 'Our Trucks', '1462320000', '0', '1', '0', '0', '1462562411', '1464912000', '1462320000', 'RFQ_RDT_1006', '<p>2-3 WEEK DELIVERY FROM ISSUED P.O.</p>\n', '', '0', '1');
INSERT INTO `tbl_purchase_order` VALUES ('38', 'RFQ_RDT_1001_10PCS', '12', '442-T DUFFERIN STREET', 'OUR TRUCKS', '1462147200', '0', '1', '0', '0', '1462565988', '1465516800', '1462320000', 'RFQ_RDT_1001', '<p>2-3 WEEKS DELIVERY FOR ALL ITEMS ON THIS QUOTE</p>\n', '', '0', '1');
INSERT INTO `tbl_purchase_order` VALUES ('39', 'RFQ_RDT_1007_10PCS', '12', '442-T DUFFERIN STREET', 'OUR TRUCKS', '1462406400', '0', '1', '0', '0', '1462627445', '1466726400', '1462406400', 'RFQ_RDT_1007_1\"ALUM', '<p><span class=\"marker\"><strong>2-3 WEEKS DELIVERY</strong></span></p>\n', '', '0', '1');
INSERT INTO `tbl_purchase_order` VALUES ('40', 'RFQ#_1012_AMP500PC', '12', '442-T DUFFERIN STREET', 'OUR tRUCKS', '1463097600', '0', '1', '0', '0', '1463244506', '1463702400', '1463097600', 'RFQ#_1012_AMP500PC', '<p>GEAR WILL BE MADE FROM ROLLED LENGTH GEAR STOCK.</p>\n\n<p>FROM 4140 &amp; 1215 STEELS.</p>\n\n<p>LEAD TIME IS 13-15 WEEKS DUE TO GEAR STOCK AVAILABILITY</p>\n\n<p>GEAR STOCK ORDER WOULD REQUIRE 50% DEPOSIT.<br />\n&nbsp;</p>\n', '', '0', '1');
INSERT INTO `tbl_purchase_order` VALUES ('41', 'RFQ#_1012_ON500PC', '12', '442-T DUFFERIN STREET', 'OUR tRUCKS', '1463097600', '0', '1', '0', '0', '1463244822', '1463702400', '1463097600', 'RFQ#_1012_AMP500PC', '<p><strong>8-10 WEEK DELIVERY ON FULL 500 PC ORDER.</strong></p>\n', '', '0', '1');
INSERT INTO `tbl_purchase_order` VALUES ('42', 'RFQ#_1012_ON10PC', '12', '442-T DUFFERIN STREET', 'OUR tRUCKS', '1463097600', '0', '1', '0', '0', '1463245122', '1463702400', '1463097600', 'RFQ#_1012_AMP500PC', '<p>8-10 WEEK DELIVERY</p>\n', '', '0', '1');

-- ----------------------------
-- Table structure for tbl_purchase_order_detail
-- ----------------------------
DROP TABLE IF EXISTS `tbl_purchase_order_detail`;
CREATE TABLE `tbl_purchase_order_detail` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `purchase_order_id` int(11) unsigned NOT NULL,
  `line_number` int(5) unsigned DEFAULT NULL,
  `item_number` varchar(255) NOT NULL,
  `quantity` int(11) unsigned NOT NULL,
  `uom` varchar(20) DEFAULT NULL,
  `part_id` int(11) unsigned NOT NULL,
  `description` varchar(2048) NOT NULL,
  `revision` varchar(20) DEFAULT NULL,
  `drawing_id` int(11) unsigned DEFAULT NULL,
  `price` float unsigned NOT NULL,
  `revised_price` float NOT NULL,
  `discount` float unsigned DEFAULT NULL,
  `delivery_date` int(11) unsigned NOT NULL,
  `revised_date` int(11) NOT NULL,
  `take_from_inventory` tinyint(1) unsigned DEFAULT NULL,
  `status` tinyint(2) unsigned DEFAULT NULL,
  `created_time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=140 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_purchase_order_detail
-- ----------------------------
INSERT INTO `tbl_purchase_order_detail` VALUES ('1', '1', '1', '', '100', 'ea', '1', 'desc', 'h', '70', '10', '0', null, '1426464000', '0', null, '1', '1426516650');
INSERT INTO `tbl_purchase_order_detail` VALUES ('2', '1', '2', '', '200', 'ea', '2', 'desc', 'h', '0', '20', '0', '10', '1426550400', '0', null, '1', '0');
INSERT INTO `tbl_purchase_order_detail` VALUES ('3', '2', '0', '010', '50', '', '19', '', '', '77', '0.23', '0', null, '1430352000', '0', null, '1', '1429087690');
INSERT INTO `tbl_purchase_order_detail` VALUES ('4', '2', '0', '020', '900', '', '12', '', '', '79', '23', '33', null, '1430352000', '0', null, '1', '1429087690');
INSERT INTO `tbl_purchase_order_detail` VALUES ('5', '2', null, '030', '25', null, '21', '', null, '78', '3', '3.5', null, '1430352000', '0', null, '1', '1429115132');
INSERT INTO `tbl_purchase_order_detail` VALUES ('6', '3', '0', '10', '100', '', '13', '', '', '0', '3.6', '5.5', null, '1431475200', '0', null, '1', '1431525533');
INSERT INTO `tbl_purchase_order_detail` VALUES ('7', '4', '0', '', '20', '', '21', '', '', '0', '1', '0', null, '1433548800', '0', null, '1', '1433175660');
INSERT INTO `tbl_purchase_order_detail` VALUES ('8', '4', '0', '', '15', '', '19', '', '', '0', '2', '0', null, '1433548800', '0', null, '1', '1433175660');
INSERT INTO `tbl_purchase_order_detail` VALUES ('9', '4', '0', '', '25', '', '17', '', '', '0', '1.5', '0', null, '1433548800', '0', null, '1', '1433175660');
INSERT INTO `tbl_purchase_order_detail` VALUES ('10', '4', '0', '', '10', '', '16', '', '', '0', '2.5', '0', null, '1433548800', '0', null, '1', '1433175660');
INSERT INTO `tbl_purchase_order_detail` VALUES ('11', '5', '0', '1', '16', '', '26', '', '', '0', '16', '0', null, '1442880000', '0', null, '1', '1442330235');
INSERT INTO `tbl_purchase_order_detail` VALUES ('12', '6', '0', '1', '3', '', '28', '', '', '0', '425', '0', null, '1444348800', '0', null, '1', '1442407089');
INSERT INTO `tbl_purchase_order_detail` VALUES ('13', '6', '0', '2', '1', '', '27', '', '', '0', '450', '0', null, '1444348800', '0', null, '1', '1442407089');
INSERT INTO `tbl_purchase_order_detail` VALUES ('14', '6', '0', '3', '3', '', '29', '', '', '0', '345', '0', null, '1444348800', '0', null, '1', '0');
INSERT INTO `tbl_purchase_order_detail` VALUES ('15', '6', '0', '4', '1', '', '30', '', '', '0', '280', '0', null, '1444348800', '0', null, '1', '0');
INSERT INTO `tbl_purchase_order_detail` VALUES ('16', '7', '0', '1', '90', '', '31', '', '', '0', '5.5', '0', null, '1444608000', '0', null, '1', '1443529965');
INSERT INTO `tbl_purchase_order_detail` VALUES ('17', '8', '0', '1', '5', '', '32', '', '', '0', '435', '0', null, '1445558400', '0', null, '1', '1444692856');
INSERT INTO `tbl_purchase_order_detail` VALUES ('18', '9', '0', '1', '2', '', '37', '', '', '0', '300', '0', null, '1450224000', '0', null, '1', '1446512809');
INSERT INTO `tbl_purchase_order_detail` VALUES ('19', '9', '0', '2', '1', '', '38', '', '', '0', '300', '0', null, '1450224000', '0', null, '1', '1446512809');
INSERT INTO `tbl_purchase_order_detail` VALUES ('20', '9', '0', '3', '3', '', '25', '', '', '0', '345', '0', null, '1450224000', '0', null, '1', '1446512809');
INSERT INTO `tbl_purchase_order_detail` VALUES ('21', '10', '0', '1', '2', '', '37', '', '', '0', '300', '0', null, '1450224000', '0', null, '1', '1446512821');
INSERT INTO `tbl_purchase_order_detail` VALUES ('22', '10', '0', '2', '1', '', '38', '', '', '0', '300', '0', null, '1450224000', '0', null, '1', '1446512821');
INSERT INTO `tbl_purchase_order_detail` VALUES ('23', '10', '0', '3', '3', '', '25', '', '', '0', '345', '0', null, '1450224000', '0', null, '1', '1446512821');
INSERT INTO `tbl_purchase_order_detail` VALUES ('24', '11', '0', '1', '20', '', '39', '', '', '0', '250', '0', null, '1446768000', '0', null, '1', '1446836288');
INSERT INTO `tbl_purchase_order_detail` VALUES ('25', '12', '0', '1', '18', '', '39', '', '', '0', '250', '0', null, '1446768000', '0', null, '1', '1446836340');
INSERT INTO `tbl_purchase_order_detail` VALUES ('26', '13', '0', '1', '34', '', '41', '', '', '0', '95', '0', null, '1450828800', '0', null, '1', '1447808695');
INSERT INTO `tbl_purchase_order_detail` VALUES ('27', '13', '0', '2', '34', '', '40', '', '', '0', '115', '0', null, '1450828800', '0', null, '1', '1447808695');
INSERT INTO `tbl_purchase_order_detail` VALUES ('28', '14', '0', '1', '105', '', '42', '', '', '0', '21', '0', null, '1450828800', '0', null, '1', '1447855485');
INSERT INTO `tbl_purchase_order_detail` VALUES ('29', '14', '0', '2', '105', '', '43', '', '', '0', '15', '0', null, '1450828800', '0', null, '1', '1447855485');
INSERT INTO `tbl_purchase_order_detail` VALUES ('34', '15', '0', '1', '66', '', '48', '', '', '0', '48', '0', null, '1449532800', '0', null, '1', '1448470384');
INSERT INTO `tbl_purchase_order_detail` VALUES ('35', '16', '0', '1', '1', '', '50', '', '', '0', '300', '0', null, '1450224000', '0', null, '1', '1448486436');
INSERT INTO `tbl_purchase_order_detail` VALUES ('36', '16', '0', '2', '100', '', '50', '', '', '0', '39', '0', null, '1450224000', '0', null, '1', '1448486436');
INSERT INTO `tbl_purchase_order_detail` VALUES ('37', '16', '0', '3', '1', '', '49', '', '', '0', '900', '0', null, '1450224000', '0', null, '1', '1448486436');
INSERT INTO `tbl_purchase_order_detail` VALUES ('38', '16', '0', '4', '100', '', '49', '', '', '0', '48', '0', null, '1450224000', '0', null, '1', '1448486436');
INSERT INTO `tbl_purchase_order_detail` VALUES ('39', '17', '0', '1', '1', '', '50', '', '', '0', '300', '0', null, '1450224000', '0', null, '1', '1448487898');
INSERT INTO `tbl_purchase_order_detail` VALUES ('40', '17', '0', '2', '100', '', '50', '', '', '0', '39', '0', null, '1450224000', '0', null, '1', '1448487898');
INSERT INTO `tbl_purchase_order_detail` VALUES ('41', '17', '0', '3', '1', '', '49', '', '', '0', '960', '0', null, '1450224000', '0', null, '1', '1448487898');
INSERT INTO `tbl_purchase_order_detail` VALUES ('42', '17', '0', '4', '100', '', '49', '', '', '0', '52', '0', null, '1450224000', '0', null, '1', '1448487898');
INSERT INTO `tbl_purchase_order_detail` VALUES ('43', '18', '0', '1', '2', '', '51', '', '', '0', '245', '0', null, '1449532800', '0', null, '1', '1448559169');
INSERT INTO `tbl_purchase_order_detail` VALUES ('44', '18', '0', '2', '2', '', '52', '', '', '0', '370', '300', null, '1449532800', '0', null, '1', '1448559169');
INSERT INTO `tbl_purchase_order_detail` VALUES ('45', '18', '0', '3', '2', '', '53', '', '', '0', '140', '0', null, '1449532800', '0', null, '1', '0');
INSERT INTO `tbl_purchase_order_detail` VALUES ('47', '19', '0', '1', '35', '', '46', '', '', '0', '9.8', '0', null, '1449619200', '0', null, '1', '1448909773');
INSERT INTO `tbl_purchase_order_detail` VALUES ('48', '19', '0', '2', '35', '', '47', '', '', '0', '12.75', '0', null, '1449619200', '0', null, '1', '1448909773');
INSERT INTO `tbl_purchase_order_detail` VALUES ('49', '20', '0', '1', '2', '', '54', '', '', '0', '3', '0', null, '1450310400', '0', null, '1', '1449593199');
INSERT INTO `tbl_purchase_order_detail` VALUES ('50', '21', '0', '1', '1', '', '59', '', '', '0', '940', '0', null, '1452038400', '0', null, '1', '1449676050');
INSERT INTO `tbl_purchase_order_detail` VALUES ('51', '21', '0', '2', '1', '', '58', '', '', '0', '450', '0', null, '1452038400', '0', null, '1', '1449676050');
INSERT INTO `tbl_purchase_order_detail` VALUES ('52', '21', '0', '3', '3', '', '59', '', '', '0', '375', '0', null, '1452038400', '0', null, '1', '0');
INSERT INTO `tbl_purchase_order_detail` VALUES ('53', '21', '0', '4', '3', '', '58', '', '', '0', '175', '0', null, '1452038400', '0', null, '1', '0');
INSERT INTO `tbl_purchase_order_detail` VALUES ('56', '22', '0', '1', '1', '', '56', '', '', '0', '1990', '0', null, '1452038400', '0', null, '1', '1449678969');
INSERT INTO `tbl_purchase_order_detail` VALUES ('57', '22', '0', '2', '3', '', '56', '', '', '0', '910', '0', null, '1452038400', '0', null, '1', '1449678969');
INSERT INTO `tbl_purchase_order_detail` VALUES ('58', '23', '0', '1', '20', '', '63', '', '', '0', '33', '0', null, '1458864000', '0', null, '1', '1455295996');
INSERT INTO `tbl_purchase_order_detail` VALUES ('59', '23', '0', '2', '20', '', '64', '', '', '0', '23.65', '0', null, '1458864000', '0', null, '1', '1455295996');
INSERT INTO `tbl_purchase_order_detail` VALUES ('60', '23', '0', '3', '20', '', '62', '', '', '0', '16.7', '0', null, '1458864000', '0', null, '1', '1455295996');
INSERT INTO `tbl_purchase_order_detail` VALUES ('61', '24', null, '1', '20', null, '63', '', null, '0', '33', '0', null, '1458864000', '0', null, '1', '1455298455');
INSERT INTO `tbl_purchase_order_detail` VALUES ('62', '24', null, '2', '20', null, '64', '', null, '0', '23.65', '0', null, '1458864000', '0', null, '1', '1455298455');
INSERT INTO `tbl_purchase_order_detail` VALUES ('63', '24', null, '3', '20', null, '62', '', null, '0', '16.7', '0', null, '1458864000', '0', null, '1', '1455298455');
INSERT INTO `tbl_purchase_order_detail` VALUES ('64', '25', null, '1', '100', null, '63', '', null, '0', '18.9', '0', null, '1458864000', '0', null, '1', '1455298950');
INSERT INTO `tbl_purchase_order_detail` VALUES ('65', '25', null, '2', '100', null, '64', '', null, '0', '12.4', '0', null, '1458864000', '0', null, '1', '1455298950');
INSERT INTO `tbl_purchase_order_detail` VALUES ('66', '25', null, '3', '100', null, '62', '', null, '0', '8.5', '0', null, '1458864000', '0', null, '1', '1455298950');
INSERT INTO `tbl_purchase_order_detail` VALUES ('67', '26', null, '1', '100', null, '63', '', null, '0', '17', '0', null, '1458864000', '0', null, '1', '1455300624');
INSERT INTO `tbl_purchase_order_detail` VALUES ('68', '26', null, '2', '100', null, '64', '', null, '0', '17.7', '0', null, '1458864000', '0', null, '1', '1455300624');
INSERT INTO `tbl_purchase_order_detail` VALUES ('70', '27', null, '1', '500', null, '63', '', null, '0', '13.9', '0', null, '1458864000', '0', null, '1', '1455300996');
INSERT INTO `tbl_purchase_order_detail` VALUES ('71', '27', null, '2', '500', null, '64', '', null, '0', '8.3', '0', null, '1458864000', '0', null, '1', '1455300996');
INSERT INTO `tbl_purchase_order_detail` VALUES ('72', '27', null, '3', '500', null, '62', '', null, '0', '5.2', '0', null, '1458864000', '0', null, '1', '1455300996');
INSERT INTO `tbl_purchase_order_detail` VALUES ('73', '28', null, '1', '500', null, '63', '', null, '0', '13.9', '0', null, '1458864000', '0', null, '1', '1455301529');
INSERT INTO `tbl_purchase_order_detail` VALUES ('74', '28', null, '2', '500', null, '64', '', null, '0', '8.3', '0', null, '1458864000', '0', null, '1', '1455301529');
INSERT INTO `tbl_purchase_order_detail` VALUES ('75', '28', null, '3', '500', null, '62', '', null, '0', '5.2', '0', null, '1458864000', '0', null, '1', '1455301529');
INSERT INTO `tbl_purchase_order_detail` VALUES ('76', '29', null, '1', '500', null, '63', '', null, '0', '13.9', '0', null, '1458864000', '0', null, '1', '1455497619');
INSERT INTO `tbl_purchase_order_detail` VALUES ('77', '29', null, '2', '500', null, '64', '', null, '0', '8.3', '0', null, '1458864000', '0', null, '1', '1455497619');
INSERT INTO `tbl_purchase_order_detail` VALUES ('78', '29', null, '3', '500', null, '62', '', null, '0', '5.2', '0', null, '1458864000', '0', null, '1', '1455497619');
INSERT INTO `tbl_purchase_order_detail` VALUES ('79', '30', null, '1', '50', null, '63', '', null, '0', '19.5', '0', null, '1458864000', '0', null, '1', '1456433424');
INSERT INTO `tbl_purchase_order_detail` VALUES ('80', '30', null, '2', '50', null, '64', '', null, '0', '21.1', '0', null, '1458864000', '0', null, '1', '1456433424');
INSERT INTO `tbl_purchase_order_detail` VALUES ('81', '31', null, '1', '300', null, '63', '', null, '0', '13.3', '0', null, '1458864000', '0', null, '1', '1456499753');
INSERT INTO `tbl_purchase_order_detail` VALUES ('82', '31', null, '2', '300', null, '64', '', null, '0', '15.1', '0', null, '1458864000', '0', null, '1', '1456499753');
INSERT INTO `tbl_purchase_order_detail` VALUES ('84', '32', '0', '1', '4', '', '66', '', '', '0', '137.5', '0', null, '1458518400', '0', null, '1', '1457729775');
INSERT INTO `tbl_purchase_order_detail` VALUES ('85', '32', '0', '2', '8', '', '67', '', '', '0', '98.5', '0', null, '1458518400', '0', null, '1', '1457729775');
INSERT INTO `tbl_purchase_order_detail` VALUES ('86', '33', '0', '1', '2', '', '69', '', '', '0', '215', '0', null, '1459123200', '1459123200', null, '1', '1457794313');
INSERT INTO `tbl_purchase_order_detail` VALUES ('87', '33', '0', '2', '2', '', '68', '', '', '0', '370', '0', null, '1459123200', '1459123200', null, '1', '1457794313');
INSERT INTO `tbl_purchase_order_detail` VALUES ('88', '34', '0', '1', '1000', '', '75', '', '', '0', '1.75', '0', null, '1465516800', '0', null, '1', '1462397921');
INSERT INTO `tbl_purchase_order_detail` VALUES ('89', '34', '0', '2', '500', '', '76', '', '', '0', '10.3', '0', null, '1465516800', '0', null, '1', '1462397921');
INSERT INTO `tbl_purchase_order_detail` VALUES ('90', '34', '0', '3', '500', '', '77', '', '', '0', '3.1', '0', null, '1465516800', '0', null, '1', '1462397921');
INSERT INTO `tbl_purchase_order_detail` VALUES ('91', '34', '0', '3', '500', '', '74', '', '', '0', '4.55', '0', null, '1465516800', '0', null, '1', '1462397921');
INSERT INTO `tbl_purchase_order_detail` VALUES ('92', '34', '0', '4', '500', '', '73', '', '', '0', '2.75', '0', null, '1465516800', '0', null, '1', '1462397921');
INSERT INTO `tbl_purchase_order_detail` VALUES ('93', '34', '0', '5', '500', '', '71', '', '', '0', '6.65', '0', null, '1465516800', '0', null, '1', '1462397921');
INSERT INTO `tbl_purchase_order_detail` VALUES ('94', '34', '0', '6', '500', '', '72', '', '', '0', '3.35', '0', null, '1465516800', '0', null, '1', '1462397921');
INSERT INTO `tbl_purchase_order_detail` VALUES ('95', '34', '0', '7', '500', '', '70', '', '', '0', '7.9', '0', null, '1465516800', '0', null, '1', '1462397921');
INSERT INTO `tbl_purchase_order_detail` VALUES ('96', '35', '0', '1', '500', '', '88', '', '', '0', '27.52', '0', null, '1466726400', '0', null, '1', '1462452972');
INSERT INTO `tbl_purchase_order_detail` VALUES ('97', '35', '0', '2', '500', '', '90', '', '', '0', '40.9', '0', null, '1466726400', '0', null, '1', '1462452972');
INSERT INTO `tbl_purchase_order_detail` VALUES ('98', '35', '0', '3', '500', '', '87', '', '', '0', '19.6', '0', null, '1466726400', '0', null, '1', '1462452972');
INSERT INTO `tbl_purchase_order_detail` VALUES ('99', '35', '0', '4', '500', '', '86', '', '', '0', '17.85', '0', null, '1466726400', '0', null, '1', '1462452972');
INSERT INTO `tbl_purchase_order_detail` VALUES ('100', '35', '0', '5', '500', '', '89', '', '', '0', '33.6', '0', null, '1466726400', '0', null, '1', '1462452972');
INSERT INTO `tbl_purchase_order_detail` VALUES ('101', '36', '0', '1', '500', '', '81', '', '', '0', '4.85', '0', null, '1466726400', '0', null, '1', '1462453725');
INSERT INTO `tbl_purchase_order_detail` VALUES ('102', '36', '0', '2', '500', '', '82', '', '', '0', '2.5', '0', null, '1466726400', '0', null, '1', '1462453725');
INSERT INTO `tbl_purchase_order_detail` VALUES ('103', '36', '0', '3', '500', '', '85', '', '', '0', '6.3', '0', null, '1466726400', '0', null, '1', '1462453725');
INSERT INTO `tbl_purchase_order_detail` VALUES ('104', '36', '0', '4', '500', '', '80', '', '', '0', '8.9', '0', null, '1466726400', '0', null, '1', '1462453725');
INSERT INTO `tbl_purchase_order_detail` VALUES ('105', '37', null, '1', '10', null, '88', '', null, '0', '55', '0', null, '1464912000', '0', null, '1', '1462562411');
INSERT INTO `tbl_purchase_order_detail` VALUES ('106', '37', null, '2', '10', null, '90', '', null, '0', '68.25', '0', null, '1464912000', '0', null, '1', '1462562411');
INSERT INTO `tbl_purchase_order_detail` VALUES ('107', '37', null, '3', '10', null, '87', '', null, '0', '46.1', '0', null, '1464912000', '0', null, '1', '1462562411');
INSERT INTO `tbl_purchase_order_detail` VALUES ('108', '37', null, '4', '10', null, '86', '', null, '0', '45.1', '0', null, '1464912000', '0', null, '1', '1462562411');
INSERT INTO `tbl_purchase_order_detail` VALUES ('109', '37', null, '5', '10', null, '89', '', null, '0', '60.8', '0', null, '1464912000', '0', null, '1', '1462562411');
INSERT INTO `tbl_purchase_order_detail` VALUES ('110', '38', null, '1', '10', null, '75', '', null, '0', '16.5', '0', null, '1465516800', '0', null, '1', '1462565988');
INSERT INTO `tbl_purchase_order_detail` VALUES ('111', '38', null, '2', '10', null, '76', '', null, '0', '47.25', '0', null, '1465516800', '0', null, '1', '1462565988');
INSERT INTO `tbl_purchase_order_detail` VALUES ('112', '38', null, '3', '10', null, '77', '', null, '0', '28.5', '0', null, '1465516800', '0', null, '1', '1462565988');
INSERT INTO `tbl_purchase_order_detail` VALUES ('113', '38', null, '3', '10', null, '74', '', null, '0', '32.9', '0', null, '1465516800', '0', null, '1', '1462565988');
INSERT INTO `tbl_purchase_order_detail` VALUES ('114', '38', null, '4', '10', null, '73', '', null, '0', '23.75', '0', null, '1465516800', '0', null, '1', '1462565988');
INSERT INTO `tbl_purchase_order_detail` VALUES ('115', '38', null, '5', '10', null, '71', '', null, '0', '34.65', '0', null, '1465516800', '0', null, '1', '1462565988');
INSERT INTO `tbl_purchase_order_detail` VALUES ('116', '38', null, '6', '10', null, '72', '', null, '0', '24.3', '0', null, '1465516800', '0', null, '1', '1462565988');
INSERT INTO `tbl_purchase_order_detail` VALUES ('117', '38', null, '7', '10', null, '70', '', null, '0', '42.15', '0', null, '1465516800', '0', null, '1', '1462565988');
INSERT INTO `tbl_purchase_order_detail` VALUES ('118', '39', null, '1', '10', null, '81', '', null, '0', '34.5', '0', null, '1466726400', '0', null, '1', '1462627445');
INSERT INTO `tbl_purchase_order_detail` VALUES ('119', '39', null, '2', '10', null, '82', '', null, '0', '24.65', '0', null, '1466726400', '0', null, '1', '1462627445');
INSERT INTO `tbl_purchase_order_detail` VALUES ('120', '39', null, '3', '10', null, '85', '', null, '0', '38.47', '0', null, '1466726400', '0', null, '1', '1462627445');
INSERT INTO `tbl_purchase_order_detail` VALUES ('121', '39', null, '4', '10', null, '80', '', null, '0', '58.67', '0', null, '1466726400', '0', null, '1', '1462627445');
INSERT INTO `tbl_purchase_order_detail` VALUES ('122', '40', '0', '1', '500', '', '104', '', '', '0', '15.55', '0', null, '1463702400', '0', null, '1', '1463244506');
INSERT INTO `tbl_purchase_order_detail` VALUES ('123', '40', '0', '2', '500', '', '102', '', '', '0', '19.2', '0', null, '1463702400', '0', null, '1', '1463244506');
INSERT INTO `tbl_purchase_order_detail` VALUES ('124', '40', '0', '3', '500', '', '100', '', '', '0', '16.75', '0', null, '1463702400', '0', null, '1', '1463244506');
INSERT INTO `tbl_purchase_order_detail` VALUES ('125', '40', '0', '4', '500', '', '98', '', '', '0', '16.85', '0', null, '1463702400', '0', null, '1', '1463244506');
INSERT INTO `tbl_purchase_order_detail` VALUES ('126', '40', '0', '5', '500', '', '96', '', '', '0', '13.8', '0', null, '1463702400', '0', null, '1', '1463244506');
INSERT INTO `tbl_purchase_order_detail` VALUES ('127', '40', '0', '6', '500', '', '94', '', '', '0', '12.9', '0', null, '1463702400', '0', null, '1', '1463244506');
INSERT INTO `tbl_purchase_order_detail` VALUES ('128', '41', null, '1', '500', null, '103', '', null, '0', '22', '0', null, '1463702400', '0', null, '1', '1463244822');
INSERT INTO `tbl_purchase_order_detail` VALUES ('129', '41', null, '2', '500', null, '101', '', null, '0', '29', '0', null, '1463702400', '0', null, '1', '1463244822');
INSERT INTO `tbl_purchase_order_detail` VALUES ('130', '41', null, '3', '500', null, '99', '', null, '0', '22.5', '0', null, '1463702400', '0', null, '1', '1463244822');
INSERT INTO `tbl_purchase_order_detail` VALUES ('131', '41', null, '4', '500', null, '97', '', null, '0', '20', '0', null, '1463702400', '0', null, '1', '1463244822');
INSERT INTO `tbl_purchase_order_detail` VALUES ('132', '41', null, '5', '500', null, '95', '', null, '0', '25', '0', null, '1463702400', '0', null, '1', '1463244822');
INSERT INTO `tbl_purchase_order_detail` VALUES ('133', '41', null, '6', '500', null, '93', '', null, '0', '22', '0', null, '1463702400', '0', null, '1', '1463244822');
INSERT INTO `tbl_purchase_order_detail` VALUES ('134', '42', null, '1', '10', null, '103', '', null, '0', '103', '0', null, '1463702400', '0', null, '1', '1463245122');
INSERT INTO `tbl_purchase_order_detail` VALUES ('135', '42', null, '2', '10', null, '101', '', null, '0', '123.5', '0', null, '1463702400', '0', null, '1', '1463245122');
INSERT INTO `tbl_purchase_order_detail` VALUES ('136', '42', null, '3', '10', null, '99', '', null, '0', '87', '0', null, '1463702400', '0', null, '1', '1463245122');
INSERT INTO `tbl_purchase_order_detail` VALUES ('137', '42', null, '4', '10', null, '97', '', null, '0', '94', '0', null, '1463702400', '0', null, '1', '1463245122');
INSERT INTO `tbl_purchase_order_detail` VALUES ('138', '42', null, '5', '10', null, '95', '', null, '0', '72.5', '0', null, '1463702400', '0', null, '1', '1463245122');
INSERT INTO `tbl_purchase_order_detail` VALUES ('139', '42', null, '6', '10', null, '93', '', null, '0', '77', '0', null, '1463702400', '0', null, '1', '1463245122');

-- ----------------------------
-- Table structure for tbl_purchase_order_file
-- ----------------------------
DROP TABLE IF EXISTS `tbl_purchase_order_file`;
CREATE TABLE `tbl_purchase_order_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_order_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of tbl_purchase_order_file
-- ----------------------------
INSERT INTO `tbl_purchase_order_file` VALUES ('1', '13', '133');
INSERT INTO `tbl_purchase_order_file` VALUES ('2', '13', '134');
INSERT INTO `tbl_purchase_order_file` VALUES ('3', '36', '235');
INSERT INTO `tbl_purchase_order_file` VALUES ('4', '39', '235');
INSERT INTO `tbl_purchase_order_file` VALUES ('5', '40', '246');
INSERT INTO `tbl_purchase_order_file` VALUES ('6', '41', '246');
INSERT INTO `tbl_purchase_order_file` VALUES ('7', '42', '246');

-- ----------------------------
-- Table structure for tbl_purchase_order_item
-- ----------------------------
DROP TABLE IF EXISTS `tbl_purchase_order_item`;
CREATE TABLE `tbl_purchase_order_item` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `purchase_order_id` int(11) unsigned NOT NULL,
  `item_name` varchar(256) NOT NULL,
  `quantity` int(11) unsigned NOT NULL,
  `price` float unsigned NOT NULL,
  `status` tinyint(2) unsigned DEFAULT NULL,
  `created_time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=319 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_purchase_order_item
-- ----------------------------
INSERT INTO `tbl_purchase_order_item` VALUES ('1', '3', 'Add order item 1', '5', '25.78', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('2', '3', 'Order Item A2', '2', '30.6', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('3', '11', 'MATERIAL(C Channel)', '1', '900', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('4', '11', 'Material(flat STK)', '1', '240', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('5', '11', 'WELDING', '18', '20', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('6', '11', 'MATERIAL(C Channel)', '1', '900', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('7', '11', 'Material(flat STK)', '1', '240', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('8', '11', 'WELDING', '18', '20', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('9', '16', '1PC 4140 SHAFT PROTOTYPE MATERIAL', '1', '120', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('10', '16', '100PCS 4140 SHAFT MATERIAL', '1', '9700', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('11', '16', '1PC C1045 PROTOTYPE MATERIAL', '1', '30', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('12', '16', '100PCS C1045 MATERIAL', '1', '1100', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('13', '16', '1PC 4140 SHAFT PROTOTYPE MATERIAL', '1', '120', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('14', '16', '100PCS 4140 SHAFT MATERIAL', '1', '9700', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('15', '16', '1PC C1045 PROTOTYPE MATERIAL', '1', '30', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('16', '16', '100PCS C1045 MATERIAL', '1', '1100', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('48', '4', 'Order Item A3', '1', '310', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('50', '21', 'CHROME PLATING', '1', '2120', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('72', '24', '5/16 SS Ball', '20', '0.6', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('73', '24', 'O-Ring Spaenaur #320-117', '20', '3.9', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('74', '24', 'O-Ring Spaenaur #320-132', '20', '4.25', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('75', '24', '1/4 x 2.0\"lng Spring Pin', '20', '1.2', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('76', '24', '1/4\" x .625\"lng Spring Pin', '20', '0.8', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('77', '24', '1/4 x 2.0\"lng Hardened Dowel', '20', '1.3', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('78', '24', 'Elastomeric Spring Shore 80 - 5/32', '20', '0.001', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('79', '24', 'Assembly FEE', '20', '2.6', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('88', '25', '5/16 SS Ball', '100', '0.6', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('89', '25', 'O-Ring Spaenaur #320-117', '100', '0.8', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('90', '25', 'O-Ring Spaenaur #320-132', '100', '1.5', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('91', '25', '1/4 x 2.0\"lng Spring Pin', '100', '0.27', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('92', '25', '1/4\" x .625\"lng Spring Pin', '100', '0.17', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('93', '25', '1/4 x 2.0\"lng Hardened Dowel', '100', '0.28', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('94', '25', 'Elastomeric Spring Shore 80 - 5/32', '100', '0', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('95', '25', 'Assembly FEE', '100', '2.6', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('132', '27', '5/16 SS Ball', '500', '0.6', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('133', '27', 'O-Ring Spaenaur #320-117', '500', '0.8', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('134', '27', 'O-Ring Spaenaur #320-132', '500', '1.4', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('135', '27', '1/4 x 2.0\"lng Spring Pin', '500', '0.27', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('136', '27', '1/4\" x .625\"lng Spring Pin', '500', '0.17', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('137', '27', '1/4 x 2.0\"lng Hardened Dowel', '500', '0.28', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('138', '27', 'Elastomeric Spring Shore 80 - 5/32', '500', '0', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('186', '28', '5/16 SS Ball', '500', '0.6', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('187', '28', 'O-Ring Spaenaur #320-117', '500', '0.8', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('188', '28', 'O-Ring Spaenaur #320-132', '500', '1.4', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('189', '28', '1/4 x 2.0\"lng Spring Pin', '500', '0.27', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('190', '28', '1/4\" x .625\"lng Spring Pin', '500', '0.17', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('191', '28', '1/4 x 2.0\"lng Hardened Dowel', '500', '0.28', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('192', '28', 'Assembly FEE', '250', '2.6', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('193', '28', 'Assembly FEE', '250', '2.6', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('194', '28', 'Elastomeric Spring - Shore80 5/32', '500', '0', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('209', '29', '5/16 SS Ball', '500', '0.6', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('210', '29', 'O-Ring Spaenaur #320-117', '500', '0.8', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('211', '29', 'O-Ring Spaenaur #320-132', '500', '1.4', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('212', '29', '1/4 x 2.0\"lng Spring Pin', '500', '0.27', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('213', '29', '1/4\" x .625\"lng Spring Pin', '500', '0.17', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('214', '29', '1/4 x 2.0\"lng Hardened Dowel', '500', '0.28', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('215', '29', 'Elastomeric Spring Shore 80 - 5/32', '500', '0', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('216', '23', '5/16 SS Ball', '20', '0.6', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('217', '23', 'O-Ring Spaenaur #320-117', '20', '3.9', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('218', '23', 'O-Ring Spaenaur #320-132', '20', '4.25', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('219', '23', '1/4\" x .625\"lng Spring Pin', '20', '0.8', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('220', '23', '1/4 x 2.0\"lng Hardened Dowel', '20', '1.3', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('221', '23', 'Elastomeric Spring Shore 80 - 5/16', '20', '3', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('288', '30', '5/16 SS Ball', '50', '0.18', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('289', '30', 'O-Ring Spaenaur #320-117', '50', '1.6', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('290', '30', 'O-Ring Spaenaur #320-132', '50', '1.5', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('291', '30', '1/4\" x .625\"lng Spring Pin', '50', '0.05', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('292', '30', '1/4 x 2.0\"lng Hardened Dowel', '50', '0.28', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('293', '30', 'Elastomeric Spring Shore 80 - 5/32', '50', '1.2', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('294', '26', '5/16 SS Ball', '100', '0.18', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('295', '26', 'O-Ring Spaenaur #320-117', '100', '0.8', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('296', '26', 'O-Ring Spaenaur #320-132', '100', '1.5', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('297', '26', '1/4\" x .625\"lng Spring Pin', '100', '0.05', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('298', '26', '1/4 x 2.0\"lng Hardened Dowel', '100', '0.28', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('299', '26', 'Elastomeric Spring Shore 80 - 5/32', '100', '0.6', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('313', '31', '5/16 SS Ball', '300', '0.14', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('314', '31', 'O-Ring Spaenaur #320-117', '300', '0.76', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('315', '31', 'O-Ring Spaenaur #320-132', '300', '1.12', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('316', '31', '1/4\" x .625\"lng Spring Pin', '300', '0.05', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('317', '31', '1/4 x 2.0\"lng Hardened Dowel', '300', '0.28', '1', null);
INSERT INTO `tbl_purchase_order_item` VALUES ('318', '31', 'Elastomeric Spring Shore 80 - 5/32', '300', '0.2', '1', null);

-- ----------------------------
-- Table structure for tbl_setting
-- ----------------------------
DROP TABLE IF EXISTS `tbl_setting`;
CREATE TABLE `tbl_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` tinyint(1) NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(8000) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of tbl_setting
-- ----------------------------
INSERT INTO `tbl_setting` VALUES ('1', '1', 'TAX', '15', 'Default tax value');
INSERT INTO `tbl_setting` VALUES ('2', '1', 'SYSTEM_EMAIL', 'Office@amprecision.ca', '');
INSERT INTO `tbl_setting` VALUES ('3', '1', 'SYSTEM_EMAIL_CC', 'system@ampocs.com,hungtn87@gmail.com,thanhnambkhn@gmail.com,namnt@ihbvietnam.com', '');

-- ----------------------------
-- Table structure for tbl_shape
-- ----------------------------
DROP TABLE IF EXISTS `tbl_shape`;
CREATE TABLE `tbl_shape` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `image_id` int(11) NOT NULL,
  `sizes` varchar(255) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `created_time` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=armscii8;

-- ----------------------------
-- Records of tbl_shape
-- ----------------------------
INSERT INTO `tbl_shape` VALUES ('1', 'Hexagonal Bar', '87', '[\"size\"]', '1', '1');
INSERT INTO `tbl_shape` VALUES ('2', 'Square Bar', '81', '[\"w\",\"h\"]', '1', '1');
INSERT INTO `tbl_shape` VALUES ('3', 'Rectangular Bar', '82', '[\"w\",\"h\"]', '1', '1');
INSERT INTO `tbl_shape` VALUES ('4', 'Round Bar', '83', '[\"od\"]', '1', '1');
INSERT INTO `tbl_shape` VALUES ('7', 'Cast Bar', '91', '[\"w\",\"h\"]', '1', '1430876780');
INSERT INTO `tbl_shape` VALUES ('8', 'Tabular Bar', '92', '[\"od\",\"id\"]', '1', '1430876822');

-- ----------------------------
-- Table structure for tbl_state
-- ----------------------------
DROP TABLE IF EXISTS `tbl_state`;
CREATE TABLE `tbl_state` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT COMMENT 'State ID',
  `status` tinyint(1) NOT NULL,
  `state_short` varchar(100) NOT NULL COMMENT 'State short name',
  `state_full` varchar(100) NOT NULL COMMENT 'State full name',
  `country_short` varchar(100) NOT NULL COMMENT 'Country short name',
  `country_full` varchar(100) NOT NULL COMMENT 'Country full name',
  `seasonal_cpm_change` int(3) NOT NULL COMMENT 'Seasonal CPM % change',
  PRIMARY KEY (`id`),
  UNIQUE KEY `state_short` (`state_short`,`state_full`),
  KEY `country_short` (`country_short`,`country_full`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_state
-- ----------------------------
INSERT INTO `tbl_state` VALUES ('1', '1', 'Alabama', 'Alabama', 'US', 'US', '5');
INSERT INTO `tbl_state` VALUES ('2', '1', 'Arkansas', 'Arkansas', 'US', 'US', '10');
INSERT INTO `tbl_state` VALUES ('3', '1', 'Arizona', 'Arizona', 'US', 'US', '15');
INSERT INTO `tbl_state` VALUES ('4', '1', 'North California', 'North California', 'US', 'US', '5');
INSERT INTO `tbl_state` VALUES ('5', '1', 'South California', 'South California', 'US', 'US', '10');
INSERT INTO `tbl_state` VALUES ('6', '1', 'Colorado', 'Colorado', 'US', 'US', '15');
INSERT INTO `tbl_state` VALUES ('7', '1', 'Connecticut', 'Connecticut', 'US', 'US', '5');
INSERT INTO `tbl_state` VALUES ('8', '1', 'Delaware', 'Delaware', 'US', 'US', '10');
INSERT INTO `tbl_state` VALUES ('9', '1', 'North Florida', 'North Florida', 'US', 'US', '15');
INSERT INTO `tbl_state` VALUES ('10', '1', 'South Florida', 'South Florida', 'US', 'US', '5');
INSERT INTO `tbl_state` VALUES ('11', '1', 'Georgia', 'Georgia', 'US', 'US', '10');
INSERT INTO `tbl_state` VALUES ('12', '1', 'Iowa', 'Iowa', 'US', 'US', '15');
INSERT INTO `tbl_state` VALUES ('13', '1', 'Idaho', 'Idaho', 'US', 'US', '5');
INSERT INTO `tbl_state` VALUES ('14', '1', 'Illinois', 'Illinois', 'US', 'US', '10');
INSERT INTO `tbl_state` VALUES ('15', '1', 'Indiana', 'Indiana', 'US', 'US', '15');
INSERT INTO `tbl_state` VALUES ('16', '1', 'Kansas', 'Kansas', 'US', 'US', '5');
INSERT INTO `tbl_state` VALUES ('17', '1', 'Kentucky', 'Kentucky', 'US', 'US', '10');
INSERT INTO `tbl_state` VALUES ('18', '1', 'Louisiana', 'Louisiana', 'US', 'US', '15');
INSERT INTO `tbl_state` VALUES ('19', '1', 'Massachusetts', 'Massachusetts', 'US', 'US', '5');
INSERT INTO `tbl_state` VALUES ('20', '1', 'Maryland', 'Maryland', 'US', 'US', '10');
INSERT INTO `tbl_state` VALUES ('21', '1', 'Maine', 'Maine', 'US', 'US', '15');
INSERT INTO `tbl_state` VALUES ('22', '1', 'Michigan', 'Michigan', 'US', 'US', '5');
INSERT INTO `tbl_state` VALUES ('23', '1', 'Minnesota', 'Minnesota', 'US', 'US', '10');
INSERT INTO `tbl_state` VALUES ('24', '1', 'Missouri', 'Missouri', 'US', 'US', '15');
INSERT INTO `tbl_state` VALUES ('25', '1', 'Mississippi', 'Mississippi', 'US', 'US', '5');
INSERT INTO `tbl_state` VALUES ('26', '1', 'Montana', 'Montana', 'US', 'US', '10');
INSERT INTO `tbl_state` VALUES ('27', '1', 'North Carolina', 'North Carolina', 'US', 'US', '15');
INSERT INTO `tbl_state` VALUES ('28', '1', 'North Dakota', 'North Dakota', 'US', 'US', '5');
INSERT INTO `tbl_state` VALUES ('29', '1', 'Nebraska', 'Nebraska', 'US', 'US', '10');
INSERT INTO `tbl_state` VALUES ('30', '1', 'New Hampshire', 'New Hampshire', 'US', 'US', '15');
INSERT INTO `tbl_state` VALUES ('31', '1', 'New Jersey', 'New Jersey', 'US', 'US', '5');
INSERT INTO `tbl_state` VALUES ('32', '1', 'New Mexico', 'New Mexico', 'US', 'US', '10');
INSERT INTO `tbl_state` VALUES ('33', '1', 'Nevada', 'Nevada', 'US', 'US', '15');
INSERT INTO `tbl_state` VALUES ('34', '1', 'New York', 'New York', 'US', 'US', '5');
INSERT INTO `tbl_state` VALUES ('35', '1', 'Ohio', 'Ohio', 'US', 'US', '10');
INSERT INTO `tbl_state` VALUES ('36', '1', 'Oklahoma', 'Oklahoma', 'US', 'US', '15');
INSERT INTO `tbl_state` VALUES ('37', '1', 'Oregon', 'Oregon', 'US', 'US', '5');
INSERT INTO `tbl_state` VALUES ('38', '1', 'Pennsylvania', 'Pennsylvania', 'US', 'US', '10');
INSERT INTO `tbl_state` VALUES ('39', '1', 'Rhode Island', 'Rhode Island', 'US', 'US', '15');
INSERT INTO `tbl_state` VALUES ('40', '1', 'South Carolina', 'South Carolina', 'US', 'US', '5');
INSERT INTO `tbl_state` VALUES ('41', '1', 'South Dakota', 'South Dakota', 'US', 'US', '10');
INSERT INTO `tbl_state` VALUES ('42', '1', 'Tennessee', 'Tennessee', 'US', 'US', '15');
INSERT INTO `tbl_state` VALUES ('43', '1', 'East/South Texas', 'East/South Texas', 'US', 'US', '5');
INSERT INTO `tbl_state` VALUES ('44', '1', 'West Texas', 'West Texas', 'US', 'US', '10');
INSERT INTO `tbl_state` VALUES ('45', '1', 'Utah', 'Utah', 'US', 'US', '15');
INSERT INTO `tbl_state` VALUES ('46', '1', 'Virginia', 'Virginia', 'US', 'US', '5');
INSERT INTO `tbl_state` VALUES ('47', '1', 'Vermont', 'Vermont', 'US', 'US', '10');
INSERT INTO `tbl_state` VALUES ('48', '1', 'Washington', 'Washington', 'US', 'US', '15');
INSERT INTO `tbl_state` VALUES ('49', '1', 'Wisconsin', 'Wisconsin', 'US', 'US', '5');
INSERT INTO `tbl_state` VALUES ('50', '1', 'West Virginia', 'West Virginia', 'US', 'US', '10');
INSERT INTO `tbl_state` VALUES ('51', '1', 'Wyoming', 'Wyoming', 'US', 'US', '15');
INSERT INTO `tbl_state` VALUES ('52', '1', 'Alberta', 'Alberta', 'CA', 'CA', '5');
INSERT INTO `tbl_state` VALUES ('53', '1', 'British Columbia', 'British Columbia', 'CA', 'CA', '10');
INSERT INTO `tbl_state` VALUES ('54', '1', 'Manitoba', 'Manitoba', 'CA', 'CA', '15');
INSERT INTO `tbl_state` VALUES ('55', '1', 'New Brunswick', 'New Brunswick', 'CA', 'CA', '5');
INSERT INTO `tbl_state` VALUES ('56', '1', 'Newfoundland and Labrador', 'Newfoundland and Labrador', 'CA', 'CA', '10');
INSERT INTO `tbl_state` VALUES ('57', '1', 'Nova Scotia', 'Nova Scotia', 'CA', 'CA', '15');
INSERT INTO `tbl_state` VALUES ('58', '1', 'Northwest Territories', 'Northwest Territories', 'CA', 'CA', '5');
INSERT INTO `tbl_state` VALUES ('59', '1', 'Ontario', 'Ontario', 'CA', 'CA', '10');
INSERT INTO `tbl_state` VALUES ('60', '1', 'Prince Edward Island', 'Prince Edward Island', 'CA', 'CA', '15');
INSERT INTO `tbl_state` VALUES ('61', '1', 'Quebec', 'Quebec', 'CA', 'CA', '5');
INSERT INTO `tbl_state` VALUES ('62', '1', 'Saskatchewan', 'Saskatchewan', 'CA', 'CA', '10');
INSERT INTO `tbl_state` VALUES ('63', '1', 'Yukon', 'Yukon', 'CA', 'CA', '15');

-- ----------------------------
-- Table structure for tbl_store
-- ----------------------------
DROP TABLE IF EXISTS `tbl_store`;
CREATE TABLE `tbl_store` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `contact_name` varchar(50) NOT NULL,
  `franchisee_name` varchar(50) NOT NULL,
  `address1` varchar(1024) NOT NULL,
  `address2` varchar(1024) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state_id` int(11) NOT NULL,
  `zipcode` varchar(255) NOT NULL,
  `country` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `fax` varchar(20) DEFAULT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `created_time` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_store
-- ----------------------------
INSERT INTO `tbl_store` VALUES ('1', 'Phil', 'Philip Kul', 'Ball Media', 'LA, US', '', '', '0', '', 'US', 'phil@example.com', '123', '1212112', '1', '1426097092');
INSERT INTO `tbl_store` VALUES ('2', 'CUSTOMER1 TEST', 'JOHN TEST', 'CUSTOMER TEST COMPANY', '202-446 grey st', '', 'Brantford', '59', 'N3S 7L6', 'Canada', 'c1@ballmedia.com', '5197550853', '5197568641', '1', '1429086792');
INSERT INTO `tbl_store` VALUES ('3', 'HungTN', 'Hung', 'HVD companry', 'Hanoi VN', '', 'Hanoi', '2', '100000', 'US', 'hungtn87@gmail.com', '0909098788989', '9987978', '1', '1430448573');
INSERT INTO `tbl_store` VALUES ('4', 'GFW', 'DAN HERTEIS', 'GFW TECHNOLOGIES INC.', '485 Conestoga Blvd.', '', 'Cambridge', '59', 'N1R 7P4', 'Canada', 'dherteis@gfw.ca', '519-740-8680', '519-740-7658', '1', '1442329851');
INSERT INTO `tbl_store` VALUES ('5', 'SNS INDUSTRIAL', 'CINDY HANDCOCK', 'SNS INDUSTRIAL GROUP', '142 Sugar Maple Rd.', '', 'St. George', '59', 'N0E 1N0', 'Canada', 'cindy.hancock@snsindustrial.com', '(519) 448-3055', '519-448-3060', '1', '1442406741');
INSERT INTO `tbl_store` VALUES ('6', 'GFW', 'Daniel Adam', 'GWF TECHNOLOGIES', '485 Conestoga Boulevard', '', 'Cambridge', '59', 'N1P 7P4', 'Canada', 'dadam@gfw.ca', '519-740-8680', '519-740-7658', '1', '1443875474');
INSERT INTO `tbl_store` VALUES ('7', 'Morrow Crane', 'Jason Stewart', 'Morrow Crane', '', '', 'Brantford', '59', '', 'Canada', '', '', '', '1', '1446835918');
INSERT INTO `tbl_store` VALUES ('8', 'Kuriyama Canada Inc.', 'Walter Vogt', 'Kuriyama Canada Inc.', '140 Roy Blvd.', '', 'Brantford', '59', 'N35 7W9', 'Canada', 'kciwalt@kuritech.com', '519-759-1673  x114', '519-759-7478', '1', '1448410429');
INSERT INTO `tbl_store` VALUES ('9', 'SNS INDUSTRIAL (SAM)', 'Sam Sheets', 'SNS INDUSTRIAL', '142 Sugar Maple Rd.', '', 'St. George', '59', 'N0E 1N0', 'Canada', 'sam.sheets@snsindustrial.com', '(519) 448-3055', '519-448-3060', '1', '1448452013');
INSERT INTO `tbl_store` VALUES ('10', 'DOMITE', 'Chris Otway', 'DOMITE (MMI)', '20 Lee Ave.', '', 'Paris', '59', 'N3L 3T6', 'Canada', 'chris@domite.com', '519-442-3129   Cell ', '519-442-2604', '1', '1455293223');
INSERT INTO `tbl_store` VALUES ('11', 'SOLARSHIP INC', 'Andrew Bezkorow', 'SOLARSHIP INC', '175 Aviation Avenue,  Brantford Municipal Airport', '', 'Brantford', '59', 'N3T 5L7', 'Canada', 'abezkorow@solarship.com', '519-751-2590', '', '1', '1457728744');
INSERT INTO `tbl_store` VALUES ('12', 'Redetec (David L)', 'David Laciak', 'Redetec Inc.', '442-T DUFFERIN STREET', '', 'TORONTO', '59', 'M6K 2A3', 'CANADA', 'david@redetec.com', '416-788-2403', '', '1', '1462294139');
INSERT INTO `tbl_store` VALUES ('13', 'Reynolds', 'Don Reynolds', 'Reynolds Custom Machine', '155 Sugar Maple Rd.', '', 'St. George', '59', 'N0E 1N0', 'Canada', 'don@reynoldsmachine.ca', '519-448-1180', '519-448-1006', '1', '1469461499');
INSERT INTO `tbl_store` VALUES ('14', 'North Robotics', 'Allan Hendry', 'North Robotics', '1731 Mortimer St.', '', 'Vancouver', '53', 'V8P 3AP', 'Canada', 'ahendry@northrobotics.com', '250-508-7037', '', '1', '1472745027');

-- ----------------------------
-- Table structure for tbl_store_file
-- ----------------------------
DROP TABLE IF EXISTS `tbl_store_file`;
CREATE TABLE `tbl_store_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_store_file` (`store_id`,`file_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of tbl_store_file
-- ----------------------------

-- ----------------------------
-- Table structure for tbl_tier
-- ----------------------------
DROP TABLE IF EXISTS `tbl_tier`;
CREATE TABLE `tbl_tier` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `created_time` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=armscii8;

-- ----------------------------
-- Records of tbl_tier
-- ----------------------------
INSERT INTO `tbl_tier` VALUES ('1', 'mm', '1', '6');
INSERT INTO `tbl_tier` VALUES ('2', 'lb', '1', '6');
INSERT INTO `tbl_tier` VALUES ('3', 'each', '1', '1428316533');
INSERT INTO `tbl_tier` VALUES ('4', 'feet', '1', '1428336262');
INSERT INTO `tbl_tier` VALUES ('5', 'inches', '1', '1428336295');

-- ----------------------------
-- Table structure for tbl_uol
-- ----------------------------
DROP TABLE IF EXISTS `tbl_uol`;
CREATE TABLE `tbl_uol` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `created_time` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=armscii8;

-- ----------------------------
-- Records of tbl_uol
-- ----------------------------
INSERT INTO `tbl_uol` VALUES ('1', 'inches', '1', '1429592215');
INSERT INTO `tbl_uol` VALUES ('2', 'feet', '1', '1429592225');

-- ----------------------------
-- Table structure for tbl_uom
-- ----------------------------
DROP TABLE IF EXISTS `tbl_uom`;
CREATE TABLE `tbl_uom` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `created_time` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=armscii8;

-- ----------------------------
-- Records of tbl_uom
-- ----------------------------
INSERT INTO `tbl_uom` VALUES ('1', 'mm', '1', '6');
INSERT INTO `tbl_uom` VALUES ('2', 'lb', '1', '6');
INSERT INTO `tbl_uom` VALUES ('3', 'each', '1', '1428316533');
INSERT INTO `tbl_uom` VALUES ('4', 'feet', '1', '1428336262');
INSERT INTO `tbl_uom` VALUES ('5', 'inches', '1', '1428336295');

-- ----------------------------
-- Table structure for tbl_uoq
-- ----------------------------
DROP TABLE IF EXISTS `tbl_uoq`;
CREATE TABLE `tbl_uoq` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `created_time` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=armscii8;

-- ----------------------------
-- Records of tbl_uoq
-- ----------------------------
INSERT INTO `tbl_uoq` VALUES ('1', 'mm', '1', '9');
INSERT INTO `tbl_uoq` VALUES ('2', 'lb', '1', '9');
INSERT INTO `tbl_uoq` VALUES ('3', 'each', '1', '9');
INSERT INTO `tbl_uoq` VALUES ('4', 'feet', '1', '1428680615');
INSERT INTO `tbl_uoq` VALUES ('5', 'inches', '1', '1428680631');

-- ----------------------------
-- Table structure for tbl_user
-- ----------------------------
DROP TABLE IF EXISTS `tbl_user`;
CREATE TABLE `tbl_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(128) NOT NULL,
  `email` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `salt` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `type` tinyint(1) unsigned NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `created_time` int(11) unsigned NOT NULL,
  `created_by` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_user
-- ----------------------------
INSERT INTO `tbl_user` VALUES ('1', 'superadmin', 'superadmin@pmassetmanager.com', 'Super Admin', '555778989f6e59.79965665', '4d1eac0ac95783de86821e4fdb809da0', '0', '1', '1427041436', '0');
INSERT INTO `tbl_user` VALUES ('2', 'admin', 'admin@pmassetmanager.com', 'Admin', '554253854e4c18.55786414', 'eb6bc495ca636ca3edfd01ae5ed1b324', '0', '1', '1429024729', '0');

-- ----------------------------
-- Table structure for tbl_vendor
-- ----------------------------
DROP TABLE IF EXISTS `tbl_vendor`;
CREATE TABLE `tbl_vendor` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `address1` varchar(1024) NOT NULL,
  `address2` varchar(1024) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state_id` int(11) NOT NULL,
  `zipcode` varchar(255) NOT NULL,
  `country` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `fax` varchar(20) DEFAULT NULL,
  `company_name` varchar(50) NOT NULL,
  `contact_name` varchar(50) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `created_time` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_vendor
-- ----------------------------
INSERT INTO `tbl_vendor` VALUES ('1', 'Supper Copper company', 'LA, US', '', '', '0', '', 'US', 'copper@gmail.com', '000998987777', '898908098', 'NY Ball Media', 'Lamp Philip', '1', '1426097092');
INSERT INTO `tbl_vendor` VALUES ('2', 'Alumina Corporation', 'Miami, Florida, United States', '', '', '0', '', 'United States', 'Alumina.corp@gmail.com', '9809832098490', '9840258495209', '', '', '1', '1428659211');
INSERT INTO `tbl_vendor` VALUES ('3', 'Jimmy Steel company', 'Toronto, ON, Canada', '', '', '0', '', 'Canada', 'jimmy.steel@gmail.com', '898898989988', '123434324234', '', '', '1', '1428666782');
INSERT INTO `tbl_vendor` VALUES ('4', 'VENDOR TEST 1', '222 main st', '', 'TORONTO', '59', 'M5V 4V6', 'Canada', 'c1@ballmedia.com', '5197557209', '5197568641', 'VENDOR TEST COMPANY', 'VINCE VENDOR', '1', '1429086899');
INSERT INTO `tbl_vendor` VALUES ('5', 'BOTHWELL STEEL', '', '', '', '0', '', '', '', '', '', 'BOTHWELL STEEL', 'BRUCE', '1', '1448017750');
INSERT INTO `tbl_vendor` VALUES ('6', 'Castle Metals', '2150 Argentia Rd', '', 'Mississauga', '59', 'L5N 2K7', 'CANADA', 'spennells@amcastle.com', '905-858-3883  x53005', '905-858-3883', 'Castle Metals', 'Sean Pennells', '1', '1448021241');
INSERT INTO `tbl_vendor` VALUES ('7', 'ASA ALLOYS', '', '', '', '0', '', '', '', '', '', '-', 'STUART IRONSIDE', '1', '1448027738');
INSERT INTO `tbl_vendor` VALUES ('8', 'ROLLED ALLOYS', '', '', '', '0', '', '', '', '', '', 'rolled alloys', 'JELENAloncar', '1', '1448028017');
INSERT INTO `tbl_vendor` VALUES ('9', 'SUPER ALLOYS', '', '', '', '0', '', '', '', '', '', '-', '-', '1', '1448031478');
INSERT INTO `tbl_vendor` VALUES ('10', 'HUNTER STEEL', '', '', '', '0', '', '', '', '', '', 'HUNTER STEEL', 'HUNTER', '1', '1450096256');
INSERT INTO `tbl_vendor` VALUES ('11', 'THYSSENKRUPP', '', '', '', '0', '', '', '', '', '', 'THYSSENKRUP', '-', '1', '1450109664');

-- ----------------------------
-- Table structure for tbl_vendor_category
-- ----------------------------
DROP TABLE IF EXISTS `tbl_vendor_category`;
CREATE TABLE `tbl_vendor_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `created_time` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=armscii8;

-- ----------------------------
-- Records of tbl_vendor_category
-- ----------------------------
INSERT INTO `tbl_vendor_category` VALUES ('1', 'Steel Mill', '1', '12');
INSERT INTO `tbl_vendor_category` VALUES ('2', 'Finishing', '1', '12');
INSERT INTO `tbl_vendor_category` VALUES ('3', 'Trucking', '1', '1429035668');
INSERT INTO `tbl_vendor_category` VALUES ('4', 'TOOL and DIE out source', '1', '1429035677');
INSERT INTO `tbl_vendor_category` VALUES ('5', 'Steel Supplier', '1', '1448021282');

-- ----------------------------
-- Table structure for tbl_vendor_file
-- ----------------------------
DROP TABLE IF EXISTS `tbl_vendor_file`;
CREATE TABLE `tbl_vendor_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vendor_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of tbl_vendor_file
-- ----------------------------

-- ----------------------------
-- Table structure for tbl_vendor_order
-- ----------------------------
DROP TABLE IF EXISTS `tbl_vendor_order`;
CREATE TABLE `tbl_vendor_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vendor_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_time` int(11) NOT NULL,
  `reply_time` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of tbl_vendor_order
-- ----------------------------
INSERT INTO `tbl_vendor_order` VALUES ('1', '5', '3', '0', '1429373046', '0', '1');
INSERT INTO `tbl_vendor_order` VALUES ('2', '1', '3', '0', '1429373048', '0', '1');
INSERT INTO `tbl_vendor_order` VALUES ('3', '5', '3', '0', '1429374324', '0', '1');
INSERT INTO `tbl_vendor_order` VALUES ('4', '1', '3', '0', '1429374330', '0', '1');
INSERT INTO `tbl_vendor_order` VALUES ('5', '5', '3', '0', '1429374759', '0', '1');
INSERT INTO `tbl_vendor_order` VALUES ('6', '1', '3', '0', '1429374770', '0', '1');
INSERT INTO `tbl_vendor_order` VALUES ('7', '5', '3', '2', '1429377778', '1429381441', '1');
INSERT INTO `tbl_vendor_order` VALUES ('8', '1', '3', '0', '1429377785', '0', '1');

-- ----------------------------
-- Table structure for tbl_vendor_size
-- ----------------------------
DROP TABLE IF EXISTS `tbl_vendor_size`;
CREATE TABLE `tbl_vendor_size` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vendor_id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL,
  `cost_lbs` int(11) NOT NULL,
  `cost_inch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of tbl_vendor_size
-- ----------------------------

-- ----------------------------
-- Table structure for tbl_vendor_vendorcategory
-- ----------------------------
DROP TABLE IF EXISTS `tbl_vendor_vendorcategory`;
CREATE TABLE `tbl_vendor_vendorcategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vendor_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of tbl_vendor_vendorcategory
-- ----------------------------
INSERT INTO `tbl_vendor_vendorcategory` VALUES ('1', '5', '1');
INSERT INTO `tbl_vendor_vendorcategory` VALUES ('2', '5', '2');
INSERT INTO `tbl_vendor_vendorcategory` VALUES ('4', '6', '5');
INSERT INTO `tbl_vendor_vendorcategory` VALUES ('5', '7', '5');
INSERT INTO `tbl_vendor_vendorcategory` VALUES ('6', '8', '5');
INSERT INTO `tbl_vendor_vendorcategory` VALUES ('7', '10', '5');
