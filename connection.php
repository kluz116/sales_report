<?php


class Connection {

    protected $host = "localhost";
    protected $dbname = "sales_report";
    protected $user = "root";
    protected $pass = "Python@2019";
    protected $dbh;

    function __construct() {

        try {

            $this->dbh = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->pass);
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e) {

            echo $e->getMessage();
        }
    }

    public function closeConnection() {

        $this->dbh = null;
    }
}

?>