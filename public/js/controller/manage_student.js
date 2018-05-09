angular.module('MainApp').controller('ManageStudentController', function ($scope, $http, $document) {
    $scope.gridOptions1 = {
        paginationPageSizes: [5, 10, 15],
        paginationPageSize: 5,
        enableSorting: true,
        enableHorizontalScrollbar: 0,
        rowHeight: 40,
        columnDefs: [
            {
                displayName: 'Tên CV (Vị trí ứng tuyển)',
                name: 'Sinh viên',
                cellTemplate: '<a href="/user/{{row.entity.student_id}}">{{row.entity.student_name}}</a>',
                width: '*',
                enableHiding: false
            },
            {displayName: 'Upload lúc', field: 'studentprofiles.university_name', width: '*', enableHiding: false},
            {displayName: 'Lượt nhận xét', field: 'studentprofiles.gpa', width: '*', enableHiding: false},
            {
                name: ' ',
                cellTemplate: '<div class="text-center"><form><button ng-click="grid.appScope.detail1(row)" class="btn btn-primary">Chi tiết>></button></form></div>',
                width: '100',
                enableHiding: false,
                enableColumnMenu: false
            }
        ]
    };
    $scope.detail1 = function (row) {
        window.location = '/project-hiring/' + row.entity.id;
    };
    $scope.gridOptions2 = {
        paginationPageSizes: [5, 10, 15],
        paginationPageSize: 5,
        enableSorting: true,
        enableHorizontalScrollbar: 0,
        rowHeight: 40,
        columnDefs: [
            {
                displayName: 'Tên dự án',
                field: 'project.name',
                width: '*',
                enableHiding: false
            },
            {displayName: 'Công ty', field: 'project.companies.name', width: '*', enableHiding: false},
            {displayName: 'Đăng ký lúc', field: 'created_at', width: '*', enableHiding: false},
            {
                displayName: 'Trạng thái',
                name: 'Trạng thái',
                cellTemplate: '<div class="ui-grid-cell-contents" ng-switch="{{row.entity.result}}">' +
                '<label ng-switch-when="11" class="text-success">Xác nhận tham gia</label>' +
                '<label ng-switch-when="13" class="text-danger">Cần cố gắng hơn</label>' +
                '<label ng-switch-when="14" class="text-danger">Đã hủy</label>' +
                '<label ng-switch-default class="text-primary">Đang chờ xét duyệt</label>' +
                '</div>',
                width: '*',
                enableHiding: false
            },
            {
                name: ' ',
                cellTemplate: '<div class="text-center"><form><button ng-click="grid.appScope.detail2(row)" class="btn btn-primary">Chi tiết>></button></form></div>',
                width: '100',
                enableHiding: false,
                enableColumnMenu: false
            }
        ]
    }
    ;
    $scope.detail2 = function (row) {
        window.location = '/projects/' + row.entity.id;
    };
    $document.ready(function () {
        $scope.getCVList();
        $scope.getAppliedList();
    });
    $scope.getAppliedList = function () {
        $http({
            method: 'POST',
            url: '/api/student/applied-list',
            data: {
                '_token': window.Laravel['csrfToken'],
                'student_id': $scope.student_id,
            }
        }).then(function (response) {
            $scope.gridOptions2.data = response.data;
        });
    };
    $scope.getCVList = function () {
        $http({
            method: 'POST',
            url: '/api/student/cv',
            data: {
                '_token': window.Laravel['csrfToken'],
                'student_id': $scope.student_id,
            }
        }).then(function (response) {
            $scope.gridOptions1.data = response.data;
        });
    };
});
