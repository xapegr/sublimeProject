function Event() {
	// Properties definition
	this.id;
	this.name;
	this.maxAssistants;
	this.date;
	this.idUser;

	// Methods definition
	this.construct = function (id, name, maxAssistants, date, idUser) {
		this.id = id;
		this.name = name;
		this.maxAssistants = maxAssistants;
		this.date = date;
		this.idUser = idUser;
	}

	this.getId = function () { return this.id; }
	this.getName = function () { return this.name; }
	this.getMaxAssistants = function () { return this.maxAssistants; }
	this.getDate = function () { return this.date; }
	this.getIdUser = function () { return this.idUser; }

	this.setId = function (id) { this.id = id; }
	this.setName = function (name) { this.name = name; }
	this.setMaxAssistants = function (maxAssistants) { this.maxAssistants = maxAssistants; }
	this.setDate = function (date) { this.date = date; }
	this.setIdUser = function (idUser) { this.idUser = idUser; }

}
