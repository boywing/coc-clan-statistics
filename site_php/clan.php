<?php
  /*
th_common - cmn_table - warPref, league, name
th_awards -tbl_awards 
th_role - tbl_role
th_th - tbl_th
th_exp - tbl_exp
th_trophies - tbl_trophies
th_war_stars - tbl_war_stars
th_heroes - tbl_heroes
th_stars_cw_mirr - tbl_cw_of_mirr
th_stars_cwl_avg - tbl_cwl_of
th_stars_def - tbl_cw_def
th_3stars - tbl_three_stars
th_capital_attacks - tbl_capital_attacks
th_capital_points - tbl_capital_points
th_last_war - tbl_last_war
th_donations - 
th_ratio - tbl_donations_ratio

 */

$clan_sql = "SELECT * FROM clans WHERE tag = '" . $clantag . "'";

include "../mysql_coc.php";

if ($result = mysqli_query($conn, $clan_sql)) {
    if (mysqli_num_rows($result) > 0) {
        $clan = mysqli_fetch_assoc($result);
    } else {
        echo "Error fetching data for $clantag <br>";
    }
} else {
    echo "<br>FAIL! Clan - " . mysqli_error($conn) . "<br>";
}

$content = '<h1><img src="' . $clan['badge'] . '" height=100px alt="Badge">' . htmlspecialchars($clan['name'], ENT_QUOTES) . '</h1>';
$content .= '<table class="table table-light table-sm table-striped" style="width: 680px; border-collapse: separate; border-spacing: 1px;border:1px solid black;">';
$content .= '<tr><td colspan=4 valign=top style="width=100px">' . $clan['description'] . "</td></tr>";

$content .= "<tr><td style=\"width:160px\"><b>" . $language['CL_TAG'] . "</b></td><td>" . $clan['tag'] . "</td><td style=\"width:150px\"><b>" . $language['CL_FREQ'] . "</b></td><td>" . $clan['warFrequency'] . "</td></tr>";
$content .= "<tr><td><b>" . $language['CL_LOC'] . "</b></td><td>" . $clan['location'] . "</td><td><b>" . $language['CL_WIN_STREAK'] . "</b></td><td>" . $clan['warWinStreak'] . " war</td></tr>";
$content .= "<tr><td><b>" . $language['CL_LEVEL'] . "</b></td><td>" . $clan['clanLevel'] . "</td><td><b>" . $language['CL_CW_WINS'] . "</b></td><td>" . $clan['warWins'] . "</td></tr>";
$content .= "<tr><td><b>" . $language['CL_POINTS'] . "</b></td><td>" . $clan['clanPoints'] . "</td><td><b>" . $language['CL_CW_TIES'] . "</b></td><td>" . $clan['warTies'] . "</td></tr>";
$content .= "<tr><td><b>" . $language['CL_VS_POINTS'] . "</b></td><td>" . $clan['clanVersusPoints'] . "</td><td><b>" . $language['CL_CW_LOSSES'] . "</b></td><td>" . $clan['warLosses'] . "</td></tr>";
$content .= "<tr><td><b>" . $language['CL_CAPITAL_POINTS'] . "</b></td><td>" . $clan['clanCapitalPoints'] . "</td><td><b>" . $language['CL_MEMBERS'] . "</b></td><td>" . $clan['members'] . " of 50</td></tr>";
$content .= "<tr><td><b>" . $language['CL_REQ_TROPHIES'] . "</b></td><td>" . $clan['requiredTrophies'] . "</td><td><b>" . $language['CL_UPDATED'] . "</b></td><td>" . $clan['timestamp'] . "</td></tr></table>";

mysqli_free_result($result);
$content .= "<p>";

$th_common = '<th style="width:25px">&nbsp;</th>';
$th_common .= '<th style="width:25px">&nbsp;</th>';
$th_common .= '<th><a class="mywhite" href="?mode=clan&clantag=' . urlencode($clantag) . '&sort=name%20asc" title="' . $language['CL_TABLE_PL_NAME_DESC'] . '">' . $language['CL_TABLE_PL_NAME_SHORT'] . '</a></th>';

