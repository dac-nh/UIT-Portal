angular.module('MainApp').controller('AppliedStudentListController', function ($scope, $http, uiGridConstants) {
    $scope.company_id = $scope.result = $scope.university_id = "";
    $scope.api_token = "";
    $scope.student_name = $scope.from_date = $scope.to_date = "";
    $scope.data = [];
    $scope.gridOptions = {
        paginationPageSizes: [25, 50, 75],
        paginationPageSize: 25,
        enableSorting: true,
        enableHorizontalScrollbar: 0,
        rowHeight: 40,
        columnDefs: [
            {displayName: 'Sinh viên', field: 'student_name', width: '*', enableHiding: false},
            {displayName: 'Dự án', field: 'project.name', width: '*', enableHiding: false},
            {
                displayName: 'Công ty',
                field: 'project.companies.name',
                width: '*',
                enableHiding: false,
            },
            {displayName: 'Đăng ký vào', field: 'created_at', width: '*', enableHiding: false},
            {displayName: 'Trạng thái', field: 'result', width: '*', enableHiding: false},
            {
                name: ' ',
                cellTemplate: '<div class="text-center"><form><button ng-click="grid.appScope.detail(row)" class="btn btn-primary">Chi tiết>></button></form></div>',
                width: '*',
                enableHiding: false,
                enableColumnMenu: false
            }
        ]
    };
    $scope.detail = function (row) {
        window.location = '/user/' + row.entity.student_id;
    };
    $scope.resultOptions = [
        {
            'id': 0,
            'name': 'Đang chờ'
        },
        {
            'id': 1,
            'name': 'Đậu'
        },
        {
            'id': 2,
            'name': 'Rớt'
        },
    ];
    $http.get('/api/companies').then(function (response) {
        $scope.companyOptions = response.data;
    });
    $http.get('/api/universities').then(function (response) {
        $scope.universityOptions = response.data;
    });

    $scope.onClear = function () {
        $scope.company_id = $scope.result = $scope.student_name = $scope.university_id = "";
        $scope.from_date = $scope.to_date = "";
    };
    $scope.onSearch = function () {
        var request = {
            method: 'POST',
            url: '/api/applied-students',
            data: {
                '_token': window.Laravel['csrfToken'],
                'company_id': $scope.company_id,
                'result': $scope.result,
                'student_name': $scope.student_name,
                'from_date': $scope.from_date,
                'to_date': $scope.to_date,
            }
        };
        $http(request).then(function (response) {
            data = response.data;
            $scope.data = data;
            for (i = 0; i < data.length; i++) {
                switch (data[i].result) {
                    case 0:
                        data[i].result = 'Đang chờ';
                        break;
                    case 1:
                        data[i].result = "Đậu";
                        break;
                    case 2:
                        data[i].result = "Rớt";
                        break;
                }
            }
            $scope.gridOptions.data = data;
        });
    };
    $scope.onSearch();
    $scope.onExportCSV = function () {
        var request = {
            method: 'POST',
            url: '/export/applied-students',
            data: {
                'company_id': $scope.company_id,
                'result': $scope.result,
                'student_name': $scope.student_name,
                'from_date': $scope.from_date,
                'to_date': $scope.to_date
            }
        };
        $http(request).success(function (response) {
            window.open(response.data, '_blank', '');
        });
    };
    $scope.popup1 = {
        opened: false
    };
    $scope.open1 = function () {
        $scope.popup1.opened = true;
    };
    $scope.popup2 = {
        opened: false
    };
    $scope.open2 = function () {
        $scope.popup2.opened = true;
    };
});