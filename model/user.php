<?php
require_once("mysql/index.php");
require_once("tarantool/index.php");

class Mysql_User extends Database {
    public  $login;
    private $pass_hash;
    private $email;

    function __construct($login, $password, $email = false) {
        parent::__construct();
        $this->login = $this->mysqli->real_escape_string($login);
        $this->pass_hash = md5($password);
        $this->email = $email ? $this->mysqli->real_escape_string($email) : NULL;
    }

    public function reg() {
        if (!$this->is_error()) {
            $user = $this->mysqli->query("SELECT * FROM user WHERE login = '" . $this->login . "'");
            if ($user && !sizeof($user->fetch_all(MYSQLI_ASSOC))) {
                if ($this->mysqli->query('
                INSERT INTO user (login, pass_hash, email, refresh_token_expires_in, refresh_token) VALUES ("' 
                    . $this->login. '", "'
                    . $this->pass_hash. '", "'
                    . $this->email. '", "'
                    . time(). '", "'
                    . $this->getHash(). '");')) {
                    return true;
                }
                else return $this->new_error("Database error while inserting new user.");
            }
            else return $this->new_error("This user already exists");
        }
        else return $this->new_error("Database connection error");
    }

    public function login() {
        if (!$this->is_error()) {
            if ($user = $this->mysqli->query("SELECT * FROM user WHERE login = '" .$this->login. "'")) {
                $result = $user->fetch_all(MYSQLI_ASSOC);
                if (sizeof($result) == 1) {
                    if ($result[0]['pass_hash'] == $this->pass_hash) {
                        $id = $this->getUserId($this->login);
                        if ($id) {
                            $token = $this->getHash();
                            $tarantool = new Tarantool_User($id, $token);
                            if ($tarantool->add()) {
                                $_SESSION['id']    = $id;
                                $_SESSION['login'] = $this->login;
                                $_SESSION['expires_in']   = $result[0]['refresh_token_expires_in'];
                                $_SESSION['refreshToken'] = $result[0]['refresh_token'];
                                $_SESSION['accessToken']  = $token;
                                return true;
                            }
                            else return $this->new_error("No Tarantool connection");
                        }
                        else return $this->new_error("Database error.");
                    }
                    else return $this->new_error("Wrong password");
                }
                else return $this->new_error("This user does not exist");
            }
            else return $this->new_error("Database connection error");
        }
        else return $this->new_error("Database connection error");
    }

    private function getUserId($login) {
        $user = $this->mysqli->query("SELECT * FROM user WHERE login = '" . $this->login . "'");
        if ($user) {
            $result = $user->fetch_all(MYSQLI_ASSOC);
            if (sizeof($result) > 0)
                return $result[0]['user_id'];
            else return false;
        }
        else return false;
    }

    private function getHash($size = 32) {
		$str  = "abcdefghijklmnopqrstuvwxyz0123456789";
		$hash = "";
		$len  = strlen($str) - 1;
		
		for ($i = 0; $i < $size; $i++) {
			$hash.= $str[rand(0, $len)];
		}
		return $hash;
	}
}
