<?php

session_start();

// https://developer.okta.com/blog/2018/07/09/five-minute-php-app-auth

// If there is a username, they are logged in, and we'll show the logged-in view
if(isset($_SESSION['username'])) {
  echo '<p>Logged in as</p>';
  echo '<p>' . $_SESSION['username'] . '</p>';
  echo '<p><a href="/?logout">Log Out</a></p>';
  die();
}

// If there is no username, they are logged out, so show them the login link
if(!isset($_SESSION['username'])) {
  $authorize_url = 'TODO';
  echo '<p>Not logged in</p>';
  echo '<p><a href="'.$authorize_url.'">Log In</a></p>';
}

include "../config.php";


# Parameters sent to the form
if (isset($_GET["clantag"]))
	$clantag = htmlspecialchars($_GET["clantag"]);
if (isset($_GET["playertag"]))
	$playertag = htmlspecialchars($_GET["playertag"]);
if (isset($_GET["mode"]))
	$mode = htmlspecialchars($_GET["mode"]);
if (isset($_GET["scope"]))
	$scope = htmlspecialchars($_GET["scope"]);
if (isset($_GET["sort"]))
	$sort = htmlspecialchars($_GET["sort"]);
if (isset($_GET["search_string"]))
	$search_string = htmlspecialchars($_GET["search_string"]);
if (isset($_GET["lang"]))
	$lang = htmlspecialchars($_GET["lang"]);

# Default values if calling page with no parameters
if(empty($clantag) && empty($mode))
    {
        $mode = "clan";
        $clantag = "#80j0jrlp";
    }

# Give a cookie if the user want to change language
if (empty($lang)){ 
	$lang = 'en';
    #Nothing
}
else {
    setcookie("lang", $lang, time()+(60*60*24*30*2), "/", "localhost", 0);
    $_COOKIE["lang"] = $lang;
}

# Give cookie with default language setting
if (!isset($_COOKIE["lang"]))
{
    setcookie("lang", $default_language, time()+(60*60*24*30*2), "/", "localhost", 0);
}

# If you create a new language file, please submit it to us using github.

# adding this in case a browser refuses cookies - default lang is en
if (!isset($_COOKIE["lang"]))
	include("lang.en.php");
else
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
