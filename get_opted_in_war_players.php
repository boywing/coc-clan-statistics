#!/usr/bin/php
<?php

parse_str(implode('&', array_slice($argv, 1)), $_GET);
if (array_key_exists('clantag', $_GET)) {
    $clantag = $_GET['clantag'];
}
else {
    echo "\nNo clan specified, defaulting to #80J0JRLP";
    $clantag = '#80J0JRLP';
}


include "./config.php";
chdir($install_path);

include "./token.php";
include "./mysql_coc.php";

$ThFifteen = [];
$ThFourteen = [];
$ThLowers = [];
$LeftOuts = [];

$MyMinis = [
    [
        'name' => '-= Orz =-',
        'tag' => '#9PLJJPPRR',
        'townHallLevel' => 12
    ],
    [
        'name' => '-= Yehat =-',
        'tag' => '#9QRRUR90R',
        'townHallLevel' => 12        
    ],
    [
        'name' => '-= Ilwrath =-',
        'tag' => '#9RYYJ20U2',
        'townHallLevel' => 13        
    ],
    [
        'name' => 'El Miguel',
        'tag' => '#LVUJULVV',
        'townHallLevel' => 12             
    ],
    [
        'name' => '--== Pkunk ==--',
        'tag' => '#8Q0U2CU2Y',
        'townHallLevel' => 12
    ]
];

$sandbags = [
    [
        'name' => 'Tip1',
        'tag' => '#9CLVUCV2Y',
        'townHallLevel' => 6
    ],
    [
        'name' => '-= Spathi =-',
        'tag' => '#9QV2LR898', 
        'townHallLevel' => 6       
    ]
];

$maxThFourteens = 2;
$maxThFifteens = 10;
$maxThLowers = 10;
$warSize = 20;

$clan_url = "https://api.clashofclans.com/v1/clans/" . urlencode($clantag) . "/members";

$curl_result = callAPI($clan_url, $api_token);

$clan_members = json_decode($curl_result, true);
$members = getMemberStatus($clan_members['items'], $api_token);
clearWarLogRoster($conn);
foreach($members as $member) {
    putWarLogRoster($conn, $member['tag'], $member['name'], $member['warPreference'], 'out', 'N', 'N', 'WarSearch', 'WarSearch');
}

$excludedMembers = getExcludedMemberList($conn);
$includedMembers = getIncludedMemberList($conn);
$membersLeftOutLastWar = getMembersLeftOutLastWar($conn);

$optedInMembers = getOptedInMembers($members);

$warRoster = getWarRoster($conn, $optedInMembers);

echo "\nDraft Roster: \n\n";
$warTHLvl = array_column($warRoster, 'townHallLevel');
array_multisort($warTHLvl , SORT_DESC, $warRoster);
foreach($warRoster as $result) {
    updateWarLogRoster($conn, $result['tag'], 'inwar', 'in');
    echo $result['name']. ", TH";
    echo $result['townHallLevel'];
    echo "\n";
}

echo "\n\nLeft out players - ";
foreach($LeftOuts as $loser) {
    echo "\n" . $loser['name'];
}

function getWarRoster($conn, $optedInMembers): array
{
    global $ThFifteen, $ThFourteen, $ThLowers, $MyMinis, $sandbags, $maxThFourteens, $maxThFifteens, $maxThLowers, $warSize;

    $results = [];

    // first, sort the member list
    sortMemberListByTH($conn, $optedInMembers);

    echo "\nAdding sandbags: ";
    foreach($sandbags as $sandbag) {
        echo $sandbag['name'] . ',';
        array_push($results, $sandbag);
    }

    // next, add lower accounts
    echo "\nAdding lower accounts: ";
    $lowers = trimMemberList($conn, $ThLowers, $maxThLowers);
    foreach($lowers as $member) {
        array_push($results, $member);    
    }

    // add th14s
    // echo "\nAdding TH14s: ";
    // $thfourteens  = trimMemberList($conn, $ThFourteen, $maxThFourteens);
    // foreach ($thfourteens as $member) {
    //     array_push($results, $member);  
    // }

    // add minis
    $remainder = count($results) % 5;
    $numMinisToAdd = 5-$remainder;
    if (count($results) + $numMinisToAdd < ($warSize / 2)) {
        echo "\nNot enough lower players, adding more minis.  Might have to find more people";
        $numMinisToAdd += 5;
    }

    echo "\nTotal number of players so far: " . count($results);
    echo "\nNumber of Minis needed for an even multiple of 10: " . $numMinisToAdd;

    echo "\nAdding Minis: ";
    $miniList = trimMemberList($conn, $MyMinis, $numMinisToAdd);
    foreach($miniList as $member) {
        array_push($results, $member);  
    }

    // add th15s
    $numThFifteensToAdd = $warSize - count($results);

    echo "\nNumber of TH15s to add to get to war size (" . $warSize . "): " . $numThFifteensToAdd;

    if ($numThFifteensToAdd > $maxThFifteens) {
        echo "\nBumping maxTHFifteens to number we need to get to war size";
        $maxThFifteens = $numThFifteensToAdd;
    }

    $thFifteens = [];
    if ($numThFifteensToAdd >= count($ThFifteen)) {
        echo "\nAdding all th15s.  We might still be short on the war roster";
        $thFifteens = $ThFifteen;           
    }
    else {
        $thFifteens = trimMemberList($conn, $ThFifteen, $numThFifteensToAdd);
    }

    foreach($thFifteens as $member) {
        array_push($results, $member);  
    }

    return $results;
}

