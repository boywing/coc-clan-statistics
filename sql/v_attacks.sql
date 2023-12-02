CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `ClashOfClans`.`v_attacks` AS select `ClashOfClans`.`attacks`.`id` AS `id`,'CW' AS `war_type`,`ClashOfClans`.`attacks`.`startTime` AS `startTime`,`ClashOfClans`.`attacks`.`attacker_tag` AS `attacker_tag`,`ClashOfClans`.`attacks`.`defender_tag` AS `defender_tag`,`ClashOfClans`.`attacks`.`attacker_clan` AS `attacker_clan`,`ClashOfClans`.`attacks`.`defender_clan` AS `defender_clan`,`ClashOfClans`.`attacks`.`attacker_th` AS `attacker_th`,`ClashOfClans`.`attacks`.`defender_th` AS `defender_th`,`ClashOfClans`.`attacks`.`attacker_map_pos` AS `attacker_map_pos`,`ClashOfClans`.`attacks`.`defender_map_pos` AS `defender_map_pos`,`ClashOfClans`.`attacks`.`attack_stars` AS `attack_stars`,`ClashOfClans`.`attacks`.`destructionPercentage` AS `destructionPercentage`,`ClashOfClans`.`attacks`.`order` AS `order` from `ClashOfClans`.`attacks` union all select `ClashOfClans`.`attacks_cwl`.`id` AS `id`,'CWL' AS `war_type`,`ClashOfClans`.`attacks_cwl`.`startTime` AS `startTime`,`ClashOfClans`.`attacks_cwl`.`attacker_tag` AS `attacker_tag`,`ClashOfClans`.`attacks_cwl`.`defender_tag` AS `defender_tag`,`ClashOfClans`.`attacks_cwl`.`attacker_clan` AS `attacker_clan`,`ClashOfClans`.`attacks_cwl`.`defender_clan` AS `defender_clan`,`ClashOfClans`.`attacks_cwl`.`attacker_th` AS `attacker_th`,`ClashOfClans`.`attacks_cwl`.`defender_th` AS `defender_th`,`ClashOfClans`.`attacks_cwl`.`attacker_map_pos` AS `attacker_map_pos`,`ClashOfClans`.`attacks_cwl`.`defender_map_pos` AS `defender_map_pos`,`ClashOfClans`.`attacks_cwl`.`attack_stars` AS `attack_stars`,`ClashOfClans`.`attacks_cwl`.`destructionPercentage` AS `destructionPercentage`,`ClashOfClans`.`attacks_cwl`.`order` AS `order` from `ClashOfClans`.`attacks_cwl`;