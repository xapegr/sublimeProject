(function () {
	//Application module
	angular.module('socialSchool').controller("GroupController", ['$http', '$scope', '$window', '$cookies', 'accessService', '$filter', function ($http, $scope, $window, $cookies, accessService, $filter) {
		//scope variables
		$scope.groupForm = 0;
		$scope.group = new Group();
		$scope.accessGroup=new Array();
		//All groups to make the search
		$scope.groupsArray;
		//Array of the groups the current user is part
		$scope.yourGroupsArray;
		//Array with the position of the group to see if you are in or out
		$scope.accessArray;
		$scope.accessc = new AccessGroup();

		//$scope.assistEvent = new AssistEvent();

		//Pagination variables
		$scope.pageSize = 2;
		$scope.currentPage = 1;

		/*
		*	This method cleans $scope.event
		*/
		this.clean = function () {
			$scope.group = new Group();
		}


		/*
		This method loads all groups from db
		*/
		this.loadGroups = function(){
			$scope.groupsArray = new Array();
			//Server conenction to verify event's data
			var promise = accessService.getData("php/controllers/MainController.php",
				true, "POST", { controllerType: 2, action: 10000, jsonData: "" });

				promise.then(function (outputData) {
					if (outputData[0] === true) {
						for(var i=0;i<outputData[1].length;i++)
						{
							var group = new Group();
							group.construct(outputData[1][i].id,outputData[1][i].name,outputData[1][i].maxMembers,outputData[1][i].fundationDate,outputData[1][i].idUser);
							$scope.groupsArray.push(group);
						}
					} else {
						if (angular.isArray(outputData[1])) {
							console.log(outputData);
						} else {
							alert("There has been an error in the server, try later");
						}
					}
				});
				console.log($scope.groupsArray);

		}

		/*
		*	The method inits the accessArray
		*/
		$scope.accessing = function ()
		{
			$scope.accessArray = [];
			//connection to init accessArray
			var promise = accessService.getData("php/controllers/MainController.php",
				true, "POST", { controllerType: 2, action: 10000, jsonData: "" });

			promise.then(function (outputData) {
				if (outputData[0] === true) {
					console.log(outputData[1]);
					for (var i = 0; i < outputData[1].length; i++) {
						var accessObj = new AccessGroup();
						accessObj.construct(outputData[1][i].id,outputData[1][i].idUser);
						//usando la sessionStorage para coget la id
						console.log("accessobj->idUser: "+accessObj.idGroup);
						if(accessObj.idUser == sessionStorage.userConnected)
						{
							//alert("itworks!" + accessObj.idGroup);
							$scope.accessArray[accessObj.idGroup] = true;

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
			//console.log("scopearray");
			//console.log($scope.accessArray);
		}

		/*
		*	This method adds a new user in DB
		*/
		this.addGroup = function () {
			//copy
			$scope.group = angular.copy($scope.group);
			$scope.group.setIdUser(sessionStorage.userConnected);
			$scope.group.setFundationDate(new Date());

			console.log($scope.group);
			//Server conenction to verify event's data
			var promise = accessService.getData("php/controllers/MainController.php",
				true, "POST", { controllerType: 2, action: 10010, jsonData: JSON.stringify($scope.group) });

			promise.then(function (outputData) {
				console.log(outputData);
				if (outputData[0] === true) {
					alert("Group added!");

				} else {
					if (angular.isArray(outputData[1])) {
						console.log(outputData);
					} else {
						alert("There has been an error in the server, try later");
					}
				}
			});
			this.loadGroups();
		}

		/*
		*	This method deletes user in DB
		*/
		this.deleteGroup = function () {
			//copy/projectJBXP
			$scope.group = angular.copy($scope.group);

			//Server conenction to verify user's data
			var promise = accessService.getData("php/controllers/MainController.php",
				true, "POST", { controllerType: 2, action: 10040, jsonData: JSON.stringify($scope.group) });

			promise.then(function (outputData) {
				if (outputData[0] === true) {
					alert("Group deleted successfully!");
					this.loadGroups();
				}
				else {
					if (angular.isArray(outputData[1])) {
						console.log(outputData);
					}
					else { alert("There has been an error in the server, try later"); }
				}
			});
		}

		this.accessToGroup = function (id) {
			console.log(id);
			console.log($scope.$parent.idUser);

			//copy
			$scope.accessGroup = angular.copy($scope.accessGroup);
			$scope.accessGroup.setIdEvent(id);
			$scope.accessGroup.setIdUser($scope.$parent.idUser);

			//Server conenction to verify event's data
			var promise = accessService.getData("php/controllers/MainController.php",
				true, "POST", { controllerType: 2, action: 10030, jsonData: JSON.stringify($scope.accessGroup) });

			promise.then(function (outputData) {
				if (outputData[0] === true) {
					console.log("assisting to the group");
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
		*	The method requests all groups that the user is part
		*/
		this.loadYourGroups = function ()
		{
			//first initiates the var accessArray
			$scope.accessing();
			$scope.yourGroupsArray = [];
			console.log("idUserCurrent: "+$scope.$parent.idUser);
			console.log("idSession: "+sessionStorage.userConnected);
			var user = sessionStorage.userConnected;
			console.log("la id de session "+user);
			//console.log("idUserCurrent: "+);
			//Server conenction to verify event's data
			var promise = accessService.getData("php/controllers/MainController.php",
				true, "POST", { controllerType: 2, action: 10000, jsonData: "" });

			promise.then(function (outputData) {
				if (outputData[0] === true) {
					for (var i = 0; i < outputData[1].length; i++) {
						var groupObj = new Group();
						groupObj.construct(outputData[1][i].id, outputData[1][i].name, outputData[1][i].maxMembers, outputData[1][i].fundationDate, outputData[1][i].idUser);
						console.log(groupObj);
						if($scope.accessArray[groupObj.id])
						{
							console.log("The group: "+groupObj.id);
							$scope.yourGroupsArray.push(groupObj);
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
			console.log($scope.yourGroupsArray);
		}


		/*
		*	The method makes the user leave the group
		*/
		$scope.unaccessToGroup = function (id)
		{
			alert("leaving");

			$scope.accessc = angular.copy($scope.accessc);
			$scope.accessc.setIdGroup(id);
			$scope.accessc.setIdUser(sessionStorage.userConnected);

			//Server conenction to verify event's data
			var promise = accessService.getData("php/controllers/MainController.php",
				true, "POST", { controllerType: 2, action: 10050, jsonData: JSON.stringify($scope.accessc) });
				//alert("changed"+$scope.assistEvent.idEvent);
			promise.then(function (outputData) {
				//console.log(outputData[1]);
				//console.log($scope.assistEvent);
				//console.log("assist anted de igualar: "+$scope.assistArray[$scope.assistEvent]);
				$scope.accessArray[$scope.accessc.idGroup] = false;
				console.log("assist despues de igualar: "+$scope.accessArray[$scope.accessc.idGroup]);
			});
			//$scope.loadEvents();
		}

	}]);

})();
