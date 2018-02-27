<?php

include("html/head.html");
include("html/menu.html");

$clantag = htmlspecialchars($_GET["clantag"]);
$playertag = htmlspecialchars($_GET["playertag"]);
$mode = htmlspecialchars($_GET["mode"]);

if ($mode == "clan")
    include("clan.php");
else if ($mode == "player")
    include("player.php");

include("html/tail.html");

?>