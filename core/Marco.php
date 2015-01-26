<?php
namespace mapaxe\core;
if( !defined('ENTRYPOINT') )	die('Restricted Access');
/** 
 * Marco.php is the core object for this program;
 * entry.php is the entry point to get easy and offer function tools for the core functionality
 * @package mapaxe.core
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License version 2 or later; see LICENSE.txt. Moreover it intends to be a collaborative class multiple developers among several PHP developers.
 * @author Marco Mapaxe
 */
class Marco extends \stdClass{
    /**
     * @stdClass An object containing all the singleton instances for all the Marco objects in the program,
     * accesible from any file and object or function called because it is static like a global
     */
    protected static $singleton;
    static $config;
    /**
     * @stdClass An object containing all the variable stored in this Marco object
     * 
     */
    protected $gets;

    protected function __construct($config=NULL){
        if($config){
            if( ! $config instanceof \stdClass )
                throw new \InvalidArgumentException( "Marco::__construct EXCEPTION, bad parameter \$config on Marco core" );
            if( ! isset(self::$config) )
                self::batch($config);
        }
        $this->gets=new \stdClass();
    }
    public function __destruct(){
        foreach($this as $key=>$value)
            $this->$key=NULL;
    }
    protected static function batch($config){
        if( ! $config instanceof \stdClass )
            throw new \InvalidArgumentException( "Marco::batch EXCEPTION, bad parameter \$config on core batch execution" );
        
        $config=self::$config=new Config($config->filename);
        if( $config->isDebug() ){
            ini_set('error_reporting', E_ALL);
            ini_set('display_errors', 1);
            set_error_handler('\mapaxe\core\Handler::error_handler');
            set_exception_handler('\mapaxe\core\Handler::exception_handler');
        }
        else{
            ini_set('error_reporting',0);
            ini_set('display_errors',0);
        }
        
        return $config;
    }
    /**
     * Method to manage the singleton system of this program
     * 
     * @param mixed $params the arguments to pass to the instance, it can be an array to pass several ones
     * @param string $className the class of the objecto to instantiate, clasName will be the original class from the call
     * @return Marco the object returned is an object inheriting from Marco class 
     * @throws \InvalidArgumentException if the class name is not a string or this class doesn't exists
     * 
     */
    public static function get_instance($params='',$className=''){
        if(!$className){
            if( !is_string($className) || class_exists($className) )
                throw new \InvalidArgumentException( "Marco::get_instance EXCEPTION, bad parameter \$className with value: $className on class type: ".get_class($this) );
            $className=get_called_class();
        }
        if(!isset(self::$singleton))
              self::$singleton=new \stdClass();
        if ( !isset(self::$singleton->$className) )
           self::$singleton->$className = new $className($params);
        return self::$singleton->$className;
    }
    /**
     * Method to manage the get functionality of this object
     * @param string $name the propery name to get
     * @return mixed the value of this property
     * @throws \InvalidArgumentException if this $name is not a string or is not set this propery on this object
     */
    public function __get($name) {
        if ( is_string($name) && isset($this->gets->$name) )
            return $this->gets->$name;
        $name= ( is_string($name) ? $name : '' );
        throw new \InvalidArgumentException( "Marco::__get EXCEPTION, bad parameter. Undefined $name property on class type ".get_class($this) );
    }
    /**
     * Method to manage the set functionality of this object
     * @param string $name the name to call this property
     * @param mixed $value the value to set this propery
     */
    public function __set($name, $value) {
        if( !is_string($value) )
            throw new \InvalidArgumentException( "Marco::__set EXCEPTION, bad parameter $name, is not a string on class type ".get_class($this) );
        $this->gets->$name=$value;
    }

}