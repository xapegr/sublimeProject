<?php
/** User.php
 * Entity User
 * autor  Javier Bueno and Xavier Perez
 * version 2017/05
 */
 require_once "EntityInterface.php";
class User implements EntityInterface {
    private $id;
    private $nickName;
    private $password;
    private $mail;
    private $name;
    private $surname;
    private $birthDate;
    private $registerDate;
    private $userType;

    //----------Data base Values---------------------------------------
    private static $tableName = "users";
    private static $colNameId = "id";
    private static $colNameNickName = "nickname";
    private static $colNamePassword = "password";
    private static $colNameMail = "mail";
    private static $colNameName = "name";
    private static $colNameSurname = "surname";
    private static $colNameBirthDate = "birthDate";
    private static $colNameRegisterDate = "registerDate";
    private static $colNameUserType = "userType";
    //private static $colNameImage = "image";

    function __construct() {
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getSurname() {
        return $this->surname;
    }

    public function getNickName() {
        return $this->nickName;
    }

    public function getPassword() {
        return $this->password;
    }

	  public function getMail() {
        return $this->mail;
    }

    public function getBirthDate() {
        return $this->birthDate;
    }

    public function getRegisterDate() {
        return $this->registerDate;
    }

    public function getUserType(){
        return $this->userType;
    }

    /*public function getImage() {
        return $this->image;
    }*/


    //setters
    public function setId($id) {
        $this->id = $id;
    }
    public function setName($name) {
        $this->name = $name;
    }

	  public function setSurname($surname) {
        $this->surname = $surname;
    }

    public function setNickName($nickName) {
        $this->nickName = $nickName;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

	  public function setMail($mail) {
        $this->mail = $mail;
    }

    public function setBirthDate($birthDate) {
        $this->birthDate = $birthDate;
    }

    public function setRegisterDate($registerDate) {
        $this->registerDate = $registerDate;
    }

    public function setUserType($userType){
        $this->userType = $userType;
    }

    /*public function setImage($image) {
		    $this->image = $image;
    }*/

    public function getAll() {
		$data = array();
		$data["id"] = $this->id;
		$data["name"] = $this->name;
		$data["surname"] = $this->surname;
		$data["nickname"] = $this->nickName;
		$data["password"] = $this->password;
		$data["mail"] = $this->mail;
		$data["birthDate"] = $this->birthDate;
		$data["registerDate"] = $this->registerDate;
		$data["userType"] = $this->userType;
		//$data["image"] = $this->image;

		return $data;
    }

    public function setAll($id, $name, $surname, $nickName, $password, $mail, $birthDate, $registerDate,$userType ) {
  		$this->setId($id);
  		$this->setName($name);
  		$this->setSurname($surname);
  		$this->setNickName($nickName);
  		$this->setPassword($password);
  		$this->setMail($mail);
  		$this->setBirthDate($birthDate);
  		$this->setRegisterDate($registerDate);
  		$this->setUserType($userType);
  		//$this->setImage($image);
    }

    public function toString() {
        $toString = "User[id=" . $this->id . "][name=" . $this->getName(). "][surname=" . $this->getSurname() . "][password=" . $this->password . "][mail=" . $this->mail . "]";
		return $toString;

    }
}
?>