function putWarLogRoster($conn, $tag, $name, $warPreference, $inWar, $wasOnIncludeList, $wasOnExcludeList, $opponentTag, $opponentName): void 
{
    $sqlStatement = mysqli_prepare($conn, "INSERT INTO war_roster_log (tag, name, warpreference, inwar, wasonincludelist, wasonexcludelist, opponenttag, opponentname, datecreated)" .
        " VALUES (?, ?, ?, ?, ?, ?, ?, ?, now());");
    mysqli_stmt_bind_param($sqlStatement, "ssssssss", $tag, $name, $warPreference, $inWar, $wasOnIncludeList, $wasOnExcludeList, $opponentTag, $opponentName);
    
    $check_result = mysqli_stmt_execute($sqlStatement);
    if (!$check_result) {
        echo "Error excluding member - " . $tag . " - " . $name . " - " . $warPreference . " - " . $inWar . " - " . $wasOnIncludeList . " - " .$wasOnExcludeList . " - ". $opponentTag . " - " . $opponentName. ": " . mysqli_error($conn) . "\n";
    }     
}

function updateWarLogRoster($conn, $tag, $key, $value): void
{
    $sqlStatement = mysqli_prepare($conn, "UPDATE war_roster_log SET " . $key . "=? WHERE tag=? and opponenttag = 'WarSearch';");
    if ($sqlStatement === false) {
        trigger_error($this->mysqli->error, E_USER_ERROR);
        exit;
      }
    mysqli_stmt_bind_param($sqlStatement, "ss", $value, $tag);

    $check_result = mysqli_stmt_execute($sqlStatement);
    if (!$check_result) {
        echo "Error excluding member - " . $tag . " - " . $key . " - " . $value . ": " . mysqli_error($conn) . "\n";
    }        
}

function clearWarLogRoster($conn): void
{
    $sqlStatement = mysqli_prepare($conn, "DELETE from war_roster_log where opponenttag = 'WarSearch';");
    $check_result = mysqli_stmt_execute($sqlStatement);
    if (!$check_result) {
        echo "Error Clearing war_roster_log: " . mysqli_error($conn) . "\n";
    }    
}
function getExcludedMemberList($conn): array
{
    $result = [];
    $sqlStatement = "SELECT tag, name, expires, reason, cwltoo from players_excluded_from_war where expires > now() or expires is null;";
    $check_result = mysqli_query($conn, $sqlStatement);
    if (mysqli_num_rows($check_result) == 0) {
        echo "function getExcludedMemberList:  No rows found in players_excluded_from_war table";
    }
    else {
        while ($row = mysqli_fetch_assoc($check_result)) {
            array_push($result, $row);
        }
    }
    foreach($result as $member) {
        updateWarLogRoster($conn, $member['tag'], 'wasonexcludelist', 'Y');
    }
    return $result;
}

function getIncludedMemberList($conn): array
{
    $result = [];
    $sqlStatement = "SELECT tag, name, expires, reason, cwltoo from players_included_in_war;";
    $check_result = mysqli_query($conn, $sqlStatement);
    if (mysqli_num_rows($check_result) == 0) {
        echo "function getIncludedMemberList:  No rows found in players_included_in_war table";
    }
    else {
        while ($row = mysqli_fetch_assoc($check_result)) {
            array_push($result, $row);
        }
    }
    return $result;
}

function getMembersLeftOutLastWar($conn): array
{
    $result = [];
    $sqlStatement = "select name, tag from war_roster_log where warpreference = 'in' and inwar = 'out' " . 
        "and datecreated = (select max(datecreated) from war_roster_log where opponenttag <> 'WarSearch') " . 
        "and tag not in (select tag from players_excluded_from_war);";
    $check_result = mysqli_query($conn, $sqlStatement);
    if (mysqli_num_rows($check_result) == 0) {
        echo "function getMembersLeftOutLastWar:  No rows returned from sql query: ". $sqlStatement;
    }
    else {
        while ($row = mysqli_fetch_assoc($check_result)) {
            array_push($result, $row);
        }
    }
    return $result;     
}

