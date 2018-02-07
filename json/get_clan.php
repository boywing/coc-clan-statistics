<?php

# Hash sign (#) is %23 as url-encoded

$clantag = $_GET['clantag'];

$clan_sql = "SELECT * FROM clans WHERE tag = '" . $clantag . "'";

include "../mysql_coc.php";

if($result = mysqli_query($conn, $clan_sql))
    {
        if (mysqli_num_rows($result) > 0)
            {
                $obj = mysqli_fetch_object($result);
                $json_result = json_encode($obj, JSON_PRETTY_PRINT);
                echo $json_result;
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

?>