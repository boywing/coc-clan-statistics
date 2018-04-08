<?php

if(!isset($clantag))
    $clantag = "#9V8RQ2PR";

$content .= "<h2>Wars</h2>";
$content .= '<table class="table table-light" style="border-collapse: separate; border-spacing: 1px;border:1px solid black;" border=1>';
$content .= '<thead class="thead-dark"><th>Date</th><th>Result</th><th>Size</th><th>Clan 1</th><th>Clan 2</th></thead>';
$content .= "<tbody>";

$wars_sql = "select * from wars where (clan1_tag = '" . $clantag . "' OR clan2_tag = '" . $clantag . "') order by endTime desc";
    
include "../mysql_coc.php";
if($result = mysqli_query($conn, $wars_sql))
    {
        if (mysqli_num_rows($result) > 0)
            {
                while($war = mysqli_fetch_assoc($result))
                    {
                        if($war['result'] == "win")
                            $content .= '<tr class="table-success">';
                        else
                            $content .= '<tr class="table-danger">';
                        $content .= "<td>" . $war['endTime'] . '</td><td>' . $war['result'] . '</td><td>' . $war['teamSize'] . '</td>';
                        $content .= '<td><a href="?mode=clan&clantag=' . urlencode($war['clan1_tag']) . '">' . $war['clan1_name'] . "</a></td>";
                        $content .= '<td><a href="?mode=clan&clantag=' . urlencode($war['clan2_tag']) . '">' . $war['clan2_name'] . "</a></td>";
                        $content .= "</tr>";
                    }
            }
        else
            {
                echo "Error fetching data for clan $clantag <br>";
            }
    }
else
    {
        echo "<br>FAIL! - " . mysqli_error($conn) . "<br>";
    }
$content .= "</tbody></table>";

mysqli_close($conn);
echo $content;
?>