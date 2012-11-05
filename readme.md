# Loggy

Loggy is a remote error logger/forwarder for custom and native PHP errors. You can forward the errors to your own API. This bundle was made especially to use in combination with an internal error dashboard.


## Configuration

The configuration of this bundle is available at: `config/config.php`:

```
return array(
	'api_endpoint' => 'http://api.mysite.com/log',	// the URL of your API endpoint to POST the log items to
	'site_id' => 'my_site', // unique site id 
);
```

The `api_endpoint` is pretty much self-explanatory. The `site_id` is required for the Loggy Dashboard. This can be anything you want, just make sure it is **unique**.

## Usage

Activate the bundle in your `application/bundles.php`:

```
return array(
	'loggy' => array('auto' => true),
);
```

In your `application/config/error.php` set the `log` option to `true`.

Then in the `logger` closure, add: `Loggy::log($exception);`.


Now Loggy will do a `POST` request to your API endpoint when an error occurs. 

The message is formatted as JSON and has the following structure:

```
{
	"msg": "<strong>NOTICE<\/strong> Undefined variable: test",
	"site_id": "my_site"
	"line": 123,
	"file": "/path/to/a/file.php",
	"trace": "full trace of error will be here..."
}
```

You can do whatever you want at the API side, for example save it in a database and show it in your internal error dashboard. Take a look at my _loggy-dashboard_ repo for an example.