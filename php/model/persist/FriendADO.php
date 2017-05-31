<?php

/** FriendADO.php
 * Entity FriendADO
 * autors  Javier Bueno and Xavier Pérez
 * version 2017/06
 */
require_once "BDsocialSchool.php";
require_once "EntityInterfaceADO.php";
require_once "../model/Friend.php";

class FriendADO implements EntityInterfaceADO {

    //----------Data base Values---------------------------------------
    private static $table = "friends";
    private static $colIdUser = "id_user";
    private static $colIdFriend = "id_friend";

    //private static $colNameImage = "image";
    //---Databese management section-----------------------
    /**
     * fromResultSetList()
     * this function runs a query and returns an array with all the result transformed into an object
     * @param res query to execute
     * @return objects collection
     */
    public static function fromResultSetList($res) {
        $entityList = array();
        $i = 0;
        //while ( ($row = $res->fetch_array(MYSQLI_BOTH)) != NULL ) {
        foreach ($res as $row) {
            //We get all the values an add into the array
            $entity = FriendADO::fromResultSet($row);

            $entityList[$i] = $entity;
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
    public static function fromResultSet($res) {
        //We get all the values form the query
        $idUser = $res[FriendADO::$colIdUser];
        $idFriend = $res[FriendADO::$colIdFriend];

        //Object construction
        $entity = new Friend();
        $entity->setIdUser($idUser);
        $entity->setIdFriend($idFriend);

        return $entity;
    }

    /**
     * findByQuery()
     * It runs a particular query and returns the result
     * @param cons query to run
     * @return objects collection
     */
    public static function findByQuery($cons, $vector) {
        //Connection with the database
        try {
            $conn = DBConnect::getInstance();
        } catch (PDOException $e) {
            echo "Error executing query.";
            error_log("Error executing query in UserADO: " . $e->getMessage() . " ");
            die();
        }

        $res = $conn->execution($cons, $vector);
        return FriendADO::fromResultSetList($res);
    }

    /**
     * findById()
     * It runs a query and returns an object array
     * @param id
     * @return object with the query results
     */
    /* public static function findById( $user ) {
      $cons = "select * from `".UserADO::$table."` where ".UserADO::$colId." = ?";
      $arrayValues = [$user->getId()];

      return UserADO::findByQuery($cons,$arrayValues);
      } */

    /**
     * findlikeName()
     * It runs a query and returns an object array
     * @param name
     * @return object with the query results
     */
    /* public static function findlikeName( $user ) {
      $cons = "select * from `".UserADO::$table."` where ".UserADO::$colName." like ?";
      $arrayValues = ["%".$user->getName()."%"];

      return UserADO::findByQuery($cons,$arrayValues);
      } */



    /**
     * findByName()
     * It runs a query and returns an object array
     * @param name
     * @return object with the query results
     */
    /* public static function findByName( $user ) {
      $cons = "select * from `".UserADO::$table."` where ".UserADO::$colName." = ?";
      $arrayValues = [$user->getName()];

      return UserADO::findByQuery($cons,$arrayValues);
      } */

    /**
     * findByNick()
     * It runs a query and returns an object array
     * @param name
     * @return object with the query results
     */
    /*  public static function findByNickName( $user ) {
      $cons = "select * from `".UserADO::$table."` where ".UserADO::$colNickName." = ?";
      $arrayValues = [$user->getNickName()];

      return UserADO::findByQuery($cons,$arrayValues);
      } */

    /**
     * findByNickAndPass()
     * It runs a query and returns an object array
     * @param name
     * @return object with the query results
     */
    /* public static function findByNickAndPass( $user ) {
      //$cons = "select * from `".UserADO::$table."` where ".UserADO::$colNameNick." = \"".$user->getNick()."\" and ".UserADO::$colPassword." = \"".$user->getPassword()."\"";
      $cons = "select * from users where nickname = ? and password = ?";
      $arrayValues = [$user->getNickName(),$user->getPassword()];

      return UserADO::findByQuery( $cons, $arrayValues );
      } */


    /**
     * findByNickAndPass()
     * It runs a query and returns an object array
     * @param name
     * @return object with the query results
     */
    /* public static function findByEmail( $txt ) {
      //$cons = "select * from `".UserADO::$table."` where ".UserADO::$colNameNick." = \"".$user->getNick()."\" and ".UserADO::$colPassword." = \"".$user->getPassword()."\"";
      $cons = "select * from users where email = ?";
      $arrayValues = [$txt];

      return UserADO::findByQuery( $cons, $arrayValues );
      } */

    /**
     * findAll()
     * It runs a query and returns an object array
     * @param none
     * @return object with the query results
     */
    public static function findAll() {
        $cons = "select * from `" . FriendADO::$table . "`";
        $arrayValues = [];

        return FriendADO::findByQuery($cons, $arrayValues);
    }

    /**
     * create()
     * insert a new row into the database
     */
    public function create($friend) {
        //Connection with the database
        try {
            $conn = DBConnect::getInstance();
        } catch (PDOException $e) {
            print "Error connecting database: " . $e->getMessage() . " ";
            die();
        }

        $cons = "insert into " . FriendADO::$table . " (`id_user`,`id_friend`) values (?, ?)";
        $arrayValues = [$friend->getIdUser(), $friend->getIdFriend()];

        $row = $conn->executionInsert($cons, $arrayValues);

        return $row;
    }

    /**
     * delete()
     * it deletes a row from the database
     */
    /* public function delete($friend) {
      //Connection with the database
      try {
      $conn = DBConnect::getInstance();
      }
      catch (PDOException $e) {
      print "Error connecting database: " . $e->getMessage() . " ";
      die();
      }


      $cons="delete from `".FriendADO::$table."` where ".FriendADO::$colIdUser." = ? and ";
      $arrayValues= [$user->getId()];

      $conn->execution($cons, $arrayValues);
      } */


    /**
     * update()
     * it updates a row of the database
     */
    /* public function update($user) {
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

      } */
}

?>
