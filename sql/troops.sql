CREATE TABLE `troops` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `player_tag` varchar(12) NOT NULL,
  `type` varchar(10) DEFAULT NULL,
  `name` varchar(25) NOT NULL,
  `level` int(11) DEFAULT NULL,
  `maxLevel` int(11) DEFAULT NULL,
  `village` varchar(15) DEFAULT NULL,
  `timestamp` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`player_tag`,`name`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `player_idx` (`player_tag`),
  CONSTRAINT `player` FOREIGN KEY (`player_tag`) REFERENCES `players` (`tag`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=236 DEFAULT CHARSET=latin1;
