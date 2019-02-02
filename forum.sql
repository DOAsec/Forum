-- Adminer 4.2.3 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `accounts`;
CREATE TABLE `accounts` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `refid` bigint(20) NOT NULL DEFAULT '0',
  `email` text NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `avatar` text NOT NULL,
  `rankid` int(11) NOT NULL DEFAULT '1',
  `groupid` int(11) NOT NULL DEFAULT '1',
  `isbanned` int(11) NOT NULL DEFAULT '0',
  `postcount` int(11) NOT NULL DEFAULT '0',
  `regip` text NOT NULL,
  `regtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `invitecodes` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `rankid` (`rankid`),
  KEY `groupid` (`groupid`),
  CONSTRAINT `accounts_ibfk_1` FOREIGN KEY (`rankid`) REFERENCES `ranks` (`id`),
  CONSTRAINT `accounts_ibfk_2` FOREIGN KEY (`groupid`) REFERENCES `groups` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `accounts` (`id`, `refid`, `email`, `username`, `password`, `avatar`, `rankid`, `groupid`, `isbanned`, `postcount`, `regip`, `regtime`, `invitecodes`) VALUES
(1,	0,	'root@forum',	'root',	'aaaaaaaaaaaaaaaaaaaaaaaaaaaa',	'',	5,	4,	0,	5,	'127.0.0.1',	'2019-02-02 06:36:12',	999),
(2,	1,	'test@test.cc',	'Testing',	'toor',	'',	2,	1,	0,	3,	'127.0.0.1',	'2019-02-02 06:35:54',	0),
(3,	0,	'test@example.com',	'UsErNaMe',	'asdasdasasdasd',	'',	1,	1,	0,	0,	'127.0.0.1',	'2019-02-01 03:29:12',	0);

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `safename` text NOT NULL,
  `description` mediumtext NOT NULL,
  `thumbnail` text NOT NULL,
  `parent` int(11) NOT NULL DEFAULT '0',
  `postcount` int(11) NOT NULL,
  `threadcount` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `categories` (`id`, `name`, `safename`, `description`, `thumbnail`, `parent`, `postcount`, `threadcount`) VALUES
(1,	'General',	'general',	'',	'',	0,	777,	666),
(2,	'Tech',	'tech',	'',	'',	0,	1408,	237),
(3,	'Market',	'market',	'Buy here, sell if approved.',	'',	0,	13,	1),
(4,	'Announcements',	'announce',	'Site announcements.',	'',	1,	9001,	451),
(5,	'General',	'generaldiscussion',	'General discussion.',	'',	1,	-6,	12),
(6,	'Example',	'example1',	'Long description text here as a placeholder to show variance across forum categories and how the css styling handles it. Long description text here as a placeholder to show variance across forum categories and how the css styling handles it. Long description text here as a placeholder to show variance across forum categories and how the css styling handles it.',	'',	1,	666,	-666),
(7,	'Code',	'code',	'Discuss and share programming knowledge here.',	'',	2,	9001,	1),
(8,	'Malware',	'malware',	'Malware analysis and discussion.',	'',	2,	101,	5),
(9,	'Example',	'Example',	'Example/placeholder text.',	'',	3,	6,	1),
(10,	'subsubcattest',	'subsubcattest',	'000000000000000000000000000000000000000',	'',	4,	50,	6),
(11,	'Example',	'Placeholder text',	'',	'',	5,	0,	0);

DROP TABLE IF EXISTS `groups`;
CREATE TABLE `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `color` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `groups` (`id`, `name`, `color`) VALUES
(1,	'newbie',	'gray'),
(2,	'',	''),
(3,	'1337',	'limegreen'),
(4,	'Owner',	'limegreen');

DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `approved` int(11) NOT NULL DEFAULT '1',
  `accountid` bigint(20) NOT NULL,
  `threadid` bigint(20) NOT NULL,
  `body` longtext NOT NULL,
  `timestamp` bigint(20) NOT NULL,
  `edittimestamp` bigint(20) DEFAULT '0',
  `editaccountid` bigint(20) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `accountid` (`accountid`),
  KEY `editaccountid` (`editaccountid`),
  KEY `threadid` (`threadid`),
  CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`accountid`) REFERENCES `accounts` (`id`),
  CONSTRAINT `posts_ibfk_3` FOREIGN KEY (`editaccountid`) REFERENCES `accounts` (`id`),
  CONSTRAINT `posts_ibfk_4` FOREIGN KEY (`threadid`) REFERENCES `threads` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `posts` (`id`, `approved`, `accountid`, `threadid`, `body`, `timestamp`, `edittimestamp`, `editaccountid`) VALUES
