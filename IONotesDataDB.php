<?php

require_once "IONotesData.php";

class IONotesDataDB implements IONotesData
{
    public function dbConnection() { //Что бы не дублировать код
        $mysqli = new mysqli("localhost", "mysql", "mysql", "db_notes");
        if (mysqli_connect_errno()) {
            printf("Подключение к серверу MySQL невозможно. Код ошибки: %s\n", mysqli_connect_error());
            exit;
        }
        return $mysqli;
    }

    public function getCountNotes($userId) {

        $mysqli = $this->dbConnection();

        $res = 0;

        if($userId !== -1)
            $query = "SELECT * FROM notes_notes WHERE notes_author_id='$userId';";
        else
            $query = "SELECT * FROM notes_notes;";


        if ($result = $mysqli->query($query)) {
            $res = $result->num_rows;
            $result->close();
        }
        $mysqli->close();

        return $res;
    }


    public function getNote($idNote)
    {
        $mysqli = $this->dbConnection();
        $row = NULL;
        if ($result = $mysqli->query("SELECT * FROM notes_notes WHERE notes_id='$idNote';")) {
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
            }
            $result->close();
        }
        $mysqli->close();
        return $row;
    }

    public function getAllNotes($userId)
    {
        $mysqli = $this->dbConnection();
        $arrNotes = NULL;
        if ($result = $mysqli->query("SELECT * FROM notes_notes WHERE notes_author_id='$userId';")) {
            if ($result->num_rows > 0) {
                $arrNotes = $result->fetch_all(MYSQLI_ASSOC);
            }
            $result->close();
        }
        $mysqli->close();
        return $arrNotes;
    }

    public function createNotes($dataNote) //В случае успеха возвращает ид записи в бд. (Если нет возвращает NULL)
    {
        $mysqli = $this->dbConnection();

        $res = NULL;
        if ($mysqli->query("INSERT INTO notes_notes (notes_title,notes_text_preview,notes_text,notes_author_id) values
        ('".$dataNote['notes_title']."','".$dataNote['notes_text_preview']."','".$dataNote['notes_text']."','".$dataNote['notes_author_id']."');")) {
            $res = $mysqli->insert_id;
        }
        $mysqli->close();
        return $res;
    }

    public function editNotes($idNote, $dataNote)
    {
        // TODO: Implement editNotes() method.
    }

}