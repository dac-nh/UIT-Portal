/**
 * Created by Dark Wolf on 12/02/2016.
 */

/**
 * Event edit user information Controller
 * */
angular.module('MainApp').controller('UserInformation', function ($scope, $http) {
    /*Event when click edit user information*/
    angular.element('#editUserInformation').on('click', function () {
        var name = angular.element('#name').text();
        var gender = angular.element('#genderNum').text();
        var birthday = angular.element('#birthday').text();
        var telNum = angular.element('#telNum').text();
        var addNum = angular.element('#addNum').text();
        var currentUniversity = angular.element('#university').text();
        var academicYear = angular.element('#academicYear').text();
        var faculty = angular.element('#faculty').text();
        var gpa = angular.element('#gpa').text();
        var major = angular.element('#major').text();
        // var email = angular.element('#email').text();

        angular.element('#name').replaceWith('<input type="text" id="name" name="name" class="form-control"/>');
        angular.element('#gender').replaceWith('<select id= "gender" name="gender" class="form-control">' +
            '<option value=0>Nam</option>' +
            '<option value=1>Nữ</option>' +
            '</select>');
        angular.element('#birthday').replaceWith('<input type="date" id="birthday" name="birthday" class="form-control"/>');
        angular.element('#telNum').replaceWith('<input type="text" id= "telNum" name="telNum" class="form-control"/>');
        angular.element('#addNum').replaceWith('<input type="text" id= "addNum" name="addNum" class="form-control"/>');
        angular.element('#university').replaceWith('<select id= "university" name="university" class="form-control"/>');
        angular.element('#academicYear').replaceWith('<select id= "academicYear" name="academicYear" class="form-control"/>');
        angular.element('#faculty').replaceWith('<input type="text" id= "faculty" name="faculty" class="form-control"/>');
        angular.element('#gpa').replaceWith('<input type="text" id= "gpa" name="gpa" class="form-control"/>');
        angular.element('#major').replaceWith('<input type="text" id= "major" name="major" class="form-control"/>');
        // angular.element('#email').replaceWith('<input type="email" id= "email" name="email" class="form-control"/>');

        angular.element('#name').val(name.toString());
        angular.element('#gender').val(gender);
        angular.element('#birthday').val(birthday);
        angular.element('#telNum').val(telNum.toString());
        angular.element('#addNum').val(addNum.toString());
        angular.element('#university').val(currentUniversity.toString());
        angular.element('#faculty').val(faculty.toString());
        angular.element('#gpa').val(gpa.toString());
        angular.element('#major').val(major.toString());
        // angular.element('#email').val(email.toString());

        // Academic year
        var academic_year = angular.element("#academicYear")[0];
        var thisYear = new Date().getFullYear();
        for (var year = 1990; year <= thisYear; year++) {
            var option = document.createElement("option");
            option.text = year;
            option.value = year;
            academic_year.add(option);
        }

        // University
        var university_list = angular.element('#university')[0];
        $http.get('/get-list-universities').then(function (result) {
            switch (result.status) {
                case 200:
                    var data = result.data;
                    data.forEach(function (university) {
                        var option = document.createElement("option");
                        option.text = university.name;
                        option.value = university.id;
                        university_list.add(option);
                        if (option.text == currentUniversity){
                            university_list.value = option.value;
                        }
                    });
                    break;
                default:
                    BootstrapDialog.show({
                        type: BootstrapDialog.TYPE_WARNING,
                        title: 'Có lỗi',
                        message: 'Đã có lỗi phát sinh khi tải danh sách trường đại học. Xin vui lòng tải lại trang hoặc đăng nhập khi khác. Xin cảm ơn!',
                        buttons: [{
                            label: 'OK',
                            cssClass: 'btn-default btn-warning',
                            action: function (dialog) {
                                dialog.close();
                            }
                        }]
                    });
            }
        });
        angular.element('#academicYear').val(academicYear);
        angular.element('#file').show();
        angular.element('#editUserInformation').hide();
        angular.element('#saveUserInformation').show();
    });
    /*Event save new user information*/
    $scope.saveUserInformation = function () {
        var name = angular.element('#name').val();
        var gender = angular.element('#gender').val();
        var birthday = angular.element('#birthday').val();
        var telephone = angular.element('#telNum').val();
        var address = angular.element('#addNum').val();
        var universityName = angular.element('#university')[0].selectedOptions[0].text;
        var universityId = angular.element('#university').val();
        var academicYear = angular.element('#academicYear').val();
        var faculty = angular.element('#faculty').val();
        var gpa = angular.element('#gpa').val();
        var major = angular.element('#major').val();
        // var email = angular.element('#email').val();
        var year = new Date(birthday);
        if (year.getFullYear() >= academicYear) {
            BootstrapDialog.show({
                type: BootstrapDialog.TYPE_WARNING,
                title: 'Kiểm tra lại thông tin',
                message: 'Ngày sinh và khóa học không hợp lý. Xin vui lòng điền lại',
                buttons: [{
                    label: 'OK',
                    cssClass: 'btn-default btn-warning',
                    action: function (dialog) {
                        dialog.close();
                    }
                }]
            });
            return;
        }
        var data = new FormData();
        data.append('file', angular.element('#file')[0].files[0]);
        data.append('name', name);
        data.append('gender', gender);
        data.append('birthday', birthday);
        data.append('phone', telephone);
        data.append('address', address);
        data.append('university_name', universityName);
        data.append('university_id', universityId);
        data.append('academic_year', academicYear);
        data.append('faculty_name', faculty);
        data.append('gpa', gpa);
        data.append('major_name', major);


        var request = {
            method: 'POST',
            url: '/user/profile/' + window.location.href.substr(window.location.href.lastIndexOf('/') + 1) + '/update-profile',
            transformRequest: angular.identity,
            withCredentials: true,
            headers: {'Content-Type': undefined},
            data: data
        };

        $http(request).then(function (result) {
            if (result.status == 200) {
                switch (result.data) {
                    case "1000":
                        BootstrapDialog.show({
                            type: BootstrapDialog.TYPE_SUCCESS,
                            title: 'Thông tin trạng thái',
                            message: 'Bạn đã cập nhât thông tin tài khoản thành công',
                            buttons: [{
                                label: 'OK',
                                cssClass: 'btn-default btn-success',
                                action: function (dialog) {
                                    dialog.close();
                                    location.reload();
                                }
                            }]
                        });
                        break;
                    case 1000:
                        BootstrapDialog.show({
                            type: BootstrapDialog.TYPE_SUCCESS,
                            title: 'Thông tin trạng thái',
                            message: 'Bạn đã cập nhât thông tin tài khoản thành công',
                            buttons: [{
                                label: 'OK',
                                cssClass: 'btn-default btn-success',
                                action: function (dialog) {
                                    dialog.close();
                                    location.reload();
                                }
                            }]
                        });
                        break;
                    default:
                        BootstrapDialog.show({
                            type: BootstrapDialog.TYPE_WARNING,
                            title: 'Thông tin trạng thái',
                            message: 'Bạn đã cập nhât thông tin tài khoản thất bại',
                            buttons: [{
                                label: 'OK',
                                cssClass: 'btn-default btn-warning',
                                action: function (dialog) {
                                    dialog.close();
                                    location.reload();
                                }
                            }]
                        });
                        break;
                }
            } else {
                BootstrapDialog.alert('Không thể cập nhật bây giờ!');
            }
        });
    };

    /**
     * CHANGE AVATAR
     */
    angular.element('#file').on('change', function () {
        var reader = new FileReader();
        reader.onload = function (e) {
            angular.element('#avatar').attr('src', e.target.result);
        };
        reader.readAsDataURL(angular.element('#file')[0].files[0]);
        angular.element('#changeAvatar').show();
    });
});

