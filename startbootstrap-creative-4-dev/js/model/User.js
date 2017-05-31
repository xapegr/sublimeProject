function User() {
  // Properties definition
  this.id;
  this.nickName;
  this.password;
  this.mail;
  this.name;
  this.surname;
  this.birthDate;
  this.registerDate;
  this.userType;
  //this.image;

  // Methods definition
  this.construct = function (id, nickName, password, mail, name, surname, birthDate, registerDate, userType) {
    this.id = id;
    this.nickName = nickName;
    this.password = password;
    this.mail = mail;
    this.name = name;
    this.surname = surname;
    this.birthDate = birthDate;
    this.registerDate = registerDate;
    this.userType = userType;
    //this.image = image;
  }

  this.getId = function () { return this.id; }
  this.getNickName = function () { return this.nickName; }
  this.getPassword = function () { return this.password; }
  this.getMail = function () { return this.mail; }
  this.getName = function () { return this.name; }
  this.getSurname = function () { return this.surname; }
  this.getBirthDate = function () { return this.birthDate; }
  this.getRegisterDate = function () { return this.registerDate; }
  this.getUserType = function () { return this.userType; }
  //this.getImage = function () { return this.image; }

  this.setId = function (id) { this.id = id; }
  this.setNickName = function (nickName) { this.nickName = nickName; }
  this.setPassword = function (password) { this.password = password; }
  this.setMail = function (mail) { this.mail = mail; }
  this.setName = function (name) { this.name = name; }
  this.setSurname = function (surname) { this.surname = surname; }
  this.setBirthDate = function (birthDate) { this.birthDate = birthDate; }
  this.setRegisterDate = function (register) { this.register = register; }
  this.setUserType = function (userType) { this.userType = userType; }
  //this.setImage = function (image) { this.image = image; }

}
