#!/usr/bin/php
<?php

parse_str(implode('&', array_slice($argv, 1)), $_GET);
$clantag = $_GET['clantag'];


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
                    
                    $player_sql  = "SET @tag = '" . $player["tag"];
                    $player_sql .= "', @name = '" . mysqli_real_escape_string($conn, $player["name"]);
                    $player_sql .= "', @role = '" . $player["role"];
                    $player_sql .= "', @warPreference = '" . $player["warPreference"];
                    $player_sql .= "', @expLevel = " . $player["expLevel"];
                    if(isset($player["league"]["iconUrls"]["medium"]))
                        {
                            $player_sql .= ", @league = '" . $player["league"]["iconUrls"]["medium"] . "'";
                        }
                    $player_sql .= ", @trophies = " . $player["trophies"];
                    $player_sql .= ", @donations = " . $player["donations"];
                    $player_sql .= ", @donationsReceived = " . $player["donationsReceived"];
                    $player_sql .= ", @clan_tag = '" . $player["clan"]["tag"];
                    $player_sql .= "', @clan_name = '" . mysqli_real_escape_string($conn, $player["clan"]["name"]);
                    $player_sql .= "', @townHallLevel = " . $player["townHallLevel"];
		    if(isset($player["townHallWeaponLevel"]))
		      $player_sql .= ", @townHallWeaponLevel = " . $player["townHallWeaponLevel"];
		    else
		      $player_sql .= ", @townHallWeaponLevel = 0";
		    $player_sql .= ", @bestTrophies = " . $player["bestTrophies"];
                    $player_sql .= ", @warStars = " . $player["warStars"];
                    if(isset($player["builderHallLevel"]))
                        {
                            $player_sql .= ", @builderHallLevel = " . $player["builderHallLevel"];
                        }
                    $player_sql .= ", @versusTrophies = " . $player["versusTrophies"];
                    $player_sql .= ", @bestVersusTrophies = " . $player["bestVersusTrophies"];
                    $player_sql .= ", @versusBattleWins = " . $player["versusBattleWins"];
                    $player_sql .= ", @timestamp = CURRENT_TIMESTAMP;" . "\n";

                    mysqli_query($conn, $player_sql);
                    
                    $player_sql = "INSERT INTO players (`tag`, `name`, `role`, `warPreference`, `expLevel`, `league`, `trophies`, `donations`, `donationsReceived`,`clan_tag`, `clan_name`, `townHallLevel`, `townHallWeaponLevel`, `bestTrophies`, `warStars`, `builderHallLevel`, `versusTrophies`, `bestVersusTrophies`, `versusBattleWins`, `timestamp`) ";
                    $player_sql .= "VALUES (@tag, @name, @role, @warPreference, @expLevel, @league, @trophies, @donations, @donationsReceived, @clan_tag, @clan_name, @townHallLevel, @townHallWeaponLevel, @bestTrophies, @warStars, @builderHallLevel, @versusTrophies, @bestVersusTrophies, @versusBattleWins, @timestamp) ";
                    $player_sql .= "ON DUPLICATE KEY UPDATE tag=@tag, name=@name, role=@role, warPreference=@warPreference, expLevel=@expLevel, league=@league, trophies=@trophies, donations=@donations, donationsReceived=@donationsReceived, clan_tag=@clan_tag, clan_name=@clan_name, townHallLevel=@townHallLevel, townHallWeaponLevel=@townHallWeaponLevel, bestTrophies=@bestTrophies, warStars=@warStars, builderHallLevel=@builderHallLevel, versusTrophies=@versusTrophies, bestVersusTrophies=@bestVersusTrophies, versusBattleWins=@versusBattleWins, timestamp=@timestamp;";

                    if (mysqli_query($conn, $player_sql)) {
                        echo "Member record for player \"" . $player["name"] . "\" updated successfully.\n";
                    } else {
                        echo "----- Error updating record for " . $player["name"] . ": " . mysqli_error($conn) . "\n";
                    }
                    
                    update_troops('troops', $player["troops"]);
                    update_troops('spells', $player["spells"]);
                    update_troops('heroes', $player["heroes"]);
                }
        }
    else
        { echo "----- Error fetching data for $clantag <br>"; }
}
else
    { echo "<br>----- FAIL! - " . mysqli_error($conn) . "<br>"; }

function update_troops($type, $troops)
{
    global $playerid;
    global $conn;    

    foreach($troops as $troop)
        {            
            $troop_sql = "INSERT INTO troops (`player_tag`, `type`, `name`, `level`, `maxLevel`, `village`, `timestamp`) ";
            $troop_sql .= "VALUES ('" . $playerid . "', '" . $type . "', '" . $troop["name"] . "', " . $troop["level"] . ", " . $troop["maxLevel"] . ", '" . $troop["village"] . "', CURRENT_TIMESTAMP) ";
            $troop_sql .= "ON DUPLICATE KEY UPDATE player_tag='" . $playerid . "', type='" . $type . "', name='" . $troop["name"] . "', level=" . $troop["level"] . ", maxLevel=" . $troop["maxLevel"] . ", village='" . $troop["village"] . "', timestamp=CURRENT_TIMESTAMP;\n";           
            
            if (mysqli_query($conn, $troop_sql)) {
                #echo "Record for \"" . $troop["name"] . "\" updated successfully" . "\n";
            } else {
                echo "----- Error updating troop record for player " . $playerid . " and troop " . $troop["name"] . ": " . mysqli_error($conn) . "\n";
            }
        }
}

mysqli_close($conn);
?>
