var app = angular
  .module('themesApp', [
    'theme',
    'theme.demos', 'ngAnimate', 'angular-tour', 'ngStorage']);

app.directive(
    'ngMorphingModal',
    function() {

        var randLetter = String.fromCharCode(65 + Math.floor(Math.random() * 26));
        var uniqid = randLetter + Date.now();

        function init(scope, element, attributes) {

          var MorphingModalObj = new MorphingModal({

              contentSelector: '.cd-modal',
              contentSelectorObj: $('.cd-modal'),

              selectorId: '[data-type="modal-trigger"]',
              selectorObj: $('[data-type="modal-trigger"]'),
              //contentSelector: scope.contentSelector,
              onAfterClose: null,
              onAfterOpen: function() {
              }
          });
        };

        return {
            replace: true,
            restrict: 'AE',
            scope: {
                contentSelector: '@'
            },
            link: init,

            controller: function($scope) {

              var element = $('#helper');
              //init($scope, element, null); //?
            },
            templateUrl: function() {
                return 'views/td-modal.html';
            },
        }
    });



//Better route authentication [!] - http://stackoverflow.com/questions/20969835/angularjs-login-and-authentication-in-each-route-and-controller/29797145#29797145
app.factory('AuthService', function($q){
    return {
        authenticate : function(role){
            //Authentication logic here

            var authenticateRole = function(role) {

              switch(role) {
                case "Admin":
                  return (_config.user == "Admin");
                break;
                case "Lecturer":
                  return (_config.user == "Lecturer");
                break;
                case "Student":
                  return (_config.user == "Student");
                break;
              }
            };

            if(authenticateRole(role)){
                //If authenticated, return anything you want, probably a user object
                return true;
            } else {
                //Else send a rejection
                return $q.reject('Not Authenticated');
            }
        }
    }
});


