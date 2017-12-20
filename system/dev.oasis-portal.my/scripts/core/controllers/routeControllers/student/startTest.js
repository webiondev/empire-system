app.register.controller('startTest', ['$scope', '$http', 'pinesNotifications', '$location', '$routeParams', 'testFactory', 'timerFactory', '$route', '$modal', function($scope, $http, pinesNotifications, $location, $routeParams, testFactory, timerFactory, $route, $modal){

  $scope.contentloaded = false;

  var base_url = $("meta[name='base_url']").attr('content');
  var test_id = ($routeParams.test_id || "");

  $scope.credentials = {};

  $scope.valid = false;
  $scope.submited = null;
  $scope.duration = 0;
  $scope.items = [];

  $scope.credentials.questions = [];
  $scope.resultsmc = [];

  var url = base_url + '/student/getResultsMCbyId/' + _config.id;

  $http({
    method: 'get',
    url: base_url + '/student/gettestbyid/' + test_id
    }).success(function(data, status, headers, config) {

      $scope.credentials.tests = data;
      $scope.duration = $scope.credentials.tests.duration;
      
      var res = $scope.duration.split(":");
      var hours = res[0] * 60 * 60;
      var minutes = res[1] * 60;

      $scope.credentials.testduration = hours/60/60 + " hours, " + minutes/60 + " minutes";
      
      $scope.duration = hours + minutes;      
      $scope.contentloaded = true;
      
      //LOAD TEST

      $scope.loadTest();  
      $scope.valid = $scope.isValidTest();

      console.log($scope.valid);
      if($scope.valid) {
       $scope.items.name = $scope.credentials.tests.name;
       $scope.loadQuestions();
      } 
      
    }).error(function(data, status, headers, config) {

      $('#error').html('code: ' + status + ' unable to fetch exam data.');
      $('#alert').fadeIn(1000).removeClass('hide');
  });

  $scope.isValidTest = function() {
      
      if(($scope.credentials.tests.current_time >= $scope.credentials.tests.startdate) && ($scope.credentials.tests.current_time <= $scope.credentials.tests.enddate)){
        console.log('valid is true');
        return true;
      } else {
        console.log('valid is false');
        return false;
      }
  }

  function Countdown(options) {

    var timer,
    instance = this,
    seconds = options.seconds || 10,
    updateStatus = options.onUpdateStatus || function () {},
    counterEnd = options.onCounterEnd || function () {};

    function decrementCounter() {
      updateStatus(seconds);
      if (seconds === 0) {
        counterEnd();
        instance.stop();
      }
      seconds--;
    }

    this.start = function () {
      clearInterval(timer);
      timer = 0;
      seconds = options.seconds;
      minutes = options.minutes;
      timer = setInterval(decrementCounter, 1000);
    };

    this.stop = function () {
      clearInterval(timer);
    };
  }

  String.prototype.toHHMMSS = function () {
    var sec_num = parseInt(this, 10); // don't forget the second param
    var hours   = Math.floor(sec_num / 3600);
    var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
    var seconds = sec_num - (hours * 3600) - (minutes * 60);

    if (hours   < 10) {hours   = "0"+hours;}
    if (minutes < 10) {minutes = "0"+minutes;}
    if (seconds < 10) {seconds = "0"+seconds;}
    var time    = hours+':'+minutes+':'+seconds;
    return time;
  };

  $scope.credentials.timer = timerFactory;

  //LOAD QUESTIONS BASED ON TYPE  
  $scope.loadQuestions = function() 
  {
      $http({
        method: 'get',
        url: base_url + '/student/get-testquestions/' + test_id
        }).success(function(data, status, headers, config) {

          $scope.credentials.questions = data;
          console.log('questions: ' + $scope.credentials.questions.length);

        }).error(function(data, status, headers, config) {

          $('#error').html('code: ' + status + ' unable to fetch test data.');
          $('#alert').fadeIn(1000).removeClass('hide');
      });

  };

  //TEST LOAD
  angular.isUndefinedOrNull = function(val) {
    return angular.isUndefined(val) || val === null 
  }

  $scope.resultsmc = [];
  $scope.loadTest = function() {

    testFactory.async().then(function(d) {
        
      $scope.resultsmc = d;
      
      if(!angular.isUndefinedOrNull($scope.resultsmc)) {
        
        $('#checkup').removeClass('ng-hide');
        
      }

      if(!angular.isUndefinedOrNull($scope.resultsmc) && !$scope.resultsmc[0].submited) {

          $scope.submited = 0;
          $('#checkup').hide();

          $('panel.exam').removeClass('exam ng-hide');
          $('panel.exam').removeClass('ng-hide');

          var dt  = $scope.resultsmc.current_time.split(/-|\s|:/);//$scope.resultsmc.current_time.split(/\-|\s/);
          current = new Date(dt[0], dt[1] -1, dt[2], dt[3], dt[4], dt[5]);//new Date(dt.slice(0,3).reverse().join('/')+' '+dt[3]);
          
          dt = $scope.resultsmc[0].started_time.split(/-|\s|:/);//$scope.resultsmc[0].started_time.split(/\-|\s/);
          started = new Date(dt[0], dt[1] -1, dt[2], dt[3], dt[4], dt[5]);//new Date(dt.slice(0,3).reverse().join('/')+' '+dt[3]);

          var dif = current.getTime() - started.getTime();
          var secondspast = dif / 1000;

          if($scope.duration > secondspast) {
            
            var myCounter = new Countdown({  
            seconds: $scope.duration-secondspast,  
            onUpdateStatus: function(sec){

            $scope.$apply(function() {
              $scope.credentials.timer = "Estimated time: " + sec.toString().toHHMMSS();
            });

            },
         
            onCounterEnd: function(){ alert('counter ended!');} 
            });

            myCounter.start();

            $('panel.exam').removeClass('exam ng-hide');
            $('panel.exam').removeClass('ng-hide');

          } else {

            //post results [!!!]
            //$route.reload();
            //console.log('reloaded');
            $scope.valid = false;
          }

        } else {

          //console.log('exam is submitted:' + $scope.resultsmc[0].submited);
          $scope.valid = false;
        }

        });
  };
      
  //CHECKING TEST CODE
  $scope.check = function(){
    
    if($scope.credentials.tests.code == $scope.credentials.code) {

      $('#checkup').hide();
      $('panel.exam').removeClass('exam ng-hide');
      $('panel.exam').removeClass('ng-hide');


      $data = {
        test_id: $routeParams.test_id,
        student_id: _config.id,
        started_time: (new Date),
        status: 0
      };

      $http({
      method: 'post',
      url: base_url + '/postResultsTest',
      data: $data,
      header: {'Content-Type': undefined}
      }).
      success(function(data, status, headers, config) {

        if(!data['success']) {

          pinesNotifications.notify({
              
            title: 'Error',
            text: data["errors"],
            type: 'error',
            hide: true
          });
        }
      }).
      error(function(data, status, headers, config) {

          $('#error').html('code: ' + status);
          $('#alert').fadeIn(1000).removeClass('hide');
      }); 
      
      var myCounter = new Countdown({  
      seconds: $scope.duration,  
      onUpdateStatus: function(sec){

        $scope.$apply(function() {
          $scope.credentials.timer = "Estimated time: " + sec.toString().toHHMMSS();
        });

      },
       
      onCounterEnd: function(){ alert('counter ended!');} 
      });

      myCounter.start();

    } else {

      pinesNotifications.notify({
          
        title: 'Error',
        text: "Wrong Test Code",
        type: 'error',
        hide: true
      });
    }
  }

  //SUBMIT RESULTS BASED ON TYPE
  $scope.credentials.questions.answer = [];
  $scope.results = function() 
  {
      $data = {
        student_id: _config.id,
        test_id: $routeParams.test_id,
        answers: $scope.credentials.questions.answer
      };

      $http({
      method: 'post',
      url: base_url + '/student/postTestResults',
      data: $data,
      header: {'Content-Type': undefined}
      }).
      success(function(data, status, headers, config) {

        if(data['success']) {

          $scope.items.marks = data["results"];
          console.log(data);
          $scope.open();

          $location.path('/test-modules');

        } else {

          pinesNotifications.notify({
              
            title: 'Error',
            text: data['errors'],
            type: 'error',
            hide: true
          });
        }
      }).
      error(function(data, status, headers, config) {

          $('#error').html('code: ' + status);
          $('#alert').fadeIn(1000).removeClass('hide');
      }); 
  };

  $scope.submit = function(credentials) {
    $scope.results();
  };

  $scope.open = function(name, size) {
      var modalInstance = $modal.open({
        templateUrl: 'myModalContent.html',
        controller: function($scope, $modalInstance, items) {

          $scope.items = items;
          $scope.ok = function() {
            $modalInstance.close();
            console.log($scope.items);
          };

          $scope.cancel = function() {
            $modalInstance.dismiss('cancel');
          };
        },
        size: size,
        resolve: {
          items: function() {
            return $scope.items;
          }
        }
      });

      modalInstance.result.then(function(selectedItem) {
        $scope.selected = selectedItem;
      }, function() {
        $log.info('Modal dismissed at: ' + new Date());
      });
    };

}]);