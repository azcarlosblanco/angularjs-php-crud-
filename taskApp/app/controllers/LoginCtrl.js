// Login/logoff controller (../partials/login.html)
//app.controller('LoginCtrl', function ($scope, $rootScope, $http, $localStorage, $location){

angular.module('app').controller('LoginCtrl', Login);

function Login ($scope, $rootScope, $http, $localStorage, $location){

  // Init
  $scope.$storage = $localStorage;     // Init localStorage
  $scope.$storage.token = "";          // Clear token (login also logoff)
  $rootScope.LogoutOrLogin = 'Login';  // Change button text to 'Login'

  // Login
  $scope.login = function(){

    var data = {username: $scope.username, password: $scope.password};

    $http.post(api_root + '/token/get', data).success(function(data) {

      $scope.$storage.token = data.token;       // put token in storage
      $scope.$storage.username = data.username; // put username in storage

      // If token, then login OK
      if($scope.$storage.token){
        $rootScope.LogoutOrLogin = 'Logout';  // change button text to 'Logoff'
        $location.path('#/tasks');            // redirect to tasks
      }

    });

  };

}
