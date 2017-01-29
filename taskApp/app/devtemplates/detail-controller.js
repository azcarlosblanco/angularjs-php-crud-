angular.module('app').controller('TaskDetailCtrl', TaskDetail);

function TaskDetail ($scope, $routeParams, $http, Globals, $localStorage){

  // Init
  $scope.$storage = $localStorage;    // init local storage
  $scope.token = $scope.$storage.token;   // get token from storage
  $scope.username = $scope.$storage.username; // get username from storage
  $scope.statuses = Globals.statuses;   // get all statusses (3 at the moment)
  $scope.buttontext = 'Update';     // set button text on load

  // Get task via API
  $scope.loadTask = function(){
    var data = {timestamp: new Date().getTime(), token: $scope.token, username: $scope.username};
    $http.post(api_root + '/tasks/get/' + $routeParams.taskId, data).success(function(data) {
      $scope.taskDetail = data.tasks[0];
      //console.log($scope.taskDetail);
    });
  };

  // Update task details via API (all fields)
  $scope.updateTask = function() {
    var data = { taskId: $scope.taskDetail.taskId,
          created_by: $scope.taskDetail.created_by,
          created_at: $scope.taskDetail.created_at,
          assigned_to: $scope.taskDetail.assigned_to,
          due_date: $scope.taskDetail.due_date,
          task: $scope.taskDetail.task,
          status: $scope.taskDetail.status,
          token: $scope.token,
          username: $scope.username};
    // todo, try: http://docs.angularjs.org/api/ng/function/angular.toJson
    $http.post(api_root + '/tasks/update', data).success(function (data, status) {
      //console.log(data);
    });
  };

  // Get task on load
  $scope.loadTask();

}
