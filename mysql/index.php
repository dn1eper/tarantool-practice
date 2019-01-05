<?php

class Database {
    protected $mysqli;
    private $config;
    const VERSIONS_TABLE = 'migration_history';
    
    function __construct() {
        $this->config = require('config.php');
		/* connect to the datebase */
        $this->mysqli = new mysqli($this->config['host'], $this->config['username'], $this->config['password']);
        /* check connection */
		if ($this->mysqli->connect_errno) {
            return $this->new_error("Connection to the database failed.");            
        }
        /* check if exist database */
        if (!$this->mysqli->query("use ".$this->config['database'])) {
            /* create new database */
            if ($this->mysqli->query("CREATE DATABASE " .$this->config['database']) &&
                $this->mysqli->query("use ".$this->config['database'])) {
                // database created
                // ...
            }
            else return $this->new_error($this->mysqli->error);
        }
        /* check if exist version_table */
        if (!$this->mysqli->query("SELECT * FROM " .Database::VERSIONS_TABLE)) {
            /* create version table */
            if ($this->mysqli->query("
                CREATE TABLE " .Database::VERSIONS_TABLE. " (
                    migration_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    version VARCHAR(2) NOT NULL,
                    sub_version VARCHAR(2),
                    commentary VARCHAR(255),
                    date_applied DATETIME DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=INNODB;")) {
                if ($this->mysqli->query("SELECT * FROM " .Database::VERSIONS_TABLE)) {
                    // migration history table created
                    // ...
                }
                else return $this->new_error("Can't create migration history table");
            }
            else return $this->new_error($this->mysqli->error);
        }
        return true;
	}
	function __destruct() {
        if (!$this->mysqli->connect_errno) {
            $this->mysqli->close();
        }
    }
    protected function new_error($error_msg) {
        $this->error = $error_msg;
        return false;
    }

    /* public interface */
    public function is_error() {
        if (isset($this->error)) return true;
        else return false;        
    }
    public function error_msg() {
        if ($this->is_error()) return $this->error;
        else return "No errors.";
    }
    public function query($script) {        
        if (!$this->is_error()) {
            /* execute script */                
            if ($this->mysqli->multi_query($script)) {
                while ($this->mysqli->next_result()) { 
                    if ($result = $this->mysqli->store_result()) {
                        $result->free();
                    }
                }
                return true;
            }
            else return $this->new_error("An error occurred while executing:<br>".$script."<br><br>".$this->mysqli->error);
        }
        else return false;
    }
    public function drop() {        
        if ($this->is_error()) return false;
        else {
            if ($this->mysqli->query("DROP DATABASE " .$this->config["database"])) {
                return true;
            }
            else return $this->new_error($this->mysqli->error);
        }
    }
}
