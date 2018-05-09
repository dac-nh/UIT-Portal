/**
 * Created by huyentran on 05/12/2016.
 */
var oldNameElement = cvID2 = cvID = name = "";
var n = 0;
angular.module('MainApp').controller('CVListController', function ($scope, $http,$uibModal) {
    $scope.cv_name_edit = "";
    $scope.openModal = function (size, template, controller) {
        var modalInstance = $uibModal.open({
            animation: true,
            templateUrl: template,
            controller: controller,
            size: size,
            scope: $scope
        });
    };

    $scope.onUpload = function (event) {
        var numOfCV = angular.element('#numOfCV').val();
        if(numOfCV < 5)
            $scope.openModal('md','upload-modal.html','UploadController');
        else
            alert("Chỉ được phép Upload tối đa 5 CV");
    };

    $scope.onEdit = function (event) {
        event.preventDefault();
        oldNameElement =  event.target.parentNode.childNodes[11].childNodes[3].childNodes[1].childNodes[1];
        var oldName = oldNameElement.textContent;
        console.log(oldName);
        $scope.cv_name_edit = oldName;
        cvID2 = event.target.parentNode.childNodes[1];
        cvID2 = cvID2.getAttribute('value');
        $scope.openModal('md','edit-modal.html','EditController');
    };

    $scope.onDelete = function (event) {
        event.preventDefault();
        cvID = event.target.parentNode.childNodes[1];
        cvID = cvID.getAttribute('value');
        $scope.openModal('md','delete-modal.html','DeleteController');
    };
});

angular.module('MainApp').controller('UploadController',function ($scope,$http,$uibModalInstance) {
    $scope.onSureUpload = function () {
        if(document.getElementById("cv_file").files.length == 0){
            alert('Bạn chưa chọn file CV.');
            return;
        }
        name = angular.element('#cv_name').val();
        if(name == null){
            name = "";
        }
        filename = angular.element("#cv_file").val();
        type = filename.split('.');
        type = type[type.length-1];
        n = type.localeCompare('pdf');
        if(n!= 0){
            alert('Định dạng file không hợp lệ.');
            return;
        }
        $.ajax({
            method: 'POST',
            url: saveCV,
            headers: {'X-CSRF-Token': $('input[name="_token"]').val()},
            processData: false,
            contentType: false,
            data: new FormData(angular.element("#upload_form")[0]),
            success: function (msg) {
                switch(msg){
                    case "1000":
                        BootstrapDialog.show({
                            title: 'Trạng thái thao tác',
                            message: 'Bạn đã  đăng tải CV thành công!',
                            buttons: [{
                                label: 'OK',
                                action: function(){
                                    window.location.href = listCV;
                                }
                            }]
                        });
                        break;
                    case "-1000": alert("Không thể upload CV! Vui lòng kiểm tra lại.");
                        break;
                    default: break;
                }
            }
        }).done(function (msg) {
            $uibModalInstance.close();
        });
    };
    $scope.onCancel = function () {
        $uibModalInstance.close();
    };
});

angular.module('MainApp').controller('EditController',function ($scope,$http,$uibModalInstance) {
    $scope.onSureEdit = function () {
        var request = {
            method:'POST',
            url: editCV,
            data:{
                'cvID':cvID2,
                'newName': $scope.cv_name_edit
            }
        };
        $http(request).then(function (result) {
            if(result.status == 200){
                $uibModalInstance.close();
                switch (result.data) {
                    case "1000":
                        window.location.href = listCV;
                        break;
                    case "-1000":
                        alert("Không thể câp nhật CV này! Vui lòng kiểm tra lại.");
                        return;
                    default: break;
                }
            }
        });
    };
    $scope.onCancel = function () {
        $uibModalInstance.close();
    };
});

angular.module('MainApp').controller('DeleteController',function ($scope,$http,$uibModalInstance) {
    $scope.onSureDelete = function () {
        var request = {
            method: 'POST',
            url: deleteCV,
            data: {
                cvID: cvID
            }
        };
        $http(request).then(function (result) {
            if(result.status == 200){
                $uibModalInstance.close();
                switch (result.data) {
                    case "1000":
                        BootstrapDialog.show({
                            title: 'Trạng thái thao tác',
                            message: 'Xóa thành công!',
                            buttons: [{
                                label: 'OK',
                                action: function () {
                                    window.location.href = listCV;
                                }
                            }]
                        });
                        break;
                    case "-1000":
                        alert("Không thể xóa CV này! Vui lòng kiểm tra lại.");
                        return;
                    default:
                        break;
                }
            }
        });
    };
    $scope.onCancel = function () {
        $uibModalInstance.close();
    };
});