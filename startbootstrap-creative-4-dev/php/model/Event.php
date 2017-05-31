<?php
/** directorClass.php
* Entity directorClass
* autor  Roberto Plana
* version 2012/09
*/
require_once "EntityInterface.php";

class Event implements EntityInterface {
   private $id;
   private $name;
   private $maxAssistants;
   private $date;
   private $idUser;


   function __construct() {
   }

   //getters

   public function getId() {
       return $this->id;
   }

   public function getName() {
       return $this->name;
   }

   public function getMaxAssistants() {
       return $this->maxAssistants;
   }


   public function getDate() {
       return $this->date;
   }

   public function getIdUser() {
       return $this->idUser;
   }

   //setters

   public function setId($id) {
       $this->id = $id;
   }

   public function setName($name) {
       $this->name = $name;
   }

   public function setMaxAssistants($maxAssistants) {
       $this->maxAssistants = $maxAssistants;
   }


   public function setDate($date) {
       $this->date = $date;
   }

   public function setIdUser($idUser) {
       $this->idUser = $idUser;
   }


   public function getAll() {
       $data = array();
       $data["id"] = $this->id;
       $data["idUser"] = $this->idUser;
       $data["name"] = $this->name;
       $data["maxAssistants"] = $this->maxAssistants;
       $data["date"] = $this->date;
       return $data;
   }

   /*
   *  This method set all values from the event.
   */
   public function setAll($id,$name, $maxAssistants, $date,$idUser) {
       $this->setId($id);

       $this->setName($name);
       $this->setMaxAssistants($maxAssistants);
       $this->setDate($date);
       $this->setIdUser($idUser);
   }

   public function toString() {
       $toString = "Review[id=" . $this->id . "][name=" . $this->name . "][idUser=" . $this->idUser . "][maxAssistants=" . $this->maxAssistants . "][date=" . $this->date . "]";
       return $toString;
   }
}
?>
