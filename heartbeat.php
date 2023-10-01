#!/usr/bin/php
<?php

include "./token.php";
include "./mysql_coc.php";

// Globals
$clantag = '#80J0JRLP';
mysqli_report(MYSQLI_REPORT_ERROR);

$prev_row = getMostRecentHeartbeat($conn);
insertHeartbeatRecord($conn);
$new_row = getMostRecentHeartbeat($conn);

if ($prev_row['state'] != $new_row['state']){
    echo "New state!  Previous state: " . $prev_row['state'] . ", New state: " . $new_row['state'];
    switch($new_row['state']) {
        case 'preparation':
            include "./config.php";
            chdir($update_path);
            include "./update_war_roster_log.php";
            break;               
        case 'warEnded':
            include "./config.php";
            chdir($update_path);
            include "./update_war.php";
            break;            
    }

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

    $sqlStatement = mysqli_prepare($conn, "INSERT INTO heartbeat(state, startTime, endTime, preparationStartTime, hbTimestamp) VALUES (?, ?, ?, ?, UTC_TIMESTAMP())");
    mysqli_stmt_bind_param($sqlStatement, "ssss", $currentwar['state'], $startTime, $endTime, $preparationStartTime);
    
    $check_result = mysqli_stmt_execute($sqlStatement);
    if (!$check_result) {
        echo "Error inserting heartbeat record - " . $currentwar['state'] . " - " . $currentwar['startTime'] . " - " . $currentwar['endTime'] . " - " . $currentwar['preparationStartTime'] . ": " . mysqli_error($conn) . "\n";
    }     
}

function getMostRecentHeartbeat($conn): array
{
    $sqlStatement = "select a.state, a.startTime, a.endTime, a.preparationStartTime, a.hbTimestamp from heartbeat a inner join (select max(hbTimestamp) as hbTimestamp from heartbeat) b on a.hbTimestamp = b.hbTimestamp;";
    $check_result = mysqli_query($conn, $sqlStatement);
    // var_dump(mysqli_num_rows($check_result));
    if (mysqli_num_rows($check_result) == 0) {
        echo "Error; No rows found in heartbeat table";
        insertHeartbeatRecord($conn);
    }
    return mysqli_fetch_assoc($check_result);
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