#!/usr/bin/php
<?php

include "./token.php";
include "./mysql_coc.php";

// Globals
$clantag = '#80J0JRLP';

$sqlStatement = "select state, startTime, endTime, preparationStartTime, max(hbTimestamp) as hbTimestamp from heartbeat;";
$check_result = mysqli_query($conn, $sqlStatement);
var_dump(mysqli_num_rows($check_result));
if (mysqli_num_rows($check_result) == 0) {
    echo "Error; No rows found in heartbeat table";
    insertHeartbeatRecord($conn);
}
$row = mysqli_fetch_assoc($check_result);
$now = gmdate('Y-m-d H:i:s');
var_dump($row['endTime'], $now);
die('Timestamps are for whole war, prep and in war both.  Need to work on logic for when to write a heartbeat record');
if (array_key_exists('endTime', $row)) {
    if (is_null($row['endTime']) || $row['endTime'] < $now) {
        insertHeartbeatRecord($conn);
    }
}
else {
    insertHeartbeatRecord($conn);
}

function insertHeartbeatRecord($conn): void
{
    global $clantag, $api_token;

    $currentwar_url = "https://api.clashofclans.com/v1/clans/" . urlencode($clantag) . "/currentwar";
    $curl_result = callAPI($currentwar_url, $api_token);
    $currentwar = json_decode($curl_result, true);

    // convert to sql datetime format
    $sT = date_create_from_format('Ymd\THis\.\0\0\0\Z',$currentwar['startTime']);
    $startTime = $sT->format('Y-m-d H:i:s');
    $eT = date_create_from_format('Ymd\THis\.\0\0\0\Z',$currentwar['endTime']);
    $endTime = $eT->format('Y-m-d H:i:s');
    $pST = date_create_from_format('Ymd\THis\.\0\0\0\Z',$currentwar['preparationStartTime']);
    $preparationStartTime = $pST->format('Y-m-d H:i:s');

    $sqlStatement = mysqli_prepare($conn, "INSERT INTO heartbeat(state, startTime, endTime, preparationStartTime, hbTimestamp) VALUES (?, ?, ?, ?, GETUTCDATE())");
    mysqli_stmt_bind_param($sqlStatement, "ssss", $currentwar['state'], $startTime, $endTime, $preparationStartTime);
    
    $check_result = mysqli_stmt_execute($sqlStatement);
    if (!$check_result) {
        echo "Error inserting heartbeat record - " . $currentwar['state'] . " - " . $currentwar['startTime'] . " - " . $currentwar['endTime'] . " - " . $currentwar['preparationStartTime'] . ": " . mysqli_error($conn) . "\n";
    }     
}

function callAPI($url, $api_token) 
{
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
    curl_close($curl);
    return $curl_result;
}