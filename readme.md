# Loggy

Loggy is a remote error logger/forwarder for custom and native PHP errors. You can forward the errors to your own API. This bundle was made especially to use in combination with an internal error dashboard.

## Usage

Activate the bundle in your `application/bundles.php`:

```
return array(
	'loggy' => array('auto' => true),
);
```

In your `application/config/error.php` set the `log` option to `true`.

Then in the `logger` closure, add: `Loggy::log($exception);`.


Now Loggy will do a `POST` request to your API endpoint (see configuration below) when an error occurs. 

The message is formatted as JSON and has the following structure:

```
{
	"msg": "<strong>NOTICE<\/strong> Undefined variable: test",
	"line": 123,
	"file": "/var/www/test/test.php",
	"trace": "full trace here..."
}
```

Can you whatever you want at the API side, for example save it in a database and show it in your internal error dashboard. I might publish my own dashboard on GitHub soon too.

## Configuration

The configuration of this bundle is available at: `bundles/loggy/config/config.php`.

```
return array(
	'api_endpoint'		=> 'http://api.mysite.com/log',
);
```