#!/usr/bin/php
<?php

$activity_threshold = 5; // Dividing the average value to a proper level. Adjust as the overall activity increases to get a reasonable amount of players passing the threshold.
$elders = array("test", "test2"); //Remove this when appropriate
$dead = array();
//--------------------------------------------------------------------------

parse_str(implode('&', array_slice($argv, 1)), $_GET);
$clantag = $_GET['clanid'];

include "/var/www/html/aktivavikingar/config.php";
chdir($update_path);

include ($secret_path . "mysql_coc.php");

$clantag = mysqli_real_escape_string($conn, $clantag);
$members_sql = "SELECT tag, name, donations, unix_timestamp(createDate) AS createDate,
  (select IFNULL(ROUND(AVG(capitalResourcesLooted)/1000, 0), 0) from raids where attacker_tag=p.tag and startTime >= date_sub(now(), interval $days day)) as capital_points,
  (SELECT ROUND(AVG(attack_stars),1) FROM attacks WHERE attacker_tag = p.tag AND startTime >= date_sub(now(), interval $days day)) AS stars_cw, 
  (SELECT ROUND(AVG(destructionPercentage)) FROM attacks WHERE attacker_tag = p.tag AND startTime >= date_sub(now(), interval $days day)) AS percentage_cw, 
  (SELECT ROUND(AVG(attack_stars),1) FROM attacks WHERE attacker_tag = p.tag AND attacker_th = defender_th AND defender_th = p.townHallLevel AND startTime >= date_sub(now(), interval $days day)) as stars_cw_th,
  (SELECT ROUND(AVG(destructionPercentage)) FROM attacks WHERE attacker_tag = p.tag AND attacker_th = defender_th AND defender_th = p.townHallLevel AND startTime >= date_sub(now(), interval $days day)) as percentage_cw_th,
  (select round(avg(attack_stars),1) from attacks where attacker_tag = p.tag AND attacker_map_pos = defender_map_pos AND startTime >= date_sub(now(), interval $days day)) as stars_cw_mirr,
  (select round(avg(destructionPercentage)) from attacks where attacker_tag = p.tag AND attacker_map_pos = defender_map_pos AND startTime >= date_sub(now(), interval $days day)) as percentage_cw_mirr,
  (select round(avg(attack_stars),1) from attacks_cwl where attacker_tag = p.tag AND startTime >= date_sub(now(), interval $days day)) as stars_cwl,
  (select round(avg(destructionPercentage)) from attacks_cwl where attacker_tag = p.tag AND startTime >= date_sub(now(), interval $days day)) as percentage_cwl,
  (SELECT ROUND(AVG(attack_stars),1) FROM attacks_cwl WHERE attacker_tag = p.tag AND attacker_th = defender_th AND defender_th = p.townHallLevel AND startTime >= date_sub(now(), interval $days day)) as stars_cwl_th,
  (select round(avg(attack_stars),1) from v_attacks where defender_tag = p.tag AND defender_th = p.townHallLevel AND startTime >= date_sub(now(), interval $days day)) as def_stars,
  (select round(avg(attack_stars),1) from v_attacks where defender_tag = p.tag AND defender_th = p.townHallLevel AND defender_th = attacker_th AND startTime >= date_sub(now(), interval $days day)) as def_th_stars,
  (select round(avg(attack_stars),1) from attacks_cwl where defender_tag = p.tag AND defender_th = p.townHallLevel AND startTime >= date_sub(now(), interval $days day)) as def_stars_cwl,
	    (SELECT count(*) from attacks where attacker_tag = p.tag AND attack_stars=3 AND startTime >= date_sub(now(), interval $days day)) as three_stars_cw,
	    (SELECT count(*) from attacks_cwl where attacker_tag = p.tag AND attack_stars=3 AND startTime >= date_sub(now(), interval $days day)) as three_stars_cwl,
	    (SELECT count(*) from attacks where attacker_tag = p.tag AND startTime >= date_sub(now(), interval $days day)) as attacks_cw,
	    (SELECT count(*) from attacks_cwl where attacker_tag = p.tag AND startTime >= date_sub(now(), interval $days day)) as attacks_cwl,
  (SELECT COALESCE(TIMESTAMPDIFF(WEEK, MAX(startTime), NOW()),0) FROM v_attacks WHERE attacker_tag = p.tag) as last_war_week,
  (SELECT COALESCE(TIMESTAMPDIFF(DAY, MAX(startTime), DATE_SUB(NOW(),INTERVAL last_war_week WEEK)),0)FROM v_attacks a WHERE a.attacker_tag = p.tag) as last_war_day,
  (SELECT COALESCE(TIMESTAMPDIFF(HOUR, MAX(startTime), NOW()),0) FROM v_attacks a WHERE a.attacker_tag = p.tag) as last_war_hour,
  (SELECT COALESCE(TIMESTAMPDIFF(MINUTE, MAX(startTime), NOW()),0) FROM v_attacks a WHERE a.attacker_tag = p.tag) as last_war_minute,
  (select MAX(unix_timestamp(startTime)) from v_attacks where attacker_tag = tag) AS last_war,
  (select MAX(unix_timestamp(startTime)) from v_attacks where attacker_tag = tag AND attacker_clan = p.clan_tag) AS last_war_clan,
	    (SELECT count(*) from v_attacks where attacker_tag = p.tag AND attacker_clan = p.clan_tag AND attacker_th = defender_th AND defender_th = p.townHallLevel AND startTime >= date_sub(now(), interval $days day)) as attacks_clan,
	    (SELECT ROUND(AVG(attack_stars),1) FROM v_attacks WHERE attacker_tag = p.tag AND attacker_clan = p.clan_tag AND attacker_th = defender_th AND defender_th = p.townHallLevel AND startTime >= date_sub(now(), interval $days day)) as th_stars_clan FROM players p WHERE clan_tag = '$clantag'";

