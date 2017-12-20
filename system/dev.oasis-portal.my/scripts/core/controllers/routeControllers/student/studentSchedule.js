app.register.controller('studentSchedule', ['$scope', '$http', 'pinesNotifications', '$location', '$routeParams', '$theme', function($scope, $http, pinesNotifications, $location, $routeParams, $theme){

	var base_url = $("meta[name='base_url']").attr('content');
	var a = [];

    $scope.demoEvents = {};
    $scope.demoEvents.demoEvents = [];
    $scope.demoEvents.calendar_id = 1;

    $http({
	method: 'get',
	url: base_url +'/schedule/loadEventsForStudent/'
	}).success(function(data, status, headers, config) {

		console.log(data);
		if(!data['calendar']){
			$('#message').text(data['message']);
			$('#modalMessage').modal('show');
			$("#fullcalendar").fullCalendar(); 
		}else{

			if(data['events'][0]){
				//create a new fullcalendar 

				data['events'][0].forEach(function(event){
					objEvent = {
						title:event.title,
						start:event.start,
						allDay:true
					};

					a.push(objEvent);
				});

				console.log("value for the new a is : ");
				console.log(JSON.stringify(a));
			}

			$("#fullcalendar").fullCalendar({
					events:a
				});



		}
	      

	}).error(function(data, status, headers, config) {
	  console.log('error fetching events');
	}); 

}]);


			//populate the fullcalendar
			// if(data) {

	      //   //$scope.demoEvents.length = 0;
	      //   //$scope.demoEvents = data;
	      //   $scope.demoEvents.calendar_id = 1;

	      //   angular.forEach(data, function(value, key) {

	      //     console.log(value);

	      //     var date = new Date(Date.parse(value.start));
	      //     var d = date.getDate();
	      //     var m = date.getMonth();
	      //     var y = date.getFullYear();
	          
	      //     $scope.demoEvents.demoEvents.push({
	      //       title: value.title,
	      //       start: new Date(y, m, d),
	      //       backgroundColor: value.backgroundColor
	      //     });

	      //   });
	          
	      //   console.log('demoEvents:');
	      //   console.log($scope.demoEvents);
	      // } 