angular.module('MainApp').controller('UploadImageController', function ($scope, $http) {
    $scope.imageSrc = '../../../storage/user/avatar/1.png';
    $scope.setFile = function (element) {
        $scope.currentFile = element.files[0];
        var reader = new FileReader();

        reader.onload = function (event) {
            $scope.imageSrc = event.target.result;
            $scope.$apply();
        };
        // when the file is read it triggers the onload event above.
        reader.readAsDataURL(element.files[0]);
    }
});
