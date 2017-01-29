angular.module('app').controller('PersonDetailCtrl', PersonDetail);

function PersonDetail ($scope, $routeParams, $http, Globals, $localStorage){

  // Init
  $scope.$storage = $localStorage;    // init local storage
  $scope.token = $scope.$storage.token;   // get token from storage
  $scope.username = $scope.$storage.username; // get username from storage
  //$scope.statuses = Globals.statuses;   // get all statusses (3 at the moment)
  $scope.buttontext = 'Update';     // set button text on load

  // Get task via API
  $scope.load = function(){
    var data = {timestamp: new Date().getTime(), token: $scope.token, username: $scope.username};
    $http.post(api_root + '/persons/get/' + $routeParams.PersonID, data).success(function(data) {
      $scope.person = data.persons[0];
      //console.log($scope.taskDetail);
    });
  };

  // Update task details via API (all fields)
  $scope.update = function() {
    var data = {
      PersonID: $scope.person.PersonID,
      Name: $scope.person.Name,
      Email: $scope.person.Email,
      Type: $scope.person.Type,
      Username: $scope.person.Username,
      token: $scope.token,
      username: $scope.username};
      // todo, try: http://docs.angularjs.org/api/ng/function/angular.toJson
      $http.post(api_root + '/persons/update', data).success(function (data, status) {
        //console.log(data);
      });
    };

    // Lookup
    $scope.showModal = false;
    $scope.lu_f = ""; // lookup field
    $scope.lu_v = ""; // lookup value
    $scope.lu_d = ""; // lookup display
    $scope.lookup = function(api_controller) {
      var data = {timestamp: new Date().getTime(), token: $scope.token, username: $scope.username  };
      $http.post(api_root + '/' + api_controller + '/get', data).success(function(data) {
          $scope.ld = data[api_controller];
      });
      $scope.showModal = true;
    };
    $scope.closelookup = function() {
      $scope.showModal = false;
    };
    $scope.setVal = function(f,v) {
      $scope.person[f] = v;
    }
    // End lookup

    // Get task on load
    $scope.load();

  }
