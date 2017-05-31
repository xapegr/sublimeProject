(function () {
	//Application module
	angular.module('socialSchool').controller("UserController", ['$http', '$scope', '$window', '$cookies', 'accessService', '$filter', function ($http, $scope, $window, $cookies, accessService, $filter) {
		$scope.user = new User();
		$scope.friendsArray = new Array();

		//scope variables
		$scope.showForm = 0;
		$scope.correctUser = true;

		$scope.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
		$scope.format = $scope.formats[0];
		$scope.minBirthDate = new Date((new Date()).setDate((new Date()).getDate() - 365 * 10));

		$scope.dateOptions = {
			dateDisabled: "",
			formatYear: 'yyyy',
			maxDate: $scope.minBirthDate,
			setDate: $scope.minBirthDate,
			minDate: "",
			startingDay: 1,
			defaultDate: $scope.minBirthDate,
		};

		$scope.birthDate = {
			opened: false
		};

		$scope.openBirthDate = function () {
			$scope.birthDate.opened = true;
		};

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
				//console.log(outputData[0]);
				if (outputData[0] === true) {
					window.open("main.html", "_self");
					//User correct, mainWindow is opened.
					var user = new User();
					user.setId(outputData[1][0].id);
					user.setNickName(outputData[1][0].nick);
					user.setName(outputData[1][0].name);
					user.setSurname(outputData[1][0].surname);
					//console.log(user);
					//pongo la id en el sessionStorage
					sessionStorage.userConnected = outputData[1][0].id;//JSON.stringify(outputData[1][0])
				} else if (outputData[0] === false) {
					if (angular.isArray(outputData[1])) {
						$scope.correctUser = false;
					} else {
						alert("There has been an error in the server, try later");
					}
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
			//seeing user
			//console.log($scope.user.nickName);

			//Server conenction to verify user's data
			var promise = accessService.getData("php/controllers/MainController.php",
				true, "POST", { controllerType: 0, action: 10010, jsonData: JSON.stringify($scope.user) });

			promise.then(function (outputData) {
				//console.log(outputData);
				if (outputData[0] === true) {

					//User correct, mainWindow is opened.
					sessionStorage.userConnected = JSON.stringify(outputData[1][0]);
					alert("User registered!");

					//lanzando pues index y k se
					window.open("index.html", "_self");
				}
				else {
					if (angular.isArray(outputData[1])) {

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

		this.passRec = function () {
			//TODO t manda a una pagina a parte llamada password-recovery (puede ser una template) y aqui pones el mail que tienes,
			//se busca en la BD y te manda nombre de user y pass, sin posibilidad de cambiar.
			alert("Recovering pass");
			window.open("recover.html", "_self");
		}

		this.recover = function () {
			alert("sending email");
		}

		this.back = function () {
			window.open("index.html", "_self");
		}

		this.listFriends = function () {
			//copy
			$scope.user = angular.copy($scope.user);
			$scope.user.setId(sessionStorage.userConnected);
			//console.log("User id: "+sessionStorage.userConnected);
			//$scope.user.setId(1);

			//Server conenction to verify user's data
			var promise = accessService.getData("php/controllers/MainController.php",
				true, "POST", { controllerType: 0, action: 10080, jsonData: JSON.stringify($scope.user) });

			promise.then(function (outputData) {
				if (outputData[0] === true) {
					for (var i=0; i<outputData[1].length; i++) {
						var friendObj = new User();
						friendObj.construct(outputData[1][i].id, outputData[1][i].nickName, outputData[1][i].password,
							outputData[1][i].mail, outputData[1][i].name, outputData[1][i].surname, outputData[1][i].birthDate,
							outputData[1][i].registerDate, outputData[1][i].userType);
						$scope.friendsArray.push(friendObj);
					}
				} else {
					if (angular.isArray(outputData[1])) {

					} else {
						alert("There has been an error in the server, try later");
					}
				}
			});
		}
		
	}]);

})();
