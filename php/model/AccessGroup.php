<?php

/** AccessGroup.php
 * Entity AccessGroup
 * authors Javier Bueno and Xavier Perez
 */
require_once "EntityInterface.php";

class AccessGroup implements EntityInterface {

    private $idGroup;
    private $idUser;

    function __construct() {
        
    }

    //getters
    public function getIdGroup() {
        return $this->idGroup;
    }

    public function getIdUser() {
        return $this->idUser;
    }

    //setters
    public function setIdGroup($idGroup) {
        $this->idGroup = $idGroup;
    }

    public function setIdUser($idUser) {
        $this->idUser = $idUser;
    }

    public function getAll() {
        $data = array();
        $data["idGroup"] = $this->idGroup;
        $data["idUser"] = $this->idUser;
        return $data;
    }

    /*
     *  This method set all values from the Group.
     */

    public function setAll($idGroup, $idUser) {
        $this->setIdGroup($idGroup);
        $this->setIdUser($idUser);
    }

}

?>
