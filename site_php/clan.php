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
        echo "<br>FAIL! Clan - " . mysqli_error($conn) . "<br>";
    }

$content = "<h1><img src=\"" . $clan['badge'] . "\" height=100>" . htmlspecialchars($clan['name'], ENT_QUOTES) . "</h1>";
$content .= '<table width=100%><tr><td><table class="table-light" width=670 style="border-collapse: separate; border-spacing: 1px;border:1px solid black;">';
$content .= "<tr><td colspan=4 valign=top width=100>" . $clan['description'] . "</td></tr>";
$content .= "<tr><td colspan=4>&nbsp;</td></tr>";
$content .= "<tr><td width=160 ><b>" . $language['CL_TAG'] . "</b></td><td>" . $clan['tag'] ."</td><td width=100><b>" . $language['CL_FREQ'] . "</b></td><td>" . $clan['warFrequency'] . "</td></tr>";
$content .= "<tr><td><b>" . $language['CL_LOC'] . "</b></td><td>" . $clan['location'] . "</td><td><b>" . $language['CL_WIN_STREAK'] . "</b></td><td>" . $clan['warWinStreak'] . " war</td></tr>";
$content .= "<tr><td><b>" . $language['CL_LEVEL'] . "</b></td><td>" . $clan['clanLevel'] . "</td><td><b>" . $language['CL_CW_WINS'] . "</b></td><td>" . $clan['warWins'] . "</td></tr>";
$content .= "<tr><td><b>" . $language['CL_POINTS'] . "</b></td><td>" . $clan['clanPoints'] . "</td><td><b>" . $language['CL_CW_TIES'] . "</b></td><td>" . $clan['warTies'] . "</td></tr>";
$content .= "<tr><td><b>" . $language['CL_VS_POINTS'] . "</b></td><td>" . $clan['clanVersusPoints'] . "</td><td><b>" . $language['CL_CW_LOSSES'] . "</b></td><td>" . $clan['warLosses'] . "</td></tr>";
$content .= "<tr><td><b>" . $language['CL_REQ_TROPHIES'] . "</b></td><td>" . $clan['requiredTrophies'] . "</td><td><b>" . $language['CL_MEMBERS'] . "</b></td><td>" . $clan['members'] . " of 50</td></tr>";
$content .= "<tr><td><b>" . $language['CL_UPDATED'] . "</b></td><td colspan=3>" . $clan['timestamp'] . "</td></tr></table>";

mysqli_free_result($result);
$content .= "<p/>";

$content .= '<table class="table table-striped table-sm table-hover table-light" border=0>';
$content .= '<thead align=center class="thead-dark">';
$content .= '<th>&nbsp;</th>';
$content .= '<th><a class="mywhite" href="?mode=clan&clantag='. urlencode($clantag) . '&sort=name%20asc" title="' . $language['CL_TABLE_PL_NAME_DESC'] . '">' . $language['CL_TABLE_PL_NAME'] . '</a></th>';
$content .= '<th><a class="mywhite" href="?mode=clan&clantag='. urlencode($clantag) . '&sort=role%20asc" title="' . $language['CL_TABLE_ROLE_DESC'] . '">' . $language['CL_TABLE_ROLE'] . '</a></th>';
$content .= '<th><a class="mywhite" href="?mode=clan&clantag='. urlencode($clantag) . '&sort=townHallLevel%20desc" title="' . $language['CL_TABLE_TH_DESC'] . '">' . $language['CL_TABLE_TH'] . '</a></th>';
$content .= '<th><a class="mywhite" href="?mode=clan&clantag='. urlencode($clantag) . '&sort=expLevel%20desc" title="' . $language['CL_TABLE_LVL_DESC'] . '">' . $language['CL_TABLE_LVL'] . '</a></th>';
#$content .= '<th><img height=25 src="images/Trophy.png"></th>';
$content .= '<th><a class="mywhite" href="?mode=clan&clantag='. urlencode($clantag) . '&sort=warStars%20desc" title="' . $language['CL_TABLE_WAR_STARS_DESC'] . '">' . $language['CL_TABLE_WAR_STARS'] . '</a></th>';
$content .= '<th><a class="mywhite" href="?mode=clan&clantag='. urlencode($clantag) . '&sort=king%20desc"><img height=25 src="images/Barbarian King.png" title="King"></a>-<a class="mywhite" href="?mode=clan&clantag='. urlencode($clantag) . '&sort=queen%20desc"><img height=25 src="images/Archer Queen.png" title="Queen"></a>-<a class="mywhite" href="?mode=clan&clantag='. urlencode($clantag) . '&sort=warden%20desc"><img height=25 src="images/Grand Warden.png" title="Grand Warden"></a></th>';
$content .= '<th><a class="mywhite" href="?mode=clan&clantag='. urlencode($clantag) . '&sort=stars%20desc" title="' . $language['CL_TABLE_AVG_STARS_MIRR_DESC'] . '">' . $language['CL_TABLE_AVG_STARS_MIRR'] . '</a></th>';
$content .= '<th><a class="mywhite" href="?mode=clan&clantag='. urlencode($clantag) . '&sort=def_stars%20asc" title="' . $language['CL_TABLE_DEF_DESC'] . '">' . $language['CL_TABLE_DEF'] . '</a></th>';
$content .= '<th><a class="mywhite" href="?mode=clan&clantag='. urlencode($clantag) . '&sort=three_stars%20desc" title="' . $language['CL_TABLE_3_STARS_DESC'] . '">' . $language['CL_TABLE_3_STARS'] . '</a></th>';
$content .= '<th><a class="mywhite" href="?mode=clans&clantag='. urlencode($clantag) . '&sort=last_war%20desc" title="'.$language['CL_TABLE_LAST_WAR_DAYS_DESC'].'">'.$language['CL_TABLE_LAST_WAR_DAYS'].'</a></th>';
#$content .= '<th>Donations</th>';
$content .= '<th><a class="mywhite" href="?mode=clan&clantag='. urlencode($clantag) . '&sort=donations%20desc" title="' . $language['CL_TABLE_RATIO_DESC'] . '">' . $language['CL_TABLE_RATIO'] . '</a></th></thead>';
$content .= "<tbody>";

