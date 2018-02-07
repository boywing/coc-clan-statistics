var app = angular.module('app');

app.controller("appCtrl", function ($scope, $http, $q) {
});

app.controller("webinfoCtrl", function ($scope, $http) {
    $http.get("http://192.168.1.32/clash_of_clans/coc-clan-statistics/json/get_clan.php?clanid=%239V8RQ2PR")
        .then(function (response) {
            $scope.data = response.data;
            console.log($scope.data);
        });
});