app.config(['$provide', '$routeProvider', '$controllerProvider', '$compileProvider', '$filterProvider', function($provide, $routeProvider, $controllerProvider, $compileProvider, $filterProvider) {
    'use strict';

    app.register = {
      controller: $controllerProvider.register,
      directive: $compileProvider.directive,
      filter: $filterProvider.register,
      factory: $provide.factory,
      service: $provide.service
    };
    

    $routeProvider
      .when('/', {
        templateUrl: function($scope) {

          $scope.type = _config;
          return 'views/dashboard' + $scope.type.user.toLowerCase() + '.html';
        },

        controller: 'dashboardController',

        access: {
            requiresLogin: true,
            requiredPermissions: ['Admin', 'UserManager'],
            permissionType: 'AtLeastOne'
        }

      }).when('/admin-browse-users', {

        templateUrl: 'views/admin/admin-browse-users.html',
        resolve: {
            load: function($q, $route, $rootScope) {

              var deferred = $q.defer();
              var dependencies = [
                '/scripts/core/controllers/routeControllers/admin/adminBrowseUsers.js'
              ];

              $script(dependencies, function () {
                $rootScope.$apply(function() {
                  deferred.resolve();
                });
              });

              return deferred.promise;
            },

            //This function is injected with the AuthService where you'll put your authentication logic
          'auth' : function(AuthService){
              return AuthService.authenticate("Admin");
          }
       
        } 
        
      }).when('/student-notifications/:student_id', {

        templateUrl: 'views/admin/student-notifications.html',
        resolve: {
            load: function($q, $route, $rootScope) {

              var deferred = $q.defer();
              var dependencies = [
                '/scripts/core/controllers/routeControllers/admin/adminStudentNotifications.js'
              ];

              $script(dependencies, function () {
                $rootScope.$apply(function() {
                  deferred.resolve();
                });
              });

              return deferred.promise;
            },

            //This function is injected with the AuthService where you'll put your authentication logic
          'auth' : function(AuthService){
              return AuthService.authenticate("Admin");
          }
       
        } 
        
      }).when('/admin-browse-lecturers', {

        templateUrl: 'views/admin/admin-browse-lecturers.html',
        resolve: {
            load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/admin/adminBrowseLecturers.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
           },

            'auth' : function(AuthService){
              return AuthService.authenticate("Admin");
          }
        } 
        
      }).when('/admin-student-registration', {

        templateUrl: 'views/admin/admin-student-registration.html',
        resolve: {
          loadStepy: ['$ocLazyLoad', function($ocLazyLoad) {
            return $ocLazyLoad.load([
              'bower_components/jquery-validation/dist/jquery.validate.js',
              'bower_components/stepy/lib/jquery.stepy.js'
            ]);
          }],
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/admin/studentRegistration.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },

          'auth' : function(AuthService){
            return AuthService.authenticate("Admin");
      }
        }
      }).when('/admin-lecturer-registration', {

        templateUrl: 'views/admin/admin-lecturer-registration.html',
        resolve: {
          loadStepy: ['$ocLazyLoad', function($ocLazyLoad) {
            return $ocLazyLoad.load([
              'bower_components/jquery-validation/dist/jquery.validate.js',
              'bower_components/stepy/lib/jquery.stepy.js'
            ]);
          }],
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/admin/lecturerRegistration.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },

        'auth' : function(AuthService){
            return AuthService.authenticate("Admin");
      }
        }
      }).when('/register-new-course', {

        templateUrl: 'views/admin/register-new-course.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/admin/courseRegistration.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
            return AuthService.authenticate("Admin");
      }
        }

      }).when('/register-new-module', {

        templateUrl: 'views/admin/register-new-module.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/admin/moduleRegistration.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
            return AuthService.authenticate("Admin");
      }
        } 

      }).when('/module/edit/:id', {

        templateUrl: 'views/admin/module-edit.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/admin/adminEditModule.js',
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
            return AuthService.authenticate("Admin");
      }
        } 

      }).when('/manage-courses', {

        templateUrl: 'views/admin/admin-manage-courses.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/admin/manageCourses.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
            return AuthService.authenticate("Admin");
      }
        } 

      }).when('/manage-modules', {

        templateUrl: 'views/admin/admin-manage-modules.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/admin/manageModules.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
            return AuthService.authenticate("Admin");
      }
        }

      }).when('/view-course/:course_id', {

        templateUrl: 'views/admin/admin-view-course.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/admin/viewCourse.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
            return AuthService.authenticate("Admin");
      }
        } 

      }).when('/add-new-module/:course_id', {

        templateUrl: 'views/admin/admin-add-new-module.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/admin/addCourseModule.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
            return AuthService.authenticate("Admin");
      }
        }

      }).when('/student-details/:student_id', {

        templateUrl: 'views/admin/admin-student-details.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/admin/studentDetails.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
            return AuthService.authenticate("Admin");
      }
        } 

      }).when('/lecturer-consultations', {

        templateUrl: 'views/lecturer/lecturer-consultations.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/lecturer/lecturerConsultations.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
            return AuthService.authenticate("Lecturer");
      }
        } 

      }).when('/fee-statement/:student_id', {

        templateUrl: 'views/admin/admin-fee-statement.html',
        resolve: {
          loadStepy: ['$ocLazyLoad', function($ocLazyLoad) {
            return $ocLazyLoad.load([
              'bower_components/jquery-validation/dist/jquery.validate.js'
            ]);
          }],
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/admin/feeStatement.js',
              '/scripts/core/controllers/routeControllers/admin/feeStatementSubmit.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
            return AuthService.authenticate("Admin");
        }
        }

      }).when('/student-fee-statement', {

        templateUrl: 'views/student/student-fee-statement.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/student/studentFeeStatement.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
            return AuthService.authenticate("Student");
        }
        } 

      }).when('/student-list', {

        templateUrl: 'views/lecturer/student-list.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/lecturer/studentList.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
              return AuthService.authenticate("Lecturer");
        }
        }


      }).when('/student-assessment/:student_id', {

        templateUrl: 'views/lecturer/student-assessment.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/lecturer/studentAssessment.js',
              '/scripts/core/controllers/routeControllers/lecturer/formStudentAssessment.js',
              '/scripts/core/controllers/routeControllers/lecturer/submitAssessment.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
              return AuthService.authenticate("Lecturer");
        }
        }

      }).when('/add-assessment/:student_id', {

        templateUrl: 'views/lecturer/add-assessment.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/lecturer/createAssessment.js'
             ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
              return AuthService.authenticate("Lecturer");
        }
        }


      }).when('/edit-assessment/:student_id', {

        templateUrl: 'views/lecturer/edit-assessment.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/lecturer/editAssessment.js'
             ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
              return AuthService.authenticate("Lecturer");
        }
        }

      //Edit Test Question work on this
      })
      //.when('/test-edit/:test_id', {

      //   templateUrl: 'views/lecturer/edit-test.html',
      //   resolve: {
      //     load: function($q, $route, $rootScope) {

      //       var deferred = $q.defer();
      //       var dependencies = [
      //         '/scripts/core/controllers/routeControllers/lecturer/editTestQuestion.js'
      //        ];

      //       $script(dependencies, function () {
      //         $rootScope.$apply(function() {
      //           deferred.resolve();
      //         });
      //       });

      //       return deferred.promise;
      //     },
      //     'auth' : function(AuthService){
      //         return AuthService.authenticate("Lecturer");
      //   }
      //   }

      // })
      .when('/view-consultations', {

        templateUrl: 'views/lecturer/view-consultations.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/lecturer/viewConsultations.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
              return AuthService.authenticate("Lecturer");
        }
        }

      }).when('/student-web-enrollment', {

        templateUrl: 'views/student/student-web-enrollment.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/student/studentWebEnrollment.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
              return AuthService.authenticate("Student");
        }
        }

      }).when('/schedule', {

        templateUrl: 'views/student/schedule.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/student/studentSchedule.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
              return AuthService.authenticate("Student");
        },

        loadCalendar: ['$ocLazyLoad', function($ocLazyLoad) {
            return $ocLazyLoad.load([
              'bower_components/fullcalendar/fullcalendar.js'
            ]);
          }]

       
        }

      }).when('/admin-create-template', {

        templateUrl: 'views/admin/admin-create-template.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/admin/createTemplate.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
              return AuthService.authenticate("Admin");
        }

        }

      }).when('/admin-edit-template', {

        templateUrl: 'views/admin/admin-edit-template.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/admin/editTemplate.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
              return AuthService.authenticate("Admin");
        },

        loadCalendar: ['$ocLazyLoad', function($ocLazyLoad) {
            return $ocLazyLoad.load([
              'bower_components/fullcalendar/fullcalendar.js'
            ]);
          }]

       
        }

      }).when('/user-group-schedule', {

        templateUrl: 'views/admin/user-group-schedule.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/admin/userGroupSchedule.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
              return AuthService.authenticate("Admin");
        },

        loadCalendar: ['$ocLazyLoad', function($ocLazyLoad) {
            return $ocLazyLoad.load([
              'bower_components/fullcalendar/fullcalendar.js'
            ]);
          }]

       
        }

      }).when('/student-myunits', {

        templateUrl: 'views/student/student-myunits.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/student/studentMyUnits.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
              return AuthService.authenticate("Student");
        }
       
        }

      }).when('/view-module/:module_id', {

        templateUrl: 'views/student/view-module.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/student/viewModule.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
              return AuthService.authenticate("Student");
        }
        }

      }).when('/lecturer-modules', {

        templateUrl: 'views/lecturer/lecturer-modules.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/lecturer/lecturerModules.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
              return AuthService.authenticate("Lecturer");
        }
        }

      }).when('/upload-materials/:module_id', {

        templateUrl: 'views/lecturer/upload-materials.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/lecturer/lecturerUploadMaterials.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
              return AuthService.authenticate("Lecturer");
        }
        }

      }).when('/view-materials/:module_id', {

        templateUrl: 'views/lecturer/view-materials.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/lecturer/lecturerViewMaterials.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
              return AuthService.authenticate("Lecturer");
        }
        }

      }).when('/create-examination', {

        templateUrl: 'views/lecturer/create-examination.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/lecturer/createExamination.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
              return AuthService.authenticate("Lecturer");
        }
        }

      }).when('/view-examinations', {

        templateUrl: 'views/lecturer/view-examinations.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/lecturer/viewExaminations.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
              return AuthService.authenticate("Lecturer");
        }
        }

      }).when('/exam-edit/:exam_id', {

        controller: 'editExamination',
        templateUrl: 'views/lecturer/exam-edit.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/lecturer/editExamination.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
              return AuthService.authenticate("Lecturer");
        }
        }

      }).when('/examination-modules', {

        templateUrl: 'views/student/examination-modules.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/student/examinationModules.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
              return AuthService.authenticate("Student");
        }
        }

      }).when('/start-exam/:exam_id', {

        templateUrl: 'views/student/start-exam.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/student/startExam.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
              return AuthService.authenticate("Student");
        }
        }
      
      }).when('/book-consultation', {

        templateUrl: 'views/student/book-consultation.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/student/bookConsultation.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
              return AuthService.authenticate("Student");
        }
        }
      
      }).when('/my-consultations', {

        templateUrl: 'views/student/my-consultations.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/student/myConsultations.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
              return AuthService.authenticate("Student");
        }
        }

      }).when('/view-consultation/:consultation_id', {

        templateUrl: 'views/lecturer/view-consultation.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/lecturer/viewConsultationById.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
              return AuthService.authenticate("Lecturer");
        }
        }
      
      }).when('/view-exam-results/:exam_id', {

        templateUrl: 'views/lecturer/view-exam-results.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/lecturer/viewExamResults.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
              return AuthService.authenticate("Lecturer");
        }
        }
      
      }).when('/test-modules', {

        templateUrl: 'views/student/test-modules.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/student/testModules.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
              return AuthService.authenticate("Student");
        }
        }
      
      }).when('/create-test', {

        templateUrl: 'views/lecturer/create-test.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/lecturer/createTest.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
              return AuthService.authenticate("Lecturer");
        }
        }
      
      }).when('/view-tests', {

        templateUrl: 'views/lecturer/view-tests.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/lecturer/viewTests.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
              return AuthService.authenticate("Lecturer");
        }
        }
      
      }).when('/test-edit/:test_id', {

        templateUrl: 'views/lecturer/test-edit.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/lecturer/editTest.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
              return AuthService.authenticate("Lecturer");
        }
        }

      }).when('/start-test/:test_id', {

        templateUrl: 'views/student/start-test.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/student/startTest.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
              return AuthService.authenticate("Student");
        }
        }

      }).when('/view-test-results/:test_id', {

        templateUrl: 'views/lecturer/view-test-results.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/lecturer/viewTestResults.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
              return AuthService.authenticate("Lecturer");
        }
        }

      }).when('/assignment-submission', {

        templateUrl: 'views/student/assignment-submission.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/student/assignmentSubmission.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
              return AuthService.authenticate("Student");
        }
        }

      }).when('/assignments-list', {

        templateUrl: 'views/lecturer/assignments-list.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/lecturer/assignmentsList.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
              return AuthService.authenticate("Lecturer");
        }
        }

      }).when('/learning-materials', {

        templateUrl: 'views/lecturer/learning-materials.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/lecturer/learningMaterials.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
              return AuthService.authenticate("Lecturer");
        }
        }

      }).when('/view-student/:student_id', {

        templateUrl: 'views/lecturer/view-student.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/lecturer/viewStudent.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
              return AuthService.authenticate("Lecturer");
        }
        }

      }).when('/course-academis-information', {

        controller: 'courseAcademicInformation',
        templateUrl: 'views/lecturer/course-academis-information.html',
        resolve: {
        'auth' : function(AuthService){
              return AuthService.authenticate("Lecturer");
        }
      }

      }).when('/lecturer-details/:lecturer_id', {

        templateUrl: 'views/admin/lecturer-details.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/admin/lecturerDetails.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
              return AuthService.authenticate("Admin");
        }
        }

      }).when('/view-fillup-results/:student_id/:exam_id', {

        templateUrl: 'views/lecturer/view-fillup-results.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/lecturer/viewFillUpResults.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
              return AuthService.authenticate("Lecturer");
        }
        }

      }).when('/view-essay-results/:student_id/:exam_id', {

        templateUrl: 'views/lecturer/view-essay-results.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/lecturer/viewEssayResults.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
              return AuthService.authenticate("Lecturer");
        }
        }

      }).when('/create-announcement', {

        templateUrl: 'views/lecturer/create-announcement.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/lecturer/createAnnouncement.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
              return AuthService.authenticate("Lecturer");
        }
        }

      }).when('/view-announcements', {

        templateUrl: 'views/lecturer/view-announcements.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/lecturer/viewAnnouncements.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
              return AuthService.authenticate("Lecturer");
        }
        }

      }).when('/profile', {

        templateUrl: 'views/profile.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/myProfile.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          }
        }

      }).when('/admin-browse-groups', {

        templateUrl: 'views/admin/browse-user-groups.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/admin/browseUserGroups.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
              return AuthService.authenticate("Admin");
        }
        }

      }).when('/admin-create-group', {

        templateUrl: 'views/admin/admin-create-group.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/admin/createUserGroup.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
              return AuthService.authenticate("Admin");
        }
        } 

      }).when('/lecturer-materials/:module_id', {

        templateUrl: 'views/lecturer/lecturer-materials.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/lecturer/viewLearningModule.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
              return AuthService.authenticate("Lecturer");
        }
        } 

      }).when('/system-modules', {

        templateUrl: 'views/admin/system-modules.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/admin/systemModule.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
              return AuthService.authenticate("Admin");
        }
        }

      }).when('/view-lecturer-materials/:module_id', {

        templateUrl: 'views/admin/view-lecturer-materials.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/admin/adminViewMaterials.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
              return AuthService.authenticate("Admin");
        }
        }

      }).when('/upload-lecturer-materials/:module_id', {

        templateUrl: 'views/admin/upload-lecturer-materials.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/admin/adminUploadMaterials.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
              return AuthService.authenticate("Admin");
        }
        }

      }).when('/course-syllabus', {

        templateUrl: 'views/student/course-syllabus.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/courseSyllabus.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
              return AuthService.authenticate("Student");
        }
        }

      }).when('/appendix', {

        templateUrl: 'views/appendix.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/courseSyllabus.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          }
        }

      }).when('/add-group-user/:group_id', {

        templateUrl: 'views/admin/add-group-user.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/admin/addGroupUser.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
              return AuthService.authenticate("Admin");
        }
        }

      }).when('/view-group-users/:group_id', {

        templateUrl: 'views/admin/view-group-users.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/admin/viewGroupUsers.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
              return AuthService.authenticate("Admin");
        }
        }

      }).when('/edit-group/:group_id', {

        templateUrl: 'views/admin/edit-group.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/admin/editGroupUser.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
              return AuthService.authenticate("Admin");
        }
        }

      }).when('/create-task', {

        templateUrl: 'views/lecturer/create-task.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/lecturer/createTask.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
              return AuthService.authenticate("Lecturer");
        }
        }

      }).when('/view-tasks', {

        templateUrl: 'views/lecturer/view-tasks.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/lecturer/lecturerViewTasks.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
              return AuthService.authenticate("Lecturer");
        }
        }

      }).when('/my-tasks', {

        templateUrl: 'views/student/my-tasks.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/student/myTasks.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
              return AuthService.authenticate("Student");
        }
        }

      }).when('/submit-task/:task_id', {

        templateUrl: 'views/student/submit-task.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/student/submitTask.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
              return AuthService.authenticate("Student");
        }
        }

      }).when('/view-task-submissions/:task_id', {

        templateUrl: 'views/lecturer/view-task-submissions.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/lecturer/viewTaskSubmissions.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
              return AuthService.authenticate("Lecturer");
        }
        }

      }).when('/lecturer-edit/:lecturer_id', {

        templateUrl: 'views/admin/lecturer-edit.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/admin/editLecturer.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
              return AuthService.authenticate("Admin");
        }
        }

      }).when('/course-edit/:course_id', {

        templateUrl: 'views/admin/course-edit.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/admin/courseEdit.js',
              '/scripts/core/controllers/routeControllers/admin/viewCourse.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
            return AuthService.authenticate("Admin");
      }
        } 

      }).when('/enrolled-student/:course_id', {

        templateUrl: 'views/admin/course-enrolled-student.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/admin/courseEnrolledStudent.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
            return AuthService.authenticate("Admin");
      }
        } 

      }).when('/module/detail/:module_id', {

        templateUrl: 'views/student/module-detail.html',
        resolve: {
          load: function($q, $route, $rootScope) {

            var deferred = $q.defer();
            var dependencies = [
              '/scripts/core/controllers/routeControllers/student/moduleDetail.js'
            ];

            $script(dependencies, function () {
              $rootScope.$apply(function() {
                deferred.resolve();
              });
            });

            return deferred.promise;
          },
          'auth' : function(AuthService){
            return AuthService.authenticate("Student");
      }
        } 

      }).when('/:templateFile', {

        templateUrl: function(param) {
          return 'views/' + param.templateFile + '.html';
        }
      }).when('#', {
        templateUrl: 'views/index.html',
      })
      .otherwise({
        redirectTo: '/'
      })
  
}]);

