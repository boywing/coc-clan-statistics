#!/usr/bin/php
<?php

parse_str(implode('&', array_slice($argv, 1)), $_GET);
$clanid = $_GET['clanid'];

include "../token.php";

$url = "https://api.clashofclans.com/v1/clans/" . urlencode($clanid) . "/currentwar";

$curl = curl_init($url);
$header = array();
$header[] = "Accept: application/json";
$header[] = "Authorization: Bearer ".$api_token;
curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($curl);
$war_data = json_decode($result, true);
curl_close($curl);

if (isset($war_data["reason"])) {
    $error = true;
    echo $war_data["reason"];
    echo "\n";
}

#if (($war_data["clan"]["stars"] - $war_data["opponent"]["stars"]) > 0)
#    $result = "Win";
#else
#    $result = "Loss";

$our_players = $war_data["clan"]["members"];
$their_players = $war_data["opponent"]["members"];
$our_clan = $war_data["clan"];
$their_clan = $war_data["opponent"];

update_clan($our_clan);
update_clan($their_clan);
update_players($our_players, $our_clan);
update_players($their_players, $their_clan);
if($war_data["state"] == "inWar")
    {
        update_attacks($our_players, $our_clan,  $their_clan);
        update_attacks($their_players, $their_clan, $our_clan);
    }

function update_attacks($players, $clan, $opponent)
{
    global $war_data;

    $sT = date_create_from_format('Ymd\THis\.\0\0\0\Z',$war_data["startTime"]);
    $startTime = $sT->format('Y-m-d H:i:s');
    
    foreach($players as $player)
        {
            $attacker_tag =  $player["tag"];
            $attacker_clan = $clan["tag"];
            $attacker_th = $player["townhallLevel"];
            $attacker_map_pos = $player["mapPosition"];
            $defender_clan = $opponent["tag"];
            
            if(isset($player["attacks"]))
                {
                    foreach($player["attacks"] as $attack)
                        {          
                            $attack_sql  = "SET @attacker_tag = '";
                            $attack_sql .= $attacker_tag;
                            $attack_sql .= "', @attacker_clan = '";
                            $attack_sql .= $attacker_clan;
                            
                            $attack_sql .= "', @defender_tag = '";
                            $attack_sql .= $attack["defenderTag"];
                            $attack_sql .= "', @defender_clan = '";
                            $attack_sql .= $defender_clan;
                            $attack_sql .= "', @attacker_th = ";
                            $attack_sql .= $attacker_th;
                            
                            $key = array_search($attack["defenderTag"], array_column($opponent["members"], 'tag'));
                            $attack_sql .= ", @defender_th = ";
                            $attack_sql .= $opponent["members"][$key]["townhallLevel"];
                            
                            $attack_sql .= ", @attacker_map_pos = ";
                            $attack_sql .= $attacker_map_pos;
                            $attack_sql .= ", @defender_map_pos = ";
                            $attack_sql .= $opponent["members"][$key]["mapPosition"];
                            
                            $attack_sql .= ", @attack_stars = ";
                            $attack_sql .= $attack["stars"];
                            $attack_sql .= ", @destructionPercentage = ";
                            $attack_sql .= $attack["destructionPercentage"];
                            $attack_sql .= ", @order = ";
                            $attack_sql .= $attack["order"];
                            $attack_sql .= ", @startTime=STR_TO_DATE('" . $startTime . "', '%Y-%m-%d %H:%i:%s'); ";
                            
                            $attack_sql .= "INSERT INTO attacks (`attacker_tag`, `defender_tag`, `attacker_clan`, `defender_clan`, `attacker_th`, `defender_th`, `attacker_map_pos`, `defender_map_pos`, `attack_stars`, `destructionPercentage`, `startTime`, `order`) ";
                            $attack_sql .= "VALUES (@attacker_tag, @defender_tag, @attacker_clan, @defender_clan, @attacker_th, @defender_th, @attacker_map_pos, @defender_map_pos, @attack_stars, @destructionPercentage, @startTime, @order);";
                           
                            include "../mysql_coc.php";
                            if (mysqli_multi_query($conn, $attack_sql)) {
                                echo "Attack record for \"" . $player["name"] . "\" updated successfully" . "\n";
                            } else {
                                echo "Error updating attack record for " . $player["name"] . ": " . mysqli_error($conn) . "\n";
                            }
                            mysqli_close($conn);
                        }
                }
        }  
}

    
function update_clan($clan)
{
    $clan_sql  = "SET @tag = '";
    $clan_sql .= $clan["tag"];
    $clan_sql .= "', @name = '";
    $clan_sql .= $clan["name"];
    $clan_sql .= "', @clanLevel = ";
    $clan_sql .= $clan['clanLevel'];
    $clan_sql .= ", @timestamp = CURRENT_TIMESTAMP;" . "\n" . "INSERT INTO clans (`tag`,`name`,`clanLevel`,`timestamp`) VALUES (@tag,@name,@clanLevel,@timestamp) ON DUPLICATE KEY UPDATE tag = @tag,name = @name,clanLevel=@clanLevel,timestamp=@timestamp;";
    
    include "../mysql_coc.php";
    
    if (mysqli_multi_query($conn, $clan_sql)) {
        echo "Record for \"" . $clan["name"] . "\" updated successfully" . "\n";
    } else {
        echo "Error updating record for " . $clan["name"] . ": " . mysqli_error($conn) . "\n";
    }
    mysqli_close($conn);   
}

function update_players($players, $clan)
{
    foreach($players as $player)
        {
            include "../mysql_coc.php";

            $player_sql  = "SET @tag = '";
            $player_sql .= $player["tag"];
            $player_sql .= "', @name = '";
            $player_sql .= mysqli_real_escape_string($conn, $player["name"]);
            $player_sql .= "', @clan_tag = '";
            $player_sql .= $clan["tag"];
            $player_sql .= "', @clan_name = '";
            $player_sql .= $clan["name"]; 
            $player_sql .= "', @timestamp = CURRENT_TIMESTAMP;" . "\n";
            $player_sql .= "INSERT INTO players (`tag`, `name`, `clan_tag`, `clan_name`, `timestamp`) ";
            $player_sql .= "VALUES (@tag, @name, @clan_tag, @clan_name, @timestamp) ";
            $player_sql .= "ON DUPLICATE KEY UPDATE tag=@tag, name=@name, clan_tag=@clan_tag, clan_name=@clan_name, timestamp=@timestamp;";

            if (mysqli_multi_query($conn, $player_sql)) {
                echo "Record for \"" . $player["name"] . "\" updated successfully" . "\n";
            } else {
                echo "Error updating player record for " . $player["name"] . ": " . mysqli_error($conn) . "\n";
            }
            mysqli_close($conn);
        }
}