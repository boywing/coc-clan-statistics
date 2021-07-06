#!/usr/bin/php
<?php

parse_str(implode('&', array_slice($argv, 1)), $_GET);
$clantag = $_GET['clantag'];

include "/var/www/html/config.php";
chdir($update_path);

include ($secret_path . "token.php");

$url = "https://api.clashofclans.com/v1/clans/" . urlencode($clantag) . "/warlog";

$curl = curl_init($url);
$header = array();
$header[] = "Accept: application/json";
$header[] = "Content-type: text/html; charset=UTF-8";
$header[] = "Authorization: Bearer ".$api_token;
curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$curl_result = curl_exec($curl);
$war_items = json_decode($curl_result, true);
curl_close($curl);

if (isset($war_item["reason"])) {
    $error = true;
    echo $war_item["reason"];
    echo "\n";
}

include ($secret_path . "mysql_coc.php");

$wars = $war_items['items'];
foreach ($wars as $war)
    {
        $war_sql  = "SET @result = '" . $war["result"];
        
        $eT = date_create_from_format('Ymd\THis\.\0\0\0\Z',$war["endTime"]);
        $endTime = $eT->format('Y-m-d H:i:s');
        $war_sql .= "', @endTime=STR_TO_DATE('" . $endTime . "', '%Y-%m-%d %H:%i:%s') ";

        $war_sql .= ", @teamSize = '" . $war["teamSize"];
        $war_sql .= "', @clan1_tag = '" . $war["clan"]["tag"];
        $war_sql .= "', @clan1_name = '" . mysqli_real_escape_string($conn, $war["clan"]["name"]);
        $war_sql .= "', @clan1_level = '" . $war["clan"]["clanLevel"];
        $war_sql .= "', @clan1_attacks = '" . $war["clan"]["attacks"];
        $war_sql .= "', @clan1_stars = '" . $war["clan"]["stars"];
        $war_sql .= "', @clan1_destructionPercentage = " . $war["clan"]["destructionPercentage"];

        $war_sql .= ", @clan2_tag = '" . $war["opponent"]["tag"];
        $war_sql .= "', @clan2_name = '" . mysqli_real_escape_string($conn, $war["opponent"]["name"]);
        $war_sql .= "', @clan2_level = '" . $war["opponent"]["clanLevel"];
        if(isset($war["opponent"]["attacks"]))
            {
                $war_sql .= "', @clan2_attacks = " . $war["opponent"]["attacks"];
            }
        else
            $war_sql .= "', @clan2_attacks = 0";

        $war_sql .= ", @clan2_stars = '" . $war["opponent"]["stars"];
        $war_sql .= "', @clan2_destructionPercentage = " . $war["opponent"]["destructionPercentage"] . ";\n";

        $war_sql .= "INSERT INTO wars (`result`, `endTime`, `teamSize`, `clan1_tag`, `clan1_name`, `clan1_level`, `clan1_attacks`, `clan1_stars`,`clan1_destructionPercentage`, `clan2_tag`, `clan2_name`, `clan2_level`, `clan2_attacks`, `clan2_stars`, `clan2_destructionPercentage`) ";
        $war_sql .= "VALUES (@result, @endTime, @teamSize, @clan1_tag, @clan1_name, @clan1_level, @clan1_attacks, @clan1_stars, @clan1_destructionPercentage, @clan2_tag, @clan2_name, @clan2_level, @clan2_attacks, @clan2_stars, @clan2_destructionPercentage) ";
        $war_sql .= "ON DUPLICATE KEY UPDATE result=@result, clan1_stars=@clan1_stars, clan2_stars=@clan2_stars, clan1_destructionPercentage=@clan1_destructionPercentage, clan2_destructionPercentage=@clan2_destructionPercentage, clan1_attacks=@clan1_attacks;";

        $check_sql = "SELECT count(*) from wars where endTime=STR_TO_DATE('" . $endTime . "', '%Y-%m-%d %H:%i:%s') AND (clan1_tag = '" . $clantag . "' OR clan2_tag = '". $clantag . "')";

        $check_result = mysqli_query($conn, $check_sql);
        $check = mysqli_fetch_row($check_result);
        if($check[0]< 1)
            {
                if (mysqli_multi_query($conn, $war_sql)) {
                    echo "Record for \"" . $war["clan"]["name"] . "\" vs. \"" . $war["opponent"]["name"] . "\" updated successfully" . "\n";
                } else {
                    echo "Error updating record for " . $war["clan"]["name"] . ": " . mysqli_error($conn) . "\n";
                }
                
                while(mysqli_more_results($conn))
                    {
                        mysqli_next_result($conn);
                    }
            }
    }
mysqli_close($conn);

?>
