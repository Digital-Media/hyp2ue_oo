<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>OO PHP</title>
</head>
<body>
<h1>OO PHP</h1>
<p>Learning OO PHP</p>
<h2>Place a html5 document containing a form with a normal input field here</h2>
<form action="StoreFormInput.php" method="post">
    <label for="product_category_name">Product Category:</label>
    <input type="text" name="product_category_name" id="product_category_name" placeholder="insert a product category">
    <button type="submit">Submit</button>
</form>
</body>
</html>
<?php
use PDO;
use PDOException;
/**
 * Einbinden des Errorhandlings, damit Sie Fehler im Browser angezeigt bekommen.
 * Erleichterung des Debugging
 */
require_once 'error_handling.php';
/**
 * TODO Sehen Sie sich die Bespiele in examples an
 * TODO Zu Beginn DefineAndConst.php und Inheritance.php
 * TODO danach auch Methods.php. (Vor allem wenn sie vollständig PSR2 konform werden möchten. Nicht Teil dieser UE)
 *
 * TODO Definieren Sie ein Klasse mit einem Klassennamen passend zu PSR1 in StudlyCaps
 * Diese Klasse soll nicht mehr können, als den Inhalt von $_POST aus index.html ausgeben und in der Datenbank
 * onlineshop speichern.
 * Zusätzlich sollen noch Klassenkonstanten und Eigenschaften der Klasse ausgegeben werden
 * In einer Methode wird der Inhalt von $_POST verarbeitet und diese Methode dann aufgerufen
 */

class StoreFormInput
{
    //TODO innerhalb dieser ersten Klasse

    /**
     * TODO definieren sie eine Klassenkonstante
     * TODO siehe examples/oophp/DefindeAndConst.php
     */
    const CLASS_CONST = "I am visible within the class with self:: and can be called statically from outside with \$object::CLASS_CONST or Class::CLASS_CONST";

    /**
     * TODO definieren sie eine Klasseneigenschaft mit Scope public
     * TODO siehe examples/oophp/PublicProtectedPrivateProperties.php
     */
    public $myPublicVar = "I am visible within the class with \$this-> and can be called from outside with \$object->myPublicVar";

    /**
     * TODO Definieren sie einen Konstruktor
     * TODO siehe examples/oophp/DefindeAndConst.php
     */
    public function __construct()
    {
        // TODO Im Konstrutor
        // TODO Geben sie die oben definierte Klassenkonstante hier aus.
        // TODO Gestalten sie die Ausgabe so, dass dabei valides HTML entsteht
        // TODO Umgeben sie Dazu den Wert mit einem <p> oder einem anderem Tag
        echo "<p>CLASS_CONST: " . self::CLASS_CONST . " </p>";
        // TODO Geben sie die oben definierte Klasseneigenschaft hier aus.
        // TODO Gestalten sie die Ausgabe so, dass dabei valides HTML entsteht
        // TODO Umgeben sie Dazu den Wert mit einem <p> oder einem anderem Tag
        echo "<p>\$myPublicVar: " . $this->myPublicVar . " </p>";
        // TODO Geben Sie den Wert der globalen Konstante DEBUG aus error_handling.php hier aus
        // TODO Verfahren sie dazu wie bei der Klassenkonstante
        echo "<p>DEBUG: " . DEBUG . " </p>";
        // TODO Ende Konstruktor
    }

    /**
     * TODO Definieren Sie Methode mit Scope public
     * TODO siehe examples/oophp/Inheritance.php
     */
    public function Show()
    {
        // TODO Innerhalb der Methode

        // TODO Geben Sie in dieser Methode den Inhalt des $_POST-Arrays das von index.html geschickt wird aus
        // TODO Verwenden sie echo und testen Sie XSS in Chrome und Firefox: <script>alert('hacked')</script>
        // TODO In einem zweiten Schritt verhindern Sie XSS für alle Browser

        echo "<p>Dumping \$_POST </p>";
        //echo $_POST['myinput'];
        echo htmlspecialchars($_POST['product_category_name'], ENT_QUOTES);
        // TODO Ende der Methode
    }

