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

    public function doAction() {
        $outPutData = array();

        switch ($this->getAction()) {
            case 10000:
                $outPutData = $this->userConnection();
                break;
            case 10010:
                $outPutData = $this->registerUser();
                break;
            /* case 10020:
              $outPutData = $this->modifyUser();
              break; */
            case 10030:
                $outPutData = $this->sessionControl();
                break;
            case 10040:
                $outPutData = $this->sessionLogout();
                break;
            case 10050:
                $outPutData = $this->listAll();
                break;
            case 10060:
                $outPutData = $this->listLike();
                break;
            case 10070:
                $outPutData = $this->recover();
                break;
            case 10080:
                $outPutData = $this->listFriends();
                break;
            case 10090:
                $outPutData = $this->addFriends();
                break;
            /* case 10100:
              $outPutData = $this->removeFriends();
              break; */
            default:
                $errors = array();
                $outPutData[0] = false;
                $errors[] = "Sorry, there has been an error. Try later";
                $outPutData[] = $errors;
                error_log("Action not correct in UserControllerClass, value: " . $this->getAction());
                break;
        }

        return $outPutData;
    }

    /*
     * The method is used to add a user in DB all params comes from the JSON.
     */

    private function registerUser() {
        $userObj = json_decode(stripslashes($this->getJsonData()));


        $user = new User();
        //public function setAll($id, $name, $surname, $nickName,
        //$password, $mail, $birthDate, $registerDate,$userType ) {
        $user->setAll(0, $userObj->name, $userObj->surname, $userObj->nickName, $userObj->password, $userObj->mail, date($userObj->birthDate), date("Y-m-d"), 1);
        $outPutData = array();
        $outPutData[] = true;
        $user->setId(UserADO::create($user));

        //the senetnce returns de id of the user inserted
        $outPutData[] = array($user->getAll());
        //$outPutData[]= date("Y-m-d");

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
        $outPutData[0] = true;
        return $outPutData;
    }

    /*
     * 	The method modifies data from a user in DB
     * Params comes from the JSON data
     */

    private function modifyUser() {
        //Films modification
        $usersArray = json_decode(stripslashes($this->getJsonData()));
        $outPutData = array();
        $outPutData[] = true;

        foreach ($usersArray as $userObj) {
            $user = new User();
            $user->setAll($userObj->id, $userObj->name, $userObj->surname, $userObj->nickName, $userObj->password, $userObj->mail, $userObj->birthDate, $userObj->registerDate, 1);
            UserADO::update($user);
        }
        return $outPutData;
    }

    /*
     * 	The method modifies data from a user in DB
     * Params comes from the JSON data
     */

    private function deleteUser() {
        //Films modification
        $usersArray = json_decode(stripslashes($this->getJsonData()));
        $outPutData = array();
        $outPutData[] = true;

        foreach ($usersArray as $userObj) {
            $user = new User();
            $user->setId($userObj->id);
            UserADO::delete($user);
        }
        return $outPutData;
    }

    /*
     * 	The method makes a select in DB and if the user exists creates a session.
     */

    private function userConnection() {
        // $outPutData[0] --> response status
        // $outPutData[1] --> data

        $userObj = json_decode(stripslashes($this->getJsonData()));

        $outPutData = array();
        $errors = array();
        $outPutData[0] = true;

        $user = new User();
        $user->setNickName($userObj->nickName);
        $user->setPassword($userObj->password);
        //error_log(var_dump($userObj->nickName,true));
        //llega
        $userList = UserADO::findByNickAndPass($user);
        //error_log(var_dump($userList,true));

        if (count($userList) == 0) {
            $outPutData[0] = false;
            $errors[] = "No user has found with these data";
            $outPutData[1] = $errors;
        } else {
            $usersArray = array();

            foreach ($userList as $user) {
                $usersArray[] = $user->getAll();
            }

            $_SESSION['connectedUser'] = $userList[0];

            $outPutData[1] = $usersArray;
        }

        return $outPutData;
    }

    /*
     * 	The method controls if the session is started or not, if it is it shows you
     * the mainWindow else it shows the index.
     */

    private function sessionControl() {
        $outPutData = array();
        $outPutData[0] = true;

        if (isset($_SESSION['connectedUser'])) {
            $outPutData[] = $_SESSION['connectedUser']->getAll();
        } else {
            $outPutData[0] = false;
            $errors[] = "No session opened";
            $outPutData[1] = $errors;
        }

        return $outPutData;
    }

    /**
     * 	The method takes all data from users table in db
     *
     * */
    private function listAll() {
        $outPutData = array();
        $outPutData[0] = true;

        $userList = UserADO::findAll();


        if (count($userList) == 0) {
            $outPutData[0] = false;
            $errors[] = "No users has found";
            $outPutData[1] = $errors;
        } else {
            $usersArray = array();

            foreach ($userList as $user) {
                $usersArray[] = $user->getAll();
            }
            $outPutData[1] = $usersArray;
        }
        return $outPutData;
    }

    /**
     * 	The method takes all data from users table in db
     *
     * */
    private function findLike() {

        $txt = json_decode(stripslashes($this->getJsonData()));

        $outPutData = array();
        $outPutData[0] = true;

        $userList = UserADO::findlikeName($txt);


        if (count($userList) == 0) {
            $outPutData[0] = false;
            $errors[] = "No users has found";
            $outPutData[1] = $errors;
        } else {
            $usersArray = array();

            foreach ($userList as $user) {
                $usersArray[] = $user->getAll();
            }
            $outPutData[1] = $usersArray;
        }
        return $outPutData;
    }

    /**
     * 	The method sends an e-mail to the user who wants recover the password
     *
     * */
    private function recover() {
        //connection with DB to recover all user with only the e-mail
        $email = json_decode(stripslashes($this->getJsonData()));
        $userToSend;
        $userList = UserADO::findByEmail($email);
        if ($userList != 0) {
            $usersArray = array();

            foreach ($userList as $user) {
                $usersArray[] = $user->getAll();
            }
            $userToSend = $usersArray[0];
        }

        $msg = "Dear $userToSend->nickName you requested the password of yor account, here we have send to you:\n\n";
        $msg .= "User: $userToSend->nickName\nPassword: $userToSend->password\n\n";
        $msg .= "To serve yourself, Social School";

        $msg = wordwrap($msg, 300);

        mail($userToSend->mail, "Social School", $msg);
    }

    private function listFriends() {
        $userObj = json_decode(stripslashes($this->getJsonData()));

        $user = new User();
        $user->setId($userObj->id);

        $outPutData = array();
        $outPutData[0] = true;

        $userList = UserADO::findFriendsById($user);

        if (count($userList) == 0) {
            $outPutData[0] = false;
            $errors[] = "No users has found";
            $outPutData[1] = $errors;
        } else {
            $usersArray = array();

            foreach ($userList as $user) {
                $usersArray[] = $user->getAll();
            }
            $outPutData[1] = $usersArray;
        }
        return $outPutData;
    }

    /*
     * The method is used to add a friend in the DB.
     */

    private function addFriend() {
        $userObj = json_decode(stripslashes($this->getJsonData()));


        $friend = new Friend();
        //public function setAll($id, $name, $surname, $nickName,
        //$password, $mail, $birthDate, $registerDate,$userType ) {
        $friend->setAll($userObj->idUser, $userObj->idFriend);
        $outPutData = array();
        $outPutData[] = true;
        $friend->setId(FriendADO::create($friend));

        //the senetnce returns de id of the user inserted
        $outPutData[] = array($friend->getAll());
        //$outPutData[]= date("Y-m-d");

        return $outPutData;
    }

}

?>
