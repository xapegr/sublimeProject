<?php
/** directorClass.php
* Entity directorClass
* autor  Roberto Plana
* version 2012/09
*/
require_once "EntityInterfaceADO.php";
require_once "BDSocialSchool.php";
require_once "../model/Event.php";

class EventADO implements EntityInterface {


   //----------Data base Values---------------------------------------
   private static  = "event";
   private static $colId = "id";
   private static $colName = "name";
   private static $colDate = "date";
   private static $colMaxAssistants = "maxAssistants";
   private static $colIdUser = "idUser";

   //---Databese management section-----------------------
   /**
  * fromResultSetList()
  * this function runs a query and returns an array with all the result transformed into an object
  * @param res query to execute
  * @return objects collection
   */
   private static function fromResultSetList( $res ) {
     $entityList = array();
     $i=0;
     foreach ( $res as $row) {
       //We get all the values an add into the array
       $entity = EventADO::fromResultSet( $row );

       $entityList[$i]= $entity;
       $i++;
     }
     return $entityList;
   }

   /**
 * fromResultSet()
 * the query result is transformed into an object
 * @param res ResultSet del qual obtenir dades
 * @return object
   */
   private static function fromResultSet( $res ) {
 //We get all the values form the query
   $id = $res[ EventADO::$colId];
   $idUser = $res[ EventADO::$colIdUser ];
   $maxAssistants = $res[ EventADO::$colMaxAssistants ];
   $date = $res[ EventADO::$colDate ];
   $name = $res[ EventADO::$colName ];

       //Object construction
       $entity = new Event();
   $entity->setId($id);
   $entity->setIdUser($idUser);
   $entity->setMaxAssistants($maxAssistants);
   $entity->setDate($date);
   $entity->setName($name);

   return $entity;
   }

   /**
  * findByQuery()
  * It runs a particular query and returns the result
  * @param cons query to run
  * @return objects collection
   */
   public static function findByQuery( $cons, $vector ) {
   //Connection with the database
   try {
     $conn = DBConnect::getInstance();
   }
   catch (PDOException $e) {
     echo "Error executing query.";
     error_log("Error executing query in EventADO: " . $e->getMessage() . " ");
     die();
   }

   //Run the query
   $res = $conn->execution($cons, $vector);

   return EventADO::fromResultSetList( $res );
   }

   /**
  * findById()
  * It runs a query and returns an object array
  * @param id
  * @return object with the query results
   */
   public static function findById( $event ) {
   $cons = "select * from `".EventADO::$table."` where ".EventADO::$colId." = ?";
   $arrayValues = [$event->getId()];

   return EventADO::findByQuery($cons,$arrayValues);
   }


   /**
 * findByIdUser()
  * It runs a query and returns an object array
  * @param dateEvent
  * @return object with the query results
   */
   public static function findByIdUser( $event ) {
   $cons = "select * from `".EventADO::$table."` where ".EventADO::$colIdUser." = ?";
   $arrayValues = [$event->getIdUser()];

   return EventADO::findByQuery( $cons, $arrayValues );
   }

   /**
  * findAll()
  * It runs a query and returns an object array
  * @param none
  * @return object with the query results
   */
   public static function findAll( ) {
     $cons = "select * from `".EventADO::$table."`";
     $arrayValues = [];

   return EventADO::findByQuery( $cons, $arrayValues );
   }


   /**
  * create()
  * insert a new row into the database
   */
   public function create($event) {
   //Connection with the database
   try {
     $conn = DBConnect::getInstance();
   }
   catch (PDOException $e) {
     print "Error connecting database: " . $e->getMessage() . " ";
     die();
   }

   $cons="insert into ".EventADO::$table." (`idUser`,`name`,`maxAssistants`,`date`) values (?, ?, ?, ?)";
   $arrayValues= [$event->getIdUser(),$event->getName(),$event->getMaxAssistants(),$event->getDate()];

   $id = $conn->executionInsert($cons, $arrayValues);

   $event->setId($id);

     return $event->getId();
 }

   /**
  * delete()
  * it deletes a row from the database
   */
   public function delete($event) {
   //Connection with the database
   try {
     $conn = DBConnect::getInstance();
   }
   catch (PDOException $e) {
     print "Error connecting database: " . $e->getMessage() . " ";
     die();
   }


   $cons="delete from `".EventADO::$tableName."` where ".EventADO::$colNameId." = ?";
   $arrayValues= [$event->getId()];

   $conn->execution($cons, $arrayValues);
   }


   /**
  * update()
  * it updates a row of the database
   */
   public function update($event) {
   //Connection with the database
   try {
     $conn = DBConnect::getInstance();
   }
   catch (PDOException $e) {
     print "Error connecting database: " . $e->getMessage() . " ";
     die();
   }

   $cons="update `".EventADO::$table."` set ".EventADO::$colIdUser." = ?,".EventADO::$colName." = ?,".
          EventADO::$colDate." = ?, ".EventADO::$colMaxAssistants." =? where ".EventADO::$colId." = ?";
   $arrayValues= [$event->getIdUser(),$event->getName(),$event->getDate(),$event->getMaxAssistants(), $event->getId()];

   $conn->execution($cons, $arrayValues);
   }

   public function toString() {
       $toString .= "EventADO[id=" . $this->id . "][idUser=" . $this->idUser . "][name=" . $this->name . "][date=" . $this->date . "][maxAssistants=" . $this->maxAssistants . "]";
   return $toString;
   }
}
?>
