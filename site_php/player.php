<?php

$player_sql = "select *,
(SELECT ROUND(AVG(attack_stars),1) FROM attacks WHERE attacker_tag = p.tag AND attacker_th = defender_th AND attacker_map_pos = defender_map_pos) as mirr_stars,
(SELECT ROUND(AVG(attack_stars),1) FROM attacks WHERE attacker_tag = p.tag AND attacker_th = defender_th AND defender_th = p.townHallLevel) as th_stars,
(SELECT ROUND(AVG(destructionPercentage)) FROM attacks WHERE attacker_tag = p.tag AND attacker_th = defender_th AND attacker_map_pos = defender_map_pos) as mirr_percentage, 
(SELECT ROUND(AVG(destructionPercentage)) FROM attacks WHERE attacker_tag = p.tag AND attacker_th = defender_th AND defender_th = p.townHallLevel) as th_percentage, 
(select round(avg(attack_stars),1) from attacks where attacker_tag = p.tag) as stars, 
(select round(avg(attack_stars),1) from attacks where defender_tag = p.tag) as def_stars, 
(select round(avg(destructionPercentage)) from attacks where attacker_tag = p.tag) as percentage, 
(select round(avg(destructionPercentage)) from attacks where defender_tag = p.tag) as def_percentage, 
(select count(*) from attacks where attacker_tag = p.tag and attack_stars=3) as three_stars, 
(select count(*) from attacks where attacker_tag = p.tag) as attacks, 
(select MAX(startTime) from attacks where attacker_tag = tag) AS last_war,
(select ROUND(AVG(attack_stars),1) from attacks where defender_th = 3 AND attacker_tag = p.tag) AS th3, 
(select ROUND(AVG(attack_stars),1) from attacks where defender_th = 4 AND attacker_tag = p.tag) AS th4, 
(select ROUND(AVG(attack_stars),1) from attacks where defender_th = 5 AND attacker_tag = p.tag) AS th5, 
(select ROUND(AVG(attack_stars),1) from attacks where defender_th = 6 AND attacker_tag = p.tag) AS th6, 
(select ROUND(AVG(attack_stars),1) from attacks where defender_th = 7 AND attacker_tag = p.tag) AS th7, 
(select ROUND(AVG(attack_stars),1) from attacks where defender_th = 8 AND attacker_tag = p.tag) AS th8, 
(select ROUND(AVG(attack_stars),1) from attacks where defender_th = 9 AND attacker_tag = p.tag) AS th9, 
(select ROUND(AVG(attack_stars),1) from attacks where defender_th = 10 AND attacker_tag = p.tag) AS th10, 
(select ROUND(AVG(attack_stars),1) from attacks where defender_th = 11 AND attacker_tag = p.tag) AS th11, 
(select ROUND(AVG(attack_stars),1) from attacks where defender_th = 12 AND attacker_tag = p.tag) AS th12, 
(SELECT round(avg(destructionPercentage)) FROM attacks WHERE defender_th = 3 AND attacker_tag = p.tag) as th3_percent, 
(SELECT round(avg(destructionPercentage)) FROM attacks WHERE defender_th = 4 AND attacker_tag = p.tag) as th4_percent, 
(SELECT round(avg(destructionPercentage)) FROM attacks WHERE defender_th = 5 AND attacker_tag = p.tag) as th5_percent, 
(SELECT round(avg(destructionPercentage)) FROM attacks WHERE defender_th = 6 AND attacker_tag = p.tag) as th6_percent, 
(SELECT round(avg(destructionPercentage)) FROM attacks WHERE defender_th = 7 AND attacker_tag = p.tag) as th7_percent, 
(SELECT round(avg(destructionPercentage)) FROM attacks WHERE defender_th = 8 AND attacker_tag = p.tag) as th8_percent, 
(SELECT round(avg(destructionPercentage)) FROM attacks WHERE defender_th = 9 AND attacker_tag = p.tag) as th9_percent, 
(SELECT round(avg(destructionPercentage)) FROM attacks WHERE defender_th = 10 AND attacker_tag = p.tag) as th10_percent, 
(SELECT round(avg(destructionPercentage)) FROM attacks WHERE defender_th = 11 AND attacker_tag = p.tag) as th11_percent, 
(SELECT round(avg(destructionPercentage)) FROM attacks WHERE defender_th = 12 AND attacker_tag = p.tag) as th12_percent, 
(select COUNT(*) from attacks where defender_th = 3 AND attacker_tag = p.tag) AS th3_attacks, 
(select COUNT(*) from attacks where defender_th = 4 AND attacker_tag = p.tag) AS th4_attacks, 
(select COUNT(*) from attacks where defender_th = 5 AND attacker_tag = p.tag) AS th5_attacks, 
(select COUNT(*) from attacks where defender_th = 6 AND attacker_tag = p.tag) AS th6_attacks, 
(select COUNT(*) from attacks where defender_th = 7 AND attacker_tag = p.tag) AS th7_attacks, 
(select COUNT(*) from attacks where defender_th = 8 AND attacker_tag = p.tag) AS th8_attacks, 
(select COUNT(*) from attacks where defender_th = 9 AND attacker_tag = p.tag) AS th9_attacks, 
(select COUNT(*) from attacks where defender_th = 10 AND attacker_tag = p.tag) AS th10_attacks, 
(select COUNT(*) from attacks where defender_th = 11 AND attacker_tag = p.tag) AS th11_attacks, 
(select COUNT(*) from attacks where defender_th = 12 AND attacker_tag = p.tag) AS th12_attacks, 
createDate FROM players p WHERE tag = '" . $playertag . "'";