if (empty($sort))
    {
        $sort = "townHallLevel desc, stars desc, three_stars desc";
    }

$members_sql = "select name, role, tag, trophies, expLevel, clan_name, townHallLevel, league, warStars,
(select level from troops where player_tag=p.tag and name=\"Barbarian King\") as king,
(select level from troops where player_tag=p.tag and name=\"Archer Queen\") as queen,
(select level from troops where player_tag=p.tag and name=\"Grand Warden\") as warden, 
(select round(avg(attack_stars),1) from attacks where attacker_tag = p.tag AND attacker_map_pos = defender_map_pos AND startTime >= date_sub(now(), interval $days day)) as stars, 
(select round(avg(attack_stars),1) from attacks where defender_tag = p.tag AND defender_th = p.townHallLevel AND startTime >= date_sub(now(), interval $days day)) as def_stars, 
(select round(avg(destructionPercentage)) from attacks where attacker_tag = p.tag AND attacker_map_pos = defender_map_pos AND startTime >= date_sub(now(), interval $days day)) as percentage, 
(select count(*) from attacks where attacker_tag = p.tag AND attack_stars=3 AND startTime >= date_sub(now(), interval $days day)) as three_stars, 
(select count(*) from attacks where attacker_tag = p.tag AND startTime >= date_sub(now(), interval $days day)) as attacks, 
(SELECT COALESCE(TIMESTAMPDIFF(WEEK, MAX(startTime), NOW()),0) FROM attacks WHERE attacker_tag = tag) as last_war_week,
(SELECT COALESCE(TIMESTAMPDIFF(DAY, MAX(startTime), DATE_SUB(NOW(),INTERVAL last_war_week WEEK)),0)FROM attacks a WHERE a.attacker_tag = p.tag) as last_war_day,
(SELECT COALESCE(TIMESTAMPDIFF(HOUR, MAX(startTime), NOW()),0) FROM attacks a WHERE a.attacker_tag = p.tag) as last_war_hour,
(SELECT COALESCE(TIMESTAMPDIFF(MINUTE, MAX(startTime), NOW()),0) FROM attacks a WHERE a.attacker_tag = p.tag) as last_war_minute,
donations, donationsReceived from players p where clan_tag = \"$clantag\" order by $sort";

if($result = mysqli_query($conn, $members_sql))
    {
        if (mysqli_num_rows($result) > 0)
            {
                while($member = mysqli_fetch_assoc($result))
                    {
                        $content .= '<tr><td><img src="' . $member['league'] . '" height=25></td>';
                        $content .= '<td><a href="?mode=player&playertag=' . urlencode($member['tag']) . '"><b>' . htmlspecialchars($member['name'], ENT_QUOTES) . '</b></a></td>';

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
                            if($clantag == '#9V8RQ2PR' ||$clantag == '#80L9VRJR' ||$clantag == '#YJJ8UGG2' ||$clantag == '#LRRPUR88' || $clantag == '#209QPLUV2')
                                $member['role'] = "Viking";
                            $role_color = '';
                            break;                            
                        }

                        $content .= "<td align=center " . $role_color . ">" . $member['role'] . "</td>";
                        $content .= "<td align=center>" . $member['townHallLevel'] . "</td>";
                        $content .= "<td align=center>" . $member['expLevel'] . "</td>";
#                        $content .= '<td align=center>' . $member['trophies'] . "</td>";
                        $content .= "<td align=center>" . $member['warStars'] . "</td>";
                        if(isset($member['king']))
                            $content .= "<td align=center>" . $member['king'] . "-";
                        else
                            $content .= "<td align=center>0-";
                        if(isset($member['queen']))
                            $content .= "" . $member['queen'] . "-";
                        else
                            $content .= "0-";
                        if(isset($member['warden']))
                            $content .= "" . $member['warden'] . "</td>";
                        else
                            $content .= "0</td>";
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
                        $content .= "<td align=center>" . $member['three_stars'] . " / ";
                        $content .= $member['attacks'] . "</td>";
                        
                        $content .= "<td align=center>";
                        if($member['last_war_week'] > 0 || $member['last_war_day'] > 0)
                        {
                            if($member['last_war_week'] > 0)
                                $content .= $member['last_war_week'] . "w ";
                            if($member['last_war_day'] > 0)
                                $content .= $member['last_war_day'] . "d";                    
                        }
                        else if ($member['last_war_hour'] > 0)
                        {
                            $content .= $member['last_war_hour'] . "h";
                        }
                        else if ($member['last_war_minute'] > 0)
                        {
                            $content .= $member['last_war_minute'] . " min";
                        }
                        else
                        {
                            $content .= "-";
                        }
                        $content .= "</td>";
                            
                        
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
#                        $content .= '<td align=right ' . $donation_colour . ' >' . $member['donations'] . " / " . $member['donationsReceived'] . "</td>";
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
        echo "<br>FAIL! Member - " . mysqli_error($conn) . "<br>";
    }
mysqli_close($conn);

$content .= "</tbody></table>";

echo $content;

?>
