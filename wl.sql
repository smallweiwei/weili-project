/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50717
Source Host           : 127.0.0.1:3306
Source Database       : wl

Target Server Type    : MYSQL
Target Server Version : 50717
File Encoding         : 65001

Date: 2019-01-26 18:30:58
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for wl_auth_group
-- ----------------------------
DROP TABLE IF EXISTS `wl_auth_group`;
CREATE TABLE `wl_auth_group` (
  `ag_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `ag_title` char(100) NOT NULL DEFAULT '' COMMENT '用户组中文名称',
  `ag_describe` text COMMENT '角色描述',
  `ag_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：为1正常，为2禁用',
  `ag_rules` varchar(255) NOT NULL DEFAULT '' COMMENT '用户组拥有的规则id， 多个规则用","隔开',
  `ag_addTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '添加时间',
  `ag_delete` tinyint(2) NOT NULL DEFAULT '1' COMMENT '是否删除 1是不删除 2是删除',
  PRIMARY KEY (`ag_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='后台角色表';

-- ----------------------------
-- Records of wl_auth_group
-- ----------------------------
INSERT INTO `wl_auth_group` VALUES ('1', '超级管理员', '拥有全部权限', '1', '1,2,3,4,5,6', '2019-01-26 10:44:53', '1');
INSERT INTO `wl_auth_group` VALUES ('2', '管理员', '拥有部分权限', '1', '1,2,3,4', '2019-01-26 11:13:07', '1');
INSERT INTO `wl_auth_group` VALUES ('3', '金沙店', '', '1', '', '2019-01-26 12:07:31', '1');
INSERT INTO `wl_auth_group` VALUES ('4', '万达店', '', '1', '', '2019-01-26 12:07:36', '1');
INSERT INTO `wl_auth_group` VALUES ('5', '荔骏会', '', '1', '', '2019-01-26 12:07:38', '1');

-- ----------------------------
-- Table structure for wl_auth_group_access
-- ----------------------------
DROP TABLE IF EXISTS `wl_auth_group_access`;
CREATE TABLE `wl_auth_group_access` (
  `uid` mediumint(8) unsigned NOT NULL COMMENT '管理员id',
  `group_id` mediumint(8) unsigned NOT NULL COMMENT '用户组id',
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`) USING BTREE,
  KEY `uid` (`uid`) USING BTREE,
  KEY `group_id` (`group_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='后台管理员和角色表';

-- ----------------------------
-- Records of wl_auth_group_access
-- ----------------------------
INSERT INTO `wl_auth_group_access` VALUES ('1', '1');
INSERT INTO `wl_auth_group_access` VALUES ('2', '2');
INSERT INTO `wl_auth_group_access` VALUES ('3', '2');
INSERT INTO `wl_auth_group_access` VALUES ('4', '2');
INSERT INTO `wl_auth_group_access` VALUES ('5', '3');
INSERT INTO `wl_auth_group_access` VALUES ('6', '3');
INSERT INTO `wl_auth_group_access` VALUES ('7', '4');
INSERT INTO `wl_auth_group_access` VALUES ('8', '4');
INSERT INTO `wl_auth_group_access` VALUES ('9', '5');
INSERT INTO `wl_auth_group_access` VALUES ('10', '5');

-- ----------------------------
-- Table structure for wl_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `wl_auth_rule`;
CREATE TABLE `wl_auth_rule` (
  `ar_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `ar_pid` int(10) NOT NULL COMMENT '父节点',
  `ar_name` char(80) NOT NULL DEFAULT '' COMMENT '规则唯一标识',
  `ar_title` char(20) NOT NULL DEFAULT '' COMMENT '规则中文名称',
  `ar_type` tinyint(1) NOT NULL DEFAULT '1',
  `ar_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：为1正常，为2禁用',
  `ar_condition` char(100) NOT NULL DEFAULT '' COMMENT '规则表达式，为空表示存在就验证，不为空表示按照条件验证',
  `ar_icon` varchar(255) DEFAULT NULL COMMENT '顶级类是的icon',
  `ar_sort` int(50) DEFAULT '1' COMMENT '排序',
  `ar_addTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '添加时间',
  PRIMARY KEY (`ar_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='后台管理员权限表';

-- ----------------------------
-- Records of wl_auth_rule
-- ----------------------------
INSERT INTO `wl_auth_rule` VALUES ('1', '0', 'Manager', '管理员管理', '1', '1', '', 'fa-users', '1', '2019-01-25 17:56:16');
INSERT INTO `wl_auth_rule` VALUES ('2', '1', 'managerView', '管理员列表', '1', '1', '', null, '1', '2019-01-26 12:22:10');
INSERT INTO `wl_auth_rule` VALUES ('3', '1', 'roleView', '角色列表', '1', '1', '', null, '2', '2019-01-26 10:03:20');
INSERT INTO `wl_auth_rule` VALUES ('4', '1', 'authView', '权限列表', '1', '1', '', null, '3', '2019-01-25 17:01:00');
INSERT INTO `wl_auth_rule` VALUES ('5', '0', 'System', '系统管理', '1', '2', '', 'fa-gear', '2', '2019-01-25 17:50:44');
INSERT INTO `wl_auth_rule` VALUES ('6', '5', 'routeView', '路由列表', '1', '2', '', null, '1', '2019-01-26 14:03:35');

-- ----------------------------
-- Table structure for wl_manager
-- ----------------------------
DROP TABLE IF EXISTS `wl_manager`;
CREATE TABLE `wl_manager` (
  `m_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '管理员id',
  `m_name` varchar(50) NOT NULL COMMENT '管理员名称',
  `m_password` varchar(255) NOT NULL COMMENT '管理员密码 (password_hash加密)',
  `m_sex` tinyint(1) NOT NULL DEFAULT '0' COMMENT '性别：  0 保密 1 男 2 女',
  `m_addTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `m_state` tinyint(1) NOT NULL DEFAULT '1' COMMENT '管理员状态 1为启用，2为禁用',
  `m_delete` tinyint(1) NOT NULL DEFAULT '1' COMMENT '管理员是否删除 1为存在，2为删除(可以恢复状态)',
  PRIMARY KEY (`m_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wl_manager
-- ----------------------------
INSERT INTO `wl_manager` VALUES ('1', 'serena', '$2y$10$xIONNGE2jWEvtlpGTspC8.FA.8W3mcZ1T5Rol.hBYeMbaO1aiv5oO', '1', '2018-11-26 10:25:06', '1', '1');
INSERT INTO `wl_manager` VALUES ('2', 'admin2', '$2y$10$xIONNGE2jWEvtlpGTspC8.FA.8W3mcZ1T5Rol.hBYeMbaO1aiv5oO', '0', '2018-12-14 17:51:46', '2', '1');
INSERT INTO `wl_manager` VALUES ('3', 'admin3', '$2y$10$xIONNGE2jWEvtlpGTspC8.FA.8W3mcZ1T5Rol.hBYeMbaO1aiv5oO', '2', '2018-12-14 17:51:46', '1', '1');
INSERT INTO `wl_manager` VALUES ('4', 'admin4', '$2y$10$xIONNGE2jWEvtlpGTspC8.FA.8W3mcZ1T5Rol.hBYeMbaO1aiv5oO', '0', '2018-12-14 17:51:46', '2', '1');
INSERT INTO `wl_manager` VALUES ('5', 'admin5', '$2y$10$xIONNGE2jWEvtlpGTspC8.FA.8W3mcZ1T5Rol.hBYeMbaO1aiv5oO', '1', '2018-12-14 17:51:46', '1', '1');
INSERT INTO `wl_manager` VALUES ('6', 'admin6', '$2y$10$xIONNGE2jWEvtlpGTspC8.FA.8W3mcZ1T5Rol.hBYeMbaO1aiv5oO', '0', '2018-12-14 17:51:46', '2', '1');
INSERT INTO `wl_manager` VALUES ('7', 'admin7', '$2y$10$xIONNGE2jWEvtlpGTspC8.FA.8W3mcZ1T5Rol.hBYeMbaO1aiv5oO', '2', '2018-12-14 17:51:46', '1', '1');
INSERT INTO `wl_manager` VALUES ('8', 'admin8', '$2y$10$xIONNGE2jWEvtlpGTspC8.FA.8W3mcZ1T5Rol.hBYeMbaO1aiv5oO', '0', '2018-12-14 17:51:46', '2', '1');
INSERT INTO `wl_manager` VALUES ('9', 'admin9', '$2y$10$xIONNGE2jWEvtlpGTspC8.FA.8W3mcZ1T5Rol.hBYeMbaO1aiv5oO', '2', '2018-12-14 17:51:46', '1', '1');
INSERT INTO `wl_manager` VALUES ('10', 'admin10', '$2y$10$xIONNGE2jWEvtlpGTspC8.FA.8W3mcZ1T5Rol.hBYeMbaO1aiv5oO', '1', '2018-12-14 17:51:46', '2', '1');
