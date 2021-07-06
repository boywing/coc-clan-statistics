<?php

if (empty($sort))
    {
        $sort = 'clan_name ASC, townHallLevel DESC, stars DESC, three_stars DESC';
    }

$content = '<h1>Spelare ' . $scope . '</h1>';
$content .= '<table class="table small table-striped table-sm table-hover table-light"  style="font-size: 9px" border=0>';
$content .= '<thead align=center class="thead-dark"><th>&nbsp;</th>';
$content .= '<th style="font-size: 9px"><a class="mywhite" href="?mode=offence&scope=' . $scope . '&sort=name%20asc" title="Players name">'.$language['CL_TABLE_PL_NAME_SHORT'].'</a></th>';
$content .= '<th style="font-size: 9px"><a class="mywhite" href="?mode=offence&scope=' . $scope . '&sort=clan_name" title="Player is member of clan">'.$language['CL_TABLE_NAME_SHORT'].'</a></th>';
$content .= '<th style="font-size: 9px"><a class="mywhite" href="?mode=offence&scope=' . $scope . '&sort=role" title="Players role in the clan">'.$language['CL_TABLE_ROLE'].'</a></th>';
$content .= '<th style="font-size: 9px"><a class="mywhite" href="?mode=offence&scope=' . $scope . '&sort=townHallLevel%20desc" title="Players Town Hall level">'.$language['CL_TABLE_TH'].'</a></th>';
$content .= '<th style="font-size: 9px"><a class="mywhite" href="?mode=offence&scope=' . $scope . '&sort=warStars%20desc" title="Players collected stars in War">'.$language['CL_TABLE_WAR_STARS'].'</a</th>';
$content .= '<th><a class="mywhite" href="?mode=offence&scope=' . $scope . '&sort=king%20desc"><img height=22 src="images/Barbarian King.png"></a></th>';
$content .= '<th><a class="mywhite" href="?mode=offence&scope=' . $scope . '&sort=queen%20desc"><img height=22 src="images/Archer Queen.png"></a></th>';
$content .= '<th><a class="mywhite" href="?mode=offence&scope=' . $scope . '&sort=warden%20desc"><img height=22 src="images/Grand Warden.png"></a></th>';
$content .= '<th><a class="mywhite" href="?mode=offence&scope=' . $scope . '&sort=royal%20desc"><img height=22 src="images/Royal Champion.png"></a></th>';

