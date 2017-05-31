function AssistEvent() {
	// Properties definition
	this.idEvent;
	this.idUser;

	// Methods definition
	this.construct = function (idEvent, idUser) {
		this.idEvent = idEvent
		this.idUser = idUser;
	}

	this.getIdEvent = function () { return this.idEvent; }
	this.getIdUser = function () { return this.idUser; }

	this.setIdEvent = function (idEvent) { this.idEvent = idEvent; }
	this.setIdUser = function (idUser) { this.idUser = idUser; }

}
