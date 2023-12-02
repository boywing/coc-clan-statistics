<?php

$content .= '<p><table class="small table table-striped table-sm table-hover table-light">';
$content .= '<thead  align=center class="table-dark">';
$content .= '<th>&nbsp;</th>';
$content .= '<th>' . $language['CL_TABLE_NAME'] . '</th>';
$content .= '<th>' . $language['CL_TABLE_LVL'] . '</th>';
$content .= '<th>' . $language['CL_TABLE_WAR_STARS'] . '</th>';
$content .= '<th><img height=25 src="images/Trophy.png" alt="Trophy"></th>';
$content .= '<th>' . $language['CL_CAPITAL_POINTS'] . '</th>';
$content .= '<th>' . $language['CL_BUILDER_HOME'] . '</th>';
$content .= '<th>' . $language['CL_MEMBERS'] . '</th>';
$content .= '<th>' . $language['CL_MEMBERS_GREEN'] . '</th>';
$content .= '<th>' . $language['CL_AVG_TH'] . '</th>';
$content .= '<th>' . $language['CL_TABLE_AVG_STARS'] . '</th>';
$content .= "<tbody>";

$cl_sql = "SELECT *,";
$cl_sql .= "(select count(*) from players where clan_tag = c.tag and warPreference='in') as green,";
$cl_sql .= "(select count(*) from players where clan_tag = c.tag and warPreference='out') as red,";
$cl_sql .= "(select round(avg(attack_stars),1) from attacks where attacker_clan = c.tag AND attacker_map_pos = defender_map_pos AND startTime >= date_sub(now(), interval $days day)) as stars,";
$cl_sql .= "(SELECT SUM(warStars) FROM players where clan_tag = c.tag) as warStars, ";
$cl_sql .= "(SELECT ROUND(AVG(townHallLevel),1) FROM players where clan_tag=c.tag) AS avg_th ";
$cl_sql .= "FROM clans c WHERE tag IN ('#9V8RQ2PR', '#80L9VRJR', '#YJJ8UGG2', '#220CLU8G0', '#209QPLUV2', '#2LGRUG8YP', '#2Q0UPCCJ2') ORDER BY name ASC";

include "../mysql_coc.php";

if($result = mysqli_query($conn, $cl_sql))
  {
    if (mysqli_num_rows($result) > 0)
      {
	while($cl = mysqli_fetch_assoc($result))
	  {
	    
	    $content .= "<tr><td><img src=\"" . $cl['badge'] . "\" height=22 alt=\"Badge\"></td>";
	    $content .= "<td><a href=\"?mode=clan&clantag=" . urlencode($cl['tag']) . "\"><b>" . htmlspecialchars($cl['name'], ENT_QUOTES) . "</b></a></td>";
	    $content .= "<td align=center>" . $cl['clanLevel'] . "</td>";
	    $content .= "<td align=center>" . $cl['warStars'] . "</td>";
	    $content .= "<td align=center>" . $cl['clanPoints'] . "</td>";
	    $content .= "<td align=center>" . $cl['clanCapitalPoints'] . "</td>";
	    $content .= "<td align=center>" . $cl['clanVersusPoints'] . "</td>";
	    $content .= "<td align=center>" . $cl['members'] . "</td>";
	    $content .= "<td align=center style=\"color: green;\"><b>" . $cl['green'] . "</b></td>";
	    $content .= "<td align=center>" . $cl['avg_th'] . "</td>";	
	    $content .= "<td align=center>" . $cl['stars'] . "</td>";
	  }
      }
        else
            {
                echo "Error fetching data for clan <br>";
            }
    }
else
    {
        echo "<br>FAIL! cl - " . mysqli_error($conn) . "<br>";
    }

$content .= "</tbody></table>";
mysqli_free_result($result);
mysqli_close($conn);
echo $content;
?>
