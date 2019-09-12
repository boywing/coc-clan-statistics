<?php

$content = '<h1>' . $language['CLS_TITLE'] . '</h1>';
$content .= '<table class="table table-striped table-sm table-hover table-light" border=0>';
$content .= '<thead class="thead-dark"><th>&nbsp;</th><th>' . $language['CL_TABLE_NAME'] . '</th><th>' . $language['CL_TAG'] . '</th><th>' . $language['CL_LOC'] . '</th><th>' . $language['CL_LEVEL'] . '</th>';
$content .= '<th><img height=25 src="images/Trophy.png"></th>';
$content .= '<th>' . $language['CL_MEMBERS'] . '</th><th>' . $language['CL_UPDATED'] . '</th>';
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
                        $content .= "<td><a href=?mode=clan&clantag=" . urlencode($clan['tag']) . "><b>" . htmlspecialchars($clan['name'], ENT_QUOTES) . "</b></a></td>";
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
