<?php

$clan_sql = "SELECT * FROM clans WHERE tag = '" . $clantag . "'";

include "../mysql_coc.php";

if($result = mysqli_query($conn, $clan_sql))
    {
        if (mysqli_num_rows($result) > 0)
            {
                $clan = mysqli_fetch_assoc($result);
            }
        else
            {
                echo "Error fetching data for $clantag <br>";
            }
    }
else
    {
        echo "<br>FAIL! - " . mysqli_error($conn) . "<br>";
    }
mysqli_close($conn);

$content = "<h1><img src=\"" . $clan['badge'] . "\" height=100>" . $clan['name'] . "</h1>";
$content .= '<table width=500 border=0 style="border-collapse: separate; border-spacing: 1px;border:1px solid black;" border=1>';
$content .= "<tr><td colspan=4 valign=top width=100>" . $clan['description'] . "</td></tr>";
$content .= "<tr><td colspan=4>&nbsp;</td></tr>";
$content .= "<tr><td width=100 ><b>Tag</b></td><td>" . $clan['tag'] ."</td><td width=100><b>Frequency</b></td><td>" . $clan['warFrequency'] . "</td></tr>";
$content .= "<tr><td><b>Location</b></td><td>" . $clan['location'] . "</td><td><b>Win streak</b></td><td>" . $clan['warWinStreak'] . "</td></tr>";
$content .= "<tr><td><b>Level</b></td><td>" . $clan['clanLevel'] . "</td><td><b>Wins</b></td><td>" . $clan['warWins'] . "</td></tr>";
$content .= "<tr><td><b>Points</b></td><td>" . $clan['clanPoints'] . "</td><td><b>Ties</b></td><td>" . $clan['warTies'] . "</td></tr>";
$content .= "<tr><td><b>vs Points</b></td><td>" . $clan['clanVersusPoints'] . "</td><td><b>Losses</b></td><td>" . $clan['warLosses'] . "</td></tr>";
$content .= "<tr><td><b>Trophies</b></td><td>" . $clan['requiredTrophies'] . "</td><td><b>Members</b></td><td>" . $clan['members'] . "</td></tr>";
$content .= "<tr><td><b>Updated</b></td><td colspan=3>" . $clan['timestamp'] . "</td></tr></table>";

$content .= "<p></p>";

$content .= '<table class="table table-striped table-sm" border=0><thead class="blue lighten-4">';
$content .= '<tr><th></th><th>Name</th><th>Role</th><th>TH</th><th>Lvl</th><th>Trophies</th><th>War stars</th><th>King</th><th>Queen</th><th>Warden</th><th>Avg stars</th><th>Avg %</th><th>3-stars</th><th>Donations</th><th>Received</th><th>Ratio</th></tr></thead>';
$content .= "<tbody>";

$members_sql = 'select name, role, tag, trophies, expLevel, clan_name, townHallLevel, league, warStars,(select level from troops where player_tag=p.tag and name="Barbarian King") as king,(select level from troops where player_tag=p.tag and name="Archer Queen") as queen,(select level from troops where player_tag=p.tag and name="Grand Warden") as warden, (select round(avg(attack_stars),1) from attacks where attacker_tag = p.tag) as stars, (select round(avg(destructionPercentage)) from attacks where attacker_tag = p.tag) as percentage, (select count(*) from attacks where attacker_tag = p.tag and attack_stars=3) as three_stars, donations, donationsReceived from players p where clan_tag = "' . $clantag . '" order by townHallLevel desc, stars desc, three_stars desc';

include "../mysql_coc.php";
if($result = mysqli_query($conn, $members_sql))
    {
        if (mysqli_num_rows($result) > 0)
            {
                while($member = mysqli_fetch_assoc($result))
                    {
                        $content .= '<tr><td><img src="' . $member['league'] . '" height=30></td>';
                        $content .= '<td><a href="' . $member['tag'] . '"><b>' . $member['name'] . '</b></a></td>';
                        $content .= "<td>" . $member['role'] . "</td>";
                        $content .= "<td>" . $member['townHallLevel'] . "</td>";
                        $content .= "<td>" . $member['expLevel'] . "</td>";
                        $content .= "<td>" . $member['trophies'] . "</td>";
                        $content .= "<td>" . $member['warStars'] . "</td>";
                        $content .= "<td>" . $member['king'] . "</td>";
                        $content .= "<td>" . $member['queen'] . "</td>";
                        $content .= "<td>" . $member['warden'] . "</td>";
                        $content .= "<td>" . $member['stars'] . "</td>";
                        $content .= "<td>" . $member['percentage'] . "</td>";
                        $content .= "<td>" . $member['three_stars'] . "</td>";
                        $content .= "<td>" . $member['donations'] . "</td>";
                        $content .= "<td>" . $member['donationsReceived'] . "</td>";
                        $content .= "<td>" . $member['donations'] . "</td>";
                        $content .= "</tr>";
                        
                    }
            }
        else
            {
                echo "Error fetching data for $clantag <br>";
            }
    }
else
    {
        echo "<br>FAIL! - " . mysqli_error($conn) . "<br>";
    }
mysqli_close($conn);

$content .= "</tbody></table>";

echo $content;

?>