<?php

/**
 * toDoClass class
 * it controls the hole server part of the application
 */
require_once "ControllerInterface.php";
require_once "../model/Event.php";
require_once "../model/persist/EventADO.php";
require_once "../model/AssistEvent.php";
require_once "../model/persist/AssistEventADO.php";

class EventControllerClass implements ControllerInterface {

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
            /* case 10000:
              $outPutData = $this->loadInitData();
              break; */
            case 10010:
                $outPutData = $this->insertEvent();
                break;
            case 10020:
                $outPutData = $this->loadEvents();
                break;
            case 10030:
                $outPutData = $this->modEvents();
                break;
            case 10040:
                $outPutData = $this->delEvents();
                break;
            case 10050:
                $outPutData = $this->findLike();
                break;
            case 10060:
                $outPutData = $this->assistEvent();
                break;
            case 10070:
                $outPutData = $this->unassistEvent();
                break;
            case 10080:
                $outPutData = $this->findAssistById();
                break;
            case 10090:
                $outPutData = $this->findEventById();
                break;
            default:
                $errors = array();
                $outPutData[0] = false;
                $errors[] = "Sorry, there has been an error. Try later";
                $outPutData[] = $errors;
                error_log("Action not correct in EventControllerClass, value: " . $this->getAction());
                break;
        }

        return $outPutData;
    }

    private function loadEvents() {
        $outPutData = array();
        $outPutData[] = true;
        $errors = array();

        $listEvents = EventADO::findAll();

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
        $eventObj = json_decode(stripslashes($this->getJsonData()));

        $event = new Event();
        $event->setAll(0, $eventObj->name, $eventObj->maxAssistants, $eventObj->date, $eventObj->idUser);
        $outPutData = array();
        $outPutData[] = true;
        $event->setId(EventADO::create($event));

        //the senetnce returns de id of the event inserted
        $outPutData[] = array($event->getAll());

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

    /*
     * 	The method finds events by name with a like sentence
     */

    private function listLike() {
        $txt = json_decode(stripslashes($this->getJsonData()));

        $outPutData = array();
        $outPutData[0] = true;
        //falta en el ADO
        $eventList = EventADO::findlikeName($txt);


        if (count($eventList) == 0) {
            $outPutData[0] = false;
            $errors[] = "No events has found";
            $outPutData[1] = $errors;
        } else {
            $eventsArray = array();

            foreach ($eventList as $event) {
                $eventsArray[] = $event->getAll();
            }
            $outPutData[1] = $eventsArray;
        }
        return $outPutData;
    }

    /*
     * 	The method adds users into the table access
     */

    private function assistEvent() {
        $assistEventObj = json_decode(stripslashes($this->getJsonData()));

        $assistEvent = new AssistEvent();
        $assistEvent->setAll($assistEventObj->idEvent, $assistEventObj->idUser);
        $outPutData = array();
        $outPutData[] = true;
        $assistEvent = AssistEventADO::create($assistEvent);

        $outPutData[] = array($assistEvent);

        return $outPutData;
    }

    /*
     * 	The method adds users into the table access
     */

    private function unassistEvent() {
        $assistEventObj = json_decode(stripslashes($this->getJsonData()));

        $assistEvent = new AssistEvent();
        $assistEvent->setAll($assistEventObj->idEvent, $assistEventObj->idUser);
        $outPutData = array();
        $outPutData[] = true;
        $assistEvent = AssistEventADO::delete($assistEvent);

        $outPutData[] = array($assistEvent);

        return $outPutData;
    }

    private function findAssistById() {
        $assistEventObj = json_decode(stripslashes($this->getJsonData()));

        $assistEvent = new AssistEvent();
        $assistEvent->setAll($assistEventObj->idEvent, $assistEventObj->idUser);

        $outPutData = array();
        $outPutData[0] = true;

        $assistEvent = AssistEventADO::findById($assistEvent);


        if ($assistEvent == null) {
            $outPutData[0] = false;
            $errors[] = "No events has found";
            $outPutData[1] = $errors;
        } else {
            $outPutData[1] = $assistEvent;
        }
        return $outPutData;
    }

    private function findEventById() {
        $eventObj = json_decode(stripslashes($this->getJsonData()));

        $event = new Event();
        $event->setId($eventObj->id);

        $outPutData = array();
        $outPutData[0] = true;

        $event = EventADO::findById($event);

        if ($event == null) {
            $outPutData[0] = false;
            $errors[] = "No events has found";
            $outPutData[1] = $errors;
        } else {
            $outPutData[1] = $event;
        }
        return $outPutData;
    }

}

?>
