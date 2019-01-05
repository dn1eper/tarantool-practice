<?php
require_once("../index.php");

class Migration extends Database {
    private $cur_version;
    private $new_migration_files;

    function __construct() {
        parent::__construct();
        /* get current database version */        
        $this->cur_version = array_pop($this->mysqli->query("SELECT * FROM " .Database::VERSIONS_TABLE)->fetch_all(MYSQLI_ASSOC));
        /* get migration files */
        $this->new_migration_files = $this->getNewMigrationFiles();
        return true;        
	}
    private function getNewMigrationFiles() {
        /* all sql files in folder */
        $allFiles = glob('*.sql');        
        /* find new migration files */
        $newFiles = array();
        $curVersionFileName = $this->cur_version();
        foreach ($allFiles as $file) {
            if ($curVersionFileName === false) {
                if (preg_match('/^([0]{2}\.){1,2}/', basename($file))) {
                    return array($file);
                }
            }
            else if (!isset($flag) && preg_match('/^'.$curVersionFileName.'/', basename($file))) {
                $flag = true;
            }
            else if (isset($flag) && preg_match('/^([0-9]{2}\.){1,2}/', basename($file))) {
                array_push($newFiles, $file);
            }
        }
        return $newFiles;
    }

    /* public interface */
    public function cur_version() {
        if ($this->is_error()) return false;
        else {
            if ($this->cur_version) {
                return $this->cur_version['version'].".".$this->cur_version['sub_version'];
            }
            else return false;
        }
    }
    public function last_migration_date() {
        if ($this->is_error()) return false;
        else return $this->cur_version['date_applied'];
    }
    public function last_new_version() {
        if ($this->is_error() || !sizeof($this->new_migration_files)) return false;
        else return substr(basename($this->new_migration_files[sizeof($this->new_migration_files)-1]), 5, 5);
    }
    public function migrate() {        
        if ($this->is_error()) return false;
        else {
            foreach ($this->new_migration_files as $index => $file) {
                /* get sql script from file */
                $script = file_get_contents($file);
                /* get file name */
                $name = basename($this->new_migration_files[$index]);
                /* execute script */
                foreach (split(";", $script) as $scr) {
                    if ($scr && !$this->mysqli->query($scr)) {
                        return $this->new_error($this->mysqli->error);
                    }
                }
                /* write record to the MIGRATION_HISTORY */                
                $record = "INSERT INTO " .Database::VERSIONS_TABLE. "(version, sub_version, commentary) VALUES('"
                    .substr($name, 0, 2). "','" .substr($name, 3, 2). "', 'null');";
                if ($this->mysqli->query($record)) return true;
                else return $this->new_error($this->mysqli->error);
            }
            return true;
        }
    }
}