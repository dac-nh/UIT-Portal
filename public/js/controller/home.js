angular.module('MainApp').controller('HomeController', function ($scope, $http) {
    $scope.onNewProjectClick = function (id) {
        window.location = 'projects/' + id;
    }
});
