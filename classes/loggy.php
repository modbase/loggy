<?php

class Loggy {

	private static $curl;

	public static $ERROR_CODE = array(
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

	public static function init()
	{
		static::$curl = new Curl();
	}

	private static function getPrefix($code)
	{
		$prefix = '<strong>';

		switch($code)
		{
			case E_ERROR:
				$prefix .= 'FATAL';
				break;
			case E_WARNING:
				$prefix .= 'WARNING';
				break;
			case E_NOTICE:
				$prefix .= 'NOTICE';
				break;
			default:
				$prefix .= 'ERROR';
				break;
		}

		$prefix .= '</strong>';

		return $prefix;
	}


	public static function log($exception)
	{
		$log = array(
			'msg' => static::getPrefix($exception->getCode()) . ' '. $exception->getMessage(),
			'site_id' => Config::get('loggy::config.site_id'),
			'code' => $exception->getCode(),
			'line' => $exception->getLine(),
			'file' => $exception->getFile(),
			'trace' => $exception->getTraceAsString()
		);

		if (static::$curl != null)
		{
			static::$curl->simple_post(Config::get('loggy::config.api_endpoint'), json_encode($log));
		}
	}
}