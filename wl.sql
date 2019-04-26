/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50717
Source Host           : 127.0.0.1:3306
Source Database       : wl

Target Server Type    : MYSQL
Target Server Version : 50717
File Encoding         : 65001

Date: 2019-04-26 18:44:00
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
INSERT INTO `wl_auth_group` VALUES ('1', '超级管理员', '拥有全部权限', '1', '1,2,3,4,19,25,11,12,13,15,14,16,17,18,9,10,23,26,22,27,21,28,24,30,20,29,5,6', '2019-03-04 10:58:12', '1');
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
INSERT INTO `wl_auth_group_access` VALUES ('13', '2');
INSERT INTO `wl_auth_group_access` VALUES ('14', '2');

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
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COMMENT='后台管理员权限表';

-- ----------------------------
-- Records of wl_auth_rule
-- ----------------------------
INSERT INTO `wl_auth_rule` VALUES ('1', '0', 'Manager', '管理员管理', '1', '1', '', 'fa-users', '1', '2019-01-25 17:56:16');
INSERT INTO `wl_auth_rule` VALUES ('2', '1', 'managerView', '管理员列表', '1', '1', '', null, '1', '2019-01-26 12:22:10');
INSERT INTO `wl_auth_rule` VALUES ('3', '1', 'roleView', '角色列表', '1', '1', '', null, '2', '2019-01-26 10:03:20');
INSERT INTO `wl_auth_rule` VALUES ('4', '1', 'authView', '权限列表', '1', '1', '', null, '3', '2019-01-25 17:01:00');
INSERT INTO `wl_auth_rule` VALUES ('5', '0', 'System', '系统管理', '1', '2', '', 'fa-gear', '11', '2019-03-12 10:43:45');
INSERT INTO `wl_auth_rule` VALUES ('6', '5', 'SystemView', '系统设置', '1', '1', '', '', '1', '2019-02-19 11:27:17');
INSERT INTO `wl_auth_rule` VALUES ('9', '0', 'WeChat', '微信管理', '1', '1', '', 'fa-weixin', '5', '2019-03-18 16:26:49');
INSERT INTO `wl_auth_rule` VALUES ('10', '9', 'weChatView', '微信基础设置', '1', '1', '', '', '1', '2019-02-19 17:07:59');
INSERT INTO `wl_auth_rule` VALUES ('11', '0', 'Store', '门店管理', '1', '1', '', 'fa-university', '3', '2019-03-18 10:18:55');
INSERT INTO `wl_auth_rule` VALUES ('12', '11', 'storeListView', '门店列表', '1', '1', '', '', '1', '2019-02-20 10:30:55');
INSERT INTO `wl_auth_rule` VALUES ('13', '0', 'StoreMassage', '门店推拿管理', '1', '1', '', 'fa-university', '4', '2019-04-09 10:07:09');
INSERT INTO `wl_auth_rule` VALUES ('14', '13', 'staff_list_view', '员工列表', '1', '1', '', '', '2', '2019-03-07 16:58:26');
INSERT INTO `wl_auth_rule` VALUES ('15', '13', 'store_massage_list_view', '推拿门店列表', '1', '1', '', '', '1', '2019-03-07 16:24:05');
INSERT INTO `wl_auth_rule` VALUES ('16', '13', 'scheduling_view', '排班设置', '1', '1', '', '', '3', '2019-03-13 11:40:34');
INSERT INTO `wl_auth_rule` VALUES ('17', '13', 'SubscribeListView', '预约列表', '1', '1', '', '', '4', '2019-03-01 15:40:11');
INSERT INTO `wl_auth_rule` VALUES ('18', '13', 'PushSettings', '推送设置', '1', '1', '', '', '5', '2019-03-01 15:40:49');
INSERT INTO `wl_auth_rule` VALUES ('19', '0', 'Member', '会员管理', '1', '2', '', 'fa-user', '2', '2019-03-12 10:43:26');
INSERT INTO `wl_auth_rule` VALUES ('20', '0', 'Logistics', '物流管理', '1', '2', '', 'fa-truck', '10', '2019-03-12 10:43:43');
INSERT INTO `wl_auth_rule` VALUES ('21', '0', 'Stock', '库存管理', '1', '2', '', 'fa-cubes', '8', '2019-03-12 10:43:38');
INSERT INTO `wl_auth_rule` VALUES ('22', '0', 'Presell', '预售管理', '1', '2', '', 'fa-calendar-check-o', '7', '2019-03-12 10:43:36');
INSERT INTO `wl_auth_rule` VALUES ('23', '0', 'Knead', '荔骏会管理', '1', '2', '', 'fa-hand-lizard-o', '6', '2019-03-12 10:43:34');
INSERT INTO `wl_auth_rule` VALUES ('24', '0', 'Book', '订货管理', '1', '2', '', 'fa-book', '9', '2019-03-12 10:43:41');
INSERT INTO `wl_auth_rule` VALUES ('25', '19', 'UserView', '会员列表', '1', '1', '', '', '1', '2019-03-04 10:54:49');
INSERT INTO `wl_auth_rule` VALUES ('26', '23', 'projectView', '项目列表', '1', '1', '', '', '1', '2019-03-04 10:55:53');
INSERT INTO `wl_auth_rule` VALUES ('27', '22', 'presellView', '预售列表', '1', '1', '', '', '1', '2019-03-04 10:56:18');
INSERT INTO `wl_auth_rule` VALUES ('28', '21', 'warehouseView', '仓库列表', '1', '1', '', '', '1', '2019-03-04 10:56:52');
INSERT INTO `wl_auth_rule` VALUES ('29', '20', 'logisticsView', '物流列表', '1', '1', '', '', '1', '2019-03-04 10:57:13');
INSERT INTO `wl_auth_rule` VALUES ('30', '24', 'bookView', '订货列表', '1', '1', '', '', '1', '2019-03-04 10:57:35');

