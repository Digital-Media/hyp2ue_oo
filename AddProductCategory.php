<?php
namespace hyp2ue_oo;
/**
 * This class should not be able to do more than printing the content of $_POST sent by index.html.
 * Additionally a class constant and a class property is defined.
 * Both are printed in different context within and outside a class to see differences in the syntax.
 * An additional objective of this exercise is to understand the scope of class constants, class properties
 * and global constants like DEBUG and see differences in syntax.
 *
 * This class implements one method to process the content of $_POST and return it.
 */

/**
 * Include error handling, to display errors in browser for easier debugging during development.
 */
require_once 'error_handling.php';

/**
 * Defining the class
 *
 * TODO Define a class with a class name in StudlyCaps according to PSR1
 */



    //TODO Within this class

    /*
     * @see examples/StoreFormInput for a working example.
     * Add methods and properties as needed to AddCountry.php to store and retrieve the data sent bei index.html
     */

try {
// TODO Erzeugen Sie ein erstes Objekt der Klasse
// TODO Benennen sie das Objekt passend zur Klasse und zu PSR1 in camelCase.
//    $addCountry = new AddCountry();

//    $addCountry->Show();


// TODO Call StoreAndRetrieve() and handle PDOExceptions here
//    $addCountry->StoreAndRetrieve();
} catch (Exception $e) {
    echo "<h1>Error Page for Debugging</h1>.";
    echo "<p><strong>Don't use that in a production environment!</strong></p>";
    echo "<p>There is an error in " . $e->getFile() . " on line " . $e->getLine() . ".</p>";
    echo "<p>Message: " . $e->getMessage() . "</p>";
    echo "<p>Code: " . $e->getCode() . "</p>";
    echo "<p>Trace: " . $e->getTraceAsString() . "</p>";
}
// At the end of a PHP file there is only a line break and no closing PHP processing instruction according to PSR2
