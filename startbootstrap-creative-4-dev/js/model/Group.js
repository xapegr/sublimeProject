function Group() {
	// Properties definition
	this.id;
	this.name;
	this.maxMembers;
	this.fundationDate;
	this.idUser;
	this.idChat;

	// Methods definition
	this.construct = function (id, name, maxMembers, fundationDate, idUser, idChat) {
		this.id = id;
		this.name = name;
		this.maxMembers = maxMembers;
		this.fundationDate = fundationDate;
		this.idUser = idUser;
		this.idChat = idChat;
	}

	this.getId = function () { return this.id; }
	this.getName = function () { return this.name; }
	this.getMaxMembers = function () { return this.maxMembers; }
	this.getFundationDate = function () { return this.fundationDate; }
	this.getIdUser = function () { return this.idUser; }
	this.getIdChat = function () { return this.idChat; }

	this.setId = function (id) { this.id = id; }
	this.setName = function (name) { this.name = name; }
	this.setMaxMembers = function (maxMembers) { this.maxMembers = maxMembers; }
	this.setFundationDate = function (fundationDate) { this.fundationDate = fundationDate; }
	this.setIdUser = function (idUser) { this.idUser = idUser; }
	this.setIdChat = function (idChat) { this.idChat = idChat; }

}
