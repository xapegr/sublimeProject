<?php

/** User.php
 * Entity User
 * autors  Javier Bueno and Xavier Pérez
 * version 2012/09
 */
require_once "BDsocialSchool.php";
require_once "EntityInterfaceADO.php";
require_once "../model/Chat.php";

class ChatADO implements EntityInterfaceADO {

    //----------Data base Values---------------------------------------
    private static $table = "chats";
    private static $colId = "id_chat";
    private static $colDate = "date";
    private static $colMessage = "message";
    private static $colFromUser = "from_user";
    private static $colToUser = "to_user";

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
            $entity = ChatADO::fromResultSet($row);

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
        $id = $res[ChatADO::$colId];
        $fromUser = $res[ChatADO::$colFromUser];
        $toUser = $res[ChatADO::$colToUser];
        $date = $res[ChatADO::$colDate];
        $message = $res[ChatADO::$colMessage];

        //Object construction
        $entity = new Chat();
        $entity->setId($id);
        $entity->setFromUser($fromUser);
        $entity->setToUser($toUser);
        $entity->setDate($date);
        $entity->setMessage($message);

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
            error_log("Error executing query in ChatADO: " . $e->getMessage() . " ");
            die();
        }

        $res = $conn->execution($cons, $vector);
        return ChatADO::fromResultSetList($res);
    }

    /**
     * findByIds()
     * It runs a query and returns an object array
     * @param id
     * @return object with the query results
     */
    public static function findByIds($chat) {
        $cons = "select * from `" . ChatADO::$table . "` where (from_user = ? and to_user = ?) or (from_user=? and to_user=?) ORDER BY date ASC";
        $arrayValues = [$chat->getFromUser(), $chat->getToUser(), $chat->getToUser(), $chat->getFromUser()];

        return ChatADO::findByQuery($cons, $arrayValues);
    }

    /**
     * findAll()
     * It runs a query and returns an object array
     * @param none
     * @return object with the query results
     */
    public static function findAll() {
        $cons = "select * from `" . ChatADO::$table . "`";
        $arrayValues = [];

        return ChatADO::findByQuery($cons, $arrayValues);
    }

    /**
     * create()
     * insert a new row into the database
     */
    public function create($chat) {
        //Connection with the database
        try {
            $conn = DBConnect::getInstance();
        } catch (PDOException $e) {
            print "Error connecting database: " . $e->getMessage() . " ";
            die();
        }

        $cons = "insert into " . ChatADO::$table . " (`from_user`,`to_user`,`message`,`date`) values (?, ?, ?, ?)";
        $arrayValues = [$chat->getFromUser(), $chat->getToUser(), $chat->getMessage(), $chat->getDate()];

        $id = $conn->executionInsert($cons, $arrayValues);

        $chat->setId($id);

        return $chat->getId();
    }

    /**
     * delete()
     * it deletes a row from the database
     */
    public function delete($user) {
        
    }

    /**
     * update()
     * it updates a row of the database
     */
    public function update($user) {
        
    }

}

?>
