CREATE TABLE `store` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) DEFAULT NULL,
  `url` varchar(128) DEFAULT NULL,
  `ipwhitelist` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

CREATE TABLE `buypaylog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eaterid` text NOT NULL,
  `eatid` text NOT NULL,
  `delta` text NOT NULL,
  `debt` text NOT NULL,
  `exchangeTime` datetime NOT NULL,
  `storeid` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5754 DEFAULT CHARSET=latin1;

CREATE TABLE `eater` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(500) DEFAULT NULL,
  `picture` varchar(500) DEFAULT NULL,
  `debt` varchar(500) DEFAULT NULL,
  `storeid` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=latin1;

CREATE TABLE `cashout` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eaterid` int(11) NOT NULL,
  `delta` int(11) NOT NULL,
  `message` text NOT NULL,
  `exchange_time` datetime DEFAULT NULL,
  `storeid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

CREATE TABLE `eat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(500) DEFAULT NULL,
  `picture` varchar(500) DEFAULT NULL,
  `price` varchar(500) DEFAULT NULL,
  `enabled` tinyint(1) DEFAULT NULL,
  `storeid` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=latin1;

