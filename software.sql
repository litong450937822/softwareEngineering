/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50720
Source Host           : localhost:3306
Source Database       : software

Target Server Type    : MYSQL
Target Server Version : 50720
File Encoding         : 65001

Date: 2019-02-12 22:25:55
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for class
-- ----------------------------
DROP TABLE IF EXISTS `class`;
CREATE TABLE `class` (
  `clid` int(11) NOT NULL AUTO_INCREMENT,
  `className` varchar(255) NOT NULL,
  PRIMARY KEY (`clid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of class
-- ----------------------------
INSERT INTO `class` VALUES ('1', '测试班级1');

-- ----------------------------
-- Table structure for class_s
-- ----------------------------
DROP TABLE IF EXISTS `class_s`;
CREATE TABLE `class_s` (
  `clid` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  PRIMARY KEY (`clid`,`sid`),
  KEY `sid` (`sid`) USING BTREE,
  CONSTRAINT `sid` FOREIGN KEY (`sid`) REFERENCES `student` (`sid`) ON DELETE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of class_s
-- ----------------------------
INSERT INTO `class_s` VALUES ('1', '1');

-- ----------------------------
-- Table structure for course
-- ----------------------------
DROP TABLE IF EXISTS `course`;
CREATE TABLE `course` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `clid` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  `courseName` varchar(255) NOT NULL,
  `startDate` varchar(10) NOT NULL,
  `endDate` varchar(10) NOT NULL,
  `describe` varchar(255) NOT NULL,
  `semester` varchar(255) NOT NULL,
  PRIMARY KEY (`cid`) USING BTREE,
  KEY `tid` (`tid`) USING BTREE,
  CONSTRAINT `tid` FOREIGN KEY (`tid`) REFERENCES `teacher` (`tid`) ON DELETE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of course
-- ----------------------------
INSERT INTO `course` VALUES ('1', '1', '1', '测试课程1', '2018.09.01', '2019.01.12', '测试课程1描述', '2018第一学期');

-- ----------------------------
-- Table structure for discass_s
-- ----------------------------
DROP TABLE IF EXISTS `discass_s`;
CREATE TABLE `discass_s` (
  `dtid` int(11) NOT NULL AUTO_INCREMENT,
  `sid` int(11) NOT NULL,
  `time` varchar(19) NOT NULL,
  `result` varchar(255) NOT NULL,
  PRIMARY KEY (`dtid`,`sid`) USING BTREE,
  KEY `student` (`sid`) USING BTREE,
  CONSTRAINT `discass` FOREIGN KEY (`dtid`) REFERENCES `discass_t` (`dtid`) ON DELETE NO ACTION,
  CONSTRAINT `student` FOREIGN KEY (`sid`) REFERENCES `student` (`sid`) ON DELETE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of discass_s
-- ----------------------------
INSERT INTO `discass_s` VALUES ('1', '1', '2018/11/28 14:27:06', '测试讨论内容1');

-- ----------------------------
-- Table structure for discass_t
-- ----------------------------
DROP TABLE IF EXISTS `discass_t`;
CREATE TABLE `discass_t` (
  `dtid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `cid` int(11) NOT NULL,
  `lastUpdateTime` varchar(16) NOT NULL,
  `traffic` int(11) DEFAULT '0',
  `startTime` varchar(16) NOT NULL,
  PRIMARY KEY (`dtid`) USING BTREE,
  KEY `discasst_c` (`cid`) USING BTREE,
  CONSTRAINT `discasst_c` FOREIGN KEY (`cid`) REFERENCES `course` (`cid`) ON DELETE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of discass_t
-- ----------------------------
INSERT INTO `discass_t` VALUES ('1', '测试讨论1', '1', '2018/12/19 16：28', '0', '2018/12/19 16：28');

-- ----------------------------
-- Table structure for question_q
-- ----------------------------
DROP TABLE IF EXISTS `question_q`;
CREATE TABLE `question_q` (
  `dqid` int(11) NOT NULL AUTO_INCREMENT,
  `qtid` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `options` varchar(255) NOT NULL,
  PRIMARY KEY (`dqid`) USING BTREE,
  KEY `qtid` (`qtid`) USING BTREE,
  CONSTRAINT `qtid` FOREIGN KEY (`qtid`) REFERENCES `question_t` (`qtid`) ON DELETE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of question_q
-- ----------------------------

-- ----------------------------
-- Table structure for question_s
-- ----------------------------
DROP TABLE IF EXISTS `question_s`;
CREATE TABLE `question_s` (
  `qtid` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  `resule` varchar(255) NOT NULL,
  `submitTime` varchar(19) NOT NULL,
  PRIMARY KEY (`qtid`,`sid`) USING BTREE,
  KEY `student_q` (`sid`) USING BTREE,
  CONSTRAINT `question` FOREIGN KEY (`qtid`) REFERENCES `question_t` (`qtid`) ON DELETE NO ACTION,
  CONSTRAINT `student_q` FOREIGN KEY (`sid`) REFERENCES `student` (`sid`) ON DELETE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of question_s
-- ----------------------------

-- ----------------------------
-- Table structure for question_t
-- ----------------------------
DROP TABLE IF EXISTS `question_t`;
CREATE TABLE `question_t` (
  `qtid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `cid` int(11) NOT NULL,
  `startTime` varchar(19) NOT NULL,
  `endTime` varchar(19) NOT NULL,
  PRIMARY KEY (`qtid`) USING BTREE,
  KEY `course_q` (`cid`) USING BTREE,
  CONSTRAINT `course_q` FOREIGN KEY (`cid`) REFERENCES `course` (`cid`) ON DELETE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of question_t
-- ----------------------------

-- ----------------------------
-- Table structure for student
-- ----------------------------
DROP TABLE IF EXISTS `student`;
CREATE TABLE `student` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `major` varchar(255) NOT NULL,
  `schoolNumber` int(11) NOT NULL,
  `studyTime` int(255) NOT NULL,
  PRIMARY KEY (`sid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of student
-- ----------------------------
INSERT INTO `student` VALUES ('1', '测试学生1', '测试班级1', '123456', '测试专业1', '1000001', '0');

-- ----------------------------
-- Table structure for teacher
-- ----------------------------
DROP TABLE IF EXISTS `teacher`;
CREATE TABLE `teacher` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `number` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`tid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of teacher
-- ----------------------------
INSERT INTO `teacher` VALUES ('1', '400001', '123456', '测试教师1');

-- ----------------------------
-- Table structure for test_q
-- ----------------------------
DROP TABLE IF EXISTS `test_q`;
CREATE TABLE `test_q` (
  `number` int(11) NOT NULL,
  `ttid` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `option1` varchar(255) NOT NULL,
  `option2` varchar(255) NOT NULL,
  `option3` varchar(255) NOT NULL,
  `option4` varchar(255) NOT NULL,
  `answer` varchar(255) NOT NULL,
  PRIMARY KEY (`number`,`ttid`),
  KEY `test` (`ttid`),
  CONSTRAINT `test` FOREIGN KEY (`ttid`) REFERENCES `test_t` (`ttid`) ON DELETE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of test_q
-- ----------------------------

-- ----------------------------
-- Table structure for test_s
-- ----------------------------
DROP TABLE IF EXISTS `test_s`;
CREATE TABLE `test_s` (
  `ttid` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `answer` varchar(255) NOT NULL,
  `sid` int(11) NOT NULL,
  PRIMARY KEY (`ttid`,`number`,`sid`),
  CONSTRAINT `testS` FOREIGN KEY (`ttid`) REFERENCES `test_t` (`ttid`) ON DELETE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of test_s
-- ----------------------------

-- ----------------------------
-- Table structure for test_t
-- ----------------------------
DROP TABLE IF EXISTS `test_t`;
CREATE TABLE `test_t` (
  `ttid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `startTime` varchar(255) NOT NULL,
  `endTime` varchar(255) NOT NULL,
  `cid` int(11) NOT NULL,
  PRIMARY KEY (`ttid`),
  KEY `classtest` (`cid`),
  CONSTRAINT `classtest` FOREIGN KEY (`cid`) REFERENCES `class` (`clid`) ON DELETE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of test_t
-- ----------------------------

-- ----------------------------
-- Table structure for time
-- ----------------------------
DROP TABLE IF EXISTS `time`;
CREATE TABLE `time` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `startTime` varchar(8) NOT NULL,
  `endTime` varchar(8) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of time
-- ----------------------------

-- ----------------------------
-- Table structure for vote_s
-- ----------------------------
DROP TABLE IF EXISTS `vote_s`;
CREATE TABLE `vote_s` (
  `vtid` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  `result` int(11) NOT NULL,
  PRIMARY KEY (`vtid`,`sid`,`result`) USING BTREE,
  KEY `student_v` (`sid`) USING BTREE,
  CONSTRAINT `student_v` FOREIGN KEY (`sid`) REFERENCES `student` (`sid`) ON DELETE NO ACTION,
  CONSTRAINT `vtid` FOREIGN KEY (`vtid`) REFERENCES `vote_t` (`vtid`) ON DELETE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of vote_s
-- ----------------------------

-- ----------------------------
-- Table structure for vote_t
-- ----------------------------
DROP TABLE IF EXISTS `vote_t`;
CREATE TABLE `vote_t` (
  `vtid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `options` varchar(255) NOT NULL,
  `startTime` varchar(19) NOT NULL,
  `endTime` varchar(19) NOT NULL,
  `cid` int(11) NOT NULL,
  PRIMARY KEY (`vtid`) USING BTREE,
  KEY `class` (`cid`),
  CONSTRAINT `class` FOREIGN KEY (`cid`) REFERENCES `class` (`clid`) ON DELETE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of vote_t
-- ----------------------------

-- ----------------------------
-- Table structure for work_s
-- ----------------------------
DROP TABLE IF EXISTS `work_s`;
CREATE TABLE `work_s` (
  `wtid` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  `submitTime` varchar(19) NOT NULL,
  `content` varchar(255) NOT NULL,
  `file` varchar(255) DEFAULT NULL,
  `score` int(11) DEFAULT '0',
  PRIMARY KEY (`wtid`,`sid`) USING BTREE,
  KEY `stid` (`sid`) USING BTREE,
  CONSTRAINT `stid` FOREIGN KEY (`sid`) REFERENCES `student` (`sid`) ON DELETE NO ACTION,
  CONSTRAINT `work` FOREIGN KEY (`wtid`) REFERENCES `work_t` (`wtid`) ON DELETE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of work_s
-- ----------------------------
INSERT INTO `work_s` VALUES ('1', '1', '2018/11/17 15:21', '测试作业答案1', 'test1.jpg;test2.jpg', '0');
INSERT INTO `work_s` VALUES ('2', '1', '2018/12/01 05:14', '', '《PHP程序设计》设计报告.doc', '0');

-- ----------------------------
-- Table structure for work_t
-- ----------------------------
DROP TABLE IF EXISTS `work_t`;
CREATE TABLE `work_t` (
  `wtid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `cid` int(11) NOT NULL,
  `content` varchar(255) NOT NULL,
  `startTime` varchar(19) NOT NULL,
  `endTime` varchar(19) NOT NULL,
  PRIMARY KEY (`wtid`) USING BTREE,
  KEY `course` (`cid`) USING BTREE,
  CONSTRAINT `course` FOREIGN KEY (`cid`) REFERENCES `course` (`cid`) ON DELETE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of work_t
-- ----------------------------
INSERT INTO `work_t` VALUES ('1', '测试作业1', '1', '测试作业1内容', '2018/11/16 16:00', '2018/11/30 18:00');
INSERT INTO `work_t` VALUES ('2', '测试作业2', '1', '测试作业2内容', '2018/11/01 18:00', '2019/01/13 16:00');
