(function () {
	//Application module
	angular.module('socialSchool').controller("SearchController", ['$http', '$scope', '$window', '$cookies', 'accessService', '$filter', function ($http, $scope, $window, $cookies, accessService, $filter) {
    //scope variables
    $scope.pageSize = 4;
		$scope.currentPage = 1;

    //Arrays to get data to show
    $scope.eventsArray;
    $scope.usersArray;
    $scope.groupsArray;

		//vars in filter
		$scope.whatSearch = 0;
		//filteredData
		$scope.filteredData = new Array();
		//Pagination variables
		$scope.pageSize = 2;
		$scope.currentPage = 1;


		/**
		* Loads all data you can search
		**/
		this.load = function () {
			//Server conenction to verify event's data
			//alert("loading! whatSearch "+$scope.whatSearch);
			$scope.filteredData = new Array();

      //users
			if($scope.whatSearch == 0)
			{
			var promise = accessService.getData("php/controllers/MainController.php",
				true, "POST", { controllerType: 0, action: 10050, jsonData: "" });

			promise.then(function (outputData) {
				//console.log(outputData);
				if (outputData[0] === true) {
					//JSON.stringify(outputData[1][i]);
					for (var i = 0; i < outputData[1].length; i++) {
						var userObj = new User();
						userObj.construct(outputData[1][i].id,outputData[1][i].nickName,"",outputData[1][i].mail,outputData[1][i].name,outputData[1][i].surname,outputData[1][i].birthDate,outputData[1][i].registerDate,outputData[1][i].userType);
					  $scope.filteredData.push( userObj );
					}
				}
				else {
					if (angular.isArray(outputData[1])) {
						console.log(outputData);
					}
					else { alert("There has been an error in the server, try later"); }
				}
			});
			}

      //events
			if($scope.whatSearch==1)
			{
      promise = accessService.getData("php/controllers/MainController.php",
				true, "POST", { controllerType: 1, action: 10020, jsonData: "" });

			promise.then(function (outputData) {
				if (outputData[0] === true) {
					for (var i = 0; i < outputData[1].length; i++) {
						var eventObj = new Event();
						eventObj.construct(outputData[1][i].id,outputData[1][i].name,outputData[1][i].maxAssistants,outputData[1][i].date,outputData[1][i].idUser);
					  $scope.filteredData.push( eventObj );
					}

				}
				else {
					if (angular.isArray(outputData[1])) {
						console.log(outputData);
					}
					else { alert("There has been an error in the server, try later"); }
				}
			});
			}

      //grous
			if($scope.whatSearch==2)
			{
      promise = accessService.getData("php/controllers/MainController.php",
				true, "POST", { controllerType: 2, action: 10000, jsonData: "" });

			promise.then(function (outputData) {
				//console.log(outputData);
				if (outputData[0] === true) {
					for (var i = 0; i < outputData[1].length; i++) {
						var groupObj = new Group();
						groupObj.construct(outputData[1][i].id,outputData[1][i].name,outputData[1][i].maxMembers,outputData[1][i].fundationDate,outputData[1][i].idUser);
					  $scope.filteredData.push( groupObj );
					}

				}
				else {
					if (angular.isArray(outputData[1])) {
						console.log(outputData);
					}
					else { alert("There has been an error in the server, try later"); }
				}
			});
			}
			//console.log($scope.whatSearch);
			//console.log($scope.filteredData);
		}//end load

		/*
		*	This method finds data like the text passed
		*/
    this.findLike = function (txt) {
      //users
			var promise = accessService.getData("php/controllers/MainController.php",
				true, "POST", { controllerType: 0, action: 10050, jsonData: JSON.stringify(txt) });

			promise.then(function (outputData) {
				if (outputData[0] === true) {
					for (var i = 0; i < outputData[1].length; i++) {
					  $scope.usersArray.push( JSON.stringify(outputData[1][i]) );
					}

				}
				else {
					if (angular.isArray(outputData[1])) {
						console.log(outputData);
					}
					else { alert("There has been an error in the server, try later"); }
				}
			});

      //events
      promise = accessService.getData("php/controllers/MainController.php",
				true, "POST", { controllerType: 1, action: 10020, jsonData: JSON.stringify(txt) });

			promise.then(function (outputData) {
				if (outputData[0] === true) {
					for (var i = 0; i < outputData[1].length; i++) {
					  $scope.usersArray.push( JSON.stringify(outputData[1][i]) );
					}

				}
				else {
					if (angular.isArray(outputData[1])) {
						console.log(outputData);
					}
					else { alert("There has been an error in the server, try later"); }
				}
			});

      //grous
      promise = accessService.getData("php/controllers/MainController.php",
				true, "POST", { controllerType: 2, action: 10000, jsonData: JSON.stringify(txt) });

			promise.then(function (outputData) {
				if (outputData[0] === true) {
					for (var i = 0; i < outputData[1].length; i++) {
					  $scope.usersArray.push( JSON.stringify(outputData[1][i]) );
					}

				}
				else {
					if (angular.isArray(outputData[1])) {
						console.log(outputData);
					}
					else { alert("There has been an error in the server, try later"); }
				}
			});

		}

		this.addFriend = function (index)
		{
			alert("Adding friend!");
		}
	}]);

})();
