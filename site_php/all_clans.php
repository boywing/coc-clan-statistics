<?php


$content = '<h1>Clans</h1>';
$content .= '<table class="table table-striped table-sm table-hover table-light" border=0>';
$content .= '<thead class="thead-dark"><th>&nbsp;</th><th>Name</th><th>Tag</th><th>Location</th><th>Lvl</th>';
$content .= '<th><img height=25 src="images/Trophy.png"></th>';
$content .= '<th>Members</th><th>Updated</th>';
$content .= "<tbody>";

$clan_sql = "SELECT * FROM clans order by clanpoints desc";

include "../mysql_coc.php";

if($result = mysqli_query($conn, $clan_sql))
    {
        if (mysqli_num_rows($result) > 0)
            {
                while($clan = mysqli_fetch_assoc($result))
                    {
                        
                        $content .= "<tr><td><img src=\"" . $clan['badge'] . "\" height=30></td>";
                        $content .= "<td><a href=?mode=clan&clantag=" . urlencode($clan['tag']) . "><b>" . $clan['name'] . "</b></a></td>";
                        $content .= "<td>" . $clan['tag'] . "</td>";
                        $content .= "<td>" . $clan['location'] . "</td>";
                        $content .= "<td>" . $clan['clanLevel'] . "</td>";
                        $content .= "<td>" . $clan['clanPoints'] . "</td>";
                        $content .= "<td>" . $clan['members'] . "</td>";
                        $content .= "<td>" . $clan['timestamp'] . "</td></td>";
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