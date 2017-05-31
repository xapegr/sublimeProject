<?php

/** AssistEventADO.php
 * Entity AssistEventADO
 */
require_once "EntityInterfaceADO.php";
require_once "BDsocialSchool.php";
require_once "../model/AssistEvent.php";

class AssistEventADO implements EntityInterface {

    //----------Data base Values---------------------------------------
    private static $table = "assists";
    private static $colIdEvent = "id_event";
    private static $colIdUser = "id_user";

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
            $entity = AssistEventADO::fromResultSet($row);

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
        $idEvent = $res[AssistEventADO::$colIdEvent];
        $idUser = $res[AssistEventADO::$colIdUser];

        //Object construction
        $entity = new AssistEvent();
        $entity->setIdEvent($idEvent);
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
            error_log("Error executing query in AssistEventADO: " . $e->getMessage() . " ");
            die();
        }

        //Run the query
        $res = $conn->execution($cons, $vector);

        return AssistEventADO::fromResultSetList($res);
    }

    /**
     * findById()
     * It runs a query and returns an object array
     * @param id
     * @return object with the query results
     */
    public static function findById($assistEvent) {
        $cons = "select * from `" . AssistEventADO::$table . "` where " . AssistEventADO::$colIdEvent . " = ? and " . AssistEventADO::$colIdUser . " = ?";
        $arrayValues = [$assistEvent->getIdEvent(), $assistEvent->getIdUser()];

        return AssistEventADO::findByQuery($cons, $arrayValues);
    }

    /**
     * findAll()
     * It runs a query and returns an object array
     * @param none
     * @return object with the query results
     */
    public static function findAll() {
        $cons = "select * from `" . AssistEventADO::$table . "`";
        $arrayValues = [];

        return AssistEventADO::findByQuery($cons, $arrayValues);
    }

    /**
     * create()
     * insert a new row into the database
     */
    public function create($assistEvent) {
        //Connection with the database
        try {
            $conn = DBConnect::getInstance();
        } catch (PDOException $e) {
            print "Error connecting database: " . $e->getMessage() . " ";
            die();
        }

        $cons = "insert into " . AssistEventADO::$table . " (`id_event`, `id_user`) values (?, ?)";
        $arrayValues = [$assistEvent->getIdEvent(), $assistEvent->getIdUser()];

        $assistEvent = $conn->executionInsert($cons, $arrayValues);

        return $assistEvent;
    }

    /**
     * delete()
     * it deletes a row from the database
     */
    public function delete($assistEvent) {
        //Connection with the database
        try {
            $conn = DBConnect::getInstance();
        } catch (PDOException $e) {
            print "Error connecting database: " . $e->getMessage() . " ";
            die();
        }


        $cons = "delete from `" . AssistEventADO::$table . "` where " . AssistEventADO::$colIdEvent . " = ? and "
                . AssistEventADO::$colIdUser . " = ?";
        $arrayValues = [$assistEvent->getIdEvent(), $assistEvent->getIdUser()];
        $assisting = "0";
        if ($conn->execution($cons, $arrayValues)) {
            $assisting = "1";
        }

        return $assisting;
    }

    /**
     * update()
     * it updates a row of the database
     */
    public function update($event) {
        
    }

}

?>
