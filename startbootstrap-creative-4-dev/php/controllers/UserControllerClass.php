<?php
/**
 * toDoClass class
 * it controls the hole server part of the application
*/
require_once "ControllerInterface.php";
require_once "../model/User.php";
require_once "../model/persist/UserADO.php";


class UserControllerClass implements ControllerInterface {
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
				$outPutData = $this->userConnection();
				break;
			case 10010:
				$outPutData = $this->registerUser();
				break;
			/*case 10020:
				$outPutData = $this->modifyUser();
				break;
			case 10050:
				$outPutData = $this->modifyUser();
				break;*/
			case 10030:
				$outPutData = $this->sessionControl();
				break;
			case 10040:
        $outPutData = $this->sessionLogout();
				break;
			default:
				$errors = array();
				$outPutData[0]= false;
				$errors[]= "Sorry, there has been an error. Try later";
				$outPutData[]= $errors;
				error_log("Action not correct in UserControllerClass, value: ".$this->getAction());
				break;
		}

		return $outPutData;
	}


	/*
	* The method is used to add a user in DB all params comes from the JSON.
	*/
	private function registerUser()
	{
		$userObj = json_decode(stripslashes($this->getJsonData()));

		$user = new User();
		$user->setAll(0, $userObj->name, $userObj->surname1, $userObj->nick, $userObj->password, $userObj->address, $userObj->telephone, $userObj->mail, $userObj->birthDate, date("Y-m-d h:i:sa"), "0000-00-00", $userObj->active, $userObj->image);

		$outPutData = array();
		$outPutData[]= true;
		$user->setId(UserADO::create($user));

		//the senetnce returns de id of the user inserted
		$outPutData[]= array($user->getAll());

		return $outPutData;
	}


	/*
	* This method makes a logout from the session, destroys it
	*/
  private function sessionLogout() {
    $outPutData = array();
    //Closing session
    session_unset();
    session_destroy();
    $outPutData[0]=true;
    return $outPutData;
  }


	/*
	*	The method modifies data from a user in DB
	* Params comes from the JSON data
	*/
	private function modifyUser()
	{
		//Films modification
		$usersArray = json_decode(stripslashes($this->getJsonData()));
		$outPutData = array();
		$outPutData[]= true;

		foreach($usersArray as $userObj)
		{
		    $user = new User();
			$user->setAll($userObj->id, $userObj->name, $userObj->surname1, $userObj->nick, $userObj->password, $userObj->address, $userObj->telephone, $userObj->mail, $userObj->birthDate, $userObj->entryDate, $userObj->dropOutDate, $userObj->active, $userObj->image);
		    UserADO::update($user);
		}
		return $outPutData;
	}

	/*
	*	The method modifies data from a user in DB
	* Params comes from the JSON data
	*/
	private function deleteUser()
	{
		//Films modification
		$usersArray = json_decode(stripslashes($this->getJsonData()));
		$outPutData = array();
		$outPutData[]= true;

		foreach($usersArray as $userObj)
		{
		    $user = new User();
			$user->setId($userObj->id);
		    UserADO::delete($user);
		}
		return $outPutData;
	}


	/*
	*	The method makes a select in DB and if the user exists creates a session.
	*/
	private function userConnection()
	{
    // $outPutData[0] --> response status
    // $outPutData[1] --> data

		$userObj = json_decode(stripslashes($this->getJsonData()));

		$outPutData = array();
		$errors = array();
		$outPutData[0]=true;

		$user = new User();
		$user->setNickName($userObj->nickName);
		$user->setPassword($userObj->password);
		//error_log(var_dump($userObj->nickName,true));
		//llega
		$userList = UserADO::findByNickAndPass($user);
		//error_log(var_dump($userList,true));

		if (count($userList)==0)
		{
			$outPutData[0]=false;
			$errors[]="No user has found with these data";
			$outPutData[1]=$errors;
		}
		else
		{
			$usersArray=array();

			foreach ($userList as $user)
			{
				$usersArray[]=$user->getAll();
			}

			$_SESSION['connectedUser'] = $userList[0];

			$outPutData[1]=$usersArray;
		}

		return $outPutData;
	}

	/*
	*	The method controls if the session is started or not, if it is it shows you
	* the mainWindow else it shows the index.
	*/
	private function sessionControl()
	{
		$outPutData = array();
		$outPutData[0]= true;

		if(isset($_SESSION['connectedUser']))
		{
			$outPutData[]=$_SESSION['connectedUser']->getAll();
		}
		else
		{
			$outPutData[0]=false;
			$errors[]="No session opened";
			$outPutData[1]=$errors;
		}

		return 	$outPutData;
	}
}

//TODO loadUsers-> lista todos los usuarios existentes
//deleteUsers-> borra un usuario pasado por id
?>
