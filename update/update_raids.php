#!/usr/bin/php
<?php

parse_str(implode('&', array_slice($argv, 1)), $_GET);
$clanid = $_GET['clanid'];

include "/var/www/html/aktivavikingar/config.php";
chdir($update_path);

include ($secret_path . "token.php");

$url = "https://api.clashofclans.com/v1/clans/" . urlencode($clanid) . "/capitalraidseasons?limit=1";

$curl = curl_init($url);
$header = array();
$header[] = "Accept: application/json";
$header[] = "Content-type: text/html; charset=UTF-8";
$header[] = "Authorization: Bearer ".$api_token;
curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($curl);
$raid_data = json_decode($result, true);
curl_close($curl);

if (isset($raid_data["reason"])) {
    $error = true;
    echo "ERROR!\n";
    echo $raid_data1["reason"];
    echo $raid_data1["message"];
    echo "\n";
}

include ($secret_path . "mysql_coc.php");
$raids = $raid_data["items"];
foreach($raids as $raid)
{
  $our_players = $raid["members"];
  update_raids($our_players);
}

mysqli_close($conn);

function update_raids($players)
{
    global $raid;
    global $conn;
    
    $sT = date_create_from_format('Ymd\THis\.\0\0\0\Z',$raid["startTime"]);
    $startTime = $sT->format('Y-m-d H:i:s');
    
    foreach($players as $player)
        {
            $attacker_tag =  $player["tag"];
	    $attacks =  $player["attacks"];
	    $capitalResourcesLooted =  $player["capitalResourcesLooted"];
            
	    $attack_sql = "SET @attacker_tag = '";
	    $attack_sql .= $attacker_tag;
	    
	    $attack_sql .= "', @attacks = ";
	    $attack_sql .= $attacks;

	    $attack_sql .= ", @capitalResourcesLooted = ";
	    $attack_sql .= $capitalResourcesLooted;

	    $attack_sql .= ", @startTime=STR_TO_DATE('" . $startTime . "', '%Y-%m-%d %H:%i:%s'); ";

	    mysqli_query($conn, $attack_sql);
            
	    $attack_sql = "INSERT INTO raids (`attacker_tag`, `attacks`, `capitalResourcesLooted`, `startTime`) ";
	    $attack_sql .= "VALUES (@attacker_tag, @attacks, @capitalResourcesLooted, @startTime) ";
            $attack_sql .= "ON DUPLICATE KEY UPDATE attacker_tag=@attacker_tag, attacks=@attacks, capitalResourcesLooted=@capitalResourcesLooted, startTime=@startTime;";

	    if (mysqli_query($conn, $attack_sql)) {
	      echo "Raid record for player \"" . $player["name"] . "\" updated successfully" . "\n";
	    } else {
	      echo "----- Error updating raid record for player " . $player["name"] . ": " . mysqli_error($conn) . "\n";
	    }
	}
}