//----------------------------- FILTERS ------------------------------------------
app.filter('unique', function() {
   return function(collection, keyname) {
      var output = [], 
          keys = [];

      angular.forEach(collection, function(item) {
          var key = item[keyname];
          if(keys.indexOf(key) === -1) {
              keys.push(key);
              output.push(item);
          }
      });

      return output;
   };
});

app.filter("sanitize", ['$sce', function($sce) {

  return function(htmlCode){
    return $sce.trustAsHtml(htmlCode);
  }

}]);

app.filter("asDate", function () {
    
    return function (input) {

      var dt  = input.split(/-|\s|:/);

      if(dt[4] == 00) {
        return "UNSET";
      }
     
      return new Date(dt[0], dt[1] -1, dt[2], dt[3], dt[4], dt[5]).toLocaleString();
    }
});

app.filter("typeDescription", function () {
    
  return function description(type) {

    switch(type) {

      case "pdf":
      return "PDF document"
      break;

      case "word":
      case "wordx":
      return "Microsoft Word document"
      break;

      case "xls":
      case "xlsx":
      return "Microsoft Excel document";
      break;

      case "ppt":
      case "pptx":
      return "PowerPoint Presentation";
      break;

      case "doc":
      case "docx":
      return "Microsoft Word document";
      break;

      case "file":
      return "file";
      break;

      default: return type; break;
    }

    return type; 
  };
});

