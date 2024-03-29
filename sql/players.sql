CREATE TABLE `players` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tag` varchar(12) NOT NULL,
  `name` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `townHallLevel` int NOT NULL DEFAULT '0',
  `townHallWeaponLevel` int DEFAULT '0',
  `clan_name` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `expLevel` int DEFAULT '0',
  `trophies` int DEFAULT '0',
  `bestTrophies` int DEFAULT '0',
  `warStars` int DEFAULT '0',
  `builderHallLevel` int DEFAULT '0',
  `versusTrophies` int DEFAULT '0',
  `bestVersusTrophies` int DEFAULT '0',
  `versusBattleWins` int DEFAULT '0',
  `role` varchar(9) DEFAULT 'member',
  `warPreference` varchar(8) DEFAULT 'in',
  `donations` int DEFAULT '0',
  `donationsReceived` int DEFAULT '0',
  `clan_tag` varchar(12) DEFAULT NULL,
  `league` varchar(100) DEFAULT NULL,
  `versusBattleWinCount` int DEFAULT '0',
  `war_weight_offence` int DEFAULT '0',
  `war_weight_defence` int DEFAULT '0',
  `timestamp` datetime DEFAULT CURRENT_TIMESTAMP,
  `createDate` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tag_UNIQUE` (`tag`),
  KEY `clan_tag` (`clan_tag`),
  CONSTRAINT `clan_tag` FOREIGN KEY (`clan_tag`) REFERENCES `clans` (`tag`)
) ENGINE=InnoDB AUTO_INCREMENT=177917587 DEFAULT CHARSET=latin1;
