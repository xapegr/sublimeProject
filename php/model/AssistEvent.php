<?php

/** AssistEvent.php
 * Entity AssistEvent
 * authors Javier Bueno and Xavier Perez
 */
require_once "EntityInterface.php";

class AssistEvent implements EntityInterface {

    private $idEvent;
    private $idUser;

    function __construct() {
        
    }

    //getters
    public function getIdEvent() {
        return $this->idEvent;
    }

    public function getIdUser() {
        return $this->idUser;
    }

    //setters
    public function setIdEvent($idEvent) {
        $this->idEvent = $idEvent;
    }

    public function setIdUser($idUser) {
        $this->idUser = $idUser;
    }

    public function getAll() {
        $data = array();
        $data["idEvent"] = $this->idEvent;
        $data["idUser"] = $this->idUser;
        return $data;
    }

    /*
     *  This method set all values from the event.
     */

    public function setAll($idEvent, $idUser) {
        $this->setIdEvent($idEvent);
        $this->setIdUser($idUser);
    }

}

?>
