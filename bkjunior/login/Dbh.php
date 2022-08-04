<?php
/**
 * Created by PhpStorm.
 * User: makaveli_10
 * Date: 02/08/2018
 * Time: 10:31
 */

class Dbh
{
    private $servername;
    private $username;
    private $password;
    private $dbname;

    protected function connect(){
        $this->servername = "xxx";
        $this->username = "xxx";
        $this->password = "xxx";
        $this->dbname = "xxx";


        $connect = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        return $connect;
    }

}