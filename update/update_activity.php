#!/usr/bin/php
<?php

parse_str(implode('&', array_slice($argv, 1)), $_GET);
$clantag = $_GET['clanid'];

include "/var/www/html/aktivavikingar/config.php";
chdir($update_path);

include ($secret_path . "token.php");
include ($secret_path . "mysql_coc.php");

$clantag = mysqli_real_escape_string($conn, $clantag);
$clan_sql = "SELECT tag FROM players WHERE clan_tag = '" . $clantag . "'";

if($result = mysqli_query($conn, $clan_sql)) {
  if (mysqli_num_rows($result) > 0)
    {
      $header = array();
      $header[] = "Accept: application/json";
      $header[] = "Content-type: text/html; charset=UTF-8";
      $header[] = "Authorization: Bearer ".$api_token;
      
      while($ply = mysqli_fetch_assoc($result))
	{
	  $playerid = $ply['tag'];
	  $url = "https://api.clashofclans.com/v1/players/" . urlencode($ply['tag']);
          
	  $curl = curl_init($url);
	  
	  curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
	  curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	  $curl_result = curl_exec($curl);
	  $player = json_decode($curl_result, true);
	  curl_close($curl);
          
	  if (isset($player["reason"])) {
	    $error = true;
	    echo $player["reason"];
	    echo "\n";
	  }
	  
	  $player_sql  = "SET @tag = '" . $player["tag"] . "'";
	  $player_sql .= ", @warStars = " . $player["warStars"];
	  $player_sql .= ", @clanCapitalContributions = " . $player["clanCapitalContributions"];

	  foreach($player["achievements"] as $activity)
	    {
	      if ($activity["name"] == "Aggressive Capitalism")
		$player_sql .= ", @clanCapitalLoot = " . $activity["value"];
	      else if ($activity["name"] == "Friend in Need")
		$player_sql .= ", @donations = " . $activity["value"];
	      else if ($activity["name"] == "Sharing is caring")
		$player_sql .= ", @donatedSpells = " . $activity["value"];
	      else if ($activity["name"] == "Siege Sharer")
		$player_sql .= ", @donatedSiege = " . $activity["value"];
	      else if ($activity["name"] == "Games Champion")
		$player_sql .= ", @clanPoints = " . $activity["value"];
	      else if ($activity["name"] == "Humiliator")
		$player_sql .= ", @townHalls = " . $activity["value"];
	      else if ($activity["name"] == "Conqueror")
		$player_sql .= ", @multiplayerWins = " . $activity["value"];
	      else if ($activity["name"] == "Un-Build It")
		$player_sql .= ", @builderHalls = " . $activity["value"];
	      else if ($activity["name"] == "Nice and Tidy")
		$player_sql .= ", @obstaclesRemoved = " . $activity["value"];
	      else if ($activity["name"] == "Gold Grab")
		$player_sql .= ", @goldGrab = " . $activity["value"];
	      else if ($activity["name"] == "Elixir Escapade")
		$player_sql .= ", @elixirGrab = " . $activity["value"];
	      else if ($activity["name"] == "Heroic Heist")
		$player_sql .= ", @darkGrab = " . $activity["value"];
	      else if ($activity["name"] == "Wall Buster")
		$player_sql .= ", @wallBuster = " . $activity["value"];
	      else if ($activity["name"] == "Union Buster")
		$player_sql .= ", @builderHuts = " . $activity["value"];
	      else if ($activity["name"] == "Unbreakable")
		$player_sql .= ", @defender = " . $activity["value"];
	      else if ($activity["name"] == "Mortar Mauler")
		$player_sql .= ", @mortars = " . $activity["value"];
	      else if ($activity["name"] == "X-Bow Exterminator")
		$player_sql .= ", @xbows = " . $activity["value"];
	      else if ($activity["name"] == "Firefighter")
		$player_sql .= ", @infernos = " . $activity["value"];
	      else if ($activity["name"] == "Anti-Artillery")
		$player_sql .= ", @eagleArtillery = " . $activity["value"];
	      else if ($activity["name"] == "Counterspell")
		$player_sql .= ", @spellTowers = " . $activity["value"];
	      else if ($activity["name"] == "Monolith Masher")
		$player_sql .= ", @monolith = " . $activity["value"];
	      else if ($activity["name"] == "War League Legend")
		$player_sql .= ", @cwl = " . $activity["value"];
	      else if ($activity["name"] == "Well Seasoned")
		$player_sql .= ", @seasonChallenges = " . $activity["value"];
	      else if ($activity["name"] == "Shattered and Scattered")
		$player_sql .= ", @scattershots = " . $activity["value"];
	      else if ($activity["name"] == "Not So Easy This Time")
		$player_sql .= ", @weaponizedTH = " . $activity["value"];
	      else if ($activity["name"] == "Bust This!")
		$player_sql .= ", @weaponizedHuts = " . $activity["value"];
	      else if ($activity["name"] == "Superb Work")
		$player_sql .= ", @superTroop = " . $activity["value"];
	      else if ($activity["name"] == "Clan War Wealth")
		$player_sql .= ", @warLoot = " . $activity["value"];
	    }
	  $player_sql .= ";\n";
	  mysqli_query($conn, $player_sql);

	  $player_sql = "INSERT INTO activity(`tag`, `warStars`, `clanCapitalContributions`, `clanCapitalLoot`, `donations`, `donatedSpells`, `donatedSiege`, `clanPoints`, `townHalls`, `multiplayerWins`, `builderHalls`, `obstaclesRemoved`, `goldGrab`, `elixirGrab`, `darkGrab`, `wallBuster`, `builderHuts`, `defender`, `mortars`, `xbows`, `infernos`, `eagleArtillery`, `spellTowers`, `monolith`, `cwl`, `seasonChallenges`, `scattershots`, `weaponizedTH`, `weaponizedHuts`, `superTroop`, `warLoot`) ";
	  $player_sql .= "VALUES (@tag, @warStars, @clanCapitalContributions, @clanCapitalLoot, @donations, @donatedSpells, @donatedSiege, @clanPoints, @townHalls, @multiplayerWins, @builderHalls, @obstaclesRemoved, @goldGrab, @elixirGrab, @darkGrab, @wallBuster, @builderHuts, @defender, @mortars, @xbows, @infernos, @eagleArtillery, @spellTowers, @monolith, @cwl, @seasonChallenges, @scattershots, @weaponizedTH, @weaponizedHuts, @superTroop, @warLoot);";

	  if (mysqli_query($conn, $player_sql)) {
	    echo "Activity record for player \"" . $player["name"] . "\" updated successfully.\n";
	  } else {
	    echo "----- Error updating record for " . $player["name"] . ": " . mysqli_error($conn) . "\n";
	  }
	}
    }
  else
    { echo "----- Error fetching data for $clantag <br>"; }
 }
 else
   { echo "<br>----- FAIL! - " . mysqli_error($conn) . "<br>"; }
