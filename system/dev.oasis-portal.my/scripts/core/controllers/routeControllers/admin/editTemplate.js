app.register.controller('editTemplateController', ['$scope', '$http', 'pinesNotifications', '$location', '$routeParams', '$theme', '$timeout', '$rootScope', function($scope, $http, pinesNotifications, $location, $routeParams, $theme, $timeout, $rootScope){

  var base_url = $("meta[name='base_url']").attr('content');
  $scope.events = [];
  // $scope.events = "";
  $scope.credentials = {};
  $scope.credentials.events = [];

  $http({
  method: 'get',
  url: base_url + '/schedule/getTemplatesList',
  }).
  success(function(data, status, headers, config) {

      $scope.credentials.templates = data;
  }).
  error(function(data, status, headers, config) {

      $('#error').html('code: ' + status + ' the modules already assigned for the following course.');
      $('#alert').fadeIn(1000).removeClass('hide');
  });  

  $scope.onTemplateChange = function()
  {
    
    $scope.credentials.events.slice(0, $scope.credentials.events.length);
    $scope.credentials.calendar_id = $scope.credentials.template;

    $http({
    method: 'get',
    url: base_url + '/schedule/loadEventsFor/' + $scope.credentials.template,
    }).
    success(function(data, status, headers, config) {
        
        $scope.credentials.calendar_id = $scope.credentials.template;
        $scope.credentials.events = data;
        $scope.recreateCalendar();
    }).
    error(function(data, status, headers, config) {

        $('#error').html('code: ' + status + ' the modules already assigned for the following course.');
        $('#alert').fadeIn(1000).removeClass('hide');
    });

  };

  //[NOTE : ] quick fix
  $scope.recreateCalendar = function(){
    console.log("should refresh calendar");
    $("#fullcalendar").empty();
    $("#fullcalendar").fullCalendar({
      events:$scope.credentials.events,
      droppable:true,
      removeDroppedEvent:true,
      calendar_id:$scope.credentials.calendar_id,
      drop:function(date){
        //create http request and refresh the page
        $data = {
          title:$scope.newEvent,
          calendar_id:$scope.credentials.template,
          date:date
        };
        $http({
          method:'post',
          url:base_url+'/admin/addSchedule',
          data:$data
        }).success(function(data,status,headers,config){
          // alert(date);
          console.log(JSON.stringify(data));
          location.reload();
        }).error(function(data, status, headers, config){
          alert("error");
          location.reload();
        });
      }
    });

   
  };

    $scope.addEvent = function() {

        console.log('add event');
        // $scope.events = $scope.newEvent;

        //[NOTE : ] keep this 
        $scope.events.push({
          title: $scope.newEvent,
          calendar_id: $scope.credentials.template
        });
    };

}]);