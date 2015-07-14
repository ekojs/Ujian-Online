/*
Navicat MySQL Data Transfer

Source Server         : MySQL
Source Server Version : 50621
Source Host           : localhost:3306
Source Database       : ujian_online_db

Target Server Type    : MYSQL
Target Server Version : 50621
File Encoding         : 65001

Date: 2015-07-14 12:55:26
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id_user` varchar(30) NOT NULL,
  `password` varchar(40) NOT NULL,
  `level` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('ekojs', '3c3989cb10c973a580078240f3b114f6', 'admin');
INSERT INTO `user` VALUES ('7711', '2794f6a20ee0685f4006210f40799acd', 'siswa');
INSERT INTO `user` VALUES ('7712', 'c5eee1896752e5ac19a3a0bb34fbab4b', 'siswa');
INSERT INTO `user` VALUES ('7713', 'b55c86af1c55672a8792354910cd548d', 'siswa');
INSERT INTO `user` VALUES ('7714', '3d91fffbdc07fc7b1240ba846c0f7e75', 'siswa');
