<?php

$player_sql = "select *, (select avg(attack_stars) from attacks where attacker_tag = p.tag) as stars, (select avg(destructionPercentage) from attacks where attacker_tag = p.tag) as percentage, (select count(*) from attacks where attacker_tag = p.tag and attack_stars=3) as three_stars, donations, donationsReceived FROM players p WHERE tag = '" . $playertag . "'";

$troops_sql = "SELECT * FROM troops WHERE player_tag = '" . $playertag . "' ORDER by village desc, type desc, name";

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
$content .= "tag = " . $player['tag'] . "<br>";
$content .= "TH = " . $player['townHallLevel'] . "<br>";
$content .= "Clan = " . $player['clan_name'] . "<br>";
$content .= "Level = " . $player['expLevel'] . "<br>";
$content .= "Trophies = " . $player['trophies'] . "<br>";
$content .= "Best Trophies = " . $player['bestTrophies'] . "<br>";
$content .= "War Stars = " . $player['warStars'] . "<br>";
$content .= "BH = " . $player['builderHallLevel'] . "<br>";
$content .= "BH Trophies = " . $player['versusTrophies'] . "<br>";
$content .= "BH Best Trophies = " . $player['bestVersusTrophies'] . "<br>";
$content .= "BH Battle Wins = " . $player['versusBattleWins'] . "<br>";
$content .= "Role = " . $player['role'] . "<br>";
$content .= "Donations = " . $player['donations'] . "<br>";
$content .= "Received = " . $player['donationsReceived'] . "<br>";
$content .= "Updated = " . $player['timestamp'] . "<br>";
$content .= "<p/>";

include "../mysql_coc.php";
$content .= "<table>";
if($result = mysqli_query($conn, $troops_sql))
    {
        if (mysqli_num_rows($result) > 0)
            {
                while($troop = mysqli_fetch_assoc($result))
                    {
                        $content .= "<tr><td>" . $troop['village'] . "</td><td>" . $troop['type'] . "</td><td>" . $troop['name'] . "</td><td>" . $troop['level'] . "</td></tr>";
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

$content .= "</table>";

echo $content;
?>