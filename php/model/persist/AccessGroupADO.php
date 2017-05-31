<?php

/** AccessGroupADO.php
 * Entity AccessGroupADO
 * autors Javier Bueno and Xavier P�rez
 */
require_once "EntityInterfaceADO.php";
require_once "BDsocialSchool.php";
require_once "../model/AccessGroup.php";

class AccessGroupADO implements EntityInterface {

    //----------Data base Values---------------------------------------
    private static $table = "access";
    private static $colIdUser = "id_user";
    private static $colIdGroup = "id_group";

    //---Databese management section-----------------------
    /**
     * fromResultSetList()
     * this function runs a query and returns an array with all the result transformed into an object
     * @param res query to execute
     * @return objects collection
     */
    private static function fromResultSetList($res) {
        $entityList = array();
        $i = 0;
        foreach ($res as $row) {
            //We get all the values an add into the array
            $entity = AccessGroupADO::fromResultSet($row);

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
    private static function fromResultSet($res) {
        //We get all the values form the query
        $idGroup = $res[AccessGroupADO::$colIdGroup];
        $idUser = $res[AccessGroupADO::$colIdUser];

        //Object construction
        $entity = new AccessGroup();
        $entity->setIdGroup($id);
        $entity->setIdUser($idUser);

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
            error_log("Error executing query in AccessGroupADO: " . $e->getMessage() . " ");
            die();
        }

        //Run the query
        $res = $conn->execution($cons, $vector);

        return AccessGroupADO::fromResultSetList($res);
    }

    /**
     * findById()
     * It runs a query and returns an object array
     * @param id
     * @return object with the query results
     */
    public static function findById($accessGroup) {
        $cons = "select * from `" . AccessGroupADO::$table . "` where " . AccessGroupADO::$colIdGroup . " = ? and " . AssistEventADO::$colIdUser . " = ?";
        $arrayValues = [$accessGroup->getIdEvent(), $accessGroup->getIdUser()];

        return AccessGroupADO::findByQuery($cons, $arrayValues);
    }

    /**
     * findAll()
     * It runs a query and returns an object array
     * @param none
     * @return object with the query results
     */
    public static function findAll() {
        $cons = "select * from `" . AccessGroupADO::$table . "`";
        $arrayValues = [];

        return AccessGroupADO::findByQuery($cons, $arrayValues);
    }

    /**
     * create()
     * insert a new row into the database
     */
    public function create($AccessGroup) {
        //Connection with the database
        try {
            $conn = DBConnect::getInstance();
        } catch (PDOException $e) {
            print "Error connecting database: " . $e->getMessage() . " ";
            die();
        }

        $cons = "insert into " . AccessGroupADO::$table . " (`id_Group`, `id_user`) values (?, ?)";
        $arrayValues = [$AccessGroup->getIdGroup(), $AccessGroup->getIdUser()];

        $AccessGroup = $conn->executionInsert($cons, $arrayValues);

        return $AccessGroup;
    }

    /**
     * delete()
     * it deletes a row from the database
     */
    public function delete($AccessGroup) {
        //Connection with the database
        try {
            $conn = DBConnect::getInstance();
        } catch (PDOException $e) {
            print "Error connecting database: " . $e->getMessage() . " ";
            die();
        }


        $cons = "delete from `" . AccessGroupADO::$table . "` where " . AccessGroupADO::$colIdGroup . " = ? and "
                . AccessGroupADO::$colIdUser . " = ?";
        $arrayValues = [$AccessGroup->getIdGroup(), $AccessGroup->getIdUser()];

        $unAccessGroup = $conn->execution($cons, $arrayValues);
        return $unAccessGroup;
    }

    /**
     * update()
     * it updates a row of the database
     */
    public function update($Group) {
        //Connection with the database
        /* try {
          $conn = DBConnect::getInstance();
          }
          catch (PDOException $e) {
          print "Error connecting database: " . $e->getMessage() . " ";
          die();
          }

          $cons="update `".AccessGroupADO::$table."` set ".AccessGroupADO::$colIdUser." = ?,".AccessGroupADO::$colName." = ?,".
          AccessGroupADO::$colDate." = ?, ".AccessGroupADO::$colMaxAccessants." =? where ".AccessGroupADO::$colId." = ?";
          $arrayValues= [$Group->getIdUser(),$Group->getName(),$Group->getDate(),$Group->getMaxAccessants(), $Group->getId()];

          $conn->execution($cons, $arrayValues);
          }

          public function toString() {
          $toString .= "AccessGroupADO[id=" . $this->id . "][idUser=" . $this->idUser . "][name=" . $this->name . "][date=" . $this->date . "][maxAccessants=" . $this->maxAccessants . "]";
          return $toString; */
    }

}

?>
