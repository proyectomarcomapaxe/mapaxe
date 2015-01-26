<?php
namespace mapaxe\core;
if( !defined('ENTRYPOINT') )	die('Restricted Access');

use \mapaxe\libs\Log;
use \mapaxe\core\Marco;
/** 
 * Handler.php is the core object to manage the error and exceptions throws by the program;
 * entry.php is the entry point to get easy and offer function tools for the core functionality
 * @package mapaxe.core
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License version 2 or later; see LICENSE.txt. Moreover it intends to be a collaborative class multiple developers among several PHP developers.
 * @author Marco Mapaxe
 */
class Handler{
    
    /**
     * Constant necesary to control the type of message what log
     */
    const ERROR='error';
    /**
     * Constant necesary to control the type of message what log
     */
    const EXCEPTION='exception';
    /**
     * Constant necesary to control the type of message what log
     */
    const WARNING='warn';
    /**
     * Constant necesary to control the type of message what log
     */
    const INFO='info';
    
    /**
     * 
     * @param string $typeMsg it will be one of the control constant  of this class, to know what king of error we are dealing with
     * @param string $message the content of the  error/exception
     * @param string $rawdata the raw content of the error/exception
     * @return string the the complete message logged
     * @throws \InvalidArgumentException if bad paremeters were passed (string in $typeMsg, string in $message, string in $rawdata)
     */
    static function log( $typeMsg, $message , $rawdata= '' ){
        if( !is_string($typeMsg) || !is_string($message) || !is_string($rawdata) )
            throw new \InvalidArgumentException( "Handler::log EXCEPTION, bad parameter on core handler" );
        
        if($typeMsg!=self::ERROR && $typeMsg!=self::EXCEPTION && $typeMsg!=self::WARNING && $typeMsg!=self::INFO)
            $typeMsg=self::INFO;
        $message  = strtoupper($typeMsg). ': ' .$message;
        $info='. You can find more details on the log file.';
        $config=Marco::$config;
        $log=new Log( $config->getLog('directory') , $config->getLog('timezone') );
        $log->write( $message.( $rawdata ? ' and raw data: '.$rawdata : '' ) );

        return $message.$info;
    }
    /**
     * Ideal manager for the set_exception_handler function although it can be called from external
     * 
     * @param \Exception $e the original exception info
     * @return void
     */
    static function exception_handler(\Exception $e){
        $context=array( $e->getPrevious(), $e->getTraceAsString() );
        self::error_handler( $e->getCode(),$e->getMessage(),$e->getFile(),$e->getLine(), $context );
    }
    /**
     * Ideal manager for the set_error_handler function although it can be called from external
     * 
     * @param string $errno error code
     * @param string $errstr error message
     * @param string $errfile absolute filename where error became
     * @param string $errline number of line in the file where script stopped
     * @param array $errcontext it can be info about the trace or the previous error
     * @return boolean for a complete or not bypass of PHP engine errors
     * 
     */
    static function error_handler($errno ,$errstr , $errfile , $errline , array $errcontext ){
        $code=$errno;
        $typeMsg=self::ERROR;
        $errcontext=json_encode($errcontext);
        switch($errno){
            case E_ALL:                 $errno='E_ALL - All errors and warnings (includes E_STRICT as of PHP 6.0.0)';break;
            case E_ERROR:               $errno='E_ERROR - fatal run-time errors';break;
            case E_RECOVERABLE_ERROR:   $errno='E_RECOVERABLE_ERROR - almost fatal run-time errors';break;
            case E_WARNING:             $errno='E_WARNING - run-time warnings (non-fatal errors)';break;
            case E_PARSE:               $errno='E_PARSE - compile-time parse errors';break;
            case E_NOTICE:              $errno='E_NOTICE run-time notices (these are warnings which often result from a bug in your code, but it\'s possible that it was intentional (e.g., using an uninitialized variable and relying on the fact it\'s automatically initialized to an empty string)';break;
            case E_STRICT:              $errno='E_STRICT run-time notices, enable to have PHP suggest changes to your code which will ensure the best interoperability and forward compatibility of your code';break;
            case E_CORE_ERROR:          $errno='E_CORE_ERROR - fatal errors that occur during PHP\'s initial startup';break;
            case E_CORE_WARNING:        $errno='E_CORE_WARNING - warnings (non-fatal errors) that occur during PHP\'s initial startup';break;
            case E_COMPILE_ERROR:       $errno='E_COMPILE_ERROR - fatal compile-time errors';break;
            case E_COMPILE_WARNING:     $errno='E_COMPILE_WARNING - compile-time warnings (non-fatal errors)';break;
            case E_USER_ERROR:          $errno='E_USER_ERROR - user-generated error message';break;
            case E_USER_WARNING:        $errno='E_USER_WARNING - user-generated warning message';break;
            case E_USER_NOTICE:         $errno='E_USER_NOTICE - user-generated notice message';break;
            case E_DEPRECATED:          $errno='E_DEPRECATED - warn about code that will not work in future versions of PHP';break;
            default:                    
                $errno='EXCEPTION - if no codified by PHP Error level constants, it is an Exception by the php script.';
                $typeMsg=self::EXCEPTION;
                
                break;
        }

        $rawdata='TYPE OF ERROR: '.$errno.'(code '.$code.'); FILE: '.$errfile.'; LINE: '.$errline.'; CONTEXT VARS: '.$errcontext;
        self::log($typeMsg,$errstr,$rawdata);
        return TRUE;
    }
    
}

