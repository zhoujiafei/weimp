-- phpMyAdmin SQL Dump
-- version 3.5.2
-- http://www.phpmyadmin.net
--
-- 主机: 127.0.0.1
-- 生成日期: 2015 年 08 月 16 日 16:52
-- 服务器版本: 5.6.17
-- PHP 版本: 5.5.27

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `dev_weimp`
--

-- --------------------------------------------------------

--
-- 表的结构 `liv_cache`
--

CREATE TABLE IF NOT EXISTS `liv_cache` (
  `id` char(128) NOT NULL,
  `expire` int(11) DEFAULT NULL,
  `data` blob,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `liv_cache`
--
-- --------------------------------------------------------

--
-- 表的结构 `liv_custom_menus`
--

CREATE TABLE IF NOT EXISTS `liv_custom_menus` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `public_id` int(10) NOT NULL DEFAULT '0' COMMENT '所属公众号ID',
  `url` varchar(255) DEFAULT NULL COMMENT '关联URL',
  `keyword` varchar(100) DEFAULT NULL COMMENT '关联关键词',
  `title` varchar(50) NOT NULL COMMENT '菜单名',
  `fid` int(10) DEFAULT '0' COMMENT '父级菜单',
  `order_id` tinyint(4) DEFAULT '0' COMMENT '排序号',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  `type` varchar(30) NOT NULL DEFAULT 'click' COMMENT '类型',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `liv_members`
--

CREATE TABLE IF NOT EXISTS `liv_members` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `public_id` int(10) NOT NULL DEFAULT '0' COMMENT '所属公众号ID(系统内部)',
  `openid` varchar(60) NOT NULL COMMENT '发送方帐号（一个OpenID）',
  `nickname` varchar(30) NOT NULL COMMENT '用户昵称',
  `headimgurl` varchar(255) NOT NULL COMMENT '头像URL',
  `sex` tinyint(1) NOT NULL DEFAULT '1' COMMENT '性别：1男性 2女性',
  `city` varchar(20) NOT NULL COMMENT '用户所在城市',
  `province` varchar(20) NOT NULL COMMENT '省',
  `country` varchar(20) NOT NULL COMMENT '国家',
  `remark` varchar(60) NOT NULL COMMENT '用户备注',
  `subscribe` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否已经订阅',
  `subscribe_time` int(11) NOT NULL DEFAULT '0' COMMENT '用户订阅时间',
  `groupid` int(10) NOT NULL DEFAULT '0' COMMENT '分组ID',
  `unionid` varchar(60) DEFAULT NULL COMMENT 'unionid',
  `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '排序ID',
  PRIMARY KEY (`id`),
  UNIQUE KEY `openid` (`openid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='用户表，用户扫描订阅该公众号之后，自动保存用户信息' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `liv_members_group`
--

CREATE TABLE IF NOT EXISTS `liv_members_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `public_id` int(10) NOT NULL DEFAULT '0' COMMENT '所属公众号ID(内部)',
  `group_id` int(10) NOT NULL COMMENT '从微信返回的分组ID',
  `name` varchar(20) NOT NULL,
  `count` tinyint(1) NOT NULL DEFAULT '0' COMMENT '该分组内用户数',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '排序ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='用户分组' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `liv_public_number`
--

CREATE TABLE IF NOT EXISTS `liv_public_number` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `unique_id` varchar(60) NOT NULL COMMENT '该公众号唯一标识(主要用于建立属于该公众号的微信回调地址)',
  `name` varchar(20) NOT NULL COMMENT '公众号名称',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '公众号类型',
  `appid` varchar(120) NOT NULL COMMENT 'APPID',
  `appsecret` varchar(120) NOT NULL COMMENT 'AppSecret',
  `encoding_aes_key` varchar(60) DEFAULT NULL,
  `token` varchar(60) NOT NULL COMMENT '令牌',
  `encript_mode` tinyint(1) NOT NULL DEFAULT '1' COMMENT ' 加解密模式',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '该公众号状态',
  `is_access` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否已经成功接入微信开发者平台',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `order_id` int(10) NOT NULL DEFAULT '0' COMMENT '排序ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='公众号相关信息表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `liv_user`
--

CREATE TABLE IF NOT EXISTS `liv_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password_hash` varchar(60) NOT NULL,
  `password_reset_token` varchar(60) NOT NULL DEFAULT '',
  `email` varchar(30) NOT NULL DEFAULT '',
  `auth_key` varchar(60) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` int(11) NOT NULL DEFAULT '0',
  `updated_at` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `liv_user`
--

INSERT INTO `liv_user` (`id`, `username`, `password_hash`, `password_reset_token`, `email`, `auth_key`, `status`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$13$HQfwh/qTwKH3z7hBRZCaw.sOgK19PmVjrJR/RMPceFkrLaVCFhlz.', '', '', '', 10, 0, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