(1,	1,	1,	1,	'aaa',	0,	0,	1),
(2,	1,	2,	1,	'THE SKY JUST BSOD\'d',	4,	1000,	2),
(3,	1,	2,	1,	'THE SKY JUST BSOD\'d',	4,	4,	2),
(4,	1,	2,	1,	'THE SKY JUST BSOD\'d',	9,	9,	2),
(5,	1,	2,	1,	'THE SKY JUST BSOD\'d',	6,	6,	2),
(6,	1,	2,	1,	'THE SKY JUST BSOD\'d',	4,	4,	2),
(7,	1,	2,	1,	'THE SKY JUST BSOD\'d',	4,	4,	2),
(8,	1,	2,	1,	'THE SKY JUST BSOD\'d',	6,	6,	2),
(9,	1,	2,	1,	'THE SKY JUST BSOD\'d',	4,	4,	2),
(10,	1,	2,	1,	'THE SKY JUST BSOD\'d',	6,	6,	2),
(11,	1,	2,	1,	'THE SKY JUST BSOD\'d',	9,	9,	2),
(12,	1,	2,	1,	'THE SKY JUST BSOD\'d',	9,	9,	2);

DROP TABLE IF EXISTS `ranks`;
CREATE TABLE `ranks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `isadmin` int(11) NOT NULL DEFAULT '0',
  `ismoderator` int(11) NOT NULL DEFAULT '0',
  `isvip` int(11) NOT NULL DEFAULT '0',
  `isuser` int(11) NOT NULL DEFAULT '1',
  `color` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `ranks` (`id`, `name`, `isadmin`, `ismoderator`, `isvip`, `isuser`, `color`) VALUES
(1,	'Unverified',	0,	0,	0,	0,	'grey'),
(2,	'User',	0,	0,	0,	1,	'dodgerblue'),
(3,	'VIP',	0,	0,	1,	1,	'gold'),
(4,	'Moderator',	0,	1,	1,	1,	'limegreen'),
(5,	'Administrator',	1,	1,	1,	1,	'red');

DROP TABLE IF EXISTS `threads`;
CREATE TABLE `threads` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `approved` int(11) NOT NULL DEFAULT '1',
  `stickied` int(11) NOT NULL DEFAULT '0',
  `repliescache` int(11) NOT NULL,
  `viewscache` int(11) NOT NULL,
  `categoryid` int(11) NOT NULL,
  `accountid` bigint(20) NOT NULL,
  `subject` text NOT NULL,
  `safesubject` text NOT NULL,
  `body` longtext NOT NULL,
  `timestamp` bigint(20) NOT NULL,
  `edittimestamp` bigint(20) NOT NULL DEFAULT '0',
  `editaccountid` bigint(20) NOT NULL DEFAULT '0',
  `lastposttimestamp` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `categoryid` (`categoryid`),
  KEY `accountid` (`accountid`),
  KEY `editaccountid` (`editaccountid`),
  CONSTRAINT `threads_ibfk_1` FOREIGN KEY (`categoryid`) REFERENCES `categories` (`id`),
  CONSTRAINT `threads_ibfk_2` FOREIGN KEY (`accountid`) REFERENCES `accounts` (`id`),
  CONSTRAINT `threads_ibfk_3` FOREIGN KEY (`editaccountid`) REFERENCES `accounts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `threads` (`id`, `approved`, `stickied`, `repliescache`, `viewscache`, `categoryid`, `accountid`, `subject`, `safesubject`, `body`, `timestamp`, `edittimestamp`, `editaccountid`, `lastposttimestamp`) VALUES
(1,	1,	0,	1,	0,	4,	1,	'Test',	'test',	'First Thread',	0,	0,	1,	0),
(2,	1,	1,	0,	1,	4,	1,	'Test sticky',	'test_sticky',	'We have sticky thread support',	9001,	9001,	1,	9001),
(3,	1,	0,	8,	20,	5,	2,	'TEST',	'test',	'TEEEEESSSSSSSSSSSTTTTTTTTTTT',	99999999,	100000000,	1,	0),
(4,	1,	0,	8,	20,	6,	2,	'Testing',	'testing',	'000000000000000000000000000',	99999999,	100000000,	1,	0),
(5,	1,	0,	8,	20,	11,	2,	'000',	'000',	'000',	99999999,	100000000,	1,	0);

-- 2019-02-02 07:04:14
