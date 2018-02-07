angular
    .module('ngApp')
    .controller('controller', ['$scope', 'dataFactory', function ($scope, dataFactory) {

        $scope.clanData;
        $scope.membersData;

        fetchClan();
        fetchMembers();
        
        function fetchClan() {
            dataFactory.fetchClan()
                .then(function (response) {
            $scope.clanData = response.data;
            console.log($scope.clanData);
        }, function (error) {
            console.log(error);
        })};

        function fetchMembers() {
            dataFactory.fetchMembers()
                .then(function (response) {
            $scope.membersData = response.data;
            console.log($scope.membersData);
        }, function (error) {
            console.log(error);
        })};
    }]);