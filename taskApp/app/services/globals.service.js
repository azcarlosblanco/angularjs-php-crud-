'use strict';

/* Services */

//app.factory('Globals', function() {
angular.module('app').factory('Globals', function() {
  return {
    statuses : [
    {value:'1', label:'Open'},
    {value:'2', label:'Pending'},
    {value:'3', label:'Completed'}
    ]
  };
});
