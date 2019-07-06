<?php

# Global variables
$days = 60;                                 # Amount of days to show in statistics.
$site_title = "Aktiva Vikingars Statistik"; # The sites title text
$menu_title = "AV Statistik";               # The shorter title for the menu
$default_language = "se";                   # Set default language e.g. "se", "en", "de"

# Parameters sent to the form
$clantag = htmlspecialchars($_GET["clantag"]);
$playertag = htmlspecialchars($_GET["playertag"]);
$mode = htmlspecialchars($_GET["mode"]);
$scope = htmlspecialchars($_GET["scope"]);
$sort = htmlspecialchars($_GET["sort"]);
$search_string = htmlspecialchars($_GET["search_string"]);
$lang = htmlspecialchars($_GET["lang"]);

# Default values if calling page with no parameters
if(empty($clantag) && empty($mode))
    {
        $mode = "clan";
        $clantag = "#9V8RQ2PR";
    }

# Give a cookie if the user want to change language
if (empty($lang)){ 
    #Nothing
}
else {
    setcookie("lang", $lang, time()+(60*60*24*30*2), "/", "localhost", 0);
    $_COOKIE["lang"] = $lang;
}

# Give cookie with default language setting
if (empty($_COOKIE["lang"]))
{
    setcookie("lang", $default_language, time()+(60*60*24*30*2), "/", "localhost", 0);
}

# If you create a new language file, please submit it to us using github.
include("lang." . $_COOKIE["lang"] . ".php");

include("html/head.html");
include("html/menu.html");
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
else if ($mode == "search")
    include("search.php");

include("html/tail.html");

?>
