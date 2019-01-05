<?php

class Tarantool_User {
    private $user_id;
    private $token;

    function __construct($user_id, $token) {
        $this->user_id = $user_id;
        $this->token   = $token;
    }

    public function add() {
        $url = "http://localhost:8080/add/" . $this->id . "/" . $this->token;
        $res = file_get_contents($url);
        if ($res) {
            return json_decode($res);
        }
        else return false;
    }

    public function validate() {
        $url = "http://localhost:8080/validate/" . $this->id . "/" . $this->token;
        $res = file_get_contents($url);
        if ($res) {
            return json_decode($res);
        }
        else return false;
    }
}