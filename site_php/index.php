<?php

include("html/head.html");

$clantag = htmlspecialchars($_GET["clantag"]);
$playertag = htmlspecialchars($_GET["playertag"]);
$mode = htmlspecialchars($_GET["mode"]);

echo '<div style="padding: 5px">';
echo '<table style="border-collapse: separate; border-spacing: 0px;border:1px solid black" border=1><tr><td><a href="?mode=clan&clantag=%239V8RQ2PR">Aktiva Vikingar</a></td><td><a href="?mode=clan&clantag=%2380L9VRJR">AktivaVikingar2</a></td><td><a href="?mode=clan&clantag=%23YJJ8UGG2">AktivaVikingar3</a></td><td><a href="?mode=clan&clantag=%23PU2CRG2Y">Vilande Vikingar</a></td><td><a href="?mode=clan&clantag=%23LRRPUR88">VilandeVikingar2</a></td></tr></table>';

if ($mode == "clan")
    include("clan.php");
else if ($mode == "player")
    include("player.php");

echo "</div>";
include("html/tail.html");

?>