$th_awards = '<th>Awards</th>';
$th_role = '<th><a class="mywhite" href="?mode=clan&clantag=' . urlencode($clantag) . '&sort=role%20asc" title="' . $language['CL_TABLE_ROLE_DESC'] . '">' . $language['CL_TABLE_ROLE'] . '</a></th>';
$th_th = '<th><a class="mywhite" href="?mode=clan&clantag=' . urlencode($clantag) . '&sort=townHallLevel%20desc" title="' . $language['CL_TABLE_TH_DESC'] . '">' . $language['CL_TABLE_TH'] . '</a></th>';

$th_exp = '<th><a class="mywhite" href="?mode=clan&clantag=' . urlencode($clantag) . '&sort=expLevel%20desc" title="' . $language['CL_TABLE_LVL_DESC'] . '">' . $language['CL_TABLE_LVL'] . '</a></th>';
$th_trophies = '<th><img height=25 src="images/Trophy.png" alt="Trophy"></th>';
$th_war_stars = '<th><a class="mywhite" href="?mode=clan&clantag=' . urlencode($clantag) . '&sort=warStars%20desc" title="' . $language['CL_TABLE_WAR_STARS_DESC'] . '">' . $language['CL_TABLE_WAR_STARS'] . '</a></th>';
$th_heroes = '<th><a class="mywhite" href="?mode=clan&clantag=' . urlencode($clantag) . '&sort=king%20desc"><img height=25 src="images/Barbarian%20King.png" title="King"></a>-<a class="mywhite" href="?mode=clan&clantag=' . urlencode($clantag) . '&sort=queen%20desc"><img height=25 src="images/Archer%20Queen.png" title="Queen"></a>-<a class="mywhite" href="?mode=clan&clantag=' . urlencode($clantag) . '&sort=warden%20desc"><img height=25 src="images/Grand%20Warden.png" title="Grand Warden"></a>-<a class="mywhite" href="?mode=clan&clantag=' . urlencode($clantag) . '&sort=royal%20desc"><img height=25 src="images/Royal%20Champion.png" title="Royal Champion"></a></th>';
$th_stars_cw = '<th><a class="mywhite" href="?mode=clan&clantag=' . urlencode($clantag) . '&sort=stars_cw%20desc" title="' . $language['CL_TABLE_AVG_STARS_DESC'] . '">' . $language['CL_TABLE_AVG_STARS'] . '</a></th>';
$th_stars_cw_mirr = '<th><a class="mywhite" href="?mode=clan&clantag=' . urlencode($clantag) . '&sort=stars_cw_mirr%20desc" title="' . $language['CL_TABLE_AVG_STARS_MIRR_DESC'] . '">' . $language['CL_TABLE_AVG_STARS_MIRR'] . '</a></th>';
$th_stars_cw_th = '<th><a class="mywhite" href="?mode=clan&clantag=' . urlencode($clantag) . '&sort=stars_cw_th%20desc" title="' . $language['CL_TABLE_AVG_STARS_TH_DESC'] . '">' . $language['CL_TABLE_AVG_STARS_TH'] . '</a></th>';
$th_stars_cwl_avg = '<th><a class="mywhite" href="?mode=clan&clantag=' . urlencode($clantag) . '&sort=stars_cwl%20desc" title="' . $language['CL_TABLE_AVG_STARS_CWL_DESC'] . '">' . $language['CL_TABLE_AVG_STARS_CWL'] . '</a></th>';
$th_stars_cwl_th = '<th><a class="mywhite" href="?mode=clan&clantag=' . urlencode($clantag) . '&sort=stars_cwl%20desc" title="' . $language['CL_TABLE_AVG_STARS_CWL_TH_DESC'] . '">' . $language['CL_TABLE_AVG_STARS_CWL_TH'] . '</a></th>';
$th_stars_def = '<th><a class="mywhite" href="?mode=clan&clantag=' . urlencode($clantag) . '&sort=def_stars%20asc" title="' . $language['CL_TABLE_DEF_DESC'] . '">' . $language['CL_TABLE_DEF'] . '</a></th>';
$th_3stars = '<th><a class="mywhite" href="?mode=clan&clantag=' . urlencode($clantag) . '&sort=three_stars%20desc" title="' . $language['CL_TABLE_3_STARS_DESC'] . '">' . $language['CL_TABLE_3_STARS'] . '</a></th>';
$th_capital_attacks = '<th><a class="mywhite" href="?mode=clan&clantag=' . urlencode($clantag) . '&sort=three_stars%20desc" title="' . $language['CL_TABLE_CAPITAL_ATTACKS_DESC'] . '">' . $language['CL_TABLE_CAPITAL_ATTACKS'] . '</a></th>';
$th_capital_points= '<th><a class="mywhite" href="?mode=clan&clantag=' . urlencode($clantag) . '&sort=three_stars%20desc" title="' . $language['CL_TABLE_CAPITAL_POINTS_DESC'] . '">' . $language['CL_TABLE_CAPITAL_POINTS'] . '</a></th>';
$th_last_war = '<th><a class="mywhite" href="?mode=clan&clantag=' . urlencode($clantag) . '&sort=last_war_week%20desc,last_war_day%20desc,last_war_hour%20desc" title="' . $language['CL_TABLE_LAST_WAR_DAYS_DESC'] . '">' . $language['CL_TABLE_LAST_WAR_DAYS'] . '</a></th>';
$th_donations = '<th>Donations</th>';
$th_donations_rec = '<th>Received</th>';
$th_donations_ratio = '<th><a class="mywhite" href="?mode=clan&clantag=' . urlencode($clantag) . '&sort=donations%20desc" title="' . $language['CL_TABLE_RATIO_DESC'] . '">' . $language['CL_TABLE_RATIO'] . '</a></th>';


