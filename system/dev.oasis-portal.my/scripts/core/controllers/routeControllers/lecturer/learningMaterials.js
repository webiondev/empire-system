app.register.controller('learningMaterials', ['$scope', '$http', 'pinesNotifications', '$location', '$routeParams', '$route', '$modal', '$theme', function($scope, $http, pinesNotifications, $location, $routeParams, $route, $modal, $theme){

  var base_url = $("meta[name='base_url']").attr('content');
  $scope.credentials = {};

  $scope.$theme = $theme;
  $scope.credentials.largeTiles = [];

  $http({
    method: 'get',
    url: base_url + '/lecturer/getmodules/' + _config.id
    }).success(function(data, status, headers, config) {

      $scope.modules = data;

      var log = [];
      angular.forEach(data, function(value, key) {
        var index = key;
        $scope.credentials.largeTiles.push({title: data[key]["name"], titleBarInfo: '#' + (++index), text: data[key]["code"], color: 'success', classes: 'fa fa-folder-open-o', href: "/#/lecturer-materials/" + data[key]["id"]});
      }, log);

    }).error(function(data, status, headers, config) {

      $('#error').html('code: ' + status + ' unable to fetch course modules.');
      $('#alert').fadeIn(1000).removeClass('hide');
  });


    

    

}]);