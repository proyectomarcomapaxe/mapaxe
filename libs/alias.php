<?php
/**
 * alias.php To make proxy functionality regarding to the libraries in this folder
 * @package	mapaxe.libs
 * @license	GNU General Public License version 2 or later; see LICENSE.txt. Moreover it intends to be a collaborative class multiple developers among several PHP developers.
 * @author  Marco Mapaxe
 */
require_once 'Helper.php';

/**
 * Proxy function to HelperCass::loadFiles static method
 *
 * @param string $absolutePath the absolute path to the parent directory, it's used to be dirname(__FILLE__) or something similar.
 *                             Its default value is the absolute path of alias.php, it is said dirname(__FILE__)
 * @param string $extension the extension of the files to read in this folder and its subfolders
 * @return array all the files in folders or subfolders from this parent directory
 *
 */
function require_once_all($absolutePath = NULL, $extension = 'php') {
    if (!$absolutePath)
        $absolutePath = dirname(__FILE__);
    return HelperClass::loadFiles($absolutePath, $extension);
}
/**
 * Proxy function to HelperCass::executionTime static method
 *
 * @param string $function the name of the function or method to call
 * @param mixed  $context the object or name of the class where the method or static method is called respectively
 * @param string $outputFormat 's' to show the execution time as seconds or 'm' to show the execution time as minutes
 * @return array all the files in folders or subfolders from this parent directory
 *
 */
function extime($function, $context = NULL, $outputFormat = 's') {
    return HelperClass::executionTime($function, $context, $outputFormat);
}
