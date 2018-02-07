angular
    .module('ngApp')
    .factory('dataFactory', [ '$http', function ($http) {

        var dataFactory= {};

        dataFactory.fetchClan = function() {
            data = $http.get("http://192.168.1.32/clash_of_clans/coc-clan-statistics/json/get_clan.php?clantag=%239V8RQ2PR");
            return data;
        };

        dataFactory.fetchMembers = function() {
            data = $http.get("http://192.168.1.32/clash_of_clans/coc-clan-statistics/json/get_members.php?clantag=%239V8RQ2PR");
            return data;
        
    };
    return dataFactory;

    }]);