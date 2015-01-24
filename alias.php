<?php
/* To make proxy function about the HelperClass static methods */ 
require_once 'Helper.php';
function require_once_all($absolutePath=NULL,$extension='php'){
	if(!$absolutePath)	$absolutePath=dirname(__FILE__);
	return HelperClass::loadFiles($absolutePath,$extension);
}
function extime($function,$context=NULL,$outputFormat='s'){
	return HelperClass::executionTime($function,$context,$outputFormat);
}
echo 'Excution time in alias.php: '.extime('require_once_all');
