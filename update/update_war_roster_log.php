#!/usr/bin/php
<?php
global $new_row;
var_dump($currentwar);
include "../mysql_coc.php";
include "../write_log.php";

// parse_str(implode('&', array_slice($argv, 1)), $_GET);
// $clanid = $_GET['clanid'];
$clanid = '#80J0JRLP';
writeLog($conn, "Updating war roster log");

$sqlStatement = "select * from war_roster_log where opponenttag = 'WarSearch';";
$check_result = mysqli_query($conn, $sqlStatement);
if (mysqli_num_rows($check_result) == 0) {
    writeLog($conn, "function update_war_roster_log:  No rows found in players_included_in_war table");
}
else {
    $sqlStatement = "select max(datecreated) from war_roster_log where opponenttag = 'WarSearch';";
    $check_result = mysqli_query($conn, $sqlStatement);
    if (mysqli_num_rows($check_result) == 0) {
        writeLog($conn, "function update_war_roster_log:  " . $sqlStatement);
    }
    $result = mysqli_fetch_assoc($check_result);
    $createdTimestamp = $result['max(datecreated)'];

    // this doesn't work when calling from war prep
    // $sqlStatement = "select tag, name from clans a inner join (select distinct attacker_clan from attacks where startTime > '" . $createdTimestamp . "' and attacker_clan <> '" . $clanid . "') b on a.tag = b.attacker_clan;";
    // // mysqli_stmt_bind_param($sqlStatement, "ss", $createdTimestamp, $clanid);    
    // $check_result = mysqli_query($conn, $sqlStatement);
    // if (mysqli_num_rows($check_result) == 0) {
    //     writeLog($conn, "function update_war_roster_log:  " . $sqlStatement);
    // }
    // $enemyClanDetails = mysqli_fetch_assoc($check_result);  
    // var_dump($enemyClanDetails);

    // newrow inherited from heartbeat
    $enemyClanDetails['tag'] = $currentwar['opponent']['tag'];
    $enemyClanDetails['name'] = $currentwar['opponent']['name'];

    if (array_key_exists('tag', $enemyClanDetails) && array_key_exists('name', $enemyClanDetails)) {
        $sqlStatement = mysqli_prepare($conn, "UPDATE war_roster_log SET opponenttag=?, opponentname=? WHERE opponenttag = 'WarSearch';");
        if ($sqlStatement === false) {
            trigger_error($this->mysqli->error, E_USER_ERROR);
            exit;
          }
        mysqli_stmt_bind_param($sqlStatement, "ss", $enemyClanDetails['tag'], $enemyClanDetails['name']);
    
        $check_result = mysqli_stmt_execute($sqlStatement);
        if (!$check_result) {
            writeLog($conn, "Error excluding member - " . $tag . " - " . $key . " - " . $value . ": " . mysqli_error($conn));
        }  
    }
    else {
        writeLog($conn, "Error getting enemy clan details");
    }
}