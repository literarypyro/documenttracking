-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.0.45-community-nt


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema user_management
--

CREATE DATABASE IF NOT EXISTS user_management;
USE user_management;

--
-- Definition of table `access_phrase`
--

DROP TABLE IF EXISTS `access_phrase`;
CREATE TABLE `access_phrase` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `sequence` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `access_phrase`
--

/*!40000 ALTER TABLE `access_phrase` DISABLE KEYS */;
/*!40000 ALTER TABLE `access_phrase` ENABLE KEYS */;


--
-- Definition of table `division_management`
--

DROP TABLE IF EXISTS `division_management`;
CREATE TABLE `division_management` (
  `division_id` varchar(150) NOT NULL,
  `security_phrase` text NOT NULL,
  `user_no` varchar(45) NOT NULL,
  PRIMARY KEY  (`division_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `division_management`
--

/*!40000 ALTER TABLE `division_management` DISABLE KEYS */;
INSERT INTO `division_management` (`division_id`,`security_phrase`,`user_no`) VALUES 
 ('ADM','admin','2'),
 ('FCD','finance','2'),
 ('IAU','iau','2'),
 ('ED','eng','5'),
 ('OOD','operations','2'),
 ('OGM','OGM','3'),
 ('REC','records','2'),
 ('SDU','sdu','2'),
 ('SSU','safety','2'),
 ('STN','stn','3'),
 ('SUP','support','2'),
 ('TRA','trans','3'),
 ('TREA','treas','2');
/*!40000 ALTER TABLE `division_management` ENABLE KEYS */;


--
-- Definition of table `log_action`
--

DROP TABLE IF EXISTS `log_action`;
CREATE TABLE `log_action` (
  `log_id` int(10) unsigned NOT NULL auto_increment,
  `username` varchar(45) NOT NULL,
  `login` datetime default NULL,
  `logout` datetime default NULL,
  PRIMARY KEY  (`log_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `log_action`
--

/*!40000 ALTER TABLE `log_action` DISABLE KEYS */;
INSERT INTO `log_action` (`log_id`,`username`,`login`,`logout`) VALUES 
 (1,'psilva','2014-02-28 07:44:53','2014-03-04 08:04:21'),
 (2,'psilva','2014-03-03 03:22:47','2014-03-04 08:04:21'),
 (3,'psilva','2014-03-03 06:50:18','2014-03-04 08:04:21'),
 (4,'psilva','2014-03-04 05:59:16','2014-03-04 08:04:21'),
 (5,'mbunite','2014-03-06 04:20:20',NULL),
 (6,'mbunite','2014-03-10 08:09:33',NULL);
/*!40000 ALTER TABLE `log_action` ENABLE KEYS */;


--
-- Definition of table `log_history`
--

DROP TABLE IF EXISTS `log_history`;
CREATE TABLE `log_history` (
  `log_id` int(10) unsigned NOT NULL auto_increment,
  `username` varchar(150) NOT NULL,
  `time` datetime NOT NULL,
  `action` varchar(45) NOT NULL,
  PRIMARY KEY  (`log_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `log_history`
--

/*!40000 ALTER TABLE `log_history` DISABLE KEYS */;
INSERT INTO `log_history` (`log_id`,`username`,`time`,`action`) VALUES 
 (1,'psilva','2014-02-28 07:44:53','login'),
 (2,'psilva','2014-02-28 07:46:18','logout'),
 (3,'psilva','2014-03-03 03:22:47','login'),
 (4,'psilva','2014-03-03 06:50:06','logout'),
 (5,'psilva','2014-03-03 06:50:18','login'),
 (6,'psilva','2014-03-04 05:59:16','login'),
 (7,'psilva','2014-03-04 08:04:21','logout'),
 (8,'','2014-03-04 08:04:55','logout'),
 (9,'mbunite','2014-03-06 04:20:20','login'),
 (10,'mbunite','2014-03-10 08:09:33','login');
/*!40000 ALTER TABLE `log_history` ENABLE KEYS */;


--
-- Definition of table `records_officer`
--

DROP TABLE IF EXISTS `records_officer`;
CREATE TABLE `records_officer` (
  `username` varchar(200) NOT NULL,
  `role` varchar(150) NOT NULL,
  `active` varchar(45) NOT NULL,
  PRIMARY KEY  (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `records_officer`
--

/*!40000 ALTER TABLE `records_officer` DISABLE KEYS */;
INSERT INTO `records_officer` (`username`,`role`,`active`) VALUES 
 ('charity','primary','false'),
 ('psilva','back-up','true');
/*!40000 ALTER TABLE `records_officer` ENABLE KEYS */;


--
-- Definition of table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `username` varchar(500) NOT NULL,
  `password` varchar(45) NOT NULL,
  `firstName` varchar(100) NOT NULL,
  `lastName` varchar(100) NOT NULL,
  `deptCode` varchar(45) NOT NULL,
  PRIMARY KEY  (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`username`,`password`,`firstName`,`lastName`,`deptCode`) VALUES 
 ('charity','cha061178','Charity Anne','Ocampo','REC'),
 ('gpperfinan','gpperfinan','grace','perfinan','IAU'),
 ('mbunite','123456','Marlon','Bunite','SDU'),
 ('psilva','123456','Patrick Simon','Silva','REC');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

--
-- Create schema records
--

CREATE DATABASE IF NOT EXISTS records;
USE records;

--
-- Definition of table `classification`
--

DROP TABLE IF EXISTS `classification`;
CREATE TABLE `classification` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `classification_desc` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=91 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `classification`
--

/*!40000 ALTER TABLE `classification` DISABLE KEYS */;
INSERT INTO `classification` (`id`,`classification_desc`) VALUES 
 (1,'Memorandum'),
 (2,'Letter'),
 (3,'Transmittal'),
 (4,'Office Order'),
 (5,'Leave Application'),
 (6,'PDS'),
 (7,'PES/PER'),
 (8,'Official Business Form'),
 (9,'Monthly Report'),
 (10,'Yearly Report'),
 (12,'Daily Report'),
 (13,'Requisition/Issuance Slip'),
 (14,'Sales/Ridership Report'),
 (15,'Training Memoranda'),
 (16,'Helpdesk Report'),
 (17,'Billing Report'),
 (18,'Maintenance Provider Document'),
 (19,'Request for Inspection'),
 (20,'Inspection and Acceptance Report'),
 (21,'Repair and Maintenance Form'),
 (22,'Access Permits'),
 (23,'Work Permits'),
 (24,'Endorsements'),
 (25,'Audit Observation Report'),
 (26,'OT Slip'),
 (27,'OT Claim'),
 (28,'Voucher'),
 (29,'Payroll'),
 (30,'Requisition Order'),
 (31,'Payslip'),
 (32,'Budget Proposal'),
 (33,'Revenue Documents'),
 (34,'Modified Obligation and Budget Request'),
 (35,'Notice of Meeting'),
 (36,'Application for Monetization'),
 (37,'Statement of Outstanding Investment (PNB)'),
 (38,'Briefing Memorandum'),
 (39,'Special Order'),
 (40,'Department Order'),
 (41,'Resolution'),
 (42,'Department Memorandum Circular'),
 (43,'General Bid Bulletin'),
 (44,'Contract'),
 (45,'Notice to Proceed'),
 (46,'Notice to Award'),
 (47,'DR9'),
 (48,'Control Center Daily Report'),
 (49,'Service Interruption Report'),
 (50,'Incident Report'),
 (51,'Train Availability Report'),
 (52,'Train Revenue Operation (Summary)'),
 (53,'LRV Peak/Off Hour'),
 (54,'Timetable'),
 (55,'Daily Attendance Monitoring Report'),
 (56,'Information Report'),
 (57,'Investigation Report'),
 (58,'Deposits and Collections Summary'),
 (59,'Weekly Report'),
 (60,'Report on Cash Overages and Shortages'),
 (61,'Service Schedule'),
 (62,'DTR Timekeeping'),
 (63,'Utility Report'),
 (64,'SALN Report'),
 (65,'PPMP Report'),
 (66,'Memo to Conduct Training'),
 (67,'Memo to Attend'),
 (68,'Sales Report'),
 (69,'Ridership Report'),
 (70,'Monthly Management Report'),
 (71,'Endorsement to Maintenance Provider'),
 (72,'Letters to Maintenance Provider'),
 (73,'Incident Report from Maintenance Provider'),
 (74,'Service Interruption Report'),
 (75,'Weekly Accomplishment Report'),
 (76,'Preventive Maintenance Schedule'),
 (77,'Letters from Maintenance Provider'),
 (78,'Transmittal to Maintenance Provider'),
 (79,'Train Preparation Report'),
 (80,'Inspection Report of LVRs'),
 (81,'Elevator and Escalator Status Report'),
 (82,'Station AFC Equipment Status Report'),
 (83,'Report of Interim Maintenance Provider'),
 (84,'Journal Entry Voucher'),
 (85,'Disbursement Voucher'),
 (86,'Report of Collections'),
 (87,'Statement of Bank Deposits'),
 (88,'Cashier II Schedule'),
 (89,'Treasury Supervisor Schedule'),
 (90,'OTHER');
/*!40000 ALTER TABLE `classification` ENABLE KEYS */;


--
-- Definition of table `department`
--

DROP TABLE IF EXISTS `department`;
CREATE TABLE `department` (
  `department_code` varchar(100) NOT NULL,
  `department_name` varchar(100) NOT NULL,
  PRIMARY KEY  (`department_code`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `department`
--

/*!40000 ALTER TABLE `department` DISABLE KEYS */;
INSERT INTO `department` (`department_code`,`department_name`) VALUES 
 ('ADM','Administrative Division'),
 ('AFC','Automatic Fare Collection Center'),
 ('FCD','Finance and Comptrollership Division'),
 ('IAU','Internal Audit Unit'),
 ('ED','Engineering Division'),
 ('OOD','Office of the Operations Director'),
 ('OGM','Office of the General Manager'),
 ('REC','Records Officer'),
 ('SDU','Systems Development Unit'),
 ('SSU','Safety and Security'),
 ('STN','Station Division'),
 ('SUP','Support Staff'),
 ('TRA','Transport Division'),
 ('TREA','Treasury Section');
/*!40000 ALTER TABLE `department` ENABLE KEYS */;


--
-- Definition of table `division_classification`
--

DROP TABLE IF EXISTS `division_classification`;
CREATE TABLE `division_classification` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `division_id` varchar(45) collate latin1_general_ci NOT NULL,
  `classification_id` varchar(45) collate latin1_general_ci NOT NULL,
  `subclassification_id` varchar(45) collate latin1_general_ci default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=82 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `division_classification`
--

/*!40000 ALTER TABLE `division_classification` DISABLE KEYS */;
INSERT INTO `division_classification` (`id`,`division_id`,`classification_id`,`subclassification_id`) VALUES 
 (1,'ALL','1',NULL),
 (2,'ALL','2',NULL),
 (3,'ALL','3',NULL),
 (4,'ALL','4',NULL),
 (5,'ALL','5',NULL),
 (6,'FIN','6',NULL),
 (7,'FIN','7',NULL),
 (8,'ALL','8',NULL),
 (9,'ALL','26',NULL),
 (10,'ALL','27',NULL),
 (11,'ALL','29',NULL),
 (12,'ALL','31',NULL),
 (13,'ALL','63',NULL),
 (14,'ALL','64',NULL),
 (15,'ALL','65',NULL),
 (16,'SSU','50',NULL),
 (17,'SSU','56',NULL),
 (18,'SSU','57',NULL),
 (19,'SUP','14',NULL),
 (20,'SUP','16',NULL),
 (21,'SUP','66',NULL),
 (22,'SUP','67',NULL),
 (23,'SUP','68',NULL),
 (24,'SUP','69',NULL),
 (25,'SUP','70',NULL),
 (26,'ENG','71',NULL),
 (27,'ENG','72',NULL),
 (28,'ENG','73',NULL),
 (29,'ENG','76',NULL),
 (30,'ENG','77',NULL),
 (31,'ENG','78',NULL),
 (32,'ALL','62',NULL),
 (33,'TRA','48',NULL),
 (34,'TRA','49',NULL),
 (35,'TRA','50',NULL),
 (36,'TRA','51',NULL),
 (37,'TRA','52',NULL),
 (38,'TRA','53',NULL),
 (39,'TRA','54',NULL),
 (40,'TRA','79',NULL),
 (41,'TRA','80',NULL),
 (42,'TRA','81',NULL),
 (43,'TRA','82',NULL),
 (44,'TRA','83',NULL),
 (45,'TREA','58',NULL),
 (46,'TREA','60',NULL),
 (47,'TREA','88',NULL),
 (48,'TREA','89',NULL),
 (49,'SUP','17',NULL),
 (50,'ENG','19',NULL),
 (51,'ENG','20',NULL),
 (52,'ENG','21',NULL),
 (53,'IAU','25',NULL),
 (54,'TREA','59',NULL),
 (55,'FIN','32',NULL),
 (56,'FIN','33',NULL),
 (57,'FIN','34',NULL),
 (58,'FIN','35',NULL),
 (59,'FIN','36',NULL),
 (60,'FIN','37',NULL),
 (61,'OGM','40',NULL),
 (62,'OGM','41',NULL),
 (63,'OGM','42',NULL),
 (64,'OGM','43',NULL),
 (65,'OGM','44',NULL),
 (66,'OGM','39',NULL),
 (67,'FIN','38',NULL),
 (68,'OGM','24',NULL),
 (69,'ENG','22',NULL),
 (70,'ENG','23',NULL),
 (71,'ENG','47',NULL),
 (72,'TREA','86',NULL),
 (73,'TREA','87',NULL),
 (74,'FIN','84',NULL),
 (75,'FIN','85',NULL),
 (76,'FIN','30',NULL),
 (77,'OGM','45',NULL),
 (78,'OGM','46',NULL),
 (79,'TRA','55',NULL),
 (80,'TRA','74',NULL),
 (81,'ALL','75',NULL);
/*!40000 ALTER TABLE `division_classification` ENABLE KEYS */;


--
-- Definition of table `document`
--

DROP TABLE IF EXISTS `document`;
CREATE TABLE `document` (
  `ref_id` int(10) unsigned NOT NULL auto_increment,
  `originating_office` varchar(500) NOT NULL,
  `originating_name` varchar(100) NOT NULL,
  `document_date` datetime NOT NULL,
  `classification_id` varchar(500) NOT NULL,
  `document_type` varchar(45) NOT NULL,
  `subject` varchar(105) NOT NULL,
  `status` varchar(105) NOT NULL,
  `receive_date` datetime default NULL,
  `security` varchar(150) NOT NULL,
  `sending_office` varchar(45) default NULL,
  `chronId` varchar(1000) default NULL,
  `subclassification_id` varchar(45) default NULL,
  PRIMARY KEY  (`ref_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `document`
--

/*!40000 ALTER TABLE `document` DISABLE KEYS */;
/*!40000 ALTER TABLE `document` ENABLE KEYS */;


--
-- Definition of table `document_access`
--

DROP TABLE IF EXISTS `document_access`;
CREATE TABLE `document_access` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `date_time` datetime NOT NULL,
  `username` varchar(150) NOT NULL,
  `division` varchar(45) NOT NULL,
  `reference_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `document_access`
--

/*!40000 ALTER TABLE `document_access` DISABLE KEYS */;
INSERT INTO `document_access` (`id`,`date_time`,`username`,`division`,`reference_id`) VALUES 
 (1,'2014-03-04 16:04:19','psilva','REC',0);
/*!40000 ALTER TABLE `document_access` ENABLE KEYS */;


--
-- Definition of table `document_actions`
--

DROP TABLE IF EXISTS `document_actions`;
CREATE TABLE `document_actions` (
  `action_code` varchar(45) NOT NULL,
  `action_description` text NOT NULL,
  PRIMARY KEY  (`action_code`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `document_actions`
--

/*!40000 ALTER TABLE `document_actions` DISABLE KEYS */;
INSERT INTO `document_actions` (`action_code`,`action_description`) VALUES 
 ('A','Approved/Signed/Dissemination/Publish'),
 ('B','Reject/Disapprove'),
 ('C','Appropriate Staff Action'),
 ('D','Study/Commend/Recommend'),
 ('E','Process Appropriate Permit'),
 ('F','Prepare Appropriate Permit'),
 ('G','Investigate/Submit Report'),
 ('H','Monitor/Submit Feedback'),
 ('I','Coordinate with Writer for Details'),
 ('J','Reply Directly to Writer'),
 ('K','Draft Reply for the Signing by the General Manager'),
 ('L','Redraft/Rewrite/Retype'),
 ('M','Returned Without Action'),
 ('N','A Matter for that Office'),
 ('O','Legal Opinion'),
 ('P','For Approval/Signing'),
 ('Q','Please see me'),
 ('R','Reference/File'),
 ('S','Finalize draft'),
 ('T','Dispatch'),
 ('U','Information/Notation'),
 ('X','OTHER Action');
/*!40000 ALTER TABLE `document_actions` ENABLE KEYS */;


--
-- Definition of table `document_receipt`
--

DROP TABLE IF EXISTS `document_receipt`;
CREATE TABLE `document_receipt` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `document_id` varchar(45) NOT NULL,
  `reference_id` varchar(150) default NULL,
  `upload_link` varchar(145) default NULL,
  `confirm_time` datetime NOT NULL,
  `download` varchar(45) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `document_receipt`
--

/*!40000 ALTER TABLE `document_receipt` DISABLE KEYS */;
/*!40000 ALTER TABLE `document_receipt` ENABLE KEYS */;


--
-- Definition of table `document_routing`
--

DROP TABLE IF EXISTS `document_routing`;
CREATE TABLE `document_routing` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `reference_no` int(50) unsigned NOT NULL,
  `request_date` datetime NOT NULL,
  `from_name` varchar(45) NOT NULL,
  `from_office` varchar(150) NOT NULL,
  `alter_from` varchar(150) default NULL,
  `alter_position` varchar(150) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `document_routing`
--

/*!40000 ALTER TABLE `document_routing` DISABLE KEYS */;
/*!40000 ALTER TABLE `document_routing` ENABLE KEYS */;


--
-- Definition of table `documents`
--

DROP TABLE IF EXISTS `documents`;
CREATE TABLE `documents` (
  `id` int(11) NOT NULL auto_increment,
  `created_at` datetime default NULL,
  `updated_at` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `documents`
--

/*!40000 ALTER TABLE `documents` DISABLE KEYS */;
/*!40000 ALTER TABLE `documents` ENABLE KEYS */;


--
-- Definition of table `download`
--

DROP TABLE IF EXISTS `download`;
CREATE TABLE `download` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `department_code` varchar(45) NOT NULL,
  `download_time` datetime NOT NULL,
  `username` varchar(45) NOT NULL,
  `reference_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `download`
--

/*!40000 ALTER TABLE `download` DISABLE KEYS */;
/*!40000 ALTER TABLE `download` ENABLE KEYS */;


--
-- Definition of table `forward_copy`
--

DROP TABLE IF EXISTS `forward_copy`;
CREATE TABLE `forward_copy` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `remarks` text,
  `to_department` varchar(150) default NULL,
  `reference_number` varchar(150) NOT NULL,
  `forward_date` datetime NOT NULL,
  `forwarding_office` varchar(45) NOT NULL,
  `document_type` varchar(150) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `forward_copy`
--

/*!40000 ALTER TABLE `forward_copy` DISABLE KEYS */;
/*!40000 ALTER TABLE `forward_copy` ENABLE KEYS */;


--
-- Definition of table `latest_actions`
--

DROP TABLE IF EXISTS `latest_actions`;
CREATE TABLE `latest_actions` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `action_date` datetime NOT NULL,
  `department_code` varchar(45) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `latest_actions`
--

/*!40000 ALTER TABLE `latest_actions` DISABLE KEYS */;
/*!40000 ALTER TABLE `latest_actions` ENABLE KEYS */;


--
-- Definition of table `originating_office`
--

DROP TABLE IF EXISTS `originating_office`;
CREATE TABLE `originating_office` (
  `department_code` int(10) unsigned NOT NULL auto_increment,
  `department_name` text NOT NULL,
  PRIMARY KEY  (`department_code`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `originating_office`
--

/*!40000 ALTER TABLE `originating_office` DISABLE KEYS */;
INSERT INTO `originating_office` (`department_code`,`department_name`) VALUES 
 (1,'Administrative Division'),
 (2,'Automatic Fare Collection Center'),
 (3,'Finance and Comptrollership Division'),
 (4,'Engineering Division'),
 (5,'Office of the Operations Director'),
 (6,'Office of the General Manager'),
 (7,'Safety and Security'),
 (8,'Station Division'),
 (9,'Support Staff'),
 (10,'Transport Division'),
 (11,'Treasury Section'),
 (12,'Records Officer'),
 (13,'OTHER'),
 (14,'Systems Development Unit'),
 (15,'Internal Audit Unit');
/*!40000 ALTER TABLE `originating_office` ENABLE KEYS */;


--
-- Definition of table `originating_officer`
--

DROP TABLE IF EXISTS `originating_officer`;
CREATE TABLE `originating_officer` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(150) NOT NULL,
  `position` varchar(150) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `originating_officer`
--

/*!40000 ALTER TABLE `originating_officer` DISABLE KEYS */;
INSERT INTO `originating_officer` (`id`,`name`,`position`) VALUES 
 (1,'Atty. Al S. Vitangcol','General Manager, DOTC-MRT3'),
 (2,'Eleanor V. Naidas','Chief, Finance and Comptrollership Division'),
 (4,'Charity Ocampo','Records Officer'),
 (5,'Renato Z. San Jose','Director for Operations'),
 (7,'Oscar B. Bongon','Chief, Station Division'),
 (8,'Jose Ric M. Inotorio','Chief, Transport Division'),
 (9,'Misael R. Narca','Chief, Engineering Division'),
 (10,'Ofelia D. Astrera','Chief, Support Staff/AFC Center/Computer Section'),
 (11,'Bernardo Antonio R. Alejandro IIII','OIC, Safety and Security Unit'),
 (12,'Rita M. Caraan','Chief, Administrative Division'),
 (13,'Emmanuel G. Sta. Ana','Chief, Treasury Division'),
 (14,'Jimmy Q. Dableo','Head, Internal Audit Unit'),
 (15,'Marlon C. Bunite','Head, Systems Development Unit');
/*!40000 ALTER TABLE `originating_officer` ENABLE KEYS */;


--
-- Definition of table `reference_increment`
--

DROP TABLE IF EXISTS `reference_increment`;
CREATE TABLE `reference_increment` (
  `ref_id` int(11) NOT NULL auto_increment,
  `year` varchar(200) NOT NULL,
  PRIMARY KEY  (`ref_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reference_increment`
--

/*!40000 ALTER TABLE `reference_increment` DISABLE KEYS */;
INSERT INTO `reference_increment` (`ref_id`,`year`) VALUES 
 (1,'2014');
/*!40000 ALTER TABLE `reference_increment` ENABLE KEYS */;


--
-- Definition of table `routing_targets`
--

DROP TABLE IF EXISTS `routing_targets`;
CREATE TABLE `routing_targets` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `destination_office` varchar(45) NOT NULL,
  `to_name` text,
  `action_id` varchar(500) NOT NULL,
  `status` varchar(45) NOT NULL,
  `remarks` text,
  `routing_id` int(10) unsigned NOT NULL,
  `alter_to` varchar(150) default NULL,
  `alter_position` varchar(150) default NULL,
  PRIMARY KEY  (`id`),
  KEY `routing_id` (`routing_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `routing_targets`
--

/*!40000 ALTER TABLE `routing_targets` DISABLE KEYS */;
/*!40000 ALTER TABLE `routing_targets` ENABLE KEYS */;


--
-- Definition of table `routing_uploads`
--

DROP TABLE IF EXISTS `routing_uploads`;
CREATE TABLE `routing_uploads` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `targets_id` varchar(200) NOT NULL,
  `upload_link` varchar(200) NOT NULL,
  `upload_date` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `routing_uploads`
--

/*!40000 ALTER TABLE `routing_uploads` DISABLE KEYS */;
/*!40000 ALTER TABLE `routing_uploads` ENABLE KEYS */;


--
-- Definition of table `schema_migrations`
--

DROP TABLE IF EXISTS `schema_migrations`;
CREATE TABLE `schema_migrations` (
  `version` varchar(255) NOT NULL,
  UNIQUE KEY `unique_schema_migrations` (`version`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schema_migrations`
--

/*!40000 ALTER TABLE `schema_migrations` DISABLE KEYS */;
INSERT INTO `schema_migrations` (`version`) VALUES 
 ('20140113071917');
/*!40000 ALTER TABLE `schema_migrations` ENABLE KEYS */;


--
-- Definition of table `subclassification`
--

DROP TABLE IF EXISTS `subclassification`;
CREATE TABLE `subclassification` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `subclassification_desc` varchar(150) collate latin1_general_ci NOT NULL,
  `classification_id` varchar(45) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `subclassification`
--

/*!40000 ALTER TABLE `subclassification` DISABLE KEYS */;
INSERT INTO `subclassification` (`id`,`subclassification_desc`,`classification_id`) VALUES 
 (1,'DTR Timekeeping','9'),
 (2,'Utility Report','9'),
 (3,'SALN Report','10'),
 (4,'PPMP Report','10'),
 (5,'Memo to Conduct Training','15'),
 (6,'Memo to Attend','15'),
 (7,'Sales Report','14'),
 (8,'Ridership Report','14'),
 (9,'Monthly Management Report','14'),
 (10,'Endorsement to Maintenance Provider','18'),
 (11,'Letters to Maintenance Provider','18'),
 (12,'Incident Report from Maintenance Provider','18'),
 (13,'Service Interruption Report','18'),
 (14,'Weekly Accomplishment Report','18'),
 (15,'Preventive Maintenance Schedule','18'),
 (16,'Letters from Maintenance Provider','18'),
 (17,'Transmittal to Maintenance Provider','18'),
 (18,'Train Preparation Report','12'),
 (19,'Inspection Report of LVRs','12'),
 (20,'Elevator and Escalator Status Report','12'),
 (21,'Station AFC Equipment Status Report','12'),
 (22,'Report of Interim Maintenance Provider','12'),
 (23,'Journal Entry Voucher','28'),
 (24,'Disbursement Voucher','28'),
 (25,'Report of Collections','9'),
 (26,'Statement of Bank Deposits','9'),
 (27,'Cashier II Schedule','61'),
 (28,'Treasury Supervisor Schedule','61');
/*!40000 ALTER TABLE `subclassification` ENABLE KEYS */;


--
-- Definition of table `uploads`
--

DROP TABLE IF EXISTS `uploads`;
CREATE TABLE `uploads` (
  `upload_id` int(11) NOT NULL auto_increment,
  `ref_no` int(11) NOT NULL,
  `upload_link` text NOT NULL,
  `upload_date` datetime NOT NULL,
  PRIMARY KEY  (`upload_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `uploads`
--

/*!40000 ALTER TABLE `uploads` DISABLE KEYS */;
/*!40000 ALTER TABLE `uploads` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
