<?php 

// namespace framework;

class Db{

    private $dbhost;
    private $dbuser;
    private $dbpass;
    private $dbname;

    public function __construct() {
        
        $this->dbhost = DBHOST;
        $this->dbuser = DBUSER;
        $this->dbpass = DBPASS;
        $this->dbname = DBNAME;

        $this->conn = mysqli_connect($this->dbhost, $this->dbuser, $this->dbpass, $this->dbname);

        if (!$this->conn) {
            
            die(mysqli_connect_error());

        }
    }


}

?>