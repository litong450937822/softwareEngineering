/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50709
Source Host           : localhost:3306
Source Database       : software

Target Server Type    : MYSQL
Target Server Version : 50709
File Encoding         : 65001

Date: 2019-04-17 18:38:45
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for chapter
-- ----------------------------
DROP TABLE IF EXISTS `chapter`;
CREATE TABLE `chapter` (
  `chid` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `content` varchar(255) DEFAULT NULL,
  `time` varchar(19) NOT NULL,
  PRIMARY KEY (`chid`) USING BTREE,
  KEY `chid` (`chid`) USING BTREE,
  KEY `courseChapter` (`cid`) USING BTREE,
  CONSTRAINT `courseChapter` FOREIGN KEY (`cid`) REFERENCES `course` (`cid`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of chapter
-- ----------------------------
INSERT INTO `chapter` VALUES ('1', '1', '1', '测试章节1', 'T', null, '2019/03/19 23:26:56');
INSERT INTO `chapter` VALUES ('2', '1', '2', '测试章节2', 'T', null, '');
INSERT INTO `chapter` VALUES ('6', '1', '1', '学习资料', 'A', '分解模式.pptx', '2019/03/20 00:01:40');
INSERT INTO `chapter` VALUES ('7', '1', '1', '百度', 'K', 'http://www.baidu.com', '2019/03/20 00:12:38');
INSERT INTO `chapter` VALUES ('29', '2', '1', '测试章节1', 'T', null, '2019/03/19 23:26:56');
INSERT INTO `chapter` VALUES ('30', '2', '1', '学习资料', 'A', '分解模式.pptx', '2019/03/20 00:01:40');
INSERT INTO `chapter` VALUES ('31', '2', '1', '百度', 'K', 'http://www.baidu.com', '2019/03/20 00:12:38');

-- ----------------------------
-- Table structure for class
-- ----------------------------
DROP TABLE IF EXISTS `class`;
CREATE TABLE `class` (
  `clid` int(11) NOT NULL AUTO_INCREMENT,
  `className` varchar(255) NOT NULL,
  `grade` varchar(255) NOT NULL,
  `major` varchar(255) NOT NULL,
  PRIMARY KEY (`clid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of class
-- ----------------------------
INSERT INTO `class` VALUES ('1', '测试班级1', '测试年纪1', '测试专业1');
INSERT INTO `class` VALUES ('2', '测试班级2', '测试年纪1', '测试专业1');

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
  KEY `clid` (`clid`) USING BTREE,
  CONSTRAINT `clid` FOREIGN KEY (`clid`) REFERENCES `class` (`clid`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `tid` FOREIGN KEY (`tid`) REFERENCES `teacher` (`tid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of course
-- ----------------------------
INSERT INTO `course` VALUES ('1', '1', '1', '测试课程1', '2018.09.01', '2019.01.12', '测试课程1描述', '2018第一学期');
INSERT INTO `course` VALUES ('2', '2', '1', '测试课程1', '2018.09.01', '2019.01.12', '测试课程1描述', '2018第一学期');

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
  PRIMARY KEY (`dsid`) USING BTREE,
  KEY `disscuse` (`dtid`) USING BTREE,
  KEY `id_t` (`id`) USING BTREE,
  CONSTRAINT `disscuse` FOREIGN KEY (`dtid`) REFERENCES `discass_t` (`dtid`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of discass_s
-- ----------------------------
INSERT INTO `discass_s` VALUES ('1', '5', '1', '2019/03/22 01:01:48', '测试讨论回复1', 't');
INSERT INTO `discass_s` VALUES ('2', '5', '1', '2019/03/22 01:02:02', '测试讨论回复2', 's');
INSERT INTO `discass_s` VALUES ('6', '5', '2', '2019/03/22 01:02:35', '测试讨论回复3', 's');

-- ----------------------------
-- Table structure for discass_t
-- ----------------------------
DROP TABLE IF EXISTS `discass_t`;
CREATE TABLE `discass_t` (
  `dtid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `cid` int(11) NOT NULL,
  `lastUpdateTime` varchar(19) DEFAULT '0',
  `traffic` int(11) DEFAULT '0',
  `startTime` varchar(19) NOT NULL,
  `chid` int(11) DEFAULT NULL,
  PRIMARY KEY (`dtid`,`cid`) USING BTREE,
  KEY `discasst_c` (`cid`) USING BTREE,
  KEY `chapterDiscuss` (`chid`) USING BTREE,
  CONSTRAINT `chapterDiscuss` FOREIGN KEY (`chid`) REFERENCES `chapter` (`chid`) ON DELETE CASCADE,
  CONSTRAINT `discasst_c` FOREIGN KEY (`cid`) REFERENCES `course` (`cid`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of discass_t
-- ----------------------------
INSERT INTO `discass_t` VALUES ('5', '测试讨论1', '1', '2019/03/22 01:02:02', '11', '2019/03/20 23:17:39', '1');
INSERT INTO `discass_t` VALUES ('6', '测试讨论2', '1', '2019/03/22 01:29:11', '0', '2019/03/22 01:29:11', '2');

-- ----------------------------
-- Table structure for question_q
-- ----------------------------
DROP TABLE IF EXISTS `question_q`;
CREATE TABLE `question_q` (
  `qtid` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `number` int(11) NOT NULL,
  PRIMARY KEY (`qtid`,`number`) USING BTREE,
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
INSERT INTO `question_q` VALUES ('3', '测试问题1', '1');
INSERT INTO `question_q` VALUES ('3', '测试问题2', '2');
INSERT INTO `question_q` VALUES ('3', '测试问题3', '3');
INSERT INTO `question_q` VALUES ('3', '测试问题4', '4');
INSERT INTO `question_q` VALUES ('3', '测试问题5', '5');
INSERT INTO `question_q` VALUES ('3', '测试问题6', '6');
INSERT INTO `question_q` VALUES ('4', '测试问题1', '1');
INSERT INTO `question_q` VALUES ('4', '测试问题2', '2');
INSERT INTO `question_q` VALUES ('4', '测试问题3', '3');
INSERT INTO `question_q` VALUES ('4', '测试问题4', '4');
INSERT INTO `question_q` VALUES ('4', '测试问题5', '5');
INSERT INTO `question_q` VALUES ('4', '测试问题6', '6');
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
INSERT INTO `question_s` VALUES ('4', '1', '1;2;3;2;1;4', '2019/03/20 14:08:37');

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
  PRIMARY KEY (`qtid`,`cid`) USING BTREE,
  KEY `course_q` (`cid`) USING BTREE,
  CONSTRAINT `course_q` FOREIGN KEY (`cid`) REFERENCES `course` (`cid`) ON DELETE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of question_t
-- ----------------------------
INSERT INTO `question_t` VALUES ('2', '测试问卷2', '1', '2019/03/05 09:45:23', '2019/03/30 00:00:00');
INSERT INTO `question_t` VALUES ('3', '测试问卷3', '1', '2019/03/05 09:46:34', '2020/04/05 00:00:00');
INSERT INTO `question_t` VALUES ('4', '测试问卷4', '1', '2019/03/10 03:57:11', '2019/03/22 00:00:00');
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
  PRIMARY KEY (`sid`,`time`,`cid`) USING BTREE,
  KEY `courseCall` (`cid`) USING BTREE,
  CONSTRAINT `courseCall` FOREIGN KEY (`cid`) REFERENCES `course` (`cid`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `studentCall` FOREIGN KEY (`sid`) REFERENCES `student` (`sid`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of rollcall
-- ----------------------------
INSERT INTO `rollcall` VALUES ('1', '2019/03/18 07:57:26', 'A', '1');
INSERT INTO `rollcall` VALUES ('1', '2019/03/22 03:11:05', 'N', '1');
INSERT INTO `rollcall` VALUES ('1', '2019/03/22 03:11:09', 'N', '1');
INSERT INTO `rollcall` VALUES ('1', '2019/03/22 03:11:19', 'N', '1');
INSERT INTO `rollcall` VALUES ('1', '2019/03/22 03:11:21', 'T', '1');
INSERT INTO `rollcall` VALUES ('1', '2019/03/24 12:52:30', 'L', '1');
INSERT INTO `rollcall` VALUES ('2', '2019/03/18 07:57:26', 'N', '1');
INSERT INTO `rollcall` VALUES ('2', '2019/03/22 03:11:05', 'N', '1');
INSERT INTO `rollcall` VALUES ('2', '2019/03/22 03:11:09', 'N', '1');
INSERT INTO `rollcall` VALUES ('2', '2019/03/22 03:11:19', 'N', '1');
INSERT INTO `rollcall` VALUES ('2', '2019/03/22 03:11:21', 'N', '1');
INSERT INTO `rollcall` VALUES ('2', '2019/03/24 12:52:30', 'N', '1');
INSERT INTO `rollcall` VALUES ('3', '2019/03/18 07:57:26', 'N', '1');
INSERT INTO `rollcall` VALUES ('3', '2019/03/22 03:11:05', 'N', '1');
INSERT INTO `rollcall` VALUES ('3', '2019/03/22 03:11:09', 'T', '1');
INSERT INTO `rollcall` VALUES ('3', '2019/03/22 03:11:19', 'N', '1');
INSERT INTO `rollcall` VALUES ('3', '2019/03/22 03:11:21', 'N', '1');
INSERT INTO `rollcall` VALUES ('3', '2019/03/24 12:52:30', 'L', '1');
INSERT INTO `rollcall` VALUES ('4', '2019/03/18 07:57:26', 'L', '1');
INSERT INTO `rollcall` VALUES ('4', '2019/03/22 03:11:05', 'L', '1');
INSERT INTO `rollcall` VALUES ('4', '2019/03/22 03:11:09', 'N', '1');
INSERT INTO `rollcall` VALUES ('4', '2019/03/22 03:11:19', 'N', '1');
INSERT INTO `rollcall` VALUES ('4', '2019/03/22 03:11:21', 'N', '1');
INSERT INTO `rollcall` VALUES ('4', '2019/03/24 12:52:30', 'N', '1');
INSERT INTO `rollcall` VALUES ('5', '2019/03/18 07:57:26', 'N', '1');
INSERT INTO `rollcall` VALUES ('5', '2019/03/22 03:11:05', 'N', '1');
INSERT INTO `rollcall` VALUES ('5', '2019/03/22 03:11:09', 'N', '1');
INSERT INTO `rollcall` VALUES ('5', '2019/03/22 03:11:19', 'N', '1');
INSERT INTO `rollcall` VALUES ('5', '2019/03/22 03:11:21', 'N', '1');
INSERT INTO `rollcall` VALUES ('5', '2019/03/24 12:52:30', 'N', '1');
INSERT INTO `rollcall` VALUES ('6', '2019/03/18 07:57:26', 'N', '1');
INSERT INTO `rollcall` VALUES ('6', '2019/03/22 03:11:05', 'N', '1');
INSERT INTO `rollcall` VALUES ('6', '2019/03/22 03:11:09', 'N', '1');
INSERT INTO `rollcall` VALUES ('6', '2019/03/22 03:11:19', 'N', '1');
INSERT INTO `rollcall` VALUES ('6', '2019/03/22 03:11:21', 'N', '1');
INSERT INTO `rollcall` VALUES ('6', '2019/03/24 12:52:30', 'A', '1');
INSERT INTO `rollcall` VALUES ('7', '2019/03/18 07:57:26', 'L', '1');
INSERT INTO `rollcall` VALUES ('7', '2019/03/22 03:11:05', 'N', '1');
INSERT INTO `rollcall` VALUES ('7', '2019/03/22 03:11:09', 'N', '1');
INSERT INTO `rollcall` VALUES ('7', '2019/03/22 03:11:19', 'N', '1');
INSERT INTO `rollcall` VALUES ('7', '2019/03/22 03:11:21', 'L', '1');
INSERT INTO `rollcall` VALUES ('7', '2019/03/24 12:52:30', 'N', '1');
INSERT INTO `rollcall` VALUES ('8', '2019/03/18 07:57:26', 'N', '1');
INSERT INTO `rollcall` VALUES ('8', '2019/03/22 03:11:05', 'N', '1');
INSERT INTO `rollcall` VALUES ('8', '2019/03/22 03:11:09', 'N', '1');
INSERT INTO `rollcall` VALUES ('8', '2019/03/22 03:11:19', 'N', '1');
INSERT INTO `rollcall` VALUES ('8', '2019/03/22 03:11:21', 'N', '1');
INSERT INTO `rollcall` VALUES ('8', '2019/03/24 12:52:30', 'A', '1');
INSERT INTO `rollcall` VALUES ('9', '2019/03/18 07:57:26', 'N', '1');
INSERT INTO `rollcall` VALUES ('9', '2019/03/22 03:11:05', 'A', '1');
INSERT INTO `rollcall` VALUES ('9', '2019/03/22 03:11:09', 'N', '1');
INSERT INTO `rollcall` VALUES ('9', '2019/03/22 03:11:19', 'N', '1');
INSERT INTO `rollcall` VALUES ('9', '2019/03/22 03:11:21', 'N', '1');
INSERT INTO `rollcall` VALUES ('9', '2019/03/24 12:52:30', 'N', '1');
INSERT INTO `rollcall` VALUES ('10', '2019/03/18 07:57:26', 'A', '1');
INSERT INTO `rollcall` VALUES ('10', '2019/03/22 03:11:05', 'N', '1');
INSERT INTO `rollcall` VALUES ('10', '2019/03/22 03:11:09', 'N', '1');
INSERT INTO `rollcall` VALUES ('10', '2019/03/22 03:11:19', 'N', '1');
INSERT INTO `rollcall` VALUES ('10', '2019/03/22 03:11:21', 'L', '1');
INSERT INTO `rollcall` VALUES ('10', '2019/03/24 12:52:30', 'N', '1');

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
  `profilePhoto` varchar(255) DEFAULT 'default.jpg',
  PRIMARY KEY (`sid`,`number`) USING BTREE,
  UNIQUE KEY `studentNumber` (`number`) USING BTREE,
  KEY `class1` (`clid`) USING BTREE,
  KEY `sid` (`sid`) USING BTREE,
  CONSTRAINT `class1` FOREIGN KEY (`clid`) REFERENCES `class` (`clid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of student
-- ----------------------------
INSERT INTO `student` VALUES ('1', '测试学生1', '1', '123456', '1000001', 'W', 'default.jpg');
INSERT INTO `student` VALUES ('2', '测试学生2', '1', '123456', '1000002', 'M', 'default.jpg');
INSERT INTO `student` VALUES ('3', '测试学生3', '1', '123456', '1000003', 'M', 'default.jpg');
INSERT INTO `student` VALUES ('4', '测试学生4', '1', '123456', '1000004', 'M', 'default.jpg');
INSERT INTO `student` VALUES ('5', '测试学生5', '1', '123456', '1000005', 'M', 'default.jpg');
INSERT INTO `student` VALUES ('6', '测试学生6', '1', '123456', '1000006', 'W', 'default.jpg');
INSERT INTO `student` VALUES ('7', '测试学生7', '1', '123456', '1000007', 'W', 'default.jpg');
INSERT INTO `student` VALUES ('8', '测试学生8', '1', '123456', '1000008', 'M', 'default.jpg');
INSERT INTO `student` VALUES ('9', '测试学生9', '1', '123456', '1000009', 'M', 'default.jpg');
INSERT INTO `student` VALUES ('10', '测试学生10', '1', '123456', '1000010', 'W', 'default.jpg');
INSERT INTO `student` VALUES ('11', '测试学生11', '2', '123456', '1000011', 'M', 'default.jpg');

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
  PRIMARY KEY (`tid`,`number`) USING BTREE,
  KEY `tid` (`tid`) USING BTREE
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
  PRIMARY KEY (`ttid`,`number`) USING BTREE,
  CONSTRAINT `test` FOREIGN KEY (`ttid`) REFERENCES `test_t` (`ttid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

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
INSERT INTO `test_q` VALUES ('16', '1', '测试问题1', '测试选项', '测试选项', '正确选项', '测试选项', 'C');
INSERT INTO `test_q` VALUES ('16', '2', '测试问题2', '测试选项', '测试选项', '正确选项', '测试选项', 'C');
INSERT INTO `test_q` VALUES ('16', '3', '测试问题3', '测试选项', '正确选项', '测试选项', '测试选项', 'B');
INSERT INTO `test_q` VALUES ('16', '4', '测试问题4', '测试选项', '测试选项', '正确选项', '测试选项', 'C');
INSERT INTO `test_q` VALUES ('16', '5', '测试问题5', '正确选项', '测试选项', '测试选项', '测试选项', 'A');

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
  PRIMARY KEY (`ttid`,`sid`) USING BTREE,
  KEY `student` (`sid`) USING BTREE,
  CONSTRAINT `student` FOREIGN KEY (`sid`) REFERENCES `student` (`sid`),
  CONSTRAINT `testS` FOREIGN KEY (`ttid`) REFERENCES `test_t` (`ttid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of test_s
-- ----------------------------
INSERT INTO `test_s` VALUES ('12', 'D;B;C', '1', '100', '2019/03/11 10:19:53');
INSERT INTO `test_s` VALUES ('12', 'C;B;C', '2', '67', '');
INSERT INTO `test_s` VALUES ('13', 'B;D;B;A;B', '1', '60', '2019/03/20 14:09:37');
INSERT INTO `test_s` VALUES ('16', 'D;C;C;C;C', '1', '40', '2019/03/22 02:25:18');

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
  PRIMARY KEY (`ttid`) USING BTREE,
  KEY `classtest` (`cid`) USING BTREE,
  KEY `ttid` (`ttid`) USING BTREE,
  CONSTRAINT `classtest` FOREIGN KEY (`cid`) REFERENCES `class` (`clid`) ON DELETE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of test_t
-- ----------------------------
INSERT INTO `test_t` VALUES ('12', '测试数据1', '2019/03/03 12:06:31', '2019/07/05 00:00:00', '1');
INSERT INTO `test_t` VALUES ('13', '测试数据2', '2019/03/11 10:39:24', '2019/06/11 00:00:00', '1');
INSERT INTO `test_t` VALUES ('15', '测试测验3', '2019/03/11 10:42:13', '2019/04/06 00:00:00', '1');
INSERT INTO `test_t` VALUES ('16', '测试测验4', '2019/03/11 10:42:36', '2019/03/22 18:30:00', '1');

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
  KEY `student1` (`sid`) USING BTREE,
  CONSTRAINT `student1` FOREIGN KEY (`sid`) REFERENCES `student` (`sid`)
) ENGINE=InnoDB AUTO_INCREMENT=272 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

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
INSERT INTO `time` VALUES ('41', '2019/03/19', '14', 'L', '20:03:25', '20:03:39', '1', null);
INSERT INTO `time` VALUES ('42', '2019/03/19', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('43', '2019/03/19', '811', 'L', '20:05:27', '20:18:58', '1', null);
INSERT INTO `time` VALUES ('44', '2019/03/19', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('45', '2019/03/19', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('46', '2019/03/19', '73', 'L', '23:11:38', '23:12:51', '1', null);
INSERT INTO `time` VALUES ('47', '2019/03/19', null, 'O', null, null, '2', '1');
INSERT INTO `time` VALUES ('48', '2019/03/19', '824', 'L', '23:12:56', '23:26:40', '2', null);
INSERT INTO `time` VALUES ('49', '2019/03/19', null, 'O', null, null, '2', '1');
INSERT INTO `time` VALUES ('50', '2019/03/19', null, 'O', null, null, '2', '1');
INSERT INTO `time` VALUES ('51', '2019/03/19', null, 'O', null, null, '2', '1');
INSERT INTO `time` VALUES ('52', '2019/03/19', null, 'O', null, null, '2', '1');
INSERT INTO `time` VALUES ('53', '2019/03/19', null, 'O', null, null, '2', '1');
INSERT INTO `time` VALUES ('54', '2019/03/19', null, 'O', null, null, '2', '1');
INSERT INTO `time` VALUES ('55', '2019/03/19', null, 'O', null, null, '2', '1');
INSERT INTO `time` VALUES ('56', '2019/03/19', null, 'O', null, null, '2', '1');
INSERT INTO `time` VALUES ('57', '2019/03/19', null, 'O', null, null, '2', '1');
INSERT INTO `time` VALUES ('58', '2019/03/19', null, 'O', null, null, '2', '1');
INSERT INTO `time` VALUES ('59', '2019/03/19', null, 'O', null, null, '2', '1');
INSERT INTO `time` VALUES ('60', '2019/03/20', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('61', '2019/03/20', null, 'D', null, null, '1', '1');
INSERT INTO `time` VALUES ('62', '2019/03/20', '16', 'L', '00:30:41', '00:30:57', '1', null);
INSERT INTO `time` VALUES ('63', '2019/03/20', null, 'D', null, null, '1', '1');
INSERT INTO `time` VALUES ('64', '2019/03/20', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('65', '2019/03/20', '813', 'L', '09:59:56', '10:13:29', '1', null);
INSERT INTO `time` VALUES ('66', '2019/03/20', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('67', '2019/03/20', null, 'V', null, null, '1', '1');
INSERT INTO `time` VALUES ('68', '2019/03/20', null, 'V', null, null, '1', '1');
INSERT INTO `time` VALUES ('69', '2019/03/20', null, 'V', null, null, '1', '1');
INSERT INTO `time` VALUES ('70', '2019/03/20', null, 'V', null, null, '1', '1');
INSERT INTO `time` VALUES ('71', '2019/03/20', null, 'V', null, null, '1', '1');
INSERT INTO `time` VALUES ('72', '2019/03/20', null, 'V', null, null, '1', '1');
INSERT INTO `time` VALUES ('73', '2019/03/20', null, 'V', null, null, '1', '1');
INSERT INTO `time` VALUES ('74', '2019/03/20', null, 'V', null, null, '1', '1');
INSERT INTO `time` VALUES ('75', '2019/03/20', null, 'V', null, null, '1', '1');
INSERT INTO `time` VALUES ('76', '2019/03/20', null, 'V', null, null, '1', '1');
INSERT INTO `time` VALUES ('77', '2019/03/20', null, 'V', null, null, '1', '1');
INSERT INTO `time` VALUES ('78', '2019/03/20', null, 'V', null, null, '1', '1');
INSERT INTO `time` VALUES ('79', '2019/03/20', null, 'V', null, null, '1', '1');
INSERT INTO `time` VALUES ('80', '2019/03/20', null, 'V', null, null, '1', '1');
INSERT INTO `time` VALUES ('81', '2019/03/20', null, 'V', null, null, '1', '1');
INSERT INTO `time` VALUES ('82', '2019/03/20', null, 'V', null, null, '1', '1');
INSERT INTO `time` VALUES ('83', '2019/03/20', null, 'V', null, null, '1', '1');
INSERT INTO `time` VALUES ('84', '2019/03/20', '387', 'L', '14:03:45', '14:10:12', '1', null);
INSERT INTO `time` VALUES ('85', '2019/03/20', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('86', '2019/03/20', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('87', '2019/03/20', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('88', '2019/03/20', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('89', '2019/03/20', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('90', '2019/03/20', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('91', '2019/03/20', '34', 'W', '14:06:47', '14:07:21', '1', '1');
INSERT INTO `time` VALUES ('92', '2019/03/20', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('93', '2019/03/20', null, 'V', null, null, '1', '1');
INSERT INTO `time` VALUES ('94', '2019/03/20', null, 'Q', null, null, '1', '1');
INSERT INTO `time` VALUES ('95', '2019/03/20', null, 'Q', null, null, '1', '1');
INSERT INTO `time` VALUES ('96', '2019/03/20', null, 'E', null, null, '1', '1');
INSERT INTO `time` VALUES ('97', '2019/03/20', '26', 'T', '14:09:11', '14:09:37', '1', '1');
INSERT INTO `time` VALUES ('98', '2019/03/21', '464', 'L', '21:12:20', '21:20:04', '1', null);
INSERT INTO `time` VALUES ('99', '2019/03/21', '827', 'L', '21:21:30', '21:35:17', '1', null);
INSERT INTO `time` VALUES ('100', '2019/03/21', '97', 'L', '21:47:52', '21:49:29', '1', null);
INSERT INTO `time` VALUES ('101', '2019/03/21', '1641', 'L', '21:57:51', '22:25:12', '1', null);
INSERT INTO `time` VALUES ('102', '2019/03/21', null, 'A', null, null, '1', '1');
INSERT INTO `time` VALUES ('103', '2019/03/21', null, 'K', null, null, '1', '1');
INSERT INTO `time` VALUES ('104', '2019/03/21', null, 'K', null, null, '1', '1');
INSERT INTO `time` VALUES ('105', '2019/03/21', null, 'K', null, null, '1', '1');
INSERT INTO `time` VALUES ('106', '2019/03/21', null, 'K', null, null, '1', '1');
INSERT INTO `time` VALUES ('107', '2019/03/21', '1131', 'L', '22:30:04', '22:48:55', '1', null);
INSERT INTO `time` VALUES ('108', '2019/03/21', '15', 'L', '23:41:27', '23:41:42', '1', null);
INSERT INTO `time` VALUES ('109', '2019/03/21', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('110', '2019/03/21', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('111', '2019/03/21', '15', 'L', '23:45:11', '23:45:26', '1', null);
INSERT INTO `time` VALUES ('112', '2019/03/21', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('113', '2019/03/21', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('114', '2019/03/21', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('115', '2019/03/21', '16', 'L', '23:46:12', '23:46:28', '1', null);
INSERT INTO `time` VALUES ('116', '2019/03/21', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('117', '2019/03/21', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('118', '2019/03/21', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('119', '2019/03/21', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('120', '2019/03/21', '-84972', 'L', '23:48:36', '00:12:24', '1', null);
INSERT INTO `time` VALUES ('121', '2019/03/21', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('122', '2019/03/21', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('123', '2019/03/21', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('124', '2019/03/22', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('125', '2019/03/22', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('126', '2019/03/22', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('127', '2019/03/22', '7', 'W', '00:09:20', '00:09:27', '1', '1');
INSERT INTO `time` VALUES ('128', '2019/03/22', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('129', '2019/03/22', null, 'D', null, null, '1', '1');
INSERT INTO `time` VALUES ('130', '2019/03/22', null, 'D', null, null, '1', '1');
INSERT INTO `time` VALUES ('131', '2019/03/22', '11', 'L', '01:01:54', '01:02:05', '1', null);
INSERT INTO `time` VALUES ('132', '2019/03/22', null, 'D', null, null, '2', '1');
INSERT INTO `time` VALUES ('133', '2019/03/22', null, 'D', null, null, '2', '1');
INSERT INTO `time` VALUES ('134', '2019/03/22', null, 'D', null, null, '2', '1');
INSERT INTO `time` VALUES ('135', '2019/03/22', null, 'D', null, null, '2', '1');
INSERT INTO `time` VALUES ('136', '2019/03/22', '283', 'L', '01:02:10', '01:06:53', '2', null);
INSERT INTO `time` VALUES ('137', '2019/03/22', null, 'D', null, null, '2', '1');
INSERT INTO `time` VALUES ('138', '2019/03/22', '116', 'L', '01:32:10', '01:34:06', '1', null);
INSERT INTO `time` VALUES ('139', '2019/03/22', null, 'E', null, null, '1', '1');
INSERT INTO `time` VALUES ('140', '2019/03/22', '1208', 'L', '01:34:50', '01:54:58', '1', null);
INSERT INTO `time` VALUES ('141', '2019/03/22', null, 'E', null, null, '1', '1');
INSERT INTO `time` VALUES ('142', '2019/03/22', null, 'E', null, null, '1', '1');
INSERT INTO `time` VALUES ('143', '2019/03/22', null, 'E', null, null, '1', '1');
INSERT INTO `time` VALUES ('144', '2019/03/22', null, 'E', null, null, '1', '1');
INSERT INTO `time` VALUES ('145', '2019/03/22', null, 'E', null, null, '1', '1');
INSERT INTO `time` VALUES ('146', '2019/03/22', null, 'V', null, null, '1', '1');
INSERT INTO `time` VALUES ('147', '2019/03/22', null, 'V', null, null, '1', '1');
INSERT INTO `time` VALUES ('148', '2019/03/22', '266', 'L', '02:15:57', '02:20:23', '1', null);
INSERT INTO `time` VALUES ('149', '2019/03/22', null, 'E', null, null, '1', '1');
INSERT INTO `time` VALUES ('150', '2019/03/22', '87', 'L', '02:23:55', '02:25:22', '1', null);
INSERT INTO `time` VALUES ('151', '2019/03/22', null, 'E', null, null, '1', '1');
INSERT INTO `time` VALUES ('152', '2019/03/22', '44', 'T', '02:24:34', '02:25:18', '1', '1');
INSERT INTO `time` VALUES ('153', '2019/03/22', null, 'V', null, null, '1', '1');
INSERT INTO `time` VALUES ('154', '2019/03/22', '210', 'L', '02:36:41', '02:40:11', '1', null);
INSERT INTO `time` VALUES ('155', '2019/03/22', null, 'V', null, null, '2', '1');
INSERT INTO `time` VALUES ('156', '2019/03/22', '19', 'L', '02:43:38', '02:43:57', '2', null);
INSERT INTO `time` VALUES ('157', '2019/03/22', null, 'V', null, null, '3', '1');
INSERT INTO `time` VALUES ('158', '2019/03/22', '134', 'L', '02:44:02', '02:46:16', '3', null);
INSERT INTO `time` VALUES ('159', '2019/03/22', null, 'V', null, null, '3', '1');
INSERT INTO `time` VALUES ('160', '2019/03/22', null, 'V', null, null, '3', '1');
INSERT INTO `time` VALUES ('161', '2019/03/22', null, 'V', null, null, '3', '1');
INSERT INTO `time` VALUES ('162', '2019/03/22', null, 'V', null, null, '3', '1');
INSERT INTO `time` VALUES ('163', '2019/03/22', null, 'V', null, null, '3', '1');
INSERT INTO `time` VALUES ('164', '2019/03/22', null, 'V', null, null, '4', '1');
INSERT INTO `time` VALUES ('165', '2019/03/22', null, 'V', null, null, '4', '1');
INSERT INTO `time` VALUES ('166', '2019/03/22', '184', 'L', '02:46:21', '02:49:25', '4', null);
INSERT INTO `time` VALUES ('167', '2019/03/22', null, 'V', null, null, '4', '1');
INSERT INTO `time` VALUES ('168', '2019/03/22', null, 'V', null, null, '4', '1');
INSERT INTO `time` VALUES ('169', '2019/03/22', null, 'V', null, null, '4', '1');
INSERT INTO `time` VALUES ('170', '2019/03/22', null, 'V', null, null, '4', '1');
INSERT INTO `time` VALUES ('171', '2019/03/22', null, 'V', null, null, '6', '1');
INSERT INTO `time` VALUES ('172', '2019/03/22', '21', 'L', '02:49:32', '02:49:53', '6', null);
INSERT INTO `time` VALUES ('173', '2019/03/22', null, 'V', null, null, '7', '1');
INSERT INTO `time` VALUES ('174', '2019/03/22', '11', 'L', '02:50:05', '02:50:16', '7', null);
INSERT INTO `time` VALUES ('175', '2019/03/22', '10', 'L', '03:10:46', '03:10:56', '1', null);
INSERT INTO `time` VALUES ('176', '2019/03/22', '41', 'L', '03:16:10', '03:16:51', '1', null);
INSERT INTO `time` VALUES ('177', '2019/03/23', '27', 'L', '18:20:13', '18:20:40', '1', null);
INSERT INTO `time` VALUES ('178', '2019/03/23', null, 'A', null, null, '1', '1');
INSERT INTO `time` VALUES ('179', '2019/03/23', '32', 'L', '18:26:36', '18:27:08', '1', null);
INSERT INTO `time` VALUES ('180', '2019/03/23', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('181', '2019/03/23', '74', 'L', '20:06:25', '20:07:39', '1', null);
INSERT INTO `time` VALUES ('182', '2019/03/24', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('183', '2019/03/24', '941', 'L', '00:36:48', '00:52:29', '1', null);
INSERT INTO `time` VALUES ('184', '2019/03/24', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('185', '2019/03/24', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('186', '2019/03/24', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('187', '2019/03/24', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('188', '2019/03/24', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('189', '2019/03/24', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('190', '2019/03/24', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('191', '2019/03/24', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('192', '2019/03/24', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('193', '2019/03/24', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('207', '2019/03/24', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('208', '2019/03/24', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('209', '2019/03/24', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('210', '2019/03/24', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('211', '2019/03/24', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('212', '2019/03/24', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('213', '2019/03/24', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('214', '2019/03/24', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('215', '2019/03/24', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('216', '2019/03/24', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('217', '2019/03/24', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('229', '2019/03/24', '619', 'L', '01:01:07', '01:11:26', '1', null);
INSERT INTO `time` VALUES ('230', '2019/03/24', '75', 'W', '01:07:23', '01:08:38', '1', '1');
INSERT INTO `time` VALUES ('231', '2019/03/24', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('232', '2019/03/24', null, 'V', null, null, '1', '1');
INSERT INTO `time` VALUES ('233', '2019/03/24', '186', 'L', '11:27:51', '11:30:57', '1', null);
INSERT INTO `time` VALUES ('234', '2019/03/24', null, 'V', null, null, '1', '1');
INSERT INTO `time` VALUES ('235', '2019/03/24', null, 'V', null, null, '1', '1');
INSERT INTO `time` VALUES ('236', '2019/03/24', null, 'V', null, null, '1', '1');
INSERT INTO `time` VALUES ('237', '2019/03/24', null, 'Q', null, null, '1', '1');
INSERT INTO `time` VALUES ('238', '2019/03/24', '187', 'L', '11:53:03', '11:56:10', '1', null);
INSERT INTO `time` VALUES ('239', '2019/03/24', null, 'E', null, null, '1', '1');
INSERT INTO `time` VALUES ('240', '2019/03/24', '12', 'T', '12:44:36', '12:44:48', '1', '1');
INSERT INTO `time` VALUES ('241', '2019/03/24', '82', 'L', '12:44:29', '12:45:51', '1', null);
INSERT INTO `time` VALUES ('242', '2019/03/24', null, 'E', null, null, '1', '1');
INSERT INTO `time` VALUES ('243', '2019/03/24', '9', 'T', '12:46:26', '12:46:35', '1', '1');
INSERT INTO `time` VALUES ('244', '2019/03/24', '12', 'L', '12:46:24', '12:46:36', '1', null);
INSERT INTO `time` VALUES ('245', '2019/03/24', '33', 'L', '12:57:57', '12:58:30', '1', null);
INSERT INTO `time` VALUES ('246', '2019/03/24', '107', 'L', '12:59:21', '13:01:08', '1', null);
INSERT INTO `time` VALUES ('247', '2019/03/24', '495', 'L', '14:00:40', '14:08:55', '1', null);
INSERT INTO `time` VALUES ('248', '2019/03/24', '13441', 'L', '15:02:55', '18:46:56', '1', null);
INSERT INTO `time` VALUES ('249', '2019/04/10', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('250', '2019/04/10', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('251', '2019/04/10', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('252', '2019/04/10', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('253', '2019/04/10', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('254', '2019/04/10', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('255', '2019/04/10', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('256', '2019/04/10', '529', 'L', '12:13:29', '12:22:18', '1', null);
INSERT INTO `time` VALUES ('257', '2019/04/10', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('258', '2019/04/10', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('259', '2019/04/10', null, 'V', null, null, '1', '1');
INSERT INTO `time` VALUES ('260', '2019/04/10', null, 'E', null, null, '1', '1');
INSERT INTO `time` VALUES ('261', '2019/04/10', null, 'E', null, null, '1', '1');
INSERT INTO `time` VALUES ('262', '2019/04/10', null, 'E', null, null, '1', '1');
INSERT INTO `time` VALUES ('263', '2019/04/10', null, 'E', null, null, '1', '1');
INSERT INTO `time` VALUES ('264', '2019/04/10', null, 'E', null, null, '1', '1');
INSERT INTO `time` VALUES ('265', '2019/04/10', null, 'E', null, null, '1', '1');
INSERT INTO `time` VALUES ('266', '2019/04/10', null, 'E', null, null, '1', '1');
INSERT INTO `time` VALUES ('267', '2019/04/10', null, 'E', null, null, '1', '1');
INSERT INTO `time` VALUES ('268', '2019/04/10', null, 'E', null, null, '1', '1');
INSERT INTO `time` VALUES ('269', '2019/04/10', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('270', '2019/04/10', null, 'O', null, null, '1', '1');
INSERT INTO `time` VALUES ('271', '2019/04/17', '361', 'L', '18:32:44', '18:38:45', '1', null);

-- ----------------------------
-- Table structure for vote_s
-- ----------------------------
DROP TABLE IF EXISTS `vote_s`;
CREATE TABLE `vote_s` (
  `vtid` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  `result` int(11) NOT NULL,
  PRIMARY KEY (`vtid`,`sid`) USING BTREE,
  KEY `student_v` (`sid`) USING BTREE,
  CONSTRAINT `student_v` FOREIGN KEY (`sid`) REFERENCES `student` (`sid`) ON DELETE CASCADE,
  CONSTRAINT `vtid` FOREIGN KEY (`vtid`) REFERENCES `vote_t` (`vtid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of vote_s
-- ----------------------------
INSERT INTO `vote_s` VALUES ('1', '1', '2');
INSERT INTO `vote_s` VALUES ('1', '2', '2');
INSERT INTO `vote_s` VALUES ('1', '3', '0');
INSERT INTO `vote_s` VALUES ('1', '4', '3');
INSERT INTO `vote_s` VALUES ('1', '6', '2');
INSERT INTO `vote_s` VALUES ('1', '7', '2');
INSERT INTO `vote_s` VALUES ('4', '3', '0');
INSERT INTO `vote_s` VALUES ('4', '4', '2');

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
  KEY `class` (`cid`) USING BTREE,
  CONSTRAINT `class` FOREIGN KEY (`cid`) REFERENCES `class` (`clid`) ON DELETE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of vote_t
-- ----------------------------
INSERT INTO `vote_t` VALUES ('1', '测试投票1', '测试选项1;12412421;214124;21421412412', '2019/03/10 03:56:37', '2019/03/30 00:00:00', '1');
INSERT INTO `vote_t` VALUES ('4', '测试投票2', '测试选项1;测试选项2;测试选项3;测试选项4', '2019/03/20 02:14:09', '2019/03/31 00:00:00', '1');

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
INSERT INTO `work_s` VALUES ('2', '1', '2019/03/20 14:07:21', '测试作业2内容', '第五组实训展示.pptx', '80');
INSERT INTO `work_s` VALUES ('2', '2', '2019/03/18 10:20:50', '12431241241', 'game.txt', '0');
INSERT INTO `work_s` VALUES ('4', '1', '2019/03/11 10:05:57', '测试作业3内容', '', '75');
INSERT INTO `work_s` VALUES ('15', '1', '2019/03/22 00:09:27', 'test', '', '76');

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
  PRIMARY KEY (`wtid`) USING BTREE,
  KEY `course` (`cid`) USING BTREE,
  KEY `workChapter` (`chid`) USING BTREE,
  CONSTRAINT `course` FOREIGN KEY (`cid`) REFERENCES `course` (`cid`) ON DELETE CASCADE,
  CONSTRAINT `workChapter` FOREIGN KEY (`chid`) REFERENCES `chapter` (`chid`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of work_t
-- ----------------------------
INSERT INTO `work_t` VALUES ('2', '测试作业2', '1', '测试作业2内容', '2019/03/08 12:39:24', '2019/07/05 00:00:00', '', '2');
INSERT INTO `work_t` VALUES ('4', '测试作业3', '1', '测试内容3update', '2019/03/11 09:48:02', '2019/03/15 18:00:00', '《PHP程序设计》设计报告.doc', '2');
INSERT INTO `work_t` VALUES ('15', '测试作业1', '1', '测试作业1', '2019/03/20 10:55:41', '2019/03/30 00:00:00', '', '1');
INSERT INTO `work_t` VALUES ('16', '测试作业1', '2', '测试作业1', '2019/03/20 10:55:41', '2019/03/30 00:00:00', '', '29');
