/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50717
Source Host           : localhost:3306
Source Database       : pep

Target Server Type    : MYSQL
Target Server Version : 50717
File Encoding         : 65001

Date: 2019-10-08 09:14:07
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `x2_actives`
-- ----------------------------
DROP TABLE IF EXISTS `x2_actives`;
CREATE TABLE `x2_actives` (
  `activeid` int(11) NOT NULL AUTO_INCREMENT,
  `activeusername` varchar(48) DEFAULT NULL,
  `activename` varchar(120) NOT NULL,
  `activesubjectid` int(11) NOT NULL,
  `activebasicid` int(11) NOT NULL,
  `activeorder` varchar(32) NOT NULL,
  `activeordertime` int(11) NOT NULL,
  `activetime` int(11) NOT NULL,
  `activestatus` tinyint(4) NOT NULL,
  PRIMARY KEY (`activeid`),
  KEY `activesubjectid` (`activesubjectid`),
  KEY `activebasicid` (`activebasicid`),
  KEY `activeorder` (`activeorder`),
  KEY `activeusername` (`activeusername`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of x2_actives
-- ----------------------------
INSERT INTO `x2_actives` VALUES ('1', '18568263814', '初级实务', '6', '3', '201902251939518', '1551094766', '366', '1');
INSERT INTO `x2_actives` VALUES ('2', '18568263814', '初级经济法', '4', '2', '201902252009687', '1551096593', '366', '99');
INSERT INTO `x2_actives` VALUES ('3', '18568263814', '初级实务', '6', '3', '201902252009687', '1551096593', '366', '99');
INSERT INTO `x2_actives` VALUES ('4', '18568263814', '初级经济法', '4', '2', '201902252025728', '1551097550', '366', '1');
INSERT INTO `x2_actives` VALUES ('5', '18568263814', '初级实务', '6', '3', '201902252025728', '1551097550', '366', '1');
INSERT INTO `x2_actives` VALUES ('6', '18568263814', '初级经济法', '4', '2', '201902252032389', '1551097953', '366', '99');
INSERT INTO `x2_actives` VALUES ('7', '18568263814', '初级实务', '6', '3', '201902252032389', '1551097953', '366', '99');
INSERT INTO `x2_actives` VALUES ('8', '13552525371', '初级经济法', '4', '2', '201902281519893', '1551338354', '366', '0');
INSERT INTO `x2_actives` VALUES ('9', '13552525371', '初级实务', '6', '3', '201902281519893', '1551338354', '366', '0');
INSERT INTO `x2_actives` VALUES ('10', '13552525371', '初级经济法', '4', '2', '201902281520465', '1551338423', '366', '0');
INSERT INTO `x2_actives` VALUES ('11', '13552525371', '初级实务', '6', '3', '201902281520465', '1551338423', '366', '0');
INSERT INTO `x2_actives` VALUES ('12', '13552525371', '初级经济法', '4', '2', '201902281526651', '1551338781', '366', '0');
INSERT INTO `x2_actives` VALUES ('13', '13552525371', '初级实务', '6', '3', '201902281526651', '1551338781', '366', '0');
INSERT INTO `x2_actives` VALUES ('14', '13552525371', '初级经济法', '4', '2', '201902281529122', '1551338968', '366', '0');
INSERT INTO `x2_actives` VALUES ('15', '13552525371', '初级实务', '6', '3', '201902281529122', '1551338968', '366', '0');
INSERT INTO `x2_actives` VALUES ('16', '13552525371', '初级经济法', '4', '2', '201902281531159', '1551339065', '366', '0');
INSERT INTO `x2_actives` VALUES ('17', '13552525371', '初级实务', '6', '3', '201902281531159', '1551339065', '366', '0');
INSERT INTO `x2_actives` VALUES ('18', '13552525371', '初级经济法', '4', '2', '201902281534530', '1551339280', '366', '0');
INSERT INTO `x2_actives` VALUES ('19', '13552525371', '初级实务', '6', '3', '201902281534530', '1551339280', '366', '0');
INSERT INTO `x2_actives` VALUES ('20', '13552525371', '初级经济法', '4', '2', '201903011201277', '1551412863', '366', '0');
INSERT INTO `x2_actives` VALUES ('21', '13552525371', '初级实务', '6', '3', '201903011201277', '1551412863', '366', '0');
INSERT INTO `x2_actives` VALUES ('22', '18568263814', '初级经济法', '4', '2', '201903012054565', '1551444879', '366', '1');
INSERT INTO `x2_actives` VALUES ('23', '18568263814', '初级实务', '6', '3', '201903012054565', '1551444879', '366', '1');
INSERT INTO `x2_actives` VALUES ('24', '18568263814', '初级经济法', '4', '2', '201903031633222', '1551602027', '366', '1');
INSERT INTO `x2_actives` VALUES ('25', '18568263814', '初级实务', '6', '3', '201903031633222', '1551602027', '366', '1');
INSERT INTO `x2_actives` VALUES ('26', 'peadmin', '初级经济法', '4', '2', '201903161556282', '1552723012', '366', '1');
INSERT INTO `x2_actives` VALUES ('27', 'peadmin', '初级实务', '6', '3', '201903161556282', '1552723012', '366', '0');

-- ----------------------------
-- Table structure for `x2_apps`
-- ----------------------------
DROP TABLE IF EXISTS `x2_apps`;
CREATE TABLE `x2_apps` (
  `appid` int(11) NOT NULL AUTO_INCREMENT,
  `appcode` varchar(36) NOT NULL,
  `appname` varchar(48) NOT NULL DEFAULT '',
  `appthumb` varchar(240) NOT NULL DEFAULT '',
  `appstatus` int(1) NOT NULL DEFAULT '0',
  `appsetting` mediumtext NOT NULL,
  PRIMARY KEY (`appid`),
  UNIQUE KEY `appcode` (`appcode`) USING BTREE,
  KEY `appstatus` (`appstatus`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of x2_apps
-- ----------------------------
INSERT INTO `x2_apps` VALUES ('1', 'core', '全局', '', '1', '');
INSERT INTO `x2_apps` VALUES ('2', 'database', '数据库', '', '1', '');
INSERT INTO `x2_apps` VALUES ('3', 'user', '用户', '', '1', '{\"closeregist\":\"0\",\"registype\":\"1\",\"managemodel\":\"0\",\"loginmodel\":\"1\",\"emailverify\":\"0\",\"emailaccount\":\"3048221737@qq.com\",\"emailpassword\":\"azmoupcjxngyddig\",\"regfields\":\"usergroupcode\"}');
INSERT INTO `x2_apps` VALUES ('4', 'exam', '考试', '', '1', '{\"selectortype\":\"A,B,C,D,E,F,G,H,I\",\"selectornumbers\":\"0,2,3,4,5,6,7,8,9\",\"selectormodel\":\"1\",\"outfields\":\"userrealname,ehscore,ehstarttime,ehtime\"}');
INSERT INTO `x2_apps` VALUES ('5', 'content', '内容', '', '1', '');
INSERT INTO `x2_apps` VALUES ('6', 'finance', '财务', '', '1', '');
INSERT INTO `x2_apps` VALUES ('7', 'lesson', '课程', '', '1', '');

-- ----------------------------
-- Table structure for `x2_basics`
-- ----------------------------
DROP TABLE IF EXISTS `x2_basics`;
CREATE TABLE `x2_basics` (
  `basicid` int(11) NOT NULL AUTO_INCREMENT,
  `basic` varchar(120) NOT NULL DEFAULT '',
  `basicarea` varchar(48) NOT NULL DEFAULT '0',
  `basicsubject` int(11) NOT NULL DEFAULT '0',
  `basicsections` text NOT NULL,
  `basicpoints` text NOT NULL,
  `basicexam` text NOT NULL,
  `basicdemo` int(1) NOT NULL DEFAULT '0',
  `basicthumb` varchar(240) NOT NULL DEFAULT '',
  `basicprice` tinytext NOT NULL,
  `basicbook` int(11) DEFAULT NULL,
  `basicclosed` int(1) NOT NULL DEFAULT '0',
  `basictop` int(1) DEFAULT NULL,
  `basicdescribe` text NOT NULL,
  PRIMARY KEY (`basicid`),
  KEY `basicexamid` (`basicarea`),
  KEY `basicsubjectid` (`basicsubject`),
  KEY `basicdemo` (`basicdemo`),
  KEY `basicclosed` (`basicclosed`),
  KEY `basictop` (`basictop`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of x2_basics
-- ----------------------------
INSERT INTO `x2_basics` VALUES ('2', '初级经济法', '河南', '4', '', '', '', '0', 'files/attach/images/content/20190103/15465119292564.jpg', '年卡:366:120.5', '1', '0', null, '河南初级经济法');
INSERT INTO `x2_basics` VALUES ('3', '测试考场', '全国', '6', '[1]', '{\"1\":{\"3\":\"3\"}}', '{\"changesequence\":\"0\",\"auto\":\"\",\"autotemplate\":\"exampaper_paper\",\"self\":\"\",\"selftemplate\":\"exam_paper\",\"opentime\":{\"start\":false,\"end\":false},\"selectrule\":\"0\",\"examnumber\":\"0\",\"notviewscore\":\"0\",\"allowgroup\":\"\"}', '1', 'app/core/styles/images/noimage.gif', '', null, '0', null, '');
INSERT INTO `x2_basics` VALUES ('4', '士大夫士大夫', '1', '9', '[4]', '{\"4\":{\"7\":\"7\"}}', '{\"changesequence\":\"0\",\"auto\":\"8\",\"autotemplate\":\"exampaper_paper\",\"self\":\"8\",\"selftemplate\":\"exam_paper\",\"opentime\":{\"start\":false,\"end\":false},\"selectrule\":\"0\",\"examnumber\":\"0\",\"notviewscore\":\"0\",\"allowgroup\":\"\"}', '0', 'app/core/styles/images/noimage.gif', '', '1', '0', '0', '');

-- ----------------------------
-- Table structure for `x2_category`
-- ----------------------------
DROP TABLE IF EXISTS `x2_category`;
CREATE TABLE `x2_category` (
  `catid` int(11) NOT NULL AUTO_INCREMENT,
  `catapp` varchar(24) NOT NULL DEFAULT '',
  `catorder` int(11) NOT NULL DEFAULT '0',
  `catname` varchar(240) NOT NULL DEFAULT '',
  `catthumb` varchar(240) NOT NULL DEFAULT '',
  `catparent` int(11) DEFAULT '0',
  `catintro` text NOT NULL,
  `cattpl` varchar(18) DEFAULT NULL,
  PRIMARY KEY (`catid`),
  KEY `catorder` (`catorder`),
  KEY `catparent` (`catparent`),
  KEY `catappid` (`catapp`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of x2_category
-- ----------------------------
INSERT INTO `x2_category` VALUES ('1', 'content', '0', '滚动广告', 'files/attach/images/content/20190113/15473654707079.jpg', '0', '', 'category_default');
INSERT INTO `x2_category` VALUES ('2', 'content', '0', '考试公告', 'app/core/styles/images/noimage.gif', '0', '', 'category_default');
INSERT INTO `x2_category` VALUES ('3', 'content', '0', '报考指南', 'app/core/styles/images/noimage.gif', '0', '', 'category_default');
INSERT INTO `x2_category` VALUES ('4', 'lesson', '0', '初级会计', 'files/attach/images/content/20190118/15477991116130.png', '0', '&lt;p&gt;初级经济法&lt;/p&gt;', 'category_default');
INSERT INTO `x2_category` VALUES ('5', 'content', '0', '初级报考', 'app/core/styles/images/noimage.gif', '3', '', 'category_default');

-- ----------------------------
-- Table structure for `x2_contents`
-- ----------------------------
DROP TABLE IF EXISTS `x2_contents`;
CREATE TABLE `x2_contents` (
  `contentid` int(11) NOT NULL AUTO_INCREMENT,
  `contentcatid` int(11) NOT NULL,
  `contenttitle` varchar(180) NOT NULL,
  `contentthumb` varchar(240) NOT NULL,
  `contentmodelcode` varchar(36) NOT NULL,
  `contentintro` text NOT NULL,
  `contenttext` mediumtext NOT NULL,
  `contentauthor` varchar(48) NOT NULL,
  `contenttime` int(11) NOT NULL,
  `contentorder` int(11) NOT NULL,
  `contenttpl` varchar(48) NOT NULL,
  PRIMARY KEY (`contentid`),
  KEY `contentauthor` (`contentauthor`),
  KEY `contenttime` (`contenttime`),
  KEY `contentmodelcode` (`contentmodelcode`),
  KEY `contentcatid` (`contentcatid`),
  KEY `contentorder` (`contentorder`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of x2_contents
-- ----------------------------
INSERT INTO `x2_contents` VALUES ('4', '1', '第二个滚动广告', 'files/attach/images/content/20190114/15473958847004.png', 'news', '', '', '', '1547308800', '0', '');
INSERT INTO `x2_contents` VALUES ('5', '3', '北约应就华为达成共识，中国是巨大市场', 'files/attach/images/content/20190113/15473939189664.png', 'news', '“中国市场巨大。”波兰指明华为员工被捕与华为公司无直接联系后，该国内政部长称希望与中国保持良好关系，又呼吁欧盟和北约就是否将华为排除在本国市场之外达成共识。不过，波兰已经在全面研究华为参与当地5G建设的情况。', '&lt;p&gt;据路透社当地时间1月12日报道，波兰内政部长布鲁辛斯基（Joachim Brudzinski）当天向该国广播电台RMF FM（该国第一个商业广播电台）表示，波兰希望继续与中国合作，但需要就是否将华为排除在某些市场之外进行讨论。&amp;ldquo;北约内部对华为也有担忧，欧盟及北约成员国应该采取共同立场。&amp;rdquo;&lt;/p&gt;\r\n\r\n&lt;p&gt;与此同时，波兰安全部门负责人指出，针对华为驻波兰员工的指控与个人行为有关，与华为公司没有直接联系。&lt;/p&gt;\r\n\r\n&lt;p&gt;尽管如此，路透社援引波兰媒体Money.pl称，波兰数字化事务部副部长透露，华沙正在全面分析华为参与该国5G建设的情况。&lt;/p&gt;\r\n\r\n&lt;p&gt;分析人士指出，西方国家考虑是否将华为排除在本国市场之外时，都必须考虑该决定对其5G发展速度和成本造成的影响。&lt;/p&gt;\r\n\r\n&lt;p&gt;在此基础上，波兰内政部长表示，&amp;ldquo;我们希望能保持良好、密切和互有吸引力的波中关系。中国是个巨大的市场。&amp;rdquo;&lt;/p&gt;\r\n\r\n&lt;p&gt;据观察者网此前报道，华为波兰代表处员工王伟晶因涉嫌违反波兰法律被逮捕调查，同时被捕的还有一名波兰国家安全局前高级官员，但两人均未认罪。&lt;/p&gt;', 'redrangon', '1547308800', '1', '');
INSERT INTO `x2_contents` VALUES ('6', '2', '签订马关条约时，日本人想拉拢李鸿章，不料竟得到这样的回复', 'files/attach/images/content/20190113/15473940365537.png', 'news', '晚清末年在慈禧的统治下，中国已经处于被列强欺辱的状态，各种丧权辱国的条约签了不知多少，慈禧对此却不以为然，她只要自己过得好就行，那管老百姓的死活，而签订这些条约又不要她亲自出手，基本都是李鸿章去签的。', '&lt;p&gt;李鸿章是晚清名臣，日本首相伊藤博文对他评价很高：&amp;quot;唯一有能力可跟世界列强一争高下之人。&amp;quot;李鸿章每次跟外国人打交道，中国都处于弱势地位，但李鸿章往往不卑不亢，能很好的完成任务，假若当时清朝强盛一点，李鸿章肯定更加闻名世界。&lt;/p&gt;\r\n\r\n&lt;p&gt;尽管李鸿章力挽狂澜，但仍旧不能挽救清朝大厦即将倒塌的命运，毛主席评价李鸿章时，用&amp;quot;水浅而舟大也&amp;quot;来形容，是相当适宜的。作为晚清栋梁之才，又深受日本人青睐，李鸿章跟日本人打交道时，还曾被对方拉拢。&lt;/p&gt;\r\n\r\n&lt;p&gt;中日甲午战争失败后，中日双方签订了《马关条约》，跟以往一样，慈禧不需要亲自出面，这些条约都由李鸿章签订，据说在马关条约的谈判现场，日本首相伊藤博文对李鸿章的文韬武略十分欣赏，甚至还向他抛出橄榄枝。&lt;/p&gt;\r\n\r\n&lt;p&gt;伊藤博文曾对李鸿章说：&amp;quot;如果你肯为日本效力，得到的好处会更多！&amp;quot;李鸿章自然知道对方在挖墙脚，面对日本人的引诱，李鸿章没有回答任何一句话，只是麻木的一笑，反而搞得伊藤博文尴尬起来，不知该如何应对了。&lt;/p&gt;\r\n\r\n&lt;p&gt;很明显李鸿章并没有接受日本人的邀请，他宁愿继续为清朝卖命，有人推测李鸿章之所以拒绝日本，是因为害怕后世的千古骂名，他已经签订了许多卖国条约，如果他再跳槽到日本，恐怕真的是生生世世要背上卖国贼的骂名。&lt;/p&gt;', 'redrangon', '1547308800', '3', '');
INSERT INTO `x2_contents` VALUES ('7', '3', '房屋出租人信息不要填了', 'files/attach/images/content/20190121/15480024019382.png', 'news', '1月20日，记者发现个人所得税APP有更新。从更新的内容看，不再强制要求填写出租人信息。这意味着租客此前遇到的填也难不填也难的困局得以缓和，房东与租客之间的博弈就此搁置。房东也不必担心出租信息泄露而被追溯租赁税费了。', '&lt;p&gt;记者登录个人所得税APP后，在住房租金信息填写中，当出租方类型选择为&amp;ldquo;自然人&amp;rdquo;时，出租人姓名和出租人身份证号码为&amp;ldquo;请输入&amp;rdquo;状态；当出租方类型选择为&amp;ldquo;组织&amp;rdquo;时，出租单位名称为&amp;ldquo;请填写&amp;rdquo;。&lt;/p&gt;\r\n\r\n&lt;p&gt;而该APP更新后，当出租方类型选择为&amp;ldquo;自然人&amp;rdquo;时，出租人姓名和出租人身份证号码变为&amp;ldquo;选填&amp;rdquo;状态；当出租方类型选择为&amp;ldquo;组织&amp;rdquo;时，出租单位名称也变为&amp;ldquo;选填&amp;rdquo;状态。&lt;/p&gt;\r\n\r\n&lt;p&gt;业内人士认为，此前由于租客填报租房个税抵扣需要征得房东同意，而房东顾虑到身份信息泄露、可能会被追溯补缴房屋租赁税费等原因，变相提出&amp;ldquo;涨租&amp;rdquo;要求，引发了房东与租客之间的博弈。此次个人所得税APP的更新应该可以打消房东的担心了。&lt;/p&gt;\r\n\r\n&lt;p&gt;此前，很多网友在社交媒体上反映，自己向房东索要其身份信息，但遭到拒绝，房东以提交信息后可能被征税为由，规劝租客不要申报个税租金扣除，甚至有房东还表示如果进行扣除就要租客退房。&lt;/p&gt;\r\n\r\n&lt;p&gt;一边是个税可能抵扣几十块，另一边是房租可能上涨几百块，权衡之下，很多租客被迫选择不再申报租金支出扣除，无法享受到国家发放的个税减税红包。现在不再强填，租客可以享受惠民政策了。&lt;/p&gt;', 'peadmin', '1548000000', '6', '');
INSERT INTO `x2_contents` VALUES ('8', '2', '朝鲜友好艺术团将对中国进行访问演出', 'files/attach/images/content/20190121/15480024113956.png', 'news', '应中共中央对外联络部邀请，朝鲜劳动党中央政治局委员、中央副委员长、国际部部长李洙墉率朝鲜友好艺术团于1月23日起对中国进行访问演出。', '&lt;p&gt;应中共中央对外联络部邀请，朝鲜劳动党中央政治局委员、中央副委员长、国际部部长李洙墉率朝鲜友好艺术团于1月23日起对中国进行访问演出。&lt;/p&gt;', 'peadmin', '1548000000', '8', '');

-- ----------------------------
-- Table structure for `x2_database`
-- ----------------------------
DROP TABLE IF EXISTS `x2_database`;
CREATE TABLE `x2_database` (
  `dbid` int(11) NOT NULL AUTO_INCREMENT,
  `dbbase` varchar(24) DEFAULT NULL,
  `dbname` varchar(48) DEFAULT NULL,
  `dbtype` enum('field','table') DEFAULT NULL,
  `dbtable` varchar(48) DEFAULT NULL,
  `dbintro` varchar(240) DEFAULT NULL,
  `dbformat` varchar(24) DEFAULT NULL,
  `dbtimeformat` varchar(36) DEFAULT NULL,
  `dbsynch` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`dbid`),
  KEY `dbname` (`dbname`),
  KEY `dbtype` (`dbtype`),
  KEY `dbbase` (`dbbase`),
  KEY `dbtable` (`dbtable`)
) ENGINE=MyISAM AUTO_INCREMENT=373 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of x2_database
-- ----------------------------
INSERT INTO `x2_database` VALUES ('1', 'default', 'dbid', 'field', 'x2_database', '主键', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('2', 'default', 'dbbase', 'field', 'x2_database', '对应字段所在分库', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('3', 'default', 'dbname', 'field', 'x2_database', '字段或表的名称', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('4', 'default', 'dbtype', 'field', 'x2_database', '类型（field/table）', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('5', 'default', 'dbtable', 'field', 'x2_database', '所在表，类型为表时填表名', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('6', 'default', 'dbintro', 'field', 'x2_database', '字段或表的备注', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('7', 'default', 'dbformat', 'field', 'x2_database', '数据类型（default/timestamp/split/json/serialize）', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('8', 'default', 'dbtimeformat', 'field', 'x2_database', '时间格式，数据类型为unix时间戳时使用，默认Y-m-d H:i:s', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('9', 'demo', 'appid', 'field', 'x2_app', '主键，模块名', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('10', 'default', 'modelid', 'field', 'x2_models', '主键ID', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('11', 'default', 'modelcode', 'field', 'x2_models', '模型代码，唯一，英文', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('12', 'default', 'modelname', 'field', 'x2_models', '模型中文名称', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('13', 'default', 'modelapp', 'field', 'x2_models', '模型所属模块', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('14', 'default', 'modelintro', 'field', 'x2_models', '模型简介', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('15', 'default', 'ppyid', 'field', 'x2_properties', '主键，属性ID', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('16', 'default', 'ppyname', 'field', 'x2_properties', '属性名称', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('17', 'default', 'ppyfield', 'field', 'x2_properties', '对应字段', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('18', 'default', 'ppymodel', 'field', 'x2_properties', '所属模型', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('19', 'default', 'ppyhtmltype', 'field', 'x2_properties', '对应html类型', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('20', 'default', 'ppyaccess', 'field', 'x2_properties', '权限', 'split', '', '0');
INSERT INTO `x2_database` VALUES ('21', 'default', 'ppyintro', 'field', 'x2_properties', '简介', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('22', 'default', 'ppyproperty', 'field', 'x2_properties', '属性设置，包括html属性，合法性检测', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('23', 'default', 'ppyvalue', 'field', 'x2_properties', '设定值', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('24', 'default', 'ppysource', 'field', 'x2_properties', '数据来源地址，{value}作为当前值', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('25', 'default', 'ppyislock', 'field', 'x2_properties', '是否锁定禁用，1为锁定，0为正常', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('26', 'default', 'modeldb', 'field', 'x2_models', '模型所在数据库', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('27', 'default', 'modeltable', 'field', 'x2_models', '模型关联表', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('28', 'default', 'x2_database', 'table', 'x2_database', '数据表信息', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('29', 'default', 'x2_models', 'table', 'x2_models', '模型表', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('30', 'default', 'x2_properties', 'table', 'x2_properties', '模型属性表，对应实际表字段', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('31', 'default', 'x2_apps', 'table', 'x2_apps', '模块表', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('32', 'default', 'appid', 'field', 'x2_apps', 'App数字ID', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('33', 'default', 'appcode', 'field', 'x2_apps', 'App标识码，唯一', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('34', 'default', 'appname', 'field', 'x2_apps', '模块名', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('35', 'default', 'appthumb', 'field', 'x2_apps', '模块缩略图，暂不启用', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('36', 'default', 'appstatus', 'field', 'x2_apps', '模块状态，1为开启，0为关闭', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('37', 'default', 'appsetting', 'field', 'x2_apps', '模块设置信息', 'json', '', '0');
INSERT INTO `x2_database` VALUES ('38', 'default', 'ppydefault', 'field', 'x2_properties', '默认值', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('39', 'default', 'groupid', 'field', 'x2_groups', '用户组ID', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('40', 'default', 'groupname', 'field', 'x2_groups', '用户组名称', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('41', 'default', 'groupmodel', 'field', 'x2_groups', '用户模型', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('42', 'default', 'groupdefault', 'field', 'x2_groups', '是否默认注册组', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('43', 'default', 'groupintro', 'field', 'x2_groups', '用户组简介', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('44', 'default', 'groupcode', 'field', 'x2_groups', '用户组代码', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('45', 'default', 'x2_groups', 'table', 'x2_groups', '用户组表', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('46', 'default', 'x2_users', 'table', 'x2_users', '用户表', 'default', '', '1');
INSERT INTO `x2_database` VALUES ('47', 'default', 'userid', 'field', 'x2_users', '用户ID', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('48', 'default', 'username', 'field', 'x2_users', '用户名', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('49', 'default', 'useremail', 'field', 'x2_users', '用户邮箱', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('50', 'default', 'userphone', 'field', 'x2_users', '手机号码', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('51', 'default', 'userpassword', 'field', 'x2_users', '密码', 'md5', '', '0');
INSERT INTO `x2_database` VALUES ('52', 'default', 'usernick', 'field', 'x2_users', '昵称', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('53', 'default', 'userrealname', 'field', 'x2_users', '真实姓名', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('54', 'default', 'usergroupcode', 'field', 'x2_users', '所在用户组', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('55', 'default', 'usersex', 'field', 'x2_users', '性别', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('56', 'default', 'userpassport', 'field', 'x2_users', '身份证号/护照', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('57', 'default', 'x2_subjects', 'table', 'x2_subjects', '科目表', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('58', 'default', 'subjectid', 'field', 'x2_subjects', '科目ID，主键', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('59', 'default', 'subjectname', 'field', 'x2_subjects', '科目名称', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('60', 'default', 'subjectsetting', 'field', 'x2_subjects', '科目设置', 'json', '', '0');
INSERT INTO `x2_database` VALUES ('61', 'default', 'subjectintro', 'field', 'x2_subjects', '科目简介', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('62', 'default', 'x2_points', 'table', 'x2_points', '知识点表', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('63', 'default', 'x2_sections', 'table', 'x2_sections', '章节', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('64', 'default', 'pointid', 'field', 'x2_points', '知识点ID，主键', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('65', 'default', 'pointname', 'field', 'x2_points', '知识点名称', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('66', 'default', 'pointsection', 'field', 'x2_points', '知识点所属章节', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('67', 'default', 'pointorder', 'field', 'x2_points', '知识点权重，越大越靠前', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('68', 'default', 'pointintro', 'field', 'x2_points', '知识点简介', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('69', 'default', 'x2_questypes', 'table', 'x2_questypes', '题型表', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('70', 'default', 'questid', 'field', 'x2_questypes', '题型ID', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('71', 'default', 'questype', 'field', 'x2_questypes', '题型名称', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('72', 'default', 'questcode', 'field', 'x2_questypes', '题型编码', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('73', 'default', 'questsort', 'field', 'x2_questypes', '是否主观题', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('74', 'default', 'questchoice', 'field', 'x2_questypes', '客观题类型，1单选，2多选，3不定项选，4判断，5定值填空', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('75', 'default', 'x2_questions', 'table', 'x2_questions', '普通试题题库', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('76', 'default', 'x2_questionrows', 'table', 'x2_questionrows', '题冒题题库', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('77', 'default', 'x2_training', 'table', 'x2_training', '培训类型表', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('78', 'default', 'trid', 'field', 'x2_training', '培训ID', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('79', 'default', 'trname', 'field', 'x2_training', '培训名称', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('80', 'default', 'trtime', 'field', 'x2_training', '考试时间', 'timestamp', 'Y-m-d', '0');
INSERT INTO `x2_database` VALUES ('81', 'default', 'trintro', 'field', 'x2_training', '培训简介', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('82', 'default', 'subjectdb', 'field', 'x2_subjects', '绑定数据库', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('83', 'default', 'subjecttrid', 'field', 'x2_subjects', '培训ID', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('84', 'default', 'basicid', 'field', 'x2_basics', '考场ID', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('85', 'default', 'basic', 'field', 'x2_basics', '考场名称', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('86', 'default', 'basicarea', 'field', 'x2_basics', '考场地区', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('87', 'default', 'basicsubject', 'field', 'x2_basics', '考场科目ID', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('88', 'default', 'basicsections', 'field', 'x2_basics', '考场章节范围', 'json', '', '0');
INSERT INTO `x2_database` VALUES ('89', 'default', 'basicpoints', 'field', 'x2_basics', '考场知识点范围', 'json', '', '0');
INSERT INTO `x2_database` VALUES ('90', 'default', 'basicexam', 'field', 'x2_basics', '考场考试设置', 'json', '', '0');
INSERT INTO `x2_database` VALUES ('91', 'default', 'basicdemo', 'field', 'x2_basics', '考场是否免费，0为免费，1为收费', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('92', 'default', 'basicthumb', 'field', 'x2_basics', '考场缩略图', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('93', 'default', 'basicprice', 'field', 'x2_basics', '考场价格设置', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('94', 'default', 'basicclosed', 'field', 'x2_basics', '考场状态，1为关闭，0为开启', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('95', 'default', 'basicdescribe', 'field', 'x2_basics', '考场简介', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('96', 'default', 'x2_basics', 'table', 'x2_basics', '考场表', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('97', 'default', 'x2_papers', 'table', 'x2_papers', '试卷表', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('98', 'default', 'x2_openbasics', 'table', 'x2_openbasics', '考场人员表', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('99', 'default', 'obid', 'field', 'x2_openbasics', '开启考场ID', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('100', 'default', 'obuserid', 'field', 'x2_openbasics', '开启用户ID', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('101', 'default', 'obbasicid', 'field', 'x2_openbasics', '开启考场ID', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('102', 'default', 'obtime', 'field', 'x2_openbasics', '考场开启时间', 'timestamp', '', '0');
INSERT INTO `x2_database` VALUES ('103', 'default', 'obendtime', 'field', 'x2_openbasics', '考场到期时间', 'timestamp', '', '0');
INSERT INTO `x2_database` VALUES ('104', 'default', 'paperid', 'field', 'x2_papers', '试卷ID', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('105', 'default', 'papername', 'field', 'x2_papers', '试卷名称', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('106', 'default', 'papersubject', 'field', 'x2_papers', '试卷所属考场ID', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('107', 'default', 'papersetting', 'field', 'x2_papers', '考场设置', 'json', '', '0');
INSERT INTO `x2_database` VALUES ('108', 'default', 'paperquestions', 'field', 'x2_papers', '考场试题', 'json', '', '0');
INSERT INTO `x2_database` VALUES ('109', 'default', 'papertype', 'field', 'x2_papers', '组卷类型，1为随机组卷，2为手工组卷，3为即时组卷', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('110', 'default', 'paperauthor', 'field', 'x2_papers', '组卷人用户名', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('111', 'default', 'papertime', 'field', 'x2_papers', '组卷时间', 'timestamp', '', '0');
INSERT INTO `x2_database` VALUES ('112', 'default', 'paperdecider', 'field', 'x2_papers', '判卷类型，1为教师判卷，0为学生自评', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('113', 'default', 'questionid', 'field', 'x2_questions', '试题ID', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('114', 'default', 'question', 'field', 'x2_questions', '题干', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('115', 'default', 'questiontype', 'field', 'x2_questions', '题型', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('116', 'default', 'questionselect', 'field', 'x2_questions', '选项', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('117', 'default', 'questionselectnumber', 'field', 'x2_questions', '选项数量', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('118', 'default', 'questionanswer', 'field', 'x2_questions', '答案', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('119', 'default', 'questionintro', 'field', 'x2_questions', '解析', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('120', 'default', 'questionlevel', 'field', 'x2_questions', '难度', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('121', 'default', 'questionsubject', 'field', 'x2_questions', '科目', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('122', 'default', 'questionpoints', 'field', 'x2_questions', '知识点', 'split', '', '0');
INSERT INTO `x2_database` VALUES ('123', 'default', 'questionparent', 'field', 'x2_questions', '题帽ID，0时为普通试题', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('124', 'default', 'questionorder', 'field', 'x2_questions', '题帽题时子题排序', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('125', 'default', 'questionstatus', 'field', 'x2_questions', '试题状态', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('126', 'default', 'questionauthor', 'field', 'x2_questions', '试题录入人', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('127', 'default', 'questiontime', 'field', 'x2_questions', '试题录入时间', 'timestamp', 'Y-m-d', '0');
INSERT INTO `x2_database` VALUES ('128', 'default', 'qrid', 'field', 'x2_questionrows', '题帽ID', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('129', 'default', 'qrquestion', 'field', 'x2_questionrows', '题帽题题帽', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('130', 'default', 'qrtype', 'field', 'x2_questionrows', '题型', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('131', 'default', 'qrlevel', 'field', 'x2_questionrows', '难度', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('132', 'default', 'qrsubject', 'field', 'x2_questionrows', '所在科目', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('133', 'default', 'qrpoints', 'field', 'x2_questionrows', '所在知识点', 'split', '', '0');
INSERT INTO `x2_database` VALUES ('134', 'default', 'qrnumber', 'field', 'x2_questionrows', '子题数量', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('135', 'default', 'qrstatus', 'field', 'x2_questionrows', '状态，1为正常，0为标记删除', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('136', 'default', 'qrauthor', 'field', 'x2_questionrows', '录入人', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('137', 'default', 'qrtime', 'field', 'x2_questionrows', '录入时间', 'timestamp', 'Y-m-d', '0');
INSERT INTO `x2_database` VALUES ('138', 'default', 'usercoin', 'field', 'x2_users', '积分/余额', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('139', 'default', 'userregtime', 'field', 'x2_users', '注册时间', 'timestamp', '', '0');
INSERT INTO `x2_database` VALUES ('140', 'default', 'ppysystem', 'field', 'x2_properties', '是否系统属性，系统属性不能删除', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('141', 'default', 'ppyorder', 'field', 'x2_properties', '权重，越大排序越靠前', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('142', 'demo', 'userid', 'field', 'x2_users', '用户ID', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('143', 'demo', 'username', 'field', 'x2_users', '用户名', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('144', 'demo', 'useremail', 'field', 'x2_users', '用户邮箱', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('145', 'demo', 'userphone', 'field', 'x2_users', '手机号码', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('146', 'demo', 'userpassword', 'field', 'x2_users', '密码', 'md5', '', '0');
INSERT INTO `x2_database` VALUES ('147', 'demo', 'usernick', 'field', 'x2_users', '昵称', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('148', 'demo', 'userrealname', 'field', 'x2_users', '真实姓名', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('149', 'demo', 'usergroupcode', 'field', 'x2_users', '所在用户组', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('150', 'demo', 'usersex', 'field', 'x2_users', '性别', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('151', 'demo', 'userpassport', 'field', 'x2_users', '身份证号/护照', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('152', 'demo', 'usercoin', 'field', 'x2_users', '积分/余额', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('153', 'demo', 'userregtime', 'field', 'x2_users', '注册时间', 'timestamp', '', '0');
INSERT INTO `x2_database` VALUES ('155', 'demo', 'x2_users', 'table', 'x2_users', '用户表', 'default', '', '1');
INSERT INTO `x2_database` VALUES ('156', 'demo', 'x2_basics', 'table', 'x2_basics', '考场表', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('157', 'demo', 'basicid', 'field', 'x2_basics', '考场ID', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('158', 'demo', 'basic', 'field', 'x2_basics', '考场名称', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('159', 'demo', 'basicarea', 'field', 'x2_basics', '考场地区', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('160', 'demo', 'basicsubject', 'field', 'x2_basics', '考场科目ID', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('161', 'demo', 'basicsections', 'field', 'x2_basics', '考场章节范围', 'json', '', '0');
INSERT INTO `x2_database` VALUES ('162', 'demo', 'basicpoints', 'field', 'x2_basics', '考场知识点范围', 'json', '', '0');
INSERT INTO `x2_database` VALUES ('163', 'demo', 'basicexam', 'field', 'x2_basics', '考场考试设置', 'json', '', '0');
INSERT INTO `x2_database` VALUES ('164', 'demo', 'basicdemo', 'field', 'x2_basics', '考场是否免费，0为免费，1为收费', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('165', 'demo', 'basicthumb', 'field', 'x2_basics', '考场缩略图', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('166', 'demo', 'basicprice', 'field', 'x2_basics', '考场价格设置', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('167', 'demo', 'basicclosed', 'field', 'x2_basics', '考场状态，1为关闭，0为开启', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('168', 'demo', 'basicdescribe', 'field', 'x2_basics', '考场简介', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('169', 'demo', 'x2_questions', 'table', 'x2_questions', '普通试题题库', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('170', 'demo', 'questionid', 'field', 'x2_questions', '试题ID', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('171', 'demo', 'question', 'field', 'x2_questions', '题干', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('172', 'demo', 'questiontype', 'field', 'x2_questions', '题型', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('173', 'demo', 'questionselect', 'field', 'x2_questions', '选项', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('174', 'demo', 'questionselectnumber', 'field', 'x2_questions', '选项数量', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('175', 'demo', 'questionanswer', 'field', 'x2_questions', '答案', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('176', 'demo', 'questionintro', 'field', 'x2_questions', '解析', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('177', 'demo', 'questionlevel', 'field', 'x2_questions', '难度', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('178', 'demo', 'questionsubject', 'field', 'x2_questions', '科目', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('179', 'demo', 'questionpoints', 'field', 'x2_questions', '知识点', 'split', '', '0');
INSERT INTO `x2_database` VALUES ('180', 'demo', 'questionparent', 'field', 'x2_questions', '题帽ID，0时为普通试题', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('181', 'demo', 'questionorder', 'field', 'x2_questions', '题帽题时子题排序', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('182', 'demo', 'questionstatus', 'field', 'x2_questions', '试题状态', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('183', 'demo', 'questionauthor', 'field', 'x2_questions', '试题录入人', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('184', 'demo', 'questiontime', 'field', 'x2_questions', '试题录入时间', 'timestamp', 'Y-m-d', '0');
INSERT INTO `x2_database` VALUES ('185', 'demo', 'x2_questionrows', 'table', 'x2_questionrows', '题冒题题库', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('186', 'demo', 'qrid', 'field', 'x2_questionrows', '题帽ID', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('187', 'demo', 'qrquestion', 'field', 'x2_questionrows', '题帽题题帽', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('188', 'demo', 'qrtype', 'field', 'x2_questionrows', '题型', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('189', 'demo', 'qrlevel', 'field', 'x2_questionrows', '难度', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('190', 'demo', 'qrsubject', 'field', 'x2_questionrows', '所在科目', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('191', 'demo', 'qrpoints', 'field', 'x2_questionrows', '所在知识点', 'split', '', '0');
INSERT INTO `x2_database` VALUES ('192', 'demo', 'qrnumber', 'field', 'x2_questionrows', '子题数量', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('193', 'demo', 'qrstatus', 'field', 'x2_questionrows', '状态，1为正常，0为标记删除', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('194', 'demo', 'qrauthor', 'field', 'x2_questionrows', '录入人', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('195', 'demo', 'qrtime', 'field', 'x2_questionrows', '录入时间', 'timestamp', 'Y-m-d', '0');
INSERT INTO `x2_database` VALUES ('196', 'demo', 'x2_papers', 'table', 'x2_papers', '试卷表', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('197', 'demo', 'paperid', 'field', 'x2_papers', '试卷ID', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('198', 'demo', 'papername', 'field', 'x2_papers', '试卷名称', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('199', 'demo', 'papersubject', 'field', 'x2_papers', '试卷所属考场ID', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('200', 'demo', 'papersetting', 'field', 'x2_papers', '考场设置', 'json', '', '0');
INSERT INTO `x2_database` VALUES ('201', 'demo', 'paperquestions', 'field', 'x2_papers', '考场试题', 'json', '', '0');
INSERT INTO `x2_database` VALUES ('202', 'demo', 'papertype', 'field', 'x2_papers', '组卷类型，1为随机组卷，2为手工组卷，3为即时组卷', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('203', 'demo', 'paperauthor', 'field', 'x2_papers', '组卷人用户名', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('204', 'demo', 'papertime', 'field', 'x2_papers', '组卷时间', 'timestamp', '', '0');
INSERT INTO `x2_database` VALUES ('205', 'demo', 'paperdecider', 'field', 'x2_papers', '判卷类型，1为教师判卷，0为学生自评', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('206', 'demo', 'x2_openbasics', 'table', 'x2_openbasics', '考场人员表', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('207', 'demo', 'obid', 'field', 'x2_openbasics', '开启考场ID', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('208', 'demo', 'obuserid', 'field', 'x2_openbasics', '开启用户ID', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('209', 'demo', 'obbasicid', 'field', 'x2_openbasics', '开启考场ID', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('210', 'demo', 'obtime', 'field', 'x2_openbasics', '考场开启时间', 'timestamp', '', '0');
INSERT INTO `x2_database` VALUES ('211', 'demo', 'obendtime', 'field', 'x2_openbasics', '考场到期时间', 'timestamp', '', '0');
INSERT INTO `x2_database` VALUES ('212', 'default', 'x2_examhistory', 'table', 'x2_examhistory', '考试记录表', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('213', 'default', 'x2_favors', 'table', 'x2_favors', '试题收藏表', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('214', 'default', 'ehid', 'field', 'x2_examhistory', '记录ID', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('215', 'default', 'ehpaperid', 'field', 'x2_examhistory', '试卷ID', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('216', 'default', 'ehexam', 'field', 'x2_examhistory', '考试名称', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('217', 'default', 'ehtype', 'field', 'x2_examhistory', '考试类型，1强化训练，2模拟考试，3正式考试', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('218', 'default', 'ehbasicid', 'field', 'x2_examhistory', '考场ID', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('219', 'default', 'ehquestion', 'field', 'x2_examhistory', '试题快照', 'zipbase64', '', '0');
INSERT INTO `x2_database` VALUES ('220', 'default', 'ehsetting', 'field', 'x2_examhistory', '试卷设置快照', 'zipbase64', '', '0');
INSERT INTO `x2_database` VALUES ('221', 'default', 'ehscorelist', 'field', 'x2_examhistory', '得分列表', 'json', '', '0');
INSERT INTO `x2_database` VALUES ('222', 'default', 'ehuseranswer', 'field', 'x2_examhistory', '答案快照', 'zipbase64', '', '0');
INSERT INTO `x2_database` VALUES ('223', 'default', 'ehtime', 'field', 'x2_examhistory', '考试用时，单位秒', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('224', 'default', 'ehscore', 'field', 'x2_examhistory', '总得分', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('225', 'default', 'ehusername', 'field', 'x2_examhistory', '考生用户名', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('226', 'default', 'ehstarttime', 'field', 'x2_examhistory', '考试开始时间', 'timestamp', '', '0');
INSERT INTO `x2_database` VALUES ('227', 'default', 'ehendtime', 'field', 'x2_examhistory', '交卷时间', 'timestamp', '', '0');
INSERT INTO `x2_database` VALUES ('228', 'default', 'ehstatus', 'field', 'x2_examhistory', '记录状态，0为需要判卷，1为判卷完成', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('229', 'default', 'ehdecide', 'field', 'x2_examhistory', '是否需要教师判卷，0为不需要，1为需要', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('230', 'default', 'ehtimelist', 'field', 'x2_examhistory', '做题时间快照', 'zipbase64', '', '0');
INSERT INTO `x2_database` VALUES ('231', 'default', 'ehneedresit', 'field', 'x2_examhistory', '是否需要补考，0不需要，1需要', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('232', 'default', 'ehispass', 'field', 'x2_examhistory', '是否几个，0不及格，1及格', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('233', 'default', 'ehteacher', 'field', 'x2_examhistory', '判卷教师用户名', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('234', 'default', 'ehdecidetime', 'field', 'x2_examhistory', '判卷时间', 'timestamp', '', '0');
INSERT INTO `x2_database` VALUES ('235', 'default', 'favorid', 'field', 'x2_favors', 'ID', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('236', 'default', 'favorusername', 'field', 'x2_favors', '收藏人用户名', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('237', 'default', 'favorsubjectid', 'field', 'x2_favors', '收藏科目ID', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('238', 'default', 'favorquestionid', 'field', 'x2_favors', '收藏试题ID', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('239', 'default', 'favortime', 'field', 'x2_favors', '收藏时间', 'timestamp', '', '0');
INSERT INTO `x2_database` VALUES ('240', 'demo', 'x2_examhistory', 'table', 'x2_examhistory', '考试记录表', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('241', 'demo', 'ehid', 'field', 'x2_examhistory', '记录ID', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('242', 'demo', 'ehpaperid', 'field', 'x2_examhistory', '试卷ID', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('243', 'demo', 'ehexam', 'field', 'x2_examhistory', '考试名称', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('244', 'demo', 'ehtype', 'field', 'x2_examhistory', '考试类型，1强化训练，2模拟考试，3正式考试', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('245', 'demo', 'ehbasicid', 'field', 'x2_examhistory', '考场ID', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('246', 'demo', 'ehquestion', 'field', 'x2_examhistory', '试题快照', 'zipbase64', '', '0');
INSERT INTO `x2_database` VALUES ('247', 'demo', 'ehsetting', 'field', 'x2_examhistory', '试卷设置快照', 'zipbase64', '', '0');
INSERT INTO `x2_database` VALUES ('248', 'demo', 'ehscorelist', 'field', 'x2_examhistory', '得分列表', 'json', '', '0');
INSERT INTO `x2_database` VALUES ('249', 'demo', 'ehuseranswer', 'field', 'x2_examhistory', '答案快照', 'zipbase64', '', '0');
INSERT INTO `x2_database` VALUES ('250', 'demo', 'ehtime', 'field', 'x2_examhistory', '考试用时，单位秒', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('251', 'demo', 'ehscore', 'field', 'x2_examhistory', '总得分', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('252', 'demo', 'ehusername', 'field', 'x2_examhistory', '考生用户名', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('253', 'demo', 'ehstarttime', 'field', 'x2_examhistory', '考试开始时间', 'timestamp', '', '0');
INSERT INTO `x2_database` VALUES ('254', 'demo', 'ehendtime', 'field', 'x2_examhistory', '交卷时间', 'timestamp', '', '0');
INSERT INTO `x2_database` VALUES ('255', 'demo', 'ehstatus', 'field', 'x2_examhistory', '记录状态，0为需要判卷，1为判卷完成', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('256', 'demo', 'ehdecide', 'field', 'x2_examhistory', '是否需要教师判卷，0为不需要，1为需要', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('257', 'demo', 'ehtimelist', 'field', 'x2_examhistory', '做题时间快照', 'zipbase64', '', '0');
INSERT INTO `x2_database` VALUES ('258', 'demo', 'ehneedresit', 'field', 'x2_examhistory', '是否需要补考，0不需要，1需要', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('259', 'demo', 'ehispass', 'field', 'x2_examhistory', '是否几个，0不及格，1及格', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('260', 'demo', 'ehteacher', 'field', 'x2_examhistory', '判卷教师用户名', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('261', 'demo', 'ehdecidetime', 'field', 'x2_examhistory', '判卷时间', 'timestamp', '', '0');
INSERT INTO `x2_database` VALUES ('262', 'demo', 'x2_favors', 'table', 'x2_favors', '试题收藏表', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('263', 'demo', 'favorid', 'field', 'x2_favors', 'ID', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('264', 'demo', 'favorusername', 'field', 'x2_favors', '收藏人用户名', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('265', 'demo', 'favorsubjectid', 'field', 'x2_favors', '收藏科目ID', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('266', 'demo', 'favorquestionid', 'field', 'x2_favors', '收藏试题ID', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('267', 'demo', 'favortime', 'field', 'x2_favors', '收藏时间', 'timestamp', '', '0');
INSERT INTO `x2_database` VALUES ('268', 'default', 'catid', 'field', 'x2_category', '分类ID', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('269', 'default', 'catapp', 'field', 'x2_category', '所属模块', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('270', 'default', 'catorder', 'field', 'x2_category', '排序，数字越大越靠前', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('271', 'default', 'catname', 'field', 'x2_category', '分类名', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('272', 'default', 'catthumb', 'field', 'x2_category', '缩略图', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('273', 'default', 'catparent', 'field', 'x2_category', '父分类', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('274', 'default', 'catintro', 'field', 'x2_category', '分类简介', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('275', 'default', 'x2_category', 'table', 'x2_category', '分类表', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('276', 'default', 'x2_contents', 'table', 'x2_contents', '新闻内容表', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('277', 'default', 'contentid', 'field', 'x2_contents', 'ID', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('278', 'default', 'contenttitle', 'field', 'x2_contents', '标题', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('279', 'default', 'contentthumb', 'field', 'x2_contents', '缩略图', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('280', 'default', 'contentmodelcode', 'field', 'x2_contents', '模型', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('281', 'default', 'contentintro', 'field', 'x2_contents', '简介', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('282', 'default', 'contenttext', 'field', 'x2_contents', '内容', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('283', 'default', 'contentauthor', 'field', 'x2_contents', '发布人', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('284', 'default', 'contenttime', 'field', 'x2_contents', '发布时间', 'timestamp', '', '0');
INSERT INTO `x2_database` VALUES ('285', 'default', 'contenttpl', 'field', 'x2_contents', '模板', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('286', 'default', 'x2_records', 'table', 'x2_records', '练习记录表', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('287', 'default', 'recordid', 'field', 'x2_records', 'ID', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('288', 'default', 'recordusername', 'field', 'x2_records', '用户名', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('289', 'default', 'recordnumber', 'field', 'x2_records', '正确和错误的数量', 'json', '', '0');
INSERT INTO `x2_database` VALUES ('290', 'default', 'recordright', 'field', 'x2_records', '正确的题号', 'json', '', '0');
INSERT INTO `x2_database` VALUES ('291', 'default', 'recordwrong', 'field', 'x2_records', '错误的题号', 'json', '', '0');
INSERT INTO `x2_database` VALUES ('292', 'demo', 'x2_records', 'table', 'x2_records', '练习记录表', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('293', 'demo', 'recordid', 'field', 'x2_records', 'ID', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('294', 'demo', 'recordusername', 'field', 'x2_records', '用户名', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('295', 'demo', 'recordnumber', 'field', 'x2_records', '正确和错误的数量', 'json', '', '0');
INSERT INTO `x2_database` VALUES ('296', 'demo', 'recordright', 'field', 'x2_records', '正确的题号', 'json', '', '0');
INSERT INTO `x2_database` VALUES ('297', 'demo', 'recordwrong', 'field', 'x2_records', '错误的题号', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('298', 'default', 'noteid', 'field', 'x2_notes', '笔记ID', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('299', 'default', 'noteusername', 'field', 'x2_notes', '笔记作者用户名', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('300', 'default', 'notequestionid', 'field', 'x2_notes', '试题ID', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('301', 'default', 'notecontent', 'field', 'x2_notes', '笔记内容', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('302', 'default', 'x2_notes', 'table', 'x2_notes', '试题笔记表', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('303', 'default', 'x2_orders', 'table', 'x2_orders', '订单表', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('304', 'default', 'ordersn', 'field', 'x2_orders', '订单号', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('305', 'default', 'ordername', 'field', 'x2_orders', '订单名称', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('306', 'default', 'orderusername', 'field', 'x2_orders', '订单用户名', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('307', 'default', 'orderitems', 'field', 'x2_orders', '订单内容', 'json', '', '0');
INSERT INTO `x2_database` VALUES ('308', 'default', 'ordertype', 'field', 'x2_orders', '订单类型，exam是题库，course是课程', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('309', 'default', 'orderprice', 'field', 'x2_orders', '订单总价', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('310', 'default', 'ordertime', 'field', 'x2_orders', '下单时间', 'timestamp', '', '0');
INSERT INTO `x2_database` VALUES ('311', 'default', 'orderstatus', 'field', 'x2_orders', '订单状态，1未支付，2已支付，99已作废', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('312', 'default', 'ordertips', 'field', 'x2_orders', '订单备注', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('313', 'demo', 'x2_notes', 'table', 'x2_notes', '试题笔记表', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('314', 'demo', 'noteid', 'field', 'x2_notes', '笔记ID', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('315', 'demo', 'noteusername', 'field', 'x2_notes', '笔记作者用户名', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('316', 'demo', 'notequestionid', 'field', 'x2_notes', '试题ID', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('317', 'demo', 'notecontent', 'field', 'x2_notes', '笔记内容', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('318', 'default', 'x2_lessons', 'table', 'x2_lessons', '课程数据表', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('319', 'default', 'lessonid', 'field', 'x2_lessons', '课程ID', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('320', 'default', 'lessonname', 'field', 'x2_lessons', '课程名称', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('321', 'default', 'lessoncatid', 'field', 'x2_lessons', '课程分类ID', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('322', 'default', 'lessonthumb', 'field', 'x2_lessons', '缩略图', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('323', 'default', 'lessonintro', 'field', 'x2_lessons', '课程简介', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('324', 'default', 'lessonorder', 'field', 'x2_lessons', '排序权重，越大越靠前', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('325', 'default', 'videoid', 'field', 'x2_videos', '视频ID', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('326', 'default', 'videolesson', 'field', 'x2_videos', '所属课程', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('327', 'default', 'videoname', 'field', 'x2_videos', '视频名称', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('328', 'default', 'videothumb', 'field', 'x2_videos', '缩略图', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('329', 'default', 'videointro', 'field', 'x2_videos', '课程简介', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('330', 'default', 'videopath', 'field', 'x2_videos', '视频源路径', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('331', 'default', 'videotime', 'field', 'x2_videos', '上传时间', 'timestamp', '', '0');
INSERT INTO `x2_database` VALUES ('332', 'default', 'videoauthor', 'field', 'x2_videos', '上传人', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('333', 'default', 'videoorder', 'field', 'x2_videos', '排序权重', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('334', 'default', 'lessontime', 'field', 'x2_lessons', '发布时间', 'timestamp', '', '0');
INSERT INTO `x2_database` VALUES ('335', 'default', 'lessondemo', 'field', 'x2_lessons', '是否免费', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('336', 'default', 'lessonprice', 'field', 'x2_lessons', '价格', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('337', 'default', 'oplid', 'field', 'x2_openlessons', 'ID', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('338', 'default', 'oplusername', 'field', 'x2_openlessons', '用户名', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('339', 'default', 'opllessonid', 'field', 'x2_openlessons', '课程ID', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('340', 'default', 'opltime', 'field', 'x2_openlessons', '开通时间', 'timestamp', '', '0');
INSERT INTO `x2_database` VALUES ('341', 'default', 'oplendtime', 'field', 'x2_openlessons', '到期时间', 'timestamp', '', '0');
INSERT INTO `x2_database` VALUES ('342', 'default', 'x2_openlessons', 'table', 'x2_openlessons', '开通科目表', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('343', 'default', 'x2_videos', 'table', 'x2_videos', '课件表', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('344', 'default', 'x2_errors', 'table', 'x2_errors', '错题反馈表', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('345', 'default', 'erid', 'field', 'x2_errors', '反馈ID', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('346', 'default', 'ersubjectid', 'field', 'x2_errors', '错题科目', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('347', 'default', 'erquestionid', 'field', 'x2_errors', '错题ID', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('348', 'default', 'ertime', 'field', 'x2_errors', '错题提交时间', 'timestamp', 'Y-m-d', '0');
INSERT INTO `x2_database` VALUES ('349', 'default', 'erintro', 'field', 'x2_errors', '错误内容', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('350', 'default', 'erusername', 'field', 'x2_errors', '错题提交人', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('351', 'default', 'erstatus', 'field', 'x2_errors', '处理状态，0未处理，1已处理', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('352', 'default', 'erteacher', 'field', 'x2_errors', '错题处理人', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('353', 'default', 'userrate', 'field', 'x2_users', '折扣率', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('354', 'demo', 'userrate', 'field', 'x2_users', '折扣率', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('355', 'default', 'orderagent', 'field', 'x2_orders', '代理用户', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('356', 'default', 'orderactivetime', 'field', 'x2_orders', '激活时间', 'default', 'Y-m-d H:i:s', '0');
INSERT INTO `x2_database` VALUES ('357', 'default', 'videomodelcode', 'field', 'x2_videos', '模型代码', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('358', 'default', 'basicbook', 'field', 'x2_basics', '考试大纲', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('359', 'default', 'cattpl', 'field', 'x2_category', '分类模板', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('360', 'default', 'contentorder', 'field', 'x2_contents', '权重', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('361', 'default', 'contentcatid', 'field', 'x2_contents', '所属分类ID', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('362', 'default', 'dbsynch', 'field', 'x2_database', '是否同步', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('363', 'default', 'trpackage', 'field', 'x2_training', '套餐', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('364', 'default', 'trtext', 'field', 'x2_training', '产品介绍', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('365', 'default', 'trthumb', 'field', 'x2_training', '缩略图', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('366', 'default', 'orderpaytype', 'field', 'x2_orders', '支付服务提供商', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('367', 'default', 'sectionid', 'field', 'x2_sections', '章节ID', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('368', 'default', 'sectionname', 'field', 'x2_sections', '章节名称', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('369', 'default', 'sectionsubject', 'field', 'x2_sections', '所属科目', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('370', 'default', 'sectionorder', 'field', 'x2_sections', '权重', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('371', 'default', 'sectionintro', 'field', 'x2_sections', '章节简介', 'default', '', '0');
INSERT INTO `x2_database` VALUES ('372', 'demo', 'basicbook', 'field', 'x2_basics', '考试大纲', 'default', '', '0');

-- ----------------------------
-- Table structure for `x2_errors`
-- ----------------------------
DROP TABLE IF EXISTS `x2_errors`;
CREATE TABLE `x2_errors` (
  `erid` int(11) NOT NULL AUTO_INCREMENT,
  `ersubjectid` int(11) NOT NULL,
  `erquestionid` int(11) NOT NULL,
  `ertime` int(11) NOT NULL,
  `erintro` text NOT NULL,
  `erusername` varchar(48) NOT NULL,
  `erstatus` tinyint(1) NOT NULL DEFAULT '0',
  `erteacher` varchar(48) DEFAULT NULL,
  PRIMARY KEY (`erid`),
  KEY `ersubjectid` (`ersubjectid`),
  KEY `erquestionid` (`erquestionid`),
  KEY `erusername` (`erusername`),
  KEY `erstatus` (`erstatus`),
  KEY `erteacher` (`erteacher`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of x2_errors
-- ----------------------------
INSERT INTO `x2_errors` VALUES ('1', '6', '740', '1549375977', '答案错误,题干错误,解析错误:这里问题很大呀', 'peadmin', '1', 'peadmin');
INSERT INTO `x2_errors` VALUES ('2', '6', '740', '1549376020', '答案错误,题干错误,解析错误:大问题', 'peadmin', '1', 'peadmin');
INSERT INTO `x2_errors` VALUES ('8', '6', '760', '1552722983', '答案错误,题干错误,解析错误,其他错误:题干错误', 'peadmin', '0', '');
INSERT INTO `x2_errors` VALUES ('4', '6', '3', '1550241154', '答案错误,题干错误,解析错误,其他错误:命题哦肉欲took', 'redrangon', '0', '');
INSERT INTO `x2_errors` VALUES ('5', '6', '3', '1550241289', '答案错误,题干错误,解析错误,其他错误:ill去', 'redrangon', '0', '');
INSERT INTO `x2_errors` VALUES ('6', '6', '647', '1551262773', '答案错误,题干错误,解析错误:我热热特热天热他', '', '0', '');
INSERT INTO `x2_errors` VALUES ('7', '6', '647', '1551262798', '答案错误,题干错误:大师傅士大夫士大夫士大夫', '', '0', '');

-- ----------------------------
-- Table structure for `x2_examhistory`
-- ----------------------------
DROP TABLE IF EXISTS `x2_examhistory`;
CREATE TABLE `x2_examhistory` (
  `ehid` int(11) NOT NULL AUTO_INCREMENT,
  `ehpaperid` int(11) NOT NULL DEFAULT '0',
  `ehexam` varchar(240) NOT NULL DEFAULT '',
  `ehtype` int(11) NOT NULL DEFAULT '0',
  `ehbasicid` int(11) NOT NULL DEFAULT '0',
  `ehquestion` longtext NOT NULL,
  `ehsetting` text,
  `ehscorelist` text,
  `ehuseranswer` text,
  `ehtime` int(11) NOT NULL DEFAULT '0',
  `ehscore` decimal(10,1) NOT NULL DEFAULT '0.0',
  `ehusername` varchar(48) NOT NULL DEFAULT '',
  `ehstarttime` int(11) NOT NULL DEFAULT '0',
  `ehendtime` int(11) NOT NULL,
  `ehstatus` int(1) NOT NULL DEFAULT '1',
  `ehdecide` int(1) NOT NULL DEFAULT '0',
  `ehtimelist` text,
  `ehneedresit` tinyint(1) NOT NULL,
  `ehispass` tinyint(1) DEFAULT NULL,
  `ehteacher` varchar(48) DEFAULT NULL,
  `ehdecidetime` int(11) DEFAULT NULL,
  PRIMARY KEY (`ehid`),
  KEY `ehtype` (`ehtype`),
  KEY `ehdecide` (`ehdecide`),
  KEY `ehneedresit` (`ehneedresit`),
  KEY `ehispass` (`ehispass`),
  KEY `ehpaperid` (`ehpaperid`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of x2_examhistory
-- ----------------------------
INSERT INTO `x2_examhistory` VALUES ('1', '8', '测试试卷', '1', '4', 'eJyrViosTS0uyczPK1ayio7VgXOL8svBIrUA3ywMvw==', 'eJy9UstOwzAQ/BXkM5Vsyqs5Vr0icUAqV8deqKs4DrZzqKJ8QdUj38EJ8UUgPgM/4tQ9tZci5bAzOzuzcrZDDW1AC44KdI8uI6qpBId/Pre/H+/u+959pZZpyzUw67qzkQJrRf2Kii5iK8L0LXYCpuSLVtJBBwxT2ncIxmHWmMQE7VsLxm4aqIQFb7Z4fvJi13nYl/N9+bhI1XKoep9BK5CKQ+WY3HV07FDdyhL0MHu4FAfDtCghLgzUbA7EUnBewUj5iRXVPCP6tG0Wg7OYIyH41JD5f4SEFz5zxvLsGX0/HGo8g/AjA6atXSkdjfPLvcJkNsF3kym5ILi4uS7INCk4MMGT8R/1R/0B', '[]', 'eJxLS8wpTgUABhYCDA==', '19', '0.0', 'peadmin', '1564541752', '0', '1', '0', '', '0', '0', '', '0');
INSERT INTO `x2_examhistory` VALUES ('2', '8', '测试试卷', '1', '4', 'eJyrViosTS0uyczPK1ayio7VgXOL8svBIrUA3ywMvw==', 'eJy9UstOwzAQ/BXkM5Vsyqs5Vr0icUAqV8deqKs4DrZzqKJ8QdUj38EJ8UUgPgM/4tQ9tZci5bAzOzuzcrZDDW1AC44KdI8uI6qpBId/Pre/H+/u+959pZZpyzUw67qzkQJrRf2Kii5iK8L0LXYCpuSLVtJBBwxT2ncIxmHWmMQE7VsLxm4aqIQFb7Z4fvJi13nYl/N9+bhI1XKoep9BK5CKQ+WY3HV07FDdyhL0MHu4FAfDtCghLgzUbA7EUnBewUj5iRXVPCP6tG0Wg7OYIyH41JD5f4SEFz5zxvLsGX0/HGo8g/AjA6atXSkdjfPLvcJkNsF3kym5ILi4uS7INCk4MMGT8R/1R/0B', '[]', 'eJxLS8wpTgUABhYCDA==', '6', '0.0', 'peadmin', '1564542061', '0', '1', '0', '', '0', '0', '', '0');
INSERT INTO `x2_examhistory` VALUES ('3', '8', '测试试卷', '1', '4', 'eJyrViosTS0uyczPK1ayio7VgXOL8svBIrUA3ywMvw==', 'eJy9UstOwzAQ/BXkM5Vsyqs5Vr0icUAqV8deqKs4DrZzqKJ8QdUj38EJ8UUgPgM/4tQ9tZci5bAzOzuzcrZDDW1AC44KdI8uI6qpBId/Pre/H+/u+959pZZpyzUw67qzkQJrRf2Kii5iK8L0LXYCpuSLVtJBBwxT2ncIxmHWmMQE7VsLxm4aqIQFb7Z4fvJi13nYl/N9+bhI1XKoep9BK5CKQ+WY3HV07FDdyhL0MHu4FAfDtCghLgzUbA7EUnBewUj5iRXVPCP6tG0Wg7OYIyH41JD5f4SEFz5zxvLsGX0/HGo8g/AjA6atXSkdjfPLvcJkNsF3kym5ILi4uS7INCk4MMGT8R/1R/0B', '[]', 'eJxLS8wpTgUABhYCDA==', '91', '0.0', 'peadmin', '1564542300', '0', '1', '0', '', '0', '0', '', '0');
INSERT INTO `x2_examhistory` VALUES ('4', '8', '测试试卷', '1', '4', 'eJyrViosTS0uyczPK1ayio7VgXOL8svBIrUA3ywMvw==', 'eJy9UstOwzAQ/BXkM5Vsyqs5Vr0icUAqV8deqKs4DrZzqKJ8QdUj38EJ8UUgPgM/4tQ9tZci5bAzOzuzcrZDDW1AC44KdI8uI6qpBId/Pre/H+/u+959pZZpyzUw67qzkQJrRf2Kii5iK8L0LXYCpuSLVtJBBwxT2ncIxmHWmMQE7VsLxm4aqIQFb7Z4fvJi13nYl/N9+bhI1XKoep9BK5CKQ+WY3HV07FDdyhL0MHu4FAfDtCghLgzUbA7EUnBewUj5iRXVPCP6tG0Wg7OYIyH41JD5f4SEFz5zxvLsGX0/HGo8g/AjA6atXSkdjfPLvcJkNsF3kym5ILi4uS7INCk4MMGT8R/1R/0B', '[]', 'eJxLS8wpTgUABhYCDA==', '46', '0.0', 'peadmin', '1564543187', '0', '1', '0', '', '0', '0', '', '0');
INSERT INTO `x2_examhistory` VALUES ('5', '8', '测试试卷', '1', '4', 'eJyrViosTS0uyczPK1ayio7VgXOL8svBIrUA3ywMvw==', 'eJy9UstOwzAQ/BXkM5Vsyqs5Vr0icUAqV8deqKs4DrZzqKJ8QdUj38EJ8UUgPgM/4tQ9tZci5bAzOzuzcrZDDW1AC44KdI8uI6qpBId/Pre/H+/u+959pZZpyzUw67qzkQJrRf2Kii5iK8L0LXYCpuSLVtJBBwxT2ncIxmHWmMQE7VsLxm4aqIQFb7Z4fvJi13nYl/N9+bhI1XKoep9BK5CKQ+WY3HV07FDdyhL0MHu4FAfDtCghLgzUbA7EUnBewUj5iRXVPCP6tG0Wg7OYIyH41JD5f4SEFz5zxvLsGX0/HGo8g/AjA6atXSkdjfPLvcJkNsF3kym5ILi4uS7INCk4MMGT8R/1R/0B', '[]', 'eJxLS8wpTgUABhYCDA==', '30', '0.0', 'peadmin', '1564543277', '0', '1', '0', '', '0', '0', '', '0');
INSERT INTO `x2_examhistory` VALUES ('6', '8', '测试试卷', '1', '4', 'eJyrViosTS0uyczPK1ayqlZyiQhRsoquhgtmpihZKRkq6cAFgFybArtnW7tfrJ/6fP7SF+vbnjftBLJfLpphE6NfYIektKSyIBWoHGQkQrA4NSc1uQRiytMly5/u6Hja1Pp08WoQe8lqsBExRTF5IGyTUaQQow/mghTD1GDqejZp0rPpy/DpxdBCgl4MLXDT0D0M8VteaW5SahHQhyZIUol5xeVgQUckwcy8kqJ8oBiSUE5qWWoOWpAXlyZlQcLMEkm0IB+oHRhn0UrmSrFIwolFqXkgtQZIavOLUsCWI4sVlySWlBajWZVYWpKRX4TqpJLMXFA0GhkYWuoamOsaGyrVxtYipIvyy0GuiK0FANbY+Bs=', 'eJy9UstOwzAQ/BXkM5Vsyqs5Vr0icUAqV8deqKs4DrZzqKJ8QdUj38EJ8UUgPgM/4tQ9tZci5bAzOzuzcrZDDW1AC44KdI8uI6qpBId/Pre/H+/u+959pZZpyzUw67qzkQJrRf2Kii5iK8L0LXYCpuSLVtJBBwxT2ncIxmHWmMQE7VsLxm4aqIQFb7Z4fvJi13nYl/N9+bhI1XKoep9BK5CKQ+WY3HV07FDdyhL0MHu4FAfDtCghLgzUbA7EUnBewUj5iRXVPCP6tG0Wg7OYIyH41JD5f4SEFz5zxvLsGX0/HGo8g/AjA6atXSkdjfPLvcJkNsF3kym5ILi4uS7INCk4MMGT8R/1R/0B', '{\"1\":0}', 'eJxLS8wpTgUABhYCDA==', '8', '0.0', 'peadmin', '1564543939', '0', '1', '0', '', '0', '0', '', '0');

-- ----------------------------
-- Table structure for `x2_favors`
-- ----------------------------
DROP TABLE IF EXISTS `x2_favors`;
CREATE TABLE `x2_favors` (
  `favorid` int(11) NOT NULL AUTO_INCREMENT,
  `favorusername` varchar(48) NOT NULL DEFAULT '',
  `favorsubjectid` int(11) NOT NULL DEFAULT '0',
  `favorquestionid` int(11) NOT NULL DEFAULT '0',
  `favortime` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`favorid`),
  KEY `favorusername` (`favorusername`,`favorquestionid`),
  KEY `favorsubjectid` (`favorsubjectid`),
  KEY `favortime` (`favortime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of x2_favors
-- ----------------------------

-- ----------------------------
-- Table structure for `x2_groups`
-- ----------------------------
DROP TABLE IF EXISTS `x2_groups`;
CREATE TABLE `x2_groups` (
  `groupid` int(11) NOT NULL AUTO_INCREMENT,
  `groupcode` varchar(24) NOT NULL,
  `groupname` varchar(48) NOT NULL,
  `groupmodel` varchar(36) NOT NULL,
  `groupdefault` tinyint(1) unsigned zerofill NOT NULL,
  `groupintro` text NOT NULL,
  PRIMARY KEY (`groupid`),
  UNIQUE KEY `groupcode` (`groupcode`),
  KEY `groupmodel` (`groupmodel`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of x2_groups
-- ----------------------------
INSERT INTO `x2_groups` VALUES ('1', 'webmaster', '管理员', 'webmaster', '1', '管理员');
INSERT INTO `x2_groups` VALUES ('2', 'teacher', '教师', 'teacher', '0', '教师');
INSERT INTO `x2_groups` VALUES ('3', 'user', '普通用户', 'user', '0', '普通用户');
INSERT INTO `x2_groups` VALUES ('4', 'agent', '代理', 'agent', '0', '');

-- ----------------------------
-- Table structure for `x2_lessons`
-- ----------------------------
DROP TABLE IF EXISTS `x2_lessons`;
CREATE TABLE `x2_lessons` (
  `lessonid` int(11) NOT NULL AUTO_INCREMENT,
  `lessonname` varchar(120) NOT NULL,
  `lessoncatid` int(11) NOT NULL,
  `lessonthumb` varchar(240) NOT NULL,
  `lessonintro` text NOT NULL,
  `lessonorder` int(11) NOT NULL,
  `lessontime` int(11) NOT NULL,
  `lessondemo` tinyint(1) NOT NULL,
  `lessonprice` text NOT NULL,
  `lessontext` text NOT NULL,
  PRIMARY KEY (`lessonid`),
  KEY `lessoncatid` (`lessoncatid`),
  KEY `lessonorder` (`lessonorder`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of x2_lessons
-- ----------------------------
INSERT INTO `x2_lessons` VALUES ('1', '初级经济法', '4', 'files/attach/images/content/20190314/15525515618647.jpg', '初级经济法', '0', '1547683200', '0', '月卡:30:128', '&lt;p&gt;风格部分：&lt;/p&gt;\r\n\r\n&lt;p&gt;1：支持界面风格自定义&lt;/p&gt;\r\n\r\n&lt;p&gt;2：支持加密风格&lt;/p&gt;\r\n\r\n&lt;p&gt;常规功能：&lt;/p&gt;\r\n\r\n&lt;p&gt;3：支持多种调用方式&lt;/p&gt;\r\n\r\n&lt;p&gt;4：支持视频地址加密功能&lt;/p&gt;\r\n\r\n&lt;p&gt;5：支持点播&lt;/p&gt;\r\n\r\n&lt;p&gt;6：支持直播&lt;/p&gt;\r\n\r\n&lt;p&gt;7：支持直播+回看&lt;/p&gt;\r\n\r\n&lt;p&gt;8：支持弹幕&lt;/p&gt;\r\n\r\n&lt;p&gt;9：支持字幕&lt;/p&gt;\r\n\r\n&lt;p&gt;10：支持自定义按钮，图片，swf插件&lt;/p&gt;\r\n\r\n&lt;p&gt;11：支持和javascript交互&lt;/p&gt;\r\n\r\n&lt;p&gt;m3u8格式PC端播放功能：&lt;/p&gt;\r\n\r\n&lt;p&gt;12：PC端内置支持m3u8播放&lt;/p&gt;\r\n\r\n&lt;p&gt;13：支持pc端m3u8普通加密/私有加密播放&lt;/p&gt;\r\n\r\n&lt;p&gt;14：支持m3u8清晰度自动列表&lt;/p&gt;\r\n\r\n&lt;p&gt;广告部分：&lt;/p&gt;\r\n\r\n&lt;p&gt;15：支持前置广告&lt;/p&gt;\r\n\r\n&lt;p&gt;16：支持暂停广告&lt;/p&gt;\r\n\r\n&lt;p&gt;17：支持插入广告&lt;/p&gt;\r\n\r\n&lt;p&gt;18：支持结尾广告&lt;/p&gt;\r\n\r\n&lt;p&gt;19：支持其它类型的广告（角标，横幅广告）&lt;/p&gt;\r\n\r\n&lt;p&gt;20：广告类型支持jpg,jpeg,png,gif,swf,mp4,flv,f4v&lt;/p&gt;\r\n\r\n&lt;p&gt;更多功能请查看手册或示例。&lt;/p&gt;');
INSERT INTO `x2_lessons` VALUES ('2', '初级实务', '4', 'files/attach/images/content/20190314/15525596044365.jpg', '初级实务', '0', '1552559614', '1', '', '&lt;p&gt;初级实务&lt;/p&gt;');

-- ----------------------------
-- Table structure for `x2_models`
-- ----------------------------
DROP TABLE IF EXISTS `x2_models`;
CREATE TABLE `x2_models` (
  `modelid` int(11) NOT NULL AUTO_INCREMENT,
  `modelcode` varchar(36) NOT NULL,
  `modelname` varchar(60) NOT NULL,
  `modelapp` varchar(36) NOT NULL,
  `modeldb` varchar(36) NOT NULL,
  `modeltable` varchar(36) DEFAULT NULL,
  `modelintro` varchar(240) NOT NULL,
  PRIMARY KEY (`modelid`),
  UNIQUE KEY `modelcode` (`modelcode`) USING BTREE,
  KEY `modeleapp` (`modelapp`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of x2_models
-- ----------------------------
INSERT INTO `x2_models` VALUES ('1', 'news', '新闻模型', 'content', 'default', 'x2_contents', '内容模型/新闻');
INSERT INTO `x2_models` VALUES ('2', 'webmaster', '网站管理员', 'user', 'default', 'x2_users', '网站管理员模型');
INSERT INTO `x2_models` VALUES ('3', 'video', '视频', 'lesson', 'default', 'x2_videos', '视频课程模型');
INSERT INTO `x2_models` VALUES ('4', 'teacher', '教师用户', 'user', 'default', 'x2_users', '教师用户模型');
INSERT INTO `x2_models` VALUES ('5', 'user', '普通用户', 'user', 'default', 'x2_users', '普通用户模型');
INSERT INTO `x2_models` VALUES ('6', 'agent', '代理', 'user', 'default', 'x2_users', '代理');

-- ----------------------------
-- Table structure for `x2_notes`
-- ----------------------------
DROP TABLE IF EXISTS `x2_notes`;
CREATE TABLE `x2_notes` (
  `noteid` int(11) NOT NULL AUTO_INCREMENT,
  `noteusername` varchar(48) NOT NULL,
  `notequestionid` int(11) NOT NULL,
  `notecontent` text NOT NULL,
  `notesubject` int(11) NOT NULL,
  `notestatus` tinyint(1) NOT NULL,
  `notetime` int(11) NOT NULL,
  PRIMARY KEY (`noteid`),
  KEY `noteusername` (`noteusername`) USING BTREE,
  KEY `notequestionid` (`notequestionid`) USING BTREE,
  KEY `notesubject` (`notesubject`),
  KEY `notestatus` (`notestatus`),
  KEY `notetime` (`notetime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of x2_notes
-- ----------------------------

-- ----------------------------
-- Table structure for `x2_openbasics`
-- ----------------------------
DROP TABLE IF EXISTS `x2_openbasics`;
CREATE TABLE `x2_openbasics` (
  `obid` int(11) NOT NULL AUTO_INCREMENT,
  `obusername` varchar(48) NOT NULL DEFAULT '0',
  `obbasicid` int(11) NOT NULL DEFAULT '0',
  `obtime` int(11) NOT NULL DEFAULT '0',
  `obendtime` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`obid`),
  KEY `obbasicid` (`obbasicid`),
  KEY `obtime` (`obtime`),
  KEY `obendtime` (`obendtime`),
  KEY `obusername` (`obusername`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of x2_openbasics
-- ----------------------------
INSERT INTO `x2_openbasics` VALUES ('3', '18568263814', '2', '1551601638', '1614846438');
INSERT INTO `x2_openbasics` VALUES ('4', 'peadmin', '2', '1552880035', '1584502435');
INSERT INTO `x2_openbasics` VALUES ('5', 'peadmin', '4', '1564541677', '1565492077');

-- ----------------------------
-- Table structure for `x2_openlessons`
-- ----------------------------
DROP TABLE IF EXISTS `x2_openlessons`;
CREATE TABLE `x2_openlessons` (
  `oplid` int(11) NOT NULL AUTO_INCREMENT,
  `oplusername` varchar(48) NOT NULL,
  `opllessonid` int(11) NOT NULL,
  `opltime` int(11) NOT NULL,
  `oplendtime` int(11) NOT NULL,
  PRIMARY KEY (`oplid`),
  KEY `oplusername` (`oplusername`),
  KEY `opllessonid` (`opllessonid`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of x2_openlessons
-- ----------------------------
INSERT INTO `x2_openlessons` VALUES ('2', 'ppstream', '2', '1556413068', '1556585868');
INSERT INTO `x2_openlessons` VALUES ('3', 'cxk', '2', '1556413902', '1556500302');
INSERT INTO `x2_openlessons` VALUES ('4', 'peadmin', '2', '1563527848', '1572167848');
INSERT INTO `x2_openlessons` VALUES ('5', 'peadmin', '1', '1563527880', '1572167880');

-- ----------------------------
-- Table structure for `x2_orders`
-- ----------------------------
DROP TABLE IF EXISTS `x2_orders`;
CREATE TABLE `x2_orders` (
  `ordersn` varchar(16) NOT NULL,
  `ordername` varchar(72) NOT NULL,
  `orderusername` varchar(48) NOT NULL,
  `orderitems` text NOT NULL,
  `ordertype` varchar(15) NOT NULL,
  `orderprice` decimal(10,2) NOT NULL,
  `ordertime` int(11) NOT NULL,
  `orderstatus` tinyint(2) NOT NULL,
  `ordertips` text NOT NULL,
  `orderagent` varchar(48) NOT NULL,
  `orderactivetime` int(11) NOT NULL,
  `orderpaytype` varchar(12) NOT NULL,
  PRIMARY KEY (`ordersn`),
  KEY `ordertype` (`ordertype`),
  KEY `ordertime` (`ordertime`),
  KEY `orderusername` (`orderusername`),
  KEY `orderagent` (`orderagent`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of x2_orders
-- ----------------------------
INSERT INTO `x2_orders` VALUES ('201902251939518', '初级经济法+实务套餐', '18568263814', '[{\"subjectid\":\"6\",\"basicid\":\"3\",\"basicname\":\"初级实务\",\"time\":\"366\"}]', 'exam', '30.04', '1551094766', '2', '', 'redrangon', '0', '');
INSERT INTO `x2_orders` VALUES ('201908042253685', '英语六级月卡', 'peadmin', '[{\"subjectid\":\"8\",\"basicid\":\"5\",\"basicname\":\"英语六级\",\"time\":\"31\",\"price\":48.8}]', 'exam', '48.80', '1564930403', '1', '', '', '0', '');
INSERT INTO `x2_orders` VALUES ('201908042253250', '英语六级月卡', 'peadmin', '[{\"subjectid\":\"8\",\"basicid\":\"5\",\"basicname\":\"英语六级\",\"time\":\"31\",\"price\":48.8}]', 'exam', '48.80', '1564930425', '1', '', '', '0', '');
INSERT INTO `x2_orders` VALUES ('201902281519893', '初级经济法+实务套餐', '13552525371', '[{\"subjectid\":\"4\",\"basicid\":\"2\",\"basicname\":\"初级经济法\",\"time\":\"366\"},{\"subjectid\":\"6\",\"basicid\":\"3\",\"basicname\":\"初级实务\",\"time\":\"366\"}]', 'exam', '30.04', '1551338354', '2', '', 'redrangon', '0', 'coin');
INSERT INTO `x2_orders` VALUES ('201902281520465', '初级经济法+实务套餐', '13552525371', '[{\"subjectid\":\"4\",\"basicid\":\"2\",\"basicname\":\"初级经济法\",\"time\":\"366\"},{\"subjectid\":\"6\",\"basicid\":\"3\",\"basicname\":\"初级实务\",\"time\":\"366\"}]', 'exam', '30.04', '1551338423', '2', '', 'redrangon', '0', 'coin');
INSERT INTO `x2_orders` VALUES ('201902281526651', '初级经济法+实务套餐', '13552525371', '[{\"subjectid\":\"4\",\"basicid\":\"2\",\"basicname\":\"初级经济法\",\"time\":\"366\"},{\"subjectid\":\"6\",\"basicid\":\"3\",\"basicname\":\"初级实务\",\"time\":\"366\"}]', 'exam', '30.04', '1551338781', '2', '', 'redrangon', '0', 'coin');
INSERT INTO `x2_orders` VALUES ('201902281529122', '初级经济法+实务套餐', '13552525371', '[{\"subjectid\":\"4\",\"basicid\":\"2\",\"basicname\":\"初级经济法\",\"time\":\"366\"},{\"subjectid\":\"6\",\"basicid\":\"3\",\"basicname\":\"初级实务\",\"time\":\"366\"}]', 'exam', '30.04', '1551338968', '2', '', 'redrangon', '0', 'coin');
INSERT INTO `x2_orders` VALUES ('201902281531159', '初级经济法+实务套餐', '13552525371', '[{\"subjectid\":\"4\",\"basicid\":\"2\",\"basicname\":\"初级经济法\",\"time\":\"366\"},{\"subjectid\":\"6\",\"basicid\":\"3\",\"basicname\":\"初级实务\",\"time\":\"366\"}]', 'exam', '30.04', '1551339065', '2', '', 'redrangon', '0', 'coin');
INSERT INTO `x2_orders` VALUES ('201902281534530', '初级经济法+实务套餐', '13552525371', '[{\"subjectid\":\"4\",\"basicid\":\"2\",\"basicname\":\"初级经济法\",\"time\":\"366\"},{\"subjectid\":\"6\",\"basicid\":\"3\",\"basicname\":\"初级实务\",\"time\":\"366\"}]', 'exam', '30.04', '1551339280', '2', '', 'redrangon', '0', 'coin');
INSERT INTO `x2_orders` VALUES ('201903011201277', '初级经济法+实务套餐', '13552525371', '[{\"subjectid\":\"4\",\"basicid\":\"2\",\"basicname\":\"初级经济法\",\"time\":\"366\"},{\"subjectid\":\"6\",\"basicid\":\"3\",\"basicname\":\"初级实务\",\"time\":\"366\"}]', 'exam', '30.04', '1551412863', '2', '', 'redrangon', '0', 'coin');
INSERT INTO `x2_orders` VALUES ('201903012054565', '初级经济法+实务套餐', '18568263814', '[{\"subjectid\":\"4\",\"basicid\":\"2\",\"basicname\":\"初级经济法\",\"time\":\"366\"},{\"subjectid\":\"6\",\"basicid\":\"3\",\"basicname\":\"初级实务\",\"time\":\"366\"}]', 'exam', '30.04', '1551444879', '2', '', 'redrangon', '0', 'coin');
INSERT INTO `x2_orders` VALUES ('201903031633222', '初级经济法+实务套餐', '15868263814', '[{\"subjectid\":\"4\",\"basicid\":\"2\",\"basicname\":\"初级经济法\",\"time\":\"366\"},{\"subjectid\":\"6\",\"basicid\":\"3\",\"basicname\":\"初级实务\",\"time\":\"366\"}]', 'exam', '30.04', '1551602027', '2', '', 'redrangon', '0', 'coin');
INSERT INTO `x2_orders` VALUES ('201903031743975', '代理手动充值', '', '[]', 'offline', '500.00', '1551606204', '2', '', '', '0', '');
INSERT INTO `x2_orders` VALUES ('201903031745689', '代理手动充值', '', '[]', 'offline', '-1000.00', '1551606316', '2', '', '', '0', '');
INSERT INTO `x2_orders` VALUES ('201903041046771', '代理手动充值', 'redrangon', '[]', 'offline', '500.00', '1551667563', '2', '', '', '0', '');

-- ----------------------------
-- Table structure for `x2_papers`
-- ----------------------------
DROP TABLE IF EXISTS `x2_papers`;
CREATE TABLE `x2_papers` (
  `paperid` int(11) NOT NULL AUTO_INCREMENT,
  `papername` varchar(72) NOT NULL,
  `papersubject` int(11) NOT NULL,
  `papersetting` text NOT NULL,
  `paperquestions` mediumtext NOT NULL,
  `papertype` tinyint(4) NOT NULL,
  `paperauthor` varchar(48) NOT NULL,
  `papertime` int(11) NOT NULL,
  `paperdecider` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`paperid`),
  KEY `papersubject` (`papersubject`),
  KEY `papertype` (`papertype`),
  KEY `paperauthor` (`paperauthor`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of x2_papers
-- ----------------------------
INSERT INTO `x2_papers` VALUES ('8', '测试试卷', '9', '{\"papertime\":\"60\",\"comfrom\":\"\",\"score\":\"100\",\"passscore\":\"60\",\"questypelite\":{\"DXT\":\"1\",\"MDXT\":\"1\",\"BDXT\":\"1\",\"PDT\":\"1\",\"WDT\":\"1\"},\"scalemodel\":\"0\",\"questype\":{\"DXT\":{\"number\":\"1\",\"score\":\"100\",\"describe\":\"\",\"easynumber\":\"1\",\"middlenumber\":\"0\",\"hardnumber\":\"0\"},\"MDXT\":{\"number\":\"0\",\"score\":\"0\",\"describe\":\"\",\"easynumber\":\"0\",\"middlenumber\":\"0\",\"hardnumber\":\"0\"},\"BDXT\":{\"number\":\"0\",\"score\":\"0\",\"describe\":\"\",\"easynumber\":\"0\",\"middlenumber\":\"0\",\"hardnumber\":\"0\"},\"PDT\":{\"number\":\"0\",\"score\":\"0\",\"describe\":\"\",\"easynumber\":\"0\",\"middlenumber\":\"0\",\"hardnumber\":\"0\"},\"WDT\":{\"number\":\"0\",\"score\":\"0\",\"describe\":\"\",\"easynumber\":\"0\",\"middlenumber\":\"0\",\"hardnumber\":\"0\"}}}', '', '1', '', '1564541653', '0');
INSERT INTO `x2_papers` VALUES ('6', '测试手工组卷', '6', '{\"papertime\":\"60\",\"comfrom\":\"本地\",\"score\":\"100\",\"passscore\":\"60\",\"questypelite\":{\"DXT\":\"1\",\"PDT\":\"1\",\"BDXT\":\"1\",\"MDXT\":\"1\"},\"questype\":{\"PDT\":{\"number\":\"10\",\"score\":\"5\",\"describe\":\"\"},\"BDXT\":{\"number\":\"0\",\"score\":\"0\",\"describe\":\"\"},\"MDXT\":{\"number\":\"0\",\"score\":\"0\",\"describe\":\"\"},\"DXT\":{\"number\":\"10\",\"score\":\"5\",\"describe\":\"\"}}}', '{\"PDT\":{\"questions\":\"\",\"rowsquestions\":\"\"},\"BDXT\":{\"questions\":\"\",\"rowsquestions\":\"\"},\"MDXT\":{\"questions\":\"\",\"rowsquestions\":\"\"},\"DXT\":{\"questions\":\"\",\"rowsquestions\":\"\"}}', '2', '', '1544795684', '1');
INSERT INTO `x2_papers` VALUES ('7', '测试即时组卷', '6', '{\"papertime\":\"60\",\"comfrom\":\"本地\",\"score\":\"100\",\"passscore\":\"60\",\"questypelite\":{\"BDXT\":\"1\",\"PDT\":\"1\",\"MDXT\":\"1\",\"DXT\":\"1\"},\"questype\":{\"PDT\":{\"number\":\"0\",\"score\":\"0\",\"describe\":\"\"},\"BDXT\":{\"number\":\"10\",\"score\":\"10\",\"describe\":\"\"},\"MDXT\":{\"number\":\"0\",\"score\":\"0\",\"describe\":\"\"},\"DXT\":{\"number\":\"0\",\"score\":\"0\",\"describe\":\"\"}}}', '{\"questions\":[],\"questionrows\":null}', '3', '', '1544796087', '1');

-- ----------------------------
-- Table structure for `x2_points`
-- ----------------------------
DROP TABLE IF EXISTS `x2_points`;
CREATE TABLE `x2_points` (
  `pointid` int(11) NOT NULL AUTO_INCREMENT,
  `pointname` varchar(48) NOT NULL,
  `pointsection` int(11) NOT NULL,
  `pointorder` int(11) NOT NULL,
  `pointintro` text NOT NULL,
  `pointvideo` varchar(240) NOT NULL,
  PRIMARY KEY (`pointid`),
  KEY `pointsection` (`pointsection`),
  KEY `pointorder` (`pointorder`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of x2_points
-- ----------------------------
INSERT INTO `x2_points` VALUES ('3', '分论二', '1', '0', '', '');
INSERT INTO `x2_points` VALUES ('2', '分论一', '1', '0', '', '');
INSERT INTO `x2_points` VALUES ('1', '总论', '1', '3', '&lt;p&gt;总论&lt;/p&gt;', 'files/attach/images/content/20190223/15508874631759.mp4');
INSERT INTO `x2_points` VALUES ('6', '测试', '2', '0', '', '');
INSERT INTO `x2_points` VALUES ('7', '测试知识点', '4', '0', '', '');

-- ----------------------------
-- Table structure for `x2_properties`
-- ----------------------------
DROP TABLE IF EXISTS `x2_properties`;
CREATE TABLE `x2_properties` (
  `ppyid` int(11) NOT NULL AUTO_INCREMENT,
  `ppyname` varchar(60) NOT NULL,
  `ppyfield` varchar(60) NOT NULL,
  `ppymodel` varchar(36) NOT NULL,
  `ppyhtmltype` varchar(48) NOT NULL,
  `ppyaccess` varchar(240) NOT NULL,
  `ppyintro` varchar(240) NOT NULL,
  `ppyproperty` text NOT NULL,
  `ppyvalue` text NOT NULL,
  `ppyislock` int(1) NOT NULL,
  `ppydefault` varchar(240) NOT NULL,
  `ppysource` varchar(240) NOT NULL,
  `ppysystem` tinyint(1) NOT NULL,
  `ppyorder` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ppyid`),
  KEY `ppyfield` (`ppyfield`),
  KEY `ppymodule` (`ppymodel`),
  KEY `ppyislock` (`ppyislock`),
  KEY `ppyorder` (`ppyorder`)
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of x2_properties
-- ----------------------------
INSERT INTO `x2_properties` VALUES ('6', '时间', 'contenttime', 'news', 'text', '-1', '', 'class=form-control datetimepicker normalinput\r\ndata-date-format=yyyy-mm-dd', '', '0', '', '', '0', '6');
INSERT INTO `x2_properties` VALUES ('7', '缩略图', 'contentthumb', 'news', 'thumb', '-1', '', 'class=qq-uploader-selector\r\nstyle=width:30%', '', '0', 'app/core/styles/img/noimage.gif', '', '0', '7');
INSERT INTO `x2_properties` VALUES ('8', '内容', 'contenttext', 'news', 'editor', '-1', '', 'class=pepeditor', '', '0', '', '', '0', '4');
INSERT INTO `x2_properties` VALUES ('9', '简介', 'contentintro', 'news', 'textarea', '-1', '', 'class=form-control', '', '0', '', '', '0', '5');
INSERT INTO `x2_properties` VALUES ('10', '标题', 'contenttitle', 'news', 'text', '-1', '', 'class=form-control', '', '0', '', '', '0', '8');
INSERT INTO `x2_properties` VALUES ('11', '模型', 'contentmodelcode', 'news', 'hidden', '-1', '', '', '', '0', '', '', '0', '0');
INSERT INTO `x2_properties` VALUES ('12', '发布人', 'contentauthor', 'news', 'hidden', '-1', '', '', '', '0', '', '', '1', '0');
INSERT INTO `x2_properties` VALUES ('19', '分类', 'contentcatid', 'news', 'select', '-1', '', 'refUrl=index.php?content-master-ajax-getchildcategory&amp;catid={value}\r\nclass=autocombox form-control col-xs-3\r\nstyle=width:20%\r\nneedle=needle\r\nmsg=请选择分类', '请选择分类=', '0', '', '[&quot;catname&quot;,&quot;catid&quot;],&quot;default&quot;,&quot;category&quot;,[[&quot;AND&quot;,&quot;catapp = \\\'content\\\'&quot;],[&quot;AND&quot;,&quot;catparent = 0&quot;]],&quot;catorder desc,catid desc&quot;', '1', '9');
INSERT INTO `x2_properties` VALUES ('13', '用户名', 'username', 'webmaster', 'text', '-1', '', 'class=form-control normalinput\r\nneedle=needle\r\ndisabled', '', '0', '', '', '1', '6');
INSERT INTO `x2_properties` VALUES ('14', '手机号码', 'userphone', 'webmaster', 'text', '[\"-1\"]', '', 'class=form-control normalinput\r\nneedle=needle\r\nmsg=请填写手机号码\r\ndisabled', '', '0', '', '', '1', '5');
INSERT INTO `x2_properties` VALUES ('15', '邮箱', 'useremail', 'webmaster', 'text', '[\"-1\"]', '', 'class=form-control normalinput\r\nneedle=needle\r\nmsg=请填写邮箱\r\ndisabled', '', '0', '', '', '1', '4');
INSERT INTO `x2_properties` VALUES ('16', '性别', 'usersex', 'webmaster', 'radio', '', '', '', '男=男\r\n女=女', '0', '男', '', '0', '1');
INSERT INTO `x2_properties` VALUES ('17', '用户密码', 'userpassword', 'webmaster', 'text', '-1', '', 'type=password\r\nclass=form-control normalinput\r\nplaceholder=不修改密码请留空', '', '0', '', '', '1', '3');
INSERT INTO `x2_properties` VALUES ('18', '用户组', 'usergroupcode', 'webmaster', 'select', '-1', '', 'class=form-control normalinput', '', '0', '', '[&quot;groupname&quot;,&quot;groupcode&quot;],&quot;default&quot;,[&quot;groups&quot;],[],&quot;groupid desc&quot;', '1', '2');
INSERT INTO `x2_properties` VALUES ('20', '视频ID', 'videoid', 'video', 'hidden', '', '', '', '', '0', '', '', '0', '0');
INSERT INTO `x2_properties` VALUES ('21', '所属课程', 'videolesson', 'video', 'hidden', '', '', '', '', '0', '', '', '0', '0');
INSERT INTO `x2_properties` VALUES ('22', '视频名称', 'videoname', 'video', 'text', '', '', 'class=form-control', '', '0', '', '', '0', '9');
INSERT INTO `x2_properties` VALUES ('23', '缩略图', 'videothumb', 'video', 'thumb', '', '', 'class=qq-uploader-selector\r\nstyle=width:30%', '', '0', '', '', '0', '6');
INSERT INTO `x2_properties` VALUES ('24', '简介', 'videointro', 'video', 'editor', '', '', 'class=pepeditor', '', '0', '', '', '0', '5');
INSERT INTO `x2_properties` VALUES ('25', '视频源', 'videopath', 'video', 'videotext', '', '', '', '', '0', '', '', '0', '7');
INSERT INTO `x2_properties` VALUES ('26', '发布时间', 'videotime', 'video', 'text', '', '', 'class=form-control datetimepicker normalinput\r\ndata-date-format=yyyy-mm-dd hh:ii:ss', '', '0', '', '', '0', '8');
INSERT INTO `x2_properties` VALUES ('27', '发布人', 'videoauthor', 'video', 'hidden', '', '', '', '', '0', '', '', '0', '0');
INSERT INTO `x2_properties` VALUES ('28', '权重', 'videoorder', 'video', 'hidden', '', '', '', '', '0', '', '', '0', '0');
INSERT INTO `x2_properties` VALUES ('29', '模型', 'videomodelcode', 'video', 'hidden', '', '', '', '', '0', '', '', '0', '0');
INSERT INTO `x2_properties` VALUES ('30', '用户名', 'username', 'teacher', 'text', '-1', '', 'class=form-control normalinput\r\nneedle=needle\r\ndisabled', '', '0', '', '', '1', '0');
INSERT INTO `x2_properties` VALUES ('31', '手机号码', 'userphone', 'teacher', 'text', '-1', '', 'class=form-control normalinput\r\nneedle=needle\r\nmsg=请填写手机号码\r\ndisabled', '', '0', '', '', '1', '0');
INSERT INTO `x2_properties` VALUES ('32', '邮箱', 'useremail', 'teacher', 'text', '-1', '', 'class=form-control normalinput\r\nneedle=needle\r\nmsg=请填写邮箱\r\ndisabled', '', '0', '', '', '1', '0');
INSERT INTO `x2_properties` VALUES ('33', '用户组', 'usergroupcode', 'teacher', 'select', '-1', '', 'class=form-control normalinput', '', '0', '', '[&quot;groupname&quot;,&quot;groupcode&quot;],&quot;default&quot;,[&quot;groups&quot;],[],&quot;groupid desc&quot;', '1', '0');
INSERT INTO `x2_properties` VALUES ('34', '用户密码', 'userpassword', 'teacher', 'text', '-1', '', 'type=password\r\nclass=form-control normalinput\r\nplaceholder=不修改密码请留空', '', '0', '', '', '1', '0');
INSERT INTO `x2_properties` VALUES ('35', '用户名', 'username', 'agent', 'text', '-1', '', 'class=form-control normalinput\r\nneedle=needle\r\ndisabled', '', '0', '', '', '1', '0');
INSERT INTO `x2_properties` VALUES ('36', '用户名', 'username', 'user', 'text', '-1', '', 'class=form-control normalinput\r\nneedle=needle\r\ndisabled', '', '0', '', '', '1', '0');
INSERT INTO `x2_properties` VALUES ('37', '手机号码', 'userphone', 'agent', 'text', '-1', '', 'class=form-control normalinput\r\nneedle=needle\r\nmsg=请填写手机号码\r\ndisabled', '', '0', '', '', '1', '0');
INSERT INTO `x2_properties` VALUES ('38', '手机号码', 'userphone', 'user', 'text', '-1', '', 'class=form-control normalinput\r\nneedle=needle\r\nmsg=请填写手机号码\r\ndisabled', '', '0', '', '', '1', '0');
INSERT INTO `x2_properties` VALUES ('39', '邮箱', 'useremail', 'user', 'text', '-1', '', 'class=form-control normalinput\r\nneedle=needle\r\nmsg=请填写邮箱\r\ndisabled', '', '0', '', '', '1', '0');
INSERT INTO `x2_properties` VALUES ('40', '邮箱', 'useremail', 'agent', 'text', '-1', '', 'class=form-control normalinput\r\nneedle=needle\r\nmsg=请填写邮箱\r\ndisabled', '', '0', '', '', '1', '0');
INSERT INTO `x2_properties` VALUES ('41', '用户组', 'usergroupcode', 'agent', 'select', '-1', '', 'class=form-control normalinput', '', '0', '', '[&quot;groupname&quot;,&quot;groupcode&quot;],&quot;default&quot;,[&quot;groups&quot;],[],&quot;groupid desc&quot;', '1', '0');
INSERT INTO `x2_properties` VALUES ('42', '用户组', 'usergroupcode', 'user', 'select', '-1', '', 'class=form-control normalinput', '', '0', '', '[&quot;groupname&quot;,&quot;groupcode&quot;],&quot;default&quot;,[&quot;groups&quot;],[],&quot;groupid desc&quot;', '1', '0');
INSERT INTO `x2_properties` VALUES ('43', '用户密码', 'userpassword', 'agent', 'text', '', '', 'type=password\r\nclass=form-control normalinput\r\nplaceholder=不修改密码请留空', '', '0', '', '', '1', '0');
INSERT INTO `x2_properties` VALUES ('44', '用户密码', 'userpassword', 'user', 'text', '', '', 'type=password\r\nclass=form-control normalinput\r\nplaceholder=不修改密码请留空', '', '0', '', '', '1', '0');
INSERT INTO `x2_properties` VALUES ('45', '折扣率', 'userrate', 'agent', 'text', '-1', '', 'class=form-control normalinput', '', '0', '', '', '1', '0');
INSERT INTO `x2_properties` VALUES ('46', '余额', 'usercoin', 'agent', 'text', '-1', '', 'class=form-control normalinput', '', '0', '', '', '1', '0');

-- ----------------------------
-- Table structure for `x2_questionrows`
-- ----------------------------
DROP TABLE IF EXISTS `x2_questionrows`;
CREATE TABLE `x2_questionrows` (
  `qrid` int(11) NOT NULL AUTO_INCREMENT,
  `qrquestion` text NOT NULL,
  `qrtype` varchar(12) DEFAULT NULL,
  `qrlevel` tinyint(4) NOT NULL,
  `qrsubject` int(11) DEFAULT NULL,
  `qrpoints` varchar(48) NOT NULL,
  `qrnumber` tinyint(4) DEFAULT NULL,
  `qrstatus` tinyint(1) DEFAULT NULL,
  `qrauthor` varchar(48) DEFAULT NULL,
  `qrtime` int(11) DEFAULT NULL,
  PRIMARY KEY (`qrid`),
  KEY `qrtype` (`qrtype`),
  KEY `qrlevel` (`qrlevel`),
  KEY `qrpoints` (`qrpoints`),
  KEY `qrstatus` (`qrstatus`),
  KEY `qrauthor` (`qrauthor`),
  KEY `qrtime` (`qrtime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of x2_questionrows
-- ----------------------------

-- ----------------------------
-- Table structure for `x2_questions`
-- ----------------------------
DROP TABLE IF EXISTS `x2_questions`;
CREATE TABLE `x2_questions` (
  `questionid` int(11) NOT NULL AUTO_INCREMENT,
  `question` text NOT NULL,
  `questiontype` varchar(12) NOT NULL,
  `questionselect` text NOT NULL,
  `questionselectnumber` tinyint(4) NOT NULL,
  `questionanswer` text NOT NULL,
  `questionintro` text NOT NULL,
  `questionlevel` tinyint(4) NOT NULL,
  `questionsubject` int(11) NOT NULL,
  `questionpoints` varchar(48) NOT NULL,
  `questionparent` int(11) NOT NULL,
  `questionorder` tinyint(4) NOT NULL,
  `questionstatus` tinyint(4) NOT NULL,
  `questionauthor` varchar(48) DEFAULT NULL,
  `questiontime` int(11) DEFAULT NULL,
  PRIMARY KEY (`questionid`),
  KEY `questionpoints` (`questionpoints`),
  KEY `questionparent` (`questionparent`),
  KEY `questionlevel` (`questionlevel`),
  KEY `questionstatus` (`questionstatus`),
  KEY `questionorder` (`questionorder`),
  KEY `questionsubject` (`questionsubject`),
  KEY `questiontype` (`questiontype`),
  KEY `questionauthor` (`questionauthor`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of x2_questions
-- ----------------------------
INSERT INTO `x2_questions` VALUES ('1', '&lt;p&gt;测试知识点试题&lt;/p&gt;', 'DXT', '&lt;p&gt;大师傅士大夫&lt;/p&gt;\r\n\r\n&lt;hr /&gt;\r\n&lt;p&gt;士大夫大师傅士大夫撒旦&lt;/p&gt;\r\n\r\n&lt;hr /&gt;\r\n&lt;p&gt;大师傅士大夫士大夫撒旦&lt;/p&gt;\r\n\r\n&lt;hr /&gt;\r\n&lt;p&gt;士大夫士大夫大师傅&lt;/p&gt;', '4', 'A', '', '1', '9', '7', '0', '0', '1', '', '1564541628');
INSERT INTO `x2_questions` VALUES ('2', '&lt;p&gt;啊实打实大苏打2&lt;/p&gt;', 'DXT', '&lt;p&gt;大幅度的方式&lt;/p&gt;\r\n\r\n&lt;hr /&gt;\r\n&lt;p&gt;撒旦发生大法师的&lt;/p&gt;\r\n\r\n&lt;hr /&gt;\r\n&lt;p&gt;撒旦飞洒地方撒旦&lt;/p&gt;\r\n\r\n&lt;hr /&gt;\r\n&lt;p&gt;阿斯顿发射点&lt;/p&gt;', '4', 'A', '', '1', '9', '7', '0', '0', '1', '', '1564542243');

-- ----------------------------
-- Table structure for `x2_questypes`
-- ----------------------------
DROP TABLE IF EXISTS `x2_questypes`;
CREATE TABLE `x2_questypes` (
  `questid` int(11) NOT NULL AUTO_INCREMENT,
  `questype` varchar(60) NOT NULL DEFAULT '',
  `questcode` varchar(12) DEFAULT NULL,
  `questsort` int(1) NOT NULL DEFAULT '0',
  `questchoice` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`questid`),
  UNIQUE KEY `questcode` (`questcode`),
  KEY `questchoice` (`questchoice`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of x2_questypes
-- ----------------------------
INSERT INTO `x2_questypes` VALUES ('1', '单选题', 'DXT', '0', '1');
INSERT INTO `x2_questypes` VALUES ('2', '多选题', 'MDXT', '0', '2');
INSERT INTO `x2_questypes` VALUES ('3', '不定项选择', 'BDXT', '0', '3');
INSERT INTO `x2_questypes` VALUES ('4', '判断题', 'PDT', '0', '4');
INSERT INTO `x2_questypes` VALUES ('5', '简答题', 'WDT', '1', '0');

-- ----------------------------
-- Table structure for `x2_records`
-- ----------------------------
DROP TABLE IF EXISTS `x2_records`;
CREATE TABLE `x2_records` (
  `recordid` int(11) NOT NULL AUTO_INCREMENT,
  `recordusername` varchar(48) NOT NULL,
  `recordnumber` mediumtext NOT NULL,
  `recordright` mediumtext NOT NULL,
  `recordwrong` mediumtext NOT NULL,
  PRIMARY KEY (`recordid`),
  KEY `recordusername` (`recordusername`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of x2_records
-- ----------------------------

-- ----------------------------
-- Table structure for `x2_sections`
-- ----------------------------
DROP TABLE IF EXISTS `x2_sections`;
CREATE TABLE `x2_sections` (
  `sectionid` int(11) NOT NULL AUTO_INCREMENT,
  `sectionname` varchar(48) NOT NULL,
  `sectionsubject` int(11) NOT NULL,
  `sectionorder` tinyint(4) DEFAULT NULL,
  `sectionintro` text,
  PRIMARY KEY (`sectionid`),
  KEY `sectionsubject` (`sectionsubject`),
  KEY `sectionorder` (`sectionorder`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of x2_sections
-- ----------------------------
INSERT INTO `x2_sections` VALUES ('1', '总论', '6', '2', '&lt;p&gt;初级经济学总论&lt;/p&gt;');
INSERT INTO `x2_sections` VALUES ('2', '经济法初级', '6', '1', '&lt;p&gt;经济法初级&lt;/p&gt;');
INSERT INTO `x2_sections` VALUES ('3', '', '0', '0', '');
INSERT INTO `x2_sections` VALUES ('4', '测试章节', '9', '0', '');

-- ----------------------------
-- Table structure for `x2_subjects`
-- ----------------------------
DROP TABLE IF EXISTS `x2_subjects`;
CREATE TABLE `x2_subjects` (
  `subjectid` int(11) NOT NULL AUTO_INCREMENT,
  `subjectname` varchar(48) NOT NULL,
  `subjectdb` varchar(36) NOT NULL,
  `subjecttrid` int(11) NOT NULL,
  `subjectsetting` text NOT NULL,
  `subjectintro` text NOT NULL,
  PRIMARY KEY (`subjectid`),
  KEY `subjectname` (`subjectname`),
  KEY `subjecttrid` (`subjecttrid`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of x2_subjects
-- ----------------------------
INSERT INTO `x2_subjects` VALUES ('4', '初级经济法', 'default', '2', '[\"MDXT\",\"DXT\"]', '&lt;p&gt;初级经济法&lt;/p&gt;');
INSERT INTO `x2_subjects` VALUES ('5', '初级会计基础', 'default', '2', '[\"MDXT\",\"DXT\"]', '&lt;p&gt;初级会计基础&lt;/p&gt;');
INSERT INTO `x2_subjects` VALUES ('6', '初级经济法测试', 'demo', '2', '[\"DXT\",\"MDXT\",\"BDXT\",\"PDT\",\"WDT\"]', '&lt;p&gt;初级经济法&lt;/p&gt;');
INSERT INTO `x2_subjects` VALUES ('7', '英语四级', 'demo', '3', '[\"DXT\",\"MDXT\",\"BDXT\",\"PDT\"]', '&lt;p&gt;英语四级&lt;/p&gt;');
INSERT INTO `x2_subjects` VALUES ('8', '英语六级', 'demo', '3', '[\"DXT\",\"MDXT\",\"BDXT\",\"PDT\"]', '&lt;p&gt;英语六级&lt;/p&gt;');
INSERT INTO `x2_subjects` VALUES ('9', '驾照', 'default', '4', '[\"DXT\",\"MDXT\",\"BDXT\",\"PDT\",\"WDT\"]', '');

-- ----------------------------
-- Table structure for `x2_training`
-- ----------------------------
DROP TABLE IF EXISTS `x2_training`;
CREATE TABLE `x2_training` (
  `trid` int(11) NOT NULL AUTO_INCREMENT,
  `trname` varchar(48) NOT NULL,
  `trtime` int(11) NOT NULL,
  `trthumb` varchar(120) NOT NULL,
  `trtext` text NOT NULL,
  `trintro` text NOT NULL,
  `trpackage` text NOT NULL,
  PRIMARY KEY (`trid`),
  KEY `trid` (`trid`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of x2_training
-- ----------------------------
INSERT INTO `x2_training` VALUES ('2', '初级会计', '1562342400', 'files/attach/images/content/20190313/15524641654595.jpg', '', '初级会计', '初级经济法+实务套餐:4-2,6-3:366:150.2');
INSERT INTO `x2_training` VALUES ('3', '英语四六级', '1552406400', 'files/attach/images/content/20190313/15524641402461.jpg', '', '英语四六级，简称CET4,CET6。一般要求本科毕业大学生必须过英语四级。', '');
INSERT INTO `x2_training` VALUES ('4', '托福GRE', '1552406400', 'files/attach/images/content/20190313/15524638924503.jpg', '&lt;p&gt;2019年初级会计报名时间2018年11月1日-11月30日，考试2019年5月11日-5月19日进行，经济法基础科目的考试时长为1.5小时，初级会计实务科目的考试时长为2小时，两个科目连续考试，时间不能混用。&lt;/p&gt;', '2019年初级会计报名时间2018年11月1日-11月30日，考试2019年5月11日-5月19日进行，经济法基础科目的考试时长为1.5小时，初级会计实务科目的考试时长为2小时，两个科目连续考试，时间不能混用。', '');

-- ----------------------------
-- Table structure for `x2_users`
-- ----------------------------
DROP TABLE IF EXISTS `x2_users`;
CREATE TABLE `x2_users` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(48) NOT NULL,
  `userphone` varchar(24) NOT NULL,
  `useremail` varchar(48) NOT NULL,
  `userpassword` varchar(32) NOT NULL,
  `useropenid` varchar(32) NOT NULL,
  `usernick` varchar(72) NOT NULL,
  `userrealname` varchar(72) NOT NULL,
  `usergroupcode` varchar(24) NOT NULL,
  `usersex` varchar(9) NOT NULL,
  `userpassport` varchar(36) NOT NULL,
  `usercoin` decimal(10,2) NOT NULL,
  `userregtime` int(11) NOT NULL,
  `userrate` int(11) NOT NULL,
  `useragent` varchar(48) NOT NULL,
  `userstatus` tinyint(1) NOT NULL,
  PRIMARY KEY (`userid`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `userphone` (`userphone`),
  UNIQUE KEY `useremail` (`useremail`) USING BTREE,
  KEY `usergroupcode` (`usergroupcode`),
  KEY `useragent` (`useragent`),
  KEY `useropenid` (`useropenid`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of x2_users
-- ----------------------------
INSERT INTO `x2_users` VALUES ('1', 'peadmin', '18738317214', 'peadmin@phpems.net', '244153a2599be7685c32d2281f57ae67', '', '火眼', '哼哼', 'webmaster', '男', '410782198502140077', '0.00', '0', '0', '', '0');
INSERT INTO `x2_users` VALUES ('2', 'redrangon', '18578263814', '18568263814@139.com', '96e79218965eb72c92a549dd5a330112', '', '', '', 'agent', '男', '', '9699.60', '1547465421', '20', '', '0');
INSERT INTO `x2_users` VALUES ('3', '18568263814', '18568263814', '18568263814@qq.com', '96e79218965eb72c92a549dd5a330112', '', '', '', 'teacher', '', '', '0.00', '1550150387', '0', '', '0');
INSERT INTO `x2_users` VALUES ('8', 'ppstream', '15800158000', '15800158000@139.com', '9db06bcff9248837f86d1a6bcf41c9e7', '', '', '', '', '', '', '0.00', '1555860602', '0', '', '0');
INSERT INTO `x2_users` VALUES ('9', 'cxk', '18703729411', '123456@qq.com', 'e10adc3949ba59abbe56e057f20f883e', '', '', '', 'webmaster', '', '', '0.00', '1556242644', '0', '', '0');
INSERT INTO `x2_users` VALUES ('10', 'tester', '15012325421', '15012325421@139.com', '96e79218965eb72c92a549dd5a330112', '', '', '', 'user', '', '', '0.00', '1557539406', '0', '', '0');
INSERT INTO `x2_users` VALUES ('11', 'tester2', '15365452145', '15365452145@163.com', '96e79218965eb72c92a549dd5a330112', '', '', '', 'user', '', '', '0.00', '1557539429', '0', '', '0');

-- ----------------------------
-- Table structure for `x2_videos`
-- ----------------------------
DROP TABLE IF EXISTS `x2_videos`;
CREATE TABLE `x2_videos` (
  `videoid` int(11) NOT NULL AUTO_INCREMENT,
  `videolesson` int(11) NOT NULL,
  `videoname` varchar(120) NOT NULL,
  `videomodelcode` varchar(255) DEFAULT NULL,
  `videothumb` varchar(240) NOT NULL,
  `videointro` text NOT NULL,
  `videopath` varchar(240) NOT NULL,
  `videotime` int(11) NOT NULL,
  `videoauthor` varchar(48) NOT NULL,
  `videoorder` int(11) NOT NULL,
  PRIMARY KEY (`videoid`),
  KEY `videolesson` (`videolesson`),
  KEY `videoauthor` (`videoauthor`),
  KEY `videoorder` (`videoorder`),
  KEY `videomodelcode` (`videomodelcode`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of x2_videos
-- ----------------------------
INSERT INTO `x2_videos` VALUES ('1', '1', '第一章会计法', 'video', 'files/attach/images/content/20190118/15478149647937.jpg', '&lt;p&gt;第一章会计法&lt;/p&gt;', '//player.alicdn.com/video/aliyunmedia.mp4', '1547813317', '', '7');
INSERT INTO `x2_videos` VALUES ('2', '1', '第二章经济法', 'video', 'files/attach/images/content/20190119/15479083421925.jpg', '', '//player.alicdn.com/video/aliyunmedia.mp4', '1547908321', '', '6');
INSERT INTO `x2_videos` VALUES ('3', '1', '第三章初级出纳', 'video', 'files/attach/images/content/20190119/15479096979202.jpg', '', '//player.alicdn.com/video/aliyunmedia.mp4', '1547909679', '', '5');
INSERT INTO `x2_videos` VALUES ('4', '1', '第四章初级财务账目', 'video', 'files/attach/images/content/20190119/15479097311647.jpg', '', 'http://img.ksbbs.com/asset/Mon_1703/05cacb4e02f9d9e.mp4', '1547909711', '', '4');
INSERT INTO `x2_videos` VALUES ('5', '1', '第五章会计电算化', 'video', 'files/attach/images/content/20190119/15479097618767.jpg', '', 'http://img.ksbbs.com/asset/Mon_1703/05cacb4e02f9d9e.mp4', '1547909742', '', '3');
INSERT INTO `x2_videos` VALUES ('6', '1', '第六章会计分录', 'video', 'files/attach/images/content/20190119/15479099662632.jpg', '', '//player.alicdn.com/video/aliyunmedia.mp4', '1547909953', '', '2');
INSERT INTO `x2_videos` VALUES ('7', '1', '第七章税务', 'video', 'files/attach/images/content/20190119/15479099896475.jpg', '&lt;p&gt;第七章税务&lt;/p&gt;', '//player.alicdn.com/video/aliyunmedia.mp4', '1547909972', '', '1');
