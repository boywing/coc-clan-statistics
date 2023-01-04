CREATE TABLE `ClashOfClans`.`raids` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `startTime` DATETIME NULL DEFAULT NULL,
  `attacker_tag` VARCHAR(12) NULL DEFAULT NULL,
  `attacks` INT NULL DEFAULT NULL,
  `capitalResourcesLooted` INT NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `player` (`attacker_tag` ASC) VISIBLE,
  UNIQUE INDEX `unique` (`startTime` ASC, `attacker_tag` ASC) VISIBLE);
