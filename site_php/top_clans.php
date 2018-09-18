<?php

$content .= '<p/><table class="table table-striped table-sm table-hover table-light">';
$content .= '<thead  align=center class="thead-dark">';
$content .= '<th>&nbsp;</th>';
$content .= '<th>Clan name</th>';
$content .= '<th>Lvl</th>';
$content .= '<th>War stars</th>';
$content .= '<th><img height=25 src="images/Trophy.png"></th>';
$content .= '<th>Members</th>';
$content .= '<th>Avg stars</th>';
$content .= "<tbody>";

$cl_sql = "SELECT *,(select round(avg(attack_stars),1) from attacks where attacker_clan = c.tag AND attacker_map_pos = defender_map_pos AND startTime >= date_sub(now(), interval $days day)) as stars,(SELECT SUM(warStars) FROM players where clan_tag = c.tag) as warStars FROM clans c WHERE tag IN ('#9V8RQ2PR', '#80L9VRJR', '#YJJ8UGG2', '#220CLU8G0', '#PU2CRG2Y') ORDER BY clanpoints DESC";

include "../mysql_coc.php";

if($result = mysqli_query($conn, $cl_sql))
    {
        if (mysqli_num_rows($result) > 0)
            {
                while($cl = mysqli_fetch_assoc($result))
                    {
                        
                        $content .= "<tr><td><img src=\"" . $cl['badge'] . "\" height=30></td>";
                        $content .= "<td><a href=?mode=clan&clantag=" . urlencode($cl['tag']) . "><b>" . $cl['name'] . "</b></a></td>";
                        $content .= "<td align=center>" . $cl['clanLevel'] . "</td>";
                        $content .= "<td align=center>" . $cl['warStars'] . "</td>";
                        $content .= "<td align=center>" . $cl['clanPoints'] . "</td>";
                        $content .= "<td align=center>" . $cl['members'] . "</td>";
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