/**
 * Event edit user introduction Controller
 * */
var student_profile_id = "";
angular.module('MainApp').controller('UserIntroduction', function ($scope, $http) {
    /*Event when click edit user information*/
    angular.element('#editUserIntroduction').on('click', function () {
        var intro = angular.element('#intro').text();
        angular.element('#intro').replaceWith('<textarea rows="4" id="intro" name="intro" class="form-control"/>');
        angular.element('#intro').val(intro);
        angular.element('#editUserIntroduction').hide();
        angular.element('#saveUserIntroduction').show();
    });
    /*Event when click save user information*/
    $scope.saveUserIntroduction = function () {
        var intro = angular.element('#intro').val();

        var request = {
            method: 'POST',
            url: '/user/profile/' + window.location.href.substr(window.location.href.lastIndexOf('/') + 1) + '/update-intro',
            data: {
                'intro': intro,
                '_token': window.Laravel['csrfToken']
            }
        };

        $http(request).then(function (result) {
            if (result.status == 200) {
                switch (result.data) {
                    case "1000":
                        BootstrapDialog.show({
                            type: BootstrapDialog.TYPE_SUCCESS,
                            title: 'Thông tin trạng thái',
                            message: 'Bạn đã cập nhât thông tin tài khoản thành công',
                            buttons: [{
                                label: 'OK',
                                cssClass: 'btn-default btn-success',
                                action: function (dialog) {
                                    dialog.close();
                                    location.reload();
                                }
                            }]
                        });
                        break;
                    case 1000:
                        BootstrapDialog.show({
                            type: BootstrapDialog.TYPE_SUCCESS,
                            title: 'Thông tin trạng thái',
                            message: 'Bạn đã cập nhât thông tin tài khoản thành công',
                            buttons: [{
                                label: 'OK',
                                cssClass: 'btn-default btn-success',
                                action: function (dialog) {
                                    dialog.close();
                                    location.reload();
                                }
                            }]
                        });
                        break;
                    default:
                        BootstrapDialog.show({
                            type: BootstrapDialog.TYPE_WARNING,
                            title: 'Thông tin trạng thái',
                            message: 'Bạn đã cập nhât thông tin tài khoản thất bại',
                            buttons: [{
                                label: 'OK',
                                cssClass: 'btn-default btn-warning',
                                action: function (dialog) {
                                    dialog.close();
                                    location.reload();
                                }
                            }]
                        });
                        break;
                }
            } else {
                BootstrapDialog.alert('Không thể cập nhật bây giờ!');
            }
        });
    };
    $scope.init = function (id) {
        student_profile_id = id;
        console.log(student_profile_id);
    };
    $scope.settingCV = function () {
        window.location.href = '/list-cv/' + student_profile_id;
    };
});

$(document).ready(
    function () {
        angular.element('#file').hide();
        angular.element('#saveUserInformation').hide();
        angular.element('#saveUserIntroduction').hide();
    });