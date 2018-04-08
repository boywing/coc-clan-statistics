<?php

include("html/head.html");
include("html/menu.html");

$clantag = htmlspecialchars($_GET["clantag"]);
$playertag = htmlspecialchars($_GET["playertag"]);
$mode = htmlspecialchars($_GET["mode"]);
$scope = htmlspecialchars($_GET["scope"]);

if(empty($clantag) && empty($mode))
    {
        $mode = "clan";
        $clantag = "#9V8RQ2PR";
    }

if ($mode == "clan")
    include("clan.php");
else if ($mode == "player")
    include("player.php");
else if ($mode == "clans")
    include("all_clans.php");
else if ($mode == "players")
    include("all_players.php");
else if ($mode == "wars")
    include("wars.php");

include("html/tail.html");

?>