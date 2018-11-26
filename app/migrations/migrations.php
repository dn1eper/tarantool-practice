<?php

const VERSIONS_TABLE = 'migration_history'

class Migrations {
    private $mysqli;
    private $cur_version;
    private $new_migration_files;

    function __construct($db_host, $db_user, $db_password, $database, $db_migration_folder) {
		/* connect to the datebase */
        $this->mysqli = @new mysqli($db_host, $db_user, $db_password);
        /* check connection */
		if ($this->mysqli->connect_errno) {
            return $this->new_error("Connection to the database failed.");            
        }
        /* check if exist database and version_table */
        else if (!$this->mysqli->query("use ".$database) || !$this->mysqli->query("select * from ".VERSIONS_TABLE)) {
            return $this->new_error($this->mysqli->error);
        }
        /* get current database version */        
        $this->cur_version = @array_pop($this->mysqli->query("select * from ".VERSIONS_TABLE)->fetch_all(MYSQLI_ASSOC));
        /* get migration files */
        $this->new_migration_files = $this->getNewMigrationFiles();

        return true;        
	}
	function __destruct() {
        if (!$this->mysqli->connect_errno) {
            $this->mysqli->close();
        }
    }
    private function new_error($error_msg) {
        $this->error = $error_msg;
        return false;
    }
    private function getNewMigrationFiles() {
        /* all sql files in folder */
        $allFiles = glob('*.sql');        
        /* find new migration files */
        $newFiles = array();
        $curVersionFileName = $this->cur_version(true);        
        foreach ($allFiles as $file) {
            if (!isset($flag) && preg_match('/^'.$curVersionFileName.'/', basename($file))) {
                $flag = true;
            }
            else if (isset($flag) && preg_match('/^([0-9]{2}\.){1,2}/', basename($file))) {
                array_push($newFiles, $file);
            }
        }        
        return $newFiles;
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
    public function cur_version($arg = false) {
        if ($this->is_error()) return;
        else if ($arg) {
            return $this->cur_version['file_num'].".".$this->cur_version['version'].".".$this->cur_version['sub_version'];
        }
        else {
            return $this->cur_version['version'].".".$this->cur_version['sub_version'];
        }
    }
    public function last_migration_date() {
        if ($this->is_error()) return;
        else return $this->cur_version['date_applied'];
    }
    public function last_new_version() {
        if ($this->is_error() || !sizeof($this->new_migration_files)) return;
        else return substr(basename($this->new_migration_files[sizeof($this->new_migration_files)-1]), 5, 5);
    }
    public function migrate() {        
        if ($this->is_error()) return;
        else {
            foreach ($this->new_migration_files as $index => $file) {
                /* get sql script from file */
                $script = file_get_contents($file);                
                /* get file name */
                $name = basename($this->new_migration_files[$index]);
                /* execute script */                
                if (!$this->mysqli->multi_query(substr($script, 3))) {
                    return $this->new_error("An error occurred while executing the file ".$name.". Migration stopped. <br><br>".$this->mysqli->error);
                }
                else {                    
                    while ($this->mysqli->next_result()) { 
                        if ($result = $this->mysqli->store_result()) $result->free();
                    }
                }
                /* write record to the MIGRATION_HISTORY */                
                $record = "INSERT INTO ".VERSIONS_TABLE."(version, sub_version, file_num, commentary, date_applied) VALUES('"
                        .substr($name, 8, 2)."','".substr($name, 5, 2)."', '".substr($name, 0, 4)."', 'comment', NOW());";
                $this->mysqli->query($record);
            }
            return true;
        }
    }
}