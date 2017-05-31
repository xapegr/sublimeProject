<?php

/**
 * toDoClass class
 * it controls the hole server part of the application
 */
require_once "ControllerInterface.php";
require_once "../model/Group.php";
require_once "../model/persist/GroupADO.php";

class GroupControllerClass implements ControllerInterface {

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
                $outPutData = $this->listAll();
                break;
            case 10010:
                $outPutData = $this->insertGroup();
                break;
            case 10020:
                $outPutData = $this->modGroups();
                break;
            case 10030:
                $outPutData = $this->accessGroup();
                break;
            case 10040:
                $outPutData = $this->delGroups();
                break;
            case 10050:
                $outPutData = $this->unAccessGroup();
                break;
            case 10060:
                $outPutData = $this->accessing();
                break;
            default:
                $errors = array();
                $outPutData[0] = false;
                $errors[] = "Sorry, there has been an error. Try later";
                $outPutData[] = $errors;
                error_log("Action not correct in GroupControllerClass, value: " . $this->getAction());
                break;
        }

        return $outPutData;
    }

    private function listAll() {
        $outPutData = array();
        $outPutData[0] = true;

        $groupList = GroupADO::findAll();


        if (count($groupList) == 0) {
            $outPutData[0] = false;
            $errors[] = "No groups has found";
            $outPutData[1] = $errors;
        } else {
            $groupsArray = array();

            foreach ($groupList as $group) {
                $groupsArray[] = $group->getAll();
            }
            $outPutData[1] = $groupsArray;
        }
        return $outPutData;
    }

    private function insertGroup() {
			$groupObj = json_decode(stripslashes($this->getJsonData()));
        //$groupsArray = json_decode(stripslashes($this->getJsonData()));
				$group = new Group();
        //TODO coge mal la fecha
				$group->setAll(0, $groupObj->name, $groupObj->maxMembers, date("Y-m-d"), $groupObj->idUser);
        $outPutData = array();
        $outPutData[] = true;
        $groupIds = array();
				$group->setId(GroupADO::create($group));
        /*foreach ($groupsArray as $groupObj) {
            $group = new Group();
            $group->setAll(0, $groupObj->name, $groupObj->maxMembers, date("Y-m-d"), $groupObj->idUser);
            $groupIds[] = GroupADO::create($group);
        }*/
        //Once the group is created the first person who is in is the founder
        $access= new AccessGroup();
        $access->setAll($group->idUser,$group->id);
        AccessGroupADO::create($access);
        $outPutData[] = $groupIds;
        return $outPutData;
    }

    private function modGroups() {
        $groupsArray = json_decode(stripslashes($this->getJsonData()));
        $outPutData = array();
        $outPutData[] = true;
        $groupIds = array();

        foreach ($groupsArray as $groupObj) {
            $group = new Group();
            $group->setAll(0, $groupObj->name, $groupObj->maxMembers, $groupObj->fundationDate, $groupObj->idUser);

            $groupIds[] = GroupADO::update($group);
        }

        $outPutData[] = $groupIds;
        return $outPutData;
    }

    /*
     * 	The method finds groups by name with a like sentence
     */

    private function listLike() {
        $txt = json_decode(stripslashes($this->getJsonData()));

        $outPutData = array();
        $outPutData[0] = true;
        //TODO falta en el ADO
        $groupList = GroupADO::findlikeName($txt);


        if (count($groupList) == 0) {
            $outPutData[0] = false;
            $errors[] = "No groups has found";
            $outPutData[1] = $errors;
        } else {
            $groupsArray = array();

            foreach ($groupList as $group) {
                $groupsArray[] = $group->getAll();
            }
            $outPutData[1] = $groupsArray;
        }
        return $outPutData;
    }

    /*
      The method deletes a group from DB
     */

    private function delGroups() {
        $groupsArray = json_decode(stripslashes($this->getJsonData()));
        $outPutData = array();
        $outPutData[] = true;
        $groupIds = array();

        foreach ($groupsArray as $groupObj) {
            $group = new Group();
            $group->setId($groupObj->id);
            //Mirar ADO
            $groupIds[] = GroupADO::delete($group);
        }

        $outPutData[] = $groupIds;
        return $outPutData;
    }

    /*
     * 	The method adds a user into a grup from the table access
     */

    private function accessGroup() {
        $accessGroupObj = json_decode(stripslashes($this->getJsonData()));

        $accessGroup = new AccessGroup();
        $accessGroup->setAll($accessGroupObj->idGroup, $accessGroupObj->idUser);
        $outPutData = array();
        $outPutData[] = true;
        $accessGroup = AccessGroupADO::create($accessGroup);

        $outPutData[] = array($accessGroup);

        return $outPutData;
    }

    /*
     * 	The method removes a user into a grup from the table access
     */

    private function unAccessGroup() {
        $unAccessGroupObj = json_decode(stripslashes($this->getJsonData()));

        $unAccessGroup = new AccessGroup();
        $unAccessGroup->setAll($unAccessGroupObj->idGroup, $unAccessGroupObj->idUser);
        $outPutData = array();
        $outPutData[] = true;
        $unAccessGroupDao = AccessGroupADO::delete($unAccessGroup);

        $outPutData[] = array($unAccessGroupDao);

        return $outPutData;
    }

    /*
     * 	The method returns all groups
     */

    private function accessing() {
        $outPutData = array();
        $outPutData[] = true;
        $assist = AccessGroupADO::listAll($accessGroup);
        $outPutData[] = array($assist);
    }

    /*
     * The method finds all groups the user is part
     */

    private function findAccessingById() {
        $assistGroupObj = json_decode(stripslashes($this->getJsonData()));

        $assistGroup = new AccessEvent();
        $assistGroup->setAll($assistGroupObj->idEvent, $assistGroupObj->idUser);

        $outPutData = array();
        $outPutData[0] = true;

        $assistGroup = AccessGroupADO::findById($assistGroup);


        if ($assistGroup == null) {
            $outPutData[0] = false;
            $errors[] = "No events has found";
            $outPutData[1] = $errors;
        } else {
            $outPutData[1] = $assistGroup;
        }
        return $outPutData;
    }

}

?>