    // TODO Add a private method to connect to the database
    private function DBConnect()
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
            // PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_NUM,
            // PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_BOTH,
            PDO::MYSQL_ATTR_INIT_COMMAND => $charsetAttr,
            PDO::MYSQL_ATTR_MULTI_STATEMENTS => $multi
        );
        try {
            $this->dbh = new PDO($dsn, $mysqlUser, $mysqlPwd, $options);
        } catch (PDOException $e) {
            throw new DatabaseException($e->getMessage());
        }

    }

    // TODO Add a private method to store $_POST['myinput'] in onlineshop.product_category.product_category_name
    private function Store()
    {
        $query = <<<SQL
             INSERT INTO product_category
             SET product_category_name = :product_category_name
        SQL;
        echo "<p>$query</p>";
        $params=array(':product_category_name' => $_POST['product_category_name']);
        try {
            if ($this->dbh) {
                $this->stmt = $this->dbh->prepare($query);
                $this->stmt->execute($params);
            }
        } catch (PDOException $e) {
            throw new DatabaseException($e->getMessage());
        }
    }

    // TODO Add a private method to get onlineshop.product_category.product_category_name from the database
    private function Retrieve()
    {
        $query = <<<SQL
             SELECT product_category_name
             FROM product_category 
             WHERE product_category_name = :product_category_name
        SQL;
        echo "<p>$query</p>";
        $params=array(':product_category_name' => $_POST['product_category_name']);
        try {
            if ($this->dbh) {
                $this->stmt = $this->dbh->prepare($query);
                $this->result=$this->stmt->execute($params);
                $this->result = $this->stmt->fetchAll();
                var_dump($this->result);
                // echo $this->result[0]['product_category_name'];
                // echo $this->result[0]->product_category_name;
                echo $this->result[0][0];
            }
        } catch (PDOException $e) {
            throw new DatabaseException($e->getMessage());
        }
    }

    // TODO Add a public method to store and retrieve $_POST['myinput'] with PDO
    public function StoreAndRetrieve()
    {
        $this->DBConnect();
        echo "<p>Connect to Database worked</p>";
        $this->Store();
        echo "<p>Storing of Product Category worked";
        $this->Retrieve();
        echo "<p>Retrieving of Product Category worked";
    }

// TODO Ende der Klasse
}

// TODO Erzeugen Sie ein erstes Objekt der Klasse
// TODO Benennen sie das Objekt passend zur Klasse und zu PSR1 in camelCase.
$showFormInput = new StoreFormInput();

// TODO Rufen Sie die Methode der Klasse mit Scope public hier aus
$showFormInput->Show();

// TODO Geben sie das erste Objekt mit var_dump() aus
var_dump($showFormInput);

// TODO Geben sie die oben definierte Klassenkonstante im Konstruktor aus.
// TODO Gestalten sie die Ausgabe so, dass dabei valides HTML entsteht
// TODO Umgeben sie dazu den Wert mit einem <p> oder einem anderem Tag
echo "<p>CLASS_CONST called statically: " . $showFormInput::CLASS_CONST . "</p>";
echo "Or other possibility";
echo "<p>CLASS_CONST called with Classname: " . StoreFormInput::CLASS_CONST . "</p>";
/*
 * TODO Erzeugen Sie ein zweites Objekt mit unterschiedlichem Namen
 * TODO Benennen sie das Objekt passend zur Klasse und zu PSR1 in camelCase.
 */
$showFormInput2 = new StoreFormInput();

// TODO Geben sie das zweite Objekt mit var_dump() aus
var_dump($showFormInput2);

// TODO Geben sie die oben definierte Klasseneigenschaft hier aus.
// TODO Gestalten sie die Ausgabe so, dass dabei valides HTML entsteht
// TODO Umgeben sie Dazu den Wert mit einem <p> oder einem anderem Tag
echo "<p>\$myPublicVar: " . $showFormInput2->myPublicVar . " </p>";

// TODO Geben Sie den Wert der globalen Konstante DEBUG aus error_handling.php hier aus
// TODO Gestalten sie die Ausgabe so, dass dabei valides HTML entsteht
// TODO Umgeben sie dazu den Wert mit einem <p> oder einem anderem Tag
echo  "<p>DEBUG: " . DEBUG . "</p>";


// TODO Call StoreAndRetrieve()
$showFormInput->StoreAndRetrieve();
// TODO Geben Sie nur einen Zeilenumbruch am Ende an und kein closing Tag für PHP gemäß PSR2
