angular.module('app').controller('StandardFormCtrl', StandardFormCtrl);

function StandardFormCtrl ($scope, $routeParams, $rootScope, $http, Globals, $localStorage, $location, $timeout){

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

  $scope.loadSchema = function(){
    var data = {timestamp: new Date().getTime(), token: $scope.token, username: $scope.username};
    $http.post(api_root + '/schemaform/schema/' + $routeParams.table, data).success(function(data) {
      $scope.schema = data;
    });
  };

  $scope.loadForm = function(){
    var data = {timestamp: new Date().getTime(), token: $scope.token, username: $scope.username};
    $http.post(api_root + '/schemaform/form/' + $routeParams.table, data).success(function(data) {
      $scope.form = data;
    });
  };

  $scope.loadData = function(){
    var data = {timestamp: new Date().getTime(), token: $scope.token, username: $scope.username, table:$routeParams.table, key:$routeParams.key, id:$routeParams.id};
    $http.post(api_root + '/schemaform/data', data).success(function(data) {
      $scope.model = data[0];
    });
  };

  $scope.onSubmit = function(model) {

    model.timestamp = new Date().getTime();
    model.token = $scope.token;
    model.username = $scope.username;
    model.table = $routeParams.table;
    model.key = $routeParams.key;
    model.id = $routeParams.id;

    $http.post(api_root + '/liteman/update', model).success(function(data) {
    });

  }

  $scope.table = $routeParams.table;
  $scope.key = $routeParams.key;
  $scope.id = $routeParams.id;
  $scope.loadSchema();
  $scope.loadForm();
  $scope.loadData();

}
