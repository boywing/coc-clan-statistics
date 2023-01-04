#!/bin/bash

clans=('#9V8RQ2PR' '#80L9VRJR' '#YJJ8UGG2' '#220CLU8G0' '#209QPLUV2' '#9GPLVPRU' '#2LGRUG8YP' '#2Q0UPCCJ2')

DIR="/var/www/html/aktivavikingar/update" # path to scripts
cd $DIR

for clan in "${clans[@]}"
do
    "$DIR"/update_raids.php clanid="$clan"
done