$content .= '<th><a class="mywhite" href="?mode=offence&scope=' . $scope . '&sort=barbarian%20desc"><img height=22 src="images/Barbarian.png"></a></th>';
$content .= '<th><a class="mywhite" href="?mode=offence&scope=' . $scope . '&sort=archer%20desc"><img height=22 src="images/Archer.png"></a></th>';
$content .= '<th><a class="mywhite" href="?mode=offence&scope=' . $scope . '&sort=giant%20desc"><img height=22 src="images/Giant.png"></a></th>';
$content .= '<th><a class="mywhite" href="?mode=offence&scope=' . $scope . '&sort=goblin%20desc"><img height=22 src="images/Goblin.png"></a></th>';
$content .= '<th><a class="mywhite" href="?mode=offence&scope=' . $scope . '&sort=wall_breaker%20desc"><img height=22 src="images/Wall Breaker.png"></a></th>';
$content .= '<th><a class="mywhite" href="?mode=offence&scope=' . $scope . '&sort=balloon%20desc"><img height=22 src="images/Balloon.png"></a></th>';
$content .= '<th><a class="mywhite" href="?mode=offence&scope=' . $scope . '&sort=wizard%20desc"><img height=22 src="images/Wizard.png"></a></th>';
$content .= '<th><a class="mywhite" href="?mode=offence&scope=' . $scope . '&sort=healer%20desc"><img height=22 src="images/Healer.png"></a></th>';
$content .= '<th><a class="mywhite" href="?mode=offence&scope=' . $scope . '&sort=dragon%20desc"><img height=22 src="images/Dragon.png"></a></th>';
$content .= '<th><a class="mywhite" href="?mode=offence&scope=' . $scope . '&sort=pekka%20desc"><img height=22 src="images/P.E.K.K.A.png"></a></th>';
$content .= '<th><a class="mywhite" href="?mode=offence&scope=' . $scope . '&sort=baby_dragon%20desc"><img height=22 src="images/Baby Dragon.png"></a></th>';
$content .= '<th><a class="mywhite" href="?mode=offence&scope=' . $scope . '&sort=miner%20desc"><img height=22 src="images/Miner.png"></a></th>';
$content .= '<th><a class="mywhite" href="?mode=offence&scope=' . $scope . '&sort=minion%20desc"><img height=22 src="images/Minion.png"></a></th>';
$content .= '<th><a class="mywhite" href="?mode=offence&scope=' . $scope . '&sort=hog_rider%20desc"><img height=22 src="images/Hog Rider.png"></a></th>';
$content .= '<th><a class="mywhite" href="?mode=offence&scope=' . $scope . '&sort=valkyrie%20desc"><img height=22 src="images/Valkyrie.png"></a></th>';
$content .= '<th><a class="mywhite" href="?mode=offence&scope=' . $scope . '&sort=golem%20desc"><img height=22 src="images/Golem.png"></a></th>';
$content .= '<th><a class="mywhite" href="?mode=offence&scope=' . $scope . '&sort=witch%20desc"><img height=22 src="images/Witch.png"></a></th>';
$content .= '<th><a class="mywhite" href="?mode=offence&scope=' . $scope . '&sort=lava_hound%20desc"><img height=22 src="images/Lava Hound.png"></a></th>';
$content .= '<th><a class="mywhite" href="?mode=offence&scope=' . $scope . '&sort=bowler%20desc"><img height=22 src="images/Bowler.png"></a></th>';
$content .= '<th><a class="mywhite" href="?mode=offence&scope=' . $scope . '&sort=ice_golem%20desc"><img height=22 src="images/Ice Golem.png"></a></th>';
$content .= '<th><a class="mywhite" href="?mode=offence&scope=' . $scope . '&sort=wall_wrecker%20desc"><img height=22 src="images/Wall Wrecker.png"></a></th>';
$content .= '<th><a class="mywhite" href="?mode=offence&scope=' . $scope . '&sort=battle_blimp%20desc"><img height=22 src="images/Battle Blimp.png"></a></th>';
$content .= '<th><a class="mywhite" href="?mode=offence&scope=' . $scope . '&sort=stone_slammer%20desc"><img height=22 src="images/Stone Slammer.png"></a></th>';

$content .= '<th><a class="mywhite" href="?mode=offence&scope=' . $scope . '&sort=lightning_spell%20desc"><img height=22 src="images/Lightning Spell.png"></a></th>';
$content .= '<th><a class="mywhite" href="?mode=offence&scope=' . $scope . '&sort=healing_spell%20desc"><img height=22 src="images/Healing Spell.png"></a></th>';
$content .= '<th><a class="mywhite" href="?mode=offence&scope=' . $scope . '&sort=rage_spell%20desc"><img height=22 src="images/Rage Spell.png"></a></th>';
$content .= '<th><a class="mywhite" href="?mode=offence&scope=' . $scope . '&sort=jump_spell%20desc"><img height=22 src="images/Jump Spell.png"></a></th>';
$content .= '<th><a class="mywhite" href="?mode=offence&scope=' . $scope . '&sort=freeze_spell%20desc"><img height=22 src="images/Freeze Spell.png"></a></th>';
$content .= '<th><a class="mywhite" href="?mode=offence&scope=' . $scope . '&sort=clone_spell%20desc"><img height=22 src="images/Clone Spell.png"></a></th>';
$content .= '<th><a class="mywhite" href="?mode=offence&scope=' . $scope . '&sort=poison_spell%20desc"><img height=22 src="images/Poison Spell.png"></a></th>';
$content .= '<th><a class="mywhite" href="?mode=offence&scope=' . $scope . '&sort=earthquake_spell%20desc"><img height=22 src="images/Earthquake Spell.png"></a></th>';
$content .= '<th><a class="mywhite" href="?mode=offence&scope=' . $scope . '&sort=haste_spell%20desc"><img height=22 src="images/Haste Spell.png"></a></th>';
$content .= '<th><a class="mywhite" href="?mode=offence&scope=' . $scope . '&sort=skeleton_spell%20desc"><img height=22 src="images/Skeleton Spell.png"></a></th>';
$content .= '<th><a class="mywhite" href="?mode=offence&scope=' . $scope . '&sort=bat_spell%20desc"><img height=22 src="images/Bat Spell.png"></a></th>';