if (empty($sort)) {
    $sort = "townHallLevel DESC, stars_cw DESC, stars_cwl DESC, three_stars_cw DESC";
}


$members_sql = "SELECT name, role, warPreference, tag, trophies, expLevel, clan_name, townHallLevel, townHallWeaponLevel, league, warStars, 
  unix_timestamp(createDate) as createDate,
  (select level from troops where player_tag=p.tag and name=\"Barbarian King\") as king,
  (select level from troops where player_tag=p.tag and name=\"Archer Queen\") as queen,
  (select level from troops where player_tag=p.tag and name=\"Grand Warden\") as warden,
  (select level from troops where player_tag=p.tag and name=\"Royal Champion\") as royal,
  (select attacks from raids where attacker_tag=p.tag and startTime >= date_sub(now(), interval 7 day) order by startTime desc limit 1) as capital_attacks,
  (select IFNULL(ROUND(AVG(capitalResourcesLooted)/1000, 0), 0) from raids where attacker_tag=p.tag and startTime >= date_sub(now(), interval $days day)) as capital_points,
  (SELECT ROUND(AVG(attack_stars),1) FROM attacks WHERE attacker_tag = p.tag AND startTime >= date_sub(now(), interval $days day)) AS stars_cw, 
  (SELECT ROUND(AVG(destructionPercentage)) FROM attacks WHERE attacker_tag = p.tag AND startTime >= date_sub(now(), interval $days day)) AS percentage_cw, 
  (SELECT ROUND(AVG(attack_stars),1) FROM attacks WHERE attacker_tag = p.tag AND attacker_th = defender_th AND defender_th = p.townHallLevel AND startTime >= date_sub(now(), interval $days day)) as stars_cw_th,
  (SELECT ROUND(AVG(destructionPercentage)) FROM attacks WHERE attacker_tag = p.tag AND attacker_th = defender_th AND defender_th = p.townHallLevel AND startTime >= date_sub(now(), interval $days day)) as percentage_cw_th,
  (select round(avg(attack_stars),1) from attacks where attacker_tag = p.tag AND attacker_map_pos = defender_map_pos AND startTime >= date_sub(now(), interval $days day)) as stars_cw_mirr,
  (select round(avg(destructionPercentage)) from attacks where attacker_tag = p.tag AND attacker_map_pos = defender_map_pos AND startTime >= date_sub(now(), interval $days day)) as percentage_cw_mirr,
  (select round(avg(attack_stars),1) from attacks_cwl where attacker_tag = p.tag AND startTime >= date_sub(now(), interval $days day)) as stars_cwl,
  (select round(avg(destructionPercentage)) from attacks_cwl where attacker_tag = p.tag AND startTime >= date_sub(now(), interval $days day)) as percentage_cwl,
  (SELECT ROUND(AVG(attack_stars),1) FROM attacks_cwl WHERE attacker_tag = p.tag AND attacker_th = defender_th AND defender_th = p.townHallLevel AND startTime >= date_sub(now(), interval $days day)) as stars_cwl_th,
  (select round(avg(attack_stars),1) from v_attacks where defender_tag = p.tag AND defender_th = p.townHallLevel AND startTime >= date_sub(now(), interval $days day))  as def_stars,
  (select round(avg(attack_stars),1) from attacks_cwl where defender_tag = p.tag AND defender_th = p.townHallLevel AND startTime >= date_sub(now(), interval $days day)) as def_stars_cwl,
  (SELECT count(*) from attacks where attacker_tag = p.tag AND attack_stars=3 AND startTime >= date_sub(now(), interval $days day)) as three_stars_cw,
  (SELECT count(*) from attacks_cwl where attacker_tag = p.tag AND attack_stars=3 AND startTime >= date_sub(now(), interval $days day)) as three_stars_cwl,
  (SELECT count(*) from attacks where attacker_tag = p.tag AND startTime >= date_sub(now(), interval $days day)) as attacks_cw,
  (SELECT count(*) from attacks_cwl where attacker_tag = p.tag AND startTime >= date_sub(now(), interval $days day)) as attacks_cwl,
  (SELECT COALESCE(TIMESTAMPDIFF(WEEK, MAX(startTime), NOW()),0) FROM v_attacks WHERE attacker_tag = p.tag) as last_war_week,
  (SELECT COALESCE(TIMESTAMPDIFF(DAY, MAX(startTime), DATE_SUB(NOW(),INTERVAL last_war_week WEEK)),0)FROM v_attacks a WHERE a.attacker_tag = p.tag) as last_war_day,
  (SELECT COALESCE(TIMESTAMPDIFF(HOUR, MAX(startTime), NOW()),0) FROM v_attacks a WHERE a.attacker_tag = p.tag) as last_war_hour,
  (SELECT COALESCE(TIMESTAMPDIFF(MINUTE, MAX(startTime), NOW()),0) FROM v_attacks a WHERE a.attacker_tag = p.tag) as last_war_minute,
  (select MAX(unix_timestamp(startTime)) from v_attacks where attacker_tag = tag) AS last_war,
  (select MAX(unix_timestamp(startTime)) from v_attacks where attacker_tag = tag AND attacker_clan = p.clan_tag) AS last_war_clan,
  (SELECT count(*) from v_attacks where attacker_tag = p.tag AND attacker_clan = p.clan_tag AND attacker_th = defender_th AND defender_th = p.townHallLevel AND startTime >= date_sub(now(), interval $days day)) as attacks_clan,
  (SELECT ROUND(AVG(attack_stars),1) FROM v_attacks WHERE attacker_tag = p.tag AND attacker_clan = p.clan_tag AND attacker_th = defender_th AND defender_th = p.townHallLevel AND startTime >= date_sub(now(), interval $days day)) as th_stars_clan, donations, donationsReceived from players p where clan_tag = \"$clantag\" order by " . $sort;

if ($result = mysqli_query($conn, $members_sql)) {
  if (mysqli_num_rows($result) > 0) {      
    while ($member = mysqli_fetch_assoc($result)) {
      
      $weak_attacker   = false;
      $newcomer        = false;
      $strong_attacker = false;
      $ace_attacker    = false;
      $donator         = false;
      $inactive        = false;

      #--------------------For weak and strong attackers. Make sure that we have different requirements for different klans. Also make sure we only count the attacks made in the current clan.
												   
      if (!isset($member['last_war_clan']))
	$newcomer = true;
      if ((isset($member['th_stars_clan'])) && ($member['th_stars_clan'] < 1.5) && ($member['attacks_clan'] >= 9))
	$weak_attacker = true;
      if ($member['th_stars_clan'] >= 2.3 && $member['attacks_clan'] >= 9)
	$strong_attacker = true;
      if ($member['th_stars_clan'] == 3.0 && $member['attacks_clan'] >= 3)
	$ace_attacker = true;     
      if($member['donations'] > 1500)
	$donator = true;
      if((isset($member['last_war']) && (time() - $member['last_war'] > (60*60*24*21))) || (!isset($member['last_war']) && (time() - $member['createDate'] > (60*60*24*21))))
	$inactive = true;
      
      $cmn_table = "<td><img src=\"images/" . $member['warPreference'] . ".png\" height=25 alt=\"Preference\"></td>";
      $cmn_table .= "<td><img src=\"" . $member['league'] . "\" height=25 alt=\"League\"></td>";
      $cmn_table .= "<td><a href=\"?mode=player&playertag=" . urlencode($member['tag']) . "\"><b>" . htmlspecialchars($member['name'], ENT_QUOTES) . "</b></a>";
      $cmn_table .= "</td>";

      $tbl_awards = "<td>";
      if (time() - $member['createDate'] > (60*60*24*365*3))
	$tbl_awards .= "<img height=25 src=\"images/trophy_1f3c6.png\" alt=\"Medal 3 years\">";
      else if (time() - $member['createDate'] > (60*60*24*365*1))
	$tbl_awards .= '<img height=25 src="images/1st-place-medal_1f947.png" alt="Medal 1 year">';
      if ($newcomer)
	$tbl_awards .= '<img height=25 src="images/monkey-face_1f435.png" alt="Monkey">';
      if($member['donations'] > 4000)
	$tbl_awards .= '<img height=25 src="images/star_2b50.png" alt="Gold star">';
      else if($member['donations'] > 3000)
	$tbl_awards .= '<x style="color:#FF0000;font-size:20px;">★</x>';
      else if($member['donations'] > 2500)
	$tbl_awards .= '<x style="color:#3333FF;font-size:20px;">★</x>';
      else if($member['donations'] > 1500)
	$tbl_awards .= '<x alt="asd" style="color:#000000;font-size:20px;">★</x>';

      if(($member['role'] != "leader") && $strong_attacker)
	$tbl_awards .= '<x style="color:#22BB22;font-size:20px;">▲</x>';
      else if(($member['role'] != "leader") && ($weak_attacker))
	$tbl_awards .= '<x style="color:#FFAA33;font-size:20px;">▼</x>';
      else if(($member['role'] != "leader") && ($inactive))
        $tbl_awards .= '<x style="color:#FF0000;font-size:20px;">▼</x>';
      
      if($ace_attacker)
	$tbl_awards .= ' 🂡';
      $tbl_awards .= '</td>';
      
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
                    if ($clantag == '#9V8RQ2PR' || $clantag == '#80L9VRJR' || $clantag == '#YJJ8UGG2' || $clantag == '#LRRPUR88' || $clantag == '#209QPLUV2' || $clantag == '#2LGRUG8YP')
                        $member['role'] = "Viking";
                    $role_color = '';
                    break;
            }

            $tbl_role = "<td style=\"text-align: center;\" " . $role_color . ">" . $member['role'];
	    $tbl_role .= "</td>";
	    
	    if ($member['townHallWeaponLevel'] == 0)
	      $tbl_th = "<td align=center>" . $member['townHallLevel'] . "</td>";
	    else
	      $tbl_th = "<td align=center>" . $member['townHallLevel'] . "<sup>" . $member['townHallWeaponLevel'] . "</sup></td>";
	    
	    $tbl_exp = "<td align=center>" . $member['expLevel'] . "</td>";
            $tbl_trophies = '<td align=center>' . $member['trophies'] . "</td>";
            $tbl_war_stars = "<td align=center>" . $member['warStars'] . "</td>";
            if (isset($member['king']))
                $tbl_heroes = "<td align=center>" . $member['king'] . "-";
            else
                $tbl_heroes = "<td align=center>0-";
            if (isset($member['queen']))
                $tbl_heroes .= "" . $member['queen'] . "-";
            else
                $tbl_heroes .= "0-";
            if (isset($member['warden']))
                $tbl_heroes .= "" . $member['warden'] . "-";
            else
                $tbl_heroes .= "0-";
            if (isset($member['royal']))
                $tbl_heroes .= "" . $member['royal'] . "</td>";
            else
                $tbl_heroes .= "0</td>";

            if (!isset($member['stars_cw']))
                $member['stars_cw'] = 0;
            if (!isset($member['stars_cw_mirr']))
                $member['stars_cw_mirr'] = 0;
            if (!isset($member['stars_cw_th']))
                $member['stars_cw_th'] = 0;
            if (!isset($member['stars_cwl']))
                $member['stars_cwl'] = '-';
            if (!isset($member['stars_cwl_th']))
                $member['stars_cwl_th'] = '-';
            if (!isset($member['def_stars']))
                $member['def_stars'] = '-';
            if (!isset($member['percentage_cw']))
                $member['percentage_cw'] = 0;
            if (!isset($member['percentage_cw_mirr']))
                $member['percentage_cw_mirr'] = 0;
            if (!isset($member['percentage_cw_th']))
                $member['percentage_cw_th'] = 0;
            if (!isset($member['percentage_cwl']))
                $member['percentage_cwl'] = '-';

	    $stars_color_cw = calculate_color($member['stars_cw']);
	    $member['stars_cw'] = $member['stars_cw'] . ' @ ' . $member['percentage_cw'] . '%';
	    
	    $stars_color_cw_mirr = calculate_color($member['stars_cw_mirr']);
	    $member['stars_cw_mirr'] = $member['stars_cw_mirr'] . ' @ ' . $member['percentage_cw_mirr'] . '%';
	    
	    $stars_color_cw_th = calculate_color($member['stars_cw_th']);
	    $member['stars_cw_th'] = $member['stars_cw_th'] . ' @ ' . $member['percentage_cw_th'] . '%';
	    
	    if ($member['stars_cwl'] == '-')
	      $stars_color_cwl = '';
	    else
	      {
		$stars_color_cwl = calculate_color($member['stars_cwl']);
		$member['stars_cwl'] = $member['stars_cwl'] . ' @ ' . $member['percentage_cwl'] . '%';
	      }

	    if ($member['stars_cwl_th'] == '-')
	      $stars_color_cwl_th = '';
	    else
	      {
		$stars_color_cwl_th = calculate_color($member['stars_cwl_th']);
		$member['stars_cwl_th'] = $member['stars_cwl_th'] . ' @ ' . $member['percentage_cwl_th'] . '%';
	      }

            $tbl_cw_of = '<td align=center ' . $stars_color_cw . ' >' . $member['stars_cw'] . '</td>';
            $tbl_cw_of_mirr = '<td align=center ' . $stars_color_cw_mirr . ' >' . $member['stars_cw_mirr'] . '</td>';
            $tbl_cw_of_th = '<td align=center ' . $stars_color_cw_th . ' >' . $member['stars_cw_th'] . '</td>';

            $tbl_cwl_of = '<td align=center ' . $stars_color_cwl . ' >' . $member['stars_cwl'] . '</td>';
            $tbl_cwl_of_th = '<td align=center ' . $stars_color_cwl_th . ' >' . $member['stars_cwl_th'] . '</td>';
	    $tbl_cw_def = '<td align=center>' . $member['def_stars'] . '</td>';
	    
            $tbl_three_stars = '<td align=center>' . $member['three_stars_cw'] . ' / ';
            $tbl_three_stars .= $member['attacks_cw'] . '</td>';

	    if(!isset($member['capital_attacks']))
	      {
		$member['capital_attacks'] = 0;
		$raid_colour = 'class="table-danger"';
	      }
	    else
	      {
		if($member['capital_attacks'] < 6)
		  $raid_colour = 'class="table-warning"';
		else
		  $raid_colour = 'class="table-success"';
	      }
		$tbl_capital_attacks = "<td align=center " . $raid_colour . ">" . $member['capital_attacks'] . "</td>";
		$tbl_capital_points = "<td align=center>" . $member['capital_points'] . "k</td>";	      
	    
            $tbl_last_war = "<td align=center>";
	      
            if ($member['last_war_week'] > 0 || $member['last_war_day'] > 0) {
                if ($member['last_war_week'] > 0)
                    $tbl_last_war .= $member['last_war_week'] . "w ";
                if ($member['last_war_day'] > 0)
                    $tbl_last_war .= $member['last_war_day'] . "d";
            } else if ($member['last_war_hour'] > 0) {
                $tbl_last_war .= $member['last_war_hour'] . "h";
            } else if ($member['last_war_minute'] > 0) {
                $tbl_last_war .= $member['last_war_minute'] . " min";
            } else {
                $tbl_last_war .= "-";
            }
            $tbl_last_war .= "</td>";

	    $tbl_donations = '<td align=center>' . $member['donations'] . '</td>';
	    $tbl_donations_rec = '<td align=center>' . $member['donationsReceived'] . '</td>';


	    if($member['donationsReceived'] == 0)
	      $donation_received = 1;
	    else
	      $donation_received = $member['donationsReceived'];
		
	    if (version_compare(phpversion(), "8.0.0", ">=")) {
	      $donation_count = round(fdiv($member['donations'], $donation_received), 2);
	    }
	    else {
	      $donation_count = round($member['donations'] / $donation_received, 2);
	    }
	    
            if ($member['donations'] == 0)
	      $donation_colour = 'style="background-color:rgb(255,0,0)"';
	    else if ($member['donations'] > 1000)
	      $donation_colour = 'class="table-success"';
            else if (($donation_count < 0.4) || ($member['donations'] < 10))
	      $donation_colour = 'class="table-danger"';
            else if ((($donation_count <= 0.6) && ($donation_count >= 0.4)) || ($member['donations'] < 100))
	      $donation_colour = 'class="table-warning"';
            else if ($donation_count > 0.6)
	      $donation_colour = 'class="table-success"';
            else
	      $donation_colour = 'class="table-secondary"';

            $tbl_donations_ratio = "<td align=center " . $donation_colour . ">" . $donation_count . "</td>";

	    $table_cw .= '<tr>' . $cmn_table . $tbl_heroes . $tbl_cw_of . $tbl_cw_of_mirr . $tbl_cw_of_th . $tbl_cw_def . $tbl_three_stars . $tbl_last_war . '</tr>';
	    $table_cwl .= '<tr>' . $cmn_table . $tbl_heroes . $tbl_cwl_of . $tbl_cwl_of_th . $tbl_last_war . '</tr>';
	    $table_capital .= '<tr>' . $cmn_table . $tbl_capital_attacks . $tbl_capital_points . '</tr>';
	    $table_donations .= '<tr>' . $cmn_table . $tbl_donations . $tbl_donations_rec . $tbl_donations_ratio . '</tr>';
	    $table_activity .= '<tr>' . $cmn_table . $tbl_last_war . '</tr>';
	    $table_awards .= '<tr>' . $cmn_table . $tbl_role . $tbl_awards . $tbl_exp . $tbl_trophies . '</tr>';
        }
    } else {
        echo "Error fetching data for $clantag <br>";
    }
} else {
    echo "<br>FAIL! Member - " . mysqli_error($conn) . "<br>";
}
mysqli_close($conn);

$content .= '<ul class="nav nav-tabs" id="clanTab">';
$content .= '<li class="nav-item active"><a class="nav-link active" data-bs-toggle="tab" href="#CW">' . $language['CL_TAB_CW'] . '</a></li>';
$content .= '<li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#CWL">' . $language['CL_TAB_CWL'] . '</a></li>';
$content .= '<li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#ClanCapital">' . $language['CL_TAB_CAPITAL'] . '</a></li>';
$content .= '<li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#Donations">' . $language['CL_TAB_DONATIONS'] . '</a></li>';
$content .= '<li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#Activity">' . $language['CL_TAB_ACTIVITY'] . '</a></li>';
$content .= '<li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#Awards">' . $language['CL_TAB_AWARDS'] . '</a></li>';
$content .= '</ul>';
$content .= '<div class="tab-content clan-tab">';
$content .= '<div id="CW" class="tab-pane fade in active show">';

$content .= '<table class="table table-sm table-light" border=0>';
$content .= '<thead align=center class="table-dark"><tr>';

$content .= $th_common . $th_heroes . $th_stars_cw . $th_stars_cw_mirr . $th_stars_cw_th . $th_stars_def . $th_3stars . $th_last_war . '</tr></thead><tbody>';
$content .= $table_cw . '</tbody></table>';

$content .= '</div>';
$content .= '<div id="CWL" class="tab-pane fade">';

$content .= '<table class="table table-sm table-light" border=0>';
$content .= '<thead align=center class="table-dark"><tr>';

$content .= $th_common . $th_heroes . $th_stars_cwl_avg . $th_stars_cwl_th . $th_last_war . '</tr></thead><tbody>';
$content .= $table_cwl . '</tbody></table>';

$content .= '</div>';
$content .= '<div id="ClanCapital" class="tab-pane fade">';

$content .= '<table class="table table-sm table-light" border=0>';
$content .= '<thead align=center class="table-dark"><tr>';

$content .= $th_common . $th_capital_attacks . $th_capital_points . '</tr></thead><tbody>';
$content .= $table_capital . '</tbody></table>';

$content .= '</div>';
$content .= '<div id="Donations" class="tab-pane fade">';

$content .= '<table class="table table-sm table-light" border=0>';
$content .= '<thead align=center class="table-dark"><tr>';

$content .= $th_common . $th_donations . $th_donations_rec . $th_donations_ratio . '</tr></thead><tbody>';
$content .= $table_donations . '</tbody></table>';

$content .= '</div>';
$content .= '<div id="Activity" class="tab-pane fade">';

$content .= '<table class="table table-sm table-light" border=0>';
$content .= '<thead align=center class="table-dark"><tr>';

$content .= $th_common . $th_last_war . '</tr></thead><tbody>';
$content .= $table_activity . '</tbody></table>';

$content .= '</div>';
$content .= '<div id="Awards" class="tab-pane fade">';

$content .= '<table class="table table-sm table-light" border=0>';
$content .= '<thead align=center class="table-dark"><tr>';

$content .= $th_common . $th_role . $th_awards . $th_exp . $th_trophies . '</tr></thead><tbody>';
$content .= $table_awards . '</tbody></table>';

$content .= '</div></div>';


echo $content;


function calculate_color($stars)
{
  if ($stars <= 2.0) {
    $r = 255 - 255;
    $g = 255 - 155;
    $b = 255 - 155;
    $s = 2 - $stars;
    $r1 = round($r * $s + 255, 0);
    $g1 = round(230 - $g * $s, 0);
    $b1 = round(230 - $b * $s, 0);
    $stars_color = 'style="background-color:rgb(' . $r1 . ',' . $g1 . ',' . $b1 . ')"';
  }
  else if ($stars > 2.0) {
    $r = 255 - 100;
    $g = 255 - 200;
    $b = 255 - 110;
    $s = 3 - $stars;
    $r1 = round($r * $s + 108, 0);
    $g1 = round($g * $s + 215, 0);
    $b1 = round($b * $s + 111, 0);
    $stars_color = 'style="background-color:rgb(' . $r1 . ',' . $g1 . ',' . $b1 . ')"';
  }
  else
    $stars_color = 'x';
  
  return $stars_color;
}
