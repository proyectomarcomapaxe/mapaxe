<?php
/**
     * alias.php To make proxy functionality regarding to the libraries in this folder
     * @package	mapaxe.libs
     * @license	GNU General Public License version 2 or later; see LICENSE.txt. Moreover it intends to be a collaborative class multiple developers among several PHP developers.
       @author  Marco Mapaxe
     */
/*  */ 
require_once 'Helper.php';
function require_once_all($absolutePath=NULL,$extension='php'){
	if(!$absolutePath)	$absolutePath=dirname(__FILE__);
	return HelperClass::loadFiles($absolutePath,$extension);
}
function extime($function,$context=NULL,$outputFormat='s'){
	return HelperClass::executionTime($function,$context,$outputFormat);
}