$avg_arr = get_average_activity();
var_dump($avg_arr);

if($result = mysqli_query($conn, $members_sql)) {
  if (mysqli_num_rows($result) > 0)
    {
      while($player = mysqli_fetch_assoc($result))
	{
	  $activity_sql = "SELECT tag, (select name from players where tag=a.tag) as name,
	    MAX(warStars)-MIN(warStars) AS cwStars,
	    MAX(cwl)-MIN(cwl) AS cwlStars,
	    MAX(warStars+cwl)-MIN(warStars+cwl) AS totStars,
	    MAX(clanCapitalContributions)-MIN(clanCapitalContributions) AS clanCapitalContributions,
	    MAX(clanCapitalLoot)-MIN(clanCapitalLoot) AS clanCapitalLoot,
	    MAX(donations)-MIN(donations) AS donations,
	    MAX(donatedSpells)-MIN(donatedSpells) AS donatedSpells,
	    MAX(donatedSiege)-MIN(donatedSiege) AS donatedSiege,
	    MAX(clanPoints)-MIN(clanPoints) AS clanPoints,
	    MAX(townHalls)-MIN(townHalls) AS townHalls,
	    MAX(multiplayerWins)-MIN(multiplayerWins) AS multiplayerWins,
	    MAX(defender)-MIN(defender) AS defender,
	    MAX(builderHalls)-MIN(builderHalls) AS builderHalls,
	    MAX(obstaclesRemoved)-MIN(obstaclesRemoved) AS obstaclesRemoved,
	    MAX(goldGrab)-MIN(goldGrab) AS goldGrab,
	    MAX(elixirGrab)-MIN(elixirGrab) AS elixirGrab,
	    MAX(darkGrab)-MIN(darkGrab) AS darkGrab,
	    MAX(wallBuster)-MIN(wallBuster) AS wallBuster,
	    MAX(builderHuts)-MIN(builderHuts) AS builderHuts,
	    MAX(mortars)-MIN(mortars) AS mortars,
	    MAX(xbows)-MIN(xbows) AS xbows,
	    MAX(infernos)-MIN(infernos) AS infernos,
	    MAX(eagleArtillery)-MIN(eagleArtillery) AS eagleArtillery,
	    MAX(scattershots)-MIN(scattershots) AS scattershots,
	    MAX(spellTowers)-MIN(spellTowers) AS spellTowers,
	    MAX(monolith)-MIN(monolith) AS monolith,
	    MAX(weaponizedTH)-MIN(weaponizedTH) AS weaponizedTH,
	    MAX(weaponizedHuts)-MIN(weaponizedHuts) AS weaponizedHuts,
	    MAX(seasonChallenges)-MIN(seasonChallenges) AS seasonChallenges,
	    MAX(superTroop)-MIN(superTroop) AS superTroop,
	    MAX(warLoot)-MIN(warLoot) AS warLoot,
	    (select unix_timestamp(createDate) from players where tag=a.tag) AS createDate
	    FROM activity a
	    WHERE tag = '" . $player["tag"] . "' AND date >= date_sub(now(), interval $days day);";


//	  echo $warStars . "," . $clanCapitalContributions . "," . $cwl . "," . $clanCapitalLoot . "," . $donations . "," . $donatedSpells . "," . $donatedSiege . "," . $clanPoints . "," . $townHalls . "," . $multiplayerWins . "," . $defender . "," . $builderHalls . "," . $obstaclesRemoved . "," . $goldGrab . "," . $elixirGrab . "," . $darkGrab . "," . $wallBuster . "," . $builderHuts . "," . $mortars . "," . $xbows . "," . $infernos . "," . $eagleArtillery . "," . $scattershots . "," . $spellTowers . "," . $monolith . "," . $weaponizedTH . "," . $weaponizedHuts . "," . $seasonChallenges . "," . $superTroop . "," . $warLoot . "\n"; 
	    
	  if($myres = mysqli_query($conn, $activity_sql)) {
	    if (mysqli_num_rows($myres) > 0)
	      {
		while($activity = mysqli_fetch_assoc($myres))
		  {
		    if(is_elder($activity))
		      $elders[] = $activity['tag'];
		    if(is_dead($activity))
		      $dead[] = $activity['tag'];
		    if(is_above_average($activity, 'donations', 1.1))
		      {
		      }
		  }
	      }
	  }
	  
	  $player_sql  = "SET @tag = '" . $player["tag"] . "'";
	  $player_sql .= ", @capital_points = " . $player["capital_points"];
	  $player_sql .= ", @stars_cw = " . $player["stars_cw"];
	  $player_sql .= ", @percentage_cw = " . $player["percentage_cw"];
	  $player_sql .= ", @stars_cw_th = " . $player["stars_cw_th"];
	  $player_sql .= ", @percentage_cw_th = " . $player["percentage_cw_th"];
	  $player_sql .= ", @stars_cw_mirr = " . $player["stars_cw_mirr"];
	  $player_sql .= ", @percentage_cw_mirr = " . $player["percentage_cw_mirr"];
	  $player_sql .= ", @stars_cwl = " . $player["stars_cwl"];
	  $player_sql .= ", @percentage_cwl = " . $player["percentage_cwl"];
	  $player_sql .= ", @stars_cwl_th = " . $player["stars_cwl_th"];
	  $player_sql .= ", @def_stars = " . $player["def_stars"];
	  $player_sql .= ", @def_th_stars = " . $player["def_th_stars"];
	  $player_sql .= ", @def_stars_cwl = " . $player["def_stars_cwl"];
	  $player_sql .= ", @three_stars_cw = " . $player["three_stars_cw"];
	  $player_sql .= ", @three_stars_cwl = " . $player["three_stars_cwl"];
	  $player_sql .= ", @attacks_cw = " . $player["attacks_cw"];
	  $player_sql .= ", @attacks_cwl = " . $player["attacks_cwl"];
	  $player_sql .= ", @last_war_week = " . $player["last_war_week"];
	  $player_sql .= ", @last_war_day = " . $player["last_war_day"];
	  $player_sql .= ", @last_war_hour = " . $player["last_war_hour"];
	  $player_sql .= ", @last_war_minute = " . $player["last_war_minute"];
	  $player_sql .= ", @last_war = " . $player["last_war"];
	  $player_sql .= ", @last_war_clan = " . $player["last_war_clan"];
	  $player_sql .= ", @attacks_clan = " . $player["attacks_clan"];
	  $player_sql .= ", @th_stars_clan = " . $player["th_stars_clan"];

	  if (!isset($player['last_war_clan']))
	    $player_sql .= ", @newcomer=true";
	  else
	    $player_sql .= ", @newcomer=false";
	  
	  if ((isset($player['th_stars_clan'])) && ($player['th_stars_clan'] < 1.5) && ($player['attacks_clan'] >= 9))
	    $player_sql .= ", @weakAttacker=true";
	  else
	    $player_sql .= ", @weakAttacker=false";
	  
	  if ($player['th_stars_clan'] >= 2.3 && $player['attacks_clan'] >= 9)
	    $player_sql .= ", @strongAttacker=true";
	  else
	    $player_sql .= ", @strongAttacker=false";
	  
	  if ($player['th_stars_clan'] == 3.0 && $player['attacks_clan'] >= 3)
	    $player_sql .= ", @aceAttacker=true";
	  else
	    $player_sql .= ", @aceAttacker=false";
	  
	  if((isset($player['last_war']) && (time() - $player['last_war'] > (60*60*24*21))) || (!isset($player['last_war']) && (time() - $player['createDate'] > (60*60*24*21))))
	    $player_sql .= ", @inactive=true";
	  else
	    $player_sql .= ", @inactive=false";

	  if(is_above_average($player, 'donations', 1.1))
	    $player_sql .= ", @donator=" . $player['donations'];
	  else
	    $player_sql .= ", @donator=0";
	  
	  if(is_above_average($player, 'cwStars', 1.1))
	    $player_sql .= ", @cwHero=" . $player['cwStars'];
	  else
	    $player_sql .= ", @cwHero=0";
	  
	  if(is_above_average($player, 'cwlStars', 1.1))
	    $player_sql .= ", @cwlChampion=" . $player['cwlStars'];
	  else
	    $player_sql .= ", @cwlChampion=0";
	  
	  if(is_above_average($player, 'totStars', 1.1))
	    $player_sql .= ", @starCollector=" . $player['totStars'];
	  else
	    $player_sql .= ", @starCollector=0";
	  
	  if(is_above_average($player, 'clanCapitalContributions', 1.1))
	    $player_sql .= ", @capitalMaster=" . $player['clanCapitalContributions'];
	  else
	    $player_sql .= ", @capitalMaster=0";
	  
	  if(is_above_average($player, 'townHalls', 1.1))
	    $player_sql .= ", @thSmasher=" . $player['townHalls'];
	  else
	    $player_sql .= ", @thSmasher=0";
	  
	  if(is_above_average($player, 'multiplayerWins', 1.1))
	    $player_sql .= ", @farmer=" . $player['multiplayerWins'];
	  else
	    $player_sql .= ", @farmer=0";
	  
	  if(is_above_average($player, 'defender', 1.1))
	    $player_sql .= ", @unbreakableBase=" . $player['defender'];
	  else
	    $player_sql .= ", @unbreakableBase=0";
	  
	  if(is_above_average($player, 'obstaclesRemoved', 1.1))
	    $player_sql .= ", @gardener=" . $player['obstaclesremoved'];
	  else
	    $player_sql .= ", @gardener=0";

	  if(is_above_average($player, 'darkGrab', 1.1))
	    $player_sql .= ", @darkHunter=" . $player['darkGrab'];
	  else
	    $player_sql .= ", @darkHunter=0";
	  
	  if(is_above_average($player, 'wallBuster', 1.1))
	    $player_sql .= ", @wallBuster=" . $player['wallBuster'];
	  else
	    $player_sql .= ", @wallBuster=0";
	  
	  if(is_above_average($player, 'seasonChallenges', 1.1))
	    $player_sql .= ", @seasonChallenges=" . $player['seasonChallenges'];
	  else
	    $player_sql .= ", @seasonChallenges=0";
	  
	  if(is_above_average($player, 'superTroop', 1.1))
	    $player_sql .= ", @superTroop=" . $player['superTroop'];
	  else
	    $player_sql .= ", @superTroop=0";
	  
	  if(is_above_average($player, 'superTroop', 1.1))
	    $player_sql .= ", @superTroop=" . $player['superTroop'];
	  else
	    $player_sql .= ", @superTroop=0";

	  if(is_above_average($player, 'superTroop', 1.1))
	    $player_sql .= ", @superTroop=" . $player['superTroop'];
	  else
	    $player_sql .= ", @superTroop=0";
		  

	  $player_sql .= ";\n";
	  echo $player_sql;
	}
      
      
      /*
      mysqli_query($conn, $player_sql);
      
      $player_sql = "INSERT INTO activity(`tag`, `warStars`, `clanCapitalContributions`, `clanCapitalLoot`, `donations`, `donatedSpells`, `donatedSiege`, `clanPoints`, `townHalls`, `multiplayerWins`, `builderHalls`, `obstaclesRemoved`, `goldGrab`, `elixirGrab`, `darkGrab`, `wallBuster`, `builderHuts`, `defender`, `mortars`, `xbows`, `infernos`, `eagleArtillery`, `spellTowers`, `monolith`, `cwl`, `seasonChallenges`, `scattershots`, `weaponizedTH`, `weaponizedHuts`, `superTroop`, `warLoot`) ";
      $player_sql .= "VALUES (@tag, @warStars, @clanCapitalContributions, @clanCapitalLoot, @donations, @donatedSpells, @donatedSiege, @clanPoints, @townHalls, @multiplayerWins, @builderHalls, @obstaclesRemoved, @goldGrab, @elixirGrab, @darkGrab, @wallBuster, @builderHuts, @defender, @mortars, @xbows, @infernos, @eagleArtillery, @spellTowers, @monolith, @cwl, @seasonChallenges, @scattershots, @weaponizedTH, @weaponizedHuts, @superTroop, @warLoot);";
      
      if (mysqli_query($conn, $player_sql)) {
	echo "Activity record for player \"" . $player["name"] . "\" updated successfully.\n";
      } else {
	echo "----- Error updating record for " . $player["name"] . ": " . mysqli_error($conn) . "\n";
      }
      */
    }
  echo "Elders = " . $elders . "\n";
  echo "Dead = " . $dead . "\n";

 }
 else
   { echo "<br>----- FAIL! - " . mysqli_error($conn) . "<br>"; }