$content .= '<th style="font-size: 9px"><a class="mywhite" href="?mode=offence&scope=' . $scope . '&sort=stars%20desc" title="'.$language['CL_TABLE_AVG_STARS_DESC'].'">'.$language['CL_TABLE_AVG_STARS'].'</a></th>';
$content .= '<th style="font-size: 9px"><a class="mywhite" href="?mode=offence&scope=' . $scope . '&sort=mirr_stars%20desc" title="'.$language['CL_TABLE_AVG_STARS_MIRR_DESC'].'">'.$language['CL_TABLE_AVG_STARS_MIRR'].'</a></th>';
$content .= '<th style="font-size: 9px"><a class="mywhite" href="?mode=offence&scope=' . $scope . '&sort=th_stars%20desc" title="'.$language['CL_TABLE_AVG_STARS_TH_DESC'].'">'.$language['CL_TABLE_AVG_STARS_TH'].'</a></th>';
$content .= '<th style="font-size: 9px"><a class="mywhite" href="?mode=offence&scope=' . $scope . '&sort=def_stars%20desc" title="'.$language['CL_TABLE_DEF_DESC'].'">'.$language['CL_TABLE_DEF_SHORT'].'</a></th>';
$content .= '<th style="font-size: 9px"><a class="mywhite" href="?mode=offence&scope=' . $scope . '&sort=three_stars%20desc" title="'.$language['CL_TABLE_3_STARS_DESC'].'">'.$language['CL_TABLE_3_STARS_SHORT'].'</a></th>';
#$content .= '<th style="font-size: 9px"><a class="mywhite" href="?mode=offence&scope=' . $scope . '&sort=attacks%20desc" title="'.$language['CL_TABLE_ATTACKS_DESC'].'">'.$language['CL_TABLE_ATTACKS'].'</a></th>';
#$content .= '<th style="font-size: 9px"><a class="mywhite" href="?mode=offence&scope=' . $scope . '&sort=createDate" title="'.$language['PL_FIRST_SEEN_DESC'].'">'.$language['PL_FIRST_SEEN'].'</a></th>';
$content .= '<th style="font-size: 9px"><a class="mywhite" href="?mode=offence&scope=' . $scope . '&sort=last_war%20desc">'.$language['PL_LAST_WAR'].'</a></th>';
$content .= "</thead><tbody>";

if($scope == "AV")
    $scope_sql = " WHERE clan_tag IN ('#9V8RQ2PR', '#80L9VRJR', '#YJJ8UGG2', '#220CLU8G0', '#209QPLUV2', '#229QJJR9V')"; #, '#PU2CRG2Y', '#LRRPUR88') ";
else
    $scope_sql = " ";

