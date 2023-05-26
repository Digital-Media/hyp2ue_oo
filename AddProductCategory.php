<?php
namespace hyp2ue_oo;

use PDO;
use PDOException;
/**
 * In this example we separate HTML and PHP code.
 * To generate HTML sent to the client we use echo.
 * Later this job will be done by templates.
 *
 * TODO Look at the example StoreFormInput and implement storing and retrieving for the table onlineshop.product_category.
 * TODO Move initializing the DB connection to the method DBConnect() and call it within __construct
 */

/**
 * Include error handling, to display errors in browser for easier debugging during development.
 */
require_once 'error_handling.php';

class AddProductCategory
{
    public function __construct()
    {

    }
    public function StoreAndRetrieve() :void
    {

    }
}
try {
    // TODO Initialize Class
    // TODO Call StoreAndRetrieve() and handle PDOExceptions here

} catch (Exception $e) {
    echo "<h1>Error Page for Debugging</h1>.";
    echo "<p><strong>Don't use that in a production environment!</strong></p>";
    echo "<p>There is an error in " . $e->getFile() . " on line " . $e->getLine() . ".</p>";
    echo "<p>Message: " . $e->getMessage() . "</p>";
    echo "<p>Code: " . $e->getCode() . "</p>";
    echo "<p>Trace: " . $e->getTraceAsString() . "</p>";
}
