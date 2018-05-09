/**
 * Created by Dark Wolf on 12/09/2016.
 */
angular.module('MainApp').controller('GoogleLoginController', function ($scope, $http) {
    $scope.googleLogin = function () {
        auth2.grantOfflineAccess({'/google-sign-in': 'postmessage'}).then(signInCallback);
    };
    function signInCallback(authResult) {
        if (authResult['code']) {
            // Send the code to the server
            var request = {
                'code': authResult['code'],
                '_token': window.Laravel['csrfToken']
            };
            $http.post('/google-sign-in', request).then(function (result) {
                if (result.status == 200) {
                    var status = result.data.status;
                    switch (status) {
                        case 1000: {
                            window.location = '/';
                            break;
                        }
                        case -1000: {
                            auth2.signOut();
                            alert('Your account has been deactivated');
                            break;
                        }
                        case 999: {
                            alert('Your account has been logged in');
                            break;
                        }
                    }
                } else {
                    alert('Không thể sử dụng tài khoản Google tại thời điểm này');
                }
            });
        } else {
            // There was an error.
            alert('Không thể sử dụng tài khoản Google tại thời điểm này');
        }
    }

    setTimeout(function () {
        auth2.signOut();
    }, 3000);
});