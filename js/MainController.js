(function () {
	//Application module
	var socialSchool = angular.module('socialSchool', ['ng-currency', 'ui.bootstrap', 'ngCookies', 'angularUtils.directives.dirPagination']);

	socialSchool.factory('accessService', function ($http, $log, $q) {
		return {
			getData: function (url, async, method, params, data) {
				var deferred = $q.defer();
				$http({
					url: url,
					method: method,
					asyn: async,
					params: params,
					data: data
				})
					.success(function (response, status, headers, config) {
						deferred.resolve(response);
					})
					.error(function (msg, code) {
						deferred.reject(msg);
						$log.error(msg, code);
						alert("There has been an error in the server, try later");
					});

				return deferred.promise;
			}
		}
	});

	socialSchool.factory('userConnected', function () {
		// I know this doesn't work, but what will?
		var user = new User();
		return user;
	});


	socialSchool.directive("loginForm", function () {
		return {
			restrict: 'E',
			templateUrl: "view/templates/login-form.html",
			controller: function () {

			},
			controllerAs: 'loginForm'
		};
	});

	socialSchool.directive("registerForm", function () {
		return {
			restrict: 'E',
			templateUrl: "view/templates/register-form.html",
			controller: function () {

			},
			controllerAs: 'registerForm'
		};
	});

	socialSchool.directive("eventsPage", function () {
		return {
			restrict: 'E',
			templateUrl: "view/templates/events-page.html",
			controller: function () {

			},
			controllerAs: 'eventsPage'
		};
	});

	socialSchool.directive("chatPage", function () {
		return {
			restrict: 'E',
			templateUrl: "view/templates/chat-page.html",
			controller: function () {

			},
			controllerAs: 'chatPage'
		};
	});

	socialSchool.directive("searchPage", function () {
		return {
			restrict: 'E',
			templateUrl: "view/templates/search-page.html",
			controller: function () {

			},
			controllerAs: 'searchPage'
		};
	});

	socialSchool.directive("createEventForm", function () {
		return {
			restrict: 'E',
			templateUrl: "view/templates/create-event-form.html",
			controller: function () {

			},
			controllerAs: 'createEventForm'
		};
	});

	socialSchool.directive("createGroupForm", function () {
		return {
			restrict: 'E',
			templateUrl: "view/templates/create-group-form.html",
			controller: function () {

			},
			controllerAs: 'createGroupForm'
		};
	});

	socialSchool.directive("groupsPage", function () {
		return {
			restrict: 'E',
			templateUrl: "view/templates/groups-page.html",
			controller: function () {

			},
			controllerAs: 'groupsPage'
		};
	});

	socialSchool.directive("editEventForm", function () {
		return {
			restrict: 'E',
			templateUrl: "view/templates/edit-event-form.html",
			controller: function () {

			},
			controllerAs: 'editEventForm'
		};
	});
})();
