function AccessGroup() {
	// Properties definition
	this.idGroup;
	this.idUser;

	// Methods definition
	this.construct = function (idGroup, idUser) {
		this.idGroup = idGroup
		this.idUser = idUser;
	}

	this.getIdGroup = function () { return this.idGroup; }
	this.getIdUser = function () { return this.idUser; }

	this.setIdGroup = function (idGroup) { this.idGroup = idGroup; }
	this.setIdUser = function (idUser) { this.idUser = idUser; }

}