app.filter("asHumanReadable", function () {
    
  return function bytesToSize(bytes) {

   var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
   if (bytes == 0) return '0 Byte';

    var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
    return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
    };
});


app.factory('Login', function($http){

var base_url = $("meta[name='base_url']").attr('content');

  return {

      auth:function(){

      var authUser = $http({method:'GET',  url:base_url+'/auth/login/store'});
      return authUser;
    }
  }
});

app.factory('SessionService',function(){
  return{
    get:function(key){
    return sessionStorage.getItem(key);
    },
    set:function(key,val){
    return sessionStorage.setItem(key,val);
    },
    unset:function(key){
    return sessionStorage.removeItem(key);
    }
  }
});

app.run(['Login', 'SessionService', '$rootScope', '$localStorage', 'progressLoader', function(Login, SessionService, $rootScope, $localStorage, progressLoader) {

  //Check
  $rootScope.$on('$routeChangeStart', function(){
    progressLoader.start();
    progressLoader.set(10);
  });

  $rootScope.$on('$routeChangeSuccess', function(){
    progressLoader.end();
  });

  $rootScope.loginSubmit = function() {

     var auth = Login.auth();
     auth.success(function(response){

      if(response.id){
        
        SessionService.set('auth', true); 
        SessionService.set('type', response.type);

        $localStorage.currentUser = response.user;
        //console.log($localStorage.currentUser);

       }  else {

          console.log("Cannot authenticate your login");
       }
     });
  };

  if(!SessionService.get('auth')) {

    $rootScope.loginSubmit();

  }

}]);


