<?php

$player_sql = "select *,(select round(avg(attack_stars),1) from attacks where attacker_tag = p.tag) as stars, (select round(avg(attack_stars),1) from attacks where defender_tag = p.tag) as def_stars, (select round(avg(destructionPercentage)) from attacks where attacker_tag = p.tag) as percentage, (select round(avg(destructionPercentage)) from attacks where defender_tag = p.tag) as def_percentage, (select count(*) from attacks where attacker_tag = p.tag and attack_stars=3) as three_stars, (select count(*) from attacks where attacker_tag = p.tag) as attacks FROM players p WHERE tag = '" . $playertag . "'";

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

$content .= "<p><h2>Attacks</h2>";
$content .= '<table class="table table-light" style="border-collapse: separate; border-spacing: 1px;border:1px solid black;" border=1>';
$content .= '<thead class="thead-dark"><th>Date</th><th>Defender</th><th>TH</th><th>Clan</th><th>Stars</th><th>Delta</th></thead>';
$content .= "<tbody>";

$attack_sql = "SELECT startTime, defender_tag, (SELECT name FROM players WHERE tag=a.defender_tag) AS defender, defender_clan, (SELECT name FROM clans WHERE tag=a.defender_clan) AS defender_clan_name, attack_stars, destructionPercentage, defender_th, attacker_map_pos-defender_map_pos AS delta FROM attacks a WHERE attacker_tag = '" . $playertag . "'";

    
include "../mysql_coc.php";
if($result = mysqli_query($conn, $attack_sql))
    {
        if (mysqli_num_rows($result) > 0)
            {
                while($attack = mysqli_fetch_assoc($result))
                    {
                        $content .= "<tr>";
                        $content .= "<td>" . $attack['startTime'] . '</td><td><a href="?mode=player&playertag=' . urlencode($attack['defender_tag']) . '">' . $attack['defender'] . "</a></td>";
                        $content .= "<td>" . $attack['defender_th'] . "</th>";
                        $content .= '<td><a href="?mode=clan&clantag=' . urlencode($attack['defender_clan']) . '">' . $attack['defender_clan_name'] . "</a></td>";
                        $content .= "<td>" . $attack['attack_stars'] . "* " . $attack['destructionPercentage'] . "%</td><td>" . $attack['delta'] . "</th>";
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
$content .= '<thead class="thead-dark"><th>Date</th><th>Defender</th><th>TH</th><th>Clan</th><th>Stars</th><th>Delta</th></thead>';
$content .= "<tbody>";

$attack_sql = "SELECT startTime, attacker_tag, (SELECT name FROM players WHERE tag=a.attacker_tag) AS attacker, attacker_clan, (SELECT name FROM clans WHERE tag=a.attacker_clan) AS attacker_clan_name, attack_stars, destructionPercentage, attacker_th, attacker_map_pos-defender_map_pos AS delta FROM attacks a WHERE defender_tag = '" . $playertag . "'";

    
include "../mysql_coc.php";
if($result = mysqli_query($conn, $attack_sql))
    {
        if (mysqli_num_rows($result) > 0)
            {
                while($attack = mysqli_fetch_assoc($result))
                    {
                        $content .= "<tr>";
                        $content .= "<td>" . $attack['startTime'] . '</td><td><a href="?mode=player&playertag=' . urlencode($attack['attacker_tag']) . '">' . $attack['attacker'] . "</a></td>";
                        $content .= "<td>" . $attack['attacker_th'] . "</th>";
                        $content .= '<td><a href="?mode=clan&clantag=' . urlencode($attack['attacker_clan']) . '">' . $attack['attacker_clan_name'] . "</a></td>";
                        $content .= "<td>" . $attack['attack_stars'] . "* " . $attack['destructionPercentage'] . "%</td><td>" . $attack['delta'] . "</th>";
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