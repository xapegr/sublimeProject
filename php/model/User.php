<?php

/** User.php
 * Entity User
 * authors Javier Bueno and Xavier Perez
 */
require_once "EntityInterface.php";

class User implements EntityInterface {

    private $id;
    private $nickName;
    private $password;
    private $mail;
    private $name;
    private $surname;
    private $birthDate;
    private $registerDate;
    private $userType;

    function __construct() {
        
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getSurname() {
        return $this->surname;
    }

    public function getNickName() {
        return $this->nickName;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getMail() {
        return $this->mail;
    }

    public function getBirthDate() {
        return $this->birthDate;
    }

    public function getRegisterDate() {
        return $this->registerDate;
    }

    public function getUserType() {
        return $this->userType;
    }

    //setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setSurname($surname) {
        $this->surname = $surname;
    }

    public function setNickName($nickName) {
        $this->nickName = $nickName;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setMail($mail) {
        $this->mail = $mail;
    }

    public function setBirthDate($birthDate) {
        $this->birthDate = $birthDate;
    }

    public function setRegisterDate($registerDate) {
        $this->registerDate = $registerDate;
    }

    public function setUserType($userType) {
        $this->userType = $userType;
    }

    public function getAll() {
        $data = array();
        $data["id"] = $this->id;
        $data["name"] = $this->name;
        $data["surname"] = $this->surname;
        $data["nickName"] = $this->nickName;
        $data["password"] = $this->password;
        $data["mail"] = $this->mail;
        $data["birthDate"] = $this->birthDate;
        $data["registerDate"] = $this->registerDate;
        $data["userType"] = $this->userType;

        return $data;
    }

    public function setAll($id, $name, $surname, $nickName, $password, $mail, $birthDate, $registerDate, $userType) {
        $this->setId($id);
        $this->setName($name);
        $this->setSurname($surname);
        $this->setNickName($nickName);
        $this->setPassword($password);
        $this->setMail($mail);
        $this->setBirthDate($birthDate);
        $this->setRegisterDate($registerDate);
        $this->setUserType($userType);
    }

    public function toString() {
        $toString = "User[id=" . $this->id . "][name=" . $this->getName() . "][surname=" . $this->getSurname() . "][password=" . $this->password . "][mail=" . $this->mail . "]";
        return $toString;
    }

}

?>
