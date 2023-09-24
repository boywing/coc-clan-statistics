desc players_excluded_from_war;

SELECT tag, name, expires, reason, cwltoo from players_excluded_from_war;

#select * 
delete
from players_excluded_from_war where tag = 'testtag3';
commit;

INSERT INTO players_excluded_from_war (tag, name, expires, reason, cwltoo) VALUES ('#29VRV2JGL', 'Witchmuzen', null, 'Poor attacks', 'N');