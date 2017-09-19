angular
	.module('swipeApp', [])
	.controller('swipeController', swipeController);

	function curiousController($scope){

		$scope.num = 0;

		$scope.curious = function(){

			++$scope.num;

			$scope.$apply();
		};

		$scope.notInterested = function(){

			++$scope.num;

			$scope.$apply();
		};
	}