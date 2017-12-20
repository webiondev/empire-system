app.register.controller('courseEnrolledStudent', ['$scope', '$http', '$routeParams', 'pinesNotifications', '$location', function($scope, $http, $routeParams, pinesNotifications, $location){

  	var base_url = $("meta[name='base_url']").attr('content');
  	var course_id = ($routeParams.course_id || "");

	  if($scope.course_id != "") {
	      
	      $http({
	      method: 'get',
	      url: base_url + '/course/getStudent/'+course_id
	      }).success(function(data, status, headers, config) {
	      
	        $scope.students = data;
	        
	      
	      }).error(function(data, status){
	        console.log("ERROR: " + status);
	      });
	  }


	$scope.modal = function(key,id,name){
		$scope.delStudent = id;
		$scope.delKey = key;
		$("#mdlMessage").html("Are you sure you want to remove "+name);
	};

	$scope.removeStudent = function(){
		
		// var token = $("meta[name='_token']").attr('content');

		// $data = {
		// 	user_id:$scope.delStudent,
		// 	course_id:course_id,
		// 	_token:token
		// }

		$http({
		method: 'get',
		url:base_url + '/course/removeStudent/'+course_id+'/'+$scope.delStudent
		}).success(function(data,status,headers,config){
			$scope.students.splice($scope.delKey,1);
			$('#mdRmvStudent').modal('hide');
		}).error(function(data,status){
			console.log("ERROR: "+status);
		});

	};
}]);