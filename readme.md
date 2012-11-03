# Loggy

Loggy is a remote error logger for custom and native PHP errors. You can forward the errors to any API. This bundle was made especially to use in combination with a dedicated error dashboard (see INSERT_LINK_HERE).

## Usage

Activate the bundle in your `bundles.php`:

```
return array(
	'loggy' => array('auto' => true),
);
```

* Start logging anywhere in your code: `Loggy::connect();`.
PHP native errors and exceptions will be logged automatically.
*To log custom errors: `Loggy::log($data);`.
* The time and memory monitoring will automatically stop at end end of your script execution.
If needed, you can stop the monitoring anywhere yourself: `Ĺoggy::end();`.
* The remote error logging can be stopped (reset old error handlers) by using: `Loggy::reset();`.

## Configuration

The configuration is available at: `config/config.php`.

```
return array(
	'log_errors' 		=> true,		// log PHP errors
	'log_exceptions' 	=> true,		// log PHP uncaught exceptions
	'log_mem'			=> true,		// log memory usage
	'log_time'			=> true,		// log execution time
	'api_endpoint'		=> 'http://api.mysite.com/log',
);
```