angular.module('MainApp').controller('ProjectDetailController', function ($rootScope,$scope, $http, $document,$uibModal) {
    $rootScope.wantDelete = 0;
    $rootScope.wantConfirm = 0;
    $scope.is_guest = true;
    $scope.gridOptions = {
        paginationPageSizes: [5, 10, 15],
        paginationPageSize: 5,
        enableSorting: true,
        enableHorizontalScrollbar: 0,
        columnDefs: [
            {displayName: 'Họ tên', field: 'full_name'},
            {displayName: 'Trường',field:'university_name'}
        ]
    };

    $scope.getAppliedList= function () {
        var request = {
            method: 'POST',
            url: '/api/applied-student-list',
            data: {
                'project_id': $scope.project_id
            }
        };
        $http(request).then(function (response) {
            data = response.data;
            $scope.gridOptions.data = data;
        });
    };

    $document.ready(function () {
        console.log($scope.is_guest);
        if($scope.is_guest == false){
            $scope.getAppliedList();
        }
    });

    $scope.openModal = function (size, template, controller) {
        var modalInstance = $uibModal.open({
            animation: true,
            templateUrl: template,
            controller: controller,
            size: size,
            scope: $scope
        });
    };

    $scope.onNeedConfirm = function (event) {
        event.preventDefault();
        $scope.openModal('md','confirm-modal.html','ConfirmController');
    };

    $scope.onCancel = function (event) {
        event.preventDefault();
        $scope.openModal('md','cancel-modal.html','CancelController');
    };

    $scope.onNominate = function (event) {
        event.preventDefault();
        $scope.openModal('md','nominate-modal.html','NominateController');
    }
});

angular.module('MainApp').controller('ConfirmController', function ($rootScope,$scope, $http, $uibModalInstance) {
    $rootScope.wantConfirm = 1;
    $scope.onConfirm = function () {
        var request = {
            method: 'POST',
            url: urlConfirm,
            data: {
                wantConfirm:$rootScope.wantConfirm,
                _token: token
            }
        };

        $http(request).then(function (result) {
            if (result.status == 200) {
                switch (result.data){
                    case "1000":
                        BootstrapDialog.show({
                            title: 'Trạng thái thao tác',
                            message: 'Xác nhận tham gia dự án hoàn tất!',
                            buttons: [{
                                label: 'OK',
                                action: function () {
                                    window.location.href = project_url;
                                }
                            }]
                        });
                        break;
                    case "-1000":
                        alert("Đã có lỗi xảy ra! Vui lòng kiểm tra lại.");
                        return;
                    case "2000":
                        alert("Không thể cập nhật kết quả! Vui lòng kiểm tra lại.");
                        return;
                    case "2001":
                        alert("Không thể thêm dữ liệu! Vui lòng kiểm tra lại.");
                        return;
                }
                $uibModalInstance.close();
            }
        });
    };
    $scope.cancel = function () {
        $uibModalInstance.close();
    }
});

angular.module('MainApp').controller('CancelController', function ($rootScope,$scope, $http, $uibModalInstance) {
    $rootScope.wantDelete = 1;
    $scope.onConfirm = function () {
        var request = {
            method: 'POST',
            url: urlCancel,
            data: {
                wantDelete:$rootScope.wantDelete,
                _token: token
            }
        };
        $http(request).then(function (result) {
            if (result.status == 200) {
                switch (result.data){
                    case "1000":
                        BootstrapDialog.show({
                            title: 'Trạng thái thao tác',
                            message: 'Hủy tham gia dự án hoàn tất!',
                            buttons: [{
                                label: 'OK',
                                action: function () {
                                    window.location.href = project_url;
                                }
                            }]
                        });
                        break;
                    case "-1000":
                        alert("Đã có lỗi xảy ra! Vui lòng kiểm tra lại.");
                        return;
                    case "2000":
                        alert("Không thể cập nhật kết quả! Vui lòng kiểm tra lại.");
                        return;
                }
                $uibModalInstance.close();
            }
        });
    };
    $scope.cancel = function () {
        $uibModalInstance.close();
    }
});

angular.module('MainApp').controller('NominateController',function ($rootScope,$scope, $http, $uibModalInstance) {

});