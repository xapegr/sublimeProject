(function () {
	//Application module
	angular.module('socialSchool').controller("EventController", ['$http', '$scope', '$window', '$cookies', 'accessService', '$filter', function ($http, $scope, $window, $cookies, accessService, $filter) {
		//scope variables
		$scope.showEvnt = 0;
		//Pagination variables
		$scope.pageSize = 4;
		$scope.currentPage = 1;
		$scope.event;
		/*
		*	This method cleans $scope.event
		*/
		this.clean = function () {
			$scope.event = new Event();
		}

		/**
		* Loads the last events
		**/
		this.initData = function () {
			//Server conenction to verify event's data
			var promise = accessService.getData("php/controllers/MainController.php",
				true, "POST", { controllerType: 1, action: 10000, jsonData: JSON.stringify($scope.user) });

			promise.then(function (outputData) {
				if (outputData[0] === true) {
					//User correct, mainWindow is opened.
					sessionStorage.userConnected = JSON.stringify(outputData[1][0]);
					//Te manda a eventos (caution scope vars)
					window.open("mainWindow.html", "_self");
				}
				else {
					if (angular.isArray(outputData[1])) {
						console.log(outputData);
					}
					else { alert("There has been an error in the server, try later"); }
				}
			});
		}

		/*
		*	This method adds a new user in DB
		*/
		this.addEvent = function () {
			//copy
			$scope.event = angular.copy($scope.event);

			//Server conenction to verify event's data
			var promise = accessService.getData("php/controllers/MainController.php",
				true, "POST", { controllerType: 1, action: 10010, jsonData: JSON.stringify($scope.user) });

			promise.then(function (outputData) {
				if (outputData[0] === true) {
					//User correct, mainWindow is opened.
					sessionStorage.userConnected = JSON.stringify(outputData[1][0]);
					//window.open("mainWindow.html", "_self");
					alert("Event added!");
					//updateData();
				}
				else {
					if (angular.isArray(outputData[1])) {
						console.log(outputData);
					}
					else { alert("There has been an error in the server, try later"); }
				}
			});
		}

		/*
		*	This method modifies user in DB
		*/
		this.modifyEvent = function () {
			//copy
			$scope.user = angular.copy($scope.user);

			//Server conenction to verify user's data
			var promise = accessService.getData("php/controllers/MainController.php",
				true, "POST", { controllerType: 1, action: 10030, jsonData: JSON.stringify($scope.user) });

			promise.then(function (outputData) {
				if (outputData[0] === true) {
					//User correct, mainWindow is opened.
					sessionStorage.userConnected = JSON.stringify(outputData[1][0]);
					alert("Event modified successfully!");
					//actualizar los eventos del calendario
					//updateData();
					//window.open("mainWindow.html", "_self");
				}
				else {
					if (angular.isArray(outputData[1])) {
						console.log(outputData);
					}
					else { alert("There has been an error in the server, try later"); }
				}
			});
		}

		/*
		*	This method deletes user in DB
		*/
		this.deleteEvent = function () {
			//copy
			$scope.user = angular.copy($scope.user);

			//Server conenction to verify user's data
			var promise = accessService.getData("php/controllers/MainController.php",
				true, "POST", { controllerType: 1, action: 10040, jsonData: JSON.stringify($scope.user) });

			promise.then(function (outputData) {
				if (outputData[0] === true) {
					//User correct, mainWindow is opened.
					sessionStorage.userConnected = JSON.stringify(outputData[1][0]);
					alert("Event deleted successfully!");
					//actualizar los eventos del calendario

					//updateData();

					//window.open("mainWindow.html", "_self");
				}
				else {
					if (angular.isArray(outputData[1])) {
						console.log(outputData);
					}
					else { alert("There has been an error in the server, try later"); }
				}
			});
		}

	}]);

})();
