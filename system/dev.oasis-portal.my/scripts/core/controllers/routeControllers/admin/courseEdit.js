app.register.controller('courseEdit', ['$scope', '$http', 'pinesNotifications', '$location', '$routeParams', '$route', '$modal', 'SessionService', function($scope, $http, pinesNotifications, $location, $routeParams, $route, $modal, SessionService){

  var base_url = $("meta[name='base_url']").attr('content');
  $scope.course_id = ($routeParams.course_id || "");

  $scope.credentials = {};
  $scope.deleteModule = [];

   $scope.submit = function(){
    	if($scope.deleteModule.length > 0){
   			this.removeModule();
   		}

   		   	this.updateCourses();
    };

   $scope.delBtn = function(id){
   		$('#'+id).attr('class','hide');
   		$scope.deleteModule.push(id);
   };

   $scope.removeModule = function(){

   		var base_url = $("meta[name='base_url']").attr('content');
   		$data = {
   			course_id : $scope.editForm.courseId.$viewValue,
   			module_id : $scope.deleteModule
   		};

   		$http({
		  method: 'post',
		  url: base_url + '/module/removeFromCourses',
		  data: $data
		  }).
   		success(function(data, status, headers, config){
   			if(data['success']) {
                
                pinesNotifications.notify({
                
                  title: 'Success',
                  text: 'Modules removed from courses',
                  type: 'success',
                  hide: true
                }); 

              } else {

                pinesNotifications.notify({
                
                  title: 'Error',
                  text: data['errors'],
                  type: 'error',
                  hide: true
                });

              } 
   		}).
   		error(function(data, status, headers, config){
   			console.log("failed to remove module from courses");
   		});
   };

   $scope.updateCourses = function(){

   		var base_url = $("meta[name='base_url']").attr('content');
   		$data = {
   			course_id : $scope.editForm.courseId.$viewValue,
   			course_name : $scope.editForm.courseName.$viewValue,
   			course_description : $scope.editForm.courseDesc.$viewValue
   		};

   		$http({
		  method: 'post',
		  url: base_url + '/course/update',
		  data: $data
		  }).
   		success(function(data, status, headers, config){
   			if(data['success']) {
                
                pinesNotifications.notify({
                
                  title: 'Success',
                  text: 'Courses Updated',
                  type: 'success',
                  hide: true
                }); 

              } else {

                pinesNotifications.notify({
                
                  title: 'Error',
                  text: data['errors'],
                  type: 'error',
                  hide: true
                });

              }

           	window.location.href = "/#/manage-courses/"; 
   		}).
   		error(function(data, status, headers, config){
   			console.log("failed to update courses");
   		});

   };

}]);