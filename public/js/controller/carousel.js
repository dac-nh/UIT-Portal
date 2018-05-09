angular.module('MainApp').controller('CarouselController', function ($scope, $http) {
    $scope.myInterval = 5000;
    $scope.noWrapSlides = false;
    $scope.active = 0;
    $scope.slides = [
        {
            'text': 'acb',
            'id': '1',
            'image': '/storage/banner/banner1.jpg'
        },
        {
            'text': 'acb',
            'id': '2',
            'image': '/storage/banner/banner2.jpg'
        },
        {
            'text': 'acb',
            'id': '3',
            'image': '/storage/banner/banner3.jpg'
        }
    ];
});