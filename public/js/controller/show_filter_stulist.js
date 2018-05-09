$('#button_filter').on('click',function (event) {
    event.preventDefault();
    $('#filterSL').slideToggle('slow');
});

angular.module('MainApp').controller('StudentListController', function ($scope, $http) {
    $scope.name=""; $scope.university_name="";$scope.rating_from =""; $scope.rating_to  ="";
    $scope.user_id="";
    $scope.gridOptions = {
        paginationPageSizes: [15, 50, 100],
        paginationPageSize: 15,
        enableSorting: true,
        rowHeight:70,
        columnDefs: [
            {displayName: 'Rating', field: 'rating',width: 200,cellTemplate: '<div class="ui-grid-cell-contents" style="padding-top: 15px;">{{grid.getCellValue(row, col)}} <span class="glyphicon glyphicon-star" aria-hidden="true" style="color: burlywood"></span></div>'},
            {displayName: 'Sinh viên',width: 550,field:'full_name',cellTemplate: '<div class="row" style="padding-top: 10px;">' +
                                                                            '<div class="col-md-4" style="text-align: center">'+
                                                                                '<img src="{{row.entity.avatar}}" width="50" height="50" class="companyimg"/>'+
                                                                            '</div>'+
                                                                            '<div class="col-md-8" style="text-align: left;padding-top: 15px;">'+
                                                                                '<a href="/user/{{row.entity.id}}">{{row.entity.full_name}} </a>'+
                                                                            '</div>'+
                                                                        '</div>'},
            {displayName: 'Khoa - Trường',field:'Khoa_Truong', cellTemplate: '<div class="ui-grid-cell-contents" >{{row.entity.university_name}} <br> {{row.entity.faculty_name}} </div>'}
        ]
    };

    $http.get('/api/universities').then(function (response) {
        $scope.universityOptions = response.data;
    });

    $scope.onSearch = function () {
        var request = {
            method: 'POST',
            url: '/list-student',
            data: {
                'name': $scope.name,
                'university_name':$scope.university_name.name,
                'rating_from':$scope.rating_from,
                'rating_to':$scope.rating_to
            }
        };
        $http(request).then(function (response) {
            data = response.data;
            $scope.gridOptions.data = data;
        });
    };
    $scope.onSearch();

    $scope.onSearchMe = function () {
        var request = {
            method: 'POST',
            url: '/list-student',
            data: {
                'user_id':$scope.user_id
            }
        };
        $http(request).then(function (response) {
            data = response.data;
            $scope.gridOptions.data = data;
        });
    };

    $scope.clear = function () {
        $scope.name=""; $scope.university_name=-1;$scope.rating_from =""; $scope.rating_to  ="";
        $scope.onSearch();
    };
});