$troops_sql = "SELECT * FROM troops WHERE player_tag = '" . $playertag . "' AND village = 'home' ORDER by type desc, name";

include "../mysql_coc.php";

if($result = mysqli_query($conn, $player_sql))
    {
        if (mysqli_num_rows($result) > 0)
            {
                $player = mysqli_fetch_assoc($result);                
            }
        else
            {
                echo "Error fetching data for player $playertag <br>";
            }
    }
else
    {
        echo "<br>FAIL! - " . mysqli_error($conn) . "<br>";
    }
mysqli_close($conn);

$content = "<h1><img src=\"" . $player['league'] . "\" height=100>" . $player['name'] . "</h1>";
$content .= '<table width=400 class="table-light" style="border-collapse: separate; border-spacing: 1px;border:1px solid black;">';
$content .= "<tr><td>Tag </td><td> " . $player['tag'] . "</td></tr>";
$content .= "<tr><td>TH </td><td> " . $player['townHallLevel'] . "</td></tr>";
$content .= "<tr><td>Clan </td><td> " . $player['clan_name'] . "</td></tr>";
$content .= "<tr><td>Level </td><td> " . $player['expLevel'] . "</td></tr>";
$content .= "<tr><td>Trophies </td><td> " . $player['trophies'] . "</td></tr>";
$content .= "<tr><td>Best Trophies </td><td> " . $player['bestTrophies'] . "</td></tr>";
$content .= "<tr><td>War Stars </td><td> " . $player['warStars'] . "</td></tr>";
$content .= "<tr><td>Attack stars per war</td><td> " . $player['stars'] . " @ " . $player['percentage'] . "%</td></tr>";
$content .= "<tr><td>Attack stars mirror</td><td> " . $player['mirr_stars'] . " @ " . $player['mirr_percentage'] . "%</td></tr>";
$content .= "<tr><td>Attack stars same TH</td><td> " . $player['th_stars'] . " @ " . $player['th_percentage'] . "%</td></tr>";
$content .= "<tr><td>Def stars per war</td><td> " . $player['def_stars'] . " @ " . $player['def_percentage'] . "%</td></tr>";
$content .= "<tr><td>3-Stars </td><td> " . $player['three_stars'] . "</td></tr>";
$content .= "<tr><td>BH </td><td> " . $player['builderHallLevel'] . "</td></tr>";
$content .= "<tr><td>BH Trophies </td><td> " . $player['versusTrophies'] . "</td></tr>";
$content .= "<tr><td>BH Best Trophies </td><td> " . $player['bestVersusTrophies'] . "</td></tr>";
$content .= "<tr><td>BH Battle Wins </td><td> " . $player['versusBattleWins'] . "</td></tr>";
$content .= "<tr><td>Role </td><td> " . $player['role'] . "<br></td></tr>";
$content .= "<tr><td>Donations </td><td> " . $player['donations'] . "</td></tr>";
$content .= "<tr><td>Received </td><td> " . $player['donationsReceived'] . "</td></tr>";
$content .= "<tr><td>Updated </td><td> " . $player['timestamp'] . "</td></tr>";
$content .= "<tr><td>Last war </td><td> " . $player['last_war'] . "</td></tr>";
$content .= "<tr><td>Create Date </td><td> " . $player['createDate'] . "</td></tr>";
$content .= "</table>";

