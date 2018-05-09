angular.module('MainApp').controller('HiringProjectsListController', function ($scope, $http, uiGridConstants, $document) {
    $scope.isCollapsed = true;
    $scope.project_name = $scope.length_id = $scope.type_id = $scope.from_date = "";
    $scope.typeOptions = [
        {
            'id': 0,
            'name': 'Parttime'
        },
        {
            'id': 1,
            'name': 'Fulltime'
        }
    ];
    $scope.lengthOptions = [
        {
            'id': 0,
            'name': 'Dưới 3 tháng'
        },
        {
            'id': 1,
            'name': '3 đến 6 tháng'
        },
        {
            'id': 2,
            'name': 'Trên 6 tháng'
        }
    ];
    $scope.onClear = function () {
        $scope.project_name = $scope.length_id = $scope.type_id = $scope.from_date = "";
        if ($scope.viewpoint == 2) {
            $scope.company_id = "";
        }
        $scope.onSearch();
    };
    $document.ready(function () {
        if ($scope.viewpoint == 2) {
            $http.get('/api/companies').then(function (response) {
                $scope.companyOptions = response.data;
            });
            $scope.company_id = "";
        }
        $scope.onSearch();
    });


    $scope.gridOptions1 = {
        paginationPageSizes: [25, 50, 75],
        paginationPageSize: 25,
        enableSorting: true,
        enableHorizontalScrollbar: 0,
        rowHeight: 40,
        columnDefs: [
            {displayName: 'ID', field: 'id', width: '*', enableHiding: false},
            {displayName: 'Tên dự án', field: 'name', width: '*', enableHiding: false},
            {displayName: 'Loại', field: 'is_fulltime', width: '*', enableHiding: false},
            {displayName: 'Thời gian làm việc', field: 'length', width: '*', enableHiding: false},
            {displayName: 'Ngày bắt đầu', field: 'start_date', width: '*', enableHiding: false},
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
    $scope.detail1 = function (row) {
        window.location = '/project-hiring/' + row.entity.id;
    };
    $scope.popup = {
        opened: false
    };
    $scope.open = function () {
        $scope.popup.opened = true;
    };

    $scope.gridOptions2 = {
        paginationPageSizes: [25, 50, 75],
        paginationPageSize: 25,
        enableSorting: true,
        enableHorizontalScrollbar: 0,
        rowHeight: 100,
        columnDefs: [
            {displayName: 'ID', field: 'id', width: '100', enableHiding: false},
            {
                displayName: 'Công ty',
                name: 'Công ty',
                cellTemplate: '<div class="text-center"><img src="storage/company/logo/{{row.entity.company_id}}.png" width="50px" height="50px" style="margin: 25px;"></div>',
                width: '100',
                enableHiding: false
            },
            {
                name: 'Tên dự án',
                cellTemplate: '<div class="white-space: pre;"><h4>{{row.entity.name}}</h4><div style="font-size: 12px; height:50px;overflow: hidden;text-overflow: ellipsis;"></div></div>',
                width: '*',
                enableHiding: false
            }
            ,
            {
                displayName: 'Loại', field: 'is_fulltime', width: '100', enableHiding: false
            }
            ,
            {
                displayName: 'Thời gian', field: 'length', width: '120', enableHiding: false
            }
            ,
            {
                displayName: 'Ngày bắt đầu', field: 'start_date', width: '150', enableHiding: false
            }
            ,
            {
                displayName: 'Đã đăng ký', field: 'num_of_applied', width: '120', enableHiding: false
            }
            ,
            {
                name: ' ',
                cellTemplate: '<div class="text-center"><form><button ng-click="grid.appScope.detail2(row)" class="btn btn-primary">Chi tiết>></button></form></div>',
                width: '100',
                enableHiding: false,
                enableColumnMenu: false
            }
        ]
    };
    $scope.detail2 = function (row) {
        window.location = '/projects/' + row.entity.id;
    };
    $scope.onSearch = function () {
        var request = {
            method: 'POST',
            url: '/api/hiring-projects',
            data: {
                '_token': window.Laravel['csrfToken'],
                'company_id': $scope.company_id,
                'project_name': $scope.project_name,
                'type_id': $scope.type_id,
                'length_id': $scope.length_id.id,
                'from_date': $scope.from_date
            }
        };
        $http(request).then(function (response) {
            data = response.data;
            for (i = 0; i < data.length; i++) {
                switch (data[i].is_fulltime) {
                    case 0:
                        data[i].is_fulltime = 'Parttime';
                        break;
                    case 1:
                        data[i].is_fulltime = "Fulltime";
                        break;
                }
                var date = new Date(data[i].start_date);
                data[i].start_date = date.customFormat("#DD#/#MM#/#YYYY# #hh#:#mm#:#ss#");

                data[i].length = data[i].length + " tuần";
            }
            if ($scope.viewpoint == 1) {
                $scope.gridOptions1.data = data;
            } else {
                $scope.gridOptions2.data = data;
            }
        });
    };
});