function average($array, $item)
{
 $total = 0;
 $count = 0;
 foreach ($array as $row) {
   if($row[$item] > 0)
     {
       $total += $row[$item];
       $count++;
     }
 };
 return $total/$count;	
}

function get_average_activity()
{
  global $follow_clans, $days, $conn;
  
  $avg_sql = "SELECT tag, 1 as name,
    MAX(warStars)-MIN(warStars) AS cwStars,
    MAX(cwl)-MIN(cwl) AS cwlStars,
    MAX(warStars+cwl)-MIN(warStars+cwl) AS totStars,
    MAX(clanCapitalContributions)-MIN(clanCapitalContributions) AS clanCapitalContributions,
    MAX(clanCapitalLoot)-MIN(clanCapitalLoot) AS clanCapitalLoot,
    MAX(donations)-MIN(donations) AS donations,
    MAX(donatedSpells)-MIN(donatedSpells) AS donatedSpells,
    MAX(donatedSiege)-MIN(donatedSiege) AS donatedSiege,
    MAX(clanPoints)-MIN(clanPoints) AS clanPoints,
    MAX(townHalls)-MIN(townHalls) AS townHalls,
    MAX(multiplayerWins)-MIN(multiplayerWins) AS multiplayerWins,
    MAX(defender)-MIN(defender) AS defender,
    MAX(builderHalls)-MIN(builderHalls) AS builderHalls,
    MAX(obstaclesRemoved)-MIN(obstaclesRemoved) AS obstaclesRemoved,
    MAX(goldGrab)-MIN(goldGrab) AS goldGrab,
    MAX(elixirGrab)-MIN(elixirGrab) AS elixirGrab,
    MAX(darkGrab)-MIN(darkGrab) AS darkGrab,
    MAX(wallBuster)-MIN(wallBuster) AS wallBuster,
    MAX(builderHuts)-MIN(builderHuts) AS builderHuts,
    MAX(mortars)-MIN(mortars) AS mortars,
    MAX(xbows)-MIN(xbows) AS xbows,
    MAX(infernos)-MIN(infernos) AS infernos,
    MAX(eagleArtillery)-MIN(eagleArtillery) AS eagleArtillery,
    MAX(scattershots)-MIN(scattershots) AS scattershots,
    MAX(spellTowers)-MIN(spellTowers) AS spellTowers,
    MAX(monolith)-MIN(monolith) AS monolith,
    MAX(weaponizedTH)-MIN(weaponizedTH) AS weaponizedTH,
    MAX(weaponizedHuts)-MIN(weaponizedHuts) AS weaponizedHuts,
    MAX(seasonChallenges)-MIN(seasonChallenges) AS seasonChallenges,
    MAX(superTroop)-MIN(superTroop) AS superTroop,
    MAX(warLoot)-MIN(warLoot) AS warLoot
    FROM activity a
    WHERE tag IN (SELECT tag from players where clan_tag IN(" . $follow_clans . ")) AND darkGrab>0 AND date >= date_sub(now(), interval $days day)
    GROUP BY tag;
  ";

if($avg_res = mysqli_query($conn, $avg_sql)) {
  if (mysqli_num_rows($avg_res) > 0)
    {
      $avg_arr = $tot_arr = $count_arr = array(
		     "cwStars" => 0,
		     "cwlStars" => 0,
		     "totStars" => 0,
		     "clanCapitalContributions" => 0,
		     "clanCapitalLoot" => 0,
		     "donations" => 0,
		     "donatedSpells" => 0,
		     "donatedSiege" => 0,
		     "clanPoints" => 0,
		     "townHalls" => 0,
		     "multiplayerWins" => 0,
		     "defender" => 0,
		     "builderHalls" => 0,
		     "obstaclesRemoved" => 0,
		     "goldGrab" => 0,
		     "elixirGrab" => 0,
		     "darkGrab" => 0,
		     "wallBuster" => 0,
		     "builderHuts" => 0,
		     "mortars" => 0,
		     "xbows" => 0,
		     "infernos" => 0,
		     "eagleArtillery" => 0,
		     "scattershots" => 0,
		     "spellTowers" => 0,
		     "monolith" => 0,
		     "weaponizedTH" => 0,
		     "weaponizedHuts" => 0,
		     "seasonChallenges" => 0,
		     "superTroop" => 0,
		     "warLoot" => 0
		     );
      
      while($avg = mysqli_fetch_assoc($avg_res))
	{
	  foreach ($avg as $item => $value)
	    {
	      if ($item != 'tag' && $item != 'name' && $value > 0) {
		$tot_arr[$item] += $value;
		$count_arr[$item]++;
	      }
	    }
	}
      foreach($tot_arr as $item => $value)
	{
	  $avg_arr[$item] = round($value / $count_arr[$item]);
	}
    }
 }
 return $avg_arr;
}

