<?php

# Global variables
$site_name = "aktivavikingar.servegame.com";			# Server name in URL

$site_title = "Aktiva Vikingars Statistik"; # The sites title text
$menu_title = "AV Statistik";               # The shorter title for the menu

$install_path = "/srv/www/htdocs/stats/";			# Path to folder where statistics site is installed
$update_path = "/srv/www/htdocs/stats/update/";     		# Path to update scripts folder
$secret_path = "/secret/path/";					# Path outside reach of web server for mysql dredentials and token.
$www_path = "/statistics/";                  			# WWW path to index.php without site name

$follow_clans = "'#9V8RQ2PR', '#80L9VRJR', '#YJJ8UGG2', '#220CLU8G0', '#209QPLUV2', '#PU2CRG2Y', '#LRRPUR88', '#229qjjr9v', '#9GPLVPRU'"; # What clans to follow for statistics. Also need to update shell scripts if used.
# Need to work on the variable above to include it in the scipts.

$days = 60;                                 # Amount of days to show in statistics.
$default_language = "se";                   # Set default language e.g. "se", "en", "de"

?>