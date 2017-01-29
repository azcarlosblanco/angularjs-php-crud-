angular.module('app').controller('[REPLACE_CONTROLLERNAME]', [REPLACE_CONTROLLERNAME]);

function [REPLACE_CONTROLLERNAME] ($scope, $rootScope, $http, Globals, $localStorage, $location, $timeout, editableOptions){

  // Init
  editableOptions.theme = 'bs3'; // bootstrap3 theme. Can be also 'bs2', 'default'
  $scope.$storage = $localStorage;            // init localStorage
  $scope.token = $scope.$storage.token;       // get token from storage
  $scope.username = $scope.$storage.username; // get username from storage
  $scope.orderProp = "[REPLACE_SORT_ON_LOAD]";            // sort on load

  $scope.[REPLACE_INPUT_FIELD] = "";                           // init textbox task

  // Set table height
  $scope.tableheight = window.innerHeight - 300;

   // Check if token available
  if($scope.token){
     $rootScope.LogoutOrLogin = 'Logout';  // change button text to 'Logoff'
  } else {
     $location.path('/Login');             // redirect to login page
  }

  // Get tasks from API
  $scope.loadData = function(){
    var data = {timestamp: new Date().getTime(), token: $scope.token, username: $scope.username  };
    $http.post(api_root + '/[REPLACE_API_CONTROLLER]/get', data).success(function(data) {
        $scope.tasks = data.tasks;
    });
  };

  /*
  // Filter completed tasks (used for ng-repeat)
  $scope.filterCompleted = function(task){
    if($scope.showCompletedTasks === false){
      if(task.status < 3) {
              return true;
          } else {
             return false;
         }
     } else {
         return true;
     }
 };
 */

  // Add task via API
  $scope.addTask = function() {
    if($scope.[REPLACE_INPUT_FIELD].length > 0){
      var data = {
             [REPLACE_FIELDS_AND_DEFAULTS],
             token: $scope.token,
             username: $scope.username};
             $http.post(api_root + '/tasks/put', data).success(function (data, status) {
               $scope.loadData();
           }).success(function(){
               $scope.buttontext = 'Saved';
               $scope.buttonclass = 'btn btn-success';
               $scope.taskinputclass = '';
           });
       } else {
         $scope.buttontext = 'Add';
         $scope.buttonclass = 'btn btn-primary';
         $scope.taskinputclass = 'alert-danger';
     }
 };

  /*
  // Delete task via API
  $scope.deleteTask = function(taskId) {
    var data = { taskId: taskId, token:$scope.token };
    if(confirm('Delete task ' + taskId + '?','Please confirm')){
      $http.post(api_root + '/tasks/delete', data).success(function (data, status){
        $scope.loadData();
      });
       }
   };

  // Update task status via API
  $scope.updateTask = function(taskId, task, status) {
    var data = { taskId: taskId, task: task, status: status, token: $scope.token, username: $scope.username };
    $http.post(api_root + '/tasks/update', data).success(function (data, status) {
      $scope.loadData();
    });
  };
  */

  // On load check access and load data
  $scope.loadData();


}
