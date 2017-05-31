<?php

/** EventADO.php
 * Entity EventADO
 */
require_once "EntityInterfaceADO.php";
require_once "BDsocialSchool.php";
require_once "../model/Event.php";

class EventADO implements EntityInterface {

    //----------Data base Values---------------------------------------
    private static $table = "events";
    private static $colId = "id_event";
    private static $colName = "name";
    private static $colMaxAssistants = "max_assistants";
    private static $colDate = "event_date";
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
            $entity = EventADO::fromResultSet($row);

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
        $id = $res[EventADO::$colId];
        $name = $res[EventADO::$colName];
        $maxAssistants = $res[EventADO::$colMaxAssistants];
        $date = $res[EventADO::$colDate];
        $idUser = $res[EventADO::$colIdUser];

        //Object construction
        $entity = new Event();
        $entity->setId($id);
        $entity->setName($name);
        $entity->setMaxAssistants($maxAssistants);
        $entity->setDate($date);
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
            error_log("Error executing query in EventADO: " . $e->getMessage() . " ");
            die();
        }

        //Run the query
        $res = $conn->execution($cons, $vector);

        return EventADO::fromResultSetList($res);
    }

    /**
     * findById()
     * It runs a query and returns an object array
     * @param id
     * @return object with the query results
     */
    public static function findById($event) {
        $cons = "select * from `" . EventADO::$table . "` where " . EventADO::$colId . " = ?";
        $arrayValues = [$event->getId()];

        return EventADO::findByQuery($cons, $arrayValues);
    }

    /**
     * findByIdUser()
     * It runs a query and returns an object array
     * @param dateEvent
     * @return object with the query results
     */
    public static function findByIdUser($event) {
        $cons = "select * from `" . EventADO::$table . "` where " . EventADO::$colIdUser . " = ?";
        $arrayValues = [$event->getIdUser()];

        return EventADO::findByQuery($cons, $arrayValues);
    }

    /**
     * findAll()
     * It runs a query and returns an object array
     * @param none
     * @return object with the query results
     */
    public static function findAll() {
        $cons = "select * from `" . EventADO::$table . "` order by event_date asc";
        $arrayValues = [];

        return EventADO::findByQuery($cons, $arrayValues);
    }

    /**
     * create()
     * insert a new row into the database
     */
    public function create($event) {
        //Connection with the database
        try {
            $conn = DBConnect::getInstance();
        } catch (PDOException $e) {
            print "Error connecting database: " . $e->getMessage() . " ";
            die();
        }

        $cons = "insert into " . EventADO::$table . " (`id_user`,`name`,`max_assistants`,`event_date`) values (?, ?, ?, ?)";
        $arrayValues = [$event->getIdUser(), $event->getName(), $event->getMaxAssistants(), $event->getDate()];

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
        } catch (PDOException $e) {
            print "Error connecting database: " . $e->getMessage() . " ";
            die();
        }


        $cons = "delete from `" . EventADO::$tableName . "` where " . EventADO::$colNameId . " = ?";
        $arrayValues = [$event->getId()];

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
        } catch (PDOException $e) {
            print "Error connecting database: " . $e->getMessage() . " ";
            die();
        }

        $cons = "update `" . EventADO::$table . "` set " . EventADO::$colIdUser . " = ?," . EventADO::$colName . " = ?," .
                EventADO::$colDate . " = ?, " . EventADO::$colMaxAssistants . " =? where " . EventADO::$colId . " = ?";
        $arrayValues = [$event->getIdUser(), $event->getName(), $event->getDate(), $event->getMaxAssistants(), $event->getId()];

        $conn->execution($cons, $arrayValues);
    }

    public function toString() {
        $toString .= "EventADO[id=" . $this->id . "][idUser=" . $this->idUser . "][name=" . $this->name . "][date=" . $this->date . "][maxAssistants=" . $this->maxAssistants . "]";
        return $toString;
    }

}

?>
