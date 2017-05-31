(function () {
	//Application module
	angular.module('socialSchool').controller("UserController", ['$http', '$scope', '$window', '$cookies', 'accessService', '$filter', function ($http, $scope, $window, $cookies, accessService, $filter) {
		$scope.user = new User();

		//scope variables
		$scope.showForm = 0;
		//Pagination variables
		$scope.pageSize = 4;
		$scope.currentPage = 1;

		/*
		*	This method is used to make the login in the app.
		*/
		this.connection = function () {
			//copy
			$scope.user = angular.copy($scope.user);

			//Server conenction to verify user's data
			var promise = accessService.getData("php/controllers/MainController.php",
				true, "POST", { controllerType: 0, action: 10000, jsonData: JSON.stringify($scope.user) });

			promise.then(function (outputData) {
				console.log(outputData[0]);
				if (outputData[0] === true) {
					//que pasa??
					alert("estamos dentro");
					window.open("main.html", "_self");
					//User correct, mainWindow is opened.
					sessionStorage.userConnected = JSON.stringify(outputData[1][0]);
					//console.log("adsds");
					//window.open("mainWindow.html", "_self");
				} else if (outputData[0] === false) {
					if (angular.isArray(outputData[1])) {
						console.log(outputData);
					}
					else { alert("There has been an error in the server, try later"); }
				}
			});
		}
		/*
		*	This method cleans $scope.user
		*/
		this.clean = function () {
			$scope.user = new User();
		}

		/*
		*	This method adds a new user in DB
		*/
		this.addUser = function () {
			//copy
			$scope.user = angular.copy($scope.user);

			//Server conenction to verify user's data
			var promise = accessService.getData("php/controllers/MainController.php",
				true, "POST", { controllerType: 0, action: 10010, jsonData: JSON.stringify($scope.user) });

			promise.then(function (outputData) {
				if (outputData[0] === true) {
					//User correct, mainWindow is opened.
					sessionStorage.userConnected = JSON.stringify(outputData[1][0]);
					//TODO aqui añadir llamar a session controller y crear session para el user acabado de registrar
					//TODO mejor se hace un reload de index y atpc.

					//lanzando pues index y k se
					window.open("index.html", "_self");
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
		this.modifyUser = function () {
			//copy
			$scope.user = angular.copy($scope.user);

			//Server conenction to verify user's data
			var promise = accessService.getData("php/controllers/MainController.php",
				true, "POST", { controllerType: 0, action: 10020, jsonData: JSON.stringify($scope.user) });

			promise.then(function (outputData) {
				if (outputData[0] === true) {
					//User correct, mainWindow is opened.
					sessionStorage.userConnected = JSON.stringify(outputData[1][0]);
					//TODO actualizar la info del user modificado
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
		this.deleteUser = function () {
			//copy
			$scope.user = angular.copy($scope.user);

			//Server conenction to verify user's data
			var promise = accessService.getData("php/controllers/MainController.php",
				true, "POST", { controllerType: 0, action: 10020, jsonData: JSON.stringify($scope.user) });

			promise.then(function (outputData) {
				if (outputData[0] === true) {
					//User correct, mainWindow is opened.
					sessionStorage.userConnected = JSON.stringify(outputData[1][0]);
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

		this.passRec = function ()
		{
			//TODO t manda a una pagina a parte llamada password-recovery (puede ser una template) y aqui pones el mail que tienes,
			//se busca en la BD y te manda nombre de user y pass, sin posibilidad de cambiar.
			alert("Recovering pass");
		}

	}]);

})();
