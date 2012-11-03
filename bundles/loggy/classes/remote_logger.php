<?php

class Remote_Logger {

	private static $instance;

	private $time;
    private $mem;
    private $curl;
    private $api_endpoint;
    private $log_errors;
    private $log_exceptions;
    private $log_time;
    private $log_mem;

    const $ERRORS = array(
        E_ERROR             => 'ERROR',
        E_RECOVERABLE_ERROR => 'RECOVERABLE_ERROR',
        E_WARNING           => 'WARNING',
        E_PARSE             => 'PARSE',
        E_NOTICE            => 'NOTICE',
        E_STRICT            => 'STRICT',
        E_DEPRECATED        => 'DEPRECATED',
        E_CORE_ERROR        => 'CORE_ERROR',
        E_CORE_WARNING      => 'CORE_WARNING',
        E_COMPILE_ERROR     => 'COMPILE_ERROR',
        E_COMPILE_WARNING   => 'COMPILE_WARNING',
        E_USER_ERROR        => 'USER_ERROR',
        E_USER_WARNING      => 'USER_WARNING',
        E_USER_NOTICE       => 'USER_NOTICE',
        E_USER_DEPRECATED   => 'USER_DEPRECATED',
    );

    private function __construct($api_endpoint, $log_errors, $log_exceptions, $log_mem, $log_time)
    {
    	$this->api_endpoint = $api_endpoint;
    	$this->log_errors = $log_errors;
    	$this->log_exceptions = $log_exceptions;
    	$this->log_mem = $log_mem;
    	$this->log_time = $log_time;

    	$this->curl = new Curl($api_endpoint);
    	$this->init();
    }

    public static function start($api_endpoint, $log_errors = true, $log_exceptions = true, $log_mem = true, $log_time = true)
    {
    	if (self::$instance == null)
    	{
    		self::$instance = new self($api_endpoint, $log_errors, $log_exceptions, $log_mem, $log_time);
    	}

    	return self::$instance;
    }

    public function log($log)
    {
        return json_decode($this->curl->simple_post($data), true);
    }

    public function end()
    {
    	$results = array();

    	if ($this->log_time)
    	{
    		$time = microtime(true) - $this->time;
    		$results['time'] => $time;
    	}

    	if ($this->log_mem)
    	{
        	$mem = (memory_get_usage() - $this->mem) / (1024 * 1024);
        	$results['memory'] = $mem;
    	}

    	if (!empty($results))
    	{
    		$this->log($results);
    	}
   	}

    public function reset()
    {
    	return restore_error_handler() && restore_exception_handler();
    }

	private function init()
	{
		if ($this->log_errors)
		{
			$this->enable_error_logger();
		}

		if ($this->log_exceptions)
		{
			$this->enable_exception_logger();
		}

		if ($this->log_time)
		{
			$this->time = microtime(true);
		}

		if ($this->log_mem)
		{
			$this->mem = memory_get_usage();
		}
	}

	private function getErrorName($errno)
    {
        return $ERRORS[$errno];
    }

	private function enable_error_logger()
	{
		set_error_handler(function($errno, $errstr, $errfile, $errline) {
            $err = $this->getErrorName($errno);

            $log = array(
                'msg' => "<strong>{$err}:</strong> {$errfile}:{$errline}"
            );

            $this->log($log);
            return false; // why false?
        });
	}

	private function enable_exception_logger()
	{
		set_exception_handler(function($exception) {
            $exceptionName = get_class($exception);
            $message = $exception->getMessage();
            $file = $exception->getFile();
            $line = $exception->getLine();
            $trace = $exception->getTraceAsString();

            //$msg = count($trace) > 0 ? "Stack trace:\n{$trace}" : null;

            $log = array(
            	'msg' => "<strong>Uncaught exception:</strong> {$exceptionName} - '{$message}' in {$file}:{$line}"
            );

            $this->log($log);
            return false; // why false?
        });
	}
}