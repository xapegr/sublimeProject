<?php

/** Chat.php
 * Entity Chat
 * authors Javier Bueno and Xavier Perez
 */
require_once "EntityInterface.php";

class Chat implements EntityInterface {

    private $id;
    private $fromUser;
    private $toUser;
    private $date;
    private $message;

    function __construct() {
        
    }

    //getters
    public function getId() {
        return $this->id;
    }

    public function getFromUser() {
        return $this->fromUser;
    }

    public function getToUser() {
        return $this->toUser;
    }

    public function getDate() {
        return $this->date;
    }

    public function getMessage() {
        return $this->message;
    }

    //setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setFromUser($fromUser) {
        $this->fromUser = $fromUser;
    }

    public function setToUser($toUser) {
        $this->toUser = $toUser;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    public function setMessage($message) {
        $this->message = $message;
    }

    public function getAll() {
        $data = array();
        $data["id_chat"] = $this->id;
        $data["from_user"] = $this->fromUser;
        $data["to_user"] = $this->toUser;
        $data["date"] = $this->creationDate;
        $data["message"] = $this->idMessage;

        return $data;
    }

    public function setAll($id, $fromUser, $toUser, $date, $message) {
        $this->setId($id);
        $this->setFromUser($fromUser);
        $this->setToUser($toUser);
        $this->setDate($date);
        $this->setMessage($message);
    }

}

?>
