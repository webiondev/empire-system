app.register.controller('studentMyUnits', ['$scope', '$http', 'pinesNotifications', '$location', '$routeParams', '$theme', function($scope, $http, pinesNotifications, $location, $routeParams, $theme){

  var base_url = $("meta[name='base_url']").attr('content');
  
  $scope.cut = function (value, wordwise, max, tail) {
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

  $scope.modules = [];
  $scope.credentials = {};

  $scope.$theme = $theme;
  $scope.credentials.largeTiles = [];

  $http({
    method: 'get',
    url: base_url + '/student/getmodules/' + _config.id
    }).success(function(data, status, headers, config) {

      $scope.modules = data;

      var log = [];
      angular.forEach(data, function(value, key) {
        var index = key;

        //data[key]["name"]
        var title = $scope.cut(data[key]["name"], true, 60, "...");
        $scope.credentials.largeTiles.push({title: title, titleBarInfo: '#' + (++index), text: data[key]["code"], color: 'success', classes: 'fa fa-folder-open-o', href: "/#/view-module/" + data[key]["id"]});
      }, log);

    }).error(function(data, status, headers, config) {

      $('#error').html('code: ' + status + ' unable to fetch course modules.');
      $('#alert').fadeIn(1000).removeClass('hide');
  });

}]);