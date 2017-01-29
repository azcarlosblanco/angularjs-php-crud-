angular.module('app').controller('LiteManRecordsCtrl', LiteManRecordsCtrl);

function LiteManRecordsCtrl ($scope, $routeParams, $rootScope, $http, Globals, $localStorage, $location, $timeout){

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

  // load data
  $scope.loadData = function(){
    var data = {timestamp: new Date().getTime(), token: $scope.token, username: $scope.username  };
    $http.post(api_root + '/liteman/records/' + $routeParams.table, data).success(function(data) {
        var obj = JSON.parse(data);
        $scope.columns = Object.keys(obj[0]);
        $scope.rows = obj;
    });
  };

  // get primary key
  $scope.getPK = function(){
    var data = {timestamp: new Date().getTime(), token: $scope.token, username: $scope.username  };
    $http.post(api_root + '/liteman/pk/' + $routeParams.table, data).success(function(data) {
        console.log(data);
        $scope.pk = data;
    });
  };

  // delete record
  $scope.delete = function(id) {
    var data = {timestamp: new Date().getTime(), table: $routeParams.table, pk: $scope.pk, key: id, token: $scope.token, username: $scope.username };
    if(confirm('Delete record?','Please confirm')){
        $http.post(api_root + '/liteman/delete', data).success(function (data, status){
        $scope.loadData();
        return false;
      });
    }
  };

  // go
  $scope.table = $routeParams.table;
  $scope.loadData();
  $scope.getPK();

}
