angular
  .module('theme.core.services')
  .service('$theme', ['$rootScope', 'EnquireService', '$document', function($rootScope, EnquireService, $document) {
    'use strict';
    this.settings = {
      fixedHeader: true,
      headerBarHidden: true,
      leftbarCollapsed: false,
      leftbarShown: false,
      rightbarCollapsed: false,
      fullscreen: false,
      layoutHorizontal: false,
      layoutHorizontalLargeIcons: false,
      layoutBoxed: false,
      showSmallSearchBar: false,
      topNavThemeClass: 'navbar-default',
      sidebarThemeClass: 'sidebar-default',
      showChatBox: false,
      pageTransitionStyle: 'fadeIn',
      dropdownTransitionStyle: 'zoomIn'
    };

    var brandColors = {
      'default': '#ecf0f1',

      'inverse': '#95a5a6',
      'primary': '#3498db',
      'success': '#2ecc71',
      'warning': '#f1c40f',
      'danger': '#e74c3c',
      'info': '#1abcaf',

      'brown': '#c0392b',
      'indigo': '#9b59b6',
      'orange': '#e67e22',
      'midnightblue': '#34495e',
      'sky': '#82c4e6',
      'magenta': '#e73c68',
      'purple': '#e044ab',
      'green': '#16a085',
      'grape': '#7a869c',
      'toyo': '#556b8d',
      'alizarin': '#e74c3c'
    };

    this.getBrandColor = function(name) {
      if (brandColors[name]) {
        return brandColors[name];
      } else {
        return brandColors['default'];
      }
    };

    $document.ready(function() {
      EnquireService.register('screen and (max-width: 767px)', {
        match: function() {
          $rootScope.$broadcast('themeEvent:maxWidth767', true);
        },
        unmatch: function() {
          $rootScope.$broadcast('themeEvent:maxWidth767', false);
        }
      });
    });

    this.get = function(key) {
      return this.settings[key];
    };
    this.set = function(key, value) {
      this.settings[key] = value;
      $rootScope.$broadcast('themeEvent:changed', {
        key: key,
        value: this.settings[key]
      });
      $rootScope.$broadcast('themeEvent:changed:' + key, this.settings[key]);
    };
    this.values = function() {
      return this.settings;
    };

    this.AdminMenu = [
    {
      label: 'Overview',
      iconClasses: '',
      separator: true
    }, {
      label: 'Dashboard',
      iconClasses: 'glyphicon glyphicon-home',
      url: '#/'
    },
    {
      label: 'Education',
      iconClasses: 'fa fa-home',
      separator: true
    },
    {
      label: 'Students',
      iconClasses: 'glyphicon glyphicon-user',
      children: [{
        label: 'Browse Students',
        url: '#/admin-browse-users'
      }, {
        label: 'Register new student',
        url: '#/admin-student-registration'
      }]
    },
    {
      label: 'User Groups',
      iconClasses: 'glyphicon glyphicon-tasks',
      children: [{
        label: 'Browse User Groups',
        url: '#/admin-browse-groups'
      }, {
        label: 'Create new group',
        url: '#/admin-create-group'
      }]
    },
    {
      label: 'Schedule Calendar',
      iconClasses: 'glyphicon glyphicon-calendar',
      children: [{
        label: 'Create Template',
        url: '#/admin-create-template'
      }, {
        label: 'Edit Template Dates',
        url: '#/admin-edit-template'
      },{
        label: 'UserGroup Schedule',
        url: '#/user-group-schedule'
      }]
    },
    {
      label: 'Lecturers',
      iconClasses: 'glyphicon glyphicon-briefcase',
      children: [{
        label: 'Browse Lecturers',
        url: '#/admin-browse-lecturers'
      }, {
        label: 'Register new lecturer',
        url: '#/admin-lecturer-registration'
      },
      {
        label: 'Learning Materials',
        url: '#/system-modules'
      }]
    },
    {
      label: 'Courses',
      iconClasses: 'glyphicon glyphicon-book',
      children: [{
        label: 'Manage Courses',
        url: '#/manage-courses'
      },{
        label: 'Register new course',
        url: '#/register-new-course'
      }, {
        label: 'Manage Modules',
        url: '#/manage-modules'
      },{
        label: 'Register new module',
        url: '#/register-new-module'
      }]
    },

    {
      label: 'System',
      iconClasses: 'fa fa-home',
      separator: true
    }, {
      label: 'Settings',
      iconClasses: 'glyphicon glyphicon-cog',
      children: [{
        label: 'My Profile',
        url: '#/profile'
      }, {
        label: 'System Settings',
        url: '#/'
      }]
    }
  
    ];

    this.LecturerMenu = [{
      label: 'Lecturer Menu',
      iconClasses: '',
      separator: true
      }, {
      label: 'Dashboard',
      iconClasses: 'glyphicon glyphicon-home',
      url: '#/'
      },
      {
      label: 'Course Details',
      iconClasses: '',
      separator: true
      },
      {
      label: 'Course and Academic information',
      iconClasses: 'glyphicon glyphicon-list-alt',
      url: '#/course-academis-information'
      },
      {
      label: 'Announcements',
      iconClasses: 'glyphicon glyphicon-bullhorn',
      children: [{
        label: 'Create Announcement',
        url: '#/create-announcement'
      },
      {
        label: 'View Announcements',
        url: '#/view-announcements'
      }]},
      {
      label: 'Modules',
      iconClasses: 'glyphicon glyphicon-file',
      children: [{
        label: 'My Modules',
        url: '#/lecturer-modules'
      },
      {
        label: 'Students',
        url: '#/student-list'
      },
      {
        label: 'Assignments',
        url: '#/assignments-list'
      },
      {
        label: 'Learning Materials',
        url: '#/learning-materials'
      }]
      },
      {
      label: 'Tasks',
      iconClasses: 'glyphicon glyphicon-tasks ',
      children: [{
        label: 'Create a task',
        url: '#/create-task'
      },
      {
        label: 'Tasks List',
        url: '#/view-tasks'
      }]},
      {
      label: 'Consultation Hours',
      iconClasses: 'glyphicon glyphicon-calendar',
      children: [{
        label: 'Add new slot',
        url: '#/lecturer-consultations'
      },
      {
        label: 'View Consultations',
        url: '#/view-consultations'
      }]},
      {
      label: 'Tests & Examination',
      iconClasses: '',
      separator: true
      },
      {
      label: 'Examination',
      iconClasses: 'glyphicon glyphicon-book',
      children: [{
        label: 'Create Examination',
        url: '#/create-examination'
      },
      {
        label: 'View Examinations',
        url: '#/view-examinations'
      }]},
      {
      label: 'Tests',
      iconClasses: 'glyphicon glyphicon-book',
      children: [{
        label: 'Create Test',
        url: '#/create-test'
      },
      {
        label: 'View Tests',
        url: '#/view-tests'
      }]},
      {
      label: 'My Account',
      iconClasses: 'fa fa-home',
      separator: true
      }, {
      label: 'Settings',
      iconClasses: 'glyphicon glyphicon-cog',
      children: [{
        label: 'My Profile',
        url: '#/profile'
      }]
      }
      
    ];

    this.StudentMenu = [{
      label: 'Student Menu',
      iconClasses: '',
      separator: true
      }, {
      label: 'Dashboard',
      iconClasses: 'glyphicon glyphicon-home',
      url: '#/'
      },
      {
      label: 'Course Details',
      iconClasses: '',
      separator: true
      },
      {
      label: 'Course and Academic information',
      iconClasses: 'glyphicon glyphicon-list-alt',
      children: [{
        label: 'Education Oasis',
        url: '#/about'
      },{
        label: 'Course Syllabus',
        url: '#/course-syllabus'
      },
      {
        label: 'Appendix',
        url: '#/appendix'
      }]
      },
      {
      label: 'Modules',
      iconClasses: 'glyphicon glyphicon-file',
      children: [{
        label: 'My Units',
        url: '#/student-myunits'
      },{
        label: 'Assignment Submission',
        url: '#/assignment-submission'
      }]
      },
      {
      label: 'Tasks',
      iconClasses: 'glyphicon glyphicon-tasks ',
      children: [{
        label: 'My Tasks',
        url: '#/my-tasks'
      }]},
      {
      label: 'Consultation Hours',
      iconClasses: 'glyphicon glyphicon-time',
      children: [{
        label: 'Classes Schedule',
        url: '#/schedule'
      },{
        label: 'Book new consultation',
        url: '#/book-consultation'
      },{
        label: 'View Consultations Made',
        url: '#/my-consultations'
      }]
      },
      {
      label: 'Web Enrollment System',
      iconClasses: 'glyphicon glyphicon-signal',
      url: '#/student-web-enrollment'
      },
      {
      label: 'Course Fee Details',
      iconClasses: 'glyphicon glyphicon-list',
      url: '#/student-fee-statement'
      },
      {
      label: 'Tests & Examination',
      iconClasses: '',
      separator: true
      },
      {
      label: 'Examination',
      iconClasses: 'glyphicon glyphicon-book',
      url: '#/examination-modules'
      },
      {
      label: 'Tests',
      iconClasses: 'glyphicon glyphicon-book',
      url: '#/test-modules'
      },
      {
      label: 'My Account',
      iconClasses: 'fa fa-home',
      separator: true
      }, {
      label: 'Settings',
      iconClasses: 'glyphicon glyphicon-cog',
      children: [{
        label: 'My Profile',
        url: '#/profile'
      }]
    }];


  }]);