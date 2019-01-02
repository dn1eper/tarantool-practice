<?php
require_once("database/index.php");

class User extends Database {
    public  $login;
    private $pass_hash;
    private $email;

    function __construct($login, $password, $email = false) {
        parent::__construct();
        $this->login = $this->mysqli->real_escape_string($login);
        $this->pass_hash = md5($password);
        $this->email = $email ? $this->mysqli->real_escape_string($email) : NULL;
    }

    function reg() {
        if (!$this->is_error()) {
            $user = $this->mysqli->query("SELECT * FROM user WHERE login = '" .$this->login. "'");
            if ($user && !sizeof($user->fetch_all(MYSQLI_ASSOC))) {
                if ($this->mysqli->query('
                INSERT INTO user (login, pass_hash, email) VALUES ("' 
                    .$this->login. '", "'
                    .$this->pass_hash. '", "'
                    .$this->email. '");')) {
                    return true;
                }
                else return $this->new_error("Database error while inserting new user. [". $this->mysqli->real_escape_string($this->mysqli->error). "]");
            }
            else return $this->new_error("This user already exists");
        }
        else return $this->new_error("Database connection error");
    }

    function check() {
        if (!$this->is_error()) {
            if ($user = $this->mysqli->query("SELECT * FROM user WHERE login = '" .$this->login. "'")) {
                $result = $user->fetch_all(MYSQLI_ASSOC);
                if (sizeof($result) == 1) {
                    if ($result[0]['pass_hash'] == $this->pass_hash) {
                        return true;
                    }
                    else return $this->new_error("Wrong password");
                }
                else return $this->new_error("This user does not exist");
            }
            else return $this->new_error("Database connection error");
        }
        else return $this->new_error("Database connection error");
    }
}