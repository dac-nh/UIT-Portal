/**
 * Created by huyentran on 29/11/2016.
 */
angular.module('MainApp').controller('CompanyListController', function ($scope, $http) {
    $scope.name="";
    $scope.gridOptions = {
        paginationPageSizes: [10, 15, 25],
        paginationPageSize: 10,
        enableSorting: true,
        rowHeight:70,
        columnDefs: [
            {displayName: 'Rating', field: 'rating', width: 200, cellTemplate: '<div class="ui-grid-cell-contents" style="padding-top: 15px;" >{{grid.getCellValue(row, col)}} <span class="glyphicon glyphicon-star" aria-hidden="true" style="color: burlywood"></span></div>'},
            {displayName: 'Doanh nghiệp',field:'name',  width: 400, cellTemplate: '<div class="row" style="padding-top: 10px;">' +
            '<div class="col-md-3" style="text-align: center">'+
            '<img src="{{row.entity.avatar}}" width="50" height="50" class="companyimg"/>'+
            '</div>'+
            '<div class="col-md-9" style="text-align: left;padding-top: 15px;">'+
            '<a href="">{{row.entity.name}} </a>'+
            '</div>'+
            '</div>'},
            {displayName: 'Địa chỉ',field:'address', cellTemplate: '<div style="text-align: left; padding-top: 20px;padding-left: 5px;">{{row.entity.address}}</div>'}
        ]
    };

    $scope.onSearch = function () {
        var request = {
            method: 'POST',
            url: '/list-company',
            data: {
                'name': $scope.name
            }
        };
        $http(request).then(function (response) {
            data = response.data;
            $scope.gridOptions.data = data;
        });
    };
    $scope.onSearch();
});