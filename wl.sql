-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: 2019-05-20 00:58:48
-- 服务器版本： 5.7.26-0ubuntu0.18.04.1
-- PHP Version: 7.2.18-1+ubuntu18.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wl`
--

-- --------------------------------------------------------

--
-- 表的结构 `wl_auth_group`
--

CREATE TABLE `wl_auth_group` (
  `ag_id` mediumint(8) UNSIGNED NOT NULL,
  `ag_title` char(100) NOT NULL DEFAULT '' COMMENT '用户组中文名称',
  `ag_describe` text COMMENT '角色描述',
  `ag_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：为1正常，为2禁用',
  `ag_rules` varchar(255) NOT NULL DEFAULT '' COMMENT '用户组拥有的规则id， 多个规则用","隔开',
  `ag_addTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '添加时间',
  `ag_delete` tinyint(2) NOT NULL DEFAULT '1' COMMENT '是否删除 1是不删除 2是删除'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='后台角色表';

--
-- 转存表中的数据 `wl_auth_group`
--

INSERT INTO `wl_auth_group` (`ag_id`, `ag_title`, `ag_describe`, `ag_status`, `ag_rules`, `ag_addTime`, `ag_delete`) VALUES
(1, '超级管理员', '拥有全部权限', 1, '1,2,3,4,19,25,11,12,13,15,14,16,17,18,9,10,23,26,22,27,21,28,24,30,20,29,5,6', '2019-03-04 02:58:12', 1),
(2, '管理员', '拥有部分权限', 1, '1,2,3,4', '2019-01-26 03:13:07', 1),
(3, '金沙店', '', 1, '', '2019-01-26 04:07:31', 1),
(4, '万达店', '', 1, '', '2019-01-26 04:07:36', 1),
(5, '荔骏会', '', 1, '', '2019-01-26 04:07:38', 1),
(6, '门店小儿推拿', '', 1, '1,2,3,4', '2019-05-18 17:23:19', 1);

-- --------------------------------------------------------

--
-- 表的结构 `wl_auth_group_access`
--

CREATE TABLE `wl_auth_group_access` (
  `uid` mediumint(8) UNSIGNED NOT NULL COMMENT '管理员id',
  `group_id` mediumint(8) UNSIGNED NOT NULL COMMENT '用户组id'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='后台管理员和角色表';

--
-- 转存表中的数据 `wl_auth_group_access`
--

INSERT INTO `wl_auth_group_access` (`uid`, `group_id`) VALUES
(1, 1),
(2, 2),
(3, 2),
(4, 2),
(5, 3),
(6, 3),
(7, 4),
(8, 4),
(9, 5),
(10, 5),
(13, 2),
(14, 2);

-- --------------------------------------------------------

--
-- 表的结构 `wl_auth_rule`
--

CREATE TABLE `wl_auth_rule` (
  `ar_id` mediumint(8) UNSIGNED NOT NULL,
  `ar_pid` int(10) NOT NULL COMMENT '父节点',
  `ar_name` char(80) NOT NULL DEFAULT '' COMMENT '规则唯一标识',
  `ar_title` char(20) NOT NULL DEFAULT '' COMMENT '规则中文名称',
  `ar_type` tinyint(1) NOT NULL DEFAULT '1',
  `ar_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：为1正常，为2禁用',
  `ar_condition` char(100) NOT NULL DEFAULT '' COMMENT '规则表达式，为空表示存在就验证，不为空表示按照条件验证',
  `ar_icon` varchar(255) DEFAULT NULL COMMENT '顶级类是的icon',
  `ar_sort` int(50) DEFAULT '1' COMMENT '排序',
  `ar_addTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '添加时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='后台管理员权限表';

--
-- 转存表中的数据 `wl_auth_rule`
--

INSERT INTO `wl_auth_rule` (`ar_id`, `ar_pid`, `ar_name`, `ar_title`, `ar_type`, `ar_status`, `ar_condition`, `ar_icon`, `ar_sort`, `ar_addTime`) VALUES
(1, 0, 'Manager', '管理员管理', 1, 1, '', 'fa-users', 1, '2019-01-25 09:56:16'),
(2, 1, 'managerView', '管理员列表', 1, 1, '', NULL, 1, '2019-01-26 04:22:10'),
(3, 1, 'roleView', '角色列表', 1, 1, '', NULL, 2, '2019-01-26 02:03:20'),
(4, 1, 'authView', '权限列表', 1, 1, '', NULL, 3, '2019-01-25 09:01:00'),
(5, 0, 'System', '系统管理', 1, 2, '', 'fa-gear', 11, '2019-03-12 02:43:45'),
(6, 5, 'SystemView', '系统设置', 1, 1, '', '', 1, '2019-02-19 03:27:17'),
(9, 0, 'WeChat', '微信管理', 1, 1, '', 'fa-weixin', 5, '2019-03-18 08:26:49'),
(10, 9, 'weChatView', '微信基础设置', 1, 1, '', '', 1, '2019-02-19 09:07:59'),
(11, 0, 'Store', '门店管理', 1, 1, '', 'fa-university', 3, '2019-03-18 02:18:55'),
(12, 11, 'storeListView', '门店列表', 1, 1, '', '', 1, '2019-02-20 02:30:55'),
(13, 0, 'StoreMassage', '门店推拿管理', 1, 1, '', 'fa-university', 4, '2019-04-09 02:07:09'),
(14, 13, 'staff_list_view', '员工列表', 1, 1, '', '', 2, '2019-03-07 08:58:26'),
(15, 13, 'store_massage_list_view', '推拿门店列表', 1, 1, '', '', 1, '2019-03-07 08:24:05'),
(16, 13, 'scheduling_view', '排班设置', 1, 1, '', '', 3, '2019-03-13 03:40:34'),
(17, 13, 'subscribe_list_view', '预约列表', 1, 1, '', '', 4, '2019-05-05 14:51:03'),
(18, 13, 'PushSettings', '推送设置', 1, 1, '', '', 5, '2019-03-01 07:40:49'),
(19, 0, 'Member', '会员管理', 1, 2, '', 'fa-user', 2, '2019-03-12 02:43:26'),
(20, 0, 'Logistics', '物流管理', 1, 2, '', 'fa-truck', 10, '2019-03-12 02:43:43'),
(21, 0, 'Stock', '库存管理', 1, 2, '', 'fa-cubes', 8, '2019-03-12 02:43:38'),
(22, 0, 'Presell', '预售管理', 1, 2, '', 'fa-calendar-check-o', 7, '2019-03-12 02:43:36'),
(23, 0, 'Knead', '荔骏会管理', 1, 2, '', 'fa-hand-lizard-o', 6, '2019-03-12 02:43:34'),
(24, 0, 'Book', '订货管理', 1, 2, '', 'fa-book', 9, '2019-03-12 02:43:41'),
(25, 19, 'UserView', '会员列表', 1, 1, '', '', 1, '2019-03-04 02:54:49'),
(26, 23, 'projectView', '项目列表', 1, 1, '', '', 1, '2019-03-04 02:55:53'),
(27, 22, 'presellView', '预售列表', 1, 1, '', '', 1, '2019-03-04 02:56:18'),
(28, 21, 'warehouseView', '仓库列表', 1, 1, '', '', 1, '2019-03-04 02:56:52'),
(29, 20, 'logisticsView', '物流列表', 1, 1, '', '', 1, '2019-03-04 02:57:13'),
(30, 24, 'bookView', '订货列表', 1, 1, '', '', 1, '2019-03-04 02:57:35');

-- --------------------------------------------------------

--
-- 表的结构 `wl_config`
--

CREATE TABLE `wl_config` (
  `c_id` int(10) NOT NULL COMMENT '配置id',
  `c_key` varchar(255) NOT NULL COMMENT '系统配置键',
  `c_value` text NOT NULL COMMENT '系统配置value',
  `c_addTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '系统配置时间'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='配置表';

