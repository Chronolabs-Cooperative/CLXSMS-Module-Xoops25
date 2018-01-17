CREATE TABLE `clxsms_content` (
  `content_id` mediumint(46) unsigned NOT NULL AUTO_INCREMENT,
  `content` varchar(360) DEFAULT '',
  `method` enum('sent','received','unknown') DEFAULT 'unknown',
  `actioned` int(13) DEFAULT '0',
  `deleted` int(13) DEFAULT '0',
  PRIMARY KEY (`content_id`),
  KEY `searches` (`content`(23), `method`, `deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `clxsms_delievery` (
  `delievery_id` mediumint(23) unsigned NOT NULL AUTO_INCREMENT,
  `sent_id` mediumint(23) unsigned DEFAULT '0',
  `msgid` varchar(50) DEFAULT '',
  `source` varchar(50) DEFAULT '',
  `destination` varchar(50) DEFAULT '',
  `status` varchar(50) DEFAULT '',
  `errorcode` varchar(50) DEFAULT '',
  `datetime` varchar(50) DEFAULT '',
  `userref` varchar(50) DEFAULT '',
  `created` int(13) DEFAULT '0',
  `deleted` int(13) DEFAULT '0',
  PRIMARY KEY (`delievery_id`),
  KEY `searches` (`sent_id`, `msgid`(13), `source`(13), `destination`(13), `status`(13), `errorcode`(13)),
  KEY `dates` (`datetime`(23), `created`, `deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `clxsms_numbers` (
  `number_id` mediumint(15) unsigned NOT NULL AUTO_INCREMENT,
  `number` int(40) NOT NULL DEFAULT '0',
  `number_queued` mediumint(13) NOT NULL DEFAULT '0',
  `number_sent` mediumint(13) NOT NULL DEFAULT '0',
  `number_received` mediumint(13) NOT NULL DEFAULT '0',
  `last_queued_id` mediumint(23) unsigned NOT NULL DEFAULT '0',
  `last_sent_id` mediumint(23) unsigned NOT NULL DEFAULT '0',
  `last_received_id` mediumint(23) unsigned NOT NULL DEFAULT '0',
  `last_queued` int(13) NOT NULL DEFAULT '0',
  `last_sent` int(13) NOT NULL DEFAULT '0',
  `last_received` int(13) NOT NULL DEFAULT '0',
  `banned` enum('Yes','No') DEFAULT 'No',
  PRIMARY KEY (`number_id`),
  KEY `searches` (`banned`, `last_queued_id`, `last_sent_id`, `last_received_id`, `last_queued`, `last_sent`, `last_received`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `clxsms_received` (
  `received_id` mediumint(23) unsigned NOT NULL AUTO_INCREMENT,
  `from_uid` int(13) NOT NULL DEFAULT '0',
  `from_number_id` mediumint(15) NOT NULL DEFAULT '0',
  `to_number_id` mediumint(15) NOT NULL DEFAULT '0',
  `sms_content_id` mediumint(46) NOT NULL DEFAULT '0',
  `response_id` mediumint(46) NOT NULL DEFAULT '0',
  `method` enum('callback','polled') NOT NULL DEFAULT 'callback',
  `received` int(13) NOT NULL DEFAULT '0',
  `deleted` int(13) NOT NULL DEFAULT '0',
  `plugins` mediumtext,
  `keys` mediumtext,
  `identities` mediumtext,
  PRIMARY KEY (`received_id`),
  KEY `searches` (`from_uid`, `from_number_id`, `method`),
  KEY `dates` (`received`, `deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `clxsms_responses` (
  `response_id` mediumint(46) unsigned NOT NULL AUTO_INCREMENT,
  `code` int(3) NOT NULL DEFAULT '200',
  `url` varchar(500) NOT NULL,
  `method` enum('furl','curl') NOT NULL DEFAULT 'curl',
  `response` mediumtext,
  `data` mediumtext,
  `created` int(13) NOT NULL DEFAULT '0',
  `deleted` int(13) NOT NULL DEFAULT '0',
  PRIMARY KEY (`response_id`),
  KEY `dates` (`created`, `deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `clxsms_sent` (
  `sent_id` mediumint(23) unsigned NOT NULL AUTO_INCREMENT,
  `delievery_id` mediumint(23) unsigned DEFAULT '0',
  `msgid` varchar(50) DEFAULT '',
  `from_uid` int(13) NOT NULL DEFAULT '0',
  `to_uid` int(13) NOT NULL DEFAULT '0',
  `from_number_id` mediumint(15) NOT NULL DEFAULT '0',
  `to_number_id` mediumint(15) NOT NULL DEFAULT '0',
  `sms_level` enum('required','important','normal','low') NOT NULL DEFAULT 'normal',
  `sms_sent_after` int(13) NOT NULL DEFAULT '0',
  `sms_sent_before` int(13) NOT NULL DEFAULT '0',
  `sms_day_number` int(23) NOT NULL DEFAULT '0',
  `sms_content_id` mediumint(46) NOT NULL DEFAULT '0',
  `module` varchar(50) NOT NULL DEFAULT 'clxsms',
  `class` varchar(50) NOT NULL DEFAULT 'send',
  `function` varchar(50) NOT NULL DEFAULT 'sendsms',
  `identity` int(30) NOT NULL DEFAULT '0',
  `key` varchar(44) NOT NULL DEFAULT '',
  `plugins` mediumtext,
  `keys` mediumtext,
  `identities` mediumtext,
  `created` int(13) NOT NULL DEFAULT '0',
  `sent` int(13) NOT NULL DEFAULT '0',
  `retry` int(13) NOT NULL DEFAULT '0',
  `canceled` int(13) NOT NULL DEFAULT '0',
  `deleted` int(13) NOT NULL DEFAULT '0',
  `response_id` mediumint(46) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sent_id`,`response_id`),
  KEY `searches` (`msgid`(13), `delievery_id`, `from_uid`, `to_uid`, `from_number_id`, `to_number_id`, `sms_level`),
  KEY `dates` (`sms_sent_after`, `sms_sent_before`, `created`, `sent`, `retry`, `canceled`, `deleted`, `sms_level`),
  KEY `xoops` (`module`(11), `class`(11), `function`(11), `identity`, `key`(11), `sms_level`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `clxsms_statistics` (
  `statistic_id` mediumint(69) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('delievered','queued','send','receive','system') NOT NULL DEFAULT 'system',
  `day` int(2) NOT NULL DEFAULT '0',
  `month` int(2) NOT NULL DEFAULT '0',
  `year` int(2) NOT NULL DEFAULT '0',
  `hour` int(2) NOT NULL DEFAULT '0',
  `from` int(13) NOT NULL DEFAULT '0',
  `to` int(13) NOT NULL DEFAULT '0',
  `count` int(23) NOT NULL DEFAULT '0',
  `errors` int(23) NOT NULL DEFAULT '0',
  `nocredit` int(13) NOT NULL DEFAULT '0',
  PRIMARY KEY (`statistic_id`),
  KEY `searches` (`type`, `day`, `month`, `year`, `hour`),
  KEY `dates` (`type`, `from`, `to`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;