-- ----------------------------
-- Table structure for wl_config
-- ----------------------------
DROP TABLE IF EXISTS `wl_config`;
CREATE TABLE `wl_config` (
  `c_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '配置id',
  `c_key` varchar(255) NOT NULL COMMENT '系统配置键',
  `c_value` text NOT NULL COMMENT '系统配置value',
  `c_addTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '系统配置时间',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COMMENT='配置表';

-- ----------------------------
-- Records of wl_config
-- ----------------------------
INSERT INTO `wl_config` VALUES ('1', 'weChat', '{\"wc_appid\":\"wxc7d11a087b99ecdf\",\"wc_appsecret\":\"ad935003349978f8d1c4fa7746d28407\",\"wc_token\":\"mYyPYPwBR38G5p88\"}', '2019-02-19 18:09:46');

-- ----------------------------
-- Table structure for wl_manager
-- ----------------------------
DROP TABLE IF EXISTS `wl_manager`;
CREATE TABLE `wl_manager` (
  `m_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '管理员id',
  `m_name` varchar(50) NOT NULL COMMENT '管理员名称',
  `m_password` varchar(255) NOT NULL COMMENT '管理员密码 (password_hash加密)',
  `m_sex` tinyint(1) NOT NULL DEFAULT '0' COMMENT '性别：  0 保密 1 男 2 女',
  `m_addTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '添加时间',
  `m_state` tinyint(1) NOT NULL DEFAULT '1' COMMENT '管理员状态 1为启用，2为禁用',
  `m_delete` tinyint(1) NOT NULL DEFAULT '1' COMMENT '管理员是否删除 1为存在，2为删除(可以恢复状态)',
  PRIMARY KEY (`m_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='管理员员工表';

-- ----------------------------
-- Records of wl_manager
-- ----------------------------
INSERT INTO `wl_manager` VALUES ('1', 'serena', '$2y$10$xIONNGE2jWEvtlpGTspC8.FA.8W3mcZ1T5Rol.hBYeMbaO1aiv5oO', '1', '2018-11-26 10:25:06', '1', '1');
INSERT INTO `wl_manager` VALUES ('2', 'admin2', '$2y$10$xIONNGE2jWEvtlpGTspC8.FA.8W3mcZ1T5Rol.hBYeMbaO1aiv5oO', '0', '2018-12-14 17:51:46', '1', '1');
INSERT INTO `wl_manager` VALUES ('3', 'admin3', '$2y$10$xIONNGE2jWEvtlpGTspC8.FA.8W3mcZ1T5Rol.hBYeMbaO1aiv5oO', '2', '2018-12-14 17:51:46', '1', '1');
INSERT INTO `wl_manager` VALUES ('4', 'admin4', '$2y$10$xIONNGE2jWEvtlpGTspC8.FA.8W3mcZ1T5Rol.hBYeMbaO1aiv5oO', '0', '2018-12-14 17:51:46', '1', '1');
INSERT INTO `wl_manager` VALUES ('5', 'admin5', '$2y$10$xIONNGE2jWEvtlpGTspC8.FA.8W3mcZ1T5Rol.hBYeMbaO1aiv5oO', '1', '2018-12-14 17:51:46', '1', '1');
INSERT INTO `wl_manager` VALUES ('6', 'admin6', '$2y$10$xIONNGE2jWEvtlpGTspC8.FA.8W3mcZ1T5Rol.hBYeMbaO1aiv5oO', '0', '2018-12-14 17:51:46', '1', '1');
INSERT INTO `wl_manager` VALUES ('7', 'admin7', '$2y$10$xIONNGE2jWEvtlpGTspC8.FA.8W3mcZ1T5Rol.hBYeMbaO1aiv5oO', '2', '2018-12-14 17:51:46', '1', '1');
INSERT INTO `wl_manager` VALUES ('8', 'admin8', '$2y$10$xIONNGE2jWEvtlpGTspC8.FA.8W3mcZ1T5Rol.hBYeMbaO1aiv5oO', '0', '2018-12-14 17:51:46', '1', '1');
INSERT INTO `wl_manager` VALUES ('9', 'admin9', '$2y$10$xIONNGE2jWEvtlpGTspC8.FA.8W3mcZ1T5Rol.hBYeMbaO1aiv5oO', '2', '2019-04-08 17:19:52', '2', '1');
INSERT INTO `wl_manager` VALUES ('10', 'admin10', '$2y$10$xIONNGE2jWEvtlpGTspC8.FA.8W3mcZ1T5Rol.hBYeMbaO1aiv5oO', '0', '2018-12-14 17:51:46', '1', '1');
INSERT INTO `wl_manager` VALUES ('13', 'admin', '$2y$10$1GaSULRb.ql0liqiJ875teHUaQVPFNl2l0w9hM5Bv0e4bG30eBlay', '0', '2019-02-14 23:13:48', '2', '2');
INSERT INTO `wl_manager` VALUES ('14', 'admin1', '$2y$10$TrDJ0MUR42ZS4.hfkx9Y8.3c6XYkd9S9FlszNjVSdV0zvBUlAU7Iq', '0', '2019-02-14 23:14:49', '2', '2');

-- ----------------------------
-- Table structure for wl_massage_personnel
-- ----------------------------
DROP TABLE IF EXISTS `wl_massage_personnel`;
CREATE TABLE `wl_massage_personnel` (
  `mp_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '推拿门店员工id',
  `mp_msId` int(10) NOT NULL COMMENT '推拿门店id',
  `mp_name` varchar(255) NOT NULL COMMENT '推拿门店员工名称',
  `mp_password` varchar(255) NOT NULL COMMENT '推拿员工登录密码 (password_hash加密）',
  `mp_spell` varchar(255) NOT NULL COMMENT '推拿员工名称拼音',
  `mp_workShift` tinyint(1) NOT NULL DEFAULT '1' COMMENT '推拿员工上班时间（1 全天  2  上午  3 下午）',
  `mp_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '添加时间',
  PRIMARY KEY (`mp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='推拿门店员工';

-- ----------------------------
-- Records of wl_massage_personnel
-- ----------------------------
INSERT INTO `wl_massage_personnel` VALUES ('1', '1', '梁世兰', '$2y$10$P1y3HV6JkEpPGhvVjfHCdOT4YnDEuXCYLHhss5uUbXdRV0vI6uvfW', 'liangshilan', '1', '2019-03-13 10:54:43');
INSERT INTO `wl_massage_personnel` VALUES ('2', '1', '何宝娣', '$2y$10$9RzyXRSRPwqDq/NfsjclGe6sPmxMmygNI.tVmZsy/xIdeZNAJ8OkO', 'hebaodi', '1', '2019-03-13 10:57:49');
INSERT INTO `wl_massage_personnel` VALUES ('3', '2', '齐晓明', '$2y$10$0edKnGuaVhG2pV0mmsCVLOXEXHwcEVhSYKY1g792rpFkO2lY6HKt6', 'qixiaoming', '1', '2019-03-13 10:58:01');
INSERT INTO `wl_massage_personnel` VALUES ('4', '1', '李弯', '$2y$10$sRAmad4GLiUnEAGofEld.uySOxDSphjvW1/Zi1e1TQ4YcgJomdITe', 'liwan', '1', '2019-03-13 10:58:37');
INSERT INTO `wl_massage_personnel` VALUES ('5', '1', '刘坤', '$2y$10$hZ4kdop2gTmp/toL8jEBhud/RQbMVioBiYI4Z24TIjfdAsgbu48ye', 'liukun', '3', '2019-03-13 11:12:16');

-- ----------------------------
-- Table structure for wl_massage_reser
-- ----------------------------
DROP TABLE IF EXISTS `wl_massage_reser`;
CREATE TABLE `wl_massage_reser` (
  `mr_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '预约时间id',
  `mr_uid` int(10) NOT NULL COMMENT '用户id',
  `mr_msid` int(10) NOT NULL COMMENT '门店id',
  `mr_name` char(50) NOT NULL COMMENT '宝宝名称',
  `mr_time` int(10) NOT NULL COMMENT '小儿推拿预约时间',
  `mr_phone` varchar(20) NOT NULL COMMENT '预约手机号码',
  `mr_remarks` text COMMENT '推拿备注',
  `mr_state` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 1 预约 2 删除',
  `mr_addTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '推拿预约添加时间',
  PRIMARY KEY (`mr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='门店小儿推拿预约表';

-- ----------------------------
-- Records of wl_massage_reser
-- ----------------------------
INSERT INTO `wl_massage_reser` VALUES ('1', '1', '1', 'serena', '1556002800', '13800138000', null, '1', '2019-04-23 12:29:49');
INSERT INTO `wl_massage_reser` VALUES ('2', '1', '1', 'serena', '1556006400', '13800138000', null, '1', '2019-04-23 12:35:00');
INSERT INTO `wl_massage_reser` VALUES ('3', '1', '1', 'serena', '1556092800', '13800138000', null, '1', '2019-04-23 15:12:11');
INSERT INTO `wl_massage_reser` VALUES ('4', '1', '2', 'serena', '1556092800', '13800138000', null, '1', '2019-04-23 15:12:34');
INSERT INTO `wl_massage_reser` VALUES ('5', '1', '1', 'serena', '1556274600', '13800138000', null, '1', '2019-04-26 17:46:22');
INSERT INTO `wl_massage_reser` VALUES ('6', '1', '1', 'serena', '1556361000', '13800138000', null, '1', '2019-04-26 17:46:22');
INSERT INTO `wl_massage_reser` VALUES ('7', '1', '1', '测试', '1556359200', '1380038000', null, '1', '2019-04-26 17:48:16');
INSERT INTO `wl_massage_reser` VALUES ('8', '1', '1', '测试', '1556359200', '1380038000', '', '1', '2019-04-26 17:59:46');
INSERT INTO `wl_massage_reser` VALUES ('9', '1', '1', '测试', '1556359200', '1380038000', '', '2', '2019-04-26 17:48:16');

-- ----------------------------
-- Table structure for wl_massage_rest
-- ----------------------------
DROP TABLE IF EXISTS `wl_massage_rest`;
CREATE TABLE `wl_massage_rest` (
  `mr_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '推拿员工休息id',
  `mr_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '推拿员工休息时间',
  `mr_mpId` int(11) NOT NULL COMMENT '推拿员工id',
  `mr_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '推拿休息时间添加时间',
  PRIMARY KEY (`mr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8 COMMENT='推拿员工休息表';

-- ----------------------------
-- Records of wl_massage_rest
-- ----------------------------
INSERT INTO `wl_massage_rest` VALUES ('1', '2019-01-30 00:00:00', '2', '2019-03-14 17:01:03');
INSERT INTO `wl_massage_rest` VALUES ('2', '2019-01-30 00:00:00', '1', '2019-03-14 17:01:22');
INSERT INTO `wl_massage_rest` VALUES ('3', '2019-01-30 00:00:00', '3', '2019-03-14 17:01:27');
INSERT INTO `wl_massage_rest` VALUES ('4', '2019-01-31 00:00:00', '2', '2019-03-14 17:20:41');
INSERT INTO `wl_massage_rest` VALUES ('5', '2019-01-31 00:00:00', '1', '2019-03-14 17:21:06');
INSERT INTO `wl_massage_rest` VALUES ('6', '2019-02-01 00:00:00', '2', '2019-03-14 17:21:19');
INSERT INTO `wl_massage_rest` VALUES ('7', '2019-02-01 00:00:00', '1', '2019-03-14 17:21:24');
INSERT INTO `wl_massage_rest` VALUES ('8', '2019-02-01 00:00:00', '3', '2019-03-14 17:21:29');
INSERT INTO `wl_massage_rest` VALUES ('9', '2019-02-02 00:00:00', '3', '2019-03-14 17:21:35');
INSERT INTO `wl_massage_rest` VALUES ('10', '2019-02-02 00:00:00', '1', '2019-03-14 17:21:41');
INSERT INTO `wl_massage_rest` VALUES ('11', '2019-02-02 00:00:00', '2', '2019-03-14 17:21:45');
INSERT INTO `wl_massage_rest` VALUES ('12', '2019-02-03 00:00:00', '1', '2019-03-14 17:24:38');
INSERT INTO `wl_massage_rest` VALUES ('13', '2019-02-03 00:00:00', '2', '2019-03-14 17:24:41');
INSERT INTO `wl_massage_rest` VALUES ('14', '2019-02-03 00:00:00', '3', '2019-03-14 17:24:47');
INSERT INTO `wl_massage_rest` VALUES ('15', '2019-02-04 00:00:00', '2', '2019-03-14 17:33:01');
INSERT INTO `wl_massage_rest` VALUES ('16', '2019-02-04 00:00:00', '1', '2019-03-14 17:33:13');
INSERT INTO `wl_massage_rest` VALUES ('17', '2019-02-04 00:00:00', '3', '2019-03-14 17:33:18');
INSERT INTO `wl_massage_rest` VALUES ('18', '2019-02-05 00:00:00', '1', '2019-03-14 17:33:26');
INSERT INTO `wl_massage_rest` VALUES ('19', '2019-02-05 00:00:00', '2', '2019-03-14 17:33:28');
INSERT INTO `wl_massage_rest` VALUES ('20', '2019-02-05 00:00:00', '3', '2019-03-14 17:33:32');
INSERT INTO `wl_massage_rest` VALUES ('21', '2019-02-06 00:00:00', '2', '2019-03-14 17:33:39');
INSERT INTO `wl_massage_rest` VALUES ('22', '2019-02-06 00:00:00', '1', '2019-03-14 17:33:45');
INSERT INTO `wl_massage_rest` VALUES ('23', '2019-02-07 00:00:00', '1', '2019-03-14 17:33:47');
INSERT INTO `wl_massage_rest` VALUES ('24', '2019-02-08 00:00:00', '1', '2019-03-14 17:33:53');
INSERT INTO `wl_massage_rest` VALUES ('25', '2019-02-09 00:00:00', '1', '2019-03-14 17:33:56');
INSERT INTO `wl_massage_rest` VALUES ('26', '2019-02-10 00:00:00', '1', '2019-03-14 17:34:00');
INSERT INTO `wl_massage_rest` VALUES ('27', '2019-02-11 00:00:00', '1', '2019-03-14 17:34:04');
INSERT INTO `wl_massage_rest` VALUES ('28', '2019-02-12 00:00:00', '1', '2019-03-14 17:34:07');
INSERT INTO `wl_massage_rest` VALUES ('29', '2019-02-07 00:00:00', '2', '2019-03-14 17:34:24');
INSERT INTO `wl_massage_rest` VALUES ('30', '2019-02-08 00:00:00', '2', '2019-03-14 17:34:30');
INSERT INTO `wl_massage_rest` VALUES ('31', '2019-02-06 00:00:00', '3', '2019-03-14 17:34:44');
INSERT INTO `wl_massage_rest` VALUES ('32', '2019-02-07 00:00:00', '3', '2019-03-14 17:34:49');
INSERT INTO `wl_massage_rest` VALUES ('33', '2019-02-08 00:00:00', '3', '2019-03-14 17:34:52');
INSERT INTO `wl_massage_rest` VALUES ('34', '2019-02-22 00:00:00', '3', '2019-03-14 17:34:58');
INSERT INTO `wl_massage_rest` VALUES ('35', '2019-03-04 00:00:00', '2', '2019-03-14 17:35:13');
INSERT INTO `wl_massage_rest` VALUES ('36', '2019-03-15 00:00:00', '3', '2019-03-14 17:35:23');
INSERT INTO `wl_massage_rest` VALUES ('37', '2019-03-16 00:00:00', '3', '2019-03-14 17:35:25');
INSERT INTO `wl_massage_rest` VALUES ('38', '2019-03-17 00:00:00', '3', '2019-03-14 17:35:27');
INSERT INTO `wl_massage_rest` VALUES ('40', '2019-05-06 00:00:00', '2', '2019-04-22 11:27:12');
INSERT INTO `wl_massage_rest` VALUES ('41', '2019-05-09 00:00:00', '1', '2019-04-22 11:27:22');
INSERT INTO `wl_massage_rest` VALUES ('42', '2019-05-10 00:00:00', '1', '2019-04-22 11:27:26');
INSERT INTO `wl_massage_rest` VALUES ('43', '2019-05-11 00:00:00', '1', '2019-04-22 11:27:36');
INSERT INTO `wl_massage_rest` VALUES ('44', '2019-04-30 00:00:00', '2', '2019-04-22 11:27:47');
INSERT INTO `wl_massage_rest` VALUES ('45', '2019-04-29 00:00:00', '2', '2019-04-22 11:27:51');
INSERT INTO `wl_massage_rest` VALUES ('46', '2019-04-27 00:00:00', '2', '2019-04-22 11:27:56');
INSERT INTO `wl_massage_rest` VALUES ('47', '2019-04-25 00:00:00', '2', '2019-04-22 11:28:00');
INSERT INTO `wl_massage_rest` VALUES ('48', '2019-05-13 00:00:00', '2', '2019-04-22 11:33:39');
INSERT INTO `wl_massage_rest` VALUES ('49', '2019-05-20 00:00:00', '2', '2019-04-22 11:33:42');
INSERT INTO `wl_massage_rest` VALUES ('50', '2019-05-16 00:00:00', '1', '2019-04-22 11:33:48');
INSERT INTO `wl_massage_rest` VALUES ('51', '2019-05-23 00:00:00', '1', '2019-04-22 11:33:52');
INSERT INTO `wl_massage_rest` VALUES ('52', '2019-05-30 00:00:00', '1', '2019-04-22 11:33:57');
INSERT INTO `wl_massage_rest` VALUES ('53', '2019-05-27 00:00:00', '2', '2019-04-22 11:34:16');
INSERT INTO `wl_massage_rest` VALUES ('54', '2019-04-25 00:00:00', '3', '2019-04-22 14:51:54');

-- ----------------------------
-- Table structure for wl_massage_store
-- ----------------------------
DROP TABLE IF EXISTS `wl_massage_store`;
CREATE TABLE `wl_massage_store` (
  `ms_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '推拿门店id',
  `ms_name` varchar(255) NOT NULL COMMENT '推拿门店名称',
  `ms_phone` char(11) NOT NULL COMMENT '推拿门店电话',
  `ms_address` varchar(255) NOT NULL COMMENT '推拿门店地址',
  `ms_number` char(50) NOT NULL COMMENT '上班人数',
  `ms_slot` char(50) NOT NULL COMMENT '可预约时段',
  `ms_workShift` text NOT NULL COMMENT '推拿门店上班时间',
  `ms_pic` varchar(255) DEFAULT NULL COMMENT '推拿门店图片',
  `ms_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '推拿门店添加时间',
  PRIMARY KEY (`ms_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='门店推拿(门店列表)';

-- ----------------------------
-- Records of wl_massage_store
-- ----------------------------
INSERT INTO `wl_massage_store` VALUES ('1', '金沙店乐婴岛', '18927543087', '广东省广州市海珠区金沙路16至20号首层商铺自编之十二', '3', '15', '0,1,2,3,4,5,6,10,11,12,13,14,15,16,17,18,19', './static/uploads/store_massage/20190307\\e931a095c4a16e5422d96fed044ec2b7.png', '2019-04-22 11:07:56');
INSERT INTO `wl_massage_store` VALUES ('2', '万达店乐婴岛', '17728026810', '桂城街道桂澜北路28号南海万达广场南7栋235号铺', '1', '15', '0,1,2,3,4,5,6,9,10,11,12,13,14,15,16,17,18,19,20,21', './static/uploads/store_massage/20190307\\312193fdfcf570fa778aff40bae550ac.jpg', '2019-04-22 11:07:58');

-- ----------------------------
-- Table structure for wl_store
-- ----------------------------
DROP TABLE IF EXISTS `wl_store`;
CREATE TABLE `wl_store` (
  `s_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '门店id',
  `s_name` varchar(255) NOT NULL COMMENT '门店名称',
  `s_phone` char(11) NOT NULL COMMENT '门店电话',
  `s_pic` varchar(255) DEFAULT NULL COMMENT '门店图片',
  `s_address` varchar(255) NOT NULL COMMENT '门店地址',
  `s_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '门店添加时间',
  PRIMARY KEY (`s_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='门店信息表';

-- ----------------------------
-- Records of wl_store
-- ----------------------------
INSERT INTO `wl_store` VALUES ('1', '金沙店乐婴岛', '18927543087', './static/uploads/store/20190306\\f415ff7ce750cb5c01175db33222ec90.png', '广东省广州市海珠区金沙路16至20号首层商铺自编之十二', '2019-03-06 10:34:43');
INSERT INTO `wl_store` VALUES ('2', '万达店乐婴岛', '17728026810', './static/uploads/store/20190306\\312193fdfcf570fa778aff40bae550ac.jpg', '桂城街道桂澜北路28号南海万达广场南7栋235号铺', '2019-03-06 10:37:28');

-- ----------------------------
-- Table structure for wl_users
-- ----------------------------
DROP TABLE IF EXISTS `wl_users`;
CREATE TABLE `wl_users` (
  `u_user_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '表id',
  `u_password` varchar(255) NOT NULL DEFAULT '' COMMENT '密码',
  `u_sex` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0 保密 1 男 2 女',
  `u_mobile` varchar(20) DEFAULT NULL COMMENT '手机号码',
  `u_oauth` varchar(10) DEFAULT '' COMMENT '第三方来源 wx weibo alipay',
  `u_openid` varchar(100) DEFAULT NULL COMMENT '第三方唯一标示',
  `u_unionId` varchar(100) DEFAULT NULL COMMENT '公众号和小程序共有的id',
  `u_head_pic` varchar(255) DEFAULT NULL COMMENT '头像',
  `u_country` char(50) DEFAULT '0' COMMENT '国家',
  `u_province` char(50) DEFAULT '0' COMMENT '省份',
  `u_city` char(50) DEFAULT '0' COMMENT '市区',
  `u_nickname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT '第三方返回昵称',
  `u_time` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '注册时间',
  PRIMARY KEY (`u_user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of wl_users
-- ----------------------------
INSERT INTO `wl_users` VALUES ('1', '$2y$10$JRmYCmowj5X0w6Pxja5BXuc3Oa3hjN3OOMGJPljKHO6ITEbarG/py', '1', '13800138000', 'weixin', 'o_Aqa1OK0wuGazh3vhFyNfCcuUak', null, 'http://thirdwx.qlogo.cn/mmopen/vi_32/k3r9YIaWdlkax86PLglXP0bKnMEn3d9lHgyQJXfErQ7LnzrVrWQLxdxia0KStY0U4cjXngK241ck8PUFzAGVic4Q/132', '中国', '广东', '揭阳', 'Serena', '2019-04-17 17:13:19');
