<?php
namespace mapaxe\core;
if(!defined('ENTRYPOINT'))	die('Restricted Access');
use mapaxe\libs\Xml;

class Config extends Xml{
    function __construct($xmlFileName) {
        parent::__construct($xmlFileName);
    }
    function getLog($name){
        if( !is_string($name) || !isset($this->configs->log->$name) )
            throw new \InvalidArgumentException( "Config::getLog EXCEPTION, bad parameter \$name with value $name on class type ".get_class($this) );
        return (string) $this->configs->log->$name;
    }
    /**
     * 
     * @return boolean indicador que estamos o no estamos en modo depurador
     */
    function isDebug(){
        //ojo con moldear el resultado de un elemento simple ya que devuelve un object, hay que moldearlo al valor que sabemos que debe tener o queremos comprobar
        if( ( strtolower( (string)$this->debug) ) =='true' )
            return TRUE;
        else
            return FALSE;
    }
}
