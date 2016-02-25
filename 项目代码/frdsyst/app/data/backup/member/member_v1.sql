--
-- MySQL database dump
-- Created by DBManage class, Power By yanue. 
-- http://yanue.net 
--
-- 主机: 77.66.36.43
-- 生成日期: 2015 年  04 月 16 日 16:23
-- MySQL版本: 5.1.28-rc-community
-- PHP 版本: 5.2.6

--
-- 数据库: `crazy_forward`
--

-- -------------------------------------------------------

--
-- 表的结构member
--

DROP TABLE IF EXISTS `member`;
CREATE TABLE `member` (
  `member_id` int(16) NOT NULL AUTO_INCREMENT,
  `parent_id` int(16) DEFAULT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(128) NOT NULL,
  `member_code` varchar(128) NOT NULL,
  `phone` varchar(32) NOT NULL,
  `qq` varchar(16) DEFAULT NULL,
  `weixin` varchar(32) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `nick_name` varchar(32) DEFAULT NULL,
  `head_pic` varchar(255) DEFAULT NULL,
  `third_group_open_id` varchar(64) DEFAULT NULL COMMENT '第三方账户openid',
  `third_group_type` int(8) DEFAULT NULL COMMENT '第三方账户类型',
  `token` varchar(36) DEFAULT NULL,
  `exprise_in` bigint(20) DEFAULT NULL,
  `add_date` datetime DEFAULT NULL,
  `mention_password` varchar(128) DEFAULT NULL,
  `invited_num` int(9) DEFAULT '0' COMMENT '邀请数量',
  `sex` int(2) DEFAULT NULL,
  `age` int(3) DEFAULT NULL,
  `id_card` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `status` smallint(1) DEFAULT '1',
  `job` smallint(2) DEFAULT '0',
  PRIMARY KEY (`member_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 member
--

INSERT INTO `member` VALUES('1','0','测试用户1','$P$BOJ7XQSuxShj4iC9JU37uR8Dbxxn4R0','10000002','13540140175','','','','','','','0','','0','2015-03-30 13:37:40','','0','0','0','','','','','1','0');
INSERT INTO `member` VALUES('2','9','13540140176','e10adc3949ba59abbe56e057f20f883e','12345678','13540140176','','','','','','','0','','0','2015-03-30 13:37:43','','0','0','0','','','','','1','0');
INSERT INTO `member` VALUES('6','9','13540140178','e10adc3949ba59abbe56e057f20f883e','10000005','13540140178','','','','','','','0','','0','2015-03-30 13:37:49','','0','0','0','','','','','1','0');
INSERT INTO `member` VALUES('7','9','13544444444','e10adc3949ba59abbe56e057f20f883e','10000006','13544444444','','','','','','','0','','0','2015-03-30 13:37:52','','0','0','0','','','','','1','0');
INSERT INTO `member` VALUES('8','8','18482380479','e10adc3949ba59abbe56e057f20f883e','10000007','18482380479','','','','阿斯顿的','http://wx.qlogo.cn/mmopen/04LrpEqAf4tpfdLAgT8rXgWsMZqmebtYWbrqCWqyH1hv1n0iakjz58I16qebZ0icTTCE2Hg0B4bjumemgXgpNUQxPl4VuJWXNQ/0','','0','','0','0000-00-00 00:00:00','','0','2','12','','','','','1','5');
INSERT INTO `member` VALUES('9','10','13540140177','e10adc3949ba59abbe56e057f20f883e','10000008','13540140177','','','','','http://wx.qlogo.cn/mmopen/04LrpEqAf4tpfdLAgT8rXgWsMZqmebtYWbrqCWqyH1hv1n0iakjz58I16qebZ0icTTCE2Hg0B4bjumemgXgpNUQxPl4VuJWXNQ/0','','0','','0','0000-00-00 00:00:00','e10adc3949ba59abbe56e057f20f883e','10','2','0','','','','','1','0');
INSERT INTO `member` VALUES('10','8','13540444477','e10adc3949ba59abbe56e057f20f883e','10000009','13540444477','','','','','','','0','','0','0000-00-00 00:00:00','','1','0','0','','','','','1','0');
