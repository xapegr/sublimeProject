function Chat() {
    //Properties
    this.id;
    this.fromUser;
    this.toUser;
    this.date;
    this.message;

    // Methods definition
    this.construct = function (id, fromUser, toUser, date, message) {
        this.id = id;
        this.fromUser = fromUser;
        this.toUser = toUser;
        this.date = date;
        this.message = message;
    }

    this.getId = function () { return this.id; }
    this.getFromUser = function () { return this.fromUser }
    this.getToUser = function () { return this.toUser }
    this.getDate = function () { return this.date; }
    this.getMessage = function () { return this.message; }

    this.setId = function (id) { this.id = id; }
    this.setFromUser = function (fromUser) { this.fromUser = fromUser; }
    this.setToUser = function (toUser) { this.toUser = toUser; }
    this.setDate = function (date) { this.date = date; }
    this.setMessage = function (message) { this.message = message; }

}
