#!/bin/bash

clans=('#9V8RQ2PR' '#80L9VRJR' '#YJJ8UGG2' '#220CLU8G0' '#209QPLUV2')

DIR="/path/to/scripts" # path to scripts
cd $DIR

for clan in "${clans[@]}"
do
    "$DIR"/update_war.php clanid="$clan"
done