$members_sql = "SELECT name, 
clan_name, 
role, 
tag, 
trophies, 
expLevel, 
clan_name, 
townHallLevel, 
league, 
warStars,
(SELECT level FROM troops WHERE player_tag=p.tag AND name=\"Barbarian King\") AS king,
(SELECT level FROM troops WHERE player_tag=p.tag AND name=\"Archer Queen\") AS queen,
(SELECT level FROM troops WHERE player_tag=p.tag AND name=\"Grand Warden\") AS warden,
(SELECT level FROM troops WHERE player_tag=p.tag AND name=\"Royal Champion\") AS royal,

(SELECT level FROM troops WHERE player_tag=p.tag AND village='home' AND name=\"Barbarian\") AS barbarian,
(SELECT level FROM troops WHERE player_tag=p.tag AND village='home' AND name=\"Archer\") AS archer,
(SELECT level FROM troops WHERE player_tag=p.tag AND village='home' AND name=\"Baby Dragon\") AS baby_dragon,
(SELECT level FROM troops WHERE player_tag=p.tag AND village='home' AND name=\"Balloon\") AS balloon,
(SELECT level FROM troops WHERE player_tag=p.tag AND village='home' AND name=\"Battle Blimp\") AS battle_blimp,
(SELECT level FROM troops WHERE player_tag=p.tag AND village='home' AND name=\"Bowler\") AS bowler,
(SELECT level FROM troops WHERE player_tag=p.tag AND village='home' AND name=\"Dragon\") AS dragon,
(SELECT level FROM troops WHERE player_tag=p.tag AND village='home' AND name=\"Electro Dragon\") AS electro_dragon,
(SELECT level FROM troops WHERE player_tag=p.tag AND village='home' AND name=\"Giant\") AS giant,
(SELECT level FROM troops WHERE player_tag=p.tag AND village='home' AND name=\"Goblin\") AS goblin,
(SELECT level FROM troops WHERE player_tag=p.tag AND village='home' AND name=\"Golem\") AS golem,
(SELECT level FROM troops WHERE player_tag=p.tag AND village='home' AND name=\"Healer\") AS healer,
(SELECT level FROM troops WHERE player_tag=p.tag AND village='home' AND name=\"Hog Rider\") AS hog_rider,
(SELECT level FROM troops WHERE player_tag=p.tag AND village='home' AND name=\"Ice Golem\") AS ice_golem,
(SELECT level FROM troops WHERE player_tag=p.tag AND village='home' AND name=\"Lava Hound\") AS lava_hound,
(SELECT level FROM troops WHERE player_tag=p.tag AND village='home' AND name=\"Miner\") AS miner,
(SELECT level FROM troops WHERE player_tag=p.tag AND village='home' AND name=\"Minion\") AS minion,
(SELECT level FROM troops WHERE player_tag=p.tag AND village='home' AND name=\"P.E.K.K.A\") AS pekka,
(SELECT level FROM troops WHERE player_tag=p.tag AND village='home' AND name=\"Stone Slammer\") AS stone_slammer,
(SELECT level FROM troops WHERE player_tag=p.tag AND village='home' AND name=\"Valkyrie\") AS valkyrie,
(SELECT level FROM troops WHERE player_tag=p.tag AND village='home' AND name=\"Wall Breaker\") AS wall_breaker,
(SELECT level FROM troops WHERE player_tag=p.tag AND village='home' AND name=\"Wall Wrecker\") AS wall_wrecker,
(SELECT level FROM troops WHERE player_tag=p.tag AND village='home' AND name=\"Witch\") AS witch,
(SELECT level FROM troops WHERE player_tag=p.tag AND village='home' AND name=\"Wizard\") AS wizard,

(SELECT level FROM troops WHERE player_tag=p.tag AND village='home' AND name=\"Bat Spell\") AS bat_spell,
(SELECT level FROM troops WHERE player_tag=p.tag AND village='home' AND name=\"Clone Spell\") AS clone_spell,
(SELECT level FROM troops WHERE player_tag=p.tag AND village='home' AND name=\"Earthquake Spell\") AS earthquake_spell,
(SELECT level FROM troops WHERE player_tag=p.tag AND village='home' AND name=\"Freeze Spell\") AS freeze_spell,
(SELECT level FROM troops WHERE player_tag=p.tag AND village='home' AND name=\"Haste Spell\") AS haste_spell,
(SELECT level FROM troops WHERE player_tag=p.tag AND village='home' AND name=\"Healing Spell\") AS healing_spell,
(SELECT level FROM troops WHERE player_tag=p.tag AND village='home' AND name=\"Jump Spell\") AS jump_spell,
(SELECT level FROM troops WHERE player_tag=p.tag AND village='home' AND name=\"Lightning Spell\") AS lightning_spell,
(SELECT level FROM troops WHERE player_tag=p.tag AND village='home' AND name=\"Poison Spell\") AS poison_spell,
(SELECT level FROM troops WHERE player_tag=p.tag AND village='home' AND name=\"Rage Spell\") AS rage_spell,
(SELECT level FROM troops WHERE player_tag=p.tag AND village='home' AND name=\"Skeleton Spell\") AS skeleton_spell,

(SELECT ROUND(AVG(attack_stars),1) FROM attacks WHERE attacker_tag = p.tag AND startTime >= date_sub(now(), interval $days day)) AS stars, 
(SELECT ROUND(AVG(destructionPercentage)) FROM attacks WHERE attacker_tag = p.tag AND startTime >= date_sub(now(), interval $days day)) AS percentage, 
(SELECT ROUND(AVG(attack_stars),1) FROM attacks WHERE attacker_tag = p.tag AND attacker_th = defender_th AND defender_th = p.townHallLevel AND startTime >= date_sub(now(), interval $days day)) as th_stars,
(SELECT ROUND(AVG(destructionPercentage)) FROM attacks WHERE attacker_tag = p.tag AND attacker_th = defender_th AND defender_th = p.townHallLevel AND startTime >= date_sub(now(), interval $days day)) as th_percentage, 
(SELECT ROUND(AVG(attack_stars),1) FROM attacks WHERE attacker_tag = p.tag AND attacker_map_pos = defender_map_pos AND startTime >= date_sub(now(), interval $days day)) as mirr_stars,
(SELECT ROUND(AVG(destructionPercentage)) FROM attacks WHERE attacker_tag = p.tag AND attacker_map_pos = defender_map_pos AND startTime >= date_sub(now(), interval $days day)) as mirr_percentage, 
(SELECT ROUND(AVG(attack_stars),1) FROM attacks WHERE defender_tag = p.tag AND startTime >= date_sub(now(), interval $days day)) AS def_stars, 
(SELECT COUNT(*) FROM attacks WHERE attacker_tag = p.tag AND attack_stars=3 AND startTime >= date_sub(now(), interval $days day)) AS three_stars, 
(SELECT COUNT(*) FROM attacks WHERE attacker_tag = p.tag AND startTime >= date_sub(now(), interval $days day)) AS attacks, 
(SELECT MAX(date(startTime)) FROM attacks WHERE attacker_tag = tag) AS last_war, 
createDate 
FROM players p" . $scope_sql . "ORDER BY " . $sort;


include "../mysql_coc.php";

if($result = mysqli_query($conn, $members_sql))
    {
        if (mysqli_num_rows($result) > 0)
            {
                while($member = mysqli_fetch_assoc($result))
                    {
                        $content .= '<tr><td><img src="' . $member['league'] . '" height=20></td>';
                        $content .= '<td><a href="?mode=player&playertag=' . urlencode($member['tag']) . '"><b>' . htmlspecialchars($member['name'], ENT_QUOTES) . '</b></a></td>';
                        $content .= '<td>' . htmlspecialchars($member['clan_name'], ENT_QUOTES) . '</td>';

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
                        $content .= "<td align=center>" . $member['warStars'] . "</td>";
                        $content .= "<td align=center style=\"background-color:rgb(200,200,255)\">" . $member['king'] . "</td>";
                        $content .= "<td align=center style=\"background-color:rgb(210,210,255)\">" . $member['queen'] . "</td>";
                        $content .= "<td align=center style=\"background-color:rgb(200,200,255)\">" . $member['warden'] . "</td>";
                        $content .= "<td align=center style=\"background-color:rgb(210,210,255)\">" . $member['royal'] . "</td>";

                        $content .= "<td align=center>" . $member['barbarian'] . "</td>";
                        $content .= "<td align=center>" . $member['archer'] . "</td>";
                        $content .= "<td align=center>" . $member['giant'] . "</td>";
                        $content .= "<td align=center>" . $member['goblin'] . "</td>";
                        $content .= "<td align=center>" . $member['wall_breaker'] . "</td>";
                        $content .= "<td align=center class=\"table-danger\">" . $member['balloon'] . "</td>";
                        $content .= "<td align=center>" . $member['wizard'] . "</td>";
                        $content .= "<td align=center>" . $member['healer'] . "</td>";
                        $content .= "<td align=center class=\"table-danger\">" . $member['dragon'] . "</td>";
                        $content .= "<td align=center>" . $member['pekka'] . "</td>";
                        $content .= "<td align=center>" . $member['baby_dragon'] . "</td>";
                        $content .= "<td align=center>" . $member['miner'] . "</td>";
                        $content .= "<td align=center>" . $member['minion'] . "</td>";
                        $content .= "<td align=center style=\"background-color:rgb(255,200,200)\">" . $member['hog_rider'] . "</td>";
                        $content .= "<td align=center style=\"background-color:rgb(255,210,210)\">" . $member['valkyrie'] . "</td>";
                        $content .= "<td align=center style=\"background-color:rgb(255,200,200)\">" . $member['golem'] . "</td>";
                        $content .= "<td align=center style=\"background-color:rgb(255,210,210)\">" . $member['witch'] . "</td>";
                        $content .= "<td align=center style=\"background-color:rgb(255,200,200)\">" . $member['lava_hound'] . "</td>";
                        $content .= "<td align=center style=\"background-color:rgb(255,210,210)\">" . $member['bowler'] . "</td>";
                        $content .= "<td align=center>" . $member['ice_golem'] . "</td>";
                        $content .= "<td align=center>" . $member['wall_wrecker'] . "</td>";
                        $content .= "<td align=center>" . $member['battle_blimp'] . "</td>";
                        $content .= "<td align=center>" . $member['stone_slammer'] . "</td>";
                        $content .= "<td align=center>" . $member['lightning_spell'] . "</td>";
                        $content .= "<td align=center style=\"background-color:rgb(255,200,200)\">" . $member['healing_spell'] . "</td>";
                        $content .= "<td align=center style=\"background-color:rgb(255,210,210)\">" . $member['rage_spell'] . "</td>";
                        $content .= "<td align=center style=\"background-color:rgb(255,200,200)\">" . $member['jump_spell'] . "</td>";
                        $content .= "<td align=center>" . $member['freeze_spell'] . "</td>";
                        $content .= "<td align=center>" . $member['clone_spell'] . "</td>";
                        $content .= "<td align=center>" . $member['poison_spell'] . "</td>";
                        $content .= "<td align=center>" . $member['earthquake_spell'] . "</td>";
                        $content .= "<td align=center>" . $member['haste_spell'] . "</td>";
                        $content .= "<td align=center>" . $member['skeleton_spell'] . "</td>";
                        $content .= "<td align=center>" . $member['bat_spell'] . "</td>";

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
                        $content .= "<td align=center>" . $member['three_stars'] . "/" . $member['attacks'] . "</td>";
                        #$content .= "<td align=center>" . $member['createDate'] . "</td>";
                        $content .= "<td align=center>" . $member['last_war'] . "</td>";
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
