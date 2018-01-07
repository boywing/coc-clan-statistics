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
$player_data = json_decode($result, true);
curl_close($curl);

if (isset($player_data["reason"])) {
    $error = true;
    echo $player_data["reason"];
    echo "\n";
}
