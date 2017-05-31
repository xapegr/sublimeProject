//Angular code
(function () {

	angular.module('socialSchool').controller("SessionController", ['$http', '$scope', '$window', '$cookies', 'accessService', 'userConnected', function ($http, $scope, $window, $cookies, accessService, userConnected) {

		//scope variables
		//$scope.user = new User();
		$scope.userAction = 0;
		$scope.sessionOpened = false;

		this.sessionControl = function () {
			switch ($scope.userAction) {
				case 0: // index.html is executed
					// If the session is open wi will have to go to mainWindow.html
					// otherwise we will remain in the index.html

					// Server conenction to verify user's data.
					var promise = accessService.getData("php/controllers/MainController.php",
						true, "POST", { controllerType: 0, action: 10030, jsonData: '' });

					promise.then(function (outputData) {
						console.log(outputData[0]);
						if (outputData[0] === true) {
							// Login correct, mainWindow is opened.
							window.open("main.html", "_self");

						} else {
							if (angular.isArray(outputData[1])) {
								console.log(outputData);
							}
							else { alert("There has been an error in the server, try again later."); }
						}
					});

					// if (this.isSessionOpen()) {
					//      console.log("IS OPENED!");
					//      window.open("mainWindow.html", "_self");
					//}

					break;

				case 1: // mainWindow.html is executed

					// Server conenction to verify user's data.
					var promise = accessService.getData("php/controllers/MainController.php",
						true, "POST", { controllerType: 0, action: 10030, jsonData: '' });

					promise.then(function (outputData) {
						if (outputData[0] === true) {
							// Login correct, mainWindow is opened.
							$scope.sessionOpened = true;
						} else {
							if (angular.isArray(outputData[1])) {
								console.log(outputData);
								window.open("index.html", "_self");
							}
							else { alert("There has been an error in the server, try again later."); }
						}
					});

					break;
				default:
					console.log("user action incorrect: " + $scope.userAction);
					break;
			}
		}

		this.logOut = function () {
			//Local session destroy
			// Server conenction to verify user's data.
			var promise = accessService.getData("php/controllers/MainController.php",
				true, "POST", { controllerType: 0, action: 10040, jsonData: '' });

			promise.then(function (outputData) {
				if (outputData[0] === true) {
					// Logout correct, mainWindow is opened.
					$scope.sessionOpened = false;
					sessionStorage.removeItem("userConnected");
					window.open("index.html", "_self");

				}
				else {
					if (angular.isArray(outputData[1])) {
						console.log(outputData);
					}
					else { alert("There has been an error in the server, try again later."); }
				}
			});
		}
	}]);
})();
