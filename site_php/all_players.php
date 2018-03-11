<?php
$content .= '<h1>Spelare ' . $scope . '</h1>';
$content .= '<table class="table table-striped table-sm table-hover table-light" border=0>';
$content .= '<thead align=center class="thead-dark"><th>&nbsp;</th><th>Name</th><th>Clan</th><th>Role</th><th>TH</th><th>Lvl</th>';
$content .= '<th><img height=25 src="images/Trophy.png"></th>';
$content .= '<th>War stars</th><th><img height=25 src="images/Barbarian King.png"></th><th><img height=25 src="images/Archer Queen.png"></th><th><img height=25 src="images/Grand Warden.png"></th><th>Avg stars</th><th>Def stars</th><th>3-stars</th><th>Attacks</th>';
$content .= '<th>Donations</th>';
$content .= '<th>Ratio</th></thead>';
$content .= "<tbody>";

if($scope == "AV")
    $scope_sql = " WHERE clan_tag IN ('#9V8RQ2PR', '#80L9VRJR', '#YJJ8UGG2', '#PU2CRG2Y', '#LRRPUR88') ";
else
    $scope_sql = " ";

$members_sql = 'select name, clan_name, role, tag, trophies, expLevel, clan_name, townHallLevel, league, warStars,(select level from troops where player_tag=p.tag and name="Barbarian King") as king,(select level from troops where player_tag=p.tag and name="Archer Queen") as queen,(select level from troops where player_tag=p.tag and name="Grand Warden") as warden, (select round(avg(attack_stars),1) from attacks where attacker_tag = p.tag) as stars, (select round(avg(attack_stars),1) from attacks where defender_tag = p.tag) as def_stars, (select round(avg(destructionPercentage)) from attacks where attacker_tag = p.tag) as percentage, (select count(*) from attacks where attacker_tag = p.tag and attack_stars=3) as three_stars, (select count(*) from attacks where attacker_tag = p.tag) as attacks, donations, donationsReceived from players p' . $scope_sql . 'order by townHallLevel desc, stars desc, three_stars desc';


include "../mysql_coc.php";

if($result = mysqli_query($conn, $members_sql))
    {
        if (mysqli_num_rows($result) > 0)
            {
                while($member = mysqli_fetch_assoc($result))
                    {
                                                $content .= '<tr><td><img src="' . $member['league'] . '" height=30></td>';
                        $content .= '<td><a href="?mode=player&playertag=' . urlencode($member['tag']) . '"><b>' . $member['name'] . '</b></a></td>';
                        $content .= '<td>' . $member['clan_name'] . '</td>';

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
                            if($clantag == '#9V8RQ2PR' ||$clantag == '#80L9VRJR' ||$clantag == '#YJJ8UGG2' ||$clantag == '#LRRPUR88')
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
                        if (!isset($member['def_stars']))
                            $member['def_stars'] = '-';
                        if (!isset($member['percentage']))
                            $member['percentage'] = 0;
                        if($member['stars'] <= 2.0)
                            {
                                $r = 255-255;
                                $g = 255-155;
                                $b = 255-155;
                                $s = 2 - $member['stars'];
                                $r1 = round($r*$s+255,0);
                                $g1 = round(230-$g*$s,0);
                                $b1 = round(230-$b*$s,0);
                                $stars_color = 'style="background-color:rgb(' . $r1 . ',' . $g1 . ',' . $b1 . ')"';
                            }                            
                        else if($member['stars'] > 2.0)
                            {
                                $r = 255-100;
                                $g = 255-200;
                                $b = 255-110;
                                $s = 3 - $member['stars'];
                                $r1 = round($r*$s+108,0);
                                $g1 = round($g*$s+215,0);
                                $b1 = round($b*$s+111,0);
                                $stars_color = 'style="background-color:rgb(' . $r1 . ',' . $g1 . ',' . $b1 . ')"';
                            }
                        else
                            $stars_color = "";
                        
                        $content .= "<td align=center " . $stars_color . " >" . $member['stars'] . " @ " . $member['percentage'] . "%</td>";
                        $content .= "<td align=center>" . $member['def_stars'] . "</td>";
                        $content .= "<td align=center>" . $member['three_stars'] . "</td>";
                        $content .= "<td align=center>" . $member['attacks'] . "</td>";
                        
                        $donation_count = round($member['donations']/$member['donationsReceived'], 2);
                        if ($member['donations'] == 0)
                            $donation_colour = 'style="background-color:rgb(255,0,0)"';
                        else if (($donation_count < 0.4) || ($member['donations'] < 2))
                            $donation_colour = 'class="table-danger"';
                        else if ((($donation_count <= 0.6) && ($donation_count >= 0.4)) || (($member['donations'] < 50) && ($member['donations'] > 1)))
                            $donation_colour = 'class="table-warning"';
                        else if ($donation_count > 0.6)
                            $donation_colour = 'class="table-success"';
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