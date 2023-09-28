desc players_excluded_from_war;

SELECT tag, name, expires, reason, cwltoo from players_excluded_from_war;

select * 
#delete
from players_excluded_from_war; # where tag = 'testtag3';
#commit;

INSERT INTO players_excluded_from_war (tag, name, expires, reason, cwltoo) VALUES ('#P0GUYGVJC', 'Jarhead', DATE_ADD(now(), INTERVAL 7 DAY), 'Missed war attack', 'N');

#sql to delete expired entries
select * from players_excluded_from_war where expires < now();