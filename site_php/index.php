<?php

include("html/head.html");
include("html/menu.html");

# Global variables
$days = 60; # Amount of days to show in statistics.

# Parameters sent to the form
$clantag = htmlspecialchars($_GET["clantag"]);
$playertag = htmlspecialchars($_GET["playertag"]);
$mode = htmlspecialchars($_GET["mode"]);
$scope = htmlspecialchars($_GET["scope"]);
$sort = htmlspecialchars($_GET["sort"]);

# Default values if calling page with no parameters
if(empty($clantag) && empty($mode))
    {
        $mode = "clan";
        $clantag = "#9V8RQ2PR";
    }

include("top_clans.php");

# Switch mode
if ($mode == "clan")
    include("clan.php");
else if ($mode == "player")
    include("player.php");
else if ($mode == "clans")
    include("all_clans.php");
else if ($mode == "players")
    include("all_players.php");
else if ($mode == "offence")
    include("all_players_offence.php");
else if ($mode == "wars")
    include("wars.php");

include("html/tail.html");

?>