$content .= '<br><div class="left small-shadow"><h2>Troops</h2>';

include "../mysql_coc.php";
$content .= '<table width=200 style="border-collapse: separate; border-spacing: 1px;border:1px solid black;"><tr>';
$troops = 0;
if($result = mysqli_query($conn, $troops_sql))
    {
        if (mysqli_num_rows($result) > 0)
            {
                while($troop = mysqli_fetch_assoc($result))
                    {
                        if(($troops++ % 10) == 0)
                            $content .= "</tr><tr>";
                        $content .= "<td><div style=\"background-image: url('images/" . $troop['name'] . ".png'); background-size: auto 50px; width: 50px; height: 50px;text-shadow: -1px -1px 0 #fff, 1px -1px 0 #fff, -2px 3px 0px #fff, 1px 3px 0 #fff;\"><span class=\"center\"><b>" . $troop['level'] . "</b></span></div></td>";
                    }
            }
        else
            {
                echo "Error fetching data for player $playertag <br>";
            }
    }
else
    {
        echo "<br>FAIL! - " . mysqli_error($conn) . "<br>";
    }
mysqli_close($conn);

$content .= "</div></tr></table>";

$content .= "<p><h2>Average stars against TH</h2>";
$content .= '<table class="table table-light" style="border-collapse: separate; border-spacing: 1px;border:1px solid black;" border=1>';
$content .= '<thead class="thead-dark"><th>TH12</th><th>TH11</th><th>TH10</th><th>TH9</th><th>TH8</th><th>TH7</th><th>TH6</th><th>TH5</th><th>TH4</th><th>TH3</th></thead>';
$content .= "<tbody><tr>";
if(empty($player['th12']))
    $content .= "<td></td>";
else
    $content .= "<td>" . $player['th12'] . " @ " . $player['th12_percent'] . "% (" . $player['th12_attacks'] . " st)</td>";
if(empty($player['th11']))
    $content .= "<td></td>";
else
$content .= "<td>" . $player['th11'] . " @ " . $player['th11_percent'] . "% (" . $player['th11_attacks'] . " st)</td>";
if(empty($player['th10']))
    $content .= "<td></td>";
else
$content .= "<td>" . $player['th10'] . " @ " . $player['th10_percent'] . "% (" . $player['th10_attacks'] . " st)</td>";
if(empty($player['th9']))
    $content .= "<td></td>";
else
$content .= "<td>" . $player['th9'] . " @ " . $player['th9_percent'] . "% (" . $player['th9_attacks'] . " st)</td>";
if(empty($player['th8']))
    $content .= "<td></td>";
else
$content .= "<td>" . $player['th8'] . " @ " . $player['th8_percent'] . "% (" . $player['th8_attacks'] . " st)</td>";
if(empty($player['th7']))
    $content .= "<td></td>";
else
$content .= "<td>" . $player['th7'] . " @ " . $player['th7_percent'] . "% (" . $player['th7_attacks'] . " st)</td>";
if(empty($player['th6']))
    $content .= "<td></td>";
else
$content .= "<td>" . $player['th6'] . " @ " . $player['th6_percent'] . "% (" . $player['th6_attacks'] . " st)</td>";
if(empty($player['th5']))
    $content .= "<td></td>";
else
$content .= "<td>" . $player['th5'] . " @ " . $player['th5_percent'] . "% (" . $player['th5_attacks'] . " st)</td>";
if(empty($player['th4']))
    $content .= "<td></td>";
else
$content .= "<td>" . $player['th4'] . " @ " . $player['th4_percent'] . "% (" . $player['th4_attacks'] . " st)</td>";
if(empty($player['th3']))
    $content .= "<td></td>";
else
$content .= "<td>" . $player['th3'] . " @ " . $player['th3_percent'] . "% (" . $player['th3_attacks'] . " st)</td>";
$content .= "</tr></body></table>";

$content .= "<p><h2>Attacks</h2>";
$content .= '<table class="table table-light" style="border-collapse: separate; border-spacing: 1px;border:1px solid black;" border=1>';
$content .= '<thead class="thead-dark"><th>Date</th><th>Attacker clan</th><th>Attacker TH</th><th>Defender</th><th>Defender TH</th><th>Defender Clan</th><th>Stars</th><th>Delta</th></thead>';
$content .= "<tbody>";

