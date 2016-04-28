<?php

class Mysql
{
    private $conn;
    private $hostname;
    private $username;
    private $password;
    private $database;
    private $port;
    private $charset = 'utf8';

    function __construct($hostname, $username, $password, $database = '', $port = 3306)
    {
        $this->hostname = $hostname;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
        $this->port = $port;

        $this->conn = mysqli_connect($this->hostname, $this->username, $this->password) or die('[ERROR] Mysql Connect Error :' . mysqli_error($this->conn) . "\n");
        mysqli_set_charset($this->conn, $this->charset);

        if (!empty($this->database)) {
            mysqli_select_db($this->conn, $this->database) or die('[ERROR] select Database Error:' . mysqli_error($this->conn) . "\n");
        }
    }

    function __destruct()
    {
        if ($this->conn) {
            $this->close();
        }
    }

    public function close()
    {
        mysqli_close($this->conn) or die(mysqli_error($this->conn));
        $this->conn = null;
    }

    public function select_db($database)
    {
        $this->database = $database;
        mysqli_select_db($this->conn, $this->database) or die('Use Database Error:' . mysqli_error($this->conn) . "\n");
    }

    public function execute($sql)
    {
        $res = mysqli_query($this->conn, $sql) or die(mysqli_error($this->conn));
        mysqli_free_result($res);
        return mysqli_affected_rows($this->conn);
    }

    public function query($sql)
    {
        $res = @mysqli_query($this->conn, $sql) or die(mysqli_error($this->conn));
        return $res;
    }

    public function free($res)
    {
        if ($res) {
            mysqli_free_result($res);
        }
    }

    public function fetch($res)
    {
        return mysqli_fetch_assoc($res);
    }

    public function fetch_all($res)
    {
        $rows = array();
        while ($row = mysqli_fetch_assoc($res)) {
            array_push($rows, $row);
        }
        return $rows;
    }
}

//$conn = new MySQL("localhost", "root", "ybybyb");
//$conn->useDatabase("server");
//$r = $conn->query('select * from user;');
//var_dump($conn->fetch($r));
//var_dump($conn->fetch($r));
//var_dump($conn->fetch($r));
//var_dump($conn->fetch_all($r));
//
//$a = json_encode($r);
//var_dump($a);
//var_dump(json_encode(array(0=>"name", 2=>"zrb")));
