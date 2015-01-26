<?php
namespace mapaxe;
/**
 * index.php To run this programa as the global entry point of it, importing resources, running main subprograms and showing the results of the request
 * @package mapaxe
 * @license GNU General Public License version 2 or later; see LICENSE.txt. Moreover it intends to be a collaborative class multiple developers among several PHP developers.
 * @author Marco Mapaxe
 */

use mapaxe\libs\Helper;
use function mapaxe\libs\extime;
use mapaxe\core\Marco;

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

define('ENTRYPOINT','index.php');
require 'libs/entry.php';
require 'core/entry.php';


echo '<pre>
/*
 Examples of \libs\Helper usage:

*/

</pre>';

try {
    //Loading files
    echo '<p style="color:brown">Files founded and loaded if needed:<p><pre>' . print_r(Helper::get_files(dirname(__FILE__)), 1) . '</pre></p></p>';

    //Getting execution time
    $context = new MyClass();
    $function = "doNothing";
    $format = 'seconds';

    $clasName = get_class($context);
    echo "<p style='color:teal'>$clasName::$function executed along " . Helper::execution_time($function, $context, $format[0]) . " $format</p>";
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
 Examples of \libs\alias.php usage:

*/

</pre>';

echo 'Excution time in alias.php: ' . extime('\mapaxe\libs\require_once_all');

echo '<pre>
/*
 Examples of \Marco.php usage:

*/

</pre>';

Marco::getInstance()->property='First setting the variable like this: Marcos::getInstance()->property="Setting a property through the core of this program"; and then show this variable in this line like this echo Marco::getInstance()->property;';
echo Marco::getInstance()->property;

