angular.module('MainApp').controller('CreateProjectController', function ($scope, $rootScope, $http, $document, $compile) {
    $scope.popup = {
        opened: false
    };
    $scope.open = function () {
        $scope.popup.opened = true;
    };
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
    $document.ready(function () {
        $http.get('/api/companies').then(function (response) {
            $scope.companyOptions = response.data;
        });
        $http.get('/api/skills').then(function (response) {
            $scope.skillOptions = response.data;
        });
        $scope.company_id = "";
    });

    $scope.selected_skill = "";
    $scope.selected_skill_list = [];
    $scope.onAddSkill = function () {
        if ($scope.selected_skill != "") {
            $scope.selected_skill_list.push($scope.selected_skill);
            for (var i = 0; i < $scope.skillOptions.length; i++) {
                if ($scope.skillOptions[i].id == $scope.selected_skill.id) {
                    $scope.skillOptions.splice(i, 1);
                    break;
                }
            }
        }
        $scope.selected_skill = "";
    };
    $scope.onRemoveSkill = function (index) {
        for (var i = 0; i < $scope.skillOptions.length; i++) {
            if ($scope.skillOptions[i].id > $scope.selected_skill_list[index].id) {
                $scope.skillOptions.splice(i, 0, $scope.selected_skill_list[index]);
                break;
            }
        }
        $scope.selected_skill_list.splice(index, 1);
    };
    $scope.project_name = $scope.company = $scope.address = $scope.start_date =
        $scope.number_of_week = $scope.work_type = $scope.contact_email = $scope.plus_point =
            $scope.requirement = $scope.intro = $scope.need_min = $scope.need_max = "";
    $scope.validateFields = function () {
        var validation_check = true;
        if ($scope.project_name == "") {
            $scope.project_name_field = "required-field";
            validation_check = false;
        } else {
            $scope.project_name_field = "";
        }
        if ($scope.company == "") {
            $scope.company_field = "required-field";
            validation_check = false;
        } else {
            $scope.company_field = "";
        }
        if ($scope.address == "") {
            $scope.address_field = "required-field";
            validation_check = false;
        } else {
            $scope.address_field = "";
        }
        if ($scope.start_date == "") {
            $scope.start_date_field = "required-field";
            validation_check = false;
        } else {
            $scope.start_date_field = "";
        }
        if ($scope.number_of_week == "") {
            $scope.num_of_week_field = "required-field";
            validation_check = false;
        } else {
            $scope.num_of_week_field = "";
        }
        if ($scope.work_type == "") {
            $scope.work_type_field = "required-field";
            validation_check = false;
        } else {
            $scope.work_type_field = "";
        }
        if ($scope.need_min == "") {
            $scope.need_min_field = "required-field";
            validation_check = false;
        } else {
            $scope.need_min_field = "";
        }
        if ($scope.need_max == "") {
            $scope.need_max_field = "required-field";
            validation_check = false;
        } else {
            $scope.need_max_field = "";
        }
        if ($scope.intro == "") {
            $scope.intro_field = "required-field";
            validation_check = false;
        } else {
            $scope.intro_field = "";
        }
        if ($scope.requirement == "") {
            $scope.requirement_field = "required-field";
            validation_check = false;
        } else {
            $scope.requirement_field = "";
        }
        if ($scope.plus_point == "") {
            $scope.plus_point_field = "required-field";
            validation_check = false;
        } else {
            $scope.plus_point_field = "";
        }
        if ($scope.contact_email == "") {
            $scope.contact_email_field = "required-field";
            validation_check = false;
        } else {
            $scope.contact_email_field = "";
        }
        return validation_check;
    };
    $scope.onCreateProjectClick = function () {
        var check = $scope.validateFields();
        var dateEpoch = new Date($scope.start_date).valueOf() / 1000;
        var data = {
            '_token': window.Laravel['csrfToken'],
            'name': $scope.project_name,
            'company_id': $scope.company.id,
            'status': window.Laravel['CONST_PROJECT_NEW'],
            'is_fulltime': $scope.work_type.id,
            'address': $scope.address,
            'length': $scope.number_of_week,
            'need_min': $scope.need_min,
            'need_max': $scope.need_max,
            'start_date': dateEpoch,
            'intro': $scope.intro,
            'requirement': $scope.requirement,
            'plus_point': $scope.plus_point,
            'extra_file': $scope.extra_file,
            'created_by_agent_id': window.Laravel['current_user_id'],
            'contact_email': $scope.contact_email,
            'skill': $scope.selected_skill_list,
        };
        var request = {
            method: 'POST',
            url: '/api/create/project',
            data: data
        };
        // $http(request).then(function (response) {
        // });
    }
});