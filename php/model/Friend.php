<?php

/** Friend.php
 * Entity Friend
 * authors Javier Bueno and Xavier Perez
 */
require_once "EntityInterface.php";

class Friend implements EntityInterface {

    private $idUser;
    private $idFriend;

    function __construct() {
        
    }

    public function getIdUser() {
        return $this->idUser;
    }

    public function getIdFriend() {
        return $this->idFriend;
    }

    //setters
    public function setIdUser($idUser) {
        $this->idUser = $idUser;
    }

    public function setIdFriend($idFriend) {
        $this->idFriend = $idFriend;
    }

    public function getAll() {
        $data = array();
        $data["idUser"] = $this->idUser;
        $data["idFriend"] = $this->idFriend;

        return $data;
    }

    public function setAll($idUser, $idFriend) {
        $this->setIdUser($idUser);
        $this->setIdFriend($idFriend);
    }

    public function toString() {
        $toString = "User[id=" . $this->idUser . "][Friend=" . $this->getIdFriend() . "]";
        return $toString;
    }

}

?>
