app.register.controller('courseSyllabus', ['$scope', '$http', 'pinesNotifications', '$location', function($scope, $http, pinesNotifications, $location) {
    $titles = [];
    $scope.credentials = {};
    $scope.credentials.subjects = {};

    $courseId = []; //temp array for rearrange
    $courseTitle = [];
    $courseContent = [];

    var base_url = $("meta[name='base_url']").attr('content');

    $http({
      method: 'get',
      url: base_url + '/student/getSyllabus'
      }).success(function(data, status, headers, config) {
        
        console.log(JSON.stringify(data));
        $scope.arrange(data);
        $scope.dataObj();
        
      
      }).error(function(data, status){
        console.log("ERROR: " + status);
      });

    $scope.cut = function(value, wordwise, max, tail) {
        if (!value) return '';

        max = parseInt(max, 10);
        if (!max) return value;
        if (value.length <= max) return value;

        value = value.substr(0, max);
        if (wordwise) {
            var lastspace = value.lastIndexOf(' ');
            if (lastspace != -1) {
                value = value.substr(0, lastspace);
            }
        }

        return value + (tail || ' …');
    };

    $scope.arrange = function(data){
        for (var i = 0; i < data.length; i++) {
            $check = $.inArray(data[i].courseId,$courseId); //jquery return -1 if not in array else return index
            if($check == -1){
                var size = $courseId.length;
                $courseId.push(data[i].courseId);
                $courseTitle.push(data[i].courseName);

                $courseContent[size] = []
                $courseContent[size].push(data[i]);

            }else{
                $courseContent[$check].push(data[i]);
            }
        }
    };

   console.log($courseContent);

   
   $scope.dataObj = function(){
    
        for (var i = 0; i < $courseId.length; i++) {
            var tempArray = [];
            for (var k = 0; k < $courseContent.length; k++) {
                
                for(var m = 0; m < $courseContent[k].length; m++){

                   if($courseContent[k][m].courseId == $courseId[i]){
                        moduleObj = {
                            title:$scope.cut($courseContent[k][m].moduleName, true, 60, "..."),
                            titleBarInfo:'',
                            text:$courseContent[k][m].moduleCode,
                            color:'success',
                            classes:'fa fa-folder-open-o',
                            href:'#/module/detail/'+$courseContent[k][m].moduleID
                        }

                        tempArray.push(moduleObj);
                    }
                }            
            }

            $scope.credentials.subjects[$courseTitle[i]] = tempArray
        }
    
   };
  

    $scope.credentials.shortcutTiles = [{
        text: '1. Staff and Student Copyright Acknowledgement Form',
        titleBarInfo: '',
        color: 'danger',
        classes: 'fa fa-file-text-o',
        href: '#/acknowledgement-form'
    }, {
        text: '2. Statement and Confirmation of Own Work',
        titleBarInfo: '',
        color: 'danger',
        classes: 'fa fa-file-text-o',
        href: '#/statement-and-confirmation'
    }, {
        text: '3. Academic Dishonesty and Plagiarism Policy ',
        titleBarInfo: '',
        color: 'danger',
        classes: 'fa fa-file-text-o',
        href: '#/plagiarism-policy'
    }, {
        text: '4. Special Circumstances Form',
        titleBarInfo: '',
        color: 'info',
        classes: 'fa fa-file-text-o',
        href: '#/special-circumstances-form'
    }, {
        text: '5. Assignment Front Cover Sheet',
        titleBarInfo: '',
        color: 'info',
        classes: 'fa fa-file-text-o',
        href: '#/assignment-front-cover-sheet'
    }, {
        text: '6. Student Feedback Form',
        titleBarInfo: '',
        color: 'info',
        classes: 'fa fa-file-text-o',
        href: '#/student-feedback-form'
    }, {
        text: '7. NEC Student Complaints Procedure',
        titleBarInfo: '',
        color: 'success',
        classes: 'fa fa-file-text-o',
        href: '#/complaints-procedure'
    }, {
        text: '8. A Guide to Harward Referencing',
        titleBarInfo: '',
        color: 'success',
        classes: 'fa fa-file-text-o',
        href: '#/harward-referencing'
    }, {
        text: '9. Assessment Criteria',
        titleBarInfo: '',
        color: 'indigo',
        classes: 'fa fa-file-text-o',
        href: '#/assessment-criteria'
    }];

}]);
