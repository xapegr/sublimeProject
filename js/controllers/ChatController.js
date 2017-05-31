(function () {
	//Application module
	angular.module('socialSchool').controller("ChatController", ['$http', '$scope', '$window', '$cookies', 'accessService', '$filter', function ($http, $scope, $window, $cookies, accessService, $filter) {
		$scope.chat = new Chat();
		$scope.chatsArray;

		$scope.showChat = 0;
		
		this.loadMessages = function (idFriend) {
			$scope.chatsArray = [];

			//copy
			$scope.chat = angular.copy($scope.chat);
			$scope.chat.setFromUser(sessionStorage.userConnected);
			$scope.chat.setToUser(idFriend);

			//Server conenction to verify chat's data
			var promise = accessService.getData("php/controllers/MainController.php",
				true, "POST", { controllerType: 3, action: 10000, jsonData: JSON.stringify($scope.chat) });

			promise.then(function (outputData) {
				if (outputData[0] === true) {
					for (var i = 0; i < outputData[1].length; i++) {
						var chatObj = new Chat();
						chatObj.construct(outputData[1][i].id, outputData[1][i].fromUser, outputData[1][i].toUser, outputData[1][i].date, outputData[1][i].message);
						$scope.chatsArray.push(chatObj);
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

		/*
		*	This method adds a new message in DB
		*/
		this.addMessage = function () {
			//copy
			$scope.chat = angular.copy($scope.chat);
			//seeing user
			console.log($scope.user.nickName);

			//Server conenction to verify user's data
			var promise = accessService.getData("php/controllers/MainController.php",
				true, "POST", { controllerType: 3, action: 10010, jsonData: JSON.stringify($scope.user) });

			promise.then(function (outputData) {
				console.log(outputData);
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
	}]);

})();
