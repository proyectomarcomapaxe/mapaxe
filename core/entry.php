<?php
//declaration of package
namespace mapaxe\core;
if( !defined('ENTRYPOINT') )	die('Restricted Access');

//importing function to use
use function mapaxe\libs\require_once_all;

//importing all files in this directory and subfolder
require_once_all( dirname(__FILE__) );

$config=new \stdClass();
$config->filename=dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'config.xml';

$mapaxe=Marco::get_instance($config);
