#select * from
update
war_roster_log 
set opponenttag = '#9LJ0YUCU', opponentname = 'Balkan knights'
where opponenttag='WarSearch';

select * from war_roster_log; # where tag='#2JGJLGLVQ';

select * from attacks order by startTime desc;
select * from clans where tag = '#RQVCPLLG'; # عشاق الحروب
select min(select distinct datecreated from war_roster_log); # order by datecreated desc;
select max(datecreated) from war_roster_log;

select * from players_excluded_from_war;
select * from war_roster_log where warpreference = 'in' and inwar = 'out';

#gets players left out of last war who were opted in, unless they are still on the excluded list
select name, tag from war_roster_log
where warpreference = 'in'
and inwar = 'out'
and tag not in (select tag from players_excluded_from_war);

select * from players_included_in_war;