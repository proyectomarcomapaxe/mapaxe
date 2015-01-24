<?php
        ini_set('error_reporting',E_ALL);
	ini_set('display_errors',1);
		
	/**
	 * Helper.php is a collection of functions we all use on our PHP projects
	 * @package	Proyectomapaxe.Helper
	 * @license	GNU General Public License version 2 or later; see LICENSE.txt. Moreover it intends to be a collaborative class multiple developers among several PHP developers.
	   @author      Marco Mapaxe
	 */

	/*
	 * Wrapper class for PHP helper functions
	*/
	class HelperClass{
		/**
		 *
		 * Function to load files from a parent directory, it can used to load libs from a concrete path
		 *
		 * @param string $absolutePath the absolute path to the parent directory, it's used to be dirname(__FILLE__) or something similar
		 * @return array all the files in folders or subfolders from this parent directory
		 *
		*/
		static function loadFiles($absolutePath,$extension='php'){
			//validate params
			if( !is_string($absolutePath) || !is_string($extension) )	throw new InvalidArgumentException( ' -- HelperClass::loadFiles EXCEPTION, bad parameter -- ');
			
			static $files=[];
		
			//file names storing
			if ( is_dir($absolutePath) ) {
			   if( $absolutePath[strlen($absolutePath)-1] != DIRECTORY_SEPARATOR )
				   $absolutePath.=DIRECTORY_SEPARATOR;
			   $dh = opendir($absolutePath);
			   
			   if ($dh) {
				  while ( ( $file = readdir($dh) ) !== FALSE) {
					if( $file!='.' && $file!='..' ){
						 if ( is_dir($absolutePath . DIRECTORY_SEPARATOR .$file) ){
							self::loadLibs($absolutePath.$file);
						 }
						 else{
							$file=explode('.',$file);
							if( end($file) == $extension )
								$files[]=$absolutePath.implode('.',$file);
							CONTINUE;
						}
					}
				  }
				  closedir($dh);
			   }
			}
			else{
				//no valid path
				throw new Exception( " -- HelperClass::loadLibs EXCEPTION opening $absolutePath -- ");
			}
			
			//loading files
			foreach($files as $file)
				require_once $file;
				
			return $files;
		}
		/**
		 *
		 * Function to show the execution time of a function, a static method of a class or a method form an object.
		 * These functions or methods can't get any parameter, otherwise this helper will fail.
		 *
		 * @param string $function the name of the function or method to call
		 * @param mixed  $context the object or name of the class where the method or static method is called respectively
		 * @param string $outputFormat 's' to show the execution time as seconds or 'm' to show the execution time as minutes
		 * @return array all the files in folders or subfolders from this parent directory
		 *
		*/
		static function executionTime($function,$context=NULL,$outputFormat='s'){
		
			//validate params
			if( !is_string($function) )	throw new InvalidArgumentException( ' -- HelperClass::executionTime EXCEPTION, bad \$function parameter -- ');
			if( $context!=NULL && !is_object($context) && !is_string($context) ) throw new InvalidArgumentException( ' -- HelperClass::executionTime EXCEPTION, bad \$context parameter -- ' );
			$outputFormat=strtolower($outputFormat);
			if( $outputFormat!='s' && $outputFormat!='m')	throw new InvalidArgumentException( ' -- HelperClass::executionTime EXCEPTION, bad \$outputFormat parameter -- ' );
			
			//fixing and checking params
			if($context)
				$callable=( is_string($context) ? "$context::$function" : array($context,$function) );
			else
				$callable=$function;
				
			if( !is_callable($callable) ){
				$className=( is_string($context) ? $context : get_class($context) );
				throw new BadFunctionCallException( " -- HelperClass::executionTime EXCEPTION in ' $className::$function ' calling");
			}
			
			//processing and getting time
			$timestart=microtime(TRUE);
			call_user_func($callable);
			$timeend=microtime(TRUE);
			
			switch($outputFormat){
				case 's':	$divider=3600;
				case 'm':	$divider=60;
			}
			
			return (float)(($timeend-$timestart)/$divider);
		}
	}
	echo '<pre>
	/*
	 Examples of usage:
	 
	*/

	</pre>';

	try{
		//Loading files
		echo '<p style="color:brown">Files founded and loaded if needed:<p><pre>'.print_r( HelperClass::loadFiles( dirname(__FILE__) ),1 ).'</pre></p></p>';

		//Getting execution time
		$context=new MyClass();
		$function="doNothing";
		$format='seconds';
		
		$clasName=get_class($context);
		echo "<p style='color:teal'>$clasName::$function executed along ".HelperClass::executionTime($function,$context,$format[0])." $format</p>";
	}
	catch(Exception $e){
		echo '<p>EXCEPTION</p>'.var_dump($e);
	}


	exit(0);

	/*
	  End of Helper.php file
	  
	*/

	class MyClass{
		function doNothing(){
			usleep(1000);
			echo '<p>Doing nothing... to get my execution time:</p>';
		}
	}
