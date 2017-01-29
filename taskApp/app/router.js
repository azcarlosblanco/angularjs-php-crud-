/* router */

//app.config(['$routeProvider',
angular.module('app').config(['$routeProvider',
  function($routeProvider) {
    $routeProvider.
    when('/tasks', {
      templateUrl: 'views/tasks-list.html',
      controller: 'TasksListCtrl'
    }).
    when('/tasks/:taskId', {
      templateUrl: 'views/tasks-detail.html',
      controller: 'TaskDetailCtrl'
    }).
    when('/liteman/tables', {
      templateUrl: 'views/liteman-tables.html',
      controller: 'LiteManTablesCtrl'
    }).
    when('/liteman/columns/:table', {
      templateUrl: 'views/liteman-columns.html',
      controller: 'LiteManColumnsCtrl'
    }).
    when('/liteman/records/:table', {
      templateUrl: 'views/liteman-records.html',
      controller: 'LiteManRecordsCtrl'
    }).
    when('/StandardForm/:table/:key/:id', {
      templateUrl: 'views/standard-form.html',
      controller: 'StandardFormCtrl'
    }).
    when('/persons', {
      templateUrl: 'views/persons-list.html',
      controller: 'PersonsListCtrl'
    }).
    when('/persons/:PersonID', {
      templateUrl: 'views/persons-detail.html',
      controller: 'PersonDetailCtrl'
    }).
    when('/Login', {
      templateUrl: 'views/login.html',
      controller: 'LoginCtrl'
    }).
    when('/Logout', {
      templateUrl: 'views/login.html',
      controller: 'LogoutCtrl'
    }).
    otherwise({
      redirectTo: '/tasks'
    });
  }]
);
