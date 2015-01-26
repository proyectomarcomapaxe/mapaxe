<?php
namespace mapaxe\libs;
/**
 * entry.php To make proxy functionality regarding in the libraries folder and and offer other function tools for the core functionality;
 * Helper.php is a collection of functions we all use on our PHP projects. Wrapper class for PHP helper functions
 * @package mapaxe.libs
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License version 2 or later; see LICENSE.txt. Moreover it intends to be a collaborative class multiple developers among several PHP developers.
 * @author Marco Mapaxe
 */
class Helper {

    /**
     * Function to get file names from a parent directory, it can used to load libs from a concrete path.
     * Moreover, this function serve to get the directories from this parent because these ones are the keys of the returned array
     *
     * @param string $absolutePath the absolute path to the parent directory, it's used to be dirname(__FILLE__) or something similar
     * @param string $extension the extension of the files to read in this folder and its subfolders
     * @param array $files it's the variables where are stored all the file names, this variable is local because it is a function but it is an object method it would be a reference to keep modified from external calls
     * @return array all the files in folders or subfolders from this parent directory in the form of: array([absolutePath]=>[filename with extension]);
     * @throws RuntimeException if the absolutePath isn't a directory to read its contents (files and or directories inside)
     * @throws InvalidArgumentException if any argument is not of type expected ( string for $absolutePath, string for $extension or array for $files )
     *
     */
    static function get_files($absolutePath, $extension = 'php', $files=[]) {
        //validate params
        if ( !is_string($absolutePath) || !is_string($extension) || !is_array($files) )
            throw new \InvalidArgumentException('Helper::loadFiles EXCEPTION, bad parameter');

        //file names storing
        if (is_dir($absolutePath)) {
            if ($absolutePath[strlen($absolutePath) - 1] != DIRECTORY_SEPARATOR)
                $absolutePath.=DIRECTORY_SEPARATOR;
            $dh = opendir($absolutePath);

            if ($dh) {
                while (( $file = readdir($dh) ) !== FALSE) {
                    if ($file != '.' && $file != '..') {
                        if (is_dir($absolutePath . $file)) {
                            $files=self::get_files($absolutePath . $file , $extension, $files);
                        } else {
                            $file = explode('.', $file);
                            if (end($file) == $extension)
                                $files[$absolutePath][] = basename( implode('.',$file) );
                            CONTINUE;
                        }
                    }
                }
                closedir($dh);
            }
        }
        else {
            //no valid path
            throw new \RuntimeException("Helper::get_files EXCEPTION opening $absolutePath directory");
        }

        return $files;
    }

    /** 
     * Function to show the execution time of a function, a static method of a class or a method form an object.
     * These functions or methods can't get any parameter, otherwise this helper will fail.
     *
     * @param string $function the name of the function or method to call
     * @param mixed  $context the object or name of the class where the method or static method is called respectively
     * @param string $outputFormat 's' to show the execution time as seconds or 'm' to show the execution time as minutes
     * @return array all the files in folders or subfolders from this parent directory
     * @throws BadFunctionCallException it couldn't be called the callable arguments function and context
     * @throws InvalidArgumentException if any argument is not of type expected
     *
     */
    static function execution_time($function, $context = NULL, $outputFormat = 's') {

        //validate params
        if (!is_string($function))
            throw new \InvalidArgumentException('Helper::executionTime EXCEPTION, bad \$function parameter with value: '.$function);
        if ($context != NULL && !is_object($context) && !is_string($context))
            throw new \InvalidArgumentException('Helper::executionTime EXCEPTION, bad \$context parameter with value: '.$context);
        $outputFormat = strtolower($outputFormat);
        if ($outputFormat != 's' && $outputFormat != 'm')
            throw new \InvalidArgumentException('Helper::executionTime EXCEPTION, bad \$outputFormat parameter with value: '.$outputFormat);

        //fixing and checking params
        if ($context)
            $callable = ( is_string($context) ? "$context::$function" : array($context, $function) );
        else
            $callable = $function;

        if (!is_callable($callable)) {
            $className = ( is_string($context) ? $context : get_class($context) );
            throw new \BadFunctionCallException("Helper::executionTime EXCEPTION in $className::$function calling");
        }

        //processing and getting time
        $timestart = microtime(TRUE);
        call_user_func($callable);
        $timeend = microtime(TRUE);

        switch ($outputFormat) {
            case 's': $divider = 3600;
            case 'm': $divider = 60;
        }

        return (float) (($timeend - $timestart) / $divider);
    }

}
