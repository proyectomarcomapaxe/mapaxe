<?php
//declaration of package
namespace mapaxe\libs;
if( !defined('ENTRYPOINT') )	die('Restricted Access');
/**
 * Xml.php is a class to read and xml file or offer its utilities;
 * entry.php To make proxy functionality regarding in the libraries folder and and offer other function tools for the core functionality
 * @package mapaxe.libs
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License version 2 or later; see LICENSE.txt. Moreover it intends to be a collaborative class multiple developers among several PHP developers.
 * @author Marco Mapaxe
 */
class Xml{
    /**
     *
     * @var string $fileName the name of the xml file to read/load 
     */
    protected $fileName;
    public function __construct($xmlFileName){
        $this->fileName=$xmlFileName;
        $mi_XML = new \DOMDocument();
        if( !$mi_XML->load($xmlFileName) )
            throw \RuntimeException( "Xml::__construct EXCEPTION, this xml $fileName couldn\'t be read on class type: ".get_class($this) );    
	$mi_XML= self::xml_2_array($mi_XML);
	$this->attach($mi_XML);
		
    }
    /**
     * @param object $xmlArray a php object representing the loading from xml_2_array static method
     * @return boolean indica si el xml cargado desde la ruta es valido con el schema cargado por defecto (./schema.xsd) 
     * @throws \InvalidArgumentException if $xmlArray is not an object
     */

    protected function attach($xmlArray){
        if( !is_object($xmlArray) )
            throw new \InvalidArgumentException( "Xml::attach EXCEPTION, bad parameter \$xmlArray on class type: ".get_class($this) );
        
        foreach($xmlArray as $key => $value)
            $this->{$key} = $value;
    }
    
    /**
     * It is a tool relationed with xml functionality, general tools or not rated ones are in Helper class
     * @param \DOMNode $dom the dom node representation of a xml object previously loaded
     * @return array the asociative array representation of the xml dom node
     * @throws \InvalidArgumentException if $dom is not a instance of \DomNode
     * @throws \RuntimeException if it wasn't possible to read the dom object from simple xml  library due to not validation success or any I/O reading error
     */
    static function xml_2_array ($dom){
        if( ! $dom instanceof \DOMNode )
            throw new \InvalidArgumentException( "Xml::xml_2_array EXCEPTION, bad parameter \$dom on class type: ".get_class($this) );
        if( ! $xml=simplexml_import_dom($dom) )
            throw \RuntimeException( "Xml::xml_2_array EXCEPTION, this xml $this->fileName couldn\'t be read on class type: ".get_class($this) );    
        $array = json_decode( json_encode($xml) );
        return $array;
    }

}