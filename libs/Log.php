<?php 
namespace mapaxe\libs;
if(!defined('ENTRYPOINT'))	die('Restricted Access');
class Log{
		
    /**
     * @string, Log directory name
     */
    private $path;

    //@void, Default Constructor, Sets the timezone and path of the log files.
    function __construct($path,$timeZone) {
        if( !is_string($path) || !is_string($timeZone) )
            throw new \InvalidArgumentException( "Log::__construct EXCEPTION, bad parameter on class type: ".get_class($this) );	
        if( $path[strlen($path)-1]!=DIRECTORY_SEPARATOR )
            $path.=DIRECTORY_SEPARATOR;
        $this->path= $path;
        if( ! date_default_timezone_set($timeZone) )
            throw new \InvalidArgumentException( "Log::__construct EXCEPTION, bad parameter \timeZone on class type: ".get_class($this) );	
    }

    /**
    *   @void 
    *	Creates the log
    *
    *   @param string $message the message which is written into the log.
    *	@description:
    *	 1. Checks if directory exists, if not, create one and call this method again.
    *	 2. Checks if log already exists.
    *	 3. If not, new log gets created. Log is written into the logs folder.
    *	 4. Logname is current date(Year - Month - Day).
    *	 5. If log exists, edit method called.
    *	 6. Edit method modifies the current log.
    */	
    public function write($message) {
        $date = new \DateTime();
        $log = $this->path . $date->format('Y-m-d') . ".txt";

        if (is_dir($this->path)) {
            if (!file_exists($log)) {
                try {
                    $fh = fopen($log, 'a+') or die("Fatal Error !");
                    $logcontent = "Time : " . $date->format('H:i:s') . "\r\n" . $message . "\r\n";
                    fwrite($fh, $logcontent);
                    fclose($fh);
                } catch (\Exception $e) {
                    throw new \RuntimeException( "Log::write EXCEPTION on file $log on class type: ".get_class($this) , $e->getCode(), $e->getPrevious());
                }
            } else {
                $this->edit($log, $date, $message);
            }
        } else {
            if (mkdir($this->path, 0777) === true) {
                $this->write($message);
            }
        }
    }

    /** 
     *  @void
     *  Gets called if log exists. 
     *  Modifies current log and adds the message to the log.
     *
     * @param string $log
     * @param DateTimeObject $date
     * @param string $message
     */
    
    private function edit($log,$date,$message) {
        try{
            $logcontent = "Time : " . $date->format('H:i:s')."\r\n" . $message ."\r\n\r\n";
            $logcontent = $logcontent . file_get_contents($log);
            file_put_contents($log, $logcontent);
        }
        catch(\Exception $e){
            throw new \RuntimeException( "Log::edit EXCEPTION on file $log on class type: ".get_class($this) , $e->getCode(), $e->getPrevious());
        }
    }
}
