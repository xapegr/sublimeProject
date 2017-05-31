<?php
/** User.php
 * Entity User
 * autors  Javier Bueno and Xavier Pérez
 * version 2012/09
 */
require_once "BDsocialSchool.php";
require_once "EntityInterfaceADO.php";
require_once "../model/User.php";

class UserADO implements EntityInterfaceADO {

    //----------Data base Values---------------------------------------
    private static $table = "users";
    private static $colId = "id_user";
    private static $colName = "name";
    private static $colSurname = "surname";
    private static $colNickName = "nickname";
    private static $colPassword = "password";
    private static $colMail = "email";
    private static $colBirthDate = "birth_date";
    private static $colRegisterDate = "register_date";
    private static $colUserType = "user_type";
    //private static $colNameImage = "image";

    //---Databese management section-----------------------
    /**
	 * fromResultSetList()
	 * this function runs a query and returns an array with all the result transformed into an object
	 * @param res query to execute
	 * @return objects collection
    */
    public static function fromResultSetList( $res ) {
		$entityList = array();
		$i=0;
		//while ( ($row = $res->fetch_array(MYSQLI_BOTH)) != NULL ) {
		foreach ( $res as $row)
		{
			//We get all the values an add into the array
			$entity = UserADO::fromResultSet( $row );

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
    public static function fromResultSet( $res ) {
	    //We get all the values form the query
        $id = $res[ UserADO::$colId];
        $name = $res[ UserADO::$colName ];
        $surname = $res[ UserADO::$colSurname ];
        $nickName = $res[ UserADO::$colNickName ];
        $password = $res[ UserADO::$colPassword ];
        $mail = $res[ UserADO::$colMail ];
        $birthDate = $res[ UserADO::$colBirthDate ];
        $registerDate = $res[ UserADO::$colRegisterDate ];
        $userType = $res[ UserADO::$colUserType ];

     	//Object construction
     	$entity = new User();
    	$entity->setId($id);
    	$entity->setName($name);
    	$entity->setSurname($surname);
    	$entity->setNickName($nickName);
    	$entity->setPassword($password);
    	$entity->setMail($mail);
    	$entity->setBirthDate($birthDate);
    	$entity->setRegisterDate($registerDate);
    	$entity->setUserType($userType);

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
			error_log("Error executing query in UserADO: " . $e->getMessage() . " ");
			die();
		}

		$res = $conn->execution($cons, $vector);
		return UserADO::fromResultSetList( $res );
    }

    /**
	 * findById()
	 * It runs a query and returns an object array
	 * @param id
	 * @return object with the query results
    */
    public static function findById( $user ) {
		$cons = "select * from `".UserADO::$table."` where ".UserADO::$colId." = ?";
		$arrayValues = [$user->getId()];

		return UserADO::findByQuery($cons,$arrayValues);
    }

    /**
	 * findlikeName()
	 * It runs a query and returns an object array
	 * @param name
	 * @return object with the query results
    */
    public static function findlikeName( $user ) {
		$cons = "select * from `".UserADO::$table."` where ".UserADO::$colName." like ?";
		$arrayValues = ["%".$user->getName()."%"];

		return UserADO::findByQuery($cons,$arrayValues);
    }



    /**
	* findByName()
	 * It runs a query and returns an object array
	 * @param name
	 * @return object with the query results
    */
    public static function findByName( $user ) {
		$cons = "select * from `".UserADO::$table."` where ".UserADO::$colName." = ?";
		$arrayValues = [$user->getName()];

		return UserADO::findByQuery($cons,$arrayValues);
    }

    /**
	* findByNick()
	 * It runs a query and returns an object array
	 * @param name
	 * @return object with the query results
    */
    public static function findByNickName( $user ) {
		$cons = "select * from `".UserADO::$table."` where ".UserADO::$colNickName." = ?";
		$arrayValues = [$user->getNickName()];

		return UserADO::findByQuery($cons,$arrayValues);
    }

    /**
	* findByNickAndPass()
	 * It runs a query and returns an object array
	 * @param name
	 * @return object with the query results
    */
    public static function findByNickAndPass( $user ) {
		//$cons = "select * from `".UserADO::$table."` where ".UserADO::$colNameNick." = \"".$user->getNick()."\" and ".UserADO::$colPassword." = \"".$user->getPassword()."\"";
		$cons = "select * from users where nickname = ? and password = ?";
		$arrayValues = [$user->getNickName(),$user->getPassword()];

		return UserADO::findByQuery( $cons, $arrayValues );
    }

    /**
	 * findAll()
	 * It runs a query and returns an object array
	 * @param none
	 * @return object with the query results
    */
    public static function findAll( ) {
    	$cons = "select * from `".UserADO::$table."`";
		$arrayValues = [];

		return UserADO::findByQuery( $cons, $arrayValues );
    }


    /**
	 * create()
	 * insert a new row into the database
    */
    public function create($user) {
		//Connection with the database
		try {
			$conn = DBConnect::getInstance();
		}
		catch (PDOException $e) {
			print "Error connecting database: " . $e->getMessage() . " ";
			die();
		}

		$cons="insert into ".UserADO::$table." (`name`,`surname`,`nickname`,`password`,`email`,`birth_date`,`register_date`,`user_type` ) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )";
		$arrayValues= [$user->getName(),$user->getSurname(), $user->getNickName(), $user->getPassword(),$user->getMail(), $user->getBirthDate(), $user->getRegisterDate(), $user->getUserType() ];

		$id = $conn->executionInsert($cons, $arrayValues);

		$user->setId($id);

	  return $user->getId();
	}

    /**
	 * delete()
	 * it deletes a row from the database
    */
    public function delete($user) {
		//Connection with the database
  		try {
  			$conn = DBConnect::getInstance();
  		}
  		catch (PDOException $e) {
  			print "Error connecting database: " . $e->getMessage() . " ";
  			die();
  		}


  		$cons="delete from `".UserADO::$table."` where ".UserADO::$colId." = ?";
  		$arrayValues= [$user->getId()];

  		$conn->execution($cons, $arrayValues);
    }


    /**
	 * update()
	 * it updates a row of the database
    */
	 public function update($user) {
		//Connection with the database
		try {
			$conn = DBConnect::getInstance();
		}
		catch (PDOException $e) {
			print "Error connecting database: " . $e->getMessage() . " ";
			die();
		}

		$cons="update `".UserADO::$table."` set ".UserADO::$colName." = ?, ".UserADO::$colSurname." = ?, ".UserADO::$colNickName." = ?, ".UserADO::$colPassword." = ?, ".UserADO::$colMail." = ?, ".UserADO::$colBirthDate." = ?, ".UserADO::$colRegisterDate." = ?, ".UserADO::$colUserType." = ? where ".UserADO::$colId." = ?" ;
		$arrayValues= [$user->getName(),$user->getSurname(), $user->getNickName(), $user->getPassword(), $user->getMail(), $user->getBirthDate(), $user->getRegisterDate(), $user->getUserType(), $user->getImage(),$user->getId()];

		$conn->execution($cons, $arrayValues);

    }
}
?>
