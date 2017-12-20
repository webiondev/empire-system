app.register.controller('viewCourse',['$scope', '$http', '$routeParams', 'pinesNotifications', '$location', function($scope, $http, $routeParams, pinesNotifications, $location){

    $scope.course_id = ($routeParams.course_id || "");

    $scope.moduleHolder = {};
    $scope.moduleHolder.moduleId = [];
    $scope.isValid = function(object) {
      return (object !== undefined && object.length > 0);
    };

    var course_id = $scope.course_id;
    var base_url = $("meta[name='base_url']").attr('content');

    if($scope.course_id != "") {
      
      $http({
      method: 'get',
      url: base_url + '/course/getdetails/' + course_id
      }).success(function(data, status, headers, config) {
      
        $scope.course = data;
      
      }).error(function(data, status){

      });

      $http({
      method: 'get',
      url: base_url + '/course/getmodules/' + course_id
      }).success(function(data, status, headers, config) {
      
        $scope.modules = data;
      
      }).error(function(data, status){

      });
      
    }


   $scope.delBtn2 = function(moduleId,courseId,moduleCode,moduleName,courseName){
      $scope.moduleHolder.moduleId[0] = moduleId;
      $scope.moduleHolder.courseId = courseId;
      // console.log(JSON.stringify($scope.moduleHolder));
      $('#modalMessage').html('Confirm delete module '+moduleCode+' '+moduleName+' from '+courseName );

      console.log("delete button clicked");
   };

   $scope.removeModule = function(){

    var base_url = $("meta[name='base_url']").attr('content');
      $data = {
        course_id : $scope.moduleHolder.courseId,
        module_id : $scope.moduleHolder.moduleId
      };

      console.log(JSON.stringify($data));

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

                $("#mod_"+$scope.moduleHolder.moduleId[0]).attr("class","hide");
                $('#modalDelete').modal('hide')
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

}]);