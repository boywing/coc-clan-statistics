CREATE TABLE `attacks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `startTime` datetime DEFAULT NULL,
  `attacker_tag` varchar(12) DEFAULT NULL,
  `defender_tag` varchar(12) DEFAULT NULL,
  `attacker_clan` varchar(15) DEFAULT NULL,
  `defender_clan` varchar(15) DEFAULT NULL,
  `attacker_th` int DEFAULT NULL,
  `defender_th` int DEFAULT NULL,
  `attacker_map_pos` int DEFAULT NULL,
  `defender_map_pos` int DEFAULT NULL,
  `attack_stars` int DEFAULT NULL,
  `destructionPercentage` decimal(10,0) DEFAULT NULL,
  `order` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `attack` (`startTime`,`attacker_tag`,`defender_tag`),
  KEY `attacker` (`attacker_tag`),
  KEY `defender` (`defender_tag`)
) ENGINE=InnoDB AUTO_INCREMENT=167271 DEFAULT CHARSET=latin1;
