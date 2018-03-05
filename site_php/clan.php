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
$content .= '<table class="table-light" width=670 style="border-collapse: separate; border-spacing: 1px;border:1px solid black;">';
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

$content .= '<table class="table table-striped table-sm table-hover table-light" border=0>';
$content .= '<thead align=center class="thead-dark"><th>&nbsp;</th><th>Name</th><th>Role</th><th>TH</th><th>Lvl</th>';
$content .= '<th><img height=25 src="images/Trophy.png"></th>';
$content .= '<th>War stars</th><th><img height=25 src="images/Barbarian King.png"></th><th><img height=25 src="images/Archer Queen.png"></th><th><img height=25 src="images/Grand Warden.png"></th><th>Avg stars</th><th>3-stars</th>';
$content .= '<th>Donations</th>';
$content .= '<th>Ratio</th></thead>';
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
                        $content .= '<td><a href="?mode=player&playertag=' . urlencode($member['tag']) . '"><b>' . $member['name'] . '</b></a></td>';

                        switch ($member['role']) {
                        case "leader":
                            $member['role'] = "Leader";
                            $role_color = 'class="table-danger"';
                            break;
                        case "coLeader":
                            $member['role'] = "CO";
                            $role_color = 'class="table-danger"';
break;
                        case "admin":
                            $member['role'] = "Elder";
                            $role_color = 'class="table-success"';
                            break;
                        case "member":
                            $member['role'] = "Viking";
                            $role_color = '';
                            break;                            
                        }

                        $content .= "<td align=center " . $role_color . ">" . $member['role'] . "</td>";
                        $content .= "<td align=center>" . $member['townHallLevel'] . "</td>";
                        $content .= "<td align=center>" . $member['expLevel'] . "</td>";
                        $content .= '<td align=center>' . $member['trophies'] . "</td>";
                        $content .= "<td align=center>" . $member['warStars'] . "</td>";
                        $content .= "<td align=center>" . $member['king'] . "</td>";
                        $content .= "<td align=center>" . $member['queen'] . "</td>";
                        $content .= "<td align=center>" . $member['warden'] . "</td>";
                        if (!isset($member['stars']))
                            $member['stars'] = 0;
                        if (!isset($member['percentage']))
                            $member['percentage'] = 0;
                        
                        $content .= "<td align=center>" . $member['stars'] . " @ " . $member['percentage'] . "%</td>";
                        $content .= "<td align=center>" . $member['three_stars'] . "</td>";
                        
                        $donation_count = round($member['donations']/$member['donationsReceived'], 2);
                        if (($donation_count < 0.8) || ($member['donations'] < 2))
                            $donation_colour = 'class="table-danger"';
                        else if ($donation_count > 1.1)
                            $donation_colour = 'class="table-success"';
                        else if (($donation_count <= 1.1) || ($donation_count >= 0.8) || (($member['donations'] < 50) && ($member['donations'] > 1)))
                            $donation_colour = 'class="table-warning"';
                        else
                            $donation_colour = 'class="table-secondary"';
                        $content .= '<td align=right ' . $donation_colour . ' >' . $member['donations'] . " / " . $member['donationsReceived'] . "</td>";
                        $content .= "<td align=center " . $donation_colour . ">" . $donation_count . "</td>";
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