angular.module('app').controller('LiteManColumnsCtrl', LiteManColumnsCtrl);

function LiteManColumnsCtrl ($scope, $routeParams, $rootScope, $http, Globals, $localStorage, $location, $timeout){

  // Init
  $scope.$storage = $localStorage;            // init localStorage
  $scope.token = $scope.$storage.token;       // get token from storage
  $scope.username = $scope.$storage.username; // get username from storage

  // Check if token available
  if($scope.token){
     $rootScope.LogoutOrLogin = 'Logout';  // change button text to 'Logoff'
  } else {
     $location.path('/login');             // redirect to login page
  }

  // Get ...
  $scope.loadData = function(){
    var data = {timestamp: new Date().getTime(), token: $scope.token, username: $scope.username  };
    $http.post(api_root + '/liteman/pragma/' + $routeParams.table, data).success(function(data) {

        var obj = JSON.parse(data);

        $scope.columns = Object.keys(obj[0]);

        $scope.rows = obj;

        //console.log(Object.keys(obj[0]));

        /*
        console.log(obj[0]);
        for (var k in obj[0]){
          console.log(k);
        }
        */

    });
  };


  // On load check access and load data
  $scope.loadData();

}
