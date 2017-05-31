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

	public function doAction()
	{
		$outPutData = array();

		switch ( $this->getAction() )
		{
			case 10000:
				$outPutData = $this->loadInitData();
				break;
			case 10010:
				$outPutData = $this->insertGroup();
				break;
			case 10020:
				$outPutData = $this->loadGroups();
				break;
			case 10030:
				$outPutData = $this->modGroups();
				break;
			default:
				$errors = array();
				$outPutData[0]=false;
				$errors[]="Sorry, there has been an error. Try later";
				$outPutData[]=$errors;
				error_log("Action not correct in GroupControllerClass, value: ".$this->getAction());
				break;
		}

		return $outPutData;
	}

	private function loadGroups()
	{
		$outPutData = array();
		$outPutData[]=true;
		$errors = array();

		$listGroups = GroupADO::findAll();


		if(count($listGroups)==0)
		{
			$outPutData[0]=false;
			$errors[]="No groups found in database";
		}
		else
		{
			$groupsArray=array();

			foreach ($listGroups as $group)
			{
				$groupsArray[]=$group->getAll();
			}
		}


		if($outPutData[0])
		{
			$outPutData[]=$groupsArray;
		}
		else
		{
			$outPutData[]=$errors;
		}

		return $outPutData;
	}

	private function insertGroup () {
		$groupsArray = json_decode(stripslashes($this->getJsonData()));
		$outPutData = array();
		$outPutData[]= true;
		$groupIds = array();

		foreach ($groupsArray as $groupObj) {
			$group = new Group();
			$group->setAll($groupObj->id, $groupObj->idGroupType, $groupObj->idDirector, $groupObj->name, $groupObj->price, $groupObj->image, $groupObj->inSale, $groupObj->rented, $groupObj->reviews);
			$groupIds[] =GroupADO::create($group);
		}

		$outPutData[] = $groupIds;
		return $outPutData;
	}

	private function modGroups () {
		$groupsArray = json_decode(stripslashes($this->getJsonData()));
		$outPutData = array();
		$outPutData[]= true;
		$groupIds = array();

		foreach ($groupsArray as $groupObj) {
			$group = new Group();
			$group->setAll($groupObj->id, $groupObj->idGroupType, $groupObj->idDirector, $groupObj->name, $groupObj->price, $groupObj->image, $groupObj->inSale, $groupObj->rented, $groupObj->reviews);

			$groupIds[] =GroupADO::update($group);
		}

		$outPutData[] = $groupIds;
		return $outPutData;
	}

	//Add delete function

}
?>
