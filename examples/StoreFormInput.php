<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>OO PHP</title>
</head>
<body>
<h1>OO PHP</h1>
<p>Learning OO PHP</p>
<h2>Adding visit</h2>
<form action="StoreFormInput.php" method="post">
    <label for="ip_address">Product Category:</label>
    <input type="text" name="ip_address" id="ip_address" placeholder="insert an ipaddress">
    <button type="submit">Submit</button>
</form>
</body>
</html>
<?php
use PDO;
use PDOException;

require_once 'error_handling.php';

class StoreFormInput
{
    public function __construct()
    {
        $charsetAttr="SET NAMES utf8 COLLATE utf8_general_ci";
        $dsn="mysql:host=localhost;port=3306;dbname=onlineshop";
        $mysqlUser="onlineshop";
        $mysqlPwd="geheim";
        $multi=false;
        $options = array(
            // A warning is given for persistent connections in case of a interrupted database connection.
            // This warning is shown on the web page if error_reporting=E_ALL is set in php.ini
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            // PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            // PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_NUM,
            // PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_BOTH,
            PDO::MYSQL_ATTR_INIT_COMMAND => $charsetAttr,
            PDO::MYSQL_ATTR_MULTI_STATEMENTS => $multi
        );
        $this->dbh = new PDO($dsn, $mysqlUser, $mysqlPwd, $options);
        echo "<p>Connect to Database worked</p>";
    }

    private function Store()
    {
        $query = <<<SQL
             INSERT INTO visit
             SET ip_address = :ip_address,
                 timestamp = now()
        SQL;
        echo "<p>$query</p>";
        $params=array(':ip_address' => $_POST['ip_address']);
        if ($this->dbh) {
            $this->stmt = $this->dbh->prepare($query);
            $this->stmt->execute($params);
        }
    }

    private function Retrieve()
    {
        $query = <<<SQL
             SELECT ip_address, timestamp
             FROM visit 
             WHERE ip_address = :ip_address
        SQL;
        echo "<p>$query</p>";
        $params=array(':ip_address' => $_POST['ip_address']);
            if ($this->dbh) {
                $this->stmt = $this->dbh->prepare($query);
                $this->result=$this->stmt->execute($params);
                $this->result = $this->stmt->fetchAll();
                var_dump($this->result);
                // echo $this->result[0]['ip_address'];
                echo $this->result[0]->ip_address;
                // echo $this->result[0][0];
            }
    }

    public function StoreAndRetrieve()
    {
        $this->Store();
        echo "<p>Storing of IP address worked";
        $this->Retrieve();
        echo "<p>Retrieving of IP address worked";
    }
}
$showFormInput = new StoreFormInput();
if (isset($_POST['ip_address'])) {
    try {
        $showFormInput->StoreAndRetrieve();
    } catch ( PDOException $e ) {
        var_dump($e);
        echo '<table>';
        print_r($e->xdebug_message);
        echo '</table>';
    }
}
