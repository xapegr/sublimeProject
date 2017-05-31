(function () {
	//Application module
	angular.module('socialSchool').controller("EventController", ['$http', '$scope', '$window', '$cookies', 'accessService', '$filter', function ($http, $scope, $window, $cookies, accessService, $filter) {
		//scope variables
		$scope.eventForm = 0;
		$scope.event = new Event();
		$scope.eventsArray;

		$scope.assistEvent = new AssistEvent();
		$scope.assistArray;

		$scope.editEventArray;

		//Pagination variables
		$scope.pageSize = 5;
		$scope.currentPage = 1;

		$scope.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
		$scope.format = $scope.formats[0];
		$scope.minEventDate = new Date((new Date()).setDate((new Date()).getDate() + 1));

		$scope.dateOptions = {
			dateDisabled: "",
			formatYear: 'yyyy',
			maxDate: "",
			setDate: new Date(),
			minDate: $scope.minEventDate,
			startingDay: 1,
		};

		$scope.eventDate = {
			opened: false
		};

		$scope.openEventDate = function () {
			$scope.eventDate.opened = true;
		};

		/*
		*	This method cleans $scope.event
		*/
		this.clean = function () {
			$scope.event = new Event();
		}

		/**
		* Loads the last events
		**/
		$scope.loadEvents = function () {
			$scope.eventsArray = [];
			$scope.editEventArray =  [];

			//Server conenction to verify event's data
			var promise = accessService.getData("php/controllers/MainController.php",
				true, "POST", { controllerType: 1, action: 10020, jsonData: "" });

			promise.then(function (outputData) {
				if (outputData[0] === true) {
					for (var i = 0; i < outputData[1].length; i++) {
						//console.log("i es: "+i);
						var eventObj = new Event();
						eventObj.construct(outputData[1][i].id, outputData[1][i].name, outputData[1][i].maxAssistants, outputData[1][i].date, outputData[1][i].idUser);
						$scope.eventsArray.push(eventObj);

						// for each event check if user is assisting or not
						$scope.assistingEvent(outputData[1][i].id);

						if (outputData[1][i].idUser == $scope.$parent.idUser) {
							$scope.editEventArray[outputData[1][i].id] = true;
						}
					}
				} else {
					if (angular.isArray(outputData[1])) {
						console.log(outputData);
					} else {
						alert("There has been an error in the server, try later");
					}
				}
			});
		}
		this.show = function (){
			$scope.eventForm=2;
			//alert($scope.eventForm);
		}

		/*
		*	This method adds a new user in DB
		*/
		this.addEvent = function () {
			//copy
			$scope.event = angular.copy($scope.event);
			$scope.event.setIdUser($scope.$parent.idUser);

			//Server conenction to verify event's data
			var promise = accessService.getData("php/controllers/MainController.php",
				true, "POST", { controllerType: 1, action: 10010, jsonData: JSON.stringify($scope.event) });

			promise.then(function (outputData) {
				if (outputData[0] === true) {
					var eventObj = new Event();
					eventObj.construct(outputData[1][0].id, $scope.event.name, $scope.event.maxAssistants,
						$scope.event.date, $scope.event.idUser);
					$scope.eventsArray.push(eventObj);
					alert("Event added!");

					$scope.assistToEvent(outputData[1][0].id);

				} else {
					if (angular.isArray(outputData[1])) {
						console.log(outputData);
					} else {
						alert("There has been an error in the server, try later");
					}
				}
			});
		}
		/*
		*	This method modifies event in DB
		*/
		this.modifyEvent = function () {
			//copy
			$scope.event = angular.copy($scope.event);

			//Server conenction to verify user's data
			var promise = accessService.getData("php/controllers/MainController.php",
				true, "POST", { controllerType: 1, action: 10030, jsonData: JSON.stringify($scope.event) });

			promise.then(function (outputData) {
				if (outputData[0] === true) {
					//User correct, mainWindow is opened.
					//sessionStorage.userConnected = JSON.stringify(outputData[1][0]);
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
		/*this.deleteEvent = function () {
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
		}*/

		$scope.assistToEvent = function (id) {
			//copy
			$scope.assistEvent = angular.copy($scope.assistEvent);
			$scope.assistEvent.setIdEvent(id);
			$scope.assistEvent.setIdUser($scope.$parent.idUser);

			//Server conenction to verify event's data
			var promise = accessService.getData("php/controllers/MainController.php",
				true, "POST", { controllerType: 1, action: 10060, jsonData: JSON.stringify($scope.assistEvent) });
			promise.then(function (outputData) {
				//alert("changed"+$scope.assistEvent.idEvent);
				//console.log(outputData[1]);
				//console.log($scope.assistEvent);
				//console.log("assist anted de igualar: "+$scope.assistArray[$scope.assistEvent]);
				$scope.assistArray[$scope.assistEvent] = true;
				console.log("assist despues de igualar: "+$scope.assistArray[$scope.assistEvent]);


			});
			$scope.loadEvents();
		}

		/*$scope.test = function(index){
			alert("Index->"+index);
		}*/

		$scope.unassistToEvent = function (id) {
			//copy
			$scope.assistEvent = angular.copy($scope.assistEvent);
			$scope.assistEvent.setIdEvent(id);
			$scope.assistEvent.setIdUser($scope.$parent.idUser);

			//Server conenction to verify event's data
			var promise = accessService.getData("php/controllers/MainController.php",
				true, "POST", { controllerType: 1, action: 10070, jsonData: JSON.stringify($scope.assistEvent) });
				//alert("changed"+$scope.assistEvent.idEvent);
			promise.then(function (outputData) {
				//console.log(outputData[1]);
				//console.log($scope.assistEvent);
				//console.log("assist anted de igualar: "+$scope.assistArray[$scope.assistEvent]);
				//TODO aqui no iria una id???????
				$scope.assistArray[$scope.assistEvent] = false;
				console.log("assist despues de igualar: "+$scope.assistArray[$scope.assistEvent]);

			});
			$scope.loadEvents();
		}

		$scope.assistingEvent = function (id) {
			//copy
			$scope.assistArray=[];
			$scope.assistEvent = angular.copy($scope.assistEvent);

			$scope.assistEvent.setIdEvent(id);
			$scope.assistEvent.setIdUser($scope.$parent.idUser);

			var promise = accessService.getData("php/controllers/MainController.php",
				true, "POST", { controllerType: 1, action: 10080, jsonData: JSON.stringify($scope.assistEvent) });

			promise.then(function (outputData) {
				if (outputData[0] === true) {
					//console.log("Id event: "+id);
					$scope.assistArray[id] = outputData[0];
				} else {
					if (angular.isArray(outputData[1])) {
						//console.log(outputData);
					} else {
						alert("There has been an error in the server, try later");
					}
				}
			});
		}

	}]);

})();
