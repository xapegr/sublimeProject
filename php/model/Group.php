<?php

/** directorClass.php
 * Entity directorClass
 * authors Javier Bueno and Xavier Perez
 */
require_once "EntityInterface.php";

class Group implements EntityInterface {

    private $id;
    private $name;
    private $maxMembers;
    private $fundationDate;
    private $idUser;

    /* private $idChat; */

    function __construct() {
        
    }

    //getters

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getMaxMembers() {
        return $this->maxMembers;
    }

    public function getFundationDate() {
        return $this->date;
    }

    public function getIdUser() {
        return $this->idUser;
    }

    /* public function getIdChat() {
      return $this->idChat;
      } */

    //setters

    public function setId($id) {
        $this->id = $id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setMaxMembers($maxMembers) {
        $this->maxMembers = $maxMembers;
    }

    public function setFundationDate($date) {
        $this->fundationDate = $date;
    }

    public function setIdUser($idUser) {
        $this->idUser = $idUser;
    }

    /* public function setIdChat($idChat) {
      $this->idUser = $idUser;
      } */

    public function getAll() {
        $data = array();
        $data["id"] = $this->id;
        $data["idUser"] = $this->idUser;
        $data["name"] = $this->name;
        $data["maxMembers"] = $this->maxMembers;
        $data["fundationDate"] = $this->fundationDate;
        //$data["idChat"] = $this->idChat;
        return $data;
    }

    /*
     *  This method set all values from the group.
     */

    public function setAll($id, $name, $maxMembers, $date, $idUser, $idChat) {
        $this->setId($id);

        $this->setName($name);
        $this->setMaxMembers($maxMembers);
        $this->setFundationDate($date);
        $this->setIdUser($idUser);
        //$this->setIdChat($idChat);
    }

    public function toString() {
        $toString = "Review[id=" . $this->id . "][name=" . $this->name . "][idUser=" . $this->idUser . "][maxMembers=" . $this->maxMembers . "][fundationDate=" . $this->fundationDate . "]";
        return $toString;
    }

}

?>
