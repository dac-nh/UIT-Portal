angular.module('MainApp').controller('ManageProjectsHiringController', function ($rootScope, $scope, $http, $document, $uibModal) {
    $rootScope.check_confirm = false;
    $scope.num_of_joined = 0;
    $scope.num_of_applied = 0;
    $scope.isOpen1 = true;
    $scope.isOpen2 = true;
    $scope.isOpen3 = true;
    $scope.gridOptions2 = {
        paginationPageSizes: [5, 10, 15],
        paginationPageSize: 5,
        enableSorting: true,
        enableHorizontalScrollbar: 0,
        rowHeight: 40,
        columnDefs: [
            {
                displayName: 'Sinh viên',
                name: 'Sinh viên',
                cellTemplate: '<a href="/user/{{row.entity.student_id}}">{{row.entity.student_name}}</a>',
                width: '*',
                enableHiding: false
            },
            {displayName: 'Trường', field: 'studentprofiles.university_name', width: '*', enableHiding: false},
            {displayName: 'GPA', field: 'studentprofiles.gpa', width: '*', enableHiding: false},
            {displayName: 'Phone', field: 'studentprofiles.phone', width: '*', enableHiding: false},
            {
                displayName: 'Đã đăng ký lúc',
                field: 'created_at',
                width: '*',
                enableHiding: false,
            },
            {
                displayName: 'Xác nhận',
                name: 'Xác nhận',
                cellTemplate: '<i class="fa fa-check-circle fa-icon-button" aria-hidden="true" ng-click="grid.appScope.onConfirm(row)" style="color:green;cursor:pointer;"></i>' +
                '<i class="fa fa-times-circle fa-icon-button" aria-hidden="true" ng-click="grid.appScope.onReject(row)" style="color:red;cursor:pointer;"></i>',
                width: '*',
                enableHiding: false,
                enableColumnMenu: false
            }
        ]
    };
    $scope.gridOptions3 = {
        paginationPageSizes: [5, 10, 15],
        paginationPageSize: 5,
        enableSorting: true,
        enableHorizontalScrollbar: 0,
        rowHeight: 40,
        columnDefs: [
            {
                displayName: 'Sinh viên',
                name: 'Sinh viên',
                cellTemplate: '<a href="/user/{{row.entity.student_id}}">{{row.entity.student_name}}</a>',
                width: '*',
                enableHiding: false
            },
            {displayName: 'Trường', field: 'studentprofiles.university_name', width: '*', enableHiding: false},
            {displayName: 'GPA', field: 'studentprofiles.gpa', width: '*', enableHiding: false},
            {displayName: 'Phone', field: 'studentprofiles.phone', width: '*', enableHiding: false},
            {
                displayName: 'Đã đăng ký lúc',
                field: 'created_at',
                width: '*',
                enableHiding: false,
            },
            {
                displayName: 'Trạng thái',
                name: 'Trạng thái',
                cellTemplate: '<span ng-switch="{{row.entity.result}}">' +
                '<span tooltip-placement="right" uib-tooltip="Đang chờ xác nhận" ng-switch-when="11" class="fa  fa-clock-o fa-icon-button" aria-hidden="true" style="color:dodgerblue"></span>' +
                '<span tooltip-placement="right" uib-tooltip="Đã từ chối" ng-switch-when="13" class="fa  fa-times-circle fa-icon-button" aria-hidden="true" style="color:red"></span>' +
                '<span tooltip-placement="right" uib-tooltip="Sinh viên đã hủy" ng-switch-when="14" class="fa fa-exclamation-triangle fa-icon-button" aria-hidden="true" style="color:red"></span>' +
                '<span tooltip-placement="right" uib-tooltip="Sinh viên đã xác nhận" ng-switch-default class="fa fa-check-circle fa-icon-button" aria-hidden="true" style="color:green"></span>' +
                '</span>',
                width: '*',
                enableHiding: false,
                enableColumnMenu: false
            }
        ]
    };
    $scope.openModal = function (size, template, controller) {
        var modalInstance = $uibModal.open({
            animation: true,
            ariaLabelledBy: 'modal-title',
            ariaDescribedBy: 'modal-body',
            templateUrl: template,
            controller: controller,
            size: size,
            scope: $scope,
        });

        modalInstance.result.then(function (selectedItem) {
            $scope.getDataSet2();
            $scope.getDataSet3();
            if ($rootScope.check_confirm == true) {
                $scope.num_of_joined += 1;
                $rootScope.check_confirm = false;
            }
        }, function () {

        });
    };

    $scope.onReject = function (row) {
        $scope.apply_id = row.entity.id;
        $scope.student_name = row.entity.student_name;
        $scope.openModal('sm', 'ConfirmRejectModal.html', 'RejectModalController');
    };
    $scope.onConfirm = function (row) {
        $scope.apply_id = row.entity.id;
        $scope.student_name = row.entity.student_name;
        $scope.openModal('sm', 'ConfirmJoinModal.html', 'ConfirmModalController');
    };
    $document.ready(function () {
        $scope.getDataSet2();
        $scope.getDataSet3();
        $scope.isOpen2 = false;
        $scope.isOpen3 = false;
    });
    $scope.getDataSet1 = function () {
        $http({
            method: 'POST',
            url: '/api/applied-list-hiring-projects',
            data: {
                '_token': window.Laravel['csrfToken'],
                'project_id': $scope.project_id,
                'status': 1,
            }
        }).then(function (response) {
            $scope.gridOptions1.data = response.data;
        });
    };
    $scope.getDataSet2 = function () {
        $http({
            method: 'POST',
            url: '/api/applied-list-hiring-projects',
            data: {
                '_token': window.Laravel['csrfToken'],
                'project_id': $scope.project_id,
                'status': 2,
            }
        }).then(function (response) {
            $scope.gridOptions2.data = response.data;
        });
    };
    $scope.getDataSet3 = function () {
        $http({
            method: 'POST',
            url: '/api/applied-list-hiring-projects',
            data: {
                '_token': window.Laravel['csrfToken'],
                'project_id': $scope.project_id,
                'status': 3,
            }
        }).then(function (response) {
            $scope.gridOptions3.data = response.data;
        });
    }
});
angular.module('MainApp').controller('RejectModalController', function ($scope, $http, $uibModalInstance) {
    $scope.ok = function () {
        $http({
            method: 'POST',
            url: '/api/reject-apply',
            data: {
                '_token': window.Laravel['csrfToken'],
                'apply_id': $scope.apply_id,
                'email_content': $scope.email_content
            }
        }).then(function (response) {
        });
        $uibModalInstance.close();
    };

    $scope.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };
});
angular.module('MainApp').controller('ConfirmModalController', function ($rootScope, $scope, $http, $uibModalInstance) {
    $scope.ok = function () {
        $http({
            method: 'POST',
            url: '/api/confirm-join',
            data: {
                '_token': window.Laravel['csrfToken'],
                'apply_id': $scope.apply_id,
                'email_content': $scope.email_content
            }
        }).then(function (response) {
            $rootScope.check_confirm = true;
            $uibModalInstance.close();
        });
    };

    $scope.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };
});