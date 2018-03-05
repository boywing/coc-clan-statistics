<?php

$player_sql = "select *, (select avg(attack_stars) from attacks where attacker_tag = p.tag) as stars, (select avg(destructionPercentage) from attacks where attacker_tag = p.tag) as percentage, (select count(*) from attacks where attacker_tag = p.tag and attack_stars=3) as three_stars, donations, donationsReceived FROM players p WHERE tag = '" . $playertag . "'";

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
$content .= '<table class="table-light" style="border-collapse: separate; border-spacing: 1px;border:1px solid black;">';
$content .= "<tr><td>tag </td><td> " . $player['tag'] . "</td></tr>";
$content .= "<tr><td>TH </td><td> " . $player['townHallLevel'] . "</td></tr>";
$content .= "<tr><td>Clan </td><td> " . $player['clan_name'] . "</td></tr>";
$content .= "<tr><td>Level </td><td> " . $player['expLevel'] . "</td></tr>";
$content .= "<tr><td>Trophies </td><td> " . $player['trophies'] . "</td></tr>";
$content .= "<tr><td>Best Trophies </td><td> " . $player['bestTrophies'] . "</td></tr>";
$content .= "<tr><td>War Stars </td><td> " . $player['warStars'] . "</td></tr>";
$content .= "<tr><td>BH </td><td> " . $player['builderHallLevel'] . "</td></tr>";
$content .= "<tr><td>BH Trophies </td><td> " . $player['versusTrophies'] . "</td></tr>";
$content .= "<tr><td>BH Best Trophies </td><td> " . $player['bestVersusTrophies'] . "</td></tr>";
$content .= "<tr><td>BH Battle Wins </td><td> " . $player['versusBattleWins'] . "</td></tr>";
$content .= "<tr><td>Role </td><td> " . $player['role'] . "<br></td></tr>";
$content .= "<tr><td>Donations </td><td> " . $player['donations'] . "</td></tr>";
$content .= "<tr><td>Received </td><td> " . $player['donationsReceived'] . "</td></tr>";
$content .= "<tr><td>Updated </td><td> " . $player['timestamp'] . "</td></tr>";
$content .= "</table>";

$content .= '<br><div class="left small-shadow"><span><b>Troops</b></span><br>';

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

echo $content;
?>