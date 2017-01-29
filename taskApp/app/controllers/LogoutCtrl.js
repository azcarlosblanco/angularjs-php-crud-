angular.module('app').controller('LogoutCtrl', Logout);

function Logout ($scope, $rootScope, $http, $localStorage, $location){

  // Init
  $scope.$storage = $localStorage;     // Init localStorage

  // Get current username + token
  var data = {username: $scope.$storage.username, token: $scope.$storage.token};

  // Destroy session
  $http.post(api_root + '/token/destroy', data).success(function(data) {
      $scope.$storage.username = "";
      $scope.$storage.token = "";
      $localStorage.removeItem('token');
      $localStorage.removeItem('username');
      $rootScope.LogoutOrLogin = 'Login';  // change button text to 'Logoff'
  });

}