function is_elder($activity)
{
  global $avg_arr, $days, $activity_threshold;
  
  if(time() - $activity['createDate'] > (60*60*24*$days))
    $elder = true;
  else
    $elder = false;
  foreach ($activity as $item => $value)
    {
      if (($item == "cwStars" || $item == "clanCapitalContributions" || $item == "donations" || $item == "townHalls" || $item == "clanPoints") && ($value < $avg_arr[$item]/$activity_threshold) && $elder == true)
	$elder = false;
    }
  return $elder;
}

function is_dead($activity)
{
  global $avg_arr, $days;
  
  if(time() - $activity['createDate'] > (60*60*24*14))
    $dead = true;
  else
    $dead = false;
  foreach ($activity as $item => $value)
    {
      if (($item == "cwStars" || $item == "clanCapitalContributions" || $item == "donations" || $item == "townHalls" || $item == "clanPoints") && $value > 1 && $dead == true)
	{
	  $dead = false;
	}
    }
  return $dead;
}

function is_above_average($player, $action, $offset)
{
  global $avg_arr;
 
  if ($player[$action] > ($avg_arr[$action] * $offset))
    return true;
  else
    return false;
}


function search_for_value($tag, $array, $item)
{
  foreach ($array as $key => $val) {
    if ($val['tag'] === $tag) {
      return $val[$item];
    }
  }
  return null;
}