//----------------------------- GENERAL CONTROLLERS  ------------------------------------------

app.controller('logoutController', ['$scope', '$http', 'pinesNotifications', '$location', '$routeParams', '$route', '$modal', 'Login', 'SessionService', '$window', function($scope, $http, pinesNotifications, $location, $routeParams, $route, $modal, Login, SessionService, $window){

  var base_url = $("meta[name='base_url']").attr('content');

  $scope.logout = function() {

    $http({
        method: 'get',
        //url: base_url + '/api/login/deauth'
        url: base_url + '/logout'
        }).
        success(function(data, status, headers, config) {
          
          if(data['success']) {

            SessionService.unset('auth');
            SessionService.unset('type');
            
            $window.location = '/';
            console.log("successfully logout !!!!!!!!!");


          } else {

            $('#error').html('code: ' + status + ' unable to logout. Connection error.');
            $('#alert').fadeIn(1000).removeClass('hide');
            console.log("code: " + status + " unable to logout. Connection error.");
          } 
        }).
        error(function(data, status, headers, config) {

            $('#error').html('code: ' + status + ' unable to logout. Connection error.');
            $('#alert').fadeIn(1000).removeClass('hide');
            console.log("code: " + status + " unable to logout. Connection error.");
        }); 
  };

}]);

app.directive('backImg', function(){
    return function(scope, element, attrs){
        attrs.$observe('backImg', function(value) {

          if(value) {

            element.css({
                'background': 'transparent url(' + value +') no-repeat',
                'background-size' : '100% 100%'//'cover'
            });

          } else {

             element.css({
                'background': 'none repeat scroll 0% 0% #7A869C'
            });
          }

        });
    };
});

