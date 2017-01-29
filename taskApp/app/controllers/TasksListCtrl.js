angular.module('app').controller('TasksListCtrl', TaskList);

function TaskList ($scope, $rootScope, $http, Globals, $localStorage, $location, $timeout, editableOptions){

  // Init
  editableOptions.theme = 'bs3'; // bootstrap3 theme. Can be also 'bs2', 'default'
  $scope.$storage = $localStorage;            // init localStorage
  $scope.token = $scope.$storage.token;       // get token from storage
  $scope.username = $scope.$storage.username; // get username from storage
  $scope.showCompletedTasks = true;          // hide completed tasks on load
  $scope.statuses = Globals.statuses;         // get all statusses (3 at the moment)
  $scope.orderProp = "created_at";            // sort on created_at on load
  $scope.task = "";                           // init textbox task

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
    $http.post(api_root + '/tasks/get', data).success(function(data) {
        $scope.tasks = data.tasks;
    });
  };

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

  // Add task via API
  $scope.addTask = function() {
    if($scope.task.length > 0){
      var data = { task: $scope.task,
             status: "1",
             created_by: "NA",
             created_at: "NA",
             assigned_to: "NA",
             due_date: "NA",
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

  // Update task status via API
  $scope.updateCell = function(taskId, field, value) {

    var data = {};
    data['taskId'] = taskId;
    data[field] = value;
    data['token'] = $scope.token;
    data['username'] = $scope.username;

    // var data = { taskId: taskId, assigned_to: assigned_to, status: status, token: $scope.token, username: $scope.username };

    $http.post(api_root + '/tasks/update', data).success(function (data, status) {
      $scope.loadData();
    });

  };

  // On load check access and load data
  $scope.loadData();


}
