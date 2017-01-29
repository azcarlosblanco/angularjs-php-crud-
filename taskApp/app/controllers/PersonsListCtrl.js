angular.module('app').controller('PersonsListCtrl', PersonsListCtrl);

function PersonsListCtrl ($scope, $rootScope, $http, Globals, $localStorage, $location, $timeout, editableOptions){

  // Init
  editableOptions.theme = 'bs3'; // bootstrap3 theme. Can be also 'bs2', 'default'
  $scope.$storage = $localStorage;            // init localStorage
  $scope.token = $scope.$storage.token;       // get token from storage
  $scope.username = $scope.$storage.username; // get username from storage
  $scope.orderProp = "PersonID";            // sort on load
  $scope.Name = "";                           // init textbox

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
    $http.post(api_root + '/persons/get', data).success(function(data) {
        $scope.persons = data.persons;
    });
  };

  // Add task via API
  $scope.addPerson = function() {
    if($scope.username.length > 0){
      var data = {
             Name: $scope.Name,
             Email: "name@domainxyz.com",
             Type: "User",
             token: $scope.token,
             username: $scope.username};
             $http.post(api_root + '/persons/put', data).success(function (data, status) {
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
  $scope.delete = function(PersonID) {
    var data = { PersonID: PersonID, token:$scope.token, username:$scope.username };
    if(confirm('Delete person ' + PersonID + '?','Please confirm')){
      $http.post(api_root + '/persons/delete', data).success(function (data, status){
        $scope.loadData();
      });
       }
   };

  // On load check access and load data
  $scope.loadData();


}
