CREATE TABLE `wars` (
  `id` int NOT NULL AUTO_INCREMENT,
  `teamSize` int NOT NULL DEFAULT '0',
  `startTime` datetime DEFAULT NULL,
  `endTime` datetime NOT NULL,
  `result` varchar(10) NOT NULL DEFAULT 'Ongoing',
  `clan1_tag` varchar(12) NOT NULL,
  `clan1_name` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `clan1_level` int NOT NULL DEFAULT '0',
  `clan1_attacks` int NOT NULL DEFAULT '0',
  `clan1_stars` int NOT NULL DEFAULT '0',
  `clan1_destructionPercentage` decimal(10,0) NOT NULL DEFAULT '0',
  `clan2_tag` varchar(12) NOT NULL,
  `clan2_name` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `clan2_level` int NOT NULL DEFAULT '0',
  `clan2_attacks` int NOT NULL DEFAULT '0',
  `clan2_stars` int NOT NULL DEFAULT '0',
  `clan2_destructionPercentage` decimal(10,0) NOT NULL DEFAULT '0',
  `war_status` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `war` (`clan1_tag`,`clan2_tag`,`endTime`),
  KEY `clan1` (`clan1_tag`),
  KEY `clan2` (`clan2_tag`)
) ENGINE=InnoDB AUTO_INCREMENT=459 DEFAULT CHARSET=latin1;
