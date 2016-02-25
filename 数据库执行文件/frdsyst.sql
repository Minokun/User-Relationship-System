-- --------------------------------------------------------
-- 主机:                           127.0.0.1
-- 服务器版本:                        5.6.24 - MySQL Community Server (GPL)
-- 服务器操作系统:                      Win32
-- HeidiSQL 版本:                  9.2.0.4947
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- 导出 test2 的数据库结构
CREATE DATABASE IF NOT EXISTS `frdsyst` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `frdsyst`;


-- 导出  表 test2.access_control 结构
CREATE TABLE IF NOT EXISTS `access_control` (
  `cid` bigint(20) NOT NULL,
  `name` char(20) DEFAULT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 正在导出表  test2.access_control 的数据：~4 rows (大约)
DELETE FROM `access_control`;
/*!40000 ALTER TABLE `access_control` DISABLE KEYS */;
INSERT INTO `access_control` (`cid`, `name`) VALUES
	(0, '私密'),
	(1, '公开'),
	(2, '好友'),
	(3, '指定');
/*!40000 ALTER TABLE `access_control` ENABLE KEYS */;


-- 导出  表 test2.group_members 结构
CREATE TABLE IF NOT EXISTS `group_members` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `gid` bigint(20) DEFAULT NULL,
  `rid` bigint(20) DEFAULT NULL,
  `uid` char(50) DEFAULT NULL,
  `jointime` datetime DEFAULT NULL,
  `group_name` char(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Reference_14` (`rid`),
  KEY `FK_Reference_33` (`gid`),
  CONSTRAINT `FK_Reference_14` FOREIGN KEY (`rid`) REFERENCES `roles_access` (`rid`),
  CONSTRAINT `FK_Reference_33` FOREIGN KEY (`gid`) REFERENCES `user_group` (`gid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 正在导出表  test2.group_members 的数据：~6 rows (大约)
DELETE FROM `group_members`;
/*!40000 ALTER TABLE `group_members` DISABLE KEYS */;
/*!40000 ALTER TABLE `group_members` ENABLE KEYS */;


-- 导出  表 test2.group_message 结构
CREATE TABLE IF NOT EXISTS `group_message` (
  `mid` bigint(20) NOT NULL AUTO_INCREMENT,
  `gid` bigint(20) DEFAULT NULL,
  `uid` char(50) DEFAULT NULL,
  `content` char(200) DEFAULT NULL,
  `time` datetime DEFAULT NULL,
  PRIMARY KEY (`mid`),
  KEY `FK_Reference_12` (`gid`),
  CONSTRAINT `FK_Reference_12` FOREIGN KEY (`gid`) REFERENCES `user_group` (`gid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 正在导出表  test2.group_message 的数据：~0 rows (大约)
DELETE FROM `group_message`;
/*!40000 ALTER TABLE `group_message` DISABLE KEYS */;
/*!40000 ALTER TABLE `group_message` ENABLE KEYS */;


-- 导出  表 test2.group_resource 结构
CREATE TABLE IF NOT EXISTS `group_resource` (
  `pid` bigint(20) NOT NULL AUTO_INCREMENT,
  `gid` bigint(20) DEFAULT NULL,
  `pstatus` tinyint(4) DEFAULT NULL,
  `pdesc` char(50) DEFAULT NULL,
  `purls` char(50) DEFAULT NULL,
  `createtime` datetime DEFAULT NULL,
  `uid` char(50) DEFAULT NULL,
  PRIMARY KEY (`pid`),
  KEY `FK_Reference_30` (`gid`),
  CONSTRAINT `FK_Reference_30` FOREIGN KEY (`gid`) REFERENCES `user_group` (`gid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 正在导出表  test2.group_resource 的数据：~2 rows (大约)
DELETE FROM `group_resource`;
/*!40000 ALTER TABLE `group_resource` DISABLE KEYS */;
/*!40000 ALTER TABLE `group_resource` ENABLE KEYS */;


-- 导出  表 test2.roles_access 结构
CREATE TABLE IF NOT EXISTS `roles_access` (
  `rid` bigint(20) NOT NULL,
  `name` char(20) DEFAULT NULL,
  PRIMARY KEY (`rid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 正在导出表  test2.roles_access 的数据：~1 rows (大约)
DELETE FROM `roles_access`;
/*!40000 ALTER TABLE `roles_access` DISABLE KEYS */;
INSERT INTO `roles_access` (`rid`, `name`) VALUES
	(1, '群主'),
	(2, '普通');
/*!40000 ALTER TABLE `roles_access` ENABLE KEYS */;


-- 导出  表 test2.user_control 结构
CREATE TABLE IF NOT EXISTS `user_control` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `rid` bigint(20) DEFAULT NULL,
  `cids` char(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Reference_18` (`rid`),
  CONSTRAINT `FK_Reference_18` FOREIGN KEY (`rid`) REFERENCES `user_role` (`rid`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- 正在导出表  test2.user_control 的数据：~4 rows (大约)
DELETE FROM `user_control`;
/*!40000 ALTER TABLE `user_control` DISABLE KEYS */;
INSERT INTO `user_control` (`id`, `rid`, `cids`) VALUES
	(1, 0, '0,1,2,3'),
	(2, 1, '1'),
	(3, 2, '1,2'),
	(4, 3, '1,2,3');
/*!40000 ALTER TABLE `user_control` ENABLE KEYS */;


-- 导出  表 test2.user_friends 结构
CREATE TABLE IF NOT EXISTS `user_friends` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `gids` varchar(1000) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `fids` varchar(1000) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `uid` char(50) DEFAULT NULL,
  `remark` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- 正在导出表  test2.user_friends 的数据：~6 rows (大约)
DELETE FROM `user_friends`;
/*!40000 ALTER TABLE `user_friends` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_friends` ENABLE KEYS */;


-- 导出  表 test2.user_group 结构
CREATE TABLE IF NOT EXISTS `user_group` (
  `gid` bigint(20) NOT NULL AUTO_INCREMENT,
  `uid` char(50) DEFAULT NULL,
  `gname` char(50) DEFAULT NULL,
  `gdesc` char(100) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `level` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`gid`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- 正在导出表  test2.user_group 的数据：~5 rows (大约)
DELETE FROM `user_group`;
/*!40000 ALTER TABLE `user_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_group` ENABLE KEYS */;


-- 导出  表 test2.user_message 结构
CREATE TABLE IF NOT EXISTS `user_message` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `to_uid` char(20) DEFAULT NULL,
  `urls` char(50) DEFAULT NULL,
  `pic_describe` char(100) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `type` bigint(4) DEFAULT NULL,
  `status` bigint(4) DEFAULT NULL,
  `uid` char(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 正在导出表  test2.user_message 的数据：~0 rows (大约)
DELETE FROM `user_message`;
/*!40000 ALTER TABLE `user_message` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_message` ENABLE KEYS */;


-- 导出  表 test2.user_resource 结构
CREATE TABLE IF NOT EXISTS `user_resource` (
  `pid` bigint(20) NOT NULL AUTO_INCREMENT,
  `cid` bigint(20) DEFAULT NULL,
  `urls` char(200) DEFAULT NULL,
  `uid` char(50) DEFAULT NULL,
  `createtime` datetime DEFAULT NULL,
  `fids` char(100) DEFAULT NULL,
  `descr` char(100) DEFAULT NULL,
  PRIMARY KEY (`pid`),
  KEY `FK_Reference_21` (`cid`),
  CONSTRAINT `FK_Reference_21` FOREIGN KEY (`cid`) REFERENCES `access_control` (`cid`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- 正在导出表  test2.user_resource 的数据：~4 rows (大约)
DELETE FROM `user_resource`;
/*!40000 ALTER TABLE `user_resource` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_resource` ENABLE KEYS */;


-- 导出  表 test2.user_resource_desc 结构
CREATE TABLE IF NOT EXISTS `user_resource_desc` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pid` bigint(20) DEFAULT NULL,
  `uid` char(50) DEFAULT NULL,
  `coment` char(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Reference_16` (`pid`),
  CONSTRAINT `FK_Reference_16` FOREIGN KEY (`pid`) REFERENCES `user_resource` (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 正在导出表  test2.user_resource_desc 的数据：~0 rows (大约)
DELETE FROM `user_resource_desc`;
/*!40000 ALTER TABLE `user_resource_desc` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_resource_desc` ENABLE KEYS */;


-- 导出  表 test2.user_role 结构
CREATE TABLE IF NOT EXISTS `user_role` (
  `rid` bigint(4) NOT NULL,
  `rname` char(20) DEFAULT NULL,
  PRIMARY KEY (`rid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 正在导出表  test2.user_role 的数据：~4 rows (大约)
DELETE FROM `user_role`;
/*!40000 ALTER TABLE `user_role` DISABLE KEYS */;
INSERT INTO `user_role` (`rid`, `rname`) VALUES
	(0, '自己'),
	(1, '陌生人'),
	(2, '好友'),
	(3, '指定好友');
/*!40000 ALTER TABLE `user_role` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
