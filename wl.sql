-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: localhost    Database: weimeiyi
-- ------------------------------------------------------
-- Server version	5.7.17

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `weimeiyi`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `weimeiyi` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `weimeiyi`;

--
-- Table structure for table `wl_auth_group`
--

DROP TABLE IF EXISTS `wl_auth_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wl_auth_group`
--

LOCK TABLES `wl_auth_group` WRITE;
/*!40000 ALTER TABLE `wl_auth_group` DISABLE KEYS */;
INSERT INTO `wl_auth_group` VALUES (1,'超级管理员','拥有全部权限',1,'1,2,3,4,19,25,11,12,13,15,14,16,17,18,9,10,23,26,22,27,21,28,24,30,20,29,5,6','2019-03-04 02:58:12',1),(2,'管理员','拥有部分权限',1,'1,2,3,4','2019-01-26 03:13:07',1),(3,'金沙店','',1,'','2019-01-26 04:07:31',1),(4,'万达店','',1,'','2019-01-26 04:07:36',1),(5,'荔骏会','',1,'','2019-01-26 04:07:38',1);
/*!40000 ALTER TABLE `wl_auth_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wl_auth_group_access`
--

DROP TABLE IF EXISTS `wl_auth_group_access`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wl_auth_group_access` (
  `uid` mediumint(8) unsigned NOT NULL COMMENT '管理员id',
  `group_id` mediumint(8) unsigned NOT NULL COMMENT '用户组id',
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`) USING BTREE,
  KEY `uid` (`uid`) USING BTREE,
  KEY `group_id` (`group_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='后台管理员和角色表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wl_auth_group_access`
--

LOCK TABLES `wl_auth_group_access` WRITE;
/*!40000 ALTER TABLE `wl_auth_group_access` DISABLE KEYS */;
INSERT INTO `wl_auth_group_access` VALUES (1,1),(2,2),(3,2),(4,2),(5,3),(6,3),(7,4),(8,4),(9,5),(10,5),(13,2),(14,2);
/*!40000 ALTER TABLE `wl_auth_group_access` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wl_auth_rule`
--

DROP TABLE IF EXISTS `wl_auth_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wl_auth_rule`
--

LOCK TABLES `wl_auth_rule` WRITE;
/*!40000 ALTER TABLE `wl_auth_rule` DISABLE KEYS */;
INSERT INTO `wl_auth_rule` VALUES (1,0,'Manager','管理员管理',1,1,'','fa-users',1,'2019-01-25 09:56:16'),(2,1,'managerView','管理员列表',1,1,'',NULL,1,'2019-01-26 04:22:10'),(3,1,'roleView','角色列表',1,1,'',NULL,2,'2019-01-26 02:03:20'),(4,1,'authView','权限列表',1,1,'',NULL,3,'2019-01-25 09:01:00'),(5,0,'System','系统管理',1,2,'','fa-gear',11,'2019-03-12 02:43:45'),(6,5,'SystemView','系统设置',1,1,'','',1,'2019-02-19 03:27:17'),(9,0,'WeChat','微信管理',1,2,'','fa-weixin',5,'2019-03-12 02:43:32'),(10,9,'weChatView','微信基础设置',1,1,'','',1,'2019-02-19 09:07:59'),(11,0,'Store','门店管理',1,2,'','fa-university',3,'2019-03-12 02:43:28'),(12,11,'storeListView','门店列表',1,1,'','',1,'2019-02-20 02:30:55'),(13,0,'StoreMassage','门店推拿管理',1,1,'','fa-university',4,'2019-03-04 07:30:56'),(14,13,'staff_list_view','员工列表',1,1,'','',2,'2019-03-07 08:58:26'),(15,13,'store_massage_list_view','推拿门店列表',1,1,'','',1,'2019-03-07 08:24:05'),(16,13,'scheduling_view','排班设置',1,1,'','',3,'2019-03-13 03:40:34'),(17,13,'SubscribeListView','预约列表',1,1,'','',4,'2019-03-01 07:40:11'),(18,13,'PushSettings','推送设置',1,1,'','',5,'2019-03-01 07:40:49'),(19,0,'Member','会员管理',1,2,'','fa-user',2,'2019-03-12 02:43:26'),(20,0,'Logistics','物流管理',1,2,'','fa-truck',10,'2019-03-12 02:43:43'),(21,0,'Stock','库存管理',1,2,'','fa-cubes',8,'2019-03-12 02:43:38'),(22,0,'Presell','预售管理',1,2,'','fa-calendar-check-o',7,'2019-03-12 02:43:36'),(23,0,'Knead','荔骏会管理',1,2,'','fa-hand-lizard-o',6,'2019-03-12 02:43:34'),(24,0,'Book','订货管理',1,2,'','fa-book',9,'2019-03-12 02:43:41'),(25,19,'UserView','会员列表',1,1,'','',1,'2019-03-04 02:54:49'),(26,23,'projectView','项目列表',1,1,'','',1,'2019-03-04 02:55:53'),(27,22,'presellView','预售列表',1,1,'','',1,'2019-03-04 02:56:18'),(28,21,'warehouseView','仓库列表',1,1,'','',1,'2019-03-04 02:56:52'),(29,20,'logisticsView','物流列表',1,1,'','',1,'2019-03-04 02:57:13'),(30,24,'bookView','订货列表',1,1,'','',1,'2019-03-04 02:57:35');
/*!40000 ALTER TABLE `wl_auth_rule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wl_config`
--

DROP TABLE IF EXISTS `wl_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wl_config` (
  `c_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '配置id',
  `c_key` varchar(255) NOT NULL COMMENT '系统配置键',
  `c_value` text NOT NULL COMMENT '系统配置value',
  `c_addTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '系统配置时间',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COMMENT='配置表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wl_config`
--

LOCK TABLES `wl_config` WRITE;
/*!40000 ALTER TABLE `wl_config` DISABLE KEYS */;
INSERT INTO `wl_config` VALUES (1,'weChat','{\"wc_appid\":\"wxacf1cebed28d9d4a\",\"wc_appsecret\":\"4594e0ced6ce00ccaf257644cec92109\",\"wc_token\":\"mYyPYPwBR38G5p88\"}','2019-02-19 10:09:46');
/*!40000 ALTER TABLE `wl_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wl_manager`
--

DROP TABLE IF EXISTS `wl_manager`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wl_manager`
--

LOCK TABLES `wl_manager` WRITE;
/*!40000 ALTER TABLE `wl_manager` DISABLE KEYS */;
INSERT INTO `wl_manager` VALUES (1,'serena','$2y$10$xIONNGE2jWEvtlpGTspC8.FA.8W3mcZ1T5Rol.hBYeMbaO1aiv5oO',1,'2018-11-26 02:25:06',1,1),(2,'admin2','$2y$10$xIONNGE2jWEvtlpGTspC8.FA.8W3mcZ1T5Rol.hBYeMbaO1aiv5oO',0,'2018-12-14 09:51:46',1,1),(3,'admin3','$2y$10$xIONNGE2jWEvtlpGTspC8.FA.8W3mcZ1T5Rol.hBYeMbaO1aiv5oO',2,'2018-12-14 09:51:46',1,1),(4,'admin4','$2y$10$xIONNGE2jWEvtlpGTspC8.FA.8W3mcZ1T5Rol.hBYeMbaO1aiv5oO',0,'2018-12-14 09:51:46',1,1),(5,'admin5','$2y$10$xIONNGE2jWEvtlpGTspC8.FA.8W3mcZ1T5Rol.hBYeMbaO1aiv5oO',1,'2018-12-14 09:51:46',1,1),(6,'admin6','$2y$10$xIONNGE2jWEvtlpGTspC8.FA.8W3mcZ1T5Rol.hBYeMbaO1aiv5oO',0,'2018-12-14 09:51:46',1,1),(7,'admin7','$2y$10$xIONNGE2jWEvtlpGTspC8.FA.8W3mcZ1T5Rol.hBYeMbaO1aiv5oO',2,'2018-12-14 09:51:46',1,1),(8,'admin8','$2y$10$xIONNGE2jWEvtlpGTspC8.FA.8W3mcZ1T5Rol.hBYeMbaO1aiv5oO',0,'2018-12-14 09:51:46',1,1),(9,'admin9','$2y$10$xIONNGE2jWEvtlpGTspC8.FA.8W3mcZ1T5Rol.hBYeMbaO1aiv5oO',2,'2018-12-14 09:51:46',1,1),(10,'admin10','$2y$10$xIONNGE2jWEvtlpGTspC8.FA.8W3mcZ1T5Rol.hBYeMbaO1aiv5oO',0,'2018-12-14 09:51:46',1,1),(13,'admin','$2y$10$1GaSULRb.ql0liqiJ875teHUaQVPFNl2l0w9hM5Bv0e4bG30eBlay',0,'2019-02-14 15:13:48',2,2),(14,'admin1','$2y$10$TrDJ0MUR42ZS4.hfkx9Y8.3c6XYkd9S9FlszNjVSdV0zvBUlAU7Iq',0,'2019-02-14 15:14:49',2,2);
/*!40000 ALTER TABLE `wl_manager` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wl_massage_personnel`
--

DROP TABLE IF EXISTS `wl_massage_personnel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wl_massage_personnel`
--

LOCK TABLES `wl_massage_personnel` WRITE;
/*!40000 ALTER TABLE `wl_massage_personnel` DISABLE KEYS */;
INSERT INTO `wl_massage_personnel` VALUES (1,1,'梁世兰','$2y$10$P1y3HV6JkEpPGhvVjfHCdOT4YnDEuXCYLHhss5uUbXdRV0vI6uvfW','liangshilan',1,'2019-03-13 02:54:43'),(2,1,'何宝娣','$2y$10$9RzyXRSRPwqDq/NfsjclGe6sPmxMmygNI.tVmZsy/xIdeZNAJ8OkO','hebaodi',1,'2019-03-13 02:57:49'),(3,2,'齐晓明','$2y$10$0edKnGuaVhG2pV0mmsCVLOXEXHwcEVhSYKY1g792rpFkO2lY6HKt6','qixiaoming',1,'2019-03-13 02:58:01'),(4,1,'李弯','$2y$10$sRAmad4GLiUnEAGofEld.uySOxDSphjvW1/Zi1e1TQ4YcgJomdITe','liwan',1,'2019-03-13 02:58:37'),(5,1,'刘坤','$2y$10$hZ4kdop2gTmp/toL8jEBhud/RQbMVioBiYI4Z24TIjfdAsgbu48ye','liukun',3,'2019-03-13 03:12:16');
/*!40000 ALTER TABLE `wl_massage_personnel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wl_massage_rest`
--

DROP TABLE IF EXISTS `wl_massage_rest`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wl_massage_rest` (
  `mr_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '推拿员工休息id',
  `mr_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '推拿员工休息时间',
  `mr_mpId` int(11) NOT NULL COMMENT '推拿员工id',
  `mr_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '推拿休息时间添加时间',
  PRIMARY KEY (`mr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8 COMMENT='推拿员工休息表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wl_massage_rest`
--

LOCK TABLES `wl_massage_rest` WRITE;
/*!40000 ALTER TABLE `wl_massage_rest` DISABLE KEYS */;
INSERT INTO `wl_massage_rest` VALUES (1,'2019-01-29 16:00:00',2,'2019-03-14 09:01:03'),(2,'2019-01-29 16:00:00',1,'2019-03-14 09:01:22'),(3,'2019-01-29 16:00:00',3,'2019-03-14 09:01:27'),(4,'2019-01-30 16:00:00',2,'2019-03-14 09:20:41'),(5,'2019-01-30 16:00:00',1,'2019-03-14 09:21:06'),(6,'2019-01-31 16:00:00',2,'2019-03-14 09:21:19'),(7,'2019-01-31 16:00:00',1,'2019-03-14 09:21:24'),(8,'2019-01-31 16:00:00',3,'2019-03-14 09:21:29'),(9,'2019-02-01 16:00:00',3,'2019-03-14 09:21:35'),(10,'2019-02-01 16:00:00',1,'2019-03-14 09:21:41'),(11,'2019-02-01 16:00:00',2,'2019-03-14 09:21:45'),(12,'2019-02-02 16:00:00',1,'2019-03-14 09:24:38'),(13,'2019-02-02 16:00:00',2,'2019-03-14 09:24:41'),(14,'2019-02-02 16:00:00',3,'2019-03-14 09:24:47'),(15,'2019-02-03 16:00:00',2,'2019-03-14 09:33:01'),(16,'2019-02-03 16:00:00',1,'2019-03-14 09:33:13'),(17,'2019-02-03 16:00:00',3,'2019-03-14 09:33:18'),(18,'2019-02-04 16:00:00',1,'2019-03-14 09:33:26'),(19,'2019-02-04 16:00:00',2,'2019-03-14 09:33:28'),(20,'2019-02-04 16:00:00',3,'2019-03-14 09:33:32'),(21,'2019-02-05 16:00:00',2,'2019-03-14 09:33:39'),(22,'2019-02-05 16:00:00',1,'2019-03-14 09:33:45'),(23,'2019-02-06 16:00:00',1,'2019-03-14 09:33:47'),(24,'2019-02-07 16:00:00',1,'2019-03-14 09:33:53'),(25,'2019-02-08 16:00:00',1,'2019-03-14 09:33:56'),(26,'2019-02-09 16:00:00',1,'2019-03-14 09:34:00'),(27,'2019-02-10 16:00:00',1,'2019-03-14 09:34:04'),(28,'2019-02-11 16:00:00',1,'2019-03-14 09:34:07'),(29,'2019-02-06 16:00:00',2,'2019-03-14 09:34:24'),(30,'2019-02-07 16:00:00',2,'2019-03-14 09:34:30'),(31,'2019-02-05 16:00:00',3,'2019-03-14 09:34:44'),(32,'2019-02-06 16:00:00',3,'2019-03-14 09:34:49'),(33,'2019-02-07 16:00:00',3,'2019-03-14 09:34:52'),(34,'2019-02-21 16:00:00',3,'2019-03-14 09:34:58'),(35,'2019-03-03 16:00:00',2,'2019-03-14 09:35:13'),(36,'2019-03-14 16:00:00',3,'2019-03-14 09:35:23'),(37,'2019-03-15 16:00:00',3,'2019-03-14 09:35:25'),(38,'2019-03-16 16:00:00',3,'2019-03-14 09:35:27'),(39,'2019-02-25 16:00:00',4,'2019-03-14 09:41:00');
/*!40000 ALTER TABLE `wl_massage_rest` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wl_massage_store`
--

DROP TABLE IF EXISTS `wl_massage_store`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wl_massage_store` (
  `ms_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '推拿门店id',
  `ms_name` varchar(255) NOT NULL COMMENT '推拿门店名称',
  `ms_phone` char(11) NOT NULL COMMENT '推拿门店电话',
  `ms_address` varchar(255) NOT NULL COMMENT '推拿门店地址',
  `ms_workShift` text NOT NULL COMMENT '推拿门店上班时间',
  `ms_pic` varchar(255) DEFAULT NULL COMMENT '推拿门店图片',
  `ms_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '推拿门店添加时间',
  PRIMARY KEY (`ms_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='门店推拿(门店列表)';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wl_massage_store`
--

LOCK TABLES `wl_massage_store` WRITE;
/*!40000 ALTER TABLE `wl_massage_store` DISABLE KEYS */;
INSERT INTO `wl_massage_store` VALUES (1,'金沙店乐婴岛','18927543087','广东省广州市海珠区金沙路16至20号首层商铺自编之十二','0,1,2,3,4,5,6,10,11,12,13,14,15,16,17,18,19','./static/uploads/store_massage/20190307\\e931a095c4a16e5422d96fed044ec2b7.png','2019-03-08 08:32:23'),(2,'万达店乐婴岛','17728026810','桂城街道桂澜北路28号南海万达广场南7栋235号铺','0,1,2,3,4,5,6,9,10,11,12,13,14,15,16,17,18,19,20,21','./static/uploads/store_massage/20190307\\6e24f8e6c608b8fd3ac6fd63d0650a97.jpg','2019-03-08 08:33:25');
/*!40000 ALTER TABLE `wl_massage_store` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wl_store`
--

DROP TABLE IF EXISTS `wl_store`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wl_store` (
  `s_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '门店id',
  `s_name` varchar(255) NOT NULL COMMENT '门店名称',
  `s_phone` char(11) NOT NULL COMMENT '门店电话',
  `s_pic` varchar(255) DEFAULT NULL COMMENT '门店图片',
  `s_address` varchar(255) NOT NULL COMMENT '门店地址',
  `s_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '门店添加时间',
  PRIMARY KEY (`s_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='门店信息表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wl_store`
--

LOCK TABLES `wl_store` WRITE;
/*!40000 ALTER TABLE `wl_store` DISABLE KEYS */;
INSERT INTO `wl_store` VALUES (1,'金沙店乐婴岛','18927543087','./static/uploads/store/20190306\\f415ff7ce750cb5c01175db33222ec90.png','广东省广州市海珠区金沙路16至20号首层商铺自编之十二','2019-03-06 02:34:43'),(2,'万达店乐婴岛','17728026810','./static/uploads/store/20190306\\312193fdfcf570fa778aff40bae550ac.jpg','桂城街道桂澜北路28号南海万达广场南7栋235号铺','2019-03-06 02:37:28');
/*!40000 ALTER TABLE `wl_store` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-03-14 18:45:43
