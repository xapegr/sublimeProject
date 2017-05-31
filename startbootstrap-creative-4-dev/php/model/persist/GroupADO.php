<?php
/** directorClass.php
* Entity directorClass
* autor  Roberto Plana
* version 2012/09
*/
require_once "EntityInterfaceADO.php";
require_once "BDSocialSchool.php";
require_once "../model/Group.php";

class GroupADO implements EntityInterface {


   //----------Data base Values---------------------------------------
   private static $table = "group";
   private static $colId = "id";
   private static $colDateGroupName = "name";
   private static $colMaxMembers = "maxMembers";
   private static $colFundationDate = "fundationDate";
   private static $colIdUser = "idUser";
   private static $colIdChat = "idChat";

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
       $entity = GroupADO::fromResultSet( $row );

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
     $id = $res[ GroupADO::$colId];
     $idUser = $res[ GroupADO::$colIdUser ];
     $maxMembers = $res[ GroupADO::$colMaxMembers ];
     $fundationDate = $res[ GroupADO::$colFundationDate ];
     $name = $res[ GroupADO::$colDateGroupName ];

     //Object construction
     $entity = new Group();
     $entity->setId($id);
     $entity->setIdUser($idUser);
     $entity->setMaxMembers($maxMembers);
     $entity->setFundationDate($fundationDate);
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
     error_log("Error executing query in GroupADO: " . $e->getMessage() . " ");
     die();
   }

   //Run the query
   $res = $conn->execution($cons, $vector);

   return GroupADO::fromResultSetList( $res );
   }

   /**
  * findById()
  * It runs a query and returns an object array
  * @param id
  * @return object with the query results
   */
   public static function findById( $group ) {
   $cons = "select * from `".GroupADO::$table."` where ".GroupADO::$colId." = ?";
   $arrayValues = [$group->getId()];

   return GroupADO::findByQuery($cons,$arrayValues);
   }


   /**
 * findByIdUser()
  * It runs a query and returns an object array
  * @param fundationDateGroup
  * @return object with the query results
   */
   public static function findByIdUser( $group ) {
   $cons = "select * from `".GroupADO::$table."` where ".GroupADO::$colIdUser." = ?";
   $arrayValues = [$group->getIdUser()];

   return GroupADO::findByQuery( $cons, $arrayValues );
   }

   /**
  * findAll()
  * It runs a query and returns an object array
  * @param none
  * @return object with the query results
   */
   public static function findAll( ) {
     $cons = "select * from `".GroupADO::$table."`";
     $arrayValues = [];

   return GroupADO::findByQuery( $cons, $arrayValues );
   }


   /**
  * create()
  * insert a new row into the database
   */
   public function create($group) {
   //Connection with the database
   try {
     $conn = DBConnect::getInstance();
   }
   catch (PDOException $e) {
     print "Error connecting database: " . $e->getMessage() . " ";
     die();
   }

   $cons="insert into ".GroupADO::$table." (`idUser`,`name`,`maxMembers`,`fundationDate`) values (?, ?, ?, ?)";
   $arrayValues= [$group->getIdUser(),$group->getName(),$group->getMaxMembers(),$group->getFundationDate()];

   $id = $conn->executionInsert($cons, $arrayValues);

   $group->setId($id);

     return $group->getId();
 }

   /**
  * delete()
  * it deletes a row from the database
   */
   public function delete($group) {
   //Connection with the database
   try {
     $conn = DBConnect::getInstance();
   }
   catch (PDOException $e) {
     print "Error connecting database: " . $e->getMessage() . " ";
     die();
   }


   $cons="delete from `".GroupADO::$tableName."` where ".GroupADO::$colNameId." = ?";
   $arrayValues= [$group->getId()];

   $conn->execution($cons, $arrayValues);
   }


   /**
  * upfundationDate()
  * it upfundationDates a row of the database
   */
   public function upfundationDate($group) {
   //Connection with the database
   try {
     $conn = DBConnect::getInstance();
   }
   catch (PDOException $e) {
     print "Error connecting database: " . $e->getMessage() . " ";
     die();
   }

   $cons="upfundationDate `".GroupADO::$table."` set ".GroupADO::$colIdUser." = ?,".GroupADO::$colDateGroupName." = ?,".
          GroupADO::$colDateGroupDate." = ?, ".GroupADO::$colMaxMembers." =? where ".GroupADO::$colId." = ?";
   $arrayValues= [$group->getIdUser(),$group->getName(),$group->getDate(),$group->getMaxMembers(), $group->getId()];

   $conn->execution($cons, $arrayValues);
   }

   public function toString() {
       $toString .= "GroupADO[id=" . $this->id . "][idUser=" . $this->idUser . "][name=" . $this->name . "][fundationDate=" . $this->fundationDate . "][maxMembers=" . $this->maxMembers . "]";
   return $toString;
   }
}
?>
