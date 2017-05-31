<?php

/**
 * toDoClass class
 * it controls the hole server part of the application
 */
require_once "ControllerInterface.php";
require_once "../model/Chat.php";
require_once "../model/persist/ChatADO.php";

class ChatControllerClass implements ControllerInterface {

    private $action;
    private $jsonData;

    function __construct($action, $jsonData) {
        $this->setAction($action);
        $this->setJsonData($jsonData);
    }

    public function getAction() {
        return $this->action;
    }

    public function getJsonData() {
        return $this->jsonData;
    }

    public function setAction($action) {
        $this->action = $action;
    }

    public function setJsonData($jsonData) {
        $this->jsonData = $jsonData;
    }

    public function doAction() {
        $outPutData = array();

        switch ($this->getAction()) {
            case 10000:
                $outPutData = $this->loadMessages();
                break;
            case 10010:
                $outPutData = $this->insertMessage();
                break;
            default:
                $errors = array();
                $outPutData[0] = false;
                $errors[] = "Sorry, there has been an error. Try later";
                $outPutData[] = $errors;
                error_log("Action not correct in ChatControllerClass, value: " . $this->getAction());
                break;
        }

        return $outPutData;
    }

    private function loadMessages() {
        $outPutData = array();
        $outPutData[] = true;
        $errors = array();

        $listChats = ChatADO::findByIds();


        if (count($listEvents) == 0) {
            $outPutData[0] = false;
            $errors[] = "No events found in database";
        } else {
            $eventsArray = array();

            foreach ($listEvents as $event) {
                $eventsArray[] = $event->getAll();
            }
        }


        if ($outPutData[0]) {
            $outPutData[] = $eventsArray;
        } else {
            $outPutData[] = $errors;
        }

        return $outPutData;
    }

    private function insertEvent() {
        $eventsArray = json_decode(stripslashes($this->getJsonData()));
        $outPutData = array();
        $outPutData[] = true;
        $eventIds = array();

        foreach ($eventsArray as $eventObj) {
            $event = new Event();
            $event->setAll($eventObj->id, $eventObj->idEventType, $eventObj->idDirector, $eventObj->name, $eventObj->price, $eventObj->image, $eventObj->inSale, $eventObj->rented, $eventObj->reviews);
            $eventIds[] = EventADO::create($event);
        }

        $outPutData[] = $eventIds;
        return $outPutData;
    }

    private function modEvents() {
        $eventsArray = json_decode(stripslashes($this->getJsonData()));
        $outPutData = array();
        $outPutData[] = true;
        $eventIds = array();

        foreach ($eventsArray as $eventObj) {
            $event = new Event();
            $event->setAll($eventObj->id, $eventObj->idEventType, $eventObj->idDirector, $eventObj->name, $eventObj->price, $eventObj->image, $eventObj->inSale, $eventObj->rented, $eventObj->reviews);

            $eventIds[] = EventADO::update($event);
        }

        $outPutData[] = $eventIds;
        return $outPutData;
    }

    //add delete function
    private function delEvents() {
        $eventsArray = json_decode(stripslashes($this->getJsonData()));
        $outPutData = array();
        $outPutData[] = true;
        $eventIds = array();

        foreach ($eventsArray as $eventObj) {
            $event = new Event();
            $event->setId($eventObj->id);
            //$event->setAll($eventObj->id, $eventObj->idEventType, $eventObj->idDirector, $eventObj->name, $eventObj->price, $eventObj->image, $eventObj->inSale, $eventObj->rented, $eventObj->reviews);

            $eventIds[] = EventADO::delete($event);
        }

        $outPutData[] = $eventIds;
        return $outPutData;
    }

}

?>
