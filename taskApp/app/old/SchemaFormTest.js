angular.module('app').controller('SchemaFormTest', SchemaFormTest);

function SchemaFormTest ($scope, $routeParams, $rootScope, $http, Globals, $localStorage, $location, $timeout){

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


  $http.get("formschemas/testschema.json").
              success(function(data, status) {
                $scope.schema = data;
              }).
              error(function(data, status) {
                console.log(data || "Request failed");
            });


  $http.get("formschemas/testform.json").
              success(function(data, status) {
                $scope.form = data;
              }).
              error(function(data, status) {
                console.log(data || "Request failed");
            });

  $scope.model = {};


  // Get ...
  /*
  $scope.loadData = function(){
    var data = {timestamp: new Date().getTime(), token: $scope.token, username: $scope.username  };
    $http.post(api_root + '/liteman/pragma/' + $routeParams.table, data).success(function(data) {
        var obj = JSON.parse(data);
        $scope.columns = Object.keys(obj[0]);
        $scope.rows = obj;
    });
  };


  // On load check access and load data
  $scope.loadData();
  */

}
