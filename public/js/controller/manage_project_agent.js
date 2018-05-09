angular.module('MainApp').controller('ManageProjectAgentController', function ($scope, $http, uiGridConstants, $document) {
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

    $scope.popup = {
        opened: false
    };
    $scope.open = function () {
        $scope.popup.opened = true;
    };

    $scope.gridOptions = {
        paginationPageSizes: [25, 50, 75],
        paginationPageSize: 25,
        enableSorting: true,
        enableHorizontalScrollbar: 0,
        rowHeight: 70,
        columnDefs: [
            {displayName: 'ID', field: 'id', width: '50', enableHiding: false},
            {
                displayName: 'Công ty',
                name: 'Công ty',
                cellTemplate: '<div><img src="storage/company/logo/{{row.entity.company_id}}.png" width="50px" height="50px" style="margin: 10px;"></div>',
                width: '100',
                enableHiding: false
            },
            {
                name: 'Tên dự án',
                field: 'name',
                width: '*',
                enableHiding: false
            },
            {
                displayName: 'Loại', field: 'is_fulltime', width: '100', enableHiding: false
            },
            {
                displayName: 'Thời gian', field: 'length', width: '100', enableHiding: false
            },
            {
                displayName: 'Ngày bắt đầu', field: 'start_date', width: '150', enableHiding: false
            },
            {
                displayName: 'Đã đăng ký', field: 'num_of_applied', width: '120', enableHiding: false
            },
            {
                name: ' ',
                cellTemplate: '<div style="line-height: 70px"><form><button ng-click="grid.appScope.detail2(row)" class="btn btn-primary">Chi tiết>></button></form></div>',
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
                $scope.gridOptions.data = data;
        });
    };
});