function excludeMember($conn, $tag, $name, $expires, $reason, $cwltoo): void
{
    $sqlStatement = mysqli_prepare($conn, "INSERT INTO players_excluded_from_war (tag, name, expires, reason, cwltoo) VALUES (?, ?, null, ?, ?);");
    mysqli_stmt_bind_param($sqlStatement, "ssss", $tag, $name, $reason, $cwltoo);
    
    $check_result = mysqli_stmt_execute($sqlStatement);
    if (!$check_result) {
        echo "Error excluding member - " . $tag . " - " . $name . " - " . $expires . " - " . $reason . " - " . $cwltoo . ": " . mysqli_error($conn) . "\n";
    }    
}

function trimMemberList($conn,$members, $max): array
{
    $results = [];
    $membersToAdd = [];
    if(count($members) <= $max) {
        $membersToAdd = $members;
    } else {
        $membersToAdd = pickMembersFromGroup($conn,$members, $max);    
    }
    foreach($membersToAdd as $member) {
        echo $member['name'] . ',';
        array_push($results, $member);
    }
    return $results;
}

function pickMembersFromGroup($conn, $members, $numToPick): array 
{
    global $LeftOuts, $includedMembers, $membersLeftOutLastWar;
    echo "\nGolden Children: ";
    for($i=0; $i<count($members); $i++) {
        $members[$i]['random value'] = rand(0, 100000);

        //set all included members to max random value so they are included in war
        // echo ;

        foreach($includedMembers as $goldenChild) {
            if($members[$i]['tag'] == $goldenChild['tag']) {
                updateWarLogRoster($conn, $goldenChild['tag'], 'wasonincludelist', 'Y');
                $members[$i]['random value'] = 100000;
                echo "\nAlways In list - " .$members[$i]['name'] . ", ";
            }
        }
        // echo ;
        foreach($membersLeftOutLastWar as $goldenChild) {
            if($members[$i]['tag'] == $goldenChild['tag']) {
                updateWarLogRoster($conn, $goldenChild['tag'], 'wasonincludelist', 'Y');
                $members[$i]['random value'] = 100000;
                echo "\nOut last war so in this war - " . $members[$i]['name'] . ", ";
            }
        }
    }

    $randColumn = array_column($members, 'random value');
    $thLevel = array_column($members, 'townHallLevel');
    array_multisort($thLevel, SORT_DESC, $randColumn, SORT_DESC, $members);
    $results = array_slice($members, 0, $numToPick);
    $leftOutList = array_slice($members, $numToPick, count($members));

//     var_dump($members);
//     echo "\n=========================\n";
//     var_dump($results);
//     var_dump($leftOutList);
//     var_dump($numToPick);
//     var_dump(count($members));
// die();

    echo "\nLeft out players - ";
    foreach($leftOutList as $loser) {
        echo "\n" . $loser['name'];
        // var_dump($loser);
        array_push($LeftOuts, $loser);
    }
    return $results;
}

function getTagsFromArray($members) {
    $results = [];
    foreach ($members as $member) {
        array_push($results, $member['tag']);
    }
    return $results;
}

function sortMemberListByTH($conn, $members): void
{
    global $ThFifteen, $ThFourteen, $ThLowers, $MyMinis, $sandbags, $excludedMembers;

    foreach($members as $member) {
        $isExcluded = false;
        foreach($excludedMembers as $excludedMember) {
            if ($member['tag'] == $excludedMember['tag']) {
                echo "\nCan't include " . $member['name'] . " - " . $member['tag'] . " - is part of the exclude list.  Reasion: " . $excludedMember['reason'];
                $isExcluded = true;
            }
        }
        if (!$isExcluded) {
            switch ($member['townHallLevel']) {
                case '15':
                    array_push($ThFifteen, $member);
                    break;
                case '14':
                    // changing this to TH15s because I want to group 15s and 14s together now
                    array_push($ThFifteen, $member);
                    break;
                default:
                    if (!in_array($member['tag'], getTagsFromArray($MyMinis)) && !in_array($member['tag'], getTagsFromArray($sandbags))) {
                        array_push($ThLowers, $member);
                    }
            }
        }

    }
}

function getOptedInMembers($members): array
{
    $results = [];
    foreach($members as $member) {
        if($member['warPreference'] == 'in')
        {
            array_push($results,  $member);
        }
    }
    return $results;
}

function getMemberStatus($members, $api_token): array
{
    echo "\nRetrieving Member List";
    $results = [];
    foreach ($members as $member) {
        echo '.';
        $player_url = "https://api.clashofclans.com/v1/players/" . urlencode($member['tag']);
        $curl_result = callAPI($player_url, $api_token);
        $player_info = json_decode($curl_result, true);
        array_push($results, 
        [
            'name' => $player_info['name'],
            'tag' => $player_info['tag'],
            'townHallLevel' => $player_info['townHallLevel'],
            'warPreference' => $player_info['warPreference'],
            'trophies' => $player_info['trophies']
        ]);
    }

    return $results;
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