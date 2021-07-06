#!/usr/bin/php
<?php

parse_str(implode('&', array_slice($argv, 1)), $_GET);
$clanid = $_GET['clanid'];

include "/var/www/html/config.php";
chdir($update_path);

include "/etc/ClashOfClans/token.php";

$url = "https://api.clashofclans.com/v1/clans/" . urlencode($clanid);
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
$clan_data = json_decode($result, true);
curl_close($curl);

if (isset($clan_data["reason"])) {
    $error = true;
    echo $clan_data["reason"];
    echo "\n";
}

include "/etc/ClashOfClans/mysql_coc.php";

$clan_sql  = "SET @tag = '" . $clan_data["tag"];
$clan_sql .= "', @name = '" . mysqli_real_escape_string($conn, $clan_data["name"]);
$clan_sql .= "', @description = '" . mysqli_real_escape_string($conn, $clan_data["description"]);
$clan_sql .= "', @location = '" . $clan_data['location']['name'];
$clan_sql .= "', @badge = '" . $clan_data['badgeUrls']['medium'];
$clan_sql .= "', @clanLevel = " . $clan_data['clanLevel'];
$clan_sql .= ", @clanPoints = " . $clan_data['clanPoints'];
$clan_sql .= ", @clanVersusPoints = " . $clan_data['clanVersusPoints'];
$clan_sql .= ", @requiredTrophies = " . $clan_data['requiredTrophies'];
$clan_sql .= ", @warFrequency = '" . $clan_data['warFrequency'];
$clan_sql .= "', @warWinStreak = " . $clan_data['warWinStreak'];
$clan_sql .= ", @warWins = " . $clan_data['warWins'];
if($clan_data['isWarLogPublic'] == true)
{
    $clan_sql .= ", @warTies = " . $clan_data['warTies'];
    $clan_sql .= ", @warLosses = " . $clan_data['warLosses'];
}
else
    {
        $clan_sql .= ", @warTies = 0";
        $clan_sql .= ", @warLosses = 0";
    }
$clan_sql .= ", @members = " . $clan_data['members'];
$clan_sql .= ", @timestamp = CURRENT_TIMESTAMP;";

mysqli_query($conn, $clan_sql);
$clan_sql = "INSERT INTO clans (`tag`,`name`,`description`,`location`,`badge`,`clanLevel`,`clanPoints`,`clanVersusPoints`,`requiredTrophies`,`warFrequency`,`warWinStreak`,`warWins`,`warTies`,`warLosses`,`members`,`timestamp`) VALUES (@tag,@name,@description,@location,@badge,@clanLevel,@clanPoints,@clanVersusPoints,@requiredTrophies,@warFrequency,@warWinStreak,@warWins,@warTies,@warLosses,@members,@timestamp) ON DUPLICATE KEY UPDATE tag = @tag,name = @name,description=@description,location=@location,badge=@badge,clanLevel=@clanLevel,clanPoints=@clanPoints,clanVersusPoints=@clanVersusPoints,requiredTrophies=@requiredTrophies,warFrequency=@warFrequency,warWinStreak=@warWinStreak,warWins=@warWins,warTies=@warTies,warLosses=@warLosses,members=@members,timestamp=@timestamp;";

if (mysqli_query($conn, $clan_sql)) {
    echo "Record for clan \"" . $clan_data["name"] . "\" updated successfully" . " -------------------\n";
} else {
    echo "----- Error updating record for " . $clan_data["name"] . ": " . mysqli_error($conn) . "\n";
}

$current_members = "('dummy'";

$players = $clan_data["memberList"];
foreach ($players as $player)
    {
        #$player_tag_url = urlencode($player["tag"]);
        $current_members .= ",'" . $player["tag"] . "'";

        #include "../mysql_coc.php";

        $player_sql  = "SET @tag = '" . $player["tag"];
        $player_sql .= "', @name = '" . mysqli_real_escape_string($conn, $player["name"]);
        $player_sql .= "', @role = '" . $player["role"];
        $player_sql .= "', @expLevel = " . $player["expLevel"];
        if(isset($player["league"]["iconUrls"]["medium"]))
            {
                $player_sql .= ", @league = '" . $player["league"]["iconUrls"]["medium"] . "'";
            }
        $player_sql .= ", @trophies = " . $player["trophies"];
        $player_sql .= ", @donations = " . $player["donations"];
        $player_sql .= ", @donationsReceived = " . $player["donationsReceived"];
        $player_sql .= ", @clan_tag = '" . $clan_data["tag"];
        $player_sql .= "', @clan_name = '" . $clan_data["name"];
        $player_sql .= "', @timestamp = CURRENT_TIMESTAMP;" . "\n";
        mysqli_query($conn, $player_sql);
        
        $player_sql = "INSERT INTO players (`tag`, `name`, `role`, `expLevel`, `league`, `trophies`, `donations`, `donationsReceived`,`clan_tag`, `clan_name`, `timestamp`) ";
        $player_sql .= "VALUES (@tag, @name, @role, @expLevel, @league, @trophies, @donations, @donationsReceived, @clan_tag, @clan_name, @timestamp) ";
        $player_sql .= "ON DUPLICATE KEY UPDATE tag=@tag, name=@name, role=@role, expLevel=@expLevel, league=@league, trophies=@trophies, donations=@donations, donationsReceived=@donationsReceived, clan_tag=@clan_tag, clan_name=@clan_name, timestamp=@timestamp;";
        
        if (mysqli_query($conn, $player_sql)) {
            echo "Record for player \"" . $player["name"] . "\" updated successfully" . "\n";
        } else {
            echo "----- Error updating record for " . $player["name"] . ": " . mysqli_error($conn) . "\n";
        }
    }

$current_members .= ")";
$remove_sql = "UPDATE players SET clan_tag=NULL, clan_name=NULL WHERE clan_tag='" . $clan_data["tag"] . "' AND tag NOT IN " . $current_members;

include "/etc/ClashOfClans/mysql_coc.php";
if (!mysqli_multi_query($conn, $remove_sql)) {
    echo "----- Error removing old members in clan: " . mysqli_error($conn) . "\n";
}
mysqli_close($conn);

?>
