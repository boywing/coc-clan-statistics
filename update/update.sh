#!/bin/bash

clans=('#9V8RQ2PR' '#80L9VRJR' '#YJJ8UGG2' '#220CLU8G0' '#209QPLUV2' '#PU2CRG2Y' '#LRRPUR88' '#229qjjr9v' '#9GPLVPRU')

DIR="/path/to/scripts" # path to scripts
cd $DIR

for clan in "${clans[@]}"
do
    "$DIR"/update_clan.php clanid="$clan"
    "$DIR"/update_members.php clantag="$clan"
done
