CREATE TABLE `troops` (
  `id` int NOT NULL AUTO_INCREMENT,
  `player_tag` varchar(12) NOT NULL,
  `type` varchar(10) DEFAULT NULL,
  `name` varchar(25) NOT NULL,
  `level` int DEFAULT NULL,
  `maxLevel` int DEFAULT NULL,
  `village` varchar(15) DEFAULT NULL,
  `timestamp` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_row` (`player_tag`,`village`,`name`),
  KEY `player_idx` (`player_tag`),
  CONSTRAINT `player` FOREIGN KEY (`player_tag`) REFERENCES `players` (`tag`)
) ENGINE=InnoDB AUTO_INCREMENT=13219630 DEFAULT CHARSET=latin1;
