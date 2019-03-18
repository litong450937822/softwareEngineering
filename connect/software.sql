/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50720
Source Host           : localhost:3306
Source Database       : software

Target Server Type    : MYSQL
Target Server Version : 50720
File Encoding         : 65001

Date: 2019-03-18 23:10:49
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for attachment
-- ----------------------------
DROP TABLE IF EXISTS `attachment`;
CREATE TABLE `attachment` (
  `aid` int(11) NOT NULL AUTO_INCREMENT,
  `file` varchar(255) NOT NULL,
  `startTime` varchar(19) NOT NULL,
  `target` varchar(255) NOT NULL,
  `chid` int(11) NOT NULL,
  PRIMARY KEY (`aid`),
  KEY `attachment` (`chid`),
  CONSTRAINT `attachment` FOREIGN KEY (`chid`) REFERENCES `chapter` (`chid`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of attachment
-- ----------------------------

-- ----------------------------
-- Table structure for chapter
-- ----------------------------
DROP TABLE IF EXISTS `chapter`;
CREATE TABLE `chapter` (
  `chid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  KEY `chid` (`chid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of chapter
-- ----------------------------

-- ----------------------------
-- Table structure for class
-- ----------------------------
DROP TABLE IF EXISTS `class`;
CREATE TABLE `class` (
  `clid` int(11) NOT NULL AUTO_INCREMENT,
  `className` varchar(255) NOT NULL,
  `grade` varchar(255) NOT NULL,
  `major` varchar(255) NOT NULL,
  PRIMARY KEY (`clid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of class
-- ----------------------------
INSERT INTO `class` VALUES ('1', '测试班级1', '测试年纪1', '测试专业1');

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
  KEY `clid` (`clid`),
  CONSTRAINT `clid` FOREIGN KEY (`clid`) REFERENCES `class` (`clid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `tid` FOREIGN KEY (`tid`) REFERENCES `teacher` (`tid`) ON DELETE NO ACTION ON UPDATE NO ACTION
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
  `dsid` int(11) NOT NULL AUTO_INCREMENT,
  `dtid` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `time` varchar(19) NOT NULL,
  `content` varchar(255) NOT NULL,
  `identity` varchar(1) NOT NULL,
  PRIMARY KEY (`dsid`),
  KEY `disscuse` (`dtid`),
  KEY `id_t` (`id`),
  CONSTRAINT `disscuse` FOREIGN KEY (`dtid`) REFERENCES `discass_t` (`dtid`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `id_s` FOREIGN KEY (`id`) REFERENCES `student` (`sid`),
  CONSTRAINT `id_t` FOREIGN KEY (`id`) REFERENCES `teacher` (`tid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of discass_s
-- ----------------------------
INSERT INTO `discass_s` VALUES ('1', '1', '1', '2019/03/11 09:58:18', '测试数据1', 's');

-- ----------------------------
-- Table structure for discass_t
-- ----------------------------
DROP TABLE IF EXISTS `discass_t`;
CREATE TABLE `discass_t` (
  `dtid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `cid` int(11) NOT NULL,
  `lastUpdateTime` varchar(19) NOT NULL,
  `traffic` int(11) DEFAULT '0',
  `startTime` varchar(19) NOT NULL,
  PRIMARY KEY (`dtid`,`cid`),
  KEY `discasst_c` (`cid`) USING BTREE,
  CONSTRAINT `discasst_c` FOREIGN KEY (`cid`) REFERENCES `course` (`cid`) ON DELETE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of discass_t
-- ----------------------------
INSERT INTO `discass_t` VALUES ('1', '测试讨论题目1', '1', '2019/03/11 10:00:56', '13', '2019/03/03 01:02:28');

-- ----------------------------
-- Table structure for question_q
-- ----------------------------
DROP TABLE IF EXISTS `question_q`;
CREATE TABLE `question_q` (
  `qtid` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `number` int(11) NOT NULL,
  PRIMARY KEY (`qtid`,`number`),
  KEY `qtid` (`qtid`) USING BTREE,
  CONSTRAINT `qtid` FOREIGN KEY (`qtid`) REFERENCES `question_t` (`qtid`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of question_q
-- ----------------------------
INSERT INTO `question_q` VALUES ('2', '测试问卷2问题1', '1');
INSERT INTO `question_q` VALUES ('2', '21412412421', '2');
INSERT INTO `question_q` VALUES ('2', '214124124124', '3');
INSERT INTO `question_q` VALUES ('2', '21412421412412', '4');
INSERT INTO `question_q` VALUES ('3', '1412545125125', '1');
INSERT INTO `question_q` VALUES ('3', '23523523532', '2');
INSERT INTO `question_q` VALUES ('3', '325235525', '3');
INSERT INTO `question_q` VALUES ('3', '54645645645', '4');
INSERT INTO `question_q` VALUES ('3', '45745745757', '5');
INSERT INTO `question_q` VALUES ('3', '5685685685685', '6');
INSERT INTO `question_q` VALUES ('4', '34634634', '1');
INSERT INTO `question_q` VALUES ('4', '645645654', '2');
INSERT INTO `question_q` VALUES ('4', '346435345', '3');
INSERT INTO `question_q` VALUES ('4', '34543634', '4');
INSERT INTO `question_q` VALUES ('4', '3463463', '5');
INSERT INTO `question_q` VALUES ('4', '34634636', '6');
INSERT INTO `question_q` VALUES ('5', '测试问卷1问题1', '1');
INSERT INTO `question_q` VALUES ('5', '21412412421', '2');
INSERT INTO `question_q` VALUES ('5', '214124124124', '3');
INSERT INTO `question_q` VALUES ('5', '21412421412412', '4');

-- ----------------------------
-- Table structure for question_s
-- ----------------------------
DROP TABLE IF EXISTS `question_s`;
CREATE TABLE `question_s` (
  `qtid` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  `result` varchar(255) NOT NULL,
  `submitTime` varchar(19) NOT NULL,
  PRIMARY KEY (`qtid`,`sid`) USING BTREE,
  KEY `student_q` (`sid`) USING BTREE,
  CONSTRAINT `question` FOREIGN KEY (`qtid`) REFERENCES `question_t` (`qtid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `student_q` FOREIGN KEY (`sid`) REFERENCES `student` (`sid`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of question_s
-- ----------------------------
INSERT INTO `question_s` VALUES ('2', '1', '1;2;1;2', '2019/03/11 10:38:25');
INSERT INTO `question_s` VALUES ('3', '1', '2;2;2;1;2;1', '2019/03/11 10:38:34');

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
  PRIMARY KEY (`qtid`,`cid`),
  KEY `course_q` (`cid`) USING BTREE,
  CONSTRAINT `course_q` FOREIGN KEY (`cid`) REFERENCES `course` (`cid`) ON DELETE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of question_t
-- ----------------------------
INSERT INTO `question_t` VALUES ('2', '测试问卷2', '1', '2019/03/05 09:45:23', '2019/03/30 00:00:00');
INSERT INTO `question_t` VALUES ('3', '1242142142141245245745', '1', '2019/03/05 09:46:34', '2020/04/05 00:00:00');
INSERT INTO `question_t` VALUES ('4', '1241245435', '1', '2019/03/10 03:57:11', '2019/03/22 00:00:00');
INSERT INTO `question_t` VALUES ('5', '测试问卷1', '1', '2019/03/05 09:45:23', '2019/03/30 00:00:00');

-- ----------------------------
-- Table structure for rollcall
-- ----------------------------
DROP TABLE IF EXISTS `rollcall`;
CREATE TABLE `rollcall` (
  `sid` int(11) NOT NULL,
  `time` varchar(19) NOT NULL,
  `state` varchar(1) NOT NULL,
  `cid` int(11) NOT NULL,
  PRIMARY KEY (`sid`,`time`,`cid`),
  KEY `courseCall` (`cid`),
  CONSTRAINT `courseCall` FOREIGN KEY (`cid`) REFERENCES `course` (`cid`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `studentCall` FOREIGN KEY (`sid`) REFERENCES `student` (`sid`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of rollcall
-- ----------------------------
INSERT INTO `rollcall` VALUES ('1', '2019/03/18 07:57:26', 'A', '1');
INSERT INTO `rollcall` VALUES ('1', '2019/03/18 08:41:14', 'N', '1');
INSERT INTO `rollcall` VALUES ('2', '2019/03/18 07:57:26', 'N', '1');
INSERT INTO `rollcall` VALUES ('2', '2019/03/18 08:41:14', 'N', '1');
INSERT INTO `rollcall` VALUES ('3', '2019/03/18 07:57:26', 'N', '1');
INSERT INTO `rollcall` VALUES ('3', '2019/03/18 08:41:14', 'N', '1');
INSERT INTO `rollcall` VALUES ('4', '2019/03/18 07:57:26', 'L', '1');
INSERT INTO `rollcall` VALUES ('4', '2019/03/18 08:41:14', 'N', '1');
INSERT INTO `rollcall` VALUES ('5', '2019/03/18 07:57:26', 'N', '1');
INSERT INTO `rollcall` VALUES ('5', '2019/03/18 08:41:14', 'L', '1');
INSERT INTO `rollcall` VALUES ('6', '2019/03/18 07:57:26', 'N', '1');
INSERT INTO `rollcall` VALUES ('6', '2019/03/18 08:41:14', 'N', '1');
INSERT INTO `rollcall` VALUES ('7', '2019/03/18 07:57:26', 'L', '1');
INSERT INTO `rollcall` VALUES ('7', '2019/03/18 08:41:14', 'N', '1');
INSERT INTO `rollcall` VALUES ('8', '2019/03/18 07:57:26', 'N', '1');
INSERT INTO `rollcall` VALUES ('8', '2019/03/18 08:41:14', 'T', '1');
INSERT INTO `rollcall` VALUES ('9', '2019/03/18 07:57:26', 'N', '1');
INSERT INTO `rollcall` VALUES ('9', '2019/03/18 08:41:14', 'T', '1');
INSERT INTO `rollcall` VALUES ('10', '2019/03/18 07:57:26', 'A', '1');
INSERT INTO `rollcall` VALUES ('10', '2019/03/18 08:41:14', 'N', '1');

-- ----------------------------
-- Table structure for student
-- ----------------------------
DROP TABLE IF EXISTS `student`;
CREATE TABLE `student` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `clid` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `number` int(11) NOT NULL,
  `sex` varchar(1) DEFAULT NULL,
  `studyTime` int(255) NOT NULL DEFAULT '0',
  `profilePhoto` varchar(255) DEFAULT 'default.jpg',
  PRIMARY KEY (`sid`,`number`),
  UNIQUE KEY `studentNumber` (`number`),
  KEY `class1` (`clid`),
  KEY `sid` (`sid`),
  CONSTRAINT `class1` FOREIGN KEY (`clid`) REFERENCES `class` (`clid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of student
-- ----------------------------
INSERT INTO `student` VALUES ('1', '测试学生1', '1', '123456', '1000001', 'W', '0', 'default.jpg');
INSERT INTO `student` VALUES ('2', '测试学生2', '1', '123456', '1000002', 'M', '0', 'default.jpg');
INSERT INTO `student` VALUES ('3', '测试学生3', '1', '123456', '1000003', 'M', '0', 'default.jpg');
INSERT INTO `student` VALUES ('4', '测试学生4', '1', '123456', '1000004', 'M', '0', 'default.jpg');
INSERT INTO `student` VALUES ('5', '测试学生5', '1', '123456', '1000005', 'M', '0', 'default.jpg');
INSERT INTO `student` VALUES ('6', '测试学生6', '1', '123456', '1000006', 'W', '0', 'default.jpg');
INSERT INTO `student` VALUES ('7', '测试学生7', '1', '123456', '1000007', 'W', '0', 'default.jpg');
INSERT INTO `student` VALUES ('8', '测试学生8', '1', '123456', '1000008', 'M', '0', 'default.jpg');
INSERT INTO `student` VALUES ('9', '测试学生9', '1', '123456', '1000009', 'M', '0', 'default.jpg');
INSERT INTO `student` VALUES ('10', '测试学生10', '1', '123456', '1000010', 'W', '0', 'default.jpg');

-- ----------------------------
-- Table structure for teacher
-- ----------------------------
DROP TABLE IF EXISTS `teacher`;
CREATE TABLE `teacher` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `number` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `profilePhoto` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`tid`,`number`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of teacher
-- ----------------------------
INSERT INTO `teacher` VALUES ('1', '400001', '123456', '测试教师1', null);

-- ----------------------------
-- Table structure for test_q
-- ----------------------------
DROP TABLE IF EXISTS `test_q`;
CREATE TABLE `test_q` (
  `ttid` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `option1` varchar(255) NOT NULL,
  `option2` varchar(255) NOT NULL,
  `option3` varchar(255) NOT NULL,
  `option4` varchar(255) NOT NULL,
  `answer` varchar(255) NOT NULL,
  PRIMARY KEY (`ttid`,`number`),
  CONSTRAINT `test` FOREIGN KEY (`ttid`) REFERENCES `test_t` (`ttid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of test_q
-- ----------------------------
INSERT INTO `test_q` VALUES ('12', '1', '测试问题1', '测试选项', '测试选项', '测试选项', '正确选项', 'D');
INSERT INTO `test_q` VALUES ('12', '2', '测试问题2', '测试选项', '正确选项', '测试选项', '测试选项', 'B');
INSERT INTO `test_q` VALUES ('12', '3', '测试问题3', '测试选项', '测试选项', '正确选项', '测试选项', 'C');
INSERT INTO `test_q` VALUES ('13', '1', '测试问题1', '111', '2222', '333', '44444444', 'D');
INSERT INTO `test_q` VALUES ('13', '2', '测试问题2', '2222222222', '3333', '44444444444', '222222', 'B');
INSERT INTO `test_q` VALUES ('13', '3', '测试问题3', '111', '2222222', '333', '333333', 'B');
INSERT INTO `test_q` VALUES ('13', '4', '测试问题4', '1111111111111111', '2222', '3333333', '444444444444', 'A');
INSERT INTO `test_q` VALUES ('13', '5', '测试问题5', '111', '22222222', '333333', '4444', 'B');
INSERT INTO `test_q` VALUES ('15', '1', '124124', '12421421', '2142142', '214124', '214214124', 'D');
INSERT INTO `test_q` VALUES ('15', '2', '124124', '12421421421', '2142142', '214124131311331', '214214124', 'C');
INSERT INTO `test_q` VALUES ('16', '1', '21412', '214212', '1421421', '241', '24', 'C');
INSERT INTO `test_q` VALUES ('16', '2', '124124', '214124', '21421', '4214214', '2144', 'C');
INSERT INTO `test_q` VALUES ('16', '3', '2141', '124124124', '21412412', '214214', '124214124', 'C');
INSERT INTO `test_q` VALUES ('16', '4', '214214', '214124124', '214124', '2142142', '142141', 'C');
INSERT INTO `test_q` VALUES ('16', '5', '214124', '124124124', '12421214', '21421421', '424124', 'C');

-- ----------------------------
-- Table structure for test_s
-- ----------------------------
DROP TABLE IF EXISTS `test_s`;
CREATE TABLE `test_s` (
  `ttid` int(11) NOT NULL,
  `answer` varchar(255) NOT NULL,
  `sid` int(11) NOT NULL,
  `score` int(3) DEFAULT '0',
  `submitTime` varchar(19) NOT NULL,
  PRIMARY KEY (`ttid`,`sid`),
  KEY `student` (`sid`),
  CONSTRAINT `student` FOREIGN KEY (`sid`) REFERENCES `student` (`sid`),
  CONSTRAINT `testS` FOREIGN KEY (`ttid`) REFERENCES `test_t` (`ttid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of test_s
-- ----------------------------
INSERT INTO `test_s` VALUES ('12', 'D;B;C', '1', '100', '2019/03/11 10:19:53');
INSERT INTO `test_s` VALUES ('12', 'C;B;C', '2', '67', '');
INSERT INTO `test_s` VALUES ('16', 'D;C;C;C;C', '1', '80', '2019/03/11 10:43:59');

-- ----------------------------
-- Table structure for test_t
-- ----------------------------
DROP TABLE IF EXISTS `test_t`;
CREATE TABLE `test_t` (
  `ttid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `startTime` varchar(255) NOT NULL,
  `endTime` varchar(255) NOT NULL,
  `cid` int(11) NOT NULL,
  PRIMARY KEY (`ttid`),
  KEY `classtest` (`cid`),
  KEY `ttid` (`ttid`),
  CONSTRAINT `classtest` FOREIGN KEY (`cid`) REFERENCES `class` (`clid`) ON DELETE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of test_t
-- ----------------------------
INSERT INTO `test_t` VALUES ('12', '测试数据1', '2019/03/03 12:06:31', '2019/07/05 00:00:00', '1');
INSERT INTO `test_t` VALUES ('13', '测试数据2', '2019/03/11 10:39:24', '2019/06/11 00:00:00', '1');
INSERT INTO `test_t` VALUES ('15', '测试测验3', '2019/03/11 10:42:13', '2019/04/06 00:00:00', '1');
INSERT INTO `test_t` VALUES ('16', '12412421412', '2019/03/11 10:42:36', '2019/04/06 00:00:00', '1');

-- ----------------------------
-- Table structure for time
-- ----------------------------
DROP TABLE IF EXISTS `time`;
CREATE TABLE `time` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(255) NOT NULL,
  `time` int(11) DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `startTime` varchar(8) DEFAULT NULL,
  `endTime` varchar(8) DEFAULT NULL,
  `sid` int(11) NOT NULL,
  `cid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `student1` (`sid`),
  CONSTRAINT `student1` FOREIGN KEY (`sid`) REFERENCES `student` (`sid`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of time
-- ----------------------------
INSERT INTO `time` VALUES ('4', '2019/03/11', '586', 'L', '09:35:54', '09:45:40', '1', '1');
INSERT INTO `time` VALUES ('8', '2019/03/11', '6', 'W', '10:19:47', '10:19:53', '1', '1');
INSERT INTO `time` VALUES ('9', '2019/03/11', '1840', 'L', '09:49:37', '10:20:17', '1', '1');
INSERT INTO `time` VALUES ('11', '2019/03/11', '576', 'L', '10:23:38', '10:33:14', '1', '1');
INSERT INTO `time` VALUES ('13', '2019/03/11', '22', 'L', '10:38:13', '10:38:35', '1', '1');
INSERT INTO `time` VALUES ('15', '2019/03/11', '8', 'T', '10:43:51', '10:43:59', '1', '1');
INSERT INTO `time` VALUES ('16', '2019/03/11', '130', 'L', '10:43:49', '10:45:59', '1', '1');
INSERT INTO `time` VALUES ('17', '2019/03/11', '399', 'L', '10:46:21', '10:53:00', '1', '1');
INSERT INTO `time` VALUES ('18', '2019/03/11', '55', 'L', '10:55:31', '10:56:26', '1', '1');
INSERT INTO `time` VALUES ('19', '2019/03/12', '181', 'L', '07:56:00', '07:59:01', '1', '1');
INSERT INTO `time` VALUES ('20', '2019/03/12', '8251', 'L', '07:59:05', '10:16:36', '1', '1');
INSERT INTO `time` VALUES ('21', '2019/03/12', '5234', 'L', '22:17:10', '23:44:24', '1', '1');
INSERT INTO `time` VALUES ('23', '2019/03/13', '15', 'L', '22:48:48', '22:49:03', '1', '1');
INSERT INTO `time` VALUES ('24', '2019/03/13', '159', 'L', '22:51:53', '22:54:32', '2', '1');
INSERT INTO `time` VALUES ('25', '2019/03/13', null, 'D', null, null, '2', '1');
INSERT INTO `time` VALUES ('26', '2019/03/13', null, 'V', null, null, '2', '1');
INSERT INTO `time` VALUES ('27', '2019/03/13', null, 'Q', null, null, '2', '1');
INSERT INTO `time` VALUES ('28', '2019/03/14', '70', 'L', '23:33:17', '23:34:27', '1', null);
INSERT INTO `time` VALUES ('29', '2019/03/14', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('30', '2019/03/14', null, 'V', null, null, '1', '1');
INSERT INTO `time` VALUES ('31', '2019/03/14', null, 'Q', null, null, '1', '1');
INSERT INTO `time` VALUES ('32', '2019/03/14', null, 'E', null, null, '1', '1');
INSERT INTO `time` VALUES ('33', '2019/03/14', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('34', '2019/03/14', null, 'D', null, null, '1', '1');
INSERT INTO `time` VALUES ('35', '2019/03/18', null, 'O', null, null, '2', '1');
INSERT INTO `time` VALUES ('36', '2019/03/18', '30', 'L', '10:16:28', '10:16:58', '2', null);
INSERT INTO `time` VALUES ('37', '2019/03/18', null, 'O', null, null, '2', '1');
INSERT INTO `time` VALUES ('38', '2019/03/18', '9', 'W', '10:20:41', '10:20:50', '2', '1');
INSERT INTO `time` VALUES ('39', '2019/03/18', '240', 'L', '10:20:36', '10:24:36', '2', null);
INSERT INTO `time` VALUES ('40', '2019/03/18', '8101', 'L', '20:55:34', '23:10:35', '1', null);

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
  CONSTRAINT `student_v` FOREIGN KEY (`sid`) REFERENCES `student` (`sid`) ON DELETE CASCADE,
  CONSTRAINT `vtid` FOREIGN KEY (`vtid`) REFERENCES `vote_t` (`vtid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of vote_s
-- ----------------------------
INSERT INTO `vote_s` VALUES ('1', '1', '2');
INSERT INTO `vote_s` VALUES ('1', '2', '0');

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
  PRIMARY KEY (`vtid`),
  KEY `class` (`cid`),
  CONSTRAINT `class` FOREIGN KEY (`cid`) REFERENCES `class` (`clid`) ON DELETE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of vote_t
-- ----------------------------
INSERT INTO `vote_t` VALUES ('1', '测试投票1', '测试选项1;12412421;214124;21421412412', '2019/03/10 03:56:37', '2019/03/30 00:00:00', '1');

-- ----------------------------
-- Table structure for work_s
-- ----------------------------
DROP TABLE IF EXISTS `work_s`;
CREATE TABLE `work_s` (
  `wtid` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  `submitTime` varchar(19) NOT NULL,
  `answer` varchar(255) NOT NULL,
  `file` varchar(255) DEFAULT NULL,
  `score` int(11) DEFAULT '0',
  PRIMARY KEY (`wtid`,`sid`) USING BTREE,
  KEY `stid` (`sid`) USING BTREE,
  CONSTRAINT `stid` FOREIGN KEY (`sid`) REFERENCES `student` (`sid`) ON DELETE CASCADE,
  CONSTRAINT `work` FOREIGN KEY (`wtid`) REFERENCES `work_t` (`wtid`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of work_s
-- ----------------------------
INSERT INTO `work_s` VALUES ('1', '1', '2018/11/17 15:21', '测试作业答案1', 'test1.jpg;test2.jpg', '88');
INSERT INTO `work_s` VALUES ('2', '2', '2019/03/18 10:20:50', '12431241241', 'game.txt', '0');
INSERT INTO `work_s` VALUES ('4', '1', '2019/03/11 10:05:57', '测试作业3内容', '', '0');

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
  `file` varchar(255) DEFAULT NULL,
  `chid` int(11) DEFAULT NULL,
  PRIMARY KEY (`wtid`),
  KEY `course` (`cid`) USING BTREE,
  KEY `workChapter` (`chid`),
  CONSTRAINT `course` FOREIGN KEY (`cid`) REFERENCES `course` (`cid`) ON DELETE CASCADE,
  CONSTRAINT `workChapter` FOREIGN KEY (`chid`) REFERENCES `chapter` (`chid`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of work_t
-- ----------------------------
INSERT INTO `work_t` VALUES ('1', '测试作业1', '1', '测试作业1内容', '2018/11/16 16:00', '2018/11/30 18:00', null, null);
INSERT INTO `work_t` VALUES ('2', '测试作业2', '1', '测试作业2内容', '2019/03/08 12:39:24', '2019/07/05 00:00:00', '', null);
INSERT INTO `work_t` VALUES ('4', '测试作业3', '1', '测试内容3update', '2019/03/11 09:48:02', '2019/07/04 00:00:00', '《PHP程序设计》设计报告.doc', null);
