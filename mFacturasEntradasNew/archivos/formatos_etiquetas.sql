/*
Navicat MySQL Data Transfer

Source Server         : Local
Source Server Version : 50717
Source Host           : localhost:3306
Source Database       : supsys

Target Server Type    : MYSQL
Target Server Version : 50717
File Encoding         : 65001

Date: 2018-06-23 15:33:03
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for formatos_etiquetas
-- ----------------------------
DROP TABLE IF EXISTS `formatos_etiquetas`;
CREATE TABLE `formatos_etiquetas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` text,
  `activo` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of formatos_etiquetas
-- ----------------------------
INSERT INTO `formatos_etiquetas` VALUES ('1', '24', '1');
INSERT INTO `formatos_etiquetas` VALUES ('2', '32', '1');
INSERT INTO `formatos_etiquetas` VALUES ('3', '40', '1');
INSERT INTO `formatos_etiquetas` VALUES ('4', '1', '1');
INSERT INTO `formatos_etiquetas` VALUES ('5', '1 Vertical', '1');
INSERT INTO `formatos_etiquetas` VALUES ('6', '1 Horizontal', '1');
INSERT INTO `formatos_etiquetas` VALUES ('7', '2', '1');
INSERT INTO `formatos_etiquetas` VALUES ('8', '4', '1');
INSERT INTO `formatos_etiquetas` VALUES ('9', '6', '1');
