<?php
namespace mapaxe\core;
if(!defined('ENTRYPOINT'))	die('Restricted Access');
use mapaxe\libs\Xml;
/** 
 * Config.php is the core object to manage the config info from the config file read on Xml library from what this class inherit;
 * entry.php is the entry point to get easy and offer function tools for the core functionality
 * @package mapaxe.core
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License version 2 or later; see LICENSE.txt. Moreover it intends to be a collaborative class multiple developers among several PHP developers.
 * @author Marco Mapaxe
 */
class Config extends Xml{
    function __construct($xmlFileName) {
        parent::__construct($xmlFileName);
    }
    /**
     * To get a log configuration from the config file
     * 
     * @param string $name the property name to get
     * @return string the value of the property
     * @throws \InvalidArgumentException if property doesn't exists on the config file
     */
    function getLog($name){
        if( !is_string($name) || !isset($this->configs->log->$name) )
            throw new \InvalidArgumentException( "Config::getLog EXCEPTION, bad parameter \$name with value $name on class type ".get_class($this) );
        return (string) $this->configs->log->$name;
    }
    /**
     * To know the debug environmet was configured not
     * 
     * @return boolean the indicator of debug mode or not
     */
    function isDebug(){
        //ojo con moldear el resultado de un elemento simple ya que devuelve un object, hay que moldearlo al valor que sabemos que debe tener o queremos comprobar
        if( ( strtolower( (string)$this->debug) ) =='true' )
            return TRUE;
        else
            return FALSE;
    }
}
