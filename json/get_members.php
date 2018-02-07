<?php

# Hash sign (#) is %23 as url-encoded

$clantag = $_GET['clantag'];

$clan_sql = "SELECT * FROM players WHERE clan_tag = '" . $clantag . "'";

include "../mysql_coc.php";

if($result = mysqli_query($conn, $clan_sql))
    {
        if (mysqli_num_rows($result) > 0)
            {
                echo "[";
                $obj = mysqli_fetch_object($result);
                    $json_result = json_encode($obj, JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK);
                    echo $json_result;

                while($obj = mysqli_fetch_object($result))
                {
                    echo ",\n";
                    $json_result = json_encode($obj, JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK);
                    echo $json_result;
                }
                echo "]";
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