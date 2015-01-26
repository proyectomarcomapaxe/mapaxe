<?php
namespace mapaxe\libs;
//this libs is necessary to make the alias functions for the libs done in this file
require_once 'Helper.php';
//import of all files in this directory and subfolder
require_once_all();


/** 
 * Proxy function to Helper::get_files static method
 *
 * @param string $absolutePath the absolute path to the parent directory, it's used to be dirname(__FILLE__) or something similar.
 *                             Its default value is the absolute path of alias.php, it is said dirname(__FILE__)
 * @param string $extension the extension of the files to read in this folder and its subfolders
 * @return array all the files in folders or subfolders from this parent directory in the form of: array([absolutePath]=>[filename with extension]);
 * @throws RuntimeException if the absolutePath isn't a directory to read its contents (files and or directories inside)
 * @throws InvalidArgumentException if any argument is not of type expected
 *
 */
function require_once_all($absolutePath = NULL, $extension = 'php', array $return=[]) {
    if (!$absolutePath)
        $absolutePath = dirname(__FILE__);
    foreach( Helper::get_files($absolutePath, $extension, $return ) as $absolutePath=>$filesArray )
        foreach( $filesArray as $filename )
            require_once $absolutePath.$filename;
}
/**
 * Proxy function to Helper::execution_time static method
 *
 * @param string $function the name of the function or method to call
 * @param mixed  $context the object or name of the class where the method or static method is called respectively
 * @param string $outputFormat 's' to show the execution time as seconds or 'm' to show the execution time as minutes
 * @return array all the files in folders or subfolders from this parent directory
 * @throws BadFunctionCallException it couldn't be called the callable arguments function and context
 * @throws InvalidArgumentException if any argument is not of type expected
 */
function extime($function, $context = NULL, $outputFormat = 's') {
    return Helper::execution_time($function, $context, $outputFormat);
}
