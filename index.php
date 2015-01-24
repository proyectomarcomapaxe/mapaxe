<?php
/**
 * alias.php To make proxy functionality regarding to the libraries in this folder
 * @package     mapaxe
 * @license	GNU General Public License version 2 or later; see LICENSE.txt. Moreover it intends to be a collaborative class multiple developers among several PHP developers.
 * @author       Marco Mapaxe
 */
require 'libs/alias.php';
echo '<pre>
/*
 Examples of HelperClass usage:

*/

</pre>';

try {
    //Loading files
    echo '<p style="color:brown">Files founded and loaded if needed:<p><pre>' . print_r(HelperClass::loadFiles(dirname(__FILE__)), 1) . '</pre></p></p>';

    //Getting execution time
    $context = new MyClass();
    $function = "doNothing";
    $format = 'seconds';

    $clasName = get_class($context);
    echo "<p style='color:teal'>$clasName::$function executed along " . HelperClass::executionTime($function, $context, $format[0]) . " $format</p>";
} catch (Exception $e) {
    echo '<p>EXCEPTION</p>' . var_dump($e);
}

class MyClass {

    function doNothing() {
        usleep(1000);
        echo '<p>Doing nothing... to get my execution time:</p>';
    }

}

echo '<pre>
/*
 Examples of alias.php usage:

*/

</pre>';

echo 'Excution time in alias.php: ' . extime('require_once_all');

