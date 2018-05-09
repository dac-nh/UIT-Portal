angular.module('MainApp').controller('ManageCompanyController', function ($scope, $http, $document) {
    $scope.onClick = function () {
        console.log($scope.company_id);
    };
    $scope.isOpen1 = $scope.isOpen2 = $scope.isOpen3 = true;
    $scope.api_token = "";
    $scope.gridOptions1 = {
        enableSorting: true,
        enableHorizontalScrollbar: 0,
        rowHeight: 40,
        columnDefs: [
            {displayName: 'ID', field: 'id', width: '*', enableHiding: false},
            {displayName: 'Tên dự án', field: 'name', width: '*', enableHiding: false},
            {
                displayName: 'Thời gian bắt đầu',
                field: 'start_date',
                width: '*',
                enableHiding: false,
            },
            {displayName: 'Số lượng đăng ký', field: 'num_of_applied', width: '*', enableHiding: false},
            {
                name: ' ',
                cellTemplate: '<div class="text-center"><form><button ng-click="grid.appScope.detail1(row)" class="btn btn-primary">Chi tiết>></button></form></div>',
                width: '*',
                enableHiding: false,
                enableColumnMenu: false
            }
        ]
    };
    $scope.gridOptions2 = {
        enableSorting: true,
        enableHorizontalScrollbar: 0,
        rowHeight: 40,
        columnDefs: [
            {displayName: 'ID', field: 'id', width: '*', enableHiding: false},
            {displayName: 'Tên dự án', field: 'name', width: '*', enableHiding: false},
            {
                displayName: 'Thời gian bắt đầu',
                field: 'start_date',
                width: '*',
                enableHiding: false,
            },
            {displayName: 'Số lượng sinh viên', field: 'num_of_joined', width: '*', enableHiding: false},
            {
                name: ' ',
                cellTemplate: '<div class="text-center"><form><button ng-click="grid.appScope.detail2(row)" class="btn btn-primary">Chi tiết>></button></form></div>',
                width: '*',
                enableHiding: false,
                enableColumnMenu: false
            }
        ]
    };
    $scope.gridOptions3 = {
        enableSorting: true,
        enableHorizontalScrollbar: 0,
        rowHeight: 40,
        columnDefs: [
            {displayName: 'ID', field: 'id', width: '*', enableHiding: false},
            {displayName: 'Tên dự án', field: 'name', width: '*', enableHiding: false},
            {
                displayName: 'Thời gian bắt đầu',
                field: 'start_date',
                width: '*',
                enableHiding: false,
            },
            {
                displayName: 'Thời gian kết thúc',
                field: 'start_date',
                width: '*',
                enableHiding: false,
            },
            {displayName: 'Số lượng sinh viên', field: 'num_of_joined', width: '*', enableHiding: false},
            {
                name: ' ',
                cellTemplate: '<div class="text-center"><form><button ng-click="grid.appScope.detail3(row)" class="btn btn-primary">Chi tiết>></button></form></div>',
                width: '*',
                enableHiding: false,
                enableColumnMenu: false
            }
        ]
    };
    $scope.detail1 = function (row) {
        window.location = '/project-hiring/' + row.entity.id;
    };
    $scope.detail2 = function (row) {
        window.location = '/project-in-progress/' + row.entity.id;
    };
    $scope.detail3 = function (row) {
        window.location = '/project-finished/' + row.entity.id;
    };
    $document.ready(function () {
        $http({
            method: 'POST',
            url: '/api/hiring-projects',
            data: {
                '_token': window.Laravel['csrfToken'],
                'company_id': $scope.company_id,
            }
        }).then(function (response) {
            $scope.gridOptions1.data = response.data;
        });
        $http({
            method: 'POST',
            url: '/api/in-progress-projects',
            data: {
                '_token': window.Laravel['csrfToken'],
            }
        }).then(function (response) {
            $scope.gridOptions2.data = response.data;
        });
        $http({
            method: 'POST',
            url: '/api/finished-projects',
            data: {
                '_token': window.Laravel['csrfToken'],
            }
        }).then(function (response) {
            $scope.gridOptions3.data = response.data;
        });
        $scope.isOpen2 = $scope.isOpen3 = false;
    });
});