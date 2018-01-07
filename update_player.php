#!/usr/bin/php
<?php

parse_str(implode('&', array_slice($argv, 1)), $_GET);
$playerid = $_GET['playerid'];

include "token.php";

$url = "https://api.clashofclans.com/v1/players/" . urlencode($playerid);

$curl = curl_init($url);
$header = array();
$header[] = "Accept: application/json";
$header[] = "Authorization: Bearer ".$api_token;
curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($curl);
$player = json_decode($result, true);
curl_close($curl);

if (isset($player["reason"])) {
    $error = true;
    echo $player["reason"];
    echo "\n";
}

$player_sql  = "SET @tag = '" . $player["tag"];
$player_sql .= "', @name = '" . $player["name"];
$player_sql .= "', @role = '" . $player["role"];
$player_sql .= "', @expLevel = " . $player["expLevel"];
if(isset($player["league"]["iconUrls"]["medium"]))
    {
        $player_sql .= ", @league = '" . $player["league"]["iconUrls"]["medium"] . "'";
    }
$player_sql .= ", @trophies = " . $player["trophies"];
$player_sql .= ", @donations = " . $player["donations"];
$player_sql .= ", @donationsReceived = " . $player["donationsReceived"];
$player_sql .= ", @clan_tag = '" . $player["clan"]["tag"];
$player_sql .= "', @clan_name = '" . $player["clan"]["name"];
$player_sql .= "', @townHallLevel = " . $player["townHallLevel"];
$player_sql .= ", @bestTrophies = " . $player["bestTrophies"];
$player_sql .= ", @warStars = " . $player["warStars"];
$player_sql .= ", @builderHallLevel = " . $player["builderHallLevel"];
$player_sql .= ", @versusTrophies = " . $player["versusTrophies"];
$player_sql .= ", @bestVersusTrophies = " . $player["bestVersusTrophies"];
$player_sql .= ", @versusBattleWins = " . $player["versusBattleWins"];
$player_sql .= ", @timestamp = CURRENT_TIMESTAMP;" . "\n";
$player_sql .= "INSERT INTO players (`tag`, `name`, `role`, `expLevel`, `league`, `trophies`, `donations`, `donationsReceived`,`clan_tag`, `clan_name`, `townHallLevel`, `bestTrophies`, `warStars`, `builderHallLevel`, `versusTrophies`, `bestVersusTrophies`, `versusBattleWins`, `timestamp`) ";
$player_sql .= "VALUES (@tag, @name, @role, @expLevel, @league, @trophies, @donations, @donationsReceived, @clan_tag, @clan_name, @townHallLevel, @bestTrophies, @warStars, @builderHallLevel, @versusTrophies, @bestVersusTrophies, @versusBattleWins, @timestamp) ";
$player_sql .= "ON DUPLICATE KEY UPDATE tag=@tag, name=@name, role=@role, expLevel=@expLevel, league=@league, trophies=@trophies, donations=@donations, donationsReceived=@donationsReceived, clan_tag=@clan_tag, clan_name=@clan_name, townHallLevel=@townHallLevel, bestTrophies=@bestTrophies, warStars=@warStars, builderHallLevel=@builderHallLevel, versusTrophies=@versusTrophies, bestVersusTrophies=@bestVersusTrophies, versusBattleWins=@versusBattleWins, timestamp=@timestamp;";

include "mysql_coc.php";
if (mysqli_multi_query($conn, $player_sql)) {
    echo "Record for \"" . $player["name"] . "\" updated successfully" . "\n";
} else {
    echo "Error updating record for " . $player["name"] . ": " . mysqli_error($conn) . "\n";
}
mysqli_close($conn);

?>