$attack_sql = "SELECT startTime, defender_tag, 
(SELECT name FROM clans WHERE tag=a.attacker_clan) AS attacker_clan_name, 
(SELECT name FROM players WHERE tag=a.defender_tag) AS defender, 
attacker_clan, defender_clan, 
(SELECT name FROM clans WHERE tag=a.defender_clan) AS defender_clan_name, 
attack_stars, destructionPercentage, attacker_th, defender_th, attacker_map_pos-defender_map_pos AS delta FROM attacks a WHERE attacker_tag = '" . $playertag . "'";

    
include "../mysql_coc.php";
if($result = mysqli_query($conn, $attack_sql))
    {
        if (mysqli_num_rows($result) > 0)
            {
                while($attack = mysqli_fetch_assoc($result))
                    {
                        $content .= "<tr>";
                        $content .= "<td>" . $attack['startTime'] . '</td>';
                        $content .= '<td><a href="?mode=clan&clantag=' . urlencode($attack['attacker_clan']) . '">' . $attack['attacker_clan_name'] . "</a></td>";
                        $content .= "<td>" . $attack['attacker_th'] . '</td>';
                        $content .= '<td><a href="?mode=player&playertag=' . urlencode($attack['defender_tag']) . '">' . $attack['defender'] . "</a></td>";
                        $content .= "<td>" . $attack['defender_th'] . "</td>";
                        $content .= '<td><a href="?mode=clan&clantag=' . urlencode($attack['defender_clan']) . '">' . $attack['defender_clan_name'] . "</a></td>";
                        $content .= "<td>" . $attack['attack_stars'] . "* " . $attack['destructionPercentage'] . "%</td><td>" . $attack['delta'] . "</td>";
                        $content .= "</tr>";
                    }
            }
        else
            {
                echo "Error fetching data for player $playertag <br>";
            }
    }
else
    {
        echo "<br>FAIL! - " . mysqli_error($conn) . "<br>";
    }
$content .= "</tbody></table>";

mysqli_close($conn);

$content .= "<p><h2>Defences</h2>";
$content .= '<table class="table table-light" style="border-collapse: separate; border-spacing: 1px;border:1px solid black;" border=1>';
$content .= '<thead class="thead-dark"><th>Date</th><th>Defender Clan</th><th>Attacker</th><th>TH</th><th>Attacker Clan</th><th>Stars</th><th>Delta</th></thead>';
$content .= "<tbody>";

$attack_sql = "SELECT startTime, attacker_tag, 
(SELECT name FROM clans WHERE tag=a.defender_clan) AS defender_clan_name, 
(SELECT name FROM players WHERE tag=a.attacker_tag) AS attacker, 
attacker_clan, 
(SELECT name FROM clans WHERE tag=a.attacker_clan) AS attacker_clan_name, 
attack_stars, destructionPercentage, attacker_th, attacker_map_pos-defender_map_pos AS delta FROM attacks a WHERE defender_tag = '" . $playertag . "'";

    
include "../mysql_coc.php";
if($result = mysqli_query($conn, $attack_sql))
    {
        if (mysqli_num_rows($result) > 0)
            {
                while($attack = mysqli_fetch_assoc($result))
                    {
                        $content .= "<tr>";
                        $content .= "<td>" . $attack['startTime'] . '</td>';
                        $content .= '<td><a href="?mode=clan&clantag=' . urlencode($attack['defender_clan']) . '">' . $attack['defender_clan_name'] . "</a></td>";                        
                        $content .= '<td><a href="?mode=player&playertag=' . urlencode($attack['attacker_tag']) . '">' . $attack['attacker'] . "</a></td>";
                        $content .= "<td>" . $attack['attacker_th'] . "</td>";
                        $content .= '<td><a href="?mode=clan&clantag=' . urlencode($attack['attacker_clan']) . '">' . $attack['attacker_clan_name'] . "</a></td>";
                        $content .= "<td>" . $attack['attack_stars'] . "* " . $attack['destructionPercentage'] . "%</td><td>" . $attack['delta'] . "</td>";
                        $content .= "</tr>";
                    }
            }
        else
            {
                echo "Error fetching data for player $playertag <br>";
            }
    }
else
    {
        echo "<br>FAIL! - " . mysqli_error($conn) . "<br>";
    }
$content .= "</tbody></table>";

mysqli_close($conn);

echo $content;
?>