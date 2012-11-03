<?php

class Loggy {

	private static $logger;
	
	public static function connect()
	{
		static::$logger = Remote_Logger::start(
			Config('loggy::config.api_endpoint'),
			Config('loggy::config.log_errors'),
			Config('loggy::config.log_exceptions'),
			Config('loggy::config.log_mem'),
			Config('loggy::config.log_time')
		);
	}

	public static function log($data)
	{
		if ($logger != null)
		{
			static::$logger->log($data);
		}
	}

	public static function end()
	{
		if ($logger != null)
		{
			static::$logger->end();
		}
	}

	public static function reset()
	{
		if ($logger != null)
		{
			static::$logger->reset();
		}
	}
}