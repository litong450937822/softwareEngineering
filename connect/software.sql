/*
 Navicat Premium Data Transfer

 Source Server         : web
 Source Server Type    : MySQL
 Source Server Version : 50720
 Source Host           : localhost:3306
 Source Schema         : software

 Target Server Type    : MySQL
 Target Server Version : 50720
 File Encoding         : 65001

 Date: 20/03/2019 21:00:03
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for attachment
-- ----------------------------
DROP TABLE IF EXISTS `attachment`;
CREATE TABLE `attachment`  (
  `aid` int(11) NOT NULL AUTO_INCREMENT,
  `file` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `startTime` varchar(19) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `target` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `chid` int(11) NOT NULL,
  PRIMARY KEY (`aid`) USING BTREE,
  INDEX `attachment`(`chid`) USING BTREE,
  CONSTRAINT `attachment` FOREIGN KEY (`chid`) REFERENCES `chapter` (`chid`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for chapter
-- ----------------------------
DROP TABLE IF EXISTS `chapter`;
CREATE TABLE `chapter`  (
  `chid` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `content` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `time` varchar(19) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`chid`) USING BTREE,
  INDEX `chid`(`chid`) USING BTREE,
  INDEX `courseChapter`(`cid`) USING BTREE,
  CONSTRAINT `courseChapter` FOREIGN KEY (`cid`) REFERENCES `course` (`cid`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 35 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of chapter
-- ----------------------------
INSERT INTO `chapter` VALUES (1, 1, 1, '测试章节1', 'T', NULL, '2019/03/19 23:26:56');
INSERT INTO `chapter` VALUES (2, 1, 2, '测试章节2', 'T', NULL, '');
INSERT INTO `chapter` VALUES (5, 1, 3, '测试章节3', 'T', NULL, '2019/03/19 23:26:56');
INSERT INTO `chapter` VALUES (6, 1, 1, '学习资料', 'A', '分解模式.pptx', '2019/03/20 00:01:40');
INSERT INTO `chapter` VALUES (7, 1, 1, '百度', 'L', 'http://www.baidu.com', '2019/03/20 00:12:38');
INSERT INTO `chapter` VALUES (29, 2, 1, '测试章节1', 'T', NULL, '2019/03/19 23:26:56');
INSERT INTO `chapter` VALUES (30, 2, 1, '学习资料', 'A', '分解模式.pptx', '2019/03/20 00:01:40');
INSERT INTO `chapter` VALUES (31, 2, 1, '百度', 'L', 'http://www.baidu.com', '2019/03/20 00:12:38');

-- ----------------------------
-- Table structure for class
-- ----------------------------
DROP TABLE IF EXISTS `class`;
CREATE TABLE `class`  (
  `clid` int(11) NOT NULL AUTO_INCREMENT,
  `className` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `grade` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `major` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`clid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of class
-- ----------------------------
INSERT INTO `class` VALUES (1, '测试班级1', '测试年纪1', '测试专业1');
INSERT INTO `class` VALUES (2, '测试班级2', '测试年纪1', '测试专业1');

-- ----------------------------
-- Table structure for course
-- ----------------------------
DROP TABLE IF EXISTS `course`;
CREATE TABLE `course`  (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `clid` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  `courseName` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `startDate` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `endDate` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `describe` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `semester` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`cid`) USING BTREE,
  INDEX `tid`(`tid`) USING BTREE,
  INDEX `clid`(`clid`) USING BTREE,
  CONSTRAINT `clid` FOREIGN KEY (`clid`) REFERENCES `class` (`clid`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `tid` FOREIGN KEY (`tid`) REFERENCES `teacher` (`tid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of course
-- ----------------------------
INSERT INTO `course` VALUES (1, 1, 1, '测试课程1', '2018.09.01', '2019.01.12', '测试课程1描述', '2018第一学期');
INSERT INTO `course` VALUES (2, 2, 1, '测试课程1', '2018.09.01', '2019.01.12', '测试课程1描述', '2018第一学期');

-- ----------------------------
-- Table structure for discass_s
-- ----------------------------
DROP TABLE IF EXISTS `discass_s`;
CREATE TABLE `discass_s`  (
  `dsid` int(11) NOT NULL AUTO_INCREMENT,
  `dtid` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `time` varchar(19) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `content` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `identity` varchar(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`dsid`) USING BTREE,
  INDEX `disscuse`(`dtid`) USING BTREE,
  INDEX `id_t`(`id`) USING BTREE,
  CONSTRAINT `disscuse` FOREIGN KEY (`dtid`) REFERENCES `discass_t` (`dtid`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `id_s` FOREIGN KEY (`id`) REFERENCES `student` (`sid`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `id_t` FOREIGN KEY (`id`) REFERENCES `teacher` (`tid`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for discass_t
-- ----------------------------
DROP TABLE IF EXISTS `discass_t`;
CREATE TABLE `discass_t`  (
  `dtid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `cid` int(11) NOT NULL,
  `lastUpdateTime` varchar(19) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0',
  `traffic` int(11) NULL DEFAULT 0,
  `startTime` varchar(19) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `chid` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`dtid`, `cid`) USING BTREE,
  INDEX `discasst_c`(`cid`) USING BTREE,
  INDEX `chapterDiscuss`(`chid`) USING BTREE,
  CONSTRAINT `chapterDiscuss` FOREIGN KEY (`chid`) REFERENCES `chapter` (`chid`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `discasst_c` FOREIGN KEY (`cid`) REFERENCES `course` (`cid`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for question_q
-- ----------------------------
DROP TABLE IF EXISTS `question_q`;
CREATE TABLE `question_q`  (
  `qtid` int(11) NOT NULL,
  `question` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `number` int(11) NOT NULL,
  PRIMARY KEY (`qtid`, `number`) USING BTREE,
  INDEX `qtid`(`qtid`) USING BTREE,
  CONSTRAINT `qtid` FOREIGN KEY (`qtid`) REFERENCES `question_t` (`qtid`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of question_q
-- ----------------------------
INSERT INTO `question_q` VALUES (2, '测试问卷2问题1', 1);
INSERT INTO `question_q` VALUES (2, '21412412421', 2);
INSERT INTO `question_q` VALUES (2, '214124124124', 3);
INSERT INTO `question_q` VALUES (2, '21412421412412', 4);
INSERT INTO `question_q` VALUES (3, '测试问题1', 1);
INSERT INTO `question_q` VALUES (3, '测试问题2', 2);
INSERT INTO `question_q` VALUES (3, '测试问题3', 3);
INSERT INTO `question_q` VALUES (3, '测试问题4', 4);
INSERT INTO `question_q` VALUES (3, '测试问题5', 5);
INSERT INTO `question_q` VALUES (3, '测试问题6', 6);
INSERT INTO `question_q` VALUES (4, '测试问题1', 1);
INSERT INTO `question_q` VALUES (4, '测试问题2', 2);
INSERT INTO `question_q` VALUES (4, '测试问题3', 3);
INSERT INTO `question_q` VALUES (4, '测试问题4', 4);
INSERT INTO `question_q` VALUES (4, '测试问题5', 5);
INSERT INTO `question_q` VALUES (4, '测试问题6', 6);
INSERT INTO `question_q` VALUES (5, '测试问卷1问题1', 1);
INSERT INTO `question_q` VALUES (5, '21412412421', 2);
INSERT INTO `question_q` VALUES (5, '214124124124', 3);
INSERT INTO `question_q` VALUES (5, '21412421412412', 4);

-- ----------------------------
-- Table structure for question_s
-- ----------------------------
DROP TABLE IF EXISTS `question_s`;
CREATE TABLE `question_s`  (
  `qtid` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  `result` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `submitTime` varchar(19) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`qtid`, `sid`) USING BTREE,
  INDEX `student_q`(`sid`) USING BTREE,
  CONSTRAINT `question` FOREIGN KEY (`qtid`) REFERENCES `question_t` (`qtid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `student_q` FOREIGN KEY (`sid`) REFERENCES `student` (`sid`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of question_s
-- ----------------------------
INSERT INTO `question_s` VALUES (2, 1, '1;2;1;2', '2019/03/11 10:38:25');
INSERT INTO `question_s` VALUES (3, 1, '2;2;2;1;2;1', '2019/03/11 10:38:34');
INSERT INTO `question_s` VALUES (4, 1, '1;2;3;2;1;4', '2019/03/20 14:08:37');

-- ----------------------------
-- Table structure for question_t
-- ----------------------------
DROP TABLE IF EXISTS `question_t`;
CREATE TABLE `question_t`  (
  `qtid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `cid` int(11) NOT NULL,
  `startTime` varchar(19) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `endTime` varchar(19) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`qtid`, `cid`) USING BTREE,
  INDEX `course_q`(`cid`) USING BTREE,
  CONSTRAINT `course_q` FOREIGN KEY (`cid`) REFERENCES `course` (`cid`) ON DELETE NO ACTION ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of question_t
-- ----------------------------
INSERT INTO `question_t` VALUES (2, '测试问卷2', 1, '2019/03/05 09:45:23', '2019/03/30 00:00:00');
INSERT INTO `question_t` VALUES (3, '测试问卷3', 1, '2019/03/05 09:46:34', '2020/04/05 00:00:00');
INSERT INTO `question_t` VALUES (4, '测试问卷4', 1, '2019/03/10 03:57:11', '2019/03/22 00:00:00');
INSERT INTO `question_t` VALUES (5, '测试问卷1', 1, '2019/03/05 09:45:23', '2019/03/30 00:00:00');

-- ----------------------------
-- Table structure for rollcall
-- ----------------------------
DROP TABLE IF EXISTS `rollcall`;
CREATE TABLE `rollcall`  (
  `sid` int(11) NOT NULL,
  `time` varchar(19) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `state` varchar(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `cid` int(11) NOT NULL,
  PRIMARY KEY (`sid`, `time`, `cid`) USING BTREE,
  INDEX `courseCall`(`cid`) USING BTREE,
  CONSTRAINT `courseCall` FOREIGN KEY (`cid`) REFERENCES `course` (`cid`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `studentCall` FOREIGN KEY (`sid`) REFERENCES `student` (`sid`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of rollcall
-- ----------------------------
INSERT INTO `rollcall` VALUES (1, '2019/03/18 07:57:26', 'A', 1);
INSERT INTO `rollcall` VALUES (2, '2019/03/18 07:57:26', 'N', 1);
INSERT INTO `rollcall` VALUES (3, '2019/03/18 07:57:26', 'N', 1);
INSERT INTO `rollcall` VALUES (4, '2019/03/18 07:57:26', 'L', 1);
INSERT INTO `rollcall` VALUES (5, '2019/03/18 07:57:26', 'N', 1);
INSERT INTO `rollcall` VALUES (6, '2019/03/18 07:57:26', 'N', 1);
INSERT INTO `rollcall` VALUES (7, '2019/03/18 07:57:26', 'L', 1);
INSERT INTO `rollcall` VALUES (8, '2019/03/18 07:57:26', 'N', 1);
INSERT INTO `rollcall` VALUES (9, '2019/03/18 07:57:26', 'N', 1);
INSERT INTO `rollcall` VALUES (10, '2019/03/18 07:57:26', 'A', 1);

-- ----------------------------
-- Table structure for student
-- ----------------------------
DROP TABLE IF EXISTS `student`;
CREATE TABLE `student`  (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `clid` int(11) NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `number` int(11) NOT NULL,
  `sex` varchar(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `studyTime` int(255) NOT NULL DEFAULT 0,
  `profilePhoto` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'default.jpg',
  PRIMARY KEY (`sid`, `number`) USING BTREE,
  UNIQUE INDEX `studentNumber`(`number`) USING BTREE,
  INDEX `class1`(`clid`) USING BTREE,
  INDEX `sid`(`sid`) USING BTREE,
  CONSTRAINT `class1` FOREIGN KEY (`clid`) REFERENCES `class` (`clid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of student
-- ----------------------------
INSERT INTO `student` VALUES (1, '测试学生1', 1, '123456', 1000001, 'W', 0, 'default.jpg');
INSERT INTO `student` VALUES (2, '测试学生2', 1, '123456', 1000002, 'M', 0, 'default.jpg');
INSERT INTO `student` VALUES (3, '测试学生3', 1, '123456', 1000003, 'M', 0, 'default.jpg');
INSERT INTO `student` VALUES (4, '测试学生4', 1, '123456', 1000004, 'M', 0, 'default.jpg');
INSERT INTO `student` VALUES (5, '测试学生5', 1, '123456', 1000005, 'M', 0, 'default.jpg');
INSERT INTO `student` VALUES (6, '测试学生6', 1, '123456', 1000006, 'W', 0, 'default.jpg');
INSERT INTO `student` VALUES (7, '测试学生7', 1, '123456', 1000007, 'W', 0, 'default.jpg');
INSERT INTO `student` VALUES (8, '测试学生8', 1, '123456', 1000008, 'M', 0, 'default.jpg');
INSERT INTO `student` VALUES (9, '测试学生9', 1, '123456', 1000009, 'M', 0, 'default.jpg');
INSERT INTO `student` VALUES (10, '测试学生10', 1, '123456', 1000010, 'W', 0, 'default.jpg');
INSERT INTO `student` VALUES (11, '测试学生11', 2, '123456', 1000011, 'M', 0, 'default.jpg');

-- ----------------------------
-- Table structure for teacher
-- ----------------------------
DROP TABLE IF EXISTS `teacher`;
CREATE TABLE `teacher`  (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `number` int(11) NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `profilePhoto` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`tid`, `number`) USING BTREE,
  INDEX `tid`(`tid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of teacher
-- ----------------------------
INSERT INTO `teacher` VALUES (1, 400001, '123456', '测试教师1', NULL);

-- ----------------------------
-- Table structure for test_q
-- ----------------------------
DROP TABLE IF EXISTS `test_q`;
CREATE TABLE `test_q`  (
  `ttid` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `question` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `option1` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `option2` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `option3` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `option4` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `answer` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`ttid`, `number`) USING BTREE,
  CONSTRAINT `test` FOREIGN KEY (`ttid`) REFERENCES `test_t` (`ttid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of test_q
-- ----------------------------
INSERT INTO `test_q` VALUES (12, 1, '测试问题1', '测试选项', '测试选项', '测试选项', '正确选项', 'D');
INSERT INTO `test_q` VALUES (12, 2, '测试问题2', '测试选项', '正确选项', '测试选项', '测试选项', 'B');
INSERT INTO `test_q` VALUES (12, 3, '测试问题3', '测试选项', '测试选项', '正确选项', '测试选项', 'C');
INSERT INTO `test_q` VALUES (13, 1, '测试问题1', '111', '2222', '333', '44444444', 'D');
INSERT INTO `test_q` VALUES (13, 2, '测试问题2', '2222222222', '3333', '44444444444', '222222', 'B');
INSERT INTO `test_q` VALUES (13, 3, '测试问题3', '111', '2222222', '333', '333333', 'B');
INSERT INTO `test_q` VALUES (13, 4, '测试问题4', '1111111111111111', '2222', '3333333', '444444444444', 'A');
INSERT INTO `test_q` VALUES (13, 5, '测试问题5', '111', '22222222', '333333', '4444', 'B');
INSERT INTO `test_q` VALUES (15, 1, '124124', '12421421', '2142142', '214124', '214214124', 'D');
INSERT INTO `test_q` VALUES (15, 2, '124124', '12421421421', '2142142', '214124131311331', '214214124', 'C');
INSERT INTO `test_q` VALUES (16, 1, '测试问题1', '测试选项', '测试选项', '正确选项', '测试选项', 'C');
INSERT INTO `test_q` VALUES (16, 2, '测试问题2', '测试选项', '测试选项', '正确选项', '测试选项', 'D');
INSERT INTO `test_q` VALUES (16, 3, '测试问题3', '测试选项', '正确选项', '测试选项', '测试选项', 'B');
INSERT INTO `test_q` VALUES (16, 4, '测试问题4', '测试选项', '测试选项', '正确选项', '测试选项', 'C');
INSERT INTO `test_q` VALUES (16, 5, '测试问题1', '正确选项', '测试选项', '测试选项', '测试选项', 'A');

-- ----------------------------
-- Table structure for test_s
-- ----------------------------
DROP TABLE IF EXISTS `test_s`;
CREATE TABLE `test_s`  (
  `ttid` int(11) NOT NULL,
  `answer` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `sid` int(11) NOT NULL,
  `score` int(3) NULL DEFAULT 0,
  `submitTime` varchar(19) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`ttid`, `sid`) USING BTREE,
  INDEX `student`(`sid`) USING BTREE,
  CONSTRAINT `student` FOREIGN KEY (`sid`) REFERENCES `student` (`sid`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `testS` FOREIGN KEY (`ttid`) REFERENCES `test_t` (`ttid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of test_s
-- ----------------------------
INSERT INTO `test_s` VALUES (12, 'D;B;C', 1, 100, '2019/03/11 10:19:53');
INSERT INTO `test_s` VALUES (12, 'C;B;C', 2, 67, '');
INSERT INTO `test_s` VALUES (13, 'B;D;B;A;B', 1, 60, '2019/03/20 14:09:37');
INSERT INTO `test_s` VALUES (16, 'D;C;C;C;C', 1, 80, '2019/03/11 10:43:59');

-- ----------------------------
-- Table structure for test_t
-- ----------------------------
DROP TABLE IF EXISTS `test_t`;
CREATE TABLE `test_t`  (
  `ttid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `startTime` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `endTime` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `cid` int(11) NOT NULL,
  PRIMARY KEY (`ttid`) USING BTREE,
  INDEX `classtest`(`cid`) USING BTREE,
  INDEX `ttid`(`ttid`) USING BTREE,
  CONSTRAINT `classtest` FOREIGN KEY (`cid`) REFERENCES `class` (`clid`) ON DELETE NO ACTION ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of test_t
-- ----------------------------
INSERT INTO `test_t` VALUES (12, '测试数据1', '2019/03/03 12:06:31', '2019/07/05 00:00:00', 1);
INSERT INTO `test_t` VALUES (13, '测试数据2', '2019/03/11 10:39:24', '2019/06/11 00:00:00', 1);
INSERT INTO `test_t` VALUES (15, '测试测验3', '2019/03/11 10:42:13', '2019/04/06 00:00:00', 1);
INSERT INTO `test_t` VALUES (16, '测试测验4', '2019/03/11 10:42:36', '2019/04/06 00:00:00', 1);

-- ----------------------------
-- Table structure for time
-- ----------------------------
DROP TABLE IF EXISTS `time`;
CREATE TABLE `time`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `time` int(11) NULL DEFAULT NULL,
  `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `startTime` varchar(8) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `endTime` varchar(8) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `sid` int(11) NOT NULL,
  `cid` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `student1`(`sid`) USING BTREE,
  CONSTRAINT `student1` FOREIGN KEY (`sid`) REFERENCES `student` (`sid`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 98 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of time
-- ----------------------------
INSERT INTO `time` VALUES (4, '2019/03/11', 586, 'L', '09:35:54', '09:45:40', 1, 1);
INSERT INTO `time` VALUES (8, '2019/03/11', 6, 'W', '10:19:47', '10:19:53', 1, 1);
INSERT INTO `time` VALUES (9, '2019/03/11', 1840, 'L', '09:49:37', '10:20:17', 1, 1);
INSERT INTO `time` VALUES (11, '2019/03/11', 576, 'L', '10:23:38', '10:33:14', 1, 1);
INSERT INTO `time` VALUES (13, '2019/03/11', 22, 'L', '10:38:13', '10:38:35', 1, 1);
INSERT INTO `time` VALUES (15, '2019/03/11', 8, 'T', '10:43:51', '10:43:59', 1, 1);
INSERT INTO `time` VALUES (16, '2019/03/11', 130, 'L', '10:43:49', '10:45:59', 1, 1);
INSERT INTO `time` VALUES (17, '2019/03/11', 399, 'L', '10:46:21', '10:53:00', 1, 1);
INSERT INTO `time` VALUES (18, '2019/03/11', 55, 'L', '10:55:31', '10:56:26', 1, 1);
INSERT INTO `time` VALUES (19, '2019/03/12', 181, 'L', '07:56:00', '07:59:01', 1, 1);
INSERT INTO `time` VALUES (20, '2019/03/12', 8251, 'L', '07:59:05', '10:16:36', 1, 1);
INSERT INTO `time` VALUES (21, '2019/03/12', 5234, 'L', '22:17:10', '23:44:24', 1, 1);
INSERT INTO `time` VALUES (23, '2019/03/13', 15, 'L', '22:48:48', '22:49:03', 1, 1);
INSERT INTO `time` VALUES (24, '2019/03/13', 159, 'L', '22:51:53', '22:54:32', 2, 1);
INSERT INTO `time` VALUES (25, '2019/03/13', NULL, 'D', NULL, NULL, 2, 1);
INSERT INTO `time` VALUES (26, '2019/03/13', NULL, 'V', NULL, NULL, 2, 1);
INSERT INTO `time` VALUES (27, '2019/03/13', NULL, 'Q', NULL, NULL, 2, 1);
INSERT INTO `time` VALUES (28, '2019/03/14', 70, 'L', '23:33:17', '23:34:27', 1, NULL);
INSERT INTO `time` VALUES (29, '2019/03/14', NULL, 'O', NULL, NULL, 1, 1);
INSERT INTO `time` VALUES (30, '2019/03/14', NULL, 'V', NULL, NULL, 1, 1);
INSERT INTO `time` VALUES (31, '2019/03/14', NULL, 'Q', NULL, NULL, 1, 1);
INSERT INTO `time` VALUES (32, '2019/03/14', NULL, 'E', NULL, NULL, 1, 1);
INSERT INTO `time` VALUES (33, '2019/03/14', NULL, 'O', NULL, NULL, 1, 1);
INSERT INTO `time` VALUES (34, '2019/03/14', NULL, 'D', NULL, NULL, 1, 1);
INSERT INTO `time` VALUES (35, '2019/03/18', NULL, 'O', NULL, NULL, 2, 1);
INSERT INTO `time` VALUES (36, '2019/03/18', 30, 'L', '10:16:28', '10:16:58', 2, NULL);
INSERT INTO `time` VALUES (37, '2019/03/18', NULL, 'O', NULL, NULL, 2, 1);
INSERT INTO `time` VALUES (38, '2019/03/18', 9, 'W', '10:20:41', '10:20:50', 2, 1);
INSERT INTO `time` VALUES (39, '2019/03/18', 240, 'L', '10:20:36', '10:24:36', 2, NULL);
INSERT INTO `time` VALUES (40, '2019/03/18', 8101, 'L', '20:55:34', '23:10:35', 1, NULL);
INSERT INTO `time` VALUES (41, '2019/03/19', 14, 'L', '20:03:25', '20:03:39', 1, NULL);
INSERT INTO `time` VALUES (42, '2019/03/19', NULL, 'O', NULL, NULL, 1, 1);
INSERT INTO `time` VALUES (43, '2019/03/19', 811, 'L', '20:05:27', '20:18:58', 1, NULL);
INSERT INTO `time` VALUES (44, '2019/03/19', NULL, 'O', NULL, NULL, 1, 1);
INSERT INTO `time` VALUES (45, '2019/03/19', NULL, 'O', NULL, NULL, 1, 1);
INSERT INTO `time` VALUES (46, '2019/03/19', 73, 'L', '23:11:38', '23:12:51', 1, NULL);
INSERT INTO `time` VALUES (47, '2019/03/19', NULL, 'O', NULL, NULL, 2, 1);
INSERT INTO `time` VALUES (48, '2019/03/19', 824, 'L', '23:12:56', '23:26:40', 2, NULL);
INSERT INTO `time` VALUES (49, '2019/03/19', NULL, 'O', NULL, NULL, 2, 1);
INSERT INTO `time` VALUES (50, '2019/03/19', NULL, 'O', NULL, NULL, 2, 1);
INSERT INTO `time` VALUES (51, '2019/03/19', NULL, 'O', NULL, NULL, 2, 1);
INSERT INTO `time` VALUES (52, '2019/03/19', NULL, 'O', NULL, NULL, 2, 1);
INSERT INTO `time` VALUES (53, '2019/03/19', NULL, 'O', NULL, NULL, 2, 1);
INSERT INTO `time` VALUES (54, '2019/03/19', NULL, 'O', NULL, NULL, 2, 1);
INSERT INTO `time` VALUES (55, '2019/03/19', NULL, 'O', NULL, NULL, 2, 1);
INSERT INTO `time` VALUES (56, '2019/03/19', NULL, 'O', NULL, NULL, 2, 1);
INSERT INTO `time` VALUES (57, '2019/03/19', NULL, 'O', NULL, NULL, 2, 1);
INSERT INTO `time` VALUES (58, '2019/03/19', NULL, 'O', NULL, NULL, 2, 1);
INSERT INTO `time` VALUES (59, '2019/03/19', NULL, 'O', NULL, NULL, 2, 1);
INSERT INTO `time` VALUES (60, '2019/03/20', NULL, 'O', NULL, NULL, 1, 1);
INSERT INTO `time` VALUES (61, '2019/03/20', NULL, 'D', NULL, NULL, 1, 1);
INSERT INTO `time` VALUES (62, '2019/03/20', 16, 'L', '00:30:41', '00:30:57', 1, NULL);
INSERT INTO `time` VALUES (63, '2019/03/20', NULL, 'D', NULL, NULL, 1, 1);
INSERT INTO `time` VALUES (64, '2019/03/20', NULL, 'O', NULL, NULL, 1, 1);
INSERT INTO `time` VALUES (65, '2019/03/20', 813, 'L', '09:59:56', '10:13:29', 1, NULL);
INSERT INTO `time` VALUES (66, '2019/03/20', NULL, 'O', NULL, NULL, 1, 1);
INSERT INTO `time` VALUES (67, '2019/03/20', NULL, 'V', NULL, NULL, 1, 1);
INSERT INTO `time` VALUES (68, '2019/03/20', NULL, 'V', NULL, NULL, 1, 1);
INSERT INTO `time` VALUES (69, '2019/03/20', NULL, 'V', NULL, NULL, 1, 1);
INSERT INTO `time` VALUES (70, '2019/03/20', NULL, 'V', NULL, NULL, 1, 1);
INSERT INTO `time` VALUES (71, '2019/03/20', NULL, 'V', NULL, NULL, 1, 1);
INSERT INTO `time` VALUES (72, '2019/03/20', NULL, 'V', NULL, NULL, 1, 1);
INSERT INTO `time` VALUES (73, '2019/03/20', NULL, 'V', NULL, NULL, 1, 1);
INSERT INTO `time` VALUES (74, '2019/03/20', NULL, 'V', NULL, NULL, 1, 1);
INSERT INTO `time` VALUES (75, '2019/03/20', NULL, 'V', NULL, NULL, 1, 1);
INSERT INTO `time` VALUES (76, '2019/03/20', NULL, 'V', NULL, NULL, 1, 1);
INSERT INTO `time` VALUES (77, '2019/03/20', NULL, 'V', NULL, NULL, 1, 1);
INSERT INTO `time` VALUES (78, '2019/03/20', NULL, 'V', NULL, NULL, 1, 1);
INSERT INTO `time` VALUES (79, '2019/03/20', NULL, 'V', NULL, NULL, 1, 1);
INSERT INTO `time` VALUES (80, '2019/03/20', NULL, 'V', NULL, NULL, 1, 1);
INSERT INTO `time` VALUES (81, '2019/03/20', NULL, 'V', NULL, NULL, 1, 1);
INSERT INTO `time` VALUES (82, '2019/03/20', NULL, 'V', NULL, NULL, 1, 1);
INSERT INTO `time` VALUES (83, '2019/03/20', NULL, 'V', NULL, NULL, 1, 1);
INSERT INTO `time` VALUES (84, '2019/03/20', 387, 'L', '14:03:45', '14:10:12', 1, NULL);
INSERT INTO `time` VALUES (85, '2019/03/20', NULL, 'O', NULL, NULL, 1, 1);
INSERT INTO `time` VALUES (86, '2019/03/20', NULL, 'O', NULL, NULL, 1, 1);
INSERT INTO `time` VALUES (87, '2019/03/20', NULL, 'O', NULL, NULL, 1, 1);
INSERT INTO `time` VALUES (88, '2019/03/20', NULL, 'O', NULL, NULL, 1, 1);
INSERT INTO `time` VALUES (89, '2019/03/20', NULL, 'O', NULL, NULL, 1, 1);
INSERT INTO `time` VALUES (90, '2019/03/20', NULL, 'O', NULL, NULL, 1, 1);
INSERT INTO `time` VALUES (91, '2019/03/20', 34, 'W', '14:06:47', '14:07:21', 1, 1);
INSERT INTO `time` VALUES (92, '2019/03/20', NULL, 'O', NULL, NULL, 1, 1);
INSERT INTO `time` VALUES (93, '2019/03/20', NULL, 'V', NULL, NULL, 1, 1);
INSERT INTO `time` VALUES (94, '2019/03/20', NULL, 'Q', NULL, NULL, 1, 1);
INSERT INTO `time` VALUES (95, '2019/03/20', NULL, 'Q', NULL, NULL, 1, 1);
INSERT INTO `time` VALUES (96, '2019/03/20', NULL, 'E', NULL, NULL, 1, 1);
INSERT INTO `time` VALUES (97, '2019/03/20', 26, 'T', '14:09:11', '14:09:37', 1, 1);

-- ----------------------------
-- Table structure for vote_s
-- ----------------------------
DROP TABLE IF EXISTS `vote_s`;
CREATE TABLE `vote_s`  (
  `vtid` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  `result` int(11) NOT NULL,
  PRIMARY KEY (`vtid`, `sid`) USING BTREE,
  INDEX `student_v`(`sid`) USING BTREE,
  CONSTRAINT `student_v` FOREIGN KEY (`sid`) REFERENCES `student` (`sid`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `vtid` FOREIGN KEY (`vtid`) REFERENCES `vote_t` (`vtid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of vote_s
-- ----------------------------
INSERT INTO `vote_s` VALUES (1, 1, 2);

-- ----------------------------
-- Table structure for vote_t
-- ----------------------------
DROP TABLE IF EXISTS `vote_t`;
CREATE TABLE `vote_t`  (
  `vtid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `options` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `startTime` varchar(19) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `endTime` varchar(19) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `cid` int(11) NOT NULL,
  PRIMARY KEY (`vtid`) USING BTREE,
  INDEX `class`(`cid`) USING BTREE,
  CONSTRAINT `class` FOREIGN KEY (`cid`) REFERENCES `class` (`clid`) ON DELETE NO ACTION ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of vote_t
-- ----------------------------
INSERT INTO `vote_t` VALUES (1, '测试投票1', '测试选项1;12412421;214124;21421412412', '2019/03/10 03:56:37', '2019/03/30 00:00:00', 1);
INSERT INTO `vote_t` VALUES (4, 'teste', 'test1;test2;test3;test4', '2019/03/20 02:14:09', '2019/03/31 00:00:00', 1);

-- ----------------------------
-- Table structure for work_s
-- ----------------------------
DROP TABLE IF EXISTS `work_s`;
CREATE TABLE `work_s`  (
  `wtid` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  `submitTime` varchar(19) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `answer` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `file` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `score` int(11) NULL DEFAULT 0,
  PRIMARY KEY (`wtid`, `sid`) USING BTREE,
  INDEX `stid`(`sid`) USING BTREE,
  CONSTRAINT `stid` FOREIGN KEY (`sid`) REFERENCES `student` (`sid`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `work` FOREIGN KEY (`wtid`) REFERENCES `work_t` (`wtid`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of work_s
-- ----------------------------
INSERT INTO `work_s` VALUES (2, 1, '2019/03/20 14:07:21', '测试作业2内容', '第五组实训展示.pptx', 80);
INSERT INTO `work_s` VALUES (2, 2, '2019/03/18 10:20:50', '12431241241', 'game.txt', 0);
INSERT INTO `work_s` VALUES (4, 1, '2019/03/11 10:05:57', '测试作业3内容', '', 0);

-- ----------------------------
-- Table structure for work_t
-- ----------------------------
DROP TABLE IF EXISTS `work_t`;
CREATE TABLE `work_t`  (
  `wtid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `cid` int(11) NOT NULL,
  `content` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `startTime` varchar(19) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `endTime` varchar(19) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `file` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `chid` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`wtid`) USING BTREE,
  INDEX `course`(`cid`) USING BTREE,
  INDEX `workChapter`(`chid`) USING BTREE,
  CONSTRAINT `course` FOREIGN KEY (`cid`) REFERENCES `course` (`cid`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `workChapter` FOREIGN KEY (`chid`) REFERENCES `chapter` (`chid`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of work_t
-- ----------------------------
INSERT INTO `work_t` VALUES (2, '测试作业2', 1, '测试作业2内容', '2019/03/08 12:39:24', '2019/07/05 00:00:00', '', 2);
INSERT INTO `work_t` VALUES (4, '测试作业3', 1, '测试内容3update', '2019/03/11 09:48:02', '2019/07/04 00:00:00', '《PHP程序设计》设计报告.doc', NULL);
INSERT INTO `work_t` VALUES (7, '测试作业4', 1, '测试作业4内容', '2019/03/19 11:26:58', '2019/04/12 00:00:00', '软件1502第二组实训报告.doc;设计模式_第六组.zip', 5);
INSERT INTO `work_t` VALUES (15, '测试作业1', 1, '测试作业1', '2019/03/20 10:55:41', '2019/03/30 00:00:00', '', 1);
INSERT INTO `work_t` VALUES (16, '测试作业1', 2, '测试作业1', '2019/03/20 10:55:41', '2019/03/30 00:00:00', '', 29);

SET FOREIGN_KEY_CHECKS = 1;
