<?php
define ("SERIAL_DEVICE_NOTSET", 0);
define ("SERIAL_DEVICE_SET", 1);
define ("SERIAL_DEVICE_OPENED", 2);

/**
 * Serial port control class
 *
 * THIS PROGRAM COMES WITH ABSOLUTELY NO WARANTIES !
 * USE IT AT YOUR OWN RISKS !
 *
 * @author Rémy Sanchez <thenux@gmail.com>
 * @thanks Aurélien Derouineau for finding how to open serial ports with windows
 * @thanks Alec Avedisyan for help and testing with reading
 * @copyright under GPL 2 licence
 */
class phpSerial
{
	var $_device = null;
	var $_windevice = null;
	var $_dHandle = null;
	var $_dState = SERIAL_DEVICE_NOTSET;
	var $_buffer = "";
	var $_os = "";

	/**
	 * This var says if buffer should be flushed by sendMessage (true) or manualy (false)
	 *
	 * @var bool
	 */
	var $autoflush = true;

	/**
	 * Constructor. Perform some checks about the OS and setserial
	 *
	 * @return phpSerial
	 */
	function __construct (){
		//Set locale information
		setlocale(LC_ALL, "en_US");
		
		//返回运行 PHP 的系统的有关信
		$sysname = php_uname();

		if (substr($sysname, 0, 5) === "Linux"){
			$this->_os = "linux";

			if($this->_exec("stty --version") === 0){
				//register_shutdown_function Register a function for execution on shutdown
				register_shutdown_function(array($this, "deviceClose"));
			}
			else{
				exit();
			}
		}else{
			exit();
		}
	}

	function __destruct() {

	}

	//
	// OPEN/CLOSE DEVICE SECTION -- {START}
	//

	/**
	 * Device set function : used to set the device name/address.
	 * -> linux : use the device address, like /dev/ttyS0
	 * -> windows : use the COMxx device name, like COM1 (can also be used
	 *     with linux)
	 *
	 * @param string $device the name of the device to be used
	 * @return bool
	 */
	function deviceSet ($device){
		if ($this->_dState !== SERIAL_DEVICE_OPENED){
			if ($this->_os === "linux"){
				if (preg_match("@^COM(\d+):?$@i", $device, $matches)){
					$device = "/dev/ttyS" . ($matches[1] - 1);
				}
				//stty -F : 打开并使用指定设备代替标准输入
				if ($this->_exec("stty -F " . $device) === 0){
					$this->_device = $device;
					$this->_dState = SERIAL_DEVICE_SET;
					return true;
				}
			}
		}
		return false;
	}

	/**
	 * Opens the device for reading and/or writing.
	 *
	 * @param string $mode Opening mode : same parameter as fopen()
	 * @return bool
	 */
	function deviceOpen ($mode = "r+b"){
		if ($this->_dState === SERIAL_DEVICE_OPENED){
			return true;
		}

		if ($this->_dState === SERIAL_DEVICE_NOTSET){
			return false;
		}

		if (!preg_match("@^[raw]\+?b?$@", $mode)){
			return false;
		}

		//fopen 打开文件或者 URL
		$this->_dHandle = @fopen($this->_device, $mode);

		if ($this->_dHandle !== false){
			stream_set_blocking($this->_dHandle, 0);
			$this->_dState = SERIAL_DEVICE_OPENED;
			return true;
		}

		$this->_dHandle = null;
		return false;
	}

	/**
	 * Closes the device
	 *
	 * @return bool
	 */
	function deviceClose (){
		if ($this->_dState !== SERIAL_DEVICE_OPENED){
			return true;
		}

		if (fclose($this->_dHandle)){
			$this->_dHandle = null;
			$this->_dState = SERIAL_DEVICE_SET;
			return true;
		}

		return false;
	}


	/**
	 * Sends a string to the device
	 *
	 * @param string $str string to be sent to the device
	 * @param float $waitForReply time to wait for the reply (in seconds)
	 */
	function sendMessage ($str, $waitForReply = 1){
		$this->_buffer .= $str;

		$this->flush();

		usleep((int) ($waitForReply * 1000000));
	}
	/**
	 * Flushes the output buffer
	 *
	 * @return bool
	 */
	function flush (){
		if (!$this->_ckOpened()) return false;

		//fwrite 写入文件（可安全用于二进制文件）
		if (fwrite($this->_dHandle, $this->_buffer) !== false){
			$this->_buffer = "";
			return true;
		}else{
			$this->_buffer = "";
			return false;
		}
	}


	function _ckOpened(){
		return $this->_dState === SERIAL_DEVICE_OPENED;
	}

	function _ckClosed(){
		return $this->_dState === SERIAL_DEVICE_CLOSED;
	}

	function _exec($cmd, &$out = null){
		$desc = array(
		1 => array("pipe", "w"),// stdin is a pipe that the child will read from
		2 => array("pipe", "w") // stdout is a pipe that the child will write to
		);

		// Execute a command and open file pointers for input/output
		$proc = proc_open($cmd, $desc, $pipes);

		//stream_get_contents :  Reads remainder of a stream into a string
		$ret = stream_get_contents($pipes[1]);
		$err = stream_get_contents($pipes[2]);

		fclose($pipes[1]);
		fclose($pipes[2]);

		//proc_close : Close a process opened by proc_open() and return the exit code of that process
		$retVal = proc_close($proc);

		//func_num_args : Returns the number of arguments passed to the function
		if (func_num_args() == 2) $out = array($ret, $err);
		return $retVal;
	}

}
?>
