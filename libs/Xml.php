<?php
//declaration of package
namespace mapaxe\libs;
if( !defined('ENTRYPOINT') )	die('Restricted Access');
class Xml{
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
     *@return boolean indica si el xml cargado desde la ruta es valido con el schema cargado por defecto (./schema.xsd) 
     */

    protected function attach($xmlArray){
        if( !is_object($xmlArray) )
            throw new \InvalidArgumentException( "Xml::attach EXCEPTION, bad parameter \$xmlArray on class type: ".get_class($this) );
        
        foreach($xmlArray as $key => $value)
            $this->{$key} = $value;
    }
    //poner que no es de uso general o no clasificados como los helpers, cuando se clasifiquen los de helpers pasaron a su clase
    static function xml_2_array ($dom){
        if( ! $dom instanceof \DOMNode )
            throw new \InvalidArgumentException( "Xml::xml_2_array EXCEPTION, bad parameter \$dom on class type: ".get_class($this) );
        if( ! $xml=simplexml_import_dom($dom) )
            throw \RuntimeException( "Xml::xml_2_array EXCEPTION, this xml $this->fileName couldn\'t be read on class type: ".get_class($this) );    
        $array = json_decode( json_encode($xml) );
        return $array;
    }

}