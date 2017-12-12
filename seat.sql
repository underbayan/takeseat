/*
Navicat MySQL Data Transfer
Source Host     : localhost:3306
Source Database : seat
Target Host     : localhost:3306
Target Database : seat
Date: 2015-04-18 12:10:29
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for config
-- ----------------------------
DROP TABLE IF EXISTS `config`;
CREATE TABLE `config` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `lname` varchar(30) DEFAULT NULL,
  `value` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`,`name`),
  UNIQUE KEY `ciname` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of config
-- 默认密码 ：12345678
-- ----------------------------
INSERT INTO `config` VALUES ('1', 'admin', '管理员名称', 'admin');
INSERT INTO `config` VALUES ('2', 'adminpwd', '管理员密码', '410c6242d272fa9e80f1f7b67d2c98d2');
INSERT INTO `config` VALUES ('3', 'endtime', '结束时间（填写格式：8,17  表示每月8号17点）', '2,20');
INSERT INTO `config` VALUES ('4', 'starttime', '开始时间（填写格式：8,16  表示每月8号16点）', '1,8');
INSERT INTO `config` VALUES ('5', 'sysStatus', '系统状态', '3');

-- ----------------------------
-- Table structure for layer
-- ----------------------------
DROP TABLE IF EXISTS `layer`;
CREATE TABLE `layer` (
  `id` int(10) NOT NULL DEFAULT '1',
  `imagePath` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of layer
-- ----------------------------
INSERT INTO `layer` VALUES ('1', '1429329872QQ.jpg');

-- ----------------------------
-- Table structure for seat
-- ----------------------------
DROP TABLE IF EXISTS `seat`;
CREATE TABLE `seat` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `owner` varchar(20) DEFAULT NULL,
  `layer` tinyint(3) NOT NULL DEFAULT '0',
  `px` float(12,0) NOT NULL DEFAULT '0',
  `py` float(12,0) NOT NULL DEFAULT '0',
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `w` int(11) NOT NULL DEFAULT '20',
  `h` int(11) NOT NULL DEFAULT '20',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of seat
-- ----------------------------
INSERT INTO `seat` VALUES ('5', '', '1', '359', '235', '0', '0', '66', '20');
INSERT INTO `seat` VALUES ('6', '333', '1', '361', '257', '0', '1', '63', '20');
INSERT INTO `seat` VALUES ('7', null, '1', '433', '232', '0', '0', '63', '20');
INSERT INTO `seat` VALUES ('8', null, '1', '501', '233', '0', '0', '63', '20');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `pwd` varchar(100) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `iname` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('10', '333', 'ea49ff52db98f81517f1a4bef606e8a2', '0', '1');
INSERT INTO `user` VALUES ('11', '111', 'ea49ff52db98f81517f1a4bef606e8a2', '0', '0');
