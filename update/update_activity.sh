#!/bin/bash

clans=('#9V8RQ2PR' '#80L9VRJR' '#YJJ8UGG2' '#220CLU8G0' '#209QPLUV2' '#PU2CRG2Y' '#LRRPUR88' '#229qjjr9v' '#9GPLVPRU' '#2LGRUG8YP' '#2Q0UPCCJ2')

DIR="/path/to/scripts" # path to scripts
cd $DIR

for clan in "${clans[@]}"
do
    "$DIR"/update_activity.php clanid="$clan"
done
