angular.module('MainApp').controller('RegisterController', function ($scope,$http,$document,$uibModal) {
    $scope.gpa = $scope.wantUpdate = 0;
    $scope.intro = $scope.cv_id = $scope.full_name = $scope.birthday = $scope.email = $scope.phone = "";
    $scope.skypeid = $scope.address = $scope.university_name = $scope.faculty_name = $scope.major_name = $scope.academic_year = "";

    $scope.onEdit = function () {
        $scope.show = true;
        $scope.wantUpdate = 1;
        var phoneold=$('#phone').text();
        var skypeidold=$('#skypeid').text();
        var addressold=$('#address').text();

        angular.element('#phone').replaceWith("<input type='text' id='phone' name='phone'/>");
        angular.element('#skypeid').replaceWith('<input type="text" id= "skypeid" name="skypeid"/>');
        angular.element('#address').replaceWith('<input type="text" id= "address" name="address"/>');

        angular.element('#phone').val(phoneold.toString());
        angular.element('#skypeid').val(skypeidold.toString());
        angular.element('#address').val(addressold.toString());
    };

    $scope.onSave = function () {
        $scope.show = false;
        var phonenew = angular.element('#phone').val();
        var skypeidnew = angular.element('#skypeid').val();
        var addressnew = angular.element('#address').val();

        angular.element('#phone').replaceWith("<label id='phone'></label>");
        angular.element('#skypeid').replaceWith('<label id= "skypeid"></label>');
        angular.element('#address').replaceWith('<label id= "address"></label>');

        angular.element('#phone').text(phonenew);
        angular.element('#skypeid').text(skypeidnew);
        angular.element('#address').text(addressnew);

        angular.element('.btnSave').data('clicked', true);
    };

    $scope.onRegister = function (event) {
        event.preventDefault();
        if(document.getElementById("gpa_detail").files.length == 0){
            alert('Bạn chưa upload Bảng điểm chi tiết.');
            return;
        }
        if ($scope.wantUpdate == 1) {
            if (!angular.element('.btnSave').data('clicked')){
                alert('Bạn phải lưu thông tin trước khi đăng ký.');
                return;
            }
            if (!$.isNumeric(angular.element("#phone").text())) {
                alert("Số điện thoại không hợp lệ!");
                return;
            }
            if (angular.element('#address').text().length < 5) {
                alert("Địa chỉ không hợp lệ!");
                return;
            }
        }
        else {
            if (angular.element("#phone").text() == "") {
                alert("Thiếu thông tin: Số điện thoại!");
                return;
            }
            if (angular.element("#skypeid").text() == "") {
                alert("Thiếu thông tin: SkypeID!");
                return;
            }
            if (angular.element('#address').text() == "") {
                alert("Thiếu thông tin: Địa chỉ!");
                return;
            }
        }
        $scope.openModal = function (size, template, controller) {
            var modalInstance = $uibModal.open({
                animation: true,
                templateUrl: template,
                controller: controller,
                size: size,
                scope: $scope
            });
        };
        $scope.openModal('md','confirm-modal.html','ConfirmController');
    };
});

angular.module('MainApp').controller('ConfirmController',function ($scope,$http,$uibModalInstance) {
    $scope.onSureRegist = function () {
        $scope.gpa = angular.element('#gpa').text();
        $scope.phone = angular.element('#phone').text();
        $scope.skypeid = angular.element('#skypeid').text();
        $scope.address = angular.element("#address").text();
        $scope.cv_id = angular.element('.cv_select').val();
        $scope.full_name = angular.element('#full_name').text();
        $scope.birthday = angular.element('#birthday').text();
        $scope.email = angular.element('#email').text();
        $scope.university_name = angular.element('#university_name').text();
        $scope.faculty_name = angular.element('#faculty_name').text();
        $scope.major_name = angular.element('#major_name').text();
        $scope.academic_year = angular.element('#academic_year').text();
        $scope.intro = angular.element('#intro').val();

        $.ajax({
            method: 'POST',
            url: urlSaveFile,
            headers: {'X-CSRF-Token': $('input[name="_token"]').val()},
            processData: false,
            contentType: false,
            data: new FormData(angular.element("#upload_form")[0]),
            success: function (msg) {
                switch(msg){
                    case "1000":
                        $http(request).then(function (result) {
                            if (result.status == 200) {
                                $uibModalInstance.close();
                                switch (result.data) {
                                    case "1000":
                                        BootstrapDialog.show({
                                            title: 'Trạng thái thao tác',
                                            message: 'Đăng ký dự án thành công!',
                                            buttons: [{
                                                label: 'OK',
                                                action: function () {
                                                    window.location.href = project_url;
                                                }
                                            }]
                                        });
                                        break;
                                    case "-1000":
                                        alert("Rất tiếc! Đã có lỗi xảy ra.");
                                        break;
                                    default: break;
                                }
                            } else {
                                alert("Rất tiếc! Đã có lỗi xảy ra.");
                            }
                        });
                        break;
                    case "-1000": alert("Không thể upload CV! Vui lòng kiểm tra lại.");
                        break;
                    default: break;
                }
            }
        });

        var request = {
            method: 'POST',
            url: urlSave,
            data: {
                'intro':$scope.intro,
                'cv_id':$scope.cv_id,
                'full_name':$scope.full_name,
                'birthday':$scope.birthday,
                'address':$scope.address,
                'skypeid':$scope.skypeid,
                'phone':$scope.phone,
                'gpa':$scope.gpa,
                'email':$scope.email,
                'university_name':$scope.university_name,
                'faculty_name':$scope.faculty_name,
                'major_name':$scope.major_name,
                'academic_year':$scope.academic_year,
                'wantUpdate':$scope.wantUpdate
            }
        };
    };

    $scope.onCancel = function () {
        $uibModalInstance.close();
    };
});

