<?php

if (empty($sort))
    {
        $sort = 'townHallLevel DESC, stars DESC, three_stars DESC';
    }

$content = '<h1>Spelare ' . $scope . '</h1>';
$content .= '<table class="table table-striped table-sm table-hover table-light" border=0>';
$content .= '<thead align=center class="thead-dark"><th>&nbsp;</th>';
$content .= '<th><a class="mywhite" href="?mode=players&scope=' . $scope . '&sort=name%20asc">Name</a></th>';
$content .= '<th><a class="mywhite" href="?mode=players&scope=' . $scope . '&sort=clan_name">Clan</a></th>';
$content .= '<th><a class="mywhite" href="?mode=players&scope=' . $scope . '&sort=role">Role</a></th>';
$content .= '<th><a class="mywhite" href="?mode=players&scope=' . $scope . '&sort=townHallLevel%20desc">TH</a></th>';
$content .= '<th><a class="mywhite" href="?mode=players&scope=' . $scope . '&sort=expLevel%20desc">Lvl</a></th>';
$content .= '<th><a class="mywhite" href="?mode=players&scope=' . $scope . '&sort=trophies%20desc"><img height=25 src="images/Trophy.png"></a></th>';
$content .= '<th><a class="mywhite" href="?mode=players&scope=' . $scope . '&sort=warStars%20desc">War stars</a</th>';
$content .= '<th><a class="mywhite" href="?mode=players&scope=' . $scope . '&sort=king%20desc"><img height=25 src="images/Barbarian King.png"></a></th>';
$content .= '<th><a class="mywhite" href="?mode=players&scope=' . $scope . '&sort=queen%20desc"><img height=25 src="images/Archer Queen.png"></a></th>';
$content .= '<th><a class="mywhite" href="?mode=players&scope=' . $scope . '&sort=warden%20desc"><img height=25 src="images/Grand Warden.png"></a></th>';
$content .= '<th><a class="mywhite" href="?mode=players&scope=' . $scope . '&sort=stars%20desc" title="Average stars from all attacks">Avg stars</a></th>';
$content .= '<th><a class="mywhite" href="?mode=players&scope=' . $scope . '&sort=mirr_stars%20desc" title="Average stars from mirror attacks">Avg mirror stars</a></th>';
$content .= '<th><a class="mywhite" href="?mode=players&scope=' . $scope . '&sort=th_stars%20desc" title="Average stars agains the same TH level">Avg TH stars</a></th>';
$content .= '<th><a class="mywhite" href="?mode=players&scope=' . $scope . '&sort=def_stars%20desc" title="Average stars the opponent made to own base">Def stars</a></th>';
$content .= '<th><a class="mywhite" href="?mode=players&scope=' . $scope . '&sort=three_stars%20desc" title="Total amount of attacks resulting in three stars">3-stars</a></th>';
$content .= '<th><a class="mywhite" href="?mode=players&scope=' . $scope . '&sort=attacks%20desc" title="Total amount of attacks played">Attacks</a></th>';
$content .= '<th><a class="mywhite" href="?mode=players&scope=' . $scope . '&sort=createDate" title="When players first appeared in our database">First seen</a></th>';
$content .= '<th><a class="mywhite" href="?mode=players&scope=' . $scope . '&sort=last_war%20desc">Last War</a></th>';
$content .= '<th><a class="mywhite" href="?mode=players&scope=' . $scope . '&sort=donations%20desc">Donations</a></th>';
$content .= '<th><a class="mywhite" href="?mode=players&scope=' . $scope . '&sort=donations%20desc">Ratio</a></th></thead>';
$content .= "<tbody>";

if($scope == "AV")
    $scope_sql = " WHERE clan_tag IN ('#9V8RQ2PR', '#80L9VRJR', '#YJJ8UGG2', '#220CLU8G0')"; #, '#PU2CRG2Y', '#LRRPUR88') ";
else
    $scope_sql = " ";