--
-- 转存表中的数据 `wl_config`
--

INSERT INTO `wl_config` (`c_id`, `c_key`, `c_value`, `c_addTime`) VALUES
(1, 'weChat', '{\"wc_appid\":\"wxc7d11a087b99ecdf\",\"wc_appsecret\":\"ad935003349978f8d1c4fa7746d28407\",\"wc_token\":\"mYyPYPwBR38G5p88\"}', '2019-02-19 10:09:46');

-- --------------------------------------------------------

--
-- 表的结构 `wl_manager`
--

CREATE TABLE `wl_manager` (
  `m_id` int(10) NOT NULL COMMENT '管理员id',
  `m_name` varchar(50) NOT NULL COMMENT '管理员名称',
  `m_password` varchar(255) NOT NULL COMMENT '管理员密码 (password_hash加密)',
  `m_sex` tinyint(1) NOT NULL DEFAULT '0' COMMENT '性别：  0 保密 1 男 2 女',
  `m_addTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '添加时间',
  `m_state` tinyint(1) NOT NULL DEFAULT '1' COMMENT '管理员状态 1为启用，2为禁用',
  `m_delete` tinyint(1) NOT NULL DEFAULT '1' COMMENT '管理员是否删除 1为存在，2为删除(可以恢复状态)'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='管理员员工表';

--
-- 转存表中的数据 `wl_manager`
--

INSERT INTO `wl_manager` (`m_id`, `m_name`, `m_password`, `m_sex`, `m_addTime`, `m_state`, `m_delete`) VALUES
(1, 'serena', '$2y$10$xIONNGE2jWEvtlpGTspC8.FA.8W3mcZ1T5Rol.hBYeMbaO1aiv5oO', 1, '2018-11-26 02:25:06', 1, 1),
(2, 'admin2', '$2y$10$xIONNGE2jWEvtlpGTspC8.FA.8W3mcZ1T5Rol.hBYeMbaO1aiv5oO', 0, '2018-12-14 09:51:46', 1, 1),
(3, 'admin3', '$2y$10$xIONNGE2jWEvtlpGTspC8.FA.8W3mcZ1T5Rol.hBYeMbaO1aiv5oO', 2, '2018-12-14 09:51:46', 1, 1),
(4, 'admin4', '$2y$10$xIONNGE2jWEvtlpGTspC8.FA.8W3mcZ1T5Rol.hBYeMbaO1aiv5oO', 0, '2018-12-14 09:51:46', 1, 1),
(5, 'admin5', '$2y$10$xIONNGE2jWEvtlpGTspC8.FA.8W3mcZ1T5Rol.hBYeMbaO1aiv5oO', 1, '2018-12-14 09:51:46', 1, 1),
(6, 'admin6', '$2y$10$xIONNGE2jWEvtlpGTspC8.FA.8W3mcZ1T5Rol.hBYeMbaO1aiv5oO', 0, '2018-12-14 09:51:46', 1, 1),
(7, 'admin7', '$2y$10$xIONNGE2jWEvtlpGTspC8.FA.8W3mcZ1T5Rol.hBYeMbaO1aiv5oO', 2, '2018-12-14 09:51:46', 1, 1),
(8, 'admin8', '$2y$10$xIONNGE2jWEvtlpGTspC8.FA.8W3mcZ1T5Rol.hBYeMbaO1aiv5oO', 0, '2018-12-14 09:51:46', 1, 1),
(9, 'admin9', '$2y$10$xIONNGE2jWEvtlpGTspC8.FA.8W3mcZ1T5Rol.hBYeMbaO1aiv5oO', 2, '2019-04-08 09:19:52', 2, 1),
(10, 'admin10', '$2y$10$xIONNGE2jWEvtlpGTspC8.FA.8W3mcZ1T5Rol.hBYeMbaO1aiv5oO', 0, '2018-12-14 09:51:46', 1, 1),
(13, 'admin', '$2y$10$1GaSULRb.ql0liqiJ875teHUaQVPFNl2l0w9hM5Bv0e4bG30eBlay', 0, '2019-02-14 15:13:48', 2, 2),
(14, 'admin1', '$2y$10$TrDJ0MUR42ZS4.hfkx9Y8.3c6XYkd9S9FlszNjVSdV0zvBUlAU7Iq', 0, '2019-02-14 15:14:49', 2, 2);

-- --------------------------------------------------------

--
-- 表的结构 `wl_massage_personnel`
--

CREATE TABLE `wl_massage_personnel` (
  `mp_id` int(10) NOT NULL COMMENT '推拿门店员工id',
  `mp_msId` int(10) NOT NULL COMMENT '推拿门店id',
  `mp_name` varchar(255) NOT NULL COMMENT '推拿门店员工名称',
  `mp_password` varchar(255) NOT NULL COMMENT '推拿员工登录密码 (password_hash加密）',
  `mp_spell` varchar(255) NOT NULL COMMENT '推拿员工名称拼音',
  `mp_workShift` tinyint(1) NOT NULL DEFAULT '1' COMMENT '推拿员工上班时间（1 全天  2  上午  3 下午）',
  `mp_state` int(1) NOT NULL DEFAULT '1' COMMENT '推拿员工状态 1为启用，2为禁用',
  `mp_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '添加时间',
  `mp_delete` tinyint(1) NOT NULL DEFAULT '1' COMMENT '推拿门店员工是否删除 1为存在，2为删除(可以恢复状态)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='推拿门店员工';

--
-- 转存表中的数据 `wl_massage_personnel`
--

INSERT INTO `wl_massage_personnel` (`mp_id`, `mp_msId`, `mp_name`, `mp_password`, `mp_spell`, `mp_workShift`, `mp_state`, `mp_time`, `mp_delete`) VALUES
(1, 1, '梁世兰', '$2y$10$P1y3HV6JkEpPGhvVjfHCdOT4YnDEuXCYLHhss5uUbXdRV0vI6uvfW', 'liangshilan', 1, 1, '2019-03-13 02:54:43', 1),
(2, 1, '何宝娣', '$2y$10$9RzyXRSRPwqDq/NfsjclGe6sPmxMmygNI.tVmZsy/xIdeZNAJ8OkO', 'hebaodi', 1, 1, '2019-03-13 02:57:49', 1),
(3, 2, '齐晓明', '$2y$10$0edKnGuaVhG2pV0mmsCVLOXEXHwcEVhSYKY1g792rpFkO2lY6HKt6', 'qixiaoming', 1, 1, '2019-03-13 02:58:01', 1),
(4, 1, '李弯', '$2y$10$sRAmad4GLiUnEAGofEld.uySOxDSphjvW1/Zi1e1TQ4YcgJomdITe', 'liwan', 1, 1, '2019-03-13 02:58:37', 1),
(5, 1, '刘坤', '$2y$10$hZ4kdop2gTmp/toL8jEBhud/RQbMVioBiYI4Z24TIjfdAsgbu48ye', 'liukun', 3, 1, '2019-03-13 03:12:16', 1);

-- --------------------------------------------------------

--
-- 表的结构 `wl_massage_reser`
--

CREATE TABLE `wl_massage_reser` (
  `mr_id` int(10) NOT NULL COMMENT '预约时间id',
  `mr_uid` int(10) NOT NULL COMMENT '用户id',
  `mr_msid` int(10) NOT NULL COMMENT '门店id',
  `mr_name` char(50) NOT NULL COMMENT '宝宝名称',
  `mr_time` int(10) NOT NULL COMMENT '小儿推拿预约时间',
  `mr_phone` varchar(20) NOT NULL COMMENT '预约手机号码',
  `mr_remarks` text COMMENT '推拿备注',
  `mr_state` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 1 预约 2 删除',
  `mr_addTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '推拿预约添加时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='门店小儿推拿预约表';

--
-- 转存表中的数据 `wl_massage_reser`
--

INSERT INTO `wl_massage_reser` (`mr_id`, `mr_uid`, `mr_msid`, `mr_name`, `mr_time`, `mr_phone`, `mr_remarks`, `mr_state`, `mr_addTime`) VALUES
(1, 1, 1, 'serena', 1556589600, '13800138000', NULL, 1, '2019-04-29 10:32:53'),
(2, 1, 1, 'serena', 1556591400, '13800138000', NULL, 1, '2019-04-29 10:33:07'),
(3, 1, 2, 'serena', 1556595000, '13800138000', NULL, 1, '2019-04-29 10:33:20'),
(4, 1, 2, 'serena', 1556092800, '13800138000', NULL, 1, '2019-04-23 07:12:34'),
(5, 1, 1, 'serena', 1556274600, '13800138000', NULL, 1, '2019-04-26 09:46:22'),
(6, 1, 2, 'serena', 1556361000, '13800138000', NULL, 1, '2019-04-29 10:33:33'),
(7, 1, 2, 'serena', 1556359200, '13800138000', NULL, 1, '2019-04-29 10:33:39'),
(8, 1, 1, 'serena', 1556359200, '13800138000', '', 1, '2019-04-29 10:33:41'),
(9, 1, 1, 'serena', 1556359200, '13800138000', '', 2, '2019-04-29 10:33:43'),
(10, 1, 1, '测试', 1556933400, '13800138000', ' 测试                           ', 1, '2019-05-01 09:05:53'),
(11, 1, 2, '测试', 1557831600, '13800138000', '   测试数据                         ', 1, '2019-05-01 09:13:57');

-- --------------------------------------------------------

--
-- 表的结构 `wl_massage_rest`
--

CREATE TABLE `wl_massage_rest` (
  `mr_id` int(10) NOT NULL COMMENT '推拿员工休息id',
  `mr_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '推拿员工休息时间',
  `mr_mpId` int(11) NOT NULL COMMENT '推拿员工id',
  `mr_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '推拿休息时间添加时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='推拿员工休息表';

--
-- 转存表中的数据 `wl_massage_rest`
--

INSERT INTO `wl_massage_rest` (`mr_id`, `mr_date`, `mr_mpId`, `mr_time`) VALUES
(1, '2019-01-29 16:00:00', 2, '2019-03-14 09:01:03'),
(2, '2019-01-29 16:00:00', 1, '2019-03-14 09:01:22'),
(3, '2019-01-29 16:00:00', 3, '2019-03-14 09:01:27'),
(4, '2019-01-30 16:00:00', 2, '2019-03-14 09:20:41'),
(5, '2019-01-30 16:00:00', 1, '2019-03-14 09:21:06'),
(6, '2019-01-31 16:00:00', 2, '2019-03-14 09:21:19'),
(7, '2019-01-31 16:00:00', 1, '2019-03-14 09:21:24'),
(8, '2019-01-31 16:00:00', 3, '2019-03-14 09:21:29'),
(9, '2019-02-01 16:00:00', 3, '2019-03-14 09:21:35'),
(10, '2019-02-01 16:00:00', 1, '2019-03-14 09:21:41'),
(11, '2019-02-01 16:00:00', 2, '2019-03-14 09:21:45'),
(12, '2019-02-02 16:00:00', 1, '2019-03-14 09:24:38'),
(13, '2019-02-02 16:00:00', 2, '2019-03-14 09:24:41'),
(14, '2019-02-02 16:00:00', 3, '2019-03-14 09:24:47'),
(15, '2019-02-03 16:00:00', 2, '2019-03-14 09:33:01'),
(16, '2019-02-03 16:00:00', 1, '2019-03-14 09:33:13'),
(17, '2019-02-03 16:00:00', 3, '2019-03-14 09:33:18'),
(18, '2019-02-04 16:00:00', 1, '2019-03-14 09:33:26'),
(19, '2019-02-04 16:00:00', 2, '2019-03-14 09:33:28'),
(20, '2019-02-04 16:00:00', 3, '2019-03-14 09:33:32'),
(21, '2019-02-05 16:00:00', 2, '2019-03-14 09:33:39'),
(22, '2019-02-05 16:00:00', 1, '2019-03-14 09:33:45'),
(23, '2019-02-06 16:00:00', 1, '2019-03-14 09:33:47'),
(24, '2019-02-07 16:00:00', 1, '2019-03-14 09:33:53'),
(25, '2019-02-08 16:00:00', 1, '2019-03-14 09:33:56'),
(26, '2019-02-09 16:00:00', 1, '2019-03-14 09:34:00'),
(27, '2019-02-10 16:00:00', 1, '2019-03-14 09:34:04'),
(28, '2019-02-11 16:00:00', 1, '2019-03-14 09:34:07'),
(29, '2019-02-06 16:00:00', 2, '2019-03-14 09:34:24'),
(30, '2019-02-07 16:00:00', 2, '2019-03-14 09:34:30'),
(31, '2019-02-05 16:00:00', 3, '2019-03-14 09:34:44'),
(32, '2019-02-06 16:00:00', 3, '2019-03-14 09:34:49'),
(33, '2019-02-07 16:00:00', 3, '2019-03-14 09:34:52'),
(34, '2019-02-21 16:00:00', 3, '2019-03-14 09:34:58'),
(35, '2019-03-03 16:00:00', 2, '2019-03-14 09:35:13'),
(36, '2019-03-14 16:00:00', 3, '2019-03-14 09:35:23'),
(37, '2019-03-15 16:00:00', 3, '2019-03-14 09:35:25'),
(38, '2019-03-16 16:00:00', 3, '2019-03-14 09:35:27'),
(40, '2019-05-05 16:00:00', 2, '2019-04-22 03:27:12'),
(41, '2019-05-08 16:00:00', 1, '2019-04-22 03:27:22'),
(42, '2019-05-09 16:00:00', 1, '2019-04-22 03:27:26'),
(43, '2019-05-10 16:00:00', 1, '2019-04-22 03:27:36'),
(44, '2019-04-29 16:00:00', 2, '2019-04-22 03:27:47'),
(45, '2019-04-28 16:00:00', 2, '2019-04-22 03:27:51'),
(46, '2019-04-26 16:00:00', 2, '2019-04-22 03:27:56'),
(47, '2019-04-24 16:00:00', 2, '2019-04-22 03:28:00'),
(48, '2019-05-12 16:00:00', 2, '2019-04-22 03:33:39'),
(49, '2019-05-19 16:00:00', 2, '2019-04-22 03:33:42'),
(50, '2019-05-15 16:00:00', 1, '2019-04-22 03:33:48'),
(51, '2019-05-22 16:00:00', 1, '2019-04-22 03:33:52'),
(52, '2019-05-29 16:00:00', 1, '2019-04-22 03:33:57'),
(53, '2019-05-26 16:00:00', 2, '2019-04-22 03:34:16'),
(54, '2019-04-24 16:00:00', 3, '2019-04-22 06:51:54');

-- --------------------------------------------------------

--
-- 表的结构 `wl_massage_store`
--

CREATE TABLE `wl_massage_store` (
  `ms_id` int(10) NOT NULL COMMENT '推拿门店id',
  `ms_name` varchar(255) NOT NULL COMMENT '推拿门店名称',
  `ms_phone` char(11) NOT NULL COMMENT '推拿门店电话',
  `ms_address` varchar(255) NOT NULL COMMENT '推拿门店地址',
  `ms_number` char(50) NOT NULL COMMENT '上班人数',
  `ms_slot` char(50) NOT NULL COMMENT '可预约时段',
  `ms_workShift` text NOT NULL COMMENT '推拿门店上班时间',
  `ms_pic` varchar(255) DEFAULT NULL COMMENT '推拿门店图片',
  `ms_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '推拿门店添加时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='门店推拿(门店列表)';

--
-- 转存表中的数据 `wl_massage_store`
--

INSERT INTO `wl_massage_store` (`ms_id`, `ms_name`, `ms_phone`, `ms_address`, `ms_number`, `ms_slot`, `ms_workShift`, `ms_pic`, `ms_time`) VALUES
(1, '金沙店乐婴岛', '18927543087', '广东省广州市海珠区金沙路16至20号首层商铺自编之十二', '3', '15', '0,1,2,3,4,5,6,10,11,12,13,14,15,16,17,18,19', './static/uploads/store_massage/20190307\\e931a095c4a16e5422d96fed044ec2b7.png', '2019-04-22 03:07:56'),
(2, '万达店乐婴岛', '17728026810', '桂城街道桂澜北路28号南海万达广场南7栋235号铺', '1', '15', '0,1,2,3,4,5,6,9,10,11,12,13,14,15,16,17,18,19,20,21', './static/uploads/store_massage/20190307\\312193fdfcf570fa778aff40bae550ac.jpg', '2019-04-22 03:07:58');

-- --------------------------------------------------------

--
-- 表的结构 `wl_store`
--

CREATE TABLE `wl_store` (
  `s_id` int(10) NOT NULL COMMENT '门店id',
  `s_name` varchar(255) NOT NULL COMMENT '门店名称',
  `s_phone` char(11) NOT NULL COMMENT '门店电话',
  `s_pic` varchar(255) DEFAULT NULL COMMENT '门店图片',
  `s_address` varchar(255) NOT NULL COMMENT '门店地址',
  `s_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '门店添加时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='门店信息表';

--
-- 转存表中的数据 `wl_store`
--

INSERT INTO `wl_store` (`s_id`, `s_name`, `s_phone`, `s_pic`, `s_address`, `s_time`) VALUES
(1, '金沙店乐婴岛', '18927543087', './static/uploads/store/20190306\\f415ff7ce750cb5c01175db33222ec90.png', '广东省广州市海珠区金沙路16至20号首层商铺自编之十二', '2019-03-06 02:34:43'),
(2, '万达店乐婴岛', '17728026810', './static/uploads/store/20190306\\312193fdfcf570fa778aff40bae550ac.jpg', '桂城街道桂澜北路28号南海万达广场南7栋235号铺', '2019-03-06 02:37:28');

-- --------------------------------------------------------

--
-- 表的结构 `wl_store_personnel`
--

CREATE TABLE `wl_store_personnel` (
  `sp_id` int(10) NOT NULL COMMENT '门店员工id',
  `sp_sId` int(10) NOT NULL COMMENT '门店id',
  `sp_name` varchar(255) NOT NULL COMMENT '门店员工名称',
  `sp_password` varchar(255) NOT NULL COMMENT '员工登录密码 (password_hash加密）',
  `sp_spell` varchar(255) NOT NULL COMMENT '员工名称拼音',
  `sp_state` int(1) NOT NULL DEFAULT '1' COMMENT '员工状态 1为启用，2为禁用',
  `sp_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '添加时间',
  `sp_delete` tinyint(1) NOT NULL DEFAULT '1' COMMENT '门店员工是否删除 1为存在，2为删除(可以恢复状态)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='门店员工';

-- --------------------------------------------------------

--
-- 表的结构 `wl_users`
--

CREATE TABLE `wl_users` (
  `u_user_id` mediumint(8) UNSIGNED NOT NULL COMMENT '表id',
  `u_password` varchar(255) NOT NULL DEFAULT '' COMMENT '密码',
  `u_sex` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '0 保密 1 男 2 女',
  `u_mobile` varchar(20) DEFAULT NULL COMMENT '手机号码',
  `u_oauth` varchar(10) DEFAULT '' COMMENT '第三方来源 wx weibo alipay',
  `u_openid` varchar(100) DEFAULT NULL COMMENT '第三方唯一标示',
  `u_unionId` varchar(100) DEFAULT NULL COMMENT '公众号和小程序共有的id',
  `u_head_pic` varchar(255) DEFAULT NULL COMMENT '头像',
  `u_country` char(50) DEFAULT '0' COMMENT '国家',
  `u_province` char(50) DEFAULT '0' COMMENT '省份',
  `u_city` char(50) DEFAULT '0' COMMENT '市区',
  `u_nickname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT '第三方返回昵称',
  `u_time` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '注册时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户表';

--
-- 转存表中的数据 `wl_users`
--

INSERT INTO `wl_users` (`u_user_id`, `u_password`, `u_sex`, `u_mobile`, `u_oauth`, `u_openid`, `u_unionId`, `u_head_pic`, `u_country`, `u_province`, `u_city`, `u_nickname`, `u_time`) VALUES
(1, '$2y$10$JRmYCmowj5X0w6Pxja5BXuc3Oa3hjN3OOMGJPljKHO6ITEbarG/py', 1, '13800138000', 'weixin', 'o_Aqa1OK0wuGazh3vhFyNfCcuUak', NULL, 'https://thirdwx.qlogo.cn/mmopen/vi_32/k3r9YIaWdlkax86PLglXP0bKnMEn3d9lHgyQJXfErQ7LnzrVrWQLxdxia0KStY0U4cjXngK241ck8PUFzAGVic4Q/132', '中国', '广东', '揭阳', 'Serena', '2019-04-29 04:16:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `wl_auth_group`
--
ALTER TABLE `wl_auth_group`
  ADD PRIMARY KEY (`ag_id`);

--
-- Indexes for table `wl_auth_group_access`
--
ALTER TABLE `wl_auth_group_access`
  ADD UNIQUE KEY `uid_group_id` (`uid`,`group_id`) USING BTREE,
  ADD KEY `uid` (`uid`) USING BTREE,
  ADD KEY `group_id` (`group_id`) USING BTREE;

--
-- Indexes for table `wl_auth_rule`
--
ALTER TABLE `wl_auth_rule`
  ADD PRIMARY KEY (`ar_id`);

--
-- Indexes for table `wl_config`
--
ALTER TABLE `wl_config`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `wl_manager`
--
ALTER TABLE `wl_manager`
  ADD PRIMARY KEY (`m_id`);

--
-- Indexes for table `wl_massage_personnel`
--
ALTER TABLE `wl_massage_personnel`
  ADD PRIMARY KEY (`mp_id`);

--
-- Indexes for table `wl_massage_reser`
--
ALTER TABLE `wl_massage_reser`
  ADD PRIMARY KEY (`mr_id`);

--
-- Indexes for table `wl_massage_rest`
--
ALTER TABLE `wl_massage_rest`
  ADD PRIMARY KEY (`mr_id`);

--
-- Indexes for table `wl_massage_store`
--
ALTER TABLE `wl_massage_store`
  ADD PRIMARY KEY (`ms_id`);

--
-- Indexes for table `wl_store`
--
ALTER TABLE `wl_store`
  ADD PRIMARY KEY (`s_id`);

--
-- Indexes for table `wl_users`
--
ALTER TABLE `wl_users`
  ADD PRIMARY KEY (`u_user_id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `wl_auth_group`
--
ALTER TABLE `wl_auth_group`
  MODIFY `ag_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- 使用表AUTO_INCREMENT `wl_auth_rule`
--
ALTER TABLE `wl_auth_rule`
  MODIFY `ar_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- 使用表AUTO_INCREMENT `wl_config`
--
ALTER TABLE `wl_config`
  MODIFY `c_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '配置id', AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `wl_manager`
--
ALTER TABLE `wl_manager`
  MODIFY `m_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '管理员id', AUTO_INCREMENT=15;
--
-- 使用表AUTO_INCREMENT `wl_massage_personnel`
--
ALTER TABLE `wl_massage_personnel`
  MODIFY `mp_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '推拿门店员工id', AUTO_INCREMENT=6;
--
-- 使用表AUTO_INCREMENT `wl_massage_reser`
--
ALTER TABLE `wl_massage_reser`
  MODIFY `mr_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '预约时间id', AUTO_INCREMENT=12;
--
-- 使用表AUTO_INCREMENT `wl_massage_rest`
--
ALTER TABLE `wl_massage_rest`
  MODIFY `mr_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '推拿员工休息id', AUTO_INCREMENT=55;
--
-- 使用表AUTO_INCREMENT `wl_massage_store`
--
ALTER TABLE `wl_massage_store`
  MODIFY `ms_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '推拿门店id', AUTO_INCREMENT=3;
--
-- 使用表AUTO_INCREMENT `wl_store`
--
ALTER TABLE `wl_store`
  MODIFY `s_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '门店id', AUTO_INCREMENT=3;
--
-- 使用表AUTO_INCREMENT `wl_users`
--
ALTER TABLE `wl_users`
  MODIFY `u_user_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '表id', AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
