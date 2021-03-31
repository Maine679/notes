<?php

class Users {
    public $login;
    //private $password; //пароль пользователя
    private int $id; //Ид в бд.

    public $name;
    public $surname;

    private bool $authorized = false;

    public function getUserId() {
        return $this->id;
    }

    public function getAuthorized()    {
        return $this->authorized;
    }

    public function user_exists($login) {
        $mysqli = new mysqli("localhost","mysql","mysql","db_notes");
        $answer = false;
        if (mysqli_connect_errno()) {
            printf("Подключение к серверу MySQL невозможно. Код ошибки: %s\n", mysqli_connect_error());
            exit;
        }

        if ($result = $mysqli->query("SELECT * FROM notes_user WHERE n_user_login='$login';")) {
            if($result->num_rows > 0) {
                $answer = true;
            }
        }

        $result->close();
        $mysqli->close();
        return $answer;
    }

    public function registration($login,$password,$name,$surname) {
        if(!$this->user_exists($login)) {
            //Значит создаём нового пользователя.
            $mysqli = new mysqli("localhost","mysql","mysql","db_notes");
            if (mysqli_connect_errno()) {
                printf("Подключение к серверу MySQL невозможно. Код ошибки: %s\n", mysqli_connect_error());
                exit;
            }
            $time = time();

            $hash = password_hash($password,PASSWORD_DEFAULT );


            $result = $mysqli->query("INSERT INTO notes_user (n_user_login,n_user_password,n_user_name,n_user_surname,n_user_timestamp) values ('$login','$hash','$name','$surname','$time');");
            if($result) {
                $this->authorization($login,$password);
                return true;
            }
            return false;
        } else {
            return false;
        }
    }

    public function authorization(string $login,string $password,int $userId=-1) {
        $mysqli = new mysqli("localhost","mysql","mysql","db_notes");
        if (mysqli_connect_errno()) {
            printf("Подключение к серверу MySQL невозможно. Код ошибки: %s\n", mysqli_connect_error());
            exit;
        }
        if($userId >= 0) {
            if ($result = $mysqli->query("SELECT * FROM notes_user WHERE n_user_id='$userId';")) {
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();

                   // $this->password = $row['n_user_password']; //Хеш пароля
                    $this->name = $row['n_user_name'];
                    $this->surname = $row['n_user_surname'];
                    $this->login = $row['n_user_login'];
                    $this->id = $row['n_user_id']; //Ид в БД

                    $this->authorized = true;
                }
            }
        } else {
            if ($result = $mysqli->query("SELECT * FROM notes_user WHERE n_user_login='$login';")) {
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();

                    //$this->password = $row['n_user_password']; //Хеш пароля
                    $this->name = $row['n_user_name'];
                    $this->surname = $row['n_user_surname'];
                    $this->login = $row['n_user_login'];
                    $this->id = $row['n_user_id']; //Ид в БД

                    if (password_verify($password, $row['n_user_password'])) {
                        $this->authorized = true;
                        $_SESSION['user_id'] = "$this->id";
                    }
                }
            }
        }

        $result->close();
        $mysqli->close();
        return $this->authorized;
    }

    public function __destruct() {
        //Не знаю на кой она нужна.
    }
}