$members_sql = 'SELECT name, 
clan_name, 
role, 
tag, 
trophies, 
expLevel, 
clan_name, 
townHallLevel, 
league, 
warStars,
(SELECT level FROM troops WHERE player_tag=p.tag AND name="Barbarian King") AS king,
(SELECT level FROM troops WHERE player_tag=p.tag AND name="Archer Queen") AS queen,
(SELECT level FROM troops WHERE player_tag=p.tag AND name="Grand Warden") AS warden, 
(SELECT ROUND(AVG(attack_stars),1) FROM attacks WHERE attacker_tag = p.tag) AS stars, 
(SELECT ROUND(AVG(destructionPercentage)) FROM attacks WHERE attacker_tag = p.tag) AS percentage, 
(SELECT ROUND(AVG(attack_stars),1) FROM attacks WHERE attacker_tag = p.tag AND attacker_th = defender_th AND defender_th = p.townHallLevel) as th_stars,
(SELECT ROUND(AVG(destructionPercentage)) FROM attacks WHERE attacker_tag = p.tag AND attacker_th = defender_th AND defender_th = p.townHallLevel) as th_percentage, 
(SELECT ROUND(AVG(attack_stars),1) FROM attacks WHERE attacker_tag = p.tag AND attacker_map_pos = defender_map_pos) as mirr_stars,
(SELECT ROUND(AVG(destructionPercentage)) FROM attacks WHERE attacker_tag = p.tag AND attacker_map_pos = defender_map_pos) as mirr_percentage, 
(SELECT ROUND(AVG(attack_stars),1) FROM attacks WHERE defender_tag = p.tag) AS def_stars, 
(SELECT COUNT(*) FROM attacks WHERE attacker_tag = p.tag AND attack_stars=3) AS three_stars, 
(SELECT COUNT(*) FROM attacks WHERE attacker_tag = p.tag) AS attacks, 
(SELECT MAX(startTime) FROM attacks WHERE attacker_tag = tag) AS last_war, 
donations, 
donationsReceived, 
createDate 
FROM players p' . $scope_sql . 'ORDER BY ' . $sort;


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
                        if (!isset($member['percentage']))
                            $member['percentage'] = 0;
                        if (!isset($member['th_stars']))
                            $member['th_stars'] = 0;
                        if (!isset($member['th_percentage']))
                            $member['th_percentage'] = 0;
                        if (!isset($member['mirr_stars']))
                            $member['mirr_stars'] = 0;
                        if (!isset($member['mirr_percentage']))
                            $member['mirr_percentage'] = 0;
                        if (!isset($member['def_stars']))
                            $member['def_stars'] = '-';
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
                        
                        if($member['mirr_stars'] <= 2.0)
                            {
                                $r = 255-255;
                                $g = 255-155;
                                $b = 255-155;
                                $s = 2 - $member['mirr_stars'];
                                $r1 = round($r*$s+255,0);
                                $g1 = round(230-$g*$s,0);
                                $b1 = round(230-$b*$s,0);
                                $stars_color = 'style="background-color:rgb(' . $r1 . ',' . $g1 . ',' . $b1 . ')"';
                            }                            
                        else if($member['mirr_stars'] > 2.0)
                            {
                                $r = 255-100;
                                $g = 255-200;
                                $b = 255-110;
                                $s = 3 - $member['mirr_stars'];
                                $r1 = round($r*$s+108,0);
                                $g1 = round($g*$s+215,0);
                                $b1 = round($b*$s+111,0);
                                $stars_color = 'style="background-color:rgb(' . $r1 . ',' . $g1 . ',' . $b1 . ')"';
                            }
                        else
                            $stars_color = "";
                        
                        $content .= "<td align=center " . $stars_color . " >" . $member['mirr_stars'] . " @ " . $member['mirr_percentage'] . "%</td>";
                        
                        if($member['th_stars'] <= 2.0)
                            {
                                $r = 255-255;
                                $g = 255-155;
                                $b = 255-155;
                                $s = 2 - $member['th_stars'];
                                $r1 = round($r*$s+255,0);
                                $g1 = round(230-$g*$s,0);
                                $b1 = round(230-$b*$s,0);
                                $stars_color = 'style="background-color:rgb(' . $r1 . ',' . $g1 . ',' . $b1 . ')"';
                            }                            
                        else if($member['th_stars'] > 2.0)
                            {
                                $r = 255-100;
                                $g = 255-200;
                                $b = 255-110;
                                $s = 3 - $member['th_stars'];
                                $r1 = round($r*$s+108,0);
                                $g1 = round($g*$s+215,0);
                                $b1 = round($b*$s+111,0);
                                $stars_color = 'style="background-color:rgb(' . $r1 . ',' . $g1 . ',' . $b1 . ')"';
                            }
                        else
                            $stars_color = "";
                        
                        $content .= "<td align=center " . $stars_color . " >" . $member['th_stars'] . " @ " . $member['th_percentage'] . "%</td>";
                        $content .= "<td align=center>" . $member['def_stars'] . "</td>";
                        $content .= "<td align=center>" . $member['three_stars'] . "</td>";
                        $content .= "<td align=center>" . $member['attacks'] . "</td>";
                        $content .= "<td align=center>" . $member['createDate'] . "</td>";
                        $content .= "<td align=center>" . $member['last_war'] . "</td>";
                        
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