app.controller('dashboardController', ['$scope', '$http', 'pinesNotifications', '$location', '$routeParams', '$route', '$modal', 'SessionService', '$localStorage', function($scope, $http, pinesNotifications, $location, $routeParams, $route, $modal, SessionService, $localStorage){

  var base_url = $("meta[name='base_url']").attr('content');

  $scope.isValid = function(object) {
    return (object !== undefined && object.length > 0);
  };
  
  $scope.credentials = {};
  $scope.tasks = [];
  $scope.credentials.avatar = "/files/avatar/" + $localStorage.currentUser.avatar;





  switch(_config.user) {
  
  case "Admin": break;
  case "Lecturer": 

  $http({
    method: 'get',
    url: base_url + '/announcement/lecturer-get',
    }).success(function(data, status, headers, config) {
    
      $scope.credentials.announcements = data;

      console.log($scope.credentials.announcements)

    }).error(function(data, status){
        
        $('#error').html('code: ' + status);
        $('#alert').fadeIn(1000).removeClass('hide');

  });

  break;
    
  case "Student": 

   $scope.module_s_count=new Array();


    $http({
    
      method: 'get',
      url: base_url + '/student/getmodulecount'

      }).success(function(data, status, headers, config) {
        
          $scope.module_s_count= data;
          console.log(data);
         
    

  }).error(function(data, status, headers, config) {

        $('#error').html('code: ' + status + ' unable to fetch student list.');
        $('#alert').fadeIn(1000).removeClass('hide');
  });

  $http({
    method: 'get',
    url: base_url + '/announcement/getdashboard',
    }).success(function(data, status, headers, config) {
    
      $scope.credentials.announcements = data;

    }).error(function(data, status){
        
        $('#error').html('code: ' + status);
        $('#alert').fadeIn(1000).removeClass('hide');

  }).then(function() {

      $http({
        method: 'get',
        url: base_url + '/student/get-my-tasks/' + _config.id,
        }).success(function(data, status, headers, config) {
        
          $scope.credentials.tasks = data;

        }).error(function(data, status){
            
            $('#error').html('code: ' + status);
            $('#alert').fadeIn(1000).removeClass('hide');
      });

  });

  break;
  }

  $scope.open = function(name, size) {
      var modalInstance = $modal.open({
        templateUrl: 'taskSubmission.html',
        controller: function($scope, $modalInstance, items, pinesNotifications) {

          $scope.items = items;
          $scope.ok = function() {

          var fileName = $('#filename').html();
          var ext = fileName.substr(fileName.lastIndexOf('.') + 1);

          $data = {
            task_id: name,
            file: $scope.credentials.file,
            filename: fileName,
            ext: ext
          };

          $http({
          method: 'post',
          url: base_url + '/task/upload-task',
          data: $data,
          header: {'Content-Type': undefined}
          }).
          success(function(data, status, headers, config) {

            if(data['success']) {

              $location.path('/my-tasks');
              pinesNotifications.notify({
              
                title: 'Success',
                text: 'Task successfully uploaded.',
                type: 'success',
                hide: true
              });

            } else {

              pinesNotifications.notify({
              
                title: 'Error',
                text: data["message"],
                type: 'error',
                hide: true
              });
            }
          }).
          error(function(data, status, headers, config) {

              $('#error').html('code: ' + status);
              $('#alert').fadeIn(1000).removeClass('hide');
          }); 

          

          $modalInstance.close();

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

    };

}]);


app.controller('courseAcademicInformation', ['$scope', '$http', 'pinesNotifications', '$location', '$routeParams', '$route', '$modal', 'SessionService', function($scope, $http, pinesNotifications, $location, $routeParams, $route, $modal, SessionService){

//alert(SessionService.get('type'));

}]);


app.directive("profileread", ['$rootScope', '$http', 'pinesNotifications', function ($rootScope, $http, pinesNotifications) {
    
    return {
        scope: {
            fileread: "=?"
        },
        link: function (scope, element, attributes) {
            element.bind("change", function (changeEvent) {

            var reader = new FileReader();
            reader.onload = function (loadEvent) {
                  scope.$apply(function () {
                      
                      scope.fileread = loadEvent.target.result;
                  });

                  $data = {
                    image: scope.fileread
                  };

                  var base_url = $("meta[name='base_url']").attr('content');
                  var url = base_url + element.attr('url'); 

                  $http({
                  method: 'post',
                  url: url,
                  data: $data,
                  header: {'Content-Type': undefined}
                  }).
                  success(function(data, status, headers, config) {

                    if(data['success']) {

                      pinesNotifications.notify({
              
                        title: 'Success',
                        text: "Profile picture successfully changed.",
                        type: 'success',
                        hide: true
                      });
                      
                    } else {

                      pinesNotifications.notify({
              
                        title: 'Error',
                        text: "Unable to change profile picture.",
                        type: 'error',
                        hide: true
                      });
                    }

                  }).
                  error(function(data, status, headers, config) {

                    $('#error').html('code: ' + status);
                    $('#alert').fadeIn(1000).removeClass('hide');
                  });

                }
                reader.readAsDataURL(changeEvent.target.files[0]);
            });
        }
    }
}]);



//--------------------------- ADMIN CONTROLLERS  ------------------------------------------

app.controller('submitTestQuestions', ['$scope', '$http', 'pinesNotifications', '$location', '$routeParams', '$timeout', 'testDetails', function($scope, $http, pinesNotifications, $location, $routeParams, $timeout, testDetails){

  $scope.credentials = {};
  var test_id = ($routeParams.test_id || "");
  var base_url = $("meta[name='base_url']").attr('content');


  $scope.submit = function(credentials) {

    $data = {
      test_id: test_id,
      question: $scope.credentials.question,
      option_1: $scope.credentials.option_1,
      option_2: $scope.credentials.option_2,
      option_3: $scope.credentials.option_3,
      option_4: $scope.credentials.option_4,
      correct_answer: $scope.credentials.correct_answer,
      mark: $scope.credentials.mark
    };

    $scope.shared.mydata = testDetails;
      
    var callback = function() {
      $scope.shared.mydata.push({question: $scope.credentials.question, option_1: $scope.credentials.option_1, option_2: $scope.credentials.option_2, option_3: $scope.credentials.option_3, option_4: $scope.credentials.option_4, correct_answer: $scope.credentials.correct_answer, mark: $scope.credentials.mark});
    };

    $http({
      method: 'post',
      url: base_url + '/lecturer/test-postquestions',
      data: $data,
      header: {'Content-Type': undefined}
      }).
      success(function(data, status, headers, config) {

        if(data['success']) {

          callback();
          pinesNotifications.notify({
          
            title: 'Success',
            text: 'Test question successfully added.',
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
      error(function(data, status, headers, config) {

          $('#error').html('code: ' + status);
          $('#alert').fadeIn(1000).removeClass('hide');
      }); 
  };


  


}]);

app.factory('feeDetails', function() {
  
  var feeDetails = [];

  return feeDetails;
});

//--------------------------- LECTURER CONTROLLERS  ------------------------------------------

app.factory('testFactory', function($http, $routeParams) {

  var base_url = $("meta[name='base_url']").attr('content');
  var test_id = ($routeParams.test_id || "");

  var testFactory = {
    async: function() {
     
     var promise = $http.get(base_url + '/student/getTestResultsById/' + _config.id + '/' + test_id).then(function (response) {
        return response.data;
      });

      return promise;
    }
  };
  return testFactory;
});

app.factory('testDetails', function() {
  
  var testDetails = [];

  return testDetails;
});

app.factory('studentGrades', function() {
  
  var studentGrades = [];
  
  return studentGrades;
});

app.filter('getObjectBy', function(){
 
 return function(input, attribute) {
    if (!angular.isObject(input)) return input;

    var array = [];
    
    for(var objectKey in input) {

      if(input[objectKey].hasOwnProperty("category")) {
        if(input[objectKey].category == attribute) {
            
            array.push(input[objectKey]);
        }
      }
    }

    return array;
 }

});

app.factory('multipleChoiceDetails', function() {
  
  var multipleChoiceDetails = [];

  return multipleChoiceDetails;
});

app.factory('fillUpDetails', function() {
  
  var fillUpDetails = [];

  return fillUpDetails;
});

app.factory('essayDetails', function() {
  
  var essayDetails = [];

  return essayDetails;
});


//--------------------------- STUDENT CONTROLLERS  ------------------------------------------

app.factory('eventFactory', function() {
  
  var eventFactory = [];

  return eventFactory;
});

app.factory('examFactory', function($http, $routeParams) {

  var base_url = $("meta[name='base_url']").attr('content');
  var exam_id = ($routeParams.exam_id || "");

  var examFactory = {
    async: function() {
      // $http returns a promise, which has a then function, which also returns a promise
      var promise = $http.get(base_url + '/student/getResultsMCbyId/' + _config.id + '/' + exam_id).then(function (response) {
        // The then function here is an opportunity to modify the response
        //console.log(response);
        // The return value gets picked up by the then in the controller.
        return response.data;
      });
      // Return the promise to the controller
      return promise;
    }
  };
  return examFactory;
});

app.factory('examFactoryFillUp', function($http, $routeParams) {

  var base_url = $("meta[name='base_url']").attr('content');
  var exam_id = ($routeParams.exam_id || "");

  var examFactory = {
    async: function() {
      // $http returns a promise, which has a then function, which also returns a promise
      var promise = $http.get(base_url + '/student/getResultsFillUpById/' + _config.id + '/' + exam_id).then(function (response) {
        // The then function here is an opportunity to modify the response
        //console.log(response);
        // The return value gets picked up by the then in the controller.
        return response.data;
      });
      // Return the promise to the controller
      return promise;
    }
  };
  return examFactory;
});

app.factory('examFactoryEssay', function($http, $routeParams) {

  var base_url = $("meta[name='base_url']").attr('content');
  var exam_id = ($routeParams.exam_id || "");

  var examFactory = {
    async: function() {
      // $http returns a promise, which has a then function, which also returns a promise
      var promise = $http.get(base_url + '/student/getResultsEssayById/' + _config.id + '/' + exam_id).then(function (response) {
        // The then function here is an opportunity to modify the response
        //console.log(response);
        // The return value gets picked up by the then in the controller.
        return response.data;
      });
      // Return the promise to the controller
      return promise;
    }
  };
  return examFactory;
});


app.factory('timerFactory', function() {
  
  var timerFactory = [];

  return timerFactory;
});


app.controller('multipleChoiceController', ['$scope', '$http', 'pinesNotifications', '$location', '$routeParams', 'multipleChoiceDetails', function($scope, $http, pinesNotifications, $location, $routeParams, multipleChoiceDetails){

  $scope.credentials = {};
  var exam_id = ($routeParams.exam_id || "");
  var base_url = $("meta[name='base_url']").attr('content');


  $scope.submit = function(credentials) {

    $data = {
      exam_id: exam_id,
      question: $scope.credentials.question,
      option_1: $scope.credentials.option_1,
      option_2: $scope.credentials.option_2,
      option_3: $scope.credentials.option_3,
      option_4: $scope.credentials.option_4,
      correct_answer: $scope.credentials.correct_answer,
      mark: $scope.credentials.mark
    };

    $scope.shared.mydata = multipleChoiceDetails;
      
    var callback = function() {
      $scope.shared.mydata.push({question: $scope.credentials.question, option_1: $scope.credentials.option_1, option_2: $scope.credentials.option_2, option_3: $scope.credentials.option_3, option_4: $scope.credentials.option_4, correct_answer: $scope.credentials.correct_answer, mark: $scope.credentials.mark});
    };

    $http({
      method: 'post',
      url: base_url + '/lecturer/examination-postmultiplechoice',
      data: $data,
      header: {'Content-Type': undefined}
      }).
      success(function(data, status, headers, config) {

        if(data['success']) {

          callback();
          pinesNotifications.notify({
          
            title: 'Success',
            text: 'Examination question successfully added.',
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
      error(function(data, status, headers, config) {

          $('#error').html('code: ' + status);
          $('#alert').fadeIn(1000).removeClass('hide');
      }); 
  };

}]);

app.controller('essayController', ['$scope', '$http', 'pinesNotifications', '$location', '$routeParams', 'essayDetails', function($scope, $http, pinesNotifications, $location, $routeParams, essayDetails){

  $scope.credentials = {};
  var exam_id = ($routeParams.exam_id || "");
  var base_url = $("meta[name='base_url']").attr('content');


  $scope.submit = function(credentials) {

    $data = {
      exam_id: exam_id,
      question: $scope.credentials.question,
      mark: $scope.credentials.mark
    };

    $scope.shared.mydata = essayDetails;
      
    var callback = function() {
      $scope.shared.mydata.push({question: $scope.credentials.question, mark: $scope.credentials.mark});
    };

    $http({
      method: 'post',
      url: base_url + '/lecturer/examination-postessay',
      data: $data,
      header: {'Content-Type': undefined}
      }).
      success(function(data, status, headers, config) {

        if(data['success']) {

          callback();
          pinesNotifications.notify({
          
            title: 'Success',
            text: 'Examination question successfully added.',
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
      error(function(data, status, headers, config) {

          $('#error').html('code: ' + status);
          $('#alert').fadeIn(1000).removeClass('hide');
      }); 
  };

}]);

app.controller('fillAnswerController', ['$scope', '$http', 'pinesNotifications', '$location', '$routeParams', 'fillUpDetails', function($scope, $http, pinesNotifications, $location, $routeParams, fillUpDetails){

  $scope.credentials = {};
  var exam_id = ($routeParams.exam_id || "");
  var base_url = $("meta[name='base_url']").attr('content');


  $scope.submit = function(credentials) {

    $data = {
      exam_id: exam_id,
      question: $scope.credentials.question,
      mark: $scope.credentials.mark
    };

    $scope.shared.mydata = fillUpDetails;
      
    var callback = function() {
      $scope.shared.mydata.push({question: $scope.credentials.question, mark: $scope.credentials.mark});
    };

    $http({
      method: 'post',
      url: base_url + '/lecturer/examination-postfillup',
      data: $data,
      header: {'Content-Type': undefined}
      }).
      success(function(data, status, headers, config) {

        if(data['success']) {

          callback();
          pinesNotifications.notify({
          
            title: 'Success',
            text: 'Examination question successfully added.',
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
      error(function(data, status, headers, config) {

          $('#error').html('code: ' + status);
          $('#alert').fadeIn(1000).removeClass('hide');
      }); 
  };

}]);

app.directive("fileread", [function () {

    return {
        scope: {
            fileread: "="
        },
        link: function (scope, element, attributes) {
            element.bind("change", function (changeEvent) {
                var reader = new FileReader();
                reader.onload = function (loadEvent) {
                    scope.$apply(function () {
                        scope.fileread = loadEvent.target.result;
                    });
                }
                reader.readAsDataURL(changeEvent.target.files[0]);
            });
        }
    }
}]);

app.directive('moduleTile', function() {
    'use strict';
    return {
      restrict: 'E',
      scope: {
        item: '=data'
      },
      templateUrl: 'templates/tile-large.html',
      replace: true,
      transclude: true
    };
});

app.factory('timeFactory', function() {
  
  var time = [];
  
  return time;
});